<?php
// Config
$config['base_url'] = 'http://localhost:8000/AppsLIS/people/index';

// style
$config['full_tag_open'] = '<div class="d-flex align-items-center justify-content-end flex-wrap gap-2 mt-24"><ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">' ;
$config['full_tag_close'] = '</ul></div>';

$config['first_link'] = '<iconify-icon icon="ep:d-arrow-left" class=""></iconify-icon>';
$config['first_tag_open'] = '<li class="page-item">';
$config['first_tag_close'] = '</li>';

$config['last_link'] = '<iconify-icon icon="ep:d-arrow-right" class=""></iconify-icon>';
$config['last_tag_open'] = '<li class="page-item">';
$config['last_tag_close'] = '</li>';

$config['next_link'] = 'Next';
$config['next_tag_open'] = '<li class="page-item">';
$config['next_tag_close'] = '</li>';

$config['prev_link'] = 'Prev';
$config['prev_tag_open'] = '<li class="page-item">';
$config['prev_tag_close'] = '</li>';

$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link fw-semibold rounded-circle border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md" href="#">';
$config['cur_tag_close'] = '</a></li>';

$config['num_tag_open'] = '<li class="page-item">';
$config['num_tag_close'] = '</li>';

$config['attributes'] = array('class' => 'page-link fw-semibold rounded-circle border-0 d-flex align-items-center justify-content-center h-32-px w-32-px text-md');