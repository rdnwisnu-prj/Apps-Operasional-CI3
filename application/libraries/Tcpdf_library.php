<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load TCPDF library
require_once(APPPATH . '../vendor/tecnickcom/tcpdf/tcpdf.php');

class Tcpdf_library {

    public function __construct() {
        // Create instance of TCPDF
    }

    public function create_pdf() {
        // Create instance of TCPDF
        $pdf = new TCPDF();

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('TCPDF Example');
        $pdf->SetSubject('TCPDF and CodeIgniter');
        $pdf->SetKeywords('TCPDF, PDF, example, CodeIgniter');

        // Set default header data
        $pdf->SetHeaderData('', '', 'TCPDF Example', '');

        // Set header and footer fonts
        $pdf->setHeaderFont(Array('helvetica', '', 10));
        $pdf->setFooterFont(Array('helvetica', '', 8));

        // Set margins
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Add a page
        $pdf->AddPage();

        return $pdf;
    }
}