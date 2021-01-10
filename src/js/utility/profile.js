{
  const init = () => {
    let currentPage = (window.location.href).split('?')[1];
    if(currentPage === "page=profiel" && typeof currentPage !== "undefined"){
    console.log('profile init');
    const newpassword = document.querySelector(".newpassword");
    newpassword.addEventListener("click", showOldPass);

    const form__button = document.querySelector(".form__button");
    form__button.addEventListener("click", updateProfile);

    const profiel_newname = document.querySelector(".profiel_newname");
    profiel_newname.addEventListener("input", checkUsername);

    const profiel_newemail = document.querySelector(".profiel_newemail");
    profiel_newemail.addEventListener("input", checkEmail);

    const file_selected = document.querySelector(".file_selected");
    if (file_selected != null) {
      file_selected.addEventListener("click", hideMelding);
    }
  }
  };

  hideMelding = (e) => {
    e.currentTarget.classList.add("hidden");
  };

  checkUsername = async (e) => {
    let newName = e.currentTarget.value;
    const response = await fetch(`index.php?page=profiel`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
        "Accept": "application/json",
      }),
      body: `{"action": "checkUsername", "newName": "${newName}"}`,
    });
    const returned = await response.json();
    console.log(returned);
    if (returned == true) {
      document.querySelector(".check_username_wrong").classList.add("hidden");
      document
        .querySelector(".check_username_correct")
        .classList.remove("hidden");
    } else {
      document
        .querySelector(".check_username_wrong")
        .classList.remove("hidden");
      document.querySelector(".check_username_correct").classList.add("hidden");
    }
  };

  checkEmail = async (e) => {
    let newEmail = e.currentTarget.value;
    const response = await fetch(`index.php?page=profiel`, {
      method: "POST",
      headers: new Headers({
        "Content-Type": "application/json",
        Accept: "application/json",
      }),
      body: `{"action": "checkEmail", "newEmail": "${newEmail}"}`,
    });
    const returned = await response.json();
    console.log(returned);
    if (returned == true) {
      document.querySelector(".check_email_correct").classList.remove("hidden");
      document.querySelector(".check_email_wrong").classList.add("hidden");
    } else {
      document.querySelector(".check_email_correct").classList.add("hidden");
      document.querySelector(".check_email_wrong").classList.remove("hidden");
    }
  };

  updateProfile = async (e) => {
    e.preventDefault();
    console.log("update");
    const newName = document.querySelector(".profiel_newname").value;
    const newEmail = document.querySelector(".profiel_newemail").value;
    const oldPassword = document.querySelector(".inputoldpass").value;
    const newPassword = document.querySelector(".inputnewpass").value;

    if (
      document.querySelector(".inputoldpass").value !== "******" &&
      document.querySelector(".inputnewpass").value !== "******"
    ) {
      //Update naam email en password
      const response = await fetch(`index.php?page=profiel`, {
        method: "POST",
        headers: new Headers({
          "Content-Type": "application/json",
          Accept: "application/json",
        }),
        body: `{"action": "updateProfileAll", "newName": "${newName}", "newEmail": "${newEmail}", "oldPassword": "${oldPassword}", "newPassword": "${newPassword}"}`,
      });
      window.location.replace("index.php?page=profiel");
      //const returned = await response.json();
      //console.log(returned);
    } else {
      //Update naam en email
      const response = await fetch(`index.php?page=profiel`, {
        method: "POST",
        headers: new Headers({
          "Content-Type": "application/json",
          Accept: "application/json",
        }),
        body: `{"action": "updateProfile", "newName": "${newName}", "newEmail": "${newEmail}"}`,
      });
      //const returned = await response.json();
      //Error Uncaught (in promise) SyntaxError: Unexpected token < in JSON at position 0
      window.location.replace("index.php?page=profiel");
      //console.log(returned);
    }
  };

  showOldPass = () => {
    document.querySelector(".oldpassword").classList.remove("hidden");
    document.querySelector(".newpasswordlabel").innerHTML = "Nieuw wachtwoord";
    document.querySelector(".inputoldpass").value = "";
    document.querySelector(".inputnewpass").value = "";
  };

  init();
}
