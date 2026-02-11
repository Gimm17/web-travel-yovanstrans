<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib {
    protected $CI;
    
    // Role permissions: what modules each role can access
    protected $permissions = [
        'superadmin' => '*', // all access
        'editor' => ['posts', 'events', 'popups', 'galleries', 'testimonials', 'faqs'],
        'cs' => ['dashboard'], // read-only of dashboard
    ];

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Check if user is logged in
     */
    public function is_logged_in() {
        return $this->CI->session->userdata('admin_logged_in') === true;
    }

    /**
     * Get current user role
     */
    public function get_role() {
        return $this->CI->session->userdata('admin_role') ?: 'cs';
    }

    /**
     * Check if user has required role
     */
    public function require_role($role) {
        if (!$this->is_logged_in()) {
            redirect('admin/login');
        }
        $current = $this->get_role();
        $hierarchy = ['cs' => 1, 'editor' => 2, 'superadmin' => 3];
        $current_level = isset($hierarchy[$current]) ? $hierarchy[$current] : 0;
        $required_level = isset($hierarchy[$role]) ? $hierarchy[$role] : 99;
        
        if ($current_level < $required_level) {
            $this->CI->session->set_flashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
            redirect('admin');
        }
    }

    /**
     * Check if current role can access a module
     */
    public function can_access($module) {
        $role = $this->get_role();
        if ($role === 'superadmin') return true;
        $perms = isset($this->permissions[$role]) ? $this->permissions[$role] : [];
        if ($perms === '*') return true;
        return in_array($module, $perms);
    }

    /**
     * Check if current user is superadmin
     */
    public function is_superadmin() {
        return $this->get_role() === 'superadmin';
    }
}
