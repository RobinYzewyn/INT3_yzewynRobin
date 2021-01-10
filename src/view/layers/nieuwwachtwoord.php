<body>
  <div class="login_1">
    <div class="header">
      <h1 class="titel">Nieuw wachtwoord</h1>
    </div>
    <div class="body">
      <img class="logo" src="./assets/img/logo_masked.svg" alt="Logo" width="126" height="126">
      <h2 class="h2_desktop">Wachtwoord vergeten?</h2>
      <form class="inloggen_form" method="post" action="index.php?page=nieuwwachtwoord">
        <?php if(!empty($_SESSION['send'])):?><div class="file_selected send"><?php echo $_SESSION['send'];?></div><?php endif;?>
        <?php if(!empty($_SESSION['error'])):?><div class="error_register"><?php echo $_SESSION['error'];?></div><?php endif;?>
        <input type="hidden" name="action" value="new-password">
        <div class="field">
          <input type="email" name="mail" id="mail" placeholder="alexander.verdickt@student.howest.be"">
        <label class=" label" for="mail">E-mailadres</label>
        </div>
        <!-- <input class="input" type="email" name="email" id="email" placeholder="E-mailadres"><br> -->
        <input type="submit" class="button form__button" value="Vraag nieuw wachtwoord aan">
      </form>
    </div>
    <div class="registreer">
      <a class="button a__button desktop_hide" href="index.php?page=index">Aanmelden</a>
    </div>
  </div>
  <div class="desktop">
    <h2 class="h2_desktop-right">Welkom terug!</h2>
    <p class="desktop_text">Log in met uw persoonlijke gegevens om in uw planner te gaan</p>
    <a class="button desktop_button a__button" href="index.php?page=index">Aanmelden</a>
  </div>
</body>
