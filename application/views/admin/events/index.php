<h1 class="admin-page-title">Kelola Event</h1>
<div class="admin-card">
  <div class="admin-card-header">
    <h3>Daftar Event (<?= count($events); ?>)</h3>
    <a href="<?= base_url('admin/events/create'); ?>" class="btn-add"><i class="fas fa-plus"></i> Tambah</a>
  </div>
  <div class="table-responsive">
  <table class="admin-table">
    <thead><tr><th>Cover</th><th>Judul</th><th>Tanggal</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (empty($events)): ?><tr><td colspan="6" style="text-align:center;color:var(--gray-400)">Belum ada event</td></tr>
    <?php else: foreach ($events as $e): ?>
    <tr>
      <td><?= $e->cover_image ? '<img src="' . base_url('assets/uploads/' . $e->cover_image) . '">' : '-'; ?></td>
      <td><strong><?= $e->title; ?></strong></td>
      <td style="white-space:nowrap"><?= date('d M', strtotime($e->date_start)); ?> — <?= date('d M Y', strtotime($e->date_end)); ?></td>
      <td><?= $e->location ?: '-'; ?></td>
      <td>
        <?php if ($e->is_published && strtotime($e->date_end) >= time()): ?>
          <span class="badge badge-success">Aktif</span>
        <?php elseif ($e->is_published): ?>
          <span class="badge badge-warning">Selesai</span>
        <?php else: ?>
          <span class="badge badge-danger">Draft</span>
        <?php endif; ?>
      </td>
      <td><div class="btn-actions">
        <a href="<?= base_url('admin/events/edit/' . $e->id); ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
        <button onclick="confirmDelete('<?= base_url('admin/events/delete/' . $e->id); ?>', 'Event')" class="btn-delete"><i class="fas fa-trash"></i></button>
      </div></td>
    </tr>
    <?php endforeach; endif; ?>
    </tbody>
  </table>
  </div>
</div>