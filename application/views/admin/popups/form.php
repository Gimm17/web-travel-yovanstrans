<h1 class="admin-page-title"><?= isset($popup) ? 'Edit Popup' : 'Tambah Popup'; ?></h1>
<div class="admin-card"><div class="admin-card-body">
<form method="post" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">

  <!-- Tipe Popup -->
  <div class="form-group">
    <label class="form-label">Tipe Popup</label>
    <select name="popup_type" id="popup_type" class="form-control" onchange="togglePopupType(this.value)">
      <option value="custom" <?= isset($popup) && $popup->popup_type == 'custom' ? 'selected' : ''; ?>>✏️ Custom (tulis sendiri)</option>
      <option value="berita" <?= isset($popup) && $popup->popup_type == 'berita' ? 'selected' : ''; ?>>📰 Berita</option>
      <option value="event" <?= isset($popup) && $popup->popup_type == 'event' ? 'selected' : ''; ?>>📅 Event</option>
      <option value="promo" <?= isset($popup) && $popup->popup_type == 'promo' ? 'selected' : ''; ?>>🏷️ Promo</option>
      <option value="tips" <?= isset($popup) && $popup->popup_type == 'tips' ? 'selected' : ''; ?>>💡 Tips</option>
      <option value="info" <?= isset($popup) && $popup->popup_type == 'info' ? 'selected' : ''; ?>>ℹ️ Info</option>
    </select>
  </div>

  <!-- Pilih Artikel (filtered by category) -->
  <div class="form-group" id="post_group" style="display:none">
    <label class="form-label" id="post_label">Pilih Artikel</label>
    <select name="post_id" id="post_select" class="form-control">
      <option value="">— Pilih —</option>
      <?php if (!empty($posts)): foreach ($posts as $p): ?>
      <option value="<?= $p->id; ?>" data-category="<?= $p->category; ?>" data-image="<?= $p->cover_image ? base_url('assets/uploads/' . $p->cover_image) : ''; ?>" <?= isset($popup) && $popup->post_id == $p->id ? 'selected' : ''; ?>><?= $p->title; ?></option>
      <?php endforeach; endif; ?>
    </select>
  </div>

  <!-- Custom Fields -->
  <!-- Post image preview (shown when linked to article) -->
  <div class="form-group" id="post_image_preview" style="display:none">
    <label class="form-label">Gambar dari Artikel</label>
    <div id="post_image_container">
      <?php if (isset($popup) && !empty($popup->post_image)): ?>
      <img src="<?= base_url('assets/uploads/' . $popup->post_image); ?>" style="width:200px;border-radius:var(--radius-md);border:2px solid var(--gray-200)">
      <?php endif; ?>
    </div>
    <div class="form-hint">Gambar akan otomatis diambil dari artikel yang dipilih</div>
  </div>

  <div id="custom_fields">
    <div class="form-group"><label class="form-label">Judul <span id="override_label" style="font-weight:400;color:var(--gray-400)"></span></label><input type="text" name="title" class="form-control" value="<?= isset($popup) ? $popup->title : ''; ?>">
      <div class="form-hint" id="title_hint" style="display:none">Kosongkan untuk menggunakan judul artikel</div>
    </div>
    <div class="form-group"><label class="form-label">Konten <span id="content_override_label" style="font-weight:400;color:var(--gray-400)"></span></label><textarea name="content" class="form-control" rows="3"><?= isset($popup) ? $popup->content : ''; ?></textarea></div>
    <div class="form-group">
      <label class="form-label">Gambar <span id="image_override_label" style="font-weight:400;color:var(--gray-400)"></span></label>
      <?php if (isset($popup) && $popup->image): ?><div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $popup->image); ?>" style="width:150px;border-radius:var(--radius-md)"></div><?php endif; ?>
      <input type="file" name="image" class="form-control" accept="image/*">
      <div class="form-hint" id="image_hint" style="display:none">Kosongkan untuk menggunakan gambar dari artikel</div>
    </div>
  </div>

  <div class="admin-grid-2">
    <div class="form-group"><label class="form-label">Tombol CTA</label><input type="text" name="cta_text" class="form-control" value="<?= isset($popup) ? $popup->cta_text : ''; ?>" placeholder="Pesan Sekarang"></div>
    <div class="form-group"><label class="form-label">URL CTA</label><input type="text" name="cta_url" class="form-control" value="<?= isset($popup) ? $popup->cta_url : ''; ?>" placeholder="https://...">
      <div class="form-hint">Untuk artikel: kosongkan agar otomatis link ke detail</div>
    </div>
  </div>
  <div class="admin-grid-3">
    <div class="form-group"><label class="form-label">Frekuensi</label>
      <select name="frequency" class="form-control">
        <option value="once_per_day" <?= isset($popup) && $popup->frequency == 'once_per_day' ? 'selected' : ''; ?>>1x per hari</option>
        <option value="every_visit" <?= isset($popup) && $popup->frequency == 'every_visit' ? 'selected' : ''; ?>>Setiap kunjungan</option>
        <option value="once_only" <?= isset($popup) && $popup->frequency == 'once_only' ? 'selected' : ''; ?>>1x saja</option>
      </select>
    </div>
    <div class="form-group"><label class="form-label">Mulai</label><input type="datetime-local" name="date_start" class="form-control" value="<?= isset($popup) && $popup->date_start ? date('Y-m-d\TH:i', strtotime($popup->date_start)) : ''; ?>"></div>
    <div class="form-group"><label class="form-label">Berakhir</label><input type="datetime-local" name="date_end" class="form-control" value="<?= isset($popup) && $popup->date_end ? date('Y-m-d\TH:i', strtotime($popup->date_end)) : ''; ?>"></div>
  </div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_active" value="1" <?= !isset($popup) || $popup->is_active ? 'checked' : ''; ?>> Aktif</label></div>
  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/popups'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>

<script>
var categoryLabels = {berita:'Berita', event:'Event', promo:'Promo', tips:'Tips', info:'Info'};

function togglePopupType(val) {
  var isCustom = val === 'custom';
  var postGroup = document.getElementById('post_group');
  var postSelect = document.getElementById('post_select');
  var postLabel = document.getElementById('post_label');

  // Show/hide article selector & image preview
  postGroup.style.display = isCustom ? 'none' : 'block';
  document.getElementById('post_image_preview').style.display = (!isCustom && postSelect.value) ? 'block' : 'none';

  // Update label
  if (!isCustom) {
    postLabel.textContent = 'Pilih ' + (categoryLabels[val] || 'Artikel');
  }

  // Filter options by category
  var options = postSelect.querySelectorAll('option[data-category]');
  for (var i = 0; i < options.length; i++) {
    var show = isCustom || options[i].getAttribute('data-category') === val;
    options[i].style.display = show ? '' : 'none';
  }

  // Reset selection if current selection doesn't match category
  if (!isCustom && postSelect.selectedOptions[0] && postSelect.selectedOptions[0].getAttribute('data-category') !== val) {
    postSelect.value = '';
  }

  // Override labels
  var overrideText = isCustom ? '' : '(override)';
  document.getElementById('override_label').textContent = overrideText;
  document.getElementById('content_override_label').textContent = overrideText;
  document.getElementById('image_override_label').textContent = overrideText;
  document.getElementById('title_hint').style.display = isCustom ? 'none' : 'block';
  document.getElementById('image_hint').style.display = isCustom ? 'none' : 'block';

  updatePostImagePreview();
}

function updatePostImagePreview() {
  var sel = document.getElementById('post_select');
  var preview = document.getElementById('post_image_preview');
  var container = document.getElementById('post_image_container');
  var type = document.getElementById('popup_type').value;

  if (type === 'custom' || !sel.value) {
    preview.style.display = 'none';
    return;
  }

  var opt = sel.selectedOptions[0];
  var imgUrl = opt ? opt.getAttribute('data-image') : '';
  if (imgUrl) {
    container.innerHTML = '<img src="' + imgUrl + '" style="width:200px;border-radius:8px;border:2px solid var(--gray-200)">';
    preview.style.display = 'block';
  } else {
    container.innerHTML = '<span style="color:var(--gray-400)">Artikel ini tidak memiliki gambar</span>';
    preview.style.display = 'block';
  }
}

// Listen for article selection changes
document.getElementById('post_select').addEventListener('change', updatePostImagePreview);

// Init on load
togglePopupType(document.getElementById('popup_type').value);
</script>
