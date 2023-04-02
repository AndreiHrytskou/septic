document.addEventListener('DOMContentLoaded', function(){
  let video = document.querySelector(".video-bottom__item");
  let videoImg = document.querySelector(".video-bottom__item-img");

  let heightImg;
  video.addEventListener("click", (e) => {
    const iframe = document.createElement("iframe");
    video.append(iframe);
    e.preventDefault();
    iframe.className = "video__frame";
    let videoSrc = video.href;
    let videoId = videoSrc.substr(17) + "?rel=0&autoplay=1";
    videoImg.style.display = "none";
    let link = "https://www.youtube.com/embed/" + videoId;
    iframe.src = link;
    iframe.style.display = "block";
    iframe.setAttribute("allow", "autoplay");
  });
// videoImg.onload = function () {
//   heightImg = this.height;
//   iframe.style.height = `${heightImg}px`;
// };

}, false);

