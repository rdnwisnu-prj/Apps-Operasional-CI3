<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Picqer\Barcode\BarcodeGeneratorHTML;

class BarcodeLibrary {

    // Fungsi untuk menghasilkan Barcode Batang
    public function generateBarcode($code) {
        $generator = new BarcodeGeneratorHTML();
        return $generator->getBarcode($code, $generator::TYPE_CODE_128);
    }

    // Fungsi untuk menghasilkan QR Code
    public function generateQrCode($text) {
        $qrCode = new QrCode($text);
        return $qrCode->writeDataUri();
    }
}