<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$jobdesk_options = ['TENSI','TBB','VISUS','EKG','AUDIO','SPIRO','REGISTRASI LAB','REGISTASI MCU','FINAL','ANALIS SAMPLING','PENJAGA URINE','PENJAGA SNACK/SOUVENIR','DRIVER RONTGEN','ADMIN RONTGEN','ATRO RO','SETTING','AUTOREFF','TRIALENS','KORLAP','BIDAN (Papsmear)','Cek Formulir'];

$current_role_id = (int) $this->session->userdata('role_id');
$can_manage_operasional = in_array($current_role_id, [5, 8, 9], true);
$allowed_proses_options = $proses_labels;
if ($current_role_id === 8) {
    $allowed_proses_options = ['2' => $proses_labels['2']];
} elseif ($current_role_id === 9) {
    $allowed_proses_options = [
        '1' => $proses_labels['1'],
        '3' => $proses_labels['3'],
        '4' => $proses_labels['4'],
    ];
}
?>
<style>
<?php if ( !$can_manage_operasional): ?>.operasional-manage-only {
    display: none !important;
}

<?php endif;

?>.flatpickr-calendar.entertain-offcanvas-flatpickr {
    z-index: 20000 !important;
}
</style>
<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1"><?= html_escape($subheader); ?></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                        <li class="breadcrumb-item active"><?= html_escape($subheader); ?></li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-custom mt-2 mt-md-0 operasional-manage-only" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvas-entertain-add" aria-controls="offcanvas-entertain-add">
                <i class="ti ti-circle-plus me-1"></i>Buat Entertain
            </button>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= html_escape($subheader); ?></h5>
            </div>
            <div class="card-body">
                <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:3%">No</th>
                            <th>Project</th>
                            <th class="text-center">Proses</th>
                            <th class="text-center">Periode</th>
                            <th>Nama Karyawan</th>
                            <th class="text-center">Hari</th>
                            <th class="text-end">Nominal</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Lampiran</th>
                            <th>Created By</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($entertain as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <span
                                    class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span>
                                <?= html_escape($row['nama_project'] ?? '-'); ?>
                            </td>
                            <td class="text-center">
                                <?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['tgl_mulai']) && !empty($row['tgl_selesai'])): ?>
                                <?= tanggal_indonesia_medium($row['tgl_mulai']); ?> -
                                <?= tanggal_indonesia_medium($row['tgl_selesai']); ?>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td><?= html_escape($row['nama_karyawan'] ?? '-'); ?></td>
                            <td class="text-center"><?= number_format((float) ($row['j_hari'] ?? 0), 0, ',', '.'); ?>
                            </td>
                            <td class="text-end">Rp <?= number_format((float) ($row['nominal'] ?? 0), 0, ',', '.'); ?>
                            </td>
                            <td class="text-end">Rp <?= number_format((float) ($row['total'] ?? 0), 0, ',', '.'); ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($row['lampiran'])): ?>
                                <a href="<?= base_url('uploads/entertain/' . rawurlencode($row['lampiran'])); ?>"
                                    target="_blank" data-bs-toggle="tooltip" title="Lihat Lampiran">
                                    <i class="ti ti-photo fs-18 text-primary"></i>
                                </a>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-entertain" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-entertain-edit"
                                                data-id="<?= (int) $row['id_entertain']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-tgl-mulai="<?= html_escape($row['tgl_mulai'] ?? ''); ?>"
                                                data-tgl-selesai="<?= html_escape($row['tgl_selesai'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-nama-karyawan="<?= html_escape($row['nama_karyawan'] ?? ''); ?>"
                                                data-nominal="<?= html_escape($row['nominal'] ?? 0); ?>"
                                                data-total="<?= html_escape($row['total'] ?? 0); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-lampiran="<?= html_escape($row['lampiran'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy"
                                                href="<?= base_url('Entertain/destroy/' . $row['id_entertain']); ?>">
                                                <i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only entertain-offcanvas" tabindex="-1"
        id="offcanvas-entertain-add" aria-labelledby="offcanvas-entertain-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-entertain-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-entertain" class="entertain-form" action="<?= base_url('Entertain/Store'); ?>"
                method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label" for="add_project">Project <span class="text-danger">*</span></label>
                    <select class="form-select js-project" id="add_project" name="project" required>
                        <option value="" data-start="" data-end="">-- Pilih Project --</option>
                        <?php foreach ($projects as $project): ?>
                        <option value="<?= html_escape($project['kode_project']); ?>"
                            data-start="<?= html_escape($project['tgl_mulai']); ?>"
                            data-end="<?= html_escape($project['tgl_selesai']); ?>">
                            <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="add_tgl_mulai">Tanggal Mulai <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-date-entertain js-tgl-mulai" id="add_tgl_mulai"
                            name="tgl_mulai" autocomplete="off" placeholder="Pilih tanggal mulai" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="add_tgl_selesai">Tanggal Selesai <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-date-entertain js-tgl-selesai" id="add_tgl_selesai"
                            name="tgl_selesai" autocomplete="off" placeholder="Pilih tanggal selesai" required>
                    </div>
                </div>
                <div class="mb-3">
                    <?php $form_mode = 'add'; include APPPATH . 'views/operasional/_proses_field.php'; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_nama_karyawan">Nama Karyawan <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="add_nama_karyawan" name="nama_karyawan"
                        placeholder="Enter nama karyawan" required>
                </div>
                <div class="row g-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_jumlah_hari">Jumlah Hari</label>
                        <input type="number" class="form-control js-jumlah-hari" id="add_jumlah_hari" name="jumlah_hari"
                            step="1" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_nominal_display">Nominal <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-nominal-display" id="add_nominal_display"
                            placeholder="0" required>
                        <input type="hidden" class="js-nominal" name="nominal" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_total_display">Total</label>
                        <input type="text" class="form-control js-total-display" id="add_total_display" placeholder="0"
                            readonly>
                        <input type="hidden" class="js-total" name="total" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_lampiran">Lampiran</label>
                    <input type="file" class="form-control" id="add_lampiran" name="lampiran"
                        accept="image/jpeg,image/png">
                    <small class="text-muted">Format JPG/PNG. File akan dikompres otomatis maksimal 100KB.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_keterangan">Keterangan</label>
                    <textarea class="form-control" id="add_keterangan" name="keterangan" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-entertain" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only entertain-offcanvas" tabindex="-1"
        id="offcanvas-entertain-edit" aria-labelledby="offcanvas-entertain-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-entertain-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-entertain" class="entertain-form" action="<?= base_url('Entertain/update'); ?>"
                method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_entertain" value="">
                <input type="hidden" name="old_lampiran" value="">
                <div class="mb-3">
                    <label class="form-label" for="edit_project">Project <span class="text-danger">*</span></label>
                    <select class="form-select js-project" id="edit_project" name="project" required>
                        <option value="" data-start="" data-end="">-- Pilih Project --</option>
                        <?php foreach ($projects as $project): ?>
                        <option value="<?= html_escape($project['kode_project']); ?>"
                            data-start="<?= html_escape($project['tgl_mulai']); ?>"
                            data-end="<?= html_escape($project['tgl_selesai']); ?>">
                            <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="edit_tgl_mulai">Tanggal Mulai <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-date-entertain js-tgl-mulai" id="edit_tgl_mulai"
                            name="tgl_mulai" autocomplete="off" placeholder="Pilih tanggal mulai" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="edit_tgl_selesai">Tanggal Selesai <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-date-entertain js-tgl-selesai" id="edit_tgl_selesai"
                            name="tgl_selesai" autocomplete="off" placeholder="Pilih tanggal selesai" required>
                    </div>
                </div>
                <div class="mb-3">
                    <?php $form_mode = 'edit'; include APPPATH . 'views/operasional/_proses_field.php'; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_nama_karyawan">Nama Karyawan <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_nama_karyawan" name="nama_karyawan" required>
                </div>
                <div class="row g-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_jumlah_hari">Jumlah Hari</label>
                        <input type="number" class="form-control js-jumlah-hari" id="edit_jumlah_hari"
                            name="jumlah_hari" step="1" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_nominal_display">Nominal <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control js-nominal-display" id="edit_nominal_display"
                            placeholder="0" required>
                        <input type="hidden" class="js-nominal" name="nominal" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_total_display">Total</label>
                        <input type="text" class="form-control js-total-display" id="edit_total_display" placeholder="0"
                            readonly>
                        <input type="hidden" class="js-total" name="total" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_lampiran">Lampiran</label>
                    <div class="mb-2 d-none js-current-lampiran-wrap">
                        <a href="javascript:void(0);" class="link-primary js-current-lampiran" target="_blank">
                            <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                        </a>
                    </div>
                    <input type="file" class="form-control" id="edit_lampiran" name="lampiran"
                        accept="image/jpeg,image/png">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti lampiran. File baru akan dikompres
                        maksimal 100KB.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_keterangan">Keterangan</label>
                    <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-entertain" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function cleanNumber(value) {
            return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
        }

        function displayNumber(value) {
            var rounded = Math.round(value || 0);
            if (typeof formatNumber === 'function') {
                return formatNumber(String(rounded));
            }
            return String(rounded).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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

        function initEntertainForm(form) {
            var $form = $(form);
            var $project = $form.find('.js-project');
            var $tglMulai = $form.find('.js-tgl-mulai');
            var $tglSelesai = $form.find('.js-tgl-selesai');
            var $jumlahHari = $form.find('.js-jumlah-hari');
            var $nominal = $form.find('.js-nominal');
            var $nominalDisplay = $form.find('.js-nominal-display');
            var $total = $form.find('.js-total');
            var $totalDisplay = $form.find('.js-total-display');
            var mulaiPicker = null;
            var selesaiPicker = null;

            function setMoney(name, value) {
                var rounded = Math.round(value || 0);
                if (name === 'nominal') {
                    $nominal.val(rounded);
                    $nominalDisplay.val(displayNumber(rounded));
                } else {
                    $total.val(rounded);
                    $totalDisplay.val(displayNumber(rounded));
                }
            }

            function calculateTotal() {
                var days = countDays($tglMulai.val(), $tglSelesai.val());
                $jumlahHari.val(days || '');
                setMoney('total', days * cleanNumber($nominal.val()));
            }

            function getRange() {
                var selected = $project.find('option:selected');
                return {
                    start: selected.attr('data-start') || '',
                    end: selected.attr('data-end') || ''
                };
            }

            function normalizePicker(instance) {
                return $.isArray(instance) ? instance[0] : instance;
            }

            function enablePickerInput(picker, $input) {
                $input.prop('disabled', false).prop('readonly', false);
                if (picker && picker.calendarContainer) {
                    picker.calendarContainer.classList.add('entertain-offcanvas-flatpickr');
                }
            }

            function destroyPicker(picker) {
                if (picker && typeof picker.destroy === 'function') {
                    picker.destroy();
                }
            }

            function initDatePickers(range) {
                var startValue = $tglMulai.val();
                var endValue = $tglSelesai.val();

                destroyPicker(mulaiPicker);
                destroyPicker(selesaiPicker);
                mulaiPicker = null;
                selesaiPicker = null;

                $tglMulai.val(startValue);
                $tglSelesai.val(endValue);
                $tglMulai.add($tglSelesai).prop('disabled', false).prop('readonly', false);
                $tglMulai.add($tglSelesai).attr('min', range.start || '').attr('max', range.end || '');

                if (typeof flatpickr === 'undefined') {
                    return;
                }

                var config = {
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    clickOpens: true,
                    disableMobile: true,
                    minDate: range.start || null,
                    maxDate: range.end || null,
                    appendTo: document.body,
                    onChange: calculateTotal,
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.calendarContainer.classList.add('entertain-offcanvas-flatpickr');
                    },
                    onOpen: function(selectedDates, dateStr, instance) {
                        instance.calendarContainer.classList.add('entertain-offcanvas-flatpickr');
                    }
                };

                mulaiPicker = normalizePicker(flatpickr($tglMulai[0], config));
                selesaiPicker = normalizePicker(flatpickr($tglSelesai[0], config));
                enablePickerInput(mulaiPicker, $tglMulai);
                enablePickerInput(selesaiPicker, $tglSelesai);
            }

            function setDateValue(field, value) {
                var picker = field === 'start' ? mulaiPicker : selesaiPicker;
                var $input = field === 'start' ? $tglMulai : $tglSelesai;
                if (picker && typeof picker.setDate === 'function') {
                    picker.setDate(value || null, false, 'Y-m-d');
                    enablePickerInput(picker, $input);
                } else {
                    $input.val(value || '');
                }
            }

            function setDateRange(clearValue) {
                var range = getRange();
                if (clearValue) {
                    $tglMulai.val('');
                    $tglSelesai.val('');
                    $jumlahHari.val('');
                }
                initDatePickers(range);
                calculateTotal();
            }

            function handleProjectChange() {
                var kode = $project.val();
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
            }

            $project.on('change input', handleProjectChange);
            if ($project[0]) {
                $project[0].addEventListener('change', handleProjectChange);
            }


            $nominalDisplay.on('input change', function() {
                $nominal.val(cleanNumber(this.value));
                calculateTotal();
            });

            $tglMulai.add($tglSelesai).on('input change', calculateTotal);

            initDatePickers(getRange());
            calculateTotal();

            $form.data('entertainForm', {
                setDateRange: setDateRange,
                setDateValue: setDateValue,
                calculateTotal: calculateTotal,
                setMoney: setMoney
            });
        }

        $('.entertain-form').each(function() {
            initEntertainForm(this);
        });

        $('#offcanvas-entertain-add').on('show.bs.offcanvas', function() {
            var $form = $('#form-add-entertain');
            $form[0].reset();
            $form.find('input[type="file"]').val('');
            var methods = $form.data('entertainForm');
            if (methods) {
                methods.setDateRange(true);
                methods.setMoney('nominal', 0);
                methods.calculateTotal();
            }
            $form.find('.js-tgl-mulai, .js-tgl-selesai').prop('disabled', false);
            $form.find('.js-date-entertain').prop('disabled', false).prop('readonly', false);
        });

        $('.btn-edit-entertain').on('click', function() {
            var $button = $(this);
            var $form = $('#form-edit-entertain');
            var methods = $form.data('entertainForm');
            var lampiran = $button.attr('data-lampiran') || '';

            $form[0].reset();
            $form.find('input[type="file"]').val('');
            $form.find('[name="id_entertain"]').val($button.attr('data-id') || '');
            $form.find('[name="old_lampiran"]').val(lampiran);
            $form.find('[name="project"]').val($button.attr('data-project') || '');
            $form.find('[name="proses"]').val($button.attr('data-proses') || '');
            $form.find('[name="nama_karyawan"]').val($button.attr('data-nama-karyawan') || '');
            $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');

            if (methods) {
                methods.setDateRange(false);
                methods.setDateValue('start', $button.attr('data-tgl-mulai') || '');
                methods.setDateValue('end', $button.attr('data-tgl-selesai') || '');
                methods.setMoney('nominal', cleanNumber($button.attr('data-nominal') || 0));
                methods.calculateTotal();
            }
            $form.find('.js-tgl-mulai, .js-tgl-selesai').prop('disabled', false);
            $form.find('.js-date-entertain').prop('disabled', false).prop('readonly', false);

            if (lampiran) {
                $form.find('.js-current-lampiran-wrap').removeClass('d-none');
                $form.find('.js-current-lampiran').attr('href', base_url + 'uploads/entertain/' +
                    encodeURIComponent(lampiran));
            } else {
                $form.find('.js-current-lampiran-wrap').addClass('d-none');
                $form.find('.js-current-lampiran').attr('href', 'javascript:void(0);');
            }
        });
    });
    </script>
