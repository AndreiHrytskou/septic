<?php echo $header; ?>
<div class="wrapper">
  <div class="container container__screen">
    <div class="bread-band" itemscope="" itemtype="http://schema.org/BreadcrumbList">
      <div itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
        <?php for ($i = 0; $i < count($breadcrumbs); $i++) { ?>
        <?php if($i == 0):?>
        <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-link" itemprop="item">
          <span itemprop="name"><?php echo $breadcrumbs[$i]['text']; ?></span>
          <meta itemprop="position" content="<?= $i + 1; ?>">
        </a>
        <span class="bread-sep">-</span>
        <?php elseif ($i == count($breadcrumbs) - 1): ?>
        <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
        <?php else: ?>
        <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-before">
          <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
        </a>
        <span class="bread-sep">-</span>
        <?php endif; ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<?php echo $content_top; ?>
<div class="wrapper">
  <div class="container container__screen bread-band">
    <h1 class="page-title title__indent-top"><?php echo $heading_title ?></h1>
  </div>
</div>
<div class="wrapper">
  <div class="container container__screen">
    <div class=" wrapper_grey textblock">
      <div class="white-block">
        <?php echo $description; ?>
      </div>
    </div>
  </div>
</div>


<?php echo $column_left; ?>

<?php echo $content_bottom; ?>
<?php echo $column_right; ?>

<?php echo $footer; ?>