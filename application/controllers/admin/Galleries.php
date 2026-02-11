<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galleries extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Gallery_model');
        $this->load->library('upload');
    }
    public function index() {
        $data = ['admin_page' => 'galleries', 'page_title' => 'Kelola Galeri',
            'albums' => $this->Gallery_model->get_albums(false), 'admin_view' => 'admin/galleries/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'galleries', 'page_title' => 'Tambah Album'];
        if ($this->input->method() === 'post') {
            $insert = ['title' => $this->input->post('title'), 'slug' => url_title($this->input->post('title'), 'dash', true),
                'description' => $this->input->post('description'), 'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0];
            if ($_FILES['cover_image']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 2048, 'file_name' => 'gallery_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) $insert['cover_image'] = $this->upload->data('file_name');
            }
            $album_id = $this->Gallery_model->insert_album($insert);
            $this->session->set_flashdata('success', 'Album ditambahkan!');
            redirect('admin/galleries');
        }
        $data['admin_view'] = 'admin/galleries/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'galleries', 'page_title' => 'Edit Album'];
        $data['album'] = $this->Gallery_model->get_album_by_id($id);
        if (!$data['album']) show_404();
        $data['items'] = $this->Gallery_model->get_items($id);
        if ($this->input->method() === 'post') {
            $update = ['title' => $this->input->post('title'), 'slug' => url_title($this->input->post('title'), 'dash', true),
                'description' => $this->input->post('description'), 'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0];
            if ($_FILES['cover_image']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 2048, 'file_name' => 'gallery_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) $update['cover_image'] = $this->upload->data('file_name');
            }
            $this->Gallery_model->update_album($id, $update);
            $this->session->set_flashdata('success', 'Album diperbarui!');
            redirect('admin/galleries/edit/' . $id);
        }
        $data['admin_view'] = 'admin/galleries/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function add_item($album_id) {
        if ($_FILES['image']['name']) {
            $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 2048, 'file_name' => 'gi_' . time()];
            $this->upload->initialize($config);
            if ($this->upload->do_upload('image')) {
                $this->Gallery_model->insert_item([
                    'gallery_id' => $album_id,
                    'image' => $this->upload->data('file_name'),
                    'caption' => $this->input->post('caption')
                ]);
                $this->session->set_flashdata('success', 'Foto ditambahkan!');
            }
        }
        redirect('admin/galleries/edit/' . $album_id);
    }
    public function delete_item($id, $album_id) {
        $this->Gallery_model->delete_item($id);
        $this->session->set_flashdata('success', 'Foto dihapus!');
        redirect('admin/galleries/edit/' . $album_id);
    }
    public function delete($id) {
        $this->Gallery_model->delete_album($id);
        $this->session->set_flashdata('success', 'Album dihapus!');
        redirect('admin/galleries');
    }
}
