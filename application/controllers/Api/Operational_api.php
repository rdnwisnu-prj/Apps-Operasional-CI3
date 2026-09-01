<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Operational_api extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('operational_api');
        $this->load->model('Perusahaan_model', 'perusahaan');
        $this->load->model('Project_model', 'project');
        $this->validateApiKey();
    }

    public function clients_get()
    {
        $updatedAfter = $this->get('updated_after', true);
        $keyword = $this->get('q', true);

        $this->db->select('id_perusahaan, client_id, nama_perusahaan, alamat_perusahaan, nama_pic, tlp_pic, no_tlp, email, marketing_id, marketing_name, source, created_at, updated_at');
        $this->db->from('tab_perusahaan');

        if ($updatedAfter) {
            $this->db->where('updated_at >=', $updatedAfter);
        }

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('nama_perusahaan', $keyword);
            $this->db->or_like('nama_pic', $keyword);
            $this->db->or_like('marketing_name', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('nama_perusahaan', 'ASC');
        $rows = $this->db->get()->result_array();

        $this->respondSuccess('Data perusahaan berhasil diambil', $rows);
    }

    public function projects_get($kodeProject = null)
    {
        if ($kodeProject) {
            $project = $this->getProjectSiteRows([
                'kode_project' => urldecode($kodeProject),
                'single' => true,
            ]);

            if (!$project) {
                $this->response([
                    'status' => false,
                    'message' => 'Project tidak ditemukan',
                ], 404);
                return;
            }

            $this->respondSuccess('Detail project berhasil diambil', $project);
            return;
        }

        $this->project_sites_get();
    }

    public function project_sites_get($kodeProject = null)
    {
        $filters = [
            'kode_project' => $kodeProject ? urldecode($kodeProject) : $this->get('kode_project', true),
            'client_id' => $this->get('client_id', true),
            'updated_after' => $this->get('updated_after', true),
            'q' => $this->get('q', true),
            'single' => (bool) $kodeProject,
        ];

        $rows = $this->getProjectSiteRows($filters);

        if ($filters['single'] && !$rows) {
            $this->response([
                'status' => false,
                'message' => 'Project/site tidak ditemukan',
            ], 404);
            return;
        }

        $this->respondSuccess('Data project/site berhasil diambil', $rows);
    }

    private function getProjectSiteRows($filters = [])
    {
        $this->db->select('
            p.kode_project,
            p.nama_project,
            p.tgl_mulai,
            p.tgl_selesai,
            p.deskripsi,
            p.marketing_project_id,
            p.marketing_site_id,
            p.source AS project_source,
            p.created_at AS project_created_at,
            p.updated_at AS project_updated_at,
            c.id_perusahaan,
            c.client_id,
            c.nama_perusahaan,
            c.alamat_perusahaan,
            c.nama_pic,
            c.tlp_pic,
            c.no_tlp,
            c.email,
            c.marketing_id,
            c.marketing_name,
            c.source AS perusahaan_source,
            s.id_site,
            s.nama_site,
            s.provinsi,
            s.kota,
            s.keterangan AS site_keterangan,
            s.marketing_site_id AS site_marketing_site_id,
            s.client_id AS site_client_id,
            s.source AS site_source,
            pr.nama_provinsi,
            kt.nama_kota
        ', false);
        $this->db->from('tab_project p');
        $this->db->join('tab_perusahaan c', 'c.id_perusahaan = p.perusahaan_id', 'left');
        $this->db->join('tab_site s', 's.id_site = p.site_id', 'left');
        $this->db->join('tab_provinsi pr', 'pr.id_provinsi = s.provinsi', 'left');
        $this->db->join('tab_kota kt', 'kt.id_kota = s.kota', 'left');

        if (!empty($filters['kode_project'])) {
            $this->db->where('p.kode_project', $filters['kode_project']);
        }

        if (!empty($filters['client_id'])) {
            $this->db->where('c.client_id', (int) $filters['client_id']);
        }

        if (!empty($filters['updated_after'])) {
            $this->db->where('p.updated_at >=', $filters['updated_after']);
        }

        if (!empty($filters['q'])) {
            $keyword = $filters['q'];
            $this->db->group_start();
            $this->db->like('p.kode_project', $keyword);
            $this->db->or_like('p.nama_project', $keyword);
            $this->db->or_like('c.nama_perusahaan', $keyword);
            $this->db->or_like('s.nama_site', $keyword);
            $this->db->group_end();
        }

        $this->db->order_by('p.updated_at', 'DESC');
        $this->db->order_by('p.created_at', 'DESC');
        $query = $this->db->get();
        $rows = $filters['single'] ?? false ? $query->row_array() : $query->result_array();

        if (($filters['single'] ?? false) && $rows) {
            return $this->formatProjectSiteRow($rows);
        }

        return array_map([$this, 'formatProjectSiteRow'], $rows);
    }

    private function formatProjectSiteRow($row)
    {
        $kodeProject = $row['kode_project'] ?? '';

        return [
            'kode_project' => $kodeProject,
            'nama_project' => $row['nama_project'] ?? '',
            'tgl_mulai' => $row['tgl_mulai'] ?? null,
            'tgl_selesai' => $row['tgl_selesai'] ?? null,
            'deskripsi' => $row['deskripsi'] ?? '',
            'marketing_project_id' => (int) ($row['marketing_project_id'] ?? 0),
            'marketing_site_id' => (int) ($row['marketing_site_id'] ?? 0),
            'source' => $row['project_source'] ?? '',
            'created_at' => $row['project_created_at'] ?? null,
            'updated_at' => $row['project_updated_at'] ?? null,
            'client' => [
                'id_perusahaan' => (int) ($row['id_perusahaan'] ?? 0),
                'client_id' => (int) ($row['client_id'] ?? 0),
                'nama_perusahaan' => $row['nama_perusahaan'] ?? '',
                'alamat_perusahaan' => $row['alamat_perusahaan'] ?? '',
                'nama_pic' => $row['nama_pic'] ?? '',
                'tlp_pic' => $row['tlp_pic'] ?? '',
                'no_tlp' => $row['no_tlp'] ?? '',
                'email' => $row['email'] ?? '',
                'marketing_id' => (int) ($row['marketing_id'] ?? 0),
                'marketing_name' => $row['marketing_name'] ?? '',
                'source' => $row['perusahaan_source'] ?? '',
            ],
            'site' => [
                'id_site' => (int) ($row['id_site'] ?? 0),
                'marketing_site_id' => (int) ($row['site_marketing_site_id'] ?? ($row['marketing_site_id'] ?? 0)),
                'client_id' => (int) ($row['site_client_id'] ?? 0),
                'nama_site' => $row['nama_site'] ?? '',
                'provinsi' => $row['provinsi'] ?? '',
                'kota' => $row['kota'] ?? '',
                'nama_provinsi' => $row['nama_provinsi'] ?? '',
                'nama_kota' => $row['nama_kota'] ?? '',
                'keterangan' => $row['site_keterangan'] ?? '',
                'source' => $row['site_source'] ?? '',
            ],
            'korlap' => $this->getKorlapPayload($kodeProject),
        ];
    }

    private function getKorlapPayload($kodeProject)
    {
        if (!$kodeProject) {
            return [];
        }

        $rows = $this->project->getKorlapByProject($kodeProject);
        return array_map(function ($row) {
            return [
                'id_user' => (int) ($row['user_id'] ?? 0),
                'nama' => $row['nama'] ?? '',
                'tgl_mulai' => $row['tgl_mulai'] ?? null,
                'tgl_selesai' => $row['tgl_selesai'] ?? null,
            ];
        }, $rows);
    }

    private function validateApiKey()
    {
        $expectedKey = (string) $this->config->item('operational_api_key');
        $requestKey = (string) $this->input->get_request_header('X-API-KEY', true);

        if ($expectedKey === '' || !hash_equals($expectedKey, $requestKey)) {
            $this->response([
                'status' => false,
                'message' => 'API key tidak valid',
            ], 401);
            exit;
        }
    }

    private function respondSuccess($message, $data)
    {
        $count = $this->isListArray($data) ? count($data) : null;

        $this->response([
            'status' => true,
            'message' => $message,
            'count' => $count,
            'data' => $data,
            'generated_at' => date('Y-m-d H:i:s'),
        ], 200);
    }

    private function isListArray($data)
    {
        if (!is_array($data)) {
            return false;
        }

        $index = 0;
        foreach (array_keys($data) as $key) {
            if ($key !== $index) {
                return false;
            }
            $index++;
        }

        return true;
    }
}
