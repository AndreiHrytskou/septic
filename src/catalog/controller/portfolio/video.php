<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPortfolioVideo extends Controller
{
    public function index()
    {
        $this->load->language('portfolio/video');

        $this->load->model('portfolio/video');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_title'),
            'href' => $this->url->link('portfolio/video')
        );

        $this->document->setTitle($this->language->get('text_title'));

        $this->document->setDescription($this->language->get('meta_description'));
        $this->document->setKeywords($this->language->get('meta_keyword'));

        $videos = $this->model_portfolio_video->getVideos();

        $data['video'] = [];

        if ($videos) {

            $this->load->model('tool/image');

            foreach ($videos as $video) {
                $video_id = $video['video_id'];
                $item = $this->model_portfolio_video->getVideo($video_id);

                $item['description'] = html_entity_decode($video['description'], ENT_QUOTES, 'UTF-8');


                if (isset($item['preview']) && is_file(DIR_IMAGE . $item['preview'])) {
                    $item['thumb'] = $this->model_tool_image->cropsize($item['preview'], 660, 380);
                } else {
                    $item['thumb'] = null;
                }

                $data['video'][] = $item;

            }

            $this->log->write($data['video']);

            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/burger.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/menu.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/search.js');
            $this->document->addScript('/catalog/view/theme/prostoseptik/assets/js/video_page.js');

//            if ($video_info['meta_title']) {
//                $this->document->setTitle($video_info['meta_title']);
//            } else {
//                $this->document->setTitle($video_info['title']);
//            }
//
//            if ($video_info['noindex'] <= 0) {
//                $this->document->setRobots('noindex,follow');
//            }
//
//            if ($video_info['meta_h1']) {
//                $data['heading_title'] = $video_info['meta_h1'];
//            } else {
//                $data['heading_title'] = $video_info['title'];
//            }

//            $this->document->setDescription($video_info['meta_description']);
//            $this->document->setKeywords($video_info['meta_keyword']);

//            $data['breadcrumbs'][] = array(
//                'text' => $video_info['title'],
//                'href' => $this->url->link('portfolio/video', 'video_id=' . $video_id)
//            );

            $data['button_continue'] = $this->language->get('button_continue');

//            $data['description'] = html_entity_decode($video_info['description'], ENT_QUOTES, 'UTF-8');

            $data['continue'] = $this->url->link('common/home');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('portfolio/video', $data));
        } else {
//            $data['breadcrumbs'][] = array(
//                'text' => $this->language->get('text_error'),
//                'href' => $this->url->link('portfolio/video', 'video_id=' . $video_id)
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

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

}