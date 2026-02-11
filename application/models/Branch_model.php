<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {
    protected $table = 'branches';

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
}
