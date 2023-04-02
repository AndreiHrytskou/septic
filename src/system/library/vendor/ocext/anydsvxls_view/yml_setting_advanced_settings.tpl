<div id="tab_anyyml_import" class="tab-pane" >
   
    <input value="<?php echo $tamplate_data_selected['anyyml_yml_upload']; ?>" name="odmpro_tamplate_data[anyyml_yml_upload]" type="hidden" />
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Основные настройки</h3>
    <?php if(isset($suppliers_feed_source) && $suppliers_feed_source){ ?>
    
        <label style="margin-top: 10px;">
            Исходная спецификация
        </label>
        <select onchange="getSupplierSettingView(this.value)"  name="odmpro_tamplate_data[supplier_feed_source]" class="form-control">
            
            <option value="0"  >Не выбрано</option>
            
        <?php foreach($suppliers_feed_source as $source_id => $source){ ?>
    
            
        
                <?php if(isset($tamplate_data_selected['supplier_feed_source']) && $tamplate_data_selected['supplier_feed_source']==$source_id){ ?>
                    <option value="<?php echo $source_id ?>" selected="" ><?php echo $source['name'] ?></option>
                <?php }else{ ?>
                    <option value="<?php echo $source_id ?>" ><?php echo $source['name'] ?></option>
                <?php } ?>
    
        <?php } ?>        
        </select>
    
        <script type="text/javascript"><!--

            $(document).ready(function() {
                
                $("select[name='odmpro_tamplate_data[supplier_feed_source]']").change();
                
            });
            
            function getSupplierSettingView(source_id){
            
                if(source_id==0){
                
                    return;
                
                }
                
                $.ajax({
                        type: 'post',
                        url: 'index.php?route='+path_oc_version+'/csv_ocext_dmpro/getSupplierSettingView&type_process=import&'+token_name_by_version+'='+token_value_by_version+'&source_id='+source_id,
                        data: $('#tamplate_data_form_import input:text, #tamplate_data_form_import input:hidden, #tamplate_data_form_import input:checkbox:checked, #tamplate_data_form_import select, #tamplate_data_form_import textarea'),
                        dataType: 'html',
                        success: function(response) {
                            $('#tab_anyyml_import').html(response);
                        },
                        failure: function(response){

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                });
                
            }

        //--></script> 
    
    <?php } ?>
    <label style="margin-top: 10px;">
        Удалить колонки из обмена<span data-toggle="tooltip" title="" data-original-title="Перечислите названия тегов, или названия колонок файла, которых не должно быть в обмене (уменьшает нагрузку) через вертикальную черту: |. Если Вы не знаете названия, то это можно будет сделать позднее, когда названия будут доступны в области настроек Шага 2"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_delete_columns']) && $tamplate_data_selected['anyyml_delete_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_columns]"  value="<?php echo $tamplate_data_selected['anyyml_delete_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Время ожидания ответа при старте задачи (рекомендуется не более 30), в секундах
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_max_curl_timeout']) && $tamplate_data_selected['anyyml_max_curl_timeout']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_max_curl_timeout]"  value="<?php echo $tamplate_data_selected['anyyml_max_curl_timeout'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_max_curl_timeout]"  value="30" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        С какой позиции начать<span data-toggle="tooltip" title="" data-original-title="Порядковый номер узла в файле"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_start_offer']) && $tamplate_data_selected['anyyml_start_offer']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_start_offer]"  value="<?php echo $tamplate_data_selected['anyyml_start_offer'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_start_offer]"  value="1" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Сколько позиций собрать для импорта<span data-toggle="tooltip" title="" data-original-title="Если все, то нужно оставить пустым"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_limit_offer']) && $tamplate_data_selected['anyyml_limit_offer']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_limit_offer]"  value="<?php echo $tamplate_data_selected['anyyml_limit_offer'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_limit_offer]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Объединение складских позиций в ассортиментную по групповому идентификатору</h3>
    
    <label style="margin-top: 10px;">
        Укажите название тега/атрибута тега offer/колонки, который является признаком ассортиметной позиции<span data-toggle="tooltip" title="" data-original-title="Отдельные товары будут объединяться в один, а опции, атрибуты, категории разных offer будут записываться в одном товаре"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_group_id']) && $tamplate_data_selected['anyyml_group_id']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_group_id]"  value="<?php echo $tamplate_data_selected['anyyml_group_id'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_group_id]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Перечислите значения, которые нужно удалить из названия ассортиментного товара<span data-toggle="tooltip" title="" data-original-title="Укажите через вертикальную черту текстовые элементы, которые нужно удалять из названия ассортиментной позиции. Как правило, это названия свойтв цвета, размера отдельного оффера, которые будут лишними в названии групповой позиции"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_group_delete']) && $tamplate_data_selected['anyyml_group_delete']!=='' ){ ?>
        <textarea name="odmpro_tamplate_data[anyyml_group_delete]"  class="form-control" ><?php echo $tamplate_data_selected['anyyml_group_delete'] ?></textarea>
    <?php }else{ ?>
        <textarea name="odmpro_tamplate_data[anyyml_group_delete]"  class="form-control" ></textarea>
    <?php } ?>
    
    
    <label style="margin-top: 10px;" onclick="showHide('#anyyml_group_unique_data');">
        <span style="border-bottom: 1px dashed; cursor: pointer; color: #1abc9c">Найденные уникальные элементы в названиях</span><span data-toggle="tooltip" title="" data-original-title="При обходе товаров, из которых должен собираться один товар анализируются названия, чтобы собрать уникальные элементы. Используйте эти элементы для вставки выше в область удаления из названий уникальных элементов"></span>
    </label>
    <div id="anyyml_group_unique_data" class="well" style="display: none; max-height: 500px; overflow-y: auto">
        <?php echo $anyyml_group_unique_data; ?>
    </div>
    
    
    
    <br><label style="margin-top: 10px;">
        Записывать идентификатор группы в колонку импорта ID (или с названием указанным ниже)<span data-toggle="tooltip" title="" data-original-title="Если включено, в колонку ID области настроек Шага 2 будет записывать, указанный выше идентификатор ассортиметной позиции. Это позволяет сделать идентификатор всем позициям по одной колонке, т.к. у некоторых данных может отсутствовать групповой идентификатор"></span>
    </label>
    
    <select  name="odmpro_tamplate_data[anyyml_group_id_write_to_id]" class="form-control">
            <?php if(isset($tamplate_data_selected['anyyml_group_id_write_to_id']) && $tamplate_data_selected['anyyml_group_id_write_to_id']){ ?>
                <option value="1" selected="" >Включено</option>
                <option value="0" >Выключено</option>
            <?php }else{ ?>
                <option value="1"  >Включено</option>
                <option value="0" selected="">Выключено</option> 
            <?php } ?>
    </select>
    
    <label style="margin-top: 10px;">
        Название колонки, по которой будет выставлен идентификатор товаров, и где будет изменено значение на групповой идентификатор, если включено выше
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_product_id_column_name']) && $tamplate_data_selected['anyyml_product_id_column_name']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_product_id_column_name]"  value="<?php echo $tamplate_data_selected['anyyml_product_id_column_name'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_product_id_column_name]"  value="id" class="form-control" type="text" />
    <?php } ?>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Создание опций</h3>
    
    <label style="margin-top: 10px;">
        Создать опции из параметров<span data-toggle="tooltip" title="" data-original-title="Будет создана колонка с названием options, в которую будут сложены данные в микроразметке опций: Микроразметка 1. Перечислите названия параметров из атрибута NAME тега PARAM через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_option_columns']) && $tamplate_data_selected['anyyml_option_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_option_columns]"  value="<?php echo $tamplate_data_selected['anyyml_option_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_option_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Опции у которых будет передаваться изображение<span data-toggle="tooltip" title="" data-original-title="Если будут создаваться опции и некоторым требуется передача первого изображения, перечислите названия параметров из атрибута NAME тега PARAM через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_option_whis_image']) && $tamplate_data_selected['anyyml_option_whis_image']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_option_whis_image]"  value="<?php echo $tamplate_data_selected['anyyml_option_whis_image'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_option_whis_image]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Тип опций (select, image или checkbox)<span data-toggle="tooltip" title="" data-original-title="Если будут создаваться опции Вы можете задать им тип вывода во фронте магазина: select - список, checkbox - галочка и т.п."></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_option_type']) && $tamplate_data_selected['anyyml_option_type']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_option_type]"  value="<?php echo $tamplate_data_selected['anyyml_option_type'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_option_type]"  value="select" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Способ вывода опций в колонках
    </label>
    
    <select  name="odmpro_tamplate_data[anyyml_option_value_by_column]" class="form-control">
            <?php if(isset($tamplate_data_selected['anyyml_option_value_by_column']) && $tamplate_data_selected['anyyml_option_value_by_column']==='name_column'){ ?>
                <option value="name_column" selected="" >Каждая опция в отдельной колонке под своим названием</option>
                <option value="value_column"  >Каждая опция в отдельной колонке под номером всех опций (уменьшает количество колонок)</option>
                <option value="0" >Все опции в одной колонке</option>
            <?php }elseif(isset($tamplate_data_selected['anyyml_option_value_by_column']) && $tamplate_data_selected['anyyml_option_value_by_column']==='value_column'){ ?>
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
    
    <?php if(isset($tamplate_data_selected['anyyml_attribute_columns']) && $tamplate_data_selected['anyyml_attribute_columns']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_attribute_columns]"  value="<?php echo $tamplate_data_selected['anyyml_attribute_columns'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_attribute_columns]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <h3 style="color: crimson; margin-top: 15px; margin-bottom: 0px; font-size: 17px;">Дополнителные настройки тега PARAM</h3>
    
    <label style="margin-top: 10px;">
        Вычеркнуть следующие param<span data-toggle="tooltip" title="" data-original-title="Перечислите названия параметров из атрибута name тега param через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_delete_params']) && $tamplate_data_selected['anyyml_delete_params']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_params]"  value="<?php echo $tamplate_data_selected['anyyml_delete_params'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_params]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Создать колонки из указанных тегов param, атрибута name<span data-toggle="tooltip" title="" data-original-title="Перечислите названия параметров из атрибута name тега param через вертикальную черту: |"></span>
    </label>
    
    <?php if(isset($tamplate_data_selected['anyyml_select_params_as_column']) && $tamplate_data_selected['anyyml_select_params_as_column']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_select_params_as_column]"  value="<?php echo $tamplate_data_selected['anyyml_select_params_as_column'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_select_params_as_column]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Не записывать содержание атрибута UNIT в название<span data-toggle="tooltip" title="" data-original-title="Если включено, то к названию не будет дописываться значение UNIT"></span>
    </label>
    
    <select  name="odmpro_tamplate_data[anyyml_unit_not_write]" class="form-control">
            <?php if(isset($tamplate_data_selected['anyyml_unit_not_write']) && $tamplate_data_selected['anyyml_unit_not_write']){ ?>
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
    
    <select  name="odmpro_tamplate_data[anyyml_params_as_column]" class="form-control">
            <?php if(isset($tamplate_data_selected['anyyml_params_as_column']) && $tamplate_data_selected['anyyml_params_as_column']){ ?>
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
    
    
    <?php if(isset($tamplate_data_selected['anyyml_delete_by_category_id']) && $tamplate_data_selected['anyyml_delete_by_category_id']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_by_category_id]"  value="<?php echo $tamplate_data_selected['anyyml_delete_by_category_id'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_by_category_id]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    
    
    <label style="margin-top: 10px;">
        Импортировать товары категорий<span data-toggle="tooltip" title="" data-original-title="Перечислите categoryId категорий, товары которых должны попадать в файл импорта через вертикальную черту (товары остальные категорий будут отброшены): |"></span>
    </label>
    
    
    <?php if(isset($tamplate_data_selected['anyyml_set_products_by_category_id']) && $tamplate_data_selected['anyyml_set_products_by_category_id']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_set_products_by_category_id]"  value="<?php echo $tamplate_data_selected['anyyml_set_products_by_category_id'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_set_products_by_category_id]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    <label style="margin-top: 10px;">
        Не импортировать товары производителей<span data-toggle="tooltip" title="" data-original-title="Перечислите названия производителей (из тега vendor), товары которых не должны попадать в файле импорта через вертикальную черту: |"></span>
    </label>
    
    
    <?php if(isset($tamplate_data_selected['anyyml_delete_by_vendor']) && $tamplate_data_selected['anyyml_delete_by_vendor']!=='' ){ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_by_vendor]"  value="<?php echo $tamplate_data_selected['anyyml_delete_by_vendor'] ?>" class="form-control" type="text" />
    <?php }else{ ?>
        <input name="odmpro_tamplate_data[anyyml_delete_by_vendor]"  value="" class="form-control" type="text" />
    <?php } ?>
    
    
    
    
    
    
</div>