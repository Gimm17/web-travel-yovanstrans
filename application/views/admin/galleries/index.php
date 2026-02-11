<h1 class="admin-page-title">Kelola Galeri</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Album</h3>
    <a href="<?= base_url('admin/galleries/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah Album</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Cover</th><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($albums)): ?><tr><td colspan="4" style="text-align:center;color:var(--gray-400)">Belum ada album</td></tr>
    <?php else: foreach ($albums as $a): ?>
    <tr>
      <td><?= $a->cover_image ? '<img src="' . base_url('assets/uploads/' . $a->cover_image) . '">' : '-'; ?></td>
      <td><strong><?= $a->title; ?></strong></td>
      <td><?= $a->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/galleries/edit/' . $a->id); ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit & Foto</a>
        <button onclick="confirmDelete('<?= base_url('admin/galleries/delete/' . $a->id); ?>', 'Album')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
</div>
