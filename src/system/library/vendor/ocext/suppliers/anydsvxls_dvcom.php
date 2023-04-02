<?php
class anyDSVXLSdvcom { 
    private $data = array();
    private $path_oc_version;
    private $language;
    private $db;
    private $feed_setting = array(
        'memory_usage' => 0,
        'params_as_column'=>1,
        'group_attribute_name'=>'Характеристики',
        'max_nodes_to_write'=>1000,
        'features_detail'=>1,
        'delimeter_option_value'=>'####',
        'attribute_whis_group'=>0,
        'option_value_by_column'=>'name_column',
        'offers'=>array(),
        'cache_offers'=>array(),
        'first_row'=>array(),
        'memory_usage'=>0,
        'max_exe_time'=>0,
        'count_rows'=>0,
        'delete_columns'=>array(),
        'attribute_columns'=>array(),
        'option_columns'=>array(),
        'option_type'=>'select',
        'categories'=>array(),
        'delete_by_category_id'=>array(),
        'delete_by_vendor'=>array(),
        'set_products_by_category_id' => array(),
        'category_path'=>array()
    );
    private $settings = array(
        'count_product_on_sec' => 5,
        'max_limit' => 30,
    );
    private $specification = array(
        'name' => "dvcom",
        'id_specification' => "dvcom___1_0_0_0",
        'version' => "1_0_0_0",
        'encoding' => 'UTF-8',
        'check_valid_status' => FALSE
    );
    private $feed_cache = array(
            'status'=>0,
            'count_nodes'=>1000,
            'offers_file_name_prefix'=>'oanydsvxlsym_dvcom_cache_',
            'categories_file_name_prefix'=>'oanydsvxlsym_dvcom_cats_cache_',
            'offers_file_name_prefix_csv'=>'dvcom_csv_'
    );

    public function __construct($registry,$path_oc_version,$language,$load,$feed_setting=array()) {
        $this->registry = $registry;
        $this->language = $language;
        $this->db = $registry->get('db');
        $this->load = $load;
        $this->path_oc_version = $path_oc_version;
        if($feed_setting){
            foreach ($feed_setting as $feed_setting_name => $feed_setting_value){
                $this->feed_setting[$feed_setting_name] = $feed_setting_value;
            }
        }
    }
    
    public function get($key) {
            return (isset($this->data[$key]) ? $this->data[$key] : null);
    }
    
    public function getProp($prop) {
            return (isset($this->{$prop}) ? $this->{$prop} : null);
    }
    
    public function getSpec() {
            return $this->specification;
    }
    
    public function getData() {
            return $this->data;
    }

    public function set($key, $value) {
            $this->data[$key] = $value;
    }
    
    public function updateMaxMemoryUsage() {
        if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

            $this->feed_setting['memory_usage'] = memory_get_usage();

        }
    }
    
    public function viewData($template_data_on_step_one) {
        
        if(!isset($template_data_on_step_one['dvcom_count_product_on_sec'])){
            
            $template_data_on_step_one['dvcom_count_product_on_sec'] = $this->settings['count_product_on_sec'];
            
        }
        
        if(!isset($template_data_on_step_one['dvcom_max_limit'])){
            
            $template_data_on_step_one['dvcom_max_limit'] = $this->settings['max_limit'];
            
        }
        
        $data['tamplate_data_selected'] = $template_data_on_step_one;
        
        $data['supplier_feed_source'] = $this->specification['id_specification'];
        
        return $data;
        
    }
    
    public function view($template_file,$data) {
        
        $file = DIR_SYSTEM.'library/vendor/ocext/suppliers/' . $template_file;
        
        $output = '';

        if (is_file($file)) {
            
                extract($data);

                ob_start();

                require($file);

                $output = ob_get_clean();
                
        }
        
        return $output;
        
    }
    
    public function feedToDSV($filename,$template_data){
        
        $find = array('<yml_catalog>','</yml_catalog>','<products>',   '</products>', '<product>','</product>');
        
        $replace = array('<yml_catalog><shop2>','</shop2></yml_catalog>','<offers2>',   '</offers2>', '<element>','</element>');
        
        $this->replaceAndConvert($filename,$find,$replace);
        
        $result = array('error'=>'','file_upload'=>'');
        
        $tags = array('shop2'=>array('offers2'=>array('element')));
        
        $tags_new_names = array(
            'yml_catalog'=>'yml_catalog',
            'shop'=>'shop',
            'products'=>'products',
            'product'=>'product',
            'categories'=>'categories',
            'category'=>'category',
        );
        
        $this->getYMLCategories($filename,$template_data, array('yml_catalog'=>array('shop2'=>array('categories'=>array('category')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'color_groups', array('yml_catalog'=>array('shop2'=>array('color_groups'=>array('color_groups')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'color', array('yml_catalog'=>array('shop2'=>array('colors'=>array('color')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'glass', array('yml_catalog'=>array('shop2'=>array('glasses'=>array('glass')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'accessory_group', array('yml_catalog'=>array('shop2'=>array('accessory_groups'=>array('accessory_group')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'accessory', array('yml_catalog'=>array('shop2'=>array('accessories'=>array('accessory')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'trademark', array('yml_catalog'=>array('shop2'=>array('trademarks'=>array('trademark')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'property', array('yml_catalog'=>array('shop2'=>array('properties'=>array('property')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getXMLParams($filename,$template_data,'property_value', array('yml_catalog'=>array('shop2'=>array('property_values'=>array('property_value')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->feed_setting['delete_by_vendor'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_by_vendor']);
        
        $option_columns = $this->getArrayByDelimeterAndString($template_data['dvcom_option_columns']);
        
        $attribute_columns = $this->getArrayByDelimeterAndString($template_data['dvcom_attribute_columns']);
        
        $delete_columns = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_columns']);
        
        $this->feed_setting['group_attribute_name'] = $this->getStringFromSetting($template_data['dvcom_group_attribute_name']);
        
        $this->feed_setting['option_color_name'] = $this->getStringFromSetting($template_data['dvcom_option_color_name']);;
        
        $this->feed_setting['option_color_group_name'] = $this->getStringFromSetting($template_data['dvcom_option_color_group_name']);;
        
        $this->feed_setting['option_glass_name'] = $this->getStringFromSetting($template_data['dvcom_option_glass_name']);;
        
        $this->feed_setting['accessory_group_name'] = $this->getStringFromSetting($template_data['dvcom_accessory_group_name']);;

        $this->feed_setting['option_options_name'] = $this->getStringFromSetting($template_data['dvcom_option_options_name']);;
        
        $this->feed_setting['delete_columns'] = $delete_columns;
        
        $this->feed_setting['attribute_columns'] = $attribute_columns;
        
        $this->feed_setting['option_columns'] = $option_columns;
        
        $this->feed_setting['option_value_by_column'] = $template_data['dvcom_option_value_by_column'];
        
        $this->feed_setting['option_type'] = $template_data['dvcom_option_type'];
        
        $this->feed_setting['params_as_column'] = $template_data['dvcom_params_as_column'];
        
        if($template_data['dvcom_max_curl_timeout'] && $template_data['dvcom_max_curl_timeout']!=='' && $template_data['dvcom_max_curl_timeout']<600){
            
            $this->settings['max_curl_timeout'] = $template_data['dvcom_max_curl_timeout']*1000;
            
        }
        
        $this->feed_setting['option_whis_image'] = array();
        
        if(isset($template_data['dvcom_option_whis_image'])){
            
            $this->feed_setting['option_whis_image'] = $this->getArrayByDelimeterAndString($template_data['dvcom_option_whis_image']);
            
        }
        
        $this->feed_setting['select_params_as_column'] = $this->getArrayByDelimeterAndString($template_data['dvcom_select_params_as_column']);
        
        $this->feed_setting['delete_params'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_params']);
        
        $this->feed_setting['start_offer'] = (int)$template_data['dvcom_start_offer'];
        
        if($this->feed_setting['start_offer']==1){
            
            $this->feed_setting['start_offer'] = 0;
            
        }
        
        $this->feed_setting['limit_offer'] = trim($template_data['dvcom_limit_offer']);
        
        if($this->feed_setting['limit_offer']===''){
            
            $this->feed_setting['limit_offer'] = 1000000;
            
        }else{
            
            $this->feed_setting['limit_offer'] = (int)$this->feed_setting['limit_offer'];
            
        }
        
        $result = $this->getCSVFromYML($filename,$template_data, $tags, 1, $tags_new_names, $this->feed_setting['start_offer'], $this->feed_setting['limit_offer'],  '', 0);
        
        if($result['file_upload'] && is_string($result['file_upload']) && is_file(DIR_DOWNLOAD.$result['file_upload'])){
            
            $result['file_upload'] = $result['file_upload'];
            
        }
        
        return $result;
        
    }
    
    public function getXMLNodeData($filename,$template_data,$branch) {
        
        $myXML = new XMLReader();
        
        $this->feed_setting['time_start'] = time();
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
        
        $this_branch = '';
        
        while ($myXML->read()) {
            
            if($myXML->nodeType == XMLReader::ELEMENT){
                
                $tag = $myXML->name;
                
                $this_branch = explode("__", $this_branch);
                
                $this_branch[] = $tag;
                
                $this_branch = implode("__", $this_branch);
                
                echo $this_branch.'<br>';
                
            }
            elseif($myXML->nodeType == XMLReader::END_ELEMENT){
                
                $this_branch = explode("__", $this_branch);
                
                unset($this_branch[count($this_branch)-1]);
                
                $this_branch = implode("__", $this_branch);
                
                echo $this_branch.'<br>';
                
            }
            
        }
        
    }

    public function getYMLCategories($filename,$template_data,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
        //var_dump($template_data);exit();  
        
        $myXML = new XMLReader();
        
        $this->feed_setting['time_start'] = time();
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
                                    
        $count_subnodes = 0;
        
        $this_num_row = 0;
        
        $first_write = 1;
        
        while ($myXML->read()) {
            
            $tag = $myXML->name;
            
            $outer_xml = '';
            
            $outer_xml_close = '';
            
            $tag_name = $tag;
                                            
            if(isset($tags_new_names[$tag])){

                $tag_name = $tags_new_names[$tag];

            }
            
            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag])) {
                
                while($myXML->read()) { 

                    $tag2 = $myXML->name;
                    
                    $tag_name = $tag;
                    
                    if(isset($tags_new_names[$tag])){
                        
                        $tag_name = $tags_new_names[$tag];
                        
                    }
                    
                    $tag_name2 = $tag2;
                                            
                    if(isset($tags_new_names[$tag2])){

                        $tag_name2 = $tags_new_names[$tag2];

                    }
                    
                    $outer_xml = '<'.$tag_name.'>';
                    
                    $outer_xml_close = '</'.$tag_name.'>';
                    
                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2])) {
                        
                        while($myXML->read()) {
                        
                            $tag3 = $myXML->name;
                            
                            $tag_name2 = $tag2;
                    
                            if(isset($tags_new_names[$tag2])){

                                $tag_name2 = $tags_new_names[$tag2];

                            }
                            
                            $tag_name3 = $tag3;
                                            
                            if(isset($tags_new_names[$tag3])){

                                $tag_name3 = $tags_new_names[$tag3];

                            }
                            
                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>';
                            
                            $outer_xml_close = '</'.$tag_name2.'>'.'</'.$tag_name.'>';

                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3])) {
                                
                                while($myXML->read()) {
                                    
                                    $tag4 = $myXML->name;
                                    
                                    $tag_name3 = $tag3;
                    
                                    if(isset($tags_new_names[$tag3])){

                                        $tag_name3 = $tags_new_names[$tag3];

                                    }
                                    
                                    $tag_name4 = $tag4;
                                            
                                    if(isset($tags_new_names[$tag4])){

                                        $tag_name4 = $tags_new_names[$tag4];

                                    }
                                    
                                    $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>';
                                    
                                    $outer_xml_close = '</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                    
                                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4])) {
                                        
                                        while($myXML->read()) {
                                            
                                            $tag5 = $myXML->name;
                                            
                                            $tag_name4 = $tag4;
                    
                                            if(isset($tags_new_names[$tag4])){

                                                $tag_name4 = $tags_new_names[$tag4];

                                            }
                                            
                                            $tag_name5 = $tag5;
                                            
                                            if(isset($tags_new_names[$tag5])){

                                                $tag_name5 = $tags_new_names[$tag5];

                                            }
                                             
                                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>'.'<'.$tag_name4.'>';
                                            
                                            $outer_xml_close = '</'.$tag_name4.'>'.'</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                            
                                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4][$tag5])) {
                                                
                                                $result['error'] = 'out of 5 nodes - выход за пять вложенных узлов';
                                                
                                            }
                                            elseif(in_array($tag5, $tags[$tag][$tag2][$tag3][$tag4])){
                                        
                                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                                    $xml_as_string = $myXML->readInnerXml();

                                                    if($xml_as_string){
                                                        
                                                        $count_subnodes++;

                                                        $inner_xml .= '<'.$tag_name5.'>'.$xml_as_string.'</'.$tag_name5.'>';

                                                        if($count_subnodes===$count_nodes){

                                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                                            $this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                                            $count_subnodes = 0;

                                                            $xml_cache = '';

                                                            $inner_xml = '';

                                                        }

                                                    }

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    elseif(in_array($tag4, $tags[$tag][$tag2][$tag3])){
                                        
                                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                            $xml_as_string = $myXML->readInnerXml();

                                            if($xml_as_string){
                                                
                                                $count_subnodes++;
                                                
                                                $inner_xml .= '<'.$tag_name4;
                                                
                                                $readOuterXml = $myXML->readOuterXml();
                                    
                                                if($readOuterXml && is_string($readOuterXml)){
                                                    
                                                    $xml_as_sxml = (array)simplexml_load_string($readOuterXml);

                                                    if(isset($xml_as_sxml['@attributes'])){

                                                        foreach ($xml_as_sxml['@attributes'] as $attribute_name => $attribute_value) {

                                                            $inner_xml .= ' '.$attribute_name.'="'.$attribute_value.'"';

                                                        }

                                                    }
                                                }
                                                
                                                $inner_xml .= '>'.$xml_as_string.'</'.$tag_name4.'>'.PHP_EOL;

                                                if($count_subnodes===$count_nodes){
                                                    
                                                    if($inner_xml && $tag_name4=='category'){
                                                        
                                                        $category_row = simplexml_load_string($inner_xml);
                                                        
                                                        $parent_id = 0;

                                                        $category_id = 0;

                                                        $name = '';

                                                        $attributes = (array)$category_row->attributes();

                                                        if(isset($category_row->id)){

                                                            $category_id = trim((string)$category_row->id);

                                                        }

                                                        if(isset($category_row->parent_id)){

                                                            $parent_id = trim((string)$category_row->parent_id);

                                                        }
                                                        
                                                        if(!$parent_id){
                                                            
                                                            $parent_id = 0;
                                                            
                                                        }

                                                        $name = trim((string)$category_row->title);
                                                        
                                                        if($name && $category_id){
                                                            
                                                            $this->feed_setting['categories'][$category_id] = array(
                                                                'category_id'  => $category_id,
                                                                'parent_id'  => $parent_id,
                                                                'name' => $name,
                                                            );
                                                            
                                                        }
                                                        
                                                    }

                                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;
                                                    
                                                    $count_subnodes = 0;
                                                    
                                                    $xml_cache = '';
                                                    
                                                    $inner_xml = '';

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }

                            }
                            
                            elseif(in_array($tag3, $tags[$tag][$tag2])){
                                        
                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                    $xml_as_string = $myXML->readInnerXml();

                                    if($xml_as_string){

                                        $count_subnodes++;

                                        $inner_xml .= '<'.$tag_name3.'>'.$xml_as_string.'</'.$tag_name3.'>'.PHP_EOL;;

                                        if($count_subnodes===$count_nodes){

                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                            $count_subnodes = 0;

                                            $xml_cache = '';

                                            $inner_xml = '';

                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }
                    elseif(in_array($tag2, $tags[$tag])){
                        
                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                            $xml_as_string = $myXML->readInnerXml();

                            if($xml_as_string){

                                $count_subnodes++;

                                $inner_xml .= '<'.$tag_name2.'>'.$xml_as_string.'</'.$tag_name2.'>'.PHP_EOL;

                                if($count_subnodes===$count_nodes){

                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                    $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                    $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                    //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                    $count_subnodes = 0;

                                    $xml_cache = '';

                                    $inner_xml = '';

                                }

                            }

                        }

                    }

                }
                
            }elseif(in_array($tag, $tags)){

                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                    $xml_as_string = $myXML->readInnerXml();

                    if($xml_as_string){

                        $count_subnodes++;

                        $inner_xml .= '<'.$tag_name.'>'.$xml_as_string.'</'.$tag_name.'>'.PHP_EOL;

                        if($count_subnodes===$count_nodes){

                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                            $count_subnodes = 0;

                            $xml_cache = '';

                            $inner_xml = '';

                        }

                    }

                }

            }
            
        }
        
        if($count_subnodes && $inner_xml!==''){
            
            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

            $count_subnodes = 0;

        }
        
        $myXML->close();
        
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_by_category_id']);
        
        $this->feed_setting['set_products_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_set_products_by_category_id']);
        
        foreach ($this->feed_setting['categories'] as $category_id => $category) {
            
            if(!$this->feed_setting['delete_by_category_id'] || !in_array($category_id, $this->feed_setting['delete_by_category_id'])/* && (!$this->feed_setting['set_products_by_category_id'] || in_array($category_id, $this->feed_setting['set_products_by_category_id']))*/ ){
                
                $this->feed_setting['category_path'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['name'],'/','name');
                
                
                
            }
            
            $this->feed_setting['category_path_by_category_id'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['category_id'],'____','category_id','____');
            
        }
        
        $this->feed_setting['categories'] = array();
        
        return $result;
        
    }
    
    public function getXMLParams($filename,$template_data,$node_name,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
        $myXML = new XMLReader();
        
        $this->feed_setting['time_start'] = time();
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
                                    
        $count_subnodes = 0;
        
        $this_num_row = 0;
        
        $first_write = 1;
        
        while ($myXML->read()) {
            
            $tag = $myXML->name;
            
            $outer_xml = '';
            
            $outer_xml_close = '';
            
            $tag_name = $tag;
                                            
            if(isset($tags_new_names[$tag])){

                $tag_name = $tags_new_names[$tag];

            }
            
            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag])) {
                
                while($myXML->read()) { 

                    $tag2 = $myXML->name;
                    
                    $tag_name = $tag;
                    
                    if(isset($tags_new_names[$tag])){
                        
                        $tag_name = $tags_new_names[$tag];
                        
                    }
                    
                    $tag_name2 = $tag2;
                                            
                    if(isset($tags_new_names[$tag2])){

                        $tag_name2 = $tags_new_names[$tag2];

                    }
                    
                    $outer_xml = '<'.$tag_name.'>';
                    
                    $outer_xml_close = '</'.$tag_name.'>';
                    
                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2])) {
                        
                        while($myXML->read()) {
                        
                            $tag3 = $myXML->name;
                            
                            $tag_name2 = $tag2;
                    
                            if(isset($tags_new_names[$tag2])){

                                $tag_name2 = $tags_new_names[$tag2];

                            }
                            
                            $tag_name3 = $tag3;
                                            
                            if(isset($tags_new_names[$tag3])){

                                $tag_name3 = $tags_new_names[$tag3];

                            }
                            
                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>';
                            
                            $outer_xml_close = '</'.$tag_name2.'>'.'</'.$tag_name.'>';

                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3])) {
                                
                                while($myXML->read()) {
                                    
                                    $tag4 = $myXML->name;
                                    
                                    $tag_name3 = $tag3;
                    
                                    if(isset($tags_new_names[$tag3])){

                                        $tag_name3 = $tags_new_names[$tag3];

                                    }
                                    
                                    $tag_name4 = $tag4;
                                            
                                    if(isset($tags_new_names[$tag4])){

                                        $tag_name4 = $tags_new_names[$tag4];

                                    }
                                    
                                    $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>';
                                    
                                    $outer_xml_close = '</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                    
                                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4])) {
                                        
                                        while($myXML->read()) {
                                            
                                            $tag5 = $myXML->name;
                                            
                                            $tag_name4 = $tag4;
                    
                                            if(isset($tags_new_names[$tag4])){

                                                $tag_name4 = $tags_new_names[$tag4];

                                            }
                                            
                                            $tag_name5 = $tag5;
                                            
                                            if(isset($tags_new_names[$tag5])){

                                                $tag_name5 = $tags_new_names[$tag5];

                                            }
                                             
                                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>'.'<'.$tag_name4.'>';
                                            
                                            $outer_xml_close = '</'.$tag_name4.'>'.'</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                            
                                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4][$tag5])) {
                                                
                                                $result['error'] = 'out of 5 nodes - выход за пять вложенных узлов';
                                                
                                            }
                                            elseif(in_array($tag5, $tags[$tag][$tag2][$tag3][$tag4])){
                                        
                                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                                    $xml_as_string = $myXML->readInnerXml();

                                                    if($xml_as_string){
                                                        
                                                        $count_subnodes++;

                                                        $inner_xml .= '<'.$tag_name5.'>'.$xml_as_string.'</'.$tag_name5.'>';

                                                        if($count_subnodes===$count_nodes){

                                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                                            $this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                                            $count_subnodes = 0;

                                                            $xml_cache = '';

                                                            $inner_xml = '';

                                                        }

                                                    }

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    elseif(in_array($tag4, $tags[$tag][$tag2][$tag3])){
                                        
                                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                            $xml_as_string = $myXML->readInnerXml();

                                            if($xml_as_string){
                                                
                                                $count_subnodes++;
                                                
                                                $inner_xml .= '<'.$tag_name4;
                                                
                                                $readOuterXml = $myXML->readOuterXml();
                                    
                                                if($readOuterXml && is_string($readOuterXml)){
                                                    
                                                    $xml_as_sxml = (array)simplexml_load_string($readOuterXml);

                                                    if(isset($xml_as_sxml['@attributes'])){

                                                        foreach ($xml_as_sxml['@attributes'] as $attribute_name => $attribute_value) {

                                                            $inner_xml .= ' '.$attribute_name.'="'.$attribute_value.'"';

                                                        }

                                                    }
                                                }
                                                
                                                $inner_xml .= '>'.$xml_as_string.'</'.$tag_name4.'>'.PHP_EOL;

                                                if($count_subnodes===$count_nodes){
                                                    
                                                    if($inner_xml && $tag_name4==$node_name){
                                                        
                                                        $node = simplexml_load_string($inner_xml);

                                                        $id = 0;

                                                        $attributes = (array)$node->attributes();

                                                        if(isset($node->id)){

                                                            $id = trim((string)$node->id);

                                                        }
                                                        
                                                        if($id){
                                                            
                                                            if($node_name=='accessory'){
                                                                
                                                                foreach ($node as $node_tag_name => $node_tag) {
                                                                    
                                                                    if((string)$node_tag_name=='pictures'){
                                                                        
                                                                        $node_tag_name = 'picture';
                                                                        
                                                                        $node_tag = (string)$node_tag->large;
                                                                        
                                                                        $this->feed_setting[$node_name][$id][$node_tag_name] = $node_tag;
                                                                        
                                                                    }
                                                                    else{
                                                                        
                                                                        $this->feed_setting[$node_name][$id][(string)$node_tag_name] = (string)$node_tag;
                                                                        
                                                                    }
                                                                    
                                                                }
                                                                
                                                                $this->feed_setting[$node_name][$id]['accessory_group_data'] = array();
                                                                
                                                                if(isset($node->accessory_group_id) && isset($this->feed_setting['accessory_group'][(string)$node->accessory_group_id])){
                                                                    
                                                                    $this->feed_setting[$node_name][$id]['accessory_group_data'] = $this->feed_setting['accessory_group'][(string)$node->accessory_group_id];
                                                                    
                                                                }
                                                                
                                                            }
                                                            elseif($node_name=='color'){
                                                                
                                                                foreach ($node as $node_tag_name => $node_tag) {
                                                                    
                                                                    $this->feed_setting[$node_name][$id][(string)$node_tag_name] = (string)$node_tag;
                                                                    
                                                                }
                                                                
                                                                $this->feed_setting[$node_name][$id]['color_group_data'] = array();
                                                                
                                                                if(isset($node->color_group_id) && isset($this->feed_setting['color_groups'][(string)$node->color_group_id])){
                                                                    
                                                                    $this->feed_setting[$node_name][$id]['color_group_data'] = $this->feed_setting['color_groups'][(string)$node->color_group_id];
                                                                    
                                                                }
                                                                
                                                            }
                                                            else{
                                                                
                                                                foreach ($node as $node_tag_name => $node_tag) {
                                                                    
                                                                    $this->feed_setting[$node_name][$id][(string)$node_tag_name] = (string)$node_tag;
                                                                    
                                                                }
                                                                
                                                            }
                                                            
                                                            
                                                        }
                                                        
                                                    }

                                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;
                                                    
                                                    $count_subnodes = 0;
                                                    
                                                    $xml_cache = '';
                                                    
                                                    $inner_xml = '';

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }

                            }
                            
                            elseif(in_array($tag3, $tags[$tag][$tag2])){
                                        
                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                    $xml_as_string = $myXML->readInnerXml();

                                    if($xml_as_string){

                                        $count_subnodes++;

                                        $inner_xml .= '<'.$tag_name3.'>'.$xml_as_string.'</'.$tag_name3.'>'.PHP_EOL;;

                                        if($count_subnodes===$count_nodes){

                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                            $count_subnodes = 0;

                                            $xml_cache = '';

                                            $inner_xml = '';

                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }
                    elseif(in_array($tag2, $tags[$tag])){
                        
                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                            $xml_as_string = $myXML->readInnerXml();

                            if($xml_as_string){

                                $count_subnodes++;

                                $inner_xml .= '<'.$tag_name2.'>'.$xml_as_string.'</'.$tag_name2.'>'.PHP_EOL;

                                if($count_subnodes===$count_nodes){

                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                    $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                    $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                    //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                    $count_subnodes = 0;

                                    $xml_cache = '';

                                    $inner_xml = '';

                                }

                            }

                        }

                    }

                }
                
            }elseif(in_array($tag, $tags)){

                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                    $xml_as_string = $myXML->readInnerXml();

                    if($xml_as_string){

                        $count_subnodes++;

                        $inner_xml .= '<'.$tag_name.'>'.$xml_as_string.'</'.$tag_name.'>'.PHP_EOL;

                        if($count_subnodes===$count_nodes){

                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                            $count_subnodes = 0;

                            $xml_cache = '';

                            $inner_xml = '';

                        }

                    }

                }

            }
            
        }
        
        if($count_subnodes && $inner_xml!==''){
            
            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

            $count_subnodes = 0;

        }
        
        $myXML->close();
        
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_by_category_id']);
        
        $this->feed_setting['set_products_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_set_products_by_category_id']);
        
        foreach ($this->feed_setting['categories'] as $category_id => $category) {
            
            if(!$this->feed_setting['delete_by_category_id'] || !in_array($category_id, $this->feed_setting['delete_by_category_id'])/* && (!$this->feed_setting['set_products_by_category_id'] || in_array($category_id, $this->feed_setting['set_products_by_category_id']))*/ ){
                
                $this->feed_setting['category_path'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['name'],'/','name');
                
                
                
            }
            
            $this->feed_setting['category_path_by_category_id'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['category_id'],'____','category_id','____');
            
        }
        
        $this->feed_setting['categories'] = array();
        
        return $result;
        
    }

    
    public function getCSVFromSource($filename,$template_data,$start=0,$limit=30){
        
        $handle = fopen($filename,'r');
        
        $this_row = 0;
        
        $setting = $this->db->query("SELECT * FROM " . DB_PREFIX ."prime_sport_ru_wsdl_setting WHERE code = 'setting' ");
        
        if(isset($setting->row['value'])){
            
            $setting = json_decode($setting->row['value'],TRUE);
            
        }
        else{
            
            $setting = array();
            
        }
        
        if(!$setting || !$setting['prime_sport_ru_host'] || !$setting['login'] || !$setting['password']){
            
            return '';
            
        }
        
        $options = array(
            'login' => $setting['login'],
            'password' => $setting['password'],
        );
        
        $client = new SoapClient($setting['prime_sport_ru_host'], $options);
        
        $time = time();
        
        $count_product_on_sec = 0;
        
        $this->feed_setting['offers'] = array();
        
        $dvcom_categories_as_string = array();
        
        if(isset($template_data['dvcom_categories_as_string']) && $template_data['dvcom_categories_as_string']!==''){
            
            $dvcom_categories_as_string = explode(PHP_EOL, $template_data['dvcom_categories_as_string']);
            
            foreach ($dvcom_categories_as_string as $key => $value) {
                
                $dvcom_categories_as_string[$key] = html_entity_decode(trim(strtoupper($value)));
                
                if(!$dvcom_categories_as_string[$key]){
                    unset($dvcom_categories_as_string[$key]);
                }
                
            }
            
        }
        
        if($start==1){
            //$start--;
        }
        
        while (($data = fgetcsv($handle, 0, $template_data['csv_delimiter'], $template_data['csv_enclosure'], $template_data['csv_escape'])) !== FALSE) {
            
            if( $this_row >= $start && $this_row < ($start+$limit) ){
                
                $count_product_on_sec++;
                
                if( ($time-time())>=0 && $count_product_on_sec>=$this->feed_setting['count_product_on_sec'] ){
                    
                    sleep(1);
                    
                    $time = time();
        
                    $count_product_on_sec = 0;
                    
                }
                $error = FALSE;
                //$data[0] = 10877;
                try {
                    $product = (array)$client->getProduct((int)$data[0]);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                
                //var_dump($product);exit();
                
                if(!$error && isset($product['code'])){
                    
                    $offer = array();
                    
                    $atributes = array();
                    
                    $options_oc = array();
                    
                    $picture = array();
                    
                    $category = array();
                    
                    $prices = array();
                    
                    $quantity = 0;
                    
                    $skip_by_category = FALSE;
                    
                    foreach ($product as $field => $value) {
                        
                        $this->feed_setting['first_row']['productId'] = 'productId';
                        
                        if($field=='category'){
                            
                            $value = (array)$value;
                            
                            if(isset($value['_'])){
                                
                                $value = $value['_'];
                                
                            }
                            else{
                                
                                foreach ($value as $p) {

                                    $p = (array)$p;
                                    
                                    if(isset($p['_'])){
                                
                                        $category[] = $p['_'];

                                    }
                                    
                                }
                                
                                $value = implode('---', $category);
                                
                            }
                            
                            if($dvcom_categories_as_string){
                                
                                $skip_by_category = TRUE;
                                
                                foreach ($dvcom_categories_as_string as $category) {
                                
                                    if(strstr($value, $category)){
                                        
                                        $skip_by_category = FALSE;
                                        
                                    }
                                    
                                }
                                
                            }
                            
                        }
                        elseif($field=='description'){
                            
                            $description = explode("Характеристики:", $value);
                            
                            $description2 = explode("Размеры", $value);
                            
                            $delete = array("Таблица размеров",'Размеры','Название','Описание');
                            
                            if(isset($description[1]) && $description[1]){
                                
                                $attributes_source = explode(PHP_EOL, $description[1]);
                                
                                foreach ($attributes_source as $attributes_source_row) {
                                    
                                    $attributes_source_row = explode(":", strip_tags(html_entity_decode($attributes_source_row)));
                                    
                                    if(isset($attributes_source_row[1]) && !in_array($attributes_source_row[0], $delete)){
                                        
                                        $atributes[] = trim($attributes_source_row[0]).'---'.trim($attributes_source_row[1]);
                                        
                                    }
                                    
                                }
                                
                                $atributes = implode('|', $atributes);
                                
                            }
                            elseif(isset($description2[0]) && $description2[0]){
                                
                                $attributes_source = explode(PHP_EOL, $value);
                                
                                $description[0] = $value;
                                
                                foreach ($attributes_source as $attributes_source_row) {
                                    
                                    $attributes_source_row = explode(":", strip_tags(html_entity_decode($attributes_source_row)));
                                    
                                    if(isset($attributes_source_row[1]) && !in_array($attributes_source_row[0], $delete)){
                                        
                                        $atributes[] = trim($attributes_source_row[0]).'---'.trim($attributes_source_row[1]);
                                        
                                    }
                                    
                                }
                                
                                $atributes = implode('|', $atributes);
                                
                            }
                            else{
                                
                                foreach ($delete as $delete_string) {
                                        
                                    if(strstr($description[0],$delete_string)){

                                        $description = explode("Таблица размеров:", $description[0]);

                                    }

                                }
                                
                            }
                            
                            $value = $description[0];
                            
                        }
                        elseif($field=='picture'){
                            
                            $value = (array)$value;
                            
                            if(isset($value['_']) && isset($value['source']) && ($value['source']=='detail' || $value['source']=='more') ){
                                
                                $value = $value['_'];
                                
                            }
                            elseif(is_array($value) && !isset($value['_'])){
                                
                                foreach ($value as $p) {

                                    $p = (array)$p;
                                    
                                    if(isset($p['_']) && isset($p['source']) && ($p['source']=='detail' || $p['source']=='more') ){
                                
                                        $picture[] = $p['_'];

                                    }
                                    
                                }
                                
                                $value = implode(',', $picture);
                                
                            }
                            else{
                                
                                $value = '';
                                
                            }
                            
                        }
                        elseif($field=='size'){
                            
                            
                            
                            $value = (array)$value;
                            
                            if(isset($value['price'])){
                                
                                if(isset($value['quantity'])){

                                    $quantity = $value['quantity'];

                                }

                                $value['price'] = (array)$value['price'];
                                    
                                foreach ($value['price'] as $variant) {

                                    $variant = (array)$variant;

                                    $price = $variant['_'];

                                    $name = $variant['name'];

                                    $prices[$name] = $price;

                                    //$options_oc["select|Вариант|".$name."|0|".$quantity."|0|+|".$price."|-|0|+|0"] = "select|Вариант|".$name."|0|".$quantity."|0|+|".$price."|-|0|+|0";

                                }
                                
                            }
                            
                            else{
                                
                                $values = $value;
                                
                                if(is_array($values)){
                                    
                                    foreach ($values as $value) {
                                        
                                        $value = (array)$value;
                            
                                        if(isset($value['price'])){

                                            if(isset($value['quantity'])){

                                                $quantity += $value['quantity'];

                                            }
                                            
                                            $value['price'] = (array)$value['price'];
                                            
                                            foreach ($value['price'] as $variant) {

                                                $variant = (array)$variant;

                                                $price = $variant['_'];

                                                $name = $variant['name'];
                                                
                                                $prices[$name] = $price;

                                                //$options_oc["select|Вариант|".$name."|0|".$quantity."|0|+|".$price."|-|0|+|0"] = "select|Вариант|".$name."|0|".$quantity."|0|+|".$price."|-|0|+|0";

                                            }

                                        }
                                        
                                        if(strstr($value['name'],'/') && strstr($value['name'],'EUR')){
                                            
                                            $value['name'] = explode('/', $value['name']);
                                            
                                            if(isset($value['name'][1])){
                                                
                                                $value['name'] = trim($value['name'][1]);
                                                
                                            }
                                            else{
                                                
                                                $value['name'] = implode('/', $value['name']);
                                                
                                            }
                                            
                                        }
                                        
                                        $options_oc["select|Вариант|".$value['name']."|1|".$value['quantity']."|1|+|0|-|0|+|0"] = "select|Вариант|".$value['name']."|1|".$value['quantity']."|1|+|0|-|0|+|0";
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            $options_oc = implode('---', $options_oc);
                            
                            $value = json_encode($value);
                            
                        }
                        
                        $this->feed_setting['first_row'][$field] = $field;
                        
                        $offer[$field] = (string)$value;
                        
                    }
                    
                    $offer['productId'] = (int)$data[0];
                        
                    $offer['atributes'] = $atributes;
                    
                    $offer['quantity'] = $quantity;
                    
                    $this->feed_setting['first_row']['quantity'] = 'quantity';
                    
                    $this->feed_setting['first_row']['atributes'] = 'atributes';
                    
                    foreach ($prices as $key => $value) {
                        
                        $offer[$key] = $value;
                        
                        $this->feed_setting['first_row'][$key] = $key;
                        
                    }
                    
                    $offer['options'] = $options_oc;
                    
                    $this->feed_setting['first_row']['options'] = 'options';
                    
                    //var_dump($offer);exit();
                    
                    if(!$skip_by_category){
                        
                        $this->feed_setting['offers'][] = $offer;
                        
                    }
                    else{
                        
                        $offer['productId'] = '';
                        
                        $this->feed_setting['offers'][] = $offer;
                        
                    }
                    //var_dump($offer);exit();
                    
                }
                
                
            }
            elseif($data[0]>0 && (!isset ($this->feed_setting['only_data']) || !$this->feed_setting['only_data'])){
                
                $this->feed_setting['first_row']['productId'] = 'productId';
                
                $this->feed_setting['offers'][]['productId'] = (int)$data[0];
                
            }
            
            $this_row++;
            
        }
        
        $result['file_upload'] = $this->getCSVFormObj($template_data,$filename);
        
        $this->feed_setting['time_finish'] = time();
        
        $this->feed_setting['count_rows'] = 10000;
        
        $this->feed_setting['max_exe_time'] = $this->feed_setting['time_finish'] - $this->feed_setting['time_start'];
        
        $result['count_rows'] = $this->feed_setting['count_rows'];
        
        $result['max_exe_time'] = $this->feed_setting['max_exe_time'];
        
        $result['memory_usage'] = $this->feed_setting['memory_usage'];
        
        return $result;
        
    }
    
    private function getCSVFormObj($odmpro_tamplate_data,$filename,$first_write=1,$prefix=''){
        
        $first_row = array();
        
        $new_file_name = $prefix.md5($filename);
        
        $csv_delimiter = $odmpro_tamplate_data['csv_delimiter'];

        $csv_enclosure = $odmpro_tamplate_data['csv_enclosure'];
        
        $csv_escape = $odmpro_tamplate_data['csv_escape'];

        $encoding = $odmpro_tamplate_data['encoding'];
        
        $offers_writed = 0;
        
        $csv_rows = array();
                    
        foreach ($this->feed_setting['offers'] as $offer) {

            $csv_row = array();

            if($first_write && !$first_row){

                $first_row = $this->feed_setting['first_row'];

                $csv_rows[] = $first_row;

            }

            foreach ($this->feed_setting['first_row'] as $csv_column_name) {

                if(isset($offer[$csv_column_name])){

                    if(isset($offer[$csv_column_name]) && is_array($offer[$csv_column_name])){
                        
                        $offer[$csv_column_name] = json_encode($offer[$csv_column_name]);
                        
                    }
                    elseif(!isset ($offer[$csv_column_name])){
                        
                        $offer[$csv_column_name] = '';
                        
                    }

                    $csv_row[] = $offer[$csv_column_name];

                }else{

                    $csv_row[] = '';

                }

            }

            $csv_rows[] = $csv_row;

            $offers_writed++;

        }

        $file_name = $this->writeCsv($csv_rows,$first_write,$csv_delimiter,$csv_enclosure,$csv_escape,$encoding,$new_file_name,array());
        
        return $file_name;
        
    }
    
    public function writeCsv($data,$first_write,$csv_delimiter,$csv_enclosure,$csv_escape,$encoding,$file_and_path,$log_data=array()) {
        
        $file_name_and_path = $file_and_path.'.csv';
        
        $file_name_and_path_array = explode('/', trim($file_name_and_path));
            
        $path_array = array();

        for ($i=0;$i<(count($file_name_and_path_array)-1);$i++) {

            $path_array[] = $file_name_and_path_array[$i];

        }

        $file_name = end($file_name_and_path_array);
        
        $write_path = DIR_DOWNLOAD;
        
        if($path_array){
            
            foreach ($path_array as $dir) {
                
                $write_path .= $dir.'/';
                
                if(!file_exists($write_path)){

                    mkdir($write_path,0777);

                }
                
            }
            
        }
        
        if(!file_exists($write_path)){
            
            return;
            
        }
        
        if(!file_exists($write_path.$file_name)){
            
            $handle = fopen($write_path.$file_name, "a+"); 
            
            fclose($handle);
            
        }
        
        //Открываем
        if($first_write){
            
            $handle = fopen($write_path.$file_name, "w+");
        }else{
            $handle = fopen($write_path.$file_name, "a+");
        }
        
        
        if(!$handle){
            
            return;
        }
        
        $csv_delimiter = html_entity_decode(trim($csv_delimiter));
        
        $csv_enclosure = html_entity_decode(trim($csv_enclosure));
        
        foreach ($data as $num_row => $csv_row) {
            
            $value = '';
            
            $num_columns = count($csv_row);
            
            $this_num_column = 1;
            
            foreach ($csv_row as $row) {
                
                $row = (string)html_entity_decode($row);
                
                if($this_num_column<$num_columns){
                    $value .= $row.$csv_delimiter;
                }else{
                    $value .= $row;
                }
                $this_num_column++;
                
            }
            
            unset($data[$num_row]);
        
            fputcsv($handle, explode($csv_delimiter, $value), $csv_delimiter,$csv_enclosure);
            
        }
        
        fclose($handle);
        
        return $file_name;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function getNamePathSupplierCaregories($parent_id,$name,$delimeter='/'){
        
        if(!isset($this->feed_setting['categories'][$parent_id])){
            
            return $name;
            
        }else{
            
            $name = $this->feed_setting['categories'][$parent_id]['name'].$delimeter.$name;
            
            return $this->getNamePathSupplierCaregories($this->feed_setting['categories'][$parent_id]['parent_id'],$name);
            
        }
        
    }
    
    public function replaceAndConvert($filename,$find,$replace,$encoding='') {
        
        $file = fopen($filename, 'r');
        
        $text = fread($file, filesize($filename));
        
        //$text = fread($file, 100);
        
        //$text = mb_convert_encoding((string)$text,'UTF-8',$encoding);
        
        //$text = iconv($encoding,'UTF-8',$text);
        
        //var_dump($text);exit();
        
        if($encoding && $encoding!='UTF-8'){
            
            $text = iconv($encoding,'UTF-8',$text);
            //$text = mb_convert_encoding((string)$text,'UTF-8',$encoding);
            
        }
        fclose($file);
        $file = fopen($filename, 'w');
        $text = str_replace($find, $replace, $text);
        fwrite($file, $text);
        fclose($file);
        
    }
    
    public function convertValue($value,$from='UCS-2',$to='UTF-8'){
        
        if(is_array($value)){
            
            foreach ($value as $key => $value2) {
                
                $result[$this->convertCSVValue($key,$from,$to)] = $this->convertCSVValue($value2,$from,$to);
                
            }
            
        }else{
            
            $result = mb_convert_encoding((string)$value,$to,$from);
            
        }
        
        return $result;
        
    }

    

    public function getCMLParams($filename,$template_data,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
        libxml_use_internal_errors (FALSE);
        $myXML = new XMLReader();
        libxml_use_internal_errors (FALSE);
        $this->feed_setting['time_start'] = time();
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
                                    
        $count_subnodes = 0;
        
        $this_num_row = 0;
        
        $first_write = 1;
        
        while ($myXML->read()) {
            
            $tag = $myXML->name;
            
            $outer_xml = '';
            
            $outer_xml_close = '';
            
            $tag_name = $tag;
                                            
            if(isset($tags_new_names[$tag])){

                $tag_name = $tags_new_names[$tag];

            }
            
            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag])) {
                
                while($myXML->read()) { 

                    $tag2 = $myXML->name;
                    
                    $tag_name = $tag;
                    
                    if(isset($tags_new_names[$tag])){
                        
                        $tag_name = $tags_new_names[$tag];
                        
                    }
                    
                    $tag_name2 = $tag2;
                                            
                    if(isset($tags_new_names[$tag2])){

                        $tag_name2 = $tags_new_names[$tag2];

                    }
                    
                    $outer_xml = '<'.$tag_name.'>';
                    
                    $outer_xml_close = '</'.$tag_name.'>';
                    
                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2])) {
                        
                        while($myXML->read()) {
                        
                            $tag3 = $myXML->name;
                            
                            $tag_name2 = $tag2;
                    
                            if(isset($tags_new_names[$tag2])){

                                $tag_name2 = $tags_new_names[$tag2];

                            }
                            
                            $tag_name3 = $tag3;
                                            
                            if(isset($tags_new_names[$tag3])){

                                $tag_name3 = $tags_new_names[$tag3];

                            }
                            
                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>';
                            
                            $outer_xml_close = '</'.$tag_name2.'>'.'</'.$tag_name.'>';

                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3])) {
                                
                                while($myXML->read()) {
                                    
                                    $tag4 = $myXML->name;
                                    
                                    $tag_name3 = $tag3;
                    
                                    if(isset($tags_new_names[$tag3])){

                                        $tag_name3 = $tags_new_names[$tag3];

                                    }
                                    
                                    $tag_name4 = $tag4;
                                            
                                    if(isset($tags_new_names[$tag4])){

                                        $tag_name4 = $tags_new_names[$tag4];

                                    }
                                    
                                    $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>';
                                    
                                    $outer_xml_close = '</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                    
                                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4])) {
                                        
                                        while($myXML->read()) {
                                            
                                            $tag5 = $myXML->name;
                                            
                                            $tag_name4 = $tag4;
                    
                                            if(isset($tags_new_names[$tag4])){

                                                $tag_name4 = $tags_new_names[$tag4];

                                            }
                                            
                                            $tag_name5 = $tag5;
                                            
                                            if(isset($tags_new_names[$tag5])){

                                                $tag_name5 = $tags_new_names[$tag5];

                                            }
                                             
                                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>'.'<'.$tag_name4.'>';
                                            
                                            $outer_xml_close = '</'.$tag_name4.'>'.'</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                            
                                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4][$tag5])) {
                                                
                                                $result['error'] = 'out of 5 nodes - выход за пять вложенных узлов';
                                                
                                            }
                                            elseif(in_array($tag5, $tags[$tag][$tag2][$tag3][$tag4])){
                                        
                                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                                    $xml_as_string = $myXML->readInnerXml();

                                                    if($xml_as_string){
                                                        
                                                        $count_subnodes++;

                                                        $inner_xml .= '<'.$tag_name5.'>'.$xml_as_string.'</'.$tag_name5.'>';

                                                        if($count_subnodes===$count_nodes){

                                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                                            $this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                                            $count_subnodes = 0;

                                                            $xml_cache = '';

                                                            $inner_xml = '';

                                                        }

                                                    }

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    elseif(in_array($tag4, $tags[$tag][$tag2][$tag3])){
                                        
                                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                            $xml_as_string = $myXML->readInnerXml();

                                            if($xml_as_string){
                                                
                                                $count_subnodes++;
                                                
                                                $inner_xml .= '<'.$tag_name4;
                                                
                                                $readOuterXml = $myXML->readOuterXml();
                                    
                                                if($readOuterXml && is_string($readOuterXml)){
                                                    
                                                    $xml_as_sxml = (array)simplexml_load_string($readOuterXml);

                                                    if(isset($xml_as_sxml['@attributes'])){

                                                        foreach ($xml_as_sxml['@attributes'] as $attribute_name => $attribute_value) {

                                                            $inner_xml .= ' '.$attribute_name.'="'.$attribute_value.'"';

                                                        }

                                                    }
                                                }
                                                
                                                $inner_xml .= '>'.$xml_as_string.'</'.$tag_name4.'>'.PHP_EOL;

                                                if($count_subnodes===$count_nodes){
                                                    
                                                    if($inner_xml && $tag_name4=='param'){
                                                        
                                                        $param_row = simplexml_load_string($inner_xml);

                                                        $param_id = trim((string)$param_row->{'Ид'});

                                                        $name = trim((string)$param_row->{'Наименование'});
                                                        
                                                        $variants = array();
                                                        
                                                        if(isset($param_row->{'ВариантыЗначений'}->{'Вариант'})){
                                                            
                                                            foreach ($param_row->{'ВариантыЗначений'}->{'Вариант'} as $variant) {
                                                                
                                                                if(isset($variant->{'Ид'})){ 
                                                                    
                                                                    $variants[(string)$variant->{'Ид'}] = array(
                                                                        'variant_id' => (string)$variant->{'Ид'},
                                                                        'name' => (string)$variant->{'Значение'}
                                                                    );
                                                                    
                                                                }
                                                                
                                                            }
                                                            
                                                        }
                                                        
                                                        if($name && $param_id){
                                                            
                                                            $this->feed_setting['params'][$param_id] = array(
                                                                'param_id'  => $param_id,
                                                                'name' => $name,
                                                                'variants' => $variants,
                                                            );
                                                            
                                                        }
                                                        
                                                    }

                                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;
                                                    
                                                    $count_subnodes = 0;
                                                    
                                                    $xml_cache = '';
                                                    
                                                    $inner_xml = '';

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }

                            }
                            
                            elseif(in_array($tag3, $tags[$tag][$tag2])){
                                        
                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                    $xml_as_string = $myXML->readInnerXml();

                                    if($xml_as_string){

                                        $count_subnodes++;

                                        $inner_xml .= '<'.$tag_name3.'>'.$xml_as_string.'</'.$tag_name3.'>'.PHP_EOL;;

                                        if($count_subnodes===$count_nodes){

                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                            $count_subnodes = 0;

                                            $xml_cache = '';

                                            $inner_xml = '';

                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }
                    elseif(in_array($tag2, $tags[$tag])){
                        
                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                            $xml_as_string = $myXML->readInnerXml();

                            if($xml_as_string){

                                $count_subnodes++;

                                $inner_xml .= '<'.$tag_name2.'>'.$xml_as_string.'</'.$tag_name2.'>'.PHP_EOL;

                                if($count_subnodes===$count_nodes){

                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                    $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                    $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                    //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                    $count_subnodes = 0;

                                    $xml_cache = '';

                                    $inner_xml = '';

                                }

                            }

                        }

                    }

                }
                
            }elseif(in_array($tag, $tags)){

                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                    $xml_as_string = $myXML->readInnerXml();

                    if($xml_as_string){

                        $count_subnodes++;

                        $inner_xml .= '<'.$tag_name.'>'.$xml_as_string.'</'.$tag_name.'>'.PHP_EOL;

                        if($count_subnodes===$count_nodes){

                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                            $count_subnodes = 0;

                            $xml_cache = '';

                            $inner_xml = '';

                        }

                    }

                }

            }
            
        }
        
        if($count_subnodes && $inner_xml!==''){
            
            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

            $count_subnodes = 0;

        }
        
        $myXML->close();
        
        /*
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_by_category_id']);
        
        foreach ($this->feed_setting['params'] as $category_id => $category) {
            
            if(!$this->feed_setting['delete_by_category_id'] || !in_array($category_id, $this->feed_setting['delete_by_category_id'])){
                
                $this->feed_setting['category_path'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['name']);
                
            }
            
        }
         * 
         */
        
        //$this->feed_setting['params'] = array();
        
        return $result;
        
    }
    
    public function getYMLCategories2($filename,$template_data,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
        //var_dump($template_data);exit();  
        
        
        
        $myXML = new XMLReader();
        
        $this->feed_setting['time_start'] = time();
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
                                    
        $count_subnodes = 0;
        
        $this_num_row = 0;
        
        $first_write = 1;
        
        while ($myXML->read()) {
            
            $tag = $myXML->name;
            
            $outer_xml = '';
            
            $outer_xml_close = '';
            
            $tag_name = $tag;
                                            
            if(isset($tags_new_names[$tag])){

                $tag_name = $tags_new_names[$tag];

            }
            
            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag])) {
                
                while($myXML->read()) { 

                    $tag2 = $myXML->name;
                    
                    $tag_name = $tag;
                    
                    if(isset($tags_new_names[$tag])){
                        
                        $tag_name = $tags_new_names[$tag];
                        
                    }
                    
                    $tag_name2 = $tag2;
                                            
                    if(isset($tags_new_names[$tag2])){

                        $tag_name2 = $tags_new_names[$tag2];

                    }
                    
                    $outer_xml = '<'.$tag_name.'>';
                    
                    $outer_xml_close = '</'.$tag_name.'>';
                    
                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2])) {
                        
                        while($myXML->read()) {
                        
                            $tag3 = $myXML->name;
                            
                            $tag_name2 = $tag2;
                    
                            if(isset($tags_new_names[$tag2])){

                                $tag_name2 = $tags_new_names[$tag2];

                            }
                            
                            $tag_name3 = $tag3;
                                            
                            if(isset($tags_new_names[$tag3])){

                                $tag_name3 = $tags_new_names[$tag3];

                            }
                            
                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>';
                            
                            $outer_xml_close = '</'.$tag_name2.'>'.'</'.$tag_name.'>';

                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3])) {
                                
                                while($myXML->read()) {
                                    
                                    $tag4 = $myXML->name;
                                    
                                    $tag_name3 = $tag3;
                    
                                    if(isset($tags_new_names[$tag3])){

                                        $tag_name3 = $tags_new_names[$tag3];

                                    }
                                    
                                    $tag_name4 = $tag4;
                                            
                                    if(isset($tags_new_names[$tag4])){

                                        $tag_name4 = $tags_new_names[$tag4];

                                    }
                                    
                                    $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>';
                                    
                                    $outer_xml_close = '</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                    
                                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4])) {
                                        
                                        while($myXML->read()) {
                                            
                                            $tag5 = $myXML->name;
                                            
                                            $tag_name4 = $tag4;
                    
                                            if(isset($tags_new_names[$tag4])){

                                                $tag_name4 = $tags_new_names[$tag4];

                                            }
                                            
                                            $tag_name5 = $tag5;
                                            
                                            if(isset($tags_new_names[$tag5])){

                                                $tag_name5 = $tags_new_names[$tag5];

                                            }
                                             
                                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>'.'<'.$tag_name4.'>';
                                            
                                            $outer_xml_close = '</'.$tag_name4.'>'.'</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                            
                                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4][$tag5])) {
                                                
                                                $result['error'] = 'out of 5 nodes - выход за пять вложенных узлов';
                                                
                                            }
                                            elseif(in_array($tag5, $tags[$tag][$tag2][$tag3][$tag4])){
                                        
                                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                                    $xml_as_string = $myXML->readInnerXml();

                                                    if($xml_as_string){
                                                        
                                                        $count_subnodes++;

                                                        $inner_xml .= '<'.$tag_name5.'>'.$xml_as_string.'</'.$tag_name5.'>';

                                                        if($count_subnodes===$count_nodes){

                                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                                            $this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                                            $count_subnodes = 0;

                                                            $xml_cache = '';

                                                            $inner_xml = '';

                                                        }

                                                    }

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    elseif(in_array($tag4, $tags[$tag][$tag2][$tag3])){
                                        
                                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                            $xml_as_string = $myXML->readInnerXml();

                                            if($xml_as_string){
                                                
                                                $count_subnodes++;
                                                
                                                $inner_xml .= '<'.$tag_name4;
                                                
                                                $readOuterXml = $myXML->readOuterXml();
                                    
                                                if($readOuterXml && is_string($readOuterXml)){
                                                    
                                                    $xml_as_sxml = (array)simplexml_load_string($readOuterXml);

                                                    if(isset($xml_as_sxml['@attributes'])){

                                                        foreach ($xml_as_sxml['@attributes'] as $attribute_name => $attribute_value) {

                                                            $inner_xml .= ' '.$attribute_name.'="'.htmlspecialchars($attribute_value,ENT_QUOTES).'"';

                                                        }

                                                    }
                                                }
                                                
                                                $inner_xml .= '>'.$xml_as_string.'</'.$tag_name4.'>'.PHP_EOL;

                                                if($count_subnodes===$count_nodes){
                                                    
                                                    if($inner_xml && $tag_name4=='category'){
                                                        
                                                        $category_row = simplexml_load_string($inner_xml);
                                                        
                                                        $parent_id = 0;

                                                        $category_id = 0;

                                                        $name = '';

                                                        $attributes = (array)$category_row->attributes();

                                                        if(isset($attributes['@attributes']['id'])){

                                                            $category_id = trim((string)$attributes['@attributes']['id']);

                                                        }

                                                        if(isset($attributes['@attributes']['parentId'])){

                                                            $parent_id = trim((string)$attributes['@attributes']['parentId']);

                                                        }
                                                        
                                                        if(!$parent_id){
                                                            
                                                            $parent_id = 0;
                                                            
                                                        }
							
							if($category_id==$parent_id){
							    
							    $parent_id = 0;
							    
							}
                                                        
                                                        if(isset($attributes['@attributes']['name'])){

                                                            $name = trim((string)$attributes['@attributes']['name']);

                                                        }else{
                                                            
                                                            $name = trim((string)$category_row);
                                                            
                                                        }
                                                        
                                                        if($name && $category_id){
                                                            
                                                            $this->feed_setting['categories'][$category_id] = array(
                                                                'category_id'  => $category_id,
                                                                'parent_id'  => $parent_id,
                                                                'name' => $name,
                                                            );
                                                            
                                                        }
                                                        
                                                    }

                                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;
                                                    
                                                    $count_subnodes = 0;
                                                    
                                                    $xml_cache = '';
                                                    
                                                    $inner_xml = '';

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }

                            }
                            
                            elseif(in_array($tag3, $tags[$tag][$tag2])){
                                        
                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                    $xml_as_string = $myXML->readInnerXml();

                                    if($xml_as_string){

                                        $count_subnodes++;

                                        $inner_xml .= '<'.$tag_name3.'>'.$xml_as_string.'</'.$tag_name3.'>'.PHP_EOL;;

                                        if($count_subnodes===$count_nodes){

                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                            $count_subnodes = 0;

                                            $xml_cache = '';

                                            $inner_xml = '';

                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }
                    elseif(in_array($tag2, $tags[$tag])){
                        
                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                            $xml_as_string = $myXML->readInnerXml();

                            if($xml_as_string){

                                $count_subnodes++;

                                $inner_xml .= '<'.$tag_name2.'>'.$xml_as_string.'</'.$tag_name2.'>'.PHP_EOL;

                                if($count_subnodes===$count_nodes){

                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                    $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                    $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                    //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                    $count_subnodes = 0;

                                    $xml_cache = '';

                                    $inner_xml = '';

                                }

                            }

                        }

                    }

                }
                
            }elseif(in_array($tag, $tags)){

                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                    $xml_as_string = $myXML->readInnerXml();

                    if($xml_as_string){

                        $count_subnodes++;

                        $inner_xml .= '<'.$tag_name.'>'.$xml_as_string.'</'.$tag_name.'>'.PHP_EOL;

                        if($count_subnodes===$count_nodes){

                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                            $count_subnodes = 0;

                            $xml_cache = '';

                            $inner_xml = '';

                        }

                    }

                }

            }
            
        }
        
        if($count_subnodes && $inner_xml!==''){
            
            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

            $count_subnodes = 0;

        }
        
        $myXML->close();
        
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_delete_by_category_id']);
        
        $this->feed_setting['set_products_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['dvcom_set_products_by_category_id']);
        
        foreach ($this->feed_setting['categories'] as $category_id => $category) {
            
            if($category_id && $category['parent_id']!=$category_id && !isset( $this->feed_setting['tmp_cat'][$category_id.'-'.$category['parent_id']])){
                
                if(!$this->feed_setting['delete_by_category_id'] || !in_array($category_id, $this->feed_setting['delete_by_category_id'])/* && (!$this->feed_setting['set_products_by_category_id'] || in_array($category_id, $this->feed_setting['set_products_by_category_id']))*/ ){

                    $this->feed_setting['category_path'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['name'],'/','name');

                }

                $this->feed_setting['category_path_by_category_id'][$category_id] = $this->getNamePathSupplierCaregories($category['parent_id'], $category['category_id'],'____','category_id','____');
                
                $this->feed_setting['tmp_cat'][$category_id.'-'.$category['parent_id']] = TRUE;
                
            }
            
        }
        
        $this->feed_setting['categories'] = array();
        
        return $result;
        
    }

    public function getValueFromCDATA($cdata) {
        
        return htmlspecialchars(str_replace(array('<![CDATA[ ',' ]]>'),array('',''),   strip_tags(html_entity_decode(trim((string)$cdata)))),ENT_QUOTES);
        
    }

    public function getCSVFromYML($filename,$template_data,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
        $offers_file_name_prefix = '';
        
        if($this->feed_cache['status']){

            $offers_file_name_prefix = $template_data['id'].'-'.$this->feed_cache['offers_file_name_prefix'];
            
            $this->unlinkFiles(array($offers_file_name_prefix),DIR_SYSTEM . 'library/vendor/ocext/cache/yml_cache/');
            
        }
        
        libxml_use_internal_errors (FALSE);
        
        $myXML = new XMLReader();
        
        libxml_use_internal_errors (FALSE);
        
        $myXML->open($filename);
        
        $result = array('file'=>array(),'error'=>array());
        
        $inner_xml = '';
                                    
        $count_subnodes = 0;
        
        $this_num_row = 0;
        
        $first_write = 1;
        
        while ($myXML->read()) {
            
            $tag = $myXML->name;
            
            $outer_xml = '';
            
            $outer_xml_close = '';
            
            $tag_name = $tag;
                                            
            if(isset($tags_new_names[$tag])){

                $tag_name = $tags_new_names[$tag];

            }
            
            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag])) {
                
                while($myXML->read()) { 

                    $tag2 = $myXML->name;
                    
                    $tag_name = $tag;
                    
                    if(isset($tags_new_names[$tag])){
                        
                        $tag_name = $tags_new_names[$tag];
                        
                    }
                    
                    $tag_name2 = $tag2;
                                            
                    if(isset($tags_new_names[$tag2])){

                        $tag_name2 = $tags_new_names[$tag2];

                    }
                    
                    $outer_xml = '<'.$tag_name.'>';
                    
                    $outer_xml_close = '</'.$tag_name.'>';
                    
                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2])) {
                        
                        while($myXML->read()) {
                        
                            $tag3 = $myXML->name;
                            
                            $tag_name2 = $tag2;
                    
                            if(isset($tags_new_names[$tag2])){

                                $tag_name2 = $tags_new_names[$tag2];

                            }
                            
                            $tag_name3 = $tag3;
                                            
                            if(isset($tags_new_names[$tag3])){

                                $tag_name3 = $tags_new_names[$tag3];

                            }
                            
                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>';
                            
                            $outer_xml_close = '</'.$tag_name2.'>'.'</'.$tag_name.'>';
                            
                            
                                   

                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3])) {
                                
                                while($myXML->read()) {
                                    
                                    $tag4 = $myXML->name;
                                    
                                    $tag_name3 = $tag3;
                    
                                    if(isset($tags_new_names[$tag3])){

                                        $tag_name3 = $tags_new_names[$tag3];

                                    }
                                    
                                    $tag_name4 = $tag4;
                                            
                                    if(isset($tags_new_names[$tag4])){

                                        $tag_name4 = $tags_new_names[$tag4];

                                    }
                                    
                                    $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>';
                                    
                                    $outer_xml_close = '</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                    
                                    if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4])) {
                                        
                                        while($myXML->read()) {
                                            
                                            $tag5 = $myXML->name;
                                            
                                            $tag_name4 = $tag4;
                    
                                            if(isset($tags_new_names[$tag4])){

                                                $tag_name4 = $tags_new_names[$tag4];

                                            }
                                            
                                            $tag_name5 = $tag5;
                                            
                                            if(isset($tags_new_names[$tag5])){

                                                $tag_name5 = $tags_new_names[$tag5];

                                            }
                                             
                                            $outer_xml = '<'.$tag_name.'>'.'<'.$tag_name2.'>'.'<'.$tag_name3.'>'.'<'.$tag_name4.'>';
                                            
                                            $outer_xml_close = '</'.$tag_name4.'>'.'</'.$tag_name3.'>'.'</'.$tag_name2.'>'.'</'.$tag_name.'>';
                                            
                                            if ($myXML->nodeType == XMLReader::ELEMENT && isset($tags[$tag][$tag2][$tag3][$tag4][$tag5])) {
                                                
                                                $result['error'] = 'out of 5 nodes - выход за пять вложенных узлов';
                                                
                                            }
                                            elseif(in_array($tag5, $tags[$tag][$tag2][$tag3][$tag4])){
                                        
                                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                                    $xml_as_string = $myXML->readInnerXml();

                                                    if($xml_as_string){
                                                        
                                                        $count_subnodes++;

                                                        $inner_xml .= '<'.$tag_name5.'>'.$xml_as_string.'</'.$tag_name5.'>';

                                                        if($count_subnodes===$count_nodes){

                                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                                            $this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                                            $count_subnodes = 0;

                                                            $xml_cache = '';

                                                            $inner_xml = '';

                                                        }

                                                    }

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                    elseif(in_array($tag4, $tags[$tag][$tag2][$tag3])){
                                        
                                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                            $xml_as_string = $myXML->readInnerXml();

                                            if($xml_as_string){
                                                
                                                $count_subnodes++;
                                                
                                                $inner_xml .= '<'.$tag_name4;
                                                
                                                $readOuterXml = $myXML->readOuterXml();
                                    
                                                if($readOuterXml && is_string($readOuterXml)){
                                                    
                                                    $xml_as_sxml = (array)simplexml_load_string($readOuterXml);

                                                    if(isset($xml_as_sxml['@attributes'])){

                                                        foreach ($xml_as_sxml['@attributes'] as $attribute_name => $attribute_value) {

                                                            $inner_xml .= ' '.$attribute_name.'="'.$attribute_value.'"';

                                                        }

                                                    }
                                                }
                                    
                                                $inner_xml .= '>'.$xml_as_string.'</'.$tag_name4.'>'.PHP_EOL;
                                                
                                                if($count_subnodes===$count_nodes){
                                                    
                                                    if($inner_xml && $tag_name4=='element'){
                                                        
                                                        $offer_row = simplexml_load_string($inner_xml);
                                                        
                                                        $delete_by_vendor = $this->feed_setting['delete_by_vendor'];
                                                        
                                                        $delete_by_category_id = $this->feed_setting['delete_by_category_id'];
                                                        
                                                        $skip = FALSE;
                                                        
                                                        if(isset($offer_row->vendor) && ($delete_by_vendor && in_array(trim((string)$offer_row->vendor), $delete_by_vendor)) ){

                                                            $skip = TRUE;

                                                        }
                                                        
                                                        if(isset($offer_row->sections)){
                                                            // && ($delete_by_vendor && in_array(trim((string)$offer_row->vendor), $delete_by_vendor)) 
                                                            $sections = $offer_row->sections;
                                                            
                                                            foreach ($sections->section as $categoryId) {
                                                                
                                                                if($delete_by_category_id && in_array(trim((string)$categoryId), $delete_by_category_id)){
                                                                    
                                                                    $skip = TRUE;
                                                                    
                                                                }
                                                                
                                                            }

                                                        }
                                                        
                                                        exit('sssssssss');
                                                        
                                                        if(!$skip){
                                                            
                                                            if($start<=$this_num_row && $this_num_row<($start+$limit)){
                                                                $this->getDsvRowFromOfferNode($offer_row,FALSE,$offers_file_name_prefix);
                                                            }else{
                                                                $this->getDsvRowFromOfferNode($offer_row,TRUE,$offers_file_name_prefix);
                                                            }

                                                            if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                                $this->feed_setting['memory_usage'] = memory_get_usage();

                                                            }

                                                            if(count($this->feed_setting['offers']) == $this->feed_setting['max_nodes_to_write']){

                                                                if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                                    $this->feed_setting['memory_usage'] = memory_get_usage();

                                                                }

                                                                $result['file_upload'] = $this->getCSVFormObj($template_data,$filename,$first_write);

                                                                $this->feed_setting['offers'] = array();

                                                                $first_write = 0;

                                                            }

                                                            if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                                $this->feed_setting['memory_usage'] = memory_get_usage();

                                                            }

                                                            $this_num_row++;

                                                            $this->feed_setting['count_rows'] += 1;
                                                            
                                                        }
                                                        
                                                    }

                                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;
                                                    
                                                    $count_subnodes = 0;
                                                    
                                                    $xml_cache = '';
                                                    
                                                    $inner_xml = '';

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }

                            }
                            
                            elseif(in_array($tag3, $tags[$tag][$tag2])){
                                       
                                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                                    $xml_as_string = $myXML->readInnerXml();

                                    if($xml_as_string){

                                        $count_subnodes++;
                                        
                                        $readOuterXml = $myXML->readOuterXml();
                                        
                                        $inner_xml .= '<'.$tag_name3;
                                                
                                        $xml_as_sxml_attr = (array)simplexml_load_string($readOuterXml);

                                        if(isset($xml_as_sxml_attr['@attributes'])){

                                            foreach ($xml_as_sxml_attr['@attributes'] as $attribute_name => $attribute_value) {

                                                $inner_xml .= ' '.$attribute_name.'="'.$attribute_value.'"';

                                            }

                                        }

                                        $inner_xml .= '>'.$xml_as_string.'</'.$tag_name3.'>'.PHP_EOL;;
                                        
                                        if($count_subnodes===$count_nodes){

                                            if($inner_xml && $tag_name3=='element'){
                                                        
                                                $offer_row = simplexml_load_string($inner_xml);

                                                $delete_by_vendor = $this->feed_setting['delete_by_vendor'];

                                                $delete_by_category_id = $this->feed_setting['delete_by_category_id'];

                                                $skip = FALSE;

                                                if(isset($offer_row->vendor) && ($delete_by_vendor && in_array(trim((string)$offer_row->vendor), $delete_by_vendor)) ){

                                                    $skip = TRUE;

                                                }

                                                if(isset($offer_row->sections)){
                                                    // && ($delete_by_vendor && in_array(trim((string)$offer_row->vendor), $delete_by_vendor)) 
                                                    $sections = $offer_row->sections;

                                                    foreach ($sections->section as $categoryId) {

                                                        if($delete_by_category_id && in_array(trim((string)$categoryId), $delete_by_category_id)){

                                                            $skip = TRUE;

                                                        }

                                                    }

                                                }

                                                if(!$skip){

                                                    if($start<=$this_num_row && $this_num_row<($start+$limit)){
                                                        $this->getDsvRowFromOfferNode($offer_row,FALSE,$offers_file_name_prefix);
                                                    }else{
                                                        $this->getDsvRowFromOfferNode($offer_row,TRUE,$offers_file_name_prefix);
                                                    }

                                                    if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                        $this->feed_setting['memory_usage'] = memory_get_usage();

                                                    }

                                                    if(count($this->feed_setting['offers']) == $this->feed_setting['max_nodes_to_write']){

                                                        if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                            $this->feed_setting['memory_usage'] = memory_get_usage();

                                                        }

                                                        $result['file_upload'] = $this->getCSVFormObj($template_data,$filename,$first_write);

                                                        $this->feed_setting['offers'] = array();

                                                        $first_write = 0;

                                                    }

                                                    if( $this->feed_setting['memory_usage'] <  memory_get_usage() ){

                                                        $this->feed_setting['memory_usage'] = memory_get_usage();

                                                    }

                                                    $this_num_row++;

                                                    $this->feed_setting['count_rows'] += 1;

                                                }

                                            }

                                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                            $count_subnodes = 0;

                                            $xml_cache = '';

                                            $inner_xml = '';

                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }
                    elseif(in_array($tag2, $tags[$tag])){
                        
                        if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                            $xml_as_string = $myXML->readInnerXml();

                            if($xml_as_string){

                                $count_subnodes++;

                                $inner_xml .= '<'.$tag_name2.'>'.$xml_as_string.'</'.$tag_name2.'>'.PHP_EOL;

                                if($count_subnodes===$count_nodes){

                                    $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                                    $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                                    $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                                    //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                                    $count_subnodes = 0;

                                    $xml_cache = '';

                                    $inner_xml = '';

                                }

                            }

                        }

                    }

                }
                
            }elseif(in_array($tag, $tags)){

                if ($myXML->nodeType == XMLReader::ELEMENT){
                                            
                    $xml_as_string = $myXML->readInnerXml();

                    if($xml_as_string){

                        $count_subnodes++;

                        $inner_xml .= '<'.$tag_name.'>'.$xml_as_string.'</'.$tag_name.'>'.PHP_EOL;

                        if($count_subnodes===$count_nodes){

                            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

                            $as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

                            $result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

                            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

                            $count_subnodes = 0;

                            $xml_cache = '';

                            $inner_xml = '';

                        }

                    }

                }

            }
            
        }
        
        if($count_subnodes && $inner_xml!==''){
            
            $xml_cache = $outer_xml.$inner_xml.$outer_xml_close;

            //$as_file_xml_cache = $file_name_cach_prefix.count($result['as_files']).'.xml';

            //$result['as_files'][$as_file_xml_cache] = DIR_CACHE.$as_file_xml_cache;

            //$this->writeXMLCache($as_file_xml_cache,$xml_cache);

            $count_subnodes = 0;

        }
        
        $myXML->close();
        
        if($this->feed_cache['status'] && $this->feed_setting['offers']){

            $offers_cache_file_name = $offers_file_name_prefix.count($this->feed_setting['cache_offers']);

            $this->writeCache($offers_cache_file_name, $this->feed_setting['offers'],'yml_cache/');

            $this->feed_setting['offers'] = array();

            $this->feed_setting['cache_offers'][$offers_cache_file_name] = $offers_cache_file_name;

        }
        
        $this->feed_setting['time_finish'] = time();
        
        $this->feed_setting['category_path'] = array();
        
        $result['file_upload'] = array();
        
        if(isset($this->feed_setting['cache_offers']) && $this->feed_setting['cache_offers']){
            
            $this->unlinkFiles(array($this->feed_cache['offers_file_name_prefix_csv'].md5($filename)),DIR_DOWNLOAD);
            
            foreach ($this->feed_setting['cache_offers'] as $cache_offers_file) {
                
                $offers_file_name_prefix_csv = count($result['file_upload']).'_'.$this->feed_cache['offers_file_name_prefix_csv'];
                
                $this->feed_setting['offers'] = $this->getCache($cache_offers_file,TRUE,'yml_cache/');
                
                $result['file_upload'][] = $this->getCSVFormObj($template_data,$filename,$first_write,$offers_file_name_prefix_csv);
                
            }
            
        }else{
            
            $result['file_upload'] = $this->getCSVFormObj($template_data,$filename,$first_write);
            
        }
        
        $this->feed_setting['max_exe_time'] = $this->feed_setting['time_finish'] - $this->feed_setting['time_start'];
        
        $result['count_rows'] = $this->feed_setting['count_rows'];
        
        $result['max_exe_time'] = $this->feed_setting['max_exe_time'];
        
        $result['memory_usage'] = $this->feed_setting['memory_usage'];
        
        return $result;
        
    }
    
    
    public function getStringFromSetting($string){
        
        return trim(ltrim($string));;
        
    }
    
    

    public function getArrayByDelimeterAndString($string,$delimeter='|',$trim=TRUE){
     
        $result = array();
        
        $parts = explode($delimeter,$string);
            
        foreach ($parts as $part) {
            
            if($trim){
                
                $part = trim(ltrim($part));
                
            }
            
            if($part!==''){
                
                $result[$part] = $part;
                
            }
            
        }
        
        return $result;
        
    }

    private function getDsvRowFromOfferNode($offer_row,$only_first_row=FALSE,$offers_file_name_prefix){
        
            $attributes_offer = (array)$offer_row->attributes();
            
            $params = array();
            
            $option_columns = array();
            
            $quantity_on_option = 0;
            
            $select_params_as_column = array();
            
            $offer_row_new = array();
            
            $code = '';
            
            $id = '';
            
            $name = '';
            
            $pictures = array();
            
            $categories = array();
            
            $param_group_title = $this->feed_setting['group_attribute_name'];
            
            $price = '';
            
            $price_selling = '';
            
            $available_balance = '';
            
            if(!$id && isset($offer_row->{'id'})){

                $id = (string)$offer_row->{'id'};

            }

            $country_name = '';
            
            $offer_additional_colums = array();
            
            $title = '';

            $available_status = '';

            $description = '';

            $sale_price = '';

            $wholesale_price = '';
            
            $supplier_trademark_id = '';
            
            $params_as_column = array();
            
            $analogs = array();
            
            $delete_params = $this->feed_setting['delete_params'];
            
            if(isset($offer_row->pictures)){
                
                foreach ($offer_row->pictures as $pictures_xml) {
                    
                    foreach ($pictures_xml->picture as $picture){
                        
                        $picture_value = (string)$picture->large;
                        
                        if($picture_value){
                            
                            $pictures[$picture_value] = $picture_value;
                            
                        }

                    }
                    
                }

            }
            
            if(isset($offer_row->category_id)){
                
                foreach ($offer_row->category_id as $category_id) {
                    
                    if(isset($this->feed_setting['category_path'][(string)$category_id])){
                        
                        $categories[] = $this->feed_setting['category_path'][(string)$category_id];
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->trademark_id)){
                
                if(isset($this->feed_setting['trademark'][(string)$offer_row->trademark_id])){

                    $trademark = $this->feed_setting['trademark'][(string)$offer_row->trademark_id];
                    
                    if(isset($trademark['title']) && $trademark['title']!==''){
                        
                        $supplier_trademark_id = $trademark['title'];
                        
                    }
                    
                    if(isset($trademark['picture']) && $trademark['picture']!==''){
                        
                        $supplier_trademark_id .= '_-T-_'.$trademark['picture'];
                        
                    }

                }
                
            }
            
            if(isset($offer_row->color_id)){
                
                if(isset($this->feed_setting['color'][(string)$offer_row->color_id])){
                    
                    $color = $this->feed_setting['color'][(string)$offer_row->color_id];
                    
                    $param_value = '';
                    
                    $param_image = '';
                    
                    $quantity_on_option = 100;
                    
                    $param_title = 'Цвет';
                    
                    if(isset($this->feed_setting['option_color_name']) && $this->feed_setting['option_color_name']!==''){
                        
                        $param_title = $this->feed_setting['option_color_name'];
                        
                    }
                    
                    if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){
                        
                        $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];
                        
                    }
                    
                    if(isset($color['title'])){
                        
                        $param_value = $color['title'];
                        
                    }
                    
                    if(isset($color['picture'])){
                        
                        $param_image = $color['picture'];
                        
                    }

                    if($this->feed_setting['params_as_column']){

                        $params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                        $select_params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                        $option_columns[] = $param_title;

                    }elseif(!$this->feed_setting['option_columns']){

                        $option_columns[] = $param_title;

                    }

                    $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                    ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                    if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                        $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                    }

                    if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                        $params_this['product_feature_code'] = $id;

                    }

                    $params[] = $params_this;
                    
                    if(isset($color['color_group_data']['title'])){
                        
                        $param_title = 'Цветность';
                    
                        if(isset($this->feed_setting['option_color_group_name']) && $this->feed_setting['option_color_group_name']!==''){

                            $param_title = $this->feed_setting['option_color_group_name'];

                        }
                        
                        $param_value = $color['color_group_data']['title'];
                        
                        if($this->feed_setting['params_as_column']){

                            $params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                            $select_params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                            $option_columns[] = $param_title;

                        }elseif(!$this->feed_setting['option_columns']){

                            $option_columns[] = $param_title;

                        }

                        $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                        ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                        if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                            $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                        }

                        if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                            $params_this['product_feature_code'] = $id;

                        }
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->glass_id)){
                
                if(isset($this->feed_setting['glass'][(string)$offer_row->glass_id])){
                    
                    $glass = $this->feed_setting['glass'][(string)$offer_row->glass_id];
                    
                    $param_title = 'Стекло';
                    
                    if(isset($this->feed_setting['option_glass_name']) && $this->feed_setting['option_glass_name']!==''){
                        
                        $param_title = $this->feed_setting['option_glass_name'];
                        
                    }
                    
                    $param_value = '';
                    
                    $param_image = '';
                    
                    $quantity_on_option = 100;
                    
                    if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){
                        
                        $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];
                        
                    }
                    
                    if(isset($glass['color_group_data']['title'])){
                        
                        $param_title = $glass['color_group_data']['title'];
                        
                    }
                    
                    if(isset($glass['title'])){
                        
                        $param_value = $glass['title'];
                        
                    }
                    
                    if(isset($glass['picture'])){
                        
                        $param_image = $glass['picture'];
                        
                    }

                    if($this->feed_setting['params_as_column']){

                        $params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                        $select_params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                        $option_columns[] = $param_title;

                    }elseif(!$this->feed_setting['option_columns']){

                        $option_columns[] = $param_title;

                    }

                    $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                    ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                    if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                        $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                    }

                    if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                        $params_this['product_feature_code'] = $id;

                    }

                    $params[] = $params_this;
                    
                }
                
            }
            
            if(isset($offer_row->accessory_group_id)){
                
                if(isset($this->feed_setting['accessory_group'][(string)$offer_row->accessory_group_id])){
                    
                    $accessory_group = $this->feed_setting['accessory_group'][(string)$offer_row->accessory_group_id];
                    
                    $param_title = 'Группа аксессуаров';
                    
                    if(isset($this->feed_setting['accessory_group_name']) && $this->feed_setting['accessory_group_name']!==''){
                        
                        $param_title = $this->feed_setting['accessory_group_name'];
                        
                    }
                    
                    $param_value = '';
                    
                    $param_image = '';
                    
                    $quantity_on_option = 100;
                    
                    if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){
                        
                        $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];
                        
                    }
                    
                    if(isset($accessory_group['title'])){
                        
                        $param_value = $accessory_group['title'];
                        
                    }
                    
                    if(isset($accessory_group['picture'])){
                        
                        $param_image = $accessory_group['picture'];
                        
                    }

                    if($this->feed_setting['params_as_column']){

                        $params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                        $select_params_as_column[$param_title] = (string)$param_value;

                    }

                    if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                        $option_columns[] = $param_title;

                    }elseif(!$this->feed_setting['option_columns']){

                        $option_columns[] = $param_title;

                    }

                    $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                    ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                    if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                        $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                    }

                    if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                        $params_this['product_feature_code'] = $id;

                    }

                    $params[] = $params_this;
                    
                }
                
            }
            
            if(isset($offer_row->properties->property)){
                
                $properties = $offer_row->properties;
                
                if(isset($properties->property)){
                    
                    foreach ($properties->property as $property) {
                    
                        $property = (array)$property;

                        $param_title = '';

                        $param_value = '';

                        if(isset($property['id']) && isset($this->feed_setting['property'][$property['id']])){

                            $param_title = $this->feed_setting['property'][$property['id']]['title'];

                        }

                        if(isset($property['value_id']) && isset($this->feed_setting['property_value'][$property['value_id']])){

                            $param_value = $this->feed_setting['property_value'][$property['value_id']]['title'];

                        }

                        $param_image = '';

                        $quantity_on_option = 100;

                        if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){

                            $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];

                        }

                        if(isset($property['picture'])){

                            $param_image = $property['picture'];

                        }

                        if($this->feed_setting['params_as_column']){

                            $params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                            $select_params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                            $option_columns[] = $param_title;

                        }elseif(!$this->feed_setting['option_columns']){

                            $option_columns[] = $param_title;

                        }

                        $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                        ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                        if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                            $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                        }

                        if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                            $params_this['product_feature_code'] = $id;

                        }

                        $params[] = $params_this;

                    }
                    
                }
                
            }
            
            if(isset($offer_row->accessory_properties->accessory_property)){
                
                $properties = $offer_row->accessory_properties;
                
                if(isset($properties->accessory_property)){
                    
                    foreach ($properties->accessory_property as $property) {
                    
                        $property = (array)$property;

                        $param_title = '';

                        $param_value = '';
                        
                        $param_group_title_this = $param_group_title. " (акссесуары)";

                        if(isset($property['id']) && isset($this->feed_setting['property'][$property['id']])){

                            $param_title = $this->feed_setting['property'][$property['id']]['title'];

                        }

                        if(isset($property['value_id']) && isset($this->feed_setting['property_value'][$property['value_id']])){

                            $param_value = $this->feed_setting['property_value'][$property['value_id']]['title'];

                        }

                        $param_image = '';

                        $quantity_on_option = 100;

                        if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){

                            $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];

                        }

                        if(isset($property['picture'])){

                            $param_image = $property['picture'];

                        }

                        if($this->feed_setting['params_as_column']){

                            $params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                            $select_params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                            $option_columns[] = $param_title;

                        }elseif(!$this->feed_setting['option_columns']){

                            $option_columns[] = $param_title;

                        }

                        $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title_this,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                        ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                        if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                            $params_this['feature_code'] = md5($param_group_title_this.$param_title.$param_value.$param_image);

                        }

                        if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                            $params_this['product_feature_code'] = $id;

                        }

                        $params[] = $params_this;

                    }
                    
                }
                
            }
            
            if(isset($offer_row->options->option)){
                
                $properties = $offer_row->options;
                
                if(isset($properties->option)){
                    
                    foreach ($properties->option as $property) {
                    
                        $property = (array)$property;

                        $param_title = 'Размер';
                    
                        if(isset($this->feed_setting['option_options_name']) && $this->feed_setting['option_options_name']!==''){

                            $param_title = $this->feed_setting['option_options_name'];

                        }
                    
                    

                        $param_value = $property['title'];
                        
                        $param_price = $property['price'];
                        
                        $param_vendor_code = $property['vendor_code'];
                        
                        if($param_vendor_code){
                            
                            $param_value = $param_value.' ('.$param_vendor_code.')';
                            
                        }

                        $param_image = '';

                        $quantity_on_option = 100;

                        if(isset($this->feed_setting['quantity_on_option']) && $this->feed_setting['quantity_on_option']!==''){

                            $quantity_on_option = (int)$this->feed_setting['quantity_on_option'];

                        }

                        if(isset($property['picture'])){

                            $param_image = $property['picture'];

                        }

                        if($this->feed_setting['params_as_column']){

                            $params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['select_params_as_column'] && in_array($param_title, $this->feed_setting['select_params_as_column'])){

                            $select_params_as_column[$param_title] = (string)$param_value;

                        }

                        if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                            $option_columns[] = $param_title;

                        }elseif(!$this->feed_setting['option_columns']){

                            $option_columns[] = $param_title;

                        }

                        $params_this = array('title'=>$param_title,'price'=>$param_price,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');

                        ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                        if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                            $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                        }

                        if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                            $params_this['product_feature_code'] = $param_vendor_code;

                        }

                        $params[] = $params_this;

                    }
                    
                }
                
            }
            
            if(isset($offer_row->title)){

                $title = $this->getValueFromCDATA($offer_row->title);

            }
            
            if(isset($offer_row->price)){

                $price = (float)$this->getValueFromCDATA($offer_row->price);

            }
            
            if(isset($offer_row->analogs->analog)){
                
                $properties = $offer_row->analogs;
                
                if(isset($properties->analog)){
                    
                    foreach ($properties->analog as $property) {
                    
                        $property = (array)$property;

                        $analogs[] = $property['id'];

                    }
                    
                }
                
            }
            
            $analogs = implode(',', $analogs);

            if(isset($offer_row->description)){
                
                if(strstr((string)$offer_row->description, '[CDATA[')){
                    
                    $description = trim(html_entity_decode(str_replace(array('&lt;![CDATA[',']]&gt;',']]>', ' ]]&gt;'), array('','','',''), (string)$offer_row->description)));
                    
                }else{
                    
                    $description = (string)$offer_row->description;
                    
                }
                
                $description = str_replace('Описание=', '', $description);

            }
            
            $this->feed_setting['offers'][$id] = array();
            
            if(isset($attributes_offer['@attributes']) && $attributes_offer['@attributes']){

                foreach ($attributes_offer['@attributes'] as $attributes_offer_name => $attributes_offer_value) {

                    if($attributes_offer_name=='available'){

                        $this->feed_setting['offers'][$id]['available_status'] = (string)$attributes_offer_value;

                        $this->feed_setting['offers'][$id]['available_balance'] = $available_balance;

                    }else{

                        $this->feed_setting['offers'][$id][$attributes_offer_name] = (string)$attributes_offer_value;

                    }

                }

            }
            
            foreach ($offer_row as $tag_name => $tag_value) {
                
                if(!isset($this->feed_setting['offers'][$id][$tag_name])){
                    
                    $offer_row_new[$tag_name] = $this->getValueFromCDATA($tag_value);
                    
                }
                
            }
            
            $this->feed_setting['offers'][$id] = array_merge($this->feed_setting['offers'][$id],$offer_row_new, $params_as_column, $select_params_as_column, $offer_additional_colums);
            
            $this->feed_setting['offers'][$id]['params'] = $params;
            
            $this->feed_setting['offers'][$id]['id'] = $id;

            $this->feed_setting['offers'][$id]['pictures'] = implode(',', $pictures);

            $this->feed_setting['offers'][$id]['categories'] = implode('---', $categories);

            $this->feed_setting['offers'][$id]['description'] = $description;

            $this->feed_setting['offers'][$id]['price'] = $price;

            $this->feed_setting['offers'][$id]['title'] = $title;

            $this->feed_setting['offers'][$id]['trademark'] = $supplier_trademark_id;
            
            $this->feed_setting['offers'][$id]['analogs'] = $analogs;
            
            if($code!==''){
                
                $this->feed_setting['offers'][$id]['code'] = $code;
                
            }
            
            if($country_name!==''){
                
                $this->feed_setting['offers'][$id]['country_name'] = $country_name;
                
            }
            
            if($available_balance!==''){
                
                $this->feed_setting['offers'][$id]['available_balance'] = $available_balance;
                
            }
            
            if($available_status!==''){
                
                $this->feed_setting['offers'][$id]['available_status'] = $available_status;
                
            }
            
            if($sale_price!==''){
                
                $this->feed_setting['offers'][$id]['sale_price'] = $sale_price;
                
            }
            
            if($wholesale_price!==''){
                
                $this->feed_setting['offers'][$id]['wholesale_price'] = $wholesale_price;
                
            }
            
            if($price_selling!==''){
                
                $this->feed_setting['offers'][$id]['price_selling'] = $price_selling;
                
            }
            
            $options_microdata_1 = $this->getVariationsArrayWhisString($this->feed_setting['offers'][$id],$option_columns,$price,$available_balance,  current($pictures));
            
            if($options_microdata_1){

                if(isset($this->feed_setting['option_value_by_column']) && $this->feed_setting['option_value_by_column']==='name_column'){

                    $variations_array_whis_string_temp = $options_microdata_1;

                    foreach($variations_array_whis_string_temp as $variation_array_option_name => $variation_array){

                        $variations_array_whis_string = array();

                        foreach($variation_array as $variation_array_name => $variation_array_array){

                            $variations_array_whis_string[] = implode('|',$variation_array_array);

                        }

                        $this->feed_setting['offers'][$id]['options_'.$variation_array_option_name] = implode('---',$variations_array_whis_string);

                    }

                }
                elseif(isset($this->feed_setting['option_value_by_column']) && $this->feed_setting['option_value_by_column']==='value_column'){

                    $variations_array_whis_string_temp = $options_microdata_1;

                    $variations_array_whis_string = array();

                    $v = 0;

                    foreach($variations_array_whis_string_temp as $variation_array_option_name => $variation_array){

                        foreach($variation_array as $variation_array_name => $variation_array_array){

                            $this->feed_setting['offers'][$id]['options_'.$v] = implode('|',$variation_array_array);

                            $v++;

                        }

                    }

                }
                else{

                    $variations_array_whis_string_temp = $options_microdata_1;

                    $variations_array_whis_string = array();

                    foreach($variations_array_whis_string_temp as $variation_array){

                        foreach($variation_array as $variation_array_name => $variation_array_array){

                            $variations_array_whis_string[] = implode('|',$variation_array_array);

                        }

                    }

                    $this->feed_setting['offers'][$id]['options'] = implode('---',$variations_array_whis_string);

                }

            }
            
            $this->feed_setting['offers'][$id]['attributes'] = $this->getAttributes($this->feed_setting['offers'][$id],$delete_params);
            
            $unsets = array('@attributes','picture','params','delivery-options');
            
            if($this->feed_setting['delete_columns']){
                
                $unsets = array_merge($unsets,$this->feed_setting['delete_columns']);
                
            }
            
            foreach ($unsets as $name) {
                
                unset($this->feed_setting['offers'][$id][$name]);
                
            }
            
            foreach ($this->feed_setting['offers'][$id] as $first_row_name => $tmp) {

                if($tmp!==''){
                    
                    $this->feed_setting['first_row'][$first_row_name] = $first_row_name;
                    
                }
                else{
                    
                    unset($this->feed_setting['offers'][$id][$first_row_name]);
                    
                }

            }
            
            $codes = FALSE;
            
            if(isset($offer_row->code) && isset($offer_row_new['url']) && $offer_row_new['url']){

                foreach ($offer_row->code as $code_tag) {
                   
                    $codes[$this->getValueFromCDATA($code_tag)]['code'] = $this->getValueFromCDATA($code_tag);
                    
                    $codes[$this->getValueFromCDATA($code_tag)]['picture'] = $offer_row_new['url'].'&p='. md5($offer_row_new['url']).'.jpg';
                    
                }

            }
            
            if($codes){
                
                unset($this->feed_setting['offers'][$id]);
                
                foreach ($codes as $code) {
                    
                    $this->feed_setting['offers'][$code['code']] = array(
                        'code' => $code['code'],
                        'picture' => $code['picture'],
                    );
                    
                    $this->feed_setting['first_row']['code'] = 'code';
                    
                    $this->feed_setting['first_row']['picture'] = 'picture';
                    
                }
                
            }
            
            if($this->feed_setting['dvcom_group_id'] && isset($this->feed_setting['offers'][$id][$this->feed_setting['dvcom_group_id']]) && $this->feed_setting['offers'][$id][$this->feed_setting['dvcom_group_id']]!==''){
                
                $this_group_offer = $this->feed_setting['offers'][$id];
                
                $new_id_from_group_id = $this->feed_setting['offers'][$id][$this->feed_setting['dvcom_group_id']];
                
                if($this->feed_setting['dvcom_group_delete'] && isset($this_group_offer['name'])){
                    
                    $this_group_offer['name'] = str_replace($this->feed_setting['dvcom_group_delete']['find'], $this->feed_setting['dvcom_group_delete']['replace'], $this_group_offer['name']);
                    
                }
                
                if(!isset($this->feed_cache['group_id_unique_data'][$new_id_from_group_id])){
                    
                    $this_group_offer_name_elements_result = $this->getCleanExplode(' ', $this_group_offer['name']);
                    
                    foreach ($this_group_offer_name_elements_result as $this_group_offer_name_element_result) {
                        
                        $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['all_data'][$this_group_offer_name_element_result] = $this_group_offer_name_element_result;
                        
                    }
                    
                    $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['unique_data'] = $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['all_data'];
                    
                }
                else{
                    
                    $this_group_all_data = $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['all_data'];
                    
                    $this_group_unique_data = $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['unique_data'];
                    
                    $this_group_unique_data_new = array();
                    
                    $this_group_offer_name_elements = $this->getCleanExplode( ' ' , $this_group_offer['name']);
                    
                    foreach ($this_group_offer_name_elements as $this_group_offer_name_element) {
                     
                        if(!in_array($this_group_offer_name_element, $this_group_unique_data) && !in_array($this_group_offer_name_element, $this_group_all_data)){
                            
                            $this_group_unique_data_new[$this_group_offer_name_element] = $this_group_offer_name_element;
                            
                        }
                        elseif(in_array($this_group_offer_name_element, $this_group_unique_data)){
                            
                            unset($this_group_unique_data[$this_group_offer_name_element]);
                            
                        }
                        
                        $this_group_all_data[$this_group_offer_name_element] = $this_group_offer_name_element;
                        
                    }
                    
                    $this_group_unique_data = array_merge($this_group_unique_data,$this_group_unique_data_new);
                    
                    $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['all_data'] = $this_group_all_data;
                    
                    $this->feed_cache['group_id_unique_data'][$new_id_from_group_id]['unique_data'] = $this_group_unique_data;
                    
                }
                
                //echo $new_id_from_group_id.'-'.implode(' ', $this_group_offer_name_elements_result).'-<br>';
                
                if($this->feed_setting['dvcom_group_id_write_to_id'] && $this->feed_setting['dvcom_product_id_column_name']!==''){
                    
                    $this_group_offer[$this->feed_setting['dvcom_product_id_column_name']] = $new_id_from_group_id;
                    
                }
                
                if(isset($this->feed_setting['offers'][$new_id_from_group_id])){
                    
                    $last_group_offer = $this->feed_setting['offers'][$new_id_from_group_id];
                    
                    $options = '';
                    
                    $attributes = array();
                    
                    $categories = array();
                    
                    if(isset($last_group_offer['categories'])){
                        
                        $categories = explode('---', $last_group_offer['categories']);
                        
                        if(isset($this_group_offer['categories']) && $this_group_offer['categories']!==''){
                            
                            $categories_new = explode('---', $this_group_offer['categories']);
                            
                            foreach ($categories_new as $category) {
                                
                                if(!in_array($category, $categories)){
                                    
                                    $categories[$category] = $category;
                                    
                                }
                                
                            }
                            
                        }
                        
                        $categories = implode('---', $categories);
                        
                    }
                    
                    if(isset($last_group_offer['options'])){
                        
                        $options = explode('---', $last_group_offer['options']);
                        
                        if(isset($this_group_offer['options']) && $this_group_offer['options']!==''){
                            
                            $options_new = explode('---', $this_group_offer['options']);
                            
                            foreach ($options_new as $option) {
                                
                                if(!in_array($option, $options)){
                                    
                                    $options[$option] = $option;
                                    
                                }
                                
                            }
                            
                        }
                        
                        $options = implode('---', $options);
                        
                    }
                   
                    if(isset($last_group_offer['attributes'])){
                        
                        $attributes = explode('|', $last_group_offer['attributes']);
                        
                        if(isset($this_group_offer['attributes']) && $this_group_offer['attributes']!==''){
                            
                            $attributes_new = explode('---', $this_group_offer['attributes']);
                            
                            foreach ($attributes_new as $attribute) {
                                
                                if(!in_array($attribute, $attributes)){
                                    
                                    $attributes[$attribute] = $attribute;
                                    
                                }
                                
                            }
                            
                        }
                        
                        $attributes = implode('|', $attributes);
                        
                    }
                    
                    $this_group_offer['options'] = $options;
                    
                    $this_group_offer['attributes'] = $attributes;
                    
                    $this_group_offer['categories'] = $categories;
                    
                    $this->feed_setting['offers'][$new_id_from_group_id] = $this_group_offer;
                    
                    unset($this->feed_setting['offers'][$id]);
                    
                }
                
                else{
                    
                    $this->feed_setting['offers'][$new_id_from_group_id] = $this_group_offer;
                    
                    unset($this->feed_setting['offers'][$id]);
                    
                }
                
            }
            
            if($only_first_row){
                
                unset($this->feed_setting['offers'][$id]);
                
            }
            elseif($this->feed_cache['status'] && $this->feed_cache['count_nodes'] && $this->feed_cache['count_nodes']==count($this->feed_setting['offers'])){
                
                $offers_cache_file_name = $offers_file_name_prefix.count($this->feed_setting['cache_offers']);
                
                $this->writeCache($offers_cache_file_name, $this->feed_setting['offers'],'yml_cache/');
                
                $this->feed_setting['offers'] = array();
                
                $this->feed_setting['cache_offers'][$offers_cache_file_name] = $offers_cache_file_name;
                
            }
        
    }
    
    
    public function getAttributes($supplier_product,$delete_params=array()) {
        
        $features = array();
        
        $attribute_columns = $this->feed_setting['attribute_columns'];
        
        if(isset($supplier_product['params']) && $supplier_product['params']){
            
            foreach($supplier_product['params'] as $feature){

                $feature_name = $feature['title'];

                $feature_value = $feature['value'];

                $feature_group_title = $feature['group_title'];
                
                if($feature_value!=='' && $feature_name!=='' && (!$attribute_columns || in_array($feature_name, $attribute_columns)) ){
                    
                    if($delete_params && !in_array($feature_name, $delete_params) || !$delete_params){

                        if($this->feed_setting['attribute_whis_group']){
                        
                        if($feature_group_title===''){
                            
                                $feature_group_title = $this->feed_setting['group_attribute_name'];

                            }

                            $features[] = $feature_group_title.'---'.$feature_name.'---'.$feature_value;

                        }else{

                            $features[] = $feature_name.'---'.$feature_value;

                        }

                    }
                    
                }

            }

        }

        $features_as_string = implode('|', $features);
        
        return $features_as_string;
        
    }
    
    public function getVariationsArrayWhisString($supplier_product,$option_columns,$recommended_retail_price,$availability_balance,$image){
        
        $variations_array_whis_string = array();

        $column_this = '';

        $type_this = $this->feed_setting['option_type'];

        $subtract_this = 0;

        $required_this = 0;

        $option_name_this = '';
        
        $image_this = '';

        if($type_this=='image'){
            
            $image_this = $image;
            
        }
        
        $price_this = $recommended_retail_price;

        $quantity_this = $availability_balance;

        $product_feature_code_this = $supplier_product['id'];

        $feature_code_this = '';

        foreach ($supplier_product['params'] as $option_value_this_row) {

            $option_name_this = $option_value_this_row['title'];

            $column_this = $option_name_this;

            if(isset($option_value_this_row['picture']) && $option_value_this_row['picture'] && $type_this=='image'){

                $image_this = $option_value_this_row['picture'];

            }
            
            if(in_array($column_this, $this->feed_setting['option_whis_image'])){
                
                if(isset($option_value_this_row['picture']) && $option_value_this_row['picture']){

                    $image_this = $option_value_this_row['picture'];

                }else{
                    
                    if(is_array($supplier_product['pictures'])){
                        
                        $image_this = key($supplier_product['pictures']);
                        
                    }elseif(is_string($supplier_product['pictures'])){
                        
                        $image_this = $supplier_product['pictures'];
                        
                    }
                    
                }
                
            }

            if(isset($option_value_this_row['product_feature_code']) && $option_value_this_row['product_feature_code']!==''){

                $product_feature_code_this = $option_value_this_row['product_feature_code'];

            }

            if(isset($option_value_this_row['feature_code']) && $option_value_this_row['feature_code']!==''){

                $feature_code_this = $option_value_this_row['feature_code'];

            }

            if(isset($option_value_this_row['quantity']) && $option_value_this_row['quantity']!==''){

                $quantity_this = $option_value_this_row['quantity'];

            }

            if(isset($option_value_this_row['price']) && $option_value_this_row['price']!==''){

                $price_this = $option_value_this_row['price'];

            }
			
            if($image_this){

                    $image_parts = explode(',',$image_this);

                    $image = trim($image_parts[0]);

                    $image_this = $image;

            }

            if($option_value_this_row['title'] && in_array($column_this, $option_columns)){

                $option_value_this = (string)trim($option_value_this_row['value']);

                $option_value_this_parts = explode($this->feed_setting['delimeter_option_value'],$option_value_this);

                foreach($option_value_this_parts as $option_value_this){

                    $variations_array = array(
                        $type_this,$option_name_this,$option_value_this,$required_this,$quantity_this,$subtract_this,'+',$price_this,'+',0,'+',0,$image_this
                    );

                    if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                        $variations_array[] = $feature_code_this;

                    }

                    if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                        $variations_array[] = $product_feature_code_this;

                    }

                    if(!isset($variations_array_whis_string[$option_name_this])){

                        $variations_array_whis_string[$option_name_this]['variations__0'] = $variations_array;

                    }else{

                        $variations_array_whis_string[$option_name_this]['variations__'.count($variations_array_whis_string[$option_name_this])] = $variations_array;

                    }

                }

            }

        }
        
        return $variations_array_whis_string;
        
    }
}