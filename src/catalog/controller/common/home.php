<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/burger.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/swiper.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/firstswiper.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/form.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/search.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/thanks.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/animation_headPage.js');
        $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/animate_catalog.js');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
