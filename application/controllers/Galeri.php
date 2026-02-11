<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Gallery_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'galeri';
        $data['page_title'] = 'Galeri';
        $data['albums'] = $this->Gallery_model->get_albums();
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/galeri';
        $this->load->view('layouts/main', $data);
    }
    public function album($slug) {
        $data['active_page'] = 'galeri';
        $data['album'] = $this->Gallery_model->get_album_by_slug($slug);
        if (!$data['album']) show_404();
        $data['items'] = $this->Gallery_model->get_items($data['album']->id);
        $data['page_title'] = $data['album']->title;
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/galeri_album';
        $this->load->view('layouts/main', $data);
    }
}
