<h1 class="admin-page-title">Dashboard</h1>
<p class="admin-page-subtitle">Selamat datang, <?= $this->session->userdata('admin_name'); ?>!</p>

<!-- Stats -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-card-icon blue"><i class="fas fa-route"></i></div>
    <div>
      <div class="stat-card-number"><?= $total_routes; ?></div>
      <div class="stat-card-label">Total Rute</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon yellow"><i class="fas fa-newspaper"></i></div>
    <div>
      <div class="stat-card-number"><?= $total_posts; ?></div>
      <div class="stat-card-label">Artikel</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon green"><i class="fas fa-map-marker-alt"></i></div>
    <div>
      <div class="stat-card-number"><?= $total_branches; ?></div>
      <div class="stat-card-label">Agen</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon red"><i class="fab fa-whatsapp"></i></div>
    <div>
      <div class="stat-card-number"><?= $wa_total; ?></div>
      <div class="stat-card-label">Total Klik WA</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon" style="background:linear-gradient(135deg,#10b981,#059669)"><i class="fas fa-chart-line"></i></div>
    <div>
      <div class="stat-card-number"><?= $wa_today; ?></div>
      <div class="stat-card-label">Klik WA Hari Ini</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon" style="background:linear-gradient(135deg,#6366f1,#4f46e5)"><i class="fas fa-eye"></i></div>
    <div>
      <div class="stat-card-number"><?= $pv_total; ?></div>
      <div class="stat-card-label">Total Views</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed)"><i class="fas fa-chart-area"></i></div>
    <div>
      <div class="stat-card-number"><?= $pv_today; ?></div>
      <div class="stat-card-label">Views Hari Ini</div>
    </div>
  </div>
</div>

<!-- Recent Posts -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Artikel Terbaru</h3>
    <a href="<?= base_url('admin/posts'); ?>" class="btn-add"><i class="fas fa-newspaper"></i> Kelola</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Judul</th><th>Kategori</th><th>Views</th><th>Tanggal</th></tr></thead>
    <tbody>
    <?php if (empty($recent_posts)): ?>
    <tr><td colspan="4" style="text-align:center;color:var(--gray-400)">Belum ada artikel</td></tr>
    <?php else: ?>
    <?php foreach ($recent_posts as $p): ?>
    <tr>
      <td><strong><?= $p->title; ?></strong></td>
      <td><span class="badge badge-warning"><?= $p->category ?: '-'; ?></span></td>
      <td><?= $p->views; ?></td>
      <td><?= date('d M Y', strtotime($p->published_at ?: $p->created_at)); ?></td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
  </div>
</div>

<!-- Quick Links -->
<div class="stats-grid">
  <a href="<?= base_url('admin/posts/create'); ?>" class="stat-card" style="text-decoration:none;color:inherit;cursor:pointer">
    <div class="stat-card-icon yellow"><i class="fas fa-plus"></i></div>
    <div><div class="stat-card-label" style="font-weight:700;color:var(--gray-800)">Artikel Baru</div></div>
  </a>
  <a href="<?= base_url('admin/analytics'); ?>" class="stat-card" style="text-decoration:none;color:inherit;cursor:pointer">
    <div class="stat-card-icon red"><i class="fas fa-chart-pie"></i></div>
    <div><div class="stat-card-label" style="font-weight:700;color:var(--gray-800)">Analytics</div></div>
  </a>
  <a href="<?= base_url('admin/galleries'); ?>" class="stat-card" style="text-decoration:none;color:inherit;cursor:pointer">
    <div class="stat-card-icon blue"><i class="fas fa-images"></i></div>
    <div><div class="stat-card-label" style="font-weight:700;color:var(--gray-800)">Kelola Galeri</div></div>
  </a>
  <a href="<?= base_url(); ?>" target="_blank" class="stat-card" style="text-decoration:none;color:inherit;cursor:pointer">
    <div class="stat-card-icon green"><i class="fas fa-external-link-alt"></i></div>
    <div><div class="stat-card-label" style="font-weight:700;color:var(--gray-800)">Lihat Website</div></div>
  </a>
</div>
