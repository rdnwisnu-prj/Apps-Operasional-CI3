<?php defined('BASEPATH') OR exit('No direct script access allowed');

use mikehaertl\wkhtmlto\Pdf;

class Pdf_lib {

    protected $pdf;

    public function __construct() {
        $this->pdf = new Pdf();
    }

    public function create_pdf($html, $outputPath = null) 
    {
        $this->pdf->addPage($html);
    
        if ($outputPath) {
            if (!$this->pdf->saveAs($outputPath)) {
                echo 'Error: ' . $this->pdf->getError();
            } else {
                echo 'PDF saved to ' . $outputPath;
            }
        } else {
            if (!$this->pdf->send()) {
                echo 'Error: ' . $this->pdf->getError();
            } else {
                echo 'PDF sent to browser.';
            }
        }
    }
    
}