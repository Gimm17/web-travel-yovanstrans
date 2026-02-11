<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {
    protected $table = 'settings';
    public function get($key) {
        $row = $this->db->where('key_name', $key)->get($this->table)->row();
        return $row ? $row->value : null;
    }
    public function set($key, $value) {
        $exists = $this->db->where('key_name', $key)->count_all_results($this->table);
        if ($exists) {
            return $this->db->where('key_name', $key)->update($this->table, ['value' => $value]);
        }
        return $this->db->insert($this->table, ['key_name' => $key, 'value' => $value]);
    }
    public function get_all() { return $this->db->get($this->table)->result(); }
    public function get_by_group($group) { return $this->db->where('group_name', $group)->get($this->table)->result(); }
}
