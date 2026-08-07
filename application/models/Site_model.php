<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Site_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_site.*, tab_perusahaan.nama_perusahaan, tab_provinsi.nama_provinsi, tab_kota.nama_kota');
        $this->db->from('tab_site');
        $this->db->join('tab_perusahaan', 'tab_perusahaan.id_perusahaan = tab_site.id_perusahaan', 'left');
        $this->db->join('tab_provinsi', 'tab_provinsi.id_provinsi = tab_site.provinsi', 'left');
        $this->db->join('tab_kota', 'tab_kota.id_kota = tab_site.kota', 'left');
        $this->db->order_by('tab_site.id_site', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getSiteById($id_site)
    {
        return $this->db->get_where('tab_site', ['id_site' => $id_site])->row_array();
    }

    public function storeData($data) 
    {
        $this->db->insert('tab_site', $data);
    }

    public function editData($id_site, $data)
    {
        $this->db->where('id_site', $id_site);
        $this->db->update('tab_site', $data);
    }

    public function deleteData($id_site)
    {
        $this->db->delete('tab_site', ['id_site' => $id_site]);
    }

    public function getProvinsi()
    {
        $this->db->order_by('nama_provinsi', 'ASC');
        return $this->db->get('tab_provinsi')->result_array();
    }

    public function getKotaByProvinsi($id_provinsi)
    {
        $this->db->where('provinsi', $id_provinsi);
        $this->db->order_by('nama_kota', 'ASC');
        return $this->db->get('tab_kota')->result_array();
    }
}