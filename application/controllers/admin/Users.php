<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->library('auth_lib');
        $this->auth_lib->require_role('superadmin');
        $this->load->model('User_model');
    }
    public function index() {
        $data = ['admin_page' => 'users', 'page_title' => 'Kelola User',
            'users' => $this->User_model->get_all(), 'admin_view' => 'admin/users/index'];
        $this->load->view('admin/layouts/main', $data);
    }
    public function create() {
        $data = ['admin_page' => 'users', 'page_title' => 'Tambah User'];
        if ($this->input->method() === 'post') {
            $this->User_model->insert([
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            redirect('admin/users');
        }
        $data['admin_view'] = 'admin/users/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function edit($id) {
        $data = ['admin_page' => 'users', 'page_title' => 'Edit User'];
        $data['user'] = $this->User_model->get_by_id($id);
        if (!$data['user']) show_404();
        if ($this->input->method() === 'post') {
            $update = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
            ];
            $pw = $this->input->post('password');
            if ($pw) $update['password'] = password_hash($pw, PASSWORD_DEFAULT);
            $this->User_model->update($id, $update);
            $this->session->set_flashdata('success', 'User berhasil diperbarui!');
            redirect('admin/users');
        }
        $data['admin_view'] = 'admin/users/form';
        $this->load->view('admin/layouts/main', $data);
    }
    public function delete($id) {
        if ($id == $this->session->userdata('admin_id')) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus diri sendiri!');
        } else {
            $this->User_model->delete($id);
            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        }
        redirect('admin/users');
    }
}
