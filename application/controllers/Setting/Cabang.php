<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Cabang_model','cabang');
        $this->load->library('form_validation');
		is_logged_in();
	}
	
	public function index()
	{
        $data = [
            'title'     => 'Operasional Web App | Setting Cabang',
            'header'    => 'Pengaturan',
            'subheader' => 'Cabang',
            'cabang'    => $this->cabang->getData(),
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/cabang', $data);
		$this->load->view('templates/footer');
	}

    public function create() 
    {
        $this->form_validation->set_rules('nama_cabang', 'Nama cabang', 'required');
       
        if ($this->form_validation->run() == FALSE) {

            $data = [
                'title'     => 'Operasional Web App | Setting Cabang',
                'header'    => 'Pengaturan',
                'subheader' => 'Cabang',
                'cabang'    => $this->cabang->getData(),
                'errors'    => validation_errors()
            ];
 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/cabang', $data);
            $this->load->view('templates/footer');
 
        } else {
    
            $data = [
                "nama_cabang"     => $this->input->post('nama_cabang', true),
            ];
    
            $this->cabang->storeData($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Setting/Cabang');
            
        }
    }

    public function edit($id_cabang)
    {
        $edit_data = $this->cabang->getCabangsById($id_cabang);
        
        $data = [
            'title'     => 'Operasional Web App | Setting Cabang',
            'header'    => 'Pengaturan',
            'subheader' => 'Cabang',
            'cabang'    => $this->cabang->getData(),
            'edit_data' => $edit_data
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/cabang', $data);
		$this->load->view('templates/footer');
    }

    public function update() 
    {
        $id_cabang = $this->input->post('id_cabang');
    
        $this->form_validation->set_rules('nama_cabang', 'Nama cabang', 'required');
    
        if ($this->form_validation->run() == FALSE) {
    
            $edit_data = $this->cabang->getcabangsById($id_cabang);
    
            $data = [
                'title'     => 'Operasional Web App | Setting Cabang',
                'header'    => 'Pengaturan',
                'subheader' => 'Cabang',    
                'cabang'    => $this->cabang->getData(),
                'edit_data' => $edit_data,
                'errors'    => validation_errors()
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/cabang', $data);
            $this->load->view('templates/footer');
    
        } else {
    
            $data = [
                "nama_cabang"     => $this->input->post('nama_cabang', true),
            ];
    
            $this->cabang->editData($id_cabang, $data);
            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect('Setting/Cabang');
            
        }
    }

    public function destroy($id)
    {
        $this->cabang->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Setting/Cabang');
    }
	
}