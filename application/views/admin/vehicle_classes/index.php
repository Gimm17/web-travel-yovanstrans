<h1 class="admin-page-title">Kelola Armada & Kelas</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Kelas Armada (<?= count($classes); ?>)</h3>
    <a href="<?= base_url('admin/vehicle_classes/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah Kelas</a>
  </div>
  <table class="admin-table">
    <thead><tr><th>Cover</th><th>Nama Kelas</th><th>Kursi</th><th>Highlight</th><th>Fitur</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($classes as $c): ?>
    <tr>
      <td>
        <?php if ($c->cover_image): ?>
        <img src="<?= base_url('assets/uploads/' . $c->cover_image); ?>" style="width:60px;height:40px;object-fit:cover;border-radius:4px">
        <?php else: ?>
        <div style="width:60px;height:40px;background:#eee;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#999"><i class="fas fa-bus"></i></div>
        <?php endif; ?>
      </td>
      <td><strong><?= $c->name; ?></strong></td>
      <td><?= $c->seat_count; ?></td>
      <td><?= $c->highlight; ?></td>
      <td>
        <?php 
          $feats = json_decode($c->features, true);
          echo $feats ? count($feats) . ' fitur' : '-';
        ?>
      </td>
      <td><?= $c->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>'; ?></td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/vehicle_classes/edit/' . $c->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/vehicle_classes/delete/' . $c->id); ?>', 'Kelas Armada')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
