<!DOCTYPE html>
<html lang="ru-ru">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/catalog/view/theme/prostoseptik/assets/css/fonts/fonts.css">
		<link rel="stylesheet" href="/catalog/view/theme/prostoseptik/assets/css/swiper.css">
		<link rel="stylesheet" href="/catalog/view/theme/prostoseptik/assets/css/styles.css?ver=1.0.0">
		<link rel="shortcut icon" href="/catalog/view/theme/prostoseptik/assets/img/favicon/favicon.ico" type="image/x-icon">
		<title><?php echo $title; ?></title>
		<?php if ($description) { ?>
			<meta name="description" content="<?php echo $description; ?>"/>
		<?php } ?>
		<?php if ($keywords) { ?>
			<meta name="keywords" content="<?php echo $keywords; ?>"/>
		<?php } ?>
		<?php foreach ($styles as $style) { ?>
			<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>"/>
		<?php } ?>
		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
		<?php } ?>
		<script src="/catalog/view/javascript/jquery/jquery-2.1.1.min.js"></script>
		<?php foreach ($scripts as $script) { ?>
			<script src="<?php echo $script; ?>"></script>
		<?php } ?>
		<?php foreach ($analytics as $analytic) { ?>
			<?php echo $analytic; ?>
		<?php } ?>

		<script src="/catalog/view/javascript/common.js" type="text/javascript"></script>
		<script src="/catalog/view/theme/prostoseptik/assets/js/ajax.js" defer></script>
		<base href="<?php echo $base; ?>"/>
	</head>
	<body>
		<div class="wrapper header__container">
			<div class="container">
				<header class="header container__screen">
					<div class="header__logo">
						<a class='header__logo-link' href="/">
							<img class="logo header__logo-img" src="/catalog/view/theme/prostoseptik/assets/img/logo.png" alt="logo">
						</a>
					</div>
					<div class="header__menu">
						<div class="header__menu-list">
							<a href="<?= $header_septic_url; ?>" class="header__menu-list-item">Каталог септиков</a>
							<div class="header__menu-list-item water">
								<span>
									Водоснабжение
									<img class="arrow-down" src="/catalog/view/theme/prostoseptik/assets/img/arrow-down-bold.png" alt="arrow-down-bold">
									<img class="arrow-up" src="/catalog/view/theme/prostoseptik/assets/img/arrow.png" alt="arrow">
								</span>
								<ul class="water-list">
									<li>
										<a href="<?php echo $borehole_href ?>" class="water__hide-link">Скважина на воду</a>
									</li>
									<li>
										<a href="<?php echo $well_href ?>" class="water__hide-link">Колодец для дома</a>
									</li>
									<li>
										<a href="<?php echo $water_href ?>" class="water__hide-link">Завод воды в дом</a>
									</li>
								</ul>
							</div>
							<div class="header__menu-list-item portfolio">
								<span>
									Портфолио
									<img class="arrow-down" src="/catalog/view/theme/prostoseptik/assets/img/arrow-down-bold.png" alt="arrow-down-bold">
									<img class="arrow-up" src="/catalog/view/theme/prostoseptik/assets/img/arrow.png" alt="arrow">
								</span>
								<ul class="portfolio-list">
									<li>
										<a href="<?php echo $photo_href; ?>" class="water__hide-link">Фото</a>
									</li>
									<li>
										<a href="<?php echo $video_href; ?>" class="water__hide-link">Видео</a>
									</li>
								</ul>
							</div>
							<a href="<?php echo $contact_href ?>" class="header__menu-list-item">Контакты</a>
							<a href="<?php echo $blog_href ?>" class="header__menu-list-item">Новости</a>
							<div class="footer__contacts-social-list">
								<a href="<?php echo $vk ?>" target="_blank" class="footer__contacts-social-list-item"><img class="footer__contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/cib_vk.png" alt="vk">
								</a>
								<a href="<?php echo $dzen ?>" target="_blank" class="footer__contacts-social-list-item"><img class="footer__contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/Yandex_Zen_logo1.png" alt="Yandex_Zen_logo">
								</a>
								<a href="<?php echo $youtube ?>" target="_blank" class="footer__contacts-social-list-item"><img class="footer__contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/fa_youtube-square.png" alt="youtube">
								</a>
								<a href="<?php echo $rutube ?>" target="_blank" class="footer__contacts-social-list-item"><img class="footer__contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/rutubelogo.png" alt="rutube">
								</a>
							</div>
							<?php if($request_uri == '/'): ?>
							<div class="header__menu-discount">
								<img class="header__menu-discount-img" src="/catalog/view/theme/prostoseptik/assets/img/Frame4.png" alt="discount_img">
								<p class="header__menu-discount-text">Скидка 10%</p>
							</div>
							<?php endif; ?>
						</div>
						<?php if($request_uri == '/'): ?>
						<div class="header__menu-discount">
							<img class="header__menu-discount-img" src="/catalog/view/theme/prostoseptik/assets/img/Frame4.png" alt="discount_img">
							<p class="header__menu-discount-text">Скидка 10%</p>
						</div>
						<?php endif; ?>
						<button class="header__menu-search">
							<img class="header__menu-search-img" src="/catalog/view/theme/prostoseptik/assets/img/bx_search.png" alt="search_img">
							<img class="header__menu-search-close" src="/catalog/view/theme/prostoseptik/assets/img/ep_close.png" alt="ep_close">
						</button>
						<form class="search" id="search-form">
							<input class="search-input" type="search" name="search" id="search" placeholder="Поиск">

							<button class="search-form-btn" id="search-form-btn" type="button"><img class="" src="/catalog/view/theme/prostoseptik/assets/img/search.png" alt="search"></button>
						</form>
						<button class="header__menu-cart">
							<img class="header__menu-cart-img" src="/catalog/view/theme/prostoseptik/assets/img/Cart.png" alt="cart_img">
							<span id="header-products-count" class="header__menu-cart-count"><?php echo $products_count; ?></span>
						</button>
						<a href="javascript:void(0)" class="burger">
							<span></span>
						</a>
					</div>
				</header>

				<?php if($request_uri == '/'): ?>
				<div class="header__menu-discount discount__hide">
					<img class="header__menu-discount-img" src="/catalog/view/theme/prostoseptik/assets/img/Frame4.png" alt="discount_img">
					<p class="header__menu-discount-text">Скидка 10%</p>
				</div>
				<?php endif; ?>
				<div
					class="cart-modal">
					<!-- Корзина -->
					<p class="title">Корзина</p>

					<div class="cart-wrap-row" id="cart-header">
						<?php foreach($products as $product): ?>
						<div class="cart-wrap-block">
							<div class="product-thumbnail">
								<a href="<?php echo $product['href'] ?>"><img loading="lazy" class="product-thumbnail-img" src="<?php echo $product['thumb'] ?>" alt="Rectangle"></a>
							</div>
							<div class="cart-wrap-block-name">
								<span class="product-name">
									<a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a>
								</span>
								<span class="product-price"><?php echo $product['total'] ?></span>
							</div>
							<div class="product-quantity">
								<span class="minus" onclick="cart.updateSubmit('<?php echo $product['cart_id']; ?>', this)">-</span>
								<input id="1" type="number" class="quantity" value="<?php echo $product['quantity'] ?>">
								<span class="plus" onclick="cart.updateSubmit('<?php echo $product['cart_id']; ?>', this)">+</span>
							</div>
							<button onclick="cart.remove('<?php echo $product['cart_id']; ?>');" class="remove">&times;</button>
						</div>
						<?php endforeach; ?>
					</div>

					<div class="order-total">
						<div><?php echo $total_price['title']; ?>:&nbsp;</div>
						<div id="cart-header-total" data-title="Total">
							<strong>
								<span class="woocommerce-Price-amount amount"><?php echo $total_price['value']; ?>
									₽</span>
							</strong>
						</div>
					</div>
					<a href="<?php echo $cart_href ?>" class="continue">Продолжить</a>
					<a href="javascript:void(0)" class="back">
						<img src="/catalog/view/theme/prostoseptik/assets/img/bi_arrow-left-short.png" alt="bi_arrow-left-short">вернуться назад
					</a>
				</div>
			</div>
			<div class="water__hide">
				<div class="water__hide-menu">
					<a href="<?php echo $borehole_href ?>" class="water__hide-menu-item" style="background-image: url('/catalog/view/theme/prostoseptik/assets/img/1.webp')">
						<p class="water__hide-menu-item-title">Скважина на воду</p>
					</a>
					<a href="<?php echo $well_href ?>" class="water__hide-menu-item" style="background-image: url('/catalog/view/theme/prostoseptik/assets/img/2.webp')">
						<p class="water__hide-menu-item-title">Колодец для дома</p>
					</a>
					<a href="<?php echo $water_href ?>" class="water__hide-menu-item" style="background-image: url('catalog/view/theme/prostoseptik/assets/img/3.webp')">
						<p class="water__hide-menu-item-title">Завод воды в дом</p>
					</a>
				</div>
			</div>
			<div class="portfolio__hide">
				<div class="portfolio__hide-menu">
					<a href="<?php echo $photo_href; ?>" class="portfolio__hide-menu-item" style="background-image: url('catalog/view/theme/prostoseptik/assets/img/pic4.png')">
						<p class="water__hide-menu-item-title">фото</p>
					</a>
					<a href="<?php echo $video_href; ?>" class="portfolio__hide-menu-item" style="background-image: url('catalog/view/theme/prostoseptik/assets/img/pic5.png')">
						<p class="water__hide-menu-item-title">Видео</p>
					</a>
				</div>
			</div>
		</div>
		<!--end header-->
		<main class="main<?= $request_uri == '/' ? ' main__head' : '' ?>">
