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
    <div class="main-container">

        <div class="form-wrapper">
            <div class="text-center">
                <img src="<?= base_url()?>assets/img/easy-ga.png" alt="Reimbursement Form Illustration"
                    class="form-image" />
            </div>

            <form action="<?= base_url('RequestAset'); ?>" method="post" enctype="multipart/form-data">

                <div class="form-header">
                    <h4 class="form-title mb-3">Formulir Pemakaian Mobil Operasional Cakra Medika & Konsehat</h4>
                    <p class="form-description">
                        Silahkan lakukan pengisian form dibawah ini terlebih dahulu dengan benar
                    </p>
                </div>

                <div class="form-group mb-4">
                    <label for="nama_req" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_req" id="nama_req" class="form-input"
                        placeholder="Enter Nama Lengkap" />
                    <div class="form-text text-danger">
                        <?= form_error('nama_req') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="nik_req" class="form-label">NIK Karyawan (Optional)</label>
                    <input type="text" name="nik_req" id="nik_req" class="form-input"
                        placeholder="Enter NIK Karyawan" />
                </div>

                <div class="form-group mb-4">
                    <label for="tgl_start_req" class="form-label">Tanggal Mulai Pemakaian <span
                            class="text-danger">*</span></label>
                    <div class="form-icon right">
                        <input type="date" class="form-input form-control-icon" name="tgl_start_req" id="tgl_start_req"
                            placeholder="Pilih Tanggal">
                        <i class="ri-calendar-line"></i>
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('tgl_start_req') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="tgl_end_req" class="form-label">Tanggal Selesai Pemakaian <span
                            class="text-danger">*</span></label>
                    <div class="form-icon right">
                        <input type="date" class="form-input form-control-icon" name="tgl_end_req" id="tgl_end_req"
                            placeholder="Pilih Tanggal">
                        <i class="ri-calendar-line"></i>
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('tgl_end_req') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="jam_pemakaian" class="form-label">Jam Pemakaian <span
                            class="text-danger">*</span></label>
                    <div class="form-icon right">
                        <input type="time" class="form-input form-control-icon" name="jam_pemakaian" id="jam_pemakaian"
                            placeholder="Pilih Jam">
                        <i class="ri-time-line"></i>
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('jam_pemakaian') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="jam_kembali" class="form-label">Jam Kembali <span class="text-danger">*</span></label>
                    <div class="form-icon right">
                        <input type="time" class="form-input form-control-icon" name="jam_kembali" id="jam_kembali"
                            placeholder="Pilih Jam">
                        <i class="ri-time-line"></i>
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('jam_kembali') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="tujuan" class="form-label">Tujuan <span class="text-danger">*</span></label>
                    <input type="text" name="tujuan" id="tujuan" class="form-input" placeholder="Enter Tujuan"
                        value="<?= set_value('tujuan'); ?>" />
                    <div class="form-text text-danger">
                        <?= form_error('tujuan') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <textarea name="keperluan" id="keperluan" rows="3" class="form-textarea"
                        placeholder="Enter Keperluan"><?= set_value('keperluan'); ?></textarea>
                    <div class="form-text text-danger">
                        <?= form_error('keperluan') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="lampiran" class="form-label">Upload SIM <span class="text-danger">*</span></label>
                    <input type="file" name="lampiran" id="lampiran" class="form-input" accept=".jpg,.jpeg,.png,.pdf" />
                    <div class="form-text">
                        Format: JPG, JPEG, PNG, PDF | Maksimal: 2MB
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('lampiran') ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="consent-group">
                        <input type="checkbox" name="declaration" id="declaration" class="form-checkbox" value="1"
                            <?= set_checkbox('declaration', '1'); ?> />
                        <label for="declaration" class="consent-label">
                            Saya setuju dengan syarat dan ketentuan dari GA
                        </label>
                    </div>
                    <div class="form-text text-danger">
                        <?= form_error('declaration') ?>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Form</button>
            </form>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="<?= base_url()?>assets/template/material/assets/js/layout.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= base_url()?>assets/template/material/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="<?= base_url()?>assets/template/material/assets/js/pages/password-addon.init.js"></script>
    <script src="<?= base_url()?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?= base_url()?>assets/js/proses.js"></script>
    <script src="<?= base_url()?>assets/js/main.js"></script>
</body>

</html>
