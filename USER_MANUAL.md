# 📘 Panduan Pengguna (User Manual) - YovansTrans Website

Dokumen ini berisi panduan lengkap penggunaan website YovansTrans, baik untuk pengunjung umum (Public) maupun pengelola (Admin).

---

## 🌐 Bagian 1: Website Publik (Front-End)

Website publik dapat diakses oleh pelanggan di alamat utama domain.

### 1. Fitur Utama Halaman Depan

- **Pencarian Jadwal**: Formulir untuk mencari ketersediaan travel berdasarkan rute, tanggal, dan jumlah penumpang.
- **Keunggulan Layanan**: Menampilkan alasan memilih YovansTrans.
- **Armada**: Menampilkan jenis kendaraan yang tersedia.
- **Testimoni**: Ulasan dari pelanggan (yang sudah disetujui admin).
- **Artikel Terbaru**: Berita dan informasi terkini.

### 2. Cara Memesan Tiket

1. Pada formulir pencarian di beranda, pilih **Kota Asal** dan **Kota Tujuan**.
2. Tentukan **Tanggal Keberangkatan** dan jumlah **Kursi**.
3. Klik tombol **Cari Jadwal**.
4. Website akan menampilkan daftar jadwal yang tersedia beserta harga.
5. Klik **Pesan via WhatsApp**.
6. Anda akan diarahkan ke aplikasi WhatsApp dengan pesan otomatis yang sudah terisi format pemesanan.

### 3. Mengirim Ulasan (Review)

1. Di halaman depan, scroll ke bagian "Apa Kata Pelanggan".
2. Klik tombol **Tulis Ulasan**.
3. Isi Nama, Rute yang pernah dinaiki, Rating (Bintang 1-5), dan Ulasan Anda.
4. Klik **Kirim Ulasan**.
   > **Catatan**: Ulasan tidak akan langsung muncul. Admin harus menyetujuinya terlebih dahulu melalui Admin Panel.

### 4. Halaman Lain

- **Rute & Jadwal**: Menampilkan daftar lengkap rute dan jam keberangkatan.
- **Armada**: Detail fasilitas dan foto kendaraan.
- **Galeri**: Foto-foto kegiatan dan armada.
- **Berita/Event**: Informasi promo dan pengumuman.

---

## 🔐 Bagian 2: Admin Panel (Back-End)

Admin Panel digunakan untuk mengelola konten website, jadwal, dan operasional.

### 1. Login Admin

- **URL**: `https://website-anda.com/admin/login`
- Masukkan **Username** dan **Password** yang telah diberikan.

### 2. Dashboard

Halaman utama setelah login menampilkan ringkasan:

- Total Rute & Jadwal.
- Statistik Pengunjung (Views).
- Jumlah Klik WhatsApp (Lead).
- Artikel Terbaru.

### 3. Manajemen Operasional

Menu ini digunakan untuk mengatur layanan travel.

#### 🚍 Armada (Vehicle Classes)

Mengelola jenis kendaraan.

- **Tambah Armada**: Masukkan nama (misal: Hiace Premio), jumlah kursi, fasilitas, dan foto.
- **Edit/Hapus**: Mengubah info armada.

#### 🛣️ Rute (Routes)

Mengelola rute perjalanan.

- **Tambah Rute**: Tentukan Asal dan Tujuan.
- **Harga**: Hubungkan rute dengan daftar harga.

#### 📅 Jadwal (Schedules)

Mengatur jam keberangkatan.

- **Set Jadwal**: Pilih Rute, lalu tambahkan jam keberangkatan (misal: 10:00, 20:00).

#### 🏷️ Harga (Pricing)

Mengatur harga tiket.

- **Set Harga**: Tentukan harga normal dan harga tuslah (jika ada).

#### 🏢 Agen (Branches)

Mengelola daftar kantor cabang/agen.

- **Tambah Agen**: Masukkan Nama Kota, Alamat, No. Telepon/WA, dan Jam Buka.

### 4. Manajemen Konten

Menu ini untuk mengisi informasi di website.

#### 📰 Berita & Artikel

- **Tulis Artikel**: Gunakan editor teks untuk membuat berita atau tips travel.
- **Upload Gambar**: Tambahkan gambar utama artikel.
- **Status**: Set ke 'Published' agar muncul di website, atau 'Draft' untuk simpan sementara.

#### 🖼️ Galeri

- Upload foto-foto armada atau dokumentasi perjalanan.

#### ❓ FAQ (Tanya Jawab)

- Tambahkan pertanyaan yang sering diajukan beserta jawabannya.

#### 📢 Popup Promo

- Buat banner promo yang akan muncul otomatis saat website dibuka.
- Bisa diatur gambar, judul, dan link tombol.

### 5. Interaksi Pengguna & Laporan

#### ⭐ Testimoni

Mengelola ulasan yang masuk dari pengguna.

- **Status Menunggu**: Ulasan baru akan muncul dengan tanda kuning.
- **Approve**: Klik tombol **Centang Hijau** agar ulasan muncul di website.
- **Hapus**: Klik tombol **Sampah** untuk menghapus ulasan spam/tidak pantas.

#### 📊 Analytics

Melihat performa website.

- **Traffic**: Jumlah pengunjung harian & total.
- **Halaman Populer**: Halaman mana yang paling sering dibuka.
- **Klik WhatsApp**: Berapa orang yang klik tombol pesan.

### 6. Pengaturan Sistem

#### 👤 User

- Mengelola akun admin (Ubah password, tambah admin baru).

#### ⚙️ Pengaturan Website

- Mengubah Judul Website, Meta Description, No. WhatsApp Utama, Link Sosmed, dan Alamat Footer.

---

### 💡 Tips Keamanan

- Selalu **Logout** setelah selesai menggunakan Admin Panel.
- Jangan berikan password admin kepada orang yang tidak berkepentingan.
- Lakukan backup database secara berkala melalui cPanel.

---

_Dokumen ini dibuat otomatis oleh AI Assistant YovansTrans._
