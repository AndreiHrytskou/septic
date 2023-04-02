<div class="wrapper">
  <div class="container container__screen">
    <div class="news">
      <h2 class="subtitle center"><?php echo $heading_title; ?></h2>
      <div class="news-block">
        <div class="swiper mySwiper3">
          <div class="swiper-wrapper">
            <?php foreach ($articles as $article) { ?>
            <div class="swiper-slide">
              <div class="news-block-item">
                <div class="news-block__img">
                  <a href="<?php echo $article['href']; ?>">
                    <img class="news-foto" src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" >
                  </a>
                </div>
                <div class="news-block__descr">
                  <p class="news-block__date"><?php echo $article["date_added"];?></p>
                  <a class="news-block__title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
                  <p class="news-block__text"><?php echo $article['description']; ?></p>
                  <a href="<?php echo $article['href']; ?>" class="news-block__link"><span>подробнее</span></a>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
           <div class="swiper-button-prev">
				<img src="catalog/view/theme/prostoseptik/assets/img/ep_arrow-right.png" alt="previus">
			</div>
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next">
				<img src="catalog/view/theme/prostoseptik/assets/img/ep_arrow-right1.png" alt="next">
			</div>
        </div>
      </div>
      <a href="<?= $more_news ?>" class="news-more news__hide">больше статей</a>
    </div>
  </div>
</div>
