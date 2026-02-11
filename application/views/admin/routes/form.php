<h1 class="admin-page-title"><?= isset($route) ? 'Edit Rute' : 'Tambah Rute'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Asal</label><input type="text" name="origin" class="form-control" value="<?= isset($route) ? $route->origin : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Tujuan</label><input type="text" name="destination" class="form-control" value="<?= isset($route) ? $route->destination : ''; ?>" required></div>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Jarak (km)</label><input type="number" step="0.1" name="distance_km" class="form-control" value="<?= isset($route) ? $route->distance_km : ''; ?>"></div>
    <div class="form-group"><label class="form-label">Durasi (jam)</label><input type="number" step="0.1" name="duration_hours" class="form-control" value="<?= isset($route) ? $route->duration_hours : ''; ?>"></div>
  </div>
  <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3"><?= isset($route) ? $route->description : ''; ?></textarea></div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="<?= isset($route) ? $route->sort_order : 0; ?>"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($route) || $route->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  </div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/routes'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
