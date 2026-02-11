<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wa_click_model extends CI_Model {
    protected $table = 'wa_clicks';

    public function track($data) {
        $data['clicked_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function get_total() {
        return $this->db->count_all($this->table);
    }

    public function get_today() {
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        return $this->db
            ->where('clicked_at >=', $today)
            ->where('clicked_at <', $tomorrow)
            ->count_all_results($this->table);
    }

    public function get_stats_by_page($days = 30) {
        return $this->db
            ->select('source_page, COUNT(*) as total')
            ->where('clicked_at >=', date('Y-m-d', strtotime("-{$days} days")))
            ->group_by('source_page')
            ->order_by('total', 'DESC')
            ->get($this->table)->result();
    }

    public function get_stats_by_agent($days = 30) {
        return $this->db
            ->select('agent_wa, COUNT(*) as total')
            ->where('clicked_at >=', date('Y-m-d', strtotime("-{$days} days")))
            ->group_by('agent_wa')
            ->order_by('total', 'DESC')
            ->get($this->table)->result();
    }

    public function get_daily_stats($days = 30) {
        $start = date('Y-m-d', strtotime("-{$days} days"));
        return $this->db
            ->select('DATE(clicked_at) as date, COUNT(*) as total')
            ->where('clicked_at >=', $start . ' 00:00:00')
            ->group_by('DATE(clicked_at)')
            ->order_by('date', 'ASC')
            ->get($this->table)->result();
    }

    public function get_recent($limit = 20) {
        return $this->db->order_by('clicked_at', 'DESC')->limit($limit)->get($this->table)->result();
    }
}
