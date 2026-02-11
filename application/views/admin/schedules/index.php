<h1 class="admin-page-title">Kelola Jadwal</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Jadwal</h3>
    <a href="<?= base_url('admin/schedules/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Rute</th><th>Kelas</th><th>Jam</th><th>Catatan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($schedules as $s): ?>
    <tr>
      <td><?= $s->origin; ?> → <?= $s->destination; ?></td>
      <td><?= $s->class_name ?: '-'; ?></td>
      <td><strong><?= date('H:i', strtotime($s->depart_time)); ?></strong></td>
      <td><?= $s->notes ?: '-'; ?></td>
      <td><?= $s->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/schedules/edit/' . $s->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/schedules/delete/' . $s->id); ?>', 'Jadwal')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
