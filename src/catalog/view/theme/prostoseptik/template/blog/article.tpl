<?php echo $header; ?>
<div class="wrapper">
  <div class="container">
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

<div class="wrapper">
  <div class="container container__screen">
    <p class="post_date"><?php echo $date_added; ?></p>
    <h1 class="page-title title__indent-top"><?php echo $heading_title; ?></h1>
    <div class="post_wrap">
      <div class="post_container">
        <?php if(isset($image) && !empty($image)): ?>
        <img class="post_img" src="<?= $image; ?>"	alt="Rectangle">
        <?php endif; ?>
        <div class="post_descr">
          <?php echo $description; ?>
        </div>
      </div>
      <?php echo $column_right; ?>
      <?php echo $column_left; ?>


    </div>

  </div>
</div>

<div class="wrapper">
  <div class="container container__screen">
    <?php echo $content_bottom; ?>
  </div>
</div>


<?php echo $footer; ?>