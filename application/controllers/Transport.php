<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport extends CI_Controller
{
    private $uploadPath;
    private $imageMaxBytes = 102400;

    private $jenisPengeluaranOptions = ['BBM', 'Toll', 'Parkir', 'Sewa Operasional'];
    private $transportOptions = ['Mobil Operasional', 'Mobil Pribadi', 'Taxi Online', 'Sewa'];
    private $jenisOptions = ['Bis', 'Mobil Penumpang', 'Mobil Barang', 'Motor'];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transport_model', 'transport');
        $this->load->library('form_validation');
        $this->uploadPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'transport' . DIRECTORY_SEPARATOR;
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        $data = [
            'title'     => 'Operational Cakra Application | Transport',
            'header'    => 'Keuangan',
            'subheader' => 'Transport',
            'transport' => $this->transport->getData(),
            'projects'  => $this->transport->getProjects(),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('transport/index', $data);
        $this->load->view('templates/footer');
    }

    public function Store()
    {
        $data = $this->formData('Operational Cakra Application | Tambah Transport');

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Transport');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Transport');
            return;
        }

        $lampiran = $this->uploadImageCompressed('lampiran');
        if ($lampiran === false) {
            redirect('Transport');
            return;
        }

        if (!$this->validateStnkUpload()) {
            if ($lampiran) {
                $this->deleteFile($lampiran);
            }
            redirect('Transport');
            return;
        }

        $stnk = $this->uploadImageCompressed('stnk');
        if ($stnk === false) {
            if ($lampiran) {
                $this->deleteFile($lampiran);
            }
            redirect('Transport');
            return;
        }

        $insert = $this->buildPayload();
        $insert['lampiran'] = $lampiran ?: '';
        $insert['stnk'] = $stnk ?: '';
        $insert['korlap'] = $this->session->userdata('id_user');
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated'] = date('Y-m-d H:i:s');

        $this->transport->storeData($insert);
        $this->session->set_flashdata('flash', 'Ditambahkan');
        redirect('Transport');
    }

    public function edit($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $edit_data = $this->transport->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Transport');
            return;
        }

        redirect('Transport');
    }

    public function update()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Transport');
            return;
        }

        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $id = $this->input->post('id_transport', true);
        $edit_data = $this->transport->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Transport');
            return;
        }

        $data = $this->formData('Operational Cakra Application | Edit Transport', $edit_data);
        $this->forcePelaksanaanMcuProses();
        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            redirect('Transport');
            return;
        }

        $lampiran = $this->uploadImageCompressed('lampiran');
        if ($lampiran === false) {
            redirect('Transport');
            return;
        }

        if (!$this->validateStnkUpload($edit_data['stnk'] ?? '')) {
            redirect('Transport');
            return;
        }

        $stnk = $this->uploadImageCompressed('stnk');
        if ($stnk === false) {
            redirect('Transport');
            return;
        }

        $update = $this->buildPayload();
        if ($lampiran) {
            $update['lampiran'] = $lampiran;
        }
        if ($stnk) {
            $update['stnk'] = $stnk;
        }

        $deleteOldStnk = false;
        if ($update['transport'] !== 'Sewa') {
            $deleteOldStnk = !empty($edit_data['stnk']);
            $update['stnk'] = '';
        }

        $update['updated'] = date('Y-m-d H:i:s');

        $this->transport->editData($id, $update);

        if ($lampiran && !empty($edit_data['lampiran'])) {
            $this->deleteFile($edit_data['lampiran']);
        }
        if (($stnk || $deleteOldStnk) && !empty($edit_data['stnk'])) {
            $this->deleteFile($edit_data['stnk']);
        }
        $this->session->set_flashdata('flash', 'Diperbarui');
        redirect('Transport');
    }

    public function destroy($id)
    {
        if (!$this->requireOperationalInputRole()) {
            return;
        }

        $row = $this->transport->getById($id);
        if ($row) {
            if (!empty($row['lampiran'])) {
                $this->deleteFile($row['lampiran']);
            }
            if (!empty($row['stnk'])) {
                $this->deleteFile($row['stnk']);
            }
        }

        $this->transport->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Transport');
    }

    public function requiredIfSewa($value)
    {
        if ($this->isSewaTransport() && trim((string) $value) === '') {
            $this->form_validation->set_message('requiredIfSewa', '{field} wajib diisi jika transport Sewa.');
            return false;
        }

        return true;
    }

    public function requiredTransportIfMobil($value)
    {
        if (!$this->isMobilExpense()) {
            return true;
        }

        $value = trim((string) $value);
        if ($value === '' || !in_array($value, $this->transportOptions, true)) {
            $this->form_validation->set_message('requiredTransportIfMobil', '{field} wajib dipilih jika Jenis Pengeluaran Sewa Operasional.');
            return false;
        }

        return true;
    }

    public function requiredJenisIfMobil($value)
    {
        if (!$this->isMobilExpense()) {
            return true;
        }

        $value = trim((string) $value);
        if ($value === '' || !in_array($value, $this->jenisOptions, true)) {
            $this->form_validation->set_message('requiredJenisIfMobil', '{field} wajib dipilih jika Jenis Pengeluaran Sewa Operasional.');
            return false;
        }

        return true;
    }

    public function requiredTipeIfMobil($value)
    {
        if (!$this->isMobilExpense()) {
            return true;
        }

        if (trim((string) $value) === '') {
            $this->form_validation->set_message('requiredTipeIfMobil', '{field} wajib diisi jika Jenis Pengeluaran Sewa Operasional.');
            return false;
        }

        return true;
    }

    public function validNominal($value)
    {
        $value = trim((string) $value);
        $normalized = str_replace('.', '', $value);

        if ($value === '' || !preg_match('/^\d+(,\d+)?$/', $normalized)) {
            $this->form_validation->set_message('validNominal', '{field} wajib berupa angka.');
            return false;
        }

        return true;
    }

    private function formData($title, $editData = null)
    {
        return [
            'title'     => $title,
            'header'    => 'Keuangan',
            'subheader' => 'Transport',
            'projects'  => $this->transport->getProjects(),
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
        $this->form_validation->set_rules('tgl_transport', 'Tanggal Transport', 'required|trim');
        $this->form_validation->set_rules('proses', 'Proses', 'required|trim|callback_validRoleProses');
        $this->form_validation->set_rules('jenis_pengeluaran', 'Jenis Pengeluaran', 'required|trim|in_list[BBM,Toll,Parkir,Sewa Operasional,Mobil]');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|trim|callback_validNominal');
        $this->form_validation->set_rules('transport', 'Transport', 'trim|callback_requiredTransportIfMobil');
        $this->form_validation->set_rules('jenis', 'Jenis', 'trim|callback_requiredJenisIfMobil');
        $this->form_validation->set_rules('tipe', 'Merk Kendaraan', 'trim|callback_requiredTipeIfMobil');
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'trim|callback_requiredIfSewa');
        $this->form_validation->set_rules('nopol_kendaraan', 'Nomer Polisi Kendaraan', 'trim|callback_requiredIfSewa');
        $this->form_validation->set_rules('ktp_pemilik', 'Nomer KTP', 'trim|callback_requiredIfSewa');
    }

    private function buildPayload()
    {
        $jenisPengeluaran = $this->input->post('jenis_pengeluaran', true);
        $isMobil = $this->isMobilExpenseValue($jenisPengeluaran);
        $transport = $isMobil ? $this->input->post('transport', true) : '';
        $isSewa = $isMobil && $transport === 'Sewa';

        return [
            'project'             => $this->input->post('project', true),
            'proses'              => $this->input->post('proses', true),
            'jenis_pengeluaran'   => $jenisPengeluaran,
            'tgl_transport'       => $this->input->post('tgl_transport', true),
            'nominal'             => (float) str_replace(['.', ','], ['', '.'], (string) $this->input->post('nominal', true)),
            'transport'           => $transport,
            'jenis'               => $isMobil ? $this->input->post('jenis', true) : '',
            'tipe'                => $isMobil ? $this->input->post('tipe', true) : '',
            'nama_pemilik'        => $isSewa ? $this->input->post('nama_pemilik', true) : '',
            'nopol_kendaraan'     => $isSewa ? $this->input->post('nopol_kendaraan', true) : '',
            'ktp_pemilik'         => $isSewa ? $this->input->post('ktp_pemilik', true) : '',
            'keterangan'          => $this->input->post('keterangan', true),
        ];
    }

    private function validateStnkUpload($currentStnk = '')
    {
        if ($this->isSewaTransport() && empty($currentStnk) && empty($_FILES['stnk']['name'])) {
            $this->session->set_flashdata('error', 'Upload STNK wajib diisi jika transport Sewa.');
            return false;
        }

        return true;
    }

    private function uploadImageCompressed($field)
    {
        if (empty($_FILES[$field]['name'])) {
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

        if (!$this->upload->do_upload($field)) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            return false;
        }

        $uploadData = $this->upload->data();
        $sourcePath = $uploadData['full_path'];
        $targetName = $uploadData['raw_name'] . '.jpg';
        $targetPath = $this->uploadPath . $targetName;

        if (!$this->compressImageToMaxSize($sourcePath, $targetPath)) {
            @unlink($sourcePath);
            $this->session->set_flashdata('error', 'Upload gagal dikompres. Pastikan file berupa JPG atau PNG yang valid.');
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
        $scaleBySize = $sourceSize > $this->imageMaxBytes ? sqrt($this->imageMaxBytes / $sourceSize) : 1;
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

            if (file_exists($targetPath) && filesize($targetPath) <= $this->imageMaxBytes) {
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

        $ok = file_exists($targetPath) && filesize($targetPath) <= $this->imageMaxBytes;
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

    private function deleteFile($filename)
    {
        $filename = basename($filename);
        $path = $this->uploadPath . $filename;
        if ($filename !== '' && file_exists($path)) {
            @unlink($path);
        }
    }

    private function requireOperationalInputRole()
    {
        if (in_array((int) $this->session->userdata('role_id'), [5, 8, 9], true)) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Hanya user dengan role 5, 8, dan 9 yang dapat mengelola data operasional.');
        redirect('Transport');
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
        if ($this->transport->canUseProject($project)) {
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

    private function isMobilExpense()
    {
        return $this->isMobilExpenseValue($this->input->post('jenis_pengeluaran', true));
    }

    private function isSewaTransport()
    {
        return $this->isMobilExpense() && $this->input->post('transport', true) === 'Sewa';
    }

    private function isMobilExpenseValue($value)
    {
        return in_array((string) $value, ['Sewa Operasional', 'Mobil'], true);
    }
}
