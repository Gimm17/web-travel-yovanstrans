<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Branch_model', 'Route_model', 'Vehicle_class_model',
            'Schedule_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'pesan';
        $data['page_title'] = 'Pesan Tiket';
        $data['branches'] = $this->Branch_model->get_all();
        $data['routes'] = $this->Route_model->get_all();
        $data['classes'] = $this->Vehicle_class_model->get_all();
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/pesan';
        $this->load->view('layouts/main', $data);
    }
}
