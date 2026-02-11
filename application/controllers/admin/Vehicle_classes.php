<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_classes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_logged_in')) redirect('admin/login');
        $this->load->model('Vehicle_class_model');
    }

    public function index() {
        $data['admin_page'] = 'vehicle_classes';
        $data['page_title'] = 'Kelola Armada & Kelas';
        $data['classes'] = $this->Vehicle_class_model->get_all(false);
        $data['admin_view'] = 'admin/vehicle_classes/index';
        $this->load->view('admin/layouts/main', $data);
    }

    public function create() {
        $data['admin_page'] = 'vehicle_classes';
        $data['page_title'] = 'Tambah Kelas Armada';
        if ($this->input->method() === 'post') {
            $cover_image = $this->_upload_image('cover_image');

            $features_input = $this->input->post('features');
            $features_array = array_filter(array_map('trim', explode("\n", $features_input)));
            $features_json = json_encode(array_values($features_array));

            $this->Vehicle_class_model->insert([
                'name'          => $this->input->post('name'),
                'slug'          => url_title($this->input->post('name'), '-', true),
                'seat_count'    => $this->input->post('seat_count'),
                'highlight'     => $this->input->post('highlight'),
                'description'   => $this->input->post('description'),
                'features'      => $features_json,
                'cover_image'   => $cover_image,
                'sort_order'    => $this->input->post('sort_order') ?: 0,
                'is_active'     => $this->input->post('is_active') ? 1 : 0,
            ]);
            $this->session->set_flashdata('success', 'Kelas armada berhasil ditambahkan!');
            redirect('admin/vehicle_classes');
        }
        $data['admin_view'] = 'admin/vehicle_classes/form';
        $this->load->view('admin/layouts/main', $data);
    }

    public function edit($id) {
        $data['admin_page'] = 'vehicle_classes';
        $data['page_title'] = 'Edit Kelas Armada';
        $data['class'] = $this->Vehicle_class_model->get_by_id($id);
        if (!$data['class']) show_404();
        $data['photos'] = $this->Vehicle_class_model->get_photos($id);

        if ($this->input->method() === 'post') {
            $update_data = [
                'name'          => $this->input->post('name'),
                'slug'          => url_title($this->input->post('name'), '-', true),
                'seat_count'    => $this->input->post('seat_count'),
                'highlight'     => $this->input->post('highlight'),
                'description'   => $this->input->post('description'),
                'sort_order'    => $this->input->post('sort_order') ?: 0,
                'is_active'     => $this->input->post('is_active') ? 1 : 0,
            ];

            $features_input = $this->input->post('features');
            $features_array = array_filter(array_map('trim', explode("\n", $features_input)));
            $update_data['features'] = json_encode(array_values($features_array));

            // Handle cover image upload
            $cover = $this->_upload_image('cover_image');
            if ($cover) $update_data['cover_image'] = $cover;

            $this->Vehicle_class_model->update($id, $update_data);

            // Handle multiple gallery photos upload
            if (!empty($_FILES['gallery_photos']['name'][0])) {
                $this->_upload_gallery_photos($id);
            }

            $this->session->set_flashdata('success', 'Kelas armada berhasil diperbarui!');
            redirect('admin/vehicle_classes');
        }
        $data['admin_view'] = 'admin/vehicle_classes/form';
        $this->load->view('admin/layouts/main', $data);
    }

    public function delete($id) {
        // Delete all photos first
        $photos = $this->Vehicle_class_model->get_photos($id);
        foreach ($photos as $p) {
            $this->Vehicle_class_model->delete_photo($p->id);
        }
        $this->Vehicle_class_model->delete($id);
        $this->session->set_flashdata('success', 'Kelas armada berhasil dihapus!');
        redirect('admin/vehicle_classes');
    }

    public function delete_photo($photo_id) {
        $photo = $this->Vehicle_class_model->get_photo_by_id($photo_id);
        if (!$photo) show_404();
        $class_id = $photo->vehicle_class_id;
        $this->Vehicle_class_model->delete_photo($photo_id);
        $this->session->set_flashdata('success', 'Foto berhasil dihapus!');
        redirect('admin/vehicle_classes/edit/' . $class_id);
    }

    // === Helper: Upload single image ===
    private function _upload_image($field_name) {
        if (empty($_FILES[$field_name]['name'])) return '';
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        if ($this->upload->do_upload($field_name)) {
            return $this->upload->data('file_name');
        }
        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
        return '';
    }

    // === Helper: Upload multiple gallery photos ===
    private function _upload_gallery_photos($class_id) {
        $files = $_FILES['gallery_photos'];
        $count = count($files['name']);
        for ($i = 0; $i < $count; $i++) {
            if (empty($files['name'][$i])) continue;
            // Re-arrange $_FILES for CI upload
            $_FILES['gallery_single'] = [
                'name'     => $files['name'][$i],
                'type'     => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error'    => $files['error'][$i],
                'size'     => $files['size'][$i],
            ];
            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('gallery_single')) {
                $this->Vehicle_class_model->insert_photo([
                    'vehicle_class_id' => $class_id,
                    'image'            => $this->upload->data('file_name'),
                    'caption'          => '',
                    'sort_order'       => $i,
                ]);
            }
        }
    }
}
