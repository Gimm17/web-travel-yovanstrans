<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title"><?= $post->title; ?></h1>
    <p class="page-header-subtitle">
      <i class="fas fa-calendar"></i> <?= date('d M Y', strtotime($post->published_at ?: $post->created_at)); ?>
      &nbsp; <i class="fas fa-eye"></i> <?= $post->views; ?>x dibaca
    </p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <a href="<?= base_url('berita'); ?>">Berita</a> / <span><?= $post->title; ?></span></div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:800px">
    <?php if ($post->cover_image): ?>
    <img src="<?= base_url('assets/uploads/' . $post->cover_image); ?>" alt="<?= $post->title; ?>" style="width:100%;border-radius:var(--radius-xl);margin-bottom:2rem">
    <?php endif; ?>
    <div class="post-content" style="line-height:1.8;color:var(--gray-700);font-size:1rem">
      <?= $post->content; ?>
    </div>
    <div style="margin-top:2rem;display:flex;gap:1rem">
      <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa"><i class="fab fa-whatsapp"></i> Pesan Tiket</a>
      <a href="<?= base_url('berita'); ?>" class="btn btn-blue btn-sm"><i class="fas fa-arrow-left"></i> Semua Berita</a>
    </div>

    <!-- Recent Posts -->
    <?php if (!empty($recent)): ?>
    <hr style="margin:3rem 0;border:none;border-top:1px solid var(--gray-200)">
    <h3 style="font-weight:700;margin-bottom:1rem">Berita Lainnya</h3>
    <div class="grid grid-2">
      <?php foreach ($recent as $r): if ($r->id == $post->id) continue; ?>
      <a href="<?= base_url('berita/' . $r->slug); ?>" class="card" style="text-decoration:none;color:inherit">
        <div class="card-body">
          <h4 class="card-title"><?= $r->title; ?></h4>
          <p class="card-text"><?= date('d M Y', strtotime($r->published_at ?: $r->created_at)); ?></p>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
