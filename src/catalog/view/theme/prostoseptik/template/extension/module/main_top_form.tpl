<div class="wrapper">
	<div class="container">
		<div class="swiper mySwiper">
			<div class="swiper-wrapper">
				<?php if(isset($poster_images) && count($poster_images) > 0): ?>
				<?php foreach($poster_images as $poster): ?>
				<div class="swiper-slide">
					<div class="baner">
						<div class="baner-left">
							<p class="page-title baner__title"><?php echo $poster['title'] ?></p>
							<?php if(isset($poster['link']) && !empty($poster['link'])): ?>
							<a class="main-banner-btn" href="<?php echo $poster['link'] ?>">Перейти</a>
						<?php else: ?>
							<button class="baner-btn">Заказать</button>
							<?php endif; ?>
							<div class="baner-left-social">
								<a href="<?php echo $vk ?>" target="_blank" class="baner-left-social-link">
									<img class="baner-left-social-img" src="catalog/view/theme/prostoseptik/assets/img/cib_vk.png" alt="vk">
								</a>
								<a href="<?php echo $dzen ?>" target="_blank" class="baner-left-social-link">
									<img class="baner-left-social-img" src="catalog/view/theme/prostoseptik/assets/img/Yandex_Zen_logo1.png" alt="zen">
								</a>
								<a href="<?php echo $youtube ?>" target="_blank" class="baner-left-social-link">
									<img class="baner-left-social-img" src="catalog/view/theme/prostoseptik/assets/img/fa_youtube-square.png" alt="fa_youtube">
								</a>
								<a href="<?php echo $rutube ?>" target="_blank" class="baner-left-social-link">
									<img class="baner-left-social-img" src="catalog/view/theme/prostoseptik/assets/img/rutubelogo.png" alt="rutube">
								</a>
							</div>
						</div>
						<div class="baner-right">
							<img class="baner-right-img" src="<?php echo $poster['thumb'] ?>" alt="picture">
							<img class="baner-img" src="<?php echo $poster['thumb_mobile'] ?>" alt="Rectangle139">
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="container__bottom">
				<div class="swiper-button-prev">
					<img src="catalog/view/theme/prostoseptik/assets/img/ep_arrow-right.png" alt="previus">
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next">
					<img src="catalog/view/theme/prostoseptik/assets/img/ep_arrow-right1.png" alt="next">
				</div>
			</div>
		</div>
		<div class="modal">
			<form id="main-top-form" class="form-order">
				<p class="title center">Оставьте свои данные, и мы свяжемся с вами</p>
				<input class="input-name" type="text" name="name" id="main-top-form-name" placeholder="Имя" required="">
				<input class="input-tel" type="tel" name="phone" id="main-top-form-phone" placeholder="Номер телефона" required="">
				<label class="label-checkbox" for="checkbox">
					<input class="input-checkbox" type="checkbox" name="checkbox" id="checkbox">
					Согласен на обработку персональных данных.
				</label>
				<div id="main-top-form-error" style="display: none; color: red;"></div>
				<button id="main-top-form-btn" onclick="helpFormSubmit('<?= $action; ?>', 'main-top-form', 'main-top-form-error', 'main-top-form-name', 'main-top-form-phone')" type="button" class="button" disabled="">Оставить</button>
				<button class="button-close">×</button>
			</form>
		</div>
		<div class="content wrapper_grey">
			<div class="content__text">
				<p class="textblock-text">Основной проблемой владельцев земельных участков, отдаленных от центрального канализационного трубопровода, является
															                    создание производительной и надежной автономной канализации. Сделать это невозможно без постоянного водоснабжения,
															                    которое можно обеспечить из пробуренной на участке скважины. В первом случае потребуется установка септика, а для
															                    бурения скважины придется нанять бригаду мастеров и арендовать спецтехнику. Вообще, такие проблемы лучше решать
															                    комплексно, в соответствии с действующими санитарно-экологическими и строительными нормами. А предоставить подобные
															                    услуги сможет специализированная компания Простосептик (pro100septik.ru), занимающаяся профессиональной установкой
															                    локально-очистных станций, а также бурением и обустройством скважин.
				</p>
			</div>
			<img src="catalog/view/theme/prostoseptik/assets/img/img500.webp" alt="prostoseptik" class="content__img">
		</div>
	</div>
</div>
