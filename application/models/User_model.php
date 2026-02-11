<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'users';
    public function get_by_email($email) { return $this->db->where('email', $email)->get($this->table)->row(); }
    public function get_by_id($id) { return $this->db->where('id', $id)->get($this->table)->row(); }
    public function get_all() { return $this->db->get($this->table)->result(); }
    public function insert($data) { return $this->db->insert($this->table, $data); }
    public function update($id, $data) { return $this->db->where('id', $id)->update($this->table, $data); }
    public function delete($id) { return $this->db->where('id', $id)->delete($this->table); }
    public function verify_password($email, $password) {
        $user = $this->get_by_email($email);
        if ($user && password_verify($password, $user->password)) return $user;
        return false;
    }
}
