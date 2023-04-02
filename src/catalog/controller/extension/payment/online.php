<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionPaymentOnline extends Controller {
	public function index() {
		$this->load->language('extension/payment/online');

		$data['text_instruction'] = $this->language->get('text_instruction');
		$data['text_description'] = $this->language->get('text_description');
		$data['text_payment'] = $this->language->get('text_payment');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['bank'] = nl2br($this->config->get('online_bank' . $this->config->get('config_language_id')));

		$data['continue'] = $this->url->link('checkout/success');

		return $this->load->view('extension/payment/online', $data);
	}

	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'online') {
			$this->load->language('extension/payment/online');

			$this->load->model('checkout/order');

			$comment  = $this->language->get('text_instruction') . "\n\n";
			$comment .= $this->config->get('online_bank' . $this->config->get('config_language_id')) . "\n\n";
			$comment .= $this->language->get('text_payment');

			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('online_order_status_id'), $comment, true);
		}
	}
}