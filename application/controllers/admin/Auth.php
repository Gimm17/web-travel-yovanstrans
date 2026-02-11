<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }

        if ($this->input->method() === 'post') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->verify_password($email, $password);
            if ($user) {
                $this->session->set_userdata([
                    'admin_logged_in' => true,
                    'admin_id' => $user->id,
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'admin_role' => $user->role
                ]);
                redirect('admin');
            } else {
                $data['error'] = 'Email atau password salah!';
            }
        }

        $data['page_title'] = 'Login Admin';
        $this->load->view('admin/login', isset($data) ? $data : []);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}
