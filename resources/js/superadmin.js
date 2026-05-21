document.addEventListener('DOMContentLoaded', () => {
    // 1. Get all the elements
    const userModal = document.getElementById('user-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');

    const createUserForm = document.getElementById('create-user-form');
    const modalTitle = document.getElementById('modal-title');
    const submitFormBtn = document.getElementById('submit-form-btn');
    const defaultFormAction = createUserForm ? createUserForm.action : '';

    // 2. Define Open and Close functions
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
        }
    }

    // 3. Attach Event Listeners
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }
    
    // 4. Edit user logic
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
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

                // Populate fields
                document.getElementById('first-name').value = employee.first_name || '';
                document.getElementById('middle-name').value = employee.middle_name || '';
                document.getElementById('last-name').value = employee.last_name || '';
                document.getElementById('birthdate').value = employee.birth_date || '';
                document.getElementById('sex').value = employee.sex || '';
                document.getElementById('barangay').value = employee.barangay || '';
                document.getElementById('region').value = employee.region || '';
                document.getElementById('city').value = employee.city_municipality || '';
                document.getElementById('province').value = employee.province || '';
                document.getElementById('gov-email').value = employee.govt_email || '';
                document.getElementById('gov-id').value = employee.govt_id || '';

                const roleRadio = createUserForm.querySelector(`input[name="role"][value="${employee.role}"]`);
                if (roleRadio) roleRadio.checked = true;

                // Update UI for Edit mode
                if (modalTitle) modalTitle.textContent = 'Edit User Profile';
                if (submitFormBtn) submitFormBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]" aria-hidden="true">save</span> Save Changes';
            }

            openModal();
        });
    });

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }
    
    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', closeModal);
    }

    // Optional: Close the modal if the user clicks the dark background outside the panel
    if (userModal) {
        userModal.addEventListener('click', (event) => {
            if (event.target === userModal) {
                closeModal();
            }
        });
    }
});