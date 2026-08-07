<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];

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
<?php if (!$can_manage_operasional): ?>
.operasional-manage-only { display: none !important; }
<?php endif; ?>
.flatpickr-calendar.makan-offcanvas-flatpickr {
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

    <div class="content pb-0">
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
                data-bs-target="#offcanvas-makan-add" aria-controls="offcanvas-makan-add">
                <i class="ti ti-circle-plus me-1"></i>Tambah Data
            </button>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= html_escape($subheader); ?></h5>
            </div>
            <div class="card-body">
                <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:3%">No</th>
                            <th>Project</th>
                            <th>Tanggal</th>
                            <th class="text-center">Proses</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Nominal</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Lampiran</th>
                            <th>Created By</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($makan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span>
                                <?= html_escape($row['nama_project'] ?? '-'); ?>
                            </td>
                            <td><?= !empty($row['tgl_makan']) ? tanggal_indonesia_medium($row['tgl_makan']) : '-'; ?></td>
                            <td class="text-center"><?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td class="text-center"><?= number_format((float) ($row['jumlah'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['nominal'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['total'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['lampiran'])): ?>
                                <a href="<?= base_url('uploads/makan/' . rawurlencode($row['lampiran'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Lampiran">
                                    <i class="ti ti-photo fs-18 text-primary"></i>
                                </a>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-makan" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-makan-edit"
                                                data-id="<?= (int) $row['id_makan']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-tgl-makan="<?= html_escape($row['tgl_makan'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-jumlah="<?= html_escape($row['jumlah'] ?? 0); ?>"
                                                data-nominal="<?= html_escape($row['nominal'] ?? 0); ?>"
                                                data-total="<?= html_escape($row['total'] ?? 0); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-lampiran="<?= html_escape($row['lampiran'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy" href="<?= base_url('Makan/destroy/' . $row['id_makan']); ?>">
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

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-makan-add" aria-labelledby="offcanvas-makan-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-makan-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-makan" class="makan-form" action="<?= base_url('Makan/Store'); ?>" method="post" enctype="multipart/form-data">
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
                        <label class="form-label" for="add_tgl_makan">Tanggal Makan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control js-tgl-makan" id="add_tgl_makan" name="tgl_makan" autocomplete="off" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?php $form_mode = 'add'; include APPPATH . 'views/operasional/_proses_field.php'; ?>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control js-jumlah" id="add_jumlah" name="jumlah" step="any" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_nominal_display">Nominal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control js-nominal-display" id="add_nominal_display" placeholder="0" required>
                        <input type="hidden" class="js-nominal" name="nominal" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="add_total_display">Total</label>
                        <input type="text" class="form-control js-total-display" id="add_total_display" placeholder="0" readonly>
                        <input type="hidden" class="js-total" name="total" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_lampiran">Lampiran</label>
                    <input type="file" class="form-control" id="add_lampiran" name="lampiran" accept="image/jpeg,image/png">
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
            <button type="submit" form="form-add-makan" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-makan-edit" aria-labelledby="offcanvas-makan-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-makan-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-makan" class="makan-form" action="<?= base_url('Makan/update'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_makan" value="">
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
                        <label class="form-label" for="edit_tgl_makan">Tanggal Makan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control js-tgl-makan" id="edit_tgl_makan" name="tgl_makan" autocomplete="off" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?php $form_mode = 'edit'; include APPPATH . 'views/operasional/_proses_field.php'; ?>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_jumlah">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control js-jumlah" id="edit_jumlah" name="jumlah" step="any" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_nominal_display">Nominal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control js-nominal-display" id="edit_nominal_display" placeholder="0" required>
                        <input type="hidden" class="js-nominal" name="nominal" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="edit_total_display">Total</label>
                        <input type="text" class="form-control js-total-display" id="edit_total_display" placeholder="0" readonly>
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
                    <input type="file" class="form-control" id="edit_lampiran" name="lampiran" accept="image/jpeg,image/png">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti lampiran. File baru dikompres maksimal 100KB.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_keterangan">Keterangan</label>
                    <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-makan" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
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

    function initMakanForm(form) {
        var $form = $(form);
        var $project = $form.find('.js-project');
        var $tglMakan = $form.find('.js-tgl-makan');
        var $jumlah = $form.find('.js-jumlah');
        var $nominal = $form.find('.js-nominal');
        var $nominalDisplay = $form.find('.js-nominal-display');
        var $total = $form.find('.js-total');
        var $totalDisplay = $form.find('.js-total-display');
        var datePicker = null;

        function getRange() {
            var selected = $project.find('option:selected');
            return {
                start: selected.attr('data-start') || '',
                end: selected.attr('data-end') || ''
            };
        }

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
            setMoney('total', cleanNumber($jumlah.val()) * cleanNumber($nominal.val()));
        }

        function destroyPicker() {
            if (datePicker && typeof datePicker.destroy === 'function') {
                datePicker.destroy();
            }
            datePicker = null;
        }

        function initDatePicker(range) {
            var value = $tglMakan.val();
            destroyPicker();
            $tglMakan.val(value);
            $tglMakan.prop('disabled', false).prop('readonly', false);
            $tglMakan.attr('min', range.start || '').attr('max', range.end || '');

            if (typeof flatpickr === 'undefined') {
                return;
            }

            datePicker = flatpickr($tglMakan[0], {
                dateFormat: 'Y-m-d',
                allowInput: true,
                clickOpens: true,
                disableMobile: true,
                minDate: range.start || null,
                maxDate: range.end || null,
                appendTo: document.body,
                onChange: calculateTotal,
                onReady: function(selectedDates, dateStr, instance) {
                    instance.calendarContainer.classList.add('makan-offcanvas-flatpickr');
                },
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.calendarContainer.classList.add('makan-offcanvas-flatpickr');
                }
            });
        }

        function setDateRange(clearValue) {
            var range = getRange();
            if (clearValue) {
                $tglMakan.val('');
            }
            initDatePicker(range);
            calculateTotal();
        }

        function setDateValue(value) {
            if (datePicker && typeof datePicker.setDate === 'function') {
                datePicker.setDate(value || null, false, 'Y-m-d');
            } else {
                $tglMakan.val(value || '');
            }
        }

        $project.on('change input', function() {
            setDateRange(true);
        });
        if ($project[0]) {
            $project[0].addEventListener('change', function() {
                setDateRange(true);
            });
        }

        $jumlah.on('input change', calculateTotal);
        $nominalDisplay.on('input change', function() {
            $nominal.val(cleanNumber(this.value));
            calculateTotal();
        });
        $tglMakan.on('input change', calculateTotal);

        initDatePicker(getRange());
        calculateTotal();

        $form.data('makanForm', {
            setDateRange: setDateRange,
            setDateValue: setDateValue,
            setMoney: setMoney,
            calculateTotal: calculateTotal
        });
    }

    $('.makan-form').each(function() {
        initMakanForm(this);
    });

    $('#offcanvas-makan-add').on('show.bs.offcanvas', function() {
        var $form = $('#form-add-makan');
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        var methods = $form.data('makanForm');
        if (methods) {
            methods.setDateRange(true);
            methods.setMoney('nominal', 0);
            methods.calculateTotal();
        }
        $form.find('.js-tgl-makan').prop('disabled', false).prop('readonly', false);
    });

    $('.btn-edit-makan').on('click', function() {
        var $button = $(this);
        var $form = $('#form-edit-makan');
        var methods = $form.data('makanForm');
        var lampiran = $button.attr('data-lampiran') || '';

        $form[0].reset();
        $form.find('input[type="file"]').val('');
        $form.find('[name="id_makan"]').val($button.attr('data-id') || '');
        $form.find('[name="old_lampiran"]').val(lampiran);
        $form.find('[name="project"]').val($button.attr('data-project') || '');
        $form.find('[name="proses"]').val($button.attr('data-proses') || '');
        $form.find('[name="jumlah"]').val($button.attr('data-jumlah') || '');
        $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');

        if (methods) {
            methods.setDateRange(false);
            methods.setDateValue($button.attr('data-tgl-makan') || '');
            methods.setMoney('nominal', cleanNumber($button.attr('data-nominal') || 0));
            methods.calculateTotal();
        }
        $form.find('.js-tgl-makan').prop('disabled', false).prop('readonly', false);

        if (lampiran) {
            $form.find('.js-current-lampiran-wrap').removeClass('d-none');
            $form.find('.js-current-lampiran').attr('href', base_url + 'uploads/makan/' + encodeURIComponent(lampiran));
        } else {
            $form.find('.js-current-lampiran-wrap').addClass('d-none');
            $form.find('.js-current-lampiran').attr('href', 'javascript:void(0);');
        }
    });
});
</script>
