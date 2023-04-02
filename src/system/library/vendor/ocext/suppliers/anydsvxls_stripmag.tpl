
<h2 style="color: red">Обработка через драйвер поставщик: stripmag</h2>

<input value="1" name="odmpro_tamplate_data[anyyml_yml_upload]" type="hidden" />
<input value="<?php echo $supplier_feed_source; ?>" name="odmpro_tamplate_data[supplier_feed_source]" type="hidden" />



    <label style="margin-top: 10px;">
        Удалить колонки из обмена<span data-toggle="tooltip" title="" data-original-title="Перечислите названия тегов, или названия колонок файла, которых не должно быть в обмене (уменьшает нагрузку) через вертикальную черту: |. Если Вы не знаете названия, то это можно будет сделать позднее, когда названия будут доступны в области настроек Шага 2"></span>
    </label>



    <?php if(isset($tamplate_data_selected['stripmag_delete_columns']) && $tamplate_data_selected['stripmag_delete_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_columns]"  value="<?php echo $tamplate_data_selected['stripmag_delete_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Время ожидания ответа при старте задачи (рекомендуется не более 30), в секундах
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_max_curl_timeout']) && $tamplate_data_selected['stripmag_max_curl_timeout']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_max_curl_timeout]"  value="<?php echo $tamplate_data_selected['stripmag_max_curl_timeout'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_max_curl_timeout]"  value="30" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        С какой позиции начать<span data-toggle="tooltip" title="" data-original-title="Порядковый номер узла в файле"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_start_offer']) && $tamplate_data_selected['stripmag_start_offer']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_start_offer]"  value="<?php echo $tamplate_data_selected['stripmag_start_offer'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_start_offer]"  value="1" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Сколько позиций собрать для импорта<span data-toggle="tooltip" title="" data-original-title="Если все, то нужно оставить пустым"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_limit_offer']) && $tamplate_data_selected['stripmag_limit_offer']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_limit_offer]"  value="<?php echo $tamplate_data_selected['stripmag_limit_offer'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_limit_offer]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Создание опций</h3>
    
    <label style="margin-top: 10px;">
        Создать опции из параметров<span data-toggle="tooltip" title="" data-original-title="Будет создана колонка с названием options, в которую будут сложены данные в микроразметке опций: Микроразметка 1. Перечислите названия параметров из атрибута NAME тега PARAM через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_option_columns']) && $tamplate_data_selected['stripmag_option_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_option_columns]"  value="<?php echo $tamplate_data_selected['stripmag_option_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_option_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Опции у которых будет передаваться изображение<span data-toggle="tooltip" title="" data-original-title="Если будут создаваться опции и некоторым требуется передача первого изображения, перечислите названия параметров из атрибута NAME тега PARAM через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_option_whis_image']) && $tamplate_data_selected['stripmag_option_whis_image']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_option_whis_image]"  value="<?php echo $tamplate_data_selected['stripmag_option_whis_image'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_option_whis_image]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Тип опций (select, image или checkbox)<span data-toggle="tooltip" title="" data-original-title="Если будут создаваться опции Вы можете задать им тип вывода во фронте магазина: select - список, checkbox - галочка и т.п."></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_option_type']) && $tamplate_data_selected['stripmag_option_type']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_option_type]"  value="<?php echo $tamplate_data_selected['stripmag_option_type'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_option_type]"  value="select" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Способ вывода опций в колонках
    </label>
    
    <select  name="odmpro_tamplate_data[stripmag_option_value_by_column]" class="form-control">
            <?php if(isset($tamplate_data_selected['stripmag_option_value_by_column']) && $tamplate_data_selected['stripmag_option_value_by_column']==='name_column'){ ?>
                <option value="name_column" selected="" >Каждая опция в отдельной колонке под своим названием</option>
                <option value="value_column"  >Каждая опция в отдельной колонке под номером всех опций (уменьшает количество колонок)</option>
                <option value="0" >Все опции в одной колонке</option>
            <?php }elseif(isset($tamplate_data_selected['stripmag_option_value_by_column']) && $tamplate_data_selected['stripmag_option_value_by_column']==='value_column'){ ?>
                <option value="name_column" >Каждая опция в отдельной колонке под своим названием</option>
                <option value="value_column" selected="" >Каждая опция в отдельной колонке под номером всех опций (уменьшает количество колонок)</option>
                <option value="0" >Все опции в одной колонке</option>
            <?php }else{ ?>
                <option value="name_column" >Каждая опция в отдельной колонке под своим названием</option>
                <option value="value_column"  >Каждая опция в отдельной колонке под номером всех опций (уменьшает количество колонок)</option>
                <option value="0" selected="" >Все опции в одной колонке</option>
            <?php } ?>
    </select>
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Создание атрибутов</h3>
    <label style="margin-top: 10px;">
        Создать атрибуты из параметров<span data-toggle="tooltip" title="" data-original-title="Перечислите названия параметров из атрибута name тега param через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_attribute_columns']) && $tamplate_data_selected['stripmag_attribute_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_attribute_columns]"  value="<?php echo $tamplate_data_selected['stripmag_attribute_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_attribute_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Дополнителные настройки тега PARAM</h3>
    
    <label style="margin-top: 10px;">
        Вычеркнуть следующие param<span data-toggle="tooltip" title="" data-original-title="Перечислите названия параметров из атрибута name тега param через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_delete_params']) && $tamplate_data_selected['stripmag_delete_params']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_params]"  value="<?php echo $tamplate_data_selected['stripmag_delete_params'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_params]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Создать колонки из указанных тегов param, атрибута name<span data-toggle="tooltip" title="" data-original-title="Перечислите названия параметров из атрибута name тега param через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['stripmag_select_params_as_column']) && $tamplate_data_selected['stripmag_select_params_as_column']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_select_params_as_column]"  value="<?php echo $tamplate_data_selected['stripmag_select_params_as_column'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_select_params_as_column]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Не записывать содержание атрибута UNIT в название<span data-toggle="tooltip" title="" data-original-title="Если включено, то к названию не будет дописываться значение UNIT"></span>
    </label>
    
    <select  name="odmpro_tamplate_data[stripmag_unit_not_write]" class="form-control">
            <?php if(isset($tamplate_data_selected['stripmag_unit_not_write']) && $tamplate_data_selected['stripmag_unit_not_write']){ ?>
                <option value="1" selected="" >Включено</option>
                <option value="0" >Выключено</option>
            <?php }else{ ?>
                <option value="1"  >Включено</option>
                <option value="0" selected="">Выключено</option> 
            <?php } ?>
    </select>
    
    <label style="margin-top: 10px;">
        Параметры записывать в колонки<span data-toggle="tooltip" title="" data-original-title="Если включено, то параметры будут записываться в колонках. Если у товаров много разных параметров, то колонок может быть очень много"></span>
    </label>
    
    <select  name="odmpro_tamplate_data[stripmag_params_as_column]" class="form-control">
            <?php if(isset($tamplate_data_selected['stripmag_params_as_column']) && $tamplate_data_selected['stripmag_params_as_column']){ ?>
                <option value="1" selected="" >Включено</option>
                <option value="0" >Выключено</option>
            <?php }else{ ?>
                <option value="1"  >Включено</option>
                <option value="0" selected="">Выключено</option> 
            <?php } ?>
    </select>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Отбор по категории или производителю</h3>
    
    
    
    
    <label style="margin-top: 10px;">
        Не импортировать товары категорий<span data-toggle="tooltip" title="" data-original-title="Перечислите categoryId категорий, товары которых не должны попадать в файл импорта через вертикальную черту: |"></span>
    </label>
    
    
    <?php if(isset($tamplate_data_selected['stripmag_delete_by_category_id']) && $tamplate_data_selected['stripmag_delete_by_category_id']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_by_category_id]"  value="<?php echo $tamplate_data_selected['stripmag_delete_by_category_id'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_by_category_id]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    -->
    
    <label style="margin-top: 10px;">
        Импортировать товары категорий<span data-toggle="tooltip" title="" data-original-title="Перечислите текст внутри категории, как в колонках файла импорта, которые нужно оставить в файле. Если пусто зайдут все товары, если задано, то останутся только те, у которых будет текст в категориях, который Вы укажите. Если элментов несколько, укажите через разделитель вертикальная черта: |"></span>
    </label>
    
    
    <?php if(isset($tamplate_data_selected['stripmag_set_products_by_category_id']) && $tamplate_data_selected['stripmag_set_products_by_category_id']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_set_products_by_category_id]"  value="<?php echo $tamplate_data_selected['stripmag_set_products_by_category_id'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_set_products_by_category_id]"  value="" class="form-control" type="text" />
    <?php } ?>

    
    
    <label style="margin-top: 10px;">
        Не импортировать товары производителей<span data-toggle="tooltip" title="" data-original-title="Перечислите названия производителей (из тега vendor), товары которых не должны попадать в файле импорта через вертикальную черту: |"></span>
    </label>
    
    
    <?php if(isset($tamplate_data_selected['stripmag_delete_by_vendor']) && $tamplate_data_selected['stripmag_delete_by_vendor']!=='' ){ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_by_vendor]"  value="<?php echo $tamplate_data_selected['stripmag_delete_by_vendor'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[stripmag_delete_by_vendor]"  value="" class="form-control" type="text" />
    <?php } ?>
    
   