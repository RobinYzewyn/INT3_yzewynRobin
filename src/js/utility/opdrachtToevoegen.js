{
  const init = () => {
    let currentPage = (window.location.href).split('?')[1];
    if(currentPage === "page=opdrachttoevoegen" && typeof currentPage !== "undefined"){
    const toevoegenRad = document.querySelectorAll('.toevoegenRad');
    for (let i = 0;i < toevoegenRad.length;i ++) {
      toevoegenRad[i].addEventListener('click', radioButtonSelect);
    }

    const toevoegen_stap1 = document.querySelector('.button_stap1-volgende');
    toevoegen_stap1.addEventListener('click', naarStap2);

    const vakToevoegen = document.querySelector('.circle_add');
    vakToevoegen.addEventListener('click', vakForm);

    const button_stap1_vorige = document.querySelector('.button_stap1-vorige');
    button_stap1_vorige.addEventListener('click', vorigeStap1NEW);
  }
  };

  addOpdracht = async e => {
    //Opdracht importeren in DB
    e.preventDefault();
    console.log('Add task');
    console.log(
      document
        .querySelector('.toevoegen_overzicht_herinnering')
        .innerHTML.substring(13)
    );
    const opdracht_datum_dag = document
      .querySelector('.toevoegen_overzicht_datum')
      .innerHTML.substring(7)
      .substr(
        0,
        document
          .querySelector('.toevoegen_overzicht_datum')
          .innerHTML.substring(7)
          .indexOf(' ')
      );
    let opdracht_datum_maand = document
      .querySelector('.toevoegen_overzicht_datum')
      .innerHTML.substring(7)
      .substr(
        0,
        document
          .querySelector('.toevoegen_overzicht_datum')
          .innerHTML.substring(7)
          .indexOf(',')
      )
      .split(' ')[1];
    const opdracht_datum_jaar = document
      .querySelector('.toevoegen_overzicht_datum')
      .innerHTML.split(', ')[1]
      .split(' - ')[0];
    const maandnummers = [
      ' ',
      'Januari',
      'Februari',
      'Maart',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Augustus',
      'September',
      'Oktober',
      'November',
      'December',
    ];
    console.log(opdracht_datum_maand);
    for (let i = 0;i < maandnummers.length;i ++) {
      if (maandnummers[i] == opdracht_datum_maand) {
        opdracht_datum_maand = i;
      }
    }
    console.log(opdracht_datum_maand);
    const opdracht_vak = document
      .querySelector('.toevoegen_overzicht_vak')
      .innerHTML.substring(5);
    const opdracht_datum =
      `${opdracht_datum_jaar
      }-${
        opdracht_datum_maand
      }-${
        opdracht_datum_dag}`;
    const opdracht_tijd = document
      .querySelector('.toevoegen_overzicht_datum')
      .innerHTML.split(', ')[1]
      .split(' - ')[1];
    const opdracht_naam = document.querySelector('.toevoegen_opdracht_naam')
      .value;
    const opdracht_omschrijving = document.querySelector(
      '.toevoegen_omschrijving'
    ).value;
    const opdracht_link = document.querySelector('.toevoegen_opdracht_link')
      .value;
    const opdracht_herinnering = document
      .querySelector('.toevoegen_overzicht_herinnering')
      .innerHTML.substring(13);

    if (opdracht_naam == '') {
      console.log('Error, geen naam');
    }
    if (opdracht_omschrijving == '') {
      console.log('Error, geen omschrijving');
    }

    const response = await fetch(`index.php?page=opdrachten`, {
      method: 'POST',
      headers: new Headers({
        'Content-Type': 'application/json',
      }),
      body: `{"action": "toevoegenOpdracht", "opdracht_vak": "${opdracht_vak}", "opdracht_datum": "${opdracht_datum}", "opdracht_tijd": "${opdracht_tijd}", "opdracht_naam": "${opdracht_naam}", "opdracht_omschrijving": "${opdracht_omschrijving}", "opdracht_herinneringen": "${opdracht_herinnering}", "opdracht_link": "${opdracht_link}"}`,
    });
    window.location.replace('index.php?page=opdrachten');
  };

  vorigeStap1NEW = e => {
    e.preventDefault();
    window.location.replace('index.php?page=opdrachten');
  };

  vorigeStap2NEW = e => {
    e.preventDefault();
    document.querySelector('.steps_circle2').classList.remove('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap2_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap1_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap1_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };
    document.querySelector('.stap2_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);
  };

  vorigeStap3NEW = e => {
    e.preventDefault();
    document.querySelector('.steps_circle3').classList.remove('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap3_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap2_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap2_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };
    document.querySelector('.stap3_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);
  };

  vorigeStap4NEW = e => {
    e.preventDefault();
    document.querySelector('.steps_circle4').classList.remove('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap4_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap3_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap3_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };
    document.querySelector('.stap4_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);
  };

  naarStap4 = e => {
    e.preventDefault();
    document.querySelector('.steps_circle4').classList.add('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap3_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap4_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap4_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };

    e.preventDefault();
    document.querySelector('.stap3_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);

    const button_stap4_vorige = document.querySelector('.button_stap4-vorige');
    button_stap4_vorige.addEventListener('click', vorigeStap4NEW);

    const button_stap4_volgende = document.querySelector(
      '.button_stap4-volgende'
    );
    button_stap4_volgende.addEventListener('click', addOpdracht);
  };

  naarStap3 = e => {
    e.preventDefault();
    document.querySelector('.steps_circle3').classList.add('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap2_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap3_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap3_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };
    const updateTextHerinnering = e => {
      textBottom = document.querySelector('.inputDate_text');
      textOverzicht = document.querySelector(
        '.toevoegen_overzicht_herinnering'
      );
      if (e.currentTarget.value == 0) {
        textBottom.innerHTML = 'Herinnering: Dag tevoren';
        textOverzicht.innerHTML = 'Herinnering: Dag tevoren';
      } else if (e.currentTarget.value == 1) {
        textBottom.innerHTML = 'Herinnering: Elke dag';
        textOverzicht.innerHTML = 'Herinnering: Elke dag';
      } else if (e.currentTarget.value == 2) {
        textBottom.innerHTML = 'Herinnering: Week tevoren';
        textOverzicht.innerHTML = 'Herinnering: Week tevoren';
      } else if (e.currentTarget.value == 3) {
        textBottom.innerHTML = 'Herinnering: Elke week';
        textOverzicht.innerHTML = 'Herinnering: Elke week';
      }
    };

    e.preventDefault();
    document.querySelector('.stap2_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);
    document.querySelector('.toevoegen_overzicht_herinnering').innerHTML =
      'Herinnering: Dag tevoren';
    document
      .querySelector('.herinnering_slider')
      .addEventListener('input', updateTextHerinnering);

    const button_stap3_vorige = document.querySelector('.button_stap3-vorige');
    button_stap3_vorige.addEventListener('click', vorigeStap3NEW);

    const button_stap3_volgende = document.querySelector(
      '.button_stap3-volgende'
    );
    button_stap3_volgende.addEventListener('click', naarStap4);
  };

  naarStap2 = e => {
    document.querySelector('.steps_circle1').classList.add('steps_active');
    document.querySelector('.steps_circle2').classList.add('steps_active');
    const hideFirst = () => {
      document.querySelector('.stap1_box').classList.add('hidden');
    };
    const showSecond = () => {
      document.querySelector('.stap2_box').classList.remove('hidden');
    };
    const startAnimationSecond = () => {
      document.querySelector('.stap2_box').style.animation =
        'animatie_groot .5s ease-in-out';
    };

    e.preventDefault();
    document.querySelector('.stap1_box').style.animation =
      'animatie_klein .5s ease-in-out';
    setTimeout(hideFirst, 500);
    setTimeout(showSecond, 499);
    setTimeout(startAnimationSecond, 500);

    const day = new Date();
    const dd = String(day.getDate()).padStart(2, '0');
    const mm = String(day.getMonth() + 1).padStart(2, '0'); //January is 0!
    const yyyy = day.getFullYear();
    const monthNames = [
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December',
    ];
    document.querySelector('.toevoegen_overzicht_datum').innerHTML =
      `Datum: ${ dd } ${ monthNames[mm - 1] }, ${ yyyy } - 23:59`;
    document.querySelector('.inputDate_text').innerHTML =
      `${dd } ${ monthNames[mm - 1] }, ${ yyyy } - 23:59`;

    const button_stap2_volgende = document.querySelector(
      '.button_stap2-volgende'
    );
    button_stap2_volgende.addEventListener('click', naarStap3);

    const button_stap2_vorige = document.querySelector('.button_stap2-vorige');
    button_stap2_vorige.addEventListener('click', vorigeStap2NEW);
  };

  radioButtonSelect = e => {
    const toevoegenRad = document.querySelectorAll('.radiobuttonSelected');
    for (let i = 0;i < toevoegenRad.length;i ++) {
      toevoegenRad[i].innerHTML = '';
    }
    e.currentTarget.children[0].innerHTML = 'Selected';

    document.querySelector(
      '.toevoegen_overzicht_vak'
    ).innerHTML = `Vak: ${e.currentTarget.children[2].innerHTML}`;
  };

  getDataLink = async () => {
    //Get API LINK van opdracht
    const input = document.querySelector('.opdrachtLink').value;
    const firstpart = input.split('courses')[0];
    const firstpartedit = `${firstpart }api/v1/courses/`;
    const secondpart = input.substring(44, 48);
    const secondpartedit =
      `${firstpartedit +
      secondpart
      }/module_item_sequence?asset_type=Assignment&asset_id=`; //api/v1/courses/xxxx/
    const thirdpart = input.substring(61, 66);
    const thirdpartedit =
      `${secondpartedit + thirdpart }&frame_external_urls=true`;
  };

  const vakForm = e => {
    e.preventDefault();
    console.log('open form');
    const vakForm = document.querySelector('.vak_toevoegen-opdracht');
    const overlay = document.querySelector('.overlay');
    vakForm.classList.add('active');
    overlay.classList.add('active');
    const buttonClose = document.querySelector('.vakX');
    buttonClose.addEventListener('click', closeVakForm);
    submitVak = document.querySelector('.opdrachttoevoegen_form');
    submitVak.addEventListener('submit', vakToevoegen);
  };

  const closeVakForm = e => {
    const vakForm = document.querySelector('.vak_toevoegen-opdracht');
    const overlay = document.querySelector('.overlay');
    vakForm.classList.remove('active');
    overlay.classList.remove('active');
  };

  const vakToevoegen = e => {
    e.preventDefault();
    console.log('vak toevoegen');
    $formVakToevoegen = e.currentTarget;
    postVak(
      $formVakToevoegen.getAttribute('action'),
      formdataToJsonVakken($formVakToevoegen)
    ); // object opmaken
  };

  const formdataToJsonVakken = $from => {
    const data = new FormData($from);
    const obj = {};
    data.forEach((value, key) => {
      console.log(`${key } : ${ value}`);
      obj[key] = value;
    });
    return obj;
  };

  const postVak = async (url, data) => {
    console.log(url);
    console.log(data);
    // versturen naar de juiste route op de server en aangeven dat we een JSON response verwachten
    // de parameter body bevat de data (in dit geval quoten auteur en id van de aflevering)
    const response = await fetch(url, {
      method: 'POST',
      headers: new Headers({
        'Content-Type': 'application/json',
      }),
      body: JSON.stringify(data),
    });
    // antwoord van PHP. Kan een error bevatten of een lijst van quotes (zie code in EpisodesController)
    const returned = await response.json();
    //console.log(returned);
    if (returned.error) {
      console.log(returned.error);
      // TODO: ook nog de boodschap vervangen die normaal door de session wordt gegeven
    } else {
      const vakken = returned;
      console.log(vakken);
      showVakken(vakken);
    }

    closeVakForm();
    init();
  };

  const showVakken = vakken => {
    console.log(vakken);
    const $allVakken = document.querySelector('.radio-toolbar');
    console.log($allVakken);
    $allVakken.innerHTML = ``;
    const $divToevoegen = document.createElement('div');
    $divToevoegen.innerHTML = `
    <div class="option_circle circle_add">
      <p class="option_plus">+</p>
    </div>
    `;
    $divToevoegen.classList.add('fullWidthHeight');
    $allVakken.appendChild($divToevoegen);
    vakken.forEach(vak => {
      const $div = document.createElement('div');
      const $input = document.createElement('input');
      $input.type = 'radio';
      $input.id = 'radioBanana';
      $input.name = 'radioFruit';
      $input.value = 'x';
      const $label = document.createElement('label');
      $label.classList.add('toevoegenRad');
      $label.for = 'radioBanana'
      $label.innerHTML = `
      <p class="radiobuttonSelected"></p>
        <div class="option_circle Tcolor_${vak.vak_kleur}">
        ${vak.vak_naam.substring(0, 3)}
        </div>
      <p class="toevoegen_text">${vak.vak_naam}</p>
      `;
      $div.appendChild($input);
      $div.appendChild($label);
      $allVakken.appendChild($div);
      $allVakken.querySelector(
        '.radiobuttonSelected'
      ).innerHTML = `Selected`;
    });
  };

  // VOLGENDE STAP
  // STAP1
  nextStap1 = e => {
    e.preventDefault();

    const buttonStap1 = document.querySelector('.button_stap1-volgende');
    const stap2 = document.querySelector('.toevoegen_stap2');
    buttonStap1.parentElement.classList.add('animate_content');
    //buttonStap1.parentElement.classList.add("stap_hidden");
    //stap2.classList.remove("stap_hidden");
  };
  // STAP2 VORIGE
  vorigeStap2 = e => {
    e.preventDefault();

    const buttonStap2Vorige = document.querySelector('.button_stap2-vorige');
    const stap1 = document.querySelector('.toevoegen_stap1');
    buttonStap2Vorige.parentElement.parentElement.classList.add('stap_hidden');
    stap1.classList.remove('stap_hidden');
  };
  // STAP2 VOLGENDE
  nextstap2 = e => {
    e.preventDefault();

    const buttonStap2Volgende = document.querySelector(
      '.button_stap2-volgende'
    );
    const stap3 = document.querySelector('.toevoegen_stap3');
    buttonStap2Volgende.parentElement.parentElement.classList.add(
      'stap_hidden'
    );
    stap3.classList.remove('stap_hidden');
  };
  // STAP3 VORIGE
  vorigeStap3 = e => {
    e.preventDefault();

    const buttonStap3Vorige = document.querySelector('.button_stap3-vorige');
    const stap2 = document.querySelector('.toevoegen_stap2');
    buttonStap3Vorige.parentElement.parentElement.classList.add('stap_hidden');
    stap2.classList.remove('stap_hidden');
  };
  // STAP3 VOLGENDE
  nextstap3 = e => {
    e.preventDefault();

    const buttonStap3Volgende = document.querySelector(
      '.button_stap3-volgende'
    );
    const stap4 = document.querySelector('.toevoegen_stap4');
    buttonStap3Volgende.parentElement.parentElement.classList.add(
      'stap_hidden'
    );
    stap4.classList.remove('stap_hidden');
  };
  // STAP4 VORIGE
  vorigeStap4 = e => {
    e.preventDefault();

    const buttonStap4Vorige = document.querySelector('.button_stap4-vorige');
    const stap3 = document.querySelector('.toevoegen_stap3');
    buttonStap4Vorige.parentElement.parentElement.classList.add('stap_hidden');
    stap3.classList.remove('stap_hidden');
  };
  // STAP4 VOLGENDE
  nextstap4 = e => {
    e.preventDefault();

    const buttonStap4Volgende = document.querySelector(
      '.button_stap4-volgende'
    );
    const stap5 = document.querySelector('.toevoegen_stap5');
    buttonStap4Volgende.parentElement.parentElement.classList.add(
      'stap_hidden'
    );
    stap5.classList.remove('stap_hidden');
  };
  // STAP5 VORIGE
  vorigeStap5 = e => {
    e.preventDefault();

    const buttonStap5Vorige = document.querySelector('.button_stap5-vorige');
    const stap4 = document.querySelector('.toevoegen_stap4');
    buttonStap5Vorige.parentElement.parentElement.classList.add('stap_hidden');
    stap4.classList.remove('stap_hidden');
  };

  init();
}
