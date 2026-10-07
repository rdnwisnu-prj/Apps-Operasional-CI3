<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_model', 'dashboard');
		is_logged_in();
	}

    public function index()
    {
        $data = [
            'title' => 'Operational Cakra Application | Dashboard',
            'dashboard' => $this->dashboard->get_operational_dashboard(),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }
}
