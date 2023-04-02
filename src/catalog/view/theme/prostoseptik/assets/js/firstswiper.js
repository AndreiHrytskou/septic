document.addEventListener(
  "DOMContentLoaded",
  function () {
    var swiper = new Swiper(".mySwiper", {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });

    // second swiper

    var swiper2 = new Swiper(".mySwiper2", {
      slidesPerView: 4,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      //   autoplay: {
      //     delay: 5000,
      //     disableOnInteraction: false,
      //   },
      breakpoints: {
        // when window width is >= 300px
        320: {
          slidesPerView: 1.2,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });

    const width = window.innerWidth;
    if (width > 768) {
      var swiper2 = new Swiper(".mySwiper3", {
        slidesPerView: 3,
        spaceBetween: 23,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
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
    // products

    var galleryThumbs = new Swiper(".gallery-thumbs", {
      centeredSlides: true,
      centeredSlidesBounds: true,
      direction: "horizontal",
      //   spaceBetween: 10,
      slidesPerView: 3,
      freeMode: false,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
      watchOverflow: true,
      breakpoints: {
        480: {
          direction: "vertical",
          slidesPerView: 3,
        },
      },
    });
    var galleryTop = new Swiper(".gallery-top", {
      direction: "horizontal",
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      a11y: {
        prevSlideMessage: "Previous slide",
        nextSlideMessage: "Next slide",
      },
      keyboard: {
        enabled: true,
      },
      thumbs: {
        swiper: galleryThumbs,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
    galleryTop.on("slideChangeTransitionStart", function () {
      galleryThumbs.slideTo(galleryTop.activeIndex);
    });
    galleryThumbs.on("transitionStart", function () {
      galleryTop.slideTo(galleryThumbs.activeIndex);
    });

    var swiper9 = new Swiper(".mySwiper99", {
      slidesPerView: 4,
      spaceBetween: 23,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      //   autoplay: {
      //     delay: 5000,
      //     disableOnInteraction: false,
      //   },
      breakpoints: {
        // when window width is >= 300px
        320: {
          slidesPerView: 1,
        },
        700: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 4,
        },
      },
    });
  },
  false
);
