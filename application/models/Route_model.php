<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Route_model extends CI_Model {
    protected $table = 'routes';

    public function get_all($active_only = true) {
        if ($active_only) $this->db->where('is_active', 1);
        return $this->db->order_by('sort_order', 'ASC')->get($this->table)->result();
    }

    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function get_with_pricing($active_only = true) {
        $routes = $this->get_all($active_only);
        foreach ($routes as &$route) {
            $route->pricings = $this->db
                ->select('pricings.*, vehicle_classes.name as class_name, vehicle_classes.seat_count')
                ->join('vehicle_classes', 'vehicle_classes.id = pricings.class_id')
                ->where('pricings.route_id', $route->id)
                ->where('pricings.is_active', 1)
                ->get('pricings')->result();
        }
        return $routes;
    }

    public function get_with_schedules($active_only = true) {
        $routes = $this->get_all($active_only);
        foreach ($routes as &$route) {
            $route->schedules = $this->db
                ->select('schedules.*, vehicle_classes.name as class_name')
                ->join('vehicle_classes', 'vehicle_classes.id = schedules.class_id', 'left')
                ->where('schedules.route_id', $route->id)
                ->where('schedules.is_active', 1)
                ->order_by('schedules.depart_time', 'ASC')
                ->get('schedules')->result();
        }
        return $routes;
    }

    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
    public function count_all() { return $this->db->count_all($this->table); }
}
