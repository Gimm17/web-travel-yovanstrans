<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model(['Wa_click_model', 'Post_model', 'Page_view_model']);
    }
    public function index() {
        $data = [
            'admin_page' => 'analytics',
            'page_title' => 'Analytics',
            // WA Clicks
            'wa_total' => $this->Wa_click_model->get_total(),
            'wa_today' => $this->Wa_click_model->get_today(),
            'by_page' => $this->Wa_click_model->get_stats_by_page(),
            'by_agent' => $this->Wa_click_model->get_stats_by_agent(),
            'daily_wa' => $this->Wa_click_model->get_daily_stats(),
            // Page Views
            'pv_total' => $this->Page_view_model->get_total(),
            'pv_today' => $this->Page_view_model->get_today(),
            'pv_unique_today' => $this->Page_view_model->get_unique_today(),
            'pv_unique_total' => $this->Page_view_model->get_unique_total(),
            'pv_by_page' => $this->Page_view_model->get_by_page(10),
            'daily_pv' => $this->Page_view_model->get_daily_stats(),
            'top_referrers' => $this->Page_view_model->get_top_referrers(5),
            // Post views
            'total_post_views' => $this->_get_total_post_views(),
            'admin_view' => 'admin/analytics',
        ];
        $this->load->view('admin/layouts/main', $data);
    }
    private function _get_total_post_views() {
        $result = $this->db->select_sum('views')->get('posts')->row();
        return $result ? (int) $result->views : 0;
    }
}
