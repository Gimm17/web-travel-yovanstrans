<h1 class="admin-page-title">Kelola User</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar User (<?= count($users); ?>)</h3>
    <a href="<?= base_url('admin/users/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td><strong><?= $u->name; ?></strong></td>
      <td><?= $u->email; ?></td>
      <td><span class="badge <?= $u->role === 'superadmin' ? 'badge-danger' : ($u->role === 'editor' ? 'badge-warning' : 'badge-info'); ?>"><?= ucfirst($u->role); ?></span></td>
      <td><?= $u->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/users/edit/' . $u->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/users/delete/' . $u->id); ?>', 'User')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
</div>