<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller 
{
    public function __construct()
	{
	    parent::__construct();
        $this->load->model('Client_model','client');
        $this->load->model('Team_model','team');
        $this->load->model('Group_model','group');
        $this->load->model('Project_model','project');
        $this->load->library('form_validation');
	    is_logged_in();
	}
	
    public function index()
    {
        $current_year = date('Y');

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');

        $team_as_spv = $this->client->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);
        
        // Determine filter access and team members list
        if (in_array($role_id, [1, 2, 3, 4, 13])) {
            $can_filter = true;
            $team_members = $this->team->getMarketingUsers();
            $client_monthly = $this->client->getClientCountByMonth($current_year);
        } elseif ($role_id == 5 || $is_spv) {
            $can_filter = true;
            $team_members = $this->team->getTeamMembersBySpv($id_user, $team_as_spv);
            $user_ids = $this->_getTeamUserIds($id_user, $team_as_spv);
            $client_monthly = $this->client->getClientCountByMonthFiltered($current_year, $user_ids);
        } else {
            $can_filter = true;
            $team_members = [];
            $client_monthly = $this->client->getClientCountByMonthFiltered($current_year, [$id_user]);
        }

        $data = [
            'title'             => 'Operasional Web App | Report Client',
            'header'            => 'Reports',
            'subheader'         => 'Report Client',
            'current_year'      => $current_year,
            'client_monthly'    => $client_monthly,
            'current_user_id'   => $id_user,
            'current_user_role' => $role_id,
            'can_filter'        => $can_filter,
            'is_spv'            => $is_spv,
            'team_members'      => $team_members,
            'groups'            => $this->group->getData(),
            'sektors'           => $this->client->getDistinctSektor(),
            'bulan_names'       => $this->getBulanNames(),
            'tahun'             => $current_year,
            'bulan'             => date('n')
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('report/client', $data);
        $this->load->view('templates/footer');
    }

    private function _getTeamUserIds($id_user, $team_as_spv)
    {
        $team_ids = array_column($team_as_spv, 'id_team');
        $anggota = $this->team->getTeamMemberIdsByTeams($team_ids);
        $user_ids = array_column($anggota, 'staff_id');
        $user_ids[] = $id_user;
        return array_unique($user_ids);
    }

    public function getClientTahunan()
    {
        $year = $this->input->post('year', TRUE);
        
        if (!$year) {
            $year = date('Y');
        }

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        $team_as_spv = $this->client->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);

        if (in_array($role_id, [1, 2, 3, 4, 13])) {
            $data = $this->client->getClientCountByMonth($year);
        } elseif ($role_id == 5 || $is_spv) {
            $user_ids = $this->_getTeamUserIds($id_user, $team_as_spv);
            $data = $this->client->getClientCountByMonthFiltered($year, $user_ids);
        } else {
            $data = $this->client->getClientCountByMonthFiltered($year, [$id_user]);
        }
        
        echo json_encode([
            'status' => 'success',
            'year' => $year,
            'data' => $data,
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        ]);
    }

    public function getTopClients()
    {
        header('Content-Type: application/json');

        $id_user = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');
        $team_as_spv = $this->client->getTeamBySpv($id_user);
        $is_spv = !empty($team_as_spv);

        if (in_array($role_id, [1, 2, 3, 4, 13])) {
            $top_clients = $this->client->getTopClients(10);
        } elseif ($role_id == 5 || $is_spv) {
            $user_ids = $this->_getTeamUserIds($id_user, $team_as_spv);
            $top_clients = $this->client->getTopClients(10, $user_ids);
        } else {
            $top_clients = $this->client->getTopClients(10, [$id_user]);
        }

        $data = [];
        foreach ($top_clients as $c) {
            $data[] = [
                'nama_client'    => htmlspecialchars($c['nama_client'] ?? '-'),
                'sektor'         => htmlspecialchars($c['sektor'] ?? '-'),
                'group'          => htmlspecialchars($c['nama_group'] ?? '-'),
                'total_estimasi' => (float) $c['total_estimasi'],
                'marketing'      => htmlspecialchars($c['marketing'] ?? '-'),
            ];
        }

        echo json_encode(['success' => true, 'data' => $data]);
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

        private function buildFilters($params, $method = 'post')
    {
        $current_user_id = $this->session->userdata('id_user');
        $role_id = $this->session->userdata('role_id');

        $user_id = $params['user_id'] ?? '';
        $bulan   = $params['bulan'] ?? '';
        $tahun   = $params['tahun'] ?? '';

        $filters = [];

        $is_admin = in_array($role_id, [1, 2, 3, 4, 5, 13]);
        $team_as_spv = $this->client->getTeamBySpv($current_user_id);
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

        return $filters;
    }

    public function getFilteredClients()
    {
        header('Content-Type: application/json');

        $params = [
            'user_id' => $this->input->post('user_id'),
            'bulan'   => $this->input->post('bulan'),
            'tahun'   => $this->input->post('tahun'),
        ];

        $filters = $this->buildFilters($params);
        $clients = $this->client->getFilteredClients($filters);

        $bulan_names = $this->getBulanNames();
        $data = [];
        foreach ($clients as $c) {
            $data[] = [
                'nama_client'  => htmlspecialchars($c['nama_client'] ?? '-'),
                'sektor'       => htmlspecialchars($c['sektor'] ?? '-'),
                'nama_pic'     => htmlspecialchars($c['nama_pic'] ?? '-'),
                'tlp_pic'      => htmlspecialchars($c['tlp_pic'] ?? '-'),
                'group'   => htmlspecialchars($c['group'] ?? '-'),
                'status'       => htmlspecialchars($c['status'] ?? '-'),
                'periode'      => (!empty($c['periode_bulan']) && !empty($c['periode_tahun'])) ? $bulan_names[(int)$c['periode_bulan']] . ' ' . $c['periode_tahun'] : '-',
                'marketing'    => htmlspecialchars($c['marketing'] ?? '-'),
            ];
        }

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    }

    public function exportExcel()
    {
        $params = [
            'user_id' => $this->input->get('user_id'),
            'bulan'   => $this->input->get('bulan'),
            'tahun'   => $this->input->get('tahun'),
        ];

        $filters = $this->buildFilters($params);
        $clients = $this->client->getFilteredClients($filters);
        $bulan_names = $this->getBulanNames();
        $marketing_name = 'Semua';
        if (!empty($params['user_id'])) {
            $user_data = $this->team->getUserById($params['user_id']);
            if ($user_data) {
                $marketing_name = $user_data['nama'] ?? 'Semua';
            }
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $lastCol = 'R';
        $sheet->setCellValue('A1', 'LAPORAN DATA CLIENT');
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $filter_info = 'Filter: ';
        $filter_parts = [];
        if (!empty($params['bulan']) && !empty($params['tahun'])) {
            $filter_parts[] = ($bulan_names[(int)$params['bulan']] ?? $params['bulan']) . ' ' . $params['tahun'];
        } elseif (!empty($params['tahun'])) {
            $filter_parts[] = 'Tahun ' . $params['tahun'];
        }
        $filter_info .= !empty($filter_parts) ? implode(', ', $filter_parts) : 'Semua Data';

        $sheet->setCellValue('A2', $filter_info);
        $sheet->mergeCells('A2:' . $lastCol . '2');
        $sheet->getStyle('A2')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $headers = [
            'No.', 'Nama Perusahaan', 'Sektor Perusahaan', 'Nama PIC', 'No Tlp PIC',
            'Email', 'Alamat Perusahaan', 'HUT PIC', 'HUT Client',
            'Client Group', 'Status Client', 'Periode',
            'Jenis Projek', 'Tgl Pelaksanaan', 'Tgl Selesai', 'Jumlah Karyawan', 'Estimasi',
            'Marketing'
        ];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $col++;
        }
        $headerRange = 'A4:' . $lastCol . '4';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE0E0E0');
        $sheet->getStyle($headerRange)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row = 5;
        $no = 1;
        foreach ($clients as $c) {
            $projects = $this->project->getProjectByClientId($c['id_client']);

            $periode = (!empty($c['periode_bulan']) && !empty($c['periode_tahun']))
                ? $bulan_names[(int)$c['periode_bulan']] . ' ' . $c['periode_tahun']
                : '-';
            $writeClientRow = function($targetRow) use ($sheet, $c, $no, $bulan_names, $periode) {
                $sheet->setCellValue('A' . $targetRow, $no);
                $sheet->setCellValue('B' . $targetRow, $c['nama_client'] ?? '-');
                $sheet->setCellValue('C' . $targetRow, $c['sektor'] ?? '-');
                $sheet->setCellValue('D' . $targetRow, $c['nama_pic'] ?? '-');
                $sheet->setCellValueExplicit('E' . $targetRow, $c['tlp_pic'] ?? '-', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('F' . $targetRow, $c['email_pic'] ?? '-');
                $sheet->setCellValue('G' . $targetRow, $c['alamat_client'] ?? '-');
                $sheet->setCellValue('H' . $targetRow, !empty($c['hut_pic']) ? date('d M Y', strtotime($c['hut_pic'])) : '-');
                $sheet->setCellValue('I' . $targetRow, !empty($c['hut_client']) ? date('d M Y', strtotime($c['hut_client'])) : '-');
                $sheet->setCellValue('J' . $targetRow, $c['group'] ?? '-');
                $sheet->setCellValue('K' . $targetRow, $c['status'] ?? '-');
                $sheet->setCellValue('L' . $targetRow, $periode);
            };

            $writeProjectRow = function($targetRow, $p) use ($sheet) {
                $sheet->setCellValue('M' . $targetRow, $p['jenis_project'] ?? '-');
                $sheet->setCellValue('N' . $targetRow, !empty($p['tgl_pelaksanaan']) ? date('d M Y', strtotime($p['tgl_pelaksanaan'])) : '-');
                $sheet->setCellValue('O' . $targetRow, !empty($p['tgl_selesai']) ? date('d M Y', strtotime($p['tgl_selesai'])) : '-');
                $sheet->setCellValue('P' . $targetRow, $p['jumlah_karyawan'] ?? 0);
                $sheet->setCellValue('Q' . $targetRow, $p['estimasi'] ?? 0);
                $sheet->getStyle('Q' . $targetRow)->getNumberFormat()->setFormatCode('#,##0');
            };

            if (!empty($projects)) {
                foreach ($projects as $idx => $p) {
                    $writeClientRow($row);
                    $writeProjectRow($row, $p);
                    $sheet->setCellValue('R' . $row, $c['marketing'] ?? '-');
                    $row++;
                }
            } else {
                $writeClientRow($row);
                $sheet->setCellValue('M' . $row, '-');
                $sheet->setCellValue('N' . $row, '-');
                $sheet->setCellValue('O' . $row, '-');
                $sheet->setCellValue('P' . $row, '-');
                $sheet->setCellValue('Q' . $row, '-');
                $sheet->setCellValue('R' . $row, $c['marketing'] ?? '-');
                $row++;
            }

            $no++;
        }

        $lastRow = $row - 1;
        if ($lastRow >= 5) {
            $dataRange = 'A5:' . $lastCol . $lastRow;
            $sheet->getStyle($dataRange)->getAlignment()
                ->setWrapText(true)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        }

        foreach (range('A', 'R') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $file_parts = ['Laporan', 'Client'];
        $file_parts[] = str_replace(' ', '_', $marketing_name);
        if (!empty($params['bulan'])) {
            $file_parts[] = $bulan_names[(int)$params['bulan']] ?? $params['bulan'];
        }
        if (!empty($params['tahun'])) {
            $file_parts[] = $params['tahun'];
        }
        $filename = implode('-', $file_parts) . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}