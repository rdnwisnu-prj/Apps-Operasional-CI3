<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();        
        $this->load->model('Role_model', 'role');
        $this->load->library('form_validation');
		is_logged_in();
        check_role_access();
	}
	
	public function index()
	{
        $data = [
            'title'     => 'Operational Cakra Application | Role & Access',
            'header'    => 'Pengaturan',
            'subheader' => 'Role & Access',
            'roles'     => $this->role->getData(),
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/role', $data);
		$this->load->view('templates/footer');
	}

    public function store()
    {
        $this->form_validation->set_rules('nama_role', 'Nama Role', 'required');

        if ($this->form_validation->run() == FALSE) {

            $response = [
                'status' => 'error',
                'message' => validation_errors()
            ];
            echo json_encode($response);
            return;
            
        } else {
            $data = [
                'nama_role' => $this->input->post('nama_role', TRUE)
            ];
            
            $this->role->storeData($data);
            
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan'
            ];
            echo json_encode($response);
            return;
        }
    }

    public function update()
    {
        $id_role = $this->input->post('id_role');

        $this->form_validation->set_rules('nama_role', 'Nama Role', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            
        } else {
            $data = [
                'nama_role' => $this->input->post('nama_role', TRUE)
            ];
            
            $this->role->updateData($id_role, $data);
            $this->session->set_flashdata('flash', 'Diperbarui');
        }
        redirect('Setting/Role');
    }

    public function getRoleById($id_role)
    {
        echo json_encode($this->role->getRoleById($id_role));
    }

    public function destroy($id_role)
    {
        $this->role->deleteData($id_role);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Setting/Role');
    }

    public function getMenuAccess($role_id)
    {
        $menus = $this->db->get('tab_menu')->result_array();
        $access_data = [];
        
        foreach ($menus as $menu) {
            $this->db->where('menu_id', $menu['id_menu']);
            $submenus = $this->db->get('tab_submenu')->result_array();
            
            $menu_item = [
                'menu_id'       => $menu['id_menu'],
                'menu_header'   => $menu['header'],
                'menu_name'     => $menu['nama_menu'],
                'submenus'      => []
            ];
            
            if (!empty($submenus)) {
                foreach ($submenus as $submenu) {
                    $this->db->where('role_id', $role_id);
                    $this->db->where('submenu_access', $submenu['id_submenu']);
                    $this->db->where('access', 1);
                    $access = $this->db->get('tab_access')->row_array();
                    
                    $menu_item['submenus'][] = [
                        'submenu_id' => $submenu['id_submenu'],
                        'submenu_name' => $submenu['nama_submenu'],
                        'has_access' => !empty($access)
                    ];
                }
            } else {
                $this->db->where('role_id', $role_id);
                $this->db->where('menu_access', $menu['id_menu']);
                $this->db->where('submenu_access', 0);
                $this->db->where('access', 1);
                $access = $this->db->get('tab_access')->row_array();
                
                $menu_item['has_access'] = !empty($access);
            }
            
            $access_data[] = $menu_item;
        }
        
        echo json_encode($access_data);
    }

    public function saveAccess()
    {
        $role_id = $this->input->post('role_id');
        $access_data = $this->input->post('access_data');

        $this->db->where('role_id', $role_id);
        $this->db->delete('tab_access');
        
        foreach ($access_data as $access) {
            $data = [
                'role_id' => $role_id,
                'menu_access' => $access['menu_id'],
                'submenu_access' => !empty($access['submenu_id']) ? $access['submenu_id'] : 0,
                'access' => 1
            ];
            
            $this->db->insert('tab_access', $data);
        }

        $response = [
            'status' => 'success',
            'message' => 'Berhasil Update Access'
        ];
        echo json_encode($response);
    }
	
}
