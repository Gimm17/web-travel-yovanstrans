<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Post_model');
        $this->load->library('upload');
    }
    public function index() {
        $data['admin_page'] = 'posts';
        $data['page_title'] = 'Berita & Artikel';
        $data['posts'] = $this->Post_model->get_all();
        $data['admin_view'] = 'admin/posts/index';
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data['admin_page'] = 'posts';
        $data['page_title'] = 'Tambah Artikel';
        if ($this->input->method() === 'post') {
            $insert = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', true),
                'content' => $this->input->post('content'),
                'category' => $this->input->post('category'),
                'is_published' => $this->input->post('is_published') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
                'published_at' => $this->input->post('is_published') ? date('Y-m-d H:i:s') : null,
            ];
            if ($_FILES['cover_image']['name']) {
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['max_size'] = 2048;
                $config['file_name'] = 'post_' . time();
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) {
                    $insert['cover_image'] = $this->upload->data('file_name');
                }
            } elseif ($this->input->post('ig_cover_image')) {
                // Use pre-downloaded Instagram image
                $ig_file = $this->input->post('ig_cover_image');
                if (file_exists('./assets/uploads/' . $ig_file)) {
                    $insert['cover_image'] = $ig_file;
                }
            }
            $this->Post_model->insert($insert);
            $this->session->set_flashdata('success', 'Artikel berhasil ditambahkan!');
            redirect('admin/posts');
        }
        $data['admin_view'] = 'admin/posts/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data['admin_page'] = 'posts';
        $data['page_title'] = 'Edit Artikel';
        $data['post'] = $this->Post_model->get_by_id($id);
        if (!$data['post']) show_404();
        if ($this->input->method() === 'post') {
            $update = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', true),
                'content' => $this->input->post('content'),
                'category' => $this->input->post('category'),
                'is_published' => $this->input->post('is_published') ? 1 : 0,
                'is_featured' => $this->input->post('is_featured') ? 1 : 0,
            ];
            if ($this->input->post('is_published') && !$data['post']->published_at) {
                $update['published_at'] = date('Y-m-d H:i:s');
            }
            if ($_FILES['cover_image']['name']) {
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|webp';
                $config['max_size'] = 2048;
                $config['file_name'] = 'post_' . time();
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) {
                    $update['cover_image'] = $this->upload->data('file_name');
                }
            }
            $this->Post_model->update($id, $update);
            $this->session->set_flashdata('success', 'Artikel berhasil diperbarui!');
            redirect('admin/posts');
        }
        $data['admin_view'] = 'admin/posts/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Post_model->delete($id);
        $this->session->set_flashdata('success', 'Artikel berhasil dihapus!');
        redirect('admin/posts');
    }
}
