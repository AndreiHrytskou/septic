
<h2 style="color: red">Обработка через драйвер поставщик: optimus-cctv</h2>

<input value="1" name="odmpro_tamplate_data[anyyml_yml_upload]" type="hidden" />
<input value="<?php echo $supplier_feed_source; ?>" name="odmpro_tamplate_data[supplier_feed_source]" type="hidden" />



    <label style="margin-top: 10px;">
        Найти
    </label>

    <?php if(isset($tamplate_data_selected['csvsb0221_find']) && $tamplate_data_selected['csvsb0221_find']!=='' ){ ?>
        <textarea name="odmpro_tamplate_data[csvsb0221_find]"  class="form-control" type="text" ><?php echo $tamplate_data_selected['csvsb0221_find'] ?></textarea>
    <?php }else{ ?>
        <textarea name="odmpro_tamplate_data[csvsb0221_find]"  class="form-control" type="text" ></textarea>
    <?php } ?> 


    <label style="margin-top: 10px;">
        Заменить
    </label>

    <?php if(isset($tamplate_data_selected['csvsb0221_replace']) && $tamplate_data_selected['csvsb0221_replace']!=='' ){ ?>
        <textarea name="odmpro_tamplate_data[csvsb0221_replace]"  class="form-control" type="text" ><?php echo $tamplate_data_selected['csvsb0221_replace'] ?></textarea>
    <?php }else{ ?>
        <textarea name="odmpro_tamplate_data[csvsb0221_replace]"  class="form-control" type="text" ></textarea>
    <?php } ?> 
    
    <label style="margin-top: 10px;">
        Загрузка JSON
    </label>
   <select  name="odmpro_tamplate_data[csvsb0221_json]" class="form-control">
            <?php if(isset($tamplate_data_selected['csvsb0221_json']) && $tamplate_data_selected['csvsb0221_json']){ ?>
                <option value="1" selected="" >Включено</option>
                <option value="0" >Выключено</option>
            <?php }else{ ?>
                <option value="1"  >Включено</option>
                <option value="0" selected="">Выключено</option> 
            <?php } ?>
    </select>