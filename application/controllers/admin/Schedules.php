<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model(['Schedule_model', 'Route_model', 'Vehicle_class_model']);
    }
    public function index() {
        $data = ['admin_page' => 'schedules', 'page_title' => 'Kelola Jadwal',
            'schedules' => $this->Schedule_model->get_all_with_details(), 'admin_view' => 'admin/schedules/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'schedules', 'page_title' => 'Tambah Jadwal',
            'routes' => $this->Route_model->get_all(false), 'classes' => $this->Vehicle_class_model->get_all(false)];
        if ($this->input->method() === 'post') {
            $this->Schedule_model->insert([
                'route_id' => $this->input->post('route_id'), 'class_id' => $this->input->post('class_id'),
                'depart_time' => $this->input->post('depart_time'), 'notes' => $this->input->post('notes'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Jadwal ditambahkan!');
            redirect('admin/schedules');
        }
        $data['admin_view'] = 'admin/schedules/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'schedules', 'page_title' => 'Edit Jadwal',
            'routes' => $this->Route_model->get_all(false), 'classes' => $this->Vehicle_class_model->get_all(false)];
        $data['schedule'] = $this->Schedule_model->get_by_id($id);
        if (!$data['schedule']) show_404();
        if ($this->input->method() === 'post') {
            $this->Schedule_model->update($id, [
                'route_id' => $this->input->post('route_id'), 'class_id' => $this->input->post('class_id'),
                'depart_time' => $this->input->post('depart_time'), 'notes' => $this->input->post('notes'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Jadwal diperbarui!');
            redirect('admin/schedules');
        }
        $data['admin_view'] = 'admin/schedules/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Schedule_model->delete($id);
        $this->session->set_flashdata('success', 'Jadwal dihapus!');
        redirect('admin/schedules');
    }
}
