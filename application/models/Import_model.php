<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import_model extends CI_Model
{
	public function getExistingClients()
    {
        return $this->db->select('LOWER(nama_client) as nama_client')
                       ->from('tab_client')
                       ->get()
                       ->result_array();
    }

    public function getExistingLeads($periode_bulan = null, $periode_tahun = null)
    {
        $this->db->select('LOWER(nama_client) as nama_client')
                 ->from('tab_leads');
        if ($periode_bulan !== null && $periode_tahun !== null) {
            $this->db->where('periode_bulan', $periode_bulan);
            $this->db->where('periode_tahun', $periode_tahun);
        }
        return $this->db->get()->result_array();
    }

    public function importClientsAndProjects($clients, $projects)
    {
        $this->db->trans_start();
        $this->db->insert_batch('tab_client', $clients);

        $client_names = array_column($clients, 'nama_client');
        $this->db->select('id_client, nama_client');
        $this->db->where_in('nama_client', $client_names);
        $inserted_clients_result = $this->db->get('tab_client')->result_array();
        
        $inserted_clients = [];
        foreach ($inserted_clients_result as $client) {
            $inserted_clients[$client['nama_client']] = $client['id_client'];
        }

        $projects_with_client_id = [];
        foreach ($projects as $project) {
            if (isset($inserted_clients[$project['nama_client']])) {
                $project_data = [
                    'client_id' => $inserted_clients[$project['nama_client']],
                    'nama_project' => $project['nama_project'],
                    'service' => $project['service'],
                    'tgl_pelaksanaan' => $project['tgl_pelaksanaan'],
                    'tgl_selesai' => $project['tgl_selesai'],
                    'jumlah_karyawan' => $project['jumlah_karyawan'],
                    'estimasi' => $project['estimasi'],
                    'status_project' => $project['status_project'],
                    'deskripsi' => $project['deskripsi'],
                    'user_id' => $project['user_id'],
                    'periode_bulan' => isset($project['periode_bulan']) ? $project['periode_bulan'] : intval(date('m')),
                    'periode_tahun' => isset($project['periode_tahun']) ? $project['periode_tahun'] : intval(date('Y')),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $projects_with_client_id[] = $project_data;
            }
        }
        
        if (!empty($projects_with_client_id)) {
            $this->db->insert_batch('tab_project', $projects_with_client_id);
        }
        
        $this->db->trans_complete();;
        
        return $this->db->trans_status();
    }

    public function importClientsAndProjectsAlternative($clients, $projects)
    {
        try {
            $this->db->trans_begin();
            
            $success_count = 0;
            
            foreach ($clients as $index => $client) {

                $this->db->insert('tab_client', $client);
                $client_id = $this->db->insert_id();
                
                if ($client_id) {

                    $project = $projects[$index];
                    $project_data = [
                        'client_id'         => $client_id,
                        'nama_project'      => $project['nama_project'],
                        'service'     => $project['service'],
                        'tgl_pelaksanaan'   => $project['tgl_pelaksanaan'],
                        'tgl_selesai'       => $project['tgl_selesai'],
                        'jumlah_karyawan'   => $project['jumlah_karyawan'],
                        'estimasi'          => $project['estimasi'],
                        'status_project'    => $project['status_project'],
                        'deskripsi'         => $project['deskripsi'],
                        'user_id'           => $project['user_id'],
                        'periode_bulan'     => isset($project['periode_bulan']) ? $project['periode_bulan'] : intval(date('m')),
                        'periode_tahun'     => isset($project['periode_tahun']) ? $project['periode_tahun'] : intval(date('Y')),
                        'updated_at'        => date('Y-m-d H:i:s')
                    ];
                    
                    $this->db->insert('tab_project', $project_data);
                    $success_count++;
                }
            }
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return $success_count;
            }
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;
        }
    }
}