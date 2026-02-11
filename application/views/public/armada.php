<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Armada & Kelas</h1>
    <p class="page-header-subtitle">Armada premium untuk perjalanan nyaman Anda</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Armada</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php foreach ($classes as $i => $cls): ?>
    <div class="animate-on-scroll" style="margin-bottom:3rem;display:grid;grid-template-columns:1fr;gap:2rem;<?= $i % 2 ? '' : ''; ?>">
      <div style="display:grid;grid-template-columns:1fr;gap:2rem;align-items:center" class="<?= $i % 2 ? '' : ''; ?>">
        <?php if ($cls->cover_image): ?>
        <div style="border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-lg)">
          <img src="<?= base_url('assets/uploads/' . $cls->cover_image); ?>" alt="<?= $cls->name; ?>" style="width:100%;height:300px;object-fit:cover">
        </div>
        <?php else: ?>
        <div style="background:var(--gradient-blue);border-radius:var(--radius-xl);height:300px;display:flex;align-items:center;justify-content:center">
          <i class="fas fa-shuttle-van" style="font-size:4rem;color:var(--white)"></i>
        </div>
        <?php endif; ?>
        <div>
          <h2 style="font-size:1.75rem;font-weight:900;margin-bottom:.5rem"><?= $cls->name; ?></h2>
          <p style="color:var(--gray-500);margin-bottom:1rem"><i class="fas fa-chair"></i> <?= $cls->seat_count; ?> Kursi</p>
          <?php if ($cls->highlight): ?>
          <span class="fleet-card-highlight"><?= $cls->highlight; ?></span>
          <?php endif; ?>
          <p style="margin-top:1rem;line-height:1.7;color:var(--gray-600)"><?= $cls->description; ?></p>
          <?php $features = json_decode($cls->features, true);
          if ($features): ?>
          <div class="features-list" style="margin-top:1rem">
            <?php foreach ($features as $f): ?>
            <span class="feature-badge"><i class="fas fa-check"></i> <?= $f; ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
          <div style="margin-top:1.5rem">
            <a href="<?= base_url('armada/' . $cls->slug); ?>" class="btn btn-blue btn-sm"><i class="fas fa-eye"></i> Lihat Detail</a>
            <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-sm" style="margin-left:.5rem"><i class="fab fa-whatsapp"></i> Pesan</a>
            <a href="<?= base_url('harga'); ?>" class="btn btn-blue btn-sm" style="margin-left:.5rem"><i class="fas fa-tags"></i> Harga</a>
          </div>
        </div>
      </div>
    </div>
    <?php if ($i < count($classes) - 1): ?>
    <hr style="border:none;border-top:1px solid var(--gray-200);margin-bottom:2rem">
    <?php endif; ?>
    <?php endforeach; ?>
  </div>
</section>
