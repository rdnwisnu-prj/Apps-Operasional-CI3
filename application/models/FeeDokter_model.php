<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FeeDokter_model extends CI_Model
{
    public function getData($filters = [])
    {
        $this->db->select('tab_fee_dokter.*, tab_project.nama_project, tab_cabang.nama_cabang, u.nama as created_by, d.nama_dokter as master_nama_dokter, d.ktp as master_ktp, r.bank as rek_bank, r.no_rek as rek_no_rek, r.atas_nama as rek_atas_nama, r.kcp as rek_kcp');
        $this->db->from('tab_fee_dokter');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_fee_dokter.project', 'left');
        $this->db->join('tab_cabang', 'tab_cabang.id_cabang = tab_fee_dokter.cabang', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_fee_dokter.user_id', 'left');
        $this->db->join('tab_dokter d', 'd.id_dokter = tab_fee_dokter.dokter_id', 'left');
        $this->db->join('tab_fee_rekening r', 'r.id_fee = tab_fee_dokter.id_fee AND r.is_active = 1', 'left');

        if (!empty($filters['bulan'])) {
            $this->db->where('MONTH(tab_fee_dokter.tgl_project)', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('YEAR(tab_fee_dokter.tgl_project)', $filters['tahun']);
        }
        if (!empty($filters['cabang'])) {
            $this->db->where('tab_fee_dokter.cabang', $filters['cabang']);
        }
        if (!empty($filters['dokter'])) {
            if (is_array($filters['dokter'])) {
                $this->db->where_in('tab_fee_dokter.dokter_id', $filters['dokter']);
            } else {
                $this->db->where('tab_fee_dokter.dokter_id', $filters['dokter']);
            }
        }
        if (isset($filters['pph21']) && $filters['pph21'] !== '') {
            $this->db->where('tab_fee_dokter.pph21', $filters['pph21']);
        }

        $this->db->order_by('tab_fee_dokter.tgl_project', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('tab_fee_dokter', ['id_fee' => $id])->row_array();
    }

    public function getDokter()
    {
        $this->db->select('id_dokter, nama_dokter, ktp, bank, no_rekening, atas_nama, kcp');
        $this->db->order_by('nama_dokter', 'ASC');
        return $this->db->get('tab_dokter')->result_array();
    }

    public function getDokterById($id)
    {
        $this->db->select('id_dokter, nama_dokter, ktp, bank, no_rekening, atas_nama, kcp');
        return $this->db->get_where('tab_dokter', ['id_dokter' => $id])->row_array();
    }

    public function getDokterByNama($nama)
    {
        return $this->db->get_where('tab_dokter', ['nama_dokter' => $nama])->row_array();
    }

    public function storeData($data)
    {
        $this->db->insert('tab_fee_dokter', $data);
        return $this->db->insert_id();
    }

    public function editData($id, $data)
    {
        $this->db->where('id_fee', $id);
        $this->db->update('tab_fee_dokter', $data);
    }

    public function deleteData($id)
    {
        $this->deleteRekeningByFee($id);
        $this->db->delete('tab_fee_dokter', ['id_fee' => $id]);
    }

    public function getProjects()
    {
        $this->db->select('kode_project, nama_project, tab_perusahaan.nama_perusahaan, tab_site.nama_site, ,tgl_mulai, tgl_selesai');
        $this->db->from('tab_project');
        $this->db->join('tab_perusahaan', 'tab_perusahaan.id_perusahaan = tab_project.perusahaan_id', 'left');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->order_by('nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getCabang()
    {
        $this->db->select('id_cabang, nama_cabang, kota_cabang');
        $this->db->from('tab_cabang');
        $this->db->order_by('nama_cabang', 'ASC');
        return $this->db->get()->result_array();
    }

    // ---- Rekening Methods ----

    public function storeRekening($data)
    {
        return $this->db->insert('tab_fee_rekening', $data);
    }

    public function getRekeningByFee($id_fee)
    {
        return $this->db->get_where('tab_fee_rekening', ['id_fee' => $id_fee])->result_array();
    }

    public function deleteRekeningByFee($id_fee)
    {
        $this->db->delete('tab_fee_rekening', ['id_fee' => $id_fee]);
    }

    public function setActiveRekening($id_rekening, $id_fee)
    {
        // Set all to inactive
        $this->db->where('id_fee', $id_fee);
        $this->db->update('tab_fee_rekening', ['is_active' => 0]);
        // Set selected as active
        $this->db->where('id_rekening', $id_rekening);
        $this->db->update('tab_fee_rekening', ['is_active' => 1]);
    }

    // ---- Autocomplete Methods ----

    public function searchByNamaDokter($keyword)
    {
        $this->db->select('id_dokter, nama_dokter');
        $this->db->from('tab_dokter');
        $this->db->like('nama_dokter', $keyword, 'both');
        $this->db->order_by('nama_dokter', 'ASC');
        $this->db->limit(15);
        return $this->db->get()->result_array();
    }

    public function getLatestByNamaDokter($nama)
    {
        $this->db->where('nama_dokter', $nama);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit(1);
        $row = $this->db->get('tab_fee_dokter')->row_array();

        if ($row) {
            $row['rekening'] = $this->getRekeningByFee($row['id_fee']);
        }

        return $row;
    }
}