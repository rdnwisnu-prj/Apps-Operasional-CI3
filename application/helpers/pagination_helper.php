// application/helpers/pagination_helper.php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('initialize_pagination')) {
    function initialize_pagination($base_url, $total_rows, $per_page, $uri_segment = 3) {
        $CI =& get_instance();
        $CI->load->library('pagination');
        $CI->load->config('pagination');

        $config = array();
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;

        foreach ($CI->config->item('pagination') as $key => $value) {
            $config[$key] = $value;
        }

        $CI->pagination->initialize($config);
    }
}