<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marketing_api
{
    protected $CI;
    protected $api_base_url;
    protected $expense_api_url;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->api_base_url = getenv('MARKETING_API_BASE_URL') ?: 'https://marketing.cakramedika.co.id/Api/Client_api';
        $this->expense_api_url = getenv('MARKETING_EXPENSE_API_URL') ?: 'http://localhost:8000/Apps-Marketing/Api/Client_api/project_site_expense';
    }

    public function getClients()
    {
        $url = $this->api_base_url;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    public function getClientById($id_client)
    {
        $id_client = (int) $id_client;
        $url = $this->api_base_url . '/detail/' . $id_client;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    /**
     * Cari client berdasarkan keyword
     * @param string $keyword
     * @return array|false
     */
    public function searchClients($keyword)
    {
        $keyword = urlencode($keyword);
        $url = $this->api_base_url . '/search?q=' . $keyword;
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    /**
     * Ambil daftar user marketing (role_id = 7) dari Marketing API
     * @return array|false
     */
    public function getMarketingUsers()
    {
        $url = $this->api_base_url . '/marketing';
        $response = $this->_request($url);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return $response['data'];
        }

        return false;
    }

    public function getProjectSites($filters = [])
    {
        $query = [];
        foreach (['client_id', 'project_id', 'q'] as $key) {
            if (isset($filters[$key]) && $filters[$key] !== '') {
                $query[$key] = $filters[$key];
            }
        }

        $suffix = '/project_sites' . (!empty($query) ? '?' . http_build_query($query) : '');
        $response = $this->_request($this->api_base_url . $suffix);

        if ($this->hasProjectSitePayload($response)) {
            return $response['data'];
        }

        return false;
    }

    private function hasProjectSitePayload($response)
    {
        if (!$response || !isset($response['status'], $response['data']) || $response['status'] !== true || !is_array($response['data'])) {
            return false;
        }

        if (empty($response['data'])) {
            return true;
        }

        $first = reset($response['data']);
        if (!is_array($first)) {
            return false;
        }

        return !empty($first['marketing_site_id'])
            && !empty($first['marketing_project_id'])
            && isset($first['nama_site']) && $first['nama_site'] !== '';
    }

    public function getProjectSiteByKey($marketingProjectId, $marketingSiteId)
    {
        $rows = $this->getProjectSites(['project_id' => (int) $marketingProjectId]);

        if (!is_array($rows)) {
            return false;
        }

        foreach ($rows as $row) {
            if ((int) ($row['marketing_project_id'] ?? 0) === (int) $marketingProjectId
                && (int) ($row['marketing_site_id'] ?? 0) === (int) $marketingSiteId) {
                return $row;
            }
        }

        return false;
    }

    public function syncProjectSiteByKey($marketingProjectId, $marketingSiteId, $options = [])
    {
        $row = $this->getProjectSiteByKey($marketingProjectId, $marketingSiteId);

        if (!$row) {
            return ['success' => false, 'message' => 'Data project/site marketing tidak ditemukan'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');
        $this->CI->load->model('Project_model', 'project');

        $perusahaan = $this->upsertPerusahaanFromProjectSite($row);
        if (!$perusahaan) {
            return ['success' => false, 'message' => 'Data perusahaan gagal diproses'];
        }

        $site = $this->upsertSiteFromProjectSite($row, $perusahaan['id_perusahaan']);
        if (!$site) {
            return ['success' => false, 'message' => 'Data site gagal diproses'];
        }

        $project = $this->upsertProjectFromProjectSite(
            $row,
            $perusahaan['id_perusahaan'],
            $site['id_site'],
            $options['kode_project'] ?? null,
            $options['deskripsi'] ?? null
        );

        if (!$project) {
            return ['success' => false, 'message' => 'Data project gagal diproses'];
        }

        return [
            'success' => true,
            'message' => $project['action'] === 'inserted' ? 'Data project berhasil ditambahkan' : 'Data project berhasil diperbarui',
            'project' => $project,
            'site' => $site,
            'perusahaan' => $perusahaan,
            'source' => $row,
        ];
    }

    public function syncProjectSites()
    {
        $projectSites = $this->getProjectSites();

        if ($projectSites === false) {
            return ['success' => false, 'message' => 'Gagal mengambil data project site dari Marketing API'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');
        $this->CI->load->model('Project_model', 'project');

        $insertedProjects = 0;
        $updatedProjects = 0;
        $deletedProjects = 0;
        $insertedSites = 0;
        $updatedSites = 0;
        $insertedCompanies = 0;
        $updatedCompanies = 0;
        $skipped = 0;
        $sourceKeys = [];

        $this->CI->db->trans_start();

        foreach ($projectSites as $row) {
            if (empty($row['client_id']) || empty($row['marketing_site_id']) || empty($row['marketing_project_id'])) {
                $skipped++;
                continue;
            }

            $sourceKeys[] = ((int) $row['marketing_project_id']) . '|' . ((int) $row['marketing_site_id']);

            $perusahaan = $this->upsertPerusahaanFromProjectSite($row);
            if (!$perusahaan) {
                $skipped++;
                continue;
            }
            $insertedCompanies += $perusahaan['action'] === 'inserted' ? 1 : 0;
            $updatedCompanies += $perusahaan['action'] === 'updated' ? 1 : 0;

            $site = $this->upsertSiteFromProjectSite($row, $perusahaan['id_perusahaan']);
            if (!$site) {
                $skipped++;
                continue;
            }
            $insertedSites += $site['action'] === 'inserted' ? 1 : 0;
            $updatedSites += $site['action'] === 'updated' ? 1 : 0;

            $project = $this->upsertProjectFromProjectSite($row, $perusahaan['id_perusahaan'], $site['id_site']);
            if (!$project) {
                $skipped++;
                continue;
            }
            $insertedProjects += $project['action'] === 'inserted' ? 1 : 0;
            $updatedProjects += $project['action'] === 'updated' ? 1 : 0;
        }

        $deletedProjects = $this->CI->project->deleteMissingApiProjectSites(array_values(array_unique($sourceKeys)));

        $this->CI->db->trans_complete();

        if (!$this->CI->db->trans_status()) {
            return ['success' => false, 'message' => 'Sinkronisasi project site gagal disimpan'];
        }

        return [
            'success' => true,
            'message' => "Sinkronisasi selesai. Project ditambahkan: $insertedProjects, project diperbarui: $updatedProjects, project dihapus: $deletedProjects, site ditambahkan: $insertedSites, site diperbarui: $updatedSites",
            'total' => count($projectSites),
            'inserted_projects' => $insertedProjects,
            'updated_projects' => $updatedProjects,
            'deleted_projects' => $deletedProjects,
            'inserted_sites' => $insertedSites,
            'updated_sites' => $updatedSites,
            'inserted_companies' => $insertedCompanies,
            'updated_companies' => $updatedCompanies,
            'skipped' => $skipped,
        ];
    }

    public function sendProjectSiteExpense($payload)
    {
        if (empty($payload['marketing_project_id']) || empty($payload['marketing_site_id'])) {
            return ['success' => false, 'message' => 'Mapping project/site marketing belum tersedia'];
        }

        $response = $this->_postJson($this->expense_api_url, $payload);

        if ($response && isset($response['status']) && $response['status'] === true) {
            return [
                'success' => true,
                'message' => $response['message'] ?? 'Pengeluaran berhasil dikirim ke Marketing',
                'data' => $response['data'] ?? null,
            ];
        }

        return [
            'success' => false,
            'message' => $response['message'] ?? 'Gagal mengirim pengeluaran ke Marketing',
            'response' => $response,
        ];
    }

    private function upsertPerusahaanFromProjectSite($row)
    {
        $clientId = (int) $row['client_id'];
        $existing = $this->CI->perusahaan->getByClientId($clientId);
        $now = date('Y-m-d H:i:s');

        $data = [
            'nama_perusahaan' => $row['nama_client'] ?: 'Client #' . $clientId,
            'alamat_perusahaan' => $row['alamat_client'] ?: '',
            'nama_pic' => $row['nama_pic'] ?: '',
            'tlp_pic' => $row['tlp_pic'] ?: '',
            'no_tlp' => $row['tlp_pic'] ?: '',
            'email' => $row['email_pic'] ?: null,
            'marketing_id' => (int) ($row['user_id'] ?? 0),
            'marketing_name' => $row['marketing_name'] ?: '',
            'source' => 'api_project_site',
            'client_id' => $clientId,
            'updated_at' => $now,
        ];

        if ($existing) {
            $this->CI->perusahaan->editData($existing['id_perusahaan'], $data);
            return ['id_perusahaan' => (int) $existing['id_perusahaan'], 'action' => 'updated'];
        }

        $data['created_at'] = $now;
        $this->CI->perusahaan->storeData($data);
        return ['id_perusahaan' => (int) $this->CI->db->insert_id(), 'action' => 'inserted'];
    }

    private function upsertSiteFromProjectSite($row, $id_perusahaan)
    {
        $marketingSiteId = (int) $row['marketing_site_id'];
        $existing = $this->CI->project->getSiteByMarketingSiteId($marketingSiteId);
        if (!$existing) {
            $existing = $this->CI->project->getSiteByPerusahaanAndName($id_perusahaan, $row['nama_site']);
        }
        $now = date('Y-m-d H:i:s');

        $data = [
            'id_perusahaan' => (int) $id_perusahaan,
            'nama_site' => $row['nama_site'] ?: 'Site #' . $marketingSiteId,
            'provinsi' => $row['provinsi_id'] ?: null,
            'kota' => $row['kota_id'] ?: null,
            'keterangan' => $row['nama_provinsi'] || $row['nama_kota']
                ? trim(($row['nama_provinsi'] ?: '') . ' ' . ($row['nama_kota'] ?: ''))
                : '',
            'marketing_site_id' => $marketingSiteId,
            'client_id' => (int) $row['client_id'],
            'source' => 'api_project_site',
            'updated_at' => $now,
        ];
        $data = $this->filterExistingFields('tab_site', $data);

        if ($existing) {
            $this->CI->project->updateSiteData($existing['id_site'], $data);
            return ['id_site' => (int) $existing['id_site'], 'action' => 'updated'];
        }

        $data['created_at'] = $now;
        $this->CI->project->storeSiteData($data);
        return ['id_site' => (int) $this->CI->db->insert_id(), 'action' => 'inserted'];
    }

    private function upsertProjectFromProjectSite($row, $id_perusahaan, $id_site, $kode_project = null, $deskripsi_override = null)
    {
        $marketingProjectId = (int) $row['marketing_project_id'];
        $marketingSiteId = (int) $row['marketing_site_id'];
        $existing = $kode_project ? $this->CI->project->getProjectById($kode_project) : null;
        if (!$existing) {
            $existing = $this->CI->project->getProjectByMarketingSite($marketingProjectId, $marketingSiteId);
        }
        if (!$existing) {
            $existing = $this->CI->project->getProjectBySiteAndName($id_site, $row['nama_project']);
        }
        $now = date('Y-m-d H:i:s');
        $tglMulai = $row['tgl_pelaksanaan'] ?: null;
        $tglSelesai = $row['tgl_selesai'] ?: $tglMulai;

        if (!$tglMulai || !$tglSelesai) {
            return false;
        }

        $data = [
            'perusahaan_id' => (int) $id_perusahaan,
            'site_id' => (int) $id_site,
            'nama_project' => $row['nama_project'] ?: 'Project #' . $marketingProjectId,
            'tgl_mulai' => $tglMulai,
            'tgl_selesai' => $tglSelesai,
            'deskripsi' => $deskripsi_override !== null ? $deskripsi_override : ($row['deskripsi'] ?: ($row['keterangan'] ?: '')),
            'marketing_project_id' => $marketingProjectId,
            'marketing_site_id' => $marketingSiteId,
            'source' => 'api_project_site',
            'updated_at' => $now,
        ];
        $data = $this->filterExistingFields('tab_project', $data);

        if ($existing) {
            $this->CI->project->editData($existing['kode_project'], $data);
            return ['kode_project' => $existing['kode_project'], 'action' => 'updated'];
        }

        $data['kode_project'] = $this->CI->project->generateKode();
        $data['user_id'] = (int) $this->CI->session->userdata('id_user');
        $data['created_at'] = $now;
        $data = $this->filterExistingFields('tab_project', $data);
        $this->CI->project->storeData($data);

        return ['kode_project' => $data['kode_project'], 'action' => 'inserted'];
    }

    private function filterExistingFields($table, $data)
    {
        $filtered = [];
        foreach ($data as $field => $value) {
            if ($this->CI->db->field_exists($field, $table)) {
                $filtered[$field] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Sinkronisasi semua client dari Marketing ke tab_perusahaan
     * @return array result summary
     */
    public function syncAll()
    {
        $clients = $this->getClients();

        if ($clients === false) {
            return ['success' => false, 'message' => 'Gagal mengambil data dari Marketing API'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');

        $inserted = 0;
        $updated  = 0;
        $skipped  = 0;

        foreach ($clients as $client) {
            $existing = $this->CI->perusahaan->getByClientId($client['id_client']);

            $data = [
                'nama_perusahaan'   => $client['nama_client'],
                'alamat_perusahaan' => $client['alamat_client'] ?: '',
                'nama_pic'          => $client['nama_pic'] ?: '',
                'tlp_pic'           => $client['tlp_pic'] ?: '',
                'no_tlp'            => $client['tlp_pic'] ?: '',
                'email'             => $client['email_pic'] ?: '',
                'marketing_id'      => (int) $client['user_id'],
                'marketing_name'    => $client['marketing_name'] ?: '',
                'source'            => 'api',
                'client_id'         => (int) $client['id_client'],
                'updated_at'        => date('Y-m-d H:i:s'),
            ];

            if ($existing) {
                $this->CI->perusahaan->editData($existing['id_perusahaan'], $data);
                $updated++;
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->CI->perusahaan->storeData($data);
                $inserted++;
            }
        }

        return [
            'success'  => true,
            'message'  => "Sinkronisasi selesai. Ditambahkan: $inserted, Diperbarui: $updated",
            'inserted' => $inserted,
            'updated'  => $updated,
            'total'    => count($clients)
        ];
    }

    /**
     * Sinkronisasi satu client berdasarkan ID
     * @param int $id_client
     * @return array
     */
    public function syncOne($id_client)
    {
        $client = $this->getClientById($id_client);

        if ($client === false) {
            return ['success' => false, 'message' => 'Client tidak ditemukan di Marketing'];
        }

        $this->CI->load->model('Perusahaan_model', 'perusahaan');
        $existing = $this->CI->perusahaan->getByClientId($client['id_client']);

        $data = [
            'nama_perusahaan'   => $client['nama_client'],
            'alamat_perusahaan' => $client['alamat_client'] ?: '',
            'nama_pic'          => $client['nama_pic'] ?: '',
            'tlp_pic'           => $client['tlp_pic'] ?: '',
            'no_tlp'            => $client['tlp_pic'] ?: '',
            'email'             => $client['email_pic'] ?: '',
            'marketing_id'      => (int) $client['user_id'],
            'marketing_name'    => $client['marketing_name'] ?: '',
            'source'            => 'api',
            'client_id'         => (int) $client['id_client'],
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            $this->CI->perusahaan->editData($existing['id_perusahaan'], $data);
            return ['success' => true, 'message' => 'Data client berhasil diperbarui', 'action' => 'updated'];
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->CI->perusahaan->storeData($data);
            return ['success' => true, 'message' => 'Data client berhasil ditambahkan', 'action' => 'inserted'];
        }
    }

    /**
     * HTTP GET request menggunakan cURL
     * @param string $url
     * @return array|false
     */
    private function _request($url)
    {
        if (!function_exists('curl_init')) {
            log_message('error', 'Marketing_api: cURL extension tidak tersedia');
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Marketing_api cURL Error: ' . $error);
            return false;
        }

        if ($http_code !== 200) {
            log_message('error', 'Marketing_api HTTP Error: ' . $http_code);
            return false;
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Marketing_api JSON Error: ' . json_last_error_msg());
            return false;
        }

        return $decoded;
    }

    private function _postJson($url, $payload)
    {
        if (!function_exists('curl_init')) {
            log_message('error', 'Marketing_api: cURL extension tidak tersedia');
            return false;
        }

        $body = json_encode($payload);
        if ($body === false) {
            log_message('error', 'Marketing_api JSON Encode Error: ' . json_last_error_msg());
            return false;
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Marketing_api cURL POST Error: ' . $error);
            return false;
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'Marketing_api POST JSON Error: ' . json_last_error_msg() . ' Response: ' . $response);
            return false;
        }

        if ($http_code < 200 || $http_code >= 300) {
            log_message('error', 'Marketing_api POST HTTP Error: ' . $http_code . ' Response: ' . $response);
            return $decoded;
        }

        return $decoded;
    }
}
