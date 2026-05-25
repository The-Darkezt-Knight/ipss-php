document.addEventListener('DOMContentLoaded', () => {
    // ═══════════════════════════════════════════════════════════════════════
    // Modal & Form Elements
    // ═══════════════════════════════════════════════════════════════════════
    const userModal = document.getElementById('user-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');

    const createUserForm = document.getElementById('create-user-form');
    const modalTitle = document.getElementById('modal-title');
    const submitFormBtn = document.getElementById('submit-form-btn');
    const defaultFormAction = createUserForm ? createUserForm.action : '';

    // ═══════════════════════════════════════════════════════════════════════
    // Location Dropdown Elements
    // ═══════════════════════════════════════════════════════════════════════
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const districtCodeInput = document.getElementById('district_code');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');
    const cityBarangayFields = document.getElementById('city-barangay-fields');
    const districtField = document.getElementById('district-field');

    // ═══════════════════════════════════════════════════════════════════════
    // Modal Open / Close
    // ═══════════════════════════════════════════════════════════════════════
    function openModal() {
        userModal.classList.remove('hidden');
        userModal.classList.add('flex');
    }

    function closeModal() {
        userModal.classList.add('hidden');
        userModal.classList.remove('flex');

        // Reset form to Create mode
        if (createUserForm) {
            createUserForm.reset();
            createUserForm.action = defaultFormAction;

            // Remove _method input if exists
            const methodInput = createUserForm.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }

            if (modalTitle) modalTitle.textContent = 'Create New User Profile';
            if (submitFormBtn) submitFormBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]" aria-hidden="true">person_add</span> Submit Entry';

            // Reset location dropdowns
            resetSelect(provinceSelect, 'Select Province…');
            resetSelect(districtSelect, 'Select District…');
            resetSelect(citySelect, 'Select City / Municipality…');
            resetSelect(barangaySelect, 'Select Barangay…');
            if (districtCodeInput) districtCodeInput.value = '';

            // Reset role-dependent visibility
            updateRoleVisibility(null);
        }
    }

    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', closeModal);
    }

    // Close on background click
    if (userModal) {
        userModal.addEventListener('click', (event) => {
            if (event.target === userModal) {
                closeModal();
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Cascading Dropdown Helpers
    // ═══════════════════════════════════════════════════════════════════════
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
            option.value = item.name; // Store the name as the value (plain text)
            option.dataset.code = item.code; // Store the PSGC code as data attribute
            option.textContent = item.name;
            select.appendChild(option);
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Load Regions on Modal Open
    // ═══════════════════════════════════════════════════════════════════════
    let regionsLoaded = false;

    async function loadRegions() {
        if (regionsLoaded) return;
        try {
            const res = await fetch('/api/regions');
            const data = await res.json();
            populateSelect(regionSelect, data, 'Select Region…');
            regionsLoaded = true;
        } catch (err) {
            console.error('Error loading regions:', err);
        }
    }

    // Load regions when modal opens
    if (openModalBtn) {
        const origOpenClick = openModalBtn.onclick;
        openModalBtn.addEventListener('click', () => {
            loadRegions();
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Cascading: Region → Province
    // ═══════════════════════════════════════════════════════════════════════
    if (regionSelect) {
        regionSelect.addEventListener('change', async function () {
            resetSelect(provinceSelect, 'Select Province…');
            resetSelect(districtSelect, 'Select District…');
            resetSelect(citySelect, 'Select City / Municipality…');
            resetSelect(barangaySelect, 'Select Barangay…');
            if (districtCodeInput) districtCodeInput.value = '';

            const selectedOption = this.options[this.selectedIndex];
            const regionCode = selectedOption?.dataset.code;

            if (regionCode) {
                try {
                    const res = await fetch(`/api/provinces?region_code=${regionCode}`);
                    const data = await res.json();
                    populateSelect(provinceSelect, data, 'Select Province…');
                } catch (err) {
                    console.error('Error loading provinces:', err);
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Cascading: Province → District (and optionally City)
    // ═══════════════════════════════════════════════════════════════════════
    if (provinceSelect) {
        provinceSelect.addEventListener('change', async function () {
            resetSelect(districtSelect, 'Select District…');
            resetSelect(citySelect, 'Select City / Municipality…');
            resetSelect(barangaySelect, 'Select Barangay…');
            if (districtCodeInput) districtCodeInput.value = '';

            const selectedOption = this.options[this.selectedIndex];
            const provinceCode = selectedOption?.dataset.code;

            if (provinceCode) {
                try {
                    const res = await fetch(`/api/districts?province_code=${provinceCode}`);
                    const data = await res.json();
                    populateSelect(districtSelect, data, 'Select District…');
                } catch (err) {
                    console.error('Error loading districts:', err);
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Cascading: District → City (when city/barangay visible)
    // ═══════════════════════════════════════════════════════════════════════
    if (districtSelect) {
        districtSelect.addEventListener('change', async function () {
            resetSelect(citySelect, 'Select City / Municipality…');
            resetSelect(barangaySelect, 'Select Barangay…');

            const selectedOption = this.options[this.selectedIndex];
            const districtCode = selectedOption?.dataset.code;

            // Store district_code in hidden input
            if (districtCodeInput) {
                districtCodeInput.value = districtCode || '';
            }

            if (districtCode && cityBarangayFields && !cityBarangayFields.classList.contains('hidden')) {
                try {
                    const res = await fetch(`/api/cities-municipalities?district_code=${districtCode}`);
                    const data = await res.json();
                    populateSelect(citySelect, data, 'Select City / Municipality…');
                } catch (err) {
                    console.error('Error loading cities:', err);
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Cascading: City → Barangay
    // ═══════════════════════════════════════════════════════════════════════
    if (citySelect) {
        citySelect.addEventListener('change', async function () {
            resetSelect(barangaySelect, 'Select Barangay…');

            const selectedOption = this.options[this.selectedIndex];
            const cityCode = selectedOption?.dataset.code;

            if (cityCode) {
                try {
                    const res = await fetch(`/api/barangays?city_municipality_code=${cityCode}`);
                    const data = await res.json();
                    populateSelect(barangaySelect, data, 'Select Barangay…');
                } catch (err) {
                    console.error('Error loading barangays:', err);
                }
            }
        });
    }

    // ═══════════════════════════════════════════════════════════════════════
    // Role-Dependent Field Visibility
    // ═══════════════════════════════════════════════════════════════════════
    function updateRoleVisibility(role) {
        if (!cityBarangayFields || !districtField) return;

        if (role === 'ROLE_SURVEYOR') {
            // Hide city/barangay for surveyors, show district as required
            cityBarangayFields.classList.add('hidden');
            districtField.classList.remove('hidden');
        } else {
            // Show city/barangay for other roles
            cityBarangayFields.classList.remove('hidden');
            districtField.classList.remove('hidden');
        }
    }

    // Listen for role radio changes
    const roleRadios = document.querySelectorAll('input[name="role"]');
    roleRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            updateRoleVisibility(this.value);
        });
    });

    // ═══════════════════════════════════════════════════════════════════════
    // Edit User Logic
    // ═══════════════════════════════════════════════════════════════════════
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', async function() {
            const employee = JSON.parse(this.getAttribute('data-employee'));

            if (createUserForm) {
                // Change action to update route
                createUserForm.action = `/employee/${employee.id}`;

                // Add PUT method override
                let methodInput = createUserForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    createUserForm.appendChild(methodInput);
                }

                // Populate personal fields
                document.getElementById('first-name').value = employee.first_name || '';
                document.getElementById('middle-name').value = employee.middle_name || '';
                document.getElementById('last-name').value = employee.last_name || '';
                document.getElementById('birthdate').value = employee.birth_date || '';
                document.getElementById('sex').value = employee.sex || '';
                document.getElementById('gov-email').value = employee.govt_email || '';
                document.getElementById('gov-id').value = employee.govt_id || '';

                const roleRadio = createUserForm.querySelector(`input[name="role"][value="${employee.role}"]`);
                if (roleRadio) roleRadio.checked = true;

                // Update role visibility
                updateRoleVisibility(employee.role);

                // Load regions and pre-select cascading values
                await loadRegions();

                // Pre-select region
                if (employee.region) {
                    const regionOpt = Array.from(regionSelect.options).find(o => o.value === employee.region);
                    if (regionOpt) {
                        regionSelect.value = employee.region;
                        // Load provinces for this region
                        const regionCode = regionOpt.dataset.code;
                        if (regionCode) {
                            try {
                                const res = await fetch(`/api/provinces?region_code=${regionCode}`);
                                const provinces = await res.json();
                                populateSelect(provinceSelect, provinces, 'Select Province…');

                                // Pre-select province
                                if (employee.province) {
                                    provinceSelect.value = employee.province;
                                    const provOpt = Array.from(provinceSelect.options).find(o => o.value === employee.province);
                                    const provCode = provOpt?.dataset.code;

                                    if (provCode) {
                                        // Load districts
                                        const dRes = await fetch(`/api/districts?province_code=${provCode}`);
                                        const districts = await dRes.json();
                                        populateSelect(districtSelect, districts, 'Select District…');

                                        // Pre-select district
                                        if (employee.district) {
                                            districtSelect.value = employee.district;
                                            const distOpt = Array.from(districtSelect.options).find(o => o.value === employee.district);
                                            if (distOpt && districtCodeInput) {
                                                districtCodeInput.value = distOpt.dataset.code || employee.district_code || '';
                                            }
                                        }
                                    }
                                }
                            } catch (err) {
                                console.error('Error pre-populating locations:', err);
                            }
                        }
                    }
                }

                // Update UI for Edit mode
                if (modalTitle) modalTitle.textContent = 'Edit User Profile';
                if (submitFormBtn) submitFormBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]" aria-hidden="true">save</span> Save Changes';
            }

            openModal();
        });
    });

    // ═══════════════════════════════════════════════════════════════════════
    // Search and Filter Logic
    // ═══════════════════════════════════════════════════════════════════════
    const searchInput = document.getElementById('search-input');
    const filterRole = document.getElementById('filter-role');
    const filterStatus = document.getElementById('filter-status');
    const tableRows = document.querySelectorAll('#user-tbody tr');

    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const roleTerm = filterRole ? filterRole.value.toLowerCase() : 'all roles';
        const statusTerm = filterStatus ? filterStatus.value.toLowerCase() : 'all status';

        tableRows.forEach(row => {
            // Get text contents of the cells
            const nameCell = row.cells[0]?.textContent.toLowerCase() || '';
            const emailCell = row.cells[1]?.textContent.toLowerCase() || '';
            const idCell = row.cells[2]?.textContent.toLowerCase() || '';
            const roleCell = row.cells[3]?.textContent.toLowerCase() || '';
            const statusCell = row.cells[4]?.textContent.toLowerCase() || '';

            // Search matches (name, email, or id)
            const matchesSearch = searchTerm === '' ||
                nameCell.includes(searchTerm) ||
                emailCell.includes(searchTerm) ||
                idCell.includes(searchTerm);

            // Role matches
            const matchesRole = roleTerm === 'all roles' ||
                roleCell.includes(roleTerm);

            // Status matches
            let matchesStatus = false;
            if (statusTerm === 'all status') {
                matchesStatus = true;
            } else if (statusTerm === 'active') {
                matchesStatus = statusCell.trim() === 'active';
            } else if (statusTerm === 'inactive') {
                matchesStatus = statusCell.trim() === 'inactive';
            }

            // Display row if it matches all conditions
            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterRole) filterRole.addEventListener('change', filterTable);
    if (filterStatus) filterStatus.addEventListener('change', filterTable);
});