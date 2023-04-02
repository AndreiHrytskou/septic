<?php
class anyDSVXLSheliosvan0920 { 
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
        'name' => "heliosvan0920",
        'id_specification' => "heliosvan0920___1_0_0_0",
        'version' => "1_0_0_0",
        'encoding' => 'UTF-8',
        'check_valid_status' => FALSE
    );
    private $feed_cache = array(
            'status'=>0,
            'count_nodes'=>1000,
            'offers_file_name_prefix'=>'oanydsvxlsym_heliosvan0920_cache_',
            'categories_file_name_prefix'=>'oanydsvxlsym_heliosvan0920_cats_cache_',
            'offers_file_name_prefix_csv'=>'heliosvan0920_csv_'
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
        
        if(!isset($template_data_on_step_one['heliosvan0920_count_product_on_sec'])){
            
            $template_data_on_step_one['heliosvan0920_count_product_on_sec'] = $this->settings['count_product_on_sec'];
            
        }
        
        if(!isset($template_data_on_step_one['heliosvan0920_max_limit'])){
            
            $template_data_on_step_one['heliosvan0920_max_limit'] = $this->settings['max_limit'];
            
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
        
        $result = array('error'=>'','file_upload'=>'');
        
        $tags = array('shop2'=>array('offers2'=>array('element')));
        
        //$tags = array('yml_catalog'=>array('shop'=>array('categories'=>array('category'))));
        
        $tags_new_names = array(
            'yml_catalog'=>'yml_catalog',
            'shop2'=>'shop2',
            'offers2'=>'offers2',
            'element'=>'element',
            'sections'=>'sections',
            'section'=>'section',
            'properties'=>'properties',
            'property'=>'property',
            'categories'=>'categories',
            'category'=>'category',
        );
	
	$handle = fopen($filename, "r");
        
        $xml_check = fread($handle, 2048);
        
	if(!strstr($xml_check, '<ProductCatalog') && !strstr($xml_check, '<Каталог') ){
	    
	    $result['error'] = "Данный файл не является файлом XML. Проверьте правильность ссылки или файла";
	    
	    return $result;
	    
	}
        elseif(strstr($xml_check, '<ProductCatalog')){
            
            $xml_replace = file_get_contents($filename);
        
            $xml_replace = str_replace(
                    array('</ProductCatalog>',                   '<ProductCatalog'), 
                    array('</offers2></shop2></yml_catalog>',                   '<yml_catalog><shop2><offers2'),
                    $xml_replace);

            $xml_replace = str_replace(
                    array('<Product>','</Product>'), 
                    array('<element>','</element>'),
                    $xml_replace);
            
        }
        elseif(strstr($xml_check, '<stock')){
            
            
            
        }
        
        $handle = fopen($filename, "w+");
        
        fwrite($handle, $xml_replace);
        
        fclose($handle);
        
        //$this->getYMLCategories($filename,$template_data, array('shop2'=>array('sections'=>array('section'))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        //$this->getYMLCategories($filename,$template_data, array('shop2'=>array('properties'=>array('property'))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->getYMLCategories($filename,$template_data, array('yml_catalog'=>array('shop2'=>array('categories'=>array('category')))), 1, $tags_new_names, 0, 100000,  '', 0);
        
        $this->feed_setting['delete_by_vendor'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_delete_by_vendor']);
        
        $option_columns = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_option_columns']);
        
        $attribute_columns = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_attribute_columns']);
        
        $delete_columns = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_delete_columns']);
        
        $this->feed_setting['delete_columns'] = $delete_columns;
        
        $this->feed_setting['attribute_columns'] = $attribute_columns;
        
        $this->feed_setting['option_columns'] = $option_columns;
        
        $this->feed_setting['option_value_by_column'] = $template_data['heliosvan0920_option_value_by_column'];
        
        $this->feed_setting['option_type'] = $template_data['heliosvan0920_option_type'];
        
        $this->feed_setting['params_as_column'] = $template_data['heliosvan0920_params_as_column'];
        
        if($template_data['heliosvan0920_max_curl_timeout'] && $template_data['heliosvan0920_max_curl_timeout']!=='' && $template_data['heliosvan0920_max_curl_timeout']<600){
            
            $this->settings['max_curl_timeout'] = $template_data['heliosvan0920_max_curl_timeout']*1000;
            
        }
        
        $this->feed_setting['option_whis_image'] = array();
        
        if(isset($template_data['heliosvan0920_option_whis_image'])){
            
            $this->feed_setting['option_whis_image'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_option_whis_image']);
            
        }
        
        $this->feed_setting['heliosvan0920_group_id'] = '';
        
        if(isset($template_data['heliosvan0920_group_id']) && $template_data['heliosvan0920_group_id']!==''){
            
            $this->feed_setting['heliosvan0920_group_id'] = $template_data['heliosvan0920_group_id'];
            
        }
        
        $this->feed_setting['heliosvan0920_group_delete'] = array();
        
        if(isset($template_data['heliosvan0920_group_delete']) && $template_data['heliosvan0920_group_delete']!==''){
            
            $this->feed_setting['heliosvan0920_group_delete']['find'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_group_delete']);
            
            $this->feed_setting['heliosvan0920_group_delete']['replace'] = array();
            
        }
        
        $this->feed_setting['heliosvan0920_group_id_write_to_id'] = FALSE;
        
        if(isset($template_data['heliosvan0920_group_id_write_to_id']) && $template_data['heliosvan0920_group_id_write_to_id']){
            
            $this->feed_setting['heliosvan0920_group_id_write_to_id'] = TRUE;
            
        }
        
        $this->feed_setting['heliosvan0920_product_id_column_name'] = '';
        
        if(isset($template_data['heliosvan0920_product_id_column_name']) && $template_data['heliosvan0920_product_id_column_name']!==''){
            
            $this->feed_setting['heliosvan0920_product_id_column_name'] = $template_data['heliosvan0920_product_id_column_name'];
            
        }
        
        $this->feed_setting['heliosvan0920_unit_not_write'] = FALSE;
        
        if(isset($template_data['heliosvan0920_unit_not_write']) && $template_data['heliosvan0920_unit_not_write']){
            
            $this->feed_setting['heliosvan0920_unit_not_write'] = TRUE;
            
        }
        
        
        $this->feed_setting['select_params_as_column'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_select_params_as_column']);
        
        $this->feed_setting['delete_params'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_delete_params']);
        
        $this->feed_setting['start_offer'] = (int)$template_data['heliosvan0920_start_offer'];
        
        if($this->feed_setting['start_offer']==1){
            
            $this->feed_setting['start_offer'] = 0;
            
        }
        
        $this->feed_setting['limit_offer'] = trim($template_data['heliosvan0920_limit_offer']);
        
        if($this->feed_setting['limit_offer']===''){
            
            $this->feed_setting['limit_offer'] = 1000000;
            
        }else{
            
            $this->feed_setting['limit_offer'] = (int)$this->feed_setting['limit_offer'];
            
        }
        
        /*
         * $xml_replace = file_get_contents($filename);
        
        $xml_replace = str_replace(array('<offers>','</offers>'), array('<shop><offers>','</offers></shop>'), $xml_replace);
        
        $handle = fopen($filename, "w+");
        
        fwrite($handle, $xml_replace);
        
        fclose($handle);
         * 
         */
        
        $result = $this->getCSVFromYML($filename,$template_data, $tags, 1, $tags_new_names, $this->feed_setting['start_offer'], $this->feed_setting['limit_offer'],  '', 0);
        
        if($result['file_upload'] && is_string($result['file_upload']) && is_file(DIR_DOWNLOAD.$result['file_upload'])){
            
            $result['file_upload'] = $result['file_upload'];
            
        }
        
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
        
        $heliosvan0920_categories_as_string = array();
        
        if(isset($template_data['heliosvan0920_categories_as_string']) && $template_data['heliosvan0920_categories_as_string']!==''){
            
            $heliosvan0920_categories_as_string = explode(PHP_EOL, $template_data['heliosvan0920_categories_as_string']);
            
            foreach ($heliosvan0920_categories_as_string as $key => $value) {
                
                $heliosvan0920_categories_as_string[$key] = html_entity_decode(trim(strtoupper($value)));
                
                if(!$heliosvan0920_categories_as_string[$key]){
                    unset($heliosvan0920_categories_as_string[$key]);
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
                            
                            if($heliosvan0920_categories_as_string){
                                
                                $skip_by_category = TRUE;
                                
                                foreach ($heliosvan0920_categories_as_string as $category) {
                                
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
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_delete_by_category_id']);
        
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
    
    public function getYMLCategories($filename,$template_data,$tags,$count_nodes=1,$tags_new_names=array(),$start=0,$limit=100000,$file_name_cach_prefix,$selected_setting_id=''){
        
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
                                                        
                                                        if(isset($attributes['@attributes']['name'])){

                                                            $name = trim((string)$attributes['@attributes']['name']);

                                                        }else{
                                                            
                                                            $name = trim((string)$category_row);
                                                            
                                                        }
                                                        
                                                        if(isset($category_row->{'ИдРодителя'})){
                                                            
                                                           $parent_id = trim((string)$category_row->{'ИдРодителя'}); 
                                                            
                                                        }
                                                        
                                                        if(isset($category_row->{'Наименование'})){
                                                            
                                                           $name = trim((string)$category_row->{'Наименование'}); 
                                                            
                                                        }
                                                        
                                                        if(isset($category_row->{'Ид'})){
                                                            
                                                           $category_id = trim((string)$category_row->{'Ид'}); 
                                                            
                                                        }
                                                        
                                                        if(!$parent_id){
                                                            
                                                            $parent_id = 0;
                                                            
                                                        }
							
							if($category_id==$parent_id){
							    
							    $parent_id = 0;
							    
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
        
        $this->feed_setting['delete_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_delete_by_category_id']);
        
        $this->feed_setting['set_products_by_category_id'] = $this->getArrayByDelimeterAndString($template_data['heliosvan0920_set_products_by_category_id']);
        
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
            
            $params_from_prop = array();
            
            $params = array();
            
            $option_columns = array();
            
            $quantity_on_option = 0;
            
            $select_params_as_column = array();
            
            $offer_row_new = array();
            
            $code = '';
            
            $id = '';
            
            $group_id = '';
            
            $group_code = '';
            
            $name = '';
            
            $pictures = array();
            
            $categories = array();
            
            $price = '';
            
            $price_selling = '';
            
            $available_balance = 0;
            
            if(isset($attributes_offer['@attributes']) && $attributes_offer['@attributes']){

                foreach ($attributes_offer['@attributes'] as $attributes_offer_name => $attributes_offer_value) {

                    if($attributes_offer_name=='available' && (string)$attributes_offer_value=='true'){

                        $quantity_on_option = 100;
                    
                    }
                    elseif($attributes_offer_name=='prodID'){
                        
                        $id = $attributes_offer_value;
                        
                    }
                    elseif($attributes_offer_name=='prodID'){
                        
                        $id = $attributes_offer_value;
                        
                    }
                    elseif($attributes_offer_name=='code'){
                        
                        $id = $attributes_offer_value;
                        
                    }elseif($attributes_offer_name=='id'){
                        
                        $id = $attributes_offer_value;
                        
                    }
                    elseif($attributes_offer_name=='name'){
                        
                        $name = $attributes_offer_value;
                        
                    }
                    
                    $offer_row_new[$attributes_offer_name] = $attributes_offer_value;
                    
                }
                
            }
            
            if(isset($attributes_offer['@attributes']['id'])){

                $id = $attributes_offer['@attributes']['id'];

            }
            
            if(isset($offer_row->external_id)){

                $id = (string)$offer_row->external_id;

            }
            
            if(isset($offer_row->code)){

                $code = (string)$offer_row->code;

            }
            
            if(isset($offer_row->atricle) && !$id){
                
                $id = $this->getValueFromCDATA($offer_row->atricle);
                
            }
            
            if(isset($offer_row->id) && !$id){
                
                $id = $this->getValueFromCDATA($offer_row->id);
                
            }
            
            if(isset($offer_row->code) && !$id){
                
                $id = $this->getValueFromCDATA($offer_row->code);
                
            }
            
            if(isset($offer_row->{'Артикул'}) && !$id){
                
                $id = $this->getValueFromCDATA($offer_row->{'Артикул'});
                
            }
            
            if($offer_row->price){
                
                $attributes_offer = (array)$offer_row->price->attributes();
                
                /*
                foreach ($attributes_offer['@attributes'] as $attributes_offer_name => $attributes_offer_value) {

                    $offer_row_new[$attributes_offer_name] = $attributes_offer_value;
                    
                }
                */
                
            }
            
            
            
            $param_group_title = "Характеристики";
            
            if(isset($offer_row->properties)){
                
                $properties = $offer_row->properties;
                
                if(isset($properties->property)){
                    
                    foreach ($properties->property as $property) {
                        
                        $property = (array)$property;
                        
                        $params_this = array();
                        
                        if(isset($property['external_id']) && isset($this->feed_setting['properties'][$property['external_id']])){
                            
                            $property_value = '';
                            
                            $property_name = $property['external_id'];
                            
                            if(isset($property['value'])){
                                
                                $property_value = (string)$property['value'];
                                
                            }
                            
                            if(isset($this->feed_setting['properties'][$property['external_id']]['name'])){
                                
                                $property_name = $this->feed_setting['properties'][$property['external_id']]['name'];
                                
                            }
                            
                            $params_from_prop[] = array(
                                'value' => $property_value,
                                'name' => $property_name,
                            );
                            
                            $params_this = array('title'=>$property_name,'quantity'=>'','group_title'=>$param_group_title,'value'=>$property_value,'image'=>'','feature_code'=>'','product_feature_code'=>'');
                            
                        }
                        
                        if($params_this){
                            
                            if($this->feed_setting['select_params_as_column'] && in_array($property_name, $this->feed_setting['select_params_as_column'])){

                                $select_params_as_column[$property_name] = (string)$property_value;

                            }
                            
                            $params[] = $params_this;
                            
                            if($this->feed_setting['option_columns'] && in_array($property_name, $this->feed_setting['option_columns'])){

                                $option_columns[] = $property_name;
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->models) && isset($offer_row->models->model)){
                
                $models_obj = $offer_row->models;
                
                if(isset($models_obj->model) && count($models_obj->model)>1){
                    
                    $code = $id;
                    
                    foreach ($models_obj->model as $property) {
                        
                        $property_attributes = (array)$property->attributes();
                        
                        $price_this = (string)$property_attributes['@attributes']['price'];
                        
                        if(!$price){
                            
                            $price = $price_this;
                            
                        }
                        
                        $available_balance += (int)$property_attributes['@attributes']['count'];
                        
                        $price_selling_this  = (string)$property_attributes['@attributes']['selling'];
                        
                        if(!$price_selling){
                            
                            $price_selling = $price_selling_this;
                            
                        }
                        
                        $code_this  = (string)$property_attributes['@attributes']['code'];
                        
                        $description_model = $this->getValueFromCDATA($property->description);
                        
                        $name = $description_model.' ('.$code_this.')';
                        
                        $params_this = array('title'=>"Вариант",'price'=>$price_selling,'quantity'=>(int)$property_attributes['@attributes']['count'],'group_title'=>'','value'=>$name,'image'=>'','feature_code'=>'','product_feature_code'=>'');
                        
                        if($params_this){
                            
                            $params[] = $params_this;
                            
                        }
                        
                        $this->feed_setting['option_columns']["Вариант"] = "Вариант";
                        
                        $option_columns[] = "Вариант";
                        
                    }
                    
                }
                else{
                 
                    foreach ($models_obj->model as $property) {
                        
                        $property_attributes = (array)$property->attributes();
                        
                        $price = (string)$property_attributes['@attributes']['price'];
                        
                        $available_balance = (string)$property_attributes['@attributes']['count'];
                        
                        $price_selling  = (string)$property_attributes['@attributes']['selling'];
                        
                        $code  = (string)$property_attributes['@attributes']['code'];
                        
                    }
                    
                }
                
            }
            
            if(!$id && isset($offer_row->{'Ид'})){

                $id = (string)$offer_row->{'Ид'};

            }
            
            if(!$id && isset($offer_row->{'id'})){

                $id = (string)$offer_row->{'id'};

            }
            
            if(!$id && isset($offer_row->{'code'})){

                $id = (string)$offer_row->{'code'};

            }
            
            if(!$group_id && isset($offer_row->group)){
                
                $group_id = 'xnd-'.trim($this->getValueFromCDATA($offer_row->group));
                
            }
            
            if(!$group_code && isset($offer_row->group->properties->element->value)){
                
                $group_code = 'xnd-'.trim($this->getValueFromCDATA($offer_row->group->properties->element->value));
                
            }
            
            if(!$group_id && isset($attributes_offer['@attributes']['group_id'])){

                $group_id = 'xnd-'.(string)$attributes_offer['@attributes']['group_id'];

            }
            
            if(!$group_id && isset($offer_row->{'ГруповойАртикул'})){
                
                $group_id = 'xnd-'.trim($this->getValueFromCDATA($offer_row->{'ГруповойАртикул'}));
                
            }
            
            if(!$id && isset($offer_row->{'ProductCode'})){

                $id = (string)$offer_row->{'ProductCode'};

            }

            $country_name = '';

            $param_whis_balance = array('остаток','количество','наличие');
            
            $write_param_as_columns = array('Количество','Наличие',"Артикул");
            
            $offer_additional_colums = array();
            
            if(isset($offer_row->{'Атрибуты'})){

                $offer_additional_colums['Атрибуты'] = str_replace(array(': ', ' | '), array(':', '|'),(string)$offer_row->{'Атрибуты'});

            }
            
            if(isset($offer_row->{'Категория'})){

                $offer_additional_colums['Категория'] = str_replace(array(' / '), array('/'),(string)$offer_row->{'Категория'});

            }

            $size = '';

            $available_status = '';

            $description = '';

            $sale_price = '';

            $wholesale_price = '';
            
            $supplier_trademark_id = '';
            
            if(isset($offer_row->vendor)){

                $supplier_trademark_id = trim($this->getValueFromCDATA($offer_row->vendor));

            }
            
            if(isset($offer_row->properties->element)){
                
                foreach ($offer_row->properties->element as $property_value) {
                    
                    $params_this = array('title'=>trim($this->getValueFromCDATA($property_value->title)),'group_title'=>'','value'=>$this->getValueFromCDATA($property_value->value),'image'=>'','feature_code'=>'','product_feature_code'=>'');

                    $params[] = $params_this;
                    
                }
                
            }
            
            if(isset($offer_row->properties) && FALSE){

                if(!isset($this->feed_setting['properties/param'])){
                    
                    $xml = new XMLReader();
                    
                    $xml->open($this->file_name_on_xml);
                    
                    while ($xml->read()) {
            
                        $tag = $xml->name;
                        
                        if($tag=='properties'){
                            
                            while ($xml->read()) {
                                
                                $tag = $xml->name;
                                
                                if ($xml->nodeType == XMLReader::ELEMENT){
                                    
                                    if($tag == 'param'){
                                        
                                        if($xml->hasAttributes){
                                            
                                            $this_atr_id = 0;
                                            
                                            while($xml->moveToNextAttribute()){
                            
                                                if($xml->name=='id'){

                                                    $this_atr_id = $xml->value;

                                                }elseif($xml->name=='name'){

                                                    $this->feed_setting['properties/param'][$this_atr_id] = $xml->value;

                                                }

                                            }
                                            
                                        }
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            break;
                            
                        }
                        
                    }
                    
                }

            }
            
            if(isset($offer_row->Vendor) && !$supplier_trademark_id){

                $supplier_trademark_id = trim($this->getValueFromCDATA($offer_row->Vendor));

            }

            $supplier_country_id = '';

            if(isset($offer_row->country_of_origin)){

                $supplier_country_id = trim($this->getValueFromCDATA($offer_row->country_of_origin));

            }

            if(isset($offer_row->LastCountry)){

                $supplier_country_id = trim((string)$offer_row->LastCountry);

            }
            
            if(isset($offer_row->picture)){

                foreach ($offer_row->picture as $picture){

                    $pictures[$this->getValueFromCDATA($picture)] = $this->getValueFromCDATA($picture);

                }

                for($p=0;$p<5;$p++){
                    if(isset($offer_row->{'picture'.$p}) && $offer_row->{'picture'.$p}){
                        $picture = $this->getValueFromCDATA($offer_row->{'picture'.$p});
                        if($picture){
                            $pictures[(string)$picture] = (string)$picture;
                        }
                    }
                }

            }
            
            if(isset($offer_row->{'Фотографии'})){
                
                foreach ($offer_row->{'Фотографии'} as $pictures_xml) {
                    
                    foreach ($pictures_xml->{'Фотография'} as $picture){
                        
                        $picture_as_attr = (string)$picture;
                        
                        if($picture_as_attr){
                            
                            $pictures[$picture_as_attr] = $picture_as_attr;
                            
                        }

                    }
                    
                }

            }
            
            if(isset($offer_row->Images->Image)){

                foreach ($offer_row->Images->Image as $picture){
                    
                    $picture = $this->getValueFromCDATA($picture);
                    
                    if($picture){
                        
                        $pictures[ $picture ] = $picture;
                        
                    }

                }
                
            }
            
            if(!$pictures && isset($offer_row->Image)){

                foreach ($offer_row->Image as $picture){
                    
                    $picture = (array)$picture->attributes();
                    
                    if(isset($picture['@attributes']['url']) && $picture['@attributes']['url']){
                        
                        $pictures[ $picture['@attributes']['url'] ] = $picture['@attributes']['url'];
                        
                    }

                }
                
            }

            if(isset($offer_row->param) && !$supplier_country_id){

                foreach ($offer_row->param as $yml_param) {

                    $attributes = (array)$yml_param->attributes();

                    if(isset($attributes['@attributes']['name']) && ($attributes['@attributes']['name']=='Страна' || $attributes['@attributes']['name']=='Страна производства' || $attributes['@attributes']['name']=='Страна-производитель')){

                        $supplier_country_id = trim($this->getValueFromCDATA($yml_param));

                    }
                    
                    if(isset($attributes['@attributes']['name']) && in_array($attributes['@attributes']['name'], $write_param_as_columns)){

                        $offer_additional_colums[$attributes['@attributes']['name']] = trim($this->getValueFromCDATA($yml_param));

                    }
                    
                    //$write_param_as_columns

                }

            }

            if(!$supplier_country_id && isset($offer_row->country)){

                $supplier_country_id = trim($this->getValueFromCDATA($offer_row->country));

            }
            
            if(isset($offer_row->categories) && FALSE){
                
                $categories_nodes = $offer_row->categories;
                
                foreach($categories_nodes->category as $category){
                    
                    $category_this = array();
                    
                    $category_attr = (array)$category->attributes();
                    
                    if(isset($category_attr['@attributes']['Name'])){
                        
                        $category_this[] = $category_attr['@attributes']['Name'];
                        
                    }
                    
                    if(isset($category_attr['@attributes']['subName'])){
                        
                        $category_this[] = $category_attr['@attributes']['subName'];
                        
                    }
                    
                    if($category_this){
                        
                        $categories[] = implode('/', $category_this);
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->categories->{'Ид'})){

                foreach ($offer_row->categories->{'Ид'} as $category_xml) {
                    
                    $category_xml = $this->getValueFromCDATA($category_xml);
                    
                    if(isset($this->feed_setting['category_path'][$category_xml])){

                        $categories[] = $this->feed_setting['category_path'][$category_xml];
                        
                    }
                    
                }

            }
            
            $params_as_column = array();
            
            $delete_params = $this->feed_setting['delete_params'];
            
            $sizes = array();
            
            if(isset($offer_row->{'AttrList'})){
                
                foreach ($offer_row->{'AttrList'} as $param_values) {
                    
                    foreach ($param_values->element as $param_name => $attribute_value) {

                        $attributes = (array)$attribute_value->attributes();

                        if(isset($attributes['@attributes']['Name']) && isset($attributes['@attributes']['Value'])){

                            $attribute_value = trim((string)$attributes['@attributes']['Value']);

                            $unit = '';

                            $param_title = (string)$attributes['@attributes']['Name'].$unit;

                            $param_group_title = '';

                            $param_image = '';

                            $quantity_on_option = 100;

                            if($attribute_value!==''){

                                if($this->feed_setting['params_as_column']){

                                    $params_as_column[$attribute_value] = (string)$param_title;

                                }

                                if($this->feed_setting['select_params_as_column'] && in_array($attribute_value, $this->feed_setting['select_params_as_column'])){

                                    $select_params_as_column[$attribute_value] = (string)$param_title;

                                }

                                $params_tag = 'param';

                                $params_tag_attribute_name = $param_title;

                                $params_tag_attribute_value = (string)$attribute_value.$unit;

                                $supplier_params_id_this = md5($params_tag.'_'.$params_tag_attribute_name.'_'.$params_tag_attribute_value);

                                $param_group_title = $this->feed_setting['group_attribute_name'];

                                if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                                    $option_columns[] = $param_title;

                                }elseif(!$this->feed_setting['option_columns']){

                                    $option_columns[] = $param_title;

                                }

                                $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$attribute_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');


                                ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                                if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                                    $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                                }

                                if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                                    $params_this['product_feature_code'] = $id;

                                }

                                $params[] = $params_this;

                                //array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'product_feature_code'=>$id,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image));


                                //$params[] = array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image),'product_feature_code'=>$id);

                            }

                        }
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->{'Упаковка'})){
                
                foreach ($offer_row->{'Упаковка'} as $param_values) {
                    
                    foreach ($param_values as $param_name => $attribute_value) {

                        $attribute_value = trim((string)$attribute_value);

                        $unit = '';

                        $param_title = (string)$param_name.$unit;
                        
                        if($param_title=='РазмерКоробки'){
                            
                            $param_title = "Размер коробки";
                            
                        }elseif($param_title=='ШтукВКоробке'){
                            
                            $param_title = "Штук в коробке";
                            
                        }elseif($param_title=='ВесКоробки'){
                            
                            $param_title = "Вес коробки";
                            
                        }

                        $param_group_title = '';

                        $param_image = '';
                        
                        $quantity_on_option = 100;

                        if($attribute_value!==''){

                            if($this->feed_setting['params_as_column']){

                                $params_as_column[$attribute_value] = (string)$param_title;

                            }

                            if($this->feed_setting['select_params_as_column'] && in_array($attribute_value, $this->feed_setting['select_params_as_column'])){

                                $select_params_as_column[$attribute_value] = (string)$param_title;

                            }

                            $params_tag = 'param';

                            $params_tag_attribute_name = $param_title;

                            $params_tag_attribute_value = (string)$attribute_value.$unit;

                            $supplier_params_id_this = md5($params_tag.'_'.$params_tag_attribute_name.'_'.$params_tag_attribute_value);

                            $param_group_title = $this->feed_setting['group_attribute_name'];

                            if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                                $option_columns[] = $param_title;

                            }elseif(!$this->feed_setting['option_columns']){

                                $option_columns[] = $param_title;

                            }

                            $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$attribute_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');


                            ////1 - без кодов, 2 - код опции, 3 - код опции и код товара, 4 - код товара, без кода опции
                            if($this->feed_setting['features_detail']==2 || $this->feed_setting['features_detail']==3){

                                $params_this['feature_code'] = md5($param_group_title.$param_title.$param_value.$param_image);

                            }

                            if($this->feed_setting['features_detail']==4 || $this->feed_setting['features_detail']==3){

                                $params_this['product_feature_code'] = $id;

                            }

                            $params[] = $params_this;

                            //array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'product_feature_code'=>$id,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image));


                            //$params[] = array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image),'product_feature_code'=>$id);

                        }
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->{'ТипыНанесения'})){
                
                $param_title = "Типы нанесения";
                
                $attribute_value = array();
                
                $ТипыНанесения = $offer_row->{'ТипыНанесения'};
                
                foreach ($ТипыНанесения->{'ТипНанесения'} as $param_values) {
                        
                    $attribute_value[$this->getValueFromCDATA($param_values->{'Тип'})] = $this->getValueFromCDATA($param_values->{'Тип'});
                    
                }
                
                if($attribute_value){
                    
                    $attribute_value = implode(', ', $attribute_value);
                    
                }
                
                $param_group_title = '';

                $param_image = '';

                $quantity_on_option = 100;

                if($attribute_value && $attribute_value!==''){

                    if($this->feed_setting['params_as_column']){

                        $params_as_column[$attribute_value] = (string)$param_title;

                    }

                    if($this->feed_setting['select_params_as_column'] && in_array($attribute_value, $this->feed_setting['select_params_as_column'])){

                        $select_params_as_column[$attribute_value] = (string)$param_title;

                    }

                    $params_tag = 'param';

                    $params_tag_attribute_name = $param_title;

                    $params_tag_attribute_value = (string)$attribute_value.$unit;

                    $supplier_params_id_this = md5($params_tag.'_'.$params_tag_attribute_name.'_'.$params_tag_attribute_value);

                    $param_group_title = $this->feed_setting['group_attribute_name'];

                    if($this->feed_setting['option_columns'] && in_array($param_title, $this->feed_setting['option_columns'])){

                        $option_columns[] = $param_title;

                    }elseif(!$this->feed_setting['option_columns']){

                        $option_columns[] = $param_title;

                    }

                    $params_this = array('title'=>$param_title,'quantity'=>$quantity_on_option,'group_title'=>$param_group_title,'value'=>$attribute_value,'image'=>$param_image,'feature_code'=>'','product_feature_code'=>'');


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
           

            if(isset($offer_row->param)){

                foreach ($offer_row->param as $yml_param) {

                    $attributes = (array)$yml_param->attributes();

                    if(isset($attributes['@attributes']['name']) && $attributes['@attributes']['name']=="Размер"){

                        $size = $this->getValueFromCDATA($yml_param);;
                        
                        $size_parts = explode('х',$size);
                        
                        foreach($size_parts as $num_size => $size_part){
                            
                            $sizes['size_'.$num_size] = $size_part;
                            
                        }

                    }

                    if(isset($attributes['@attributes']['name']) && in_array(mb_strtolower($attributes['@attributes']['name']),$param_whis_balance)){

                        $available_balance = (int)$available_balance;

                    }

                    $special_params = array('props','sert','images');
                    
                    foreach ($attributes['@attributes'] as $attribute_name => $attribute_value) {

                        if($attribute_name=='name' && !in_array((string)$attribute_value, $special_params)){

                            $param_value = $this->getValueFromCDATA($yml_param);

                            $param_value_parts = explode(PHP_EOL,$param_value);

                            $param_value = implode(' ',$param_value_parts);

                            $attribute_value = trim((string)$attribute_value);

                            $unit = '';

                            if(isset($attributes['@attributes']['unit']) && !$this->feed_setting['heliosvan0920_unit_not_write']){

                                $unit .= ', '.$attributes['@attributes']['unit'];

                            }

                            $param_title = (string)$attribute_value.$unit;

                            $param_group_title = '';

                            $param_image = '';

                            if($attribute_value!==''){

                                $param_value = str_replace(array("'"),array("&#039;"), $param_value);

                                $param_title = str_replace(array("'"),array("&#039;"), $param_title); 

                                if($this->feed_setting['params_as_column']){

                                    $params_as_column[$attribute_value] = (string)$param_value;

                                }
                                
                                if($this->feed_setting['select_params_as_column'] && in_array($attribute_value, $this->feed_setting['select_params_as_column'])){
                                    
                                    $select_params_as_column[$attribute_value] = (string)$param_value;
                                    
                                }

                                $params_tag = 'param';

                                $params_tag_attribute_name = $attribute_name;

                                $params_tag_attribute_value = (string)$attribute_value.$unit;

                                $supplier_params_id_this = md5($params_tag.'_'.$params_tag_attribute_name.'_'.$params_tag_attribute_value);

                                $param_group_title = $this->feed_setting['group_attribute_name'];
                                
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
                                
                                //array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'product_feature_code'=>$id,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image));


                                //$params[] = array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image),'product_feature_code'=>$id);

                            }

                        }elseif($attribute_name=='name' && in_array((string)$attribute_value, $special_params)){

                            if((string)$attribute_value=='images' || (string)$attribute_value=='sert'){
                                
                                if(isset($yml_param->variant)){

                                    foreach($yml_param->variant as $variant){

                                        $pictures[$this->getValueFromCDATA($variant)] = $this->getValueFromCDATA($variant);

                                    }

                                }
                                
                            }elseif((string)$attribute_value=='props'){
                                
                                if(isset($yml_param->variant)){

                                    foreach($yml_param->variant as $variant){

                                        $variant_parts = explode('=', $this->getValueFromCDATA($variant));

                                        if(isset($variant_parts[1])){

                                            $params_this = array('title'=>$variant_parts[0],'quantity'=>$quantity_on_option,'group_title'=>$this->feed_setting['group_attribute_name'],'value'=>$variant_parts[1],'image'=>'','feature_code'=>'','product_feature_code'=>'');

                                            $params[] = $params_this;

                                        }

                                    }

                                }
                                
                            }

                        }

                    }

                    if(isset($attributes_offer['@attributes']['available'])){

                        $offer_row->available_status = $attributes_offer['@attributes']['available'];

                    }

                }

                unset($offer_row->param);

            }
            
            elseif(isset($offer_row->properties) && FALSE){
                
                foreach ($offer_row->properties as $properties) {
                    
                    foreach ($properties->param as $yml_param) {

                        $attributes = (array)$yml_param->attributes();
                        
                        if( isset($attributes['@attributes']['id']) && isset( $this->feed_setting['properties/param'][$attributes['@attributes']['id']] )){
                            
                            $attributes['@attributes']['name'] = $this->feed_setting['properties/param'][$attributes['@attributes']['id']];
                            
                        }

                        if(isset($attributes['@attributes']['name']) && $attributes['@attributes']['name']=="Размер"){

                            $size = $this->getValueFromCDATA($yml_param);

                            $size_parts = explode('х',$size);

                            foreach($size_parts as $num_size => $size_part){

                                $sizes['size_'.$num_size] = $size_part;

                            }

                        }

                        if(isset($attributes['@attributes']['name']) && in_array(mb_strtolower($attributes['@attributes']['name']),$param_whis_balance)){

                            $available_balance = (int)$available_balance;

                        }

                        $special_params = array('props','sert','images');

                        foreach ($attributes['@attributes'] as $attribute_name => $attribute_value) {

                            if($attribute_name=='name' && !in_array((string)$attribute_value, $special_params)){

                                $param_value = $this->getValueFromCDATA($yml_param);

                                $param_value_parts = explode(PHP_EOL,$param_value);

                                $param_value = implode(' ',$param_value_parts);

                                $attribute_value = trim((string)$attribute_value);

                                $unit = '';

                                if(isset($attributes['@attributes']['unit']) && !$this->feed_setting['heliosvan0920_unit_not_write']){

                                    $unit .= ', '.$attributes['@attributes']['unit'];

                                }

                                $param_title = (string)$attribute_value.$unit;

                                $param_group_title = '';

                                $param_image = '';

                                if($attribute_value!==''){

                                    $param_value = str_replace(array("'"),array("&#039;"), $param_value);

                                    $param_title = str_replace(array("'"),array("&#039;"), $param_title); 

                                    if($this->feed_setting['params_as_column']){

                                        $params_as_column[$attribute_value] = (string)$param_value;

                                    }

                                    if($this->feed_setting['select_params_as_column'] && in_array($attribute_value, $this->feed_setting['select_params_as_column'])){

                                        $select_params_as_column[$attribute_value] = (string)$param_value;

                                    }

                                    $params_tag = 'param';

                                    $params_tag_attribute_name = $attribute_name;

                                    $params_tag_attribute_value = (string)$attribute_value.$unit;

                                    $supplier_params_id_this = md5($params_tag.'_'.$params_tag_attribute_name.'_'.$params_tag_attribute_value);

                                    $param_group_title = $this->feed_setting['group_attribute_name'];

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

                                    //array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'product_feature_code'=>$id,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image));


                                    //$params[] = array('title'=>$param_title,'group_title'=>$param_group_title,'value'=>$param_value,'image'=>$param_image,'feature_code'=>md5($param_group_title.$param_title.$param_value.$param_image),'product_feature_code'=>$id);

                                }

                            }elseif($attribute_name=='name' && in_array((string)$attribute_value, $special_params)){

                                if((string)$attribute_value=='images' || (string)$attribute_value=='sert'){

                                    if(isset($yml_param->variant)){

                                        foreach($yml_param->variant as $variant){

                                            $pictures[$this->getValueFromCDATA($variant)] = $this->getValueFromCDATA($variant);

                                        }

                                    }

                                }elseif((string)$attribute_value=='props'){

                                    if(isset($yml_param->variant)){

                                        foreach($yml_param->variant as $variant){

                                            $variant_parts = explode('=',$this->getValueFromCDATA($variant));

                                            if(isset($variant_parts[1])){

                                                $params_this = array('title'=>$variant_parts[0],'quantity'=>$quantity_on_option,'group_title'=>$this->feed_setting['group_attribute_name'],'value'=>$variant_parts[1],'image'=>'','feature_code'=>'','product_feature_code'=>'');

                                                $params[] = $params_this;

                                            }

                                        }

                                    }

                                }

                            }

                        }

                        if(isset($attributes_offer['@attributes']['available'])){

                            $offer_row->available_status = $attributes_offer['@attributes']['available'];

                        }

                    }
                    
                }
                
                unset($offer_row->properties);
                
            }
            
            $variant_names = array();
            
            if(isset($offer_row->attributes)){
                
                foreach ($offer_row->attributes as $attributes_tag) {
                    
                    foreach ($attributes_tag->attribute as $yml_param) {
                        
                        $attributes = (array)$yml_param->attributes();
                        
                        $variant_names[$attributes['@attributes']['id']] = $this->getValueFromCDATA($yml_param->name);
                        
                    }
                    
                }
                
            }
            
            if(isset($offer_row->variants)){
                
                foreach ($offer_row->variants as $variants) {
                    
                    foreach ($variants->variant as $yml_param) {

                        $attributes = (array)$yml_param->attributes();
                        
                        foreach ($yml_param->attribute_values as $attribute_values) {
                            
                            $attribute_values_attributes = (array)$attribute_values->attribute_value->attributes();
                            
                            $option_name = $variant_names[$attribute_values_attributes['@attributes']['id']];
                            
                            $option_value_name = (string)$attribute_values->attribute_value->value;
                            
                            $option_value_image = (string)$attribute_values->attribute_value->value_image;
                            
                            $option_value_price = (string)$yml_param->recommended_price;
                            
                            $option_value_quantity = 0;
                            
                            if((string)$yml_param->availability_status=='В наличии'){
                                
                                $option_value_quantity = 100;
                                
                            }
                            
                            $params_this = array('title'=>$option_name,'quantity'=>$option_value_quantity,'price'=>$option_value_price,'group_title'=>$option_name,'value'=>$option_value_name,'picture'=>$option_value_image,'feature_code'=>'','product_feature_code'=>'');
                            
                            $params[] = $params_this;
                            
                            if($this->feed_setting['option_columns'] && in_array($option_name, $this->feed_setting['option_columns'])){

                                $option_columns[] = $option_name;
                                
                            }
                            
                        }

                    }
                    
                }
                
                unset($offer_row->variants);
                
            }
            
            if(isset($offer_row->assortiment)){
                
                foreach ($offer_row->assortiment as $variants) {
                    
                    if(count($variants->assort)>1){
                        
                        foreach ($variants->assort as $yml_param) {

                            $attributes = (array)$yml_param->attributes();
                            
                            if(isset($attributes['@attributes'])){
                                
                                $option_value_quantity = $attributes['@attributes']['sklad'];
                                
                                $available_balance += $option_value_quantity;
                                
                                $option_name = "Вариант";
                                
                                $option_value_name = array();
                                
                                if(isset($attributes['@attributes']['color']) && $attributes['@attributes']['color']!==''){
                                    
                                    $option_value_name[] = $attributes['@attributes']['color'];
                                    
                                }
                                
                                if(isset($attributes['@attributes']['size']) && $attributes['@attributes']['size']!==''){
                                    
                                    $option_value_name[] = $attributes['@attributes']['size'];
                                    
                                }
                                
                                if(isset($attributes['@attributes']['aID']) && $attributes['@attributes']['aID']!==''){
                                    
                                    $option_value_name[] = $attributes['@attributes']['aID'];
                                    
                                }
                                
                                if($option_value_name){
                                    
                                    $params_this = array('title'=>$option_name,'quantity'=>$option_value_quantity,'price'=>'','group_title'=>$option_name,'value'=> implode(' ', $option_value_name),'picture'=>'','feature_code'=>'','product_feature_code'=>'');

                                    $params[] = $params_this;

                                    if($this->feed_setting['option_columns'] && in_array($option_name, $this->feed_setting['option_columns'])){

                                        $option_columns[] = $option_name;

                                    }
                                    
                                }
                                
                            }

                            foreach ($yml_param->attribute_values as $attribute_values) {

                                $attribute_values_attributes = (array)$attribute_values->attribute_value->attributes();

                                $option_name = $variant_names[$attribute_values_attributes['@attributes']['id']];

                                $option_value_name = (string)$attribute_values->attribute_value->value;

                                $option_value_image = (string)$attribute_values->attribute_value->value_image;

                                $option_value_price = (string)$yml_param->recommended_price;

                                $option_value_quantity = 0;

                                if((string)$yml_param->availability_status=='В наличии'){

                                    $option_value_quantity = 100;

                                }

                                $params_this = array('title'=>$option_name,'quantity'=>$option_value_quantity,'price'=>$option_value_price,'group_title'=>$option_name,'value'=>$option_value_name,'picture'=>$option_value_image,'feature_code'=>'','product_feature_code'=>'');

                                $params[] = $params_this;

                                if($this->feed_setting['option_columns'] && in_array($option_name, $this->feed_setting['option_columns'])){

                                    $option_columns[] = $option_name;

                                }

                            }

                        }
                        
                    }
                    else{
                        
                        foreach ($variants->assort as $yml_param) {

                            $attributes = (array)$yml_param->attributes();
                            
                            if(isset($attributes['@attributes'])){
                                
                                $option_value_quantity = $attributes['@attributes']['sklad'];
                                
                                $available_balance += $option_value_quantity;
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                unset($offer_row->assortiment);
                
            }
            
            if(isset($offer_row->country_of_origin)){

                    $params_this = array('title'=>"Страна производитель",'group_title'=>'','value'=>$this->getValueFromCDATA($offer_row->country_of_origin),'image'=>'','feature_code'=>'','product_feature_code'=>'');

                    $params[] = $params_this;

            }
            
            if(isset($offer_row->image_link)){
                
                $pictures[] = $this->getValueFromCDATA($offer_row->image_link);
                
            }
            
            if(isset($offer_row->additional_image_link)){
                
                foreach ($offer_row->additional_image_link as $additional_image_link) {
                    
                    $pictures[] = $this->getValueFromCDATA($additional_image_link);
                    
                }
                
            }
            
                $column_as_params_this = array(
                    
            );
            
            foreach($column_as_params_this as $column_as_params_t_name => $column_as_params_o_name){

                    if(isset($offer_row->{$column_as_params_t_name})){

                            $column_as_params_t_value = trim((string)$offer_row->{$column_as_params_t_name});

                            if($column_as_params_t_value){

                                    $params_this = array('title'=>$column_as_params_o_name,'group_title'=>'','price'=>trim((string)$offer_row->PriceRRP),'value'=>$column_as_params_t_value,'image'=>$this->getValueFromCDATA($offer_row->image_link),'feature_code'=>'','product_feature_code'=>'');

                                    $params[] = $params_this;
                                    
                                    if($this->feed_setting['option_columns'] && in_array($column_as_params_o_name, $this->feed_setting['option_columns'])){

                                        $option_columns[] = $column_as_params_o_name;

                                    }

                            }

                    }
                    elseif(isset ($offer_row_new[$column_as_params_t_name])){
                        
                        $column_as_params_t_value = $offer_row_new[$column_as_params_t_name];
                        
                        if($column_as_params_t_value){

                            $params_this = array('title'=>$column_as_params_o_name,'group_title'=>'','value'=>$column_as_params_t_value,'feature_code'=>'','product_feature_code'=>'');

                            $params[] = $params_this;
                        }
                        
                    }

            }
            
            if(isset($offer_row->count)){
                
                $available_balance = $this->getValueFromCDATA($offer_row->count);

            }

            if($available_balance ==='' && isset($offer_row->quantity_in_stock)){

                $available_balance = $this->getValueFromCDATA($offer_row->quantity_in_stock);

            }

            if(isset($offer_row->name)){
                
                $name = $this->getValueFromCDATA($offer_row->name);

            }
            
            if(!$name && isset($offer_row->title)){

                $name = $this->getValueFromCDATA($offer_row->title);

            }

            if(!$name && isset($offer_row->model)){

                $name = $this->getValueFromCDATA($offer_row->model);

            }

            if(!$name && isset($offer_row->{'Наименование'})){

                $name = $this->getValueFromCDATA($offer_row->{'Наименование'});

            }

            if(isset($offer_row->oldprice)){

                $sale_price = (float)$this->getValueFromCDATA($offer_row->price);

                $price = (float)$this->getValueFromCDATA($offer_row->oldprice);

            }elseif(isset($offer_row->price)){

                $price = (float)$this->getValueFromCDATA($offer_row->price);

            }

            if(isset($offer_row->base_price)){

                $price = (float)$this->getValueFromCDATA($offer_row->base_price);

            }
            
            if(isset($offer_row->{'Цена'})){

                $price = str_replace(' ', '', $this->getValueFromCDATA($offer_row->{'Цена'}));

            }

            if(!$country_name && $supplier_country_id){

                $country_name = $supplier_country_id;

            }

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
            
            $categories_this = array();
            
            if(isset($offer_row->Category)){
                
                $categories_this[] = $this->getValueFromCDATA($offer_row->Category);
                
            }
            
            if(isset($offer_row->Subcategory)){
                
                $categories_this[] = $this->getValueFromCDATA($offer_row->Subcategory);
                
            }
            
            if($categories_this){
                
                $categories[] = implode('/', $categories_this);
                
            }
            
            if(isset($offer_row->sections)){

                $sections = $offer_row->sections;
                
                foreach ($sections->section as $categoryId) {
                    
                    if(isset($this->feed_setting['category_path'][trim((string)$categoryId)])){
                        
                        $categories[] = $this->feed_setting['category_path'][trim((string)$categoryId)];
                        
                    }

                }

            }
            
            if(isset($offer_row->categoryId)){

                foreach ($offer_row->categoryId as $category_xml) {
                    
                    $category_xml = $this->getValueFromCDATA($category_xml);
                    
                    if(isset($this->feed_setting['category_path'][$category_xml])){

                        $categories[] = $this->feed_setting['category_path'][$category_xml];
                        
                    }
                    
                }

            }
            
            if(isset($offer_row->section_id)){

                foreach ($offer_row->section_id as $category_xml) {
                    
                    $category_xml = $this->getValueFromCDATA($category_xml);
                    
                    if(isset($this->feed_setting['category_path'][$category_xml])){

                        $categories[] = $this->feed_setting['category_path'][$category_xml];
                        
                    }
                    
                }

            }
            
            //section_id
            
            if(isset($offer_row->models)){
                
                foreach ($offer_row->models as $models_xml) {
                    
                    if(isset($models_xml->model)){
                        
                        foreach ($models_xml->model as $models_xml_2) {
                            
                            $mod_attributes = (array)$models_xml_2->attributes();
                            
                            if(isset($mod_attributes['@attributes'])){
                                
                                foreach($mod_attributes['@attributes'] as $name_mod => $val_mod){
                                    
                                    $offer_additional_colums['mod_'.$name_mod] = $val_mod;
                                    
                                }
                                
                            }
                            
                        }
                        
                    }
                    
                }
                
                unset($offer_row->models);
                
            }
            
            //categories
            
            if($select_params_as_column){
                
                $params_as_column = array();
                
            }

            if($sizes){
                
                $this->feed_setting['offers'][$id] = array_merge($this->feed_setting['offers'][$id],$sizes);
                
            }
            
            $pictures_tmp = $pictures;
            
            foreach($pictures_tmp as $pictures_this){
                
                if(strstr($pictures_this, '_norm_')){

                    $pictures_this = str_replace('_norm_', '_max_', $pictures_this);

                }
                
                $pictures[$pictures_this] = $pictures_this;
                
            }
            
            foreach ($offer_row as $tag_name => $tag_value) {
                
                if(!isset($this->feed_setting['offers'][$id][$tag_name])){
                    
                    $offer_row_new[$tag_name] = $this->getValueFromCDATA($tag_value);
                    
                }
                
            }
            
            if(isset($offer_row->prices)){
                
                $prices = $offer_row->prices;
                
                $price_i = 1;
                
                foreach ($prices->price as $price) {
                    
                    $this->feed_setting['offers'][$id]['price_'.$price_i] = (string)$price->value;
                    
                    $price_i++;
                    
                }
                
            }
            
            if(isset($offer_row->img)){

                $attr_tag_value = $this->getValueFromCDATA($offer_row->img);
                
                $attr_tag_value = explode('?', $attr_tag_value);
                
                $attr_tag_value = $attr_tag_value[0];
                
                $pictures[] = $attr_tag_value;

            }
            
            if(isset($offer_row->store)){

                foreach ($offer_row->store as $yml_param) {

                    $attributes = (array)$yml_param->attributes();

                    if(isset($attributes['@attributes'])){

                        foreach ($attributes['@attributes'] as $name => $value) {
                            
                            $offer_additional_colums[$name] = $value;
                            
                        }

                    }

                }

            }
            
            $this->feed_setting['offers'][$id] = array_merge($this->feed_setting['offers'][$id],$offer_row_new, $params_as_column, $select_params_as_column, $offer_additional_colums);
            
            $this->feed_setting['offers'][$id]['params'] = $params;
            
            $this->feed_setting['offers'][$id]['id'] = $id;
            
            $this->feed_setting['offers'][$id]['code'] = $code;

            $this->feed_setting['offers'][$id]['group_id'] = $group_id;
            
            $this->feed_setting['offers'][$id]['group_code'] = $group_code;
            
            $this->feed_setting['offers'][$id]['pictures'] = implode(',', $pictures);

            $this->feed_setting['offers'][$id]['categories'] = implode('---', $categories);

            $this->feed_setting['offers'][$id]['description'] = $description;

            $this->feed_setting['offers'][$id]['sale_price'] = $sale_price;

            $this->feed_setting['offers'][$id]['wholesale_price'] = $wholesale_price;

            $this->feed_setting['offers'][$id]['price'] = $price;

            $this->feed_setting['offers'][$id]['price_selling'] = $price_selling;

            $this->feed_setting['offers'][$id]['name'] = $name;

            $this->feed_setting['offers'][$id]['vendor'] = $supplier_trademark_id;
            
            if(isset($sum_instock_outlet)){
                
                $this->feed_setting['offers'][$id]['sum_instock_outlet'] = $sum_instock_outlet;
                
            }

            $this->feed_setting['offers'][$id]['country_name'] = $country_name;

            if(!isset($this->feed_setting['offers'][$id]['available_balance'])){
                $this->feed_setting['offers'][$id]['available_balance'] = $available_balance;
            }

            if(!isset($this->feed_setting['offers'][$id]['available_status'])){
                $this->feed_setting['offers'][$id]['available_status'] = $available_status;
            }

            if(!isset($this->feed_setting['offers'][$id]['url'])){
                //$this->feed_setting['offers'][$id]['url'] = '#';
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
            
            $column_as_params_whis_group_this = array(
                'type'=>array('group'=>'Характеристики шины','attribute'=>'Тип автомобиля'),
                'W'=>array('group'=>'Характеристики шины','attribute'=>'Ширина профиля, мм'),
                'H'=>array('group'=>'Характеристики шины','attribute'=>'Высота профиля, мм'),
                'D'=>array('group'=>'Характеристики шины','attribute'=>'Диаметр'),
                'runflat'=>array('group'=>'Характеристики шины','attribute'=>'Runflat'),
                'season'=>array('group'=>'Характеристики шины','attribute'=>'Сезонность'),
                'stud'=>array('group'=>'Характеристики шины','attribute'=>'Шипы'),
                'LI'=>array('group'=>'Характеристики шины','attribute'=>'Индекс'),
            );
            
            $attributes_by_tag = array();
            /*
            foreach ($column_as_params_whis_group_this as $attr_tag => $attrs_data) {
                
                if(isset($offer_row->{$attr_tag})){
                    
                    $attr_tag_value = $this->getValueFromCDATA($offer_row->{$attr_tag});
                    
                    if($attr_tag_value!==''){
                        
                        $attributes_by_tag[] = $attrs_data['group']."|".$attrs_data['attribute']."|".$attr_tag_value;
                        
                    }
                    
                }
                
            }
            */
            foreach ($column_as_params_whis_group_this as $attr_tag => $attrs_data) {
                
                if(isset($offer_row_new[$attr_tag])){
                    
                    $attr_tag_value = $offer_row_new[$attr_tag];
                    
                    if($attr_tag_value!==''){
                        
                        $attributes_by_tag[] = $attrs_data['group']."|".$attrs_data['attribute']."|".$attr_tag_value;
                        
                    }
                    
                }
                
            }
            
            $count_by_tags = 0;
            
            $count_by_columns = array(
                'StockSmirnovka','StockKhimki','StockYuzhnyy','StockPechatniki',
            );
            
            foreach ($count_by_columns as $count_by_column) {
                
                if(isset($offer_row->{$count_by_column})){
                    
                    $attr_tag_value = (int)str_replace(array('<','>'), '', $this->getValueFromCDATA($offer_row->{$count_by_column}));
                    
                    if($attr_tag_value){
                        
                        $count_by_tags += $attr_tag_value;
                        
                    }
                    
                }
                
            }
            
            $this->feed_setting['offers'][$id]['count_by_tags'] = $count_by_tags;
            
            $this->feed_setting['offers'][$id]['attributes_by_tag'] = implode('---', $attributes_by_tag);
            
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
            
            if($this->feed_setting['heliosvan0920_group_id'] && isset($this->feed_setting['offers'][$id][$this->feed_setting['heliosvan0920_group_id']]) && $this->feed_setting['offers'][$id][$this->feed_setting['heliosvan0920_group_id']]!==''){
                
                $this_group_offer = $this->feed_setting['offers'][$id];
                
                $new_id_from_group_id = $this->feed_setting['offers'][$id][$this->feed_setting['heliosvan0920_group_id']];
                
                if($this->feed_setting['heliosvan0920_group_delete'] && isset($this_group_offer['name'])){
                    
                    $this_group_offer['name'] = str_replace($this->feed_setting['heliosvan0920_group_delete']['find'], $this->feed_setting['heliosvan0920_group_delete']['replace'], $this_group_offer['name']);
                    
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
                
                if($this->feed_setting['heliosvan0920_group_id_write_to_id'] && $this->feed_setting['heliosvan0920_product_id_column_name']!==''){
                    
                    $this_group_offer[$this->feed_setting['heliosvan0920_product_id_column_name']] = $new_id_from_group_id;
                    
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
            
            
            if($id && $only_first_row){
                
                unset($this->feed_setting['offers'][$id]);
                
            }
            elseif($id && $this->feed_cache['status'] && $this->feed_cache['count_nodes'] && $this->feed_cache['count_nodes']==count($this->feed_setting['offers'])){
                
                $offers_cache_file_name = $offers_file_name_prefix.count($this->feed_setting['cache_offers']);
                
                $this->writeCache($offers_cache_file_name, $this->feed_setting['offers'],'yml_cache/');
                
                $this->feed_setting['offers'] = array();
                
                $this->feed_setting['cache_offers'][$offers_cache_file_name] = $offers_cache_file_name;
                
            }
            elseif(!$id){
                
                unset($this->feed_setting['offers'][$id]);
                
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