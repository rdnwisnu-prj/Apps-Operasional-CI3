<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('logged_in')) {
        redirect('auth');
    }
}

function check_role_access()
{
    $ci = get_instance();
    $role_id = $ci->session->userdata('role_id');
    $current_controller = $ci->router->class;
    if ($role_id == 3 && $current_controller == 'Dashboard') {
        redirect('Profile');
    }
}

function check_menu_access($menu_id)
{
    $ci = get_instance();
    $role_id = $ci->session->userdata('role_id');
    
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_access', $menu_id);
    $ci->db->where('access', 1);
    $query = $ci->db->get('tab_access');
    
    return $query->num_rows() > 0;
}

function check_submenu_access($menu_id, $submenu_id)
{
    $ci = get_instance();
    $role_id = $ci->session->userdata('role_id');
    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_access', $menu_id);
    $ci->db->like('submenu_access', $submenu_id);
    $ci->db->where('access', 1);
    $query = $ci->db->get('tab_access');
    
    return $query->num_rows() > 0;
}