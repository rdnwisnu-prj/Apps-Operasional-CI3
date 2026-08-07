<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= html_escape($judul); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo/favicon.png">
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendor/template/crms/assets/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="<?= base_url() ?>vendor/template/crms/assets/plugins/tabler-icons/tabler-icons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendor/template/crms/assets/css/style.css" id="app-style">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/login.css">
</head>

<body class="login-page">
    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-login" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <main class="login-shell">
        <section class="login-visual" aria-label="Apps Operasional">
            <div class="login-visual__overlay"></div>
            <div class="login-visual__top">
                <img src="<?= base_url() ?>assets/img/logo/transparent.png" alt="Cakra Corp" class="login-brand__logo">
                <span>Apps Operasional</span>
            </div>
            <div class="login-visual__content">
                <span class="login-kicker">Project Finance Control</span>
                <h1>Operasional project dalam satu ruang kerja.</h1>
                <p>Kontrol biaya, lampiran, dan laporan operasional project dengan akses internal Cakra Corp.</p>
                <div class="login-visual__meta" aria-label="Cakupan modul">
                    <div>
                        <i class="ti ti-report-money"></i>
                        <span>Finance</span>
                    </div>
                    <div>
                        <i class="ti ti-briefcase"></i>
                        <span>Project</span>
                    </div>
                    <div>
                        <i class="ti ti-file-analytics"></i>
                        <span>Report</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="login-panel" aria-label="Form login">
            <div class="login-panel__inner">
                <div class="login-panel__header">
                    <img src="<?= base_url() ?>assets/img/logo/transparent.png" alt="Cakra Corp"
                        class="login-panel__logo">
                    <span class="login-panel__eyebrow">Secure Internal Access</span>
                    <h2>Selamat Datang</h2>
                    <p>Lanjutkan ke dashboard Apps Operasional.</p>
                </div>

                <?php if (validation_errors()): ?>
                <div class="login-alert" role="alert">
                    <i class="ti ti-alert-circle"></i>
                    <div><?= validation_errors('<span>', '</span>'); ?></div>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('Auth') ?>" method="post" class="login-form" autocomplete="on">
                    <div class="login-field">
                        <label for="username">Username / NIK</label>
                        <div class="login-input">
                            <i class="ti ti-user-circle"></i>
                            <input type="text" id="username" name="username" value="<?= set_value('username') ?>"
                                placeholder="Masukkan username atau NIK" autocomplete="username" required autofocus>
                        </div>
                    </div>

                    <div class="login-field">
                        <div class="login-label-row">
                            <label for="password">Password</label>
                        </div>
                        <div class="login-input pass-group">
                            <i class="ti ti-lock-password"></i>
                            <input type="password" id="password" name="password" class="pass-input"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                            <button type="button" class="toggle-password" aria-label="Tampilkan password"
                                aria-pressed="false">
                                <i class="ti ti-eye-off"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-submit">
                        <span>Masuk Dashboard</span>
                        <i class="ti ti-arrow-right"></i>
                    </button>
                </form>

                <div class="login-support">
                    <i class="ti ti-shield-check"></i>
                    <span>Akses dibatasi untuk user terdaftar.</span>
                </div>

                <p class="login-footer">
                    Copyright &copy; <span id="login-year"></span> Cakra Corp. Developed by IT Team
                </p>
            </div>
        </section>
    </main>

    <script src="<?= base_url() ?>assets/vendor/jquery.min.js"></script>
    <script src="<?= base_url() ?>vendor/template/crms/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>vendor/template/crms/assets/js/script.js"></script>
    <script src="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>assets/js/login.js"></script>
    <script src="<?= base_url() ?>assets/js/proses.js"></script>
</body>

</html>