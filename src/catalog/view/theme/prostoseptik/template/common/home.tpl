<?php echo $header; ?>
<div><?php echo $column_left; ?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class = 'col-sm-6'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class = 'col-sm-9'; ?>
  <?php } else { ?>
  <?php $class = 'col-sm-12'; ?>
  <?php } ?>
  <div><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
  <?php echo $column_right; ?></div>
<?php echo $footer; ?>