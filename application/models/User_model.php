<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getData() 
    {
        $this->db->select('tab_user.*, tab_dept.nama_dept, tab_cabang.nama_cabang');
        $this->db->from('tab_user');
        $this->db->join('tab_dept', 'tab_dept.id_dept = tab_user.dept_id', 'left');
        $this->db->join('tab_cabang', 'tab_cabang.id_cabang = tab_user.cabang_id', 'left');
        return $this->db->get()->result_array();
    }

    public function getUserById($id_user)
    {
        $this->db->select('tab_user.*, tab_cabang.nama_cabang');
        $this->db->from('tab_user');
        $this->db->join('tab_cabang', 'tab_cabang.id_cabang = tab_user.cabang_id', 'left');
        $this->db->where('tab_user.id_user', $id_user);
        return $this->db->get()->row_array();
    }

    public function storeData($data) 
    {
        return $this->db->insert('tab_user', $data);
    }

    public function updateData($id_user, $data) 
    {
        $this->db->where('id_user', $id_user);
        $result = $this->db->update('tab_user', $data);
        return $result;
    }
        
    public function deleteData($id_user)
    {
        $this->db->delete('tab_user', ['id_user' => $id_user]);
    }
}