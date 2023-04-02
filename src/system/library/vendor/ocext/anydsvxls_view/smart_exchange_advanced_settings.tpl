
<tr>
<td colspan="3" style="padding: 20px;">
    
    <?php $id = $link_data['id']; ?>
    
<h3>Настройка пуска задачи через smartExchange<span data-toggle="tooltip" title="" data-original-title="Для использования smartExchange его необходимо настроить, как это указано в инструкции и в области настроек `Настроить smartExchange`"></span>  <i  onclick="showHide('#smartExchange_task_box_<?php echo $id ?>');" style="cursor: pointer; color: orange" class="fa fa-edit"></i></h3>
    
<table  class="table table-bordered table-hover"  style="border:5px solid #1abc9c; display: none; margin-bottom: 0px;" id="smartExchange_task_box_<?php echo $id ?>">




        

        <tr>
            <td>
                Если задача не завершается:
            </td>
            <td>
                <input  style="width:60%; float: left"  class="form-control" name="odmpro_update_csv_link[<?php echo $id ?>][max_task_timeout]" value="<?php echo $link_data['max_task_timeout'] ?>" />&nbsp;&nbsp;&nbsp;сек.
            </td>
            <td>
                  <select name="odmpro_update_csv_link[<?php echo $id ?>][max_task_timeout_action]"  class="form-control">

                      <option value="0" >Ничего не предпринимать</option>

                      <?php if($link_data['max_task_timeout_action'] && $link_data['max_task_timeout_action']==1){ ?>

                            <option selected="" value="1" >Запустить повторно с места остановки</option>

                            <option value="3" >Остановить</option>

                        <?php }elseif($link_data['max_task_timeout_action'] && $link_data['max_task_timeout_action']==3){ ?>

                            <option value="1" >Запустить повторно с места остановки</option>

                            <option selected="" value="3" >Остановить</option>

                        <?php }else{ ?>

                            <option value="1" >Запустить повторно с места остановки</option>

                            <option value="3" >Остановить</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                Запускать импорт или экспорт, по выбранному "Профилю настроек"?
            </td>
            <td>
                  <select name="odmpro_update_csv_link[<?php echo $id ?>][type_process]"  class="form-control">

                      <option value="0" >Выбрать</option>

                      <?php if($link_data['type_process'] && $link_data['type_process']=='import'){ ?>

                            <option selected="" value="import" >Импорт в ОпенКарт</option>

                            <option value="export" >Экспорт из ОпенКарт</option>

                        <?php }elseif($link_data['status'] && $link_data['type_process']=='export'){ ?>

                            <option value="import" >Импорт в ОпенКарт</option>

                            <option selected="" value="export" >Экспорт из ОпенКарт</option>

                        <?php }else{ ?>

                            <option value="import" >Импорт в ОпенКарт</option>

                            <option value="export" >Экспорт из ОпенКарт</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
        <tr>
            
            
        <tr>
            <td colspan="3">
                
                <h4 style="color: #1abc9c;">Установка времени запуска задачи (Время и дата на сервере: <?php echo $server_data_time ?>)</h4>
                
                <table class="table table-bordered table-hover" style="margin-bottom: 0px">
                                    <tr>
                                    <td>День недели (номером дня недели)<span data-toggle="tooltip" title="" data-original-title="1 - Пн, 2 - Вт, 3 - Ср, 4 - Чт, Пт - 5, Сб - 6, Вс - 7"></span></td>
                                    <td>Час<span data-toggle="tooltip" title="" data-original-title="от 1 до 24"></span></td>
                                    <td>Мин<span data-toggle="tooltip" title="" data-original-title="от 0 до 60"></span></td>
                                    <td>Последняя активность</td>
                                    </tr>
                                    
                                <?php for($s=0;$s < $max_count_tasks_to_profile;$s++){ ?>

                                

                                <tr style="margin-bottom: 5px;">
                                            
                                            <td>

                                                <input placeholder="день недели"  style="width:60%; float: left"  class="form-control" name="odmpro_update_csv_link[<?php echo $id ?>][timestart][<?php echo $s ?>][d]" value="<?php if(isset($link_data['timestart'][$s]['d'])){ echo $link_data['timestart'][$s]['d']; } ?>" />

                                            </td>
                                            
                                            <td>

                                                <input placeholder="час"  style="width:60%; float: left"  class="form-control" name="odmpro_update_csv_link[<?php echo $id ?>][timestart][<?php echo $s ?>][h]" value="<?php if(isset($link_data['timestart'][$s]['h'])){ echo $link_data['timestart'][$s]['h']; } ?>" />

                                            </td>
                                            <td>

                                                <input placeholder="мин." style="width:60%; float: left"  class="form-control" name="odmpro_update_csv_link[<?php echo $id ?>][timestart][<?php echo $s ?>][m]" value="<?php if(isset($link_data['timestart'][$s]['m'])){ echo $link_data['timestart'][$s]['m']; } ?>" />

                                            </td>
                                            <td style="max-width: 600px;overflow-x: auto;">
                                                
                                                <a class="btn btn-primary" onclick="showHide('#log_setting_box_<?php echo $id ?>-<?php echo $s  ?>'); $(this).remove()" >Показать</a>
                                                
                                                <div id="log_setting_box_<?php echo $id ?>-<?php echo $s  ?>" style="display: none">
                                                
                                                        <?php if(isset($link_data['timestart'][$s]['task_id']) && $link_data['timestart'][$s]['task_id']){ ?>
                                                        <div style="margin-bottom: 15px;">
                                                            <a onclick="getActionTask('<?php echo $link_data['timestart'][$s]['task_id'] ?>',1)" data-toggle="tooltip" class="btn btn-default"><i class="fa fa-play-circle"></i> Запустить сейчас</a>
                                                            <a onclick="getActionTask('<?php echo $link_data['timestart'][$s]['task_id'] ?>',3)" data-toggle="tooltip" class="btn btn-default"><i class="fa fa-pause-circle"></i> Остановить (если работает, остановится)</a>
                                                        </div>
                                                        <?php } ?>
                                                        <span style="margin-bottom: 3px;">Онлайн лог (обновляется каждые 5 секунд):</span>
                                                        <div style="max-height: 150px; overflow-y: auto; overflow-x: auto;font-size: 9px;" id='task_id_last_log_data_<?php if(isset($link_data['timestart'][$s]['task_id'])){ echo $link_data['timestart'][$s]['task_id']; } ?>' class="alert alert-info"></div>
                                                        <span style="margin-bottom: 3px;">Весь лог (обновляется при перезагрузке страницы):</span>
                                                        <div class="well well-sm" style="height: 150px; overflow-y: auto; overflow-x: auto; ">
                                                            <span style="font-size: 9px;">
                                                                <?php if(isset($link_data['timestart'][$s]['last_log_data'])){ echo $link_data['timestart'][$s]['last_log_data']; }else{ ?> - <?php } ?>
                                                            </span>
                                                        </div>
                                                
                                                </div>
                                            </td>
                                        </tr>

                                    

                                <?php } ?>
                                
                                </table>
                
                
            </td>
        </tr>
        
            
        <tr>
            <td colspan="2">Email для отправки уведомлений (через запятую, если несколько)</td>
            <td>
                <input  style="width:60%; float: left"  class="form-control" name="odmpro_update_csv_link[<?php echo $id ?>][email_notice]" value="<?php echo $link_data['email_notice'] ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">С этой задачей разрешены одновременные задачи (если выключено, то запуск одновременных задач вместе с этим процессом, будет невозможен)</td>
            <td>
                
                    <?php $setting_name = 'asynchronous_status'; ?>
                
                    <select name="odmpro_update_csv_link[<?php echo $id ?>][<?php echo $setting_name; ?>]"  class="form-control">

                      <?php if($link_data[$setting_name]){ ?>

                            <option selected="" value="1" >ДА</option>

                            <option value="0" >НЕТ</option>

                        <?php }elseif($link_data[$setting_name] && !$link_data[$setting_name]){ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php }else{ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">Отправлять письмо о начале</td>
            <td>
                
                    <?php $setting_name = 'start_email_notice'; ?>
                
                    <select name="odmpro_update_csv_link[<?php echo $id ?>][<?php echo $setting_name; ?>]"  class="form-control">

                      <?php if($link_data[$setting_name]){ ?>

                            <option selected="" value="1" >ДА</option>

                            <option value="0" >НЕТ</option>

                        <?php }elseif($link_data[$setting_name] && !$link_data[$setting_name]){ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php }else{ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">Отправлять письмо об остановке (превышения таймаута, установленного выше)</td>
            <td>
                
                    <?php $setting_name = 'timeout_email_notice'; ?>
                
                    <select name="odmpro_update_csv_link[<?php echo $id ?>][<?php echo $setting_name; ?>]"  class="form-control">

                      <?php if($link_data[$setting_name]){ ?>

                            <option selected="" value="1" >ДА</option>

                            <option value="0" >НЕТ</option>

                        <?php }elseif($link_data[$setting_name] && !$link_data[$setting_name]){ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php }else{ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">Отправлять письмо о завершении</td>
            <td>
                
                    <?php $setting_name = 'finish_email_notice'; ?>
                
                    <select name="odmpro_update_csv_link[<?php echo $id ?>][<?php echo $setting_name; ?>]"  class="form-control">

                      <?php if($link_data[$setting_name]){ ?>

                            <option selected="" value="1" >ДА</option>

                            <option value="0" >НЕТ</option>

                        <?php }elseif($link_data[$setting_name] && !$link_data[$setting_name]){ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php }else{ ?>

                            <option value="1" >ДА</option>

                            <option selected="" value="0" >НЕТ</option>

                        <?php } ?>

                  </select>
            </td>
        </tr>
</table>

</td>
</tr>