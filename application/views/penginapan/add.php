<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$tipe_hunian_options = ['Hotel', 'Mess', 'Sewa Rumah'];
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
                    <li class="breadcrumb-item"><a href="<?= base_url('Penginapan'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Tambah <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Tambah <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Penginapan'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-add-penginapan" action="<?= base_url('Penginapan/Store'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2">Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project" name="project" required>
                                <option value="" data-start="" data-end="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>" data-start="<?= html_escape($project['tgl_mulai']); ?>" data-end="<?= html_escape($project['tgl_selesai']); ?>" <?= set_select('project', $project['kode_project']); ?>>
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
                        <label for="tgl_checkin" class="col-form-label col-lg-2">Tanggal Checkin <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tgl_checkin') ? 'is-invalid' : ''; ?>" id="tgl_checkin" name="tgl_checkin" value="<?= set_value('tgl_checkin'); ?>" autocomplete="off" required>
                            <div class="invalid-feedback"><?= form_error('tgl_checkin'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_checkout" class="col-form-label col-lg-2">Tanggal Checkout <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tgl_checkout') ? 'is-invalid' : ''; ?>" id="tgl_checkout" name="tgl_checkout" value="<?= set_value('tgl_checkout'); ?>" autocomplete="off" required>
                            <div class="invalid-feedback"><?= form_error('tgl_checkout'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jumlah_hari" class="col-form-label col-lg-2">Jumlah Hari</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control <?= form_error('jumlah_hari') ? 'is-invalid' : ''; ?>" id="jumlah_hari" name="jumlah_hari" value="<?= set_value('jumlah_hari'); ?>" readonly>
                            <div class="invalid-feedback"><?= form_error('jumlah_hari'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nominal" class="col-form-label col-lg-2">Nominal <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('nominal') ? 'is-invalid' : ''; ?>" id="nominal_display" value="<?= set_value('nominal') ? number_format((float) set_value('nominal'), 0, ',', '.') : ''; ?>" placeholder="0" required>
                            <input type="hidden" id="nominal" name="nominal" value="<?= set_value('nominal'); ?>">
                            <div class="invalid-feedback"><?= form_error('nominal'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama_hunian" class="col-form-label col-lg-2">Nama Hunian <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('nama_hunian') ? 'is-invalid' : ''; ?>" id="nama_hunian" name="nama_hunian" value="<?= set_value('nama_hunian'); ?>" required>
                            <div class="invalid-feedback"><?= form_error('nama_hunian'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tipe_hunian" class="col-form-label col-lg-2">Tipe Hunian <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('tipe_hunian') ? 'is-invalid' : ''; ?>" id="tipe_hunian" name="tipe_hunian" required>
                                <option value="">-- Pilih Tipe Hunian --</option>
                                <?php foreach ($tipe_hunian_options as $option): ?>
                                <option value="<?= html_escape($option); ?>" <?= set_select('tipe_hunian', $option); ?>><?= html_escape($option); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('tipe_hunian'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="invoice" class="col-form-label col-lg-2">Invoice/Bukti</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" id="invoice" name="invoice" accept="image/jpeg,image/png">
                            <small class="text-muted">Format JPG/PNG. Maks upload 5MB, disimpan maksimal 100KB.</small>
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
                <a href="<?= base_url('Penginapan'); ?>">Cancel</a>
                <button type="submit" form="form-add-penginapan" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var checkinPicker = null;
    var checkoutPicker = null;

    function cleanNumber(value) {
        return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
    }

    function displayNumber(value) {
        var rounded = Math.round(value || 0);
        if (typeof formatNumber === 'function') {
            return formatNumber(String(rounded));
        }
        return String(rounded).replace(/B(?=(d{3})+(?!d))/g, '.');
    }

    function getRange() {
        var selected = $('#project option:selected');
        return {
            start: selected.attr('data-start') || '',
            end: selected.attr('data-end') || ''
        };
    }

    function parseDate(value) {
        if (!value) return null;
        var parts = value.split('-');
        if (parts.length !== 3) return null;
        return new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
    }

    function calculateDays() {
        var checkin = parseDate($('#tgl_checkin').val());
        var checkout = parseDate($('#tgl_checkout').val());
        var days = 0;
        if (checkin && checkout && checkout >= checkin) {
            days = Math.round((checkout - checkin) / 86400000) + 1;
        }
        $('#jumlah_hari').val(days);
    }

    function destroyPickers() {
        if (checkinPicker && typeof checkinPicker.destroy === 'function') checkinPicker.destroy();
        if (checkoutPicker && typeof checkoutPicker.destroy === 'function') checkoutPicker.destroy();
        checkinPicker = null;
        checkoutPicker = null;
    }

    function initPickers(clearValue) {
        var range = getRange();
        var checkinValue = clearValue ? '' : $('#tgl_checkin').val();
        var checkoutValue = clearValue ? '' : $('#tgl_checkout').val();

        destroyPickers();
        $('#tgl_checkin').val(checkinValue).attr('min', range.start || '').attr('max', range.end || '');
        $('#tgl_checkout').val(checkoutValue).attr('min', range.start || '').attr('max', range.end || '');

        if (typeof flatpickr !== 'undefined') {
            checkinPicker = flatpickr('#tgl_checkin', {
                dateFormat: 'Y-m-d',
                allowInput: true,
                disableMobile: true,
                minDate: range.start || null,
                maxDate: range.end || null,
                onChange: function() {
                    var checkin = $('#tgl_checkin').val();
                    if (checkoutPicker && checkin) checkoutPicker.set('minDate', checkin);
                    calculateDays();
                }
            });
            checkoutPicker = flatpickr('#tgl_checkout', {
                dateFormat: 'Y-m-d',
                allowInput: true,
                disableMobile: true,
                minDate: checkinValue || range.start || null,
                maxDate: range.end || null,
                onChange: calculateDays
            });
        }

        calculateDays();
    }

    $('#project').on('change', function() { initPickers(true); });
    $('#tgl_checkin, #tgl_checkout').on('input change', calculateDays);
    $('#nominal_display').on('input change', function() {
        $('#nominal').val(cleanNumber(this.value));
        calculateDays();
    });

    initPickers(false);
});
</script>
