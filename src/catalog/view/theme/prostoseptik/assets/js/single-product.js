document.addEventListener('DOMContentLoaded', function(){

  const buy = document.querySelector(".product-descriptions-top-btn-item");
  buy.addEventListener("click", () => {
    // const spanBack = document.createElement("div");
    // const modalBlock = document.createElement("div");
    // const img = document.createElement("img");
    // const text = document.createElement("p");
    // const toCart = document.createElement("a");
    // const toCatalog = document.createElement("a");
    // const remove = document.createElement("span");
    // modalBlock.className = "modal modal__active modal__product";
    // img.className = "modal__img";
    // img.src = "/catalog/view/theme/prostoseptik/assets/img/doneicon.png";
    // text.className = "title";
    // toCart.href = "./cart.html";
    // toCatalog.href = "./catalog.html";
    // toCatalog.className = "toCatalog";
    // remove.className = "remove";
    // document.body.append(modalBlock);
    // document.body.append(spanBack);
    // modalBlock.append(img);
    // modalBlock.append(text);
    // modalBlock.append(toCart);
    // modalBlock.append(toCatalog);
    // modalBlock.append(remove);
    // toCart.append("перейти в корзину");
    // toCatalog.append("вернуться в каталог");
    // remove.append("x");
    // toCart.className = "btn";
    // text.append("Товар добавлен в корзину");
    // spanBack.classList.toggle("background__white");
    // spanBack.addEventListener("click", () => {
    //   spanBack.classList.toggle("background__white");
    //   modalBlock.remove();
    // });
    // remove.addEventListener("click", () => {
    //   spanBack.classList.toggle("background__white");
    //   modalBlock.remove();
    // });
  });
  const product = document.querySelectorAll(".choice");
  product.forEach((e) => {
    const input = e.childNodes[1].childNodes[1];
    const input2 = e.childNodes[3].childNodes[1];
    const price = e.childNodes[1];
    const price2 = e.childNodes[3];

    if(input.checked){
      price.classList.add("active-label");
    }

    input.addEventListener("click", () => {
      if (input.checked) {
        price.classList.add("active-label");
        price2.classList.remove("active-label");
      } else {
        price.classList.remove("active-label");
      }
    });
    input2.addEventListener("click", () => {
      input2.checked = true
      if (input2.checked) {
        price2.classList.add("active-label");
        price.classList.remove("active-label");
      } else {
        price2.classList.remove("active-label");
      }
    });
  });

}, false);
