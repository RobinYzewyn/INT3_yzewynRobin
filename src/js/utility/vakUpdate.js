{
  const init = () => {
            let currentPage = (window.location.href).split('?')[1];

    if(currentPage === "page=vaktoevoegen" && typeof currentPage !== "undefined"){

    const toevoegenRad = Array.from(document.querySelectorAll(".toevoegenRad"));
    for (let i = 0; i < toevoegenRad.length; i++) {
      toevoegenRad[i].addEventListener("click", clickRadio);
    }

    const editButton = document.querySelectorAll(".vak_edit");
    console.log(editButton);
    for (let i = 0; i < editButton.length; i++) {
      editButton[i].addEventListener("click", editVak);
    }

    const vak_remove = Array.from(document.querySelectorAll(".vak_remove"));
    for (let j = 0; j < vak_remove.length; j++) {
      vak_remove[j].addEventListener("click", removeVak);
    }
  }
  };

  clickRadio = (e) => {
    e.preventDefault();
    const arrayAll = Array.from(document.querySelectorAll(".detail_action"));
    for (let i = 0; i < arrayAll.length; i++) {
      arrayAll[i].classList.add("hidden");
      arrayAll[i].classList.remove("detail_action");
    }
    const vak_radio_checked = document.querySelector(".vak_radio_checked");
    if (vak_radio_checked) {
      vak_radio_checked.classList.remove("vak_radio_checked");
    }
    e.currentTarget.parentNode.children[1].children[2].classList.remove(
      "hidden"
    );
    e.currentTarget.parentNode.children[1].children[2].classList.add(
      "detail_action"
    );
    e.currentTarget.parentNode.children[1].classList.add("vak_radio_checked");
  };

  removeVak = async (e) => {
    e.preventDefault();
    const removeId =
      e.currentTarget.parentNode.parentNode.parentNode.children[0].id;
    console.log(
      e.currentTarget.parentNode.parentNode.parentNode.children[0].id
    );

    const response = await fetch(`index.php?page=vaktoevoegen`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
      }),
      body: `{"action": "removeVak", "vakId": "${removeId}"}`,
    });

    const returned = await response.json();
    console.log(returned);
    //TIJDELIJKE OPLOSSING
    window.location.replace("index.php?page=vaktoevoegen");
    //TODO:
    // showVakken(returned);
  };

  let $vakId = 1;
  const editVak = (e) => {
    const $vakCurrent = e.currentTarget;
    $vakId = $vakCurrent.firstElementChild.id;
    $vakOldName = $vakCurrent.firstElementChild.name;
    const $formToevoegen = document.querySelector(".form_toevoegen");
    $formToevoegen.classList.add("hidden");
    $formToevoegen.id = $vakId;

    const $formEdit = document.querySelector(".form_update");
    $formEdit.classList.remove("hidden");

    const $updateButton = document.querySelector(".update_submit");

    document.querySelector(".newVak_naam").value =
      e.currentTarget.parentNode.parentNode.children[1].innerHTML;
    document.querySelector(".newVak_docent").value =
      e.currentTarget.parentNode.parentNode.children[1].id;
    //console.log(e.currentTarget.parentNode.parentNode);

    $updateButton.addEventListener("click", postVak);

    document
      .querySelector(".button_annuleren")
      .addEventListener("click", annuleerUpdate);
  };

  annuleerUpdate = (e) => {
    e.preventDefault();
    const $formToevoegen = document.querySelector(".form_toevoegen");
    $formToevoegen.classList.remove("hidden");

    const $formEdit = document.querySelector(".form_update");
    $formEdit.classList.add("hidden");
  };

  // deze functie zal het formulier afhandelen: merk op dat dit een async functie is
  const postVak = async (e) => {
    e.preventDefault();

    const vaknaam2 = document.querySelector(".newVak_naam").value;
    const naamdocent2 = document.querySelector(".newVak_docent").value;
    const input_color = Array.from(document.querySelectorAll(".input_color"));
    let kleur2 = "";

    for (let i = 0; i < input_color.length; i++) {
      if (input_color[i].checked) {
        kleur2 = input_color[i].value;
      }
    }

    console.log($vakId);
    console.log(vaknaam2);
    console.log(naamdocent2);
    console.log(kleur2);
    console.log($vakOldName);
    const response = await fetch(`index.php?page=vaktoevoegen`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
      }),
      body: `{"action": "updateVak", "vakId": "${$vakId}", "vaknaam2": "${vaknaam2}", "naamdocent2": "${naamdocent2}", "kleur2": "${kleur2}", "vakOldName": "${$vakOldName}"}`,
    });

    const returned = await response.json();
    // console.log(returned);
    //TIJDELIJKE OPLOSSING
    // window.location.replace('index.php?page=vaktoevoegen');
    //TODO:
    showVakken(returned);
    showInputForm();
    init();
  };

  // vakken showen
  const showVakken = (vakken) => {
    console.log(vakken);
    const $allVakken = document.querySelector(".radio-toolbar");
    console.log($allVakken);
    $allVakken.innerHTML = ``;4
    vakken.forEach((vak) => {
      const $div = document.createElement("div");
      const $input = document.createElement("input");
      $input.type = "radio";
      $input.id = `${$vakId}`;
      $input.name = "radioFruit";
      $input.value = "x";
      // <label class="toevoegenRad" for="radioBanana<?php echo $vak['vak_naam']; ?>">
      const $label = document.createElement("label");
      $label.classList.add("toevoegenRad");
      $label.for = `radioBanana${vak.vak_naam}`;
      $label.innerHTML = `
      <div class="option_circle Tcolor_${vak.vak_kleur}">
        ${vak.vak_naam.substring(0, 3)}
      </div>
      <p class="toevoegen_text" id="${vak.vak_docent}">${vak.vak_naam}</p>
      <div class="hidden">
        <p class="vak_edit"><img class="icon_detail_changes" id="${$vakId}" src="./assets/img/update.svg"></p>
        <p class="vak_remove"><img class="icon_detail_changes" src="./assets/img/delete.svg"></p>
      </div>
      `;
      $div.appendChild($input);
      $div.appendChild($label);
      $allVakken.appendChild($div);
    });
  };

  const showInputForm = () => {
    const $formToevoegen = document.querySelector(".form_toevoegen");
    $formToevoegen.classList.remove("hidden");
    const $formEdit = document.querySelector(".form_update");
    $formEdit.classList.add("hidden");
  };

  init();
}
