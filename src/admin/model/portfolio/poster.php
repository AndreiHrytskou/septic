<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelPortfolioPoster extends Model {
	public function addPoster($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "poster SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "'");

		$poster_id = $this->db->getLastId();

		if (isset($data['poster_image'])) {
			foreach ($data['poster_image'] as $language_id => $value) {
				foreach ($value as $poster_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "poster_image SET poster_id = '" . (int)$poster_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($poster_image['title']) . "', link = '" .  $this->db->escape($poster_image['link']) . "', image = '" .  $this->db->escape($poster_image['image']) . "', image_mobile = '" .  $this->db->escape($poster_image['image_mobile']) . "', sort_order = '" .  (int)$poster_image['sort_order'] . "'");
				}
			}
		}

		return $poster_id;
	}

	public function editPoster($poster_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "poster SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "' WHERE poster_id = '" . (int)$poster_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "poster_image WHERE poster_id = '" . (int)$poster_id . "'");

		if (isset($data['poster_image'])) {
			foreach ($data['poster_image'] as $language_id => $value) {
				foreach ($value as $poster_image) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "poster_image SET poster_id = '" . (int)$poster_id . "', language_id = '" . (int)$language_id . "', title = '" .  $this->db->escape($poster_image['title']) . "', link = '" .  $this->db->escape($poster_image['link']) . "', image = '" .  $this->db->escape($poster_image['image']) . "', image_mobile = '" .  $this->db->escape($poster_image['image_mobile']) . "', sort_order = '" . (int)$poster_image['sort_order'] . "'");
				}
			}
		}
	}

	public function deletePoster($poster_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "poster WHERE poster_id = '" . (int)$poster_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "poster_image WHERE poster_id = '" . (int)$poster_id . "'");
	}

	public function getPoster($poster_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "poster WHERE poster_id = '" . (int)$poster_id . "'");

		return $query->row;
	}

	public function getPosters($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "poster";

		$sort_data = array(
			'name',
			'status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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
	}

	public function getPosterImages($poster_id) {
		$poster_image_data = array();

		$poster_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "poster_image WHERE poster_id = '" . (int)$poster_id . "' ORDER BY sort_order ASC");

		foreach ($poster_image_query->rows as $poster_image) {
			$poster_image_data[$poster_image['language_id']][] = array(
				'title'      => $poster_image['title'],
				'link'       => $poster_image['link'],
				'image'      => $poster_image['image'],
				'image_mobile'      => $poster_image['image_mobile'],
				'sort_order' => $poster_image['sort_order']
			);
		}

		return $poster_image_data;
	}

	public function getTotalPosters() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "poster");

		return $query->row['total'];
	}
}
