<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Project_model','project');
        $this->load->model('Perusahaan_model','perusahaan');
        $this->load->library('form_validation');
        $this->load->library('Marketing_api');
        is_logged_in();
        check_role_access();
    }
    
    public function index()
    {
        $isKorlapOnly = $this->isKorlapOnly();
        $projects = $isKorlapOnly
            ? $this->project->getDataForKorlap((int) $this->session->userdata('id_user'))
            : $this->project->getData();

        foreach ($projects as &$project) {
            $project['korlap_rows'] = $this->project->getKorlapByProject($project['kode_project']);
            $project['sites'] = $this->project->getSiteByPerusahaan($project['perusahaan_id']);
        }
        unset($project);

        $marketingProjectSites = $this->getMarketingProjectSiteOptions($projects);

        $data = [
            'title'      => 'Operasional Web App | Project',
            'header'     => 'Master Data',
            'subheader'  => 'Data Project',
            'project'    => $projects,
            'perusahaan' => $this->perusahaan->getData(),
            'users'      => $this->project->getUsers(),
            'marketing_project_sites' => $marketingProjectSites,
            'can_manage_project' => !$isKorlapOnly,
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('project/index', $data);
        $this->load->view('templates/footer');
    }

    private function getKorlapRowsFromPost()
    {
        $korlap_ids   = (array) $this->input->post('korlap_id');
        $korlap_mulai = (array) $this->input->post('korlap_tgl_mulai');
        $korlap_akhir = (array) $this->input->post('korlap_tgl_selesai');
        $rows = [];
        $seen = [];

        foreach ($korlap_ids as $i => $user_id) {
            $user_id = (int) $user_id;
            $tgl_mulai = isset($korlap_mulai[$i]) ? trim($korlap_mulai[$i]) : '';
            $tgl_selesai = isset($korlap_akhir[$i]) ? trim($korlap_akhir[$i]) : '';

            if (!$user_id || $tgl_mulai === '' || $tgl_selesai === '') {
                continue;
            }

            $key = $user_id . '|' . $tgl_mulai . '|' . $tgl_selesai;
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $rows[] = [
                'user_id'     => $user_id,
                'tgl_mulai'   => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
            ];
        }

        return $rows;
    }

    private function insertKorlapRows($kode_project, $korlap_rows)
    {
        foreach ($korlap_rows as $korlap) {
            $this->project->insertKorlap([
                'kode_project' => $kode_project,
                'user_id'      => $korlap['user_id'],
                'tgl_mulai'    => $korlap['tgl_mulai'],
                'tgl_selesai'  => $korlap['tgl_selesai'],
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }

    private function getMarketingProjectSiteOptions($projects)
    {
        $rows = $this->marketing_api->getProjectSites();
        if (!is_array($rows)) {
            $rows = [];
        }

        $synced = [];
        foreach ($projects as $project) {
            if (!empty($project['marketing_project_id']) && !empty($project['marketing_site_id'])) {
                $synced[$project['marketing_project_id'] . '|' . $project['marketing_site_id']] = true;
            }
        }

        foreach ($rows as &$row) {
            $key = ((int) ($row['marketing_project_id'] ?? 0)) . '|' . ((int) ($row['marketing_site_id'] ?? 0));
            $row['marketing_key'] = $key;
            $row['is_synced'] = isset($synced[$key]);
        }
        unset($row);

        return $rows;
    }

    private function setRules()
    {
        $this->form_validation->set_rules('marketing_project_site_key', 'Project/Site Marketing', 'required|trim');
    }

    private function splitMarketingProjectSiteKey($key)
    {
        $parts = explode('|', (string) $key);

        if (count($parts) !== 2 || (int) $parts[0] <= 0 || (int) $parts[1] <= 0) {
            return false;
        }

        return [
            'marketing_project_id' => (int) $parts[0],
            'marketing_site_id' => (int) $parts[1],
        ];
    }

    private function buildPayload($isUpdate = false)
    {
        $site_id = $this->input->post('site_id', true);

        $data = [
            'perusahaan_id' => $this->input->post('perusahaan_id', true),
            'site_id'       => $site_id !== '' ? $site_id : null,
            'nama_project'  => $this->input->post('nama_project', true),
            'tgl_mulai'     => $this->input->post('tgl_mulai', true),
            'tgl_selesai'   => $this->input->post('tgl_selesai', true),
            'deskripsi'     => $this->input->post('deskripsi', true) ?: '',
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if (!$isUpdate) {
            $data['kode_project'] = $this->project->generateKode();
            $data['user_id'] = $this->session->userdata('id_user');
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        return $data;
    }

    public function detail($kode_project = null)
    {
        $kode_project = $kode_project ? urldecode($kode_project) : null;

        if (!$kode_project) {
            $this->session->set_flashdata('error', 'Kode project tidak valid');
            redirect('Project');
            return;
        }

        $project = $this->project->getProjectDetail($kode_project);

        if (!$project) {
            $this->session->set_flashdata('error', 'Data project tidak ditemukan');
            redirect('Project');
            return;
        }

        if ($this->isKorlapOnly() && !$this->project->canKorlapAccessProject($kode_project, (int) $this->session->userdata('id_user'))) {
            $this->session->set_flashdata('error', 'Akses ditolak. Korlap hanya dapat melihat project yang ditugaskan.');
            redirect('Project');
            return;
        }

        $financialSummary = $this->project->getProjectFinancialSummary($kode_project);
        $filteredFinancial = $this->filterFinancialSummaryByRole($financialSummary);

        $data = [
            'title'             => 'Operasional Web App | Detail Project',
            'header'            => 'Master Data',
            'subheader'         => 'Detail Project',
            'project_detail'    => $project,
            'korlap'            => $this->project->getKorlapByProject($kode_project),
            'financial_summary' => $filteredFinancial['summary'],
            'financial_scope'   => $filteredFinancial['scope'],
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('project/detail', $data);
        $this->load->view('templates/footer');
    }

    public function View($kode_project = null)
    {
        $this->detail($kode_project);
    }

    private function filterFinancialSummaryByRole($summary)
    {
        $roleId = (int) $this->session->userdata('role_id');
        $allowedProcesses = [];
        $scope = 'Semua Proses';

        if ($roleId === 8) {
            $allowedProcesses = ['2'];
            $scope = 'Pelaksanaan MCU';
        } elseif ($roleId === 9) {
            $allowedProcesses = ['1', '3', '4'];
            $scope = 'Setting MCU, Bongkar Setting, Kirim Hasil';
        }

        if (empty($allowedProcesses)) {
            return [
                'summary' => $summary,
                'scope'   => $scope,
            ];
        }

        $summary['process_labels'] = array_intersect_key($summary['process_labels'] ?? [], array_flip($allowedProcesses));
        $summary['budget_by_process'] = array_intersect_key($summary['budget_by_process'] ?? [], array_flip($allowedProcesses));
        $summary['topup_by_process'] = array_intersect_key($summary['topup_by_process'] ?? [], array_flip($allowedProcesses));
        $summary['expense_by_process'] = array_intersect_key($summary['expense_by_process'] ?? [], array_flip($allowedProcesses));

        $summary['category_totals'] = [];
        $summary['grand_budget'] = 0;
        $summary['grand_initial_budget'] = 0;
        $summary['grand_topup'] = 0;
        $summary['grand_expense'] = 0;

        foreach ($summary['expense_by_process'] as $processRow) {
            $summary['grand_budget'] += (float) ($processRow['budget'] ?? 0);
            $summary['grand_initial_budget'] += (float) ($processRow['initial_budget'] ?? 0);
            $summary['grand_topup'] += (float) ($processRow['topup'] ?? 0);
            $summary['grand_expense'] += (float) ($processRow['total'] ?? 0);

            foreach (($processRow['categories'] ?? []) as $categoryKey => $category) {
                if (!isset($summary['category_totals'][$categoryKey])) {
                    $summary['category_totals'][$categoryKey] = [
                        'label' => $category['label'] ?? ucfirst($categoryKey),
                        'count' => 0,
                        'total' => 0,
                    ];
                }

                $summary['category_totals'][$categoryKey]['count'] += (int) ($category['count'] ?? 0);
                $summary['category_totals'][$categoryKey]['total'] += (float) ($category['total'] ?? 0);
            }
        }

        $summary['grand_remaining'] = $summary['grand_budget'] - $summary['grand_expense'];

        return [
            'summary' => $summary,
            'scope'   => $scope,
        ];
    }

    public function Store()
    {
        if (!$this->requireProjectManager()) {
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Project');
            return;
        }

        $this->setRules();

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Project');
            return;
        }

        $key = $this->splitMarketingProjectSiteKey($this->input->post('marketing_project_site_key', true));
        if (!$key) {
            $this->session->set_flashdata('error', 'Project/Site Marketing tidak valid');
            redirect('Project');
            return;
        }

        $this->db->trans_start();
        $result = $this->marketing_api->syncProjectSiteByKey(
            $key['marketing_project_id'],
            $key['marketing_site_id'],
            ['deskripsi' => $this->input->post('deskripsi', true) ?: '']
        );

        if ($result['success']) {
            $kode_project = $result['project']['kode_project'];
            $korlapRows = $this->getKorlapRowsFromPost();
            if (!empty($korlapRows)) {
                $this->project->deleteKorlapByProject($kode_project);
                $this->insertKorlapRows($kode_project, $korlapRows);
            }
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() && $result['success']) {
            $this->session->set_flashdata('flash', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message'] ?? 'Data project gagal ditambahkan');
        }

        redirect('Project');
    }

    public function edit($kode_project)
    {
        if (!$this->requireProjectManager()) {
            return;
        }

        redirect('Project');
    }

    public function update() 
    {
        if (!$this->requireProjectManager()) {
            return;
        }

        if ($this->input->method(TRUE) !== 'POST') {
            redirect('Project');
            return;
        }

        $kode_project = $this->input->post('kode_project', true);

        if (!$kode_project || !$this->project->getProjectById($kode_project)) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('Project');
            return;
        }
    
        $this->setRules();
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', trim(strip_tags(validation_errors())));
            redirect('Project');
            return;
        }

        $key = $this->splitMarketingProjectSiteKey($this->input->post('marketing_project_site_key', true));
        if (!$key) {
            $this->session->set_flashdata('error', 'Project/Site Marketing tidak valid');
            redirect('Project');
            return;
        }

        $this->db->trans_start();
        $result = $this->marketing_api->syncProjectSiteByKey(
            $key['marketing_project_id'],
            $key['marketing_site_id'],
            [
                'kode_project' => $kode_project,
                'deskripsi' => $this->input->post('deskripsi', true) ?: '',
            ]
        );
        if ($result['success']) {
            $this->project->deleteKorlapByProject($kode_project);
            $this->insertKorlapRows($kode_project, $this->getKorlapRowsFromPost());
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() && $result['success']) {
            $this->session->set_flashdata('flash', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message'] ?? 'Data project gagal diperbarui');
        }

        redirect('Project');
    }

    public function destroy($kode_project)
    {
        if (!$this->requireProjectManager()) {
            return;
        }

        if ($this->project->deleteData($kode_project)) {
            $this->session->set_flashdata('flash', 'Dihapus');
        } else {
            $this->session->set_flashdata('error', 'Data project gagal dihapus');
        }
        redirect('Project');
    }

    public function syncMarketingSites()
    {
        if (!$this->requireProjectManager()) {
            return;
        }

        $result = $this->marketing_api->syncProjectSites();

        if ($result['success']) {
            $this->session->set_flashdata('flash', $result['message']);
        } else {
            $this->session->set_flashdata('error', $result['message']);
        }

        redirect('Project');
    }

    public function getSites()
    {
        $perusahaan_id = $this->input->get('perusahaan_id');
        $sites = $this->project->getSiteByPerusahaan($perusahaan_id);
        echo json_encode($sites);
    }

    private function isKorlapOnly()
    {
        return (int) $this->session->userdata('role_id') === 8;
    }

    private function requireProjectManager()
    {
        if (!$this->isKorlapOnly()) {
            return true;
        }

        $this->session->set_flashdata('error', 'Akses ditolak. Korlap hanya dapat melihat detail project.');
        redirect('Project');
        return false;
    }
}
