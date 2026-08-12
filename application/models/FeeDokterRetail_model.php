<?php

defined('BASEPATH') or exit('No direct script access allowed');

class FeeDokterRetail_model extends CI_Model
{
    private $table = 'tab_fee_dokter_retail';
    private $rekeningTable = 'tab_fee_rekening_retail';

    public function getData($filters = [])
    {
        $this->db->select($this->table . '.*, tab_cabang.nama_cabang, u.nama as created_by, d.nama_dokter as master_nama_dokter, d.ktp as master_ktp, r.bank as rek_bank, r.no_rek as rek_no_rek, r.atas_nama as rek_atas_nama, r.kcp as rek_kcp');
        $this->db->from($this->table);
        $this->db->join('tab_cabang', 'tab_cabang.id_cabang = ' . $this->table . '.cabang', 'left');
        $this->db->join('tab_user u', 'u.id_user = ' . $this->table . '.user_id', 'left');
        $this->db->join('tab_dokter d', 'd.id_dokter = ' . $this->table . '.dokter_id', 'left');
        $this->db->join($this->rekeningTable . ' r', 'r.id_fee = ' . $this->table . '.id_fee AND r.is_active = 1', 'left');

        if (!empty($filters['bulan'])) {
            $this->db->where('MONTH(' . $this->table . '.tgl_project)', $filters['bulan']);
        }
        if (!empty($filters['tahun'])) {
            $this->db->where('YEAR(' . $this->table . '.tgl_project)', $filters['tahun']);
        }
        if (!empty($filters['cabang'])) {
            $this->db->where($this->table . '.cabang', $filters['cabang']);
        }
        if (!empty($filters['dokter'])) {
            if (is_array($filters['dokter'])) {
                $this->db->where_in($this->table . '.dokter_id', $filters['dokter']);
            } else {
                $this->db->where($this->table . '.dokter_id', $filters['dokter']);
            }
        }
        if (isset($filters['pph21']) && $filters['pph21'] !== '') {
            $this->db->where($this->table . '.pph21', $filters['pph21']);
        }

        $this->db->order_by($this->table . '.tgl_project', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where($this->table, ['id_fee' => $id])->row_array();
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

    public function getCabang()
    {
        $this->db->select('id_cabang, nama_cabang, kota_cabang');
        $this->db->from('tab_cabang');
        $this->db->order_by('nama_cabang', 'ASC');
        return $this->db->get()->result_array();
    }

    public function storeData($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function editData($id, $data)
    {
        $this->db->where('id_fee', $id);
        return $this->db->update($this->table, $data);
    }

    public function deleteData($id)
    {
        $this->deleteRekeningByFee($id);
        return $this->db->delete($this->table, ['id_fee' => $id]);
    }

    public function storeRekening($data)
    {
        return $this->db->insert($this->rekeningTable, $data);
    }

    public function getRekeningByFee($id_fee)
    {
        return $this->db->get_where($this->rekeningTable, ['id_fee' => $id_fee])->result_array();
    }

    public function deleteRekeningByFee($id_fee)
    {
        return $this->db->delete($this->rekeningTable, ['id_fee' => $id_fee]);
    }

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
        $row = $this->db->get($this->table)->row_array();

        if ($row) {
            $row['rekening'] = $this->getRekeningByFee($row['id_fee']);
        }

        return $row;
    }
}
