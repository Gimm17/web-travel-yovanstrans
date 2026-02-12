<h1 class="admin-page-title"><?= isset($album) ? 'Edit Album: ' . $album->title : 'Tambah Album'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group"><label class="form-label">Judul Album</label><input type="text" name="title" class="form-control" value="<?= isset($album) ? $album->title : ''; ?>" required></div>
  <div class="form-group"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="3"><?= isset($album) ? $album->description : ''; ?></textarea></div>
  <div class="form-group">
    <label class="form-label">Cover Image</label>
    <?php if (isset($album) && $album->cover_image): ?><div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $album->cover_image); ?>" style="width:150px;border-radius:var(--radius-md)"></div><?php endif; ?>
    <input type="file" name="cover_image" class="form-control" accept="image/*">
  </div>
  <div class="admin-grid-2">
    <div class="form-group"><label class="form-label">Urutan</label><input type="number" name="sort_order" class="form-control" value="<?= isset($album) ? $album->sort_order : 0; ?>"></div>
    <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($album) || $album->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  </div>
  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/galleries'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>

<?php if (isset($album)): ?>
<div class="admin-card" style="margin-top:1.5rem">
  <div class="admin-card-header"><h3>Foto dalam Album</h3></div>
  <div class="admin-card-body">
    <!-- Add photo form -->
    <form method="post" action="<?= base_url('admin/galleries/add_item/' . $album->id); ?>" enctype="multipart/form-data" style="display:flex;gap:.5rem;margin-bottom:1.5rem;align-items:flex-end" onsubmit="event.preventDefault(); confirmSave(this)">
      <div style="flex:1"><label class="form-label">Upload Foto</label><input type="file" name="image" class="form-control" accept="image/*" required></div>
      <div style="flex:1"><label class="form-label">Caption</label><input type="text" name="caption" class="form-control" placeholder="Keterangan foto"></div>
      <button type="submit" class="btn-add" style="min-height:44px"><i class="fas fa-upload"></i> Upload</button>
    </form>

    <!-- Photo grid -->
    <?php if (!empty($items)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.5rem">
      <?php foreach ($items as $item): ?>
      <div style="position:relative;border-radius:var(--radius-md);overflow:hidden">
        <img src="<?= base_url('assets/uploads/' . $item->image); ?>" style="width:100%;height:120px;object-fit:cover">
        <button onclick="confirmDelete('<?= base_url('admin/galleries/delete_item/' . $item->id . '/' . $album->id); ?>', 'Foto')" class="btn-delete" style="padding:.2rem .4rem;font-size:.7rem;position:absolute;top:4px;right:4px"><i class="fas fa-times"></i></button>
        <?php if ($item->caption): ?><div style="padding:.25rem .5rem;font-size:.75rem;color:var(--gray-500)"><?= $item->caption; ?></div><?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="color:var(--gray-400);text-align:center">Belum ada foto di album ini</p>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>
