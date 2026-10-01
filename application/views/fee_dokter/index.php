<?php
$baseRoute = $base_route ?? 'FeeDokter';
$pageLabel = $page_label ?? 'Fee Dokter';
$selectedDokter = [];
if (is_array($f_dokter)) {
    $selectedDokter = array_map('intval', $f_dokter);
} elseif ($f_dokter !== '') {
    $selectedDokter = [(int) $f_dokter];
}
$namaBulan = [
    '1' => 'Januari',
    '2' => 'Februari',
    '3' => 'Maret',
    '4' => 'April',
    '5' => 'Mei',
    '6' => 'Juni',
    '7' => 'Juli',
    '8' => 'Agustus',
    '9' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];
?>

<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= html_escape($subheader); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                    <li class="breadcrumb-item active"><?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <!-- UI Filter -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form action="<?= base_url($baseRoute . '/filter'); ?>" id="form-filter"
                    class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="btn btn-outline-light shadow px-2"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside"><i
                                class="ti ti-filter me-2"></i>Filter<i class="ti ti-chevron-down ms-2"></i></a>
                        <div class="filter-dropdown-menu dropdown-menu dropdown-menu-lg p-0">
                            <div class="filter-header d-flex align-items-center justify-content-between border-bottom">
                                <h6 class="mb-0"><i class="ti ti-filter me-1"></i>Filter <?= html_escape($pageLabel); ?></h6>
                                <button type="button" class="btn-close close-filter-btn" aria-label="Close"></button>
                            </div>
                            <div class="filter-set-view p-3">
                                <div class="accordion" id="feeDokterFilterAccordion">
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#filterDokterCollapse"
                                                aria-expanded="true" aria-controls="filterDokterCollapse">Dokter</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse show"
                                            id="filterDokterCollapse" data-bs-parent="#feeDokterFilterAccordion">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <div class="mb-2">
                                                    <div class="input-icon-start input-icon position-relative">
                                                        <span class="input-icon-addon fs-12">
                                                            <i class="ti ti-search"></i>
                                                        </span>
                                                        <input type="text" class="form-control form-control-md"
                                                            placeholder="Cari dokter" id="filter_dokter_search">
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-between gap-2 mb-2 px-1">
                                                    <label class="d-flex align-items-center mb-0">
                                                        <input class="form-check-input m-0 me-2" type="checkbox"
                                                            id="filter_dokter_check_all"
                                                            <?= empty($list_dokter) ? 'disabled' : ''; ?>>
                                                        <span class="fw-medium">Checklist Semua Dokter</span>
                                                    </label>
                                                    <small class="text-muted text-nowrap" id="filter_dokter_count">0
                                                        dipilih</small>
                                                </div>
                                                <ul class="mb-0 filter-check-list" id="filter_dokter_list">
                                                    <?php if (!empty($list_dokter)): ?>
                                                    <?php foreach ($list_dokter as $d): ?>
                                                    <?php $dokterId = (int) $d['id_dokter']; ?>
                                                    <li class="mb-1">
                                                        <label class="dropdown-item px-2 d-flex align-items-center">
                                                            <input class="form-check-input m-0 me-2" type="checkbox"
                                                                name="dokter[]" value="<?= $dokterId; ?>"
                                                                <?= in_array($dokterId, $selectedDokter, true) ? 'checked' : ''; ?>>
                                                            <span
                                                                class="text-truncate"><?= html_escape($d['nama_dokter']); ?></span>
                                                        </label>
                                                    </li>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <li class="px-2 py-1 text-muted">Data dokter belum tersedia</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#filterBulanCollapse" aria-expanded="false"
                                                aria-controls="filterBulanCollapse">Bulan</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse"
                                            id="filterBulanCollapse" data-bs-parent="#feeDokterFilterAccordion">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <select class="form-control" name="bulan" id="filter_bulan">
                                                    <option value="">Semua Bulan</option>
                                                    <?php foreach ($namaBulan as $k => $v): ?>
                                                    <option value="<?= $k; ?>"
                                                        <?= ($f_bulan == $k) ? 'selected' : ''; ?>><?= $v; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#filterTahunCollapse" aria-expanded="false"
                                                aria-controls="filterTahunCollapse">Tahun</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse"
                                            id="filterTahunCollapse" data-bs-parent="#feeDokterFilterAccordion">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <select class="form-control" name="tahun" id="filter_tahun">
                                                    <option value="">Semua Tahun</option>
                                                    <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                                    <option value="<?= $y; ?>"
                                                        <?= ($f_tahun == $y) ? 'selected' : ''; ?>><?= $y; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#filterCabangCollapse" aria-expanded="false"
                                                aria-controls="filterCabangCollapse">Cabang</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse"
                                            id="filterCabangCollapse" data-bs-parent="#feeDokterFilterAccordion">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <select class="form-control" name="cabang" id="filter_cabang">
                                                    <option value="">Semua Cabang</option>
                                                    <?php foreach ($list_cabang as $c): ?>
                                                    <option value="<?= (int) $c['id_cabang']; ?>"
                                                        <?= ($f_cabang == $c['id_cabang']) ? 'selected' : ''; ?>>
                                                        <?= html_escape($c['nama_cabang']); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="filter-set-content">
                                        <div class="filter-set-content-head">
                                            <a href="#" class="collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#filterPphCollapse" aria-expanded="false"
                                                aria-controls="filterPphCollapse">Jenis Pajak</a>
                                        </div>
                                        <div class="filter-set-contents accordion-collapse collapse"
                                            id="filterPphCollapse" data-bs-parent="#feeDokterFilterAccordion">
                                            <div class="filter-content-list bg-light rounded border p-2 shadow mt-2">
                                                <select class="form-control" name="pph" id="filter_pph">
                                                    <option value="">Semua Pajak</option>
                                                    <option value="1" <?= ($f_pph === '1') ? 'selected' : ''; ?>>PPH21
                                                    </option>
                                                    <option value="0" <?= ($f_pph === '0') ? 'selected' : ''; ?>>
                                                        Non-PPH21</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-3">
                                    <button type="button" class="btn btn-outline-light w-100" id="btn-reset-filter">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary w-100" id="btn-filter">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-success" id="btn-export">
                    <i class="ti ti-file-spreadsheet me-1"></i>Export Excel
                </button>
                <a href="<?= base_url($baseRoute . '/Store'); ?>" class="btn btn-primary">
                    <i class="ti ti-square-rounded-plus-filled me-1"></i>Tambah Data
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:3%">No</th>
                            <th>Nama Dokter</th>
                            <th class="text-center" style="width:5%">Hari</th>
                            <th class="text-end" style="width:8%">Fee</th>
                            <th class="text-end" style="width:8%">B. Tambahan</th>
                            <th class="text-end" style="width:10%">Total</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width:8%">Tanggal</th>
                            <th class="text-center" style="width:5%">PPH</th>
                            <th class="text-end" style="width:9%">Pajak</th>
                            <th class="text-center" style="width:5%">Jenis</th>
                            <th class="text-center" style="width:4%">Lamp</th>
                            <th class="text-end" style="width:7%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($fee_dokter as $f): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= html_escape($f['nama_dokter']); ?></td>
                            <td class="text-center"><?= (int) $f['jumlah_hari']; ?></td>
                            <td class="text-end">Rp <?= number_format($f['fee'], 0, ',', '.'); ?></td>
                            <td class="text-end">
                                <?php if (!empty($f['biaya_tambahan']) && $f['biaya_tambahan'] > 0): ?>
                                Rp <?= number_format($f['biaya_tambahan'], 0, ',', '.'); ?>
                                <small
                                    class="d-block text-muted"><?= html_escape($f['jenis_biaya_tambahan']); ?></small>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="text-end">Rp <?= number_format($f['total'], 0, ',', '.'); ?></td>
                            <td><?= html_escape($f['keterangan'] ?: '-'); ?></td>
                            <td class="text-center">
                                <?= !empty($f['tgl_project']) ? tanggal_indonesia_medium(date($f['tgl_project'])) : '-'; ?>
                            </td>
                            <td class="text-center">2.5%</td>
                            <td class="text-end">
                                <?php if ($f['pph21'] == 1): ?>
                                Rp <?= number_format($f['jumlah_pph'], 0, ',', '.'); ?>
                                <?php else: ?>
                                Rp <?= number_format($f['jumlah_nopph'], 0, ',', '.'); ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($f['pph21'] == 1): ?>
                                <span class="badge bg-warning-subtle text-warning">PPH21</span>
                                <?php else: ?>
                                <span class="badge bg-info-subtle text-info">Non PPH21</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if (!empty($f['lampiran'])): ?>
                                <a href="<?= base_url('uploads/lampiran/' . rawurlencode($f['lampiran'])); ?>"
                                    target="_blank" data-bs-toggle="tooltip" title="Lihat Lampiran">
                                    <i class="ti ti-photo fs-18 text-primary"></i>
                                </a>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?= base_url($baseRoute . '/edit/' . $f['id_fee']); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy"
                                                href="<?= base_url($baseRoute . '/destroy/' . $f['id_fee']); ?>">
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var $doctorChecks = $('#filter_dokter_list input[name="dokter[]"]');
        var $doctorCheckAll = $('#filter_dokter_check_all');
        var $doctorCount = $('#filter_dokter_count');

        function syncDoctorCheckAll() {
            var total = $doctorChecks.length;
            var checked = $doctorChecks.filter(':checked').length;

            $doctorCheckAll
                .prop('checked', total > 0 && checked === total)
                .prop('indeterminate', checked > 0 && checked < total)
                .prop('disabled', total === 0);

            $doctorCount.text(checked + ' dipilih');
        }

        $doctorCheckAll.on('change', function() {
            $doctorChecks.prop('checked', this.checked);
            syncDoctorCheckAll();
        });

        $('#filter_dokter_list').on('change', 'input[name="dokter[]"]', syncDoctorCheckAll);

        $('#filter_dokter_search').on('keyup', function() {
            var keyword = $(this).val().toLowerCase();
            $('#filter_dokter_list li').each(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) !== -1);
            });
        });

        $('.close-filter-btn').on('click', function(e) {
            e.preventDefault();
            var dropdownToggle = $(this).closest('.dropdown').find('[data-bs-toggle="dropdown"]')[0];
            if (dropdownToggle && typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                bootstrap.Dropdown.getOrCreateInstance(dropdownToggle).hide();
            }
        });

        $('#fee-dokter-search').on('keyup', function() {
            getFeeDokterTable().search(this.value).draw();
        });

        function getFeeDokterTable() {
            if ($.fn.DataTable.isDataTable('#general')) {
                return $('#general').DataTable();
            }

            return $('#general').DataTable({
                bFilter: true,
                sDom: 'fBtlpi',
                language: {
                    paginate: {
                        next: '<i class="ti ti-arrow-right"></i>',
                        previous: '<i class="ti ti-arrow-left"></i> ',
                    },
                    emptyTable: 'Tidak ada data <?= strtolower(html_escape($pageLabel)); ?>',
                    zeroRecords: 'Data tidak ditemukan',
                },
                responsive: true,
                ordering: false,
            });
        }

        function refreshTooltips() {
            if (typeof bootstrap === 'undefined' || !bootstrap.Tooltip) {
                return;
            }

            $('[data-bs-toggle="tooltip"]').each(function() {
                var instance = bootstrap.Tooltip.getInstance(this);
                if (instance) {
                    instance.dispose();
                }
                new bootstrap.Tooltip(this);
            });
        }

        function applyFilter() {
            var $form = $('#form-filter');
            var $button = $('#btn-filter');
            var originalHtml = $button.html();

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $button.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memfilter'
                    );
                },
                success: function(response) {
                    var table = getFeeDokterTable();
                    table.clear();
                    table.rows.add(response.rows || []);
                    table.draw();
                    refreshTooltips();
                },
                error: function() {
                    Swal.fire('Error', 'Filter data <?= html_escape($pageLabel); ?> gagal diproses', 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).html(originalHtml);
                }
            });
        }

        $('#form-filter').on('submit', function(e) {
            e.preventDefault();
            applyFilter();
        });

        $('#btn-reset-filter').on('click', function() {
            var form = $('#form-filter')[0];
            form.reset();
            $('#form-filter input[type="checkbox"]').prop('checked', false);
            $('#form-filter select').val('');
            $('#filter_dokter_search').val('');
            $('#filter_dokter_list li').show();
            $('#fee-dokter-search').val('');
            getFeeDokterTable().search('').draw();
            syncDoctorCheckAll();
            applyFilter();
            window.history.replaceState({}, document.title, base_url + '<?= $baseRoute; ?>');
        });

        $('#btn-export').on('click', function() {
            var params = $('#form-filter').serialize();
            window.location.href = base_url + '<?= $baseRoute; ?>/export' + (params ? '?' + params : '');
        });

        syncDoctorCheckAll();
    });
    </script>
