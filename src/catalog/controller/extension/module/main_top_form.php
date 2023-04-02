<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleMainTopForm extends Controller {
    private $error = array();

	public function index() {
            $this->load->language('extension/module/main_top_form');

            $this->load->model('extension/module/main_top_form');

            $poster_images = $this->model_extension_module_main_top_form->getPosterImages(3);
            $this->load->model('tool/image');

            $data['poster_images'] = array();

            foreach ($poster_images as $key => $value) {

                foreach ($value as $poster_image) {
                    if (is_file(DIR_IMAGE . $poster_image['image'])) {
                        $image = $poster_image['image'];
                        $thumb = $poster_image['image'];
                        $image_mobile = $poster_image['image_mobile'];
                        $thumb_mobile = $poster_image['image_mobile'];
                    } else {
                        $image = '';
                        $thumb = 'no_image.png';
                        $image_mobile = '';
                        $thumb_mobile = $poster_image['image'];
                    }

                    $data['poster_images'][] = array(
                        'title'         => html_entity_decode($poster_image['title'], ENT_QUOTES, 'UTF-8'),
                        'link'          => $poster_image['link'],
                        'image'         => $image,
                        'image_mobile'  => $image_mobile,
                        'thumb'         => $this->model_tool_image->cropsize($thumb, 726, 556),
                        'thumb_mobile'  => $this->model_tool_image->cropsize($thumb_mobile, 726, 556),
                        'sort_order'    => $poster_image['sort_order']
                    );
                }
            }

            $data['vk'] = $this->config->get('config_vk');
            $data['dzen'] = $this->config->get('config_dzen');
            $data['youtube'] = $this->config->get('config_youtube');
            $data['rutube'] = $this->config->get('config_rutube');

            $data['action'] = $this->url->link('extension/module/help_form/send', '', true);

            return $this->load->view('extension/module/main_top_form', $data);
	}
}