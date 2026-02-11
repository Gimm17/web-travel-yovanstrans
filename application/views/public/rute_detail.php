<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title"><?= $route->origin; ?> → <?= $route->destination; ?></h1>
    <p class="page-header-subtitle">Detail rute dan jadwal keberangkatan</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <a href="<?= base_url('rute'); ?>">Rute</a> / <span><?= $route->origin; ?> → <?= $route->destination; ?></span></div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:800px">
    <div class="animate-on-scroll" style="margin-bottom:2rem">
      <div class="route-card">
        <div class="route-card-header">
          <span class="route-cities"><?= $route->origin; ?></span>
          <span class="route-arrow">→</span>
          <span class="route-cities"><?= $route->destination; ?></span>
        </div>
        <div class="route-meta">
          <?php if ($route->distance_km): ?>
          <span class="route-meta-item"><i class="fas fa-road"></i> <?= $route->distance_km; ?> km</span>
          <?php endif; ?>
          <?php if ($route->duration_hours): ?>
          <span class="route-meta-item"><i class="fas fa-clock"></i> ~<?= $route->duration_hours; ?> jam</span>
          <?php endif; ?>
        </div>
        <?php if ($route->description): ?>
        <p style="color:var(--gray-600);line-height:1.7;margin-top:1rem"><?= $route->description; ?></p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Jadwal Keberangkatan -->
    <div class="animate-on-scroll">
      <h2 style="font-size:1.5rem;font-weight:800;margin-bottom:1rem;color:var(--blue-700)">
        <i class="fas fa-clock"></i> Jadwal Keberangkatan
      </h2>
      <?php if (!empty($schedules)): ?>
      <table class="schedule-table">
        <thead><tr><th>Jam Berangkat</th><th>Kelas</th><th>Keterangan</th></tr></thead>
        <tbody>
        <?php foreach ($schedules as $s): ?>
        <tr>
          <td data-label="Jam"><?= date('H:i', strtotime($s->depart_time)); ?> WITA</td>
          <td data-label="Kelas"><?= $s->class_name ?: '-'; ?></td>
          <td data-label="Ket"><?= $s->notes ?: '-'; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php else: ?>
      <div class="empty-state" style="padding:2rem;text-align:center;color:var(--gray-400)">
        <i class="fas fa-calendar-times" style="font-size:2rem;margin-bottom:.5rem;display:block"></i>
        <p>Belum ada jadwal untuk rute ini</p>
      </div>
      <?php endif; ?>
    </div>

    <div style="margin-top:2rem;text-align:center" class="animate-on-scroll">
      <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-lg"><i class="fab fa-whatsapp"></i> Pesan Tiket Rute Ini</a>
      <a href="<?= base_url('harga'); ?>" class="btn btn-blue" style="margin-left:.5rem"><i class="fas fa-tags"></i> Lihat Harga</a>
    </div>
  </div>
</section>
