document.addEventListener('DOMContentLoaded', function(){

  const menuBtn = document.querySelector(".burger");
  const menuNav = document.querySelector(".header__container");
  const headerMenu = document.querySelector(".header__menu-list");

  function menuShow() {
    menuNav.classList.toggle("activ");
    menuBtn.classList.toggle("burger-activ");
  }
  menuBtn.addEventListener("click", () => {
    menuShow();
  });
  document.addEventListener("click", (e) => {
    e.stopPropagation();
    let target = e.target;
    let its_menu = target == headerMenu || headerMenu.contains(target);
    let its_menuBtn = target == menuBtn || menuBtn.contains(target);
    let menu_is_active = menuNav.classList.contains("activ");
    if (!its_menu && !its_menuBtn && menu_is_active) {
      menuShow();
    }
  });

  const currActive = document.querySelectorAll(".header__menu-list-item");
  const waterList = document.querySelectorAll(".water__hide-link");
  currActive.forEach((e) => {
    if (e.href == document.URL) {
      e.className += " current-link";
    }
    if (window.location.pathname == "/single-product.html") {
      document.querySelector(".header__menu-list-item").className +=
          " current-link";
    }
  });

  waterList.forEach((e) => {
    if (e.href == document.URL) {
      e.parentElement.parentElement.parentElement.className += " current-link";
    }
  });

}, false);
