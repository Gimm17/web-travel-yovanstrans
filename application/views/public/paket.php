<!-- Page Header -->
<section class="page-header">
  <div class="container">
    <h1 class="page-header-title">Kirim Paket</h1>
    <p class="page-header-subtitle">Kirim barang dengan cepat dan aman</p>
    <div class="breadcrumb"><a href="<?= base_url(); ?>">Home</a> / <span>Kirim Paket</span></div>
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
        Isi Data Pengiriman
      </h3>
      <form id="paket-form" style="background:var(--white);padding:2rem;border-radius:var(--radius-xl);box-shadow:var(--shadow-md)">
        <div class="form-group">
          <label class="form-label" for="p_nama">Nama Pengirim</label>
          <input type="text" id="p_nama" class="form-control" placeholder="Nama pengirim" required>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" for="p_asal">Kota Asal</label>
            <select id="p_asal" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="Palu">Palu</option>
              <option value="Poso">Poso</option>
              <option value="Tentena">Tentena</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="p_tujuan">Kota Tujuan</label>
            <select id="p_tujuan" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="Palu">Palu</option>
              <option value="Poso">Poso</option>
              <option value="Tentena">Tentena</option>
            </select>
          </div>
        </div>
        <div class="grid grid-2">
          <div class="form-group">
            <label class="form-label" for="p_jenis">Jenis Barang</label>
            <input type="text" id="p_jenis" class="form-control" placeholder="Mis: Dokumen, Makanan" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="p_berat">Perkiraan Berat</label>
            <input type="text" id="p_berat" class="form-control" placeholder="Mis: 2 kg" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="p_catatan">Catatan (Opsional)</label>
          <textarea id="p_catatan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
        </div>
        <button type="submit" class="btn btn-wa btn-lg btn-block">
          <i class="fab fa-whatsapp"></i> Kirim Permintaan via WhatsApp
        </button>
      </form>
    </div>
  </div>
</section>
