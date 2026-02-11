<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Pesan Tiket</h1>
    <p class="page-header-subtitle">Pesan tiket mudah lewat WhatsApp</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Pesan Tiket</span></div>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width:700px">
    <!-- Step 1: Pick Agent -->
    <div class="animate-on-scroll" style="margin-bottom:2rem">
      <h3 style="font-weight:700;margin-bottom:1rem;color:var(--blue-700)">
        <span style="background:var(--blue-500);color:var(--white);border-radius:50%;width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;margin-right:.5rem">1</span>
        Pilih Agen
      </h3>
      <input type="hidden" id="selected_agent_wa" value="">
      <div class="agent-selector">
        <?php foreach ($branches as $b): ?>
        <div class="agent-option" data-wa="<?= $b->wa_number; ?>">
          <div class="agent-option-name"><?= $b->name; ?></div>
          <div class="agent-option-phone"><i class="fab fa-whatsapp"></i> <?= $b->wa_number; ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Step 2: Form -->
    <div class="animate-on-scroll">
      <h3 style="font-weight:700;margin-bottom:1rem;color:var(--blue-700)">
        <span style="background:var(--blue-500);color:var(--white);border-radius:50%;width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;margin-right:.5rem">2</span>
        Isi Data Pesanan
      </h3>
    <form id="booking-form" style="background:var(--white);padding:2rem;border-radius:var(--radius-xl);box-shadow:var(--shadow-md)">
        <div class="form-group">
          <label class="form-label" for="f_nama">Nama Lengkap</label>
          <input type="text" id="f_nama" class="form-control" placeholder="Masukkan nama" required>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" for="f_rute">Rute</label>
            <select id="f_rute" class="form-control" required>
              <option value="">-- Pilih Rute --</option>
              <?php foreach ($routes as $r): ?>
              <option value="<?= $r->origin . ' → ' . $r->destination; ?>" data-route-id="<?= $r->id; ?>"><?= $r->origin; ?> → <?= $r->destination; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="f_kelas">Kelas</label>
            <select id="f_kelas" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              <?php foreach ($classes as $c): ?>
              <option value="<?= $c->name; ?>"><?= $c->name; ?> (<?= $c->seat_count; ?> kursi)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" for="f_tanggal">Tanggal</label>
            <input type="date" id="f_tanggal" class="form-control" min="<?= date('Y-m-d'); ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="f_jam">Jam Berangkat</label>
            <select id="f_jam" class="form-control" required>
              <option value="">-- Pilih Rute dulu --</option>
            </select>
          </div>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" for="f_jumlah">Jumlah Penumpang</label>
            <select id="f_jumlah" class="form-control" required>
              <?php for ($i = 1; $i <= 8; $i++): ?>
              <option value="<?= $i; ?>"><?= $i; ?> orang</option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="f_jemput">Titik Jemput</label>
            <input type="text" id="f_jemput" class="form-control" placeholder="Alamat jemput" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="f_catatan">Catatan (Opsional)</label>
          <textarea id="f_catatan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
        </div>
        <button type="submit" class="btn btn-wa btn-lg btn-block">
          <i class="fab fa-whatsapp"></i> Kirim Pesanan via WhatsApp
        </button>
      </form>
    </div>
  </div>
</section>

<script>
// Dynamic schedule loading based on route selection
document.getElementById('f_rute').addEventListener('change', function() {
  var sel = this.options[this.selectedIndex];
  var routeId = sel.getAttribute('data-route-id');
  var jamSelect = document.getElementById('f_jam');

  jamSelect.innerHTML = '<option value="">Memuat jadwal...</option>';

  if (!routeId) {
    jamSelect.innerHTML = '<option value="">-- Pilih Rute dulu --</option>';
    return;
  }

  fetch('<?= base_url("api/schedules-by-route"); ?>?route_id=' + routeId)
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.length === 0) {
        jamSelect.innerHTML = '<option value="">Tidak ada jadwal</option>';
        return;
      }
      var html = '<option value="">-- Pilih Jam --</option>';
      data.forEach(function(s) {
        var label = s.depart_time + ' WITA';
        // if (s.class_name) label += ' (' + s.class_name + ')'; // Removed per request
        html += '<option value="' + s.depart_time + '">' + label + '</option>';
      });
      jamSelect.innerHTML = html;
    })
    .catch(function() {
      jamSelect.innerHTML = '<option value="">Gagal memuat jadwal</option>';
    });
});
</script>

