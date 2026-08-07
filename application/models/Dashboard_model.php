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

}