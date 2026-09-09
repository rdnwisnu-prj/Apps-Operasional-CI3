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
        $data['title'] = 'Operational Cakra Application | Login';
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
        if ($this->input->method() == 'post') {
            $email = $this->input->post('email');
            $user = $this->db->get_where('tab_user', ['email' => $email])->row_array();

            if ($user) {
                $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->auth->resetPassword($user['id_user'], $hashedPassword);
                
                // Load PHPMailer library
                $this->load->library('Phpmailer_Lib');
                $mail = $this->phpmailer_lib->load();
                
                try {
                    // SMTP Configuration
                    $mail->isSMTP();
                    $mail->SMTPDebug = 2; // Debug output: 0 = off, 1 = client, 2 = client and server
                    $mail->Debugoutput = function($str, $level) {
                        log_message('debug', "SMTP Debug level $level: $str");
                    };
                    $mail->Host       = 'srv180.niagahoster.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'no-reply@cakramedika.co.id';
                    $mail->Password   = 'no-reply@CakraMedika2025';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;
                    
                    $mail->Timeout = 60;
                    $mail->SMTPKeepAlive = true;
                    
                    // Recipients
                    $mail->setFrom('no-reply@cakramedika.co.id', 'Operational Cakra Application');
                    $mail->addAddress($email, $user['nama']);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password - Operational Cakra Application';
                    $mail->CharSet = 'UTF-8';
                    
                    // HTML Message
                    $message = '<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Reset Password</title>
                    </head>
                    <body style="font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;">
                        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <h2 style="color: #333; text-align: center; border-bottom: 2px solid #5156BE; padding-bottom: 10px;">Reset Password</h2>
                            <p>Halo <strong>' . htmlspecialchars($user['nama']) . '</strong>,</p>
                            <p>Kami menerima permintaan reset password untuk akun Anda di <strong>Operational Cakra Application</strong>.</p>
                            <p>Berikut adalah password baru Anda:</p>
                            <div style="background: #f8f9fa; padding: 20px; text-align: center; border-radius: 5px; margin: 20px 0;">
                                <span style="font-size: 24px; font-weight: bold; color: #5156BE; letter-spacing: 3px;">' . $newPassword . '</span>
                            </div>
                            <p style="color: #dc3545;"><strong>Penting:</strong> Harap segera login dan ganti password Anda demi keamanan akun.</p>
                            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                            <p style="color: #666; font-size: 12px; text-align: center;">
                                Email ini dikirim secara otomatis oleh sistem.<br>
                                Mohon tidak membalas email ini.
                            </p>
                        </div>
                    </body>
                    </html>';
                    
                    $mail->Body = $message;
                    
                    // Plain text alternative
                    $plainText = "Halo " . $user['nama'] . ",\n\n";
                    $plainText .= "Kami menerima permintaan reset password untuk akun Anda di Operational Cakra Application.\n\n";
                    $plainText .= "Password baru Anda adalah: " . $newPassword . "\n\n";
                    $plainText .= "PENTING: Harap segera login dan ganti password Anda demi keamanan akun.\n\n";
                    $plainText .= "---\n";
                    $plainText .= "Email ini dikirim secara otomatis, mohon tidak membalas email ini.";
                    
                    $mail->AltBody = $plainText;
                    
                    if ($mail->send()) {
                        log_message('info', 'Email reset password berhasil dikirim ke ' . $email);
                        $this->session->set_flashdata('flash', 'Password berhasil direset! Silakan cek email Anda.');
                    } else {
                        log_message('error', 'Email gagal dikirim: ' . $mail->ErrorInfo);
                        $this->session->set_flashdata('error', 'Password berhasil direset tetapi email gagal dikirim. Silakan hubungi administrator.');
                    }
                    
                } catch (Exception $e) {
                    log_message('error', 'PHPMailer Exception: ' . $mail->ErrorInfo);
                    $this->session->set_flashdata('error', 'Password berhasil direset tetapi email gagal dikirim. Error: ' . $mail->ErrorInfo);
                }
                
            } else {
                $this->session->set_flashdata('error', 'Email tidak ditemukan.');
            }
            redirect('Auth/ForgotPassword');
        }
    
        $data['judul'] = 'Operational Cakra Applicationlication | Lupa Password';
        $this->load->view('auth/forgot', $data);
    }
}