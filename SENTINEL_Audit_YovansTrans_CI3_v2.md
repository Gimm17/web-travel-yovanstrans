# SENTINEL Audit — YovansTrans (CodeIgniter 3)

Target ZIP: `yovantrans-source-code.zip`  
Generated: 2026-02-11 07:15 UTC

Scope: Security • Performance • UX/UI • Feature completeness • Maintainability • **Extreme Mobile-First Responsive**

---

## A) Executive Summary

### Top risks
**P0 (harus segera)**
1) **ENVIRONMENT fallback = `development`** jika server tidak set `CI_ENV` → rawan bocor error/stacktrace.  
   - Where: `index.php` baris define ENVIRONMENT (fallback ke `development`)
2) **CSRF protection OFF** → admin forms rentan CSRF.  
   - Where: `application/config/config.php` → `$config['csrf_protection'] = FALSE;`
3) **`encryption_key` kosong + cookie flags lemah** → keamanan session/cookie turun.  
   - Where: `application/config/config.php` → `$config['encryption_key'] = ''`, `cookie_secure=FALSE`, `cookie_httponly=FALSE`
4) **Upload folder belum di-hardening** (`assets/uploads`) → risiko upload abuse jika server salah konfigurasi.  
   - Where: upload destination `./assets/uploads/...` (modul admin posts/galleries, dll)
5) **Authorization admin belum granular (RBAC)** → akses modul sensitif via URL (cukup “logged in”).  
   - Where: controller `application/controllers/admin/*` mayoritas hanya cek login

**P1 (segera setelah P0)**
1) **Broken/mismatch route vs controller/view**  
   - `routes.php` punya `rute/(:any) -> rute/detail/$1`, tapi `Rute` controller **tidak punya** method `detail()`.  
   - `Armada` punya `detail($slug)`, tapi view `application/views/public/armada_detail.php` **tidak ada**.
2) **Booking form belum data-driven** (jam berangkat hardcoded)  
   - Where: `application/views/public/pesan.php` dropdown jam (06:00–16:00 WITA hardcoded)
3) **API track WA tanpa rate limit & tanpa batas input** → bisa di-spam (DB bengkak).  
   - Where: `application/controllers/Api.php::track_wa()`

### Fix FIRST untuk mobile users (urutan cepat)
1) Booking flow: **rute → tanggal → jam (dari jadwal DB)** + error state yang jelas  
2) Bottom bar: **tap target ≥ 44px**, jangan sempit / terlalu tinggi  
3) Hero height: hindari “terlalu tinggi” di mobile (100vh + bottom bar)

---

## B) Feature & Function Evaluation (Mandatory)

### 1) Existing features (yang terdeteksi)
**Public**
- Landing/home (hero, rute highlight, CTA WA)
- Rute (list)
- Armada (list) + controller ada `detail($slug)` (tapi view detail belum ada)
- Berita (list/detail)
- Galeri album
- Harga
- Pesan tiket via WA (form + agent selector)
- Kirim paket via WA
- Kontak
- PWA basic (`manifest.json`, `sw.js`)
- Tracking klik WA (endpoint `api/track-wa`)

**Admin**
- Auth (login/logout), dashboard
- CRUD modul: routes, schedules, pricing, posts, events, faqs, testimonials, galleries, popups, settings, users
- Analytics/Export WA clicks

**Usefulness vs cost**
- WA booking + agent selector: sangat berguna, cost rendah.
- Tracking klik WA: berguna untuk conversion, cost rendah tapi perlu rate-limit.
- PWA: berguna, tapi perlu rapihin path & strategi cache biar tidak “stale”.

### 2) Missing features (Top priority)
**Must-have**
- **Perbaiki route mismatch**: implement `Rute::detail($slug)` *atau* hapus mapping `rute/(:any)`.
- **Armada detail page**: tambah view `public/armada_detail.php` atau ubah routing.
- **Booking form data-driven**:
  - Jam berangkat harus berasal dari table schedule berdasarkan rute (+opsional kelas).
  - Kelas armada/seat class harus mengikuti pricing yang tersedia untuk rute tsb.

**Nice-to-have**
- Halaman Event public (list + detail) kalau modul event memang dipakai untuk marketing.
- Settings-driven footer (alamat/WA/IG) agar tidak hardcoded.
- SEO pack: OG tags per berita/event + sitemap/robots.

**Optional**
- Lead capture: simpan “lead” sebelum redirect ke WA (tanpa payment), untuk follow-up admin.

### 3) Over-engineered / unnecessary
- Tidak ada over-engineering besar, tapi:
  - PWA cache tanpa versioning bisa bikin user terjebak asset lama saat update → perlu strategi update.

---

## C) Findings (Grouped)

### 1) Security findings

**[P0 • Critical] ENVIRONMENT fallback ke development**
- Where: `index.php`
- What: `define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');`
- Why: error/stack trace bisa muncul di production jika env tidak diset.
- Fix: set `CI_ENV=production` di server env / vhost; pastikan display_errors off.
- Verify: akses route invalid tidak tampil stack trace.

**[P0 • Critical] CSRF protection OFF**
- Where: `application/config/config.php`
- What: `$config['csrf_protection'] = FALSE;`
- Risk: CSRF pada admin create/edit/delete.
- Fix: enable CSRF, tambahkan token di semua form admin; exclude hanya endpoint tertentu bila perlu.
- Verify: request tanpa token ditolak.

**[P0 • High] encryption_key kosong + cookie flags lemah**
- Where: `application/config/config.php`
- What: `encryption_key=''`, `cookie_secure=FALSE`, `cookie_httponly=FALSE`
- Fix: set encryption_key random (>=32 bytes); set `cookie_secure=TRUE` (HTTPS), `cookie_httponly=TRUE`.
- Verify: cookie session punya Secure/HttpOnly (di HTTPS) dan login tetap OK.

**[P0 • High] Upload folder belum hardened**
- Where: `assets/uploads/`
- What: folder upload web-accessible, belum ada rule deny execute.
- Fix: tambahkan `.htaccess` di `assets/uploads/` untuk block `.php/.phtml` + disable exec; validasi MIME & ekstensi.
- Verify: upload `.php` ditolak / tidak bisa dieksekusi.

**[P1 • Medium] API track-wa mudah di-spam**
- Where: `application/controllers/Api.php::track_wa()`
- What: menerima input langsung tanpa batas panjang/rate limit.
- Fix: rate limit per IP + batas panjang field sebelum insert.
- Verify: spam request diblok (429) dan DB tidak bengkak.

---

### 2) Performance findings

**[P1] Booking & data listing berpotensi query repetitif**
- Where: model-route/schedule/pricing (perlu cek query pattern saat runtime)
- Fix: preload (join/grouping) + cache halaman semi-statis (home/rute/harga) 30–120 detik.
- Verify: query count turun di profiling.

**[P1] Asset caching/compression belum diset**
- Where: server config / `.htaccess`
- Fix: cache header untuk `/assets/` + gzip/brotli; versioning query string.
- Verify: transfer size & repeat-view load turun.

---

### 3) API & request hygiene

**[P1] Tidak ada loading/error UI untuk request async**
- Where: tracking fetch (JS) + form validations
- Fix: inline toast/alert component (mobile-friendly), retry strategy.
- Verify: di koneksi lambat, user tetap paham status.

---

### 4) UX/UI findings

**[P1] Jam berangkat hardcoded**
- Where: `application/views/public/pesan.php` (dropdown jam 06:00–16:00)
- Why: bisa tidak sesuai rute/jadwal real.
- Fix: dropdown jam diisi dari DB sesuai rute yang dipilih (AJAX endpoint / embed JSON server-render).
- Verify: pilih rute → opsi jam berubah.

---

### 5) Responsive findings (Extreme Mobile-first)

**[P0 • Mobile] Tap target bottom bar**
- Where: CSS bottom bar (assets css)
- Fix: min-height item 52px, padding cukup, area klik full-width, active state jelas.
- Verify: nyaman dipakai di 360×800, tidak salah tap.

**[P1 • Mobile] Hero height vs bottom bar**
- Where: hero layout
- Fix: gunakan `100svh/100dvh` dan kurangi untuk tinggi bottom bar (`calc(100svh - 70px)`).
- Verify: CTA terlihat tanpa scroll ekstra.

---

### 6) Maintainability findings

**[P0/P1] base_url masih localhost**
- Where: `application/config/config.php` → `base_url = 'http://localhost/yovantrans/'`
- Fix: config per-environment (production/local) atau override via server env.
- Verify: deploy ke domain tidak perlu edit manual banyak file.

**[P1] PWA start_url/path perlu dibuat relatif**
- Where: `manifest.json`, `sw.js`
- Fix: gunakan path relatif (`./`) dan asset list yang tidak hardcode folder.
- Verify: PWA install & caching tetap jalan di root/subdomain.

---

## D) Responsive Breakpoint Map

**Rekomendasi breakpoint uji (wajib):**
- 320, 360, 375, 390, 414, 428, 480, 768, 1024+

**Yang perlu dituning paling sering:**
- 360/375/390 (Android/iPhone umum): font-size hero, padding card, bottom bar.

---

## I) Improvement Plan (Phased)

### Phase 0 — Baseline safety & backups
- Set `CI_ENV=production`
- Set `encryption_key` + secure cookie flags
- Hardening uploads (`assets/uploads/.htaccess`)
- Backup DB + uploads

### Phase 1 — Missing critical features (mobile-first)
- Fix route mismatch `rute/detail`
- Buat armada detail view atau revisi routing
- Booking form data-driven (rute→jadwal) + error state mobile

### Phase 2 — Performance & security hardening
- Enable CSRF admin
- Rate limit login & API track-wa
- Cache halaman semi-statis + optimasi query

### Phase 3 — UX & responsive perfection
- Tuning breakpoint 360/375/390/414/428
- Improve empty/loading/error states
- SEO pack (OG/sitemap/robots)

---

## Appendix — Bukti cepat (paths yang dicek)
- `index.php` (ENVIRONMENT fallback)  
- `application/config/config.php` (csrf_protection, encryption_key, cookie flags, base_url)  
- `application/config/routes.php` (rute/detail mapping, armada/detail mapping)  
- `application/controllers/Rute.php` (hanya `index()`)  
- `application/controllers/Armada.php` (punya `detail($slug)`)  
- `application/views/public/pesan.php` (jam hardcoded)  
- `application/controllers/Api.php::track_wa()` (tanpa rate limit/batas input)
