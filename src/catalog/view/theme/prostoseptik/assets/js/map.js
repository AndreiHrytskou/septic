document.addEventListener('DOMContentLoaded', function(){
  const thanksBtn = document.querySelector(".thanks__btn");
  thanksBtn.addEventListener("click", createThanks);
  const buy = document.querySelector(".product-descriptions-top-btn-item");
  buy.addEventListener("click", () => {
    const spanBack = document.createElement("div");
    const modalBlock = document.createElement("div");
    const img = document.createElement("img");
    const text = document.createElement("p");
    const toCart = document.createElement("a");
    const toCatalog = document.createElement("a");
    const remove = document.createElement("span");
    modalBlock.className = "modal modal__active modal__product";
    img.className = "modal__img";
    img.src = "assets/img/doneicon.png";
    text.className = "title";
    toCart.href = "./cart.html";
    toCatalog.href = "./catalog.html";
    toCatalog.className = "toCatalog";
    remove.className = "remove";
    document.body.append(modalBlock);
    document.body.append(spanBack);
    modalBlock.append(img);
    modalBlock.append(text);
    modalBlock.append(toCart);
    modalBlock.append(toCatalog);
    modalBlock.append(remove);
    toCart.append("перейти в корзину");
    toCatalog.append("вернуться в каталог");
    remove.append("x");
    toCart.className = "btn";
    text.append("Товар добавлен в корзину");
    spanBack.classList.toggle("background__white");
    spanBack.addEventListener("click", () => {
      spanBack.classList.toggle("background__white");
      modalBlock.remove();
    });
    remove.addEventListener("click", () => {
      spanBack.classList.toggle("background__white");
      modalBlock.remove();
    });
  });

  const btnOrder = document.querySelector(".btnOrder");
  btnOrder.addEventListener("click", createThank);
  function createThank() {
    const div = document.createElement("div");
    const thanks = document.createElement("div");
    const thanksTitle = document.createElement("p");
    const thanksText = document.createElement("p");
    const thanksBtn = document.createElement("button");
    div.classList.toggle("white");
    thanks.className = "thanks__grey";
    thanksTitle.className = "title center";
    thanksText.className = "modal-text";
    thanksBtn.className = "mobal__btn";
    document.body.append(thanks);
    document.body.append(div);
    thanks.append(thanksTitle);
    thanks.append(thanksText);
    thanks.append(thanksBtn);
    thanksTitle.append("Спасибо за Ваш заказ");
    thanksText.append("В течение дня мы с Вами свяжемся");
    thanksBtn.append("Продолжить");
    thanksBtn.addEventListener("click", () => {
      thanks.remove();
      div.remove();
    });
    div.addEventListener("click", () => {
      thanks.remove();
      div.classList.toggle("white");
    });
  }
// contacts

  const inputBtn = document.querySelector(".form-btn");

  inputBtn.addEventListener("click", (e) => {
    e.preventDefault();
    createThanks();
  });
  function createThanks() {
    const div = document.createElement("div");
    const thanks = document.createElement("div");
    const thanksTitle = document.createElement("p");
    const thanksText = document.createElement("p");
    const thanksBtn = document.createElement("button");
    div.classList.toggle("div-hide");
    thanks.className = "thanks";
    thanksTitle.className = "title center";
    thanksText.className = "modal-text";
    thanksBtn.className = "mobal__btn";
    document.body.append(thanks);
    document.body.append(div);
    thanks.append(thanksTitle);
    thanks.append(thanksText);
    thanks.append(thanksBtn);
    thanksTitle.append("Спасибо за Ваше обращение!");
    thanksText.append("В течение дня мы с Вами свяжемся");
    thanksBtn.append("Продолжить");
    thanksBtn.addEventListener("click", () => {
      thanks.remove();
      div.remove();
    });
    div.addEventListener("click", () => {
      thanks.remove();
      div.classList.toggle("div-hide");
    });
  }
// checkout
  let order = document.querySelector(".btn-order");
  order.addEventListener("click", (e) => {
    e.preventDefault();
    createThank();
  });
  const btnCatalog = document.querySelector(".btn_catalog");
  btnCatalog.addEventListener("click", () => {
    btnCatalog.innerText = "в корзине";
  });

}, false);

