document.addEventListener('DOMContentLoaded', function(){
  // let item = document.querySelectorAll(".foto-check-list-item");
  // const arrItems = document.querySelector(".foto-check-list");
  // const filter = document.querySelector(".foto-filtr");

  // item.forEach((e) => {
  //   e.addEventListener("click", () => {
  //     if (!item[0].classList.contains("item_active")) {
  //       e.classList.toggle("item_active");
  //     }
  //     if (item[e].classList.contains("item_active")) {
  //       item[0].classList.remove("item_active");
  //       e.classList.toggle("item_active");
  //     }
  //   });
  // });
// foto-galery




  // const btnFoto = document.querySelector(".foto-more");
  let arrFoto = document.querySelectorAll(".foto-galery-wrap");
  let amountFoto = [];
// let newAmount = (amountProd = 6);

  arrFoto.forEach((el) => {
    amountFoto.push(el);
    return amountFoto;
  });
  amountFoto.forEach((el) => {
    el.style.display = "none";
  });
  let newArrFoto = amountFoto.slice(0, 4);
  newArrFoto.forEach((e) => {
    e.style.display = "flex";
  });
  // btnFoto.addEventListener("click", (e) => {
  //   e.preventDefault();
  //   amountFoto.forEach((elem) => {
  //     elem.style.display = "flex";
  //   });
  // });

}, false);

