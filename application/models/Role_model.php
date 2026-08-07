<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function getData() 
    {
        return $this->db->get('tab_role')->result_array();
    }

    public function getRoleById($id_role)
    {
        return $this->db->get_where('tab_role', ['id_role' => $id_role])->row_array();
    }
    
    public function storeData($data) 
    {
        return $this->db->insert('tab_role', $data);
    }

    public function updateData($id_role, $data) 
    {
        $this->db->where('id_role', $id_role);
        $this->db->update('tab_role', $data);
    }
    
    public function deleteData($id_role)
    {
        $this->db->delete('tab_role', ['id_role' => $id_role]);
    }
}