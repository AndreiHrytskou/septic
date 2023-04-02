<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Лид</h3>
      </div>
      <div class="panel-body">
        <div class="">
          <?php foreach ($languages as $language) { ?>
          <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                <?php echo isset($name) ? $name : ''; ?>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-phone<?php echo $language['language_id']; ?>"><?php echo $entry_phone; ?></label>
              <div class="col-sm-10">
                <?php echo isset($phone) ? $phone : ''; ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-comment; ?>"><?php echo $entry_comment; ?></label>
              <div class="col-sm-10">
                <?php echo isset($comment) ? $comment : ''; ?><
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
</div>
<?php echo $footer; ?>