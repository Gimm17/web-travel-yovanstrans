<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {
    protected $table = 'posts';

    public function get_published($limit = null, $offset = 0) {
        $this->db->where('is_published', 1)
                  ->order_by('published_at', 'DESC');
        if ($limit) $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    public function get_featured($limit = 3) {
        return $this->db->where('is_published', 1)->where('is_featured', 1)
            ->order_by('published_at', 'DESC')->limit($limit)->get($this->table)->result();
    }

    public function get_by_category($category, $limit = null) {
        $this->db->where('is_published', 1)->where('category', $category)
            ->order_by('published_at', 'DESC');
        if ($limit) $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row();
    }

    public function get_by_id($id) { return $this->db->where('id', $id)->get($this->table)->row(); }
    public function get_all() { return $this->db->order_by('created_at', 'DESC')->get($this->table)->result(); }
    public function insert($data) { $this->db->insert($this->table, $data); return $this->db->insert_id(); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
    public function count_published() { return $this->db->where('is_published', 1)->count_all_results($this->table); }
    public function increment_views($id) { $this->db->set('views', 'views+1', false)->where('id', $id)->update($this->table); }
}
