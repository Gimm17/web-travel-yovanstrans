<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Berita & Event</h1>
    <p class="page-header-subtitle">Info terbaru tentang YovansTranss dan promo menarik</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Berita</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (empty($posts)): ?>
    <div class="empty-state"><i class="fas fa-newspaper"></i><p>Belum ada berita. Segera hadir!</p></div>
    <?php else: ?>
    <div class="grid grid-3">
      <?php foreach ($posts as $post): ?>
      <div class="post-card animate-on-scroll">
        <?php if ($post->cover_image): ?>
        <img src="<?= base_url('assets/uploads/' . $post->cover_image); ?>" alt="<?= $post->title; ?>" class="post-card-image" loading="lazy">
        <?php else: ?>
        <div class="post-card-image" style="background:var(--gradient-blue);display:flex;align-items:center;justify-content:center">
          <i class="fas fa-newspaper" style="font-size:2rem;color:var(--white)"></i>
        </div>
        <?php endif; ?>
        <div class="post-card-body">
          <?php if ($post->category): ?>
          <span class="post-card-category"><?= $post->category; ?></span>
          <?php endif; ?>
          <h3 class="post-card-title">
            <a href="<?= base_url('berita/' . $post->slug); ?>"><?= $post->title; ?></a>
          </h3>
          <p class="post-card-excerpt"><?= character_limiter(strip_tags($post->content), 120); ?></p>
          <p class="post-card-date"><i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($post->published_at ?: $post->created_at)); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
