<h1 class="admin-page-title"><?= isset($user) ? 'Edit User' : 'Tambah User'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Nama</label><input type="text" name="name" class="form-control" value="<?= isset($user) ? $user->name : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= isset($user) ? $user->email : ''; ?>" required></div>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Password <?= isset($user) ? '(kosongkan jika tidak diubah)' : ''; ?></label><input type="password" name="password" class="form-control" <?= !isset($user) ? 'required' : ''; ?> minlength="6"></div>
    <div class="form-group"><label class="form-label">Role</label>
      <select name="role" class="form-control" required>
        <option value="cs" <?= isset($user) && $user->role == 'cs' ? 'selected' : ''; ?>>CS (Read Only)</option>
        <option value="editor" <?= isset($user) && $user->role == 'editor' ? 'selected' : ''; ?>>Editor (Konten)</option>
        <option value="superadmin" <?= isset($user) && $user->role == 'superadmin' ? 'selected' : ''; ?>>SuperAdmin (Semua)</option>
      </select>
    </div>
  </div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($user) || $user->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/users'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
