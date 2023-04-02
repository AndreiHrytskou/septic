<div class="wrapper">
    <div class="container">
        <div class="form">
            <div class="form-left">
                <h2 class="subtitle title__white">Затрудняетесь с выбором септика?</h2>
                <p class="form__text">Оставьте заявку и наши специалисты свяжутся с вами!</p>
                <form id="help-form" class="form-left-form">
                    <input type="text" minlength="3" maxlength="30" name="name" id="name" placeholder="Имя">
                    <input data-tel-input type="tel" minlength="7" maxlength="30" name="phone" id="phone" placeholder="Номер телефона">
                    <div id="help-form-error" style="display: none; color: red;"></div>
                    <input onclick="helpFormSubmit('<?= $action; ?>', 'help-form', 'help-form-error', 'name', 'phone')" id="help-form-btn" class="form-btn" type="button" value="Оставить">
                </form>
            </div>
            <div class="form-right">
                <img src="/catalog/view/theme/prostoseptik/assets/img/img.webp" alt="img">
            </div>
        </div>
    </div>
</div>
