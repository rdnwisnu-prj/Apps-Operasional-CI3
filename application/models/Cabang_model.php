<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cabang_model extends CI_Model
{
    public function getData()
    {
        return $this->db->get('tab_cabang')->result_array();
    }

    public function getCabangsById($id_cabang)
    {
        return $this->db->get_where('tab_cabang', ['id_cabang' => $id_cabang])->row_array();
    }

    public function storeData($data) 
    {
        $this->db->insert('tab_cabang', $data);
    }

    public function editData($id_cabang, $data)
    {
        $this->db->where('id_cabang', $id_cabang);
        $this->db->update('tab_cabang', $data);
    }
    

    public function deleteData($id_cabang)
    {
        $this->db->delete('tab_cabang', ['id_cabang' => $id_cabang]);
    }
}