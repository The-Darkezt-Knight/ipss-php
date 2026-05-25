import {
    saveSurvey, getAllPendingSurveys, deleteSurvey, getPendingCount,
    getCachedCitiesByDistrict, getCachedBarangays,
    hasLocationCache, prefetchLocationsByDistrict
} from './offline-db.js';

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('survey-form');

    // ─── Toast Notification System ──────────────────────────────────────────
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');

        const icons = {
            success: 'check_circle',
            error: 'error',
            info: 'cloud_queue',
            syncing: 'sync',
        };

        const colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-blue-600',
            syncing: 'bg-amber-600',
        };

        toast.className = `flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white ${colors[type]} transform translate-x-full opacity-0 transition-all duration-500 ease-out`;
        toast.innerHTML = `
            <span class="material-symbols-outlined ${type === 'syncing' ? 'animate-spin' : ''}">${icons[type]}</span>
            <span class="text-sm font-medium">${message}</span>
        `;

        container.appendChild(toast);

        // Trigger enter animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        });

        // Auto-remove after 4 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }

    // ─── Pending Badge Update ───────────────────────────────────────────────
    async function updatePendingBadge() {
        const badge = document.getElementById('pending-count-badge');
        const countEl = document.getElementById('pending-count');
        if (!badge || !countEl) return;

        try {
            const count = await getPendingCount();
            countEl.textContent = count;

            if (count > 0) {
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('flex');
            }
        } catch (err) {
            console.error('Error updating badge:', err);
        }
    }

    // ─── Connection Status Indicator ────────────────────────────────────────
    function updateConnectionStatus() {
        const dot = document.getElementById('status-dot');
        const label = document.getElementById('status-label');
        const pill = document.getElementById('connection-status-pill');

        if (!dot || !label || !pill) return;

        if (navigator.onLine) {
            dot.classList.remove('bg-red-500');
            dot.classList.add('bg-green-500');
            label.textContent = 'Online';
            pill.classList.remove('border-red-200', 'bg-red-50');
            pill.classList.add('border-green-200', 'bg-green-50');
        } else {
            dot.classList.remove('bg-green-500');
            dot.classList.add('bg-red-500');
            label.textContent = 'Offline';
            pill.classList.remove('border-green-200', 'bg-green-50');
            pill.classList.add('border-red-200', 'bg-red-50');
        }
    }

    window.addEventListener('online', () => {
        updateConnectionStatus();
        showToast('Connection restored — syncing pending surveys…', 'syncing');
        syncPendingSurveys();
    });

    window.addEventListener('offline', () => {
        updateConnectionStatus();
        showToast('You are offline. Surveys will be saved locally.', 'info');
    });

    // Set initial status
    updateConnectionStatus();

    // ─── Geolocation Helper ─────────────────────────────────────────────────
    function getCurrentPosition(timeoutMs = 10000) {
        return new Promise((resolve) => {
            if (!navigator.geolocation) {
                console.warn('[Geo] Geolocation API not available');
                resolve(null);
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    });
                },
                (error) => {
                    console.warn('[Geo] Could not get position:', error.message);
                    resolve(null);
                },
                {
                    enableHighAccuracy: true,
                    timeout: timeoutMs,
                    maximumAge: 60000, // accept a cached position up to 1 min old
                }
            );
        });
    }

    // ─── Collect Form Data ──────────────────────────────────────────────────
    function collectFormData() {
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            if (key !== '_token') {
                data[key] = value;
            }
        });
        return data;
    }

    // ─── Send to Server ─────────────────────────────────────────────────────
    async function sendToServer(data) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const response = await fetch('/surveyor/merge', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error(`Server responded with ${response.status}`);
        }

        return response.json();
    }

    // ─── Sync Pending Surveys ───────────────────────────────────────────────
    async function syncPendingSurveys() {
        if (!navigator.onLine) return;

        try {
            const pending = await getAllPendingSurveys();
            if (pending.length === 0) return;

            const syncBtn = document.getElementById('sync-indicator-icon');
            if (syncBtn) syncBtn.classList.add('animate-spin');

            let synced = 0;
            let failed = 0;

            for (const record of pending) {
                try {
                    await sendToServer(record.data);
                    await deleteSurvey(record.id);
                    synced++;
                } catch (err) {
                    console.error(`Failed to sync record ${record.id}:`, err);
                    failed++;
                }
            }

            await updatePendingBadge();

            if (syncBtn) syncBtn.classList.remove('animate-spin');

            if (synced > 0) {
                showToast(`${synced} survey${synced > 1 ? 's' : ''} synced successfully!`, 'success');
            }
            if (failed > 0) {
                showToast(`${failed} survey${failed > 1 ? 's' : ''} failed to sync. Will retry later.`, 'error');
            }
        } catch (err) {
            console.error('Sync error:', err);
        }
    }

    // ─── Form Validation ────────────────────────────────────────────────────
    function validateForm() {
        let isValid = true;
        const fields = form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]):not([data-auto-geo]):not([data-optional]), textarea:not([data-optional])');

        fields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error-border');
            } else {
                field.classList.remove('error-border');
            }
        });

        if (!isValid) {
            const firstInvalid = form.querySelector('.error-border');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
        }

        return isValid;
    }

    // ─── Form Submission Handler ────────────────────────────────────────────
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Auto-capture geolocation BEFORE validation so fields are pre-filled
        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        try {
            const coords = await getCurrentPosition();
            if (coords) {
                if (latInput) latInput.value = coords.latitude.toFixed(6);
                if (lngInput) lngInput.value = coords.longitude.toFixed(6);
            }
        } catch (err) {
            console.warn('[Geo] Geolocation failed, continuing without coordinates:', err);
        }

        if (!validateForm()) return;

        const data = collectFormData();
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        // Disable submit button while processing
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Processing…`;

        if (navigator.onLine) {
            // ONLINE: Try sending directly
            try {
                await sendToServer(data);
                showToast('Survey submitted successfully!', 'success');
                form.reset();
            } catch (err) {
                // Network failed even though navigator.onLine — save locally
                console.warn('Online send failed, saving locally:', err);
                try {
                    await saveSurvey(data);
                    await updatePendingBadge();
                    showToast('Network error — saved locally. Will sync when connection is stable.', 'info');
                    form.reset();
                } catch (dbErr) {
                    showToast('Failed to save survey. Please try again.', 'error');
                    console.error('IndexedDB save error:', dbErr);
                }
            }
        } else {
            // OFFLINE: Save to IndexedDB
            try {
                await saveSurvey(data);
                await updatePendingBadge();
                showToast('Saved offline — will auto-sync when back online.', 'info');
                form.reset();
            } catch (dbErr) {
                showToast('Failed to save survey locally. Please try again.', 'error');
                console.error('IndexedDB save error:', dbErr);
            }
        }

        // Re-enable submit button
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });

    // ─── "Save for Sync" Button ─────────────────────────────────────────────
    const saveForSyncBtn = document.getElementById('save-for-sync-btn');
    if (saveForSyncBtn) {
        saveForSyncBtn.addEventListener('click', async function () {
            if (!validateForm()) return;

            const data = collectFormData();

            try {
                await saveSurvey(data);
                await updatePendingBadge();
                showToast('Survey saved locally for later sync.', 'info');
                form.reset();
            } catch (err) {
                showToast('Failed to save survey. Please try again.', 'error');
                console.error('Save for sync error:', err);
            }
        });
    }

    // ─── Manual Sync Button (header) ────────────────────────────────────────
    const manualSyncBtn = document.getElementById('manual-sync-btn');
    if (manualSyncBtn) {
        manualSyncBtn.addEventListener('click', () => {
            if (navigator.onLine) {
                showToast('Syncing pending surveys…', 'syncing');
                syncPendingSurveys();
            } else {
                showToast('Cannot sync — you are offline.', 'error');
            }
        });
    }

    // Remove error styling when user types or changes the field
    const allFields = form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), textarea, select');
    allFields.forEach(field => {
        field.addEventListener('input', function () {
            if (this.value.trim()) {
                this.classList.remove('error-border');
            }
        });
        field.addEventListener('change', function () {
            if (this.value.trim()) {
                this.classList.remove('error-border');
            }
        });
    });

    // ─── District-Scoped Location Dropdowns ─────────────────────────────────
    const citySelect = document.getElementById('cityMunicipalityCode');
    const barangaySelect = document.getElementById('barangayCode');

    // Read the surveyor's assigned district code from the section data attribute
    const locationSection = document.querySelector('[data-district-code]');
    const districtCode = locationSection ? locationSection.dataset.districtCode : '';

    function resetSelect(select, defaultText) {
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = true;
    }

    function populateSelect(select, data, defaultText) {
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = false;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.code;
            option.textContent = item.name;
            select.appendChild(option);
        });
    }

    // Initial state
    resetSelect(barangaySelect, 'Select barangay');

    // Load cities for the surveyor's district — try IndexedDB cache first, then network
    async function loadCitiesByDistrict() {
        if (!districtCode) {
            console.warn('[Locations] No district_code assigned to this surveyor');
            resetSelect(citySelect, 'No district assigned');
            return;
        }

        try {
            const cached = await getCachedCitiesByDistrict(districtCode);
            if (cached && cached.length > 0) {
                populateSelect(citySelect, cached, 'Select city / municipality');
                console.log('[Locations] Loaded cities from IndexedDB cache');
                return;
            }
        } catch (err) {
            console.warn('[Locations] IndexedDB read failed, trying network:', err);
        }

        // Fallback: fetch from network
        try {
            const res = await fetch(`/api/cities-municipalities?district_code=${districtCode}`);
            const data = await res.json();
            populateSelect(citySelect, data, 'Select city / municipality');
        } catch (err) {
            console.error('Error fetching cities:', err);
            resetSelect(citySelect, 'Failed to load cities');
        }
    }

    async function initializeLocations() {
        await loadCitiesByDistrict();

        // Check for pre-filled values from URL query params
        const params = new URLSearchParams(window.location.search);
        const pCity = params.get('cityMunicipalityCode');
        const pBarangay = params.get('baranggayCode');

        if (pCity) {
            citySelect.value = pCity;
            citySelect.classList.add('pointer-events-none', 'opacity-60', 'bg-surface-variant');
            citySelect.tabIndex = -1;

            try {
                let cachedBrgy = await getCachedBarangays(pCity);
                if (!cachedBrgy || cachedBrgy.length === 0) {
                    const res = await fetch(`/api/barangays?city_municipality_code=${pCity}`);
                    cachedBrgy = await res.json();
                }
                populateSelect(barangaySelect, cachedBrgy, 'Select barangay');
                if (pBarangay) {
                    barangaySelect.value = pBarangay;
                    barangaySelect.classList.add('pointer-events-none', 'opacity-60', 'bg-surface-variant');
                    barangaySelect.tabIndex = -1;
                }
            } catch (err) {
                console.error('Error prefilling locations:', err);
            }
        }
    }

    initializeLocations();

    citySelect.addEventListener('change', async function () {
        const cityCode = this.value;
        resetSelect(barangaySelect, 'Select barangay');

        if (cityCode) {
            try {
                const cached = await getCachedBarangays(cityCode);
                if (cached.length > 0) {
                    populateSelect(barangaySelect, cached, 'Select barangay');
                    return;
                }
            } catch (err) { /* fall through to network */ }

            try {
                const res = await fetch(`/api/barangays?city_municipality_code=${cityCode}`);
                const data = await res.json();
                populateSelect(barangaySelect, data, 'Select barangay');
            } catch (err) {
                console.error('Error fetching barangays:', err);
            }
        }
    });

    // ─── Init: Update badge, sync, and ensure locations cached ──────────────
    updatePendingBadge();

    if (navigator.onLine) {
        syncPendingSurveys();

        // If location cache doesn't exist yet, pre-fetch it now (scoped to district)
        if (districtCode) {
            hasLocationCache().then((cached) => {
                if (!cached) {
                    console.log('[Locations] No cache found — prefetching district locations...');
                    prefetchLocationsByDistrict(districtCode)
                        .then((counts) => console.log('[Locations] Prefetched:', counts))
                        .catch((err) => console.error('[Locations] Prefetch failed:', err));
                }
            });
        }
    }
});
