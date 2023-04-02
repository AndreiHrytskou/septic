document.addEventListener('DOMContentLoaded', function(){

  const btnNews = document.querySelector(".news-more");
  let arrNews = document.querySelectorAll(".news-block__item");
  let amountNews = [];
// let newAmount = (amountProd = 6);

  arrNews.forEach((el) => {
    amountNews.push(el);
    return amountNews;
  });
  amountNews.forEach((el) => {
    el.style.display = "none";
  });
  let newArrNews = amountNews.slice(0, 9);
  newArrNews.forEach((e) => {
    e.style.display = "flex";
  });
  btnNews.addEventListener("click", (e) => {
    e.preventDefault();
    amountNews.forEach((elem) => {
      elem.style.display = "flex";
    });
  });
  if (window.screen.width < 1201) {
    arrNews.forEach((el) => {
      amountNews.push(el);
      return amountNews;
    });
    amountNews.forEach((el) => {
      el.style.display = "none";
    });
    let newArrNews = amountNews.slice(0, 2);
    newArrNews.forEach((e) => {
      e.style.display = "flex";
    });
    btnNews.addEventListener("click", (e) => {
      e.preventDefault();
      amountNews.forEach((elem) => {
        elem.style.display = "flex";
      });
    });
  }

}, false);
