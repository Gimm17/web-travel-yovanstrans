<h1 class="admin-page-title"><?= isset($event) ? 'Edit Event' : 'Tambah Event'; ?></h1>

<!-- Instagram Import Section -->
<?php if (!isset($event)): ?>
<div class="admin-card" style="margin-bottom:1.5rem;border:1px dashed var(--admin-border, #374151)">
  <div class="admin-card-body">
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;cursor:pointer" onclick="document.getElementById('ig-import-body').style.display = document.getElementById('ig-import-body').style.display === 'none' ? 'block' : 'none'; this.querySelector('.ig-chevron').classList.toggle('open')">
      <i class="fab fa-instagram" style="font-size:1.5rem;color:#E4405F"></i>
      <div>
        <strong style="font-size:.95rem">Import dari Instagram</strong>
        <p style="margin:0;font-size:.8rem;opacity:.7">Paste link postingan IG atau embed code untuk mengisi form otomatis</p>
      </div>
      <i class="fas fa-chevron-down ig-chevron" style="margin-left:auto;transition:transform .2s"></i>
    </div>
    <div id="ig-import-body">
      <div style="margin-bottom:.5rem">
        <textarea id="ig-input" class="form-control" rows="3" placeholder="Paste link Instagram atau embed code di sini...&#10;&#10;Contoh link: https://www.instagram.com/p/XXXXX/&#10;Contoh embed: <blockquote class=&quot;instagram-media&quot; ...>" style="font-size:.85rem;font-family:inherit;resize:vertical"></textarea>
      </div>
      <div style="display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap">
        <div style="flex:1;min-width:200px">
          <p style="margin:0;font-size:.75rem;opacity:.6">
            <i class="fas fa-info-circle"></i>
            <strong>Embed code:</strong> Buka postingan IG → klik <strong>⋯</strong> → <strong>Sematkan</strong> → Salin kode
          </p>
        </div>
        <button type="button" id="ig-fetch-btn" class="btn-add" onclick="processIgInput()" style="white-space:nowrap;height:42px">
          <i class="fas fa-download"></i> Ambil Data
        </button>
      </div>
      <div id="ig-status" style="margin-top:.75rem;display:none"></div>
      <div id="ig-preview" style="margin-top:.75rem;display:none">
        <div style="padding:.75rem;background:var(--admin-bg-darker, rgba(0,0,0,.2));border-radius:var(--radius-md, 8px)">
          <div style="display:flex;gap:1rem;align-items:flex-start">
            <img id="ig-preview-img" src="" style="width:80px;height:80px;object-fit:cover;border-radius:var(--radius-md, 8px);display:none">
            <div style="flex:1;min-width:0">
              <strong id="ig-preview-title" style="display:block;margin-bottom:.25rem;font-size:.85rem;line-height:1.3"></strong>
              <p id="ig-preview-content" style="margin:0;font-size:.8rem;opacity:.7;max-height:60px;overflow:hidden;line-height:1.4"></p>
            </div>
          </div>
          <p id="ig-preview-mode" style="margin:.5rem 0 0;font-size:.7rem;opacity:.5"></p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="admin-card"><div class="admin-card-body">
<form method="post" enctype="multipart/form-data" class="admin-form" onsubmit="event.preventDefault(); confirmSave(this)">
  <div class="form-group"><label class="form-label">Judul Event</label><input type="text" name="title" id="field-title" class="form-control" value="<?= isset($event) ? $event->title : ''; ?>" required></div>
  <div class="admin-grid-3">
    <div class="form-group"><label class="form-label">Tanggal Mulai</label><input type="date" name="date_start" class="form-control" value="<?= isset($event) ? $event->date_start : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Tanggal Selesai</label><input type="date" name="date_end" class="form-control" value="<?= isset($event) ? $event->date_end : ''; ?>" required></div>
    <div class="form-group"><label class="form-label">Lokasi</label><input type="text" name="location" class="form-control" value="<?= isset($event) ? $event->location : ''; ?>" placeholder="Kota Palu"></div>
  </div>
  <div class="form-group"><label class="form-label">Konten / Deskripsi</label><textarea name="content" id="field-content" class="form-control" rows="6" required><?= isset($event) ? $event->content : ''; ?></textarea></div>
  <div class="form-group">
    <label class="form-label">Cover Image</label>
    <?php if (isset($event) && $event->cover_image): ?><div style="margin-bottom:.5rem"><img src="<?= base_url('assets/uploads/' . $event->cover_image); ?>" style="width:150px;border-radius:var(--radius-md)"></div><?php endif; ?>
    <div id="ig-cover-preview" style="display:none;margin-bottom:.5rem">
      <img id="ig-cover-img" src="" style="width:150px;border-radius:var(--radius-md)">
      <p style="margin:.25rem 0 0;font-size:.75rem;color:#10B981"><i class="fas fa-check-circle"></i> Gambar dari Instagram (otomatis tersimpan)</p>
    </div>
    <input type="file" name="cover_image" class="form-control" accept="image/*"><p class="form-hint">Max 2MB</p>
    <input type="hidden" name="ig_cover_image" id="field-ig-cover" value="">
  </div>
  <div class="form-group"><label style="display:flex;align-items:center;gap:.5rem;cursor:pointer"><input type="checkbox" name="is_published" value="1" <?= !isset($event) || $event->is_published ? 'checked' : ''; ?>> Publish</label></div>
  <div class="admin-form-actions">
    <button type="submit" class="btn-add"><i class="fas fa-save"></i> Simpan</button>
    <a href="<?= base_url('admin/events'); ?>" class="btn-edit"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</form>
</div></div>

<style>
.ig-chevron.open { transform: rotate(180deg); }
#ig-fetch-btn:disabled { opacity: .6; cursor: not-allowed; }
@keyframes ig-spin { to { transform: rotate(360deg); } }
.ig-loading i.fa-spinner { animation: ig-spin 1s linear infinite; }
</style>

<script>
function processIgInput() {
  var raw = document.getElementById('ig-input').value.trim();
  if (!raw) {
    showIgStatus('error', 'Masukkan link atau embed code Instagram.');
    return;
  }
  var type = detectInputType(raw);
  if (type === 'embed') {
    processEmbedCode(raw);
  } else if (type === 'url') {
    fetchFromUrl(raw);
  } else {
    showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> Input tidak dikenali. Paste link Instagram atau embed code.');
  }
}

function detectInputType(input) {
  if (input.indexOf('instagram-media') !== -1 || input.indexOf('instgrm') !== -1 || input.indexOf('<blockquote') !== -1) return 'embed';
  if (input.match(/^https?:\/\/(www\.)?instagram\.com\/(p|reel|reels|tv)\//i)) return 'url';
  if (input.match(/^https?:\/\/(www\.)?instagr\.am\//i)) return 'url';
  return 'unknown';
}

function processEmbedCode(html) {
  showIgStatus('loading', '<i class="fas fa-spinner" style="animation:ig-spin 1s linear infinite"></i> Membaca embed code...');
  try {
    var parser = new DOMParser();
    var doc = parser.parseFromString(html, 'text/html');
    var bq = doc.querySelector('blockquote.instagram-media') || doc.querySelector('blockquote[data-instgrm-permalink]');
    if (!bq) { showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> Embed code tidak valid.'); return; }
    var permalink = bq.getAttribute('data-instgrm-permalink') || '';
    if (!permalink) {
      var link = bq.querySelector('a[href*="instagram.com"]');
      if (link) permalink = link.getAttribute('href') || '';
    }
    if (permalink) permalink = permalink.split('?')[0];
    if (!permalink || permalink.indexOf('instagram.com') === -1) {
      showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> Tidak dapat menemukan URL postingan dalam embed code.');
      return;
    }
    showIgStatus('loading', '<i class="fas fa-spinner" style="animation:ig-spin 1s linear infinite"></i> URL ditemukan: ' + permalink + ' — mengambil data...');
    fetchFromUrl(permalink);
  } catch (e) {
    console.error('Embed parse error:', e);
    showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> Gagal memproses embed code.');
  }
}

function fetchFromUrl(url) {
  var btn = document.getElementById('ig-fetch-btn');
  var originalHtml = btn.innerHTML;
  btn.disabled = true;
  btn.classList.add('ig-loading');
  btn.innerHTML = '<i class="fas fa-spinner"></i> Mengambil...';
  showIgStatus('loading', '<i class="fas fa-spinner" style="animation:ig-spin 1s linear infinite"></i> Mengambil data dari Instagram via server...');
  document.getElementById('ig-preview').style.display = 'none';
  var formData = new FormData();
  formData.append('url', url);
  formData.append(CSRF_NAME, CSRF_HASH);
  fetch('<?= base_url("api/import-content"); ?>', { method: 'POST', body: formData })
  .then(function(r) { if (!r.ok) throw new Error('Server error: ' + r.status); return r.json(); })
  .then(function(data) {
    btn.disabled = false; btn.classList.remove('ig-loading'); btn.innerHTML = originalHtml;
    if (data.success && data.data) {
      if (data.data.title) document.getElementById('field-title').value = data.data.title;
      if (data.data.content) document.getElementById('field-content').value = data.data.content;
      if (data.data.image_filename) {
        document.getElementById('ig-cover-img').src = '<?= base_url("assets/uploads/"); ?>' + data.data.image_filename;
        document.getElementById('ig-cover-preview').style.display = 'block';
        document.getElementById('field-ig-cover').value = data.data.image_filename;
      }
      document.getElementById('ig-preview-title').textContent = data.data.title || 'Tanpa judul';
      document.getElementById('ig-preview-content').textContent = (data.data.content || '').substring(0, 200);
      if (data.data.image_url) { document.getElementById('ig-preview-img').src = data.data.image_url; document.getElementById('ig-preview-img').style.display = 'block'; }
      document.getElementById('ig-preview-mode').textContent = '🔗 Dari link — ' + url;
      document.getElementById('ig-preview').style.display = 'block';
      showIgStatus('success', '<i class="fas fa-check-circle"></i> Data berhasil diambil! Form sudah terisi otomatis.');
      if (data.csrf_hash) CSRF_HASH = data.csrf_hash;
    } else {
      showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> ' + (data.error || data.message || 'Gagal. Coba embed code.'));
    }
  })
  .catch(function(err) {
    btn.disabled = false; btn.classList.remove('ig-loading'); btn.innerHTML = originalHtml;
    showIgStatus('error', '<i class="fas fa-exclamation-circle"></i> Server tidak dapat mengambil data. <strong>Gunakan embed code sebagai alternatif.</strong>');
    console.error('IG Fetch Error:', err);
  });
}

function showIgStatus(type, message) {
  var el = document.getElementById('ig-status');
  el.style.display = 'block';
  var colors = { loading: 'color:#60A5FA', success: 'color:#10B981', error: 'color:#EF4444' };
  el.innerHTML = '<p style="margin:0;font-size:.85rem;' + (colors[type] || '') + '">' + message + '</p>';
}
</script>
