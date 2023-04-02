<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerPortfolioVideo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('portfolio/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/video');

		$this->getList();
	}

	public function add() {
		$this->load->language('portfolio/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_video->addVideo($this->request->post);

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

			$this->response->redirect($this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('portfolio/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/video');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_portfolio_video->editVideo($this->request->get['video_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('portfolio/video');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('portfolio/video');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $video_id) {
				$this->model_portfolio_video->deleteVideo($video_id);
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

			$this->response->redirect($this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true));
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
			'href' => $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('portfolio/video/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('portfolio/video/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['enabled'] = $this->url->link('portfolio/video/enable', 'token=' . $this->session->data['token'] . $url, true);
        $data['disabled'] = $this->url->link('portfolio/video/disable', 'token=' . $this->session->data['token'] . $url, true);


		$data['videos'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$video_total = $this->model_portfolio_video->getTotalVideos();

		$results = $this->model_portfolio_video->getVideos($filter_data);

		foreach ($results as $result) {
			$data['videos'][] = array(
				'video_id' => $result['video_id'],
				'title'          => $result['title'],
				'sort_order'     => $result['sort_order'],
				'noindex'  	  	 => $result['noindex'],
				'href_shop'  	 => HTTP_CATALOG . 'index.php?route=video/video&video_id=' . ($result['video_id']),
				'edit'           => $this->url->link('portfolio/video/edit', 'token=' . $this->session->data['token'] . '&video_id=' . $result['video_id'] . $url, true)
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

		$data['sort_title'] = $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);
		$data['sort_noindex'] = $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . '&sort=i.noindex' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $video_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($video_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($video_total - $this->config->get('config_limit_admin'))) ? $video_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $video_total, ceil($video_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/video_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['video_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_preview'] = $this->language->get('entry_preview');
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

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_bottom'] = $this->language->get('help_bottom');
		$data['help_noindex'] = $this->language->get('help_noindex');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

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

        if (isset($this->error['url'])) {
            $data['error_url'] = $this->error['url'];
        } else {
            $data['error_url'] = '';
        }

        if (isset($this->error['preview'])) {
            $data['error_preview'] = $this->error['preview'];
        } else {
            $data['error_preview'] = '';
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
			'href' => $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['video_id'])) {
			$data['action'] = $this->url->link('portfolio/video/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('portfolio/video/edit', 'token=' . $this->session->data['token'] . '&video_id=' . $this->request->get['video_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['video_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$video_info = $this->model_portfolio_video->getVideo($this->request->get['video_id']);
		}

        if (isset($this->request->post['url'])) {
            $data['url'] = $this->request->post['url'];
        } elseif (!empty($video_info)) {
            $data['url'] = $video_info['url'];
        } else {
            $data['url'] = '';
        }

//        Изображение
        if (isset($this->request->post['preview'])) {
            $data['preview'] = $this->request->post['preview'];
        } elseif (!empty($video_info)) {
            $data['preview'] = $video_info['preview'];
        } else {
            $data['preview'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['preview']) && is_file(DIR_IMAGE . $this->request->post['preview'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['preview'], 100, 100);
        } elseif (!empty($video_info) && is_file(DIR_IMAGE . $video_info['preview'])) {
            $data['thumb'] = $this->model_tool_image->resize($video_info['preview'], 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        //        Изображение конец


		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['video_description'])) {
			$data['video_description'] = $this->request->post['video_description'];
		} elseif (isset($this->request->get['video_id'])) {
			$data['video_description'] = $this->model_portfolio_video->getVideoDescriptions($this->request->get['video_id']);
		} else {
			$data['video_description'] = array();
		}
		
		$language_id = $this->config->get('config_language_id');
		if (isset($data['video_description'][$language_id]['title'])) {
			$data['heading_title'] = $data['video_description'][$language_id]['title'];
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['video_store'])) {
			$data['video_store'] = $this->request->post['video_store'];
		} elseif (isset($this->request->get['video_id'])) {
			$data['video_store'] = $this->model_portfolio_video->getVideoStores($this->request->get['video_id']);
		} else {
			$data['video_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($video_info)) {
			$data['keyword'] = $video_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['bottom'])) {
			$data['bottom'] = $this->request->post['bottom'];
		} elseif (!empty($video_info)) {
			$data['bottom'] = $video_info['bottom'];
		} else {
			$data['bottom'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($video_info)) {
			$data['status'] = $video_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['noindex'])) {
			$data['noindex'] = $this->request->post['noindex'];
		} elseif (!empty($video_info)) {
			$data['noindex'] = $video_info['noindex'];
		} else {
			$data['noindex'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($video_info)) {
			$data['sort_order'] = $video_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($video_info)) {
			$data['sort_order'] = $video_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['video_layout'])) {
			$data['video_layout'] = $this->request->post['video_layout'];
		} elseif (isset($this->request->get['video_id'])) {
			$data['video_layout'] = $this->model_portfolio_video->getVideoLayouts($this->request->get['video_id']);
		} else {
			$data['video_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('portfolio/video_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'portfolio/video')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['video_description'] as $language_id => $value) {
			if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 90)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (utf8_strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

			if ((utf8_strlen($value['meta_title']) < 0) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
			
			if ((utf8_strlen($value['meta_h1']) < 0) || (utf8_strlen($value['meta_h1']) > 255)) {
				$this->error['meta_h1'][$language_id] = $this->language->get('error_meta_h1');
			}
		}

        if ((utf8_strlen($this->request->post['url']) < 10) || (utf8_strlen($this->request->post['url']) > 255)) {
            $this->error['url'] = $this->language->get('error_url');
        }

        if ((utf8_strlen($this->request->post['preview']) < 5) || (utf8_strlen($this->request->post['preview']) > 255)) {
            $this->error['preview'] = $this->language->get('error_preview');
        }

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('portfolio/url_alias');

			$url_alias_info = $this->model_portfolio_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['video_id']) && $url_alias_info['query'] != 'video_id=' . $this->request->get['video_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['video_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	
	public function enable() {
        $this->load->language('portfolio/video');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('portfolio/video');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $video_id) {
                $this->model_portfolio_video->editVideoStatus($video_id, 1);
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
            $this->response->redirect($this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }
    public function disable() {
        $this->load->language('portfolio/video');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('portfolio/video');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $video_id) {
                $this->model_portfolio_video->editVideoStatus($video_id, 0);
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
            $this->response->redirect($this->url->link('portfolio/video', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'portfolio/video')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}