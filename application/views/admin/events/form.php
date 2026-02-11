<h1 class="admin-page-title"><?= isset($event) ? 'Edit Event' : 'Tambah Event'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group"><label class="form-label">Judul Event</label><input type="text" name="title" class="form-control" value="<?= isset($event) ? $event->title : ''; ?>" required></div>
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Tanggal Mulai</label><input type="date" name="date_start" class="form-control" value="<?= isset($event) ? $event->date_start : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Tanggal Selesai</label><input type="date" name="date_end" class="form-control" value="<?= isset($event) ? $event->date_end : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="<?= isset($event) ? $event->location : ''; ?>" placeholder="Kota Palu"></div>
  </div>
  <div class="form-group"><label class="form-label">Konten / Deskripsi</label><textarea name="content" class="form-control" rows="6" required><?= isset($event) ? $event->content : ''; ?></textarea></div>
  <div class="form-group">
    <label class="form-label">Cover Image</label>
    <?php if (isset($event) && $event->cover_image): ?><div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $event->cover_image); ?>" style="width:150px;border-radius:var(--radius-md)"></div><?php endif; ?>
    <input type="file" name="cover_image" class="form-control" accept="image/*"><p class="form-hint">Max 2MB</p>
  </div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_published" value="1" <?= !isset($event) || $event->is_published ? 'checked' : ''; ?>> Publish</label></div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/events'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
