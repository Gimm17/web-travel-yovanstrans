<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WhatsApp Helper — build WA API links
 */

if (!function_exists('wa_url')) {
    /**
     * Build WhatsApp API URL
     * @param string $phone Phone number (e.g. 6282349085255)
     * @param string $text  Pre-filled message
     * @return string
     */
    function wa_url($phone, $text = '') {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $url = 'https://api.whatsapp.com/send?phone=' . $phone;
        if ($text) {
            $url .= '&text=' . urlencode($text);
        }
        return $url;
    }
}

if (!function_exists('wa_tiket_msg')) {
    /**
     * Build WhatsApp booking message from form data
     */
    function wa_tiket_msg($data) {
        $msg = "Halo kak, saya mau pesan tiket:\n";
        $msg .= "Nama: " . ($data['nama'] ?? '') . "\n";
        $msg .= "Rute: " . ($data['rute'] ?? '') . "\n";
        $msg .= "Tanggal: " . ($data['tanggal'] ?? '') . "\n";
        $msg .= "Jam: " . ($data['jam'] ?? '') . "\n";
        $msg .= "Kelas: " . ($data['kelas'] ?? '') . "\n";
        $msg .= "Jumlah penumpang: " . ($data['jumlah'] ?? '1') . "\n";
        $msg .= "Titik jemput: " . ($data['jemput'] ?? '') . "\n";
        $msg .= "Catatan: " . ($data['catatan'] ?? '-');
        return $msg;
    }
}

if (!function_exists('wa_paket_msg')) {
    /**
     * Build WhatsApp package message from form data
     */
    function wa_paket_msg($data) {
        $msg = "Halo kak, saya mau kirim paket:\n";
        $msg .= "Nama: " . ($data['nama'] ?? '') . "\n";
        $msg .= "Asal: " . ($data['asal'] ?? '') . "\n";
        $msg .= "Tujuan: " . ($data['tujuan'] ?? '') . "\n";
        $msg .= "Jenis Barang: " . ($data['jenis'] ?? '') . "\n";
        $msg .= "Berat Perkiraan: " . ($data['berat'] ?? '') . "\n";
        $msg .= "Catatan: " . ($data['catatan'] ?? '-');
        return $msg;
    }
}

if (!function_exists('format_price')) {
    /**
     * Format price in IDR
     * @param int $price Price in thousands
     */
    function format_price($price) {
        return 'Rp ' . number_format($price * 1000, 0, ',', '.');
    }
}
