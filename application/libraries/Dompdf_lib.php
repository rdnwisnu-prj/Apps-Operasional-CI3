<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Dompdf_lib {

    private $dompdf;

    public function __construct() {
        // Autoloading libraries
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        $this->dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $this->dompdf->setOptions($options);
    }

    public function loadHtml($html) {
        $this->dompdf->loadHtml($html);
    }

    public function setPaper($size, $orientation = 'portrait') {
        $this->dompdf->setPaper($size, $orientation);
    }

    public function render() {
        $this->dompdf->render();
    }

    public function output() {
        return $this->dompdf->output();
    }

    public function stream($filename = "document.pdf", $options = array()) {
        $this->dompdf->stream($filename, $options);
    }

    public function set_paper($size = 'A4', $orientation = 'portrait') {
        if ($size == 'A8') {
            // Ukuran kertas A8 dalam milimeter
            $width = 52;   // 52 mm
            $height = 74;  // 74 mm
        } else {
            // Ukuran kertas lainnya seperti A4
            $this->dompdf->setPaper($size, $orientation);
            return;
        }
    
        $this->dompdf->setPaper(array(0, 0, $width, $height), $orientation);
    }
}