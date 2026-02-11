<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? $page_title . ' — Admin YovansTranss' : 'Admin YovansTranss'; ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
  <!-- SweetAlert2 CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="admin-body">

<!-- Sidebar Overlay -->
<div class="admin-sidebar-overlay" onclick="this.classList.remove('active');document.querySelector('.admin-sidebar').classList.remove('active')"></div>

<!-- Sidebar -->
<aside class="admin-sidebar">
  <div class="admin-sidebar-brand">YOVANS<span>TRANS</span></div>
  <nav class="admin-sidebar-nav">
    <div class="admin-nav-label">Menu Utama</div>
    <a href="<?= base_url('admin'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'dashboard' ? 'active' : ''; ?>">
      <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="admin-nav-label">Konten</div>
    <a href="<?= base_url('admin/posts'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'posts' ? 'active' : ''; ?>">
      <i class="fas fa-newspaper"></i> Berita & Artikel
    </a>
    <a href="<?= base_url('admin/popups'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'popups' ? 'active' : ''; ?>">
      <i class="fas fa-bullhorn"></i> Popup Promo
    </a>
    <a href="<?= base_url('admin/events'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'events' ? 'active' : ''; ?>">
      <i class="fas fa-calendar-alt"></i> Event
    </a>
    <a href="<?= base_url('admin/galleries'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'galleries' ? 'active' : ''; ?>">
      <i class="fas fa-images"></i> Galeri
    </a>
    <a href="<?= base_url('admin/testimonials'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'testimonials' ? 'active' : ''; ?>">
      <i class="fas fa-star"></i> Testimoni
    </a>
    <a href="<?= base_url('admin/faqs'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'faqs' ? 'active' : ''; ?>">
      <i class="fas fa-question-circle"></i> FAQ
    </a>

    <div class="admin-nav-label">Operasional</div>
    <a href="<?= base_url('admin/vehicle_classes'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'vehicle_classes' ? 'active' : ''; ?>">
      <i class="fas fa-bus"></i> Armada
    </a>
    <a href="<?= base_url('admin/routes'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'routes' ? 'active' : ''; ?>">
      <i class="fas fa-route"></i> Rute
    </a>
    <a href="<?= base_url('admin/schedules'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'schedules' ? 'active' : ''; ?>">
      <i class="fas fa-clock"></i> Jadwal
    </a>
    <a href="<?= base_url('admin/pricing'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'pricing' ? 'active' : ''; ?>">
      <i class="fas fa-tags"></i> Harga
    </a>
    <a href="<?= base_url('admin/branches'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'branches' ? 'active' : ''; ?>">
      <i class="fas fa-store"></i> Agen
    </a>

    <div class="admin-nav-label">Sistem</div>
    <a href="<?= base_url('admin/analytics'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'analytics' ? 'active' : ''; ?>">
      <i class="fas fa-chart-pie"></i> Analytics
    </a>
    <a href="<?= base_url('admin/users'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'users' ? 'active' : ''; ?>">
      <i class="fas fa-users"></i> User
    </a>
    <a href="<?= base_url('admin/settings'); ?>" class="admin-nav-item <?= ($admin_page ?? '') == 'settings' ? 'active' : ''; ?>">
      <i class="fas fa-cog"></i> Pengaturan
    </a>
    <div class="admin-nav-label">Export Data</div>
    <a href="<?= base_url('admin/export/csv/routes'); ?>" class="admin-nav-item"><i class="fas fa-download"></i> Rute (CSV)</a>
    <a href="<?= base_url('admin/export/csv/pricing'); ?>" class="admin-nav-item"><i class="fas fa-download"></i> Harga (CSV)</a>
    <a href="<?= base_url('admin/export/csv/posts'); ?>" class="admin-nav-item"><i class="fas fa-download"></i> Posts (CSV)</a>
    <a href="<?= base_url('admin/export/csv/wa_clicks'); ?>" class="admin-nav-item"><i class="fas fa-download"></i> WA Clicks (CSV)</a>
    <a href="<?= base_url('admin/logout'); ?>" class="admin-nav-item" onclick="event.preventDefault(); confirmLogout('<?= base_url('admin/logout'); ?>')">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </nav>
</aside>

<!-- Main Content -->
<div class="admin-main">
  <!-- Topbar -->
  <header class="admin-topbar">
    <button class="admin-topbar-toggle" onclick="document.querySelector('.admin-sidebar').classList.toggle('active');document.querySelector('.admin-sidebar-overlay').classList.toggle('active')">
      <i class="fas fa-bars"></i>
    </button>
    <span style="font-weight:600;font-size:.9rem"><?= isset($page_title) ? $page_title : 'Dashboard'; ?></span>
    <div class="admin-topbar-user">
      <i class="fas fa-user-circle"></i>
      <span><?= $this->session->userdata('admin_name') ?: 'Admin'; ?></span>
    </div>
  </header>

  <!-- Page Content -->
  <div class="admin-content">
    
    <!-- SweetAlert2 Flashdata Handling -->
    <?php if ($this->session->flashdata('success')): ?>
    <div class="flash-data-success" data-flashdata="<?= $this->session->flashdata('success'); ?>"></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-data-error" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <?php $this->load->view($admin_view); ?>
  </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// -- CSRF Token (global) --
var CSRF_NAME = '<?= $this->security->get_csrf_token_name() ?>';
var CSRF_HASH = '<?= $this->security->get_csrf_hash() ?>';

// Auto-inject CSRF token into all POST forms on the page
document.querySelectorAll('form[method="post"]').forEach(function(form) {
  if (!form.querySelector('input[name="' + CSRF_NAME + '"]')) {
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = CSRF_NAME;
    input.value = CSRF_HASH;
    form.appendChild(input);
  }
});

// SweetAlert2 Configuration
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

// Handle Flashdata
const flashSuccess = document.querySelector('.flash-data-success');
const flashError = document.querySelector('.flash-data-error');

if (flashSuccess) {
  Toast.fire({
    icon: 'success',
    title: flashSuccess.getAttribute('data-flashdata')
  });
}

if (flashError) {
  Toast.fire({
    icon: 'error',
    title: flashError.getAttribute('data-flashdata')
  });
}

// Global Delete Confirmation
function confirmDelete(url, itemName) {
  Swal.fire({
    title: 'Hapus ' + (itemName || 'data') + '?',
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      var form = document.createElement("form");
      form.method = "POST";
      form.action = url;
      // Add CSRF token
      var csrf = document.createElement("input");
      csrf.type = "hidden";
      csrf.name = CSRF_NAME;
      csrf.value = CSRF_HASH;
      form.appendChild(csrf);
      document.body.appendChild(form);
      form.submit();
    }
  })
}

// Logout Confirmation
function confirmLogout(url) {
  Swal.fire({
    title: 'Yakin ingin keluar?',
    text: "Sesi Anda akan diakhiri.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Keluar',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  })
}

// Global Save Confirmation
function confirmSave(form) {
  Swal.fire({
    title: 'Simpan data?',
    text: "Pastikan data yang Anda masukkan sudah benar.",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, Simpan',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      form.submit();
    }
  })
}
</script>
</body>
</html>
