<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dept extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Dept_model','dept');
        $this->load->library('form_validation');
		is_logged_in();
	}
	
	public function index()
	{
        $data = [
            'title'     => 'Operasional Web App | Setting Dept',
            'header'    => 'Pengaturan',
            'subheader' => 'Departement',
            'dept'      => $this->dept->getData(),
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/dept', $data);
		$this->load->view('templates/footer');
	}

    public function create() 
    {
        $this->form_validation->set_rules('nama_dept', 'Nama dept', 'required');
       
        if ($this->form_validation->run() == FALSE) {

            $data = [
                'title'     => 'Operasional Web App | Setting Dept',
                'header'    => 'Pengaturan',
                'subheader' => 'Departement',
                'dept'      => $this->dept->getData(),
                'errors'    => validation_errors()
            ];
 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/dept ', $data);
            $this->load->view('templates/footer');
 
        } else {
    
            $data = [
                "nama_dept"     => $this->input->post('nama_dept', true),
            ];
    
            $this->dept->storeData($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Setting/Dept');
            
        }
    }

    public function edit($id_dept)
    {
        $edit_data = $this->dept->getDeptById($id_dept);
        
        $data = [
            'title'     => 'Operasional Web App | Setting Dept',
            'header'    => 'Pengaturan',
            'subheader' => 'Departement',
            'dept'      => $this->dept->getData(),
            'edit_data' => $edit_data
        ];

        $this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/dept', $data);
		$this->load->view('templates/footer');
    }

    public function update() 
    {
        $id_dept = $this->input->post('id_dept');
    
        $this->form_validation->set_rules('nama_dept', 'Nama dept', 'required');
    
        if ($this->form_validation->run() == FALSE) {
    
            $edit_data = $this->dept->getDeptById($id_dept);
    
            $data = [
                'title'     => 'Operasional Web App | Setting Dept',
                'header'    => 'Pengaturan',
                'subheader' => 'Departement',  
                'dept'      => $this->dept->getData(),
                'edit_data' => $edit_data,
                'errors'    => validation_errors()
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/dept', $data);
            $this->load->view('templates/footer');
    
        } else {
    
            $data = [
                "nama_dept"     => $this->input->post('nama_dept', true),
            ];
    
            $this->dept->editData($id_dept, $data);
            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect('Setting/Dept');
            
        }
    }

    public function destroy($id)
    {
        $this->dept->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Setting/Dept');
    }
	
}