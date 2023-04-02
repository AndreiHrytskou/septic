document.addEventListener('DOMContentLoaded', function(){

  let card = document.querySelectorAll(".card-btn");
  card.forEach((e) => {
    e.addEventListener("click", (elem) => {
      elem.preventDefault();
      e.style.zIndex = "-1";
    });
  });
  if (window.innerWidth > 1025) {
    let catalog = document.querySelectorAll(".product");
    catalog.forEach((e) => {
      let btn = e.childNodes[3].childNodes[7];
      btn.addEventListener("click", () => {
        function getCoords() {
          let cart = document.querySelector(".header__menu-cart");
          let img = e.childNodes[1];
          let image = e.childNodes[1].childNodes[1].cloneNode();
          image.style.position = "absolute";
          image.style.top = img.offsetTop + "px";
          image.style.left = img.offsetLeft + "px";
          image.style.zIndex = 999999;
          image.style.width = "281px";
          let top = cart.offsetTop;
          let left = cart.offsetLeft + "px";
          let finishTop = window.pageYOffset - top - 50 + "px";
          document.body.appendChild(image);
          image.animate(
              [
                {
                  top: finishTop,
                  left: left,
                  transform: "scale(0.2)",
                },
              ],
              {
                duration: 800,
              }
          );
          setTimeout(remImg, 800);
          function remImg() {
            image.remove();
          }
        }
        getCoords();
      });
    });
  }
  // const product = document.querySelectorAll(".product");
  // product.forEach((e) => {
  //   const input = e.childNodes[3].childNodes[3].childNodes[1].childNodes[1];
  //   const input2 = e.childNodes[3].childNodes[3].childNodes[3].childNodes[1];
  //   const price = e.childNodes[3].childNodes[3].childNodes[1];
  //   const price2 = e.childNodes[3].childNodes[3].childNodes[3];
  //   input.addEventListener("click", () => {
  //     if (input.checked) {
  //       price.classList.add("active-label");
  //       price2.classList.remove("active-label");
  //     } else {
  //       price.classList.remove("active-label");
  //     }
  //   });
  //   input2.addEventListener("click", () => {
  //     if (input2.checked) {
  //       price2.classList.add("active-label");
  //       price.classList.remove("active-label");
  //     } else {
  //       price2.classList.remove("active-label");
  //     }
  //   });
  // });

}, false);
