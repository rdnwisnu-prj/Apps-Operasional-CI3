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
<?php if (!$can_manage_operasional): ?>
.operasional-manage-only { display: none !important; }
<?php endif; ?>
.flatpickr-calendar.freelance-offcanvas-flatpickr { z-index: 20000 !important; }
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
            <button class="btn btn-custom mt-2 mt-md-0 operasional-manage-only" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-freelance-add" aria-controls="offcanvas-freelance-add">
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
                            <th>Proses</th>
                            <th>Jobdesk</th>
                            <th class="text-center">Orang</th>
                            <th class="text-center">Hari</th>
                            <th class="text-end">Fee</th>
                            <th class="text-end">Tambahan</th>
                            <th class="text-end">Total</th>
                            <th>Created By</th>
                            <th class="text-center">Lampiran</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($freelance as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span>
                                <?= html_escape($row['nama_project'] ?? '-'); ?>
                            </td>
                            <td><?= !empty($row['tgl_fee']) ? tanggal_indonesia_medium($row['tgl_fee']) : '-'; ?></td>
                            <td><?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td><?= html_escape($row['jobdesk'] ?? '-'); ?></td>
                            <td class="text-center"><?= number_format((float) ($row['jumlah_orang'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-center"><?= number_format((float) ($row['jumlah_hari'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['fee'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['biaya_tambahan'] ?? 0), 0, ',', '.'); ?></td>
                            <td class="text-end">Rp <?= number_format((float) ($row['total'] ?? 0), 0, ',', '.'); ?></td>
                            <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['lampiran'])): ?>
                                <a href="<?= base_url('uploads/freelance/' . rawurlencode($row['lampiran'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Lampiran"><i class="ti ti-photo fs-18 text-primary"></i></a>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-freelance" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-freelance-edit"
                                                data-id="<?= (int) $row['id_freelance']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-tgl-fee="<?= html_escape($row['tgl_fee'] ?? ''); ?>"
                                                data-jobdesk="<?= html_escape($row['jobdesk'] ?? ''); ?>"
                                                data-jumlah-orang="<?= html_escape($row['jumlah_orang'] ?? 0); ?>"
                                                data-jumlah-hari="<?= html_escape($row['jumlah_hari'] ?? 0); ?>"
                                                data-fee="<?= html_escape($row['fee'] ?? 0); ?>"
                                                data-biaya-tambahan="<?= html_escape($row['biaya_tambahan'] ?? 0); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-lampiran="<?= html_escape($row['lampiran'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item btn-destroy" href="<?= base_url('Freelance/destroy/' . $row['id_freelance']); ?>"><i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a></li>
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

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-freelance-add" aria-labelledby="offcanvas-freelance-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-freelance-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-freelance" class="freelance-form" action="<?= base_url('Freelance/Store'); ?>" method="post" enctype="multipart/form-data">
                <?php $form_mode = 'add'; include __DIR__ . '/_form_offcanvas.php'; ?>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-freelance" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Save</button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-freelance-edit" aria-labelledby="offcanvas-freelance-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-freelance-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-freelance" class="freelance-form" action="<?= base_url('Freelance/update'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_freelance" value="">
                <?php $form_mode = 'edit'; include __DIR__ . '/_form_offcanvas.php'; ?>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-freelance" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Update</button>
        </div>
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
    function initFreelanceForm(form) {
        var $form = $(form);
        var picker = null;
        var $tgl = $form.find('.js-tgl-fee');
        var $jumlahOrang = $form.find('.js-jumlah-orang');
        var $jumlahHari = $form.find('.js-jumlah-hari');
        var $fee = $form.find('.js-fee');
        var $feeDisplay = $form.find('.js-fee-display');
        var $tambahan = $form.find('.js-biaya-tambahan');
        var $tambahanDisplay = $form.find('.js-biaya-tambahan-display');
        var $total = $form.find('.js-total');
        var $totalDisplay = $form.find('.js-total-display');

        function setMoney(field, value) {
            var rounded = Math.round(value || 0);
            if (field === 'fee') { $fee.val(rounded); $feeDisplay.val(displayNumber(rounded)); }
            if (field === 'tambahan') { $tambahan.val(rounded); $tambahanDisplay.val(displayNumber(rounded)); }
            if (field === 'total') { $total.val(rounded); $totalDisplay.val(displayNumber(rounded)); }
        }
        function calculateTotal() {
            setMoney('total', (cleanNumber($jumlahOrang.val()) * cleanNumber($jumlahHari.val()) * cleanNumber($fee.val())) + cleanNumber($tambahan.val()));
        }
        if (typeof flatpickr !== 'undefined' && $tgl.length) {
            picker = flatpickr($tgl[0], {
                dateFormat: 'Y-m-d', allowInput: true, disableMobile: true, appendTo: document.body,
                onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('freelance-offcanvas-flatpickr'); },
                onOpen: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('freelance-offcanvas-flatpickr'); }
            });
        }
        $feeDisplay.on('input change', function() { $fee.val(cleanNumber(this.value)); calculateTotal(); });
        $tambahanDisplay.on('input change', function() { $tambahan.val(cleanNumber(this.value)); calculateTotal(); });
        $jumlahOrang.add($jumlahHari).on('input change', calculateTotal);
        $form.data('freelanceForm', {
            setMoney: setMoney,
            calculateTotal: calculateTotal,
            setDate: function(value) { picker && picker.setDate ? picker.setDate(value || null, false, 'Y-m-d') : $tgl.val(value || ''); }
        });
        calculateTotal();
    }

    $('.freelance-form').each(function() { initFreelanceForm(this); });

    $('#offcanvas-freelance-add').on('show.bs.offcanvas', function() {
        var $form = $('#form-add-freelance');
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        var methods = $form.data('freelanceForm');
        if (methods) { methods.setDate(''); methods.setMoney('fee', 0); methods.setMoney('tambahan', 0); methods.calculateTotal(); }
    });

    $('.btn-edit-freelance').on('click', function() {
        var $button = $(this);
        var $form = $('#form-edit-freelance');
        var methods = $form.data('freelanceForm');
        var lampiran = $button.attr('data-lampiran') || '';
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        $form.find('[name="id_freelance"]').val($button.attr('data-id') || '');
        $form.find('[name="project"]').val($button.attr('data-project') || '');
        $form.find('[name="proses"]').val($button.attr('data-proses') || '');
        $form.find('[name="jobdesk"]').val($button.attr('data-jobdesk') || '');
        $form.find('[name="jumlah_orang"]').val($button.attr('data-jumlah-orang') || '');
        $form.find('[name="jumlah_hari"]').val($button.attr('data-jumlah-hari') || '');
        $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');
        if (methods) {
            methods.setDate($button.attr('data-tgl-fee') || '');
            methods.setMoney('fee', cleanNumber($button.attr('data-fee') || 0));
            methods.setMoney('tambahan', cleanNumber($button.attr('data-biaya-tambahan') || 0));
            methods.calculateTotal();
        }
        if (lampiran) {
            $form.find('.js-current-lampiran-wrap').removeClass('d-none');
            $form.find('.js-current-lampiran').attr('href', base_url + 'uploads/freelance/' + encodeURIComponent(lampiran));
        } else {
            $form.find('.js-current-lampiran-wrap').addClass('d-none');
            $form.find('.js-current-lampiran').attr('href', 'javascript:void(0);');
        }
    });
});
</script>
