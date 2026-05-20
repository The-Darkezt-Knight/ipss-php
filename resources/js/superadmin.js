document.addEventListener('DOMContentLoaded', ()=> {
    const openModalBtn = document.getElementById('open-modal-btn');
    const userModal = document.getElementById('user-modal');

    openModalBtn.addEventListener('click', ()=> {
        userModal.classList.toggle('flex');
    })

})
