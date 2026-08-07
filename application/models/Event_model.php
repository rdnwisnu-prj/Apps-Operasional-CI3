<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model
{
    private $table = 'tab_events';

    public function getData()
    {
        $this->db->select('tab_events.*, tab_user.nama as created_by_name');
        $this->db->from($this->table);
        $this->db->join('tab_user', 'tab_user.id_user = tab_events.user_id', 'left');
        $this->db->order_by('tab_events.tgl_mulai', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getDataByUser($user_id)
    {
        $this->db->select('tab_events.*, tab_user.nama as created_by_name');
        $this->db->from($this->table);
        $this->db->join('tab_user', 'tab_user.id_user = tab_events.user_id', 'left');
        $this->db->where('tab_events.user_id', $user_id);
        $this->db->order_by('tab_events.tgl_mulai', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getTeamBySpv($id_user)
    {
        $this->db->where('id_spv', $id_user);
        $result = $this->db->get('tab_team')->result_array();
        return !empty($result) ? $result : null;
    }

    public function getDataBySpv($id_spv, $teams)
    {
        // Get all team_ids supervised by SPV
        $team_ids = array_column($teams, 'id_team');
        
        // Get all staff_ids from team members
        $this->db->select('staff_id');
        $this->db->from('tab_anggota_team');
        $this->db->where_in('team_id', $team_ids);
        $anggota = $this->db->get()->result_array();
        
        // Collect all user_ids (team members + SPV)
        $user_ids = array_column($anggota, 'staff_id');
        $user_ids[] = $id_spv; // Add SPV's own id
        $user_ids = array_unique($user_ids); // Remove duplicates
        
        // Query events based on user_ids
        $this->db->select('tab_events.*, tab_user.nama as created_by_name');
        $this->db->from($this->table);
        $this->db->join('tab_user', 'tab_user.id_user = tab_events.user_id', 'left');
        $this->db->where_in('tab_events.user_id', $user_ids);
        $this->db->order_by('tab_events.tgl_mulai', 'DESC');
        
        return $this->db->get()->result_array();
    }

    public function getEventById($id_event)
    {
        $this->db->select('tab_events.*, tab_user.nama as created_by_name');
        $this->db->from($this->table);
        $this->db->join('tab_user', 'tab_user.id_user = tab_events.user_id', 'left');
        $this->db->where('tab_events.id_event', $id_event);
        return $this->db->get()->row_array();
    }

    public function getUpcomingEvents($limit = 5, $user_id = null)
    {
        $this->db->from($this->table);
        $this->db->where('tgl_selesai >=', date('Y-m-d'));
        
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        
        $this->db->order_by('tgl_mulai', 'ASC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function storeData($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function updateData($id_event, $data)
    {
        $this->db->where('id_event', $id_event);
        return $this->db->update($this->table, $data);
    }

    public function deleteData($id_event)
    {
        return $this->db->delete($this->table, ['id_event' => $id_event]);
    }

    public function getEventsByDateRange($start_date, $end_date, $user_id = null)
    {
        $this->db->from($this->table);
        $this->db->where('tgl_mulai >=', $start_date);
        $this->db->where('tgl_selesai <=', $end_date);
        
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        
        $this->db->order_by('tgl_mulai', 'ASC');
        return $this->db->get()->result_array();
    }
}