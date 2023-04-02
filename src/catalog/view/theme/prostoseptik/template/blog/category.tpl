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
      <?php if(count($articles) > 0): ?>
      <h1 class="page-title title__indent-top"><?php echo $heading_title; ?></h1>
      <?php else: ?>
      <h1 class="page-title title__indent-top">Нет новостей</h1>
      <?php endif; ?>

      <?php if(count($articles) > 0): ?>
      <div class="news_page" id="news_page">
        <?php foreach ($articles as $article): ?>
        <div class="news-block__item">
          <div class="news-block__img">
            <a href="<?php echo $article['href']; ?>" class="news-block-item-link">
              <img class="news-foto" src="<?php echo $article['thumb']; ?>" alt="Rectangle 150">
            </a>
          </div>
          <div class="news-block__descr">
            <p class="news-block__date"><?php echo $article["date_added"];?></p>
            <a href="<?php echo $article['href']; ?>" class="news-block__title"><?php echo $article['name']; ?></a>
            <p class="news-block__text"><?php echo $article['description']; ?></p>
            <a href="<?php echo $article['href']; ?>" class="news-block__link"><span>подробнее</span></a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php if(isset($next_page)): ?>
      <button id="more-news" data-page="<?php echo $page; ?>" data-total="<?php echo $article_total; ?>" data-limit="<?php echo $limit; ?>" data-href="<?php echo $next_page; ?>" class="news-more">Загрузить ещё</button>
      <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  <script src="/catalog/view/theme/prostoseptik/assets/js/news.js"></script>

  <?php echo $footer; ?>