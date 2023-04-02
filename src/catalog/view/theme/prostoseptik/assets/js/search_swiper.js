document.addEventListener("DOMContentLoaded", () => {
  const width = window.innerWidth;
  if (width > 768) {
    var swiper2 = new Swiper(".mySwiper100", {
      slidesPerView: 3,
      spaceBetween: 23,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      breakpoints: {
        // when window width is >= 300px
        320: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      },
    });
  }
});
