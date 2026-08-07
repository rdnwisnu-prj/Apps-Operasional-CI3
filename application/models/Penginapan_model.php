<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Penginapan_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_penginapan.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_penginapan');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_penginapan.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_penginapan.korlap', 'left');
        $this->db->order_by('tab_penginapan.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('tab_penginapan', ['id_penginapan' => $id])->row_array();
    }

    public function getProjects()
    {
        $this->db->select('kode_project, nama_project, tgl_mulai, tgl_selesai');
        $this->db->from('tab_project');
        $this->db->order_by('nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getProjectByKode($kode_project)
    {
        return $this->db->get_where('tab_project', ['kode_project' => $kode_project])->row_array();
    }

    public function storeData($data)
    {
        $this->db->insert('tab_penginapan', $data);
        return $this->db->insert_id();
    }

    public function editData($id, $data)
    {
        $this->db->where('id_penginapan', $id);
        return $this->db->update('tab_penginapan', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_penginapan', ['id_penginapan' => $id]);
    }
}
