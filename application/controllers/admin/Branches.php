<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branches extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Branch_model');
    }

    public function index() {
        $data['admin_page'] = 'branches';
        $data['page_title'] = 'Kelola Agen';
        $data['branches'] = $this->Branch_model->get_all(false);
        $data['admin_view'] = 'admin/branches/index';
        $this->load->view('admin/layouts/main', $data);
    }

    public function create() {
        $data['admin_page'] = 'branches';
        $data['page_title'] = 'Tambah Agen';
        if ($this->input->method() === 'post') {
            $this->Branch_model->insert([
                'name'              => $this->input->post('name'),
                'slug'              => url_title($this->input->post('name'), 'dash', true),
                'address'           => $this->input->post('address'),
                'phone'             => $this->input->post('phone'),
                'wa_number'         => $this->input->post('wa_number'),
                'operational_hours' => $this->input->post('operational_hours'),
                'maps_url'          => $this->input->post('maps_url'),
                'sort_order'        => $this->input->post('sort_order') ?: 0,
                'is_active'         => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Agen berhasil ditambahkan!');
            redirect('admin/branches');
        }
        $data['admin_view'] = 'admin/branches/form';
        $this->load->view('admin/layouts/main', $data);
    }

    public function edit($id) {
        $data['admin_page'] = 'branches';
        $data['page_title'] = 'Edit Agen';
        $data['branch'] = $this->Branch_model->get_by_id($id);
        if (!$data['branch']) show_404();
        if ($this->input->method() === 'post') {
            $this->Branch_model->update($id, [
                'name'              => $this->input->post('name'),
                'slug'              => url_title($this->input->post('name'), 'dash', true),
                'address'           => $this->input->post('address'),
                'phone'             => $this->input->post('phone'),
                'wa_number'         => $this->input->post('wa_number'),
                'operational_hours' => $this->input->post('operational_hours'),
                'maps_url'          => $this->input->post('maps_url'),
                'sort_order'        => $this->input->post('sort_order') ?: 0,
                'is_active'         => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Agen berhasil diperbarui!');
            redirect('admin/branches');
        }
        $data['admin_view'] = 'admin/branches/form';
        $this->load->view('admin/layouts/main', $data);
    }

    public function delete($id) {
        $this->Branch_model->delete($id);
        $this->session->set_flashdata('success', 'Agen berhasil dihapus!');
        redirect('admin/branches');
    }
}
