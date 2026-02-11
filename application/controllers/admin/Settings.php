<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Setting_model');
    }
    public function index() {
        $data = ['admin_page' => 'settings', 'page_title' => 'Pengaturan'];
        $data['settings'] = $this->Setting_model->get_all();
        if ($this->input->method() === 'post') {
            $keys = $this->input->post('key_name');
            $values = $this->input->post('value');
            if ($keys && $values) {
                foreach ($keys as $i => $key) {
                    $this->Setting_model->set($key, $values[$i]);
                }
            }
            $this->session->set_flashdata('success', 'Pengaturan disimpan!');
            redirect('admin/settings');
        }
        $data['admin_view'] = 'admin/settings/index';
        $this->load->view('admin/layouts/main', $data);
    }
}
