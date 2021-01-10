<div class="body_opdrachten_desktop">
  <div class="header">
    <img src="assets/img/navigation.svg" class="navigation_item navigation_icon">
    <h1 class="title">Opdracht detail</h1>
    <?php if (!empty($notificatieOpdrachten)) : ?>
      <img src="assets/img/notification_melding.svg" class="navigation_item notification_icon">
    <?php else : ?>
      <img src="assets/img/notification.svg" class="navigation_item notification_icon">
    <?php endif; ?>
  </div>
  <div class="header_desktop">
    <a href="index.php?page=opdrachten"><img class="navigation_item" src="./assets/img/logo_masked_desktop.svg" alt="Logo" width="126" height="126"></a>
    <h1 class="title">Opdracht detail</h1>
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
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/user.svg">
            <img class="test_navigation_icon" src="assets/img/profile_black.svg">
          </picture>
          Profiel
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=opdrachten">
        <li class="test_navigation_list_item nav_active">
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
      <p class="test_notification_remove">Verwijder alles</p>
    </div>
    <div class="test_notification_list">
      <div class="test_notification_list_item">
        <div class="test_notification_date">
          <p class="test_notification_day">2</p>
          <p class="test_notification_month">Nov</p>
        </div>
        <div class="test_notification_content">
          <p class="test_notification_contenttitle">Development</p>
          <p class="test_notification_contenttask">Taak: Plan-it opdracht (08:00)</p>
        </div>
        <p class="test_notification_cross">✕</p>
      </div>
      <div class="test_notification_list_item">
        <div class="test_notification_date">
          <p class="test_notification_day">2</p>
          <p class="test_notification_month">Nov</p>
        </div>
        <div class="test_notification_content">
          <p class="test_notification_contenttitle">Development</p>
          <p class="test_notification_contenttask">Taak: Plan-it opdracht (08:00)</p>
        </div>
        <p class="test_notification_cross">✕</p>
      </div>
    </div>
  </div>
  <div class="content opdracht_detail_desktop">
    <div class="content opdrachten_opdracht">
      <a class="add_button" href="index.php?page=opdrachttoevoegen">Opdracht toevoegen</a>
      <div class="no_task hidden">
        <p>Nog geen opdrachten</p>
        <img class="NoTaskIMG" src="notask.png" alt="no task">
      </div>
      <?php foreach ($opdrachten as $opdracht) : ?>
        <a href="index.php?page=opdracht&id=<?php echo $opdracht['id']; ?>" class="task">
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
    <div class="task_detail opdracht_desktop <?php echo 'task_detail_' . $opdracht['vak_kleur']; ?> detail_opdracht_all">
      <div class="detail_bottom">
        <p class="detail_lesson <?php echo 'detail_' . $opdracht['vak_kleur']; ?>"><?php echo $specificOpdracht['opdracht_vak']; ?></p>
      </div>
      <p class="detail_title"><?php echo $specificOpdracht['opdracht_naam']; ?></p>
      <p class="detail_date"><?php echo $specificOpdracht['opdracht_datum'] . '  -  ' . $specificOpdracht['opdracht_tijd']; ?></p>
      <p class="detail_description"><?php echo $specificOpdracht['opdracht_omschrijving']; ?></p>
      <div class="detail_bottom">
        <a class="detail_link" href="<?php echo $specificOpdracht['opdracht_link']; ?>">Link opdracht</a>
        <div class="detail_action">
          <p class="detail_edit">v</p>
          <a class="x_delete detail_remove" href="index.php?page=opdracht&id=<?php echo $specificOpdracht['id']; ?>&action=deleteOpdracht&opdracht_id=<?php echo $specificOpdracht['id']; ?>">x</a>
        </div>
      </div>
    </div>
    <!-- form -->
    <div class="hidden task_detail opdracht_desktop <?php echo 'task_detail_' . $opdrachtKleur['vak_kleur']; ?> detail_opdracht_form">
      <form method="POST" action="index.php?page=opdracht&id=<?php echo $specificOpdracht['id']; ?>">
        <input type="hidden" name="action" value="opdrachtUpdate">
        <fieldset>
          <label class="label" class="toevoegen_label">Vak</label>
          <select class="toevoegen_ddl" name="opdracht_vak" id="myList">
            <?php foreach ($vakken as $vak) : ?>
              <option><?php echo $vak['vak_naam']; ?></option>
            <?php endforeach; ?>
          </select>
        </fieldset>
        <div class="toevoegen_datum-tijd">
          <input type="date" id="datum" value="<?php echo $specificOpdracht['opdracht_datum']; ?>" name="opdracht_datum"><br>
          <input type="time" value="<?php echo $specificOpdracht['opdracht_tijd']; ?>" name="opdracht_tijd" id="tijd">
        </div>
        <div class="field">
          <input type="text" value="<?php echo $specificOpdracht['opdracht_naam']; ?>" name="opdracht_naam" id="opdracht_naam" placeholder="Titel">
          <label class="label" for="opdracht_naam">Naam opdracht</label>
        </div>
        <div class="field">
          <textarea rows="4" class="toevoegen_omschrijving" type="text" name="opdracht_omschrijving" id="opdracht_omschrijving" placeholder="Omschrijving"><?php echo $specificOpdracht['opdracht_omschrijving']; ?></textarea>
          <label class="label" for="opdracht_omschrijving">Omschrijving opdracht</label>
        </div>
        <div class="field">
          <input type="text" value="<?php echo $specificOpdracht['opdracht_link']; ?>" name="opdracht_link" id="opdracht_link" placeholder="Link opdracht">
          <label class="label" for="opdracht_link">Link opdracht</label>
        </div>
        <fieldset class="toevoegen_herinnering">
          <label class="label" class="toevoegen_label">Herinnering</label>
          <select class="toevoegen_ddl" name="opdracht_herinneringen" id="myList">
            <option value="Elke dag">Elke dag</option>
            <option value="Elke week">Elke week</option>
            <option value="Elke maand">Elke maand</option>
          </select>
        </fieldset>
        <div>
          <input class="button form__button volgende" type="submit" value="Aanpassen">
        </div>
      </form>
    </div>
  </div>
  <div class="kalender_prikbord_desktop">
    <div class="kalender">
      <div id="caleandar">
      </div>
      <!-- <script type="text/javascript" src="js/utility/kalender.js"></script>
      <script type="text/javascript" src="js/utility/demo.js"></script> -->
    </div>
    <div class="prikbord">
      <p class="title_prikbord">Prikbord</p>
      <div>
        <form method="post" action="index.php?page=opdracht&id=<?php echo $specificOpdracht['id']; ?>">
          <input type="hidden" name="action" value="toevoegenPrikbordItem" />
          <div class="field">
            <label class="label">Zet iets op je prikbord
              <input class="input_prikbord" type="text" name="prikbord_tekst" required>
            </label>
          </div>
          <div>
            <input class="button form__button" type="submit" name="button" value="Add Todo">
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