import {
    getAllPendingSurveys,
    deleteSurvey,
    getPendingCount,
    updateSurvey,
    getCachedCitiesByDistrict,
    getCachedBarangays,
} from './offline-db.js';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('pending-surveys-tbody');
    const pendingCountCard = document.getElementById('pending-sync-count');
    const lastSyncedCard = document.getElementById('last-synced-time');
    const emptyStateRow = document.getElementById('empty-state-row');

    // ─── Format Date ────────────────────────────────────────────────────────
    function formatDate(isoString) {
        const date = new Date(isoString);
        const options = { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
        return date.toLocaleDateString('en-US', options);
    }

    function timeAgo(isoString) {
        const now = new Date();
        const past = new Date(isoString);
        const diffMs = now - past;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMs / 3600000);
        const diffDays = Math.floor(diffMs / 86400000);

        if (diffMins < 1) return 'Just now';
        if (diffMins < 60) return `${diffMins}m ago`;
        if (diffHours < 24) return `${diffHours}h ago`;
        return `${diffDays}d ago`;
    }

    // ─── Build a Client Display Name ────────────────────────────────────────
    function getClientName(record) {
        const d = record.data || {};
        const first = d.firstName || '';
        const middle = d.middleName || '';
        const last = d.lastName || '';
        const suffix = d.suffix && d.suffix !== '--N/A--' ? ` ${d.suffix}` : '';

        const fullName = `${first} ${middle ? middle + ' ' : ''}${last}${suffix}`.trim();
        return fullName || 'Unnamed Client';
    }

    // ─── Get Survey Type Label ──────────────────────────────────────────────
    function getSurveyType(record) {
        const d = record.data || {};
        return d.msmeClassification || d.statusOfClient || 'MSME Survey';
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Edit Modal Logic
    // ═══════════════════════════════════════════════════════════════════════

    const editModal = document.getElementById('edit-modal');
    const editForm = document.getElementById('edit-client-form');
    const editRecordId = document.getElementById('edit-record-id');
    const editModalClose = document.getElementById('edit-modal-close');
    const editModalCancel = document.getElementById('edit-modal-cancel');
    const editModalSave = document.getElementById('edit-modal-save');
    const selectClass = 'p-md border border-outline rounded-lg bg-surface-bright text-body-sm';
    let activeEditRecord = null;

    const SELECT_OPTIONS = {
        statusOfClient: ['Level 0 - Would be or Potential Entrepreneurs'],
        specifyLevel: ['Potential', 'Other Clients Assisted'],
        categoryOfClient: [
            '4Ps Beneficiary', 'Agrarian Reform Beneficiary', 'Alien/Foreigner',
            'Balik Probinsya Bagong Pag-asa (BP2)', 'Drug Surrenderee', 'Ex-convict',
            'Farmer', 'Former Rebel', 'Government Employee', 'Housewife/Husband',
            'KIA/WIA/KIPO/WIPO', 'Military/Police', 'OFW', 'Out-of-School-Youth',
            'Person Deprived of Liberty',
            'Persons of Concern (Stateless Person, Internally-Displaced Person, Refugee)',
            'Private Employee', 'Professional', 'PWD', 'Retiree', 'Self-Employed',
            'Senior Citizen', 'Student', 'Unemployed', 'Urban Poor', 'Youth',
        ],
        socialClassification: ['Abled', 'Person with Disabilities'],
        diffAbledType: [
            '', 'Autism', 'Breast Cancer', 'Cervical Cancer Survivor', 'Chronic Illness',
            'Deaf/Hard of Hearing', 'Heart Disease', 'Learning Disability', 'Mastectomy',
            'Nephrectomy', 'Orthopedic', 'Physical', 'Psychological',
            'Speech and Language Impairment', 'Visual Impairment/One Eye',
        ],
        isSenior: ['No', 'Yes'],
        isIndigeneous: ['No', 'Yes'],
        levelOfDigitalization: [
            'Level 0 - No use of digital tools',
            'Level 1 (Basic) - MSMEs that use basic digital tools for business',
            'Level 2 (Intermediate) - MSMEs that have an online presence',
            'Level 3 (Advanced) - Use of advanced digital tools',
        ],
        digitalTools: [
            '', 'Bank Account', 'Big data, automation tools i.e. chatbots',
            'Business process management software', 'Business Website',
            'Chat apps i.e. Messenger, Viber',
            'Creative Tools (e.g. Photoshop, Canva, Illustrator)',
            'Customer Relationship Management (CRM)', 'Cybersecurity Risk Tools',
            'E-commerce i.e. Shopee, Lazada', 'Email', 'ERP', 'Fintech i.e. GCash, PayMaya',
            'Internet connection for business', 'Laptop', 'Microsoft Office i.e. Excel, Word',
            'Online Banking', 'Platforms', 'Printer', 'Smartphone',
            'Smartphones, tablets, desktop computers', 'Tablet',
        ],
        msmeClassification: [
            'Large - More than Php 100,000,000',
            'Medium - Php 15,000,001 to Php 100,000,000',
            'Micro - Up to Php 3,000,000',
            'Not Applicable - Would-be/Potential Entrepreneur',
            'Small - Php 3,000,001 to Php 15,000,000',
        ],
        clientDesignation: ['Owner', 'Representative'],
        suffix: [
            '--N/A--', 'SR', 'JR', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX',
            'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX', 'XX',
        ],
        civilStatus: ['Legally Separated', 'Married', 'Single', 'Widowed'],
        sex: ['Male', 'Female'],
        citizenship: ['Filipino'],
        eCommercePlatform: ['Shopee / Lazada', 'Facebook Marketplace', 'Proprietary Platform', 'None'],
    };

    function applyOptions(select, options) {
        select.innerHTML = '';
        options.forEach(value => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = value || '-- Select if applicable --';
            select.appendChild(option);
        });
    }

    function initializeLockedPrefixInputs(root = document) {
        root.querySelectorAll('[data-locked-prefix]').forEach(input => {
            const prefix = input.dataset.lockedPrefix || '';

            function enforcePrefix() {
                if (!input.value.startsWith(prefix)) {
                    input.value = prefix + input.value.replace(prefix, '');
                }
            }

            function keepCursorAfterPrefix() {
                if (input.selectionStart < prefix.length) {
                    input.setSelectionRange(prefix.length, prefix.length);
                }
            }

            enforcePrefix();

            input.addEventListener('input', enforcePrefix);
            input.addEventListener('focus', () => {
                enforcePrefix();
                requestAnimationFrame(keepCursorAfterPrefix);
            });
            input.addEventListener('click', keepCursorAfterPrefix);
            input.addEventListener('keydown', event => {
                const selectionStartsBeforePrefix = input.selectionStart <= prefix.length;
                const selectionEndsBeforePrefix = input.selectionEnd <= prefix.length;

                if ((event.key === 'Backspace' && selectionStartsBeforePrefix) ||
                    (event.key === 'Delete' && selectionStartsBeforePrefix && selectionEndsBeforePrefix)) {
                    event.preventDefault();
                    keepCursorAfterPrefix();
                }
            });
        });
    }

    function replaceWithSelect(key, options) {
        const current = document.getElementById(`edit-${key}`);
        if (!current) return;

        const select = document.createElement('select');
        select.id = current.id;
        select.className = selectClass;
        applyOptions(select, options);
        current.replaceWith(select);
    }

    function replaceCheckboxWithSelect(key, labelText) {
        const current = document.getElementById(`edit-${key}`);
        if (!current) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'flex flex-col gap-xs';
        wrapper.innerHTML = `
            <label class="text-label-md font-label-md text-on-surface-variant">${labelText}</label>
            <select id="edit-${key}" class="${selectClass}">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        `;

        const parentLabel = current.closest('label');
        if (parentLabel) {
            parentLabel.replaceWith(wrapper);
        } else {
            current.replaceWith(wrapper.querySelector('select'));
        }
    }

    function initializeEditModalControls() {
        Object.entries(SELECT_OPTIONS).forEach(([key, options]) => {
            if (key === 'isSenior' || key === 'isIndigeneous') return;
            replaceWithSelect(key, options);
        });

        replaceCheckboxWithSelect('isSenior', 'Client is Senior');
        replaceCheckboxWithSelect('isIndigeneous', 'Client is Indigenous');
        replaceWithSelect('cityMunicipalityCode', []);
        replaceWithSelect('barangayCode', []);

        const zipCode = document.getElementById('edit-zipCode');
        if (zipCode) {
            zipCode.className = 'p-md border border-outline rounded-lg bg-surface-container text-body-sm text-on-surface-variant cursor-not-allowed';
            zipCode.placeholder = '6100';
            zipCode.readOnly = true;
        }

        initializeLockedPrefixInputs(editForm);
    }

    initializeEditModalControls();

    // All editable field keys (must match the form field name attributes used in form.blade.php)
    const EDITABLE_FIELDS = [
        'statusOfClient', 'categoryOfClient', 'msmeClassification', 'clientDesignation',
        'socialClassification', 'specifyLevel', 'diffAbledType', 'isSenior', 'isIndigeneous',
        'levelOfDigitalization', 'digitalTools',
        'firstName', 'middleName', 'lastName', 'suffix',
        'sex', 'civilStatus', 'citizenship',
        'oldId', 'dtiKonekId', 'philippineIdentificationSystem',
        'mobileNumber', 'emailAddress', 'landlineNumber', 'faxNumber',
        'socialMedia', 'website', 'eCommercePlatform',
        'regionCode', 'provinceCode', 'cityMunicipalityCode', 'barangayCode',
        'district', 'zipCode', 'address',
    ];

    // Read-only fields (displayed but not collected on save)
    const READONLY_FIELDS = ['id', 'latitude', 'longitude'];

    const locationSection = document.querySelector('[data-district-code]');
    const districtCode = locationSection ? locationSection.dataset.districtCode : '';

    function resetSelect(select, defaultText) {
        if (!select) return;
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = true;
    }

    function populateSelect(select, data, defaultText) {
        if (!select) return;
        select.innerHTML = `<option value="">${defaultText}</option>`;
        select.disabled = false;
        data.forEach(item => {
            const option = document.createElement('option');
            option.value = item.code;
            option.textContent = item.name;
            select.appendChild(option);
        });
    }

    function setFieldValue(el, value) {
        const normalizedValue = value ?? '';
        if (el.tagName === 'SELECT' && normalizedValue && !Array.from(el.options).some(option => option.value === normalizedValue)) {
            const option = document.createElement('option');
            option.value = normalizedValue;
            option.textContent = normalizedValue;
            el.appendChild(option);
        }

        el.value = normalizedValue;
    }

    function normalizeYesNo(value) {
        if (value === true || value === 'true' || value === 'on' || value === 'Yes') return 'Yes';
        return 'No';
    }

    async function populateEditLocationDropdowns(data) {
        const citySelect = document.getElementById('edit-cityMunicipalityCode');
        const barangaySelect = document.getElementById('edit-barangayCode');

        try {
            let cities = [];
            if (districtCode) {
                cities = await getCachedCitiesByDistrict(districtCode);
            }

            if (!cities || cities.length === 0) {
                const res = await fetch(`/api/cities-municipalities?district_code=${districtCode}`);
                cities = await res.json();
            }

            populateSelect(citySelect, cities, 'Select city / municipality');
            setFieldValue(citySelect, data.cityMunicipalityCode);
        } catch (err) {
            console.error('Error loading edit modal cities:', err);
            resetSelect(citySelect, 'Failed to load cities');
            setFieldValue(citySelect, data.cityMunicipalityCode);
        }

        try {
            let barangays = [];
            if (data.cityMunicipalityCode) {
                barangays = await getCachedBarangays(data.cityMunicipalityCode);
            }

            if ((!barangays || barangays.length === 0) && data.cityMunicipalityCode) {
                const res = await fetch(`/api/barangays?city_municipality_code=${data.cityMunicipalityCode}`);
                barangays = await res.json();
            }

            populateSelect(barangaySelect, barangays || [], 'Select barangay');
            setFieldValue(barangaySelect, data.barangayCode);
        } catch (err) {
            console.error('Error loading edit modal barangays:', err);
            resetSelect(barangaySelect, 'Failed to load barangays');
            setFieldValue(barangaySelect, data.barangayCode);
        }
    }

    document.getElementById('edit-cityMunicipalityCode')?.addEventListener('change', async (event) => {
        const cityCode = event.target.value;
        const barangaySelect = document.getElementById('edit-barangayCode');
        resetSelect(barangaySelect, 'Select barangay');

        if (!cityCode) return;

        try {
            let barangays = await getCachedBarangays(cityCode);
            if (!barangays || barangays.length === 0) {
                const res = await fetch(`/api/barangays?city_municipality_code=${cityCode}`);
                barangays = await res.json();
            }

            populateSelect(barangaySelect, barangays || [], 'Select barangay');
        } catch (err) {
            console.error('Error loading edit modal barangays:', err);
            resetSelect(barangaySelect, 'Failed to load barangays');
        }
    });

    async function openEditModal(record) {
        activeEditRecord = record;
        const d = record.data || {};
        editRecordId.value = record.id;

        await populateEditLocationDropdowns(d);

        // Populate editable fields
        EDITABLE_FIELDS.forEach(key => {
            const el = document.getElementById(`edit-${key}`);
            if (!el) return;
            if (key === 'isSenior' || key === 'isIndigeneous') {
                setFieldValue(el, normalizeYesNo(d[key]));
                return;
            }
            if (key === 'mobileNumber' || key === 'landlineNumber') {
                setFieldValue(el, d[key] || '+63');
                return;
            }
            setFieldValue(el, key === 'zipCode' ? (d[key] || '6100') : d[key]);
        });

        // Populate readonly fields
        READONLY_FIELDS.forEach(key => {
            const el = document.getElementById(`edit-${key}`);
            if (!el) return;
            if (key === 'id') {
                const clientIdDisplay = d[key] || 'Auto-generated';
                el.placeholder = clientIdDisplay;
                setFieldValue(el, clientIdDisplay);
                return;
            }
            setFieldValue(el, d[key]);
        });

        // Show modal
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        activeEditRecord = null;
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Close modal on X button, Cancel button, or backdrop click
    editModalClose?.addEventListener('click', closeEditModal);
    editModalCancel?.addEventListener('click', closeEditModal);
    editModal?.addEventListener('click', (e) => {
        if (e.target === editModal) closeEditModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !editModal.classList.contains('hidden')) {
            closeEditModal();
        }
    });

    // Save button handler
    editModalSave?.addEventListener('click', async () => {
        const recordId = editRecordId.value;
        if (!recordId) return;

        // Preserve hidden/non-editable payload fields such as surveyed_by.
        const updatedData = { ...(activeEditRecord?.data || {}) };

        EDITABLE_FIELDS.forEach(key => {
            const el = document.getElementById(`edit-${key}`);
            if (el) {
                updatedData[key] = el.value;
            }
        });

        // Preserve readonly fields from the original data
        READONLY_FIELDS.forEach(key => {
            const el = document.getElementById(`edit-${key}`);
            if (el && el.value) {
                updatedData[key] = el.value;
            }
        });

        // Always ensure surveyed_by is present from the hidden field
        const surveyedByEl = document.getElementById('edit-surveyed_by');
        if (surveyedByEl && surveyedByEl.value) {
            updatedData.surveyed_by = surveyedByEl.value;
        }

        // Disable save button while processing
        const originalContent = editModalSave.innerHTML;
        editModalSave.disabled = true;
        editModalSave.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Saving…`;

        try {
            await updateSurvey(recordId, updatedData);
            closeEditModal();
            showStatusToast('Client record updated successfully!', 'success');
            await loadPendingSurveys(); // Refresh the table
        } catch (err) {
            console.error('Error updating survey:', err);
            showStatusToast('Failed to update record. Please try again.', 'error');
        } finally {
            editModalSave.disabled = false;
            editModalSave.innerHTML = originalContent;
        }
    });

    // ─── Render a Single Row ────────────────────────────────────────────────
    function createRow(record) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-record-id', record.id);
        tr.className = 'transition-all duration-300';

        tr.innerHTML = `
            <td class="px-lg py-md font-bold text-primary">${getClientName(record)}</td>
            <td class="px-lg py-md">${formatDate(record.timestamp)}</td>
            <td class="px-lg py-md">${getSurveyType(record)}</td>
            <td class="px-lg py-md">
                <span class="flex items-center gap-xs text-secondary-fixed-dim font-bold">
                    <span class="w-2 h-2 rounded-full bg-secondary"></span> Queued
                </span>
            </td>
            <td class="px-lg py-md text-right flex justify-end gap-sm">
                <button class="edit-single-btn text-on-surface-variant hover:text-primary transition-colors" data-id="${record.id}" title="Edit">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                </button>
                <button class="sync-single-btn text-primary hover:underline font-bold" data-id="${record.id}">Sync Now</button>
                <button class="delete-single-btn text-on-surface-variant hover:text-error transition-colors" data-id="${record.id}" title="Delete">
                    <span class="material-symbols-outlined text-[20px]" data-icon="delete">delete</span>
                </button>
            </td>
        `;

        // Edit single record
        tr.querySelector('.edit-single-btn').addEventListener('click', (e) => {
            e.preventDefault();
            openEditModal(record);
        });

        // Sync single record
        tr.querySelector('.sync-single-btn').addEventListener('click', async (e) => {
            e.preventDefault();
            const btn = e.currentTarget;
            const id = btn.dataset.id;

            if (!navigator.onLine) {
                showStatusToast('Cannot sync — you are offline.', 'error');
                return;
            }

            btn.textContent = 'Syncing…';
            btn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch('/surveyor/merge', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(record.data),
                });

                if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                await deleteSurvey(id);

                // Animate row removal
                tr.style.opacity = '0';
                tr.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    tr.remove();
                    refreshCounts();
                }, 300);

                showStatusToast('Survey synced successfully!', 'success');
            } catch (err) {
                console.error('Sync failed:', err);
                btn.textContent = 'Retry';
                btn.disabled = false;

                // Show failed status on this row
                const statusCell = tr.querySelector('td:nth-child(4) span');
                if (statusCell) {
                    statusCell.innerHTML = `
                        <span class="material-symbols-outlined text-[16px]" data-icon="error_outline">error_outline</span> Failed
                    `;
                    statusCell.className = 'flex items-center gap-xs text-error font-bold';
                }

                showStatusToast('Sync failed. Please try again.', 'error');
            }
        });

        // Delete single record
        tr.querySelector('.delete-single-btn').addEventListener('click', async (e) => {
            e.preventDefault();
            const id = e.currentTarget.dataset.id;

            if (!confirm('Delete this unsaved survey? This cannot be undone.')) return;

            try {
                await deleteSurvey(id);
                tr.style.opacity = '0';
                tr.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    tr.remove();
                    refreshCounts();
                }, 300);
                showStatusToast('Record deleted.', 'info');
            } catch (err) {
                console.error('Delete failed:', err);
                showStatusToast('Failed to delete record.', 'error');
            }
        });

        return tr;
    }

    // ─── Show Empty State ───────────────────────────────────────────────────
    function showEmptyState() {
        if (!emptyStateRow) return;
        emptyStateRow.classList.remove('hidden');
    }

    function hideEmptyState() {
        if (!emptyStateRow) return;
        emptyStateRow.classList.add('hidden');
    }

    // ─── Simple Toast ───────────────────────────────────────────────────────
    function showStatusToast(message, type = 'info') {
        const existing = document.getElementById('surveyor-toast');
        if (existing) existing.remove();

        const colors = {
            success: 'bg-green-600',
            error: 'bg-red-600',
            info: 'bg-blue-600',
        };
        const icons = {
            success: 'check_circle',
            error: 'error',
            info: 'info',
        };

        const toast = document.createElement('div');
        toast.id = 'surveyor-toast';
        toast.className = `fixed bottom-6 right-6 z-50 flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white ${colors[type]} transform translate-y-4 opacity-0 transition-all duration-500 ease-out`;
        toast.innerHTML = `
            <span class="material-symbols-outlined">${icons[type]}</span>
            <span class="text-sm font-medium">${message}</span>
        `;

        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });

        setTimeout(() => {
            toast.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }, 3500);
    }

    // ─── Refresh Counts in Cards ────────────────────────────────────────────
    async function refreshCounts() {
        try {
            const count = await getPendingCount();
            if (pendingCountCard) pendingCountCard.textContent = count;

            // Update empty state
            const tbody = document.getElementById('pending-surveys-tbody');
            const dataRows = tbody?.querySelectorAll('tr:not(#empty-state-row)');
            if (!dataRows || dataRows.length === 0) {
                showEmptyState();
            } else {
                hideEmptyState();
            }
        } catch (err) {
            console.error('Error refreshing counts:', err);
        }
    }

    // ─── Load All Pending Surveys ───────────────────────────────────────────
    async function loadPendingSurveys() {
        try {
            const surveys = await getAllPendingSurveys();

            // Clear existing static rows (keep the empty state row)
            const existingRows = tableBody.querySelectorAll('tr:not(#empty-state-row)');
            existingRows.forEach(r => r.remove());

            if (surveys.length === 0) {
                showEmptyState();
                if (pendingCountCard) pendingCountCard.textContent = '0';
                if (lastSyncedCard) lastSyncedCard.textContent = '—';
                return;
            }

            hideEmptyState();

            // Sort by timestamp descending (newest first)
            surveys.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

            // Update card counts
            if (pendingCountCard) pendingCountCard.textContent = surveys.length;
            if (lastSyncedCard) lastSyncedCard.textContent = timeAgo(surveys[0].timestamp);

            // Render rows with staggered animation
            surveys.forEach((record, index) => {
                const row = createRow(record);
                row.style.opacity = '0';
                row.style.transform = 'translateY(8px)';
                tableBody.appendChild(row);

                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 50 * index);
            });
        } catch (err) {
            console.error('Error loading pending surveys:', err);
            if (pendingCountCard) pendingCountCard.textContent = '—';
        }
    }

    // ─── Sync All Button ────────────────────────────────────────────────────
    const syncAllBtn = document.getElementById('sync-all-btn');
    if (syncAllBtn) {
        syncAllBtn.addEventListener('click', async () => {
            if (!navigator.onLine) {
                showStatusToast('Cannot sync — you are offline.', 'error');
                return;
            }

            const surveys = await getAllPendingSurveys();
            if (surveys.length === 0) {
                showStatusToast('No pending surveys to sync.', 'info');
                return;
            }

            syncAllBtn.disabled = true;
            const originalContent = syncAllBtn.innerHTML;
            syncAllBtn.innerHTML = `<span class="material-symbols-outlined animate-spin">progress_activity</span> Syncing…`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            let synced = 0;
            let failed = 0;

            for (const record of surveys) {
                try {
                    const response = await fetch('/surveyor/merge', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(record.data),
                    });
                    if (!response.ok) throw new Error(`Status ${response.status}`);
                    await deleteSurvey(record.id);
                    synced++;
                } catch (err) {
                    console.error(`Failed to sync ${record.id}:`, err);
                    failed++;
                }
            }

            syncAllBtn.disabled = false;
            syncAllBtn.innerHTML = originalContent;

            if (synced > 0) showStatusToast(`${synced} survey${synced > 1 ? 's' : ''} synced!`, 'success');
            if (failed > 0) showStatusToast(`${failed} survey${failed > 1 ? 's' : ''} failed. Will retry later.`, 'error');

            await loadPendingSurveys();
        });
    }

    // ─── Init ───────────────────────────────────────────────────────────────
    loadPendingSurveys();
});
