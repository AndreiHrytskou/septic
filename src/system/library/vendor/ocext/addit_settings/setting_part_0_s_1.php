<?php
if (!function_exists('phpversion')) {
    $php_vers = '_f_6';
}else{
    $phpversion = explode('.', phpversion());
    if($phpversion[0]==5){
        $php_vers = '_f';
        if($phpversion[1]==4 || $phpversion[1]==5 || $phpversion[1]==6){
            $php_vers .= '_4';
        }
        else{
            $php_vers = '_f_6';
        }
    }
    elseif($phpversion[0]==7){
        $php_vers = '_f';
        if($phpversion[1]==0){
            $php_vers .= '_6';
        }
        elseif($phpversion[1]==1){
            $php_vers = '_s_1';
        }
        elseif($phpversion[1]==2){
            $php_vers = '_s_2';
        }
        elseif($phpversion[1]==3){
            $php_vers = '_s_3';
        }
        else{
            $php_vers = '_f_6';
        }
    }
}
class setting_part_0 {
    
    public $abstract_field = array(
        'column_replace_from'=>array(
            'element'=>'textarea2',
            'data-original-title'=>"",
            'export'=>0,
            'function-title'=>'Найти<span data-toggle="tooltip" title="" data-original-title="Укажите элементы, которые требуется найти перед заменой. Если элементов несколько укажите их через вертикальную разделительную черту: |. Если вертикальная черта есть в элементах, укажите её с символом экранирования: \\"></span>',
        ),
        'column_replace_to'=>array(
            'element'=>'textarea2',
            'data-original-title'=>"",
            'export'=>0,
            'function-title'=>'Заменить на<span data-toggle="tooltip" title="" data-original-title="Укажите элементы, на которые требуется заменить соответствующие найденные элементы. Если нужно удалить найденные, оставьте пустым. Если элементов несколько укажите их через вертикальную разделительную черту: |. Если вертикальная черта есть в элементах, укажите её с символом экранирования: \\"></span>',
        ),
        'column_transformation'=>array(
            'element'=>'textarea',
            'data-original-title'=>"",
            'export'=>0,
            'function-title'=>'Трансформация и дополнение перед вставкой',
            'function-title-help' => '<div class="info-box-modal2">Используйте эту настройку, если нужно объединить какой-то текст, или вставить HTML одновременно со значениями из других колонок. Например, Вы можете создать микроразметку для опций или атрибутов, или для категорий. Или дополнить данные каким-то текстом, или текстом из других ячеек. Чтобы передать значение из другой ячейки укажите название колонки в двойных квадратных скобках (для удобства названия колонок указаны слева оранжевым цветом). Например, напишите:<br><b>Каталог / [[КОЛОНКА1]] / [[КОЛОНКА2]]</b><br>Если необходимо создать категорию из частей: текста - Каталог, и значений из колонки с название КОЛОНКА1 и КОЛОНКА2, между которыми должен быть символ слеш</div>'
        ),
        'column_excel_transformation'=>array(
            'element'=>'textarea',
            'data-original-title'=>"",
            'export'=>0,
            'function-title'=>'Использование формул EXCEL перед вставкой',
            'function-title-help' => '<div class="info-box-modal2">Используйте эту настройку, чтобы применить формулы EXCEL перед вставкой. Язык - формул английский. Разделитель дробей - точка (не запятая!). Разделитель между элементами в формуле - запятая (не точка с запятой). Для использования данных из других колонок той же строки используйте адреса ячеек, как это указано зеленым цветом слева у названий колонок файла. Например, напишите:<br><b>=A1*0.5</b><br>Если необходимо импортировать значение, которое будет являться результатом умножения значения в A1 и 0.5</div>'
        )
    );
    
    public $yml = array(
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

    public $settings = array(

            'count_group_id_box'=>3,
            'max_curl_timeout'=>20000,
            'actions_with_data_group'=>array(
                'category_mapping' => 1,
                'action_before_import' => 1,
                'composite_id' => 1
            ),
            'edition'=>array(
                'version_host'=>'anycsv-dsv-xls-yml.ocext',
                'extension'=>'csvxls_pe',
                'version'=>'7.0.0.0',
                'import_formats' => array(
                    'csv',
                    'dsv',
                    'xls',
                    'xlsx',
                    'yml'
                ),
                'export_formats' => array(
                    'csv',
                    'dsv'
                )
            ),
            'functional'=>array(
                'automatization_by_link'=>1,
                'unzip'=>1,
                'pricing'=>1,
                'stocking'=>1,
                'currency_convert'=>1,
                'log'=>1,
                'log_on_email'=>1,
                'smart_exchange'=>1,
                'yml_to_dsv'=>1,
                'export_to_xls'=>1,
                'order_export'=>1,
                'self_column' => 1,
                'php_after_import' => 1
            ),
            'lic' => FALSE,
            'lic_success' => '',
            'lic_error' => 'Неизвестная ошибка' 

    );

    public $specification = array(
            'name' => "YML",
            'id_specification' => "YML___1_0_0_0",
            'version' => "1_0_0_0",
            'specification_valid_text'=>'yml_catalog',
            'check_valid_status'=>FALSE
    );

    public function checkLicenseStatus($tmp=TRUE){
            
        $this->settings['lic_success'] = anycsvsev_license_success_1;

        $this->settings['lic_error'] = '';

        $this->settings['lic'] = TRUE;

        return;
        
    }

    public function getSqlWhereOperators() {
        
        $operators = array('&lt;'=>'&lt;','≤'=>'≤','='=>'=','≥'=>'≥','&gt;'=>'&gt;','≠'=>'≠','±'=>'±','like_left'=>'Содержит префикс слева','like_right'=>'Содержит префикс справа','like'=>'Содержит','not_like_left'=>'Не содержит префикс слева' ,'not_like_right'=>'Не содержит префикс справа','not_like'=>'Не содержит');
        return $operators;
    }
    
    public function anydsvxls_view($template_file,$data) {
        
        $file = DIR_SYSTEM.'library/vendor/ocext/anydsvxls_view/' . $template_file;
        
        $output = '';

        if (is_file($file)) {
            
                extract($data);

                ob_start();

                require($file);

                $output = ob_get_clean();
                
        }
        
        return $output;
        
    }
    
    public function getLemailLkey() {
        
        $sql = "SELECT * FROM " . DB_PREFIX . "setting WHERE `code` = 'csv_ocext_dmpro' AND ( `key` = 'csv_ocext_dmpro_key' OR `key` = 'csv_ocext_dmpro_email' ) ";
        
        $query = NULL;
        
        if(DB_DRIVER=='mysqli'){
            
            $this->connection = new \mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

            if ($this->connection->connect_error) {
                    throw new \Exception('Error: ' . $this->connection->error . '<br />Error No: ' . $this->connection->errno);
            }

            $this->connection->set_charset("utf8");
            $this->connection->query("SET SQL_MODE = ''");
            
            $query_sql = $this->connection->query($sql);

            if (!$this->connection->errno) {
                    if ($query_sql instanceof \mysqli_result) {
                            $data = array();

                            while ($row = $query_sql->fetch_assoc()) {
                                    $data[] = $row;
                            }

                            $query = new \stdClass();
                            $query->num_rows = $query_sql->num_rows;
                            $query->row = isset($data[0]) ? $data[0] : array();
                            $query->rows = $data;

                            $query_sql->close();

                            return $query;
                    }
            } else {
                    throw new \Exception('Error: ' . $this->connection->error  . '<br />Error No: ' . $this->connection->errno . '<br />' . $sql);
            }
            
            
        }
        elseif(DB_DRIVER=='mysql'){
            
            if (!$this->connection = mysql_connect(DB_HOSTNAME . ':' . DB_PORT, DB_USERNAME, DB_PASSWORD)) {
                    trigger_error('Error: Could not make a database link using ' . DB_USERNAME . '@' . DB_HOSTNAME);
                    exit();
            }

            if (!mysql_select_db($database, $this->connection)) {
                    throw new \Exception('Error: Could not connect to database ' . DB_DATABASE);
            }

            mysql_query("SET NAMES 'utf8'", $this->connection);
            mysql_query("SET CHARACTER SET utf8", $this->connection);
            mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $this->connection);
            mysql_query("SET SQL_MODE = ''", $this->connection);
            
            $resource = mysql_query($sql, $this->connection);

            if ($resource) {
                    if (is_resource($resource)) {
                            $i = 0;

                            $data = array();

                            while ($result = mysql_fetch_assoc($resource)) {
                                    $data[$i] = $result;

                                    $i++;
                            }

                            mysql_free_result($resource);

                            $query = new \stdClass();
                            $query->row = isset($data[0]) ? $data[0] : array();
                            $query->rows = $data;
                            $query->num_rows = $i;

                            unset($data);
                    }
            } else {
                    $trace = debug_backtrace();

                    throw new \Exception('Error: ' . mysql_error($this->connection) . '<br />Error No: ' . mysql_errno($this->connection) . '<br /> Error in: <b>' . $trace[1]['file'] . '</b> line <b>' . $trace[1]['line'] . '</b><br />' . $sql);
            }
            
        }
        
        return $query;
        
    }
    
    public function setSetings() {
        
        foreach ($this->settings as $key => $value) {
            $this->data[$key] = $value;
        }
        
        return;
        
        $this->settings['lic'] = FALSE;
        
        $file_errorkey_ocext = DIR_SYSTEM.'library/vendor/ocext/addit_settings/lsign/errorkey.ocext';
        
        if(isset($_SERVER['REQUEST_URI'])){
            
            $REQUEST_URI_THIS = explode('&', $_SERVER['REQUEST_URI']);
            
            $REQUEST_URI_THIS = explode('?', $REQUEST_URI_THIS[0]);
            
            $REQUEST_URI_THIS = str_replace(array('/'.$this->admin_location.'/index.php'), '', $REQUEST_URI_THIS[0]);
            
        }
        else{
            
            $REQUEST_URI_THIS = '';
            
        }

        foreach ($this->dir_ex as $class_method_name) {

            if( !isset($_SERVER['REQUEST_URI']) || !strstr($_SERVER['REQUEST_URI'], 'index.php?route=') || strstr($_SERVER['REQUEST_URI'], $class_method_name) || strstr($_SERVER['REQUEST_URI'], strtolower($class_method_name))){
                
                if(!file_exists($file_errorkey_ocext)){
                    
                    $license_notifications_array = aplVerifyLicense(null, 0);
                    
                }
                
                else{
                    
                    return;
                    
                }
                
                if($license_notifications_array['notification_case']!=="notification_license_ok"){

                    if($license_notifications_array['notification_case']=='notification_license_cancelled' || $license_notifications_array['notification_case']=='notification_invalid_response'){
                        
                        $this->deleteLsign();
                        
                        if(!file_exists($file_errorkey_ocext)){

                            $getLemailLkey = $this->getLemailLkey();

                            if(!is_null($getLemailLkey)){

                                $lkey = FALSE;

                                $lemail = FALSE;

                                foreach ($getLemailLkey->rows as $key => $value) {

                                    if($value['key']=='csv_ocext_dmpro_key'){

                                        $lkey = $value['value'];

                                    }
                                    else{

                                        $lemail = $value['value'];

                                    }

                                }

                            }

                            $errorkey_ocext = base64_encode($lkey.'-'.$lemail);

                            $h = fopen($file_errorkey_ocext, 'w+');

                            fwrite($h, $errorkey_ocext);

                            fclose($h);

                        }
                        
                    }
                    
                    return;

                }
                
                elseif($license_notifications_array['notification_case']=="notification_license_ok"){

                    $this->settings['lic'] = TRUE;
                    
                    if(file_exists($file_errorkey_ocext)){

                        unlink($file_errorkey_ocext);

                    }

                    return;

                }

            }

        }
        
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `code` = 'csv_ocext_dmpro' AND ( `key` = 'csv_ocext_dmpro_key' OR `key` = 'csv_ocext_dmpro_email' ) ");
        
        if($query->rows){
            
            $lkey = FALSE;
            
            $lemail = FALSE;
            
            foreach ($query->rows as $key => $value) {
                
                if($value['key']=='csv_ocext_dmpro_key'){
                    
                    $lkey = $value['value'];
                    
                }
                else{
                    
                    $lemail = $value['value'];
                    
                }
                
            }
            
            if(!$lkey || !$lemail){
                
                $result['error'] = "Для регистрации введите, полученный ключ и лицензионный email";
                
                $this->settings['lic_error'] = $result['error'];
                
                return;
                
            }
            
            $ROOT_URL = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST'].$REQUEST_URI_THIS;
            
            $result = array('error'=>'');
            
            if (APL_INCLUDE_KEY_CONFIG!="2ebee6dd903c1952") //Secret key modified
            {
                $result['error'] = "Один из файлов лицензии поврежден, пожалуйста, обратитесь в поддержку, или переустановите модуль";
            
            }
            
            if($result['error']){
                $this->settings['lic_error'] = $result['error'];
                return;
            }
            
            
            $license_notifications_array = aplInstallLicense($ROOT_URL, $lemail, $lkey);
            
            if($license_notifications_array['notification_case']=='notification_already_installed'){
                
                $license_notifications_array = aplVerifyLicense(null, 1);
                
                if($license_notifications_array['notification_case']=='notification_license_ok'){
                    
                    $license_notifications_array['notification_case']='notification_already_installed';
                    
                }
                
            }
            
            if ($license_notifications_array['notification_case']=="notification_license_ok") //'notification_license_ok' case returned - operation succeeded
                {
                    $this->settings['lic_success'] = "Лицензия успешно активирована. Благодарим за сотрудничество! ";
                    $this->settings['lic'] = TRUE;
                    if(file_exists($file_errorkey_ocext)){

                        unlink($file_errorkey_ocext);

                    }
                }
            elseif($license_notifications_array['notification_case']=='notification_license_cancelled' || $license_notifications_array['notification_case']=='notification_invalid_response'){
                $this->settings['lic_error'] = "К сожалению, данная лицензия аннулирована";
                $errorkey_ocext = base64_encode($lkey.'-'.$lemail);
                $h = fopen($file_errorkey_ocext, 'w+');
                fwrite($h, $errorkey_ocext);
                fclose($h);
                $this->deleteLsign();
            }
            elseif($license_notifications_array['notification_case']=='notification_already_installed'){
                $this->settings['lic_success'] = "Лицензия активна. Благодарим за сотрудничество! ";
                $this->settings['lic'] = TRUE;
                if(file_exists($file_errorkey_ocext)){

                    unlink($file_errorkey_ocext);

                }
            }
            else{
                $this->settings['lic_error']=$license_notifications_array['notification_text'].' Возможно данная лицензия больше не активна. Свяжитесь с поддержкой. В запросе укажите ключ лицензии';
            }
            
        }
        
    }
    
    public function deleteLsign() {
        
        $filename = DIR_SYSTEM.'library/vendor/ocext/addit_settings/lsign/lsign.ocext';
        
        if(file_exists($filename)){
            
            if(filesize($filename)>0){
                
                aplUninstallLicense();
                
            }
            
            $h = fopen($filename, 'w+');
            
            fclose($h);
            
        }
        
    }
    
    public function getValueFromCDATA($cdata) {
        
        return htmlspecialchars(str_replace(array('<![CDATA[ ',' ]]>'),array('',''),   strip_tags(html_entity_decode(trim((string)$cdata)))),ENT_QUOTES);
        
    }
    
    public function getExcelColumnNameByColumnNames($column_names,$odmpro_tamplate_data){
	
	$addrses = array('A','B','C','D','E','F','G','H','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y');
	
	$addrses_result = array();
	
	$i = 0;
	
	foreach($addrses as $addrs){
	    
	    $addrses_result[$addrs] = $addrs;
	    
	    foreach($addrses as $addrs2){
	    
		$addrses_result[$addrs.$addrs2] = $i;

	    }
	    
	    $i++;
	    
	}
	
	asort($addrses_result);
	
	$result = array();
	
	foreach ($column_names as $num_name => $column_name) {
	    
	    if(isset($odmpro_tamplate_data['excel_column_name_by_column_name'][$column_name])){
		
		$result[$column_name] = $odmpro_tamplate_data['excel_column_name_by_column_name'][$column_name];
		
		unset($addrses_result[mb_strcut($odmpro_tamplate_data['excel_column_name_by_column_name'][$column_name], 0, mb_strlen($odmpro_tamplate_data['excel_column_name_by_column_name'][$column_name])-1) ]);
		
		unset($column_names[$num_name]);
		
	    }
	    
	}
	
	foreach ($column_names as $column_name) {
	    
	    $this_addr = key($addrses_result);
		
	    $result[$column_name] = $this_addr.'1';

	    unset($addrses_result[$this_addr]);
	    
	}
	
	return $result;
	
    }
    
    public function updateSmartExchange($post) {
        
        if(isset($post['odmpro_update_csv_smart_exchange_link'])){
            
            $smart_exchange_setting = $post['odmpro_update_csv_smart_exchange_link'];
            
            $token = '';
            
            if(isset($smart_exchange_setting['token'])){
                
                $token = trim($smart_exchange_setting['token']);
                
            }
            
            if($token){
                
                $file_name_smart_exchange_setting = "smart_exchange_setting";
                
                $this->unlinkFiles(array($file_name_smart_exchange_setting));
                
                $this->writeCache($file_name_smart_exchange_setting, $post);
                
            }
            
        }
        
    }
    
    public function editSetting($code, $data, $store_id = 0) {
        
            $this->db->query("DELETE FROM `" . DB_PREFIX ."ocext_csv_ocext_dmpro_setting` WHERE `code` = '" . $this->db->escape($code) . "'");

            foreach ($data as $key => $value) {
                    if (substr($key, 0, strlen($code)) == $code) {
                            if (!is_array($value)) {
                                    $this->db->query("INSERT INTO " . DB_PREFIX ."ocext_csv_ocext_dmpro_setting SET `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
                            } else {
                                    $this->db->query("INSERT INTO " . DB_PREFIX ."ocext_csv_ocext_dmpro_setting SET `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value, true)) . "', serialized = '1'");
                            }
                    }
            }
    }
    
     public function writeXls($csv_rows_result,$first_write,$odmpro_tamplate_data,$start,$limit){
        
         
        if(file_exists(DIR_SYSTEM.'PHPExcelOcext/Classes/PHPExcel.php')){
            if(!class_exists('PHPExcel')){
                include_once DIR_SYSTEM.'PHPExcelOcext/Classes/PHPExcel.php';
                include_once DIR_SYSTEM.'PHPExcelOcext/Classes/PHPExcel/Writer/Excel5.php';
            }
        }else{
            $reslut['errors'] = "Не найдены PHPExcel Classes. Создание файла заказа невозможно";
            return $reslut;
        }
        
        $file_name = $odmpro_tamplate_data['export_file_name_xls'];
        
        if($odmpro_tamplate_data['file_name_write_time_xls']){
            
            $file_name.= date("Y-m-d_H:i:s");
            
        }
        
        $file_name .= '.xlsx';
        
        $path_parts=array();
        if($file_name){
            $path_parts = explode('/', $file_name);
        }
        if($path_parts){
            foreach ($path_parts as $key => $value) {
                if(!$value){
                    unset($path_parts[$key]);
                }
            }
        }
        
        $file_name = rawurldecode($path_parts[count($path_parts)-1]);

        unset($path_parts[count($path_parts)-1]);
        
        $path = '';
        if($path_parts){
            $path = implode('/', $path_parts);
        }
        
        $dir_name = DIR_IMAGE;
        
        if($path){

            $path_parts = explode('/', $path);

            foreach ($path_parts as $new_dir_name) {

                $dir_name .= $new_dir_name.'/';

                if(!file_exists($dir_name)){

                    mkdir($dir_name,0777);

                }

            }

        }
        
        $file_name_and_path = $dir_name.$file_name;
        
        if($first_write){
            
            $xls = new PHPExcel();
            
        }elseif(file_exists($file_name_and_path)){
            
            $xls = PHPExcel_IOFactory::load($file_name_and_path);
            
        }else{
            
            $reslut['errors'] = "Невозможно записать файл, отсутствует файл для записи в: ".$file_name_and_path;
            
            return $reslut;
            
        }
        
        $xls->setActiveSheetIndex(0);
        
        $sheet = $xls->getActiveSheet();
        
        $columns = array();
        
        $start += 1;
        
        if($first_write && $csv_rows_result){
            
            if(isset($csv_rows_result[0])){
                
                foreach ($csv_rows_result[0] as $column_name => $tmp){
                
                    $columns[] = $column_name;

                }

                unset($csv_rows_result[0]);
                
            }
            
            $c = 0;
        
            foreach($columns as $column_value){

                $sheet->setCellValueByColumnAndRow($c,$start,$column_value);

                $c++;

            }
            
            $start++;
            
        }
        
        foreach($csv_rows_result as $csv_row_result){
            
            $c = 0;
            
            foreach($csv_row_result as $csv_cell){
                
                if(is_array($csv_cell)){
                    
                    foreach($csv_cell as $csv_cell_2){
                        
                        $sheet->setCellValueByColumnAndRow($c,$start++,$csv_cell_2);
                        
                    }
                    
                    $c++;
                    
                }else{
                    
                    $sheet->setCellValueByColumnAndRow($c,$start,$csv_cell);

                    $c++;
                    
                }
                
            }
            
            $start++;
            
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
        
        $objWriter->save($file_name_and_path);
        
        $reslut['success'] = "Файл успешно записан";
        
        return $reslut;
        
    }
    
    public function getParsFromCollection($collection,$dsv_row){
	    
	$from = array();

	$to = array();

	foreach ($dsv_row as $column => $value) {

	    if(strstr($collection, '[['.$column.']]')){

		$from[ '[['.$column.']]' ] = '[['.$column.']]';

		$to[ '[['.$column.']]' ] = $value;

	    }

	}

	if($from){

	    $collection = str_replace($from, $to, $collection);

	}

	return $collection;

    }
    
    public function saveTemplateSetting($tid,$templates_setting,$save_file_name=FALSE) {
        
        if(!$save_file_name){
            
            $save_file_name = $tid;
            
        }

        $template_setting = array();

        if(isset($templates_setting[$tid])){

            $template_setting[$tid] = $templates_setting[$tid];

            $template_setting[$tid]['save_anycsv'] = 'save_anycsv';

        }

        $file_name = DIR_CACHE.md5('anycsv'.$tid).'.json';

        $handle = fopen($file_name, 'w+');
        fwrite($handle, base64_encode(json_encode($template_setting)));
        fclose($handle);
        //$test = file_get_contents($file_name);
        //$test = json_decode(base64_decode($test),TRUE);
        //var_dump($test);exit();exit();

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $save_file_name . '.json"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));

        if (ob_get_level()) {
                ob_end_clean();
        }

        readfile($file_name, 'rb');

        unlink($file_name);
        exit();

    }
    
    public function getTFileByFileName($get) {
        
	    $fn = base64_decode($get['fn']);
            
            $ef = $get['ef'];
            
            $file_name = DIR_IMAGE.$fn.'.'.$ef;
            
            if(!file_exists($file_name) || !is_file($file_name)){
                
                exit('no file');
                
            }
            
            $file_string = file_get_contents($file_name);
	    
	    $handle = fopen($file_name, 'w+');
	    fwrite($handle, $file_string);
	    fclose($handle);
	    
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_name));

	    if (ob_get_level()) {
		    ob_end_clean();
	    }

	    readfile($file_name, 'rb');

	    unlink($file_name);
            
	    exit();
	    
	}
    
        public function getFindReplace($from,$to,$string) {
        
            $from = str_replace(array('\|','\\|','|'), array('__DOCEXT__','__DOCEXT__','__DOCEXT__'), html_entity_decode($from));
            
            $from = explode('__DOCEXT__', $from);
            
            $to = str_replace(array('\|','\\|','|'), array('__DOCEXT__','__DOCEXT__','__DOCEXT__'), html_entity_decode($to));
            
            $to = explode('__DOCEXT__', $to);
            
            $string = str_replace($from, $to, $string);
            
            return $string;
            
        }
        
        public function replaceOperator($operator){
            
            $find = array('&lt;','≤','=','≥','&gt;','≠');

            $replace = array('<','<=','=','>=','>','!=');

            $operator = str_replace($find, $replace, $operator);

            return $operator;

        }
        
        public function getWhere($product_data,$sql_logic='OR') {

            $where = array();
            
            
            foreach ($product_data as $product_data_where){

                if($product_data_where['product_field'] && $product_data_where['operator']){

                    $operator = $this->replaceOperator($product_data_where['operator']);



                    $product_field = $product_data_where['product_field'];

                    if($product_field=='quantity_advanced'){

                        $product_field = 'quantity';

                    }elseif($product_field=='price_advanced'){

                        $product_field = 'price';

                    }

                    $value = $product_data_where['value'];

                    $value_array = explode('///',$value);

                    if(count($value_array)>1){

                        $sql = array();

                        foreach ($value_array as $value) {

                            if($operator && $product_field){

                                if($operator=='like_right'){

                                    $sql[] = $product_field.' LIKE  "%'.$this->db->escape($value).'" ';

                                }elseif($operator=='like_left'){

                                    $sql[] = $product_field.' LIKE  "'.$this->db->escape($value).'%" ';

                                }elseif($operator=='like'){

                                    $sql[] = $product_field.' LIKE  "%'.$this->db->escape($value).'%" ';

                                }elseif($operator=='not_like_right'){

                                    $sql[] = $product_field.' NOT LIKE  "%'.$this->db->escape($value).'" ';

                                }elseif($operator=='not_like_left'){

                                    $sql[] = $product_field.' NOT LIKE  "'.$this->db->escape($value).'%" ';

                                }elseif($operator=='not_like'){

                                    $sql[] = $product_field.' NOT LIKE  "%'.$this->db->escape($value).'%" ';

                                }else{

                                    $sql[] = $product_field.' '.$operator.' "'.$this->db->escape($value).'" ';

                                }

                            }

                        }

                        if($sql){

                            $where[] = ' ( '.implode(' OR ', $sql).' ) ';

                        }

                    }else{

                        if($operator && $product_field){

                            $sql = '';

                            if($operator=='like_right'){

                                $sql = $product_field.' LIKE  "%'.$this->db->escape($value).'" ';

                            }elseif($operator=='like_left'){

                                $sql = $product_field.' LIKE  "'.$this->db->escape($value).'%" ';

                            }elseif($operator=='like'){

                                $sql = $product_field.' LIKE  "%'.$this->db->escape($value).'%" ';

                            }elseif($operator=='not_like_right'){

                                $sql = $product_field.' NOT LIKE  "%'.$this->db->escape($value).'" ';

                            }elseif($operator=='not_like_left'){

                                $sql = $product_field.' NOT LIKE  "'.$this->db->escape($value).'%" ';

                            }elseif($operator=='not_like'){

                                $sql = $product_field.' NOT LIKE  "%'.$this->db->escape($value).'%" ';

                            }else{

                                $sql = $product_field.' '.$operator.' "'.$this->db->escape($value).'" ';

                            }

                            $where[] = $sql;

                        }

                    }

                }

            }

            return implode(' '.$sql_logic.' ', $where);

        }
        
        public function getSetting($code,$key='') {
                $setting_data = array();
                

                
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX ."ocext_csv_ocext_dmpro_setting WHERE `code` = '" . $this->db->escape($code) . "'");

                foreach ($query->rows as $result) {
                        if (!$result['serialized']) {
                                $setting_data[$result['key']] = $result['value'];
                        } else {
                                $setting_data[$result['key']] = json_decode($result['value'], true);
                        }
                }

                if($key && isset($setting_data[$key])){

                    $setting_data = $setting_data[$key];

                }elseif($key && !isset($setting_data[$key])){

                    $setting_data = array();

                }

                return $setting_data;
        }
        
        public function updateGroupDataProduct($odmpro_tamplate_data,$get){
        
            
        
            $first_step = TRUE;

            if(isset($get['num_process'])){
                $num_process = $get['num_process'];
                $history_group_data_product = $this->getSetting('history_group_data','history_group_data_product');

                if(!isset($history_group_data_product[$num_process])){
                    $set_history_group_data_product['history_group_data_product'] = $history_group_data_product;
                    $set_history_group_data_product['history_group_data_product'][$num_process] = TRUE;
                    $this->editSetting('history_group_data', $set_history_group_data_product);
                }else{
                    $first_step = FALSE;
                }
            }

            if($first_step && isset($odmpro_tamplate_data['group_id_box']['product_data'])){

                $product_data = $odmpro_tamplate_data['group_id_box']['product_data'];

                $where = $this->getWhere($product_data,'AND');

                if($where){

                    $update = array();

                    if(isset($odmpro_tamplate_data['group_id_box']['disable_quantity']) && $odmpro_tamplate_data['group_id_box']['disable_quantity']!==''){

                        $disable_quantity = (int)trim($odmpro_tamplate_data['group_id_box']['disable_quantity']);

                    }

                    if(isset($odmpro_tamplate_data['group_id_box']['disable_price']) && $odmpro_tamplate_data['group_id_box']['disable_price']!==''){

                        $disable_price = (float)trim($odmpro_tamplate_data['group_id_box']['disable_price']);

                    }

                    $sql = "UPDATE * FROM " . DB_PREFIX . "product ";

                    if(isset($disable_quantity)){

                        $update[] = " quantity = ".$disable_quantity;

                    }

                    if(isset($disable_price)){

                        $update[] = " price = ".$disable_price;

                    }

                    if(isset($odmpro_tamplate_data['group_id_box']['disable_price']) && $odmpro_tamplate_data['group_id_box']['disable_product']){

                        $update[] = " status = 0 ";

                    }

                    if($update){

                        $sql = "UPDATE " . DB_PREFIX . "product SET ".implode(",",$update)." WHERE ".$where;

                        $query = $this->db->query($sql);

                    }

                }

            }

        }
    
    
}

?>