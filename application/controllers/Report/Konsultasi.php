<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsultasi extends CI_Controller 
{
    public function __construct()
	{
	    parent::__construct();
        $this->load->model('Rujukan_model', 'rujukan');
        $this->load->model('Team_model','team');
        $this->load->model('Client_model','client');
        $this->load->library('form_validation');
	    is_logged_in();
	}
	
    public function index()
    {
        $current_year = date('Y');

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');

        $team_as_spv = $this->rujukan->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);
        $can_filter = in_array($role_id, [1, 2, 3, 4, 13]) || $is_spv;
        
        if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 13) {
            $rujukan = $this->rujukan->getData();
            $team_members = $this->team->getAdminRujukanUsers();
        } else {
            if ($is_spv) {
                $team_as_spv = $this->rujukan->getTeamBySpv($id_user);
                $rujukan = $this->rujukan->getDataRujukanBySpv($id_user, $team_as_spv);
                $team_members = $this->team->getTeamMembersBySpv($id_user, $team_as_spv);
            } else {
                $rujukan = $this->rujukan->getDataRujukanByUser($id_user);
                $team_members = [];
            }
        }
        
        $data = [
            'title'             => 'Operasional Web App | Report Konsultasi',
            'header'            => 'Reports',
            'subheader'         => 'Report Konsultasi',
            'current_year'      => $current_year,
            'rujukan_monthly'   => $this->rujukan->getRujukanCountByMonth($current_year),
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
        $this->load->view('report/konsultasi', $data);
        $this->load->view('templates/footer');
    }

    public function getRujukanTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->rujukan->getRujukanCountByMonth($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
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

    public function getFilteredRujukan()
    {
        header('Content-Type: application/json');
        
        $current_user_id = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $user_id = $this->input->post('user_id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        
        $filters = [];
        $is_admin = in_array($role_id, [1, 2, 3, 4, 13]);
        $team_as_spv = $this->rujukan->getTeamBySpv($current_user_id);
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
        
        $rujukan = $this->rujukan->getFilteredRujukan($filters);
        
        $data = [];
        foreach ($rujukan as $row) {
            $pt_lama = $row['nama_client'] ?? '-';
            $pt_baru = !empty($row['other_client']) ? $row['other_client'] : '-';
            
            $data[] = [
                'nama' => $row['nama'] ?? '-',
                'pt_lama' => $pt_lama,
                'pt_baru' => $pt_baru,
                'dokter' => $row['dokter'] ?? '-',
                'tgl_konsul' => !empty($row['tgl_konsul']) ? date('d/m/Y', strtotime($row['tgl_konsul'])) : '-',
                'harga' => 'Rp ' . number_format((float)preg_replace('/[^0-9]/', '', $row['harga'] ?? '0'), 0, ',', '.'),
                'lokasi' => $row['lokasi'] ?? '-',
                'pembayaran' => $row['pembayaran'] ?? '-',
                'marketing' => $row['marketing'] ?? '-'
            ];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
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
        $team_as_spv = $this->rujukan->getTeamBySpv($current_user_id);
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
        
        $rujukan = $this->rujukan->getFilteredRujukan($filters);
        $bulan_names = $this->getBulanNames();
        
        // Load PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Build title based on filter
        $title_month = !empty($bulan) ? strtoupper($bulan_names[$bulan] ?? '') : '';
        $title_year = !empty($tahun) ? $tahun : date('Y');
        $title = 'Laporan Sales Telemedicine';
        if (!empty($title_month)) {
            $title .= ' ' . $title_month . ' ' . $title_year;
        } else {
            $title .= ' ' . $title_year;
        }
        
        // Set title - merge cells A1 to L1
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Header row - yellow background
        $headers = ['No', 'Nama', 'PT Lama', 'PT Baru', 'Dokter', 'Tgl', 'Harga', 'HPP', 'LOKASI KONSUL', 'KET', 'KET Sudah Ditagihkan/Belum'];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '3', $header);
            $sheet->getStyle($col . '3')->getFont()->setBold(true);
            $sheet->getStyle($col . '3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFFFF00'); // Yellow background
            $sheet->getStyle($col . '3')->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $col++;
        }
        
        // Data rows
        $row = 4;
        $no = 1;
        foreach ($rujukan as $r) {
            $pt_lama = $r['nama_client'] ?? '-';
            $pt_baru = !empty($r['other_client']) ? $r['other_client'] : '-';
            
            // Alternating row colors (pink and white)
            $bgColor = ($no % 2 == 0) ? 'FFFFFFFF' : 'FFFFCCCC'; // White for even, Pink for odd
            
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $r['nama'] ?? '-');
            $sheet->setCellValue('C' . $row, $pt_lama);
            $sheet->setCellValue('D' . $row, $pt_baru);
            $sheet->setCellValue('E' . $row, $r['dokter'] ?? '-');
            $sheet->setCellValue('F' . $row, !empty($r['tgl_konsul']) ? date('d/m/Y', strtotime($r['tgl_konsul'])) : '-');
            
            // Harga with Rp format (remove non-numeric chars first)
            $harga = preg_replace('/[^0-9]/', '', $r['harga'] ?? '0');
            $sheet->setCellValue('G' . $row, 'Rp ' . number_format((float)$harga, 0, ',', '.'));
            
            // HPP with Rp format (remove non-numeric chars first)
            $hpp = preg_replace('/[^0-9]/', '', $r['hpp'] ?? '0');
            $sheet->setCellValue('H' . $row, 'Rp ' . number_format((float)$hpp, 0, ',', '.'));
            
            $sheet->setCellValue('I' . $row, $r['lokasi'] ?? '-');
            $sheet->setCellValue('J' . $row, $r['keterangan'] ?? '-');
            $sheet->setCellValue('K' . $row, $r['pembayaran'] ?? '-');
            
            // Apply alternating row color
            $sheet->getStyle('A' . $row . ':K' . $row)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB($bgColor);
            
            // Add borders
            $sheet->getStyle('A' . $row . ':K' . $row)->getBorders()->getAllBorders()
                ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            
            $row++;
            $no++;
        }
        
        // === 1. Total Harga & HPP (2 baris kosong setelah data terakhir) ===
        $totalHarga = 0;
        $totalHpp = 0;
        $dokterCounts = [];

        foreach ($rujukan as $r) {
            $hargaNum = (float) preg_replace('/[^0-9]/', '', $r['harga'] ?? '0');
            $hppNum   = (float) preg_replace('/[^0-9]/', '', $r['hpp'] ?? '0');
            $totalHarga += $hargaNum;
            $totalHpp   += $hppNum;

            $dokter = trim($r['dokter'] ?? '');
            if (!empty($dokter) && $dokter !== '-') {
                if (!isset($dokterCounts[$dokter])) {
                    $dokterCounts[$dokter] = 0;
                }
                $dokterCounts[$dokter]++;
            }
        }

        $sumRow = $row + 2; // 2 baris spasi

        $sheet->setCellValue('F' . $sumRow, 'Total');
        $sheet->getStyle('F' . $sumRow)->getFont()->setBold(true);

        $sheet->setCellValue('G' . $sumRow, 'Rp ' . number_format($totalHarga, 0, ',', '.'));
        $sheet->getStyle('G' . $sumRow)->getFont()->setBold(true);

        $sheet->setCellValue('H' . $sumRow, 'Rp ' . number_format($totalHpp, 0, ',', '.'));
        $sheet->getStyle('H' . $sumRow)->getFont()->setBold(true);

        // === 2. Rekap Dokter Spesialis (di bawah kolom PT Nama) ===
        $dokterStartRow = $sumRow + 2;

        $sheet->setCellValue('B' . $dokterStartRow, 'Dokter Spesialis');
        $sheet->getStyle('B' . $dokterStartRow)->getFont()->setBold(true);
        $sheet->setCellValue('C' . $dokterStartRow, 'Jumlah');
        $sheet->getStyle('C' . $dokterStartRow)->getFont()->setBold(true);

        $dokterRow = $dokterStartRow + 1;
        ksort($dokterCounts);
        foreach ($dokterCounts as $dokterName => $count) {
            $sheet->setCellValue('B' . $dokterRow, $dokterName);
            $sheet->setCellValue('C' . $dokterRow, $count);
            $dokterRow++;
        }

        // Auto-size columns
        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Generate filename
        $filename_month = !empty($bulan) ? '_' . $bulan_names[$bulan] : '';
        $filename_year = !empty($tahun) ? '_' . $tahun : '_' . date('Y');
        $filename = 'Laporan_Sales_Telemedicine' . $filename_month . $filename_year . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}