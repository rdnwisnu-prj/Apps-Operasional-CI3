<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$tipe_hunian_options = ['Hotel', 'Mess', 'Sewa Rumah'];

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
.flatpickr-calendar.penginapan-offcanvas-flatpickr { z-index: 20000 !important; }
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
            <button class="btn btn-custom mt-2 mt-md-0 operasional-manage-only" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-penginapan-add" aria-controls="offcanvas-penginapan-add">
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
                            <th>Checkin</th>
                            <th>Checkout</th>
                            <th class="text-center">Proses</th>
                            <th class="text-center">Jumlah Hari</th>
                            <th class="text-end">Nominal</th>
                            <th>Nama Hunian</th>
                            <th>Tipe Hunian</th>
                            <th class="text-center">Invoice/Bukti</th>
                            <th>Created By</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($penginapan as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><span class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span><?= html_escape($row['nama_project'] ?? '-'); ?></td>
                            <td><?= !empty($row['tgl_checkin']) ? tanggal_indonesia_medium($row['tgl_checkin']) : '-'; ?></td>
                            <td><?= !empty($row['tgl_checkout']) ? tanggal_indonesia_medium($row['tgl_checkout']) : '-'; ?></td>
                            <td class="text-center"><?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td class="text-center"><?= number_format((float) ($row['jumlah_hari'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['nominal'] ?? 0), 0, ',', '.'); ?></td>
                            <td><?= html_escape($row['nama_hunian'] ?? '-'); ?></td>
                            <td><?= html_escape($row['tipe_hunian'] ?? '-'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['invoice'])): ?>
                                <a href="<?= base_url('uploads/penginapan/' . rawurlencode($row['invoice'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Invoice/Bukti"><i class="ti ti-photo fs-18 text-primary"></i></a>
                                <?php else: ?>-
                                <?php endif; ?>
                            </td>
                            <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-penginapan" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-penginapan-edit"
                                                data-id="<?= (int) $row['id_penginapan']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-tgl-checkin="<?= html_escape($row['tgl_checkin'] ?? ''); ?>"
                                                data-tgl-checkout="<?= html_escape($row['tgl_checkout'] ?? ''); ?>"
                                                data-jumlah-hari="<?= html_escape($row['jumlah_hari'] ?? 0); ?>"
                                                data-nominal="<?= html_escape($row['nominal'] ?? 0); ?>"
                                                data-nama-hunian="<?= html_escape($row['nama_hunian'] ?? ''); ?>"
                                                data-tipe-hunian="<?= html_escape($row['tipe_hunian'] ?? ''); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-invoice="<?= html_escape($row['invoice'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item btn-destroy" href="<?= base_url('Penginapan/destroy/' . $row['id_penginapan']); ?>"><i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a></li>
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

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-penginapan-add" aria-labelledby="offcanvas-penginapan-add-label">
        <div class="offcanvas-header border-bottom"><h4 id="offcanvas-penginapan-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4><button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
        <div class="offcanvas-body"><form id="form-add-penginapan" class="penginapan-form" action="<?= base_url('Penginapan/Store'); ?>" method="post" enctype="multipart/form-data"><?php $form_mode = 'add'; include __DIR__ . '/_form_offcanvas.php'; ?></form></div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center"><button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button><button type="submit" form="form-add-penginapan" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Save</button></div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-penginapan-edit" aria-labelledby="offcanvas-penginapan-edit-label">
        <div class="offcanvas-header border-bottom"><h4 id="offcanvas-penginapan-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4><button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
        <div class="offcanvas-body"><form id="form-edit-penginapan" class="penginapan-form" action="<?= base_url('Penginapan/update'); ?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id_penginapan" value=""><?php $form_mode = 'edit'; include __DIR__ . '/_form_offcanvas.php'; ?></form></div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center"><button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button><button type="submit" form="form-edit-penginapan" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Update</button></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function cleanNumber(value) { return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0; }
    function displayNumber(value) {
        var rounded = Math.round(value || 0);
        if (typeof formatNumber === 'function') return formatNumber(String(rounded));
        return String(rounded).replace(/B(?=(d{3})+(?!d))/g, '.');
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
        if (!start || !end || end < start) return 0;
        return Math.round((end - start) / 86400000) + 1;
    }
    function initPenginapanForm(form) {
        var $form = $(form);
        var $project = $form.find('.js-project');
        var $checkin = $form.find('.js-tgl-checkin');
        var $checkout = $form.find('.js-tgl-checkout');
        var $jumlahHari = $form.find('.js-jumlah-hari');
        var $nominal = $form.find('.js-nominal');
        var $nominalDisplay = $form.find('.js-nominal-display');
        var checkinPicker = null;
        var checkoutPicker = null;

        function getRange() {
            var selected = $project.find('option:selected');
            return { start: selected.attr('data-start') || '', end: selected.attr('data-end') || '' };
        }
        function destroyPicker(picker) { if (picker && typeof picker.destroy === 'function') picker.destroy(); }
        function calculateDays() { $jumlahHari.val(countDays($checkin.val(), $checkout.val()) || ''); }
        function setMoney(value) {
            var rounded = Math.round(value || 0);
            $nominal.val(rounded);
            $nominalDisplay.val(displayNumber(rounded));
        }
        function initPickers(range) {
            var checkinValue = $checkin.val();
            var checkoutValue = $checkout.val();
            destroyPicker(checkinPicker);
            destroyPicker(checkoutPicker);
            checkinPicker = null;
            checkoutPicker = null;
            $checkin.val(checkinValue).prop('disabled', false).prop('readonly', false).attr('min', range.start || '').attr('max', range.end || '');
            $checkout.val(checkoutValue).prop('disabled', false).prop('readonly', false).attr('min', range.start || '').attr('max', range.end || '');
            if (typeof flatpickr === 'undefined') return;
            var config = {
                dateFormat: 'Y-m-d', allowInput: true, clickOpens: true, disableMobile: true,
                minDate: range.start || null, maxDate: range.end || null, appendTo: document.body,
                onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('penginapan-offcanvas-flatpickr'); },
                onOpen: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('penginapan-offcanvas-flatpickr'); }
            };
            checkinPicker = flatpickr($checkin[0], Object.assign({}, config, { onChange: function() {
                if (checkoutPicker && $checkin.val()) checkoutPicker.set('minDate', $checkin.val());
                calculateDays();
            }}));
            checkoutPicker = flatpickr($checkout[0], Object.assign({}, config, { minDate: checkinValue || range.start || null, onChange: calculateDays }));
        }
        function setDateRange(clearValue) {
            if (clearValue) { $checkin.val(''); $checkout.val(''); $jumlahHari.val(''); }
            initPickers(getRange());
            calculateDays();
        }
        function setDate(field, value) {
            var picker = field === 'checkin' ? checkinPicker : checkoutPicker;
            var $input = field === 'checkin' ? $checkin : $checkout;
            if (picker && typeof picker.setDate === 'function') picker.setDate(value || null, false, 'Y-m-d'); else $input.val(value || '');
        }
        $project.on('change input', function() { setDateRange(true); });
        $checkin.add($checkout).on('input change', calculateDays);
        $nominalDisplay.on('input change', function() { $nominal.val(cleanNumber(this.value)); });
        initPickers(getRange());
        calculateDays();
        $form.data('penginapanForm', { setDateRange: setDateRange, setDate: setDate, setMoney: setMoney, calculateDays: calculateDays });
    }

    $('.penginapan-form').each(function() { initPenginapanForm(this); });

    $('#offcanvas-penginapan-add').on('show.bs.offcanvas', function() {
        var $form = $('#form-add-penginapan');
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        var methods = $form.data('penginapanForm');
        if (methods) { methods.setDateRange(true); methods.setMoney(0); methods.calculateDays(); }
    });

    $('.btn-edit-penginapan').on('click', function() {
        var $button = $(this);
        var $form = $('#form-edit-penginapan');
        var methods = $form.data('penginapanForm');
        var invoice = $button.attr('data-invoice') || '';
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        $form.find('[name="id_penginapan"]').val($button.attr('data-id') || '');
        $form.find('[name="project"]').val($button.attr('data-project') || '');
        $form.find('[name="proses"]').val($button.attr('data-proses') || '');
        $form.find('[name="nama_hunian"]').val($button.attr('data-nama-hunian') || '');
        $form.find('[name="tipe_hunian"]').val($button.attr('data-tipe-hunian') || '');
        $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');
        if (methods) {
            methods.setDateRange(false);
            methods.setDate('checkin', $button.attr('data-tgl-checkin') || '');
            methods.setDate('checkout', $button.attr('data-tgl-checkout') || '');
            methods.setMoney(cleanNumber($button.attr('data-nominal') || 0));
            methods.calculateDays();
        }
        if (invoice) {
            $form.find('.js-current-invoice-wrap').removeClass('d-none');
            $form.find('.js-current-invoice').attr('href', base_url + 'uploads/penginapan/' + encodeURIComponent(invoice));
        } else {
            $form.find('.js-current-invoice-wrap').addClass('d-none');
            $form.find('.js-current-invoice').attr('href', 'javascript:void(0);');
        }
    });
});
</script>
