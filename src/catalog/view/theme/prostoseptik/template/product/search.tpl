<?php echo $header; ?>

<?php echo $content_top; ?>
<div class="wrapper">
  <div class="container container__screen">
    <h2 class="search__page subtitle center title__indent-top">Результаты поиска</h2>
    <form id="search-page-form" class="search-visible">
      <input class="search-input" type="search" name="search" id="search-page-input" placeholder="Поиск" value="<?php echo $search; ?>">
      <button type="button" class="search-form-btn" id="search-page-form-btn"><img class="" src="/catalog/view/theme/prostoseptik/assets/img/search.png" alt="search"></button>
    </form>
    <div class="catalog-page-block search__name">
      <p class="sort">Найдено:</p>
      <span class="filtr__item"><?php echo isset($count_products) ? $count_products : 0; ?> товаров</span>
    </div>
    <div class="wrap">
      <div class="wrap_container">
        <ul class="catalog">
          <?php foreach ($products as $product): ?>
          <li class="product" data-product-id="<?php echo $product['product_id'] ?>">
            <a href="<?php echo $product['href']; ?>" class="product-link">
              <img   src="<?php echo $product['thumb']; ?>"	class="product-img" alt="Rectangle 154"
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
      </div>
    </div>
  </div>
</div>

<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>
<?php print_r($content_bottom) ?>




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