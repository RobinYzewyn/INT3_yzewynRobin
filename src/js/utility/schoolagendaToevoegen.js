{
  const input = (document.querySelector('.input_file'));
  const init = () =>{
        let currentPage = (window.location.href).split('?')[1];

    if(currentPage === "page=schoolagendaToevoegen" && typeof currentPage !== "undefined"){

   input.addEventListener('change', checkFileUpload);
    }
  }

  checkFileUpload = () =>{

    if (input.value != ""){
      console.log('File selected');
      document.querySelector('.file_selected').classList.remove('hidden');
      document.querySelector('.agendatoevogen_form').style.marginTop = "0.5rem";
      document.querySelector('.agenda_label').innerHTML = input.value;
    }
  }

  init();
}
