<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project_model extends CI_Model
{
    public function getData()
    {
        $this->db->select('tab_project.*, tab_perusahaan.nama_perusahaan, tab_site.nama_site, u.nama as created_by');
        $this->db->from('tab_project');
        $this->db->join('tab_perusahaan', 'tab_perusahaan.id_perusahaan = tab_project.perusahaan_id', 'left');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_project.user_id', 'left');
        $this->db->order_by('tab_project.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getDataForKorlap($user_id)
    {
        $this->db->distinct();
        $this->db->select('tab_project.*, tab_perusahaan.nama_perusahaan, tab_site.nama_site, u.nama as created_by');
        $this->db->from('tab_project');
        $this->db->join('tab_perusahaan', 'tab_perusahaan.id_perusahaan = tab_project.perusahaan_id', 'left');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_project.user_id', 'left');
        $this->db->join('tab_project_korlap k', 'k.kode_project = tab_project.kode_project', 'left');
        $this->db->group_start();
        $this->db->where('tab_project.user_id', $user_id);
        $this->db->or_where('k.user_id', $user_id);
        $this->db->group_end();
        $this->db->order_by('tab_project.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getProjectDetail($kode_project)
    {
        $this->db->select('tab_project.*, tab_perusahaan.nama_perusahaan, tab_perusahaan.no_tlp, tab_perusahaan.email, tab_perusahaan.alamat_perusahaan, tab_perusahaan.nama_pic, tab_perusahaan.tlp_pic, tab_site.nama_site, tab_site.provinsi, tab_site.kota, tab_site.keterangan as site_keterangan, tab_provinsi.nama_provinsi, tab_kota.nama_kota, u.nama as created_by');
        $this->db->from('tab_project');
        $this->db->join('tab_perusahaan', 'tab_perusahaan.id_perusahaan = tab_project.perusahaan_id', 'left');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        $this->db->join('tab_provinsi', 'tab_provinsi.id_provinsi = tab_site.provinsi', 'left');
        $this->db->join('tab_kota', 'tab_kota.id_kota = tab_site.kota', 'left');
        $this->db->join('tab_user u', 'u.id_user = tab_project.user_id', 'left');
        $this->db->where('tab_project.kode_project', $kode_project);
        return $this->db->get()->row_array();
    }

    public function getProjectById($kode_project)
    {
        return $this->db->get_where('tab_project', ['kode_project' => $kode_project])->row_array();
    }

    public function canKorlapAccessProject($kode_project, $user_id)
    {
        $this->db->from('tab_project');
        $this->db->join('tab_project_korlap k', 'k.kode_project = tab_project.kode_project', 'left');
        $this->db->where('tab_project.kode_project', $kode_project);
        $this->db->group_start();
        $this->db->where('tab_project.user_id', $user_id);
        $this->db->or_where('k.user_id', $user_id);
        $this->db->group_end();
        return $this->db->count_all_results() > 0;
    }

    public function generateKode()
    {
        $prefix = 'PRJ';
        $year   = date('Y');
        $month  = date('m');
        $like   = $prefix . $year . $month;

        $this->db->select('kode_project');
        $this->db->from('tab_project');
        $this->db->like('kode_project', $like, 'after');
        $this->db->order_by('kode_project', 'DESC');
        $this->db->limit(1);
        $last = $this->db->get()->row_array();

        if ($last) {
            $lastNum = (int) substr($last['kode_project'], -3);
            $newNum  = $lastNum + 1;
        } else {
            $newNum = 1;
        }

        return $like . str_pad($newNum, 3, '0', STR_PAD_LEFT);
    }

    public function storeData($data) 
    {
        return $this->db->insert('tab_project', $data);
    }
    
    public function editData($kode_project, $data)
    {
        $this->db->where('kode_project', $kode_project);
        return $this->db->update('tab_project', $data);
    }

    public function deleteData($kode_project)
    {
        $this->db->delete('tab_project_korlap', ['kode_project' => $kode_project]);
        return $this->db->delete('tab_project', ['kode_project' => $kode_project]);
    }

    // ============================
    // Korlap Methods
    // ============================

    public function getKorlapByProject($kode_project)
    {
        $this->db->select('tab_project_korlap.*, tab_user.nama');
        $this->db->from('tab_project_korlap');
        $this->db->join('tab_user', 'tab_user.id_user = tab_project_korlap.user_id', 'left');
        $this->db->where('tab_project_korlap.kode_project', $kode_project);
        $this->db->order_by('tab_project_korlap.tgl_mulai', 'ASC');
        return $this->db->get()->result_array();
    }

    public function insertKorlap($data)
    {
        return $this->db->insert('tab_project_korlap', $data);
    }

    public function deleteKorlapByProject($kode_project)
    {
        return $this->db->delete('tab_project_korlap', ['kode_project' => $kode_project]);
    }

    public function getSiteByPerusahaan($perusahaan_id)
    {
        return $this->db->get_where('tab_site', ['id_perusahaan' => $perusahaan_id])->result_array();
    }

    public function getSiteByMarketingSiteId($marketing_site_id)
    {
        if (!$this->db->field_exists('marketing_site_id', 'tab_site')) {
            return null;
        }

        return $this->db->get_where('tab_site', ['marketing_site_id' => (int) $marketing_site_id])->row_array();
    }

    public function getSiteByPerusahaanAndName($perusahaan_id, $nama_site)
    {
        return $this->db->get_where('tab_site', [
            'id_perusahaan' => (int) $perusahaan_id,
            'nama_site' => $nama_site,
        ])->row_array();
    }

    public function storeSiteData($data)
    {
        return $this->db->insert('tab_site', $data);
    }

    public function updateSiteData($id_site, $data)
    {
        $this->db->where('id_site', $id_site);
        return $this->db->update('tab_site', $data);
    }

    public function getProjectByMarketingSite($marketing_project_id, $marketing_site_id)
    {
        if (!$this->db->field_exists('marketing_project_id', 'tab_project') || !$this->db->field_exists('marketing_site_id', 'tab_project')) {
            return null;
        }

        return $this->db->get_where('tab_project', [
            'marketing_project_id' => (int) $marketing_project_id,
            'marketing_site_id' => (int) $marketing_site_id,
        ])->row_array();
    }

    public function getProjectBySiteAndName($site_id, $nama_project)
    {
        return $this->db->get_where('tab_project', [
            'site_id' => (int) $site_id,
            'nama_project' => $nama_project,
        ])->row_array();
    }

    public function getUsers()
    {
        $this->db->select('id_user, nama, role_id');
        $this->db->from('tab_user');
        $this->db->where_in('role_id', [8, 9]);
        $this->db->order_by('nama', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getProjectFinancialSummary($kode_project)
    {
        $processLabels = $this->getProcessLabels();
        $categoryConfig = $this->getOperationalCategoryConfig();
        $summary = [
            'process_labels' => $processLabels,
            'categories' => [],
            'budget_by_process' => [],
            'topup_by_process' => [],
            'expense_by_process' => [],
            'category_totals' => [],
            'grand_budget' => 0,
            'grand_initial_budget' => 0,
            'grand_topup' => 0,
            'grand_expense' => 0,
            'grand_remaining' => 0,
        ];

        foreach ($categoryConfig as $key => $config) {
            $summary['categories'][$key] = $config['label'];
            $summary['category_totals'][$key] = [
                'label' => $config['label'],
                'count' => 0,
                'total' => 0,
            ];
        }

        foreach ($processLabels as $process => $label) {
            $summary['budget_by_process'][$process] = [
                'label' => $label,
                'rows' => [],
                'total' => 0,
            ];
            $summary['topup_by_process'][$process] = [
                'label' => $label,
                'rows' => [],
                'total' => 0,
            ];
            $summary['expense_by_process'][$process] = [
                'label' => $label,
                'categories' => [],
                'initial_budget' => 0,
                'topup' => 0,
                'budget' => 0,
                'total' => 0,
                'remaining' => 0,
            ];

            foreach ($categoryConfig as $key => $config) {
                $summary['expense_by_process'][$process]['categories'][$key] = [
                    'label' => $config['label'],
                    'rows' => [],
                    'count' => 0,
                    'total' => 0,
                ];
            }
        }

        foreach ($this->getBudgetRowsByProject($kode_project) as $row) {
            $process = $this->normalizeFinancialProcess($row['proses'] ?? '', $summary, $categoryConfig);
            $amount = (float) ($row['amount'] ?? 0);
            $row['amount'] = $amount;
            $summary['budget_by_process'][$process]['rows'][] = $row;
            $summary['budget_by_process'][$process]['total'] += $amount;
            $summary['expense_by_process'][$process]['initial_budget'] += $amount;
            $summary['expense_by_process'][$process]['budget'] += $amount;
            $summary['grand_budget'] += $amount;
            $summary['grand_initial_budget'] += $amount;
        }

        foreach ($this->getTopupRowsByProject($kode_project) as $row) {
            $process = $this->normalizeFinancialProcess($row['proses'] ?? '', $summary, $categoryConfig);
            $amount = (float) ($row['amount'] ?? 0);
            $row['amount'] = $amount;
            $summary['topup_by_process'][$process]['rows'][] = $row;
            $summary['topup_by_process'][$process]['total'] += $amount;
            $summary['expense_by_process'][$process]['topup'] += $amount;
            $summary['expense_by_process'][$process]['budget'] += $amount;
            $summary['grand_budget'] += $amount;
            $summary['grand_topup'] += $amount;
        }

        foreach ($categoryConfig as $category => $config) {
            foreach ($this->getOperationalExpenseRows($kode_project, $config) as $row) {
                $process = $this->normalizeFinancialProcess($row['proses'] ?? '', $summary, $categoryConfig);
                $amount = $row['amount'] === null ? null : (float) $row['amount'];
                $row['amount'] = $amount;
                $row['unit_price'] = $row['unit_price'] === null ? null : (float) $row['unit_price'];
                $row['quantity'] = $row['quantity'] === null ? null : (float) $row['quantity'];
                $row['extra_amount'] = $row['extra_amount'] === null ? null : (float) $row['extra_amount'];

                $summary['expense_by_process'][$process]['categories'][$category]['rows'][] = $row;
                $summary['expense_by_process'][$process]['categories'][$category]['count']++;
                $summary['category_totals'][$category]['count']++;

                if ($amount !== null) {
                    $summary['expense_by_process'][$process]['categories'][$category]['total'] += $amount;
                    $summary['expense_by_process'][$process]['total'] += $amount;
                    $summary['category_totals'][$category]['total'] += $amount;
                    $summary['grand_expense'] += $amount;
                }
            }
        }

        foreach ($summary['expense_by_process'] as $process => &$processRow) {
            $processRow['remaining'] = $processRow['budget'] - $processRow['total'];
        }
        unset($processRow);

        $summary['grand_remaining'] = $summary['grand_budget'] - $summary['grand_expense'];

        return $summary;
    }

    private function getBudgetRowsByProject($kode_project)
    {
        if (!$this->db->table_exists('tab_budget')) {
            return [];
        }

        $this->db->select('id_budget AS id, proses, total_budget AS amount, keterangan, created_at', false);
        $this->db->from('tab_budget');
        $this->db->where('project', $kode_project);
        $this->db->order_by('proses', 'ASC');
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get()->result_array();
    }

    private function getTopupRowsByProject($kode_project)
    {
        if (!$this->db->table_exists('tab_topup_saldo')) {
            return [];
        }

        $this->db->select('id_topup AS id, proses, nominal AS amount, tgl_topup, keterangan, created_at', false);
        $this->db->from('tab_topup_saldo');
        $this->db->where('project', $kode_project);
        $this->db->order_by('proses', 'ASC');
        $this->db->order_by('tgl_topup', 'ASC');
        return $this->db->get()->result_array();
    }

    private function getOperationalExpenseRows($kode_project, $config)
    {
        if (!$this->db->table_exists($config['table'])) {
            return [];
        }

        $this->db->select($config['select'], false);
        $this->db->from($config['table']);
        $this->db->join('tab_user u', 'u.id_user = ' . $config['table'] . '.korlap', 'left');
        $this->db->where($config['table'] . '.project', $kode_project);
        $this->db->order_by($config['order'], 'ASC');
        return $this->db->get()->result_array();
    }

    private function normalizeFinancialProcess($process, &$summary, $categoryConfig)
    {
        $process = (string) $process;

        if ($process === '' || !isset($summary['expense_by_process'][$process])) {
            $process = '0';
        }

        if (isset($summary['expense_by_process'][$process])) {
            return $process;
        }

        $summary['process_labels'][$process] = 'Tanpa Proses';
        $summary['budget_by_process'][$process] = [
            'label' => 'Tanpa Proses',
            'rows' => [],
            'total' => 0,
        ];
        $summary['topup_by_process'][$process] = [
            'label' => 'Tanpa Proses',
            'rows' => [],
            'total' => 0,
        ];
        $summary['expense_by_process'][$process] = [
            'label' => 'Tanpa Proses',
            'categories' => [],
            'initial_budget' => 0,
            'topup' => 0,
            'budget' => 0,
            'total' => 0,
            'remaining' => 0,
        ];

        foreach ($categoryConfig as $key => $config) {
            $summary['expense_by_process'][$process]['categories'][$key] = [
                'label' => $config['label'],
                'rows' => [],
                'count' => 0,
                'total' => 0,
            ];
        }

        return $process;
    }

    private function getProcessLabels()
    {
        return [
            '1' => 'Setting MCU',
            '2' => 'Pelaksanaan MCU',
            '3' => 'Bongkar Setting',
            '4' => 'Kirim Hasil',
        ];
    }

    private function getOperationalCategoryConfig()
    {
        $transportNameSelect = $this->db->field_exists('jenis_pengeluaran', 'tab_transport')
            ? "CASE WHEN tab_transport.jenis_pengeluaran = 'Mobil' THEN tab_transport.transport ELSE tab_transport.jenis_pengeluaran END"
            : 'tab_transport.transport';
        $transportMetaSelect = $this->db->field_exists('jenis_pengeluaran', 'tab_transport')
            ? "CASE WHEN tab_transport.jenis_pengeluaran = 'Mobil' THEN CONCAT(tab_transport.jenis, ' - ', tab_transport.tipe) ELSE '' END"
            : "CONCAT(tab_transport.jenis, ' - ', tab_transport.tipe)";

        return [
            'entertain' => [
                'label' => 'Entertain',
                'table' => 'tab_entertain',
                'order' => 'tab_entertain.tgl_mulai',
                'select' => "tab_entertain.id_entertain AS id, tab_entertain.proses, tab_entertain.tgl_mulai AS date_start, tab_entertain.tgl_selesai AS date_end, tab_entertain.nama_karyawan AS item_name, CONCAT('Jumlah hari: ', tab_entertain.j_hari) AS item_meta, tab_entertain.j_hari AS quantity, tab_entertain.nominal AS unit_price, NULL AS extra_amount, tab_entertain.total AS amount, tab_entertain.keterangan, tab_entertain.lampiran, u.nama AS created_by",
            ],
            'makan' => [
                'label' => 'Makan',
                'table' => 'tab_makan',
                'order' => 'tab_makan.tgl_makan',
                'select' => "tab_makan.id_makan AS id, tab_makan.proses, tab_makan.tgl_makan AS date_start, NULL AS date_end, 'Makan' AS item_name, CONCAT('Jumlah: ', tab_makan.jumlah) AS item_meta, tab_makan.jumlah AS quantity, tab_makan.nominal AS unit_price, NULL AS extra_amount, tab_makan.total AS amount, tab_makan.keterangan, tab_makan.lampiran, u.nama AS created_by",
            ],
            'freelance' => [
                'label' => 'Freelance',
                'table' => 'tab_fee_freelance',
                'order' => 'tab_fee_freelance.tgl_fee',
                'select' => "tab_fee_freelance.id_freelance AS id, tab_fee_freelance.proses, tab_fee_freelance.tgl_fee AS date_start, NULL AS date_end, tab_fee_freelance.jobdesk AS item_name, CONCAT(tab_fee_freelance.jumlah_orang, ' orang x ', tab_fee_freelance.jumlah_hari, ' hari') AS item_meta, tab_fee_freelance.jumlah_orang AS quantity, tab_fee_freelance.fee AS unit_price, tab_fee_freelance.biaya_tambahan AS extra_amount, tab_fee_freelance.total AS amount, tab_fee_freelance.keterangan, tab_fee_freelance.lampiran, u.nama AS created_by",
            ],
            'transport' => [
                'label' => 'Transport',
                'table' => 'tab_transport',
                'order' => 'tab_transport.tgl_transport',
                'select' => "tab_transport.id_transport AS id, tab_transport.proses, tab_transport.tgl_transport AS date_start, NULL AS date_end, {$transportNameSelect} AS item_name, {$transportMetaSelect} AS item_meta, NULL AS quantity, NULL AS unit_price, NULL AS extra_amount, NULL AS amount, tab_transport.keterangan, tab_transport.lampiran, u.nama AS created_by",
            ],
            'penginapan' => [
                'label' => 'Penginapan',
                'table' => 'tab_penginapan',
                'order' => 'tab_penginapan.tgl_checkin',
                'select' => "tab_penginapan.id_penginapan AS id, tab_penginapan.proses, tab_penginapan.tgl_checkin AS date_start, tab_penginapan.tgl_checkout AS date_end, tab_penginapan.nama_hunian AS item_name, tab_penginapan.tipe_hunian AS item_meta, tab_penginapan.jumlah_hari AS quantity, tab_penginapan.nominal AS unit_price, NULL AS extra_amount, tab_penginapan.nominal AS amount, tab_penginapan.keterangan, tab_penginapan.invoice AS lampiran, u.nama AS created_by",
            ],
            'other' => [
                'label' => 'Other',
                'table' => 'tab_other',
                'order' => 'tab_other.tanggal',
                'select' => "tab_other.id_other AS id, tab_other.proses, tab_other.tanggal AS date_start, NULL AS date_end, tab_other.kebutuhan AS item_name, '' AS item_meta, NULL AS quantity, tab_other.nominal AS unit_price, NULL AS extra_amount, tab_other.nominal AS amount, tab_other.keterangan, tab_other.lampiran, u.nama AS created_by",
            ],
        ];
    }
}
