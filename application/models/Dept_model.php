<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dept_model extends CI_Model
{
    public function getData()
    {
        return $this->db->get('tab_dept')->result_array();
    }

    public function getDeptById($id_dept)
    {
        return $this->db->get_where('tab_dept', ['id_dept' => $id_dept])->row_array();
    }

    public function storeData($data) 
    {
        $this->db->insert('tab_dept', $data);
    }

    public function editData($id_dept, $data)
    {
        $this->db->where('id_dept', $id_dept);
        $this->db->update('tab_dept', $data);
    }
    

    public function deleteData($id_dept)
    {
        $this->db->delete('tab_dept', ['id_dept' => $id_dept]);
    }
}