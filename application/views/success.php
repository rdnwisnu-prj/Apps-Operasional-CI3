<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title><?= $judul?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url()?>assets/img/favicon.ico">

    <link href="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />

    <link href="<?= base_url()?>assets/template/material/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>assets/template/material/assets/css/icons.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>assets/template/material/assets/css/app.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>assets/template/material/assets/css/custom.min.css" rel="stylesheet" />


    <link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body>

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-login" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <div class="auth-page-wrapper pt-10">


        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4">
                            <a href="index.html" class="d-inline-block auth-logo">
                                <img src="<?= base_url()?>assets/img/easy-ga.png" alt="" height="70">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4 text-center">
                                <div class="avatar-lg mx-auto mt-2">
                                    <div class="avatar-title bg-light text-success display-3 rounded-circle">
                                        <i class="ri-checkbox-circle-fill"></i>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <h4>Well done !</h4>
                                    <p class="text-muted mx-4">Terima kasih sudah melakukan request
                                    </p>
                                    <div class="mt-4">
                                        <a href="<?php echo base_url()?>RequestAset"
                                            class="btn btn-success w-100">Kembali ke
                                            Form</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                document.write(new Date().getFullYear())
                                </script> Cakra Corp. Develop by IT Team
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url()?>assets/template/material/assets/js/layout.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="<?= base_url()?>assets/template/material/assets/js/pages/password-addon.init.js"></script>
    <script src="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url()?>assets/js/proses.js"></script>
</body>

</html>
