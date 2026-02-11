<h1 class="admin-page-title">Analytics</h1>
<p class="admin-page-subtitle">Statistik pengunjung, klik WhatsApp, dan performa konten</p>

<!-- Page View Stats -->
<div class="stats-grid">
  <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5)"><i class="fas fa-eye"></i></div><div class="stat-info"><div class="stat-number"><?= $pv_total; ?></div><div class="stat-label">Total Views</div></div></div>
  <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)"><i class="fas fa-chart-line"></i></div><div class="stat-info"><div class="stat-number"><?= $pv_today; ?></div><div class="stat-label">Views Hari Ini</div></div></div>
  <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#06b6d4,#0891b2)"><i class="fas fa-users"></i></div><div class="stat-info"><div class="stat-number"><?= $pv_unique_total; ?></div><div class="stat-label">Unique Visitors</div></div></div>
  <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#14b8a6,#0d9488)"><i class="fas fa-user-clock"></i></div><div class="stat-info"><div class="stat-number"><?= $pv_unique_today; ?></div><div class="stat-label">Unique Hari Ini</div></div></div>
</div>

<!-- WA + Post Stats row -->
<div class="stats-grid" style="margin-top:1rem">
  <div class="stat-card"><div class="stat-icon" style="background:var(--gradient-blue)"><i class="fab fa-whatsapp"></i></div><div class="stat-info"><div class="stat-number"><?= $wa_total; ?></div><div class="stat-label">Total Klik WA</div></div></div>
  <div class="stat-card"><div class="stat-icon" style="background:var(--gradient-yellow)"><i class="fas fa-chart-line"></i></div><div class="stat-info"><div class="stat-number"><?= $wa_today; ?></div><div class="stat-label">Klik WA Hari Ini</div></div></div>
  <div class="stat-card"><div class="stat-icon" style="background:linear-gradient(135deg,#10b981,#059669)"><i class="fas fa-newspaper"></i></div><div class="stat-info"><div class="stat-number"><?= $total_post_views; ?></div><div class="stat-label">Total Views Berita</div></div></div>
</div>

<!-- Page Views Chart -->
<div class="admin-card" style="margin-top:1.5rem">
  <div class="admin-card-header"><h3><i class="fas fa-chart-area"></i> Pengunjung (30 Hari Terakhir)</h3></div>
  <div style="padding:1.5rem"><canvas id="pvChart" height="250"></canvas></div>
</div>

<!-- WA Clicks Chart -->
<div class="admin-card" style="margin-top:1.5rem">
  <div class="admin-card-header"><h3><i class="fas fa-chart-bar"></i> Klik WA (30 Hari Terakhir)</h3></div>
  <div style="padding:1.5rem"><canvas id="waChart" height="200"></canvas></div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:1.5rem">
  <!-- Views per Page -->
  <div class="admin-card">
    <div class="admin-card-header"><h3><i class="fas fa-file-alt"></i> Views per Halaman</h3></div>
    <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Halaman</th><th style="text-align:right">Views</th></tr></thead>
      <tbody>
      <?php if (!empty($pv_by_page)): foreach ($pv_by_page as $p): ?>
      <tr>
        <td><code>/<?= htmlspecialchars($p->page); ?></code></td>
        <td style="text-align:right"><strong><?= number_format($p->total); ?></strong></td>
      </tr>
      <?php endforeach; else: ?><tr><td colspan="2" style="text-align:center;color:var(--gray-400)">Belum ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>
  <!-- WA Clicks per Page -->
  <div class="admin-card">
    <div class="admin-card-header"><h3><i class="fab fa-whatsapp"></i> Klik WA per Halaman</h3>
      <a href="<?= base_url('admin/export/csv/wa_clicks'); ?>" class="btn-add" style="font-size:.8rem"><i class="fas fa-download"></i> Export CSV</a></div>
    <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Halaman</th><th style="text-align:right">Total</th></tr></thead>
      <tbody>
      <?php if (!empty($by_page)): foreach ($by_page as $p): ?>
      <tr><td><?= $p->source_page; ?></td><td style="text-align:right"><strong><?= $p->total; ?></strong></td></tr>
      <?php endforeach; else: ?><tr><td colspan="2" style="text-align:center;color:var(--gray-400)">Belum ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:1.5rem">
  <!-- Top Referrers -->
  <div class="admin-card">
    <div class="admin-card-header"><h3><i class="fas fa-external-link-alt"></i> Top Referrers</h3></div>
    <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>Sumber</th><th style="text-align:right">Views</th></tr></thead>
      <tbody>
      <?php if (!empty($top_referrers)): foreach ($top_referrers as $r): ?>
      <tr>
        <td style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= htmlspecialchars($r->referrer); ?>"><?= htmlspecialchars($r->referrer); ?></td>
        <td style="text-align:right"><strong><?= number_format($r->total); ?></strong></td>
      </tr>
      <?php endforeach; else: ?><tr><td colspan="2" style="text-align:center;color:var(--gray-400)">Belum ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>
  <!-- WA Clicks per Agent -->
  <div class="admin-card">
    <div class="admin-card-header"><h3><i class="fas fa-user-tie"></i> Klik per Agen</h3></div>
    <div class="table-responsive">
    <table class="admin-table">
      <thead><tr><th>No. WA Agen</th><th style="text-align:right">Total</th></tr></thead>
      <tbody>
      <?php if (!empty($by_agent)): foreach ($by_agent as $a): ?>
      <tr><td><?= $a->agent_wa ?: 'Umum'; ?></td><td style="text-align:right"><strong><?= $a->total; ?></strong></td></tr>
      <?php endforeach; else: ?><tr><td colspan="2" style="text-align:center;color:var(--gray-400)">Belum ada data</td></tr><?php endif; ?>
      </tbody>
    </table>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
// Page Views Chart
var pvCtx = document.getElementById('pvChart');
if (pvCtx) {
  var pvLabels = <?= json_encode(array_map(function($d){ return date('d M', strtotime($d->date)); }, $daily_pv)); ?>;
  var pvData = <?= json_encode(array_map(function($d){ return (int)$d->total; }, $daily_pv)); ?>;
  var pvUnique = <?= json_encode(array_map(function($d){ return (int)$d->unique_visitors; }, $daily_pv)); ?>;
  new Chart(pvCtx, {
    type: 'line',
    data: {
      labels: pvLabels,
      datasets: [{
        label: 'Total Views',
        data: pvData,
        borderColor: '#6366f1',
        backgroundColor: 'rgba(99,102,241,0.1)',
        fill: true,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 3
      },{
        label: 'Unique Visitors',
        data: pvUnique,
        borderColor: '#06b6d4',
        backgroundColor: 'rgba(6,182,212,0.08)',
        fill: true,
        tension: 0.3,
        borderWidth: 2,
        pointRadius: 3
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'top' } },
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
  });
}

// WA Clicks Chart
var waCtx = document.getElementById('waChart');
if (waCtx) {
  var waLabels = <?= json_encode(array_map(function($d){ return date('d M', strtotime($d->date)); }, $daily_wa)); ?>;
  var waData = <?= json_encode(array_map(function($d){ return (int)$d->total; }, $daily_wa)); ?>;
  new Chart(waCtx, {
    type: 'bar',
    data: {
      labels: waLabels,
      datasets: [{
        label: 'Klik WA',
        data: waData,
        backgroundColor: 'rgba(37,99,235,0.7)',
        borderColor: 'rgba(37,99,235,1)',
        borderWidth: 1,
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
  });
}
</script>
