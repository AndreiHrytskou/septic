<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelPortfolioVideo extends Model {
	public function addVideo($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "video SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', url = '" . $data['url'] . "', preview = '" . $data['preview'] . "', noindex = '" . (int)$data['noindex'] . "'");

		$video_id = $this->db->getLastId();

		foreach ($data['video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['video_store'])) {
			foreach ($data['video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['video_layout'])) {
			foreach ($data['video_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "video_to_layout SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video');

		return $video_id;
	}

	public function editVideo($video_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "video SET sort_order = '" . (int)$data['sort_order'] . "', bottom = '" . (isset($data['bottom']) ? (int)$data['bottom'] : 0) . "', status = '" . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "', url = '" . $data['url'] . "', preview = '" . $data['preview'] . "' WHERE video_id = '" . (int)$video_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

		foreach ($data['video_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "video_description SET video_id = '" . (int)$video_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");

		if (isset($data['video_store'])) {
			foreach ($data['video_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "video_to_store SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");

		if (isset($data['video_layout'])) {
			foreach ($data['video_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "video_to_layout SET video_id = '" . (int)$video_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'video_id=" . (int)$video_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('video');
	}

	public function editVideoStatus($video_id, $status) {
        $this->db->query("UPDATE " . DB_PREFIX . "video SET status = '" . (int)$status . "'WHERE video_id = '" . (int)$video_id . "'");

		$this->cache->delete('video');

    }

	public function deleteVideo($video_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "'");

		$this->cache->delete('video');
	}

	public function getVideo($video_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'video_id=" . (int)$video_id . "') AS keyword FROM " . DB_PREFIX . "video WHERE video_id = '" . (int)$video_id . "'");

		return $query->row;
	}

	public function getVideos($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "video i LEFT JOIN " . DB_PREFIX . "video_description id ON (i.video_id = id.video_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
			$video_data = $this->cache->get('video.' . (int)$this->config->get('config_language_id'));

			if (!$video_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video i LEFT JOIN " . DB_PREFIX . "video_description id ON (i.video_id = id.video_id) WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY id.title");

				$video_data = $query->rows;

				$this->cache->set('video.' . (int)$this->config->get('config_language_id'), $video_data);
			}

			return $video_data;
		}
	}

	public function getVideoDescriptions($video_id) {
		$video_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_description WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_description_data[$result['language_id']] = array(
				'title'            => $result['title'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_h1'	       => $result['meta_h1'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword']
			);
		}

		return $video_description_data;
	}

	public function getVideoStores($video_id) {
		$video_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_to_store WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_store_data[] = $result['store_id'];
		}

		return $video_store_data;
	}

	public function getVideoLayouts($video_id) {
		$video_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "video_to_layout WHERE video_id = '" . (int)$video_id . "'");

		foreach ($query->rows as $result) {
			$video_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $video_layout_data;
	}

	public function getTotalVideos() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video");

		return $query->row['total'];
	}

	public function getTotalVideosByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "video_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}
