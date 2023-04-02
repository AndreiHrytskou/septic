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
        <?php elseif ($i == count($breadcrumbs) - 1): ?>
        <span class="bread-sep">-</span>
        <span class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></span>
        <?php else: ?>
        <span class="bread-sep">-</span>
        <a href="<?php echo $breadcrumbs[$i]['href']; ?>" class="bread-text"><?php echo $breadcrumbs[$i]['text']; ?></a>
        <?php endif; ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  <div class="container container__screen">
    <h1 class="page-title title__indent-top">Видео</h1>
  </div>
</div>
<div class="wrapper">
  <div class="container container__screen">
    <div class="foto-galery">
      <?php foreach($video as $item): ?>
      <div class="foto-galery-wrap">
        <div class="foto-galery-descr">
          <p class="foto-galery-descr-subtitle"><?php echo $item['meta_h1'] ?></p>
          <div class="foto-galery-descr-text">
            <?php echo $item['description'] ?>
          </div>
        </div>
        <div class="video-galery-block">
          <a class="video4-bottom__item" href="<?php echo $item['url'] ?>">
            <?php if($item['thumb']): ?>
            <img class="video4-bottom__item-img" src="<?php echo $item['thumb'] ?>" alt="youtube">
            <iframe class="video4__frame" loading="lazy" src="#"></iframe>
            <?php endif; ?>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="foto-more">
      <a href="https://www.youtube.com/@pro100septik" target="_blank" class="foto-more-btn">больше видео</a>
    </div>
  </div>
</div>
<?php echo $footer; ?>