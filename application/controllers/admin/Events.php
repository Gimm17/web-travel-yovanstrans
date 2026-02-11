<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Event_model');
        $this->load->library('upload');
    }
    public function index() {
        $data = ['admin_page' => 'events', 'page_title' => 'Kelola Event',
            'events' => $this->Event_model->get_all(), 'admin_view' => 'admin/events/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'events', 'page_title' => 'Tambah Event'];
        if ($this->input->method() === 'post') {
            $insert = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', true),
                'content' => $this->input->post('content'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'location' => $this->input->post('location'),
                'is_published' => $this->input->post('is_published') ? 1 : 0,
            ];
            if ($_FILES['cover_image']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp',
                    'max_size' => 2048, 'file_name' => 'event_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) {
                    $insert['cover_image'] = $this->upload->data('file_name');
                }
            } elseif ($this->input->post('ig_cover_image')) {
                $ig_file = $this->input->post('ig_cover_image');
                if (file_exists('./assets/uploads/' . $ig_file)) {
                    $insert['cover_image'] = $ig_file;
                }
            }
            $this->Event_model->insert($insert);
            $this->session->set_flashdata('success', 'Event berhasil ditambahkan!');
            redirect('admin/events');
        }
        $data['admin_view'] = 'admin/events/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'events', 'page_title' => 'Edit Event'];
        $data['event'] = $this->Event_model->get_by_id($id);
        if (!$data['event']) show_404();
        if ($this->input->method() === 'post') {
            $update = [
                'title' => $this->input->post('title'),
                'slug' => url_title($this->input->post('title'), 'dash', true),
                'content' => $this->input->post('content'),
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'location' => $this->input->post('location'),
                'is_published' => $this->input->post('is_published') ? 1 : 0,
            ];
            if ($_FILES['cover_image']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp',
                    'max_size' => 2048, 'file_name' => 'event_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('cover_image')) {
                    $update['cover_image'] = $this->upload->data('file_name');
                }
            }
            $this->Event_model->update($id, $update);
            $this->session->set_flashdata('success', 'Event berhasil diperbarui!');
            redirect('admin/events');
        }
        $data['admin_view'] = 'admin/events/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Event_model->delete($id);
        $this->session->set_flashdata('success', 'Event berhasil dihapus!');
        redirect('admin/events');
    }
}
