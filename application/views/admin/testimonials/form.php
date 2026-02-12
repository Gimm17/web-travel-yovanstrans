<h1 class="admin-page-title"><?= isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="<?= isset($testimonial) ? $testimonial->name : ''; ?>" required></div>
  <div class="form-group"><label class="form-label">Rute</label><input type="text" name="route" class="form-control" value="<?= isset($testimonial) ? $testimonial->route : ''; ?>" placeholder="Palu - Poso"></div>
  <div class="form-group"><label class="form-label">Isi Testimoni</label><textarea name="content" class="form-control" rows="4" required><?= isset($testimonial) ? $testimonial->content : ''; ?></textarea></div>
  <div class="admin-grid-3">
    <div class="form-group"><label class="form-label">Rating (1-5)</label><select name="rating" class="form-control"><?php for($i=5;$i>=1;$i--): ?><option value="<?= $i; ?>" <?= isset($testimonial) && $testimonial->rating == $i ? 'selected' : ''; ?>><?= str_repeat('★', $i); ?></option><?php endfor; ?></select></div>
    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="<?= isset($testimonial) ? $testimonial->sort_order : 0; ?>"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($testimonial) || $testimonial->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  </div>
  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/testimonials'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
