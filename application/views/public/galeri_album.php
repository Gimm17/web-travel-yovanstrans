<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title"><?= $album->title; ?></h1>
    <?php if ($album->description): ?>
    <p class="page-header-subtitle"><?= $album->description; ?></p>
    <?php endif; ?>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <a href="<?= base_url('galeri'); ?>">Galeri</a> / <span><?= $album->title; ?></span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (empty($items)): ?>
    <div class="empty-state"><i class="fas fa-images"></i><p>Album ini masih kosong</p></div>
    <?php else: ?>
    <div class="gallery-grid">
      <?php foreach ($items as $item): ?>
      <div class="gallery-item">
        <img src="<?= webp_url($item->image); ?>" alt="<?= $item->caption ?: $album->title; ?>" loading="lazy">
        <div class="gallery-item-overlay"><i class="fas fa-search-plus" style="color:var(--white);font-size:1.5rem;opacity:0"></i></div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
