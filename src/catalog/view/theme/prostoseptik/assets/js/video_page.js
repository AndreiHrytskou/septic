document.addEventListener('DOMContentLoaded', function(){

// //2
// let video2 = document.querySelector(".video2-bottom__item");
// let videoImg2 = document.querySelector(".video2-bottom__item-img");
// let videoFrame2 = document.querySelector(".video2__frame");
// let heightImg2;
// video2.addEventListener("click", (e) => {
//   e.preventDefault();
//   let videoSrc = video2.href;
//   let videoId = videoSrc.substr(17) + "?rel=0&autoplay=1";
//   videoImg2.style.display = "none";
//   let link = "https://www.youtube.com/embed/" + videoId;
//   videoFrame2.src = link;
//   videoFrame2.style.display = "block";
//   videoFrame2.setAttribute("allow", "autoplay");
// });
// videoImg2.onload = function () {
//   heightImg2 = this.height;
//   videoFrame2.style.height = `${heightImg2}px`;
// };
// // 3
// let video3 = document.querySelector(".video3-bottom__item");
// let videoImg3 = document.querySelector(".video3-bottom__item-img");
// let videoFrame3 = document.querySelector(".video3__frame");
// let heightImg3;
// video3.addEventListener("click", (e) => {
//   e.preventDefault();
//   let videoSrc = video3.href;
//   let videoId = videoSrc.substr(17) + "?rel=0&autoplay=1";
//   videoImg3.style.display = "none";
//   let link = "https://www.youtube.com/embed/" + videoId;
//   videoFrame3.src = link;
//   videoFrame3.style.display = "block";
//   videoFrame3.setAttribute("allow", "autoplay");
// });
// videoImg3.onload = function () {
//   heightImg3 = this.height;
//   videoFrame3.style.height = `${heightImg3}px`;
// };
//
// //4
// let video4 = document.querySelector(".video4-bottom__item");
// let videoImg4 = document.querySelector(".video4-bottom__item-img");
// let videoFrame4 = document.querySelector(".video4__frame");
// let heightImg4;
// video4.addEventListener("click", (e) => {
//   e.preventDefault();
//   let videoSrc = video4.href;
//   let videoId = videoSrc.substr(17) + "?rel=0&autoplay=1";
//   videoImg4.style.display = "none";
//   let link = "https://www.youtube.com/embed/" + videoId;
//   console.log(link);
//   videoFrame4.src = link;
//   videoFrame4.style.display = "block";
//   videoFrame4.setAttribute("allow", "autoplay");
// });
// videoImg4.onload = function () {
//   heightImg4 = this.height;
//   videoFrame4.style.height = `${heightImg4}px`;
// };
// //5
// let video5 = document.querySelector(".video5-bottom__item");
// let videoImg5 = document.querySelector(".video5-bottom__item-img");
// let videoFrame5 = document.querySelector(".video5__frame");
// let heightImg5;
// video5.addEventListener("click", (e) => {
//   e.preventDefault();
//   let videoSrc = video5.href;
//   let videoId = videoSrc.substr(17) + "?rel=0&autoplay=1";
//   videoImg5.style.display = "none";
//   let link = "https://www.youtube.com/embed/" + videoId;
//   console.log(link);
//   videoFrame5.src = link;
//   videoFrame5.style.display = "block";
//   videoFrame5.setAttribute("allow", "autoplay");
// });
// videoImg5.onload = function () {
//   heightImg5 = this.height;
//   videoFrame5.style.height = `${heightImg5}px`;
// };
  let videoLinks = document.querySelectorAll('.video4-bottom__item')

  videoLinks.forEach((videoLink)=>{
    videoLink.addEventListener('click', function (event){
      event.preventDefault();
      videoLink.querySelector('.video4__frame').src = videoLink.href + "?rel=0&autoplay=1"
      videoLink.querySelector('.video4__frame').style.display = "block"
      videoLink.querySelector('.video4__frame').setAttribute("allow", "autoplay");
      videoLink.querySelector('.video4-bottom__item-img').style.display = "none"
    })
  })
}, false);
