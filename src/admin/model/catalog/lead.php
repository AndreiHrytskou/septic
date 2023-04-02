<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelCatalogLead extends Model {
	public function addLead($data) {
        $data['status'] = isset($data['status']) ? $data['status'] : 0;
        $data['sort_order'] = isset($data['sort_order']) ? $data['sort_order'] : 0;
        $data['noindex'] = isset($data['noindex']) ? $data['noindex'] : 1;

		$this->db->query("INSERT INTO " . DB_PREFIX . "lead SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', phone = '" . $data['phone'] . "', comment = '" . $data['comment'] . "', name = '" . $data['name'] . "', noindex = '" . (int)$data['noindex'] . "'");

		$lead_id = $this->db->getLastId();

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		$this->cache->delete('lead');

		return $lead_id;
	}

	public function editLead($lead_id, $data) {
        $data['status'] = isset($data['status']) ? $data['status'] : 0;
        $data['sort_order'] = isset($data['sort_order']) ? $data['sort_order'] : 0;
        $data['noindex'] = isset($data['noindex']) ? $data['noindex'] : 1;

		$this->db->query("UPDATE " . DB_PREFIX . "lead SET sort_order = '" . (int)$data['sort_order'] . "', name = '"  . $data['name'] . "', phone = '"  . $data['phone'] . "', comment = '"  . $data['comment'] . "', status = '"  . (int)$data['status'] . "', noindex = '" . (int)$data['noindex'] . "' WHERE lead_id = '" . (int)$lead_id . "'");

		$this->cache->delete('seo_pro');
		$this->cache->delete('seo_url');

		$this->cache->delete('lead');
	}

	public function deleteLead($lead_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "lead WHERE lead_id = '" . (int)$lead_id . "'");
		$this->cache->delete('lead');
	}

	public function getLead($lead_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "lead WHERE lead_id = '" . (int)$lead_id . "'");

		return $query->row;
	}
//
	public function getLeads($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "lead";

			if (!empty($data['filter_name'])) {
				$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}

			$sort_data = array(
				'name',
				'sort_order'
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

		} else {
//			$lead_data = $this->cache->get('lead.' . (int)$this->config->get('config_language_id'));
//
//			if (!$lead_data) {
//				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lead");
//
//				$lead_data = $query->rows;
//
//				$this->cache->set('lead.' . (int)$this->config->get('config_language_id'), $lead_data);
//			}
//
//			return $lead_data;
		}
	}

	public function getTotalLeads() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "lead");

		return $query->row['total'];
	}

}
