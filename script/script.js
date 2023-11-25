
var swiper = new Swiper(".swiper", {
  effect: "coverflow",
  grabCursor: true,
  spaceBetween: 30,
  centeredSlides: false,
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 0,
    modifier: 1,
    slideShadows: false
  },
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true
  },
  keyboard: {
    enabled: true
  },
  mousewheel: {
    thresholdDelta: 70
  },
 autoplay: {
    delay: 4000, // Set the delay in milliseconds (2 seconds in this case)
    disableOnInteraction: false // Set to false to keep autoplaying even when user interacts with the slider
  },
  breakpoints: {
    460: {
      slidesPerView:1
    },
    768: {
      slidesPerView: 3
    },
    1024: {
      slidesPerView: 3
    },
    1600: {
      slidesPerView: 5
    }
  }
});
