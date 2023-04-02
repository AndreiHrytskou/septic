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
    <h1 class="page-title title__indent-top">Контакты</h1>
  </div>
</div>
<div class="wrapper">
  <div class="container">
    <div class="contacts">
      <div class="contacts-block container__screen">
        <ul class="contacts-block-list">
          <?php if($address): ?>
          <li class="contacts-block-list-item">
            <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/ep_map-location.png" alt="ep_map">
            <p class="contacts-block-list-item-text"><?php echo $address ?></p>
          </li>
          <?php endif; ?>
          <?php if($owner): ?>
          <li class="contacts-block-list-item">
            <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/papericon.png" alt="paper">
            <p class="contacts-block-list-item-text"><?php echo $owner ?></p>
          </li>
          <?php endif; ?>
          <?php if($inn): ?>
          <li class="contacts-block-list-item">
            <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/papericon.png" alt="paper">
            <p class="contacts-block-list-item-text"><?php echo $inn ?></p>
          </li>
          <?php endif; ?>
          <?php if($inn): ?>
          <li class="contacts-block-list-item">
            <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/papericon.png" alt="paper">
            <p class="contacts-block-list-item-text"><?php echo $ogrn ?></p>
          </li>
          <?php endif; ?>
          <?php if($telephone): ?>
          <li class="contacts-block-list-item">
            <a href="tel:+7(495)021-25-52" class="contacts-block-list-item-link">
              <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/carbon_phone.png" alt="carbon_phone">
              <p class="contacts-block-list-item-text"><?php echo $telephone ?></p>
            </a>
          </li>
          <?php endif; ?>
          <?php if($company_email): ?>
          <li class="contacts-block-list-item">
            <a href="mailto:zakaz@pro100septik.ru" class="contacts-block-list-item-link">
              <img class="contacts-block-list-item-icon" src="/catalog/view/theme/prostoseptik/assets/img/fluent_mail-16-regular.png" alt="fluent_mail">
              <p class="contacts-block-list-item-text"><?php echo $company_email ?></p>
            </a>
          </li>
          <?php endif; ?>
        </ul>
        <div class="contacts-social">
          <p class="contacts-social-title">Следите за нами:</p>
          <div class="contacts-social-list">
            <?php if($vk): ?>
            <a href="<?php echo $vk ?>" target="_blank" class="footer-right-contacts-social-list-item">
              <img class="footer-right-contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/cib_vk.png" alt="vk">
            </a>
            <?php endif; ?>
            <?php if($dzen): ?>
            <a href="<?php echo $dzen ?>" target="_blank" class="footer-right-contacts-social-list-item">
              <img class="footer-right-contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/Yandex_Zen_logo1.png" alt="Yandex_Zen_logo">
            </a>
            <?php endif; ?>
            <?php if($youtube): ?>
            <a href="<?php echo $youtube ?>" target="_blank" class="footer-right-contacts-social-list-item">
              <img class="footer-right-contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/fa_youtube-square.png" alt="fa_youtube">
            </a>
            <?php endif; ?>
            <?php if($rutube): ?>
            <a href="<?php echo $rutube ?>" target="_blank" class="footer-right-contacts-social-list-item">
              <img class="footer-right-contacts-social-list-item-img" src="/catalog/view/theme/prostoseptik/assets/img/rutubelogo.png" alt="rutube">
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="contacts-map"><iframe src="https://yandex.by/map-widget/v1/-/CCUnj8fHPB" style="position:relative;"></iframe></div>
      </div>
      <form id="help-form" action="index.php?route=information/contact/send" class="contacts-form">
        <p class="title">Форма обратной связи</p>
        <div class="contacts-form-inputs">
          <input minlength="3" maxlength="64" type="text" value="<?php echo $name; ?>" name="name" id="form-name" placeholder="Имя" required>
          <input minlength="3" maxlength="64" type="email" value="<?php echo $email; ?>" name="email" id="form-email" placeholder="E-mail" required>
          <input minlength="3" maxlength="20" data-tel-input type="tel" name="phone" id="form-tel" placeholder="Номер телефона" required>
          <textarea name="comment" id="form-comments" cols="30" rows="6" placeholder="Коментарий:"></textarea>
          <label for="consent"><input type="checkbox" name="consent" id="consent">Согласен на обработку персональных данных.</label>
          <div id="help-form-error" style="color: red; display: none;"></div>
          <button onclick="helpFormSubmit('index.php?route=information/contact/send')" class='form-btn' type="button" disabled>Оставить</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="/catalog/view/theme/prostoseptik/assets/js/contacts.js"></script>

<script src="/catalog/view/theme/prostoseptik/assets/js/phoneinput.js"></script>

<script>
  const inputChecked = document.querySelector("#consent");
  const inputBtn = document.querySelector(".form-btn");
  inputChecked.addEventListener("click", () => {
    inputBtn.toggleAttribute("disabled");
  });

  function modalHide(){
    document.getElementById('thanks-modal').remove()
  }

  function helpFormSubmit(url){

    let inputName = document.getElementById('form-name')
    let inputPhone = document.getElementById('form-tel')
    let inputEmail = document.getElementById('form-email')
    let inputComment = document.getElementById('form-comments')

    if(inputName.value == "" || inputName.value.length < 3){
      document.getElementById('help-form-error').innerText = "Введите имя"
      document.getElementById('help-form-error').style.display = "block"
      return false
    }else if(inputEmail.value == "" || inputEmail.value.length < 6){
      document.getElementById('help-form-error').innerText = "Введите email"
      document.getElementById('help-form-error').style.display = "block"
      return false
    }else if(inputPhone.value == "" || inputPhone.value.length < 5){
      document.getElementById('help-form-error').innerText = "Введите номер телефона"
      document.getElementById('help-form-error').style.display = "block"
      return false
    }

    document.getElementById('help-form-error').innerText = ""
    document.getElementById('help-form-error').style.display = "none"

    let formElem = document.getElementById('help-form')
    let formData = new FormData(formElem)
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url);
    xhr.send(formData)

    xhr.onload = () => {
      let result = xhr.response
      result = JSON.parse(result)
      if(result.error){
        document.getElementById('help-form-error').innerText = result.error
        document.getElementById('help-form-error').style.display = "block"
        return false
      }

      if (result.success){
        console.log(result)
        let html = `<div id="thanks-modal"><div class="thanks"><p class="title center">Спасибо за Ваше обращение!</p><p class="modal-text">В течение дня мы с Вами свяжемся</p><button onclick="modalHide()" class="mobal__btn">Продолжить</button></div>
                            <div class="div-hide"></div></div>`
        document.querySelector('body').insertAdjacentHTML('beforeend', html)

        inputName.value = ""
        inputPhone.value = ""
        inputEmail.value = ""
        inputComment.value = ""
      }
    };

    xhr.onprogress = () => {
      console.log('Загрузка')
    }

    xhr.onerror = () => {
      load = false
      console.log('Ошибка', xhr.status)
    }
  }
</script>

<?php echo $footer; ?>
