<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Branch_model', 'Route_model', 'Vehicle_class_model',
            'Pricing_model', 'Testimonial_model', 'Faq_model', 'Post_model',
            'Popup_model', 'Event_model']);
    }

    public function index() {
        $data['active_page'] = 'home';
        $data['routes'] = $this->Route_model->get_with_pricing(true);
        $data['classes'] = $this->Vehicle_class_model->get_all();
        $data['branches'] = $this->Branch_model->get_all();
        $data['testimonials'] = $this->Testimonial_model->get_active(4);
        $data['review_stats'] = $this->Testimonial_model->get_stats();
        $data['faqs'] = $this->Faq_model->get_active(6);
        $data['posts'] = $this->Post_model->get_published(3);
        $data['events'] = $this->Event_model->get_upcoming(3);
        $data['popup'] = $this->Popup_model->get_active();
        $data['content_view'] = 'public/home';
        $this->load->view('layouts/main', $data);
    }
}
