<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCheckoutCheckout extends Controller {
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $data['totals'] = array();

        $total_bonus = 0;

        foreach ($totals as $total) {
            if ($total['code'] == 'sub_total') {
                $total_bonus = (float)$total['value'];
            }

            if($total['code'] == 'total'){
                $total['text'] = $this->currency->format($total['value'], $this->session->data['currency']);
                $data['total_price'] = $total;
            }

            if ($total['value']) {
                $total_text = $this->currency->format($total['value'], $this->session->data['currency']);
            } elseif (isset($total['value_text'])) {
                $total_text = $total['value_text'];
            }

            $data['totals'][] = array(
                'code' => $total['code'],
                'title' => $total['title'],
                'text' => $total_text,
            );
        }

        $data['bonus'] = round($total_bonus * 0.01);
        // Total end

        // Payment Methods
        $payment_method_data = array();

        $results_payment = $this->model_extension_extension->getExtensions('payment');

        $recurring = $this->cart->hasRecurringProducts();

        $num = 0;
        foreach ($results_payment as $result) {
            if ($this->config->get($result['code'] . '_status')) {

                $this->load->model('extension/payment/' . $result['code']);

                if (isset($this->session->data['shipping_method'])) {
                    $payment_info = array_merge($this->session->data['payment_address'], array('shipping_method' => $this->session->data['shipping_method']));
                } else {
//                  $payment_info = $this->session->data['payment_methods'];
                    $payment_info['country_id'] = 0;
                    $payment_info['zone_id'] = 0;
                }

                $method = $this->{'model_extension_payment_' . $result['code']}->getMethod($payment_info, $total);

                if ($method) {

                    if ($recurring) {
                        if (property_exists($this->{'model_extension_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_extension_payment_' . $result['code']}->recurringPayments()) {
                            $payment_method_data[$result['code']] = $method;
                        }
                    } else {
                        $payment_method_data[$result['code']] = $method;
                    }

                    $payment_method_data[$result['code']]['num'] = $num;
                }
            }

            $num++;
        }

        $sort_order_payment = array();

        foreach ($payment_method_data as $key => $value) {
            $sort_order_payment[$key] = $value['sort_order'];
        }

        array_multisort($sort_order_payment, SORT_ASC, $payment_method_data);

        $this->session->data['payment_methods'] = $payment_method_data;
        $data['payment_methods'] = $payment_method_data;

        if (isset($this->session->data['payment_method']['code'])) {
            $data['payment_code'] = $this->session->data['payment_method']['code'];
        } else {
            $data['payment_code'] = '';
        }

        $data['date'] = [];

        $data['date']['days'] = range(1, 31);
        $data['date']['years'] = range(2023, (date("Y") + 4));
        $data['date']['months'] = [1 => 'январь', 2 => 'февраль', 3 => 'март', 4=>'апрель', 5=>'май', 6=>'июнь', 7=>'июль', 8=>'август', 9=>'сентябрь', 10=>'октябрь', 11=>'ноябрь', 12=>'декабрь'];

        // Shipping Methods
//        $method_data = array();
//
//        $this->load->model('extension/extension');
//
//        $results = $this->model_extension_extension->getExtensions('shipping');
//
//        foreach ($results as $result) {
//            if ($this->config->get($result['code'] . '_status')) {
//                $this->load->model('extension/shipping/' . $result['code']);
//
//                $quote = $this->{'model_extension_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);
//
//                if ($quote) {
//                    $method_data[$result['code']] = array(
//                        'title' => $quote['title'],
//                        'quote' => $quote['quote'],
//                        'sort_order' => $quote['sort_order'],
//                        'error' => $quote['error']
//                    );
//                }
//            }
//        }
//
//        $sort_order = array();
//
//        foreach ($method_data as $key => $value) {
//            $sort_order[$key] = $value['sort_order'];
//        }
//
//        array_multisort($sort_order, SORT_ASC, $method_data);
//
//        $this->session->data['shipping_methods'] = $method_data;
//        $data['shipping_methods'] = $method_data;
//
//        print_r($data['shipping_methods']);
//
//        if (isset($this->session->data['shipping_method']['code'])) {
//            $data['shipping_code'] = $this->session->data['shipping_method']['code'];
//            $shipping = explode('.', $data['shipping_code']);
//            $data['shipping_form'] = $this->load->controller('extension/shipping/' . $shipping[0]);
//        } else {
//            $data['shipping_code'] = '';
//            $data['shipping_form'] = '';
//        }


        // Validate minimum quantity requirements.
		$products = $this->cart->getProducts();
        $this->load->model('tool/image');

		foreach ($products as $product) {
			$product_total = 0;
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}

            if ($product['image']) {
                $product['thumb'] = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
            } else {
                $product['thumb'] = '';
            }

            $data['products'][] = $product;
        }

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/burger.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/swiper.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/firstswiper.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/search.js');

		// Required by klarna
		if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_checkout_option'] = sprintf($this->language->get('text_checkout_option'), 1);
		$data['text_checkout_account'] = sprintf($this->language->get('text_checkout_account'), 2);
		$data['text_checkout_payment_address'] = sprintf($this->language->get('text_checkout_payment_address'), 2);
		$data['text_checkout_shipping_address'] = sprintf($this->language->get('text_checkout_shipping_address'), 3);
		$data['text_checkout_shipping_method'] = sprintf($this->language->get('text_checkout_shipping_method'), 4);
		
		if ($this->cart->hasShipping()) {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 5);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 6);
		} else {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 3);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 4);	
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/checkout', $data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

    public function confirm()
    {

        if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
            $this->response->redirect($this->url->link('checkout/cart'));
        }

        $this->load->language('checkout/checkout');

        $json = array();

        if (!isset($this->request->post['payment_method']) && !isset($this->session->data['payment_methods']) && !isset($this->session->data['payment_method'])) {
            $json['error'] = $this->language->get('error_payment');
        }

        if(isset($this->request->post['day']) && isset($this->request->post['month']) && isset($this->request->post['year'])){
            if(mktime(12, 00, 00, (int) $this->request->post['month-number'], (int) $this->request->post['day'], (int) $this->request->post['year']) < time()){
                $json['error'] = $this->language->get('error_date');
            }
        }

        if (!isset($this->request->post['year']) || empty($this->request->post['year'])) {
            $json['error'] = $this->language->get('error_year');
        }

        if (!isset($this->request->post['month']) || empty($this->request->post['month'])) {
            $json['error'] = $this->language->get('error_month');
        }

        if (!isset($this->request->post['day']) || empty($this->request->post['day'])) {
            $json['error'] = $this->language->get('error_day');
        }

        if(!isset($this->request->post['address_1']) || (utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)){
            $json['error'] = $this->language->get('error_address_1');
        }

        if(!isset($this->request->post['city']) || (utf8_strlen($this->request->post['city']) < 3) || (utf8_strlen($this->request->post['city']) > 40)){
            $json['error'] = $this->language->get('error_city');
        }

        if (isset($this->request->post['apartament']) || !empty($this->request->post['apartament'])) {
            $this->request->post['address_1'] = $this->request->post['address_1'] . ', дом/квартира: ' . $this->request->post['apartament'];
        }

        if(!isset($this->request->post['zone']) || (utf8_strlen($this->request->post['zone']) < 3) || (utf8_strlen($this->request->post['zone']) > 60)){
            $json['error'] = $this->language->get('error_zone');
        }

        if ((utf8_strlen($this->request->post['email']) < 2) || (utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
            $json['error'] = $this->language->get('error_email');
        }

        if ((utf8_strlen($this->request->post['telephone']) < 15) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $json['error'] = $this->language->get('error_telephone');
        }

        if ((utf8_strlen(trim($this->request->post['firstname'])) < 3) || (utf8_strlen(trim($this->request->post['firstname'])) > 255)) {
            $json['error'] = $this->language->get('error_firstname');
        }

        if ((utf8_strlen(trim($this->request->post['firstname'])) < 3) || (utf8_strlen(trim($this->request->post['firstname'])) > 255)) {
            $json['error'] = $this->language->get('error_firstname');
        }



        if (!isset($json['error'])) {
            $order_data = array();

            $totals = array();
            $taxes = $this->cart->getTaxes();
            $total = 0;

            $total_data = array(
                'totals' => &$totals,
                'taxes' => &$taxes,
                'total' => &$total
            );

            $this->load->model('extension/extension');

            $sort_order = array();

            $results = $this->model_extension_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get($result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);

            $order_data['totals'] = $totals;

            $order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
            $order_data['store_id'] = $this->config->get('config_store_id');
            $order_data['store_name'] = $this->config->get('config_name');

            if ($order_data['store_id']) {
                $order_data['store_url'] = $this->config->get('config_url');
            } else {
                if ($this->request->server['HTTPS']) {
                    $order_data['store_url'] = HTTPS_SERVER;
                } else {
                    $order_data['store_url'] = HTTP_SERVER;
                }
            }

            if ($this->request->post['firstname']) {
                $order_data['payment_firstname'] = $this->request->post['firstname'];
            } else {
                $order_data['payment_firstname'] = '';
            }
            $order_data['payment_lastname'] = '';
            $order_data['payment_company'] = '';
            $order_data['payment_address_1'] = '';
            $order_data['payment_address_2'] = '';
            $order_data['payment_city'] = '';
            $order_data['payment_postcode'] = '';
            $order_data['payment_zone'] = '';
            $order_data['payment_zone_id'] = '';
            $order_data['payment_country'] = '';
            $order_data['payment_country_id'] = '';
            $order_data['payment_address_format'] = '';
            $order_data['payment_custom_field'] = '';

//            if (isset($this->session->data['payment_method']) && isset($this->session->data['payment_method']['title'])) {
//                $order_data['payment_method'] = $this->session->data['payment_method']['title'];
//            } else {
//                $order_data['payment_method'] = '';
//            }
//            if (isset($this->session->data['payment_method']) && isset($this->session->data['payment_method']['code'])) {
//                $order_data['payment_code'] = $this->session->data['payment_method']['code'];
//            } else {
//                $order_data['payment_code'] = '';
//            }

            if (isset($this->request->post['payment_method']) && isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
                $order_data['payment_code'] = $this->request->post['payment_method'];
                $order_data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']]['title'];
            } else {
                $order_data['payment_code'] = '';
                $order_data['payment_method'] = '';
            }
//            if (isset($this->session->data['payment_method']) && isset($this->session->data['payment_method']['code'])) {
//                $order_data['payment_code'] = $this->session->data['payment_method']['code'];
//            } else {
//                $order_data['payment_code'] = '';
//            }

            if ($this->request->post['firstname']) {
                $order_data['shipping_firstname'] = $this->request->post['firstname'];
            } else {
                $order_data['shipping_firstname'] = '';
            }
            $order_data['shipping_lastname'] = '';
            $order_data['shipping_company'] = '';

            if (isset($this->request->post['city']) && $this->request->post['city']) {
                $order_data['shipping_city'] = $this->request->post['city'];
                $order_data['payment_city'] = $this->request->post['city'];
            } else {
                $order_data['shipping_city'] = '';
                $order_data['payment_city'] = '';
            }

            if (isset($this->request->post['address_1']) && $this->request->post['address_1']) {
                $order_data['shipping_address_1'] = $this->request->post['address_1'];
                $order_data['payment_address_1'] = $this->request->post['address_1'];
            } else {
                $order_data['shipping_address_1'] = '';
                $order_data['payment_address_1'] = '';
            }

            if (isset($this->request->post['postcode']) && $this->request->post['postcode']) {
                $order_data['shipping_postcode'] = $this->request->post['postcode'];
            } else {
                $order_data['shipping_postcode'] = '';
            }

            if (isset($this->request->post['house']) && $this->request->post['house']) {
                $order_data['shipping_address_2'] = $this->request->post['house'];
            } else {
                $order_data['shipping_address_2'] = '';
            }

            $order_data['shipping_zone'] = '';
            $order_data['shipping_zone_id'] = '';
            $order_data['shipping_country'] = '';
            $order_data['shipping_country_id'] = '';
            $order_data['shipping_address_format'] = '';
            $order_data['shipping_custom_field'] = '';

            if (isset($this->request->post['zone']) && $this->request->post['zone']) {
                $order_data['shipping_zone'] = $this->request->post['zone'];
                $order_data['payment_zone'] = $this->request->post['zone'];
            } else {
                $order_data['shipping_zone'] = '';
                $order_data['payment_zone'] = '';
            }

            if (isset($this->session->data['shipping_method']) && isset($this->session->data['shipping_method']['title'])) {
                $order_data['shipping_method'] = $this->session->data['shipping_method']['title'];
            } else {
                $order_data['shipping_method'] = '';
            }

            if (isset($this->session->data['shipping_method']) && isset($this->session->data['shipping_method']['code'])) {
                $order_data['shipping_code'] = $this->session->data['shipping_method']['code'];
            } else {
                $order_data['shipping_code'] = '';
            }

            $order_data['products'] = array();

            foreach ($this->cart->getProducts() as $product) {

                $order_data['products'][] = array(
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'option' => array(),
                    'download' => $product['download'],
                    'quantity' => $product['quantity'],
                    'subtract' => $product['subtract'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                    'tax' => $this->tax->getTax($product['price'], $product['tax_class_id']),
                    'reward' => $product['reward']
                );
            }

            $order_data['comment'] = '';

            if (isset($this->request->post['day']) && isset($this->request->post['month']) && isset($this->request->post['year'])) {
                $order_data['comment'] .= 'Дата  доставки: ' . $this->request->post['day']. ' ' . $this->request->post['month'] . ' ' . $this->request->post['year'] . "\n";
            }

            if (isset($this->request->post['comment']) && $this->request->post['comment']) {
                $order_data['comment'] .= $this->request->post['comment'];
            }

            $order_data['total'] = $total_data['total'];

            if (isset($this->request->cookie['tracking'])) {
                $order_data['tracking'] = $this->request->cookie['tracking'];

                $subtotal = $this->cart->getSubTotal();

                // Affiliate
                $this->load->model('affiliate/affiliate');

                $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

                if ($affiliate_info) {
                    $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
                    $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                } else {
                    $order_data['affiliate_id'] = 0;
                    $order_data['commission'] = 0;
                }

                // Marketing
                $this->load->model('checkout/marketing');

                $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

                if ($marketing_info) {
                    $order_data['marketing_id'] = $marketing_info['marketing_id'];
                } else {
                    $order_data['marketing_id'] = 0;
                }
            } else {
                $order_data['affiliate_id'] = 0;
                $order_data['commission'] = 0;
                $order_data['marketing_id'] = 0;
                $order_data['tracking'] = '';
            }

            $order_data['language_id'] = $this->config->get('config_language_id');
            $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
            $order_data['currency_code'] = $this->session->data['currency'];
            $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
            $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $order_data['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $order_data['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $order_data['accept_language'] = '';
            }

            $order_data['customer_id'] = 0;
            $order_data['customer_group_id'] = 0;
            if ($this->request->post['firstname']) {
                $order_data['firstname'] = $this->request->post['firstname'];
            } else {
                $order_data['firstname'] = '';
            }
            $order_data['lastname'] = '';
            if ($this->request->post['email']) {
                $order_data['email'] = $this->request->post['email'];
            } else {
                $order_data['email'] = '';
            }
            if ($this->request->post['telephone']) {
                $order_data['telephone'] = $this->request->post['telephone'];
            } else {
                $order_data['telephone'] = '';
            }
            $order_data['fax'] = '';
            $order_data['custom_field'] = '';

            $this->load->model('checkout/order');

            $this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);

            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('config_order_status_id'), '');

            $json['success'] = $this->url->link('checkout/success');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
