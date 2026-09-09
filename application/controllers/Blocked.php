<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocked extends MY_Controller 
{
	public function index()
	{
		$data['judul'] = 'Operational Cakra Application | Blocked Access';
        $this->load->view('auth/blocked', $data);
	}		
}