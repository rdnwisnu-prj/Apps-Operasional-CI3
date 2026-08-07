<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perusahaan_model','perusahaan');
        $this->load->library('form_validation');
        $this->load->library('Marketing_api');
        is_logged_in();
        check_role_access();
    }
    
    public function index()
    {
        $data = [
            'title'      => 'Operasional Web App | Perusahaan',
            'header'     => 'Master Data',
            'subheader'  => 'Data Perusahaan',
            'perusahaan' => $this->perusahaan->getData(),
            'marketing'  => $this->getMarketingOptions(),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('perusahaan/index', $data);
        $this->load->view('templates/footer');
    }

    private function getMarketingOptions()
    {
        $marketing = $this->marketing_api->getMarketingUsers();

        if (!is_array($marketing)) {
            return [];
        }

        return array_values(array_filter($marketing, function ($user) {
            return isset($user['id_user'], $user['nama']);
        }));
    }

    private function resolveMarketingName($marketing_id, $marketing_options)
    {
        $marketing_id = (int) $marketing_id;

        foreach ($marketing_options as $marketing) {
            if ((int) $marketing['id_user'] === $marketing_id) {
                return $marketing['nama'];
            }
        }

        return '';
    }

    private function setRules()
    {
        $this->form_validation->set_rules('nama_perusahaan', 'Nama Perusahaan', 'required|trim');
        $this->form_validation->set_rules('nama_pic', 'Nama PIC', 'required|trim');
    }

    private function buildPayload($existing = [])
    {
        $marketing = $this->getMarketingOptions();
        $marketing_id = $this->input->post('marketing_id', true);
        $marketing_name = $this->resolveMarketingName($marketing_id, $marketing);

        if ($marketing_name === '' && !empty($existing) && (int) $marketing_id === (int) ($existing['marketing_id'] ?? 0)) {
            $marketing_name = $existing['marketing_name'] ?? '';
        }

        return [
            'nama_perusahaan'   => $this->input->post('nama_perusahaan', true),
            'no_tlp'            => $this->input->post('no_tlp', true) ?: '',
            'email'             => $this->input->post('email', true) ?: null,
            'alamat_perusahaan' => $this->input->post('alamat_perusahaan', true) ?: '',
            'nama_pic'          => $this->input->post('nama_pic', true),
            'tlp_pic'           => $this->input->post('tlp_pic', true) ?: '',
            'marketing_id'      => (int) $marketing_id,
            'marketing_name'    => $marketing_name,
        ];
    }

    public function Store()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Perusahaan');
            return;
        }

        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Perusahaan');
            return;
        }

        $insert = $this->buildPayload();
        $insert['source'] = 'manual';
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');

        if ($this->perusahaan->storeData($insert)) {
            $this->session->set_flashdata('flash', 'Ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Data gagal ditambahkan');
        }

        redirect('Perusahaan');
    }

    public function edit($id_perusahaan)
    {
        redirect('Perusahaan');
    }

    public function update() 
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Perusahaan');
            return;
        }

        $id_perusahaan = $this->input->post('id_perusahaan', true);
        $existing = $this->perusahaan->getPerusahaanById($id_perusahaan);

        if (!$id_perusahaan || !$existing) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Perusahaan');
            return;
        }
    
        $this->setRules();
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Perusahaan');
            return;
        }

        $update = $this->buildPayload($existing);
        $update['updated_at'] = date('Y-m-d H:i:s');

        if ($this->perusahaan->editData($id_perusahaan, $update)) {
            $this->session->set_flashdata('flash', 'Diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Data gagal diperbarui');
        }

        redirect('Perusahaan');
    }

    public function destroy($id)
    {
        if ($this->perusahaan->deleteData($id)) {
            $this->session->set_flashdata('flash', 'Dihapus');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus');
        }
        redirect('Perusahaan');
    }

    public function syncAll()
    {
        $result = $this->marketing_api->syncAll();

        if ($result['success']) {
            $this->session->set_flashdata('flash', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('Perusahaan');
    }

    public function fetchClients()
    {
        $clients = $this->marketing_api->getClients();

        if ($clients === false) {
            echo json_encode(['status' => false, 'message' => 'Gagal menghubungi Marketing API']);
            return;
        }

        echo json_encode(['status' => true, 'data' => $clients]);
    }

    public function importClient()
    {
        $client_id = $this->input->post('client_id');

        if (!$client_id) {
            echo json_encode(['status' => false, 'message' => 'ID Client tidak valid']);
            return;
        }

        $result = $this->marketing_api->syncOne($client_id);
        echo json_encode($result);
    }
}
