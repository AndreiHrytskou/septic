// document.addEventListener('DOMContentLoaded', function(){
//
//   const ingenerName = document.querySelector("#ingener_name");
//   const ingenerTel = document.querySelector("#tel");
//   if (document.querySelector(".consultant__btn") != undefined) {
//     const formBtn1 = document.querySelector(".consultant__btn");
//     formBtn1.addEventListener("click", (e) => {
//       e.preventDefault();
//       ingenerName.addEventListener("focus", () => {
//         ingenerName.placeholder = "";
//       });
//       ingenerTel.addEventListener("focus", () => {
//         ingenerTel.placeholder = "";
//       });
//       if (ingenerName.value != "" && ingenerTel.value != "") {
//         ingenerName.classList.remove("name-active");
//         ingenerTel.classList.remove("name-active");
//         ingenerName.value = "";
//         ingenerTel.value = "";
//       } else {
//         ingenerName.placeholder = "Вы не ввели имя";
//         ingenerName.classList.add("name-active");
//         ingenerTel.placeholder = "Вы не ввели телефона";
//         ingenerTel.classList.add("name-active");
//       }
//     });
//   }
//   const formBtn2 = document.querySelector(".form-button");
//   formBtn2.addEventListener("click", (e) => {
//     const name = document.getElementById("name");
//     const phone = document.getElementById("phone");
//     e.preventDefault();
//     name.addEventListener("focus", () => {
//       name.placeholder = "";
//     });
//     phone.addEventListener("focus", () => {
//       phone.placeholder = "";
//     });
//     if (name.value != "" && phone.value != "") {
//       name.classList.remove("name-active");
//       phone.classList.remove("name-active");
//       name.value = "";
//       phone.value = "";
//       name.placeholder = "Имя";
//       phone.placeholder = "Номер телефона";
//     } else {
//       name.placeholder = "Вы не ввели имя";
//       name.classList.add("name-active");
//       phone.placeholder = "Вы не ввели телефона";
//       phone.classList.add("name-active");
//     }
//   });
//
// }, false);
