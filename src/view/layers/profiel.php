<div class="body_opdrachten_desktop">
  <div class="header">
    <img src="assets/img/navigation.svg" class="navigation_item navigation_icon">
    <h1 class="title">Profiel</h1>
    <?php if (!empty($notificatieOpdrachten)) : ?>
      <img src="assets/img/notification_melding.svg" class="navigation_item notification_icon">
    <?php else : ?>
      <img src="assets/img/notification.svg" class="navigation_item notification_icon">
    <?php endif; ?>
  </div>
  <div class="header_desktop">
    <a href="index.php?page=opdrachten"><img class="navigation_item" src="./assets/img/logo_masked_desktop.svg" alt="Logo" width="126" height="126"></a>
    <h1 class="title">Profiel</h1>
    <?php if (!empty($notificatieOpdrachten)) : ?>
      <img src="assets/img/notification_melding.svg" class="navigation_item desktop_notificationbell">
    <?php else : ?>
      <img src="assets/img/notification.svg" class="navigation_item desktop_notificationbell">
    <?php endif; ?>
  </div>
  <div class="test_navigation navigation_desktop hidden_desktop">
    <div class="test_navigation_top">
      <img class="test_avatar" src="assets/img/head.svg">
      <div>
        <p><?php echo $_SESSION['user']['username']; ?></p>
        <p class="test_navigation_class">Devine 2020-2021</p>
      </div>
    </div>
    <ul class="test_navigation_list">
      <a class="navigation_a" href="index.php?page=profiel">
        <li class="test_navigation_list_item nav_active">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/user.svg">
            <img class="test_navigation_icon" src="assets/img/profile_black.svg">
          </picture>
          Profiel
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=opdrachten">
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/opdrachten.svg">
            <img class="test_navigation_icon" src="assets/img/opdrachten_black.svg">
          </picture>
          Opdrachten
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=vaktoevoegen">
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/toevoegen.svg">
            <img class="test_navigation_icon" src="assets/img/vaktoevoegen_black.svg">
          </picture>
          Mijn vakken
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=schoolagenda">
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/schoolagenda.svg">
            <img class="test_navigation_icon" src="assets/img/schoolagenda_black.svg">
          </picture>
          Schoolagenda
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=schoolagendaToevoegen">
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/import.svg">
            <img class="test_navigation_icon" src="assets/img/schoolagenda_importeren_black.svg">
          </picture>
          Schoolagenda importeren
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=logout">
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/uitloggen.svg">
            <img class="test_navigation_icon" src="assets/img/uitloggen_black.svg">
          </picture>
          Uitloggen
        </li>
      </a>
    </ul>
  </div>
  <div class="test_notification hidden_notification">
    <div class="test_notification_top">
      <p class="test_notification_title">Notificaties</p>
      <div class="row">
        <p class="test_notification_remove"><?php echo count($_SESSION['notifyTasks']); ?> Meldingen</p>
        <img class="refresh_notification" src="assets/img/refresh.svg">
      </div>

    </div>
    <div class="test_notification_list">
      <?php foreach ($notificatieOpdrachten as $notification) : ?>
        <div class="test_notification_list_item">
          <div class="notification_content">
            <div class="test_notification_date">
              <p class="test_notification_day"><?php echo $notification['Dag']; ?></p>
              <p class="test_notification_month"><?php echo $notification['Maand']; ?></p>
            </div>
            <div class="test_notification_content">
              <p class="test_notification_contenttitle"><?php echo $notification['opdracht_vak']; ?></p>
              <p class="test_notification_contenttask"><?php echo $notification['opdracht_naam']; ?>(<?php echo $notification['opdracht_tijd']; ?>)</p>
            </div>
          </div>
          <p id="<?php echo $notification['id']; ?>" class="test_notification_cross">✕</p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="body">
    <div class="profiel_gegevens">
      <p class="profiel_title">Persoonlijke gegevens</p>
      <form method="POST" class="inloggen_form" action="index.php?page=profiel">
        <?php if (!empty($_SESSION['succes'])) : ?>
          <div class="file_selected"><?php echo $_SESSION['succes'];?> ✔</div>
          <?php unset($_SESSION['succes']);?>
        <?php endif; ?>
        <input type="hidden" name="action" value="updateProfiel">
        <div class="input_div">
          <div class="field">
            <input class="profiel_newname input_error" required type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Alexander Verdickt" value="<?php echo $_SESSION['user']['username']; ?>">
            <label class="label" for="gebruikersnaam">Gebruikersnaam<span class="error"><?php if (!empty($errors['text'])) {
                                                                                          echo $errors["text"];
                                                                                        } ?></span></label>
          </div>
          <img class="check_icon check_username_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_username_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <div class="input_div">
          <div class="field">
            <input class="profiel_newemail input_error" required type="text" name="email" id="email" placeholder="alexander.verdickt@student.howest.be" value="<?php echo $_SESSION['user']['email']; ?>">
            <label class="label" for="email">E-mailadres<span class="error"><?php if (!empty($errors['text'])) {
                                                                              echo $errors["text"];
                                                                            } ?></span></label>
          </div>
          <img class="check_icon check_email_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_email_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <div class="input_div oldpassword hidden">
          <div class="field">
            <input class="inputoldpass input_error" required type="password" name="wachtwoord" id="wachtwoord" placeholder="******" value="<?php echo "******"; ?>">
            <label class="label" for="wachtwoord">Oud wachtwoord<span class="error"><?php if (!empty($errors['text'])) {
                                                                                      echo $errors["text"];
                                                                                    } ?></span></label>
          </div>
        </div>
        <div class="input_div newpassword">
          <div class="field">
            <input class="inputnewpass input_error" required type="password" name="wachtwoord" id="wachtwoord" placeholder="******" value="<?php echo "******"; ?>">
            <label class="label newpasswordlabel" for="wachtwoord">Wachtwoord<span class="error"><?php if (!empty($errors['text'])) {
                                                                                                    echo $errors["text"];
                                                                                                  } ?></span></label>
          </div>
        </div>

        <!-- <input type="text" placeholder="Alexander Verdickt">
        <input type="text" placeholder="alexander.verdickt@student.howest.be">
        <input type="password" placeholder="******"> -->
        <input class="button form__button" type="submit" value="Wijzigen">
      </form>
    </div>
  </div>
  <div class="kalender_prikbord_desktop">
    <div class="kalender">
      <div id="caleandar">
        <?php foreach ($opdrachten as $opdracht) : ?>
          <a href="index.php?page=opdracht&id=<?php echo $opdracht['id']; ?>" class="task hidden">
            <div class=" task_tag <?php echo 'color_' . $opdracht['vak_kleur']; ?>">
              <p><?php echo substr($opdracht['opdracht_vak'], 0, 3); ?></p>
            </div>
            <div class="task_text">
              <p class="task_title"><?php echo $opdracht['opdracht_naam']; ?></p>
              <p class="task_lesson"><?php echo $opdracht['opdracht_vak']; ?></p>
              <p class="task_date"><?php echo $opdracht['opdracht_datum'] . '  -  ' . $opdracht['opdracht_tijd']; ?></p>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <!-- <script type="text/javascript" src="js/utility/kalender.js"></script>
      <script type="text/javascript" src="js/utility/demo.js"></script> -->
    </div>
    <div class="prikbord">
      <p class="title_prikbord">Prikbord</p>
      <div>
        <form class="profileform" method="post" action="index.php?page=profiel">
          <input type="hidden" name="action" value="toevoegenPrikbordItem" />
          <div class="field">
            <label class="label">Zet iets op je prikbord
              <input class="input_prikbord" type="text" name="prikbord_tekst" required>
            </label>
          </div>
          <div>
            <input class="button form__button" type="submit" name="button" value="Voeg toe">
          </div>
        </form>
        <div>
          <ul class="prikbord_ul">
            <?php foreach ($prikbordItems as $prikbordItem) : ?>
              <li class="prikbord_list">
                <p class="item_prikbord">&#8901 <?php echo $prikbordItem['prikbord_tekst']; ?></p>
                <a class="x_delete" href="index.php?page=<?php echo $_GET['page'];?>&action=deleteItem&prikbord_id=<?php echo $prikbordItem['id']; ?>">x</a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>