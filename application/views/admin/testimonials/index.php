<h1 class="admin-page-title">Kelola Testimoni</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Testimoni</h3>
    <a href="<?= base_url('admin/testimonials/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Nama</th><th>Rute</th><th>Rating</th><th>Sumber</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($testimonials as $t): ?>
    <tr<?= (!$t->is_active && !empty($t->source) && $t->source === 'user') ? ' style="background:#FFFBEB"' : ''; ?>>
      <td><strong><?= $t->name; ?></strong></td>
      <td><?= $t->route; ?></td>
      <td style="color:#F59E0B"><?= str_repeat('★', $t->rating); ?><?= str_repeat('☆', 5 - $t->rating); ?></td>
      <td>
        <?php if (!empty($t->source) && $t->source === 'user'): ?>
          <span class="badge" style="background:#DBEAFE;color:#1E40AF">User</span>
        <?php else: ?>
          <span class="badge" style="background:#E5E7EB;color:#374151">Admin</span>
        <?php endif; ?>
      </td>
      <td>
        <?php if ($t->is_active): ?>
          <span class="badge badge-success">Aktif</span>
        <?php elseif (!empty($t->source) && $t->source === 'user'): ?>
          <span class="badge" style="background:#FEF3C7;color:#92400E">Menunggu</span>
        <?php else: ?>
          <span class="badge badge-danger">Nonaktif</span>
        <?php endif; ?>
      </td>
      <td><div class="btn-actions">
        <?php if (!$t->is_active && !empty($t->source) && $t->source === 'user'): ?>
          <a href="<?= base_url('admin/testimonials/approve/' . $t->id); ?>" class="btn-edit" title="Setujui" style="background:#059669;color:#fff"><i class="fas fa-check"></i></a>
        <?php endif; ?>
        <a href="<?= base_url('admin/testimonials/edit/' . $t->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/testimonials/delete/' . $t->id); ?>', 'Testimoni')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
