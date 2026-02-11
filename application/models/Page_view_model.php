<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_view_model extends CI_Model {
    protected $table = 'page_views';

    /**
     * Record a page view
     */
    public function record($page, $ip = null, $user_agent = null, $referrer = null) {
        return $this->db->insert($this->table, [
            'page'       => $page,
            'ip_address' => $ip,
            'user_agent' => $user_agent ? substr($user_agent, 0, 255) : null,
            'referrer'   => $referrer ? substr($referrer, 0, 500) : null,
        ]);
    }

    /**
     * Total page views (all time)
     */
    public function get_total() {
        return $this->db->count_all_results($this->table);
    }

    /**
     * Page views today
     */
    public function get_today() {
        return $this->db->where('DATE(created_at)', date('Y-m-d'))
                        ->count_all_results($this->table);
    }

    /**
     * Unique visitors today (by IP)
     */
    public function get_unique_today() {
        $row = $this->db->select('COUNT(DISTINCT ip_address) as cnt')
                        ->where('DATE(created_at)', date('Y-m-d'))
                        ->get($this->table)->row();
        return $row ? (int) $row->cnt : 0;
    }

    /**
     * Total unique visitors (all time)
     */
    public function get_unique_total() {
        $row = $this->db->select('COUNT(DISTINCT ip_address) as cnt')
                        ->get($this->table)->row();
        return $row ? (int) $row->cnt : 0;
    }

    /**
     * Views by page
     */
    public function get_by_page($limit = 10) {
        return $this->db->select('page, COUNT(*) as total')
                        ->group_by('page')
                        ->order_by('total', 'DESC')
                        ->limit($limit)
                        ->get($this->table)->result();
    }

    /**
     * Daily views for chart (last 30 days)
     */
    public function get_daily_stats($days = 30) {
        return $this->db->select('DATE(created_at) as date, COUNT(*) as total, COUNT(DISTINCT ip_address) as unique_visitors')
                        ->where('created_at >=', date('Y-m-d', strtotime("-{$days} days")))
                        ->group_by('DATE(created_at)')
                        ->order_by('date', 'ASC')
                        ->get($this->table)->result();
    }

    /**
     * Top referrers
     */
    public function get_top_referrers($limit = 10) {
        return $this->db->select('referrer, COUNT(*) as total')
                        ->where('referrer IS NOT NULL')
                        ->where('referrer !=', '')
                        ->group_by('referrer')
                        ->order_by('total', 'DESC')
                        ->limit($limit)
                        ->get($this->table)->result();
    }
}
