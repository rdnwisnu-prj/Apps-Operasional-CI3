<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penginapan extends CI_Controller
{
    private $uploadPath;
    private $invoiceMaxBytes = 102400;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penginapan_model', 'penginapan');
        $this->load->library('form_validation');
        $this->uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'penginapan' . DIRECTORY_SEPARATOR;
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = [
            'title'      => 'Operational Cakra Application | Biaya Penginapan',
            'header'     => 'Keuangan',
            'subheader'  => 'Biaya Penginapan',
            'penginapan' => $this->penginapan->getData(),
            'projects'   => $this->penginapan->getProjects(),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('penginapan/index', $data);
        $this->load->view('templates/footer');
    }

    public function Store()
    {
        $data = $this->formData('Operational Cakra Application | Tambah Biaya Penginapan');

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Penginapan');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Penginapan');
            return;
        }

        $invoice = $this->uploadInvoiceCompressed();
        if ($invoice === false) {
            redirect('Penginapan');
            return;
        }

        $insert = $this->buildPayload();
        $insert['invoice'] = $invoice ?: '';
        $insert['korlap'] = $this->session->userdata('id_user');
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');

        $this->penginapan->storeData($insert);
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Penginapan');
    }

    public function edit($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $edit_data = $this->penginapan->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Penginapan');
            return;
        }

        redirect('Penginapan');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Penginapan');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $id = $this->input->post('id_penginapan', true);
        $edit_data = $this->penginapan->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Penginapan');
            return;
        }

        $data = $this->formData('Operational Cakra Application | Edit Biaya Penginapan', $edit_data);
        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Penginapan');
            return;
        }

        $invoice = $this->uploadInvoiceCompressed();
        if ($invoice === false) {
            redirect('Penginapan');
            return;
        }

        $update = $this->buildPayload();
        if ($invoice) {
            $update['invoice'] = $invoice;
        }
        $update['updated_at'] = date('Y-m-d H:i:s');

        $this->penginapan->editData($id, $update);

        if ($invoice && !empty($edit_data['invoice'])) {
            $this->deleteInvoice($edit_data['invoice']);
        }

        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Penginapan');
    }

    public function destroy($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $row = $this->penginapan->getById($id);
        if ($row && !empty($row['invoice'])) {
            $this->deleteInvoice($row['invoice']);
        }

        $this->penginapan->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Penginapan');
    }

    public function validProjectStay($tgl_checkin)
    {
        $project = $this->input->post('project', true);
        $tglCheckout = $this->input->post('tgl_checkout', true);

        if ($project === '' || $tgl_checkin === '' || $tglCheckout === '') {
            $this->form_validation->set_message('validProjectStay', 'Project, tanggal checkin, dan tanggal checkout wajib diisi.');
            return false;
        }

        $projectData = $this->penginapan->getProjectByKode($project);
        if (!$projectData) {
            $this->form_validation->set_message('validProjectStay', 'Project tidak ditemukan.');
            return false;
        }

        $checkin = $this->parseDate($tgl_checkin);
        $checkout = $this->parseDate($tglCheckout);
        $projectStart = $this->parseDate($projectData['tgl_mulai']);
        $projectEnd = $this->parseDate($projectData['tgl_selesai']);

        if (!$checkin || !$checkout || !$projectStart || !$projectEnd) {
            $this->form_validation->set_message('validProjectStay', 'Format tanggal tidak valid.');
            return false;
        }

        if ($checkout < $checkin) {
            $this->form_validation->set_message('validProjectStay', 'Tanggal checkout tidak boleh lebih kecil dari tanggal checkin.');
            return false;
        }

        if ($checkin < $projectStart || $checkin > $projectEnd || $checkout < $projectStart || $checkout > $projectEnd) {
            $this->form_validation->set_message('validProjectStay', 'Tanggal checkin dan checkout harus berada dalam range tanggal project.');
            return false;
        }

        return true;
    }

    private function formData($title, $editData = null)
    {
        return [
            'title'     => $title,
            'header'    => 'Keuangan',
            'subheader' => 'Biaya Penginapan',
            'projects'  => $this->penginapan->getProjects(),
            'edit_data' => $editData,
        ];
    }

    private function renderForm($view, $data)
    {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view($view, $data);
        $this->load->view('templates/footer');
    }

    private function setRules()
    {
        $this->form_validation->set_rules('project', 'Project', 'required|trim|callback_validAssignedProject');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|callback_validRoleProses');
        $this->form_validation->set_rules('tgl_checkin', 'Tanggal Checkin', 'required|trim|callback_validProjectStay');
        $this->form_validation->set_rules('tgl_checkout', 'Tanggal Checkout', 'required|trim');
        $this->form_validation->set_rules('jumlah_hari', 'Jumlah Hari', 'required|numeric');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
        $this->form_validation->set_rules('nama_hunian', 'Nama Hunian', 'required|trim');
        $this->form_validation->set_rules('tipe_hunian', 'Tipe Hunian', 'required|trim|in_list[Hotel,Mess,Sewa Rumah]');
    }

    private function buildPayload()
    {
        $checkin = $this->parseDate($this->input->post('tgl_checkin', true));
        $checkout = $this->parseDate($this->input->post('tgl_checkout', true));
        $jumlahHari = $this->countStayDays($checkin, $checkout);
        $nominal = (double) $this->input->post('nominal', true);

        return [
            'project'       => $this->input->post('project', true),
            'proses'        => $this->input->post('proses', true),
            'tgl_checkin'   => $this->input->post('tgl_checkin', true),
            'tgl_checkout'  => $this->input->post('tgl_checkout', true),
            'jumlah_hari'   => $jumlahHari,
            'nominal'       => $nominal,
            'nama_hunian'   => $this->input->post('nama_hunian', true),
            'tipe_hunian'   => $this->input->post('tipe_hunian', true),
            'keterangan'    => $this->input->post('keterangan', true),
        ];
    }

    private function uploadInvoiceCompressed()
    {
        if (empty($_FILES['invoice']['name'])) {
            return null;
        }

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }

        $config = [
            'upload_path'   => $this->uploadPath,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 5120,
            'encrypt_name'  => TRUE,
        ];

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('invoice')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return false;
        }

        $uploadData = $this->upload->data();
        $sourcePath = $uploadData['full_path'];
        $targetName = $uploadData['raw_name'] . '.jpg';
        $targetPath = $this->uploadPath . $targetName;

        if (!$this->compressImageToMaxSize($sourcePath, $targetPath)) {
            @unlink($sourcePath);
            $this->session->set_flashdata('error', 'Invoice/Bukti gagal dikompres. Pastikan file berupa JPG atau PNG yang valid.');
            return false;
        }

        $sourceReal = realpath($sourcePath);
        $targetReal = realpath($targetPath);
        if ($sourceReal && $targetReal && $sourceReal !== $targetReal && file_exists($sourcePath)) {
            @unlink($sourcePath);
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
        $scaleBySize = $sourceSize > $this->invoiceMaxBytes ? sqrt($this->invoiceMaxBytes / $sourceSize) : 1;
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

            if (file_exists($targetPath) && filesize($targetPath) <= $this->invoiceMaxBytes) {
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

        $ok = file_exists($targetPath) && filesize($targetPath) <= $this->invoiceMaxBytes;
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

    private function deleteInvoice($filename)
    {
        $filename = basename($filename);
        $path = $this->uploadPath . $filename;
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

    private function countStayDays($checkin, $checkout)
    {
        if (!$checkin || !$checkout || $checkout < $checkin) {
            return 0;
        }

        return (int) $checkin->diff($checkout)->days + 1;
    }

    private function requireOperationalInputRole()
    {
        if (in_array((int) $this->session->userdata('role_id'), [5, 8, 9], true)) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Hanya user dengan role 5, 8, dan 9 yang dapat mengelola data operasional.');
        redirect('Penginapan');
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
        if ($this->penginapan->canUseProject($project)) {
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
