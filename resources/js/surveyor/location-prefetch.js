/**
 * Location Data Pre-Fetcher (District-Scoped)
 *
 * This script runs on the Surveyor Dashboard page (right after login).
 * It downloads location data (cities + barangays) scoped to the surveyor's
 * assigned district and stores it in IndexedDB so the form's cascading
 * dropdowns work fully offline.
 */

import { hasLocationCache, prefetchLocationsByDistrict } from './offline-db.js';

document.addEventListener('DOMContentLoaded', () => {
    if (!navigator.onLine) {
        console.log('[Location Prefetch] Offline — skipping prefetch.');
        return;
    }

    // Read district code from the jurisdiction section's data attribute
    const jurisdictionSection = document.querySelector('[data-district-code]');
    const districtCode = jurisdictionSection ? jurisdictionSection.dataset.districtCode : '';

    if (!districtCode) {
        console.warn('[Location Prefetch] No district_code found — cannot prefetch.');
        return;
    }

    //checks if there are cached location data on IndexDB. If none, it will download the data from the server.
    hasLocationCache()
        .then((cached) => {
            if (!cached) {
                console.log('[Location Prefetch] No cache found — downloading district locations...');
                return prefetchLocationsByDistrict(districtCode).then((counts) => {
                    console.log('[Location Prefetch] ✓ Cached successfully:', counts);
                });
            } else {
                console.log('[Location Prefetch] ✓ Location data already cached.');
            }
        })
        .catch((err) => {
            console.error('[Location Prefetch] Failed:', err);
        });
});
