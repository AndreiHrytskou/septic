<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModuleReview extends Controller {
	public function index() {
		$this->load->language('extension/module/review');

		$data['heading_title'] = $this->language->get('heading_title');

        $this->load->model('extension/module/review');
        $result = $this->model_extension_module_review->getReviews();

        $data['reviews'] = array();

        if($result){
            $this->load->model('tool/image');

            foreach ($result as $review) {

                if (isset($review['avatar']) && is_file(DIR_IMAGE . $review['avatar'])) {
                    $review['thumb'] = $this->model_tool_image->cropsize($review['avatar'], 660, 380);
                } else {
                    $review['thumb'] = null;
                }

                $data['reviews'][] = $review;

            }
        }

		return $this->load->view('extension/module/review', $data);
	}
}