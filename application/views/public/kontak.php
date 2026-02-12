<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Kontak</h1>
    <p class="page-header-subtitle">Hubungi kami atau kunjungi kantor agen terdekat</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Kontak</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid grid-3 mobile-carousel">
      <?php foreach ($branches as $b): ?>
      <div class="branch-card animate-on-scroll">
        <div class="branch-card-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h3 class="branch-card-name"><?= $b->name; ?></h3>
        <p class="branch-card-address"><?= $b->address; ?></p>
        <div class="branch-card-hours"><i class="fas fa-clock"></i> <?= $b->operational_hours; ?></div>
        <p style="font-size:.85rem;color:var(--gray-500);margin-bottom:1rem"><i class="fas fa-phone"></i> <?= $b->phone; ?></p>
        <div class="branch-card-actions" style="flex-direction:column">
          <a href="<?= wa_url($b->wa_number); ?>" target="_blank" class="btn btn-wa btn-sm btn-block">
            <i class="fab fa-whatsapp"></i> Chat WhatsApp
          </a>
          <?php if ($b->maps_url): ?>
          <a href="<?= $b->maps_url; ?>" target="_blank" class="btn btn-blue btn-sm btn-block">
            <i class="fas fa-map-marked-alt"></i> Buka di Google Maps
          </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Info Tambahan -->
<section class="section section-gray">
  <div class="container" style="max-width:700px;text-align:center">
    <h2 class="section-title">Butuh Bantuan?</h2>
    <p style="color:var(--gray-600);margin-bottom:2rem;font-size:1.05rem">
      Jangan ragu menghubungi kami lewat WhatsApp. Tim kami siap membantu Anda 24/7.
    </p>
    <a href="<?= wa_url('6282349085255', 'Halo kak, saya mau bertanya tentang layanan YovansTranss'); ?>" target="_blank" class="btn btn-wa btn-lg">
      <i class="fab fa-whatsapp"></i> Chat Sekarang
    </a>
  </div>
</section>
