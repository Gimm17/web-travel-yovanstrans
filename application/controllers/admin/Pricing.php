<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model(['Pricing_model', 'Route_model', 'Vehicle_class_model']);
    }
    public function index() {
        $data['admin_page'] = 'pricing';
        $data['page_title'] = 'Kelola Harga';
        $data['pricings'] = $this->Pricing_model->get_all_with_details();
        $data['admin_view'] = 'admin/pricing/index';
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data['admin_page'] = 'pricing';
        $data['page_title'] = 'Tambah Harga';
        $data['routes'] = $this->Route_model->get_all(false);
        $data['classes'] = $this->Vehicle_class_model->get_all(false);
        if ($this->input->method() === 'post') {
            $this->Pricing_model->insert([
                'route_id' => $this->input->post('route_id'),
                'class_id' => $this->input->post('class_id'),
                'price' => $this->input->post('price'),
                'promo_price' => $this->input->post('promo_price') ?: null,
                'promo_label' => $this->input->post('promo_label'),
                'promo_start' => $this->input->post('promo_start') ?: null,
                'promo_end' => $this->input->post('promo_end') ?: null,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Harga berhasil ditambahkan!');
            redirect('admin/pricing');
        }
        $data['admin_view'] = 'admin/pricing/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data['admin_page'] = 'pricing';
        $data['page_title'] = 'Edit Harga';
        $data['pricing'] = $this->Pricing_model->get_by_id($id);
        if (!$data['pricing']) show_404();
        $data['routes'] = $this->Route_model->get_all(false);
        $data['classes'] = $this->Vehicle_class_model->get_all(false);
        if ($this->input->method() === 'post') {
            $this->Pricing_model->update($id, [
                'route_id' => $this->input->post('route_id'),
                'class_id' => $this->input->post('class_id'),
                'price' => $this->input->post('price'),
                'promo_price' => $this->input->post('promo_price') ?: null,
                'promo_label' => $this->input->post('promo_label'),
                'promo_start' => $this->input->post('promo_start') ?: null,
                'promo_end' => $this->input->post('promo_end') ?: null,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Harga berhasil diperbarui!');
            redirect('admin/pricing');
        }
        $data['admin_view'] = 'admin/pricing/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Pricing_model->delete($id);
        $this->session->set_flashdata('success', 'Harga berhasil dihapus!');
        redirect('admin/pricing');
    }
}
