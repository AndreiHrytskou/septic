document.addEventListener('DOMContentLoaded', function(){

//  orderby
  const orderby = document.querySelector(".orderby");
  const filtr = document.querySelector(".filtr");
  const filtrItem = document.querySelector(".filtr__item");
  const filtrImg = document.querySelector(".filtr__img");
  let orderbyItem = document.querySelectorAll(".orderby__item");

  if(document.querySelector('.orderby [data-selected="selected"]')){
    filtrItem.innerText = document.querySelector('.orderby [data-selected="selected"]').innerText
  }

// if (filtr != undefined) {
  filtr.addEventListener("click", () => {
    orderby.classList.toggle("orderby__active");
    filtrImg.classList.toggle("filtr__img-active");
    orderbyItem.forEach((e) => {
      e.addEventListener("click", () => {
        filtrItem.innerText = e.innerText;
      });
    });
  });

  document.addEventListener("click", (e) => {
    e.stopPropagation();
    let target = e.target;
    let its_menu = target == filtr || filtr.contains(target);
    if (!its_menu) {
      orderby.classList.remove("orderby__active");
      filtrImg.classList.remove("filtr__img-active");
    }
  });
// }
// const btn = document.querySelector(".more-btn");
// btn.addEventListener("click", (e) => {
//   e.preventDefault();
//   amountProd.forEach((elem) => {
//     elem.style.display = "flex";
//     btn.style.display = "none";
//   });
//   localStorage.setItem("number", amountProduct.length);
// });

}, false);
