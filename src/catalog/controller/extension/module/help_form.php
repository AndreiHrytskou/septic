<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleHelpForm extends Controller {
    private $error = array();

	public function index() {
            $this->load->language('extension/module/help_form');

            $data['action'] = $this->url->link('extension/module/help_form/send', '', true);

            return $this->load->view('extension/module/help_form', $data);
	}

    public function send(){
        if (!isset($this->request->post['name']) || empty($this->request->post['name'])) {
            $json['error'] = "Поле с именем не должно быть пустым";
        }

        if (!isset($this->request->post['phone']) || empty($this->request->post['phone'])) {
            $json['error'] = "Поле с телефоном не должно быть пустым";
        }

        if (!isset($json['error'])) {
            $data = [];

            $data['name'] = $this->request->post['name'] ? $this->request->post['name'] : '';
            $data['phone'] = $this->request->post['phone'] ? $this->request->post['phone'] : $this->request->post['phone'];
            $data['comment'] = $data['name'] . " оставил заявку на обратный звонок , пожалуйста перезвоните по номеру " . $data['phone'];

            $this->load->model('catalog/lead');
            $this->model_catalog_lead->addLead($data);

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));

            $mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
            $mail->setSubject("Заявка из формы обратной связи");

            $text = $this->request->post['name'] . " оставил заявку на обратный звонок , пожалуйста перезвоните по номеру " . $this->request->post['phone'];
            $mail->setText($text);

            $mail->send();

            $json['success'] = "ok";

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate()
    {
        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ((utf8_strlen($this->request->post['phone']) < 3) || (utf8_strlen($this->request->post['phone']) > 32)) {
            $this->error['phone'] = $this->language->get('error_phone');
        }

        return !$this->error;
    }
}