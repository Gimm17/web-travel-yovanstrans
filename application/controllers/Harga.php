<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Harga extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Pricing_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'harga';
        $data['page_title'] = 'Harga Tiket';
        $data['grouped'] = $this->Pricing_model->get_grouped_by_class();
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/harga';
        $this->load->view('layouts/main', $data);
    }
}
