<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelPortfolioPhoto extends Model {
	public function getPhoto($photo_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "photo i LEFT JOIN " . DB_PREFIX . "photo_description id ON (i.photo_id = id.photo_id) LEFT JOIN " . DB_PREFIX . "photo_to_store i2s ON (i.photo_id = i2s.photo_id) WHERE i.photo_id = '" . (int)$photo_id . "' AND id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND i.status = '1'");

		return $query->row;
	}

	public function getPhotos($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "photo i LEFT JOIN " . DB_PREFIX . "photo_description id ON (i.photo_id = id.photo_id) LEFT JOIN " . DB_PREFIX . "photo_to_store i2s ON (i.photo_id = i2s.photo_id) WHERE ";

        if($data["manufacturer_id"] && $data["manufacturer_id"] != ''){
            $sql .= "manufacturer_id = '" .$data["manufacturer_id"] . "' AND";
        }

        $sql .= " id.language_id = '" . (int)$this->config->get('config_language_id') . "' AND i2s.store_id = '" . (int)$this->config->get('config_store_id') ."' AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) DESC";

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

	public function getPhotoLayoutId($photo_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "photo_to_layout WHERE photo_id = '" . (int)$photo_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
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

    public function getManufacturers($data) {
        $sql = "SELECT * FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id IN (" .$data . ")";

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getManufacturersIds() {
        $sql = "SELECT DISTINCT manufacturer_id FROM " . DB_PREFIX . "photo" ;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalPhotos($manufacturer_id) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "photo";

        if(isset($manufacturer_id) && $manufacturer_id != ''){
            $sql .= " WHERE manufacturer_id = '" .$manufacturer_id ."'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }
}