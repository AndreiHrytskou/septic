<div class="popular">
	<p class="popular-title">Популярные товары:</p>
	<div class="popular-product">
		<?php foreach ($products as $product) { ?>
		<div class="popular-product__item">
			<div class="popular-product__item-img">
				<a href="<?= $product['href']; ?>">
					<?php if ($product['thumb']) { ?>
					<img src="<?= $product['thumb']; ?>" class="product-thumbnail-img" alt="<?php echo $product['name']; ?>" loading="lazy">
					<?php } ?>
				</a>
			</div>
			<div class="popular-product__item-description">
				<a class="product-name" href="<?= $product['href']; ?>"><?php echo $product['name']; ?></a>
				<span class="product-price"><?= $product['price']; ?></span>
			</div>
		</div>
		<?php } ?>
	</div>
</div>