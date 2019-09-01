const modalEl = document.querySelector('.modal');
const modalBtnEl = document.querySelector('.modal-btn');
const modalFormEl = modalEl.querySelector('form');
const editBtnEl =  document.querySelectorAll('.edit-btn');

const nameEl =  modalEl.querySelector('.name');
const dateEl =  modalEl.querySelector('.date');


editBtnEl.forEach(function(editBtn) {
  editBtn.addEventListener('click', function() {
    const persName = editBtn.getAttribute('data-name');
    const persDate = editBtn.getAttribute('data-date');
    const persId = editBtn.getAttribute('data-id');

    nameEl.setAttribute('value', persName); 
    dateEl.setAttribute('value', persDate);

    modalEl.classList.toggle('active');
  
    modalFormEl.setAttribute('action', '/update?id=' + persId);
    
  });
});

modalBtnEl.addEventListener("submit", function(e) {
  e.preventDefault();
})

modalBtnEl.addEventListener('click', function() {
  modalFormEl.setAttribute('action', '/page/store');
  modalEl.classList.toggle('active');
});


