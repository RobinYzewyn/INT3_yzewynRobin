<body>
  <div class="login_1">
    <div class="header">
      <h2 class="titel">Inloggen</h2>
    </div>
    <div class="body">
      <img class="logo" src="./assets/img/logo_masked.svg" alt="Logo" width="126" height="126">
      <h2 class="h2_desktop">Inloggen</h2>
      <?php if(!empty($_SESSION['info'])){echo $_SESSION['info'];}?>
      <form class="inloggen_form" method="post">
        <?php if (!empty($errors)) : ?><div class="error_register"><?php echo $errors; ?></div><?php endif; ?>
        <input type="hidden" name="action" value="login_account">
        <div class="input_div">
          <div class="field">
            <input class="text input_error" type="text" required name="username" id="gebruikersnaam" placeholder="Gebruikersnaam">
            <label class="label" for="gebruikersnaam">Gebruikersnaam<span class="error"><?php if (!empty($errors['text'])) {
                                                                                          echo $errors["text"];
                                                                                        } ?></span></label>
          </div>
        </div>
        <div class="input_div">
          <div class="field">
            <input class="input_error" type="password" required name="password" id="wachtwoord" placeholder="Wachtwoord">
            <label class="label" for="wachtwoord">Wachtwoord<span class="error"><?php if (!empty($errors['text'])) {
                                                                                  echo $errors["text"];
                                                                                } ?></span></label>
          </div>
        </div>
        <a class="text vergeten" href="index.php?page=nieuwwachtwoord">Wachtwoord vergeten?</a><br>
        <input type="submit" class="button form__button" value="Aanmelden">
      </form>
    </div>
    <div class="registreer">
      <a class="button a__button desktop_hide" href="index.php?page=registreer">Registreer</a>
    </div>
  </div>
  <div class="desktop">
    <h2 class="h2_desktop-right">Welkom terug!</h2>
    <p class="desktop_text">Log in met uw persoonlijke gegevens om in uw planner te gaan</p>
    <a class="button desktop_button a__button" href="index.php?page=registreer">Registreer</a>
  </div>
</body>