<div class="buyers">
	<p class="popular-title center">Выбор покупателей:</p>
	<div class="popular-product">
		<?php foreach ($products as $product) { ?>
		<div class="popular-product__item">
			<div class="popular-product__item-img">
				<a href="<?= $product['href']; ?>"><img class="product-thumbnail-img" src="<?= $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
			</div>
			<div class="popular-product__item-description">
				<a class="product-name" href="<?= $product['href']; ?>">Септик Евролос Эко 3</a>
				<span class="product-price"><?= $product['price']; ?></span>
			</div>
		</div>
		<?php } ?>

	</div>
</div>