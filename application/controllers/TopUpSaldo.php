<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TopUpSaldo extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Topup_saldo_model', 'topup');
        $this->load->model('Project_model', 'project');
        $this->load->library('form_validation');
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = $this->pageData();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('topup_saldo', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('TopUpSaldo');
            return;
        }

        $this->setRules();

        if ($this->form_validation->run() === false) {
            $data = $this->pageData();
            $data['errors'] = validation_errors();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('topup_saldo', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->topup->storeData($this->buildPayload(false));
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('TopUpSaldo');
    }

    public function edit($id)
    {
        $editData = $this->topup->getById($id);

        if (!$editData) {
            $this->session->set_flashdata('error', 'Data top up saldo tidak ditemukan');
            redirect('TopUpSaldo');
            return;
        }

        $data = $this->pageData();
        $data['edit_data'] = $editData;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('topup_saldo', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('TopUpSaldo');
            return;
        }

        $id = $this->input->post('id_topup', true);
        $editData = $this->topup->getById($id);

        if (!$editData) {
            $this->session->set_flashdata('error', 'Data top up saldo tidak ditemukan');
            redirect('TopUpSaldo');
            return;
        }

        $this->setRules();

        if ($this->form_validation->run() === false) {
            $data = $this->pageData();
            $data['edit_data'] = $editData;
            $data['errors'] = validation_errors();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('topup_saldo', $data);
            $this->load->view('templates/footer');
            return;
        }

        $this->topup->editData($id, $this->buildPayload(true));
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('TopUpSaldo');
    }

    public function destroy($id)
    {
        $this->topup->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('TopUpSaldo');
    }

    private function pageData()
    {
        return [
            'title'          => 'Operasional Web App | Top Up Saldo',
            'header'         => 'Keuangan',
            'subheader'      => 'Top Up Saldo',
            'topup'          => $this->topup->getData(),
            'project'        => $this->project->getData(),
            'proses_options' => $this->prosesOptions(),
        ];
    }

    private function setRules()
    {
        $this->form_validation->set_rules('project', 'Project', 'required|trim');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|in_list[1,2,3,4]');
        $this->form_validation->set_rules('nominal', 'Nominal Top Up', 'required|numeric');
        $this->form_validation->set_rules('tgl_topup', 'Tanggal Top Up', 'required|trim');
    }

    private function buildPayload($isUpdate = false)
    {
        $data = [
            'project'    => $this->input->post('project', true),
            'proses'     => $this->input->post('proses', true),
            'nominal'    => (float) $this->input->post('nominal', true),
            'tgl_topup'  => $this->input->post('tgl_topup', true),
            'keterangan' => $this->input->post('keterangan', true),
            'user_id'    => $this->session->userdata('id_user'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$isUpdate) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $data;
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
