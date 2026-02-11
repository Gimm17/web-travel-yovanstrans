# Panduan Deploy ke cPanel (Hosting)

## 1. Persiapan File (Localhost)

Saya sudah buatkan file ZIP siap upload (`yovantrans-production.zip`). File ini sudah bersih dari file development (seperti `.git`, `node_modules`, dll).

## 2. Upload ke cPanel

1. Login ke cPanel hosting Anda.
2. Buka **File Manager**.
3. Masuk ke folder `public_html` (atau folder sub-domain jika ada).
4. Klik **Upload** dan pilih file `yovantrans-production.zip`.
5. Setelah selesai, klik kanan file zip tersebut -> **Extract**.
6. Isi folder proyek akan muncul. Pastikan file `index.php` ada di luar (root folder yang Anda tuju).

## 3. Setup Database

1. Di cPanel, cari menu **MySQL Functions/Databases** -> **MySQL® Database Wizard**.
   - **Step 1:** Buat database baru (misal: `u123456_yovantrans`).
   - **Step 2:** Buat user database baru (misal: `u123456_admin`). Catat passwordnya!
   - **Step 3:** Centang **ALL PRIVILEGES** -> Save.
2. Buka menu **phpMyAdmin** di cPanel.
3. Klik database yang baru dibuat di sidebar kiri.
4. Klik tab **Import** -> Pilih file `yovantrans_db_production.sql` (file ini saya sertakan dalam zip).
5. Klik **Go** / **Import**.

## 4. Konfigurasi Koneksi (PENTING!)

Anda harus mengedit 1 file di hosting agar website connect ke database baru.

1. Di File Manager, buka `application/config/database.php`.
2. Klik kanan -> **Edit**.
3. Cari bagian ini dan sesuaikan dengan data database yang Anda buat di langkah 3:
   ```php
   'hostname' => 'localhost',
   'username' => 'u123456_admin', // Ganti dengan user database hosting
   'password' => 'PasswordAnda123', // Ganti dengan password database hosting
   'database' => 'u123456_yovantrans', // Ganti dengan nama database hosting
   ```
4. Save Changes.

## 5. Cek `config.php` (Opsional)

Biasanya `base_url` sudah saya set otomatis. Tapi jika website berantakan:

1. Buka `application/config/config.php`.
2. Pastikan:
   ```php
   $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
   $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
   $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
   ```
   (Ini setting otomatis yang sudah saya pasang, harusnya aman).

## 6. Selesai! 🚀

Buka domain Anda di browser. Website YovansTrans (termasuk Review & Counter) harusnya sudah live.
