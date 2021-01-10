{
  const init = () =>{
        let currentPage = (window.location.href).split('?')[1];

    if(currentPage === "page=opdrachten" && typeof currentPage !== "undefined"){

    const task = document.querySelectorAll('.task');
    for (let i = 0; i < task.length; i++) {
      task[i].addEventListener('click', clickTask);
    }
    const eventday = Array.from(document.querySelectorAll('.eventday'));
    for (let j = 0; j < eventday.length; j++) {
      eventday[j].addEventListener('click', setLink);
    }

    const close_detail = document.querySelector('.close_detail');
    close_detail.addEventListener('click', closeDetail);
  }
  }
  let returned = '';
  
  clickTask = async (e) =>{
    e.preventDefault();
    document.querySelector('.opdrachtendiv').classList.add('overflow');
    console.log('Click task');
    //Opdracht detail:
    //Specific opdracht_datum
    //Specific opdracht_tijd
    //Specific opdracht_naam
    //Specific opdracht_omschrijving
    //Specific opdracht_link

    //Get id
    //specificOpdracht
    const id = e.currentTarget.id;

    const response = await fetch(`index.php?page=opdracht&id=${id}`, {
      method: "GET",
      headers: new Headers({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }),
    });
    returned = await response.json();
    console.log(returned);
    console.log(returned['vak_kleur']);
    document.querySelector('.task_detail').classList.remove('hidden');
    document.querySelector('.opdracht_desktop').className += returned['vak_kleur'];
    document.querySelector('.detail_lesson').className += (' detail_' + returned['vak_kleur']);
    document.querySelector('.detail_title').innerHTML = returned['opdracht_naam'];
    document.querySelector('.detail_date').innerHTML = returned['opdracht_datum'] + ' - ' + returned['opdracht_tijd'];
    document.querySelector('.detail_description').innerHTML = returned['opdracht_omschrijving'];
    document.querySelector('.detail_link').href = returned['opdracht_link'];
    document.querySelector('.detail_remove').href = 'index.php?page=opdracht&id='+ returned['id'] +'&action=deleteOpdracht&opdracht_id=' + returned['id'];
    const $updateForm = document.querySelector('.detail_edit');
    console.log($updateForm);
    $updateForm.addEventListener("click", showForm);
  }

  const showForm = async (e) => {
    document.querySelector('.opdrachtendiv').classList.add('overflow');
    const detailOpdracht = document.querySelector('.js_detail');
    detailOpdracht.classList.add('hidden');
    const $form = document.querySelector(".detail_opdracht_form");


    const id = e.currentTarget.id;
    const response = await fetch(`index.php?page=opdracht&id=${id}`, {
      method: "GET",
      headers: new Headers({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }),
    });
    document.querySelector('.detail_opdracht_form').classList.add('task_detail'+returned['vak_kleur']);
    document.querySelector('.update_form_detail').action = 'index.php?page=opdracht&id=' + returned['id'];
    document.querySelector('.update_form_date').value = returned['opdracht_datum'];
    document.querySelector('.update_form_tijd').value = returned['opdracht_tijd'];
    document.querySelector('.update_form_naam').value = returned['opdracht_naam'];
    document.querySelector('.update_form_omschrijving').innerHTML = returned['opdracht_omschrijving'];
    document.querySelector('.update_form_link').value = returned['opdracht_link'];
    $form.classList.remove('hidden');
  }

  setLink = async (e) =>{
    console.log('Click date');
    //Get date YYYY-MM-DD
    let dateNumber = (e.currentTarget.innerHTML).trim();
    if(dateNumber.length == 1){
      dateNumber = '0'+dateNumber;
    }
    const dateMonthYear = document.querySelector('.today').innerHTML;
    const dateYear = dateMonthYear.substr(dateMonthYear.length - 4);
    let dateMonthLetters= dateMonthYear.substr(0, dateMonthYear.indexOf(','));
    const monthsinNumber = [" ", "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"];
    for (let j = 0; j < monthsinNumber.length; j++) {
      if(monthsinNumber[j] == dateMonthLetters){
        dateMonthLetters = j;
      }
    }
    const fullDate = dateYear + '-' + dateMonthLetters + '-' + dateNumber;

    //Select opdracht by date
    const response = await fetch(`index.php?page=opdrachten&date=${fullDate}`, {
      method: "GET",
      headers: new Headers({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }),
    });
    returnedDate = await response.json();
    console.log(returnedDate);
    //Geef opdrachtdetail van date terug
    document.querySelector('.task_detail').classList.remove('hidden');
    document.querySelector('.opdracht_desktop').className += returnedDate['vak_kleur'];
    document.querySelector('.detail_lesson').className += (' detail_' + returnedDate['vak_kleur']);
    document.querySelector('.detail_title').innerHTML = returnedDate['opdracht_naam'];
    document.querySelector('.detail_date').innerHTML = returnedDate['opdracht_datum'] + ' - ' + returnedDate['opdracht_tijd'];
    document.querySelector('.detail_description').innerHTML = returnedDate['opdracht_omschrijving'];
    document.querySelector('.detail_link').href = returnedDate['opdracht_link'];
    document.querySelector('.detail_remove').href = 'index.php?page=opdracht&id='+ returnedDate['id'] +'&action=deleteOpdracht&opdracht_id=' + returnedDate['id'];
    const $updateForm = document.querySelector('.detail_edit');
    console.log($updateForm);
    $updateForm.addEventListener("click", showForm);
  }

  closeDetail = () =>{
    const detailOpdracht = document.querySelector('.js_detail');
    detailOpdracht.classList.add('hidden');
    document.querySelector('.opdrachtendiv').classList.remove('overflow');
  }

  init();
}
