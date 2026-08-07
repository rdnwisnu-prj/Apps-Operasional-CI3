<?php

defined('BASEPATH') or exit('No direct script access allowed');

class File_model extends CI_Model
{
    public function getFile($id_client = null)
    {
        $this->db->select('tab_file.*, tab_client.nama_client, tab_user.nama');
        $this->db->from('tab_file');
        $this->db->join('tab_client', 'tab_client.id_client = tab_file.client_id', 'left');
        $this->db->join('tab_user', 'tab_user.id_user = tab_file.user_id', 'left');
        
        if ($id_client) {
            $this->db->where('tab_file.client_id', $id_client);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function storeData($data)
    {
        return $this->db->insert('tab_file', $data);
    }

    public function getFileById($id_file)
    {
        $this->db->select('tab_file.*, tab_client.nama_client, tab_user.nama');
        $this->db->from('tab_file');
        $this->db->join('tab_client', 'tab_client.id_client = tab_file.client_id', 'left');
        $this->db->join('tab_user', 'tab_user.id_user = tab_file.user_id', 'left');
        $this->db->where('tab_file.id_file', $id_file);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    public function updateData($id_file, $data)
    {
        $this->db->where('id_file', $id_file);
        return $this->db->update('tab_file', $data);
    }

    public function deleteFile($id_file)
    {
        $this->db->delete('tab_file', ['id_file' => $id_file]);
    }

}