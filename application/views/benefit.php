<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $header;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader?></li>
                </ol>
            </nav>
        </div>


        <!-- Card Benefit Stats -->
        <div class="row mb-4">
            <!-- Total Benefit -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="all" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Benefit</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Total']) ? $benefit_counts['Total'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-secondary rounded-circle fs-2 shadow">
                                        <i class="ti ti-stack-2 text-secondary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Presentasi -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Presentasi" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Presentasi</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Presentasi']) ? $benefit_counts['Presentasi'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-primary rounded-circle fs-2 shadow">
                                        <i class="ti ti-presentation text-primary fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Konsultasi -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Konsultasi" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Konsultasi</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Konsultasi']) ? $benefit_counts['Konsultasi'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-messages text-info fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Health Talk -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Health Talk" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Health Talk</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Health Talk']) ? $benefit_counts['Health Talk'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded-circle fs-2 shadow">
                                        <i class="ti ti-microphone text-success fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Banner -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Banner" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Banner</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Banner']) ? $benefit_counts['Banner'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-warning rounded-circle fs-2 shadow">
                                        <i class="ti ti-flag text-warning fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Plakat -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Plakat" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Plakat</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Plakat']) ? $benefit_counts['Plakat'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-danger rounded-circle fs-2 shadow">
                                        <i class="ti ti-trophy text-danger fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Training P3K -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Training P3K" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Training P3K</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Training P3K']) ? $benefit_counts['Training P3K'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-dark rounded-circle fs-2 shadow">
                                        <i class="ti ti-first-aid-kit text-dark fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Analisa PAK -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Analisa PAK" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Analisa PAK</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Analisa PAK']) ? $benefit_counts['Analisa PAK'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-purple rounded-circle fs-2 shadow">
                                        <i class="ti ti-report-analytics text-white fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- WTS -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="WTS" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">WTS</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['WTS']) ? $benefit_counts['WTS'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-cyan rounded-circle fs-2 shadow">
                                        <i class="ti ti-target text-cyan fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Wellness -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Wellness" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Wellness</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Wellness']) ? $benefit_counts['Wellness'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-pink rounded-circle fs-2 shadow">
                                        <i class="ti ti-heart-rate-monitor text-pink fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Analisa MCU -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Analisa MCU" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Analisa MCU</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Analisa MCU']) ? $benefit_counts['Analisa MCU'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-indigo rounded-circle fs-2 shadow">
                                        <i class="ti ti-stethoscope text-indigo fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kotak P3K -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Kotak P3K" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Kotak P3K</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Kotak P3K']) ? $benefit_counts['Kotak P3K'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-orange rounded-circle fs-2 shadow">
                                        <i class="ti ti-briefcase-2 text-orange fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Uji Lingkungan -->
            <div class="col-xl-2 col-md-12 col-sm-12 mb-3">
                <div class="card card-animate card-filter h-100" data-benefit="Uji Lingkungan" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Uji Lingkungan</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($benefit_counts['Uji Lingkungan']) ? $benefit_counts['Uji Lingkungan'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-teal rounded-circle fs-2 shadow">
                                        <i class="ti ti-plant text-teal fs-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card Benefit Stats -->

        <!-- Filter -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data Benefit
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="filter_client_id" id="filter_client_id" class="form-control">
                            <option value="">-- Semua Client --</option>
                            <?php 
                                foreach ($clients as $client): ?>
                            <option value="<?= $client['id_client'] ?>">
                                <?= htmlspecialchars($client['nama_client']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="filter_tgl_awal" name="filter_tgl_awal"
                            class="form-control flatpickr-date" placeholder="Pilih Tanggal Awal" />
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="filter_tgl_akhir" name="filter_tgl_akhir"
                            class="form-control flatpickr-date" placeholder="Pilih Tanggal Akhir" />
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" id="btnFilterBenefit" class="btn btn-primary me-2">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                        <button type="button" id="btnResetFilterBenefit" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Filter -->

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>
                <a href="<?= base_url()?>Benefit/Store" class="btn btn-custom"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Benefit
                </a>
            </div>
            <div class="card-body">
                <table id="table-benefit" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Client</th>
                            <th>Detail Benefit</th>
                            <th>Marketing</th>
                            <th>Keterangan</th>
                            <th class="d-none">Benefit Types</th>
                            <th class="d-none">Benefit Dates</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($benefit_grouped as $index => $bg): ?>
                        <?php 
                                $benefit_names = array_column($bg['benefits'], 'nama_benefit');
                                $benefit_types_str = implode(',', $benefit_names);
                                $benefit_dates = array_column($bg['benefits'], 'tgl_benefit_mulai');
                                $benefit_dates_str = implode(',', $benefit_dates);
                                $earliest_date = !empty($benefit_dates) ? min($benefit_dates) : '';
                            ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                            <td class="text-uppercase"><?= $bg['nama_client']; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-soft-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailBenefitModal<?= $index; ?>">
                                    <i class="ri-eye-line me-1"></i> Lihat Detail (<?= count($bg['benefits']); ?>)
                                </button>
                            </td>
                            <td><?= $bg['nama']; ?></td>
                            <td><?= $bg['keterangan']; ?></td>
                            <td class="d-none"><?= $benefit_types_str; ?></td>
                            <td class="d-none"><?= $benefit_dates_str; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Benefit per Client -->
    <?php foreach ($benefit_grouped as $index => $bg): ?>
    <div class="modal fade" id="detailBenefitModal<?= $index; ?>" tabindex="-1"
        aria-labelledby="detailBenefitModalLabel<?= $index; ?>" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailBenefitModalLabel<?= $index; ?>">
                        <i class="ri-gift-line me-2"></i>Detail Benefit - <?= $bg['nama_client']; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Nama Benefit</th>
                                    <th>Status Benefit</th>
                                    <th>Entitas</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th class="text-center" style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $benefit_no = 1; ?>
                                <?php foreach ($bg['benefits'] as $b): ?>
                                <tr>
                                    <td class="text-center"><?= $benefit_no++; ?></td>
                                    <td><?= $b['nama_benefit']; ?></td>
                                    <td>
                                        <?php if ($b['status_benefit'] == 'Deal'): ?>
                                        <span class="badge bg-success"><?= $b['status_benefit']; ?></span>
                                        <?php elseif ($b['status_benefit'] == 'Prospek'): ?>
                                        <span class="badge bg-warning"><?= $b['status_benefit']; ?></span>
                                        <?php elseif ($b['status_benefit'] == 'Lost'): ?>
                                        <span class="badge bg-danger"><?= $b['status_benefit']; ?></span>
                                        <?php elseif ($b['status_benefit'] == 'Berjalan'): ?>
                                        <span class="badge bg-info"><?= $b['status_benefit']; ?></span>
                                        <?php elseif ($b['status_benefit'] == 'Tidak Berjalan'): ?>
                                        <span class="badge bg-secondary"><?= $b['status_benefit']; ?></span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><?= $b['status_benefit']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($b['entitas'] == 'Cakra Medika'): ?>
                                        <span class="badge bg-primary"><?= $b['entitas']; ?></span>
                                        <?php elseif ($b['entitas'] == 'Konsehat'): ?>
                                        <span class="badge bg-info"><?= $b['entitas']; ?></span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><?= $b['entitas']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= tanggal_indonesia_medium(date($b['tgl_benefit_mulai'])); ?></td>
                                    <td><?= tanggal_indonesia_medium(date($b['tgl_benefit_selesai'])); ?></td>
                                    <td class="text-center">
                                        <?php $can_edit = $b['user_id'] == $current_user_id; ?>
                                        <?php if ($can_edit): ?>
                                        <a href="<?= base_url()?>Benefit/Update/<?= $b['id_benefit']; ?>"
                                            class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ri-pencil-fill"></i>
                                        </a>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-soft-secondary" disabled
                                            data-bs-toggle="tooltip" title="Tidak memiliki akses edit">
                                            <i class="ri-pencil-fill"></i>
                                        </button>
                                        <?php endif; ?>
                                        <a href="<?= base_url()?>Benefit/Destroy/<?= $b['id_benefit']; ?>"
                                            class="btn btn-sm btn-soft-danger btn-destroy" data-bs-toggle="tooltip"
                                            title="Delete">
                                            <i class="ri-delete-bin-fill"></i>
                                        </a>

                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url()?>Benefit/Store/<?= $bg['client_id']; ?>" class="btn btn-custom">
                        <i class="ri-add-circle-line me-1"></i> Tambah Benefit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ri-close-circle-line me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <style>
    .card-filter {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .card-filter:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .card-filter.active {
        border: 2px solid #405189;
        box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof flatpickr !== 'undefined') {
            flatpickr('#filter_tgl_awal', {
                dateFormat: 'Y-m-d',
                allowInput: true
            });
            flatpickr('#filter_tgl_akhir', {
                dateFormat: 'Y-m-d',
                allowInput: true
            });
        }

        setTimeout(function() {
            var table = $('#table-benefit').DataTable();
            var cardFilters = document.querySelectorAll('.card-filter');
            var defaultCard = document.querySelector('.card-filter[data-benefit="all"]');
            if (defaultCard) {
                defaultCard.classList.add('active');
            }

            cardFilters.forEach(function(card) {
                card.addEventListener('click', function() {
                    var benefit = this.getAttribute('data-benefit');
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });

                    this.classList.add('active');
                    if (benefit === 'all') {
                        table.column(5).search('').draw();
                    } else {
                        table.column(5).search(benefit).draw();
                    }
                });
            });

            var btnFilter = document.getElementById('btnFilterBenefit');
            var btnReset = document.getElementById('btnResetFilterBenefit');

            if (btnFilter) {
                btnFilter.addEventListener('click', function() {
                    var clientId = document.getElementById('filter_client_id').value;
                    var tglAwal = document.getElementById('filter_tgl_awal').value;
                    var tglAkhir = document.getElementById('filter_tgl_akhir').value;

                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (settings.nTable.id !== 'table-benefit') {
                            return true;
                        }

                        var rowClient = data[1] || '';
                        var rowBenefitDates = data[6] ||
                            '';

                        if (clientId) {
                            var clientSelect = document.getElementById(
                                'filter_client_id');
                            var selectedText = clientSelect.options[clientSelect
                                .selectedIndex].text.trim();
                            if (rowClient.trim() !== selectedText) {
                                return false;
                            }
                        }

                        if (tglAwal || tglAkhir) {
                            var dates = rowBenefitDates.split(',');
                            var hasMatchingDate = false;

                            for (var i = 0; i < dates.length; i++) {
                                var dateStr = dates[i].trim();
                                if (dateStr) {
                                    var isInRange = true;
                                    if (tglAwal && dateStr < tglAwal) {
                                        isInRange = false;
                                    }
                                    if (tglAkhir && dateStr > tglAkhir) {
                                        isInRange = false;
                                    }
                                    if (isInRange) {
                                        hasMatchingDate = true;
                                        break;
                                    }
                                }
                            }

                            if (!hasMatchingDate) {
                                return false;
                            }
                        }

                        return true;
                    });

                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                });
            }

            if (btnReset) {
                btnReset.addEventListener('click', function() {
                    document.getElementById('filter_client_id').value = '';
                    document.getElementById('filter_tgl_awal').value = '';
                    document.getElementById('filter_tgl_akhir').value = '';
                    if (typeof flatpickr !== 'undefined') {
                        var tglAwalPicker = document.getElementById('filter_tgl_awal')
                            ._flatpickr;
                        var tglAkhirPicker = document.getElementById('filter_tgl_akhir')
                            ._flatpickr;
                        if (tglAwalPicker) tglAwalPicker.clear();
                        if (tglAkhirPicker) tglAkhirPicker.clear();
                    }

                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    if (defaultCard) {
                        defaultCard.classList.add('active');
                    }

                    table.search('').columns().search('').draw();
                });
            }
        }, 500);
    });
    </script>