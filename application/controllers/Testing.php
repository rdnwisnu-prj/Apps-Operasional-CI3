<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller 
{
    public function __construct()
	{
	    parent::__construct();
        $this->load->model('Team_model','team');
        $this->load->library('form_validation');
	    is_logged_in();
	}

    public function index()
    {
        $data = [
            'title'             => 'Tim Saya - Aplikasi CRM Cakra Medika',
            'header'            => 'Marketing',
            'subheader'         => 'Tim Saya',
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('testing', $data);
        $this->load->view('templates/footer');
    }
}