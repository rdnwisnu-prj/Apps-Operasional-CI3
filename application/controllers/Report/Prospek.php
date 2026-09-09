<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospek extends CI_Controller 
{
    public function __construct()
	{
	    parent::__construct();
        $this->load->model('Leads_model','leads');
        $this->load->model('Team_model','team');
        $this->load->library('form_validation');
	    is_logged_in();
	}
	
    public function index()
    {
        $current_year = date('Y');

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');

        $team_as_spv = $this->leads->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);
        $can_filter = in_array($role_id, [1, 2, 4, 5, 14]) || $is_spv;
        
        if ($role_id == 1 || $role_id == 2 || $role_id == 4 || $role_id == 5 || $role_id == 14) {
            $leads = $this->leads->getDataLeads();
            $status_counts = $this->leads->getStatusLeadCounts();
            $team_members = $this->team->getMarketingUsers();
        } else {
            if ($is_spv) {
                $leads = $this->leads->getDataLeadsBySpv($id_user, $team_as_spv);
                $status_counts = $this->leads->getStatusLeadCountsBySpv($id_user, $team_as_spv);
                $team_members = $this->team->getTeamMembersBySpv($id_user, $team_as_spv);
            } else {
                $leads = $this->leads->getDataLeadsByUser($id_user);
                $status_counts = $this->leads->getStatusLeadCountsByUser($id_user);
                $team_members = [];
            }
        }
        
        $data = [
            'title'             => 'Operational Cakra Application | Report Prospek',
            'header'            => 'Reports',
            'subheader'         => 'Report Prospek',
            'current_year'      => $current_year,
            'prospek_monthly'   => $this->leads->getLeadsCountByMonth($current_year),
            'prospek_status'    => $this->leads->getLeadsCountByStatus($current_year),
            'top_leads'         => $this->leads->getTopDeals(10),
            'leads'             => $leads,
            'teams'             => $this->team->getAllData(),
            'team_members'      => $team_members,
            'status_counts'     => $status_counts,
            'current_user_id'   => $id_user,
            'current_user_role' => $role_id,
            'can_filter'        => $can_filter,
            'is_spv'            => $is_spv,
            'bulan_names'       => $this->getBulanNames(),
            'tahun'             => $current_year,
            'bulan'             => date('n'),
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('report/prospek', $data);
        $this->load->view('templates/footer');
    }

    public function getProspekTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->leads->getLeadsCountByMonth($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    public function getStatusProspek()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }
        
        $data = $this->leads->getLeadsCountByStatus($year);
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'labels' => $data['labels'],
            'data' => $data['data']
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

    public function getFilteredLeads()
    {
        header('Content-Type: application/json');
        
        $current_user_id = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        
        $filters = [];
        
        $is_admin = in_array($role_id, [1, 2, 4, 5, 14]);
        $team_as_spv = $this->leads->getTeamBySpv($current_user_id);
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
        
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        if (!empty($bulan)) {
            $filters['bulan'] = $bulan;
        }
        if (!empty($tahun)) {
            $filters['tahun'] = $tahun;
        }
        
        $leads = $this->leads->getFilteredLeads($filters);
        
        $data = [];
        $bulan_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach ($leads as $lead) {
            $periode_text = '-';
            if (!empty($lead['periode_bulan']) && !empty($lead['periode_tahun'])) {
                $periode_text = $bulan_names[$lead['periode_bulan']] . ' ' . $lead['periode_tahun'];
            }
            $data[] = [
                'nama_client' => $lead['nama_client'] ?? '-',
                'sektor' => $lead['sektor'] ?? '-',
                'group' => $lead['group'] ?? '-',
                'project' => $lead['project'] ?? '-',
                'service' => $lead['service'] ?? '-',
                'nama_pic' => $lead['nama_pic'] ?? '-',
                'periode' => $periode_text,
                'estimasi_lead' => 'Rp ' . number_format($lead['estimasi_lead'] ?? 0, 0, ',', '.'),
                'marketing' => $lead['marketing'] ?? '-',
                'status_lead' => $lead['status_lead'] ?? '-'
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
        $status = $this->input->get('status');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        
        $filters = [];
        $is_admin = in_array($role_id, [1, 2, 4, 5, 14]);
        $team_as_spv = $this->leads->getTeamBySpv($current_user_id);
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
        
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        if (!empty($bulan)) {
            $filters['bulan'] = $bulan;
        }
        if (!empty($tahun)) {
            $filters['tahun'] = $tahun;
        }
        
        $leads = $this->leads->getFilteredLeads($filters);
        $bulan_names = $this->getBulanNames();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'LAPORAN DATA PROSPEK');
        
        $filter_info = 'Filter: ';
        $filter_parts = [];
        if (!empty($bulan) && !empty($tahun)) {
            $filter_parts[] = ($bulan_names[$bulan] ?? $bulan) . ' ' . $tahun;
        } elseif (!empty($tahun)) {
            $filter_parts[] = 'Tahun ' . $tahun;
        }
        if (!empty($status)) {
            $filter_parts[] = 'Status: ' . $status;
        }
        $filter_info .= !empty($filter_parts) ? implode(', ', $filter_parts) : 'Semua Data';
        
        $sheet->setCellValue('A2', $filter_info);
        $sheet->setCellValue('A3', 'Tanggal Export: ' . date('d F Y H:i'));
        $headers = ['No.', 'Nama Perusahaan', 'Sektor', 'Group', 'Project', 'Service', 'Nama PIC', 'Periode', 'Estimasi', 'Marketing', 'Status'];
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '5', $header);
            $sheet->getStyle($col . '5')->getFont()->setBold(true);
            $sheet->getStyle($col . '5')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFE0E0E0');
            $col++;
        }
        
        $row = 6;
        $no = 1;
        $bulan_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        foreach ($leads as $lead) {
            $periode_text = '-';
            if (!empty($lead['periode_bulan']) && !empty($lead['periode_tahun'])) {
                $periode_text = $bulan_names[$lead['periode_bulan']] . ' ' . $lead['periode_tahun'];
            }
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $lead['nama_client'] ?? '-');
            $sheet->setCellValue('C' . $row, $lead['sektor'] ?? '-');
            $sheet->setCellValue('D' . $row, $lead['group'] ?? '-');
            $sheet->setCellValue('E' . $row, $lead['project'] ?? '-');
            $sheet->setCellValue('F' . $row, $lead['service'] ?? '-');
            $sheet->setCellValue('G' . $row, $lead['nama_pic'] ?? '-');
            $sheet->setCellValue('H' . $row, $periode_text);
            $sheet->setCellValue('I' . $row, $lead['estimasi_lead'] ?? 0);
            $sheet->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('J' . $row, $lead['marketing'] ?? '-');
            $sheet->setCellValue('K' . $row, $lead['status_lead'] ?? '-');
            
            $row++;
            $no++;
        }
        
        foreach (range('A', 'K') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $filename = 'Laporan_Prospek_' . date('Y-m-d_His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}