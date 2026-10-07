<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model 
{
    /**
     * Apply period filter using periode_bulan and periode_tahun columns (direct month/year)
     * @param int $bulan Month number (1-12)
     * @param int $tahun Year number
     * @param string $alias Table alias (optional)
     */
    private function applyMonthYearFilter($bulan, $tahun, $alias = null)
    {
        $prefix = $alias ? $alias . '.' : '';
        $this->db->where($prefix . 'periode_bulan', intval($bulan));
        $this->db->where($prefix . 'periode_tahun', intval($tahun));
    }

    /**
     * Apply period filter using periode_bulan and periode_tahun columns
     * @param string $start_date Start date in Y-m-d format
     * @param string $end_date End date in Y-m-d format
     * @param string $alias Table alias (optional)
     */
    private function applyPeriodFilter($start_date, $end_date, $alias = null)
    {
        $prefix = $alias ? $alias . '.' : '';
        
        // Parse dates to get month and year
        $start_month = intval(date('m', strtotime($start_date)));
        $start_year = intval(date('Y', strtotime($start_date)));
        $end_month = intval(date('m', strtotime($end_date)));
        $end_year = intval(date('Y', strtotime($end_date)));
        
        // Build filter condition for periode_bulan and periode_tahun
        if ($start_year == $end_year) {
            // Same year - filter by year and month range
            $this->db->where($prefix . 'periode_tahun', $start_year);
            $this->db->where($prefix . 'periode_bulan >=', $start_month);
            $this->db->where($prefix . 'periode_bulan <=', $end_month);
        } else {
            // Different years - use OR group
            $this->db->group_start();
            // Start year: from start_month to 12
            $this->db->group_start();
            $this->db->where($prefix . 'periode_tahun', $start_year);
            $this->db->where($prefix . 'periode_bulan >=', $start_month);
            $this->db->group_end();
            // End year: from 1 to end_month
            $this->db->or_group_start();
            $this->db->where($prefix . 'periode_tahun', $end_year);
            $this->db->where($prefix . 'periode_bulan <=', $end_month);
            $this->db->group_end();
            // Years in between (if any)
            if ($end_year - $start_year > 1) {
                $this->db->or_group_start();
                $this->db->where($prefix . 'periode_tahun >', $start_year);
                $this->db->where($prefix . 'periode_tahun <', $end_year);
                $this->db->group_end();
            }
            $this->db->group_end();
        }
    }

    public function get_dashboard_data($user_id = null, $role_id = null, $bulan = null, $tahun = null)
    {
        $data = [
            'total_prospek' => 0,
            'total_estimasi_lead' => 0,
            'total_client' => 0,
            'total_project' => 0,
            'total_sales' => 0
        ];
        
        if ($role_id == 1 || $role_id == 2 || $role_id == 4 || $role_id == 5 || $role_id == 14) {
            $this->db->from('tab_leads');
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_prospek'] = $this->db->count_all_results();
            $this->db->select_sum('estimasi_lead');
            $this->db->from('tab_leads');
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $query = $this->db->get();
            $result = $query->row();
            $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;

            $this->db->from('tab_client');
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_client'] = $this->db->count_all_results();
            $this->db->from('tab_project');
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_project'] = $this->db->count_all_results();
            $this->db->select_sum('estimasi');
            $this->db->from('tab_project');
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $query = $this->db->get();
            $result = $query->row();
            $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;
            
        } elseif ($role_id == 5) {
            $team_user_ids = $this->get_team_user_ids($user_id);
            
            if (!empty($team_user_ids)) {
                $this->db->where_in('user_id', $team_user_ids);
                if (!empty($bulan) && !empty($tahun)) {
                    $this->applyMonthYearFilter($bulan, $tahun);
                }
                $data['total_prospek'] = $this->db->count_all_results('tab_leads');
                
                $this->db->select_sum('estimasi_lead');
                $this->db->where_in('user_id', $team_user_ids);
                if (!empty($bulan) && !empty($tahun)) {
                    $this->applyMonthYearFilter($bulan, $tahun);
                }
                $query = $this->db->get('tab_leads');
                $result = $query->row();
                $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;
                
                $this->db->where_in('user_id', $team_user_ids);
                if (!empty($bulan) && !empty($tahun)) {
                    $this->applyMonthYearFilter($bulan, $tahun);
                }
                $data['total_client'] = $this->db->count_all_results('tab_client');
                
                $this->db->where_in('user_id', $team_user_ids);
                if (!empty($bulan) && !empty($tahun)) {
                    $this->applyMonthYearFilter($bulan, $tahun);
                }
                $data['total_project'] = $this->db->count_all_results('tab_project');
                $this->db->select_sum('estimasi');
                $this->db->where_in('user_id', $team_user_ids);
                if (!empty($bulan) && !empty($tahun)) {
                    $this->applyMonthYearFilter($bulan, $tahun);
                }
                $query = $this->db->get('tab_project');
                $result = $query->row();
                $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;
            } else {
                $data['total_prospek'] = 0;
                $data['total_estimasi_lead'] = 0;
                $data['total_client'] = 0;
                $data['total_project'] = 0;
                $data['total_sales'] = 0;
            }
            
        } elseif ($role_id == 8) {
            $this->db->where('user_id', $user_id);
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_prospek'] = $this->db->count_all_results('tab_leads');
            $this->db->select_sum('estimasi_lead');
            $this->db->where('user_id', $user_id);
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $query = $this->db->get('tab_leads');
            $result = $query->row();
            $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;
            
            $this->db->where('user_id', $user_id);
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_client'] = $this->db->count_all_results('tab_client');
            
            $this->db->where('user_id', $user_id);
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $data['total_project'] = $this->db->count_all_results('tab_project');
            
            $this->db->select_sum('estimasi');
            $this->db->where('user_id', $user_id);
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun);
            }
            $query = $this->db->get('tab_project');
            $result = $query->row();
            $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;
        }
        
        return $data;
    }


    public function get_dashboard_data_by_filter($filter_user_id, $bulan = null, $tahun = null)
    {
        $data = [
            'total_prospek' => 0,
            'total_estimasi_lead' => 0,
            'total_client' => 0,
            'total_project' => 0,
            'total_sales' => 0
        ];
        
        // Total Prospek
        $this->db->from('tab_leads');
        $this->db->where('user_id', $filter_user_id);
        if (!empty($bulan) && !empty($tahun)) {
            $this->applyMonthYearFilter($bulan, $tahun);
        }
        $data['total_prospek'] = $this->db->count_all_results();
        
        // Total Estimasi Lead
        $this->db->select_sum('estimasi_lead');
        $this->db->from('tab_leads');
        $this->db->where('user_id', $filter_user_id);
        if (!empty($bulan) && !empty($tahun)) {
            $this->applyMonthYearFilter($bulan, $tahun);
        }
        $query = $this->db->get();
        $result = $query->row();
        $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;
        
        // Total Client
        $this->db->from('tab_client');
        $this->db->where('user_id', $filter_user_id);
        if (!empty($bulan) && !empty($tahun)) {
            $this->applyMonthYearFilter($bulan, $tahun);
        }
        $data['total_client'] = $this->db->count_all_results();
        
        // Total Project
        $this->db->from('tab_project');
        $this->db->where('user_id', $filter_user_id);
        if (!empty($bulan) && !empty($tahun)) {
            $this->applyMonthYearFilter($bulan, $tahun);
        }
        $data['total_project'] = $this->db->count_all_results();
        
        // Total Sales (Estimasi Project)
        $this->db->select_sum('estimasi');
        $this->db->from('tab_project');
        $this->db->where('user_id', $filter_user_id);
        if (!empty($bulan) && !empty($tahun)) {
            $this->applyMonthYearFilter($bulan, $tahun);
        }
        $query = $this->db->get();
        $result = $query->row();
        $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;
        
        return $data;
    }

    private function get_team_user_ids($spv_id)
    {
        $this->db->select('ta.staff_id');
        $this->db->from('tab_team tt');
        $this->db->join('tab_anggota_team ta', 'tt.id_team = ta.team_id');
        $this->db->where('tt.id_spv', $spv_id);
        $query = $this->db->get();
        
        $user_ids = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $user_ids[] = $row->staff_id;
            }
            $user_ids[] = $spv_id;
        }
        return $user_ids;
    }

    public function getSektorChart($user_id = null, $role_id = null, $bulan = null, $tahun = null)
    {
        try {
            $allowed_sektors = [
                'Industri',
                'Kementerian/ Government',
                'Kementerian/ Goverment',
                'Danantara (BUMN Karya)',
                'Pertambangan/ Mining',
                'Perkantoran/ Office',
                'Perhotelan',
                'Facility services (Security, Cleaning service, Catering)',
                'Instansi Pendidikan',
                'Travel & Agent',
                'Rumah Sakit & Lab',
                'Yayasan',
                'Shipping',
                'Retail Market',
                'Engineering (Air, Listrik, IT)',
                'Finance (Banking & Insurance)',
                'Finance (Banking, Insurance)',
                'Transportation',
                'Construction',
                'Plantation'
            ];

            // Role 5 (Supervisor) - filter by team
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_clients' => 0
                    ];
                }
            }

            $this->db->reset_query();
            $this->db->select('sektor, COUNT(*) as total');
            $this->db->from('tab_client tc');

            $this->db->where_in('sektor', $allowed_sektors);
            // If role_id is null, filter by specific user_id (used when admin filters by marketing)
            if ($role_id === null && $user_id !== null) {
                $this->db->where('tc.user_id', $user_id);
            } elseif ($role_id == 5) {
                $this->db->where_in('tc.user_id', $team_user_ids);
            }
            // Role 1, 2, 3, 4, 13 - show all data (no user filter)
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun, 'tc');
            }
            
            $this->db->where('sektor IS NOT NULL');
            $this->db->where('sektor !=', '');
            $this->db->group_by('sektor');
            $this->db->order_by('total', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_clients = 0;
            foreach ($results as $row) {
                $total_all_clients += $row->total;
            }
            foreach ($results as $row) {
                $formatted_label = $this->SektorLabel($row->sektor);
                $labels[] = $formatted_label;
                $percentage = ($total_all_clients > 0) ? ($row->total / $total_all_clients) * 100 : 0;
                $series_data[] = round($percentage, 2);
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_clients' => $total_all_clients
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getSektorChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_clients' => 0
            ];
        }
    }

    public function getGroupChart($user_id = null, $role_id = null, $bulan = null, $tahun = null)
    {
        try {
            // Allowed group labels only
            $allowed_groups = ['VIP', 'Gold', 'Silver'];
            
            // Role 5 (Supervisor) - filter by team
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_clients' => 0
                    ];
                }
            }

            $this->db->reset_query();
            $this->db->select('group, COUNT(*) as total');
            $this->db->from('tab_client tc');
            
            // Only count allowed groups
            $this->db->where_in('group', $allowed_groups);
            
            // If role_id is null, filter by specific user_id (used when admin filters by marketing)
            if ($role_id === null && $user_id !== null) {
                $this->db->where('tc.user_id', $user_id);
            } elseif ($role_id == 5) {
                // Supervisor - filter by team members
                $this->db->where_in('tc.user_id', $team_user_ids);
            }
            // Role 1, 2, 3, 4, 13 - show all data (no user filter)
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun, 'tc');
            }
            
            $this->db->where('group IS NOT NULL');
            $this->db->where('group !=', '');
            $this->db->group_by('group');
            $this->db->order_by('total', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_clients = 0;
            foreach ($results as $row) {
                $total_all_clients += $row->total;
            }
            foreach ($results as $row) {
                $formatted_label = $this->GroupLabel($row->group);
                $labels[] = $formatted_label;
                $series_data[] = (int) $row->total;
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_clients' => $total_all_clients
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getGroupChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_clients' => 0
            ];
        }
    }

    public function getOmsetChart($filter_user_id = null, $bulan = null, $tahun = null, $user_id = null, $role_id = null)
    {
        try {
            $allowed_roles = [5, 8];
            
            // Role 5 (Supervisor) - filter by team members only
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_omset' => 0
                    ];
                }
            }
            
            $this->db->reset_query();
            $this->db->select('u.id_user, u.nama, COALESCE(SUM(tp.estimasi), 0) as total_estimasi');
            $this->db->from('tab_user u');
            $this->db->join('tab_project tp', 'tp.user_id = u.id_user', 'left');
            
            // If specific user filter is provided
            if (!empty($filter_user_id)) {
                $this->db->where('u.id_user', $filter_user_id);
            } elseif ($role_id == 5) {
                // Supervisor - show only team members' omset
                $this->db->where_in('u.id_user', $team_user_ids);
            } else {
                // Role 1, 2, 3, 4, 13 - show all marketing users
                $this->db->where_in('u.role_id', $allowed_roles);
            }
            
            // Filter by period using periode columns
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun, 'tp');
            }
            
            $this->db->group_by('u.id_user');
            $this->db->having('total_estimasi >', 0);
            $this->db->order_by('total_estimasi', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $user_ids = [];
            $total_all_omset = 0;
            
            foreach ($results as $row) {
                $omset = $row->total_estimasi ? floatval($row->total_estimasi) : 0;
                $total_all_omset += $omset;
                $labels[] = $row->nama;
                $series_data[] = $omset;
                $user_ids[] = $row->id_user;
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'user_ids' => $user_ids,
                'total_omset' => $total_all_omset
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getOmsetChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_omset' => 0
            ];
        }
    }

    public function getServiceChart($bulan = null, $tahun = null, $user_id = null, $role_id = null)
    {
        try {
            $allowed_services = ['MCU', 'IHC', 'VAKSIN', 'HSEO', 'LAB RUJUKAN'];
            
            // Role 5 (Supervisor) - filter by team
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_projects' => 0
                    ];
                }
            }

            $this->db->reset_query();
            $this->db->select('service, COUNT(*) as total');
            $this->db->from('tab_project tp');
            
            // Only count allowed services
            $this->db->where_in('service', $allowed_services);

            // If role_id is null, filter by specific user_id (used when admin filters by marketing)
            if ($role_id === null && $user_id !== null) {
                $this->db->where('tp.user_id', $user_id);
            } elseif ($role_id == 5) {
                $this->db->where_in('tp.user_id', $team_user_ids);
            }
            // Role 1, 2, 3, 4, 13 - show all data (no user filter)
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun, 'tp');
            }
            
            $this->db->group_by('service');
            $this->db->order_by('total', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_projects = 0;
            
            foreach ($results as $row) {
                $total_all_projects += $row->total;
            }
            
            foreach ($results as $row) {
                $labels[] = $this->ServiceLabel($row->service);
                $series_data[] = (int) $row->total; 
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_projects' => $total_all_projects
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getServiceChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_projects' => 0
            ];
        }
    }

    public function getBranchChart($user_id = null, $role_id = null, $bulan = null, $tahun = null)
    {
        try {
            // Role 5 (Supervisor) - filter by team
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_projects' => 0
                    ];
                }
            }

            $this->db->reset_query();
            $this->db->select('tc.nama_cabang, COUNT(tp.id_project) as total');
            $this->db->from('tab_project tp');
            $this->db->join('tab_user tu', 'tu.id_user = tp.user_id', 'left');
            $this->db->join('tab_cabang tc', 'tc.id_cabang = tu.cabang', 'left');

            // If role_id is null, filter by specific user_id (used when admin filters by marketing)
            if ($role_id === null && $user_id !== null) {
                $this->db->where('tp.user_id', $user_id);
            } elseif ($role_id == 5) {
                // Supervisor - filter by team members
                $this->db->where_in('tp.user_id', $team_user_ids);
            }
            // Role 1, 2, 3, 4, 13 - show all data (no user filter)
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->applyMonthYearFilter($bulan, $tahun, 'tp');
            }
            
            $this->db->where('tc.nama_cabang IS NOT NULL');
            $this->db->where('tc.nama_cabang !=', '');
            $this->db->group_by('tc.nama_cabang');
            $this->db->order_by('total', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_projects = 0;
            
            foreach ($results as $row) {
                $total_all_projects += $row->total;
            }
            
            foreach ($results as $row) {
                $labels[] = $row->nama_cabang;
                $percentage = ($total_all_projects > 0) ? ($row->total / $total_all_projects) * 100 : 0;
                $series_data[] = round($percentage, 2);
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_projects' => $total_all_projects
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getBranchChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_projects' => 0
            ];
        }
    }

    private function ServiceLabel($service)
    {
        $formatted = strtoupper($service);
        $format_map = [
            'MCU' => 'MCU',
            'IHC' => 'IHC', 
            'VAKSIN' => 'VAKSIN',
            'HSEO' => 'HSEO',
            'LAB RUJUKAN' => 'RUJUKAN LAB',
        ];
        
        return isset($format_map[$service]) ? $format_map[$service] : $formatted;
    }

    private function SektorLabel($sektor)
    {
        $format_map = [
            'Industri' => 'Industri',
            'Kementerian/ Government' => 'Kementerian/ Government',
            'Kementerian/ Goverment' => 'Kementerian/ Government',
            'Danantara (BUMN Karya)' => 'Danantara (BUMN Karya)',
            'Pertambangan/ Mining' => 'Pertambangan/ Mining',
            'Perkantoran/ Office' => 'Perkantoran/ Office',
            'Perhotelan' => 'Perhotelan',
            'Facility services (Security, Cleaning service, Catering)' => 'Facility Services',
            'Instansi Pendidikan' => 'Instansi Pendidikan',
            'Travel & Agent' => 'Travel & Agent',
            'Rumah Sakit & Lab' => 'Rumah Sakit & Lab',
            'Yayasan' => 'Yayasan',
            'Shipping' => 'Shipping',
            'Retail Market' => 'Retail Market',
            'Engineering (Air, Listrik, IT)' => 'Engineering (Air, Listrik, IT)',
            'Finance (Banking & Insurance)' => 'Finance (Banking & Insurance)',
            'Finance (Banking, Insurance)' => 'Finance (Banking & Insurance)',
            'Transportation' => 'Transportation',
            'Construction' => 'Construction',
            'Plantation' => 'Plantation'
        ];
        
        return isset($format_map[$sektor]) ? $format_map[$sektor] : $sektor;
    }

    private function GroupLabel($group)
    {
        $format_map = [
            'VIP'       => 'VIP',
            'Gold'      => 'Gold',
            'Silver'    => 'Silver'
        ];
        
        return isset($format_map[$group]) ? $format_map[$group] : $group;
    }



    public function get_monthly_comparison($user_id = null, $role_id = null)
    {
        $current_month_start = date('Y-m-01');
        $current_month_end = date('Y-m-t');
        $previous_month_start = date('Y-m-01', strtotime('-1 month'));
        $previous_month_end = date('Y-m-t', strtotime('-1 month'));
        $current_data = $this->get_monthly_totals($user_id, $role_id, $current_month_start, $current_month_end);
        $previous_data = $this->get_monthly_totals($user_id, $role_id, $previous_month_start, $previous_month_end);
        $percentages = [
            'prospek_percentage' => $this->calculate_percentage($current_data['total_prospek'], $previous_data['total_prospek']),
            'estimasi_percentage' => $this->calculate_percentage($current_data['total_estimasi_lead'], $previous_data['total_estimasi_lead']),
            'client_percentage' => $this->calculate_percentage($current_data['total_client'], $previous_data['total_client']),
            'sales_percentage' => $this->calculate_percentage($current_data['total_sales'], $previous_data['total_sales'])
        ];

        return $percentages;
    }

    private function get_monthly_totals($user_id, $role_id, $start_date, $end_date)
    {
        $data = [
            'total_prospek' => 0,
            'total_estimasi_lead' => 0,
            'total_client' => 0,
            'total_sales' => 0
        ];

        if ($role_id == 1) {
            $this->applyPeriodFilter($start_date, $end_date);
            $data['total_prospek'] = $this->db->count_all_results('tab_leads');

            $this->db->select_sum('estimasi_lead');
            $this->applyPeriodFilter($start_date, $end_date);
            $query = $this->db->get('tab_leads');
            $result = $query->row();
            $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;

            $this->applyPeriodFilter($start_date, $end_date);
            $data['total_client'] = $this->db->count_all_results('tab_client');

            $this->db->select_sum('estimasi');
            $this->db->where('tgl_selesai >=', $start_date);
            $this->db->where('tgl_selesai <=', $end_date);
            $query = $this->db->get('tab_project');
            $result = $query->row();
            $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;

        } elseif ($role_id == 2) {
            $team_user_ids = $this->get_team_user_ids($user_id);
            
            if (!empty($team_user_ids)) {
                $this->db->where_in('user_id', $team_user_ids);
                $this->applyPeriodFilter($start_date, $end_date);
                $data['total_prospek'] = $this->db->count_all_results('tab_leads');

                $this->db->select_sum('estimasi_lead');
                $this->db->where_in('user_id', $team_user_ids);
                $this->applyPeriodFilter($start_date, $end_date);
                $query = $this->db->get('tab_leads');
                $result = $query->row();
                $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;

                $this->db->where_in('user_id', $team_user_ids);
                $this->applyPeriodFilter($start_date, $end_date);
                $data['total_client'] = $this->db->count_all_results('tab_client');

                $this->db->select_sum('estimasi');
                $this->db->where_in('user_id', $team_user_ids);
                $this->db->where('tgl_selesai >=', $start_date);
                $this->db->where('tgl_selesai <=', $end_date);
                $query = $this->db->get('tab_project');
                $result = $query->row();
                $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;
            }

        } elseif ($role_id == 4) {
            $this->db->where('user_id', $user_id);
            $this->applyPeriodFilter($start_date, $end_date);
            $data['total_prospek'] = $this->db->count_all_results('tab_leads');

            $this->db->select_sum('estimasi_lead');
            $this->db->where('user_id', $user_id);
            $this->applyPeriodFilter($start_date, $end_date);
            $query = $this->db->get('tab_leads');
            $result = $query->row();
            $data['total_estimasi_lead'] = $result->estimasi_lead ? $result->estimasi_lead : 0;

            $this->db->where('user_id', $user_id);
            $this->applyPeriodFilter($start_date, $end_date);
            $data['total_client'] = $this->db->count_all_results('tab_client');

            $this->db->select_sum('estimasi');
            $this->db->where('user_id', $user_id);
            $this->db->where('tgl_selesai >=', $start_date);
            $this->db->where('tgl_selesai <=', $end_date);
            $query = $this->db->get('tab_project');
            $result = $query->row();
            $data['total_sales'] = $result->estimasi ? $result->estimasi : 0;

        } else {
            $data['total_prospek'] = 0;
            $data['total_estimasi_lead'] = 0;
            $data['total_client'] = 0;
            $data['total_sales'] = 0;
        }

        return $data;
    }

    private function calculate_percentage($current, $previous)
    {
        if ($previous == 0) {
            if ($current > 0) {
                return 100;
            }
            return 0;
        }
        
        $percentage = (($current - $previous) / $previous) * 100;
        return round($percentage, 2);
    }

    public function getProspekMarketingChart($bulan = null, $tahun = null, $filter_user_id = null, $user_id = null, $role_id = null)
    {
        try {
            $allowed_roles = [5, 7];
            
            // Role 5 (Supervisor) - filter by team members only
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_prospek' => 0
                    ];
                }
            }
            
            // Get all marketing users with prospek count
            $this->db->select('u.id_user, u.nama, COUNT(l.id_leads) as total_prospek');
            $this->db->from('tab_user u');
            $this->db->join('tab_leads l', 'l.user_id = u.id_user', 'left');
            
            // If specific user filter is provided
            if (!empty($filter_user_id)) {
                $this->db->where('u.id_user', $filter_user_id);
            } elseif ($role_id == 5) {
                // Supervisor - show only team members' prospek
                $this->db->where_in('u.id_user', $team_user_ids);
            } else {
                // Role 1, 2, 3, 4, 13 - show all marketing users
                $this->db->where_in('u.role_id', $allowed_roles);
            }
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->db->group_start();
                $this->applyMonthYearFilter($bulan, $tahun, 'l');
                $this->db->or_where('l.id_leads IS NULL');
                $this->db->group_end();
            }
            
            $this->db->group_by('u.id_user, u.nama');
            $this->db->having('total_prospek >', 0);
            $this->db->order_by('total_prospek', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_prospek = 0;
            
            foreach ($results as $row) {
                $total_all_prospek += $row->total_prospek;
            }
            
            foreach ($results as $row) {
                $labels[] = $row->nama;
                $series_data[] = (int) $row->total_prospek;
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_prospek' => $total_all_prospek
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getProspekMarketingChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_prospek' => 0
            ];
        }
    }

    /**
     * Get Client Marketing Pie Chart Data
     * Count total clients from tab_client by each marketing user (role_id 2 & 4)
     */
    public function getClientMarketingChart($bulan = null, $tahun = null, $filter_user_id = null, $user_id = null, $role_id = null)
    {
        try {
            $allowed_roles = [5, 7];
            
            // Role 5 (Supervisor) - filter by team members only
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_client' => 0
                    ];
                }
            }
            
            // Get all marketing users with client count
            $this->db->select('u.id_user, u.nama, COUNT(c.id_client) as total_client');
            $this->db->from('tab_user u');
            $this->db->join('tab_client c', 'c.user_id = u.id_user', 'left');
            
            // If specific user filter is provided
            if (!empty($filter_user_id)) {
                $this->db->where('u.id_user', $filter_user_id);
            } elseif ($role_id == 5) {
                // Supervisor - show only team members' client
                $this->db->where_in('u.id_user', $team_user_ids);
            } else {
                // Role 1, 2, 3, 4, 13 - show all marketing users
                $this->db->where_in('u.role_id', $allowed_roles);
            }
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->db->group_start();
                $this->applyMonthYearFilter($bulan, $tahun, 'c');
                $this->db->or_where('c.id_client IS NULL');
                $this->db->group_end();
            }
            
            $this->db->group_by('u.id_user, u.nama');
            $this->db->having('total_client >', 0);
            $this->db->order_by('total_client', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_client = 0;
            
            foreach ($results as $row) {
                $total_all_client += $row->total_client;
            }
            
            foreach ($results as $row) {
                $labels[] = $row->nama;
                $series_data[] = (int) $row->total_client;
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_client' => $total_all_client
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getClientMarketingChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_client' => 0
            ];
        }
    }

    /**
     * Get Lost Marketing Pie Chart Data
     * Count total leads with status_lead = 'Lost' from tab_leads by each marketing user (role_id 5 & 7)
     */
    public function getLostMarketingChart($bulan = null, $tahun = null, $filter_user_id = null, $user_id = null, $role_id = null)
    {
        try {
            $allowed_roles = [5, 7];
            
            // Role 5 (Supervisor) - filter by team members only
            if ($role_id == 5) {
                $team_user_ids = $this->get_team_user_ids($user_id);
                if (empty($team_user_ids)) {
                    return [
                        'labels' => [],
                        'series' => [],
                        'total_lost' => 0
                    ];
                }
            }
            
            // Get all marketing users with lost leads count
            $this->db->select('u.id_user, u.nama, COUNT(l.id_leads) as total_lost');
            $this->db->from('tab_user u');
            $this->db->join('tab_leads l', 'l.user_id = u.id_user AND l.status_lead = "Lost"', 'left');
            
            // If specific user filter is provided
            if (!empty($filter_user_id)) {
                $this->db->where('u.id_user', $filter_user_id);
            } elseif ($role_id == 5) {
                // Supervisor - show only team members' lost
                $this->db->where_in('u.id_user', $team_user_ids);
            } else {
                // Role 1, 2, 3, 4, 13 - show all marketing users
                $this->db->where_in('u.role_id', $allowed_roles);
            }
            
            if (!empty($bulan) && !empty($tahun)) {
                $this->db->group_start();
                $this->applyMonthYearFilter($bulan, $tahun, 'l');
                $this->db->or_where('l.id_leads IS NULL');
                $this->db->group_end();
            }
            
            $this->db->group_by('u.id_user, u.nama');
            $this->db->having('total_lost >', 0);
            $this->db->order_by('total_lost', 'DESC');
            $query = $this->db->get();
            
            $results = $query->result();
            
            $labels = [];
            $series_data = [];
            $total_all_lost = 0;
            
            foreach ($results as $row) {
                $total_all_lost += $row->total_lost;
            }
            
            foreach ($results as $row) {
                $labels[] = $row->nama;
                $series_data[] = (int) $row->total_lost;
            }
            
            return [
                'labels' => $labels,
                'series' => $series_data,
                'total_lost' => $total_all_lost
            ];
            
        } catch (Exception $e) {
            log_message('error', 'Error in getLostMarketingChart: ' . $e->getMessage());
            return [
                'labels' => [],
                'series' => [],
                'total_lost' => 0
            ];
        }
    }

    public function get_operational_dashboard($month = null, $year = null)
    {
        $month = (int) ($month ?: date('n'));
        $year = (int) ($year ?: date('Y'));
        $period = $this->periodBounds($month, $year);
        $previous = $this->periodBounds((int) date('n', strtotime($period['start'] . ' -1 month')), (int) date('Y', strtotime($period['start'] . ' -1 month')));

        $budget = $this->sumBudget();
        $topup = $this->sumTopup();
        $doctorProject = $this->sumDoctorProject();
        $doctorRetail = $this->sumDoctorRetail();
        $operational = $this->sumOperational();
        $other = $this->sumOther();
        $expense = $doctorProject + $doctorRetail + $operational + $other;

        $previousBudget = $this->sumBudget($previous['start'], $previous['end']);
        $previousTopup = $this->sumTopup($previous['start'], $previous['end']);
        $previousDoctorProject = $this->sumDoctorProject($previous['start'], $previous['end']);
        $previousDoctorRetail = $this->sumDoctorRetail($previous['start'], $previous['end']);
        $previousOperational = $this->sumOperational($previous['start'], $previous['end']);
        $previousOther = $this->sumOther($previous['start'], $previous['end']);
        $previousExpense = $previousDoctorProject + $previousDoctorRetail + $previousOperational + $previousOther;

        $balance = $budget + $topup - $expense;
        $previousBalance = $previousBudget + $previousTopup - $previousExpense;
        $doctorTotal = $doctorProject + $doctorRetail;
        $previousDoctorTotal = $previousDoctorProject + $previousDoctorRetail;
        $pendingApproval = $this->countPendingApproval();
        $previousPendingApproval = $this->countPendingApproval($previous['start'], $previous['end']);

        return [
            'period_label' => $this->formatMonthYear($month, $year),
            'cards' => [
                'balance' => [
                    'label' => 'Saldo Operasional',
                    'value' => $balance,
                    'value_label' => $this->formatCompactRupiah($balance),
                    'percentage' => $this->calculate_percentage($balance, $previousBalance),
                    'icon' => 'ti ti-wallet',
                    'tone' => 'success',
                ],
                'expense' => [
                    'label' => 'Total Pengeluaran',
                    'value' => $expense,
                    'value_label' => $this->formatCompactRupiah($expense),
                    'percentage' => $this->calculate_percentage($expense, $previousExpense),
                    'icon' => 'ti ti-chart-bar',
                    'tone' => 'danger',
                ],
                'topup' => [
                    'label' => 'Total Top Up',
                    'value' => $topup,
                    'value_label' => $this->formatCompactRupiah($topup),
                    'percentage' => $this->calculate_percentage($topup, $previousTopup),
                    'icon' => 'ti ti-circle-plus',
                    'tone' => 'primary',
                ],
                'doctor' => [
                    'label' => 'Pembayaran Dokter',
                    'value' => $doctorTotal,
                    'value_label' => $this->formatCompactRupiah($doctorTotal),
                    'percentage' => $this->calculate_percentage($doctorTotal, $previousDoctorTotal),
                    'icon' => 'ti ti-stethoscope',
                    'tone' => 'purple',
                ],
                'approval' => [
                    'label' => 'Menunggu Approval',
                    'value' => $pendingApproval,
                    'value_label' => number_format($pendingApproval, 0, ',', '.') . ' transaksi',
                    'percentage' => $this->calculate_percentage($pendingApproval, $previousPendingApproval),
                    'icon' => 'ti ti-clock-hour-4',
                    'tone' => 'warning',
                ],
            ],
            'trend' => $this->getExpenseTrend($period['start']),
            'composition' => [
                'labels' => ['Dokter Project', 'Dokter Retail', 'Operasional', 'Lain-lain'],
                'series' => [$doctorProject, $doctorRetail, $operational, $other],
                'total' => $expense,
            ],
            'budget_rows' => $this->getBudgetRows(),
            'transactions' => $this->getRecentTransactions(null, null, 10),
        ];
    }

    public function get_month_options()
    {
        return [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    }

    public function get_year_options()
    {
        $current = (int) date('Y');
        $years = [];

        for ($year = $current - 3; $year <= $current + 1; $year++) {
            $years[] = $year;
        }

        return $years;
    }

    private function periodBounds($month, $year)
    {
        $start = sprintf('%04d-%02d-01', (int) $year, (int) $month);

        return [
            'start' => $start,
            'end' => date('Y-m-t', strtotime($start)),
        ];
    }

    private function formatMonthYear($month, $year)
    {
        $months = $this->get_month_options();

        return ($months[(int) $month] ?? '-') . ' ' . (int) $year;
    }

    private function formatCompactRupiah($value)
    {
        $value = (float) $value;
        $abs = abs($value);

        if ($abs >= 1000000000) {
            return 'Rp ' . number_format($value / 1000000000, 1, ',', '.') . ' M';
        }

        if ($abs >= 1000000) {
            return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . ' jt';
        }

        if ($abs >= 1000) {
            return 'Rp ' . number_format($value / 1000, 1, ',', '.') . ' rb';
        }

        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    private function formatFullRupiah($value)
    {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }

    private function tableReady($table, $fields = [])
    {
        if (!$this->db->table_exists($table)) {
            return false;
        }

        foreach ($fields as $field) {
            if (!$this->db->field_exists($field, $table)) {
                return false;
            }
        }

        return true;
    }

    private function sumTable($table, $amountExpression, $dateColumn, $start = null, $end = null, $extraWhere = [])
    {
        if (!$this->tableReady($table, [$dateColumn])) {
            return 0;
        }

        $this->db->select('COALESCE(SUM(' . $amountExpression . '), 0) AS total', false);
        $this->db->from($table);
        if ($start !== null && $end !== null) {
            $this->db->where($dateColumn . ' >=', $start);
            $this->db->where($dateColumn . ' <=', $end);
        }

        foreach ($extraWhere as $column => $value) {
            $this->db->where($column, $value);
        }

        $row = $this->db->get()->row_array();

        return (float) ($row['total'] ?? 0);
    }

    private function sumBudget($start = null, $end = null)
    {
        if (!$this->tableReady('tab_budget', ['total_budget'])) {
            return 0;
        }

        $dateColumn = $this->db->field_exists('created_at', 'tab_budget') ? 'created_at' : null;
        $this->db->select('COALESCE(SUM(total_budget), 0) AS total', false);
        $this->db->from('tab_budget');
        if ($dateColumn && $start !== null && $end !== null) {
            $this->db->where('DATE(' . $dateColumn . ') >=', $start);
            $this->db->where('DATE(' . $dateColumn . ') <=', $end);
        }
        $row = $this->db->get()->row_array();

        return (float) ($row['total'] ?? 0);
    }

    private function sumTopup($start = null, $end = null)
    {
        if (!$this->tableReady('tab_topup_saldo', ['nominal'])) {
            return 0;
        }

        $dateColumn = $this->db->field_exists('tgl_topup', 'tab_topup_saldo') ? 'tgl_topup' : 'created_at';

        return $this->sumTable('tab_topup_saldo', 'nominal', $dateColumn, $start, $end);
    }

    private function doctorAmountExpression($table)
    {
        if (!$this->db->table_exists($table) || !$this->db->field_exists('total', $table)) {
            return '0';
        }

        $hasPph = $this->db->field_exists('jumlah_pph', $table);
        $hasNoPph = $this->db->field_exists('jumlah_nopph', $table);
        $hasPphFlag = $this->db->field_exists('pph21', $table);

        if ($hasPph && $hasNoPph && $hasPphFlag) {
            return 'CASE WHEN pph21 = 1 THEN COALESCE(total, 0) - COALESCE(jumlah_pph, 0) ELSE COALESCE(total, 0) + COALESCE(jumlah_nopph, 0) END';
        }

        return 'COALESCE(total, 0)';
    }

    private function sumDoctorProject($start = null, $end = null)
    {
        if (!$this->tableReady('tab_fee_dokter', ['total', 'tgl_project'])) {
            return 0;
        }

        return $this->sumTable('tab_fee_dokter', $this->doctorAmountExpression('tab_fee_dokter'), 'tgl_project', $start, $end);
    }

    private function sumDoctorRetail($start = null, $end = null)
    {
        if (!$this->tableReady('tab_fee_dokter_retail', ['total', 'tgl_project'])) {
            return 0;
        }

        return $this->sumTable('tab_fee_dokter_retail', $this->doctorAmountExpression('tab_fee_dokter_retail'), 'tgl_project', $start, $end);
    }

    private function operationalSources()
    {
        return [
            ['table' => 'tab_entertain', 'date' => 'tgl_mulai', 'amount' => 'total', 'label' => 'Entertain'],
            ['table' => 'tab_makan', 'date' => 'tgl_makan', 'amount' => 'total', 'label' => 'Makan'],
            ['table' => 'tab_fee_freelance', 'date' => 'tgl_fee', 'amount' => 'total', 'label' => 'Freelance'],
            ['table' => 'tab_transport', 'date' => 'tgl_transport', 'amount' => 'nominal', 'label' => 'Transport'],
            ['table' => 'tab_penginapan', 'date' => 'tgl_checkin', 'amount' => 'nominal', 'label' => 'Penginapan'],
        ];
    }

    private function sumOperational($start = null, $end = null)
    {
        $total = 0;

        foreach ($this->operationalSources() as $source) {
            if ($this->tableReady($source['table'], [$source['date'], $source['amount']])) {
                $total += $this->sumTable($source['table'], $source['amount'], $source['date'], $start, $end);
            }
        }

        return $total;
    }

    private function sumOther($start = null, $end = null)
    {
        if (!$this->tableReady('tab_other', ['nominal', 'tanggal'])) {
            return 0;
        }

        return $this->sumTable('tab_other', 'nominal', 'tanggal', $start, $end);
    }

    private function sumExpense($start = null, $end = null)
    {
        return $this->sumDoctorProject($start, $end)
            + $this->sumDoctorRetail($start, $end)
            + $this->sumOperational($start, $end)
            + $this->sumOther($start, $end);
    }

    private function getExpenseTrend($periodStart)
    {
        $labels = [];
        $series = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = date('Y-m-01', strtotime($periodStart . ' -' . $i . ' month'));
            $month = (int) date('n', strtotime($date));
            $year = (int) date('Y', strtotime($date));
            $bounds = $this->periodBounds($month, $year);

            $labels[] = $this->shortMonthLabel($month) . ' ' . $year;
            $series[] = $this->sumExpense($bounds['start'], $bounds['end']);
        }

        return [
            'labels' => $labels,
            'series' => $series,
        ];
    }

    private function shortMonthLabel($month)
    {
        $labels = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        return $labels[(int) $month] ?? '-';
    }

    private function getBudgetRows($start = null, $end = null)
    {
        if (!$this->tableReady('tab_budget', ['project', 'total_budget'])) {
            return [];
        }

        $this->db->select('tab_budget.project, COALESCE(SUM(tab_budget.total_budget), 0) AS budget, tab_project.nama_project, tab_site.nama_site', false);
        $this->db->from('tab_budget');
        $this->db->join('tab_project', 'tab_project.kode_project = tab_budget.project', 'left');
        $this->db->join('tab_site', 'tab_site.id_site = tab_project.site_id', 'left');
        if ($this->db->field_exists('created_at', 'tab_budget') && $start !== null && $end !== null) {
            $this->db->where('DATE(tab_budget.created_at) >=', $start);
            $this->db->where('DATE(tab_budget.created_at) <=', $end);
        }
        $this->db->group_by('tab_budget.project, tab_project.nama_project, tab_site.nama_site');
        $this->db->order_by('budget', 'DESC');
        $this->db->limit(10);
        $budgets = $this->db->get()->result_array();

        $rows = [];
        foreach ($budgets as $budget) {
            $project = $budget['project'];
            $budgetValue = (float) ($budget['budget'] ?? 0);
            $realization = $this->sumProjectExpense($project, $start, $end);
            $percentage = $budgetValue > 0 ? round(($realization / $budgetValue) * 100) : 0;
            $status = $percentage >= 90 ? 'Waspada' : 'Normal';

            $rows[] = [
                'name' => $budget['nama_site'] ?: ($budget['nama_project'] ?: $project),
                'budget' => $budgetValue,
                'budget_label' => $this->formatCompactRupiah($budgetValue),
                'realization' => $realization,
                'realization_label' => $this->formatCompactRupiah($realization),
                'percentage' => min(100, $percentage),
                'status' => $status,
            ];
        }

        return $rows;
    }

    private function sumProjectExpense($project, $start = null, $end = null)
    {
        $total = 0;

        if ($this->tableReady('tab_fee_dokter', ['project', 'total', 'tgl_project'])) {
            $total += $this->sumTable('tab_fee_dokter', $this->doctorAmountExpression('tab_fee_dokter'), 'tgl_project', $start, $end, ['project' => $project]);
        }

        foreach ($this->operationalSources() as $source) {
            if ($this->tableReady($source['table'], ['project', $source['date'], $source['amount']])) {
                $total += $this->sumTable($source['table'], $source['amount'], $source['date'], $start, $end, ['project' => $project]);
            }
        }

        if ($this->tableReady('tab_other', ['project', 'nominal', 'tanggal'])) {
            $total += $this->sumTable('tab_other', 'nominal', 'tanggal', $start, $end, ['project' => $project]);
        }

        return $total;
    }

    private function countPendingApproval($start = null, $end = null)
    {
        $total = 0;
        $tables = array_merge($this->operationalSources(), [
            ['table' => 'tab_other', 'date' => 'tanggal'],
            ['table' => 'tab_fee_dokter', 'date' => 'tgl_project'],
        ]);

        foreach ($tables as $source) {
            if (!$this->tableReady($source['table'], [$source['date']]) || !$this->db->field_exists('approval_status', $source['table'])) {
                continue;
            }

            $this->db->from($source['table']);
            if ($start !== null && $end !== null) {
                $this->db->where($source['date'] . ' >=', $start);
                $this->db->where($source['date'] . ' <=', $end);
            }
            $this->db->group_start();
            $this->db->where('approval_status !=', 'approved');
            $this->db->or_where('approval_status IS NULL', null, false);
            $this->db->group_end();
            $total += (int) $this->db->count_all_results();
        }

        return $total;
    }

    private function getRecentTransactions($start = null, $end = null, $limit = 10)
    {
        $rows = [];
        $this->appendTransactions($rows, 'tab_fee_dokter', 'tgl_project', 'nama_dokter', $this->doctorAmountExpression('tab_fee_dokter'), 'Dokter Project', $start, $end);
        $this->appendTransactions($rows, 'tab_fee_dokter_retail', 'tgl_project', 'nama_dokter', $this->doctorAmountExpression('tab_fee_dokter_retail'), 'Dokter Retail', $start, $end);
        $this->appendTransactions($rows, 'tab_topup_saldo', 'tgl_topup', 'keterangan', 'nominal', 'Top Up', $start, $end);

        foreach ($this->operationalSources() as $source) {
            $description = $source['table'] === 'tab_transport' ? 'transport' : 'keterangan';
            $this->appendTransactions($rows, $source['table'], $source['date'], $description, $source['amount'], $source['label'], $start, $end);
        }

        $this->appendTransactions($rows, 'tab_other', 'tanggal', 'kebutuhan', 'nominal', 'Lain-lain', $start, $end);

        usort($rows, function ($a, $b) {
            return strcmp($b['date'], $a['date']);
        });

        return array_slice($rows, 0, $limit);
    }

    private function appendTransactions(&$rows, $table, $dateColumn, $descriptionColumn, $amountExpression, $category, $start = null, $end = null)
    {
        if (!$this->tableReady($table, [$dateColumn])) {
            return;
        }

        $descriptionSelect = $this->db->field_exists($descriptionColumn, $table) ? $descriptionColumn : "'" . $category . "'";
        $statusSelect = $this->db->field_exists('approval_status', $table) ? 'approval_status' : "'selesai'";

        $this->db->select($dateColumn . ' AS trx_date, ' . $descriptionSelect . ' AS description, ' . $amountExpression . ' AS amount, ' . $statusSelect . ' AS status', false);
        $this->db->from($table);
        if ($start !== null && $end !== null) {
            $this->db->where($dateColumn . ' >=', $start);
            $this->db->where($dateColumn . ' <=', $end);
        }
        $this->db->order_by($dateColumn, 'DESC');
        $this->db->limit(8);

        foreach ($this->db->get()->result_array() as $row) {
            $rows[] = [
                'date' => substr((string) ($row['trx_date'] ?? ''), 0, 10),
                'description' => trim((string) ($row['description'] ?? '')) ?: $category,
                'category' => $category,
                'amount' => (float) ($row['amount'] ?? 0),
                'amount_label' => $this->formatFullRupiah($row['amount'] ?? 0),
                'status' => $this->normalizeStatus($row['status'] ?? ''),
            ];
        }
    }

    private function normalizeStatus($status)
    {
        $status = strtolower(trim((string) $status));

        if ($status === 'approved' || $status === 'selesai') {
            return 'Selesai';
        }

        if ($status === 'validated') {
            return 'Validasi';
        }

        if ($status === 'verified') {
            return 'Verifikasi';
        }

        return 'Menunggu';
    }
}
