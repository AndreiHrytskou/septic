<?php echo $header; ?>
<div class="wrapper" id="cart_page">
  <div class="container">
    <?php if(isset($products) && count($products) > 0) { ?>
    <form class="cart" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
      <h1 class="page-title cart-title">Оформление заказа</h1>
      <div class="cart-wrap">
        <p class="title center">Ваш заказ</p>
        <form action="http://localhost:8100/index.php?route=checkout/cart/edit" class="cart-wrap-table" method="post" enctype="multipart/form-data">
          <div id="cart-wrap">
            <?php foreach ($products as $product) { ?>
            <div class="cart-wrap-block">
              <div class="product-thumbnail">
                <a href="<?php echo $product['href'] ?>"><img class="product-thumbnail-img" src="<?php echo $product['thumb'] ?>" alt="Rectangle"></a>
              </div>
              <div class="cart-wrap-block-name">
                <span class="product-name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></span>
                <span class="product-price" data-price="<?php echo $product['cart_id']; ?>"><?php echo $product['total'] ?></span>
              </div>
              <div class="product-quantity">
                <span class="minus" onclick="cart.updateSubmit('<?php echo $product['cart_id']; ?>', this)">-</span>
                <input onkeyup="cart.updateSubmit('<?php echo $product['cart_id']; ?>', this)" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" type="number" class="quantity">
                <span class="plus" onclick="cart.updateSubmit('<?php echo $product['cart_id']; ?>', this)">+</span>
              </div>
              <div class="product-remove">
                <span onclick="cart.remove('<?php echo $product['cart_id']; ?>');" class="remove">×</span>
              </div>
            </div>
            <?php } ?>
          </div>
        </form>
        <div class="bottom-block">
          <div class="coupon">
            <?php echo $coupon; ?>
          </div>
          <div class="shop_table">
            <div class="order-total">
              <p><?php echo $total_price['title']; ?>:&nbsp;</p>
              <p id="total_price"><strong><?php echo $total_price['value']; ?>₽</strong></p>
            </div>
          </div>
        </div>
        <div class="buttons-block">
          <a href="index.php?route=product/category&path=20" class="back">
            <img src="/catalog/view/theme/prostoseptik/assets//img/bi_arrow-left-short.png" alt="bi_arrow-left-short">вернуться назад
          </a>
          <a href="<?php echo $checkout; ?>" class="proceed">Продолжить</a>
        </div>
      </div>
  </div>
    <?php }else { ?>
      <div class="cart">
        <h1 class="page-title cart-title">Корзина пуста</h1>

        <div class="buttons-block">
          <a href="index.php?route=product/category&path=20" class="back">
            <img src="/catalog/view/theme/prostoseptik/assets//img/bi_arrow-left-short.png" alt="bi_arrow-left-short">вернуться назад
          </a>
        </div>
      </div>
    <?php } ?>
  </form>
</div>
</div>

<?php echo $footer; ?>