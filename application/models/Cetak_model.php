<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cetak_model extends CI_Model
{
    public function get_inspeksi_data_by_date($tgl_inspeksi) 
    {
        $this->db->where('tgl_inspeksi', $tgl_inspeksi);
        $form = $this->db->get('tab_form')->row_array();

        if (empty($form)) {
            return false;
        }

        $form_id = $form['id_form'];
        $this->db->select('
            ti.kondisi,
            ti.keterangan,
            tk.nama_kategori_inspeksi AS kategori_nama,
            tei.nama_item AS item_nama
        ');
        $this->db->from('tab_inspeksi ti');
        $this->db->join('tab_kategori_inspeksi tk', 'ti.kategori = tk.id_kategori_inspeksi');
        $this->db->join('tab_item_inspeksi tei', 'ti.item = tei.id_item');
        $this->db->where('ti.form_id', $form_id);
        $this->db->order_by('tk.id_kategori_inspeksi', 'ASC');
        $this->db->order_by('tei.id_item', 'ASC');
        $inspeksi_items = $this->db->get()->result_array();
        $grouped_inspeksi = [];
        foreach ($inspeksi_items as $item) {
            $grouped_inspeksi[$item['kategori_nama']][] = $item;
        }

        $this->db->where('form_id', $form_id);
        $saran = $this->db->get('tab_saran')->result_array();

        $data = [
            'form' => $form,
            'inspeksi' => $grouped_inspeksi,
            'saran' => $saran
        ];

        return $data;
    }
}