<?php
$proses_options = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$jobdesk_options = ['TENSI','TBB','VISUS','EKG','AUDIO','SPIRO','REGISTRASI LAB','REGISTASI MCU','FINAL','ANALIS SAMPLING','PENJAGA URINE','PENJAGA SNACK/SOUVENIR','DRIVER RONTGEN','ADMIN RONTGEN','ATRO RO','SETTING','AUTOREFF','TRIALENS','KORLAP','BIDAN (Papsmear)','Cek Formulir'];
$tglMulaiValue = set_value('tgl_mulai', $edit_data['tgl_mulai'] ?? '');
$tglSelesaiValue = set_value('tgl_selesai', $edit_data['tgl_selesai'] ?? '');
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
                    <li class="breadcrumb-item"><a href="<?= base_url('Entertain'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Edit <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Entertain'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-edit-entertain" action="<?= base_url('Entertain/update'); ?>" method="post">
                    <input type="hidden" name="id_entertain" value="<?= html_escape($edit_data['id_entertain']); ?>">

                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2 text-lg-end">Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project" name="project">
                                <option value="" data-start="" data-end="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>"
                                    data-start="<?= html_escape($project['tgl_mulai']); ?>"
                                    data-end="<?= html_escape($project['tgl_selesai']); ?>"
                                    <?= set_select('project', $project['kode_project'], $edit_data['project'] == $project['kode_project']); ?>>
                                    <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_mulai" class="col-form-label col-lg-2 text-lg-end">Tanggal Mulai <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control js-date-entertain <?= form_error('tgl_mulai') ? 'is-invalid' : ''; ?>"
                                id="tgl_mulai" name="tgl_mulai" value="<?= html_escape($tglMulaiValue); ?>" autocomplete="off"
                                placeholder="Pilih tanggal mulai">
                            <div class="invalid-feedback"><?= form_error('tgl_mulai'); ?></div>
                        </div>
                        <label for="tgl_selesai" class="col-form-label col-lg-2 text-lg-end">Tanggal Selesai <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control js-date-entertain <?= form_error('tgl_selesai') ? 'is-invalid' : ''; ?>"
                                id="tgl_selesai" name="tgl_selesai" value="<?= html_escape($tglSelesaiValue); ?>" autocomplete="off"
                                placeholder="Pilih tanggal selesai">
                            <div class="invalid-feedback"><?= form_error('tgl_selesai'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="proses" class="col-form-label col-lg-2 text-lg-end">Proses <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('proses') ? 'is-invalid' : ''; ?>" id="proses" name="proses">
                                <option value="">-- Pilih Proses --</option>
                                <?php foreach ($proses_options as $value => $label): ?>
                                <option value="<?= $value; ?>" <?= set_select('proses', $value, (string) $edit_data['proses'] === (string) $value); ?>>
                                    <?= $label; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('proses'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama_karyawan" class="col-form-label col-lg-2 text-lg-end">Nama Karyawan <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('nama_karyawan') ? 'is-invalid' : ''; ?>" id="nama_karyawan" name="nama_karyawan" value="<?= set_value('nama_karyawan', $edit_data['nama_karyawan']); ?>">
                            <div class="invalid-feedback"><?= form_error('nama_karyawan'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jobdesk" class="col-form-label col-lg-2 text-lg-end">Jobdesk <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('jobdesk') ? 'is-invalid' : ''; ?>" id="jobdesk" name="jobdesk">
                                <option value="">-- Pilih Jobdesk --</option>
                                <?php foreach ($jobdesk_options as $job): ?>
                                <option value="<?= html_escape($job); ?>" <?= set_select('jobdesk', $job, ($edit_data['jobdesk'] ?? '') === $job); ?>>
                                    <?= html_escape($job); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('jobdesk'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jumlah_hari" class="col-form-label col-lg-2 text-lg-end">Jumlah Hari</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control js-calc-entertain" id="jumlah_hari" name="jumlah_hari" value="<?= set_value('jumlah_hari', $edit_data['j_hari']); ?>" step="1" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nominal" class="col-form-label col-lg-2 text-lg-end">Nominal <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <?php $nominalValue = set_value('nominal', $edit_data['nominal']); ?>
                            <input type="text" class="form-control format-number js-calc-entertain" id="nominal_display" value="<?= $nominalValue !== '' ? number_format((float) $nominalValue, 0, ',', '.') : ''; ?>">
                            <input type="hidden" id="nominal" name="nominal" value="<?= html_escape($nominalValue); ?>">
                            <div class="invalid-feedback d-block"><?= form_error('nominal'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total" class="col-form-label col-lg-2 text-lg-end">Total <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <?php $totalValue = set_value('total', $edit_data['total']); ?>
                            <input type="text" class="form-control format-number <?= form_error('total') ? 'is-invalid' : ''; ?>" id="total_display" value="<?= $totalValue !== '' ? number_format((float) $totalValue, 0, ',', '.') : ''; ?>" readonly>
                            <input type="hidden" id="total" name="total" value="<?= html_escape($totalValue); ?>">
                            <div class="invalid-feedback"><?= form_error('total'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="keterangan" class="col-form-label col-lg-2 text-lg-end">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= set_value('keterangan', $edit_data['keterangan']); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url('Entertain'); ?>">Cancel</a>
                <button type="submit" form="form-edit-entertain" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tglMulaiPicker = null;
    var tglSelesaiPicker = null;

    function cleanNumber(value) {
        return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
    }

    function setMoney(name, value) {
        var rounded = Math.round(value || 0);
        $('#' + name).val(rounded);
        if (typeof formatNumber === 'function') {
            $('#' + name + '_display').val(formatNumber(String(rounded)));
        } else {
            $('#' + name + '_display').val(String(rounded));
        }
    }

    function parseDate(value) {
        if (!value) return null;
        var parts = value.split('-');
        if (parts.length !== 3) return null;
        return new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
    }

    function countDays(startValue, endValue) {
        var start = parseDate(startValue);
        var end = parseDate(endValue);
        if (!start || !end || start > end) return 0;
        return Math.round((end - start) / 86400000) + 1;
    }

    function calculateTotal() {
        var days = countDays($('#tgl_mulai').val(), $('#tgl_selesai').val());
        $('#jumlah_hari').val(days || '');
        setMoney('total', days * cleanNumber($('#nominal').val()));
    }

    function getRange() {
        var selected = $('#project option:selected');
        return {
            start: selected.data('start') || '',
            end: selected.data('end') || ''
        };
    }

    function setDateRange(clearValue) {
        var range = getRange();
        var disabled = !range.start || !range.end;

        $('#tgl_mulai, #tgl_selesai').prop('disabled', disabled);
        $('#tgl_mulai, #tgl_selesai').attr('min', range.start).attr('max', range.end);

        if (tglMulaiPicker) {
            tglMulaiPicker.set('minDate', range.start || null);
            tglMulaiPicker.set('maxDate', range.end || null);
            if (tglMulaiPicker.altInput) {
                $(tglMulaiPicker.altInput).prop('disabled', disabled);
            }
            if (clearValue) tglMulaiPicker.clear();
        }

        if (tglSelesaiPicker) {
            tglSelesaiPicker.set('minDate', range.start || null);
            tglSelesaiPicker.set('maxDate', range.end || null);
            if (tglSelesaiPicker.altInput) {
                $(tglSelesaiPicker.altInput).prop('disabled', disabled);
            }
            if (clearValue) tglSelesaiPicker.clear();
        }

        if (clearValue) {
            $('#tgl_mulai, #tgl_selesai, #jumlah_hari').val('');
            calculateTotal();
        }
    }

    if (typeof flatpickr !== 'undefined') {
        var config = {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd M Y',
            allowInput: true,
            onChange: calculateTotal
        };
        tglMulaiPicker = flatpickr('#tgl_mulai', config);
        tglSelesaiPicker = flatpickr('#tgl_selesai', config);
    }

    $(document).off('input.entertainNominal change.entertainNominal', '#nominal_display')
        .on('input.entertainNominal change.entertainNominal', '#nominal_display', function() {
            $('#nominal').val(cleanNumber(this.value));
            calculateTotal();
        });

    $(document).off('input.entertainCalc change.entertainCalc', '.js-calc-entertain, .js-date-entertain')
        .on('input.entertainCalc change.entertainCalc', '.js-calc-entertain, .js-date-entertain', calculateTotal);

    $(document).off('change.entertainProject', '#project').on('change.entertainProject', '#project', function() {
        var kode = $(this).val();
        setDateRange(true);

        if (!kode) {
            setMoney('nominal', 0);
            return;
        }

        $.getJSON(base_url + 'Entertain/getNominal', {
            kode: kode
        }, function(response) {
            if (response && response.nominal) {
                setMoney('nominal', response.nominal);
                calculateTotal();
            }
        });
    });

    setDateRange(false);
    calculateTotal();
});
</script>
