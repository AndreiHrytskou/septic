<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-photo" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-photo" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="photo_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="photo_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_h1[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_h1[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
				  </div>
                  <div style="display: none;">
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="photo_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                        <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                        <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                      <div class="col-sm-10">
                        <textarea name="photo_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                      <div class="col-sm-10">
                        <textarea name="photo_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-manufacturer"><span data-toggle="tooltip" title="<?php echo $help_manufacturer; ?>"><?php echo $entry_manufacturer; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="manufacturer" value="<?php echo $manufacturer; ?>" placeholder="<?php echo $entry_manufacturer; ?>" id="input-manufacturer" class="form-control" />
                      <input type="hidden" name="manufacturer_id" value="<?php echo $manufacturer_id; ?>" />
                    </div>
                  </div>

                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="photo_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($photo_description[$language['language_id']]) ? $photo_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>


                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_image; ?></label>
                    <div class="col-sm-10">

                      <?php $image_row = 0; ?>
                      <?php foreach ($languages as $language) { ?>
                      <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                        <table id="images<?php echo $language['language_id']; ?>"
                               class="table table-striped table-bordered table-hover">
                          <thead>
                          <tr>
                            <td class="text-left"><?php echo $entry_title; ?></td>
                            <td class="text-left"><?php echo $entry_link; ?></td>
                            <td class="text-center"><?php echo $entry_image; ?></td>
                            <td class="text-right"><?php echo $entry_sort_order; ?></td>
                            <td></td>
                          </tr>
                          </thead>
                          <tbody>
                          <?php if (isset($photo_images[$language['language_id']])) { ?>
                          <?php foreach ($photo_images[$language['language_id']] as $photo_image) { ?>
                          <tr id="image-row<?php echo $image_row; ?>">
                            <td class="text-left"><input type="text"
                                                         name="photo_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][title]"
                                                         value="<?php echo $photo_image['title']; ?>"
                                                         placeholder="<?php echo $entry_title; ?>"
                                                         class="form-control"/>
                              <?php if (isset($error_photo_image[$language['language_id']][$image_row])) { ?>
                              <div class="text-danger"><?php echo $error_photo_image[$language['language_id']][$image_row]; ?></div>
                              <?php } ?></td>
                            <td class="text-left" style="width: 30%;"><input type="text"
                                                                             name="photo_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][link]"
                                                                             value="<?php echo $photo_image['link']; ?>"
                                                                             placeholder="<?php echo $entry_link; ?>"
                                                                             class="form-control"/></td>
                            <td class="text-center"><a href="" id="thumb-image-<?php echo $image_row; ?>"
                                                       data-toggle="image" class="img-thumbnail"><img
                                        src="<?php echo $photo_image['thumb']; ?>" alt="" title=""
                                        data-placeholder="<?php echo $placeholder; ?>"/></a>
                              <input type="hidden"
                                     name="photo_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][image]"
                                     value="<?php echo $photo_image['image']; ?>"
                                     id="input-image<?php echo $image_row; ?>"/></td>
                            <td class="text-right" style="width: 10%;"><input type="text"
                                                                              name="photo_image[<?php echo $language['language_id']; ?>][<?php echo $image_row; ?>][sort_order]"
                                                                              value="<?php echo $photo_image['sort_order']; ?>"
                                                                              placeholder="<?php echo $entry_sort_order; ?>"
                                                                              class="form-control"/></td>
                            <td class="text-left">
                              <button type="button"
                                      onclick="$('#image-row<?php echo $image_row; ?>, .tooltip').remove();"
                                      data-toggle="tooltip" title="<?php echo $button_remove; ?>"
                                      class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                            </td>
                          </tr>
                          <?php $image_row++; ?>
                          <?php } ?>
                          <?php } ?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <td colspan="4"></td>
                            <td class="text-left">
                              <button type="button" onclick="addImage('<?php echo $language['language_id']; ?>');"
                                      data-toggle="tooltip" title="<?php echo $button_photo_add; ?>"
                                      class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                            </td>
                          </tr>
                          </tfoot>
                        </table>
                      </div>
                      <?php } ?>

                    </div>
                  </div>




                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $photo_store)) { ?>
                        <input type="checkbox" name="photo_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="photo_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $photo_store)) { ?>
                        <input type="checkbox" name="photo_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="photo_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-noindex"><span data-toggle="tooltip" title="<?php echo $help_noindex; ?>"><?php echo $entry_noindex; ?></span></label>
                <div class="col-sm-10">
                  <select name="noindex" id="input-noindex" class="form-control">
                    <?php if ($noindex) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
				</div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="photo_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($photo_layout[0]) && $photo_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="photo_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($photo_layout[$store['store_id']]) && $photo_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>

  <?php print_r($image_row); ?>
  <script type="text/javascript"><!--
    // Manufacturer
    $('input[name=\'manufacturer\']').autocomplete({
      'source': function(request, response) {
        $.ajax({
          url: 'index.php?route=catalog/manufacturer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
          dataType: 'json',
          success: function(json) {
            json.unshift({
              manufacturer_id: 0,
              name: '<?php echo $text_none; ?>'
            });

            response($.map(json, function(item) {
              return {
                label: item['name'],
                value: item['manufacturer_id']
              }
            }));
          }
        });
      },
      'select': function(item) {
        $('input[name=\'manufacturer\']').val(item['label']);
        $('input[name=\'manufacturer_id\']').val(item['value']);
      }
    });
  </script>
  <script type="text/javascript"><!--
    var image_row = <?php echo $image_row; ?>;

    function addImage(language_id) {
      html  = '<tr id="image-row' + image_row + '">';
      html += '  <td class="text-left"><input type="text" name="photo_image[' + language_id + '][' + image_row + '][title]" value="" placeholder="<?php echo $entry_title; ?>" class="form-control" /></td>';
      html += '  <td class="text-left" style="width: 30%;"><input type="text" name="photo_image[' + language_id + '][' + image_row + '][link]" value="" placeholder="<?php echo $entry_link; ?>" class="form-control" /></td>';
      html += '  <td class="text-center"><a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="photo_image[' + language_id + '][' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
      html += '  <td class="text-right" style="width: 10%;"><input type="text" name="photo_image[' + language_id + '][' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
      html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + ', .tooltip\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
      html += '</tr>';

      $('#images' + language_id + ' tbody').append(html);

      image_row++;
    }
    //--></script>

  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>