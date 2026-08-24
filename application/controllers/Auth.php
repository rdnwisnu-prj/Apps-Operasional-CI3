<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Operasional Web App | Login';
        $this->form_validation->set_rules('username', 'Username / NIK', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $identifier = $this->input->post('username', TRUE);
        $password = $this->input->post('password', FALSE);
        $user = $this->auth->getUserByIdentifier($identifier);
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'id_user'   => $user['id_user'],
                    'nik'       => $user['nik'],
                    'username'  => $user['username'],
                    'nama'      => $user['nama'],
                    'jabatan'   => $user['jabatan'],
                    'foto'      => $user['foto'],
                    'dept_id'   => $user['dept_id'],
                    'role_id'   => $user['role_id'],
                    'cabang_id' => $user['cabang_id'],
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($data);
                $this->session->set_flashdata('flash', 'Login Successfully!');
                redirect('Dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password Salah!');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Akun Tidak Ditemukan!');
            redirect('Auth');
        }
    }

    public function logout()
    {
        $this->session->set_flashdata('flash', 'Logout Successfully!');
        $this->session->unset_userdata([
            'id_user',
            'nik',
            'username',
            'nama',
            'jabatan',
            'foto',
            'dept_id',
            'role_id',
            'cabang_id',
            'logged_in'
        ]);
        redirect('Auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function ForgotPassword()
    {
        $data['judul'] = 'Operasional Web App | Reset Password';
        $data['temporary_password'] = null;
        $data['reset_user'] = null;

        if ($this->input->method() == 'post') {
            $this->form_validation->set_rules('username', 'Username / NIK', 'required|trim');
            $this->form_validation->set_rules('nik', 'NIK', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('auth/forgot', $data);
                return;
            }

            $identifier = $this->input->post('username', TRUE);
            $nik = $this->input->post('nik', TRUE);
            $user = $this->auth->getUserForPasswordReset($identifier, $nik);

            if ($user) {
                $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                if ($this->auth->resetPassword($user['id_user'], $hashedPassword)) {
                    $data['temporary_password'] = $newPassword;
                    $data['reset_user'] = $user;
                    $this->session->set_flashdata('flash', 'Password berhasil direset.');
                } else {
                    $this->session->set_flashdata('error', 'Password gagal direset. Silakan coba lagi.');
                }
            } else {
                $this->session->set_flashdata('error', 'Username/NIK tidak cocok dengan data user.');
            }
        }
    
        $this->load->view('auth/forgot', $data);
    }
}