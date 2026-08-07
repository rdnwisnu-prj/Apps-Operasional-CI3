<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Pagination extends CI_Pagination {
    
    public function __construct() {
        parent::__construct();
        
        // Config
        $config['full_tag_open']    = '<div class="demo-inline-spacing d-flex align-items-center justify-content-end flex-wrap gap-2 mt-24"><nav aria-label="Page navigation"><ul class="pagination pagination-primary">';
        $config['full_tag_close']   = '</div></ul></nav>';

        $config['first_link']       = '<i class="ti ti-chevrons-left ti-sm"></i>';
        $config['first_tag_open']   = '<li class="page-item first"><a href="javascript:void(0);">';
        $config['first_tag_close']  = '</a></li>';

        $config['last_link']        = '<i class="ti ti-chevrons-right ti-sm"></i>';
        $config['last_tag_open']    = '<li class="page-item last"><a href="javascript:void(0);">';
        $config['last_tag_close']   = '</a></li>';

        $config['next_link']        = '<i class="ti ti-chevron-right ti-sm"></i>';
        $config['next_tag_open']    = '<li class="page-item next"><a href="javascript:void(0);">';
        $config['next_tag_close']   = '</a></li>';

        $config['prev_link']        = '<i class="ti ti-chevron-left ti-sm"></i>';
        $config['prev_tag_open']    = '<li class="page-item prev"><a href="javascript:void(0);">';
        $config['prev_tag_close']   = '</a></li>';

        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="javascript:void(0);">';
        $config['cur_tag_close']    = '</a></li>';

        $config['num_tag_open']     = '<li class="page-item"><a href="javascript:void(0);">';
        $config['num_tag_close']    = '</a></li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->initialize($config);
    }

    public function create_links() {
        // Add the base_url dynamically
        if (empty($this->base_url)) {
            $CI =& get_instance();
            $this->base_url = current_url();
        }
        return parent::create_links();
    }
}