// {
//   const init = () => {
//     const toevoegenRad = Array.from(document.querySelectorAll(".toevoegenRad"));
//     for (let i = 0; i < toevoegenRad.length; i++) {
//       toevoegenRad[i].addEventListener("click", clickRadio);
//     }
//   };

//   clickRadio = (e) => {
//     e.preventDefault();
//     const arrayAll = Array.from(document.querySelectorAll(".detail_action"));
//     for (let i = 0; i < arrayAll.length; i++) {
//       arrayAll[i].classList.add("hidden");
//       arrayAll[i].classList.remove("detail_action");
//     }
//     const vak_radio_checked = document.querySelector(".vak_radio_checked");
//     if (vak_radio_checked) {
//       vak_radio_checked.classList.remove("vak_radio_checked");
//     }
//     e.currentTarget.parentNode.children[1].children[2].classList.remove(
//       "hidden"
//     );
//     e.currentTarget.parentNode.children[1].children[2].classList.add(
//       "detail_action"
//     );
//     e.currentTarget.parentNode.children[1].classList.add("vak_radio_checked");
//   };

//   init();
// }
