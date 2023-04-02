<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerExtensionModulePopular extends Controller
{
    public function index($setting)
    {
        $data['septic_url'] = $this->url->link('product/category', 'path=' . 20);

        $this->load->language('extension/module/popular');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_tax'] = $this->language->get('text_tax');

        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        $data['products'] = array();

        $product_data = array();

        if (isset($setting['limit']) && $setting['limit'] != '') {
            $setting['limit'] = $setting['limit'];
        } else {
            $setting['limit'] = 4;
        }


        $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.popular = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC LIMIT " . (int)$setting['limit']);


        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
        }

        $results = $product_data;

        if ($results) {
            foreach ($results as $result) {
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                }


                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }


                if ($this->config->get('config_review_status')) {
                    $rating = $result['rating'];
                } else {
                    $rating = false;
                }

                $stickers = $this->getStickers($result['product_id']);


                $this->load->model('catalog/category');
//                Атрибуты
                $data['attribute_groups'] = $this->model_catalog_category->getProductAttributes($result['product_id']);

                $attribute_group_full = [];

                $col = 0;
                foreach ($data['attribute_groups'] as $attribute_group) {
                    for ($i = 0; $i < count($attribute_group['attribute']); $i++) {
                        if ($col >= 2) {
                            break;
                        }
                        $attribute_group_full[] = $attribute_group['attribute'][$i];
                        $col++;
                    }
                    if ($col >= 2) {
                        break;
                    }
                    $col++;
                }

                //                Атрибуты
                $minimum = $result['minimum'] > 0 ? $result['minimum'] : 1;

//                Опции
                $options = array();

                foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
                    $product_option_value_data = array();

                    foreach ($option['product_option_value'] as $option_value) {
                        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                            if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                                $price = $this->currency->format($this->tax->calculate($option_value['price'], $tax, $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                            } else {
                                $price = false;
                            }

                            $product_option_value_data[] = array(
                                'product_option_value_id' => $option_value['product_option_value_id'],
                                'option_value_id' => $option_value['option_value_id'],
                                'name' => $option_value['name'],
                                'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
                                'price' => $price,
                                'price_prefix' => $option_value['price_prefix']
                            );
                        }
                    }

                    $options[] = array(
                        'product_option_id' => $option['product_option_id'],
                        'product_option_value' => $product_option_value_data,
                        'option_id' => $option['option_id'],
                        'name' => $option['name'],
                        'type' => $option['type'],
                        'value' => $option['value'],
                        'required' => $option['required']
                    );
                }

                $data['products'][] = array(
                    'product_id' => $result['product_id'],
                    'thumb' => $image,
                    'name' => $result['name'],
                    'price' => $price,
                    'special' => $special,
                    'tax' => $tax,
                    'sticker' => $stickers,
                    'minimum' => $minimum,
                    'rating' => $result['rating'],
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                    'attr' => $attribute_group_full,
                    'options' => $options
                );
            }

            if ($setting['name'] == "popular_product_sidebar") {
                return $this->load->view('extension/module/popular_sidebar', $data);
            } else if ($setting['name'] == 'popular_product_payment') {
                return $this->load->view('extension/module/popular_payment', $data);
            } else if ($setting['name'] == 'popular_product_category') {
                return $this->load->view('extension/module/popular_category', $data);
            } else {
                return $this->load->view('extension/module/popular', $data);
            }

        }
    }

    private
    function getStickers($product_id)
    {

        $stickers = $this->model_catalog_product->getProductStickerbyProductId($product_id);


        if (!$stickers) {
            return;
        }

        $data['stickers'] = array();

        foreach ($stickers as $sticker) {
            $data['stickers'][] = array(
                'position' => $sticker['position'],
                'image' => HTTP_SERVER . 'image/' . $sticker['image']
            );
        }

        return $this->load->view('product/stickers', $data);

    }
}