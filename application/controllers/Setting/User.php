<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('Cabang_model', 'cabang');
        $this->load->model('Role_model', 'role');
        $this->load->model('Dept_model', 'dept');
        $this->load->library('form_validation');
		is_logged_in();
	}
	
	public function index()
	{
        $data = [
            'title'     => 'Operational Cakra Application | Setting User',
            'header'    => 'Pengaturan',
            'subheader' => 'User',
            'user'      => $this->user->getData(),
            'cabang'    => $this->cabang->getData(),
            'role'      => $this->role->getData(),
            'dept'      => $this->dept->getData(),
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/user', $data);
		$this->load->view('templates/footer');
	}

    public function create()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]', [
            'min_length' => 'Password terlalu pendek! Minimal 8 karakter.'
        ]);

        if ($this->form_validation->run() == FALSE) {
            
            $data = [
                'title'     => 'Operational Cakra Application | Setting User',
                'header'    => 'Pengaturan',
                'subheader' => 'User',
                'user'      => $this->user->getData(),
                'cabang'    => $this->cabang->getData(),
                'role'      => $this->role->getData(),
                'dept'      => $this->dept->getData(),
                'errors'    => validation_errors()
            ];
            
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/user', $data);
            $this->load->view('templates/footer');
            
        } else {

            $data = [
                "nik"       => $this->input->post('nik', true),
                "nama"      => $this->input->post('nama', true),
                "dept_id"   => $this->input->post('dept_id', true),
                "cabang_id" => $this->input->post('cabang_id', true),
                "username"  => $this->input->post('username', true),
                "password"  => password_hash($this->input->post('password', true), PASSWORD_BCRYPT),
                "role_id"   => $this->input->post('role_id', true),
            ];

            $this->user->storeData($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Setting/User');

        }
    }

    public function edit($id_user)
    {
        $edit_data = $this->user->getUserById($id_user);
        
        $data = [
            'title'     => 'Operational Cakra Application | Setting User',
            'header'    => 'Pengaturan',
            'subheader' => 'User',
            'user'      => $this->user->getData(),
            'cabang'    => $this->cabang->getData(),
            'role'      => $this->role->getData(),
            'dept'      => $this->dept->getData(),
            'edit_data' => $edit_data
        ];

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/user', $data);
		$this->load->view('templates/footer');
    }

    public function update() 
    {
        $id_user = $this->input->post('id_user');
        
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        
        // Validasi password hanya jika diisi
        if (!empty($this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]', [
                'min_length' => 'Password terlalu pendek! Minimal 8 karakter'
            ]);
        }

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan form edit kembali
            $this->edit($id_user);
            
        } else {
            $data = [
                "nik"       => $this->input->post('nik', true),
                "nama"      => $this->input->post('nama', true),
                "dept_id"   => $this->input->post('dept_id', true),
                "cabang_id" => $this->input->post('cabang_id', true),
                "username"  => $this->input->post('username', true),
                "role_id"   => $this->input->post('role_id', true),
            ];

            // Hanya update password jika diisi
            if (!empty($this->input->post('password'))) {
                $data["password"] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }

            $this->user->updateData($id_user, $data);
            $this->session->set_flashdata('flash', 'Diubah');
            redirect('Setting/User');
        }
    }

    public function destroy($id_user)
    {
        $this->user->deleteData($id_user);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Setting/User');
    }
	
}