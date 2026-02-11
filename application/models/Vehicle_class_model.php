<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_class_model extends CI_Model {
    protected $table = 'vehicle_classes';

    public function get_all($active_only = true) {
        if ($active_only) $this->db->where('is_active', 1);
        return $this->db->order_by('sort_order', 'ASC')->get($this->table)->result();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
    public function count_all() { return $this->db->count_all($this->table); }

    // === Photo Gallery ===
    public function get_photos($class_id) {
        return $this->db->where('vehicle_class_id', $class_id)
                        ->order_by('sort_order', 'ASC')
                        ->get('vehicle_class_photos')->result();
    }

    public function insert_photo($data) {
        return $this->db->insert('vehicle_class_photos', $data);
    }

    public function delete_photo($photo_id) {
        $photo = $this->db->where('id', $photo_id)->get('vehicle_class_photos')->row();
        if ($photo) {
            // Delete file from disk
            $path = './assets/uploads/' . $photo->image;
            if (file_exists($path)) unlink($path);
            $this->db->where('id', $photo_id)->delete('vehicle_class_photos');
        }
        return $photo;
    }

    public function get_photo_by_id($photo_id) {
        return $this->db->where('id', $photo_id)->get('vehicle_class_photos')->row();
    }
}
