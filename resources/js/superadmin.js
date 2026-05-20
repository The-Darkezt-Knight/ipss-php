document.addEventListener('DOMContentLoaded', () => {
    // 1. Get all the elements
    const userModal = document.getElementById('user-modal');
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');

    // 2. Define Open and Close functions
    function openModal() {
        userModal.classList.remove('hidden');
        userModal.classList.add('flex');
    }

    function closeModal() {
        userModal.classList.add('hidden');
        userModal.classList.remove('flex');
    }

    // 3. Attach Event Listeners
    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }
    
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