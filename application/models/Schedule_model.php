<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_Model {
    protected $table = 'schedules';

    public function get_by_route($route_id) {
        return $this->db
            ->select('schedules.*, vehicle_classes.name as class_name')
            ->join('vehicle_classes', 'vehicle_classes.id = schedules.class_id', 'left')
            ->where('schedules.route_id', $route_id)
            ->where('schedules.is_active', 1)
            ->order_by('schedules.depart_time', 'ASC')
            ->get($this->table)->result();
    }

    public function get_all_with_details($active_only = false) {
        $this->db
            ->select('schedules.*, routes.origin, routes.destination, vehicle_classes.name as class_name')
            ->join('routes', 'routes.id = schedules.route_id')
            ->join('vehicle_classes', 'vehicle_classes.id = schedules.class_id', 'left');
        if ($active_only) $this->db->where('schedules.is_active', 1);
        return $this->db->order_by('routes.sort_order', 'ASC')
            ->order_by('schedules.depart_time', 'ASC')
            ->get($this->table)->result();
    }

    public function get_by_id($id) { return $this->db->where('id', $id)->get($this->table)->row(); }
    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
