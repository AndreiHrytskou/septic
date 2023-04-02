function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

$(document).ready(function() {
	/* Search */
	$('#search-form-btn').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('#search').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search-page-form-btn').on('click', function() {
		var url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('#search-page-input').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search-page-input').on('keydown', function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			$('#search-page-form-btn').trigger('click');
		}
	});

	$('#search').on('keydown', function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			$('#search-form-btn').trigger('click');
		}
	});
})


var load = false

function removeModalCart(){
	document.querySelector('.modal__product').remove()
	document.querySelector('.background__white').remove()
}

let hideText = function (btn){
	if(btn.dataset.hide == 0){
		btn.innerText = 'Скрыть'
		btn.dataset.hide = 1
	}else{
		btn.innerText = btn.dataset.hideText ? btn.dataset.hideText :'Показать еще'
		btn.dataset.hide = 0
	}

	let elems = btn.parentElement.querySelectorAll('.text-disabled')

	elems.forEach(function (elem){
		elem.classList.toggle('disabled')
	})
}


// Cart add remove functions
var cart = {
	'add': function(product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
			dataType: 'json',
			beforeSend: function() {
			},
			complete: function() {
			},
			success: function(json) {
				const spanBack = document.createElement("div");
				const modalBlock = document.createElement("div");
				const img = document.createElement("img");
				const text = document.createElement("p");
				const toCart = document.createElement("a");
				const toCatalog = document.createElement("a");
				const remove = document.createElement("span");
				modalBlock.className = "modal modal__active modal__product";
				img.className = "modal__img";
				img.src = "/catalog/view/theme/prostoseptik/assets/img/doneicon.png";
				text.className = "title";
				toCart.href = "index.php?route=checkout/cart";
				toCatalog.href = "javascript:void(0)";
				toCatalog.onclick = removeModalCart;
				toCatalog.className = "toCatalog";
				remove.className = "remove";
				document.body.append(modalBlock);
				document.body.append(spanBack);
				modalBlock.append(img);
				modalBlock.append(text);
				modalBlock.append(toCart);
				modalBlock.append(toCatalog);
				modalBlock.append(remove);
				toCart.append("перейти в корзину");
				toCatalog.append("вернуться в каталог");
				remove.append("x");
				toCart.className = "btn";
				text.append("Товар добавлен в корзину");
				spanBack.classList.toggle("background__white");
				spanBack.addEventListener("click", () => {
					spanBack.classList.toggle("background__white");
					modalBlock.remove();
				});
				remove.addEventListener("click", () => {
					spanBack.classList.toggle("background__white");
					modalBlock.remove();
				});
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'categoryAdd' : function(product_id, quantity) {
		console.log(product_id, quantity)
		console.log($(`[data-product-id="${product_id}"] input[type=\'radio\']`))
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $(`[data-product-id="${product_id}"] input[type=\'text\'], [data-product-id="${product_id}"] input[type=\'hidden\'], [data-product-id="${product_id}"] input[type=\'radio\']:checked, [data-product-id="${product_id}"] input[type=\'checkbox\']:checked, [data-product-id="${product_id}"] select, [data-product-id="${product_id}"] textarea`),
			dataType: 'json',
			beforeSend: function() {
			},
			complete: function() {
			},
			success: function(json) {
				$(`#cart-header`).load(`index.php?route=common/header/info #cart-header`);
				$(`#cart-header-total`).load(`index.php?route=common/header/info #cart-header-total`);
				$(`#header-products-count`).load(`index.php?route=common/header/info #header-products-count`);

				const spanBack = document.createElement("div");
				const modalBlock = document.createElement("div");
				const img = document.createElement("img");
				const text = document.createElement("p");
				const toCart = document.createElement("a");
				const toCatalog = document.createElement("a");
				const remove = document.createElement("span");
				modalBlock.className = "modal modal__active modal__product";
				img.className = "modal__img";
				img.src = "/catalog/view/theme/prostoseptik/assets/img/doneicon.png";
				text.className = "title";
				toCart.href = "index.php?route=checkout/cart";
				toCatalog.href = "javascript:void(0)";
				toCatalog.onclick = removeModalCart;
				toCatalog.className = "toCatalog";
				remove.className = "remove";
				document.body.append(modalBlock);
				document.body.append(spanBack);
				modalBlock.append(img);
				modalBlock.append(text);
				modalBlock.append(toCart);
				modalBlock.append(toCatalog);
				modalBlock.append(remove);
				toCart.append("перейти в корзину");
				toCatalog.append("вернуться в каталог");
				remove.append("x");
				toCart.className = "btn";
				text.append("Товар добавлен в корзину");
				spanBack.classList.toggle("background__white");
				spanBack.addEventListener("click", () => {
					spanBack.classList.toggle("background__white");
					modalBlock.remove();
				});
				remove.addEventListener("click", () => {
					spanBack.classList.toggle("background__white");
					modalBlock.remove();
				});
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function() {

			},
			complete: function() {

			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				$(`#cart-header`).load(`index.php?route=common/header/info #cart-header`);
				$(`#cart-header-total`).load(`index.php?route=common/header/info #cart-header-total`);
				$(`#header-products-count`).load(`index.php?route=common/header/info #header-products-count`);

				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {

			},
			complete: function() {

			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				$(`#cart-header`).load(`index.php?route=common/header/info #cart-header`);
				$(`#cart-header-total`).load(`index.php?route=common/header/info #cart-header-total`);
				$(`#header-products-count`).load(`index.php?route=common/header/info #header-products-count`);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'updateSubmit': function(key, elem){
		let input = $(elem).parent('.product-quantity').find('.quantity');
		let quantity = parseInt(input.val());

		if ($(elem).hasClass('minus')) {
			quantity -= 1;
			input.val(quantity);
		}

		if ($(elem).hasClass('plus')) {
			quantity += 1;
			input.val(quantity);
		}

		if (quantity <= 0) {
			quantity = 1;
			input.val(quantity);
		}

		if(load == false){
			$.ajax({
				url: 'index.php?route=checkout/cart/edit',
				type: 'post',
				data: 'key=' + key + '&quantity=' + (typeof (quantity) != 'undefined' ? quantity : 1),
				dataType: 'json',
				beforeSend: function() {
					load = true
				},
				complete: function() {
					load = false
				},
				success: function (json) {
					if (json['success']) {
						$(`#cart-header`).load(`index.php?route=common/header/info #cart-header`);
						$(`#cart-header-total`).load(`index.php?route=common/header/info #cart-header-total`);
						$(`#header-products-count`).load(`index.php?route=common/header/info #header-products-count`);

						$(`#cart-wrap`).load(`index.php?route=checkout/cart/info #cart-wrap`);
						$(`.product-price[data-price="${key}"]`).load(`index.php?route=checkout/cart/info .product-price[data-price="${key}"]`);
						$(`#total_price`).load(`index.php?route=checkout/cart/info #total_price`);
					}

					setTimeout(function () {
						$('.preloader_cart').fadeOut();
					}, 2000)

					load = false
				},
				error: function (xhr, ajaxOptions, thrownError) {
					load = false
					console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

var wishlist = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$('.alert').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				$('#wishlist-total span').html(json['total']);
				$('#wishlist-total').attr('title', json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {

	}
}

var compare = {
	'add': function(product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				console.log(json)
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(1111)
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);