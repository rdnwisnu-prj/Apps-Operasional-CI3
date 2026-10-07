<div class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-brand-wrap">
            <a href="<?= base_url(); ?>" class="logo logo-normal sidebar-brand sidebar-brand-full">
                <img src="<?= base_url('assets/img/sidebar.png'); ?>" alt="Cakra Medika Marketing & CRM">
            </a>
            <a href="<?= base_url(); ?>" class="logo-small sidebar-brand sidebar-brand-sm">
                <img src="<?= base_url('assets/img/sidebar-icon.png'); ?>" alt="Cakra Medika Marketing & CRM">
            </a>
        </div>
        <button class="sidenav-toggle-btn btn border-0 p-0 active" id="toggle_btn">
            <i class="ti ti-arrow-bar-to-left"></i>
        </button>
        <button class="sidebar-close">
            <i class="ti ti-x align-middle"></i>
        </button>
    </div>

    <div class="sidebar-inner" data-simplebar>
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <?php  
                $role_id = $this->session->userdata('role_id');

                $this->db->select('tm.id_menu, tm.nama_menu, tm.icon_menu, tm.url_menu, tm.segment_menu, tm.is_dropdown, tm.header');
                $this->db->from('tab_menu tm');
                $this->db->join('tab_access ta', 'tm.id_menu = ta.menu_access');
                $this->db->where('ta.role_id', $role_id);
                $this->db->where('ta.access', 1);
                $this->db->group_by('tm.id_menu');
                $this->db->order_by('tm.order_menu', 'ASC');
                $menu = $this->db->get()->result_array();

                $current_url = current_url();
                
                $grouped_menu = [];
                foreach ($menu as $m) {
                    $header = $m['header'] ? $m['header'] : 'Umum';
                    $grouped_menu[$header][] = $m;
                }
                ?>

                <?php foreach ($grouped_menu as $header => $menu_items): ?>
                <li class="menu-title"><span><?php echo $header; ?></span></li>
                <li>
                    <ul>
                        <?php foreach ($menu_items as $m): ?>
                        <?php if ($m['is_dropdown'] == 0): ?>
                        <li class="<?php echo (base_url() . $m['url_menu'] == $current_url) ? 'active' : '' ?>">
                            <a href="<?php echo base_url() . $m['url_menu']; ?>">
                                <i class="<?php echo $m['icon_menu']; ?>"></i>
                                <span><?php echo $m['nama_menu']; ?></span>
                            </a>
                        </li>

                        <?php elseif ($m['is_dropdown'] == 1): ?>
                        <?php 
                        $this->db->select('tsm.id_submenu, tsm.nama_submenu, tsm.url_submenu, tsm.segment_submenu');
                        $this->db->from('tab_submenu tsm');
                        $this->db->join('tab_access ta', 'FIND_IN_SET(tsm.id_submenu, ta.submenu_access)');
                        $this->db->where('tsm.menu_id', $m['id_menu']);
                        $this->db->where('ta.role_id', $role_id);
                        $this->db->where('ta.menu_access', $m['id_menu']);
                        $this->db->where('ta.access', 1);
                        $this->db->order_by('tsm.order_submenu', 'ASC');
                        $subMenu = $this->db->get()->result_array();
                                                
                        $isActive = false;
                        foreach ($subMenu as $sm) {
                            if (base_url() . $sm['url_submenu'] == $current_url) {
                                $isActive = true;
                                break;
                            }
                        }
                        ?>

                        <?php if (!empty($subMenu)): ?>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="<?php echo $isActive ? 'active subdrop' : '' ?>">
                                <i class="<?php echo $m['icon_menu']; ?>"></i>
                                <span><?php echo $m['nama_menu']; ?></span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul <?php echo $isActive ? 'style="display: block;"' : '' ?>>
                                <?php foreach ($subMenu as $sm): ?>
                                <li>
                                    <a href="<?php echo base_url() . $sm['url_submenu']; ?>"
                                        class="<?php echo (base_url() . $sm['url_submenu'] == $current_url) ? 'active' : '' ?>">
                                        <?php echo $sm['nama_submenu']; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>