<h1 class="admin-page-title"><?= isset($schedule) ? 'Edit Jadwal' : 'Tambah Jadwal'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="admin-grid-2">
    <div class="form-group"><label class="form-label">Rute</label>
      <select name="route_id" class="form-control" required>
        <option value="">-- Pilih --</option>
        <?php foreach ($routes as $r): ?>
        <option value="<?= $r->id; ?>" <?= isset($schedule) && $schedule->route_id == $r->id ? 'selected' : ''; ?>><?= $r->origin; ?> → <?= $r->destination; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Kelas</label>
      <select name="class_id" class="form-control">
        <option value="">-- Semua Kelas --</option>
        <?php foreach ($classes as $c): ?>
        <option value="<?= $c->id; ?>" <?= isset($schedule) && $schedule->class_id == $c->id ? 'selected' : ''; ?>><?= $c->name; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="admin-grid-2">
    <div class="form-group"><label class="form-label">Jam Berangkat</label><input type="time" name="depart_time" class="form-control" value="<?= isset($schedule) ? $schedule->depart_time : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Catatan</label><input type="text" name="notes" class="form-control" value="<?= isset($schedule) ? $schedule->notes : ''; ?>" placeholder="Opsional"></div>
  </div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($schedule) || $schedule->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/schedules'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
