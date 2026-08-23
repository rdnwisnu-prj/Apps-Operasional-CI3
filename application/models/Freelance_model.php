<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Freelance_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_fee_freelance.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_fee_freelance');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_fee_freelance.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_fee_freelance.korlap', 'left');
        $this->db->order_by('tab_fee_freelance.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        return $this->db->get_where('tab_fee_freelance', ['id_freelance' => $id])->row_array();
    }

    public function getProjects()
    {
        $this->db->select('tab_project.kode_project, tab_project.nama_project, tab_project.tgl_mulai, tab_project.tgl_selesai');
        $this->db->from('tab_project');
        $this->applyKorlapProjectFilter();
        $this->db->order_by('tab_project.nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function canUseProject($kode_project)
    {
        $this->db->from('tab_project');
        $this->db->where('tab_project.kode_project', $kode_project);
        $this->applyKorlapProjectFilter();
        return (bool) $this->db->get()->row_array();
    }

    public function storeData($data)
    {
        $this->db->insert('tab_fee_freelance', $data);
        return $this->db->insert_id();
    }

    public function editData($id, $data)
    {
        $this->db->where('id_freelance', $id);
        return $this->db->update('tab_fee_freelance', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_fee_freelance', ['id_freelance' => $id]);
    }

    private function applyKorlapProjectFilter()
    {
        if ((int) $this->session->userdata('role_id') !== 8) {
            return;
        }

        $this->db->join('tab_project_korlap k', 'k.kode_project = tab_project.kode_project', 'inner');
        $this->db->where('k.user_id', (int) $this->session->userdata('id_user'));
        $this->db->distinct();
    }
}
