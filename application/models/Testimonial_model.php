<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {
    protected $table = 'testimonials';

    public function get_active($limit = null) {
        $this->db->where('is_active', 1)->order_by('sort_order', 'ASC');
        if ($limit) $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_all() {
        return $this->db->order_by('is_active', 'DESC')
                        ->order_by('created_at', 'DESC')
                        ->get($this->table)->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // --- New methods for user reviews ---

    /**
     * Get review stats: average rating + total count (active only)
     */
    public function get_stats() {
        $row = $this->db->select('AVG(rating) as avg_rating, COUNT(*) as total')
                        ->where('is_active', 1)
                        ->get($this->table)->row();
        return (object) [
            'avg_rating' => round($row->avg_rating, 1),
            'total'      => (int) $row->total
        ];
    }

    /**
     * Insert a user-submitted review (pending moderation)
     */
    public function insert_public($data) {
        $data['source']    = 'user';
        $data['is_active'] = 0; // needs admin approval
        return $this->db->insert($this->table, $data);
    }

    /**
     * Rate limit: check if this IP submitted a review in the last N minutes
     */
    public function recent_from_ip($ip, $minutes = 30) {
        return $this->db->where('ip_address', $ip)
                        ->where('created_at >', date('Y-m-d H:i:s', strtotime("-{$minutes} minutes")))
                        ->count_all_results($this->table);
    }

    /**
     * Count pending (user-submitted, not yet approved)
     */
    public function count_pending() {
        return $this->db->where('is_active', 0)
                        ->where('source', 'user')
                        ->count_all_results($this->table);
    }
}
