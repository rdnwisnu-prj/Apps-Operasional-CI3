<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transport_model extends CI_Model
{
    public function getData()
    {
        $this->ensureTransportColumns();
        $this->db->select('tab_transport.*, tab_project.nama_project, u.nama as created_by');
        $this->db->from('tab_transport');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_transport.project', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_transport.korlap', 'left');
        $this->db->order_by('tab_transport.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getById($id)
    {
        $this->ensureTransportColumns();
        return $this->db->get_where('tab_transport', ['id_transport' => $id])->row_array();
    }

    public function getProjects()
    {
        $this->db->select('tab_project.kode_project, tab_project.nama_project, tab_project.tgl_mulai, tab_project.tgl_selesai');
        $this->db->from('tab_project');
        $this->applyKorlapProjectFilter();
        $this->db->order_by('tab_project.nama_project', 'ASC');
        return $this->db->get()->result_array();
    }

    public function canUseProject($kode_project)
    {
        $this->db->from('tab_project');
        $this->db->where('tab_project.kode_project', $kode_project);
        $this->applyKorlapProjectFilter();
        return (bool) $this->db->get()->row_array();
    }

    public function storeData($data)
    {
        $this->ensureTransportColumns();
        return $this->db->insert('tab_transport', $data);
    }

    public function editData($id, $data)
    {
        $this->ensureTransportColumns();
        $this->db->where('id_transport', $id);
        return $this->db->update('tab_transport', $data);
    }

    public function deleteData($id)
    {
        return $this->db->delete('tab_transport', ['id_transport' => $id]);
    }

    private function ensureTransportColumns()
    {
        $this->load->dbforge();

        if (!$this->db->field_exists('jenis_pengeluaran', 'tab_transport')) {
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

        if (!$this->db->field_exists('nominal', 'tab_transport')) {
            $this->dbforge->add_column('tab_transport', [
                'nominal' => [
                    'type'       => 'DOUBLE',
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'tgl_transport',
                ],
            ]);
        }
    }

    private function applyKorlapProjectFilter()
    {
        if ((int) $this->session->userdata('role_id') !== 8) {
            return;
        }

        $this->db->join('tab_project_korlap k', 'k.kode_project = tab_project.kode_project', 'inner');
        $this->db->where('k.user_id', (int) $this->session->userdata('id_user'));
        $this->db->distinct();
    }
}
