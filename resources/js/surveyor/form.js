import {
    saveSurvey, getAllPendingSurveys, deleteSurvey, getPendingCount,
    getCachedRegions, getCachedProvinces, getCachedCities, getCachedBarangays,
    hasLocationCache, prefetchLocations
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
        const fields = form.querySelectorAll('input:not([type="checkbox"]):not([type="radio"]), textarea');

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

    // ─── Cascading Location Dropdowns (IndexedDB-first) ─────────────────────
    const regionSelect = document.getElementById('regionCode');
    const provinceSelect = document.getElementById('provinceCode');
    const citySelect = document.getElementById('cityMunicipalityCode');
    const barangaySelect = document.getElementById('baranggayCode');

    function resetSelect(select, defaultText) {
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = true;
    }

    function populateSelect(select, data, defaultText) {
        resetSelect(select, defaultText);
        select.disabled = false;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.code;
            option.textContent = item.name;
            select.appendChild(option);
        });
    }

    // Initial state
    resetSelect(provinceSelect, 'Select province');
    resetSelect(citySelect, 'Select city / municipality');
    resetSelect(barangaySelect, 'Select baranggay');

    // Load regions — try IndexedDB cache first, then network fallback
    async function loadRegions() {
        try {
            const cached = await getCachedRegions();
            if (cached.length > 0) {
                populateSelect(regionSelect, cached, 'Select region');
                console.log('[Locations] Loaded regions from IndexedDB cache');
                return;
            }
        } catch (err) {
            console.warn('[Locations] IndexedDB read failed, trying network:', err);
        }

        // Fallback: fetch from network
        try {
            const res = await fetch('/api/regions');
            const data = await res.json();
            populateSelect(regionSelect, data, 'Select region');
        } catch (err) {
            console.error('Error fetching regions:', err);
        }
    }

    loadRegions();

    regionSelect.addEventListener('change', async function () {
        const regionCode = this.value;
        resetSelect(provinceSelect, 'Select province');
        resetSelect(citySelect, 'Select city / municipality');
        resetSelect(barangaySelect, 'Select baranggay');

        if (regionCode) {
            try {
                const cached = await getCachedProvinces(regionCode);
                if (cached.length > 0) {
                    populateSelect(provinceSelect, cached, 'Select province');
                    return;
                }
            } catch (err) { /* fall through to network */ }

            try {
                const res = await fetch(`/api/provinces?region_code=${regionCode}`);
                const data = await res.json();
                populateSelect(provinceSelect, data, 'Select province');
            } catch (err) {
                console.error('Error fetching provinces:', err);
            }
        }
    });

    provinceSelect.addEventListener('change', async function () {
        const provinceCode = this.value;
        resetSelect(citySelect, 'Select city / municipality');
        resetSelect(barangaySelect, 'Select baranggay');

        if (provinceCode) {
            try {
                const cached = await getCachedCities(provinceCode);
                if (cached.length > 0) {
                    populateSelect(citySelect, cached, 'Select city / municipality');
                    return;
                }
            } catch (err) { /* fall through to network */ }

            try {
                const res = await fetch(`/api/cities-municipalities?province_code=${provinceCode}`);
                const data = await res.json();
                populateSelect(citySelect, data, 'Select city / municipality');
            } catch (err) {
                console.error('Error fetching cities:', err);
            }
        }
    });

    citySelect.addEventListener('change', async function () {
        const cityCode = this.value;
        resetSelect(barangaySelect, 'Select baranggay');

        if (cityCode) {
            try {
                const cached = await getCachedBarangays(cityCode);
                if (cached.length > 0) {
                    populateSelect(barangaySelect, cached, 'Select baranggay');
                    return;
                }
            } catch (err) { /* fall through to network */ }

            try {
                const res = await fetch(`/api/barangays?city_municipality_code=${cityCode}`);
                const data = await res.json();
                populateSelect(barangaySelect, data, 'Select baranggay');
            } catch (err) {
                console.error('Error fetching barangays:', err);
            }
        }
    });

    // ─── Init: Update badge, sync, and ensure locations cached ──────────────
    updatePendingBadge();

    if (navigator.onLine) {
        syncPendingSurveys();

        // If location cache doesn't exist yet, pre-fetch it now
        hasLocationCache().then((cached) => {
            if (!cached) {
                console.log('[Locations] No cache found — prefetching all locations...');
                prefetchLocations()
                    .then((counts) => console.log('[Locations] Prefetched:', counts))
                    .catch((err) => console.error('[Locations] Prefetch failed:', err));
            }
        });
    }
});