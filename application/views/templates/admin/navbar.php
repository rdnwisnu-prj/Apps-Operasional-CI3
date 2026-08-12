<div class="content-page">

    <div class="navbar-custom">
        <div class="topbar">
            <div class="topbar-menu d-flex align-items-center gap-1">
                <div class="logo-box">
                    <a href="index.html" class="logo-light">
                        <img src="<?= base_url()?>assets/template/ubold/assets/images/logo-light.png" alt="logo"
                            class="logo-lg">
                        <img src="<?= base_url()?>assets/template/ubold/assets/images/logo-sm.png" alt="small logo"
                            class="logo-sm">
                    </a>
                    <a href="index.html" class="logo-dark">
                        <img src="<?= base_url()?>assets/template/ubold/assets/images/logo-dark.png" alt="dark logo"
                            class="logo-lg">
                        <img src="<?= base_url()?>assets/template/ubold/assets/images/logo-sm.png" alt="small logo"
                            class="logo-sm">
                    </a>
                </div>
                <button class="button-toggle-menu">
                    <i class="mdi mdi-menu"></i>
                </button>

            </div>

            <ul class="topbar-menu d-flex align-items-center">

                <li class="d-none d-md-inline-block">
                    <a class="nav-link waves-effect waves-light" href="" data-toggle="fullscreen">
                        <i class="fe-maximize font-22"></i>
                    </a>
                </li>


                <li class="dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?= base_url()?>assets/template/ubold/assets/images/users/user-1.jpg" alt="user-image"
                            class="rounded-circle">
                        <span class="ms-1 d-none d-md-inline-block">
                            Geneva <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-settings"></i>
                            <span>Settings</span>
                        </a>
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="fe-lock"></i>
                            <span>Lock Screen</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('Auth/logout')?>" class="dropdown-item notify-item btn-logout">
                            <i class="fe-log-out"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>
            </ul>
        </div>
    </div>