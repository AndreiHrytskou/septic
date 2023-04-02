<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPortfolioPhoto extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('portfolio/photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/photo');

		$this->getList();
	}

	public function add() {
		$this->load->language('portfolio/photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/photo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_photo->addPhoto($this->request->post);

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

			$this->response->redirect($this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('portfolio/photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/photo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_photo->editPhoto($this->request->get['photo_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('portfolio/photo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/photo');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $photo_id) {
				$this->model_portfolio_photo->deletePhoto($photo_id);
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

			$this->response->redirect($this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
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
			'href' => $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('portfolio/photo/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('portfolio/photo/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['enabled'] = $this->url->link('portfolio/photo/enable', 'token=' . $this->session->data['token'] . $url, true);
        $data['disabled'] = $this->url->link('portfolio/photo/disable', 'token=' . $this->session->data['token'] . $url, true);


		$data['photos'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$photo_total = $this->model_portfolio_photo->getTotalPhotos();

		$results = $this->model_portfolio_photo->getPhotos($filter_data);

		foreach ($results as $result) {
			$data['photos'][] = array(
				'photo_id' => $result['photo_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'noindex'  	  	 => $result['noindex'],
				'href_shop'  	 => HTTP_CATALOG . 'index.php?route=portfolio/photo&photo_id=' . ($result['photo_id']),
				'edit'           => $this->url->link('portfolio/photo/edit', 'token=' . $this->session->data['token'] . '&photo_id=' . $result['photo_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_noindex'] = $this->language->get('column_noindex');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_shop'] = $this->language->get('button_shop');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_enable'] = $this->language->get('button_enable');
        $data['button_disable'] = $this->language->get('button_disable');

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

		$data['sort_title'] = $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);
		$data['sort_noindex'] = $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . '&sort=i.noindex' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $photo_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($photo_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($photo_total - $this->config->get('config_limit_admin'))) ? $photo_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $photo_total, ceil($photo_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/photo_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['photo_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_header'] = $this->language->get('entry_header');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_bottom'] = $this->language->get('entry_bottom');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_noindex'] = $this->language->get('entry_noindex');
		$data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_bottom'] = $this->language->get('help_bottom');
		$data['help_noindex'] = $this->language->get('help_noindex');
        $data['help_manufacturer'] = $this->language->get('help_manufacturer');
        $data['text_none'] = $this->language->get('text_none');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_photo_add'] = $this->language->get('button_photo_add');
        $data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = array();
		}

        if (isset($this->error['manufacturer_id'])) {
            $data['error_manufacturer'] = $this->error['manufacturer_id'];
        } else {
            $data['error_manufacturer'] = array();
        }

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}
		
		if (isset($this->error['meta_h1'])) {
			$data['error_meta_h1'] = $this->error['meta_h1'];
		} else {
			$data['error_meta_h1'] = array();
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

        if (isset($this->error['photo_image'])) {
            $data['error_photo_image'] = $this->error['photo_image'];
        } else {
            $data['error_photo_image'] = array();
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
			'href' => $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['photo_id'])) {
			$data['action'] = $this->url->link('portfolio/photo/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('portfolio/photo/edit', 'token=' . $this->session->data['token'] . '&photo_id=' . $this->request->get['photo_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['photo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$photo_info = $this->model_portfolio_photo->getPhoto($this->request->get['photo_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['photo_description'])) {
			$data['photo_description'] = $this->request->post['photo_description'];
		} elseif (isset($this->request->get['photo_id'])) {
			$data['photo_description'] = $this->model_portfolio_photo->getPhotoDescriptions($this->request->get['photo_id']);
		} else {
			$data['photo_description'] = array();
		}
		
		$language_id = $this->config->get('config_language_id');
		if (isset($data['photo_description'][$language_id]['title'])) {
			$data['heading_title'] = $data['photo_description'][$language_id]['title'];
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['photo_store'])) {
			$data['photo_store'] = $this->request->post['photo_store'];
		} elseif (isset($this->request->get['photo_id'])) {
			$data['photo_store'] = $this->model_portfolio_photo->getPhotoStores($this->request->get['photo_id']);
		} else {
			$data['photo_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($photo_info)) {
			$data['keyword'] = $photo_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($photo_info)) {
			$data['bottom'] = $photo_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($photo_info)) {
			$data['status'] = $photo_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['noindex'])) {
			$data['noindex'] = $this->request->post['noindex'];
		} elseif (!empty($photo_info)) {
			$data['noindex'] = $photo_info['noindex'];
		} else {
			$data['noindex'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($photo_info)) {
			$data['sort_order'] = $photo_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($photo_info)) {
			$data['sort_order'] = $photo_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['photo_layout'])) {
			$data['photo_layout'] = $this->request->post['photo_layout'];
		} elseif (isset($this->request->get['photo_id'])) {
			$data['photo_layout'] = $this->model_portfolio_photo->getPhotoLayouts($this->request->get['photo_id']);
		} else {
			$data['photo_layout'] = array();
		}


        //Производитель
        $this->load->model('catalog/manufacturer');

        if (isset($this->request->post['manufacturer_id'])) {
            $data['manufacturer_id'] = $this->request->post['manufacturer_id'];
        } elseif (!empty($photo_info)) {
            $data['manufacturer_id'] = $photo_info['manufacturer_id'];
        } else {
            $data['manufacturer_id'] = 0;
        }

        if (isset($this->request->post['manufacturer'])) {
            $data['manufacturer'] = $this->request->post['manufacturer'];
        } elseif (!empty($photo_info)) {
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($photo_info['manufacturer_id']);

            if ($manufacturer_info) {
                $data['manufacturer'] = $manufacturer_info['name'];
            } else {
                $data['manufacturer'] = '';
            }
        } else {
            $data['manufacturer'] = '';
        }

        //Изображения
        $this->load->model('tool/image');

        if (isset($this->request->post['photo_image'])) {
            $photo_images = $this->request->post['photo_image'];
        } elseif (isset($this->request->get['photo_id'])) {
            $photo_images = $this->model_portfolio_photo->getPhotoImages($this->request->get['photo_id']);
        } else {
            $photo_images = array();
        }

        $data['photo_images'] = array();

        foreach ($photo_images as $key => $value) {
            foreach ($value as $photo_image) {
                if (is_file(DIR_IMAGE . $photo_image['image'])) {
                    $image = $photo_image['image'];
                    $thumb = $photo_image['image'];
                } else {
                    $image = '';
                    $thumb = 'no_image.png';
                }

                $data['photo_images'][$key][] = array(
                    'title'      => $photo_image['title'],
                    'link'       => $photo_image['link'],
                    'image'      => $image,
                    'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
                    'sort_order' => $photo_image['sort_order']
                );
            }
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/photo_form', $data));
	}

	protected function validateForm() {

		if (!$this->user->hasPermission('modify', 'portfolio/photo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['photo_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

//			if ((utf8_strlen($value['meta_title']) < 0) || (utf8_strlen($value['meta_title']) > 255)) {
//				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
//			}

//			if ((utf8_strlen($value['meta_h1']) < 0) || (utf8_strlen($value['meta_h1']) > 255)) {
//				$this->error['meta_h1'][$language_id] = $this->language->get('error_meta_h1');
//			}
		}

//		if (utf8_strlen($this->request->post['keyword']) > 0) {
//			$this->load->model('portfolio/url_alias');
//
//			$url_alias_info = $this->model_portfolio_url_alias->getUrlAlias($this->request->post['keyword']);
//
//			if ($url_alias_info && isset($this->request->get['photo_id']) && $url_alias_info['query'] != 'photo_id=' . $this->request->get['photo_id']) {
//				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
//			}
//
//			if ($url_alias_info && !isset($this->request->get['photo_id'])) {
//				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
//			}
//		}

        if (isset($this->request->post['photo_image'])) {
            foreach ($this->request->post['photo_image'] as $language_id => $value) {
                foreach ($value as $photo_image_id => $photo_image) {
                    if ((utf8_strlen($photo_image['title']) < 2) || (utf8_strlen($photo_image['title']) > 64)) {
                        $this->error['photo_image'][$language_id][$photo_image_id] = $this->language->get('error_title');
                    }
                }
            }
        }

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	
	public function enable() {
        $this->load->language('portfolio/photo');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('portfolio/photo');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $photo_id) {
                $this->model_portfolio_photo->editPhotoStatus($photo_id, 1);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            $this->response->redirect($this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }
    public function disable() {
        $this->load->language('portfolio/photo');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('portfolio/photo');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $photo_id) {
                $this->model_portfolio_photo->editPhotoStatus($photo_id, 0);
            }
            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            $this->response->redirect($this->url->link('portfolio/photo', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'portfolio/photo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('setting/store');

		foreach ($this->request->post['selected'] as $photo_id) {
			if ($this->config->get('config_account_id') == $photo_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}

			if ($this->config->get('config_checkout_id') == $photo_id) {
				$this->error['warning'] = $this->language->get('error_checkout');
			}

			if ($this->config->get('config_affiliate_id') == $photo_id) {
				$this->error['warning'] = $this->language->get('error_affiliate');
			}

			if ($this->config->get('config_return_id') == $photo_id) {
				$this->error['warning'] = $this->language->get('error_return');
			}

			$store_total = $this->model_setting_store->getTotalStoresByPhotoId($photo_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
		}

		return !$this->error;
	}
}