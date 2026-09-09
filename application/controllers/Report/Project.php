<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller 
{
    public function __construct()
	{
	    parent::__construct();
        $this->load->model('Client_model','client');
        $this->load->model('Team_model','team');
        $this->load->model('Group_model','group');
        $this->load->model('Project_model','project');
        $this->load->library('form_validation');
	    is_logged_in();
	}
	
    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $data = [
            'title'             => 'Operational Cakra Application | Report',
            'header'            => 'Laporan & Pengaturan',
            'subheader'         => 'Laporan',
            'current_year'      => $current_year,
            'project_monthly'   => $this->project->getProjectCountByMonth($current_year),
            'current_user_id'   => $id_user,
            'current_user_role' => $role_id,
            'bulan_names'       => $this->getBulanNames(),
            'tahun'             => $current_year,
            'bulan'             => date('n')
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('report/project', $data);
        $this->load->view('templates/footer');
    }

    public function getProjectTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->project->getProjectCountByMonth($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    private function getBulanNames()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }
}