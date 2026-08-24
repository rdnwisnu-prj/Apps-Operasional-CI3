<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= html_escape($title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo/favicon.png'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/template/crms/assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/template/crms/assets/plugins/icons/remix/remixicon.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css'); ?>">
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
                <div class="login-badge"><i class="ri-line-chart-line"></i> Operational Management System</div>
                <h1>Operasional project dalam satu ruang kerja.</h1>
                <p>Kontrol biaya, lampiran, dan laporan operasional project dengan akses internal Cakra Corp.</p>
                <div class="login-stats">
                    <div class="login-stat"><strong>Finance</strong><span>Monitoring Keuangan Operasional</span></div>
                    <div class="login-stat"><strong>Project</strong><span>Data Operasional Project</span></div>
                    <div class="login-stat"><strong>Report</strong><span>Akses khusus internal</span></div>
                </div>
            </div>
            <div class="login-card">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/logo/transparent.png'); ?>" class="login-logo mx-auto"
                        alt="Cakra Corp">
                    <h2>Selamat Datang</h2>
                    <p class="subtitle">Masuk untuk mengakses dashboard Aplikasi Operasional.</p>
                </div>
                <?php if (validation_errors()): ?>
                <div class="login-alert" role="alert">
                    <i class="ri-error-warning-line"></i>
                    <div><?= validation_errors('<span>', '</span>'); ?></div>
                </div>
                <?php endif; ?>
                <form action="<?= base_url('Auth') ?>" method="post" autocomplete="on">
                    <div class="mb-3">
                        <label class="form-label-modern" for="username">Username</label>
                        <div class="input-wrap">
                            <i class="ri-user-3-line input-icon"></i>
                            <input type="text" class="form-control-modern" id="username" name="username"
                                value="<?= set_value('username') ?>" placeholder="Masukkan username"
                                autocomplete="username" required autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-modern" for="signin-password">Password</label>
                        <div class="input-wrap">
                            <i class="ri-lock-password-line input-icon"></i>
                            <input id="signin-password" type="password" class="form-control-modern"
                                placeholder="Masukkan password" name="password" autocomplete="current-password"
                                required>
                            <button type="button" class="password-toggle" aria-label="Tampilkan password"
                                aria-pressed="false"><i class="ri-eye-off-line align-middle"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="login-btn mt-2">Masuk Dashboard</button>
                </form>
                <div class="login-card-note"><i class="ri-shield-check-line"></i> Akses aman untuk tim internal
                    perusahaan.</div>
                <p class="login-footer">&copy; <?= date('Y') ?> Cakra Corp. Developed by IT Team</p>
            </div>
        </section>
    </main>
    <script src="<?= base_url('assets/template/crms/assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/template/crms/assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/proses.js'); ?>"></script>
    <script>
    document.querySelector('.password-toggle').addEventListener('click', function() {
        const passwordInput = document.getElementById('signin-password');
        const passwordIcon = this.querySelector('i');
        const showPassword = passwordInput.type === 'password';
        passwordInput.type = showPassword ? 'text' : 'password';
        passwordIcon.classList.toggle('ri-eye-off-line', !showPassword);
        passwordIcon.classList.toggle('ri-eye-line', showPassword);
        this.setAttribute('aria-label', showPassword ? 'Sembunyikan password' : 'Tampilkan password');
        this.setAttribute('aria-pressed', showPassword ? 'true' : 'false');
    });
    </script>
</body>

</html>