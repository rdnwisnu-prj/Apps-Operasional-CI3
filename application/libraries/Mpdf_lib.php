<?php
use Mpdf\Mpdf;

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpdf_lib {
    protected $mpdf;

    public function __construct() {
        require_once APPPATH.'third_party/mpdf/vendor/autoload.php'; // Pastikan path ini sesuai dengan tempat autoload.php Anda berada
        $this->mpdf = new Mpdf();
    }

    public function get_instance() {
        return $this->mpdf;
    }
}