document.addEventListener('DOMContentLoaded', function(){
  if(document.querySelector('.benefits')){
    const benefits = document.querySelector(".benefits");
    window.addEventListener("scroll", () => {
      benefits.getBoundingClientRect();
      if (window.pageYOffset > benefits.offsetTop - 500) {
        benefits.style.transform = "translateX(0)";
        benefits.style.transition = "0.5s";

        setTimeout(loadItems, 800);
        function loadItems() {
          let items = document.querySelectorAll(".benefits-block-item");
          items.forEach((e) => {
            e.style.transform = "scale(1)";
            e.style.transition = "0.5s";
          });
        }
      }
    });
  }
}, false);
