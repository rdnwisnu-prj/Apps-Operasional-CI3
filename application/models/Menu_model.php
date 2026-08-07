<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getData()
    {
        return $this->db->get('tab_menu')->result_array();
    }

    public function getMenu()
    {
        $this->db->select('id_menu, nama_menu');
        $query = $this->db->get('tab_menu');
        return $query->result_array();
    }

    public function getSubmenu($id_menu = null)
    {
        $this->db->select('tab_submenu.*, tab_menu.nama_menu');
        $this->db->from('tab_submenu');
        $this->db->join('tab_menu', 'tab_menu.id_menu = tab_submenu.menu_id', 'left');
        
        if ($id_menu) {
            $this->db->where('tab_submenu.menu_id', $id_menu);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getMenusById($id_menu)
    {
        return $this->db->get_where('tab_menu', ['id_menu' => $id_menu])->row_array();
    }

    public function getMenus($id_menu)
    {
        $this->db->select('tab_menu.*');
        $this->db->from('tab_menu');
        $this->db->join('tab_submenu', 'tab_menu.id_menu = tab_submenu.menu_id', 'left');
        $this->db->where('tab_menu.id_menu', $id_menu);
        return $this->db->get()->row_array();
    }

    public function getSubMenuById($id_submenu)
    {
        return $this->db->get_where('tab_menu_subs', ['id_submenu' => $id_submenu])->row_array();
    }

    public function getDetailSubmenu($id_submenu)
    {
        $this->db->where('id_submenu', $id_submenu);
        $query = $this->db->get('tab_submenu');
        return $query->row_array();
    }
    

    public function getMenuName($id_menu)
    {
        $this->db->select('nama_menu');
        $this->db->from('tab_menu');
        $this->db->where('id_menu', $id_menu);
        return $this->db->get()->row_array()['nama_menu'];
    }

    public function storeData($data) 
    {
        $this->db->insert('tab_menu', $data);
        return $this->db->insert_id();
    }

    public function editData($id, $data)
    {
        $this->db->where('id_menu', $id);
        $this->db->update('tab_menu', $data);
    }
    

    public function deleteData($id)
    {
        $this->db->delete('tab_submenu', ['menu_id' => $id]);
        $this->db->delete('tab_menu', ['id_menu' => $id]);
    }

    public function insertSubMenu($id_menu)
    {
        $data = [
            'menu_id'           => $id_menu,
            "nama_submenu"      => $this->input->post('nama_submenu', true),
            "url_submenu"       => $this->input->post('url_submenu', true),
            "segment_submenu"   => $this->input->post('segment_submenu', true),
            "order_submenu"     => $this->input->post('order_submenu', true),
        ];
        $this->db->insert('tab_submenu', $data);
    }
    
    
    public function updateSubMenu($id_submenu, $data)
    {
        $this->db->where('id_submenu', $id_submenu);
        return $this->db->update('tab_submenu', $data);
    }

    public function deleteSubMenu($id_submenu)
    {
        if (!$this->db->delete('tab_submenu', ['id_submenu' => $id_submenu])) {
            log_message('error', 'Gagal menghapus data nilai dengan id: ' . $id_submenu);
        }
    }
}