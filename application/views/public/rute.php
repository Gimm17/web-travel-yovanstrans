<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Rute & Jadwal</h1>
    <p class="page-header-subtitle">Jadwal keberangkatan untuk semua rute</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Rute & Jadwal</span></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php if (empty($routes)): ?>
    <div class="empty-state"><i class="fas fa-route"></i><p>Belum ada data rute</p></div>
    <?php else: ?>
    <?php foreach ($routes as $route): ?>
    <div class="route-card animate-on-scroll" style="margin-bottom:1.5rem">
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
      <?php if (!empty($route->schedules)): ?>
      <table class="schedule-table" style="margin-top:1rem">
        <thead><tr><th>Jam Berangkat</th><th>Kelas</th><th>Keterangan</th></tr></thead>
        <tbody>
        <?php foreach ($route->schedules as $s): ?>
        <tr>
          <td data-label="Jam"><?= date('H:i', strtotime($s->depart_time)); ?> WITA</td>
          <td data-label="Kelas"><?= $s->class_name ?: '-'; ?></td>
          <td data-label="Ket"><?= $s->notes ?: '-'; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
      <div style="margin-top:1rem">
        <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-sm"><i class="fab fa-whatsapp"></i> Pesan Rute Ini</a>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>
