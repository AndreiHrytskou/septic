<div class="wrapper wrapper_grey">
    <div class="container">
        <div class="review">
            <div class="review-top">
                <h2 class="subtitle review-title">Заочно мы&nbsp;уже познакомились</h2>
                <p class="review-top-subtitle">Интересно узнать, что&nbsp;о&nbsp;нас думают другие? Отзывы о&nbsp;нашей работе есть&nbsp;на&nbsp;всех платформах</p>
            </div>
            <div class="review-middle">
                <div class="swiper mySwiper2">
                    <div class="swiper-wrapper">
                        <?php foreach($reviews as $review): ?>
                        <div class="swiper-slide">
                            <div class="swiper-top" itemscope="" itemtype="https://schema.org/Review">
                                <?php if($review['thumb']):?>
                                <img class="slider-top-avatar" src="<?php echo $review['thumb'] ?>" alt="<?php echo $review['author'] ?>">
                                <?php endif; ?>
                                <p class="slider-top-name" itemprop="author" itemscope="" itemtype="https://schema.org/Person">
                                    <meta itemprop="name" content="<?php echo $review['author'] ?>">
                                    <?php echo $review['author'] ?>
                                </p>
                                <span itemprop="itemReviewed" itemscope="" itemtype="https://schema.org/Organization">
									<meta itemprop="name" content="prostoseptik">
								</span>
                            </div>
                            <div class="slider-middle" itemscope="" itemtype="https://schema.org/Rating">
                                <div class="rating">
                                    <div class="rating-wrapper">
                                        <div class="ranks-wrap">
                                            <div class="rating-group">
                                                <span itemprop="ratingValue" content="<?php echo $review['rating'] ?>"></span>
                                                <div class="star-rating">
                                                    <div style="width:100%" class="superstar">
                                                        <img alt="full-star" class="star" src="catalog/view/theme/prostoseptik/assets/img/star.png">
                                                    </div>
                                                    <img class="empty-stars" alt="empty-star" src="catalog/view/theme/prostoseptik/assets/img/empty.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="slider-bottom">
                                <p><?php echo $review['text'] ?></p>
                            </div>
                            <a href="#" class="slider-bottom-link">
                                <img class="slider-bottom-link-img" src="catalog/view/theme/prostoseptik/assets/img/yandex.png" alt="yandex">
                            </a>
                        </div>
                        <?php endforeach; ?>
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
            <div class="review-bottom">
                <a href="https://yandex.ru/maps/org/pro100septik/12360602480/reviews/?ll=37.658427%2C55.728865&amp;tab=reviews&amp;z=17.03" target="_blank" class="review-bottom-btn">написать отзыв<img src="catalog/view/theme/prostoseptik/assets/img/yandexlogowhite.png" alt="yandexlogowhite"></a>
                <a href="https://g.co/kgs/3s4RNy" target="_blank" class="review-bottom-btn">написать отзыв<img src="catalog/view/theme/prostoseptik/assets/img/googlelogowhite.png" alt="googlelogowhite"></a>
            </div>
        </div>
    </div>
</div>	