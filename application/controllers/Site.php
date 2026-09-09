<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Site_model','site');
        $this->load->model('Perusahaan_model','perusahaan');
        $this->load->library('form_validation');
        is_logged_in();
        check_role_access();
    }
    
    public function index()
    {
        $data = [
            'title'      => 'Operational Cakra Application | Site Perusahaan',
            'header'     => 'Master Data',
            'subheader'  => 'Site Perusahaan',
            'site'       => $this->site->getData(),
            'perusahaan' => $this->perusahaan->getData(),
            'provinsi'   => $this->site->getProvinsi(),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('site', $data);
        $this->load->view('templates/footer');
    }

    private function setRules()
    {
        $this->form_validation->set_rules('id_perusahaan', 'Perusahaan', 'required|trim');
        $this->form_validation->set_rules('nama_site', 'Nama Site', 'required|trim');
    }

    private function buildPayload($isUpdate = false)
    {
        $data = [
            'id_perusahaan' => $this->input->post('id_perusahaan', true),
            'nama_site'     => $this->input->post('nama_site', true),
            'provinsi'      => $this->input->post('provinsi', true),
            'kota'          => $this->input->post('kota', true),
            'keterangan'    => $this->input->post('keterangan', true),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if (!$isUpdate) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $data;
    }
    
    public function create() 
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Site');
            return;
        }

        $this->setRules();
       
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Site');
            return;
        }

        $this->site->storeData($this->buildPayload(false));
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Site');
    }

    public function edit($id_site)
    {
        redirect('Site');
    }

    public function update() 
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Site');
            return;
        }

        $id_site = $this->input->post('id_site', true);
        if (!$id_site || !$this->site->getSiteById($id_site)) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Site');
            return;
        }
    
        $this->setRules();
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Site');
            return;
        }

        $this->site->editData($id_site, $this->buildPayload(true));
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Site');
    }

    public function destroy($id)
    {
        $this->site->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Site');
    }

    public function getKota($id_provinsi)
    {
        $kota = $this->site->getKotaByProvinsi($id_provinsi);
        echo json_encode($kota);
    }
}
