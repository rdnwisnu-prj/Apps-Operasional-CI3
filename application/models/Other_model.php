<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Other_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_other.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_other');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_other.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_other.korlap', 'left');
        $this->db->order_by('tab_other.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('tab_other', ['id_other' => $id])->row_array();
    }

    public function getProjects()
    {
        $this->db->select('kode_project, nama_project, tgl_mulai, tgl_selesai');
        $this->db->from('tab_project');
        $this->db->order_by('nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function storeData($data)
    {
        return $this->db->insert('tab_other', $data);
    }

    public function editData($id, $data)
    {
        $this->db->where('id_other', $id);
        return $this->db->update('tab_other', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_other', ['id_other' => $id]);
    }
}