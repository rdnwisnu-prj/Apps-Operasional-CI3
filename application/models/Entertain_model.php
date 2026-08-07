<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Entertain_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_entertain.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_entertain');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_entertain.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_entertain.korlap', 'left');
        $this->db->order_by('tab_entertain.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('tab_entertain', ['id_entertain' => $id])->row_array();
    }

    public function getProjects()
    {
        $this->db->select('tab_project.kode_project, tab_project.nama_project, tab_project.tgl_mulai, tab_project.tgl_selesai, tab_project.site_id, tab_site.provinsi, tab_site.kota');
        $this->db->from('tab_project');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->order_by('tab_project.nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getProjectByKode($kode_project)
    {
        return $this->db->get_where('tab_project', ['kode_project' => $kode_project])->row_array();
    }

    public function storeData($data)
    {
        return $this->db->insert('tab_entertain', $data);
    }

    public function editData($id, $data)
    {
        $this->db->where('id_entertain', $id);
        return $this->db->update('tab_entertain', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_entertain', ['id_entertain' => $id]);
    }

    /**
     * Calculate nominal based on province and city codes from tab_site
     */
    public function getNominalByProject($kode_project)
    {
        $this->db->select('tab_site.provinsi, tab_site.kota');
        $this->db->from('tab_project');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->where('tab_project.kode_project', $kode_project);
        $site = $this->db->get()->row_array();

        if (!$site) return 0;

        return $this->calculateNominal($site['provinsi'], $site['kota']);
    }

    /**
     * Determine nominal value based on region rules
     */
    public function calculateNominal($provinsi, $kota)
    {
        // Tier 1: Rp 7.000 - DKI Jakarta
        if ($provinsi == '31') {
            return 7000;
        }

        // Tier 1: Rp 7.000 - Jawa Barat specific cities
        $jabar_7000 = ['3201', '3215', '3216', '3271', '3275', '3276'];
        if ($provinsi == '32' && in_array($kota, $jabar_7000)) {
            return 7000;
        }

        // Tier 1: Rp 7.000 - Banten specific cities
        $banten_7000 = ['3603', '3671', '3674'];
        if ($provinsi == '36' && in_array($kota, $banten_7000)) {
            return 7000;
        }

        // Tier 2: Rp 50.000 - Jawa Barat (other cities)
        if ($provinsi == '32') {
            return 50000;
        }

        // Tier 3: Rp 75.000 - Jawa Tengah
        if ($provinsi == '33') {
            return 75000;
        }

        // Tier 4: Rp 80.000 - Jawa Timur
        if ($provinsi == '35') {
            return 80000;
        }

        // Banten other cities = Luar Jawa tariff
        if ($provinsi == '36') {
            return 110000;
        }

        // DI Yogyakarta (34) - treat as Jawa Tengah tariff
        if ($provinsi == '34') {
            return 75000;
        }

        // Tier 5: Rp 110.000 - Luar Jawa
        return 110000;
    }
}