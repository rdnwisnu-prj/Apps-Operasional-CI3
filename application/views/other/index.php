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
.flatpickr-calendar.other-offcanvas-flatpickr { z-index: 20000 !important; }
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
            <button class="btn btn-custom mt-2 mt-md-0 operasional-manage-only" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-other-add" aria-controls="offcanvas-other-add">
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
                            <th>Kebutuhan</th>
                            <th class="text-end">Nominal</th>
                            <th class="text-center">Upload Bukti/Struk</th>
                            <th>Created By</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($other as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><span class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span><?= html_escape($row['nama_project'] ?? '-'); ?></td>
                            <td><?= !empty($row['tanggal']) ? tanggal_indonesia_medium($row['tanggal']) : '-'; ?></td>
                            <td class="text-center"><?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td><?= html_escape($row['kebutuhan'] ?? '-'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['nominal'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['lampiran'])): ?>
                                <a href="<?= base_url('uploads/other/' . rawurlencode($row['lampiran'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Bukti/Struk"><i class="ti ti-photo fs-18 text-primary"></i></a>
                                <?php else: ?>-
                                <?php endif; ?>
                            </td>
                            <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-other" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-other-edit"
                                                data-id="<?= (int) $row['id_other']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-tanggal="<?= html_escape($row['tanggal'] ?? ''); ?>"
                                                data-kebutuhan="<?= html_escape($row['kebutuhan'] ?? ''); ?>"
                                                data-nominal="<?= html_escape($row['nominal'] ?? 0); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-lampiran="<?= html_escape($row['lampiran'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item btn-destroy" href="<?= base_url('Other/destroy/' . $row['id_other']); ?>"><i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a></li>
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

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-other-add" aria-labelledby="offcanvas-other-add-label">
        <div class="offcanvas-header border-bottom"><h4 id="offcanvas-other-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4><button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
        <div class="offcanvas-body"><form id="form-add-other" class="other-form" action="<?= base_url('Other/Store'); ?>" method="post" enctype="multipart/form-data"><?php $form_mode = 'add'; include __DIR__ . '/_form_offcanvas.php'; ?></form></div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center"><button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button><button type="submit" form="form-add-other" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Save</button></div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-other-edit" aria-labelledby="offcanvas-other-edit-label">
        <div class="offcanvas-header border-bottom"><h4 id="offcanvas-other-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4><button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
        <div class="offcanvas-body"><form id="form-edit-other" class="other-form" action="<?= base_url('Other/update'); ?>" method="post" enctype="multipart/form-data"><input type="hidden" name="id_other" value=""><?php $form_mode = 'edit'; include __DIR__ . '/_form_offcanvas.php'; ?></form></div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center"><button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button><button type="submit" form="form-edit-other" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Update</button></div>
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
    function initOtherForm(form) {
        var $form = $(form);
        var $tanggal = $form.find('.js-tanggal');
        var $nominal = $form.find('.js-nominal');
        var $nominalDisplay = $form.find('.js-nominal-display');
        var picker = null;
        if (typeof flatpickr !== 'undefined' && $tanggal.length) {
            picker = flatpickr($tanggal[0], {
                dateFormat: 'Y-m-d', allowInput: true, disableMobile: true, appendTo: document.body,
                onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('other-offcanvas-flatpickr'); },
                onOpen: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('other-offcanvas-flatpickr'); }
            });
        }
        function setMoney(value) {
            var rounded = Math.round(value || 0);
            $nominal.val(rounded);
            $nominalDisplay.val(displayNumber(rounded));
        }
        $nominalDisplay.on('input change', function() { $nominal.val(cleanNumber(this.value)); });
        $form.data('otherForm', {
            setDate: function(value) { picker && picker.setDate ? picker.setDate(value || null, false, 'Y-m-d') : $tanggal.val(value || ''); },
            setMoney: setMoney
        });
    }

    $('.other-form').each(function() { initOtherForm(this); });

    $('#offcanvas-other-add').on('show.bs.offcanvas', function() {
        var $form = $('#form-add-other');
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        var methods = $form.data('otherForm');
        if (methods) { methods.setDate(''); methods.setMoney(0); }
    });

    $('.btn-edit-other').on('click', function() {
        var $button = $(this);
        var $form = $('#form-edit-other');
        var methods = $form.data('otherForm');
        var lampiran = $button.attr('data-lampiran') || '';
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        $form.find('[name="id_other"]').val($button.attr('data-id') || '');
        $form.find('[name="project"]').val($button.attr('data-project') || '');
        $form.find('[name="proses"]').val($button.attr('data-proses') || '');
        $form.find('[name="kebutuhan"]').val($button.attr('data-kebutuhan') || '');
        $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');
        if (methods) { methods.setDate($button.attr('data-tanggal') || ''); methods.setMoney(cleanNumber($button.attr('data-nominal') || 0)); }
        if (lampiran) {
            $form.find('.js-current-lampiran-wrap').removeClass('d-none');
            $form.find('.js-current-lampiran').attr('href', base_url + 'uploads/other/' + encodeURIComponent(lampiran));
        } else {
            $form.find('.js-current-lampiran-wrap').addClass('d-none');
            $form.find('.js-current-lampiran').attr('href', 'javascript:void(0);');
        }
    });
});
</script>
