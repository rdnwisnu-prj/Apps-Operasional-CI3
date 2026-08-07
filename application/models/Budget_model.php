<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Budget_model extends CI_Model
{
    public function getData()
    {
        $this->ensureProsesColumn();
        $this->db->select('tab_budget.*, tab_project.nama_project');
        $this->db->from('tab_budget');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_budget.project', 'left');
        return $this->db->get()->result_array();
    }

    public function getBudgetById($id_budget)
    {
        $this->ensureProsesColumn();
        return $this->db->get_where('tab_budget', ['id_budget' => $id_budget])->row_array();
    }

    public function storeData($data) 
    {
        $this->ensureProsesColumn();
        $this->db->insert('tab_budget', $data);
    }

    public function editData($id_budget, $data)
    {
        $this->ensureProsesColumn();
        $this->db->where('id_budget', $id_budget);
        $this->db->update('tab_budget', $data);
    }
    

    public function deleteData($id_budget)
    {
        $this->db->delete('tab_budget', ['id_budget' => $id_budget]);
    }

    private function ensureProsesColumn()
    {
        if ($this->db->field_exists('proses', 'tab_budget')) {
            return;
        }

        $this->load->dbforge();
        $this->dbforge->add_column('tab_budget', [
            'proses' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
                'default' => '1',
                'after' => 'project',
            ],
        ]);
    }
}
