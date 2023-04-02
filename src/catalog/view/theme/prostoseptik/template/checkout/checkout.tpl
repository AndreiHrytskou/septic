<?php echo $header; ?>
<div class="wrapper">
  <div class="container container__screen">
    <h1 class="checkout page-title title__indent-top">Оформление заказа</h1>
  </div>
</div>
<div class="wrapper">
  <div class="container">
    <div class="order">
      <form id="checkout_form" class="order-form">
        <p class="title center">Ваши контактные данные</p>
        <div class="order-top">
          <div class="order-data">
            <div class="order-input">
              <label class="label" for="name">Имя и Фамилия<span class="label__red">*</span></label>
              <input name="firstname" class="input" type="text" id="name" required>
            </div>
            <div class="order-input">
              <label class="label" for="phone">Номер телефона<span class="label__red">*</span></label>
              <input name="telephone" class="input" type="tel" id="phone" value="" required>
            </div>
            <div class="order-input">
              <label class="label" for="email">Email<span class="label__red">*</span></label>
              <input name="email" class="input" type="email" id="email" required>
            </div>
          </div>
          <div class="order-input">
            <label class="label" for="note">Примечание к заказу (необязательно)</label>
            <textarea class="note" name="comment" id="note" placeholder="Например, особые пожелания к отделу доставки"></textarea>
          </div>
        </div>
        <div class="order-middle">
          <div class="order-input">
            <label class="label" for="region">Область/регион<span class="label__red">*</span></label>
            <input name="zone" class="input" type="text" id="region" required>
          </div>
          <div class="order-input">
            <label class="label" for="city">Населённый пункт<span class="label__red">*</span></label>
            <input name="city" class="input" type="text" id="city" required>
          </div>
          <div class="order-input">
            <label class="label" for="address">Адрес<span class="label__red">*</span></label>
            <input name="address_1" class="input" type="text" id="address" required placeholder="Номер дома и название улицы">
          </div>
          <div class="order-input">
            <label class="label" for="apartament">Квартира, апартаменты, жилое помещение и т. д. (необязательно)</label>
            <input name="apartament" class="input" type="text" id="apartament" >
          </div>
          <div class="date">
            <p class="date-title">Дата доставки<span class="label__red">*</span></p>
            <div class="date-wrap">
              <div class="date-day">
                <div class="date-input date_day"><p class="date_day_text">Число</p>
                  <img class="day-img" src="/catalog/view/theme/prostoseptik/assets/img/arrow-down-bold.png" alt="arrow">
                </div>
                <ul class="date-day-list day">
                  <?php foreach($date['days'] as $day): ?>
                  <li class="date-day-list-item"><?= $day ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="date-month">
                <div class="date-input date_month"><p class="date_month_text">Месяц</p>
                  <img class="day-img" src="/catalog/view/theme/prostoseptik/assets/img/arrow-down-bold.png" alt="arrow">
                </div>
                <ul class="date-month-list month">
                  <?php foreach($date['months'] as $day => $value): ?>
                  <li data-month="<?= $day ?>" class="date-month-list-item" ><?= $value ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="date-year">
                <div class="date-input date_year"><p class="date_year_text">Год</p>
                  <img class="day-img" src="/catalog/view/theme/prostoseptik/assets/img/arrow-down-bold.png" alt="arrow">
                </div>
                <ul class="date-year-list year">
                  <?php foreach($date['years'] as $year): ?>
                  <li class="date-year-list-item"><?= $year ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            <input id="input-day" type="hidden" name="day" value="">
            <input id="input-month" type="hidden" name="month" value="">
            <input id="input-month-number" type="hidden" name="month-number" value="">
            <input id="input-year" type="hidden" name="year" value="">
          </div>
        </div>
        <div class="order-bottom">
          <p class="order-title">Оплата</p>
          <div class="payment-method">
            <?php if ($payment_methods) { ?>
            <?php foreach ($payment_methods as $payment_method) { ?>
            <label class="label" for="payment[<?php echo $payment_method['code'] ?>]">
              <div class="payment-method-<?= $payment_method['code'] == 'online' ? 'second' : 'first' ?>">
                <div class="payment-radio">
                  <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" id="payment[<?php echo $payment_method['code'] ?>]" <?= $payment_method['num'] == 0 ? 'checked="checked"' : '' ?>>
                  <?php echo $payment_method['title']; ?>
                </div>
                <?php if($payment_method['code'] == 'online'): ?>
                <span class="payment-radio-img">
                  <img src="/catalog/view/theme/prostoseptik/assets/img/Visa_20211.png" alt="Visa_2021">
                  <img src="/catalog/view/theme/prostoseptik/assets/img/Mastercard-logo1.png" alt="Mastercard">
                  <img src="/catalog/view/theme/prostoseptik/assets/img/Mir-logo.SVG1.png" alt="Mir">
				</span>
                <?php endif; ?>

              </div>
            </label>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
        <div id="error" style="color: red; margin: 20px 0; display: none;"></div>
        <button type="button" class='btn-order' id="button-confirm">оформить заказ</button>
      </form>
      <div class="shop_table">
        <p class="title">Ваш заказ</p>
        <div class="shop_table-wrap">
          <?php foreach($products as $product): ?>
          <div class="cart_item">
            <img src="<?php echo $product['thumb'] ?>" alt="Rectangle" class="cart_item_thumbnail">
            <div class="product-description">
              <p class="product-name">
                <?php echo $product['name'] ?> <span>( <strong><?php echo $product['quantity'] ?></strong>&nbsp;шт&nbsp;)</span>
              </p>
              <div class="product-total">
							<span class="amount"><bdi><?php echo $product['total'] ?>&nbsp;<span
                                        class="currencySymbol">₽</span></bdi></span>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="order-total">
          <span><?php echo $total_price['title']; ?></span>
          <span class="total"><strong><span class="amount"><bdi><?php echo $total_price['text']; ?></bdi></span></strong> </span>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="/catalog/view/theme/prostoseptik/assets/js/checkout.js"></script>
<script>
  $(document).on('click', '#button-confirm', function () {
    let th = $(this);
    th.attr('disabled', 'disabled');
    $.ajax({
      url: 'index.php?route=checkout/checkout/confirm',
      type: 'post',
      dataType: 'json',
      data: $('#checkout_form').serialize(),
      success: function (json) {
        console.log(json)
        th.removeAttr('disabled');
        if (json['success']) {
          location = json['success'];
        }
        if (json['error']) {
          console.log(json['error'])
          $('#error').html(json['error']).fadeIn();
          $('#error').css({ display: "block" });
        }
        // $('.preloader_cart').fadeOut();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr)
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        // $('.text-danger').html('Проверьте все поля!').fadeIn();
        // th.removeAttr('disabled');
      }
    });
  });

</script>
<?php echo $footer; ?>
