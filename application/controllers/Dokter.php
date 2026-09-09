<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dokter_model','dokter');
        $this->load->library('form_validation');
        is_logged_in();
        check_role_access();
    }
    
    public function index()
    {
        $data = [
            'title'      => 'Operational Cakra Application | Data Dokter',
            'header'     => 'Master Data',
            'subheader'  => 'Dokter',
            'dokter'     => $this->dokter->getData()
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dokter', $data);
        $this->load->view('templates/footer');
    }

    private function setRules()
    {
        $this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'required|trim');
        $this->form_validation->set_rules('bank', 'Bank', 'required|trim');
        $this->form_validation->set_rules('no_rekening', 'No. Rekening', 'required|trim');
    }

    private function buildPayload($isUpdate = false)
    {
        $data = [
            'nama_dokter' => $this->input->post('nama_dokter', true),
            'ktp'         => $this->input->post('ktp', true),
            'bank'        => $this->input->post('bank', true),
            'no_rekening' => $this->input->post('no_rekening', true),
            'atas_nama'   => $this->input->post('atas_nama', true),
            'kcp'         => $this->input->post('kcp', true),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if (!$isUpdate) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $data;
    }
    
    public function create() 
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Dokter');
            return;
        }

        $this->setRules();
       
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Dokter');
            return;
        }

        $this->dokter->storeData($this->buildPayload(false));
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Dokter');
    }

    public function edit($id_dokter)
    {
        redirect('Dokter');
    }

    public function update() 
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Dokter');
            return;
        }

        $id_dokter = $this->input->post('id_dokter', true);
        if (!$id_dokter || !$this->dokter->getDokterById($id_dokter)) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Dokter');
            return;
        }
    
        $this->setRules();
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Dokter');
            return;
        }

        $this->dokter->editData($id_dokter, $this->buildPayload(true));
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Dokter');
    }

    public function destroy($id)
    {
        $this->dokter->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Dokter');
    }
}
