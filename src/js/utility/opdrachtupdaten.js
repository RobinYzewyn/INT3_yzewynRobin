{
  const init = () => {
    //const $updateForm = document.querySelector('.detail_edit');
    //console.log($updateForm);
    //$updateForm.addEventListener("click", showForm);
  };

  const showForm = async (e) => {
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
    const returned = await response.json();

    $form.classList.remove('hidden');
  }

  init();
}
