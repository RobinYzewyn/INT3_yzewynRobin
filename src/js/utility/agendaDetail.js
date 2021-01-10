{
  const init = () => {
    let currentPage = (window.location.href).split('?')[1];
    if(currentPage === "page=schoolagenda" && typeof currentPage !== "undefined"){
    // const dag_link = Array.from(document.querySelectorAll('.dag_taak'));
    const dag_link = Array.from(document.querySelectorAll(".dag_link"));
    for (let i = 0; i < dag_link.length; i++) {
      dag_link[i].addEventListener("click", getDetail);
    }
  }
  };
  let lokaal = "";
  getDetail = async (e) => {
    e.preventDefault();
    
    // url = `index.php?page=choolagendaDetail&id=${id}`
    // console.log(e.currentTarget.id);
    let id = e.currentTarget.id;
    lokaal = e.currentTarget.name;
    const response = await fetch(`index.php?page=schoolagenda&id=${id}`, {
      method: "GET",
      headers: new Headers({
        "Content-Type": "application/json",
        Accept: "application/json",
      }),
    });
    returned = await response.json();
    showDetail(returned);
    const close_detailS = document.querySelector(".close_detailS");
    close_detailS.addEventListener("click", closeDetailS);
  };

  showDetail = (data) => {
    console.log(data);
    for (let i = 0; i < data[1].length; i++) {
      console.log(data[1][i]["opdracht_vak"]);
    }
    if (lokaal == null) {
      lokaal = "Thuis";
    }
    schoolagenda_div = document.querySelector(".schoolagenda_div");
    schoolagenda_div.classList.add("schoolagenda_detail_desktop");
    const opdracht_desktop = document.querySelector(".opdracht_desktop");
    opdracht_desktop.classList.remove('hidden');

    // check if opdracht
    $divOpdracht = ``;
    for (let i = 0; i < data[1].length; i++) {
      if (
        data[0]["Datum"] == data[1][i]["opdracht_datum"] &&
        data[0]["Les"].split('"')[1].split(" -")[0] ==
          data[1][i]["opdracht_vak"]
      ) {
        $divOpdracht = `
        <div>
          <p class="dag_box-padding dag_taak"></p>
          <p class="taak_text">Opdracht</p>
        </div>
        `;
      } else {
        // $divOpdracht = ``;
      }
    }

    // check if online
    $divOnline = ``;
    if (data[0]["Type"] == "les online") {
      $divOnline = `
        <div>
          <p class="dag_box-padding dag_online"></p>
          <p class="online_text">Online les</p>
        </div>
        `;
    } else {
      // $divOnline = ``;
    }

    // lokaal/online
    if (data[0]["Type"] == "les online") {
      $pOnline = `
        <p class="detail_location-location">Les online</p>
        `;
      $pOffline = ``;
    } else {
      $pOnline = ``;
      $pOffline = `
      <p class="detail_location-location">${data[0]["Lokaal"]}</p>
      `;
    }

    // if opdracht post
    $divOpdrachtPost = ``;
    for (let i = 0; i < data[1].length; i++) {
      if (
        data[0]["Datum"] == data[1][i]["opdracht_datum"] &&
        data[0]["Les"].split('"')[1].split(" -")[0] ==
          data[1][i]["opdracht_vak"]
      ) {
        $divOpdrachtPost = `
          <div class="schoolagenda_box task_detail_${data[1][i]["vak_kleur"]}">
            <a class="opdracht_link" href="index.php?page=opdrachten">
              <p class="detail_title">${data[1][i]["opdracht_naam"]}</p>
            </a>
            <p class="detail_date">${data[1][i]["opdracht_datum"]} - ${data[1][i]["opdracht_tijd"]}</p>
          </div>
          `;
      } else {
        // $divOpdrachtPost = ``;
      }
    }

    opdracht_desktop.innerHTML = `
          <div class="schoolagenda_detail">
            <div class="schoolagenda_box box schoolagenda_vak">
              <div class="schoolagenda_details">
                <p class="close_detailS detail_aegenda-close">Close</p>
                <p class="detail_lesson">${data[0]["Les"].split('"')[1]}</p>
                <p class="detail_date">${data[0]["Datum"]} - ${
      data[0]["Begintijd"]
    }-${data[0]["Eindtijd"]}</p>
              </div>
              <div class="dag_box schoolagenda_color-box">
                ${$divOpdracht}
                ${$divOnline}
              </div>
            </div>
            <div class="schoolagenda_box box">
              <!-- is statement <?php if ($item['Type'] == 'les online') : ?> -->
              <p class="detail_location">Locatie:</p>
              ${$pOnline}
              ${$pOffline}
            </div>
          </div>
          ${$divOpdrachtPost}
    `;
  };

  closeDetailS = () => {
    const detailOpdracht = document.querySelector(".js_detail");
    console.log(detailOpdracht);
    detailOpdracht.classList.add("hidden");
    detailOpdracht.classList.remove("content");
    schoolagenda_div.classList.remove("schoolagenda_detail_desktop");
    document.querySelector(".schoolagenda_desktop").classList.remove("overflow");
  };

  init();
}
