<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {
    public function get_albums($active_only = true) {
        if ($active_only) $this->db->where('is_active', 1);
        return $this->db->order_by('sort_order', 'ASC')->get('galleries')->result();
    }
    public function get_album_by_slug($slug) { return $this->db->where('slug', $slug)->get('galleries')->row(); }
    public function get_album_by_id($id) { return $this->db->where('id', $id)->get('galleries')->row(); }
    public function get_items($gallery_id) {
        return $this->db->where('gallery_id', $gallery_id)->order_by('sort_order', 'ASC')->get('gallery_items')->result();
    }
    public function get_item($id) { return $this->db->where('id', $id)->get('gallery_items')->row(); }

    public function insert_album($data) { $this->db->insert('galleries', $data); return $this->db->insert_id(); }
    public function update_album($id, $data) { return $this->db->where('id', $id)->update('galleries', $data); }
    public function delete_album($id) { return $this->db->where('id', $id)->delete('galleries'); }
    public function insert_item($data) { return $this->db->insert('gallery_items', $data); }
    public function delete_item($id) { return $this->db->where('id', $id)->delete('gallery_items'); }
}
