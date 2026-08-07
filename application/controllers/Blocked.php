<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocked extends MY_Controller 
{
	public function index()
	{
		$data['judul'] = 'Cognix Marketing Application | Blocked Access';
        $this->load->view('auth/blocked', $data);
	}		
}