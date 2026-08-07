<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    public function getData()
    {
        $this->db->from('tab_perusahaan');
        $this->db->order_by('id_perusahaan', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getPerusahaanById($id_perusahaan)
    {
        return $this->db->get_where('tab_perusahaan', ['id_perusahaan' => $id_perusahaan])->row_array();
    }

    public function getByClientId($client_id)
    {
        return $this->db->get_where('tab_perusahaan', ['client_id' => $client_id])->row_array();
    }

    public function storeData($data) 
    {
        return $this->db->insert('tab_perusahaan', $data);
    }
    
    public function editData($id_perusahaan, $data)
    {
        $this->db->where('id_perusahaan', $id_perusahaan);
        return $this->db->update('tab_perusahaan', $data);
    }

    public function deleteData($id_perusahaan)
    {
        return $this->db->delete('tab_perusahaan', ['id_perusahaan' => $id_perusahaan]);
    }
}
