<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
?>
<div class="page-wrapper">

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= html_escape($header); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Other'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Tambah <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Tambah <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Other'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-add-other" action="<?= base_url('Other/Store'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2">Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project" name="project">
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>" <?= set_select('project', $project['kode_project']); ?>>
                                    <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="proses" class="col-form-label col-lg-2">Proses <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('proses') ? 'is-invalid' : ''; ?>" id="proses" name="proses" required>
                                <option value="">-- Pilih Proses --</option>
                                <?php foreach ($proses_labels as $value => $label): ?>
                                <option value="<?= html_escape($value); ?>" <?= set_select('proses', $value); ?>><?= html_escape($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('proses'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tanggal" class="col-form-label col-lg-2">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tanggal') ? 'is-invalid' : ''; ?>" id="tanggal" name="tanggal" value="<?= set_value('tanggal'); ?>" autocomplete="off">
                            <div class="invalid-feedback"><?= form_error('tanggal'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kebutuhan" class="col-form-label col-lg-2">Kebutuhan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="kebutuhan" name="kebutuhan" value="<?= set_value('kebutuhan'); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nominal" class="col-form-label col-lg-2">Nominal</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control format-number js-calc-other" id="nominal_display" value="<?= set_value('nominal') ? number_format((float) set_value('nominal'), 0, ',', '.') : ''; ?>" placeholder="0">
                            <input type="hidden" id="nominal" name="nominal" value="<?= set_value('nominal'); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-form-label col-lg-2">Upload Bukti/Struk</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maks 5MB.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="keterangan" class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= set_value('keterangan'); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url('Other'); ?>">Cancel</a>
                <button type="submit" form="form-add-other" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#tanggal', {dateFormat: 'Y-m-d', altInput: true, altFormat: 'd M Y', allowInput: true});
    }

    function cleanNumber(value) {
        return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
    }

    $('#nominal_display').on('input change', function() {
        $('#nominal').val(cleanNumber(this.value));
    });
});
</script>
