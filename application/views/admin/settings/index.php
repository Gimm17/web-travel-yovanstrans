<h1 class="admin-page-title">Pengaturan</h1>
<p class="admin-page-subtitle">Pengaturan umum website</p>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <?php if (empty($settings)): ?>
  <p style="color:var(--gray-400)">Belum ada pengaturan</p>
  <?php else: ?>
  <?php foreach ($settings as $s): ?>
  <div class="form-group">
    <label class="form-label"><?= ucwords(str_replace('_', ' ', $s->key_name)); ?></label>
    <input type="hidden" name="key_name[]" value="<?= $s->key_name; ?>">
    <?php if (strlen($s->value) > 100): ?>
    <textarea name="value[]" class="form-control" rows="3"><?= $s->value; ?></textarea>
    <?php else: ?>
    <input type="text" name="value[]" class="form-control" value="<?= $s->value; ?>">
    <?php endif; ?>
    <p class="form-hint"><?= $s->group_name ?: 'general'; ?></p>
  </div>
  <?php endforeach; ?>
  <?php endif; ?>
  <button type="submit" class="btn-add" style="margin-top:1rem"><i class="fas fa-save"></i> Simpan Pengaturan</button>
</form>
</div></div>
