{
  let currentPage = '';
  const init = () =>{
    currentPage = (window.location.href).split('?')[1];
    if(currentPage == "page=profiel" || currentPage == "page=opdrachten" || currentPage == "page=opdrachttoevoegen" || currentPage == "page=vaktoevoegen" || currentPage == "page=schoolagenda" || currentPage == "page=schoolagendaToevoegen"){
    const test_notification_cross = Array.from(document.querySelectorAll('.test_notification_cross'));
    for (let i = 0; i < test_notification_cross.length; i++) {
      test_notification_cross[i].addEventListener('click', closeNotification);
    }

    const refresh_notification = document.querySelector('.refresh_notification');
    refresh_notification.addEventListener('click', refreshNotification);

    currentPage = (window.location.href).split('?')[1];
    console.log('yowwww:' + currentPage);
  }
  }

  refreshNotification = async () =>{
     const response = await fetch(`index.php?${currentPage}`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
      }),
      body: `{"action": "refreshNotification"}`,
    });

    const returned = await response.json();
    console.log(returned);
    newNotificationList(returned);

  }

  closeNotification = async (e) =>{
    console.log('Sluit notificatie');
    console.log(e.currentTarget);
    const id = e.currentTarget.id;
    console.log('page:' + currentPage);
    const response = await fetch(`index.php?${currentPage}`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
      }),
      body: `{"action": "removeNotification", "notificationId": "${id}"}`,
    });

    const returned = await response.json();
    console.log(returned);
    newNotificationList(returned);

  }

  newNotificationList = (items) =>{
    console.log('update list');
    console.log(items);
    const list = document.querySelector('.test_notification_list');
    list.innerHTML = '';
    for (let i = 0; i < items.length; i++) {
      list.innerHTML += `
       <div class="test_notification_list_item">
        <div class="notification_content">
          <div class="test_notification_date">
            <p class="test_notification_day">${items[i]['Dag']}</p>
            <p class="test_notification_month">${items[i]['Maand']}</p>
          </div>
          <div class="test_notification_content">
            <p class="test_notification_contenttitle">${items[i]['opdracht_vak']}</p>
            <p class="test_notification_contenttask">${items[i]['opdracht_naam']}(${items[i]['opdracht_tijd']})</p>
          </div>
        </div>
        <p id="${items[i]['id']}" class="test_notification_cross">✕</p>
      </div>
      `
    }
    console.log(items.length);
    if (items.length == 0) {
      document.querySelector(".desktop_notificationbell").src = "assets/img/notification.svg";
      document.querySelector(".notification_icon").src = "assets/img/notification.svg"
    }
    document.querySelector('.test_notification_remove').innerHTML = items.length + ' Meldingen';
    init();
  }
  init();
}
