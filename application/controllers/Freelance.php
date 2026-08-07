<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Freelance extends CI_Controller
{
    private $lampiranPath;
    private $lampiranMaxBytes = 102400;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Freelance_model', 'freelance');
        $this->load->library('form_validation');
        $this->lampiranPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'freelance' . DIRECTORY_SEPARATOR;
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = [
            'title'     => 'Operasional Web App | Fee Freelance',
            'header'    => 'Keuangan',
            'subheader' => 'Fee Freelance',
            'freelance' => $this->freelance->getData(),
            'projects'  => $this->freelance->getProjects(),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('freelance/index', $data);
        $this->load->view('templates/footer');
    }

    public function Store()
    {
        $data = [
            'title'     => 'Operasional Web App | Tambah Fee Freelance',
            'header'    => 'Keuangan',
            'subheader' => 'Fee Freelance',
            'projects'  => $this->freelance->getProjects()
        ];

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Freelance');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Freelance');
            return;
        }

        $lampiran = $this->uploadLampiranCompressed();
        if ($lampiran === false) {
            redirect('Freelance');
            return;
        }

        $insert = $this->buildPayload();
        $insert['lampiran'] = $lampiran ?: '';
        $insert['korlap'] = $this->session->userdata('id_user');
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');

        $this->freelance->storeData($insert);
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Freelance');
    }

    public function edit($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $edit_data = $this->freelance->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Freelance');
            return;
        }

        redirect('Freelance');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Freelance');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $id = $this->input->post('id_freelance', true);
        $edit_data = $this->freelance->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Freelance');
            return;
        }

        $data = [
            'title'     => 'Operasional Web App | Edit Fee Freelance',
            'header'    => 'Keuangan',
            'subheader' => 'Fee Freelance',
            'edit_data' => $edit_data,
            'projects'  => $this->freelance->getProjects(),
        ];

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Freelance');
            return;
        }

        $lampiran = $this->uploadLampiranCompressed($edit_data['lampiran'] ?? '');
        if ($lampiran === false) {
            redirect('Freelance');
            return;
        }

        $update = $this->buildPayload();
        if ($lampiran) {
            $update['lampiran'] = $lampiran;
        }
        $update['updated_at'] = date('Y-m-d H:i:s');

        $this->freelance->editData($id, $update);
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Freelance');
    }

    public function destroy($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $data = $this->freelance->getById($id);
        if ($data && !empty($data['lampiran'])) {
            $this->deleteLampiran($data['lampiran']);
        }

        $this->freelance->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Freelance');
    }

    private function setRules()
    {
        $this->form_validation->set_rules('project', 'Project', 'required|trim');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|callback_validRoleProses');
        $this->form_validation->set_rules('tgl_fee', 'Tanggal Fee', 'required|trim');
        $this->form_validation->set_rules('jobdesk', 'Jobdesk', 'required|trim');
        $this->form_validation->set_rules('jumlah_orang', 'Jumlah Orang', 'required|numeric');
        $this->form_validation->set_rules('jumlah_hari', 'Jumlah Hari', 'required|numeric');
        $this->form_validation->set_rules('fee', 'Fee', 'required|numeric');
        $this->form_validation->set_rules('biaya_tambahan', 'Biaya Tambahan', 'numeric');
    }

    private function buildPayload()
    {
        $jumlahOrang = (double) $this->input->post('jumlah_orang', true);
        $jumlahHari = (double) $this->input->post('jumlah_hari', true);
        $fee = (double) $this->input->post('fee', true);
        $biayaTambahan = (double) $this->input->post('biaya_tambahan', true);

        return [
            'project'        => $this->input->post('project', true),
            'proses'         => $this->input->post('proses', true),
            'tgl_fee'        => $this->input->post('tgl_fee', true),
            'jobdesk'        => $this->input->post('jobdesk', true),
            'jumlah_orang'   => $jumlahOrang,
            'jumlah_hari'    => $jumlahHari,
            'fee'            => $fee,
            'biaya_tambahan' => $biayaTambahan,
            'total'          => ($jumlahOrang * $jumlahHari * $fee) + $biayaTambahan,
            'keterangan'     => $this->input->post('keterangan', true),
        ];
    }

    private function uploadLampiranCompressed($oldLampiran = '')
    {
        if (empty($_FILES['lampiran']['name'])) {
            return null;
        }

        if (!is_dir($this->lampiranPath)) {
            mkdir($this->lampiranPath, 0777, true);
        }

        $config = [
            'upload_path'   => $this->lampiranPath,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 5120,
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('lampiran')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return false;
        }

        $uploadData = $this->upload->data();
        $sourcePath = $uploadData['full_path'];
        $targetName = $uploadData['raw_name'] . '.jpg';
        $targetPath = $this->lampiranPath . $targetName;

        if (!$this->compressImageToMaxSize($sourcePath, $targetPath)) {
            @unlink($sourcePath);
            $this->session->set_flashdata('error', 'Lampiran gagal dikompres. Pastikan file berupa JPG atau PNG yang valid.');
            return false;
        }

        $sourceReal = realpath($sourcePath);
        $targetReal = realpath($targetPath);
        if ($sourceReal && $targetReal && $sourceReal !== $targetReal && file_exists($sourcePath)) {
            @unlink($sourcePath);
        }

        if (!empty($oldLampiran)) {
            $this->deleteLampiran($oldLampiran);
        }

        return $targetName;
    }

    private function compressImageToMaxSize($sourcePath, $targetPath)
    {
        if (!extension_loaded('gd')) {
            return false;
        }

        $info = @getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $image = $this->createImageResource($sourcePath, $info[2]);
        if (!$image) {
            return false;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $sourceSize = max(1, filesize($sourcePath));
        $maxDimension = 1000;
        $scaleBySize = $sourceSize > $this->lampiranMaxBytes ? sqrt($this->lampiranMaxBytes / $sourceSize) : 1;
        $scaleByDimension = min(1, $maxDimension / max($width, $height));
        $scale = min(1, $scaleBySize, $scaleByDimension);
        $quality = 76;

        for ($attempt = 0; $attempt < 14; $attempt++) {
            $newWidth = max(1, (int) floor($width * $scale));
            $newHeight = max(1, (int) floor($height * $scale));
            $canvas = imagecreatetruecolor($newWidth, $newHeight);
            $white = imagecolorallocate($canvas, 255, 255, 255);
            imagefill($canvas, 0, 0, $white);
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagejpeg($canvas, $targetPath, $quality);
            imagedestroy($canvas);

            if (file_exists($targetPath) && filesize($targetPath) <= $this->lampiranMaxBytes) {
                imagedestroy($image);
                return true;
            }

            if ($quality > 50) {
                $quality -= 10;
            } else {
                $scale *= 0.65;
                $quality = 72;
            }
        }

        $ok = file_exists($targetPath) && filesize($targetPath) <= $this->lampiranMaxBytes;
        imagedestroy($image);
        return $ok;
    }

    private function createImageResource($path, $type)
    {
        if ($type === IMAGETYPE_JPEG) {
            return @imagecreatefromjpeg($path);
        }

        if ($type === IMAGETYPE_PNG) {
            return @imagecreatefrompng($path);
        }

        return false;
    }

    private function deleteLampiran($filename)
    {
        $filename = basename($filename);
        $path = $this->lampiranPath . $filename;
        if ($filename !== '' && file_exists($path)) {
            @unlink($path);
        }
    }

    public function searchNama()
    {
        header('Content-Type: application/json');
        echo json_encode([]);
    }

    public function getDetailByNama()
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => false]);
    }

    private function requireOperationalInputRole()
    {
        if (in_array((int) $this->session->userdata('role_id'), [5, 8, 9], true)) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Hanya user dengan role 5, 8, dan 9 yang dapat mengelola data operasional.');
        redirect('Freelance');
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
