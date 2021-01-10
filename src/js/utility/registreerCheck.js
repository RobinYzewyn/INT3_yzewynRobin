{
  const init = () => {
    let currentPage = (window.location.href).split('?')[1];
    if(currentPage === "page=registreer" && typeof currentPage !== "undefined"){

    console.log("registreer");
    //const input = document
    //  .querySelector(".input_username")
    //  .addEventListener("input", handleInputName);
    //console.log;(input);
    //console.log('test');
    const check_username = document.querySelector('.check_username');
    check_username.addEventListener('input', checkUsername);

    const check_email = document.querySelector('.check_email');
    check_email.addEventListener('input', checkEmail);

    const check_password = document.querySelector('.check_password');
    check_password.addEventListener('input', checkPassword);

    const check_passwordrepeat = document.querySelector('.check_passwordrepeat');
    check_passwordrepeat.addEventListener('input', checkPasswordRepeat);
    }
  };

  checkPassword = (e) =>{
    if(e.currentTarget.value !== ""){
      document.querySelector('.check_password_correct').classList.remove('hidden');
      document.querySelector('.check_password_wrong').classList.add('hidden');
    }
    else{
      document.querySelector('.check_password_correct').classList.add('hidden');
      document.querySelector('.check_password_wrong').classList.remove('hidden');
    }
  }

  checkPasswordRepeat = (e) =>{
    console.log(e.currentTarget.value);
    console.log(document.querySelector('.check_password').value)
    if(e.currentTarget.value !== document.querySelector('.check_password').value){
      document.querySelector('.check_passwordrepeat_correct').classList.add('hidden');
      document.querySelector('.check_passwordrepeat_wrong').classList.remove('hidden');
    }
    else{
      document.querySelector('.check_passwordrepeat_correct').classList.remove('hidden');
      document.querySelector('.check_passwordrepeat_wrong').classList.add('hidden');
    }
  }

  checkEmail = async (e) =>{
    console.log(e.currentTarget);
    const response = await fetch(`index.php?page=registreer`, {
    method: "POST",
    headers: new Headers({
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }),
    body: `{"action": "checkEmail", "email": "${e.currentTarget.value}"}`
    });
    const returned = await response.json();
    console.log(returned);
    if(returned == false){
      //Naam nog beschikbaar
      document.querySelector('.check_email_correct').classList.remove('hidden');
      document.querySelector('.check_email_wrong').classList.add('hidden');
    }
    else{
      //Naam niet beschikbaar
      document.querySelector('.check_email_correct').classList.add('hidden');
      document.querySelector('.check_email_wrong').classList.remove('hidden');
    }
  }

  checkUsername = async (e) =>{
    console.log(e.currentTarget);
    const response = await fetch(`index.php?page=registreer`, {
    method: "POST",
    headers: new Headers({
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }),
    body: `{"action": "checkName", "username": "${e.currentTarget.value}"}`
    });
    const returned = await response.json();
    console.log(returned);
    if(returned == false){
      //Naam nog beschikbaar
      document.querySelector('.check_name_correct').classList.remove('hidden');
      document.querySelector('.check_name_wrong').classList.add('hidden');
    }
    else{
      //Naam niet beschikbaar
      document.querySelector('.check_name_correct').classList.add('hidden');
      document.querySelector('.check_name_wrong').classList.remove('hidden');
    }
  }

  const handleInputName = (e) => {
    // e.preventDefault();
    console.log(e.target.value);
    getData();
  };

  //const getData = () => {
  //  const $form = document.querySelector(".inloggen_form");
  //  const name = document.querySelector(".input_username");
  //  // const email = document.querySelector(".input_username");
  //  // const password = document.querySelector(".input_username");
  //  // const passwordRepeat = document.querySelector(".input_username");
  //  console.log(name);
  //  const action = $form.querySelector('.action').value;
  //  // console.log(action);
  //  const data = [];
  //  data.push(action);
  //  data.push(name);
  //  data.push(email);
  //  data.push(password);
  //  data.push(passwordRepeat);
  //  console.log(data);
//
  //  // const response = await fetch(data, {
  //  //       headers: new Headers({
  //  //     Accept: 'application/json'
  //  //   })
  //  // });
//
  //  // const dataJson = await response.json();
//
  //  // showErrors(dataJson);
  //}
//
  const showErrors = data => {
    console.log(data)
  };

  init();
}
