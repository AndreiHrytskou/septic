document.addEventListener('DOMContentLoaded', function(){

// window.addEventListener("load", () => {
  setTimeout(loadBlock, 800);
  function loadBlock() {
    let block = document.querySelectorAll(".block-bottom-item");
    block.forEach((e) => {
      e.style.transform = "scale(1)";
      e.style.transition = "0.5s";
    });
  }
// });

  const review = document.querySelector(".review");
  window.addEventListener("scroll", () => {
    review.getBoundingClientRect();
    if (window.pageYOffset > review.offsetTop - 500) {
      review.style.transform = "translateX(0)";
      review.style.transition = "0.5s";
    }
  });
  const blockHover = document.querySelectorAll(".block2-middle-item");
  if (window.innerWidth < 1025) {
    blockHover.forEach((e) => {
      e.addEventListener("focus", () => {
        e.classList.toggle("block__hide_active");
      });
    });
  }
  const blockMiddle = document.querySelector(".block2-middle");
  const topBlock2 = blockMiddle.getBoundingClientRect().top;
  window.addEventListener("scroll", () => {
    let scroll = window.scrollY;
    if (scroll > topBlock2 - 130) {
      blockMiddle.classList.add("animate");
    }
  });

// let card = document.querySelectorAll(".card-btn");
// card.forEach((e) => {
//   e.addEventListener("click", (elem) => {
//     elem.preventDefault();
//     e.style.zIndex = "-1";
//   });
// });
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
  const type = document.querySelector(".type_country");
  window.addEventListener("scroll", () => {
    type.getBoundingClientRect();
    if (window.pageYOffset > type.offsetTop - 500) {
      type.style.transform = "translateX(0)";
      type.style.transition = "0.5s";
    }
  });

  const typeBlock = document.querySelectorAll(".type-bottom-item");
  const info = document.querySelector(".item1");
  const info1 = document.querySelector(".item2");
  const info2 = document.querySelector(".item3");
  const info3 = document.querySelector(".item4");
  const info4 = document.querySelector(".item5");
  const info5 = document.querySelector(".item6");
  const info6 = document.querySelector(".item7");
  const info7 = document.querySelector(".item8");

  const block = document.getElementById("block");
  const block1 = document.getElementById("block1");
  const block2 = document.getElementById("block2");
  const block3 = document.getElementById("block3");
  const block4 = document.getElementById("block4");
  const block5 = document.getElementById("block5");
  const block6 = document.getElementById("block6");
  const block7 = document.getElementById("block7");
  typeBlock.forEach((e) => {
    const cross = e.childNodes[7];
    info.addEventListener("click", () => {
      if (info.childNodes[5].id == e.childNodes[5].id) {
        block.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block1.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block.classList.remove("blockVisible");
      });
    });
    info1.addEventListener("click", () => {
      if (info1.childNodes[5].id == e.childNodes[5].id) {
        block1.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block1.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block1.classList.remove("blockVisible");
      });
    });
    info2.addEventListener("click", () => {
      if (info2.childNodes[5].id == e.childNodes[5].id) {
        block2.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block2.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block1.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block2.classList.remove("blockVisible");
      });
    });
    info3.addEventListener("click", () => {
      if (info3.childNodes[5].id == e.childNodes[5].id) {
        block3.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block3.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block1.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block3.classList.remove("blockVisible");
      });
    });
    info4.addEventListener("click", () => {
      if (info4.childNodes[5].id == e.childNodes[5].id) {
        block4.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block4.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block1.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block4.classList.remove("blockVisible");
      });
    });
    info5.addEventListener("click", () => {
      if (info5.childNodes[5].id == e.childNodes[5].id) {
        block5.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block5.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block1.classList.remove("blockVisible");
          block.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block5.classList.remove("blockVisible");
      });
    });
    info6.addEventListener("click", () => {
      if (info6.childNodes[5].id == e.childNodes[5].id) {
        block6.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block6.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block1.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block7.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block6.classList.remove("blockVisible");
      });
    });
    info7.addEventListener("click", () => {
      if (info7.childNodes[5].id == e.childNodes[5].id) {
        block7.classList.toggle("blockVisible");
        e.classList.toggle("typeActive");
        if (
            block7.classList.contains("blockVisible") &&
            e.classList.contains("typeActive")
        ) {
          block.classList.remove("blockVisible");
          block1.classList.remove("blockVisible");
          block2.classList.remove("blockVisible");
          block3.classList.remove("blockVisible");
          block4.classList.remove("blockVisible");
          block5.classList.remove("blockVisible");
          block6.classList.remove("blockVisible");
        }
      } else {
        e.classList.remove("typeActive");
      }
      cross.addEventListener("click", () => {
        e.classList.remove("typeActive");
        block7.classList.remove("blockVisible");
      });
    });
  });

}, false);
