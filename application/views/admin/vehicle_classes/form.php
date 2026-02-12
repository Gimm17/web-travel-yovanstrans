<h1 class="admin-page-title"><?= isset($class) ? 'Edit Kelas Armada' : 'Tambah Kelas Armada'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group">
    <label class="form-label">Nama Kelas</label>
    <input type="text" name="name" class="form-control" value="<?= isset($class) ? $class->name : ''; ?>" placeholder="Contoh: Executive Class" required>
  </div>
  
  <div class="admin-grid-2">
    <div class="form-group">
      <label class="form-label">Jumlah Kursi</label>
      <input type="number" name="seat_count" class="form-control" value="<?= isset($class) ? $class->seat_count : ''; ?>" required>
    </div>
    <div class="form-group">
      <label class="form-label">Highlight / Badge (Opsional)</label>
      <input type="text" name="highlight" class="form-control" value="<?= isset($class) ? $class->highlight : ''; ?>" placeholder="Contoh: Paling Laris">
    </div>
  </div>

  <div class="form-group">
    <label class="form-label">Deskripsi Singkat</label>
    <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat tentang kelas ini..."><?= isset($class) ? $class->description : ''; ?></textarea>
  </div>

  <div class="form-group">
    <label class="form-label">Fitur & Fasilitas (Satu per baris)</label>
    <textarea name="features" class="form-control" rows="5" placeholder="AC dingin&#10;Reclining Seat&#10;USB Charger&#10;Musik"><?php
      if (isset($class) && $class->features) {
        $feats = json_decode($class->features, true);
        if ($feats) echo implode("\n", $feats);
      }
    ?></textarea>
    <div class="form-hint">Tulis fitur satu per satu di baris baru.</div>
  </div>

  <div class="form-group">
    <label class="form-label">Foto Cover</label>
    <?php if (isset($class) && $class->cover_image): ?>
      <div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $class->cover_image); ?>" style="height:100px;border-radius:var(--radius-md)"></div>
    <?php endif; ?>
    <input type="file" name="cover_image" class="form-control" accept="image/*">
    <div class="form-hint">Format: JPG, PNG, WEBP. Maks 2MB. <?= isset($class) ? 'Kosongkan jika tidak ingin ganti.' : ''; ?></div>
  </div>

  <!-- Gallery Photos (only shown on Edit) -->
  <?php if (isset($class)): ?>
  <div class="form-group">
    <label class="form-label">Galeri Foto Armada</label>
    <?php if (!empty($photos)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:.75rem;margin-bottom:1rem">
      <?php foreach ($photos as $p): ?>
      <div style="position:relative;border-radius:8px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,.12)">
        <img src="<?= base_url('assets/uploads/' . $p->image); ?>" style="width:100%;height:90px;object-fit:cover">
        <button type="button" onclick="confirmDelete('<?= base_url('admin/vehicle_classes/delete_photo/' . $p->id); ?>', 'Foto')" 
          style="position:absolute;top:4px;right:4px;background:rgba(220,38,38,.9);color:#fff;border:none;border-radius:50%;width:24px;height:24px;cursor:pointer;font-size:.7rem;display:flex;align-items:center;justify-content:center">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p style="color:var(--gray-400);font-size:.9rem;margin-bottom:.5rem">Belum ada foto galeri.</p>
    <?php endif; ?>
    <input type="file" name="gallery_photos[]" class="form-control" accept="image/*" multiple>
    <div class="form-hint">Pilih beberapa foto sekaligus. Maks 2MB per foto.</div>
  </div>
  <?php endif; ?>

  <div class="admin-grid-2">
    <div class="form-group">
      <label class="form-label">Urutan Tampil</label>
      <input type="number" name="sort_order" class="form-control" value="<?= isset($class) ? $class->sort_order : 0; ?>">
    </div>
    <div class="form-group">
      <label style="display:flex;align-items:center;gap:.5rem;margin-top:2rem;cursor:pointer">
        <input type="checkbox" name="is_active" value="1" <?= !isset($class) || $class->is_active ? 'checked' : ''; ?>> Aktif
      </label>
    </div>
  </div>

  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/vehicle_classes'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>
