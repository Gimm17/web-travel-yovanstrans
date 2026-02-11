<h1 class="admin-page-title"><?= isset($branch) ? 'Edit Agen' : 'Tambah Agen Baru'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group">
    <label class="form-label">Nama Agen / Cabang</label>
    <input type="text" name="name" class="form-control" value="<?= isset($branch) ? $branch->name : ''; ?>" placeholder="Contoh: Agen Palu Pusat" required>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group">
      <label class="form-label">Nomor WhatsApp</label>
      <input type="text" name="wa_number" class="form-control" value="<?= isset($branch) ? $branch->wa_number : ''; ?>" placeholder="6282349085255" required>
      <div class="form-hint">Format internasional tanpa + (contoh: 6282349085255)</div>
    </div>
    <div class="form-group">
      <label class="form-label">Nomor Telepon</label>
      <input type="text" name="phone" class="form-control" value="<?= isset($branch) ? $branch->phone : ''; ?>" placeholder="0823-4908-5255">
    </div>
  </div>
  <div class="form-group">
    <label class="form-label">Alamat</label>
    <textarea name="address" class="form-control" rows="2" placeholder="Alamat lengkap agen"><?= isset($branch) ? $branch->address : ''; ?></textarea>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group">
      <label class="form-label">Jam Operasional</label>
      <input type="text" name="operational_hours" class="form-control" value="<?= isset($branch) ? $branch->operational_hours : '06:00 - 21:00 WITA'; ?>" placeholder="06:00 - 21:00 WITA">
    </div>
    <div class="form-group">
      <label class="form-label">Link Google Maps</label>
      <input type="url" name="maps_url" class="form-control" value="<?= isset($branch) ? $branch->maps_url : ''; ?>" placeholder="https://maps.google.com/...">
    </div>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group">
      <label class="form-label">Urutan Tampil</label>
      <input type="number" name="sort_order" class="form-control" value="<?= isset($branch) ? $branch->sort_order : 0; ?>">
    </div>
    <div class="form-group">
      <label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer">
        <input type="checkbox" name="is_active" value="1" <?= !isset($branch) || $branch->is_active ? 'checked' : ''; ?>> Aktif
      </label>
    </div>
  </div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/branches'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
