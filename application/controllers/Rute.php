<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rute extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Route_model', 'Schedule_model', 'Popup_model']);
    }

    public function index() {
        $data['active_page'] = 'rute';
        $data['page_title'] = 'Rute & Jadwal';
        $data['routes'] = $this->Route_model->get_with_schedules(true);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/rute';
        $this->load->view('layouts/main', $data);
    }

    public function detail($slug) {
        $data['active_page'] = 'rute';
        $data['route'] = $this->Route_model->get_by_slug($slug);
        if (!$data['route']) show_404();
        $data['page_title'] = $data['route']->origin . ' → ' . $data['route']->destination;
        $data['schedules'] = $this->Schedule_model->get_by_route($data['route']->id);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/rute_detail';
        $this->load->view('layouts/main', $data);
    }
}
