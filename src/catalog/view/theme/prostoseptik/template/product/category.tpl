<?php echo $header; ?>
<!--breadcrumb-->
<div class="wrapper">
    <div class="container container__screen">
        <div class="bread-band" itemscope="" itemtype="http://schema.org/BreadcrumbList">
            <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <?php for ($i = 0; $i < count($breadcrumbs); $i++) { ?>
                <?php if ($i == 0): ?>
                <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-link" itemprop="item">
                    <span itemprop="name"><?php echo $breadcrumbs[$i]['text']; ?></span>
                    <meta itemprop="position" content="<?= $i + 1; ?>">
                </a>
                <span class="bread-sep">-</span>
                <?php elseif ($i == count($breadcrumbs) - 1): ?>
                <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
                <?php else: ?>
                <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-before">
                    <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
                </a>
                <span class="bread-sep">-</span>
                <?php endif; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--breadcrumb-->

<?php echo $content_top; ?>

<div class="wrapper">
    <div class="container container__screen">
        <div class="catalog-page-block">
            <div class="sidebar-hide">
                <p>Фильтры</p>
                <img src="/catalog/view/theme/prostoseptik/assets/img/whitetiangle.png" alt="whitetiangle">
            </div>
            <p class="sort">Сортировать:</p>
            <div class="filtr">
                <span class="filtr__item"><?php echo $sorts[0]['text'] ?>></span>
                <img class="filtr__img" src="/catalog/view/theme/prostoseptik/assets/img/bxs_down-arrow.png" alt="arrow">
                <ul name="orderby" class="orderby">
                    <?php foreach ($sorts as $sorts) { ?>
                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                    <li class="orderby__item"><a data-selected="selected" href="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></a></li>
                    <?php } else { ?>
                    <li class="orderby__item"><a href="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></a></li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="wrap">
            <div class="wrap_container">
                <ul id="catalog-list" class="catalog">
                    <?php foreach ($products as $product): ?>
                    <li class="product" data-product-id="<?php echo $product['product_id'] ?>">
                        <a href="<?php echo $product['href']; ?>" class="product-link">
                            <img   src="<?php echo $product['thumb']; ?>"	class="product-img" alt="<?php echo $product['name']; ?>"
                                   loading="lazy">
                            <p class="product__title"><?php echo $product['name']; ?></p>
                        </a>
                        <div class="catalog-textblock">
                            <div class="price-block">
                                <?php if (!$product['special']) { ?>
                                <span class="price" data-price-id="<?php echo $product['product_id']; ?>" data-value="100" data-price-value="<?php echo $product['tax']; ?>"><?php echo $product['tax']; ?></span>
                                <?php } else { ?>
                                <span class="price" data-price-id="<?php echo $product['product_id']; ?>" data-value="100" data-price-value="<?php echo $product['special']; ?>"><?php echo $product['special']; ?></span>
                                <span class="before-price"><?php echo $product['price']; ?></span>
                                <?php } ?>
                            </div>
                                <?php if(isset($product['options']) && count($product['options']) > 0): ?>
                                    <?php foreach($product['options'] as $option) { ?>
                                        <?php if ($option['type'] == 'radio') { ?>
                                        <div onclick="updatePrice(event, this)" data-product-choice-id="<?php echo $product['product_id'] ?>" class="choice" id="input[<?php echo $product['product_id'] ?>]-option<?php echo $option['product_option_id']; ?>">
                                            <?php $num = 0; ?>
                                            <?php foreach ($option['product_option_value'] as $option_value) { ?>
                                            <label class="price-wrap<?= $num == 0 ? ' active-label' : ''; ?>">
                                                <input data-input-product-id="<?php echo $product['product_id'] ?>" <?= $num == 0 ? 'checked' : ''; ?> type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price'] != '' ? $option_value['price'] : "0"; ?>"><?= $option_value['name']; ?>
                                            </label>
                                            <?php $num++; ?>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php endif; ?>
                            <div class="card-descr">
                                <?php foreach ($product['attr'] as $attr): ?>
                                <div class="card-descr-list">
                                    <p class="card-descr-list-title"><?= $attr['name'] ?></p>
                                    <p class="card-descr-list-num"><?= $attr['text'] ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <input type="hidden" name="quantity" value="<?php echo $product['minimum']; ?>" id="input-quantity" class="form-control" />
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>" />
                            <button onclick="cart.categoryAdd('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"	class="card-btn">Купить</button>
                            <a href="<?php echo $product['href']; ?>" class="added_to_cart wc-forward" title="View cart">
                                <img src="/catalog/view/theme/prostoseptik/assets/img/to_cart.png" alt="to_cart">
                                В корзине
                            </a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php if(count($products) > 0): ?>
                <div class="more">
                    <button id="more-btn-category" data-href="<?= $paginate['href']; ?>" data-page="<?= $paginate['page']; ?>" data-total="<?= $paginate['total']; ?>" data-limit="<?= $paginate['limit']; ?>" class="more-btn">Показать еще</button>
                </div>
                <?php else: ?>
                    <h2>Нет товаров</h2>
                <?php endif; ?>
            </div>
            <div class="sidebar">
                <?php echo $column_right; ?>

            </div>
            <?php echo $column_left; ?>
        </div>

    </div>
</div>

<?php echo $content_bottom; ?>
<script src="/catalog/view/theme/prostoseptik/assets/js/sidebar.js"></script>

<script>
    function getNumber(str){
        str = str.replace(/[^0-9]/g, '')
        return Number(str)
    }

    function updatePrice(e, elem){
        let productId = elem.dataset.productChoiceId
        let product = document.querySelector(`.product[data-product-id="${productId}"]`)

        if(e.target.closest('.price-wrap') && e.target.classList.contains('price-wrap')){
            product.querySelectorAll('.choice .price-wrap').forEach((elem)=> {
                elem.classList.remove('active-label')
                elem.querySelector('input').checked = false
            })
            let label = e.target
            label.classList.add('active-label')
            label.querySelector('input').checked = true
            let id = product.dataset.productId
            let price = document.querySelector(`[data-price-id="${id}"]`).dataset.priceValue
            let textPrice = document.querySelector(`[data-price-id="${id}"]`).innerText
            let dataprice = label.querySelector('input').dataset.price

            price = getNumber(price)
            textPrice = getNumber(textPrice)
            nowPrice = price
            dataprice = getNumber(dataprice)

            if(label.querySelector('input').dataset.prefix == '+' && dataprice != 0){
                price = (price + dataprice)
            }else if(label.querySelector('input').dataset.prefix == '='){
                price = dataprice
            }else if(label.querySelector('input').dataset.prefix == '-' && dataprice != 0) {
                price = (price - dataprice)
            }else if(label.querySelector('input').dataset.prefix == '*' && dataprice != 0){
                price = (price * dataprice)
            }else if(label.querySelector('input').dataset.prefix == '/' && dataprice != 0){
                price = (price / dataprice)
            }else if(dataprice == 0){
                price = getNumber(document.querySelector(`[data-price-id="${id}"]`).dataset.priceValue)
            }

            if(nowPrice < price || nowPrice < textPrice || nowPrice > price || nowPrice > textPrice){
                $({numberValue: textPrice}).animate({numberValue: price}, {
                    duration: 500,
                    easing: "linear",
                    step: function(val) {
                        $(`[data-price-id="${id}"]`).text(Math.round(val) + '₽');
                    }
                });
            }else{
                document.querySelector(`[data-price-id="${id}"]`).innerText = price + '₽'
            }
        }
    }
</script>

<?php echo $footer; ?>
