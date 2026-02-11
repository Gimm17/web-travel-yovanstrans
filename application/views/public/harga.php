<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Harga Tiket</h1>
    <p class="page-header-subtitle">Harga transparan untuk semua rute dan kelas</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Harga</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (empty($grouped)): ?>
    <div class="empty-state"><i class="fas fa-tags"></i><p>Belum ada data harga</p></div>
    <?php else: ?>
    <div class="grid grid-3">
      <?php foreach ($grouped as $cls_id => $group): ?>
      <div class="price-card animate-on-scroll">
        <div class="price-card-header">
          <div class="price-card-class"><?= $group->class_name; ?></div>
          <div class="price-card-seats"><?= $group->seat_count; ?> Kursi</div>
        </div>
        <div class="price-card-body">
          <?php foreach ($group->items as $p): ?>
          <div class="price-card-item">
            <span class="price-card-route"><?= $p->origin; ?> → <?= $p->destination; ?></span>
            <span>
              <?php if ($p->promo_price && $p->promo_start <= date('Y-m-d') && $p->promo_end >= date('Y-m-d')): ?>
              <span style="text-decoration:line-through;color:var(--gray-400);font-size:.8rem"><?= format_price($p->price); ?></span><br>
              <span class="price-card-amount price-card-promo"><?= format_price($p->promo_price); ?></span>
              <span class="badge-promo" style="font-size:.6rem">PROMO</span>
              <?php else: ?>
              <span class="price-card-amount"><?= format_price($p->price); ?></span>
              <?php endif; ?>
            </span>
          </div>
          <?php endforeach; ?>
        </div>
        <div style="padding:0 1.5rem 1.5rem">
          <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-sm btn-block"><i class="fab fa-whatsapp"></i> Pesan Kelas Ini</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
