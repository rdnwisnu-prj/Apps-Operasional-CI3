<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?= base_url()?>assets/img/logo.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="<?= base_url()?>assets/img/logo-2.png" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link <?= ($this->uri->segment(1) == 'Profil') ? 'active' : '' ?>"
                        href="<?= base_url('Profil') ?>">
                        <i class="ri-user-line"></i> <span data-key="t-widgets">Profil</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Fitur</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link <?= ($this->uri->segment(2) == 'User') ? 'active' : '' ?>"
                        href="<?= base_url('Activity/User') ?>">
                        <i class="ri-file-list-line"></i> <span data-key="t-widgets">Aktifitas</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>