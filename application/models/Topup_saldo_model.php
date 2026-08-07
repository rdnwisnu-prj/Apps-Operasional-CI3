<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Topup_saldo_model extends CI_Model
{
    public function getData()
    {
        $this->ensureTable();
        $this->db->select('tab_topup_saldo.*, tab_project.nama_project, tab_user.nama as created_by');
        $this->db->from('tab_topup_saldo');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_topup_saldo.project', 'left');
        $this->db->join('tab_user', 'tab_user.id_user = tab_topup_saldo.user_id', 'left');
        $this->db->order_by('tab_topup_saldo.tgl_topup', 'DESC');
        $this->db->order_by('tab_topup_saldo.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        $this->ensureTable();
        return $this->db->get_where('tab_topup_saldo', ['id_topup' => $id])->row_array();
    }

    public function storeData($data)
    {
        $this->ensureTable();
        return $this->db->insert('tab_topup_saldo', $data);
    }

    public function editData($id, $data)
    {
        $this->ensureTable();
        $this->db->where('id_topup', $id);
        return $this->db->update('tab_topup_saldo', $data);
    }

    public function deleteData($id)
    {
        $this->ensureTable();
        return $this->db->delete('tab_topup_saldo', ['id_topup' => $id]);
    }

    private function ensureTable()
    {
        if ($this->db->table_exists('tab_topup_saldo')) {
            return;
        }

        $this->load->dbforge();
        $this->dbforge->add_field([
            'id_topup' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'proses' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => false,
            ],
            'nominal' => [
                'type' => 'DOUBLE',
                'null' => false,
            ],
            'tgl_topup' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        $this->dbforge->add_key('id_topup', true);
        $this->dbforge->create_table('tab_topup_saldo', true);
    }
}
