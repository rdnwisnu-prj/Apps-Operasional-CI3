<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Menu_model','menu');
        $this->load->library('form_validation');
		is_logged_in();
	}
	
	public function index()
	{
        $data = [
            'title'     => 'Operational Cakra Application | Setting Menu',
            'header'    => 'Pengaturan',
            'subheader' => 'Menu',
            'menus'     => $this->menu->getData(),
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/menu', $data);
		$this->load->view('templates/footer');
	}

    public function create() 
    {
        $this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required');
        $this->form_validation->set_rules('icon_menu', 'Icon Menu', 'required');
        $this->form_validation->set_rules('order_menu', 'Urutan', 'required|numeric'); 
       
        if ($this->form_validation->run() == FALSE) {
    
            $data = [
                'title'     => 'Operational Cakra Application | Setting Menu',
                'header'    => 'Pengaturan',
                'subheader' => 'Menu',
                'menus'     => $this->menu->getData(),
                'errors'    => validation_errors()
            ];
 
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/menu', $data);
            $this->load->view('templates/footer');
 
        } else {
    
            $data = [
                "header"        => $this->input->post('header', true),
                "nama_menu"     => $this->input->post('nama_menu', true),
                "icon_menu"     => $this->input->post('icon_menu', true),
                "url_menu"      => $this->input->post('url_menu', true),
                "segment_menu"  => $this->input->post('segment_menu', true),
                "order_menu"    => $this->input->post('order_menu', true),
                "is_dropdown"   => $this->input->post('is_dropdown', true),
            ];
    
            $this->menu->storeData($data);
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('Setting/Menu');
            
        }
    }

    public function edit($id_menu)
    {
        $edit_data = $this->menu->getMenusById($id_menu);
        
        $data = [
            'title'     => 'Operational Cakra Application | Setting Menu',
            'header'    => 'Pengaturan',
            'subheader' => 'Menu',
            'menus'     => $this->menu->getData(),
            'edit_data' => $edit_data
        ];
        
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar');
		$this->load->view('setting/menu', $data);
		$this->load->view('templates/footer');
    }

    public function update() 
    {
        $id_menu = $this->input->post('id_menu');
    
        $this->form_validation->set_rules('nama_menu', 'Nama Menu', 'required');
        $this->form_validation->set_rules('icon_menu', 'Icon Menu', 'required');
        $this->form_validation->set_rules('order_menu', 'Urutan', 'required|numeric'); 
    
        if ($this->form_validation->run() == FALSE) {
    
            $edit_data = $this->menu->getMenusById($id_menu);
    
            $data = [
                'title'     => 'Operational Cakra Application | Setting Menu',
                'header'    => 'Pengaturan',
                'subheader' => 'Menu',
                'menus'     => $this->menu->getData(),
                'edit_data' => $edit_data,
                'errors'    => validation_errors()
            ];
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/menu', $data);
            $this->load->view('templates/footer');
    
        } else {
    
            $data = [
                "header"        => $this->input->post('header', true),
                "nama_menu"     => $this->input->post('nama_menu', true),
                "icon_menu"     => $this->input->post('icon_menu', true),
                "url_menu"      => $this->input->post('url_menu', true),
                "segment_menu"  => $this->input->post('segment_menu', true),
                "order_menu"    => $this->input->post('order_menu', true),
                "is_dropdown"   => $this->input->post('is_dropdown', true),
            ];
    
            $this->menu->editData($id_menu, $data);
            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect('Setting/Menu');
            
        }
    }

    public function destroy($id)
    {
        $this->menu->deleteData($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Setting/Menu');
    }
	
    public function Submenu($id_menu)
    {
        $data = [
            'title'     => 'Operational Cakra Application | Setting Sub Menu',
            'header'    => 'Pengaturan',
            'subheader' => 'Sub Menu',
            'menu'      => $this->menu->getMenus($id_menu),
            'submenu'   => $this->menu->getSubmenu($id_menu),
        ];

        if (!$data['menu']) {
            show_404();
        }

        $data['id_menu'] = $id_menu;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('setting/submenu', $data);
        $this->load->view('templates/footer');
    }
    
    public function StoreSubmenu($id_menu)
    {
        $this->form_validation->set_rules('nama_submenu', 'Nama Sub Menu', 'required');
        $this->form_validation->set_rules('url_submenu', 'Url Sub Menu', 'required');
        $this->form_validation->set_rules('segment_submenu', 'Url Segment Sub Menu', 'required');
        $this->form_validation->set_rules('order_submenu', 'Urutan Sub Menu', 'required');    
        
        if ($this->form_validation->run() == FALSE) {
            
            $data = [
                'title'     => 'Operational Cakra Application | Setting Sub Menu',
                'header'    => 'Pengaturan',
                'subheader' => 'Sub Menu',
                'menu'      => $this->menu->getMenus($id_menu),
                'submenu'   => $this->menu->getSubmenu($id_menu)
            ];
            
            if (!$data['menu']) {
                show_404();
            }
    
            $data['id_menu'] = $id_menu;
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/submenu', $data);
            $this->load->view('templates/footer');
            
        } else {  
            
            $this->menu->insertSubMenu($id_menu); 
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect(base_url('Setting/Menu/Submenu/' . $id_menu));
            
        }
    }

    public function EditSubmenu($id_menu, $id_submenu)
    {
        $edit_data = $this->menu->getDetailSubmenu($id_submenu);

        $data = [
            'title'     => 'Operational Cakra Application | Setting Sub Menu',
            'header'    => 'Pengaturan',
            'subheader' => 'Sub Menu',
            'menu'      => $this->menu->getMenus($id_menu),
            'submenu'   => $this->menu->getSubmenu($id_menu),
            'edit_data'     => $edit_data,
        ];
        
        if (!$data['menu']) {
            show_404();
        }

        $data['id_menu'] = $id_menu;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('setting/submenu', $data);
        $this->load->view('templates/footer');
    }

    public function UpdateSubmenu($id_menu)
    {
        $id_submenu = $this->input->post('id_submenu');

        $this->form_validation->set_rules('nama_submenu', 'Nama Sub Menu', 'required');
        $this->form_validation->set_rules('url_submenu', 'Url Sub Menu', 'required');
        $this->form_validation->set_rules('segment_submenu', 'Url Segment Sub Menu', 'required');
        $this->form_validation->set_rules('order_submenu', 'Urutan Sub Menu', 'required');    
        
        if ($this->form_validation->run() == FALSE) {

            $edit_data = $this->menu->getDetailSubmenu($id_submenu);
            
            $data = [
                'title'     => 'Operational Cakra Application | Setting Sub Menu',
                'header'    => 'Pengaturan',
                'subheader' => 'Sub Menu',
                'menu'      => $this->menu->getMenus($id_menu),
                'submenu'   => $this->menu->getSubmenu($id_menu),
                'edit_data' => $edit_data,
                'errors'    => validation_errors()
            ];
            
            if (!$data['menu']) {
                show_404();
            }
    
            $data['id_menu'] = $id_menu;
    
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('setting/submenu', $data);
            $this->load->view('templates/footer');
            
        } else {
            
            $data = [
                "nama_submenu"      => $this->input->post('nama_submenu', true),
                "url_submenu"       => $this->input->post('url_submenu', true),
                "segment_submenu"   => $this->input->post('segment_submenu', true),
                "order_submenu"     => $this->input->post('order_submenu', true),
            ];
            
            $this->menu->updateSubMenu($id_submenu, $data); 
            $this->session->set_flashdata('flash', 'Diperbarui');
            redirect(base_url('Setting/Menu/Submenu/' . $id_menu));
        }
    }

    public function DeleteSubmenu($id_menu, $id_submenu)
    {
        if (!$id_menu || !$id_submenu) {
            show_404();
            return;
        }
        
        $this->menu->deleteSubMenu($id_submenu);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect(base_url('Setting/Menu/Submenu/' . $id_menu));
    }
}