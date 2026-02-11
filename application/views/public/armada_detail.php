<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title"><?= $cls->name; ?></h1>
    <p class="page-header-subtitle">Detail kelas armada</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <a href="<?= base_url('armada'); ?>">Armada</a> / <span><?= $cls->name; ?></span></div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:900px">
    <div class="animate-on-scroll">
      <?php if ($cls->cover_image): ?>
      <div style="border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-lg);margin-bottom:2rem">
        <img src="<?= webp_url($cls->cover_image); ?>" alt="<?= $cls->name; ?>" style="width:100%;height:400px;object-fit:cover">
      </div>
      <?php else: ?>
      <div style="background:var(--gradient-blue);border-radius:var(--radius-xl);height:300px;display:flex;align-items:center;justify-content:center;margin-bottom:2rem">
        <i class="fas fa-shuttle-van" style="font-size:5rem;color:var(--white)"></i>
      </div>
      <?php endif; ?>

      <h2 style="font-size:2rem;font-weight:900;margin-bottom:.5rem"><?= $cls->name; ?></h2>
      <p style="color:var(--gray-500);margin-bottom:1rem"><i class="fas fa-chair"></i> <?= $cls->seat_count; ?> Kursi</p>

      <?php if ($cls->highlight): ?>
      <span class="fleet-card-highlight" style="margin-bottom:1.5rem;display:inline-block"><?= $cls->highlight; ?></span>
      <?php endif; ?>

      <?php if ($cls->description): ?>
      <p style="line-height:1.8;color:var(--gray-600);margin-bottom:1.5rem"><?= $cls->description; ?></p>
      <?php endif; ?>

      <?php $features = json_decode($cls->features, true);
      if ($features): ?>
      <h3 style="font-weight:700;margin-bottom:.75rem;color:var(--blue-700)"><i class="fas fa-star"></i> Fitur & Fasilitas</h3>
      <div class="features-list" style="margin-bottom:2rem">
        <?php foreach ($features as $f): ?>
        <span class="feature-badge"><i class="fas fa-check"></i> <?= $f; ?></span>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Photo Gallery -->
      <?php if (!empty($photos)): ?>
      <h3 style="font-weight:700;margin-bottom:.75rem;color:var(--blue-700)"><i class="fas fa-images"></i> Galeri Foto</h3>
      <div style="columns:3;column-gap:1rem;margin-bottom:2rem">
        <?php foreach ($photos as $p): ?>
        <div style="break-inside:avoid;margin-bottom:1rem;border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md);cursor:pointer" onclick="openLightbox('<?= webp_url($p->image); ?>')">
          <img src="<?= webp_url($p->image); ?>" alt="<?= $p->caption ?: $cls->name; ?>" style="width:100%;height:auto;display:block;transition:transform .3s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" loading="lazy">
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <div style="display:flex;gap:1rem;flex-wrap:wrap">
        <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-lg"><i class="fab fa-whatsapp"></i> Pesan Kelas Ini</a>
        <a href="<?= base_url('harga'); ?>" class="btn btn-blue"><i class="fas fa-tags"></i> Lihat Harga</a>
        <a href="<?= base_url('armada'); ?>" class="btn btn-yellow"><i class="fas fa-arrow-left"></i> Semua Armada</a>
      </div>
    </div>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" onclick="this.style.display='none'" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;cursor:pointer;padding:2rem;align-items:center;justify-content:center">
  <img id="lightbox-img" style="max-width:90%;max-height:90vh;border-radius:var(--radius-lg);object-fit:contain">
  <div style="position:absolute;top:1rem;right:1.5rem;color:#fff;font-size:2rem"><i class="fas fa-times"></i></div>
</div>
<script>
function openLightbox(src){var l=document.getElementById('lightbox');document.getElementById('lightbox-img').src=src;l.style.display='flex';}
</script>
