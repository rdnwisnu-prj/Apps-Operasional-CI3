<?php
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

defined('BASEPATH') OR exit('No direct script access allowed');

class Mpdf_lib {
    protected $mpdf;
    protected $html = '';
    protected $paper = 'A4';
    protected $orientation = 'portrait';

    public function __construct() {
        $autoload = FCPATH . 'vendor/autoload.php';
        if (!is_file($autoload)) {
            $autoload = APPPATH . 'third_party/mpdf/vendor/autoload.php';
        }

        require_once $autoload;
        $this->mpdf = $this->makeMpdf();
    }

    public function get_instance() {
        return $this->mpdf;
    }

    public function loadHtml($html) {
        $this->html = (string) $html;
    }

    public function setPaper($size = 'A4', $orientation = 'portrait') {
        $this->paper = $size;
        $this->orientation = $orientation;
        $this->mpdf = $this->makeMpdf();
    }

    public function render() {
        $this->mpdf->WriteHTML($this->html);
    }

    public function output() {
        return $this->mpdf->Output('', Destination::STRING_RETURN);
    }

    public function stream($filename = 'document.pdf', $options = array()) {
        $download = isset($options['Attachment']) ? (bool) $options['Attachment'] : true;
        $this->mpdf->Output($filename, $download ? Destination::DOWNLOAD : Destination::INLINE);
    }

    public function set_paper($size = 'A4', $orientation = 'portrait') {
        $this->setPaper($size, $orientation);
    }

    private function makeMpdf() {
        $format = $this->paper;
        if (is_string($format) && strtolower($this->orientation) === 'landscape') {
            $format .= '-L';
        }

        return new Mpdf([
            'mode' => 'utf-8',
            'format' => $format,
            'default_font' => 'helvetica',
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'tempDir' => APPPATH . 'cache',
        ]);
    }
}
