// document.addEventListener('DOMContentLoaded', function(){
//   const inputChecked = document.querySelector("#consent");
//   const inputBtn = document.querySelector(".form-btn");
//   const formName = document.getElementById("form-name");
//   const formEmail = document.getElementById("form-email");
//   const formTel = document.getElementById("form-tel");
//   const formComments = document.getElementById("form-comments");
//
//   inputChecked.addEventListener("click", () => {
//     inputBtn.toggleAttribute("disabled");
//   });
//   inputBtn.addEventListener("click", (e) => {
//     e.preventDefault();
//     formName.addEventListener("focus", () => {
//       formName.placeholder = "";
//     });
//     formEmail.addEventListener("focus", () => {
//       formEmail.placeholder = "";
//     });
//     formTel.addEventListener("focus", () => {
//       formTel.placeholder = "";
//     });
//     if (formName.value != "" && formTel.value != "" && formEmail.value != "") {
//       createThanks();
//       formName.classList.remove("name-active");
//       formEmail.classList.remove("name-active");
//       formTel.classList.remove("name-active");
//       formName.value = "";
//       formEmail.value = "";
//       formTel.value = "";
//       formName.placeholder = "Имя";
//       formEmail.placeholder = "E-mail";
//       formTel.placeholder = "Номер телефона";
//     } else {
//       formName.placeholder = "Вы не ввели имя";
//       formEmail.placeholder = "Вы не ввели свою почту";
//       formTel.placeholder = "Вы не ввели телефона";
//       formName.classList.add("name-active");
//       formEmail.classList.add("name-active");
//       formTel.classList.add("name-active");
//     }
//   });
//
//   function createThanks() {
//     const div = document.createElement("div");
//     const thanks = document.createElement("div");
//     const thanksTitle = document.createElement("p");
//     const thanksText = document.createElement("p");
//     const thanksBtn = document.createElement("button");
//     div.classList.toggle("div-hide");
//     thanks.className = "thanks";
//     thanksTitle.className = "title center";
//     thanksText.className = "modal-text";
//     thanksBtn.className = "mobal__btn";
//     document.body.append(thanks);
//     document.body.append(div);
//     thanks.append(thanksTitle);
//     thanks.append(thanksText);
//     thanks.append(thanksBtn);
//     thanksTitle.append("Спасибо за Ваше обращение!");
//     thanksText.append("В течение дня мы с Вами свяжемся");
//     thanksBtn.append("Продолжить");
//     thanksBtn.addEventListener("click", () => {
//       thanks.remove();
//       div.remove();
//     });
//     div.addEventListener("click", () => {
//       thanks.remove();
//       div.classList.toggle("div-hide");
//     });
//   }
//
// }, false);
//
