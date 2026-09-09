<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller 
{
    public function __construct()
	{
        parent::__construct();
        $this->load->model('Project_model', 'project');
        $this->load->library(['form_validation', 'mpdf_lib']);
	    is_logged_in();
	}
	
    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $data = [
            'title'             => 'Operational Cakra Application | Report Project',
            'header'            => 'Laporan & Pengaturan',
            'subheader'         => 'Report Project',
            'projects'          => $this->getReportProjects(),
            'process_options'   => $this->getProcessOptions(),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('report', $data);
        $this->load->view('templates/footer');
    }

    public function getProjectTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->project->getProjectCountByMonth($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    public function exportActivity()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Report');
            return;
        }

        $payload = $this->buildActivityReportPayload();
        if (!$payload) {
            redirect('Report');
            return;
        }

        $filename = 'laporan-operasional-' . preg_replace('/[^A-Za-z0-9_-]+/', '-', $payload['project']['kode_project'] . '-' . implode('-', $payload['proses_list'])) . '.pdf';
        $html = $this->load->view('report/activity_pdf', $payload, true);
        $this->mpdf_lib->loadHtml($html);
        $this->mpdf_lib->setPaper('A4', 'portrait');
        $this->mpdf_lib->render();
        $this->mpdf_lib->stream($filename, ['Attachment' => true]);
    }

    public function previewActivity()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Report');
            return;
        }

        $payload = $this->buildActivityReportPayload();
        if (!$payload) {
            redirect('Report');
            return;
        }

        $payload['preview_mode'] = true;

        $this->output
            ->set_content_type('text/html', 'utf-8')
            ->set_output($this->load->view('report/activity_pdf', $payload, true));
    }

    public function validDate($value)
    {
        $date = DateTime::createFromFormat('Y-m-d', (string) $value);
        $valid = $date && $date->format('Y-m-d') === $value;

        if (!$valid) {
            $this->form_validation->set_message('validDate', '{field} wajib menggunakan format Y-m-d.');
            return false;
        }

        return true;
    }

    private function buildActivityReportPayload()
    {
        $this->form_validation->set_rules('kode_project', 'Project/Site', 'required|trim');
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal', 'required|trim|callback_validDate');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir', 'required|trim|callback_validDate');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('', ''));
            return null;
        }

        $processOptions = $this->getProcessOptions();
        $prosesList = $this->normalizeSelectedProcesses($this->getSelectedProcessInput(), $processOptions);
        if (empty($prosesList)) {
            $this->session->set_flashdata('error', 'Pilih minimal satu proses.');
            return null;
        }

        $kodeProject = $this->input->post('kode_project', true);
        $project = $this->project->getProjectDetail($kodeProject);

        if (!$project) {
            $this->session->set_flashdata('error', 'Data project tidak ditemukan.');
            return null;
        }

        if ((int) $this->session->userdata('role_id') === 8
            && !$this->project->canKorlapAccessProject($kodeProject, (int) $this->session->userdata('id_user'))) {
            $this->session->set_flashdata('error', 'Akses ditolak. Project tidak sesuai korlap login.');
            return null;
        }

        $dateRange = $this->normalizeDateRange(
            $this->input->post('tgl_awal', true),
            $this->input->post('tgl_akhir', true)
        );

        if (!$dateRange) {
            $this->session->set_flashdata('error', 'Range tanggal tidak valid.');
            return null;
        }

        $summary = $this->project->getProjectFinancialSummary($kodeProject);
        $report = $this->buildActivityReportRows($summary, $dateRange['start'], $dateRange['end'], $prosesList);
        $attachments = $this->buildActivityAttachmentSections($summary, $dateRange['start'], $dateRange['end'], $prosesList);
        $signatureNames = $this->getActivitySignatureNames($kodeProject, $report);

        return [
            'project' => $project,
            'proses_list' => $prosesList,
            'process_label' => $this->buildProcessLabel($prosesList, $processOptions),
            'date_start' => $dateRange['start'],
            'date_end' => $dateRange['end'],
            'rows' => $report['rows'],
            'income_total' => $report['income_total'],
            'topup_total' => $report['topup_total'],
            'expense_total' => $report['expense_total'],
            'saldo_total' => $report['income_total'] - $report['expense_total'],
            'attachment_sections' => $attachments,
            'korlap_name' => $signatureNames['korlap_name'],
            'verified_by_name' => $signatureNames['verified_by_name'],
            'validated_by_name' => $signatureNames['validated_by_name'],
            'approved_by_name' => $signatureNames['approved_by_name'],
            'logo_base64' => $this->imageToBase64(FCPATH . 'assets/img/logo-cakra.png'),
        ];
    }

    private function buildActivityAttachmentSections($summary, $start, $end, $prosesList)
    {
        $sections = [];

        foreach ($prosesList as $proses) {
            $processData = $summary['expense_by_process'][$proses] ?? null;
            if (!$processData) {
                continue;
            }

            $processSection = [
                'label' => $processData['label'] ?? '-',
                'categories' => [],
            ];

            foreach (($processData['categories'] ?? []) as $categoryKey => $category) {
                $items = [];

                foreach (($category['rows'] ?? []) as $expense) {
                    if (!$this->isActivityExpenseInRange($expense, $start, $end)) {
                        continue;
                    }

                    foreach ($this->getActivityAttachmentItems($categoryKey, $category, $expense) as $attachment) {
                        $items[] = $attachment;
                    }
                }

                if (!empty($items)) {
                    $processSection['categories'][] = [
                        'label' => $category['label'] ?? ucfirst($categoryKey),
                        'items' => $items,
                    ];
                }
            }

            if (!empty($processSection['categories'])) {
                $sections[] = $processSection;
            }
        }

        return $sections;
    }

    private function getActivityAttachmentItems($categoryKey, $category, $expense)
    {
        $items = [];
        $files = [
            [
                'file' => $expense['lampiran'] ?? '',
                'label' => $categoryKey === 'penginapan' ? 'Invoice/Bukti' : 'Lampiran',
            ],
            [
                'file' => $expense['lampiran_secondary'] ?? ($expense['stnk'] ?? ''),
                'label' => 'STNK',
            ],
        ];

        foreach ($files as $file) {
            $filename = trim((string) ($file['file'] ?? ''));
            if ($filename === '') {
                continue;
            }

            $path = $this->getActivityAttachmentPath($categoryKey, $filename);
            $items[] = [
                'label' => $file['label'],
                'title' => trim((string) ($expense['item_name'] ?? '-')),
                'meta' => trim((string) ($expense['item_meta'] ?? '')),
                'date_start' => $expense['date_start'] ?? '',
                'date_end' => $expense['date_end'] ?? '',
                'amount' => $expense['amount'] ?? 0,
                'keterangan' => trim((string) ($expense['keterangan'] ?? '')),
                'filename' => basename($filename),
                'url' => $this->getActivityAttachmentUrl($categoryKey, $filename),
                'image_base64' => $this->imageToBase64($path),
            ];
        }

        return $items;
    }

    private function getActivityAttachmentPath($categoryKey, $filename)
    {
        $directory = $this->getActivityAttachmentDirectory($categoryKey);

        return FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . basename($filename);
    }

    private function getActivityAttachmentUrl($categoryKey, $filename)
    {
        $directory = $this->getActivityAttachmentDirectory($categoryKey);

        return base_url('uploads/' . $directory . '/' . rawurlencode(basename($filename)));
    }

    private function getActivityAttachmentDirectory($categoryKey)
    {
        $directories = [
            'entertain' => 'entertain',
            'makan' => 'makan',
            'fee_dokter' => 'lampiran',
            'freelance' => 'freelance',
            'transport' => 'transport',
            'penginapan' => 'penginapan',
            'other' => 'other',
        ];

        return $directories[$categoryKey] ?? $categoryKey;
    }

    private function getBulanNames()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    private function getReportProjects()
    {
        $roleId = (int) $this->session->userdata('role_id');
        $userId = (int) $this->session->userdata('id_user');

        if ($roleId === 8) {
            return $this->project->getDataForKorlap($userId);
        }

        return $this->project->getData();
    }

    private function getProcessOptions()
    {
        return [
            '1' => 'Setting MCU',
            '2' => 'Pelaksanaan MCU',
            '3' => 'Bongkar Setting',
            '4' => 'Kirim Hasil',
        ];
    }

    private function getSelectedProcessInput()
    {
        $processes = [];

        foreach (['proses', 'proses[]', 'proses_mirror'] as $key) {
            $value = $this->input->post($key, true);
            if ($value === null && isset($_POST[$key])) {
                $value = $_POST[$key];
            }

            if ($value === null || $value === '') {
                continue;
            }

            foreach ((array) $value as $process) {
                $processes[] = $process;
            }
        }

        return $processes;
    }

    private function normalizeSelectedProcesses($processes, $processOptions)
    {
        if (!is_array($processes)) {
            $processes = $processes !== null && $processes !== '' ? [$processes] : [];
        }

        $valid = array_map('strval', array_keys($processOptions));
        $selected = [];

        foreach ($processes as $process) {
            $process = trim((string) $process);
            if ($process !== '' && in_array($process, $valid, true)) {
                $selected[$process] = true;
            }
        }

        return array_keys($selected);
    }

    private function buildProcessLabel($processes, $processOptions)
    {
        $labels = [];
        foreach ($processes as $process) {
            if (isset($processOptions[$process])) {
                $labels[] = $processOptions[$process];
            }
        }

        return !empty($labels) ? implode(', ', $labels) : '-';
    }

    private function normalizeDateRange($start, $end)
    {
        $start = (string) $start;
        $end = (string) $end;

        if ($start > $end) {
            return false;
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    private function buildActivityReportRows($summary, $start, $end, $prosesList)
    {
        $rows = [
            'makan_freelance' => ['label' => 'Makan Freelance (Dokter, KSO, Tim Teknis)', 'total' => 0],
            'makan_karyawan' => ['label' => 'Makan (Karyawan)', 'total' => 0],
            'fee_freelance' => ['label' => 'Fee Freelance', 'total' => 0],
            'parkir' => ['label' => 'Parkir', 'total' => 0],
            'bbm' => ['label' => 'BBM (Bahan Bakar Minyak)', 'total' => 0],
            'tol' => ['label' => 'Tol', 'total' => 0],
            'transport' => ['label' => 'Transport (Ojek Online, Taxi,Sewa Kendaraan)', 'total' => 0],
            'penginapan' => ['label' => 'Penginapan', 'total' => 0],
            'other' => ['label' => 'Biaya Lain-lain', 'total' => 0],
        ];
        $approvalNames = [
            'verified_by_name' => [],
            'validated_by_name' => [],
            'approved_by_name' => [],
        ];

        foreach ($prosesList as $proses) {
            $processData = $summary['expense_by_process'][$proses] ?? null;
            if (!$processData) {
                continue;
            }

            foreach (($processData['categories'] ?? []) as $categoryKey => $category) {
                foreach (($category['rows'] ?? []) as $expense) {
                    if ($this->isActivityExpenseInRange($expense, $start, $end)) {
                        $bucket = $this->resolveActivityExpenseBucket($categoryKey, $expense);
                        if (isset($rows[$bucket])) {
                            $rows[$bucket]['total'] += (float) ($expense['amount'] ?? 0);
                        }
                        $this->collectActivityApprovalNames($approvalNames, $expense);
                    }
                }
            }
        }

        $incomeTotal = 0;
        $topupTotal = 0;
        foreach ($prosesList as $proses) {
            $incomeTotal += (float) ($summary['budget_by_process'][$proses]['total'] ?? 0);

            foreach (($summary['topup_by_process'][$proses]['rows'] ?? []) as $topup) {
                $topupDate = substr((string) ($topup['tgl_topup'] ?? $topup['created_at'] ?? ''), 0, 10);
                if ($topupDate !== '' && $topupDate >= $start && $topupDate <= $end) {
                    $topupTotal += (float) ($topup['amount'] ?? 0);
                }
            }
        }

        $expenseTotal = 0;
        foreach ($rows as $row) {
            $expenseTotal += (float) $row['total'];
        }

        return [
            'rows' => array_values($rows),
            'income_total' => $incomeTotal,
            'topup_total' => $topupTotal,
            'expense_total' => $expenseTotal,
            'approval_names' => [
                'verified_by_name' => implode(', ', array_keys($approvalNames['verified_by_name'])),
                'validated_by_name' => implode(', ', array_keys($approvalNames['validated_by_name'])),
                'approved_by_name' => implode(', ', array_keys($approvalNames['approved_by_name'])),
            ],
        ];
    }

    private function collectActivityApprovalNames(&$approvalNames, $expense)
    {
        foreach (array_keys($approvalNames) as $field) {
            $name = trim((string) ($expense[$field] ?? ''));
            if ($name !== '') {
                $approvalNames[$field][$name] = true;
            }
        }
    }

    private function getActivitySignatureNames($kodeProject, $report)
    {
        $korlapNames = [];
        foreach ($this->project->getKorlapByProject($kodeProject) as $korlap) {
            $name = trim((string) ($korlap['nama'] ?? ''));
            if ($name !== '') {
                $korlapNames[$name] = true;
            }
        }

        $approvalNames = $report['approval_names'] ?? [];

        return [
            'korlap_name' => implode(', ', array_keys($korlapNames)),
            'verified_by_name' => $approvalNames['verified_by_name'] ?? '',
            'validated_by_name' => $approvalNames['validated_by_name'] ?? '',
            'approved_by_name' => $approvalNames['approved_by_name'] ?? '',
        ];
    }

    private function isActivityExpenseInRange($expense, $start, $end)
    {
        $expenseStart = substr((string) ($expense['date_start'] ?? ''), 0, 10);
        $expenseEnd = substr((string) ($expense['date_end'] ?? $expenseStart), 0, 10);

        if ($expenseStart === '') {
            return true;
        }

        if ($expenseEnd === '') {
            $expenseEnd = $expenseStart;
        }

        return $expenseStart <= $end && $expenseEnd >= $start;
    }

    private function resolveActivityExpenseBucket($categoryKey, $expense)
    {
        if ($categoryKey === 'makan' || $categoryKey === 'fee_dokter') {
            return 'makan_freelance';
        }

        if ($categoryKey === 'entertain') {
            return 'makan_karyawan';
        }

        if ($categoryKey === 'freelance') {
            return 'fee_freelance';
        }

        if ($categoryKey === 'penginapan') {
            return 'penginapan';
        }

        if ($categoryKey === 'other') {
            return 'other';
        }

        if ($categoryKey === 'transport') {
            $name = strtolower((string) ($expense['item_name'] ?? ''));
            $meta = strtolower((string) ($expense['item_meta'] ?? ''));
            $text = $name . ' ' . $meta;
            if (strpos($name, 'parkir') !== false) {
                return 'parkir';
            }

            if (strpos($name, 'toll') !== false || strpos($name, 'tol') !== false) {
                return 'tol';
            }

            if (strpos($text, 'bbm') !== false
                || strpos($text, 'mobil operasional') !== false
                || strpos($text, 'mobil pribadi') !== false) {
                return 'bbm';
            }

            return 'transport';
        }

        return 'other';
    }

    private function imageToBase64($path)
    {
        if (!is_file($path)) {
            return '';
        }

        $type = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        if (!isset($mimeTypes[$type])) {
            return '';
        }

        return 'data:' . $mimeTypes[$type] . ';base64,' . base64_encode(file_get_contents($path));
    }
}
