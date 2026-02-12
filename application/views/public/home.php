<!-- HERO SECTION -->
<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge">
        <i class="fas fa-star"></i> Travel Shuttle Terpercaya di Sulawesi Tengah
      </div>
      <h1 class="hero-title">
        Perjalanan <span>Nyaman</span> &amp; Aman<br>Palu — Poso — Tentena
      </h1>
      <p class="hero-desc">
        Nikmati perjalanan dengan armada premium, fasilitas lengkap, dan pemesanan mudah lewat WhatsApp. Mulai dari <strong>Rp 75.000</strong>.
      </p>
      <div class="hero-actions">
        <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-yellow btn-lg">
          <i class="fab fa-whatsapp"></i> Pesan Tiket Sekarang
        </a>
        <a href="<?= base_url('harga'); ?>" class="btn btn-outline">
          <i class="fas fa-tags"></i> Lihat Harga
        </a>
      </div>
      <div class="quick-chips mobile-only">
        <a class="quick-chip" href="#harga"><i class="fas fa-tags"></i> Harga</a>
        <a class="quick-chip" href="#armada"><i class="fas fa-bus"></i> Armada</a>
        <a class="quick-chip" href="#fasilitas"><i class="fas fa-wifi"></i> Fasilitas</a>
        <a class="quick-chip" href="#event"><i class="fas fa-bolt"></i> Promo</a>
        <a class="quick-chip" href="#ulasan"><i class="fas fa-star"></i> Ulasan</a>
        <a class="quick-chip" href="#agen"><i class="fas fa-map-marker-alt"></i> Agen</a>
      </div>
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-number">10+</div>
          <div class="hero-stat-label">Armada</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">3</div>
          <div class="hero-stat-label">Kota</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">6</div>
          <div class="hero-stat-label">Rute</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-number">5K+</div>
          <div class="hero-stat-label">Pelanggan</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- POPULAR ROUTES + PRICING -->
<section class="section" id="harga">
  <div class="container">
    <h2 class="section-title">Rute &amp; Harga</h2>
    <p class="section-subtitle">Pilih rute perjalanan Anda dengan harga terjangkau</p>
    <div class="divider"></div>
    <div class="grid grid-2 mobile-carousel">
      <?php foreach (array_slice($routes, 0, 4) as $route): ?>
      <div class="route-card animate-on-scroll">
        <div class="route-card-header">
          <span class="route-cities"><?= $route->origin; ?></span>
          <span class="route-arrow">⇄</span>
          <span class="route-cities"><?= $route->destination; ?></span>
        </div>
        <div class="route-meta">
          <?php if ($route->distance_km): ?>
          <span class="route-meta-item"><i class="fas fa-road"></i> <?= $route->distance_km; ?> km</span>
          <?php endif; ?>
          <?php if ($route->duration_hours): ?>
          <span class="route-meta-item"><i class="fas fa-clock"></i> ~<?= $route->duration_hours; ?> jam</span>
          <?php endif; ?>
        </div>
        <?php if (!empty($route->pricings)): 
          $cheapest = $route->pricings[0];
          foreach ($route->pricings as $p) {
            $eff = $p->promo_price ?: $p->price;
            if ($eff < ($cheapest->promo_price ?: $cheapest->price)) $cheapest = $p;
          }
        ?>
        <div class="route-price">
          <span class="route-price-current"><?= format_price($cheapest->promo_price ?: $cheapest->price); ?></span>
          <?php if ($cheapest->promo_price): ?>
          <span class="route-price-old"><?= format_price($cheapest->price); ?></span>
          <span class="route-price-badge">PROMO</span>
          <?php endif; ?>
        </div>
        <?php endif; ?>
        <div style="margin-top:1rem">
          <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-sm">
            <i class="fab fa-whatsapp"></i> Pesan Sekarang
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
      <a href="<?= base_url('harga'); ?>" class="btn btn-blue"><i class="fas fa-tags"></i> Lihat Semua Harga</a>
    </div>
  </div>
</section>

<!-- KELAS ARMADA -->
<section class="section section-gray" id="armada">
  <div class="container">
    <h2 class="section-title">Kelas Armada Kami</h2>
    <p class="section-subtitle">Pilih kelas sesuai kebutuhan perjalanan Anda</p>
    <div class="divider"></div>
    <div class="grid grid-3 mobile-carousel">
      <?php foreach ($classes as $cls): ?>
      <div class="fleet-card animate-on-scroll">
        <?php if ($cls->cover_image): ?>
        <img src="<?= webp_url($cls->cover_image); ?>" alt="<?= $cls->name; ?>" class="fleet-card-image" loading="lazy">
        <?php else: ?>
        <div class="fleet-card-image" style="background:var(--gradient-blue);display:flex;align-items:center;justify-content:center;">
          <i class="fas fa-shuttle-van" style="font-size:3rem;color:var(--white)"></i>
        </div>
        <?php endif; ?>
        <div class="fleet-card-body">
          <h3 class="fleet-card-name"><?= $cls->name; ?></h3>
          <p class="fleet-card-seats"><i class="fas fa-chair"></i> <?= $cls->seat_count; ?> Kursi</p>
          <?php if ($cls->highlight): ?>
          <span class="fleet-card-highlight"><?= $cls->highlight; ?></span>
          <?php endif; ?>
          <?php $features = json_decode($cls->features, true);
          if ($features): ?>
          <div class="features-list">
            <?php foreach ($features as $f): ?>
            <span class="feature-badge"><i class="fas fa-check"></i> <?= $f; ?></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-3">
      <a href="<?= base_url('armada'); ?>" class="btn btn-blue"><i class="fas fa-bus"></i> Detail Armada</a>
    </div>
  </div>
</section>

<!-- COUNTER -->
<section class="counter-section">
  <div class="container">
    <div class="counter-grid">
      <div class="counter-item animate-on-scroll">
        <div class="counter-number">20+</div>
        <div class="counter-label">Trip per Hari</div>
      </div>
      <div class="counter-item animate-on-scroll">
        <div class="counter-number">10+</div>
        <div class="counter-label">Unit Armada</div>
      </div>
      <div class="counter-item animate-on-scroll">
        <div class="counter-number">3</div>
        <div class="counter-label">Kantor Agen</div>
      </div>
      <div class="counter-item animate-on-scroll">
        <div class="counter-number">5+</div>
        <div class="counter-label">Tahun Beroperasi</div>
      </div>
    </div>
  </div>
</section>

<!-- FASILITAS -->
<section class="section" id="fasilitas">
  <div class="container">
    <h2 class="section-title">Fasilitas Lengkap</h2>
    <p class="section-subtitle">Perjalanan nyaman dengan fasilitas premium</p>
    <div class="divider"></div>
    <div class="grid grid-4 mobile-grid-2" style="text-align:center">
      <?php
      $facilities = [
        ['icon' => 'fa-wifi', 'name' => 'Free WiFi'],
        ['icon' => 'fa-snowflake', 'name' => 'Full AC'],
        ['icon' => 'fa-tv', 'name' => 'TV/Entertainment'],
        ['icon' => 'fa-video', 'name' => 'CCTV Keamanan'],
        ['icon' => 'fa-plug', 'name' => 'USB Charger'],
        ['icon' => 'fa-fire-extinguisher', 'name' => 'Pemadam Api'],
        ['icon' => 'fa-music', 'name' => 'Karaoke*'],
        ['icon' => 'fa-cookie-bite', 'name' => 'Snack*'],
      ];
      foreach ($facilities as $f): ?>
      <div class="animate-on-scroll" style="padding:1rem;background:var(--white);border-radius:var(--radius-xl);box-shadow:var(--shadow-sm)">
        <i class="fas <?= $f['icon']; ?>" style="font-size:2rem;color:var(--blue-500);margin-bottom:.75rem;display:block"></i>
        <strong style="font-size:.9rem"><?= $f['name']; ?></strong>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="text-center text-sm" style="color:var(--gray-400);margin-top:1rem">* Tersedia di kelas Premio Luxury</p>
  </div>
</section>

<!-- UPCOMING EVENTS -->
<?php if (!empty($events)): ?>
<section class="section section-dark" id="event">
  <div class="container">
    <h2 class="section-title" style="color:var(--white)">Event & Promo</h2>
    <p class="section-subtitle" style="color:var(--gray-300)">Jangan lewatkan event dan penawaran spesial</p>
    <div class="divider"></div>
    <div class="grid grid-3 mobile-carousel">
      <?php foreach ($events as $ev): ?>
      <div class="card animate-on-scroll" style="overflow:hidden;border-radius:var(--radius-xl)">
        <?php if ($ev->cover_image): ?>
        <img src="<?= webp_url($ev->cover_image); ?>" alt="<?= $ev->title; ?>" style="width:100%;height:160px;object-fit:cover" loading="lazy">
        <?php else: ?>
        <div style="height:160px;background:var(--gradient-yellow);display:flex;align-items:center;justify-content:center">
          <i class="fas fa-calendar-alt" style="font-size:3rem;color:var(--blue-900)"></i>
        </div>
        <?php endif; ?>
        <div style="padding:1.2rem">
          <div style="display:flex;gap:.5rem;margin-bottom:.5rem">
            <span class="badge badge-warning" style="font-size:.75rem"><i class="fas fa-calendar"></i> <?= date('d M', strtotime($ev->date_start)); ?> — <?= date('d M', strtotime($ev->date_end)); ?></span>
            <?php if ($ev->location): ?><span class="badge badge-info" style="font-size:.75rem"><i class="fas fa-map-marker-alt"></i> <?= $ev->location; ?></span><?php endif; ?>
          </div>
          <h3 style="font-weight:800;font-size:1.05rem;margin-bottom:.5rem"><?= $ev->title; ?></h3>
          <p style="color:var(--gray-500);font-size:.85rem;line-height:1.5"><?= character_limiter(strip_tags($ev->content), 100); ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- TESTIMONIALS / ULASAN -->
<?php if (!empty($testimonials) || !empty($review_stats)): ?>
<section class="section section-gray" id="ulasan">
  <div class="container">
    <h2 class="section-title">Apa Kata Pelanggan</h2>
    <p class="section-subtitle">Ulasan asli dari pelanggan YovansTranss</p>
    <div class="divider"></div>

    <!-- Rating Summary Bar -->
    <?php if (!empty($review_stats) && $review_stats->total > 0): ?>
    <div style="display:flex;align-items:center;justify-content:center;gap:1.5rem;margin-bottom:1.25rem;padding:1rem 1.25rem;background:var(--white);border-radius:var(--radius-xl);box-shadow:var(--shadow-md);flex-wrap:wrap">
      <div style="text-align:center">
        <div style="font-size:2.5rem;font-weight:900;color:var(--blue-700);line-height:1"><?= $review_stats->avg_rating; ?></div>
        <div style="font-size:.85rem;color:var(--gray-500)">dari 5</div>
      </div>
      <div style="display:flex;gap:2px;font-size:1.5rem">
        <?php for ($i = 1; $i <= 5; $i++): ?>
          <?php if ($i <= floor($review_stats->avg_rating)): ?>
            <span style="color:#F59E0B">★</span>
          <?php elseif ($i - $review_stats->avg_rating < 1): ?>
            <span style="color:#F59E0B">★</span>
          <?php else: ?>
            <span style="color:#D1D5DB">★</span>
          <?php endif; ?>
        <?php endfor; ?>
      </div>
      <div style="font-size:.95rem;color:var(--gray-600)">
        <strong><?= $review_stats->total; ?></strong> ulasan
      </div>
    </div>
    <?php endif; ?>

    <!-- Review Cards -->
    <?php if (!empty($testimonials)): ?>
    <div class="grid grid-2 mobile-carousel">
      <?php foreach ($testimonials as $t): ?>
      <div class="testimonial-card animate-on-scroll">
        <div class="testimonial-stars">
          <?php for ($i = 0; $i < $t->rating; $i++): ?>★<?php endfor; ?>
        </div>
        <p class="testimonial-text"><?= $t->content; ?></p>
        <div style="display:flex;align-items:center;gap:.75rem;margin-top:1rem">
          <?php if (!empty($t->photo)): ?>
          <img src="<?= webp_url($t->photo); ?>" alt="<?= $t->name; ?>" style="width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--yellow-400)" loading="lazy">
          <?php else: ?>
          <div style="width:44px;height:44px;border-radius:50%;background:var(--gradient-blue);display:flex;align-items:center;justify-content:center;color:var(--white);font-weight:700;font-size:1.1rem"><?= strtoupper(substr($t->name, 0, 1)); ?></div>
          <?php endif; ?>
          <div>
            <div class="testimonial-author"><?= $t->name; ?></div>
            <?php if (!empty($t->route)): ?>
            <div class="testimonial-route"><?= $t->route; ?></div>
            <?php endif; ?>
          </div>
          <?php if (!empty($t->source) && $t->source === 'user'): ?>
          <span style="margin-left:auto;font-size:.7rem;padding:.2rem .6rem;background:#DBEAFE;color:#1E40AF;border-radius:999px;font-weight:600">Pengguna</span>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Write Review Button -->
    <div style="text-align:center;margin-top:2rem">
      <button onclick="document.getElementById('reviewModal').style.display='flex'" class="btn btn-yellow btn-lg" style="cursor:pointer;border:none">
        <i class="fas fa-pen"></i> Tulis Ulasan
      </button>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Review Modal -->
<div id="reviewModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center;padding:1rem">
  <div style="background:var(--white);border-radius:var(--radius-xl);padding:2rem;max-width:500px;width:100%;position:relative;max-height:90vh;overflow-y:auto;box-shadow:0 25px 60px rgba(0,0,0,.3)">
    <button onclick="document.getElementById('reviewModal').style.display='none'" style="position:absolute;top:1rem;right:1.5rem;background:none;border:none;font-size:1.5rem;cursor:pointer;color:var(--gray-500)">&times;</button>

    <h3 style="font-size:1.4rem;font-weight:800;margin-bottom:.25rem;color:var(--blue-700)">Tulis Ulasan Anda</h3>
    <p style="color:var(--gray-500);font-size:.9rem;margin-bottom:1.5rem">Bagikan pengalaman Anda menggunakan layanan YovansTranss</p>

    <form id="reviewForm" onsubmit="return submitReview(event)">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <div style="margin-bottom:1rem">
        <label style="font-weight:600;font-size:.9rem;display:block;margin-bottom:.4rem;color:var(--gray-700)">Nama Anda *</label>
        <input type="text" name="name" required placeholder="cth: Ahmad S." style="width:100%;padding:.7rem 1rem;border:2px solid var(--gray-200);border-radius:var(--radius-md);font-size:.95rem;transition:border .2s" onfocus="this.style.borderColor='var(--blue-500)'" onblur="this.style.borderColor='var(--gray-200)'">
      </div>

      <div style="margin-bottom:1rem">
        <label style="font-weight:600;font-size:.9rem;display:block;margin-bottom:.4rem;color:var(--gray-700)">Rute Perjalanan</label>
        <input type="text" name="route" placeholder="cth: Palu - Poso" style="width:100%;padding:.7rem 1rem;border:2px solid var(--gray-200);border-radius:var(--radius-md);font-size:.95rem;transition:border .2s" onfocus="this.style.borderColor='var(--blue-500)'" onblur="this.style.borderColor='var(--gray-200)'">
      </div>

      <div style="margin-bottom:1rem">
        <label style="font-weight:600;font-size:.9rem;display:block;margin-bottom:.4rem;color:var(--gray-700)">Rating *</label>
        <div id="starPicker" style="display:flex;gap:4px;font-size:2rem;cursor:pointer">
          <span class="star-pick" data-val="1" onclick="setRating(1)" onmouseover="hoverRating(1)" onmouseout="resetHover()" style="color:#D1D5DB;transition:color .15s">★</span>
          <span class="star-pick" data-val="2" onclick="setRating(2)" onmouseover="hoverRating(2)" onmouseout="resetHover()" style="color:#D1D5DB;transition:color .15s">★</span>
          <span class="star-pick" data-val="3" onclick="setRating(3)" onmouseover="hoverRating(3)" onmouseout="resetHover()" style="color:#D1D5DB;transition:color .15s">★</span>
          <span class="star-pick" data-val="4" onclick="setRating(4)" onmouseover="hoverRating(4)" onmouseout="resetHover()" style="color:#D1D5DB;transition:color .15s">★</span>
          <span class="star-pick" data-val="5" onclick="setRating(5)" onmouseover="hoverRating(5)" onmouseout="resetHover()" style="color:#D1D5DB;transition:color .15s">★</span>
        </div>
        <input type="hidden" name="rating" id="ratingInput" value="0">
      </div>

      <div style="margin-bottom:1.5rem">
        <label style="font-weight:600;font-size:.9rem;display:block;margin-bottom:.4rem;color:var(--gray-700)">Ulasan Anda *</label>
        <textarea name="content" required rows="4" placeholder="Ceritakan pengalaman Anda..." style="width:100%;padding:.7rem 1rem;border:2px solid var(--gray-200);border-radius:var(--radius-md);font-size:.95rem;resize:vertical;font-family:inherit;transition:border .2s" onfocus="this.style.borderColor='var(--blue-500)'" onblur="this.style.borderColor='var(--gray-200)'"></textarea>
      </div>

      <div id="reviewMsg" style="display:none;padding:.75rem 1rem;border-radius:var(--radius-md);margin-bottom:1rem;font-size:.9rem"></div>

      <button type="submit" id="reviewSubmitBtn" class="btn btn-blue" style="width:100%;border:none;cursor:pointer;justify-content:center">
        <i class="fas fa-paper-plane"></i> Kirim Ulasan
      </button>
    </form>
  </div>
</div>

<script>
var selectedRating = 0;
function setRating(n) {
  selectedRating = n;
  document.getElementById('ratingInput').value = n;
  var stars = document.querySelectorAll('.star-pick');
  stars.forEach(function(s) { s.style.color = parseInt(s.dataset.val) <= n ? '#F59E0B' : '#D1D5DB'; });
}
function hoverRating(n) {
  document.querySelectorAll('.star-pick').forEach(function(s) { s.style.color = parseInt(s.dataset.val) <= n ? '#FBBF24' : '#D1D5DB'; });
}
function resetHover() {
  document.querySelectorAll('.star-pick').forEach(function(s) { s.style.color = parseInt(s.dataset.val) <= selectedRating ? '#F59E0B' : '#D1D5DB'; });
}
function submitReview(e) {
  e.preventDefault();
  var form = document.getElementById('reviewForm');
  var msg = document.getElementById('reviewMsg');
  var btn = document.getElementById('reviewSubmitBtn');
  var rating = parseInt(document.getElementById('ratingInput').value);

  if (rating < 1) { msg.style.display='block'; msg.style.background='#FEF2F2'; msg.style.color='#991B1B'; msg.textContent='Silakan pilih rating bintang terlebih dahulu.'; return false; }

  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

  var fd = new FormData(form);
  fetch('<?= base_url("api/submit-review"); ?>', { method: 'POST', body: fd })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      msg.style.display = 'block';
      if (data.success) {
        msg.style.background = '#F0FDF4'; msg.style.color = '#166534';
        msg.textContent = data.message;
        form.reset(); selectedRating = 0; resetHover();
        setTimeout(function(){ document.getElementById('reviewModal').style.display='none'; msg.style.display='none'; }, 3000);
      } else {
        msg.style.background = '#FEF2F2'; msg.style.color = '#991B1B';
        msg.textContent = data.message;
      }
      btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Ulasan';
    })
    .catch(function() {
      msg.style.display='block'; msg.style.background='#FEF2F2'; msg.style.color='#991B1B';
      msg.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
      btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Ulasan';
    });
  return false;
}
// Close modal on background click
document.getElementById('reviewModal').addEventListener('click', function(e) { if (e.target === this) this.style.display = 'none'; });
</script>

<!-- LOKASI AGEN -->
<section class="section" id="agen">
  <div class="container">
    <h2 class="section-title">Kantor Agen Kami</h2>
    <p class="section-subtitle">Tersedia di 3 kota untuk melayani Anda</p>
    <div class="divider"></div>
    <div class="grid grid-3 mobile-carousel">
      <?php foreach ($branches as $b): ?>
      <div class="branch-card animate-on-scroll">
        <div class="branch-card-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h3 class="branch-card-name"><?= $b->name; ?></h3>
        <p class="branch-card-address"><?= $b->address; ?></p>
        <div class="branch-card-hours"><i class="fas fa-clock"></i> <?= $b->operational_hours; ?></div>
        <div class="branch-card-actions">
          <a href="<?= wa_url($b->wa_number); ?>" target="_blank" class="btn btn-wa btn-sm">
            <i class="fab fa-whatsapp"></i> WhatsApp
          </a>
          <?php if ($b->maps_url): ?>
          <a href="<?= $b->maps_url; ?>" target="_blank" class="btn btn-blue btn-sm">
            <i class="fas fa-map"></i> Maps
          </a>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FAQ -->
<?php if (!empty($faqs)): ?>
<section class="section section-gray">
  <div class="container" style="max-width:800px">
    <h2 class="section-title">Pertanyaan Umum (FAQ)</h2>
    <p class="section-subtitle">Jawaban untuk pertanyaan yang sering ditanyakan</p>
    <div class="divider"></div>
    <?php foreach ($faqs as $faq): ?>
    <div class="faq-item">
      <div class="faq-question">
        <span><?= $faq->question; ?></span>
        <span class="icon">▼</span>
      </div>
      <div class="faq-answer">
        <div class="faq-answer-inner"><?= $faq->answer; ?></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- CTA BOTTOM -->
<section class="section section-dark" style="text-align:center">
  <div class="container">
    <h2 style="font-size:2rem;font-weight:900;margin-bottom:1rem;color:var(--white)">
      Siap Berangkat? <span style="color:var(--yellow-400)">Pesan Sekarang!</span>
    </h2>
    <p style="color:var(--gray-300);margin-bottom:2rem;font-size:1.05rem">
      Hanya 2 klik untuk pemesanan via WhatsApp. Mudah, cepat, dan aman.
    </p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-yellow btn-lg">
        <i class="fab fa-whatsapp"></i> Pesan Tiket
      </a>
      <a href="<?= base_url('kirim-paket'); ?>" class="btn btn-outline btn-lg">
        <i class="fas fa-box"></i> Kirim Paket
      </a>
    </div>
  </div>
</section>
