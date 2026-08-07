<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$jobdesk_options = ['TENSI','TBB','VISUS','EKG','AUDIO','SPIRO','REGISTRASI LAB','REGISTASI MCU','FINAL','ANALIS SAMPLING','PENJAGA URINE','PENJAGA SNACK/SOUVENIR','DRIVER RONTGEN','ADMIN RONTGEN','ATRO RO','SETTING','AUTOREFF','TRIALENS','KORLAP','BIDAN (Papsmear)','Cek Formulir'];
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
                    <li class="breadcrumb-item"><a
                            href="<?= base_url('Freelance'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Tambah <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Tambah <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Freelance'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-add-freelance" action="<?= base_url('Freelance/Store'); ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2">Project <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project"
                                name="project" required>
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>"
                                    <?= set_select('project', $project['kode_project']); ?>>
                                    <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="proses" class="col-form-label col-lg-2">Proses <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('proses') ? 'is-invalid' : ''; ?>" id="proses"
                                name="proses" required>
                                <option value="">-- Pilih Proses --</option>
                                <?php foreach ($proses_labels as $value => $label): ?>
                                <option value="<?= html_escape($value); ?>" <?= set_select('proses', $value); ?>>
                                    <?= html_escape($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('proses'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_fee" class="col-form-label col-lg-2">Tanggal Fee <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tgl_fee') ? 'is-invalid' : ''; ?>"
                                id="tgl_fee" name="tgl_fee" value="<?= set_value('tgl_fee'); ?>"
                                placeholder="Input Tanggal Fee">
                            <div class="invalid-feedback"><?= form_error('tgl_fee'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jobdesk" class="col-form-label col-lg-2">Jobdesk <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('jobdesk') ? 'is-invalid' : ''; ?>" id="jobdesk"
                                name="jobdesk" required>
                                <option value="">-- Pilih Jobdesk --</option>
                                <?php foreach ($jobdesk_options as $jobdesk): ?>
                                <option value="<?= html_escape($jobdesk); ?>" <?= set_select('jobdesk', $jobdesk); ?>>
                                    <?= html_escape($jobdesk); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('jobdesk'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jumlah_orang" class="col-form-label col-lg-2">Jumlah Orang <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="number"
                                class="form-control <?= form_error('jumlah_orang') ? 'is-invalid' : ''; ?>"
                                id="jumlah_orang" name="jumlah_orang" value="<?= set_value('jumlah_orang', 1); ?>"
                                step="any" min="0" required>
                            <div class="invalid-feedback"><?= form_error('jumlah_orang'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jumlah_hari" class="col-form-label col-lg-2">Jumlah Hari <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="number"
                                class="form-control <?= form_error('jumlah_hari') ? 'is-invalid' : ''; ?>"
                                id="jumlah_hari" name="jumlah_hari" value="<?= set_value('jumlah_hari'); ?>" step="any"
                                min="0" required>
                            <div class="invalid-feedback"><?= form_error('jumlah_hari'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="fee" class="col-form-label col-lg-2">Fee <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('fee') ? 'is-invalid' : ''; ?>"
                                id="fee_display"
                                value="<?= set_value('fee') ? number_format((float) set_value('fee'), 0, ',', '.') : ''; ?>"
                                placeholder="0" required>
                            <input type="hidden" id="fee" name="fee" value="<?= set_value('fee'); ?>">
                            <div class="invalid-feedback"><?= form_error('fee'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="biaya_tambahan" class="col-form-label col-lg-2">Biaya Tambahan</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="biaya_tambahan_display"
                                value="<?= set_value('biaya_tambahan') ? number_format((float) set_value('biaya_tambahan'), 0, ',', '.') : ''; ?>"
                                placeholder="0">
                            <input type="hidden" id="biaya_tambahan" name="biaya_tambahan"
                                value="<?= set_value('biaya_tambahan', 0); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total" class="col-form-label col-lg-2">Total</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="total_display"
                                value="<?= set_value('total') ? number_format((float) set_value('total'), 0, ',', '.') : ''; ?>"
                                placeholder="0" readonly>
                            <input type="hidden" id="total" name="total" value="<?= set_value('total'); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-form-label col-lg-2">Lampiran</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" id="lampiran" name="lampiran"
                                accept="image/jpeg,image/png">
                            <small class="text-muted">Format JPG/PNG. File akan dikompres otomatis maksimal
                                100KB.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="keterangan" class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="keterangan" name="keterangan"
                                rows="3"><?= set_value('keterangan'); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url('Freelance'); ?>">Cancel</a>
                <button type="submit" form="form-add-freelance" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#tgl_fee', {
            dateFormat: 'Y-m-d',
            allowInput: true
        });
    }

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

    function setMoney(name, value) {
        var rounded = Math.round(value || 0);
        $('#' + name).val(rounded);
        $('#' + name + '_display').val(displayNumber(rounded));
    }

    function calculateTotal() {
        var total = cleanNumber($('#jumlah_orang').val()) * cleanNumber($('#jumlah_hari').val()) * cleanNumber(
            $('#fee').val());
        total += cleanNumber($('#biaya_tambahan').val());
        setMoney('total', total);
    }

    $('#fee_display').on('input change', function() {
        $('#fee').val(cleanNumber(this.value));
        calculateTotal();
    });

    $('#biaya_tambahan_display').on('input change', function() {
        $('#biaya_tambahan').val(cleanNumber(this.value));
        calculateTotal();
    });

    $('#jumlah_orang, #jumlah_hari').on('input change', calculateTotal);
    calculateTotal();
});
</script>