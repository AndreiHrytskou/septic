<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelPortfolioPhoto extends Model {
	public function addPhoto($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "photo SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', noindex = '" . (int)$data['noindex'] . "'");

		$photo_id = $this->db->getLastId();

		foreach ($data['photo_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "photo_description SET photo_id = '" . (int)$photo_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['photo_store'])) {
			foreach ($data['photo_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "photo_to_store SET photo_id = '" . (int)$photo_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['photo_layout'])) {
			foreach ($data['photo_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "photo_to_layout SET photo_id = '" . (int)$photo_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

        if (isset($data['photo_image'])) {
            foreach ($data['photo_image'] as $language_id => $value) {
                foreach ($value as $photo_image) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "photo_image SET photo_id = '" . (int)$photo_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($photo_image['title']) . "', link = '" .  $this->db->escape($photo_image['link']) . "', image = '" .  $this->db->escape($photo_image['image']) . "', sort_order = '" .  (int)$photo_image['sort_order'] . "'");
                }
            }
        }

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'photo_id=" . (int)$photo_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('photo');

		return $photo_id;
	}

	public function editPhoto($photo_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "photo SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', noindex = '" . (int)$data['noindex'] . "' WHERE photo_id = '" . (int)$photo_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_description WHERE photo_id = '" . (int)$photo_id . "'");

		foreach ($data['photo_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "photo_description SET photo_id = '" . (int)$photo_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_to_store WHERE photo_id = '" . (int)$photo_id . "'");

		if (isset($data['photo_store'])) {
			foreach ($data['photo_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "photo_to_store SET photo_id = '" . (int)$photo_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_to_layout WHERE photo_id = '" . (int)$photo_id . "'");

		if (isset($data['photo_layout'])) {
			foreach ($data['photo_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "photo_to_layout SET photo_id = '" . (int)$photo_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'photo_id=" . (int)$photo_id . "'");

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'photo_id=" . (int)$photo_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

        $this->db->query("DELETE FROM " . DB_PREFIX . "photo_image WHERE photo_id = '" . (int)$photo_id . "'");

        if (isset($data['photo_image'])) {
            foreach ($data['photo_image'] as $language_id => $value) {
                foreach ($value as $photo_image) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "photo_image SET photo_id = '" . (int)$photo_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($photo_image['title']) . "', link = '" .  $this->db->escape($photo_image['link']) . "', image = '" .  $this->db->escape($photo_image['image']) . "', sort_order = '" . (int)$photo_image['sort_order'] . "'");
                }
            }
        }

		$this->cache->delete('photo');
	}

	public function editPhotoStatus($photo_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "photo SET status = '" . (int)$status . "'WHERE photo_id = '" . (int)$photo_id . "'");

		$this->cache->delete('photo');

    }

	public function deletePhoto($photo_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "photo WHERE photo_id = '" . (int)$photo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_description WHERE photo_id = '" . (int)$photo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_to_store WHERE photo_id = '" . (int)$photo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "photo_to_layout WHERE photo_id = '" . (int)$photo_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'photo_id=" . (int)$photo_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "photo_image WHERE photo_id = '" . (int)$photo_id . "'");
		$this->cache->delete('photo');
	}

	public function getPhoto($photo_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'photo_id=" . (int)$photo_id . "') AS keyword FROM " . DB_PREFIX . "photo WHERE photo_id = '" . (int)$photo_id . "'");

		return $query->row;
	}

	public function getPhotos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "photo i LEFT JOIN " . DB_PREFIX . "photo_description id ON (i.photo_id = id.photo_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($data['filter_name'])) {
				$sql .= " AND id.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}

			$sort_data = array(
				'id.title',
				'i.sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY id.title";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;
		} else {
			$photo_data = $this->cache->get('photo.' . (int)$this->config->get('config_language_id'));

			if (!$photo_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo i LEFT JOIN " . DB_PREFIX . "photo_description id ON (i.photo_id = id.photo_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$photo_data = $query->rows;

				$this->cache->set('photo.' . (int)$this->config->get('config_language_id'), $photo_data);
			}

			return $photo_data;
		}
	}

	public function getPhotoDescriptions($photo_id) {
		$photo_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo_description WHERE photo_id = '" . (int)$photo_id . "'");

		foreach ($query->rows as $result) {
			$photo_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'	       => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $photo_description_data;
	}

	public function getPhotoStores($photo_id) {
		$photo_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo_to_store WHERE photo_id = '" . (int)$photo_id . "'");

		foreach ($query->rows as $result) {
			$photo_store_data[] = $result['store_id'];
		}

		return $photo_store_data;
	}

	public function getPhotoLayouts($photo_id) {
		$photo_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo_to_layout WHERE photo_id = '" . (int)$photo_id . "'");

		foreach ($query->rows as $result) {
			$photo_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $photo_layout_data;
	}

	public function getTotalPhotos() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "photo");

		return $query->row['total'];
	}

	public function getTotalPhotosByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "photo_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}

    public function getPhotoImages($photo_id) {
        $photo_image_data = array();

        $photo_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo_image WHERE photo_id = '" . (int)$photo_id . "' ORDER BY sort_order ASC");

        foreach ($photo_image_query->rows as $photo_image) {
            $photo_image_data[$photo_image['language_id']][] = array(
                'title'      => $photo_image['title'],
                'link'       => $photo_image['link'],
                'image'      => $photo_image['image'],
                'sort_order' => $photo_image['sort_order']
            );
        }

        return $photo_image_data;
    }
}
