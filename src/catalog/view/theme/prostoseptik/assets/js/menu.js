document.addEventListener('DOMContentLoaded', function(){
  const water = document.querySelector(".water");
  const portfolio = document.querySelector(".portfolio");
  const waterMenu = document.querySelector(".water__hide");
  const portfolioMenu = document.querySelector(".portfolio__hide");
  let span = document.createElement("div");
  const plus = document.querySelector(".plus");
  const minus = document.querySelector(".minus");
  let productItem = document.querySelectorAll(".cart-wrap-block");
  let quantity = document.querySelectorAll(".quantity");
  let wrap = document.querySelectorAll(".product-quantity");

  const waterShow = () => {
    water.classList.toggle("visible");
    waterMenu.classList.toggle("active");
    document.body.append(span);
    span.classList.toggle("background__white");
    if (
        portfolio.classList.contains("visible") &&
        portfolioMenu.classList.contains("active")
    ) {
      portfolio.classList.toggle("visible");
      portfolioMenu.classList.toggle("active");
    }
  };

  water.addEventListener("click", (e) => {
    e.stopPropagation();
    waterShow();
  });

  document.addEventListener("click", (e) => {
    let target = e.target;
    let menu = document.querySelector(".water__hide-menu");
    let its_menu = target == menu || menu.contains(target);
    let its_water = target == water;
    let menu_is_active = waterMenu.classList.contains("active");

    if (!its_menu && !its_water && menu_is_active) {
      waterShow();
    }
  });

  const portfolioShow = () => {
    portfolio.classList.toggle("visible");
    portfolioMenu.classList.toggle("active");
    document.body.append(span);
    span.classList.toggle("background__white");
    if (
        water.classList.contains("visible") &&
        waterMenu.classList.contains("active")
    ) {
      water.classList.toggle("visible");
      waterMenu.classList.toggle("active");
    }
  };

  portfolio.addEventListener("click", (e) => {
    e.stopPropagation();
    portfolioShow();
  });

  document.addEventListener("click", (e) => {
    let target = e.target;
    let menu = document.querySelector(".portfolio__hide-menu");
    let its_menu = target == menu || menu.contains(target);
    let its_portfolio = target == portfolio;
    let menu_is_active = portfolioMenu.classList.contains("active");

    if (!its_menu && !its_portfolio && menu_is_active) {
      portfolioShow();
      span.classList.remove("background__white");
    }
  });

// show item
  const remove = document.querySelector(".remove");
  let counter = document.querySelector(".header__menu-cart-count");

  // counter.innerText = localStorage.getItem("number");

// cart

  const cart = document.querySelector(".header__menu-cart");
  const cartModal = document.querySelector(".cart-modal");
  const back = document.querySelector(".back");
  cart.addEventListener("click", () => {
    cartModal.classList.toggle("cart-modal-active");
    const div = document.createElement("div");
    div.className = "background__white";
    document.body.append(div);
    div.addEventListener("click", () => {
      cartModal.classList.remove("cart-modal-active");
      div.remove();
    });
    back.addEventListener("click", () => {
      cartModal.classList.remove("cart-modal-active");
      div.remove();
    });
  });

  document.addEventListener("click", (e) => {
    let target = e.target;
    const title = document.querySelector(".cart-modal .title");
    const block = document.querySelector(".cart-wrap-block");
    const order = document.querySelector(".order-total");
    const quant = document.querySelector(".quantity");
    const plus = document.querySelector('.plus')
    const minus = document.querySelector('.minus')
    const remove = document.querySelector('.remove')


    let its_block = target == block;
    let its_remove = target == remove;
    let its_minus = target == minus;
    let its_plus = target == plus;
    let its_quantity = target == quant;
    let its_wrap = target == wrap;

    let its_order = target == order || order.contains(target);
    let its_title = target == title || title.contains(target);
    let its_menu = target == cart || cart.contains(target);
    let its_portfolio = target == cartModal;
    let menu_is_active = cartModal.classList.contains("cart-modal-active");

    if (
        !target.closest('.cart-modal') &&
        !target.classList.contains('cart-wrap-row') &&
        !its_wrap &&
        !its_quantity &&
        !its_plus &&
        !its_minus &&
        !its_order &&
        !its_remove &&
        !its_block &&
        !its_title &&
        !its_menu &&
        !its_portfolio
        && menu_is_active
    ) {
      cartModal.classList.toggle("cart-modal-active");
      console.log(132143243214)
    }
  });

// cart count
//   quantity.forEach((e) => {
//     e.id;
//     let firstId = e.id;
//     wrap.forEach((el) => {
//       let elem = el.childNodes[3];
//       let secondId = elem.id;
//       let minusItem = el.childNodes[1];
//       let plusItem = el.childNodes[5];
//
//       function plusVal() {
//         if (firstId == secondId) {
//           ++e.value;
//           e.value;
//         }
//       }
//       function minusVal() {
//         if (firstId == secondId) {
//           if (e.value > 0) --e.value;
//           e.value;
//         }
//       }
//       minusItem.addEventListener("click", minusVal);
//       plusItem.addEventListener("click", plusVal);
//     });
//   });
//   remove.addEventListener("click", () => {
//     productItem.forEach((e) => {
//       e.remove();
//     });
//   });

}, false);

