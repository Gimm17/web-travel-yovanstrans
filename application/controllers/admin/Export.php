<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->library('auth_lib');
    }

    /**
     * Export data to CSV
     * @param string $type routes|pricing|posts|schedules|wa_clicks
     */
    public function csv($type = 'routes') {
        $filename = 'yovanstrans_' . $type . '_' . date('Ymd') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');
        // BOM for Excel UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        switch ($type) {
            case 'routes':
                $this->load->model('Route_model');
                fputcsv($output, ['ID', 'Asal', 'Tujuan', 'Jarak (km)', 'Durasi (jam)', 'Status']);
                foreach ($this->Route_model->get_all(false) as $r) {
                    fputcsv($output, [$r->id, $r->origin, $r->destination, $r->distance_km, $r->duration_hours, $r->is_active ? 'Aktif' : 'Nonaktif']);
                }
                break;

            case 'pricing':
                $this->load->model('Pricing_model');
                fputcsv($output, ['ID', 'Rute', 'Kelas', 'Harga Normal', 'Harga Promo', 'Promo Mulai', 'Promo Akhir']);
                foreach ($this->Pricing_model->get_all_with_details(true) as $p) {
                    fputcsv($output, [$p->id, $p->origin . ' → ' . $p->destination, $p->class_name, $p->price, $p->promo_price ?: '-', $p->promo_start ?: '-', $p->promo_end ?: '-']);
                }
                break;

            case 'posts':
                $this->load->model('Post_model');
                fputcsv($output, ['ID', 'Judul', 'Kategori', 'Status', 'Views', 'Tanggal']);
                foreach ($this->Post_model->get_all() as $p) {
                    fputcsv($output, [$p->id, $p->title, $p->category, $p->is_published ? 'Published' : 'Draft', $p->views, $p->published_at]);
                }
                break;

            case 'schedules':
                $this->load->model('Schedule_model');
                fputcsv($output, ['ID', 'Asal', 'Tujuan', 'Kelas', 'Jam Berangkat', 'Catatan', 'Status']);
                foreach ($this->Schedule_model->get_all_with_details() as $s) {
                    fputcsv($output, [$s->id, $s->origin, $s->destination, $s->class_name ?: 'Semua', $s->depart_time, $s->notes ?: '-', $s->is_active ? 'Aktif' : 'Nonaktif']);
                }
                break;

            case 'wa_clicks':
                $this->load->model('Wa_click_model');
                fputcsv($output, ['ID', 'Halaman', 'No. WA Agen', 'Info Rute', 'Waktu Klik', 'IP']);
                foreach ($this->Wa_click_model->get_recent(500) as $w) {
                    fputcsv($output, [$w->id, $w->source_page, $w->agent_wa, $w->route_info, $w->clicked_at, $w->user_ip]);
                }
                break;
        }
        fclose($output);
    }
}
