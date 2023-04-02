<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPortfolioPoster extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('portfolio/poster');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/poster');

		$this->getList();
	}

	public function add() {
		$this->load->language('portfolio/poster');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/poster');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_poster->addPoster($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('portfolio/poster');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/poster');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_poster->editPoster($this->request->get['poster_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('portfolio/poster');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/poster');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $poster_id) {
				$this->model_portfolio_poster->deletePoster($poster_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('portfolio/poster/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('portfolio/poster/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['posters'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$poster_total = $this->model_portfolio_poster->getTotalPosters();

		$results = $this->model_portfolio_poster->getPosters($filter_data);

		foreach ($results as $result) {
			$data['posters'][] = array(
				'poster_id' => $result['poster_id'],
				'name'      => $result['name'],
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'edit'      => $this->url->link('portfolio/poster/edit', 'token=' . $this->session->data['token'] . '&poster_id=' . $result['poster_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $poster_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($poster_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($poster_total - $this->config->get('config_limit_admin'))) ? $poster_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $poster_total, ceil($poster_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/poster_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['poster_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_image_mobile'] = $this->language->get('entry_image_mobile');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_poster_add'] = $this->language->get('button_poster_add');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['poster_image'])) {
			$data['error_poster_image'] = $this->error['poster_image'];
		} else {
			$data['error_poster_image'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['poster_id'])) {
			$data['action'] = $this->url->link('portfolio/poster/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('portfolio/poster/edit', 'token=' . $this->session->data['token'] . '&poster_id=' . $this->request->get['poster_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('portfolio/poster', 'token=' . $this->session->data['token'] . $url, true);

        if (isset($this->request->get['poster_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$poster_info = $this->model_portfolio_poster->getPoster($this->request->get['poster_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($poster_info)) {
			$data['name'] = $poster_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($poster_info)) {
			$data['status'] = $poster_info['status'];
		} else {
			$data['status'] = true;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$this->load->model('tool/image');

		if (isset($this->request->post['poster_image'])) {
			$poster_images = $this->request->post['poster_image'];
		} elseif (isset($this->request->get['poster_id'])) {
			$poster_images = $this->model_portfolio_poster->getPosterImages($this->request->get['poster_id']);
		} else {
			$poster_images = array();
		}


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
                    $thumb_mobile = 'no_image.png';
				}
				
				$data['poster_images'][$key][] = array(
					'title'      => $poster_image['title'],
					'link'       => $poster_image['link'],
					'image'      => $image,
					'image_mobile'      => $image_mobile,
					'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
					'thumb_mobile'      => $this->model_tool_image->resize($thumb_mobile, 100, 100),
					'sort_order' => $poster_image['sort_order']
				);
			}
		}


        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/poster_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'portfolio/poster')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (isset($this->request->post['poster_image'])) {
			foreach ($this->request->post['poster_image'] as $language_id => $value) {
				foreach ($value as $poster_image_id => $poster_image) {
					if ((utf8_strlen($poster_image['title']) < 2) || (utf8_strlen($poster_image['title']) > 255)) {
						$this->error['poster_image'][$language_id][$poster_image_id] = $this->language->get('error_title');
					}
				}
			}
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'portfolio/poster')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}