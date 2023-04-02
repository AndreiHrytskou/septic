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
    <h1 class="page-title title__indent-top">Фото</h1>
    <div class="foto-check">
      <div class="foto-filtr" id="foto-filtr">
        <p>Все модели</p>
        <img src="/catalog/view/theme/prostoseptik/assets/img/whitetiangle.png" alt="whitetiangle">
      </div>
      <ul class="foto-check-list foto-check-list-mobile" id="photo-nav">
        <li data-manufacturer-id onclick="getPhotoList(this,'<?php echo $link_filter ?>')" class="foto-check-list-item item_active">
          <p>Все модели</p>
          <img src="/catalog/view/theme/prostoseptik/assets/img/whitetiangle.png" alt="whitetiangle">
        </li>
        <?php if($manufacturer_info): ?>
        <?php foreach($manufacturer_info as $manufacturer): ?>
        <li onclick="getPhotoList(this, '<?php echo $link_filter ?>','<?php echo $manufacturer['manufacturer_id']; ?>')" data-manufacturer-id="<?php echo $manufacturer['manufacturer_id']; ?>" class="foto-check-list-item"><p><?php echo $manufacturer['name']; ?></p></li>
        <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <div class="foto-galery" id="foto-galery">
      <?php if(isset($photos) && count($photos) > 0): ?>
      <?php foreach($photos as $photo): ?>
      <div class="foto-galery-wrap">
        <div class="foto-galery-descr">
          <p class="foto-galery-descr-subtitle"><?php echo $photo['title'] ?></p>
          <p class="foto-galery-descr-text"><?php echo $photo['description'] ?></p>
        </div>
        <div class="foto-galery-block">
          <?php foreach($photo['photo'] as $image): ?>
          <?php if($image['thumb']): ?>
            <div class="slide" style="background-image: url('<?php echo $image['thumb'] ?>');"></div>
          <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>


    <div class="foto-more">
      <button onclick="getPhotoPage(this)" data-manufacturer-id="<?= $manufacturer_id; ?>" id="photoMore" data-href="<?= $link_filter ?>" data-total="<?= $total ?>" data-page="<?= $page ?>" data-limit="<?= $limit ?>" class="foto-more-btn">Показать еще</button>
    </div>
  </div>
</div>

<?php echo $footer; ?>