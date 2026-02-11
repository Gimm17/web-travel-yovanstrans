<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Set JSON header for all API responses
        $this->output->set_content_type('application/json');
    }

    /**
     * POST /api/submit-review
     */
    public function submit_review() {
        // Only accept POST
        if ($this->input->method() !== 'post') {
            $this->output->set_status_header(405)
                 ->set_output(json_encode(['success' => false, 'message' => 'Method not allowed']));
            return;
        }

        $this->load->model('Testimonial_model');

        // Rate limit: max 1 review per 30 min per IP
        $ip = $this->input->ip_address();
        if ($this->Testimonial_model->recent_from_ip($ip, 30) > 0) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => 'Anda sudah mengirim ulasan baru-baru ini. Silakan tunggu 30 menit.'
            ]));
            return;
        }

        // Validate input
        $name    = trim($this->input->post('name'));
        $route   = trim($this->input->post('route'));
        $content = trim($this->input->post('content'));
        $rating  = (int) $this->input->post('rating');

        $errors = [];
        if (empty($name) || strlen($name) < 2)      $errors[] = 'Nama wajib diisi (min 2 karakter).';
        if (empty($content) || strlen($content) < 10) $errors[] = 'Ulasan wajib diisi (min 10 karakter).';
        if ($rating < 1 || $rating > 5)               $errors[] = 'Rating harus antara 1-5.';

        if (!empty($errors)) {
            $this->output->set_output(json_encode([
                'success' => false,
                'message' => implode(' ', $errors)
            ]));
            return;
        }

        // Insert (pending moderation)
        $this->Testimonial_model->insert_public([
            'name'       => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            'route'      => htmlspecialchars($route, ENT_QUOTES, 'UTF-8'),
            'content'    => htmlspecialchars($content, ENT_QUOTES, 'UTF-8'),
            'rating'     => $rating,
            'ip_address' => $ip,
        ]);

        $this->output->set_output(json_encode([
            'success' => true,
            'message' => 'Terima kasih! Ulasan Anda akan ditampilkan setelah diverifikasi oleh admin.'
        ]));
    }

    /**
     * POST /api/track-view
     * Records a page view (called via sendBeacon or fetch)
     */
    public function track_view() {
        if ($this->input->method() !== 'post') {
            $this->output->set_status_header(405)
                 ->set_output(json_encode(['success' => false]));
            return;
        }

        $this->load->model('Page_view_model');

        $page = $this->input->post('page');
        if (empty($page)) $page = 'home';

        $this->Page_view_model->record(
            substr($page, 0, 100),
            $this->input->ip_address(),
            $this->input->user_agent(),
            $this->input->server('HTTP_REFERER')
        );

        $this->output->set_output(json_encode(['success' => true]));
    }
}
