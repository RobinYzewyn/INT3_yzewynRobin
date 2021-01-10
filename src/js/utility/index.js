
{
  const init = () => {
    let currentPage = (window.location.href).split('?')[1];
    console.log('jow' +currentPage);

    if(currentPage !== "page=registreer" && typeof currentPage !== "undefined"){
      if(currentPage !== "page=nieuwwachtwoord"){
        console.log("heyo");
        const $navigation = document.querySelector(".navigation_icon");
        $navigation.addEventListener("click", navigatorFunction);
        const $notification = document.querySelector(".notification_icon");
        $notification.addEventListener("click", notificationFunction);
        const $deskNotificationbell = document.querySelector(
          ".desktop_notificationbell"
        );
        $deskNotificationbell.addEventListener("click", notificationFunction);
      }
    }

  };

  navigatorFunction = (e) => {
    const $nav_hidden = document.querySelector(".hidden_desktop");
    if ($nav_hidden) {
      document
        .querySelector(".test_navigation")
        .classList.remove("hidden_desktop");
    } else if (!$nav_hidden) {
      document
        .querySelector(".test_navigation")
        .classList.add("hidden_desktop");
    }
  };

  notificationFunction = (e) => {
    const $noti_hidden = document.querySelector(".hidden_notification");
    if ($noti_hidden) {
      console.log('1')
      document.querySelector(".test_notification").classList.remove("hidden_notification");
    } else if (!$noti_hidden) {
      console.log('2')
      document.querySelector(".test_notification").classList.add("hidden_notification");
    }
  };

  // openNotifications = (e) => {
  //   document.querySelector(".test_notification").classList.remove("hidden");
  //   document
  //     .querySelector(".test_notification")
  //     .addEventListener("click", closeNotification);
  // };

  // closeNotification = () => {
  //   document.querySelector(".test_notification").classList.add("hidden");
  // };

  init();
}
