<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $judul ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/logo/favicon.ico">
    <link rel="stylesheet" href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendor/template/crms/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>vendor/template/crms/assets/plugins/tabler-icons/tabler-icons.min.css">
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
        <section class="login-visual" aria-label="Operasional overview">
            <div class="login-visual__shade"></div>
            <div class="login-brand">
                <img src="<?= base_url() ?>assets/img/logo-2.png" alt="Cognix" class="login-brand__logo">
            </div>
            <div class="login-visual__content">
                <span class="login-kicker">Apps Operasional</span>
                <h1>Reset Akses User</h1>
                <p>Validasi akun menggunakan data yang tersedia di tab_user: username atau NIK karyawan.</p>
                <div class="login-stats" aria-label="Reset requirements">
                    <div>
                        <strong>Username</strong>
                        <span>Login ID</span>
                    </div>
                    <div>
                        <strong>NIK</strong>
                        <span>Employee ID</span>
                    </div>
                    <div>
                        <strong>Password</strong>
                        <span>Temporary</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="login-panel" aria-label="Reset password form">
            <div class="login-panel__inner">
                <div class="login-panel__header">
                    <img src="<?= base_url() ?>assets/img/logo.png" alt="Cakra Corp" class="login-panel__logo">
                    <span class="login-panel__eyebrow">Account Recovery</span>
                    <h2>Reset Password</h2>
                    <p>Masukkan username/NIK dan NIK karyawan. Password sementara akan tampil satu kali setelah data cocok.</p>
                </div>

                <?php if (validation_errors()): ?>
                <div class="login-alert" role="alert">
                    <i class="ti ti-alert-circle"></i>
                    <div><?= validation_errors('<span>', '</span>'); ?></div>
                </div>
                <?php endif; ?>

                <?php if (!empty($temporary_password) && !empty($reset_user)): ?>
                <div class="login-result" role="status">
                    <span class="login-result__label">Password sementara untuk <?= html_escape($reset_user['nama']); ?></span>
                    <strong><?= html_escape($temporary_password); ?></strong>
                    <small>Gunakan password ini untuk login, lalu segera ubah password dari menu profil.</small>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('Auth/ForgotPassword') ?>" method="post" class="login-form" autocomplete="off">
                    <div class="login-field">
                        <label for="username">Username / NIK</label>
                        <div class="login-input">
                            <i class="ti ti-user"></i>
                            <input type="text" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Masukkan username atau NIK" required autofocus>
                        </div>
                    </div>

                    <div class="login-field">
                        <label for="nik">NIK</label>
                        <div class="login-input">
                            <i class="ti ti-id-badge-2"></i>
                            <input type="text" id="nik" name="nik" value="<?= set_value('nik') ?>" placeholder="Masukkan NIK karyawan" required>
                        </div>
                    </div>

                    <button type="submit" class="login-submit">
                        <span>Reset Password</span>
                        <i class="ti ti-refresh"></i>
                    </button>
                </form>

                <p class="login-back">
                    <a href="<?= base_url('Auth') ?>"><i class="ti ti-arrow-left"></i> Kembali ke Login</a>
                </p>

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
