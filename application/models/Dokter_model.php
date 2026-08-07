<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokter_model extends CI_Model
{
    public function getData()
    {
        return $this->db->get('tab_dokter')->result_array();
    }

    public function getDokterById($id_dokter)
    {
        return $this->db->get_where('tab_dokter', ['id_dokter' => $id_dokter])->row_array();
    }

    public function storeData($data) 
    {
        $this->db->insert('tab_dokter', $data);
    }

    public function editData($id_dokter, $data)
    {
        $this->db->where('id_dokter', $id_dokter);
        $this->db->update('tab_dokter', $data);
    }
    

    public function deleteData($id_dokter)
    {
        $this->db->delete('tab_dokter', ['id_dokter' => $id_dokter]);
    }
}