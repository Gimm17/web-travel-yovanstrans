<h1 class="admin-page-title">Berita & Artikel</h1>
<p class="admin-page-subtitle">Kelola berita dan artikel website</p>

<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Artikel (<?= count($posts); ?>)</h3>
    <a href="<?= base_url('admin/posts/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah Artikel</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Cover</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Views</th><th>Tanggal</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($posts)): ?>
    <tr><td colspan="7" style="text-align:center;color:var(--gray-400)">Belum ada artikel</td></tr>
    <?php else: ?>
    <?php foreach ($posts as $p): ?>
    <tr>
      <td>
        <?php if ($p->cover_image): ?>
        <img src="<?= base_url('assets/uploads/' . $p->cover_image); ?>" alt="Cover">
        <?php else: ?>
        <div style="width:50px;height:50px;background:var(--gray-100);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center"><i class="fas fa-image" style="color:var(--gray-400)"></i></div>
        <?php endif; ?>
      </td>
      <td><strong><?= $p->title; ?></strong></td>
      <td><span class="badge badge-warning"><?= $p->category ?: '-'; ?></span></td>
      <td><?= $p->is_published ? '<span class="badge badge-success">Publish</span>' : '<span class="badge badge-danger">Draft</span>'; ?></td>
      <td><?= $p->views; ?></td>
      <td><?= date('d M Y', strtotime($p->created_at)); ?></td>
      <td>
        <div class="btn-actions">
          <a href="<?= base_url('admin/posts/edit/' . $p->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
          <button onclick="confirmDelete('<?= base_url('admin/posts/delete/' . $p->id); ?>', 'Artikel')" class="btn-delete"><i class="fas fa-trash"></i></button>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>
