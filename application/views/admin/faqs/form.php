<h1 class="admin-page-title"><?= isset($faq) ? 'Edit FAQ' : 'Tambah FAQ'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group"><label class="form-label">Pertanyaan</label><input type="text" name="question" class="form-control" value="<?= isset($faq) ? $faq->question : ''; ?>" required></div>
  <div class="form-group"><label class="form-label">Jawaban</label><textarea name="answer" class="form-control" rows="5" required><?= isset($faq) ? $faq->answer : ''; ?></textarea></div>
  <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem">
    <div class="form-group"><label class="form-label">Kategori</label><select name="category" class="form-control"><option value="umum" <?= isset($faq) && $faq->category == 'umum' ? 'selected' : ''; ?>>Umum</option><option value="tiket" <?= isset($faq) && $faq->category == 'tiket' ? 'selected' : ''; ?>>Tiket</option><option value="paket" <?= isset($faq) && $faq->category == 'paket' ? 'selected' : ''; ?>>Paket</option></select></div>
    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="<?= isset($faq) ? $faq->sort_order : 0; ?>"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($faq) || $faq->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  </div>
  <div style="display:flex;gap:1rem;margin-top:1rem">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/faqs'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
