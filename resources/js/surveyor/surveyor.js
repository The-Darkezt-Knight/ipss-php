import {
    getAllPendingSurveys,
    deleteSurvey,
    getPendingCount,
    updateSurvey,
    getCachedCitiesByDistrict,
    getCachedBarangays,
} from './offline-db.js';
import {
    DuplicateSyncError,
    DuplicateWarningCancelledError,
    assertSurveyCanSync,
    checkSurveyDuplicate,
} from './duplicate-check.js';

document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('pending-surveys-tbody');
    const pendingCountCard = document.getElementById('pending-sync-count');
    const lastSyncedCard = document.getElementById('last-synced-time');
    const emptyStateRow = document.getElementById('empty-state-row');
    const returnedSurveyRecords = new Map(
        (window.returnedSurveyRecords || []).map(record => [
            String(record.id),
            {
                id: `returned-${record.id}`,
                source: 'returned',
                serverId: record.id,
                updateUrl: record.update_url,
                sendBackUrl: record.send_back_url,
                data: record.data || {},
                timestamp: record.updated_at || new Date().toISOString(),
            },
        ])
    );

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
    const editModalTitle = document.getElementById('edit-modal-title');
    const editModalIssue = document.getElementById('edit-modal-issue');
    const editModalIssueText = document.getElementById('edit-modal-issue-text');
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
                    maximumAge: 60000,
                }
            );
        });
    }

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

    function duplicateDecisionHeadline(decision) {
        if (!decision) return '';

        if (decision.status === 'full_block') {
            return 'Sync blocked: exact client already exists.';
        }

        if (decision.status === 'philsys_block') {
            return 'Sync blocked: PhilSys already exists.';
        }

        if (decision.status === 'name_warning') {
            return 'Warning: name already exists. Confirmation is required before sync.';
        }

        if (decision.status === 'unchecked') {
            return 'Duplicate check was skipped for this record.';
        }

        return '';
    }

    function setEditModalDuplicateIssue(decision) {
        if (!editModalTitle || !editModalIssue || !editModalIssueText) return;

        editModalIssue.classList.add('hidden');
        editModalIssue.classList.remove(
            'flex',
            'border-red-300',
            'bg-red-50',
            'text-red-700',
            'border-amber-300',
            'bg-amber-50',
            'text-amber-800',
            'border-blue-300',
            'bg-blue-50',
            'text-blue-800'
        );
        editModalTitle.classList.remove('text-red-700', 'text-amber-800');
        editModalTitle.classList.add('text-primary');

        const headline = duplicateDecisionHeadline(decision);
        if (!headline || decision.status === 'clear') return;

        const isWarning = decision.status === 'name_warning';
        const isUnchecked = decision.status === 'unchecked';

        editModalTitle.classList.remove('text-primary');
        editModalTitle.classList.add(isWarning ? 'text-amber-800' : 'text-red-700');
        editModalIssue.classList.remove('hidden');
        editModalIssue.classList.add('flex');
        editModalIssue.classList.add(
            isUnchecked ? 'border-blue-300' : (isWarning ? 'border-amber-300' : 'border-red-300'),
            isUnchecked ? 'bg-blue-50' : (isWarning ? 'bg-amber-50' : 'bg-red-50'),
            isUnchecked ? 'text-blue-800' : (isWarning ? 'text-amber-800' : 'text-red-700')
        );
        editModalIssueText.textContent = `${headline} ${decision.message || ''}`.trim();
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
        setEditModalDuplicateIssue(record.duplicateDecision);

        if (record.source !== 'returned') {
            try {
                record.duplicateDecision = await checkSurveyDuplicate(record.data);
                setEditModalDuplicateIssue(record.duplicateDecision);
            } catch (err) {
                console.warn('[Duplicate Check] Failed to evaluate edit modal issue:', err);
            }
        }

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
        setEditModalDuplicateIssue(null);
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
            // Capture geolocation so the surveyor's position is updated on the admin map
            try {
                const coords = await getCurrentPosition();
                if (coords) {
                    updatedData.latitude = coords.latitude.toFixed(6);
                    updatedData.longitude = coords.longitude.toFixed(6);

                    const latEl = document.getElementById('edit-latitude');
                    const lngEl = document.getElementById('edit-longitude');
                    if (latEl) latEl.value = updatedData.latitude;
                    if (lngEl) lngEl.value = updatedData.longitude;
                }
            } catch (geoErr) {
                console.warn('[Geo] Geolocation failed, continuing without coordinates:', geoErr);
            }

            if (activeEditRecord?.source === 'returned') {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch(activeEditRecord.updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(updatedData),
                });

                if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                activeEditRecord.data = updatedData;
                activeEditRecord.timestamp = new Date().toISOString();
                updateReturnedRow(activeEditRecord);
            } else {
                await updateSurvey(recordId, updatedData);
                await loadPendingSurveys(); // Refresh the table
            }

            closeEditModal();
            showStatusToast('Client record updated successfully!', 'success');
        } catch (err) {
            console.error('Error updating survey:', err);
            showStatusToast('Failed to update record. Please try again.', 'error');
        } finally {
            editModalSave.disabled = false;
            editModalSave.innerHTML = originalContent;
        }
    });

    // ─── Render a Single Row ────────────────────────────────────────────────
    function duplicateStatusMarkup(decision) {
        if (!decision || decision.status === 'clear') {
            return `
                <div class="flex flex-col gap-xs">
                    <span class="flex items-center gap-xs text-secondary-fixed-dim font-bold">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span> Ready to sync
                    </span>
                    <span class="text-[11px] text-on-surface-variant">No duplicate match found.</span>
                </div>
            `;
        }

        if (decision.status === 'full_block') {
            return `
                <div class="flex flex-col gap-xs" title="${decision.message}">
                    <span class="flex items-center gap-xs text-red-700 font-bold">
                        <span class="material-symbols-outlined text-[18px]">block</span> Sync blocked
                    </span>
                    <span class="text-[11px] leading-4 text-red-700 font-semibold">Exact PhilSys and name match already exists.</span>
                </div>
            `;
        }

        if (decision.status === 'philsys_block') {
            return `
                <div class="flex flex-col gap-xs" title="${decision.message}">
                    <span class="flex items-center gap-xs text-red-700 font-bold">
                        <span class="material-symbols-outlined text-[18px]">badge</span> Sync blocked
                    </span>
                    <span class="text-[11px] leading-4 text-red-700 font-semibold">PhilSys ID is already registered in this barangay.</span>
                </div>
            `;
        }

        if (decision.status === 'name_warning') {
            return `
                <div class="flex flex-col gap-xs" title="${decision.message}">
                    <span class="flex items-center gap-xs text-amber-800 font-bold">
                        <span class="material-symbols-outlined text-[18px]">warning</span> Needs confirmation
                    </span>
                    <span class="text-[11px] leading-4 text-amber-800 font-semibold">Client name matches an existing record.</span>
                </div>
            `;
        }

        return `
            <div class="flex flex-col gap-xs" title="${decision.message}">
                <span class="flex items-center gap-xs text-blue-700 font-bold">
                    <span class="material-symbols-outlined text-[18px]">info</span> Not checked
                </span>
                <span class="text-[11px] leading-4 text-blue-700 font-semibold">No barangay was available for duplicate lookup.</span>
            </div>
        `;
    }

    function applyDuplicateDecision(row, decision) {
        if (!row || !decision) return;

        const recordId = row.dataset.recordId;
        if (recordId) {
            row.dataset.duplicateMessage = decision.message || '';
        }

        row.dataset.duplicateStatus = decision.status;
        row.classList.remove(
            'bg-red-50',
            'bg-red-100',
            'bg-amber-50',
            'bg-blue-50',
            'border-l-4',
            'border-l-8',
            'border-red-600',
            'border-red-700',
            'border-amber-500',
            'border-blue-500',
            'ring-1',
            'ring-red-200',
            'ring-amber-200'
        );
        row.title = '';

        const statusCell = row.querySelector('[data-sync-status]');
        if (statusCell) {
            statusCell.innerHTML = duplicateStatusMarkup(decision);
        }

        const syncButton = row.querySelector('.sync-single-btn');
        if (!syncButton) return;

        syncButton.disabled = false;
        syncButton.classList.remove('opacity-50', 'opacity-60', 'cursor-not-allowed', 'text-amber-700', 'text-red-700');
        syncButton.textContent = 'Sync Now';
        syncButton.title = '';

        if (decision.status === 'full_block' || decision.status === 'philsys_block') {
            row.classList.add('bg-red-100', 'border-l-8', 'border-red-700', 'ring-1', 'ring-red-200');
            row.title = decision.message;
            syncButton.disabled = true;
            syncButton.textContent = 'Blocked';
            syncButton.title = decision.message;
            syncButton.classList.add('opacity-60', 'cursor-not-allowed', 'text-red-700');
            return;
        }

        if (decision.status === 'name_warning') {
            row.classList.add('bg-amber-50', 'border-l-8', 'border-amber-500', 'ring-1', 'ring-amber-200');
            row.title = decision.message;
            syncButton.textContent = 'Review & Sync';
            syncButton.title = decision.message;
            syncButton.classList.add('text-amber-700');
            return;
        }

        if (decision.status === 'unchecked') {
            row.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
            syncButton.title = decision.message;
        }
    }

    async function syncSurveyRecord(record, row, button, options = {}) {
        const btn = button || row?.querySelector('.sync-single-btn');
        const originalText = btn?.textContent || 'Sync Now';

        if (!navigator.onLine) {
            showStatusToast('Cannot sync — you are offline.', 'error');
            return false;
        }

        if (btn) {
            btn.textContent = 'Checking…';
            btn.disabled = true;
        }

        try {
            const decision = await assertSurveyCanSync(record.data, {
                confirmNameWarning: options.confirmNameWarning,
                requireConfirmation: options.requireConfirmation,
            });
            applyDuplicateDecision(row, decision);

            if (btn) btn.textContent = 'Syncing…';

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

            if (response.status === 409) {
                const payload = await response.json().catch(() => ({}));
                throw new DuplicateSyncError(payload.duplicate || {
                    status: 'philsys_block',
                    canSync: false,
                    message: payload.message || 'Duplicate client record detected.',
                });
            }

            if (!response.ok) throw new Error(`Server responded with ${response.status}`);

            await deleteSurvey(record.id);

            if (row) {
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    row.remove();
                    refreshCounts();
                }, 300);
            }

            return true;
        } catch (err) {
            if (err instanceof DuplicateSyncError || err instanceof DuplicateWarningCancelledError) {
                applyDuplicateDecision(row, err.decision);
                showStatusToast(err.decision.message, err instanceof DuplicateSyncError ? 'error' : 'info');
                return false;
            }

            console.error('Sync failed:', err);

            const statusCell = row?.querySelector('[data-sync-status]');
            if (statusCell) {
                statusCell.innerHTML = `
                    <div class="flex flex-col gap-xs">
                        <span class="flex items-center gap-xs text-red-700 font-bold">
                            <span class="material-symbols-outlined text-[18px]" data-icon="error_outline">error_outline</span> Sync not completed
                        </span>
                        <span class="text-[11px] leading-4 text-red-700 font-semibold">Server or network error. The record is still queued.</span>
                    </div>
                `;
            }
            if (row) {
                row.classList.add('bg-red-50', 'border-l-8', 'border-red-700', 'ring-1', 'ring-red-200');
                row.title = 'Sync not completed. Server or network error. The record is still queued.';
            }

            showStatusToast('Sync not completed. The record is still queued.', 'error');
            return false;
        } finally {
            if (btn && document.body.contains(btn) && row?.dataset.duplicateStatus !== 'full_block' && row?.dataset.duplicateStatus !== 'philsys_block') {
                btn.disabled = false;
                btn.textContent = row?.dataset.duplicateStatus === 'name_warning' ? 'Review & Sync' : originalText;
            }
        }
    }

    function createRow(record) {
        const tr = document.createElement('tr');
        tr.setAttribute('data-record-id', record.id);
        tr.className = 'transition-all duration-300';

        tr.innerHTML = `
            <td class="px-lg py-md font-bold text-primary">${getClientName(record)}</td>
            <td class="px-lg py-md">${formatDate(record.timestamp)}</td>
            <td class="px-lg py-md">${getSurveyType(record)}</td>
            <td class="px-lg py-md" data-sync-status>
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
            const currentRowDecision = tr.dataset.duplicateStatus ? {
                status: tr.dataset.duplicateStatus,
                message: tr.dataset.duplicateMessage || '',
                canSync: tr.dataset.duplicateStatus !== 'full_block' && tr.dataset.duplicateStatus !== 'philsys_block',
            } : null;
            if (currentRowDecision) {
                record.duplicateDecision = currentRowDecision;
            }
            openEditModal(record);
        });

        // Sync single record
        tr.querySelector('.sync-single-btn').addEventListener('click', async (e) => {
            e.preventDefault();
            const btn = e.currentTarget;
            const synced = await syncSurveyRecord(record, tr, btn, { confirmNameWarning: true });
            if (synced) showStatusToast('Survey synced successfully!', 'success');
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

    function updateReturnedRow(record) {
        const row = document.querySelector(`[data-returned-record-id="${CSS.escape(String(record.serverId))}"]`);
        if (!row) return;

        const nameCell = row.querySelector('.returned-client-name');
        const dateCell = row.querySelector('.returned-client-date');
        const typeCell = row.querySelector('.returned-client-type');

        if (nameCell) nameCell.textContent = getClientName(record);
        if (dateCell) dateCell.textContent = formatDate(record.timestamp);
        if (typeCell) typeCell.textContent = getSurveyType(record);
    }

    document.querySelectorAll('.edit-returned-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();

            const record = returnedSurveyRecords.get(String(button.dataset.returnedRecordId));
            if (!record) {
                showStatusToast('Returned client record is missing from this page.', 'error');
                return;
            }

            openEditModal(record);
        });
    });

    // ─── Send Back Returned Survey ──────────────────────────────────────────
    document.querySelectorAll('.send-returned-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault();

            const recordId = String(button.dataset.returnedRecordId);
            const sendBackUrl = button.dataset.sendBackUrl;
            const record = returnedSurveyRecords.get(recordId);

            if (!record || !sendBackUrl) {
                showStatusToast('Returned client record is missing from this page.', 'error');
                return;
            }

            // ── 1. Connection check ─────────────────────────────────────────
            if (!navigator.onLine) {
                showStatusToast('Cannot send — you are offline. Please check your connection.', 'error');
                return;
            }

            // ── 2. Capture surveyor geolocation ─────────────────────────────
            let coords = null;
            try {
                coords = await getCurrentPosition();
            } catch (geoErr) {
                console.warn('[Geo] Geolocation failed, will send without coordinates:', geoErr);
            }

            // ── 3. Disable button and show loading state ────────────────────
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Sending…';
            button.classList.add('opacity-60', 'cursor-not-allowed');

            // ── 4. POST to the send-back endpoint ───────────────────────────
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const payload = {};
                if (coords) {
                    payload.latitude = coords.latitude;
                    payload.longitude = coords.longitude;
                }

                const response = await fetch(sendBackUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) throw new Error(`Server responded with ${response.status}`);

                // ── 5. Animate row removal on success ───────────────────────
                const row = button.closest('tr');
                if (row) {
                    row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => row.remove(), 300);
                }

                // Remove from in-memory map
                returnedSurveyRecords.delete(recordId);

                showStatusToast('Returned survey sent back for verification!', 'success');
            } catch (err) {
                console.error('Send-back failed:', err);
                button.disabled = false;
                button.textContent = 'Retry';
                button.classList.remove('opacity-60', 'cursor-not-allowed');

                // Show failed status on the row
                const statusCell = button.closest('tr')?.querySelector('td:nth-child(4) span');
                if (statusCell) {
                    statusCell.innerHTML = `
                        <span class="material-symbols-outlined text-[16px]" data-icon="error_outline">error_outline</span> Failed
                    `;
                    statusCell.className = 'inline-flex items-center gap-xs text-error font-bold';
                }

                showStatusToast('Failed to send survey. Please try again.', 'error');
            }
        });
    });

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
                checkSurveyDuplicate(record.data)
                    .then((decision) => applyDuplicateDecision(row, decision))
                    .catch((err) => console.warn('[Duplicate Check] Failed to evaluate pending row:', err));

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

            const duplicateResults = [];
            for (const record of surveys) {
                const decision = await checkSurveyDuplicate(record.data);
                const row = document.querySelector(`[data-record-id="${CSS.escape(String(record.id))}"]`);
                applyDuplicateDecision(row, decision);
                duplicateResults.push({ record, decision, row });
            }

            const blocked = duplicateResults.filter(({ decision }) => !decision.canSync);
            const warnings = duplicateResults.filter(({ decision }) => decision.status === 'name_warning');
            const syncable = duplicateResults.filter(({ decision }) => decision.canSync);

            if (blocked.length > 0) {
                showStatusToast(`${blocked.length} duplicate survey${blocked.length > 1 ? 's were' : ' was'} blocked.`, 'error');
            }

            if (warnings.length > 0) {
                const confirmed = confirm(`${warnings.length} survey${warnings.length > 1 ? 's have' : ' has'} matching client names in this barangay.\n\nSync these warning records anyway?`);
                if (!confirmed) {
                    showStatusToast('Sync all cancelled. Name-match warnings need confirmation.', 'info');
                    return;
                }
            }

            if (syncable.length === 0) {
                showStatusToast('No syncable surveys after duplicate checks.', 'error');
                return;
            }

            syncAllBtn.disabled = true;
            const syncAllOriginalContent = syncAllBtn.innerHTML;
            syncAllBtn.innerHTML = `<span class="material-symbols-outlined animate-spin">progress_activity</span> Syncing…`;

            let syncAllSynced = 0;
            let syncAllFailed = 0;

            for (const { record, row } of syncable) {
                const didSync = await syncSurveyRecord(record, row, null, { confirmNameWarning: false });
                if (didSync) {
                    syncAllSynced++;
                } else {
                    syncAllFailed++;
                }
            }

            syncAllBtn.disabled = false;
            syncAllBtn.innerHTML = syncAllOriginalContent;

            if (syncAllSynced > 0) showStatusToast(`${syncAllSynced} survey${syncAllSynced > 1 ? 's' : ''} synced!`, 'success');
            if (syncAllFailed > 0) showStatusToast(`${syncAllFailed} survey${syncAllFailed > 1 ? 's' : ''} failed or were skipped.`, 'error');

            await loadPendingSurveys();
        });
    }

    // ─── Init ───────────────────────────────────────────────────────────────
    loadPendingSurveys();
});
