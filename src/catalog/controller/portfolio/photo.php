<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPortfolioPhoto extends Controller {
    public function photo() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'id.title';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['manufacturer'])) {
            $manufacturer = $this->request->get['manufacturer'];
        } else {
            $manufacturer = '';
        }

        $url = '';

//        if (isset($this->request->get['sort'])) {
//            $url .= '&sort=' . $this->request->get['sort'];
//        }
//
//        if (isset($this->request->get['order'])) {
//            $url .= '&sort=' . $this->request->get['order'];
//        }
//
//        if (isset($this->request->get['page'])) {
//            $url .= '&page=' . $this->request->get['page'];
//        }

        $this->load->language('portfolio/photo');

        $this->load->model('portfolio/photo');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_title'),
            'href' => $this->url->link('portfolio/photo')
        );

        $this->document->setTitle($this->language->get('text_title'));

        $this->document->setDescription($this->language->get('meta_description'));
        $this->document->setKeywords($this->language->get('meta_keyword'));

        $filter_id = '';

        if(isset($this->request->get['manufacturer'])){
            $filter_id = $this->request->get['manufacturer'];
        }

        $limit = (int) $this->config->get('config_limit_photo');

        $filter_data = array(
            'manufacturer_id' => $filter_id,
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        );

        $photo_total = $this->model_portfolio_photo->getTotalPhotos($filter_data['manufacturer_id']);

        $photos = $this->model_portfolio_photo->getPhotos($filter_data);

        $data['photos'] = [];

        $data['link_filter'] = $this->url->link('portfolio/photo', $url . '&manufacturer=');

        $data['page'] = $page;
        $data['limit'] = $filter_data['limit'];
        $data['total'] = $photo_total;

        if($photo_total > $page * $limit){
            $data['next_page'] = $page;
        }

        $data['manufacturer_id'] = $filter_id;

        if ($photos) {

            $this->load->model('tool/image');

            $manufacturer_ids = $this->model_portfolio_photo->getManufacturersIds();
            $manufacture_ids = [];
            foreach ($manufacturer_ids as $id){
                $manufacture_ids[] = $id['manufacturer_id'];
            }

            $manufacture_ids = implode(',', array_unique($manufacture_ids));

            $data['manufacturer_info'] = $this->model_portfolio_photo->getManufacturers($manufacture_ids);


            foreach ($photos as $photo) {
                $photo_id = $photo['photo_id'];
                $item = $this->model_portfolio_photo->getPhoto($photo_id);
                $item['photo'] = $this->model_portfolio_photo->getPhotoImages($photo_id);
                $item['photo'] = $item['photo'][$item['language_id']];

                if(isset($item['photo'])){

                    for($i = 0; $i < count($item['photo']); $i++) {
                        if (isset($item['photo'][$i]['image']) && is_file(DIR_IMAGE . $item['photo'][$i]['image'])) {
                            $item['photo'][$i]['thumb'] = $this->model_tool_image->cropsize($item['photo'][$i]['image'], 660, 380);
                        } else {
                            $item['photo'][$i]['thumb'] = null;
                        }
                    }
                }

                $item['description'] = html_entity_decode($photo['description'], ENT_QUOTES, 'UTF-8');

                $data['photos'][] = $item;

            }

            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/burger.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/search.js');

//            if ($photo_info['meta_title']) {
//                $this->document->setTitle($photo_info['meta_title']);
//            } else {
//                $this->document->setTitle($photo_info['title']);
//            }
//
//            if ($photo_info['noindex'] <= 0) {
//                $this->document->setRobots('noindex,follow');
//            }
//
//            if ($photo_info['meta_h1']) {
//                $data['heading_title'] = $photo_info['meta_h1'];
//            } else {
//                $data['heading_title'] = $photo_info['title'];
//            }

//            $this->document->setDescription($photo_info['meta_description']);
//            $this->document->setKeywords($photo_info['meta_keyword']);

//            $data['breadcrumbs'][] = array(
//                'text' => $photo_info['title'],
//                'href' => $this->url->link('portfolio/photo', 'photo_id=' . $photo_id)
//            );

            $data['button_continue'] = $this->language->get('button_continue');

//            $data['description'] = html_entity_decode($photo_info['description'], ENT_QUOTES, 'UTF-8');

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            return $this->load->view('portfolio/photo', $data);
//            $this->response->setOutput($this->load->view('portfolio/photo', $data));
        } else {
//            $data['breadcrumbs'][] = array(
//                'text' => $this->language->get('text_error'),
//                'href' => $this->url->link('portfolio/photo', 'photo_id=' . $photo_id)
//            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            return $this->load->view('error/not_found', $data);
//            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function index(){
        $this->response->setOutput($this->photo());
    }

    public function agree() {
        $this->load->model('portfolio/photo');

        if (isset($this->request->get['photo_id'])) {
            $photo_id = (int)$this->request->get['photo_id'];
        } else {
            $photo_id = 0;
        }

        $output = '';

        $photo_info = $this->model_portfolio_photo->getPhoto($photo_id);

        if ($photo_info) {
            $output .= html_entity_decode($photo_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
        }

        $this->response->setOutput($output);
    }
}