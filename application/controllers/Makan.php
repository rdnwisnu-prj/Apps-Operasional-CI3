<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Makan extends CI_Controller
{
    private $lampiranPath;
    private $lampiranMaxBytes = 102400;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Makan_model', 'makan');
        $this->load->library('form_validation');
        $this->lampiranPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'makan' . DIRECTORY_SEPARATOR;
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = [
            'title'     => 'Operasional Web App | Biaya Makan',
            'header'    => 'Keuangan',
            'subheader' => 'Biaya Makan',
            'makan'     => $this->makan->getData(),
            'projects'  => $this->makan->getProjects(),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('makan/index', $data);
        $this->load->view('templates/footer');
    }

    public function Store()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Makan');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Makan');
            return;
        }

        $lampiran = $this->uploadLampiranCompressed();
        if ($lampiran === false) {
            redirect('Makan');
            return;
        }

        $insert = $this->buildPayload();
        $insert['lampiran'] = $lampiran ?: '';
        $insert['korlap'] = $this->session->userdata('id_user');
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');

        $this->makan->storeData($insert);
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Makan');
    }

    public function edit($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        redirect('Makan');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Makan');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $id = $this->input->post('id_makan', true);
        $oldData = $this->makan->getById($id);

        if (!$oldData) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Makan');
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Makan');
            return;
        }

        $lampiran = $this->uploadLampiranCompressed($oldData['lampiran'] ?? '');
        if ($lampiran === false) {
            redirect('Makan');
            return;
        }

        $update = $this->buildPayload();
        if ($lampiran) {
            $update['lampiran'] = $lampiran;
        }
        $update['updated_at'] = date('Y-m-d H:i:s');

        $this->makan->editData($id, $update);
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Makan');
    }

    public function destroy($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $row = $this->makan->getById($id);
        if ($row && !empty($row['lampiran'])) {
            $this->deleteLampiran($row['lampiran']);
        }

        $this->makan->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Makan');
    }

    public function validProjectDate($tgl_makan)
    {
        $project = $this->input->post('project', true);

        if ($project === '' || $tgl_makan === '') {
            $this->form_validation->set_message('validProjectDate', 'Project dan tanggal makan wajib diisi.');
            return false;
        }

        $projectData = $this->makan->getProjectByKode($project);
        if (!$projectData) {
            $this->form_validation->set_message('validProjectDate', 'Project tidak ditemukan.');
            return false;
        }

        $date = $this->parseDate($tgl_makan);
        $projectStart = $this->parseDate($projectData['tgl_mulai']);
        $projectEnd = $this->parseDate($projectData['tgl_selesai']);

        if (!$date || !$projectStart || !$projectEnd) {
            $this->form_validation->set_message('validProjectDate', 'Format tanggal tidak valid.');
            return false;
        }

        if ($date < $projectStart || $date > $projectEnd) {
            $this->form_validation->set_message('validProjectDate', 'Tanggal makan harus berada dalam range tanggal project.');
            return false;
        }

        return true;
    }

    private function setRules()
    {
        $this->form_validation->set_rules('project', 'Project', 'required|trim');
        $this->form_validation->set_rules('tgl_makan', 'Tanggal', 'required|trim|callback_validProjectDate');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|callback_validRoleProses');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
    }

    private function buildPayload()
    {
        $jumlah = (double) $this->input->post('jumlah', true);
        $nominal = (double) $this->input->post('nominal', true);

        return [
            'project'    => $this->input->post('project', true),
            'proses'     => $this->input->post('proses', true),
            'tgl_makan'  => $this->input->post('tgl_makan', true),
            'jumlah'     => $jumlah,
            'nominal'    => $nominal,
            'total'      => $jumlah * $nominal,
            'keterangan' => $this->input->post('keterangan', true),
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

    private function parseDate($date)
    {
        $parsed = DateTime::createFromFormat('Y-m-d', $date);
        if (!$parsed || $parsed->format('Y-m-d') !== $date) {
            return false;
        }

        $parsed->setTime(0, 0, 0);
        return $parsed;
    }

    private function requireOperationalInputRole()
    {
        if (in_array((int) $this->session->userdata('role_id'), [5, 8, 9], true)) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Hanya user dengan role 5, 8, dan 9 yang dapat mengelola data operasional.');
        redirect('Makan');
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
