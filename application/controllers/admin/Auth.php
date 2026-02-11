<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Login_attempt_model');
    }

    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin');
        }

        if ($this->input->method() === 'post') {
            $email = trim($this->input->post('email'));
            $password = $this->input->post('password');
            $ip = $this->input->ip_address();

            // Brute-force protection: max 5 attempts per 15 minutes
            if ($this->Login_attempt_model->is_throttled($ip, $email, 5, 15)) {
                $data['error'] = 'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.';
                $data['page_title'] = 'Login Admin';
                $this->load->view('admin/login', $data);
                return;
            }

            $user = $this->User_model->verify_password($email, $password);
            if ($user) {
                // Clear failed attempts on successful login
                $this->Login_attempt_model->clear_attempts($ip, $email);
                $this->session->set_userdata([
                    'admin_logged_in' => true,
                    'admin_id' => $user->id,
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'admin_role' => $user->role
                ]);
                redirect('admin');
            } else {
                // Record failed attempt
                $this->Login_attempt_model->record_attempt($email, $ip);
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
