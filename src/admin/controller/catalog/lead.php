<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCatalogLead extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/lead');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/lead');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/lead');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/lead');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_lead->addLead($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/lead');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/lead');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_lead->editLead($this->request->get['lead_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/lead');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/lead');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $lead_id) {
				$this->model_catalog_lead->deleteLead($lead_id);
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

			$this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

    public function show(){
        $this->load->language('catalog/lead');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/lead');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_lead->editLead($this->request->get['lead_id'], $this->request->post);

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

            $this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['lead_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_default'] = $this->language->get('text_default');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_phone'] = $this->language->get('entry_phone');
        $data['entry_comment'] = $this->language->get('entry_comment');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_noindex'] = $this->language->get('entry_noindex');

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

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        if (isset($this->error['comment'])) {
            $data['error_comment'] = $this->error['comment'];
        } else {
            $data['error_comment'] = array();
        }

        if (isset($this->error['phone'])) {
            $data['error_phone'] = $this->error['phone'];
        } else {
            $data['error_phone'] = array();
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
            'href' => $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true)
        );

        if (!isset($this->request->get['lead_id'])) {
            $data['action'] = $this->url->link('catalog/lead/add', 'token=' . $this->session->data['token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('catalog/lead/edit', 'token=' . $this->session->data['token'] . '&lead_id=' . $this->request->get['lead_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true);

        if (isset($this->request->get['lead_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $lead_info = $this->model_catalog_lead->getLead($this->request->get['lead_id']);
        }

        $data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $language_id = $this->config->get('config_language_id');
        if (isset($data['lead_description'][$language_id]['title'])) {
            $data['heading_title'] = $data['lead_description'][$language_id]['title'];
        }

        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($lead_info)) {
            $data['name'] = $lead_info['name'];
        } else {
            $data['name'] = true;
        }

        if (isset($this->request->post['phone'])) {
            $data['phone'] = $this->request->post['phone'];
        } elseif (!empty($lead_info)) {
            $data['phone'] = $lead_info['phone'];
        } else {
            $data['phone'] = true;
        }

        if (isset($this->request->post['comment'])) {
            $data['comment'] = $this->request->post['comment'];
        } elseif (!empty($lead_info)) {
            $data['comment'] = $lead_info['comment'];
        } else {
            $data['comment'] = true;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($lead_info)) {
            $data['status'] = $lead_info['status'];
        } else {
            $data['status'] = true;
        }

        if (isset($this->request->post['noindex'])) {
            $data['noindex'] = $this->request->post['noindex'];
        } elseif (!empty($lead_info)) {
            $data['noindex'] = $lead_info['noindex'];
        } else {
            $data['noindex'] = 1;
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($lead_info)) {
            $data['sort_order'] = $lead_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $this->load->model('design/layout');

        $data['layouts'] = $this->model_design_layout->getLayouts();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/lead_show', $data));
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
			'href' => $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/lead/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/lead/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['enabled'] = $this->url->link('catalog/lead/enable', 'token=' . $this->session->data['token'] . $url, true);
        $data['disabled'] = $this->url->link('catalog/lead/disable', 'token=' . $this->session->data['token'] . $url, true);


		$data['leads'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$lead_total = $this->model_catalog_lead->getTotalLeads();

		$results = $this->model_catalog_lead->getLeads($filter_data);

		foreach ($results as $result) {
			$data['leads'][] = array(
				'lead_id' => $result['lead_id'],
				'name'          => $result['name'],
				'phone'          => $result['phone'],
				'sort_order'     => $result['sort_order'],
				'noindex'  	  	 => $result['noindex'],
				'href_shop'  	 => $this->url->link('catalog/lead/show', 'token=' . $this->session->data['token'] . '&lead_id=' . $result['lead_id'] . $url, true),
				'edit'           => $this->url->link('catalog/lead/edit', 'token=' . $this->session->data['token'] . '&lead_id=' . $result['lead_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_title'] = $this->language->get('column_title');
		$data['column_phone'] = $this->language->get('column_phone');
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

		$data['sort_title'] = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . '&sort=id.title' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . '&sort=i.sort_order' . $url, true);
		$data['sort_noindex'] = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . '&sort=i.noindex' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $lead_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($lead_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($lead_total - $this->config->get('config_limit_admin'))) ? $lead_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $lead_total, ceil($lead_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/lead_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['lead_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_noindex'] = $this->language->get('entry_noindex');

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

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['comment'])) {
			$data['error_comment'] = $this->error['comment'];
		} else {
			$data['error_comment'] = array();
		}

		if (isset($this->error['phone'])) {
			$data['error_phone'] = $this->error['phone'];
		} else {
			$data['error_phone'] = array();
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
			'href' => $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['lead_id'])) {
			$data['action'] = $this->url->link('catalog/lead/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/lead/edit', 'token=' . $this->session->data['token'] . '&lead_id=' . $this->request->get['lead_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['lead_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$lead_info = $this->model_catalog_lead->getLead($this->request->get['lead_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$language_id = $this->config->get('config_language_id');
		if (isset($data['lead_description'][$language_id]['title'])) {
			$data['heading_title'] = $data['lead_description'][$language_id]['title'];
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($lead_info)) {
            $data['name'] = '';
        } else {
            $data['name'] = '';
        }

        if (isset($this->request->post['phone'])) {
            $data['phone'] = $this->request->post['phone'];
        } elseif (!empty($lead_info)) {
            $data['phone'] = '';
        } else {
            $data['phone'] = '';
        }

        if (isset($this->request->post['comment'])) {
            $data['comment'] = $this->request->post['comment'];
        } elseif (!empty($lead_info)) {
            $data['comment'] = '';
        } else {
            $data['comment'] = '';
        }

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($lead_info)) {
			$data['status'] = $lead_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['noindex'])) {
			$data['noindex'] = $this->request->post['noindex'];
		} elseif (!empty($lead_info)) {
			$data['noindex'] = $lead_info['noindex'];
		} else {
			$data['noindex'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($lead_info)) {
			$data['sort_order'] = $lead_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/lead_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/lead')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        $language_id = $this->config->get('config_language_id');

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'][$language_id] = $this->language->get('error_name');
        }

        if (utf8_strlen($this->request->post['phone']) < 3) {
            $this->error['phone'][$language_id] = $this->language->get('error_phone');
        }

        if ((utf8_strlen($this->request->post['comment']) < 0) || (utf8_strlen($this->request->post['comment']) > 255)) {
            $this->error['comment'][$language_id] = $this->language->get('error_comment');
        }

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
	
	public function enable() {
        $this->load->language('catalog/lead');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/lead');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $lead_id) {
                $this->model_catalog_lead->editLeadStatus($lead_id, 1);
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
            $this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }
    public function disable() {
        $this->load->language('catalog/lead');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/lead');
        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $lead_id) {
                $this->model_catalog_lead->editLeadStatus($lead_id, 0);
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
            $this->response->redirect($this->url->link('catalog/lead', 'token=' . $this->session->data['token'] . $url, true));
        }
        $this->getList();
    }

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/lead')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}