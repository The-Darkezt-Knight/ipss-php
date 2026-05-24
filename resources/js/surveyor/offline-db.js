/**
 * IPSS Offline Database Module
 *
 * Lightweight IndexedDB wrapper for:
 * 1. Storing survey submissions when offline (synced when back online)
 * 2. Pre-caching all location data (regions → barangays) so cascading
 *    dropdowns work fully offline
 */

const DB_NAME = 'ipss-offline';
const DB_VERSION = 2; // Bumped to add 'locations' store
const SURVEYS_STORE = 'pendingSurveys';
const LOCATIONS_STORE = 'locations';

/**
 * Opens (or creates/upgrades) the IndexedDB database.
 * @returns {Promise<IDBDatabase>}
 */
export function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);

        request.onupgradeneeded = (event) => {
            const db = event.target.result;

            // Survey queue store (from v1)
            if (!db.objectStoreNames.contains(SURVEYS_STORE)) {
                const store = db.createObjectStore(SURVEYS_STORE, { keyPath: 'id' });
                store.createIndex('timestamp', 'timestamp', { unique: false });
            }

            // Location cache store (new in v2)
            // Stores 4 keys: 'regions', 'provinces', 'cities', 'barangays'
            if (!db.objectStoreNames.contains(LOCATIONS_STORE)) {
                db.createObjectStore(LOCATIONS_STORE, { keyPath: 'type' });
            }
        };

        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

/**
 * Generates a simple UUID v4.
 * @returns {string}
 */
function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, (c) => {
        const r = (Math.random() * 16) | 0;
        const v = c === 'x' ? r : (r & 0x3) | 0x8;
        return v.toString(16);
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// Survey Queue Functions
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Saves a survey submission to IndexedDB.
 * @param {Object} formData - Key/value pairs from the form
 * @returns {Promise<string>} The generated record ID
 */
export async function saveSurvey(formData) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(SURVEYS_STORE, 'readwrite');
        const store = tx.objectStore(SURVEYS_STORE);

        const record = {
            id: generateUUID(),
            data: formData,
            timestamp: new Date().toISOString(),
        };

        const request = store.add(record);
        request.onsuccess = () => resolve(record.id);
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}

/**
 * Retrieves all pending (un-synced) survey records.
 * @returns {Promise<Array>}
 */
export async function getAllPendingSurveys() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(SURVEYS_STORE, 'readonly');
        const store = tx.objectStore(SURVEYS_STORE);
        const request = store.getAll();

        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}

/**
 * Deletes a single survey record by ID (after successful sync).
 * @param {string} id - The record UUID
 * @returns {Promise<void>}
 */
export async function deleteSurvey(id) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(SURVEYS_STORE, 'readwrite');
        const store = tx.objectStore(SURVEYS_STORE);
        const request = store.delete(id);

        request.onsuccess = () => resolve();
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}

/**
 * Returns the count of pending survey records.
 * @returns {Promise<number>}
 */
export async function getPendingCount() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(SURVEYS_STORE, 'readonly');
        const store = tx.objectStore(SURVEYS_STORE);
        const request = store.count();

        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}

// ═══════════════════════════════════════════════════════════════════════════
// Location Cache Functions
// ═══════════════════════════════════════════════════════════════════════════

/**
 * Fetches ALL location data from /api/locations/all and stores it in IndexedDB.
 * Call this once when the surveyor logs in / lands on the dashboard.
 * @returns {Promise<{regions: number, provinces: number, cities: number, barangays: number}>}
 */
export async function prefetchLocations() {
    const response = await fetch('/api/locations/all');
    if (!response.ok) {
        throw new Error(`Failed to fetch locations: ${response.status}`);
    }

    const data = await response.json();
    const db = await openDB();

    return new Promise((resolve, reject) => {
        const tx = db.transaction(LOCATIONS_STORE, 'readwrite');
        const store = tx.objectStore(LOCATIONS_STORE);

        // Store each category as a separate record keyed by 'type'
        store.put({ type: 'regions',    items: data.regions,    cachedAt: new Date().toISOString() });
        store.put({ type: 'provinces',  items: data.provinces,  cachedAt: new Date().toISOString() });
        store.put({ type: 'cities',     items: data.cities,     cachedAt: new Date().toISOString() });
        store.put({ type: 'barangays',  items: data.barangays,  cachedAt: new Date().toISOString() });

        tx.oncomplete = () => {
            db.close();
            resolve({
                regions: data.regions.length,
                provinces: data.provinces.length,
                cities: data.cities.length,
                barangays: data.barangays.length,
            });
        };
        tx.onerror = () => {
            db.close();
            reject(tx.error);
        };
    });
}

/**
 * Checks if locations are already cached in IndexedDB.
 * @returns {Promise<boolean>}
 */
export async function hasLocationCache() {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(LOCATIONS_STORE, 'readonly');
        const store = tx.objectStore(LOCATIONS_STORE);
        const request = store.count();

        request.onsuccess = () => resolve(request.result >= 4);
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}

/**
 * Gets all cached regions.
 * @returns {Promise<Array<{code: string, name: string}>>}
 */
export async function getCachedRegions() {
    return _getCachedLocationType('regions');
}

/**
 * Gets cached provinces filtered by region code.
 * @param {string} regionCode
 * @returns {Promise<Array<{code: string, name: string}>>}
 */
export async function getCachedProvinces(regionCode) {
    const all = await _getCachedLocationType('provinces');
    return all.filter((p) => p.region_code === regionCode);
}

/**
 * Gets cached cities filtered by province code.
 * @param {string} provinceCode
 * @returns {Promise<Array<{code: string, name: string}>>}
 */
export async function getCachedCities(provinceCode) {
    const all = await _getCachedLocationType('cities');
    return all.filter((c) => c.province_code === provinceCode);
}

/**
 * Gets cached barangays filtered by city/municipality code.
 * @param {string} cityCode
 * @returns {Promise<Array<{code: string, name: string}>>}
 */
export async function getCachedBarangays(cityCode) {
    const all = await _getCachedLocationType('barangays');
    return all.filter((b) => {
        if (b.city_municipality_code === cityCode) return true;
        if (!b.city_municipality_code) {
            // Match the first 6 characters (Prov/City/Muni code)
            return b.code.substring(0, 6) === cityCode.substring(0, 6);
        }
        return false;
    });
}

/**
 * Internal helper — reads a location type from IndexedDB.
 * @param {string} type - 'regions' | 'provinces' | 'cities' | 'barangays'
 * @returns {Promise<Array>}
 */
async function _getCachedLocationType(type) {
    const db = await openDB();
    return new Promise((resolve, reject) => {
        const tx = db.transaction(LOCATIONS_STORE, 'readonly');
        const store = tx.objectStore(LOCATIONS_STORE);
        const request = store.get(type);

        request.onsuccess = () => {
            resolve(request.result?.items || []);
        };
        request.onerror = () => reject(request.error);

        tx.oncomplete = () => db.close();
    });
}
