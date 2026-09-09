<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FeeDokter extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('FeeDokter_model', 'fee_dokter');
        $this->load->library('form_validation');
        is_logged_in();
        check_role_access();
    }

    public function index()
    {
        if ($this->input->server('QUERY_STRING')) {
            redirect('FeeDokter');
            return;
        }

        $data = [
            'title'      => 'Operational Cakra Application | Fee Dokter',
            'header'     => 'Keuangan',
            'subheader'  => 'Data Fee Dokter',
            'fee_dokter' => $this->fee_dokter->getData(),
            'list_cabang'=> $this->fee_dokter->getCabang(),
            'list_dokter'=> $this->fee_dokter->getDokter(),
            'f_bulan'    => '',
            'f_tahun'    => '',
            'f_cabang'   => '',
            'f_dokter'   => '',
            'f_pph'      => '',
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('fee_dokter/index', $data);
        $this->load->view('templates/footer');
    }

    public function filter()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $filters = $this->buildFilters('post');
        $data = $this->fee_dokter->getData($filters);
        $rows = [];
        $no = 1;

        foreach ($data as $row) {
            $rows[] = $this->formatFilterRow($row, $no++);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'count'  => count($rows),
                'rows'   => $rows,
            ]));
    }

    private function buildFilters($method = 'get')
    {
        $source = ($method === 'post') ? 'post' : 'get';
        $bulan  = $this->input->{$source}('bulan', true);
        $tahun  = $this->input->{$source}('tahun', true);
        $cabang = $this->input->{$source}('cabang', true);
        $dokter = $this->input->{$source}('dokter', true);
        $pph    = $this->input->{$source}('pph', true);

        $filters = [];
        if ($bulan !== null && $bulan !== '') {
            $filters['bulan'] = (int) $bulan;
        }
        if ($tahun !== null && $tahun !== '') {
            $filters['tahun'] = (int) $tahun;
        }
        if ($cabang !== null && $cabang !== '') {
            $filters['cabang'] = (int) $cabang;
        }
        if ($dokter !== null && $dokter !== '') {
            $dokterIds = is_array($dokter) ? $dokter : explode(',', (string) $dokter);
            $dokterIds = array_values(array_unique(array_filter(array_map('intval', $dokterIds))));

            if (!empty($dokterIds)) {
                $filters['dokter'] = $dokterIds;
            }
        }
        if ($pph !== null && $pph !== '') {
            $filters['pph21'] = (int) $pph;
        }

        return $filters;
    }

    private function formatFilterRow($row, $no)
    {
        $biayaTambahan = '-';
        if (!empty($row['biaya_tambahan']) && $row['biaya_tambahan'] > 0) {
            $biayaTambahan = $this->formatRupiah($row['biaya_tambahan'])
                . '<small class="d-block text-muted">' . html_escape($row['jenis_biaya_tambahan']) . '</small>';
        }

        $keterangan = $row['keterangan'] ?: ($row['nama_project'] ?? $row['project']);
        $tanggal = !empty($row['tgl_project']) ? tanggal_indonesia_medium(date($row['tgl_project'])) : '-';
        $pajak = ($row['pph21'] == 1) ? $row['jumlah_pph'] : $row['jumlah_nopph'];
        $jenisPajak = ($row['pph21'] == 1)
            ? '<span class="badge bg-warning-subtle text-warning">PPH21</span>'
            : '<span class="badge bg-info-subtle text-info">Non PPH21</span>';

        $lampiran = '-';
        if (!empty($row['lampiran'])) {
            $lampiran = '<a href="' . base_url('uploads/lampiran/' . rawurlencode($row['lampiran'])) . '" target="_blank" data-bs-toggle="tooltip" title="Lihat Lampiran">'
                . '<i class="ti ti-photo fs-18 text-primary"></i></a>';
        }

        $action = '<a href="' . base_url('FeeDokter/edit/' . $row['id_fee']) . '" class="btn btn-warning btn-icon btn-sm waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">'
            . '<i class="ti ti-pencil"></i></a> '
            . '<a href="' . base_url('FeeDokter/destroy/' . $row['id_fee']) . '" class="btn btn-danger btn-icon btn-sm waves-effect waves-light btn-destroy" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">'
            . '<i class="ti ti-trash"></i></a>';

        return [
            '<span class="d-block text-center">' . (int) $no . '</span>',
            html_escape($row['nama_dokter']),
            '<span class="d-block text-center">' . (int) $row['jumlah_hari'] . '</span>',
            '<span class="d-block text-end">' . $this->formatRupiah($row['fee']) . '</span>',
            '<span class="d-block text-end">' . $biayaTambahan . '</span>',
            '<span class="d-block text-end">' . $this->formatRupiah($row['total']) . '</span>',
            html_escape($keterangan),
            '<span class="d-block text-center">' . $tanggal . '</span>',
            '<span class="d-block text-center">2.5%</span>',
            '<span class="d-block text-end">' . $this->formatRupiah($pajak) . '</span>',
            '<span class="d-block text-center">' . $jenisPajak . '</span>',
            '<span class="d-block text-center">' . $lampiran . '</span>',
            '<span class="d-block text-end">' . $action . '</span>',
        ];
    }

    private function formatRupiah($number)
    {
        return 'Rp ' . number_format((float) $number, 0, ',', '.');
    }

    private function calculateTax($total, $pph21)
    {
        $total = (double) $total;
        $pph21 = (int) $pph21;
        $rate = 2.5 / 100;
        $taxBase = 1 - $rate;

        if ($pph21 === 1) {
            return [
                'pph21'         => 1,
                'no_pph21'      => 0,
                'jumlah_pph'    => round($total * $rate, 2),
                'jumlah_nopph'  => 0,
                'diterima'      => round($total - ($total * $rate), 2),
            ];
        }

        $diterima = $taxBase > 0 ? ($total / $taxBase) : $total;
        return [
            'pph21'         => 0,
            'no_pph21'      => 1,
            'jumlah_pph'    => 0,
            'jumlah_nopph'  => round($diterima - $total, 2),
            'diterima'      => round($diterima, 2),
        ];
    }

    public function Store()
    {
        $data = [
            'title'      => 'Operational Cakra Application | Tambah Fee Dokter',
            'header'     => 'Keuangan',
            'subheader'  => 'Tambah Fee Dokter',
            'projects'   => $this->fee_dokter->getProjects(),
            'cabang'     => $this->fee_dokter->getCabang(),
            'dokter'     => $this->fee_dokter->getDokter(),
        ];

        $this->form_validation->set_rules('project', 'Project', 'required');
        $this->form_validation->set_rules('dokter_id', 'Nama Dokter', 'required|integer');
        $this->form_validation->set_rules('tgl_project', 'Tanggal', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required|integer');
        $this->form_validation->set_rules('total', 'Total', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('fee_dokter/add', $data);
            $this->load->view('templates/footer');
        } else {
            $dokter = $this->fee_dokter->getDokterById((int) $this->input->post('dokter_id', true));
            if (!$dokter) {
                $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
                redirect('FeeDokter/Store');
                return;
            }

            $total = (double) $this->input->post('total', true);
            $pph21 = (int) $this->input->post('pph21', true);
            $tax = $this->calculateTax($total, $pph21);

            $lampiran = '';
            $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'lampiran' . DIRECTORY_SEPARATOR;
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            if (!empty($_FILES['lampiran']['name'])) {
                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 5120; // 5MB
                $config['encrypt_name']  = TRUE;
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran')) {
                    $lampiran = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                    redirect('FeeDokter/Store');
                    return;
                }
            }

            $insert = [
                'project'               => $this->input->post('project', true),
                'tgl_project'           => $this->input->post('tgl_project', true),
                'dokter_id'             => (int) $dokter['id_dokter'],
                'nama_dokter'           => $dokter['nama_dokter'],
                'spesialis'             => $this->input->post('spesialis', true),
                'jumlah_hari'           => (double) $this->input->post('jumlah_hari', true),
                'fee'                   => (double) $this->input->post('fee', true),
                'total'                 => $total,
                'jenis_biaya_tambahan'  => $this->input->post('jenis_biaya_tambahan', true),
                'biaya_tambahan'        => (double) $this->input->post('biaya_tambahan', true),
                'cabang'                => (int) $this->input->post('cabang', true),
                'ktp'                   => $dokter['ktp'] ?? '',
                'no_rek'                => $dokter['no_rekening'],
                'bank'                  => $dokter['bank'],
                'kcp'                   => $dokter['kcp'],
                'atas_nama'             => $dokter['atas_nama'],
                'pph21'                 => $tax['pph21'],
                'no_pph21'              => $tax['no_pph21'],
                'jumlah_pph'            => $tax['jumlah_pph'],
                'jumlah_nopph'          => $tax['jumlah_nopph'],
                'keterangan'            => $this->input->post('keterangan', true),
                'lampiran'              => $lampiran,
                'user_id'               => $this->session->userdata('id_user'),
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ];

            $id_fee = $this->fee_dokter->storeData($insert);

            // Save multiple rekening
            $banks     = $this->input->post('rek_bank');
            $no_reks   = $this->input->post('rek_no_rek');
            $atas_namas = $this->input->post('rek_atas_nama');
            $kcps      = $this->input->post('rek_kcp');
            $actives   = $this->input->post('rek_active');

            if (!empty($banks) && is_array($banks)) {
                foreach ($banks as $i => $bank) {
                    if (empty($bank) && empty($no_reks[$i])) continue;
                    $this->fee_dokter->storeRekening([
                        'id_fee'    => $id_fee,
                        'bank'      => $bank,
                        'no_rek'    => $no_reks[$i] ?? '',
                        'atas_nama' => $atas_namas[$i] ?? '',
                        'kcp'       => $kcps[$i] ?? '',
                        'is_active' => ($actives !== null && (string) $actives === (string) $i) ? 1 : 0,
                    ]);
                }
            }

            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('FeeDokter');
        }
    }

    public function edit($id)
    {
        $edit_data = $this->fee_dokter->getById($id);

        if (!$edit_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('FeeDokter');
            return;
        }

        $data = [
            'title'      => 'Operational Cakra Application | Edit Fee Dokter',
            'header'     => 'Keuangan',
            'subheader'  => 'Edit Fee Dokter',
            'edit_data'  => $edit_data,
            'projects'   => $this->fee_dokter->getProjects(),
            'cabang'     => $this->fee_dokter->getCabang(),
            'dokter'     => $this->fee_dokter->getDokter(),
            'rekening'   => $this->fee_dokter->getRekeningByFee($id),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('fee_dokter/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $id = $this->input->post('id_fee');

        $this->form_validation->set_rules('project', 'Project', 'required');
        $this->form_validation->set_rules('dokter_id', 'Nama Dokter', 'required|integer');
        $this->form_validation->set_rules('tgl_project', 'Tanggal', 'required');
        $this->form_validation->set_rules('cabang', 'Cabang', 'required|integer');
        $this->form_validation->set_rules('total', 'Total', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $edit_data = $this->fee_dokter->getById($id);

            $data = [
                'title'      => 'Operational Cakra Application | Edit Fee Dokter',
                'header'     => 'Keuangan',
                'subheader'  => 'Edit Fee Dokter',
                'edit_data'  => $edit_data,
                'projects'   => $this->fee_dokter->getProjects(),
                'cabang'     => $this->fee_dokter->getCabang(),
                'dokter'     => $this->fee_dokter->getDokter(),
                'rekening'   => $this->fee_dokter->getRekeningByFee($id),
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('fee_dokter/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $dokter = $this->fee_dokter->getDokterById((int) $this->input->post('dokter_id', true));
            if (!$dokter) {
                $this->session->set_flashdata('error', 'Data dokter tidak ditemukan');
                redirect('FeeDokter/edit/' . $id);
                return;
            }

            $total = (double) $this->input->post('total', true);
            $pph21 = (int) $this->input->post('pph21', true);
            $tax = $this->calculateTax($total, $pph21);

            $old_data = $this->fee_dokter->getById($id);
            $lampiran = $old_data['lampiran'];
            $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'lampiran' . DIRECTORY_SEPARATOR;
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }
            if (!empty($_FILES['lampiran']['name'])) {
                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 5120; // 5MB
                $config['encrypt_name']  = TRUE;
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('lampiran')) {
                    if (!empty($old_data['lampiran']) && file_exists($upload_path . $old_data['lampiran'])) {
                        unlink($upload_path . $old_data['lampiran']);
                    }
                    $lampiran = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                    redirect('FeeDokter/edit/' . $id);
                    return;
                }
            }

            $update = [
                'project'               => $this->input->post('project', true),
                'tgl_project'           => $this->input->post('tgl_project', true),
                'dokter_id'             => (int) $dokter['id_dokter'],
                'nama_dokter'           => $dokter['nama_dokter'],
                'spesialis'             => $this->input->post('spesialis', true),
                'jumlah_hari'           => (double) $this->input->post('jumlah_hari', true),
                'fee'                   => (double) $this->input->post('fee', true),
                'total'                 => $total,
                'jenis_biaya_tambahan'  => $this->input->post('jenis_biaya_tambahan', true),
                'biaya_tambahan'        => (double) $this->input->post('biaya_tambahan', true),
                'cabang'                => (int) $this->input->post('cabang', true),
                'ktp'                   => $dokter['ktp'] ?? '',
                'no_rek'                => $dokter['no_rekening'],
                'bank'                  => $dokter['bank'],
                'kcp'                   => $dokter['kcp'],
                'atas_nama'             => $dokter['atas_nama'],
                'pph21'                 => $tax['pph21'],
                'no_pph21'              => $tax['no_pph21'],
                'jumlah_pph'            => $tax['jumlah_pph'],
                'jumlah_nopph'          => $tax['jumlah_nopph'],
                'keterangan'            => $this->input->post('keterangan', true),
                'lampiran'              => $lampiran,
                'updated_at'            => date('Y-m-d H:i:s'),
            ];

            $this->fee_dokter->editData($id, $update);

            // Update rekening: delete old, insert new
            $this->fee_dokter->deleteRekeningByFee($id);
            $banks     = $this->input->post('rek_bank');
            $no_reks   = $this->input->post('rek_no_rek');
            $atas_namas = $this->input->post('rek_atas_nama');
            $kcps      = $this->input->post('rek_kcp');
            $actives   = $this->input->post('rek_active');

            if (!empty($banks) && is_array($banks)) {
                foreach ($banks as $i => $bank) {
                    if (empty($bank) && empty($no_reks[$i])) continue;
                    $this->fee_dokter->storeRekening([
                        'id_fee'    => $id,
                        'bank'      => $bank,
                        'no_rek'    => $no_reks[$i] ?? '',
                        'atas_nama' => $atas_namas[$i] ?? '',
                        'kcp'       => $kcps[$i] ?? '',
                        'is_active' => ($actives !== null && (string) $actives === (string) $i) ? 1 : 0,
                    ]);
                }
            }

            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect('FeeDokter');
        }
    }

    public function destroy($id)
    {
        // Delete lampiran file if exists
        $data = $this->fee_dokter->getById($id);
        $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'lampiran' . DIRECTORY_SEPARATOR;
        if ($data && !empty($data['lampiran']) && file_exists($upload_path . $data['lampiran'])) {
            unlink($upload_path . $data['lampiran']);
        }

        $this->fee_dokter->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('FeeDokter');
    }

    public function getProjectDates()
    {
        $kode = $this->input->get('kode');
        $this->db->select('tgl_mulai, tgl_selesai');
        $this->db->where('kode_project', $kode);
        $row = $this->db->get('tab_project')->row_array();
        echo json_encode($row ? $row : ['tgl_mulai' => '', 'tgl_selesai' => '']);
    }

    /**
     * AJAX: Search nama_dokter for autocomplete
     */
    public function searchNamaDokter()
    {
        $keyword = $this->input->get('term', true);
        $results = $this->fee_dokter->searchByNamaDokter($keyword);

        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'id'    => $row['id_dokter'],
                'label' => $row['nama_dokter'],
                'value' => $row['nama_dokter'],
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getDokterDetail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $id = (int) $this->input->get('id', true);
        $dokter = $this->fee_dokter->getDokterById($id);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => !empty($dokter),
                'dokter' => $dokter ?: null,
            ]));
    }

    /**
     * AJAX: Get latest dokter detail by nama (spesialis, ktp, rekening)
     */
    public function getDetailByNamaDokter()
    {
        $nama = $this->input->get('nama', true);
        $result = $this->fee_dokter->getLatestByNamaDokter($nama);

        if ($result) {
            $response = [
                'status'     => true,
                'spesialis'  => $result['spesialis'] ?? '',
                'ktp'        => $result['ktp'] ?? '',
                'rekening'   => $result['rekening'] ?? []
            ];
        } else {
            $response = ['status' => false];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function exportDokter($data, $bulan, $tahun, $dokterData = null)
    {
        $namaBulan = [
            '1'=>'JANUARI','2'=>'FEBRUARI','3'=>'MARET','4'=>'APRIL',
            '5'=>'MEI','6'=>'JUNI','7'=>'JULI','8'=>'AGUSTUS',
            '9'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'
        ];

        $namaDokter = $dokterData['nama_dokter'] ?? ($data[0]['nama_dokter'] ?? 'DOKTER');
        $title = 'FEE DOKTER - ' . strtoupper($namaDokter);
        if (!empty($bulan) && isset($namaBulan[$bulan])) {
            $title .= ' (BULAN ' . $namaBulan[$bulan] . (!empty($tahun) ? ' ' . $tahun : '') . ')';
        } elseif (!empty($tahun)) {
            $title .= ' (TAHUN ' . $tahun . ')';
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Fee Dokter');

        $headers = [
            'No', 'Nama Dokter', 'Psi', 'Fee', 'Jumlah Fee', 'Nomor Rekening',
            'Nama Bank', 'KCP', 'Atas Nama', 'Keterangan', 'Tanggal', 'PPH 21',
            'JML PPH 21', 'FEE + PPH', 'KTP'
        ];
        $columns = range('A', 'O');

        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:O1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        foreach ($headers as $i => $header) {
            $sheet->setCellValue($columns[$i] . '2', $header);
        }

        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A2:O2')->applyFromArray($headerStyle);

        $row = 3;
        $no = 1;
        $totalFee = 0;
        $totalPajak = 0;
        $totalDiterima = 0;

        foreach ($data as $f) {
            $rekeningNo = $f['rek_no_rek'] ?: $f['no_rek'];
            $rekeningBank = $f['rek_bank'] ?: $f['bank'];
            $rekeningKcp = $f['rek_kcp'] ?: $f['kcp'];
            $rekeningAtasNama = $f['rek_atas_nama'] ?: $f['atas_nama'];
            $keterangan = $f['keterangan'] ?: ($f['nama_project'] ?? $f['project']);
            $pajak = ($f['pph21'] == 1) ? (double) $f['jumlah_pph'] : (double) $f['jumlah_nopph'];
            $diterima = ($f['pph21'] == 1)
                ? ((double) $f['total'] - (double) $f['jumlah_pph'])
                : ((double) $f['total'] + (double) $f['jumlah_nopph']);

            $sheet->fromArray([
                $no,
                $f['nama_dokter'],
                (double) $f['jumlah_hari'],
                (double) $f['fee'],
                (double) $f['total'],
                $rekeningNo,
                $rekeningBank,
                $rekeningKcp,
                $rekeningAtasNama,
                $keterangan,
                !empty($f['tgl_project']) ? date('d-M-y', strtotime($f['tgl_project'])) : '-',
                '2.5%',
                $pajak,
                $diterima,
                $f['master_ktp'] ?: $f['ktp'],
            ], null, 'A' . $row);

            $totalFee += (double) $f['total'];
            $totalPajak += $pajak;
            $totalDiterima += $diterima;
            $row++;
            $no++;
        }

        $totalRow = $row;
        $sheet->setCellValue('A' . $totalRow, 'TOTAL');
        $sheet->mergeCells('A' . $totalRow . ':D' . $totalRow);
        $sheet->setCellValue('E' . $totalRow, $totalFee);
        $sheet->mergeCells('F' . $totalRow . ':I' . $totalRow);
        $sheet->setCellValue('M' . $totalRow, $totalPajak);
        $sheet->setCellValue('N' . $totalRow, $totalDiterima);

        $lastRow = $totalRow;
        $sheet->getStyle('A1:O' . $lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('A' . $totalRow . ':O' . $totalRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $totalRow . ':O' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A3:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C3:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('K3:L' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('M3:N' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B3:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F3:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('O3:O' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('C3:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M3:N' . $lastRow)->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle('F3:F' . $lastRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('O3:O' . $lastRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

        $widths = [
            'A' => 6, 'B' => 34, 'C' => 10, 'D' => 12, 'E' => 15,
            'F' => 22, 'G' => 14, 'H' => 14, 'I' => 30, 'J' => 48,
            'K' => 13, 'L' => 10, 'M' => 18, 'N' => 18, 'O' => 24,
        ];
        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->getRowDimension(1)->setRowHeight(24);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $sheet->freezePane('A3');

        $filename = 'Fee_Dokter_' . preg_replace('/[^A-Za-z0-9_-]+/', '_', $namaDokter);
        if (!empty($bulan) && isset($namaBulan[$bulan])) {
            $filename .= '_' . $namaBulan[$bulan];
        }
        if (!empty($tahun)) {
            $filename .= '_' . $tahun;
        }
        $filename .= '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    private function exportMultipleDokter($data, $bulan, $tahun, $filters = [])
    {
        $title = 'FEE DOKTER';
        if (isset($filters['pph21'])) {
            $title .= ((int) $filters['pph21'] === 1) ? ' - PPH 21' : ' - NON PPH 21';
        }
        $title .= '  ( PER DOKTER )';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Fee Dokter');

        $headers = [
            'No', 'Nama Dokter', 'Pasien', 'Fee', 'Biaya Tambahan', 'Jumlah Fee',
            'Nomor Rekening', 'Nama Bank', 'KCP', 'Atas Nama', 'Keterangan',
            'Tanggal', 'PPH 21', 'JML PPH 21', 'FEE + PPH', 'NO KTP'
        ];
        $columns = range('A', 'P');

        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:P1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFFF00'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $headerStyle = [
            'font' => ['bold' => true, 'size' => 10],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $groups = [];
        foreach ($data as $item) {
            $key = !empty($item['dokter_id']) ? 'id_' . $item['dokter_id'] : 'nama_' . $item['nama_dokter'];
            if (!isset($groups[$key])) {
                $groups[$key] = [
                    'nama' => $item['nama_dokter'],
                    'rows' => [],
                ];
            }
            $groups[$key]['rows'][] = $item;
        }

        uasort($groups, function ($a, $b) {
            return strcasecmp($a['nama'], $b['nama']);
        });

        $row = 2;
        $groupIndex = 0;
        $grandTotalFee = 0;
        $grandTotalPajak = 0;
        $grandTotalDiterima = 0;

        foreach ($groups as $group) {
            if ($groupIndex > 0) {
                $row++;
            }

            foreach ($headers as $i => $header) {
                $sheet->setCellValue($columns[$i] . $row, $header);
            }
            $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray($headerStyle);

            $row++;
            $no = 1;
            $totalTambahan = 0;
            $totalFee = 0;
            $totalPajak = 0;
            $totalDiterima = 0;

            foreach ($group['rows'] as $f) {
                $rekeningNo = $f['rek_no_rek'] ?: $f['no_rek'];
                $rekeningBank = $f['rek_bank'] ?: $f['bank'];
                $rekeningKcp = $f['rek_kcp'] ?: $f['kcp'];
                $rekeningAtasNama = $f['rek_atas_nama'] ?: $f['atas_nama'];
                $keterangan = $f['keterangan'] ?: ($f['nama_project'] ?? $f['project']);
                $pajak = ($f['pph21'] == 1) ? (double) $f['jumlah_pph'] : (double) $f['jumlah_nopph'];
                $diterima = ($f['pph21'] == 1)
                    ? ((double) $f['total'] - (double) $f['jumlah_pph'])
                    : ((double) $f['total'] + (double) $f['jumlah_nopph']);
                $ktp = $f['master_ktp'] ?: $f['ktp'];

                $sheet->fromArray([
                    $no,
                    $f['nama_dokter'],
                    (double) $f['jumlah_hari'],
                    (double) $f['fee'],
                    (double) $f['biaya_tambahan'],
                    (double) $f['total'],
                    null,
                    $rekeningBank,
                    $rekeningKcp,
                    $rekeningAtasNama,
                    $keterangan,
                    !empty($f['tgl_project']) ? date('d-M-y', strtotime($f['tgl_project'])) : '-',
                    '2.5%',
                    $pajak,
                    $diterima,
                    null,
                ], null, 'A' . $row);
                $sheet->setCellValueExplicit('G' . $row, (string) $rekeningNo, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValueExplicit('P' . $row, (string) $ktp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                $totalTambahan += (double) $f['biaya_tambahan'];
                $totalFee += (double) $f['total'];
                $totalPajak += $pajak;
                $totalDiterima += $diterima;
                $row++;
                $no++;
            }

            $totalRow = $row;
            $sheet->setCellValue('A' . $totalRow, 'TOTAL');
            $sheet->mergeCells('A' . $totalRow . ':D' . $totalRow);
            $sheet->setCellValue('E' . $totalRow, $totalTambahan);
            $sheet->setCellValue('F' . $totalRow, $totalFee);
            $sheet->mergeCells('G' . $totalRow . ':J' . $totalRow);
            $sheet->setCellValue('N' . $totalRow, $totalPajak);
            $sheet->setCellValue('O' . $totalRow, $totalDiterima);
            $sheet->getStyle('A' . $totalRow . ':P' . $totalRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $totalRow . ':P' . $totalRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $grandTotalFee += $totalFee;
            $grandTotalPajak += $totalPajak;
            $grandTotalDiterima += $totalDiterima;
            $row++;
            $groupIndex++;
        }

        $grandRow = $row;
        $sheet->setCellValue('F' . $grandRow, $grandTotalFee);
        $sheet->setCellValue('N' . $grandRow, $grandTotalPajak);
        $sheet->setCellValue('O' . $grandRow, $grandTotalDiterima);
        $sheet->getStyle('A' . $grandRow . ':P' . $grandRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $grandRow . ':P' . $grandRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $lastRow = $grandRow;
        $sheet->getStyle('A1:P' . $lastRow)->applyFromArray($borderStyle);
        $sheet->getStyle('A2:P' . $lastRow)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G2:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('L2:M' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('N2:O' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('P2:P' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('C2:F' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N2:O' . $lastRow)->getNumberFormat()->setFormatCode('"Rp" #,##0');
        $sheet->getStyle('G2:G' . $lastRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
        $sheet->getStyle('P2:P' . $lastRow)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

        $widths = [
            'A' => 9, 'B' => 40, 'C' => 12, 'D' => 10, 'E' => 24, 'F' => 20,
            'G' => 23, 'H' => 16, 'I' => 14, 'J' => 37, 'K' => 36, 'L' => 15,
            'M' => 14, 'N' => 18, 'O' => 24, 'P' => 26,
        ];
        foreach ($widths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        for ($i = 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(17.25);
        }
        $sheet->freezePane('A2');

        $namaBulan = [
            '1'=>'JANUARI','2'=>'FEBRUARI','3'=>'MARET','4'=>'APRIL',
            '5'=>'MEI','6'=>'JUNI','7'=>'JULI','8'=>'AGUSTUS',
            '9'=>'SEPTEMBER','10'=>'OKTOBER','11'=>'NOVEMBER','12'=>'DESEMBER'
        ];
        $filename = 'Fee_Dokter_Per_Dokter';
        if (!empty($bulan) && isset($namaBulan[$bulan])) {
            $filename .= '_' . $namaBulan[$bulan];
        }
        if (!empty($tahun)) {
            $filename .= '_' . $tahun;
        }
        $filename .= '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function export()
    {
        $filters = $this->buildFilters('get');
        $bulan  = $this->input->get('bulan');
        $tahun  = $this->input->get('tahun');

        $data = $this->fee_dokter->getData($filters);

        if (empty($data)) {
            $this->session->set_flashdata('error', 'Tidak ada data untuk diexport');
            redirect('FeeDokter');
            return;
        }

        $this->exportMultipleDokter($data, $bulan, $tahun, $filters);
    }

}
