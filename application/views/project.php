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

        <!-- Card -->
        <div class="row">
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="all" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Project</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['Total']) ? $service_counts['Total'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-stack-back fs-16 text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="HSEO" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">HSEO</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['HSEO']) ? $service_counts['HSEO'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-warning rounded-circle fs-2 shadow">
                                        <i class="ti ti-shield fs-16 text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="IHC" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">IHC</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['IHC']) ? $service_counts['IHC'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-heart fs-16 text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="LAB RUJUKAN"
                    style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">LAB RUJUKAN</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['LAB RUJUKAN']) ? $service_counts['LAB RUJUKAN'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-primary rounded-circle fs-2 shadow">
                                        <i class="ti ti-flask fs-16 text-primary"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="MCU" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">MCU</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['MCU']) ? $service_counts['MCU'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded-circle fs-2 shadow">
                                        <i class="ti ti-report-medical fs-16 text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-jenis="VAKSIN" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">VAKSIN</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($service_counts['VAKSIN']) ? $service_counts['VAKSIN'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-danger rounded-circle fs-2 shadow">
                                        <i class="ti ti-thermometer fs-16 text-danger"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Filter Form -->
        <?php if (isset($can_filter) && $can_filter): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data Project
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="filter_user_id" id="filter_user_id" class="form-control">
                            <option value="">-- Semua Marketing --</option>
                            <?php 
                                $members = isset($team_members) ? $team_members : [];
                                foreach ($members as $m): ?>
                            <option value="<?= $m['id_user'] ?>">
                                <?= htmlspecialchars($m['nama']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filter_bulan" name="filter_bulan" class="form-control">
                            <option value="">-- Semua Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filter_tahun" name="filter_tahun" class="form-control">
                            <option value="">-- Semua Tahun --</option>
                            <?php for($y = date('Y') - 1; $y <= date('Y') + 5; $y++): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="btnFilterClient" class="btn btn-primary me-2">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                        <button type="button" id="btnResetFilterClient" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i> Reset
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>
        <!-- End Filter Form -->


        <!-- Jumlah Estimasi -->
        <div id="estimasiSummary" class="card border-0 shadow-sm mb-3"
            style="display: none; background: linear-gradient(135deg, #34c38f 0%, #28a745 100%);">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            <span class="avatar-title bg-opacity-25 rounded-circle fs-3">
                                <i class="ri-money-dollar-circle-line text-white"></i>
                            </span>
                        </div>
                        <div>
                            <p class="text-white-50 mb-0 fs-13">Total Estimasi Sales (Hasil Filter)</p>
                            <h4 class="text-white mb-0 fw-bold" id="totalEstimasiValue">Rp 0</h4>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white bg-opacity-25 text-success fs-12 px-3 py-2" id="totalRowCount">0
                            data</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar Project</h5>

                <a href="<?= base_url()?>Project/Store" class="btn btn-custom"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Project
                </a>
            </div>
            <div class="card-body">
                <table id="table-project" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Projek</th>
                            <th>Nama Client</th>
                            <th>Layanan</th>
                            <th>Tgl Pelaksanaan</th>
                            <th>Tgl Selesai</th>
                            <th>Estimasi</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Marketing</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($project as $p): ?>
                        <tr data-periode-bulan="<?= $p['periode_bulan']; ?>"
                            data-periode-tahun="<?= $p['periode_tahun']; ?>">
                            <td class="text-center" style="width: 2%;"><?= $no++; ?></td>
                            <td>
                                <?php 
                                $is_sales = ($p['user_id'] == $current_user_id);
                                ?>

                                <a href="<?= base_url('Project/View/' . urlencode($p['id_project'])); ?>"
                                    class="text-primary">
                                    <?= $p['nama_project']; ?>
                                </a>
                            </td>
                            <td class="text-uppercase fw-medium"><?= $p['nama_client']; ?></td>
                            <td><?= $p['service']; ?></td>

                            <td>
                                <?php if ($p['tgl_pelaksanaan'] == '0000-00-00' || empty($p['tgl_pelaksanaan'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($p['tgl_pelaksanaan'])); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p['tgl_selesai'] == '0000-00-00' || empty($p['tgl_selesai'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($p['tgl_selesai'])); ?>
                                <?php endif; ?>
                            </td>
                            <td data-order="<?= $p['estimasi']; ?>">Rp
                                <?= number_format($p['estimasi'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($p['project']); ?></td>
                            <td>
                                <?php if ($p['status_project'] == 'New') : ?>
                                <span class="badge bg-info"><?= $p['status_project']; ?></span>
                                <?php elseif($p['status_project'] == 'Repeat') : ?>
                                <span class="badge bg-success"><?= $p['status_project']; ?></span>
                                <?php elseif($p['status_project'] == 'Lost') : ?>
                                <span class="badge bg-danger"><?= $p['status_project']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $p['nama']; ?></td>
                            <td class="text-center" style="width: 5%;">
                                <?php 
                                    $can_edit = $p['user_id'] == $current_user_id;
                                    ?>

                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Project/Update/<?= $p['id_project']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses edit">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </span>
                                        </li>
                                        <?php endif; ?>

                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Project/destroy/<?= $p['id_project']; ?>"
                                                class="dropdown-item remove-item-btn btn-destroy">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses hapus">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </span>
                                        </li>
                                        <?php endif; ?>
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
        setTimeout(function() {
            var table = $('#table-project').DataTable();
            var cardFilters = document.querySelectorAll('.card-filter');
            var defaultCard = document.querySelector('.card-filter[data-jenis="all"]');
            var urlParams = new URLSearchParams(window.location.search);
            var jenisParam = urlParams.get('jenis');

            if (jenisParam) {
                var matchingCard = document.querySelector('.card-filter[data-jenis="' + jenisParam +
                    '"]');
                if (matchingCard) {
                    matchingCard.classList.add('active');
                    table.column(3).search('^' + jenisParam + '$', true, false).draw();
                } else {
                    if (defaultCard) {
                        defaultCard.classList.add('active');
                    }
                }
            } else {
                if (defaultCard) {
                    defaultCard.classList.add('active');
                }
            }

            cardFilters.forEach(function(card) {
                card.addEventListener('click', function() {
                    var serviceType = this.getAttribute('data-jenis');
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                    if (serviceType === 'all') {
                        table.column(3).search('').draw();
                        var newUrl = window.location.pathname;
                        window.history.replaceState({}, '', newUrl);
                    } else {
                        table.column(3).search('^' + serviceType + '$', true, false)
                            .draw();
                        var newUrl = window.location.pathname + '?jenis=' +
                            encodeURIComponent(serviceType);
                        window.history.replaceState({}, '', newUrl);
                    }
                });
            });

            // ===================== FILTER MARKETING, BULAN, TAHUN =====================
            var btnFilter = document.getElementById('btnFilterClient');
            var btnReset = document.getElementById('btnResetFilterClient');

            if (btnFilter) {
                btnFilter.addEventListener('click', function() {
                    var userId = document.getElementById('filter_user_id') ?
                        document.getElementById('filter_user_id').value : '';
                    var filterBulan = document.getElementById('filter_bulan') ?
                        document.getElementById('filter_bulan').value : '';
                    var filterTahun = document.getElementById('filter_tahun') ?
                        document.getElementById('filter_tahun').value : '';

                    // Add custom search filter
                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (settings.nTable.id !== 'table-project') {
                            return true;
                        }

                        var rowNode = table.row(dataIndex).node();
                        var rowMarketing = data[9] || ''; // Column 9 = Marketing

                        // Filter by marketing user
                        if (userId) {
                            var marketingSelect = document.getElementById(
                                'filter_user_id');
                            var selectedText = marketingSelect.options[marketingSelect
                                .selectedIndex].text.trim();
                            if (rowMarketing.trim() !== selectedText) {
                                return false;
                            }
                        }

                        // Filter by bulan and tahun from data attributes
                        if (filterBulan || filterTahun) {
                            var rowBulan = rowNode.getAttribute('data-periode-bulan') ||
                                '';
                            var rowTahun = rowNode.getAttribute('data-periode-tahun') ||
                                '';

                            if (filterBulan && rowBulan != filterBulan) {
                                return false;
                            }
                            if (filterTahun && rowTahun != filterTahun) {
                                return false;
                            }
                        }

                        return true;
                    });

                    // Redraw table with filter
                    table.draw();
                    $.fn.dataTable.ext.search.pop();

                    // CALCULATE ESTIMASI SUMMARY
                    var totalEstimasi = 0;
                    var visibleRows = 0;
                    table.rows({
                        search: 'applied'
                    }).every(function() {
                        var cellNode = this.node();
                        var estimasiCell = cellNode.querySelectorAll('td')[
                        6]; // Column 6 = Estimasi
                        var rawValue = estimasiCell ? estimasiCell.getAttribute(
                            'data-order') : '0';
                        totalEstimasi += parseFloat(rawValue) || 0;
                        visibleRows++;
                    });

                    // Format to Rupiah
                    var formatted = 'Rp ' + totalEstimasi.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                    document.getElementById('totalEstimasiValue').textContent = formatted;
                    document.getElementById('totalRowCount').textContent = visibleRows +
                        ' data';

                    // Show summary card
                    var summaryCard = document.getElementById('estimasiSummary');
                    summaryCard.style.display = 'block';
                    summaryCard.style.animation = 'fadeSlideIn 0.4s ease';
                });
            }

            // Reset filter button
            if (btnReset) {
                btnReset.addEventListener('click', function() {
                    if (document.getElementById('filter_user_id')) {
                        document.getElementById('filter_user_id').value = '';
                    }
                    if (document.getElementById('filter_bulan')) {
                        document.getElementById('filter_bulan').value = '';
                    }
                    if (document.getElementById('filter_tahun')) {
                        document.getElementById('filter_tahun').value = '';
                    }

                    // Reset card filter ke All
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    if (defaultCard) {
                        defaultCard.classList.add('active');
                    }

                    // Clear all filters and redraw
                    table.search('').columns().search('').draw();

                    // Hide summary card
                    document.getElementById('estimasiSummary').style.display = 'none';

                    // Reset URL
                    var newUrl = window.location.pathname;
                    window.history.replaceState({}, '', newUrl);
                });
            }

        }, 500);
    });
    </script>