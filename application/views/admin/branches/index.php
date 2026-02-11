<h1 class="admin-page-title">Kelola Agen</h1>
<p class="admin-page-subtitle">Kelola daftar agen, nomor WhatsApp, dan lokasi kantor</p>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Agen (<?= count($branches); ?>)</h3>
    <a href="<?= base_url('admin/branches/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah Agen</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Nama Agen</th><th>No. WhatsApp</th><th>Telepon</th><th>Jam Operasional</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($branches as $b): ?>
    <tr>
      <td>
        <strong><?= $b->name; ?></strong>
        <div style="font-size:.8rem;color:var(--gray-500)"><?= $b->address; ?></div>
      </td>
      <td><i class="fab fa-whatsapp" style="color:#25D366"></i> <?= $b->wa_number; ?></td>
      <td><?= $b->phone; ?></td>
      <td><?= $b->operational_hours; ?></td>
      <td><?= $b->sort_order; ?></td>
      <td><?= $b->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/branches/edit/' . $b->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/branches/delete/' . $b->id); ?>', 'Agen')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
