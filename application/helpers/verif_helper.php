<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_kesimpulan')) {
    function get_kesimpulan($hasil_periksa, $nilai_ranges, $jk_pasien) {
        if (empty($hasil_periksa) || empty($nilai_ranges)) {
            return '';
        }

        $ranges = explode('|', $nilai_ranges);
        
        foreach ($ranges as $range) {
            $parts = explode(';', $range);
            if (count($parts) < 3) continue;
            
            $result_nilai = $parts[0];
            $nilai_pria = $parts[1];
            $nilai_wanita = $parts[2];
            
            if (strpos($nilai_pria, '-') === false && strpos($nilai_wanita, '-') === false) {
                if ($jk_pasien == 'Pria') {
                    if (trim(strtolower($hasil_periksa)) == trim(strtolower($nilai_pria))) {
                        return $result_nilai;
                    }
                } else {
                    if (trim(strtolower($hasil_periksa)) == trim(strtolower($nilai_wanita))) {
                        return $result_nilai;
                    }
                }
            } else {
                $range_to_check = $jk_pasien == 'Pria' ? $nilai_pria : $nilai_wanita;
                $range_to_check = str_replace(' ', '', $range_to_check);
                if (is_numeric($hasil_periksa)) {
                    $hasil_periksa = (float)$hasil_periksa;
                    if (preg_match('/^([\d\.]+)-([\d\.]+)$/', $range_to_check, $matches)) {
                        $min = (float)$matches[1];
                        $max = (float)$matches[2];
                        
                        if ($hasil_periksa >= $min && $hasil_periksa <= $max) {
                            return $result_nilai;
                        }
                    } elseif (preg_match('/^([\d\.]+)\+$/', $range_to_check, $matches)) {
                        $min = (float)$matches[1];
                        if ($hasil_periksa >= $min) {
                            return $result_nilai;
                        }
                    } elseif (preg_match('/^<([\d\.]+)$/', $range_to_check, $matches)) {
                        $max = (float)$matches[1];
                        if ($hasil_periksa < $max) {
                            return $result_nilai;
                        }
                    }
                }
            }
        }
        
        return 'Tidak Diketahui';
    }
}