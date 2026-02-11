<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {
    protected $table = 'faqs';
    public function get_active($limit = null) {
        $this->db->where('is_active', 1)->order_by('sort_order', 'ASC');
        if ($limit) $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }
    public function get_by_category($category) {
        return $this->db->where('is_active', 1)->where('category', $category)->order_by('sort_order', 'ASC')->get($this->table)->result();
    }
    public function get_by_id($id) { return $this->db->where('id', $id)->get($this->table)->row(); }
    public function get_all() { return $this->db->order_by('sort_order', 'ASC')->get($this->table)->result(); }
    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
