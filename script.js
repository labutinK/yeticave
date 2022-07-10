'use strict';

flatpickr('#lot-date', {
  enableTime: false,
  dateFormat: "Y-m-d",
  locale: "ru"
});

const fileField = document.querySelector('.form__input-file input');
const fileFieldText = document.querySelector('.form__input-file label');

if(fileField){
  const addText = fileFieldText.textContent;
  fileField.addEventListener('change', (evt) => {
    if(evt.target.value){
      let fileName = evt.target.value.split('\\').slice(-1).join();
      fileFieldText.textContent = fileName.substring(0, 6);
      if(fileName.length > 6){
        fileFieldText.textContent += '...';
      }

    }
   else{
      fileFieldText.textContent = addText;
    }
  })
}