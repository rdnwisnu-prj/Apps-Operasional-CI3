<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$jenis_pengeluaran_options = ['BBM', 'Toll', 'Parkir', 'Mobil'];
$transport_options = ['Mobil Operasional', 'Mobil Pribadi', 'Taxi Online', 'Sewa'];
$jenis_options = ['Bis', 'Mobil Penumpang', 'Mobil Barang', 'Motor'];

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
.flatpickr-calendar.transport-offcanvas-flatpickr { z-index: 20000 !important; }
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
            <button class="btn btn-custom mt-2 mt-md-0 operasional-manage-only" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-transport-add" aria-controls="offcanvas-transport-add">
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
                            <th>Jenis Pengeluaran</th>
                            <th class="text-end">Nominal</th>
                            <th>Transport</th>
                            <th>Jenis</th>
                            <th>Merk Kendaraan</th>
                            <th>Pemilik</th>
                            <th>No Polisi</th>
                            <th class="text-center">Bukti/Struk</th>
                            <th class="text-center">STNK</th>
                            <th class="text-end operasional-manage-only" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($transport as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><span class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span><?= html_escape($row['nama_project'] ?? '-'); ?></td>
                            <td><?= !empty($row['tgl_transport']) ? tanggal_indonesia_medium($row['tgl_transport']) : '-'; ?></td>
                            <td class="text-center"><?= html_escape($proses_labels[(string) ($row['proses'] ?? '')] ?? '-'); ?></td>
                            <td><span class="badge bg-info-subtle text-info"><?= html_escape($row['jenis_pengeluaran'] ?? 'Mobil'); ?></span></td>
                            <td class="text-end">Rp <?= html_escape(number_format((float) ($row['nominal'] ?? 0), 0, ',', '.')); ?></td>
                            <td><?= html_escape(($row['transport'] ?? '') ?: '-'); ?></td>
                            <td><?= html_escape(($row['jenis'] ?? '') ?: '-'); ?></td>
                            <td><?= html_escape(($row['tipe'] ?? '') ?: '-'); ?></td>
                            <td><?= html_escape(($row['nama_pemilik'] ?? '') ?: '-'); ?></td>
                            <td><?= html_escape(($row['nopol_kendaraan'] ?? '') ?: '-'); ?></td>
                            <td class="text-center">
                                <?php if (!empty($row['lampiran'])): ?>
                                <a href="<?= base_url('uploads/transport/' . rawurlencode($row['lampiran'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat Bukti/Struk"><i class="ti ti-photo fs-18 text-primary"></i></a>
                                <?php else: ?>-
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($row['stnk'])): ?>
                                <a href="<?= base_url('uploads/transport/' . rawurlencode($row['stnk'])); ?>" target="_blank" data-bs-toggle="tooltip" title="Lihat STNK"><i class="ti ti-file-certificate fs-18 text-primary"></i></a>
                                <?php else: ?>-
                                <?php endif; ?>
                            </td>
                            <td class="text-end operasional-manage-only">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-dots-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-transport" href="javascript:void(0);" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-transport-edit"
                                                data-id="<?= (int) $row['id_transport']; ?>"
                                                data-project="<?= html_escape($row['project'] ?? ''); ?>"
                                                data-proses="<?= html_escape($row['proses'] ?? ''); ?>"
                                                data-jenis-pengeluaran="<?= html_escape($row['jenis_pengeluaran'] ?? 'Mobil'); ?>"
                                                data-nominal="<?= html_escape($row['nominal'] ?? 0); ?>"
                                                data-tgl-transport="<?= html_escape($row['tgl_transport'] ?? ''); ?>"
                                                data-transport="<?= html_escape($row['transport'] ?? ''); ?>"
                                                data-jenis="<?= html_escape($row['jenis'] ?? ''); ?>"
                                                data-tipe="<?= html_escape($row['tipe'] ?? ''); ?>"
                                                data-nama-pemilik="<?= html_escape($row['nama_pemilik'] ?? ''); ?>"
                                                data-nopol-kendaraan="<?= html_escape($row['nopol_kendaraan'] ?? ''); ?>"
                                                data-ktp-pemilik="<?= html_escape($row['ktp_pemilik'] ?? ''); ?>"
                                                data-keterangan="<?= html_escape($row['keterangan'] ?? ''); ?>"
                                                data-lampiran="<?= html_escape($row['lampiran'] ?? ''); ?>"
                                                data-stnk="<?= html_escape($row['stnk'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item btn-destroy" href="<?= base_url('Transport/destroy/' . $row['id_transport']); ?>"><i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a></li>
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

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-transport-add" aria-labelledby="offcanvas-transport-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-transport-add-label" class="mb-0">Tambah <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-transport" class="transport-form" action="<?= base_url('Transport/Store'); ?>" method="post" enctype="multipart/form-data">
                <?php $form_mode = 'add'; include __DIR__ . '/_form_offcanvas.php'; ?>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-transport" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Save</button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end operasional-manage-only" tabindex="-1" id="offcanvas-transport-edit" aria-labelledby="offcanvas-transport-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-transport-edit-label" class="mb-0">Edit <?= html_escape($subheader); ?></h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-transport" class="transport-form" action="<?= base_url('Transport/update'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_transport" value="">
                <?php $form_mode = 'edit'; include __DIR__ . '/_form_offcanvas.php'; ?>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-transport" class="btn btn-custom"><i class="ri-checkbox-circle-line me-1"></i>Update</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initTransportForm(form) {
        var $form = $(form);
        var $tgl = $form.find('.js-tgl-transport');
        var picker = null;
        if (typeof flatpickr !== 'undefined' && $tgl.length) {
            picker = flatpickr($tgl[0], {
                dateFormat: 'Y-m-d', allowInput: true, disableMobile: true, appendTo: document.body,
                onReady: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('transport-offcanvas-flatpickr'); },
                onOpen: function(selectedDates, dateStr, instance) { instance.calendarContainer.classList.add('transport-offcanvas-flatpickr'); }
            });
        }
        function toggleSewaFields() {
            var isMobil = $form.find('[name="jenis_pengeluaran"]').val() === 'Mobil';
            var isSewa = isMobil && $form.find('[name="transport"]').val() === 'Sewa';
            $form.find('.js-mobil-fields').toggleClass('d-none', !isMobil);
            $form.find('.js-mobil-required').prop('required', isMobil);
            if (!isMobil) {
                $form.find('[name="transport"], [name="jenis"], [name="tipe"]').val('');
            }
            $form.find('.js-sewa-fields').toggleClass('d-none', !isSewa);
            $form.find('.js-sewa-required').prop('required', isSewa);
            if (!isSewa) {
                $form.find('.js-sewa-required').not('[type="file"]').val('');
                $form.find('[name="stnk"]').val('');
            }
        }
        $form.find('[name="jenis_pengeluaran"]').on('change', toggleSewaFields);
        $form.find('[name="transport"]').on('change', toggleSewaFields);
        $form.data('transportForm', {
            setDate: function(value) { picker && picker.setDate ? picker.setDate(value || null, false, 'Y-m-d') : $tgl.val(value || ''); },
            toggleSewaFields: toggleSewaFields
        });
        toggleSewaFields();
    }

    $('.transport-form').each(function() { initTransportForm(this); });

    $('#offcanvas-transport-add').on('show.bs.offcanvas', function() {
        var $form = $('#form-add-transport');
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        var methods = $form.data('transportForm');
        if (methods) { methods.setDate(''); methods.toggleSewaFields(); }
    });

    $('.btn-edit-transport').on('click', function() {
        var $button = $(this);
        var $form = $('#form-edit-transport');
        var methods = $form.data('transportForm');
        var lampiran = $button.attr('data-lampiran') || '';
        var stnk = $button.attr('data-stnk') || '';
        $form[0].reset();
        $form.find('input[type="file"]').val('');
        $form.find('[name="id_transport"]').val($button.attr('data-id') || '');
        $form.find('[name="project"]').val($button.attr('data-project') || '');
        $form.find('[name="proses"]').val($button.attr('data-proses') || '');
        $form.find('[name="jenis_pengeluaran"]').val($button.attr('data-jenis-pengeluaran') || 'Mobil');
        $form.find('[name="nominal"]').val($button.attr('data-nominal') || '0');
        $form.find('[name="transport"]').val($button.attr('data-transport') || '');
        $form.find('[name="jenis"]').val($button.attr('data-jenis') || '');
        $form.find('[name="tipe"]').val($button.attr('data-tipe') || '');
        $form.find('[name="nama_pemilik"]').val($button.attr('data-nama-pemilik') || '');
        $form.find('[name="nopol_kendaraan"]').val($button.attr('data-nopol-kendaraan') || '');
        $form.find('[name="ktp_pemilik"]').val($button.attr('data-ktp-pemilik') || '');
        $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');
        if (methods) { methods.setDate($button.attr('data-tgl-transport') || ''); methods.toggleSewaFields(); }
        if (lampiran) {
            $form.find('.js-current-lampiran-wrap').removeClass('d-none');
            $form.find('.js-current-lampiran').attr('href', base_url + 'uploads/transport/' + encodeURIComponent(lampiran));
        } else {
            $form.find('.js-current-lampiran-wrap').addClass('d-none');
            $form.find('.js-current-lampiran').attr('href', 'javascript:void(0);');
        }
        if (stnk) {
            $form.find('.js-current-stnk-wrap').removeClass('d-none');
            $form.find('.js-current-stnk').attr('href', base_url + 'uploads/transport/' + encodeURIComponent(stnk));
        } else {
            $form.find('.js-current-stnk-wrap').addClass('d-none');
            $form.find('.js-current-stnk').attr('href', 'javascript:void(0);');
        }
    });
});
</script>
