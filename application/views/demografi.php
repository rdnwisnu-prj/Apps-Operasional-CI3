<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title><?= $title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?= base_url()?>assets/img/favicon.ico">

    <link href="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url()?>vendor/template/material/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>vendor/template/material/assets/css/icons.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>vendor/template/material/assets/css/app.min.css" rel="stylesheet" />
    <link href="<?= base_url()?>vendor/template/material/assets/css/custom.min.css" rel="stylesheet" />


    <link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body>

    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <img src="https://img.themesbrand.com/velzon/images/auth-offline.gif" alt=""
                                        height="210">
                                    <h3 class="mt-4 fw-semibold">We're currently offline</h3>
                                    <p class="text-muted mb-4 fs-14">We can't show you this images because you aren't
                                        connected to the internet. When you’re back online refresh the page or hit the
                                        button below</p>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/js/layout.js"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= base_url()?>vendor/template/material/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="<?= base_url()?>vendor/template/material/assets/js/pages/password-addon.init.js"></script>
    <script src="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url()?>assets/js/proses.js"></script>
</body>

</html>