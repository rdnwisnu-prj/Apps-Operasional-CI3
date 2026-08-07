<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model 
{
    public function getUser($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('tab_user')->row_array();
    }

    public function getUserByIdentifier($identifier)
    {
        $this->db->group_start();
        $this->db->where('username', $identifier);
        $this->db->or_where('nik', $identifier);
        $this->db->group_end();
        return $this->db->get('tab_user')->row_array();
    }

    public function getUserForPasswordReset($identifier, $nik)
    {
        $this->db->where('nik', $nik);
        $this->db->group_start();
        $this->db->where('username', $identifier);
        $this->db->or_where('nik', $identifier);
        $this->db->group_end();
        return $this->db->get('tab_user')->row_array();
    }

    public function get_member_by_username_or_email($username)
    {
        $this->db->where('username_member', $username);
        $this->db->or_where('id_gakeslab', $username);
        return $this->db->get('tab_member')->row_array();
    }

    public function get_dinas_by_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('tab_user_dinas')->row_array();
    }

    public function resetPassword($id_user, $newPassword)
    {
        $data = [
            'password' => $newPassword
        ];
        $this->db->where('id_user', $id_user);
        return $this->db->update('tab_user', $data);
    }
}
