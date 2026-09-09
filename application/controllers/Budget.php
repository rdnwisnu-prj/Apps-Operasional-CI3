<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Budget_model','budget');
        $this->load->model('Project_model','project');
        $this->load->library('form_validation');
		is_logged_in();
		check_role_access();
	}
	
	public function index()
	{
        $data = [
            'title'      => 'Operational Cakra Application |  Budget Project',
            'header'     => 'Keuangan',
            'subheader'  => 'Budget Project',
            'budget'     => $this->budget->getData(),
            'project'    => $this->project->getData(),
            'proses_options' => $this->prosesOptions(),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
		$this->load->view('budget', $data);
		$this->load->view('templates/footer');
	}
    
    public function create() 
    {
        $this->form_validation->set_rules('project', 'Nama Project', 'required');
        $this->form_validation->set_rules('proses', 'Proses', 'required|in_list[1,2,3,4]');
        $this->form_validation->set_rules('total_budget', 'Total Budget', 'required');
       
        if ($this->form_validation->run() == FALSE) {

            $data = [
                'title'      => 'Operational Cakra Application |  Budget Project',
                'header'     => 'Keuangan',
                'subheader'  => 'Budget Project',
                'budget'     => $this->budget->getData(),
                'project'    => $this->project->getData(),
                'proses_options' => $this->prosesOptions(),
                'errors'     => validation_errors()
            ];
 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('budget', $data);
            $this->load->view('templates/footer');
 
        } else {
    
            $data = [
                "project"       => $this->input->post('project', true),
                "proses"        => $this->input->post('proses', true),
                "total_budget"  => $this->input->post('total_budget', true),
                "user_id"       => $this->session->userdata('id_user'),
                "keterangan"    => $this->input->post('keterangan', true),
                "created_at"    => date('Y-m-d H:i:s'),
                "updated_at"    => date('Y-m-d H:i:s'),
            ];
    
            $this->budget->storeData($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Budget');
            
        }
    }

    public function edit($id_budget)
    {
        $edit_data = $this->budget->getBudgetById($id_budget);
        
        $data = [
            'title'      => 'Operational Cakra Application |  Budget Project',
            'header'     => 'Keuangan',
            'subheader'  => 'Budget Project',
            'budget'     => $this->budget->getData(),
            'project'    => $this->project->getData(),
            'proses_options' => $this->prosesOptions(),
            'edit_data'  => $edit_data
        ];
        
		$this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
		$this->load->view('budget', $data);
		$this->load->view('templates/footer');
    }

    public function update() 
    {
        $id_budget = $this->input->post('id_budget');
    
        $this->form_validation->set_rules('project', 'Nama Project', 'required');
        $this->form_validation->set_rules('proses', 'Proses', 'required|in_list[1,2,3,4]');
        $this->form_validation->set_rules('total_budget', 'Total Budget', 'required');
    
        if ($this->form_validation->run() == FALSE) {
    
            $edit_data = $this->budget->getBudgetById($id_budget);
    
            $data = [
                'title'      => 'Operational Cakra Application |  Budget Project',
                'header'     => 'Keuangan',
                'subheader'  => 'Budget Project',
                'budget'     => $this->budget->getData(),
                'project'    => $this->project->getData(),
                'proses_options' => $this->prosesOptions(),
                'edit_data'  => $edit_data,
                'errors'     => validation_errors()
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('budget', $data);
            $this->load->view('templates/footer');
    
        } else {
    
            $data = [
                "project"       => $this->input->post('project', true),
                "proses"        => $this->input->post('proses', true),
                "total_budget"  => $this->input->post('total_budget', true),
                "user_id"       => $this->session->userdata('id_user'),
                "keterangan"    => $this->input->post('keterangan', true),
                "updated_at"    => date('Y-m-d H:i:s'),
            ];
    
            $this->budget->editData($id_budget, $data);
            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect('Budget');
            
        }
    }

    public function destroy($id)
    {
        $this->budget->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Budget');
    }

    private function prosesOptions()
    {
        return [
            '1' => 'Setting MCU',
            '2' => 'Pelaksanaan MCU',
            '3' => 'Bongkar Setting',
            '4' => 'Kirim Hasil',
        ];
    }
	
}
