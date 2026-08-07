<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Role_model', 'role');
        $this->load->model('User_model', 'user');
		is_logged_in();
		check_role_access();
	}

	public function index()
	{
        if (!$this->session->userdata('logged_in')) {
			redirect('Auth');
		}
		
		$id_user = $this->session->userdata('id_user');
		
		$data = [
			'title'	=> 'Operasional Web App | Profile',
			'user'  => $this->user->getUserById($id_user),
			'role'  => $this->role->getData()
		];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('profile', $data);
        $this->load->view('templates/footer');
	}

	public function update()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('Auth');
		}
		
		$id_user = $this->session->userdata('id_user');
		if (!$id_user) {
			$this->session->set_flashdata('error', 'Session tidak valid!');
			redirect('Auth');
		}
		
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		
		if (!empty($this->input->post('password'))) {
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]', [
				'min_length' => 'Password terlalu pendek! Minimal 8 karakter.'
			]);
		}

		if ($this->form_validation->run() == FALSE) {
			$data = [
				'judul'	=> 'Operasional Web App |  Profile',
				'user'  => $this->user->getUserById($id_user),
				'role'  => $this->role->getData()
			];

			if (!$data['user']) {
				$this->session->set_flashdata('error', 'Data user tidak ditemukan!');
				redirect('Auth');
			}

			$this->load->view('templates/header', $data);
			$this->load->view('templates/sidebar');
			$this->load->view('profile', $data);
			$this->load->view('templates/footer');
			
		} else {
			$data = [
				"nama"   	=> $this->input->post('nama', true),
				"username"  => $this->input->post('username', true)
			];

			$password = $this->input->post('password', true);
			if (!empty($password)) {
				$data["password"] = password_hash($password, PASSWORD_BCRYPT);
			}

			if (!empty($_FILES['foto']['name'])) {
                $upload_path = FCPATH . 'upload/employee/';
                
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0755, true);
                }
                
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['file_name'] = 'user_' . $id_user . '_' . time();
                $config['overwrite'] = false;
                
                $this->load->library('upload');
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('foto')) {
                    $user_data = $this->user->getUserById($id_user);
                    if (!empty($user_data['foto']) && file_exists($upload_path . $user_data['foto'])) {
                        unlink($upload_path . $user_data['foto']);
                    }
                    
                    $data['foto'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', 'Upload foto gagal: ' . $this->upload->display_errors('', ''));
                    redirect('Profile');
                }
            }

			$result = $this->user->updateData($id_user, $data);
			
			if ($result) {
				if ($this->session->userdata('username') != $data['username']) {
					$this->session->set_userdata('username', $data['username']);
				}
				if ($this->session->userdata('nama') != $data['nama']) {
					$this->session->set_userdata('nama', $data['nama']);
				}
				$this->session->set_flashdata('flash', 'Data profil berhasil diperbarui!');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui data profil!');
			}
			
			redirect('Profile');
		}
	}
	
}