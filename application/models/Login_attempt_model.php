<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_attempt_model extends CI_Model {
    protected $table = 'login_attempts';

    /**
     * Record a failed login attempt
     */
    public function record_attempt($email, $ip) {
        $this->db->insert($this->table, [
            'email'      => $email,
            'ip_address' => $ip,
            'attempted_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Check if IP/email is throttled (max $max_attempts in $window_minutes)
     * @return bool TRUE if blocked
     */
    public function is_throttled($ip, $email, $max_attempts = 5, $window_minutes = 15) {
        $since = date('Y-m-d H:i:s', strtotime("-{$window_minutes} minutes"));
        $count = $this->db
            ->where('ip_address', $ip)
            ->where('attempted_at >=', $since)
            ->count_all_results($this->table);
        if ($count >= $max_attempts) return true;

        $count_email = $this->db
            ->where('email', $email)
            ->where('attempted_at >=', $since)
            ->count_all_results($this->table);
        return $count_email >= $max_attempts;
    }

    /**
     * Clear old attempts (called on successful login)
     */
    public function clear_attempts($ip, $email) {
        $this->db->where('ip_address', $ip)
                 ->or_where('email', $email)
                 ->delete($this->table);
    }

    /**
     * Cleanup old records (> 24h) — can be called periodically
     */
    public function cleanup() {
        $this->db->where('attempted_at <', date('Y-m-d H:i:s', strtotime('-24 hours')))
                 ->delete($this->table);
    }
}
