<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Post_model', 'Popup_model']);
    }
    public function index() {
        $data['active_page'] = 'berita';
        $data['page_title'] = 'Berita & Event';
        $data['posts'] = $this->Post_model->get_published(12);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/berita';
        $this->load->view('layouts/main', $data);
    }
    public function detail($slug) {
        $data['active_page'] = 'berita';
        $data['post'] = $this->Post_model->get_by_slug($slug);
        if (!$data['post']) show_404();
        $this->Post_model->increment_views($data['post']->id);
        $data['page_title'] = $data['post']->title;
        $data['recent'] = $this->Post_model->get_published(5);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/berita_detail';
        $this->load->view('layouts/main', $data);
    }
}
