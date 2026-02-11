<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popup_model extends CI_Model {
    protected $table = 'popups';

    /**
     * Get the currently active popup, with optional post data joined
     */
    public function get_active() {
        $now = date('Y-m-d H:i:s');
        $this->db->select('popups.*, posts.title as post_title, posts.excerpt as post_excerpt, posts.content as post_content, posts.cover_image as post_image, posts.slug as post_slug, posts.category as post_category')
            ->join('posts', 'posts.id = popups.post_id', 'left')
            ->where('popups.is_active', 1)
            ->group_start()
                ->where('popups.date_start IS NULL', null, false)
                ->or_where('popups.date_start <=', $now)
            ->group_end()
            ->group_start()
                ->where('popups.date_end IS NULL', null, false)
                ->or_where('popups.date_end >=', $now)
            ->group_end()
            ->order_by('popups.id', 'DESC')->limit(1);
        return $this->db->get($this->table)->row();
    }

    public function get_by_id($id) {
        return $this->db->select('popups.*, posts.title as post_title, posts.cover_image as post_image, posts.slug as post_slug')
            ->join('posts', 'posts.id = popups.post_id', 'left')
            ->where('popups.id', $id)->get($this->table)->row();
    }
    public function get_all() {
        return $this->db->select('popups.*, posts.title as post_title, posts.cover_image as post_image')
            ->join('posts', 'posts.id = popups.post_id', 'left')
            ->order_by('popups.id', 'DESC')->get($this->table)->result();
    }
    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
