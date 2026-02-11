<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popups extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model(['Popup_model', 'Post_model']);
        $this->load->library('upload');
    }
    public function index() {
        $data = ['admin_page' => 'popups', 'page_title' => 'Kelola Popup',
            'popups' => $this->Popup_model->get_all(), 'admin_view' => 'admin/popups/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'popups', 'page_title' => 'Tambah Popup'];
        $data['posts'] = $this->Post_model->get_published(50);
        if ($this->input->method() === 'post') {
            $type = $this->input->post('popup_type') ?: 'custom';
            $insert = [
                'popup_type' => $type,
                'event_id' => null,
                'post_id' => $type !== 'custom' ? $this->input->post('post_id') : null,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'cta_text' => $this->input->post('cta_text'),
                'cta_url' => $this->input->post('cta_url'),
                'frequency' => $this->input->post('frequency'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'date_start' => $this->input->post('date_start') ?: null,
                'date_end' => $this->input->post('date_end') ?: null,
            ];
            if (!empty($_FILES['image']['name'])) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 2048, 'file_name' => 'popup_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) $insert['image'] = $this->upload->data('file_name');
            }
            $this->Popup_model->insert($insert);
            $this->session->set_flashdata('success', 'Popup ditambahkan!');
            redirect('admin/popups');
        }
        $data['admin_view'] = 'admin/popups/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'popups', 'page_title' => 'Edit Popup'];
        $data['popup'] = $this->Popup_model->get_by_id($id);
        if (!$data['popup']) show_404();
        $data['posts'] = $this->Post_model->get_published(50);
        if ($this->input->method() === 'post') {
            $type = $this->input->post('popup_type') ?: 'custom';
            $update = [
                'popup_type' => $type,
                'event_id' => null,
                'post_id' => $type !== 'custom' ? $this->input->post('post_id') : null,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'cta_text' => $this->input->post('cta_text'),
                'cta_url' => $this->input->post('cta_url'),
                'frequency' => $this->input->post('frequency'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'date_start' => $this->input->post('date_start') ?: null,
                'date_end' => $this->input->post('date_end') ?: null,
            ];
            if (!empty($_FILES['image']['name'])) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp', 'max_size' => 2048, 'file_name' => 'popup_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) $update['image'] = $this->upload->data('file_name');
            }
            $this->Popup_model->update($id, $update);
            $this->session->set_flashdata('success', 'Popup diperbarui!');
            redirect('admin/popups');
        }
        $data['admin_view'] = 'admin/popups/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Popup_model->delete($id);
        $this->session->set_flashdata('success', 'Popup dihapus!');
        redirect('admin/popups');
    }
}
