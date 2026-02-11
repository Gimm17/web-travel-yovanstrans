<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Branch_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'paket';
        $data['page_title'] = 'Kirim Paket';
        $data['branches'] = $this->Branch_model->get_all();
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/paket';
        $this->load->view('layouts/main', $data);
    }
}
