-- ============================================
-- YOVANSTRANS DATABASE SCHEMA
-- ============================================
CREATE DATABASE IF NOT EXISTS `yovantrans_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yovantrans_db`;

-- ============================================
-- 1. USERS (Admin)
-- ============================================
CREATE TABLE `users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('superadmin','editor','cs') DEFAULT 'editor',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 2. BRANCHES (Agen Cabang)
-- ============================================
CREATE TABLE `branches` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `address` TEXT,
  `phone` VARCHAR(20),
  `wa_number` VARCHAR(20) NOT NULL,
  `maps_url` VARCHAR(500),
  `maps_embed` TEXT,
  `operational_hours` VARCHAR(100),
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 3. ROUTES (Rute)
-- ============================================
CREATE TABLE `routes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `origin` VARCHAR(100) NOT NULL,
  `destination` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(200) NOT NULL UNIQUE,
  `distance_km` INT DEFAULT NULL,
  `duration_hours` DECIMAL(4,1) DEFAULT NULL,
  `description` TEXT,
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 4. VEHICLE CLASSES (Kelas Armada)
-- ============================================
CREATE TABLE `vehicle_classes` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `seat_count` INT NOT NULL,
  `description` TEXT,
  `features` TEXT COMMENT 'JSON array: ["WiFi","AC","USB","CCTV"]',
  `highlight` VARCHAR(255),
  `cover_image` VARCHAR(255),
  `gallery_images` TEXT COMMENT 'JSON array of image paths',
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 5. FLEETS (Armada/Unit Kendaraan)
-- ============================================
CREATE TABLE `fleets` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `class_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(100) NOT NULL,
  `plate_number` VARCHAR(20),
  `cover_image` VARCHAR(255),
  `description` TEXT,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`class_id`) REFERENCES `vehicle_classes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 6. SCHEDULES (Jadwal)
-- ============================================
CREATE TABLE `schedules` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `route_id` INT UNSIGNED NOT NULL,
  `class_id` INT UNSIGNED DEFAULT NULL,
  `depart_time` TIME NOT NULL,
  `notes` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`class_id`) REFERENCES `vehicle_classes`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- 7. PRICINGS (Harga)
-- ============================================
CREATE TABLE `pricings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `route_id` INT UNSIGNED NOT NULL,
  `class_id` INT UNSIGNED NOT NULL,
  `price` INT NOT NULL COMMENT 'dalam ribuan (e.g. 175 = Rp 175.000)',
  `promo_price` INT DEFAULT NULL,
  `promo_label` VARCHAR(100),
  `promo_start` DATE DEFAULT NULL,
  `promo_end` DATE DEFAULT NULL,
  `notes` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`class_id`) REFERENCES `vehicle_classes`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 8. POSTS (Berita)
-- ============================================
CREATE TABLE `posts` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` TEXT,
  `excerpt` TEXT,
  `cover_image` VARCHAR(255),
  `category` ENUM('promo','event','jadwal','info','paket') DEFAULT 'info',
  `is_featured` TINYINT(1) DEFAULT 0,
  `is_published` TINYINT(1) DEFAULT 0,
  `published_at` DATETIME DEFAULT NULL,
  `author_id` INT UNSIGNED DEFAULT NULL,
  `views` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================
-- 9. EVENTS
-- ============================================
CREATE TABLE `events` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `content` TEXT,
  `cover_image` VARCHAR(255),
  `location` VARCHAR(255),
  `date_start` DATETIME,
  `date_end` DATETIME,
  `cta_text` VARCHAR(100),
  `cta_url` VARCHAR(500),
  `is_published` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 10. POPUPS (Promo Popup)
-- ============================================
CREATE TABLE `popups` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT,
  `image` VARCHAR(255),
  `cta_text` VARCHAR(100),
  `cta_url` VARCHAR(500),
  `date_start` DATETIME,
  `date_end` DATETIME,
  `frequency` ENUM('every_visit','once_per_day','once_only') DEFAULT 'once_per_day',
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 11. GALLERIES & GALLERY ITEMS
-- ============================================
CREATE TABLE `galleries` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT,
  `cover_image` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `gallery_items` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `gallery_id` INT UNSIGNED NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `caption` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`gallery_id`) REFERENCES `galleries`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 12. TESTIMONIALS
-- ============================================
CREATE TABLE `testimonials` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `route` VARCHAR(100),
  `content` TEXT NOT NULL,
  `rating` TINYINT DEFAULT 5,
  `photo` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `sort_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 13. FAQS
-- ============================================
CREATE TABLE `faqs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(500) NOT NULL,
  `answer` TEXT NOT NULL,
  `category` VARCHAR(100) DEFAULT 'umum',
  `sort_order` INT DEFAULT 0,
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- 14. SETTINGS (Key-Value)
-- ============================================
CREATE TABLE `settings` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `key_name` VARCHAR(100) NOT NULL UNIQUE,
  `value` TEXT,
  `type` ENUM('text','textarea','image','json') DEFAULT 'text',
  `label` VARCHAR(255),
  `group_name` VARCHAR(50) DEFAULT 'general'
) ENGINE=InnoDB;

-- ============================================
-- 15. BOOKING LOGS (optional tracking)
-- ============================================
CREATE TABLE `booking_logs` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `type` ENUM('tiket','paket') DEFAULT 'tiket',
  `name` VARCHAR(100),
  `phone` VARCHAR(20),
  `route` VARCHAR(100),
  `class` VARCHAR(50),
  `date` DATE,
  `passengers` INT DEFAULT 1,
  `pickup_point` VARCHAR(255),
  `notes` TEXT,
  `branch` VARCHAR(50),
  `ip_address` VARCHAR(45),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- SEED DATA
-- ============================================

-- Admin User (password: admin123)
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Administrator', 'admin@yovanstrans.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin');

-- Branches
INSERT INTO `branches` (`name`, `slug`, `address`, `phone`, `wa_number`, `maps_url`, `operational_hours`, `sort_order`) VALUES
('Agen Palu', 'palu', 'Jl. Soekarno Hatta, Kota Palu, Sulawesi Tengah', '0823-4908-5255', '6282349085255', 'https://goo.gl/maps/5pyZ5UYmY9sKfSD78', '06:00 - 21:00 WITA', 1),
('Agen Poso', 'poso', 'Jl. P. Irian, Kota Poso, Sulawesi Tengah', '0852-5177-7126', '6285251777126', 'https://maps.app.goo.gl/gM83PtrunJbaJZBQ8', '06:00 - 21:00 WITA', 2),
('Agen Tentena', 'tentena', 'Terminal Tentena, Kab. Poso, Sulawesi Tengah', '0852-4188-8182', '6285241888182', '', '06:00 - 21:00 WITA', 3);

-- Routes
INSERT INTO `routes` (`origin`, `destination`, `slug`, `distance_km`, `duration_hours`, `sort_order`) VALUES
('Palu', 'Poso', 'palu-poso', 220, 5.0, 1),
('Poso', 'Palu', 'poso-palu', 220, 5.0, 2),
('Palu', 'Tentena', 'palu-tentena', 270, 7.0, 3),
('Tentena', 'Palu', 'tentena-palu', 270, 7.0, 4),
('Poso', 'Tentena', 'poso-tentena', 55, 1.5, 5),
('Tentena', 'Poso', 'tentena-poso', 55, 1.5, 6);

-- Vehicle Classes
INSERT INTO `vehicle_classes` (`name`, `slug`, `seat_count`, `description`, `features`, `highlight`, `sort_order`) VALUES
('Executive Class', 'executive', 11, 'Kelas Executive dengan 11 kursi, dilengkapi fasilitas lengkap untuk perjalanan nyaman dan aman.', '["WiFi","Full AC","TV","CCTV","USB Charger","Alat Pemadam Api","Alat Pemecah Kaca"]', 'Paling Lengkap & Nyaman', 1),
('Business Class', 'business', 9, 'Kelas Business dengan 9 kursi yang lebih lega, cocok untuk perjalanan bisnis dan keluarga.', '["WiFi","Full AC","CCTV","USB Charger"]', 'Kursi Lega & Premium', 2),
('Premio Luxury', 'premio-luxury', 7, 'Kelas Premio Luxury dengan hanya 7 kursi super lega, pengalaman perjalanan paling mewah.', '["WiFi","Full AC","TV","CCTV","USB Charger","Karaoke","Meja Lipat","Snack"]', 'Ultra Premium — 7 Seat Only', 3);

-- Schedules
INSERT INTO `schedules` (`route_id`, `class_id`, `depart_time`, `notes`) VALUES
(1, 1, '07:00:00', 'Berangkat pagi'),
(1, 1, '10:00:00', 'Berangkat siang'),
(1, 1, '14:00:00', 'Berangkat sore'),
(1, 2, '08:00:00', NULL),
(1, 2, '13:00:00', NULL),
(1, 3, '09:00:00', 'Premio Luxury'),
(2, 1, '07:00:00', 'Berangkat pagi'),
(2, 1, '10:00:00', 'Berangkat siang'),
(2, 1, '14:00:00', 'Berangkat sore'),
(2, 2, '08:00:00', NULL),
(2, 3, '09:00:00', 'Premio Luxury'),
(3, 1, '07:00:00', 'Via Poso'),
(3, 1, '12:00:00', 'Via Poso'),
(3, 3, '08:00:00', 'Premio Luxury Via Poso'),
(4, 1, '07:00:00', 'Via Poso'),
(4, 1, '12:00:00', 'Via Poso'),
(4, 3, '08:00:00', 'Premio Luxury Via Poso'),
(5, 1, '08:00:00', NULL),
(5, 1, '14:00:00', NULL),
(6, 1, '08:00:00', NULL),
(6, 1, '14:00:00', NULL);

-- Pricing (dalam ribuan)
INSERT INTO `pricings` (`route_id`, `class_id`, `price`, `promo_price`, `promo_label`, `promo_start`, `promo_end`) VALUES
(1, 1, 175, 140, 'Promo Ramadhan', '2025-02-15', '2025-02-25'),
(1, 2, 200, NULL, NULL, NULL, NULL),
(1, 3, 250, NULL, NULL, NULL, NULL),
(2, 1, 175, 140, 'Promo Ramadhan', '2025-02-15', '2025-02-25'),
(2, 2, 200, NULL, NULL, NULL, NULL),
(2, 3, 250, NULL, NULL, NULL, NULL),
(3, 1, 240, 185, 'Promo Ramadhan', '2025-02-15', '2025-02-25'),
(3, 3, 300, NULL, NULL, NULL, NULL),
(4, 1, 240, 185, 'Promo Ramadhan', '2025-02-15', '2025-02-25'),
(4, 3, 300, NULL, NULL, NULL, NULL),
(5, 1, 75, NULL, NULL, NULL, NULL),
(6, 1, 75, NULL, NULL, NULL, NULL);

-- Testimonials
INSERT INTO `testimonials` (`name`, `route`, `content`, `rating`, `sort_order`) VALUES
('Andi S.', 'Palu - Poso', 'Pelayanannya sangat bagus, mobil bersih dan nyaman. Sopir ramah dan berpengalaman. Pasti pakai Yovanstrans lagi!', 5, 1),
('Siti R.', 'Palu - Tentena', 'Pertama kali naik kelas Premio Luxury, dan benar-benar worth it! Ada WiFi, karaoke, dan snack. Recommended banget!', 5, 2),
('Budi P.', 'Poso - Palu', 'Jadwal selalu tepat waktu, harga terjangkau. Sudah 3 kali pakai Yovanstrans dan selalu puas.', 5, 3),
('Maria L.', 'Tentena - Palu', 'Kirim paket dari Tentena ke Palu sangat mudah dan cepat sampai. Harga murah mulai 15rb!', 5, 4);

-- FAQs
INSERT INTO `faqs` (`question`, `answer`, `category`, `sort_order`) VALUES
('Bagaimana cara memesan tiket?', 'Anda bisa memesan tiket melalui WhatsApp kami. Klik tombol "Pesan via WA" di website, isi form pemesanan, lalu pesan akan otomatis terkirim ke agen kami.', 'pemesanan', 1),
('Apakah bisa dijemput di lokasi?', 'Ya, kami menyediakan layanan jemput di titik tertentu. Silakan informasikan titik jemput Anda saat pemesanan via WhatsApp.', 'pemesanan', 2),
('Berapa batas bagasi?', 'Setiap penumpang diperbolehkan membawa 1 koper besar dan 1 tas kecil. Untuk bagasi berlebih akan dikenakan biaya tambahan.', 'umum', 3),
('Apakah ada fasilitas WiFi di mobil?', 'Ya, semua kelas armada kami dilengkapi WiFi gratis, AC, dan USB charger. Kelas Executive dan Premio Luxury memiliki fasilitas tambahan.', 'fasilitas', 4),
('Bagaimana jika ingin membatalkan tiket?', 'Pembatalan bisa dilakukan minimal 3 jam sebelum keberangkatan dengan menghubungi agen via WhatsApp. Biaya pembatalan mungkin berlaku.', 'pemesanan', 5),
('Apakah bisa kirim paket saja tanpa penumpang?', 'Tentu bisa! Kami melayani pengiriman paket antar kota mulai dari Rp 15.000. Hubungi agen terdekat untuk info lebih lanjut.', 'paket', 6),
('Jam berapa keberangkatan paling pagi?', 'Keberangkatan paling pagi biasanya pukul 07:00 WITA. Cek halaman Jadwal untuk info lengkap.', 'jadwal', 7),
('Apakah ada CCTV di dalam mobil?', 'Ya, semua armada kami dilengkapi CCTV untuk keamanan dan kenyamanan penumpang.', 'fasilitas', 8);

-- Settings
INSERT INTO `settings` (`key_name`, `value`, `type`, `label`, `group_name`) VALUES
('site_name', 'YovansTranss Shuttle', 'text', 'Nama Website', 'general'),
('site_tagline', 'Melayani Rute Perjalanan Darat PP Palu - Poso - Tentena', 'text', 'Tagline', 'general'),
('site_description', 'YovansTranss Shuttle - Layanan travel dan shuttle premium rute Palu, Poso, Tentena. Armada nyaman, harga terjangkau, pemesanan mudah via WhatsApp.', 'textarea', 'Deskripsi Website', 'general'),
('site_logo', '', 'image', 'Logo', 'general'),
('site_favicon', '', 'image', 'Favicon', 'general'),
('default_wa_number', '6282349085255', 'text', 'WhatsApp Default', 'contact'),
('instagram_url', 'https://instagram.com/yovanstrans', 'text', 'Instagram', 'social'),
('facebook_url', '', 'text', 'Facebook', 'social'),
('wa_template_tiket', 'Halo kak, saya mau pesan tiket:\nNama: {nama}\nRute: {rute}\nTanggal: {tanggal}\nJam: {jam}\nKelas: {kelas}\nJumlah penumpang: {jumlah}\nTitik jemput: {jemput}\nCatatan: {catatan}', 'textarea', 'Template WA Tiket', 'wa'),
('wa_template_paket', 'Halo kak, saya mau kirim paket:\nNama: {nama}\nAsal: {asal}\nTujuan: {tujuan}\nJenis Barang: {jenis}\nBerat Perkiraan: {berat}\nCatatan: {catatan}', 'textarea', 'Template WA Paket', 'wa'),
('footer_text', '© 2025 YovansTranss Shuttle. All rights reserved.', 'text', 'Footer Text', 'general');
