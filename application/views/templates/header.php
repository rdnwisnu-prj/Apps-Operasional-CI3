<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-layout="default" data-sidebar="gradientsidebar4" data-topbar="white"
    data-color="teal">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo/favicon.png">

    <!-- Theme Config Js -->
    <script src="<?= base_url()?>assets/js/fixed-theme.js"></script>

    <!-- All CSS -->
    <link rel="stylesheet" href="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?= base_url()?>vendor/template/crms/assets/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/icons/remix/remixicon.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/simplebar/simplebar.min.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/css/style.css" id="app-style">
    <link rel="stylesheet"
        href="<?= base_url()?>vendor/template/crms/assets/plugins/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/flatpickr/flatpickr.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/quill/quill.core.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/quill/quill.snow.css">
    <link rel="stylesheet" href="<?= base_url()?>vendor/template/crms/assets/plugins/quill/quill.bubble.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url()?>assets/css/custom.css">

</head>

<body>
    <div class="main-wrapper">
        <header class="navbar-header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2">
                    <a href="index-2.html" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="<?= base_url()?>assets/img/logo/icon.png" alt="logo"></span>
                            <span class="logo-sm"><img src="<?= base_url()?>assets/img/logo/icon.png"
                                    alt="small logo"></span>
                        </span>

                        <!-- Logo Dark -->
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="<?= base_url()?>assets/img/logo/icon.png"
                                    alt="dark logo"></span>
                        </span>
                    </a>

                    <!-- Sidebar Mobile Button -->
                    <a id="mobile_btn" class="mobile-btn" href="#sidebar">
                        <i class="ti ti-menu-deep fs-24"></i>
                    </a>

                    <button class="sidenav-toggle-btn btn border-0 p-0" id="toggle_btn2">
                        <i class="ti ti-arrow-bar-to-right"></i>
                    </button>

                    <div class="me-auto d-flex align-items-center header-search d-lg-flex d-none">
                        <div class="input-icon position-relative me-2">
                            <h5 class="align-bottom mt-2">Operational Application</h5>
                        </div>
                    </div>

                </div>

                <div class="d-flex align-items-center">

                    <!-- Search for Mobile -->
                    <div class="header-item d-flex d-lg-none me-2">
                        <button class="topbar-link btn" data-bs-toggle="modal" data-bs-target="#searchModal"
                            type="button">
                            <i class="ti ti-search fs-16"></i>
                        </button>
                    </div>


                    <!-- Minimize -->
                    <div class="header-item">
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);" class="btn topbar-link btnFullscreen"><i
                                    class="ti ti-maximize"></i></a>
                        </div>
                    </div>
                    <!-- Minimize -->

                    <div class="header-line"></div>

                    <!-- User Dropdown -->
                    <div class="dropdown profile-dropdown d-flex align-items-center justify-content-center">
                        <a href="javascript:void(0);"
                            class="topbar-link dropdown-toggle drop-arrow-none position-relative"
                            data-bs-toggle="dropdown" data-bs-offset="0,22" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= base_url('upload/employee/' . $this->session->userdata('foto')); ?>"
                                width="28" class="rounded-1 d-flex" alt="user-image">
                            <span class="online text-success"><i
                                    class="ti ti-circle-filled d-flex bg-white rounded-circle border border-1 border-white"></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-2">

                            <div class="d-flex align-items-center bg-light rounded-3 p-2 mb-2">
                                <img src="<?= base_url('upload/employee/' . $this->session->userdata('foto')); ?>"
                                    class="rounded-circle" width="42" height="42" alt="Img">
                                <div class="ms-2">
                                    <p class="fw-medium text-dark mb-0"><?= $this->session->userdata('nama'); ?></p>
                                    <span class="d-block fs-13"><?= $this->session->userdata('jabatan'); ?></span>
                                </div>
                            </div>

                            <!-- Item-->
                            <a href="<?=base_url()?>Profile" class="dropdown-item">
                                <i class="ti ti-user-circle me-1 align-middle"></i>
                                <span class="align-middle">Pengaturan Profil</span>
                            </a>

                            <!-- Item-->
                            <div class="pt-2 mt-2 border-top">
                                <a href="<?= base_url('Auth/logout')?>" class="dropdown-item text-danger btn-logout">
                                    <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                                    <span class="align-middle">Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </header>