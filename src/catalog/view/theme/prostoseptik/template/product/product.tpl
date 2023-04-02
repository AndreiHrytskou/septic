<?php echo $header; ?>
<div class="wrapper">
  <div class="container container__screen">
    <div class="bread-band" itemscope="" itemtype="http://schema.org/BreadcrumbList">
      <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <?php for ($i = 0; $i < count($breadcrumbs); $i++) { ?>
        <?php if($i == 0):?>
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

<div class="wrapper">
  <div class="container container__screen">
    <div class="product-headbaner" id="product">
      <div class="swiper-container-wrapper">
        <div class="swiper-container gallery-thumbs">
          <div class="swiper-wrapper">
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <div class="swiper-slide">
              <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $heading_title; ?>">
            </div>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div class="swiper swiper-container gallery-top">
          <div class="swiper-wrapper">
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <div class="swiper-slide">
              <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $heading_title; ?>">
            </div>
            <?php } ?>
            <?php } ?>
          </div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

      <div class="product-descriptions">
        <div class="product-descriptions-top">
          <p class="product-title"><?php echo $heading_title; ?></p>
          <div class="price-block">
            <?php if (!$special) { ?>
            <span class="price" data-value="100"><?php echo $price; ?></span>
            <?php } else { ?>
            <span class="price" data-value="100"><?php echo $special; ?></span>
            <span class="before-price"><?php echo $price; ?></span>
            <?php } ?>
          </div>
          <?php if ($options) { ?>
          <?php foreach($options as $option) { ?>
          <?php if ($option['type'] == 'radio') { ?>
          <div class="choice" id="input-option<?php echo $option['product_option_id']; ?>">
            <?php $num = 0; ?>
              <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <label class="price-wrap">
                  <input <?= $num == 0 ? 'checked' : ''; ?> type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>"><?= $option_value['name']; ?>
                </label>
              <?php $num++; ?>
              <?php } ?>
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>

          <input type="hidden" name="quantity" value="<?php echo $minimum; ?>" id="input-quantity" class="form-control" />
          <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
          <div class="product-descriptions-top-btn">
            <button onclick="cart.add('<?php echo $product_id ?>', '<?php echo $minimum; ?>');" class="product-descriptions-top-btn-item">купить</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="container container__screen">
    <div class="characteristic wrapper_grey">
      <h3 class="title">Характеристики</h3>
      <div class="characteristic-wrap">
        <?php if ($attribute_groups): ?>
        <?php foreach ($attribute_groups as $attribute_group): ?>
        <div class="characteristic-wrap-list">
          <?php foreach ($attribute_group as $attribute): ?>
          <div class="characteristic-wrap-list-item">
            <div class="characteristic-wrap-list-item-left">
              <img src="<?= isset($attribute['icon']['thumb']) ? $attribute['icon']['thumb'] : 'catalog/view/theme/prostoseptik/assets/img/1.png' ?>" alt="1">
              <p><?php echo $attribute['name']; ?></p>
            </div>
            <div class="characteristic-wrap-list-item-right">
              <p><?php echo $attribute['text']; ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($description)): ?>
<div class="wrapper">
  <div class="container container__screen">
    <div class="textblock wrapper_grey">
      <h3 class="title"><?php echo $tab_description; ?></h3>
      <div class="section-text">
        <?php echo $description; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="wrapper">
  <div class="container container__screen">
    <div class="textblock wrapper_grey">
      <?php if(!empty($advantages)): ?>
        <h3 class="title"><?php echo $tab_advantages; ?></h3>
        <div class="section-text">
          <?php echo $advantages; ?>
        </div>
        <?php endif; ?>
        <?php echo $content_top; ?>

    </div>
  </div>
</div>

<!-- autocalc_price_option_pro v3.1.0 -->
<script defer>
  var autocalc_aap = function (s,p,ff){$(s).each(function(){var $t=$(this);$({value:$t.data('value')||0}).animate({value:p},{easing:'swing',duration:500,step:function(value){$t.html(ff(value));$t.data('value',value);}});});};
  var price_format = function (price){
    c = <?php echo (empty($autocalc_currency['decimals']) ? "0" : $autocalc_currency['decimals'] ); ?>;
    d = '<?php echo $autocalc_currency['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $autocalc_currency['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_left']); ?>';
    s_right = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_right']); ?>';
    n = price * <?php echo $autocalc_currency['value']; ?>;
    i = parseInt(n = Math.abs(n).toFixed(c)) + '';
    j = ((j = i.length) > 3) ? j % 3 : 0;
    price_text = s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right;
    <?php if (!empty($autocalc_currency2)) { ?>
      c = <?php echo (empty($autocalc_currency2['decimals']) ? "0" : $autocalc_currency2['decimals'] ); ?>;
      d = '<?php echo $autocalc_currency2['decimal_point']; ?>'; // decimal separator
      t = '<?php echo $autocalc_currency2['thousand_point']; ?>'; // thousands separator
      s_left = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_left']); ?>';
      s_right = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_right']); ?>';
      n = price * <?php echo $autocalc_currency2['value']; ?>;
      i = parseInt(n = Math.abs(n).toFixed(c)) + '';
      j = ((j = i.length) > 3) ? j % 3 : 0;
      price_text += '  <span class="currency2">(' + s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right + ')</span>';
      <?php } ?>
    return price_text;
  };
  <?php if (!empty($tax)) { ?>
    function calculate_tax(price) {<?php foreach($tax_rates as $tax_rate){if($tax_rate['type']=='F'){echo 'price+='.$tax_rate['rate'].';';}elseif($tax_rate['type']=='P'){echo 'price+=(price*'.$tax_rate['rate'].')/100.0;';}}?>return price;}
  <?php } ?>
  var process_discounts = function(price, quantity) {<?php foreach ($dicounts_unf as $discount) {echo 'if ((quantity >= '.$discount['quantity'].') && ('.$discount['price'].' < price)) price = '.$discount['price'].';'."\n";}?>return price;};
  var recalculateprice = function() {
    var main_price = <?php echo (float)$price_value; ?>;
    var input_quantity = Number($('input[name="quantity"]').val())||0;
    var special = <?php echo (float)$special_value; ?>;
    var tax = 0;
    var discount_coefficient = 1;
    var special_coefficient = 1;
    var option_price = 0;
    var $so = $('input[type="hidden"][name^="option"],input[name^="option"]:checked,select[name^="option"] option:selected');

    if (input_quantity < 1) input_quantity = 1;

    <?php if ($special) { ?>
      special_coefficient = <?php echo ((float)$price_value/(float)$special_value); ?>;
      <?php } else { ?>
    <?php if (empty($autocalc_option_discount)) { ?>
        main_price = process_discounts(main_price, input_quantity);
        tax = process_discounts(tax, input_quantity);
        <?php } else { ?>
        if (main_price) discount_coefficient = process_discounts(main_price, input_quantity) / main_price;
        <?php } ?>
    <?php } ?>

  <?php if ($points) { ?>
      var points = <?php echo (float)$points_value; ?>;
      $so.each(function() {
        if ($(this).data('points')) points += Number($(this).data('points'));
      });
      $('.autocalc-product-points').html(points);
      <?php } ?>

    $so.each(function() {
      if ($(this).data('prefix') == '=') {
        option_price += Number($(this).data('price'));
        main_price = 0;
        special = 0;
      }
    });

    $so.each(function() {
      if ($(this).data('prefix') == '+') {
        option_price += Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '-') {
        option_price -= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '%') {
        pcnt = 1.0 + (Number($(this).data('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).data('prefix') == '*') {
        option_price *= Number($(this).data('price'));
        main_price *= Number($(this).data('price'));
        special *= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '/') {
        option_price /= Number($(this).data('price'));
        main_price /= Number($(this).data('price'));
        special /= Number($(this).data('price'));
      }
    });

    special += option_price;
    main_price += option_price;

    <?php if ($special) { ?>
    <?php if (empty($autocalc_option_special))  { ?>
        main_price = special * special_coefficient;
        <?php } else { ?>
        special = main_price / special_coefficient;
        <?php } ?>
      tax = special;
      <?php } else { ?>
    <?php if (!empty($autocalc_option_discount)) { ?>
        main_price *= discount_coefficient;
        <?php } ?>
      tax = main_price;
      <?php } ?>

  <?php if (!empty($tax)) { ?>
      // Process TAX.
      main_price = calculate_tax(main_price);
      special = calculate_tax(special);
      <?php } ?>

  <?php if (!$autocalc_not_mul_qty) { ?>
      if (input_quantity > 0) {
        main_price *= input_quantity;
        special *= input_quantity;
        tax *= input_quantity;
      }
      <?php } ?>

    autocalc_aap($('.autocalc-product-price'), main_price, price_format);
    <?php if ($special) { ?>
      autocalc_aap($('.autocalc-product-special'), special, price_format);
      <?php } ?>
  };

  $(document).ready(function(){
    $('input[name^="option"],select[name^="option"]').on('change', function() { recalculateprice(); });

    (function($quantity){
      $quantity.data('val', $quantity.val());
      (function() {
        if ($quantity.val() != $quantity.data('val')){
          $quantity.data('val',$quantity.val());
          recalculateprice();
        }
        setTimeout(arguments.callee, 250);
      })();
    })($('input[name="quantity"]'));

    <?php if ($autocalc_select_first) { ?>
      $('select[name^="option"] option[value=""]').remove();
      last_name = '';
      $('input[type="radio"][name^="option"]').each(function(){
        if ($(this).attr('name') != last_name) $(this).prop('checked', true);
        last_name = $(this).attr('name');
      });
      <?php } ?>

    recalculateprice();
  });
</script>

<?php echo $content_bottom; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<?php echo $footer; ?>
