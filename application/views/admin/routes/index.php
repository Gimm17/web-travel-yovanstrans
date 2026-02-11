<h1 class="admin-page-title">Kelola Rute</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Rute (<?= count($routes); ?>)</h3>
    <a href="<?= base_url('admin/routes/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Asal</th><th>Tujuan</th><th>Jarak</th><th>Durasi</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($routes as $r): ?>
    <tr>
      <td><?= $r->origin; ?></td>
      <td><?= $r->destination; ?></td>
      <td><?= $r->distance_km; ?> km</td>
      <td>~<?= $r->duration_hours; ?> jam</td>
      <td><?= $r->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/routes/edit/' . $r->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/routes/delete/' . $r->id); ?>', 'Rute')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
