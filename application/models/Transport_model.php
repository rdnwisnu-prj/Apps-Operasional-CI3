<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transport_model extends CI_Model
{
    public function getData()
    {
        $this->ensureJenisPengeluaranColumn();
        $this->db->select('tab_transport.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_transport');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_transport.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_transport.korlap', 'left');
        $this->db->order_by('tab_transport.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        $this->ensureJenisPengeluaranColumn();
        return $this->db->get_where('tab_transport', ['id_transport' => $id])->row_array();
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
        $this->ensureJenisPengeluaranColumn();
        return $this->db->insert('tab_transport', $data);
    }

    public function editData($id, $data)
    {
        $this->ensureJenisPengeluaranColumn();
        $this->db->where('id_transport', $id);
        return $this->db->update('tab_transport', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_transport', ['id_transport' => $id]);
    }

    private function ensureJenisPengeluaranColumn()
    {
        if ($this->db->field_exists('jenis_pengeluaran', 'tab_transport')) {
            return;
        }

        $this->load->dbforge();
        $this->dbforge->add_column('tab_transport', [
            'jenis_pengeluaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'default'    => 'Mobil',
                'after'      => 'proses',
            ],
        ]);
    }
}
