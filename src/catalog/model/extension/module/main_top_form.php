<?php
// *	@copyright	OPENCART.PRO 2011 - 2017.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelExtensionModuleMainTopForm extends Model {
    public function getPoster($poster_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "poster WHERE poster_id = '" . (int)$poster_id . "'");

        return $query->row;
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
}