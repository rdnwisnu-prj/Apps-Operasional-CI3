<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cognix Marketing Application - Lupa Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/favicon-cakra.png'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/template/crms/assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/template/crms/assets/plugins/icons/remix/remixicon.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
</head>

<body class="login-body">
    <main class="login-page">

        <?php if ($this->session->flashdata('flash')): ?>
        <div class="flash-logout" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('flash')): ?>
        <div class="flash-login" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
        <?php endif; ?>

        <section class="login-shell">
            <div class="login-hero">
                <div class="login-badge"><i class="ri-line-chart-line"></i> CRM & Marketing Workspace Application.
                </div>
                <h1>Pipeline, client, dan revenue dalam satu ruang kerja.</h1>
                <p>Built for daily marketing operations with clean visibility across prospects, projects, and clients.
                </p>
                <div class="login-stats">
                    <div class="login-stat">
                        <strong>Client</strong><span>Manage your Clients</span>
                    </div>
                    <div class="login-stat"><strong>Leads</strong><span>Manage your Leads</span></div>
                    <div class="login-stat"><strong>Project</strong><span>Manage your Projects</span></div>
                </div>
            </div>
            <div class="login-card">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/logo-cakra.png'); ?>" class="login-logo mx-auto"
                        alt="Cakra Corp">
                    <h2>Lupa Password ?</h2>
                    <p class="subtitle">Jika Anda lupa kata sandi Anda, kami akan mengirimkan email
                        kepada Anda
                        petunjuk untuk mengatur ulang kata sandi Anda
                    </p>
                </div>
                <?php if (validation_errors()): ?>
                <div class="login-alert" role="alert">
                    <i class="ri-error-warning-line"></i>
                    <div><?= validation_errors('<span>', '</span>'); ?></div>
                </div>
                <?php endif; ?>
                <form action="<?= base_url('Auth/ForgotPassword') ?>" method="post" autocomplete="on">
                    <div class="mb-3">
                        <label class="form-label-modern" for="email">Email</label>
                        <div class="input-wrap">
                            <i class="ri-mail-line input-icon"></i>
                            <input type="text" class="form-control-modern" id="email" name="email"
                                value="<?= set_value('email') ?>" placeholder="Masukkan Email Anda">
                        </div>
                    </div>
                    <button type="submit" class="login-btn mt-2"> <span>Submit</span>
                        <i class="ri-arrow-right-circle-line"></i></button>

                    <div class="pt-4 pb-1 text-center">
                        <p class="mb-0">Kembali ke Halaman <a href="<?= base_url('Auth') ?>"
                                class="link-indigo fw-bold link-hover"> Login</a></p>
                    </div>
                </form>
                <div class="login-card-note"><i class="ri-shield-check-line"></i> Akses aman untuk tim internal
                    perusahaan.</div>
                <p class="login-footer">&copy; <?= date('Y') ?> Cakra Corp. Developed by IT Team</p>
            </div>
        </section>
    </main>
    <script src="<?= base_url('vendor/template/crms/assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('vendor/template/crms/assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/js/proses.js'); ?>"></script>
</body>

</html>