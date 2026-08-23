<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KeluhanClient extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keluhan_model', 'keluhan');
        $this->load->model('Team_model','team');
        $this->load->model('Client_model','client');
        is_logged_in();
    }
    
    public function index()
    {
        $current_year = date('Y');

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');

        $team_as_spv = $this->keluhan->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);
        $can_filter = in_array($role_id, [1, 2, 3, 4, 13]) || $is_spv;

        if (in_array($role_id, [1, 2, 3, 4, 13])) {
            $team_members = $this->team->getCustomerServiceUsers();
        } elseif ($is_spv) {
            $team_members = $this->team->getTeamMembersBySpvWithRoles($id_user, $team_as_spv, [11, 12]);
        } else {
            $team_members = [];
        }

        $data = [
            'title'             => 'Operasional Web App | Report Keluhan Client',
            'header'            => 'Reports',
            'subheader'         => 'Report Keluhan Client',
            'current_year'      => $current_year,
            'keluhan_monthly'   => $this->keluhan->getKeluhanCountByMonth($current_year),
            'team_members'      => $team_members,
            'current_user_id'   => $id_user,
            'current_user_role' => $role_id,
            'can_filter'        => $can_filter,
            'is_spv'            => $is_spv,
            'bulan_names'       => $this->getBulanNames(),
            'tahun'             => $current_year,
            'bulan'             => date('n')
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('report/keluhan_client', $data);
        $this->load->view('templates/footer');
    }

    public function getKeluhanTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->keluhan->getKeluhanCountByMonth($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    public function getFilteredKeluhan()
    {
        header('Content-Type: application/json');
        
        $current_user_id = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $user_id = $this->input->post('user_id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        
        $filters = [];
        $is_admin = in_array($role_id, [1, 2, 3, 4, 13]);
        $team_as_spv = $this->keluhan->getTeamBySpv($current_user_id);
        $is_spv = !empty($team_as_spv);
        
        if ($is_admin) {
            if (!empty($user_id)) {
                $filters['user_id'] = $user_id;
            }
        } elseif ($is_spv) {
            $team_ids = array_column($team_as_spv, 'id_team');
            $anggota = $this->team->getTeamMemberIdsByTeams($team_ids);
            $user_ids = array_column($anggota, 'staff_id');
            $user_ids[] = $current_user_id;
            $user_ids = array_unique($user_ids);
            
            if (!empty($user_id) && in_array($user_id, $user_ids)) {
                $filters['user_id'] = $user_id;
            } else {
                $filters['user_ids'] = $user_ids;
            }
        } else {
            $filters['user_id'] = $current_user_id;
        }
        
        if (!empty($bulan)) {
            $filters['bulan'] = $bulan;
        }
        if (!empty($tahun)) {
            $filters['tahun'] = $tahun;
        }
        
        $keluhan = $this->keluhan->getFilteredKeluhan($filters);
        
        $data = [];
        foreach ($keluhan as $row) {
            $data[] = [
                'tgl_masuk'        => tanggal_indonesia_medium($row['tgl_masuk'] ?? ''),
                'perusahaan'       => $row['nama_client'] ?? '-',
                'pic'              => $row['pic'] ?? '-',
                'media'            => $row['media'] ?? '-',
                'divisi'           => $row['divisi'] ?? '-',
                'kategori'         => $row['kategori'] ?? '-',
                'customer_service' => $row['customer_service'] ?? '-'
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
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

    public function exportExcel()
    {
        $current_user_id = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $user_id = $this->input->get('user_id');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        $filters = [];

        $is_admin = in_array($role_id, [1, 2, 3, 4, 13]);
        $team_as_spv = $this->keluhan->getTeamBySpv($current_user_id);
        $is_spv = !empty($team_as_spv);
        
        if ($is_admin) {
            if (!empty($user_id)) {
                $filters['user_id'] = $user_id;
            }
        } elseif ($is_spv) {
            $team_ids = array_column($team_as_spv, 'id_team');
            $anggota = $this->team->getTeamMemberIdsByTeams($team_ids);
            $user_ids = array_column($anggota, 'staff_id');
            $user_ids[] = $current_user_id;
            $user_ids = array_unique($user_ids);
            
            if (!empty($user_id) && in_array($user_id, $user_ids)) {
                $filters['user_id'] = $user_id;
            } else {
                $filters['user_ids'] = $user_ids;
            }
        } else {
            $filters['user_id'] = $current_user_id;
        }
        
        if (!empty($bulan)) {
            $filters['bulan'] = $bulan;
        }
        if (!empty($tahun)) {
            $filters['tahun'] = $tahun;
        }

        $filters['order'] = 'ASC';
        $keluhan = $this->keluhan->getFilteredKeluhan($filters);
        $bulan_names = $this->getBulanNames();

        // Get cabang name from current user
        $user_data = $this->team->getUserById($current_user_id);
        $cabang_name = $user_data['nama_cabang'] ?? '';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerPurple = '7030A0';
        $lightPurple  = 'E2CCF0';

        if (!empty($bulan) && !empty($tahun)) {
            $this->_exportBulanan($sheet, $keluhan, $bulan, $tahun, $bulan_names, $cabang_name, $headerPurple, $lightPurple);
            $filename = 'Rekapan_Keluhan_' . $bulan_names[$bulan] . '_' . $tahun . '.xlsx';
        } else {
            $display_year = !empty($tahun) ? $tahun : date('Y');
            $this->_exportTahunan($sheet, $keluhan, $display_year, $bulan_names, $cabang_name, $headerPurple, $lightPurple);
            $filename = 'Rekapan_Keluhan_' . $display_year . '.xlsx';
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Format 1: Filter bulan + tahun — tanpa kolom Bulan
     */
    private function _exportBulanan($sheet, $keluhan, $bulan, $tahun, $bulan_names, $cabang_name, $headerPurple, $lightPurple)
    {
        $lastCol = 'L';

        // Title rows
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->setCellValue('A1', 'REKAPAN KOMPLAIN DAN UMPAN BALIK PASIEN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:' . $lastCol . '2');
        $subtitle = 'KLINIK UTAMA CAKRA MEDIKA';
        if (!empty($cabang_name)) {
            $subtitle .= ' ' . strtoupper(str_replace('Cakra - ', '', $cabang_name));
        }
        $sheet->setCellValue('A2', $subtitle);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A3:' . $lastCol . '3');
        $sheet->setCellValue('A3', 'Periode : ' . $bulan_names[$bulan] . ' ' . $tahun);
        $sheet->getStyle('A3')->getFont()->setSize(11);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Headers at row 4
        $headers = ['No.', 'Tgl Masuk', 'Perusahaan', 'Media', 'Divisi yang dituju', 'Isi Komplain', 'Analisa', 'RTL', 'TL', 'Tgl Respon', 'Evaluasi setelah TL', 'Keterangan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }
        $this->_applyHeaderStyle($sheet, 'A4:' . $lastCol . '4', $headerPurple);

        // Data rows
        $row = 5;
        $no = 1;
        foreach ($keluhan as $r) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, tanggal_indonesia_medium($r['tgl_masuk'] ?? ''));
            $sheet->setCellValue('C' . $row, $r['nama_client'] ?? '-');
            $sheet->setCellValue('D' . $row, $r['media'] ?? '-');
            $sheet->setCellValue('E' . $row, $r['divisi'] ?? '-');
            $sheet->setCellValue('F' . $row, $this->_stripHtml($r['complain'] ?? '-'));
            $sheet->setCellValue('G' . $row, $this->_stripHtml($r['analisa'] ?? '-'));
            $sheet->setCellValue('H' . $row, $this->_stripHtml($r['rencana_tl'] ?? '-'));
            $sheet->setCellValue('I' . $row, $this->_stripHtml($r['tidak_lanjut'] ?? '-'));
            $sheet->setCellValue('J' . $row, tanggal_indonesia_medium($r['tgl_respon'] ?? ''));
            $sheet->setCellValue('K' . $row, $this->_stripHtml($r['eval_after_tl'] ?? '-'));
            $sheet->setCellValue('L' . $row, $this->_stripHtml($r['keterangan'] ?? '-'));

            // Borders
            $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Wrap text for long content columns
            $sheet->getStyle('F' . $row . ':I' . $row)->getAlignment()->setWrapText(true);
            $sheet->getStyle('K' . $row . ':L' . $row)->getAlignment()->setWrapText(true);

            $row++;
            $no++;
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // Set explicit widths for long-text columns
        $sheet->getColumnDimension('F')->setAutoSize(false)->setWidth(30);
        $sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(25);
        $sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(20);
        $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(20);
        $sheet->getColumnDimension('K')->setAutoSize(false)->setWidth(22);
        $sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(25);
    }

    /**
     * Format 2: Filter tahun saja — dengan kolom Bulan di kiri, grouped per bulan
     */
    private function _exportTahunan($sheet, $keluhan, $tahun, $bulan_names, $cabang_name, $headerPurple, $lightPurple)
    {
        $lastCol = 'M';

        // Title rows
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->setCellValue('A1', 'REKAPAN KOMPLAIN DAN UMPAN BALIK PASIEN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:' . $lastCol . '2');
        $subtitle = 'KLINIK UTAMA CAKRA MEDIKA';
        if (!empty($cabang_name)) {
            $subtitle .= ' ' . strtoupper(str_replace('Cakra - ', '', $cabang_name));
        }
        $sheet->setCellValue('A2', $subtitle);
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A3:' . $lastCol . '3');
        $sheet->setCellValue('A3', 'PERIODE ' . $tahun);
        $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Headers at row 4
        $headers = ['Bulan', 'No.', 'Tgl Masuk', 'Nama Perusahaan', 'Media', 'Divisi yang dituju', 'Isi Komplain', 'Analisa', 'RTL', 'TL', 'Tgl Respon', 'Evaluasi setelah TL', 'Keterangan'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }
        $this->_applyHeaderStyle($sheet, 'A4:' . $lastCol . '4', $headerPurple);

        // Group data by month
        $grouped = [];
        foreach ($keluhan as $r) {
            $month = !empty($r['tgl_masuk']) ? (int) date('n', strtotime($r['tgl_masuk'])) : 0;
            $grouped[$month][] = $r;
        }
        ksort($grouped);

        $row = 5;
        foreach ($grouped as $month => $items) {
            $monthName = $bulan_names[$month] ?? '-';
            $startRow = $row;
            $no = 1;

            foreach ($items as $r) {
                $sheet->setCellValue('B' . $row, $no);
                $sheet->setCellValue('C' . $row, tanggal_indonesia_medium($r['tgl_masuk'] ?? ''));
                $sheet->setCellValue('D' . $row, $r['nama_client'] ?? '-');
                $sheet->setCellValue('E' . $row, $r['media'] ?? '-');
                $sheet->setCellValue('F' . $row, $r['divisi'] ?? '-');
                $sheet->setCellValue('G' . $row, $this->_stripHtml($r['complain'] ?? '-'));
                $sheet->setCellValue('H' . $row, $this->_stripHtml($r['analisa'] ?? '-'));
                $sheet->setCellValue('I' . $row, $this->_stripHtml($r['rencana_tl'] ?? '-'));
                $sheet->setCellValue('J' . $row, $this->_stripHtml($r['tidak_lanjut'] ?? '-'));
                $sheet->setCellValue('K' . $row, tanggal_indonesia_medium($r['tgl_respon'] ?? ''));
                $sheet->setCellValue('L' . $row, $this->_stripHtml($r['eval_after_tl'] ?? '-'));
                $sheet->setCellValue('M' . $row, $this->_stripHtml($r['keterangan'] ?? '-'));

                // Borders
                $sheet->getStyle('A' . $row . ':' . $lastCol . $row)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Alternating row color
                $sheet->getStyle('B' . $row . ':' . $lastCol . $row)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF' . $lightPurple);

                // Wrap text for long content columns
                $sheet->getStyle('G' . $row . ':J' . $row)->getAlignment()->setWrapText(true);
                $sheet->getStyle('L' . $row . ':M' . $row)->getAlignment()->setWrapText(true);

                $row++;
                $no++;
            }

            $endRow = $row - 1;
            // Merge bulan column
            if ($startRow == $endRow) {
                $sheet->setCellValue('A' . $startRow, $monthName);
            } else {
                $sheet->mergeCells('A' . $startRow . ':A' . $endRow);
                $sheet->setCellValue('A' . $startRow, $monthName);
            }
            $sheet->getStyle('A' . $startRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $startRow)->getAlignment()
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            // Light purple background for bulan column
            $sheet->getStyle('A' . $startRow . ':A' . $endRow)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF' . $lightPurple);

            // Add spacing row between months
            $row++;
        }

        // Auto-size columns
        foreach (range('A', $lastCol) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // Set explicit widths for long-text columns
        $sheet->getColumnDimension('G')->setAutoSize(false)->setWidth(30);
        $sheet->getColumnDimension('H')->setAutoSize(false)->setWidth(25);
        $sheet->getColumnDimension('I')->setAutoSize(false)->setWidth(20);
        $sheet->getColumnDimension('J')->setAutoSize(false)->setWidth(20);
        $sheet->getColumnDimension('L')->setAutoSize(false)->setWidth(22);
        $sheet->getColumnDimension('M')->setAutoSize(false)->setWidth(25);
    }

    private function _applyHeaderStyle($sheet, $range, $headerColor)
    {
        $sheet->getStyle($range)->getFont()->setBold(true)->getColor()
            ->setARGB('FFFFFFFF');
        $sheet->getStyle($range)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF' . $headerColor);
        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    private function _stripHtml($value)
    {
        if (empty($value) || $value === '-') {
            return '-';
        }
        $text = preg_replace('#<br\s*/?>#i', "\n", $value);
$text = preg_replace('#</p>\s*<p[^>]*>#i', "\n", $text);
    $text = strip_tags($text);
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = trim($text);
    return $text !== '' ? $text : '-';
    }
    }