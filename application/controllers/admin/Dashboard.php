<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model(['Route_model', 'Post_model', 'Branch_model', 'Vehicle_class_model',
            'Testimonial_model', 'Faq_model', 'Gallery_model', 'Wa_click_model', 'Event_model', 'Page_view_model']);
    }
    public function index() {
        $data['admin_page'] = 'dashboard';
        $data['page_title'] = 'Dashboard';
        $data['total_routes'] = $this->Route_model->count_all();
        $data['total_posts'] = $this->Post_model->count_published();
        $data['total_branches'] = $this->Branch_model->count_all();
        $data['wa_total'] = $this->Wa_click_model->get_total();
        $data['wa_today'] = $this->Wa_click_model->get_today();
        $data['pv_total'] = $this->Page_view_model->get_total();
        $data['pv_today'] = $this->Page_view_model->get_today();
        $data['recent_posts'] = $this->Post_model->get_published(5);
        $data['admin_view'] = 'admin/dashboard_view';
        $this->load->view('admin/layouts/main', $data);
    }
}
