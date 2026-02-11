<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Route_model');
    }
    public function index() {
        $data['admin_page'] = 'routes';
        $data['page_title'] = 'Kelola Rute';
        $data['routes'] = $this->Route_model->get_all(false);
        $data['admin_view'] = 'admin/routes/index';
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data['admin_page'] = 'routes';
        $data['page_title'] = 'Tambah Rute';
        if ($this->input->method() === 'post') {
            $this->Route_model->insert([
                'origin' => $this->input->post('origin'),
                'destination' => $this->input->post('destination'),
                'slug' => url_title($this->input->post('origin') . '-' . $this->input->post('destination'), 'dash', true),
                'distance_km' => $this->input->post('distance_km'),
                'duration_hours' => $this->input->post('duration_hours'),
                'description' => $this->input->post('description'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Rute berhasil ditambahkan!');
            redirect('admin/routes');
        }
        $data['admin_view'] = 'admin/routes/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data['admin_page'] = 'routes';
        $data['page_title'] = 'Edit Rute';
        $data['route'] = $this->Route_model->get_by_id($id);
        if (!$data['route']) show_404();
        if ($this->input->method() === 'post') {
            $this->Route_model->update($id, [
                'origin' => $this->input->post('origin'),
                'destination' => $this->input->post('destination'),
                'slug' => url_title($this->input->post('origin') . '-' . $this->input->post('destination'), 'dash', true),
                'distance_km' => $this->input->post('distance_km'),
                'duration_hours' => $this->input->post('duration_hours'),
                'description' => $this->input->post('description'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Rute berhasil diperbarui!');
            redirect('admin/routes');
        }
        $data['admin_view'] = 'admin/routes/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Route_model->delete($id);
        $this->session->set_flashdata('success', 'Rute berhasil dihapus!');
        redirect('admin/routes');
    }
}
