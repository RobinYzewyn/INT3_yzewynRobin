<div class="body_opdrachten_desktop">
  <div class="header">
    <img src="assets/img/navigation.svg" class="navigation_item navigation_icon">
    <h1 class="title">Mijn vakken</h1>
    <?php if (!empty($notificatieOpdrachten)) : ?>
      <img src="assets/img/notification_melding.svg" class="navigation_item notification_icon">
    <?php else : ?>
      <img src="assets/img/notification.svg" class="navigation_item notification_icon">
    <?php endif; ?>
  </div>
  <div class="header_desktop">
    <a href="index.php?page=opdrachten"><img class="navigation_item" src="./assets/img/logo_masked_desktop.svg" alt="Logo" width="126" height="126"></a>
    <h1 class="title">Mijn vakken</h1>
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
        <li class="test_navigation_list_item">
          <picture>
            <source media="(max-width: 850px)" srcset="./assets/img/opdrachten.svg">
            <img class="test_navigation_icon" src="assets/img/opdrachten_black.svg">
          </picture>
          Opdrachten
        </li>
      </a>
      <a class="navigation_a" href="index.php?page=vaktoevoegen">
        <li class="test_navigation_list_item nav_active">
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
  <div class="content vak_toveogen_content">
    <form method="POST" action="index.php?page=vaktoevoegen" class="opdrachttoevoegen_form form_toevoegen" enctype="multipart/form-data">
      <input type="hidden" name="action" value="toevoegenVak">
      <div class="input_div">
        <div class="field">
          <input class="input_error" type="text" required name="naamvak" id="naamvak" placeholder="Naam van vak">
          <label class="label" for="naamvak">Naam van vak<span class="error"><?php if (!empty($errors['text'])) {
                                                                                echo $errors["text"];
                                                                              } ?></span></label>
        </div>
      </div>
      <div>
        <div class="field">
          <input class="input_error" type="text" required name="naamdocent" id="naamdocent" placeholder="Naam van docent">
          <label class="label" for="naamdocent">Naam van docent<span class="error"><?php if (!empty($errors['text'])) {
                                                                                      echo $errors["text"];
                                                                                    } ?></span></label>
        </div>
      </div>
      <div class="vak_field">
        <label class="vak_label">Kleur</label>
        <div class="vak_kleuren">
          <div class="vak_kleur vak_rood">
            <input class="input_color" type="radio" checked id="rood" name="kleur" value="BD6360">
            <label for="rood"></label>
          </div>
          <div class="vak_kleur vak_oranje">
            <input class="input_color" type="radio" id="oranje" name="kleur" value="D7B088">
            <label for="oranje"></label>
          </div>
          <div class="vak_kleur vak_geel">
            <input class="input_color" type="radio" id="geel" name="kleur" value="D2C669">
            <label for="geel"></label>
          </div>
          <div class="vak_kleur vak_lichtgroen">
            <input class="input_color" type="radio" id="lichtgroen" name="kleur" value="A6B669">
            <label for="lichtgroen"></label>
          </div>
          <div class="vak_kleur vak_groen">
            <input class="input_color" type="radio" id="groen" name="kleur" value="74A16B">
            <label for="groen"></label>
          </div>
          <div class="vak_kleur vak_cyan">
            <input class="input_color" type="radio" id="cyan" name="kleur" value="699B8E">
            <label for="cyan"></label>
          </div>
          <div class="vak_kleur vak_blauw">
            <input class="input_color" type="radio" id="blauw" name="kleur" value="5D70A6">
            <label for="blauw"></label>
          </div>
          <div class="vak_kleur vak_paars">
            <input class="input_color" type="radio" id="paars" name="kleur" value="866A99">
            <label for="paars"></label>
          </div>
          <div class="vak_kleur vak_violet">
            <input class="input_color" type="radio" id="violet" name="kleur" value="8E478C">
            <label for="violet"></label>
          </div>
          <div class="vak_kleur vak_grijs">
            <input class="input_color" type="radio" id="grijs" name="kleur" value="A4A4A4">
            <label for="grijs"></label>
          </div>
        </div>
      </div>
      <input class="submit toevoegen_submit" type="submit" value="Vak toevoegen">
    </form>
    <form method="POST" action="index.php?page=opdrachten" class="opdrachttoevoegen_form hidden form_update" enctype="multipart/form-data">
      <input type="hidden" name="action" value="updateVak">
      <div class="input_div">
        <div class="field">
          <input class="input_error newVak_naam" type="text" required name="naamvak2" id="naamvak2" placeholder="Naam van vak">
          <label class="label" for="naamvak2">Naam van vak<span class="error"><?php if (!empty($errors['text'])) {
                                                                                echo $errors["text"];
                                                                              } ?></span></label>
        </div>
      </div>
      <div>
        <div class="field">
          <input class="input_error newVak_docent" type="text" required name="naamdocent2" id="naamdocent2" placeholder="Naam van docent">
          <label class="label" for="naamdocent2">Naam van docent<span class="error"><?php if (!empty($errors['text'])) {
                                                                                      echo $errors["text"];
                                                                                    } ?></span></label>
        </div>
      </div>
      <div class="vak_field">
        <label class="vak_label">Kleur</label>
        <div class="vak_kleuren">
          <div class="vak_kleur vak_rood">
            <input class="input_color" type="radio" checked id="rood2" name="kleur2" value="BD6360">
            <label for="rood"></label>
          </div>
          <div class="vak_kleur vak_oranje">
            <input class="input_color" type="radio" id="oranje2" name="kleur2" value="D7B088">
            <label for="oranje"></label>
          </div>
          <div class="vak_kleur vak_geel">
            <input class="input_color" type="radio" id="geel2" name="kleur2" value="D2C669">
            <label for="geel"></label>
          </div>
          <div class="vak_kleur vak_lichtgroen">
            <input class="input_color" type="radio" id="lichtgroen2" name="kleur2" value="A6B669">
            <label for="lichtgroen"></label>
          </div>
          <div class="vak_kleur vak_groen">
            <input class="input_color" type="radio" id="groen2" name="kleur2" value="74A16B">
            <label for="groen"></label>
          </div>
          <div class="vak_kleur vak_cyan">
            <input class="input_color" type="radio" id="cyan2" name="kleur2" value="699B8E">
            <label for="cyan"></label>
          </div>
          <div class="vak_kleur vak_blauw">
            <input class="input_color" type="radio" id="blauw2" name="kleur2" value="5D70A6">
            <label for="blauw"></label>
          </div>
          <div class="vak_kleur vak_paars">
            <input class="input_color" type="radio" id="paars2" name="kleur2" value="866A99">
            <label for="paars"></label>
          </div>
          <div class="vak_kleur vak_violet">
            <input class="input_color" type="radio" id="violet2" name="kleur2" value="8E478C">
            <label for="violet"></label>
          </div>
          <div class="vak_kleur vak_grijs">
            <input class="input_color" type="radio" id="grijs2" name="kleur2" value="A4A4A4">
            <label for="grijs"></label>
          </div>
        </div>
      </div>
      <div class="row">
        <button class="submit toevoegen_submit update_submit">Vak bijwerken</button>
        <button class="button form__button button_vaktoevoegen button_vorige button_annuleren">Annuleren</button>
      </div>
    </form>
    <div class="mijnvakken toevoegen_box stap1_box">
      <div class="toevoegen_box_top">
        <p class="toevoegen_title">Mijn vakken</p>
        <p><?php echo count($vakken); ?> vakken</p>
      </div>

      <div class="toevoegen_box_bottom">
        <div class="radio-toolbar">
          <?php foreach ($vakken as $index => $vak) : ?>
            <div>
              <input class="vak_radio" type="radio" id="<?php echo $vak['id']; ?>" name="<?php echo $vak['vak_naam']; ?>" value="x">
              <label class="toevoegenRad" for="radioBanana<?php echo $vak['vak_naam']; ?>">
                <div class="option_circle Tcolor_<?php echo $vak['vak_kleur']; ?>">
                  <?php echo substr($vak['vak_naam'], 0, 3); ?>
                </div>
                <p class="toevoegen_text" id="<?php echo $vak['vak_docent']; ?>"><?php echo $vak['vak_naam']; ?></p>
                <div class="hidden">
                  <p class="vak_edit"><img class="icon_detail_changes" id="<?php echo $vak['id']; ?>" name="<?php echo $vak["vak_naam"]; ?>" src="./assets/img/update.svg"></p>
                  <p class="vak_remove"><img class="icon_detail_changes" src="./assets/img/delete.svg"></p>
                </div>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
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
        <form method="post" action="index.php?page=vaktoevoegen">
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