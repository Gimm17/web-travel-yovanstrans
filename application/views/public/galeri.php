<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Galeri</h1>
    <p class="page-header-subtitle">Koleksi foto armada, interior, dan kegiatan kami</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Galeri</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (empty($albums)): ?>
    <div class="empty-state">
      <i class="fas fa-images"></i>
      <p>Belum ada album galeri. Segera hadir!</p>
    </div>
    <?php else: ?>
    <div class="grid grid-3">
      <?php foreach ($albums as $album): ?>
      <a href="<?= base_url('galeri/' . $album->slug); ?>" class="card animate-on-scroll" style="text-decoration:none;color:inherit">
        <?php if ($album->cover_image): ?>
        <img src="<?= webp_url($album->cover_image); ?>" alt="<?= $album->title; ?>" class="card-img" loading="lazy">
        <?php else: ?>
        <div class="card-img" style="background:var(--gradient-blue);display:flex;align-items:center;justify-content:center">
          <i class="fas fa-images" style="font-size:2rem;color:var(--white)"></i>
        </div>
        <?php endif; ?>
        <div class="card-body">
          <h3 class="card-title"><?= $album->title; ?></h3>
          <?php if ($album->description): ?>
          <p class="card-text"><?= character_limiter($album->description, 80); ?></p>
          <?php endif; ?>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
