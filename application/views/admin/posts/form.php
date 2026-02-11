<h1 class="admin-page-title"><?= isset($post) ? 'Edit Artikel' : 'Tambah Artikel'; ?></h1>
<p class="admin-page-subtitle"><?= isset($post) ? 'Perbarui data artikel' : 'Buat artikel baru'; ?></p>

<div class="admin-card">
  <div class="admin-card-body">
    <form method="post" action="" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
      <div class="form-group">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" value="<?= isset($post) ? $post->title : ''; ?>" required>
      </div>
      <div class="form-group">
        <label class="form-label">Kategori</label>
        <select name="category" class="form-control">
          <option value="">-- Pilih Kategori --</option>
          <option value="berita" <?= isset($post) && $post->category == 'berita' ? 'selected' : ''; ?>>Berita</option>
          <option value="promo" <?= isset($post) && $post->category == 'promo' ? 'selected' : ''; ?>>Promo</option>
          <option value="event" <?= isset($post) && $post->category == 'event' ? 'selected' : ''; ?>>Event</option>
          <option value="tips" <?= isset($post) && $post->category == 'tips' ? 'selected' : ''; ?>>Tips</option>
          <option value="info" <?= isset($post) && $post->category == 'info' ? 'selected' : ''; ?>>Info</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Konten</label>
        <textarea name="content" class="form-control" rows="12" required><?= isset($post) ? $post->content : ''; ?></textarea>
      </div>
      <div class="form-group">
        <label class="form-label">Cover Image</label>
        <?php if (isset($post) && $post->cover_image): ?>
        <div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $post->cover_image); ?>" style="width:150px;border-radius:var(--radius-md)"></div>
        <?php endif; ?>
        <input type="file" name="cover_image" class="form-control" accept="image/*">
        <p class="form-hint">Max 2MB. Format: JPG, PNG, WebP</p>
      </div>
      <div style="display:flex;gap:1rem">
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
            <input type="checkbox" name="is_published" value="1" <?= isset($post) && $post->is_published ? 'checked' : ''; ?>>
            <span class="form-label" style="margin:0">Publish</span>
          </label>
        </div>
        <div class="form-group">
          <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
            <input type="checkbox" name="is_featured" value="1" <?= isset($post) && $post->is_featured ? 'checked' : ''; ?>>
            <span class="form-label" style="margin:0">Featured</span>
          </label>
        </div>
      </div>
      <div style="display:flex;gap:1rem;margin-top:1rem">
        <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
        <a href="<?= base_url('admin/posts'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</div>
