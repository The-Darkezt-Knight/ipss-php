document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('user-modal');
  const openBtn = document.getElementById('open-modal-btn');
  const closeBtns = [document.getElementById('close-modal-btn'), document.getElementById('cancel-modal-btn')];

  openBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
  });

  closeBtns.forEach(btn => {
    if(btn) {
      btn.addEventListener('click', () => {
        modal.classList.add('hidden');
      });
    }
  });
});
