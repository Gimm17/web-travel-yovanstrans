<h1 class="admin-page-title"><?= isset($pricing) ? 'Edit Harga' : 'Tambah Harga'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group">
      <label class="form-label">Rute</label>
      <select name="route_id" class="form-control" required>
        <option value="">-- Pilih Rute --</option>
        <?php foreach ($routes as $r): ?>
        <option value="<?= $r->id; ?>" <?= isset($pricing) && $pricing->route_id == $r->id ? 'selected' : ''; ?>><?= $r->origin; ?> → <?= $r->destination; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label class="form-label">Kelas</label>
      <select name="class_id" class="form-control" required>
        <option value="">-- Pilih Kelas --</option>
        <?php foreach ($classes as $c): ?>
        <option value="<?= $c->id; ?>" <?= isset($pricing) && $pricing->class_id == $c->id ? 'selected' : ''; ?>><?= $c->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group"><label class="form-label">Harga Normal (Rp)</label><input type="number" name="price" class="form-control" value="<?= isset($pricing) ? $pricing->price : ''; ?>" required></div>
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Harga Promo (Rp)</label><input type="number" name="promo_price" class="form-control" value="<?= isset($pricing) ? $pricing->promo_price : ''; ?>"></div>
    <div class="form-group"><label class="form-label">Mulai Promo</label><input type="date" name="promo_start" class="form-control" value="<?= isset($pricing) ? $pricing->promo_start : ''; ?>"></div>
    <div class="form-group"><label class="form-label">Akhir Promo</label><input type="date" name="promo_end" class="form-control" value="<?= isset($pricing) ? $pricing->promo_end : ''; ?>"></div>
  </div>
  <div class="form-group"><label class="form-label">Label Promo</label><input type="text" name="promo_label" class="form-control" value="<?= isset($pricing) ? $pricing->promo_label : ''; ?>" placeholder="Mis: Diskon Tahun Baru"></div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($pricing) || $pricing->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/pricing'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
