<h1 class="admin-page-title">Kelola Harga</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Harga</h3>
    <a href="<?= base_url('admin/pricing/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Rute</th><th>Kelas</th><th>Harga</th><th>Promo</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($pricings as $p): ?>
    <tr>
      <td><?= $p->origin; ?> → <?= $p->destination; ?></td>
      <td><?= $p->class_name; ?></td>
      <td><?= format_price($p->price); ?></td>
      <td><?= $p->promo_price ? format_price($p->promo_price) . ' <span class="badge badge-danger">Promo</span>' : '-'; ?></td>
      <td><?= $p->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/pricing/edit/' . $p->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/pricing/delete/' . $p->id); ?>', 'Harga')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>