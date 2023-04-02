document.addEventListener('DOMContentLoaded', function(){

//sidebar show
  const sidebar = document.querySelector(".sidebar");
  const showSidebar = document.querySelector(".sidebar-hide");
  const showForm = document.querySelector(".sidebar__form");
  showSidebar.addEventListener("click", () => {
    sidebar.classList.toggle("sidebar-show");
  });
  let listProd = {};

  document.addEventListener("click", (e) => {
    e.stopPropagation();
    let target = e.target;
    let its_menu = target == showSidebar || showSidebar.contains(target);
    let its_showForm = target == showForm || showForm.contains(target);
    if (!its_menu && !its_showForm) {
      sidebar.classList.remove("sidebar-show");
    }
  });

  let amountProduct = document.querySelectorAll(".cart_item");
  let amountProd = [];
  let catalog = document.querySelectorAll(".product");
  catalog.forEach((el) => {
    amountProd.push(el);
    return amountProd;
  });
  let newArr = amountProd.slice(0, 6);

  const hide = document.querySelector(".hide");
  const textHide = document.querySelectorAll(".text-hide");
  hide.addEventListener("click", () => {
    hide.style.display = "none";
    textHide.forEach((e) => {
      e.style.display = "block";
    });
  });

}, false);
