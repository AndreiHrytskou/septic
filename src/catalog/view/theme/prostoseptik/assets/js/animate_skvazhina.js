document.addEventListener('DOMContentLoaded', function(){
try{
  // const blockImage = document.querySelectorAll("");
  const blockImage = document.querySelector(
      ".textblock-wrap-container:first-child .textblock-wrap-container-list"
  );
  const blockImageSecond = document.querySelector(
      ".textblock-wrap-container:nth-child(3) .textblock-wrap-container-list"
  );
  const blockHeight = document.querySelector(
      ".textblock-wrap-container:first-child"
  );
  const blockHeightSecond = document.querySelector(
      ".textblock-wrap-container:nth-child(3)"
  );
  let topBlock = blockImage.getBoundingClientRect().top;
  let bottomBlock = blockImage.getBoundingClientRect().bottom;
  let topBlockSecond = blockImageSecond.getBoundingClientRect().top;
  let bottomBlockSecond = blockImageSecond.getBoundingClientRect().bottom;
// let topBlock1 = topBlock;
  document.addEventListener("DOMContentLoaded", () => {
    if (window.innerWidth > 1200) {
      window.addEventListener("scroll", () => {
        let scrollY = window.scrollY;
        if (scrollY > topBlock - 80 && scrollY < bottomBlock - 700) {
          scrollFirst();
          blockImage.classList.add("fixed");
          if (blockImage.classList.contains("fixed")) {
            blockImage.classList.remove("fix");
          }
        } else {
          blockImage.classList.remove("fixed");
          if (
              scrollY > bottomBlock - 700 &&
              !blockImage.classList.contains("fixed")
          ) {
            blockImage.classList.add("fix");
          }
        }
        if (scrollY > topBlockSecond && scrollY < bottomBlockSecond - 850) {
          scrollSecond();
          blockImageSecond.classList.add("fixed2");
          blockImageSecond.classList.remove("fix2");
        } else {
          blockImageSecond.classList.remove("fixed2");
          if (
              scrollY > bottomBlockSecond - 850 &&
              !blockImageSecond.classList.contains("fixed2")
          ) {
            blockImageSecond.classList.add("fix2");
          }
        }
      });
      function scrollFirst() {
        let body = window.document.body.offsetWidth;
        let wrap = document.querySelector(".textblock-wrap").offsetWidth;
        let sum = (body - wrap) / 2;
        let sum2 = wrap - blockImage.offsetWidth;
        blockImage.style.left = sum + sum2 - 50 + "px";
      }
      function scrollSecond() {
        let body = window.document.body.offsetWidth;
        let wrap = document.querySelector(".textblock-wrap").offsetWidth;
        let sum = (body - wrap) / 2;
        let sum2 = wrap - blockImageSecond.offsetWidth;
        blockImageSecond.style.left = sum + sum2 - 50 + "px";
      }
    }
  });

}catch (e){

}

}, false);
