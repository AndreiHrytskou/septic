<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_bestseller'] = $this->language->get('text_bestseller');
		$data['text_mostviewed'] = $this->language->get('text_mostviewed');
		$data['text_latest'] = $this->language->get('text_latest');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['bestseller'] = $this->url->link('product/bestseller');
		$data['mostviewed'] = $this->url->link('product/mostviewed');
		$data['latest'] = $this->url->link('product/latest');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

		$data['powered'] = '© ' . date('Y', time()). ' ' . $this->config->get('config_name');
        $data['tel'] = $this->config->get('config_telephone');
        $data['email'] = $this->config->get('config_email');
        $data['config_footer'] = html_entity_decode($this->config->get('config_footer'));

        $data['video_href'] = $this->url->link('portfolio/video');
        $data['photo_href'] = $this->url->link('portfolio/photo');
        $data['borehole_href'] = $this->url->link('information/information&information_id=7');
        $data['well_href'] = $this->url->link('information/information&information_id=9');
        $data['water_href'] = $this->url->link('information/information&information_id=10');
        $data['contact_href'] = $this->url->link('information/contact');
        $data['blog_href'] = $this->url->link('blog/category&blog_category_id=69');
        $data['cart_href'] = $this->url->link('checkout/cart');
        $data['septic_href'] = $this->url->link('product/category', 'path=' . 20);
        $data['payment_href'] = $this->url->link('information/information&information_id=8');

        $data['vk'] = $this->config->get('config_vk');
        $data['dzen'] = $this->config->get('config_dzen');
        $data['youtube'] = $this->config->get('config_youtube');
        $data['rutube'] = $this->config->get('config_rutube');


		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer', $data);
	}
}
