<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Client_api extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Client_model', 'client');
    }

    /**
     * GET /Api/Client_api
     * Get all clients with marketing name
     */
    public function index_get()
    {
        $this->db->select('tab_client.id_client, tab_client.nama_client, tab_client.alamat_client, 
                           tab_client.nama_pic, tab_client.tlp_pic, tab_client.email_pic,
                           tab_client.sektor, tab_client.status, tab_client.user_id,
                           tab_user.nama as marketing_name,
                           tab_client.updated_at');
        $this->db->from('tab_client');
        $this->db->join('tab_user', 'tab_user.id_user = tab_client.user_id', 'left');
        $this->db->order_by('tab_client.id_client', 'DESC');

        $data = $this->db->get()->result_array();

        $this->response([
            'status'  => true,
            'message' => 'Data client berhasil diambil',
            'data'    => $data
        ], 200);
    }

    /**
     * GET /Api/Client_api/detail/{id}
     * Get single client by ID
     */
    public function detail_get($id = null)
    {
        if ($id === null) {
            $this->response([
                'status'  => false,
                'message' => 'ID client tidak ditemukan'
            ], 400);
            return;
        }

        $this->db->select('tab_client.id_client, tab_client.nama_client, tab_client.alamat_client, 
                           tab_client.nama_pic, tab_client.tlp_pic, tab_client.email_pic,
                           tab_client.sektor, tab_client.status, tab_client.user_id,
                           tab_user.nama as marketing_name,
                           tab_client.updated_at');
        $this->db->from('tab_client');
        $this->db->join('tab_user', 'tab_user.id_user = tab_client.user_id', 'left');
        $this->db->where('tab_client.id_client', $id);

        $data = $this->db->get()->row_array();

        if ($data) {
            $this->response([
                'status'  => true,
                'message' => 'Detail client berhasil diambil',
                'data'    => $data
            ], 200);
        } else {
            $this->response([
                'status'  => false,
                'message' => 'Client tidak ditemukan'
            ], 404);
        }
    }

    /**
     * GET /Api/Client_api/search?q=keyword
     * Search client by name
     */
    public function search_get()
    {
        $keyword = $this->get('q');

        if (empty($keyword)) {
            $this->response([
                'status'  => false,
                'message' => 'Keyword pencarian tidak boleh kosong'
            ], 400);
            return;
        }

        $this->db->select('tab_client.id_client, tab_client.nama_client, tab_client.alamat_client, 
                           tab_client.nama_pic, tab_client.tlp_pic, tab_client.email_pic,
                           tab_client.user_id, tab_user.nama as marketing_name');
        $this->db->from('tab_client');
        $this->db->join('tab_user', 'tab_user.id_user = tab_client.user_id', 'left');
        $this->db->like('tab_client.nama_client', $keyword);
        $this->db->order_by('tab_client.nama_client', 'ASC');

        $data = $this->db->get()->result_array();

        $this->response([
            'status'  => true,
            'message' => 'Hasil pencarian client',
            'data'    => $data
        ], 200);
    }

    /**
     * GET /Api/Client_api/marketing
     * Get marketing users used by Apps Operasional.
     */
    public function marketing_get()
    {
        $this->db->select('id_user, nama, role_id');
        $this->db->from('tab_user');
        $this->db->where_in('role_id', [5, 6, 8, 9]);
        $this->db->order_by('nama', 'ASC');

        $data = $this->db->get()->result_array();

        $this->response([
            'status'  => true,
            'message' => 'Data marketing berhasil diambil',
            'data'    => $data
        ], 200);
    }
}