<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Other_model', 'other');
        $this->load->library('form_validation');
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = [
            'title'     => 'Operational Cakra Application | Biaya Other',
            'header'    => 'Keuangan',
            'subheader' => 'Biaya Other',
            'other'     => $this->other->getData(),
            'projects'  => $this->other->getProjects(),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('other/index', $data);
        $this->load->view('templates/footer');
    }

    public function Store()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Other');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Other');
            return;
        }

        $lampiran = '';
        $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('lampiran')) {
                $lampiran = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('Other');
                return;
            }
        }

        $insert = [
            'project'    => $this->input->post('project', true),
            'proses'     => $this->input->post('proses', true),
            'tanggal'    => $this->input->post('tanggal', true),
            'kebutuhan'  => $this->input->post('kebutuhan', true),
            'nominal'    => (double) $this->input->post('nominal', true),
            'lampiran'   => $lampiran,
            'keterangan' => $this->input->post('keterangan', true),
            'korlap'     => $this->session->userdata('id_user'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->other->storeData($insert);
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Other');
    }

    public function edit($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        if (!$this->other->getById($id)) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
        }

        redirect('Other');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Other');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $id = $this->input->post('id_other');
        $edit_data = $this->other->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Other');
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Other');
            return;
        }

        $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR;
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $update = [
            'project'    => $this->input->post('project', true),
            'proses'     => $this->input->post('proses', true),
            'tanggal'    => $this->input->post('tanggal', true),
            'kebutuhan'  => $this->input->post('kebutuhan', true),
            'nominal'    => (double) $this->input->post('nominal', true),
            'keterangan' => $this->input->post('keterangan', true),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($_FILES['lampiran']['name'])) {
            $config['upload_path']   = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('lampiran')) {
                if (!empty($edit_data['lampiran']) && file_exists($upload_path . $edit_data['lampiran'])) {
                    unlink($upload_path . $edit_data['lampiran']);
                }
                $update['lampiran'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('Other');
                return;
            }
        }

        $this->other->editData($id, $update);
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Other');
    }

    public function destroy($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $row = $this->other->getById($id);
        if ($row && !empty($row['lampiran'])) {
            $file = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'other' . DIRECTORY_SEPARATOR . $row['lampiran'];
            if (file_exists($file)) {
                unlink($file);
            }
        }

        $this->other->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Other');
    }

    private function setRules()
    {
        $this->form_validation->set_rules('project', 'Project', 'required|callback_validAssignedProject');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|callback_validRoleProses');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
    }

    private function requireOperationalInputRole()
    {
        if (in_array((int) $this->session->userdata('role_id'), [5, 8, 9], true)) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Hanya user dengan role 5, 8, dan 9 yang dapat mengelola data operasional.');
        redirect('Other');
        return false;
    }

    private function forcePelaksanaanMcuProses()
    {
        if ((int) $this->session->userdata('role_id') === 8) {
            $_POST['proses'] = '2';
        }
    }

    public function validRoleProses($proses)
    {
        if (in_array((string) $proses, $this->allowedProsesByRole(), true)) {
            return true;
        }

        $this->form_validation->set_message('validRoleProses', 'Pilihan proses tidak sesuai dengan akses user.');
        return false;
    }

    public function validAssignedProject($project)
    {
        if ($this->other->canUseProject($project)) {
            return true;
        }

        $this->form_validation->set_message('validAssignedProject', 'Project tidak tersedia atau belum diassign ke user ini.');
        return false;
    }

    private function allowedProsesByRole()
    {
        $roleId = (int) $this->session->userdata('role_id');

        if ($roleId === 8) {
            return ['2'];
        }

        if ($roleId === 9) {
            return ['1', '3', '4'];
        }

        if ($roleId === 5) {
            return ['1', '2', '3', '4'];
        }

        return [];
    }
}
