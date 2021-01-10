<body>
  <div class="desktop">
    <h2 class="h2_desktop-right">Hallo, student!</h2>
    <p class="desktop_text">Vul jouw persoonlijke gegevens in en start met het gebruiken van onze schoolplanner</p>
    <a class="button desktop_button a__button" href="index.php?page=index">Aanmelden</a>
  </div>
  <div class="login_1">
    <div class="header">
      <h1 class="titel">Registreer</h1>
    </div>
    <div class="body">
      <img class="logo" src="./assets/img/logo_masked.svg" alt="Logo" width="126" height="126">
      <h2 class="h2_desktop">Registreer</h2>
      <form class="inloggen_form" method="post">
        <?php if (!empty($errors)) : ?><div class="error_register"><?php echo $errors; ?></div><?php endif; ?>
        <input class="action" type="hidden" name="action" value="create_account">
        <div class="input_div">
          <div class="field">
            <input class="check_username input_error input_username" required type="text" name="username" id="gebruikersnaam" placeholder="Alexander Verdickt">
            <label class="label" class="label" for="gebruikersnaam">Gebruikersnaam<span class="error"><?php if (!empty($errors['text'])) {echo $errors["text"];} ?></span></label>
          </div>
          <img class="check_icon check_name_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_name_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <!-- <input type="text" name="gebruikersnaam" id="gebruikersnaam" placeholder="Gebruikersnaam"><br> -->
        <div class="input_div">
          <div class="field">
            <input class="check_email input_error" required type="email" name="email" id="email" placeholder="alexander.verdickt@student.howest.be"">
            <label class=" label" for="email">E-mailadres<span class="error"><?php if (!empty($errors['text'])) {echo $errors["text"];} ?></span></label>
          </div>
          <img class="check_icon check_email_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_email_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <div class="input_div">
          <div class="field">
            <input class="check_password input_error" type="password" required name="password" id="wachtwoord" placeholder="Wachtwoord">
            <label class="label" for="wachtwoord">Wachtwoord<span class="error"><?php if (!empty($errors['text'])) {echo $errors["text"];} ?></span></label>
          </div>
          <img class="check_icon check_password_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_password_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <div class="input_div">
          <div class="field">
            <input class="check_passwordrepeat input_error" type="password" required name="repeat_password" id="wachtwoord_herhaal" placeholder="Wachtwoord">
            <label class="label" for="wachtwoord_herhaal">Herhaal wachtwoord<span class="error"><?php if (!empty($errors['text'])) {echo $errors["text"];} ?></span></label>
          </div>
          <img class="check_icon check_passwordrepeat_correct icon_detail_changes hidden" src="assets/img/check_correct.svg">
          <img class="check_icon check_passwordrepeat_wrong icon_detail_changes hidden" src="assets/img/check_wrong.svg">
        </div>
        <!-- <input type="password" name="wachtwoord__herhaal" id="wachtwoord__herhaal" placeholder="Herhaal wachtwoord"><br> -->
        <input type="submit" class="button form__button" value="Registreer">
      </form>
    </div>
  </div>
</body>
