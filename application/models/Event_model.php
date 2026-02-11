<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {
    protected $table = 'events';
    public function get_published($limit = null) {
        $this->db->where('is_published', 1)->order_by('date_start', 'DESC');
        if ($limit) $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }
    public function get_upcoming($limit = 3) {
        return $this->db->where('is_published', 1)->where('date_end >=', date('Y-m-d'))
            ->order_by('date_start', 'ASC')->limit($limit)->get($this->table)->result();
    }
    public function get_by_slug($slug) { return $this->db->where('slug', $slug)->get($this->table)->row(); }
    public function get_by_id($id) { return $this->db->where('id', $id)->get($this->table)->row(); }
    public function get_all() { return $this->db->order_by('created_at', 'DESC')->get($this->table)->result(); }
    public function insert($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
