<h1 class="admin-page-title">Kelola FAQ</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar FAQ</h3>
    <a href="<?= base_url('admin/faqs/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Pertanyaan</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($faqs as $f): ?>
    <tr>
      <td><?= character_limiter($f->question, 60); ?></td>
      <td><span class="badge badge-warning"><?= $f->category ?: 'umum'; ?></span></td>
      <td><?= $f->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/faqs/edit/' . $f->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/faqs/delete/' . $f->id); ?>', 'FAQ')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>