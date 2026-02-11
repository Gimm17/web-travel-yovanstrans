<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonials extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Testimonial_model');
        $this->load->library('upload');
    }
    public function index() {
        $data = ['admin_page' => 'testimonials', 'page_title' => 'Kelola Testimoni',
            'testimonials' => $this->Testimonial_model->get_all(), 'admin_view' => 'admin/testimonials/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'testimonials', 'page_title' => 'Tambah Testimoni'];
        if ($this->input->method() === 'post') {
            $insert = [
                'name' => $this->input->post('name'),
                'route' => $this->input->post('route'),
                'content' => $this->input->post('content'),
                'rating' => $this->input->post('rating'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ];
            if ($_FILES['photo']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp',
                    'max_size' => 1024, 'file_name' => 'testi_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('photo')) {
                    $insert['photo_url'] = $this->upload->data('file_name');
                }
            }
            $this->Testimonial_model->insert($insert);
            $this->session->set_flashdata('success', 'Testimoni ditambahkan!');
            redirect('admin/testimonials');
        }
        $data['admin_view'] = 'admin/testimonials/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'testimonials', 'page_title' => 'Edit Testimoni'];
        $data['testimonial'] = $this->Testimonial_model->get_by_id($id);
        if (!$data['testimonial']) show_404();
        if ($this->input->method() === 'post') {
            $update = [
                'name' => $this->input->post('name'),
                'route' => $this->input->post('route'),
                'content' => $this->input->post('content'),
                'rating' => $this->input->post('rating'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ];
            if ($_FILES['photo']['name']) {
                $config = ['upload_path' => './assets/uploads/', 'allowed_types' => 'jpg|jpeg|png|webp',
                    'max_size' => 1024, 'file_name' => 'testi_' . time()];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('photo')) {
                    $update['photo_url'] = $this->upload->data('file_name');
                }
            }
            $this->Testimonial_model->update($id, $update);
            $this->session->set_flashdata('success', 'Testimoni diperbarui!');
            redirect('admin/testimonials');
        }
        $data['admin_view'] = 'admin/testimonials/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Testimonial_model->delete($id);
        $this->session->set_flashdata('success', 'Testimoni dihapus!');
        redirect('admin/testimonials');
    }
    public function approve($id) {
        $this->Testimonial_model->update($id, ['is_active' => 1]);
        $this->session->set_flashdata('success', 'Ulasan disetujui dan ditampilkan!');
        redirect('admin/testimonials');
    }
}
