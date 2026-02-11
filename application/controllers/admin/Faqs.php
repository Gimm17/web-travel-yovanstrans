<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Faq_model');
    }
    public function index() {
        $data = ['admin_page' => 'faqs', 'page_title' => 'Kelola FAQ',
            'faqs' => $this->Faq_model->get_all(), 'admin_view' => 'admin/faqs/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'faqs', 'page_title' => 'Tambah FAQ'];
        if ($this->input->method() === 'post') {
            $this->Faq_model->insert([
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer'),
                'category' => $this->input->post('category'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'FAQ ditambahkan!');
            redirect('admin/faqs');
        }
        $data['admin_view'] = 'admin/faqs/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'faqs', 'page_title' => 'Edit FAQ'];
        $data['faq'] = $this->Faq_model->get_by_id($id);
        if (!$data['faq']) show_404();
        if ($this->input->method() === 'post') {
            $this->Faq_model->update($id, [
                'question' => $this->input->post('question'),
                'answer' => $this->input->post('answer'),
                'category' => $this->input->post('category'),
                'sort_order' => $this->input->post('sort_order') ?: 0,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'FAQ diperbarui!');
            redirect('admin/faqs');
        }
        $data['admin_view'] = 'admin/faqs/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        $this->Faq_model->delete($id);
        $this->session->set_flashdata('success', 'FAQ dihapus!');
        redirect('admin/faqs');
    }
}
