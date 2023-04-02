document.addEventListener('DOMContentLoaded', function(){
  let inputPhone = document.getElementById("phone");
  inputPhone.oninput = () => phoneMask(inputPhone);
  function phoneMask(inputEl) {
    let patStringArr = "+_(___)___-__-__".split("");
    let arrPush = [1, 3, 4, 5, 7, 8, 9, 11, 12, 14, 15];
    let val = inputEl.value;
    let arr = val.replace(/\D+/g, "").split("").splice(0);
    let n;
    let ni;
    arr.forEach((s, i) => {
      n = arrPush[i];
      patStringArr[n] = s;
      ni = i;
    });
    arr.length < 10
        ? (inputEl.style.color = "red")
        : (inputEl.style.color = "green");
    inputEl.value = patStringArr.join("");
    n
        ? inputEl.setSelectionRange(n + 1, n + 1)
        : inputEl.setSelectionRange(17, 17);
  }

  const day = document.querySelector(".date-day");
  const month = document.querySelector(".date-month");
  const year = document.querySelector(".date-year");
  const dayList = document.querySelectorAll(".date-day-list-item");
  const monthList = document.querySelectorAll(".date-month-list-item");
  const yearhList = document.querySelectorAll(".date-year-list-item");
  const dayText = document.querySelector(".date_day_text");
  const monthText = document.querySelector(".date_month_text");
  const yearText = document.querySelector(".date_year_text");
  let delivery = new Object();
  day.addEventListener("click", () => {
    if (
        month.classList.contains("active_list") ||
        year.classList.contains("active_list")
    ) {
      day.classList.toggle("active_list");
      year.classList.remove("active_list");
      month.classList.remove("active_list");
    } else {
      day.classList.toggle("active_list");
    }
  });
  dayList.forEach((e) => {
    e.addEventListener("click", () => {
      dayText.innerText = e.innerText;
      delivery.day = dayText.innerText;
      document.getElementById('input-day').value = dayText.innerText
    });
  });
  month.addEventListener("click", () => {
    if (
        day.classList.contains("active_list") ||
        year.classList.contains("active_list")
    ) {
      month.classList.toggle("active_list");
      year.classList.remove("active_list");
      day.classList.remove("active_list");
    } else {
      month.classList.toggle("active_list");
    }
  });
  monthList.forEach((el) => {
    el.addEventListener("click", () => {
      let monthNumber = el.dataset.month
      monthText.innerText = el.innerText;
      delivery.month = monthText.innerText;
      document.getElementById('input-month').value = monthText.innerText
      document.getElementById('input-month-number').value = monthNumber
    });
  });
  year.addEventListener("click", () => {
    if (
        day.classList.contains("active_list") ||
        month.classList.contains("active_list")
    ) {
      year.classList.toggle("active_list");
      day.classList.remove("active_list");
      month.classList.remove("active_list");
    } else {
      year.classList.toggle("active_list");
    }
  });
  yearhList.forEach((e) => {
    e.addEventListener("click", () => {
      yearText.innerText = e.innerText;
      delivery.year = yearText.innerText;
      document.getElementById('input-year').value = yearText.innerText
    });
  });

// output
  let form = document.querySelector(".order-form");
  let order = document.querySelector(".btn-order");
  const name = document.querySelector("#name");
  const email = document.querySelector("#email");
  const region = document.querySelector("#region");
  const address = document.querySelector("#address");
  const apartament = document.querySelector("#apartament");
  const payment1 = document.querySelector("#payment1");
  const payment2 = document.querySelector("#payment2");
  let products = {};
  const product = document.querySelectorAll(".cart_item");
  const quantityCheckout = document.querySelectorAll(".product-quantity");
  const total = document.querySelector(".total");
  let arr = [];
  let json;

  product.forEach((e) => {
    let productsDescr = e.childNodes[3].childNodes[1].innerText;
    arr.push(productsDescr);
  });
// console.log(arr);
  order.addEventListener("click", (e) => {
    //   e.preventDefault();
    products.name = name.value;
    products.phone = inputPhone.value;
    products.email = email.value;
    products.region = region.value;
    products.address = address.value;
    products.apartament = apartament.value;
    products.desc = arr;
    products.total = total.innerText;
    products.delivery = delivery;
    json = JSON.stringify(products);
    localStorage.setItem("order", json);
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      createThank();
    });
  });
  document.addEventListener("click", (e) => {
    let target = e.target;
    let its_day = target == day || day.contains(target);
    let its_month = target == month || month.contains(target);
    let its_year = target == year || year.contains(target);

    if (!its_day && !its_month && !its_year) {
      day.classList.remove("active_list");
      month.classList.remove("active_list");
      year.classList.remove("active_list");
    }
  });
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

}, false);
