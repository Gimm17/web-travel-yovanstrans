<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing_model extends CI_Model {
    protected $table = 'pricings';

    public function get_all_with_details($include_inactive = false) {
        $this->db
            ->select('pricings.*, routes.origin, routes.destination, vehicle_classes.name as class_name, vehicle_classes.seat_count,
                      CASE WHEN pricings.promo_price IS NOT NULL AND pricings.promo_end IS NOT NULL AND pricings.promo_end < CURDATE() THEN NULL ELSE pricings.promo_price END as effective_promo_price', false)
            ->join('routes', 'routes.id = pricings.route_id')
            ->join('vehicle_classes', 'vehicle_classes.id = pricings.class_id');
        if (!$include_inactive) $this->db->where('pricings.is_active', 1);
        return $this->db->order_by('routes.sort_order', 'ASC')
            ->get($this->table)->result();
    }

    public function get_grouped_by_class() {
        $pricings = $this->get_all_with_details();
        $grouped = [];
        foreach ($pricings as $p) {
            $key = $p->class_id;
            if (!isset($grouped[$key])) {
                $grouped[$key] = (object)[
                    'class_name' => $p->class_name,
                    'seat_count' => $p->seat_count,
                    'items' => []
                ];
            }
            $grouped[$key]->items[] = $p;
        }
        return $grouped;
    }

    public function get_cheapest_per_route() {
        return $this->db
            ->select('pricings.*, routes.origin, routes.destination, routes.slug as route_slug,
                      vehicle_classes.name as class_name, 
                      COALESCE(pricings.promo_price, pricings.price) as effective_price', false)
            ->join('routes', 'routes.id = pricings.route_id')
            ->join('vehicle_classes', 'vehicle_classes.id = pricings.class_id')
            ->where('pricings.is_active', 1)
            ->order_by('effective_price', 'ASC')
            ->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
}
