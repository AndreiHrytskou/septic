document.addEventListener('DOMContentLoaded', function(){

  function createThanks() {
    const span = document.createElement("div");
    const thanks = document.createElement("div");
    const thanksTitle = document.createElement("p");
    const thanksText = document.createElement("p");
    const thanksBtn = document.createElement("button");
    thanks.className = "thanks";
    thanksTitle.className = "title center";
    thanksText.className = "modal-text";
    thanksBtn.className = "mobal__btn";
    document.body.append(thanks);
    document.body.append(span);
    thanks.append(thanksTitle);
    thanks.append(thanksText);
    thanks.append(thanksBtn);
    thanksTitle.append("Спасибо!");
    thanksText.append("В ближайшее время с Вами свяжутся наши сотрудники");
    thanksBtn.append("Продолжить");
    span.classList.toggle("div-hide");
    thanksBtn.addEventListener("click", () => {
      if (span.classList.contains("div-hide")) {
        span.classList.remove("div-hide");
      }
      thanks.remove();
    });
    span.addEventListener("click", () => {
      span.classList.remove("div-hide");
      thanks.remove();
    });
  }

}, false);
