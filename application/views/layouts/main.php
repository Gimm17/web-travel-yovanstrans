<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? $page_title . ' — YovansTranss' : 'YovansTranss Shuttle — Palu Poso Tentena'; ?></title>
  <meta name="description" content="<?= isset($page_desc) ? $page_desc : 'YovansTranss Shuttle - Layanan travel dan shuttle premium rute Palu, Poso, Tentena. Pemesanan mudah via WhatsApp.'; ?>">
  <meta property="og:title" content="<?= isset($page_title) ? $page_title : 'YovansTranss Shuttle'; ?>">
  <meta property="og:description" content="<?= isset($page_desc) ? $page_desc : 'Layanan travel shuttle premium Palu - Poso - Tentena'; ?>">
  <meta property="og:type" content="website">
  <!-- PWA -->
  <link rel="manifest" href="<?= base_url('manifest.json'); ?>">
  <meta name="theme-color" content="#F5A623">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/pages.css'); ?>">

<!-- SEO: JSON-LD LocalBusiness Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "YovansTranss Shuttle",
  "description": "Layanan travel dan shuttle premium rute Palu - Poso - Tentena",
  "url": "<?= base_url(); ?>",
  "telephone": "+6282349085255",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Jl. Soekarno Hatta",
    "addressLocality": "Palu",
    "addressRegion": "Sulawesi Tengah",
    "addressCountry": "ID"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
    "opens": "06:00",
    "closes": "21:00"
  },
  "priceRange": "Rp 75.000 - Rp 250.000"
}
</script>

<?php if (isset($events) && !empty($events)): foreach ($events as $_ev): ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "<?= addslashes($_ev->title); ?>",
  "startDate": "<?= $_ev->date_start; ?>",
  "endDate": "<?= $_ev->date_end; ?>",
  <?php if (!empty($_ev->location)): ?>"location": {"@type": "Place", "name": "<?= addslashes($_ev->location); ?>"},<?php endif; ?>
  "organizer": {"@type": "Organization", "name": "YovansTranss Shuttle"}
}
</script>
<?php endforeach; endif; ?>

<?php if (isset($post) && $post): ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "<?= addslashes($post->title); ?>",
  "datePublished": "<?= $post->published_at; ?>",
  "author": {"@type": "Organization", "name": "YovansTranss"},
  "publisher": {"@type": "Organization", "name": "YovansTranss"}
}
</script>
<?php endif; ?>

</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="navbar-inner">
    <a href="<?= base_url(); ?>" class="navbar-brand">
      <i class="fas fa-shuttle-van" style="color:var(--yellow-400);font-size:1.5rem"></i>
      YOVANS<span>TRANS</span>
    </a>
    <div class="navbar-menu">
      <a href="<?= base_url(); ?>" class="<?= ($active_page ?? '') == 'home' ? 'active' : ''; ?>">Home</a>
      <a href="<?= base_url('rute'); ?>" class="<?= ($active_page ?? '') == 'rute' ? 'active' : ''; ?>">Rute & Jadwal</a>
      <a href="<?= base_url('harga'); ?>" class="<?= ($active_page ?? '') == 'harga' ? 'active' : ''; ?>">Harga</a>
      <a href="<?= base_url('armada'); ?>" class="<?= ($active_page ?? '') == 'armada' ? 'active' : ''; ?>">Armada</a>
      <a href="<?= base_url('galeri'); ?>" class="<?= ($active_page ?? '') == 'galeri' ? 'active' : ''; ?>">Galeri</a>
      <a href="<?= base_url('berita'); ?>" class="<?= ($active_page ?? '') == 'berita' ? 'active' : ''; ?>">Berita</a>
      <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-yellow btn-sm">
        <i class="fab fa-whatsapp"></i> Pesan Tiket
      </a>
    </div>
    <button class="navbar-toggle" onclick="document.querySelector('.mobile-menu').classList.add('active');document.querySelector('.mobile-menu-overlay').classList.add('active')">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay"></div>

<!-- Mobile Menu -->
<div class="mobile-menu">
  <button class="mobile-menu-close">&times;</button>
  <div style="margin-bottom:1.5rem">
    <span style="color:var(--white);font-family:var(--font-display);font-weight:800;font-size:1.3rem">YOVANS<span style="color:var(--yellow-400)">TRANS</span></span>
  </div>
  <div class="mobile-menu-nav">
    <a href="<?= base_url(); ?>" class="<?= ($active_page ?? '') == 'home' ? 'active' : ''; ?>"><i class="fas fa-home" style="width:24px"></i> Home</a>
    <a href="<?= base_url('rute'); ?>" class="<?= ($active_page ?? '') == 'rute' ? 'active' : ''; ?>"><i class="fas fa-route" style="width:24px"></i> Rute & Jadwal</a>
    <a href="<?= base_url('harga'); ?>" class="<?= ($active_page ?? '') == 'harga' ? 'active' : ''; ?>"><i class="fas fa-tags" style="width:24px"></i> Harga</a>
    <a href="<?= base_url('armada'); ?>" class="<?= ($active_page ?? '') == 'armada' ? 'active' : ''; ?>"><i class="fas fa-bus" style="width:24px"></i> Armada</a>
    <a href="<?= base_url('galeri'); ?>" class="<?= ($active_page ?? '') == 'galeri' ? 'active' : ''; ?>"><i class="fas fa-images" style="width:24px"></i> Galeri</a>
    <a href="<?= base_url('berita'); ?>" class="<?= ($active_page ?? '') == 'berita' ? 'active' : ''; ?>"><i class="fas fa-newspaper" style="width:24px"></i> Berita</a>
    <a href="<?= base_url('pesan-tiket'); ?>" class="<?= ($active_page ?? '') == 'pesan' ? 'active' : ''; ?>"><i class="fas fa-ticket-alt" style="width:24px"></i> Pesan Tiket</a>
    <a href="<?= base_url('kirim-paket'); ?>" class="<?= ($active_page ?? '') == 'paket' ? 'active' : ''; ?>"><i class="fas fa-box" style="width:24px"></i> Kirim Paket</a>
    <a href="<?= base_url('kontak'); ?>" class="<?= ($active_page ?? '') == 'kontak' ? 'active' : ''; ?>"><i class="fas fa-phone" style="width:24px"></i> Kontak</a>
  </div>
  <div style="margin-top:2rem">
    <a href="<?= base_url('pesan-tiket'); ?>" class="btn btn-wa btn-block"><i class="fab fa-whatsapp"></i> Pesan via WhatsApp</a>
  </div>
</div>

<!-- Page Content -->
<?php $this->load->view($content_view); ?>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">YOVANS<span>TRANS</span></div>
        <p class="footer-desc">Layanan travel dan shuttle premium untuk rute Palu - Poso - Tentena. Armada nyaman, harga terjangkau, pemesanan mudah via WhatsApp.</p>
        <div class="footer-social">
          <a href="https://instagram.com/yovanstrans" target="_blank"><i class="fab fa-instagram"></i></a>
          <a href="<?= wa_url('6282349085255'); ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div>
        <div class="footer-title">Menu</div>
        <div class="footer-links">
          <a href="<?= base_url(); ?>">Home</a>
          <a href="<?= base_url('rute'); ?>">Rute & Jadwal</a>
          <a href="<?= base_url('harga'); ?>">Harga</a>
          <a href="<?= base_url('armada'); ?>">Armada</a>
          <a href="<?= base_url('galeri'); ?>">Galeri</a>
          <a href="<?= base_url('berita'); ?>">Berita & Event</a>
        </div>
      </div>
      <div>
        <div class="footer-title">Layanan</div>
        <div class="footer-links">
          <a href="<?= base_url('pesan-tiket'); ?>">Pesan Tiket</a>
          <a href="<?= base_url('kirim-paket'); ?>">Kirim Paket</a>
          <a href="<?= base_url('kontak'); ?>">Kontak</a>
        </div>
      </div>
      <div>
        <div class="footer-title">Kontak</div>
        <div class="footer-contact-item"><i class="fas fa-map-marker-alt" style="color:var(--yellow-400)"></i> Jl. Soekarno Hatta, Kota Palu</div>
        <div class="footer-contact-item"><i class="fas fa-phone" style="color:var(--yellow-400)"></i> 0823-4908-5255</div>
        <div class="footer-contact-item"><i class="fab fa-whatsapp" style="color:var(--yellow-400)"></i> 0823-4908-5255</div>
        <div class="footer-contact-item"><i class="fas fa-clock" style="color:var(--yellow-400)"></i> 06:00 - 21:00 WITA</div>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; <?= date('Y'); ?> YovansTranss Shuttle. All rights reserved.
    </div>
  </div>
</footer>

<!-- Sticky Bottom Bar (Mobile) -->
<div class="bottom-bar">
  <a href="<?= base_url(); ?>" class="bottom-bar-item <?= ($active_page ?? '') == 'home' ? 'active' : ''; ?>">
    <i class="fas fa-home"></i> Home
  </a>
  <a href="<?= base_url('rute'); ?>" class="bottom-bar-item <?= ($active_page ?? '') == 'rute' ? 'active' : ''; ?>">
    <i class="fas fa-route"></i> Rute
  </a>
  <a href="<?= base_url('pesan-tiket'); ?>" class="bottom-bar-item <?= ($active_page ?? '') == 'pesan' ? 'active' : ''; ?>">
    <i class="fas fa-ticket-alt"></i> Pesan
  </a>
  <a href="<?= wa_url('6282349085255'); ?>" target="_blank" class="bottom-bar-item bottom-bar-wa">
    <i class="fab fa-whatsapp"></i> WA
  </a>
</div>

<!-- Scroll to Top -->
<button class="scroll-top"><i class="fas fa-arrow-up"></i></button>

<!-- Lightbox -->
<div class="lightbox">
  <button class="lightbox-close">&times;</button>
  <button class="lightbox-nav lightbox-prev"><i class="fas fa-chevron-left"></i></button>
  <img src="" alt="Lightbox">
  <button class="lightbox-nav lightbox-next"><i class="fas fa-chevron-right"></i></button>
</div>

<!-- Popup Promo -->
<?php if (isset($popup) && $popup): ?>
<?php
  // Resolve popup content based on type
  $p_type = isset($popup->popup_type) ? $popup->popup_type : 'custom';
  $p_title = $popup->title;
  $p_content = $popup->content;
  $p_image = $popup->image ? base_url('assets/uploads/' . $popup->image) : '';
  $p_cta_text = $popup->cta_text;
  $p_cta_url = $popup->cta_url;
  $p_category = '';

  if ($p_type !== 'custom' && !empty($popup->post_title)) {
      if (!$p_title) $p_title = $popup->post_title;
      if (!$p_content) $p_content = $popup->post_excerpt ? $popup->post_excerpt : mb_substr(strip_tags($popup->post_content), 0, 150) . '...';
      if (!$p_image && $popup->post_image) $p_image = base_url('assets/uploads/' . $popup->post_image);
      if (!$p_cta_text) $p_cta_text = 'Baca Selengkapnya';
      if (!$p_cta_url && $popup->post_slug) $p_cta_url = base_url('berita/' . $popup->post_slug);
      $p_category = $p_type;
  }

  // Category badge colors
  $cat_badges = [
      'berita' => ['bg' => '#DBEAFE', 'color' => '#1E40AF', 'icon' => '📰', 'label' => 'Berita'],
      'event'  => ['bg' => '#FEF3C7', 'color' => '#92400E', 'icon' => '📅', 'label' => 'Event'],
      'promo'  => ['bg' => '#D1FAE5', 'color' => '#065F46', 'icon' => '🏷️', 'label' => 'Promo'],
      'tips'   => ['bg' => '#EDE9FE', 'color' => '#5B21B6', 'icon' => '💡', 'label' => 'Tips'],
      'info'   => ['bg' => '#E0F2FE', 'color' => '#075985', 'icon' => 'ℹ️', 'label' => 'Info'],
  ];
?>
<div class="popup-overlay" data-popup-id="<?= $popup->id; ?>" data-frequency="<?= $popup->frequency; ?>">
  <div class="popup-modal">
    <button class="popup-close">&times;</button>
    <?php if ($p_category && isset($cat_badges[$p_category])): $badge = $cat_badges[$p_category]; ?>
    <div style="display:inline-block;padding:.25rem .75rem;border-radius:var(--radius-full);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.5rem;background:<?= $badge['bg']; ?>;color:<?= $badge['color']; ?>"><?= $badge['icon'] . ' ' . $badge['label']; ?></div>
    <?php endif; ?>
    <?php if ($p_image): ?>
    <img src="<?= $p_image; ?>" alt="<?= $p_title; ?>" class="popup-image">
    <?php endif; ?>
    <div class="popup-body">
      <h3 class="popup-title"><?= $p_title; ?></h3>
      <p class="popup-text"><?= $p_content; ?></p>
      <?php if ($p_cta_text && $p_cta_url): ?>
      <a href="<?= $p_cta_url; ?>" class="btn btn-yellow"><?= $p_cta_text; ?></a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('<?= base_url("sw.js"); ?>').catch(function(){});
}
// Page view tracking (1x per session only)
(function(){
  try {
    if (sessionStorage.getItem('yt_viewed')) return; // already counted this session
    var path = window.location.pathname.replace(/^\/yovantrans\/?/, '').replace(/\/$/, '') || 'home';
    if (path.indexOf('admin') === 0) return;
    var fd = new FormData();
    fd.append('page', path);
    if (navigator.sendBeacon) {
      navigator.sendBeacon('<?= base_url("api/track-view"); ?>', fd);
    } else {
      fetch('<?= base_url("api/track-view"); ?>', { method: 'POST', body: fd });
    }
    sessionStorage.setItem('yt_viewed', '1');
  } catch(e) {}
})();
</script>
</body>
</html>
