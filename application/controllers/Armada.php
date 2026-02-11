<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Armada extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Vehicle_class_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'armada';
        $data['page_title'] = 'Armada & Kelas';
        $data['classes'] = $this->Vehicle_class_model->get_all();
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/armada';
        $this->load->view('layouts/main', $data);
    }
    public function detail($slug) {
        $data['active_page'] = 'armada';
        $data['cls'] = $this->Vehicle_class_model->get_by_slug($slug);
        if (!$data['cls']) show_404();
        $data['page_title'] = $data['cls']->name;
        $data['photos'] = $this->Vehicle_class_model->get_photos($data['cls']->id);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/armada_detail';
        $this->load->view('layouts/main', $data);
    }
}
