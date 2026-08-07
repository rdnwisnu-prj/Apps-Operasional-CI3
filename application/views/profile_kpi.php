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
                <h4 class="mb-1">Profile</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="">Menu</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                    <img src="<?= base_url('upload/employee/' . $team['foto']); ?>" alt="img">
                                    <span class="status online"></span>
                                </div>
                                <div>
                                    <h5 class="mb-1"><?= $team['nama']; ?></h5>
                                    <p class="mb-2"><?= $team['jabatan']; ?> - <?= $team['nama_posisi']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">Basic Information</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-mail fs-14"></i>
                                </span>
                                <p class="mb-0"><?php echo $team['email']; ?>
                                </p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-phone fs-14"></i>
                                </span>
                                <p class="mb-0"><?php echo $team['no_tlp']; ?></p>
                            </div>
                        </div>
                        <h6 class="mb-3 fw-semibold">Job Information</h6>
                        <ul>
                            <li class="row mb-2"><span class="col-6">NIK</span><span
                                    class="col-6 text-dark"><?php echo $team['nik']; ?></span></li>
                            <li class="row mb-2"><span class="col-6">Cabang</span><span
                                    class="col-6 text-dark"><?php echo $team['nama_cabang']; ?></span></li>
                            <li class="row mb-2"><span class="col-6">Jabatan</span><span
                                    class="col-6 text-dark"><?php echo $team['jabatan']; ?></span></li>
                            <li class="row"><span class="col-6">Posisi</span><span
                                    class="col-6 text-dark"><?php echo $team['nama_posisi']; ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card mb-3">
                    <div class="card-body pb-3 pt-3">
                        <ul class="nav nav-pills animation-nav profile-nav gap-3 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link fs-14" href="<?php echo base_url()?>Profile">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">Pengaturan Akun</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-14 active" href="<?php echo base_url()?>Profile/Kpi">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                        class="d-none d-md-inline-block">KPI Saya</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Filter Form -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter KPI
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-select">
                                            <option value="">-- Pilih Bulan --</option>
                                            <?php foreach ($bulan_names as $key => $nama): ?>
                                            <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>>
                                                <?= $nama ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control">
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php for ($y = date('Y') - 1; $y <= date('Y') + 5; $y++): ?>
                                            <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>>
                                                <?= $y ?>
                                            </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" id="btnTampilkan" class="btn btn-primary me-2">
                                            <i class="ri-search-line me-1"></i> Tampilkan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div class="row d-none" id="loadingIndicator">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-3 text-muted">Memuat data KPI...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State (Default) -->
                <div class="row" id="emptyState">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="ri-bar-chart-box-line" style="font-size: 80px; color: #ccc;"></i>
                                <h5 class="text-muted mt-3">Pilih Tahun</h5>
                                <p class="text-muted mb-0">Silakan pilih tahun untuk menampilkan data KPI
                                    Sasaran Mutu Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Target State -->
                <div class="row d-none" id="noTargetState">
                    <div class="col-12">
                        <div class="card border-warning">
                            <div class="card-body text-center py-5">
                                <i class="ri-error-warning-line text-warning" style="font-size: 80px;"></i>
                                <h5 class="text-warning mt-3">Target Belum Diatur</h5>
                                <p class="text-muted mb-0">Pengaturan target belum dilakukan untuk periode <strong
                                        id="noTargetPeriod">-</strong>.
                                    Silakan hubungi SPV Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI Monthly Table -->
                <div class="row d-none" id="kpiMonthlyContainer">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0"><i class="ri-bar-chart-grouped-line me-2"></i>Laporan
                                        KPI Bulanan</h5>
                                    <small class="text-muted">
                                        Periode: <strong id="monthlyPeriod">-</strong>
                                    </small>
                                </div>
                                <button type="button" id="btnExportMonthly" class="btn btn-success btn-sm">
                                    <i class="ri-file-excel-2-line me-1"></i> Export Excel
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle" id="kpiMonthlyTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">No.</th>
                                                <th class="text-center" style="min-width: 200px;">Sasaran Mutu</th>
                                                <th class="text-center" style="width: 120px;">Target Bulanan</th>
                                                <th class="text-center" style="width: 120px;">Achievement</th>
                                                <th class="text-center" style="width: 100px;">Persentase</th>
                                                <th class="text-center" style="width: 120px;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="kpiMonthlyTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Keterangan Warna:</strong><br>
                                            <span class="badge bg-success">Hijau</span> ≥ 100%
                                            <span class="badge bg-info">Biru</span> 75-99%
                                            <span class="badge bg-warning">Kuning</span> 50-74%
                                            <span class="badge bg-danger">Merah</span> &lt; 50%
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            <strong>Divalidasi Oleh:</strong>
                                            <span id="monthlyValidator" class="text-primary fw-bold">-</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI Yearly Table -->
                <div class="row d-none" id="kpiYearlyContainer">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-0"><i class="ri-bar-chart-grouped-line me-2"></i>Laporan
                                        KPI Tahunan</h5>
                                    <small class="text-muted">
                                        Tahun: <strong id="yearlyPeriod">-</strong>
                                    </small>
                                </div>
                                <button type="button" id="btnExportYearly" class="btn btn-success btn-sm">
                                    <i class="ri-file-excel-2-line me-1"></i> Export Excel
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle" id="kpiYearlyTable">
                                        <thead class="table-dark">
                                            <tr>
                                                <th rowspan="2" class="text-center align-middle" style="width: 50px;">
                                                    No.</th>
                                                <th rowspan="2" class="text-center align-middle"
                                                    style="min-width: 200px;">Sasaran Mutu</th>
                                                <th colspan="12" class="text-center bg-primary">Laporan Pencapaian
                                                    Bulanan</th>
                                                <th rowspan="2" class="text-center align-middle" style="width: 100px;">
                                                    Total</th>
                                                <th rowspan="2" class="text-center align-middle" style="width: 100px;">
                                                    Target Tahunan</th>
                                                <th rowspan="2" class="text-center align-middle" style="width: 80px;">%
                                                </th>
                                                <th rowspan="2" class="text-center align-middle" style="width: 120px;">
                                                    Status</th>
                                            </tr>
                                            <tr>
                                                <?php foreach ($bulan_names as $bulan): ?>
                                                <th class="text-center" style="min-width: 60px;">
                                                    <?= strtoupper(substr($bulan, 0, 3)) ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody id="kpiYearlyTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Keterangan Warna:</strong><br>
                                            <span class="badge bg-success">Hijau</span> ≥ 100%
                                            <span class="badge bg-info">Biru</span> 75-99%
                                            <span class="badge bg-warning">Kuning</span> 50-74%
                                            <span class="badge bg-danger">Merah</span> &lt; 50%
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small class="text-muted">
                                            <strong>Divalidasi Oleh:</strong>
                                            <span id="yearlyValidator" class="text-primary fw-bold">-</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Achievement -->
    <div class="modal fade" id="detailAchievementModal" tabindex="-1" aria-labelledby="detailAchievementLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="detailAchievementLabel">
                        <i class="ri-file-list-3-line me-2"></i>Detail Achievement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="badge bg-primary me-2" id="detailSarmutName">-</span>
                        <span class="badge bg-secondary me-2" id="detailUserName">-</span>
                        <span class="badge bg-info" id="detailPeriode">-</span>
                        <span class="float-end fw-bold">Total: <span id="detailTotal"
                                class="text-primary">0</span></span>
                    </div>
                    <div id="detailLoading" class="text-center py-4 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat detail data...</p>
                    </div>
                    <div class="table-responsive" id="detailTableWrapper">
                        <table class="table table-bordered table-hover table-sm" id="detailTable">
                            <thead class="table-light" id="detailTableHead"></thead>
                            <tbody id="detailTableBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" id="btnExportDetail" class="btn btn-success" target="_blank">
                        <i class="ri-file-excel-2-line me-1"></i> Download Excel
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .achievement-link {
        cursor: pointer;
        text-decoration: underline;
        color: #405189 !important;
        font-weight: bold;
    }

    .achievement-link:hover {
        color: #0d6efd !important;
    }

    #detailTable {
        font-size: 12px;
    }

    #detailTable th,
    #detailTable td {
        vertical-align: middle;
        padding: 6px 8px;
    }
    </style>

    <script>
    var currentTahun = '';
    var currentBulan = '';

    document.getElementById('btnTampilkan').addEventListener('click', function() {
        var tahun = document.getElementById('tahun').value;
        var bulan = document.getElementById('bulan').value;

        if (!tahun) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih tahun terlebih dahulu!'
            });
            return;
        }

        currentTahun = tahun;
        currentBulan = bulan;

        // Hide all sections first
        hideAllSections();

        // Show loading
        document.getElementById('loadingIndicator').classList.remove('d-none');

        // Make AJAX request
        $.ajax({
            url: base_url + 'Profile/getKPIData',
            type: 'POST',
            data: {
                tahun: tahun,
                bulan: bulan
            },
            dataType: 'json',
            success: function(response) {
                document.getElementById('loadingIndicator').classList.add('d-none');

                if (response.success) {
                    if (!response.has_target) {
                        // Show no target state
                        var period = bulan ? response.bulan_nama + ' ' + tahun : 'Tahun ' + tahun;
                        document.getElementById('noTargetPeriod').textContent = period;
                        document.getElementById('noTargetState').classList.remove('d-none');
                        return;
                    }

                    if (response.mode === 'monthly') {
                        displayMonthlyKPI(response);
                    } else {
                        displayYearlyKPI(response);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Gagal memuat data KPI'
                    });
                    document.getElementById('emptyState').classList.remove('d-none');
                }
            },
            error: function(xhr, status, error) {
                document.getElementById('loadingIndicator').classList.add('d-none');
                document.getElementById('emptyState').classList.remove('d-none');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data'
                });
            }
        });
    });

    function hideAllSections() {
        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('loadingIndicator').classList.add('d-none');
        document.getElementById('noTargetState').classList.add('d-none');
        document.getElementById('kpiMonthlyContainer').classList.add('d-none');
        document.getElementById('kpiYearlyContainer').classList.add('d-none');
    }

    function displayMonthlyKPI(data) {
        // Set period info
        document.getElementById('monthlyPeriod').textContent = data.bulan_nama + ' ' + data.tahun;
        document.getElementById('monthlyValidator').textContent = data.validator || '-';

        // Build table body
        var tbody = document.getElementById('kpiMonthlyTableBody');
        tbody.innerHTML = '';

        data.report_data.forEach(function(item, index) {
            var persentase = parseFloat(item.persentase) || 0;
            var badgeClass = getBadgeClass(persentase);
            var status = getStatus(persentase);

            var row = '<tr>' +
                '<td class="text-center">' + (index + 1) + '</td>' +
                '<td>' + item.nama + '</td>' +
                '<td class="text-center">' + formatNumber(item.target_bulanan) + '</td>' +
                '<td class="text-center"><a href="javascript:void(0)" class="achievement-link" data-key="' +
                item.key + '" data-nama="' + escapeHtml(item.nama) + '">' + formatNumber(item.achievement) +
                '</a></td>' +
                '<td class="text-center"><span class="badge ' + badgeClass + '">' + persentase.toFixed(1) +
                '%</span></td>' +
                '<td class="text-center"><span class="badge ' + badgeClass + '">' + status + '</span></td>' +
                '</tr>';

            tbody.innerHTML += row;
        });

        // Show monthly container
        document.getElementById('kpiMonthlyContainer').classList.remove('d-none');
    }

    function displayYearlyKPI(data) {
        // Set period info
        document.getElementById('yearlyPeriod').textContent = data.tahun;
        document.getElementById('yearlyValidator').textContent = data.validator || '-';

        // Build table body
        var tbody = document.getElementById('kpiYearlyTableBody');
        tbody.innerHTML = '';

        data.report_data.forEach(function(item, index) {
            var persentase = parseFloat(item.persentase_tahunan) || 0;
            var badgeClass = getBadgeClass(persentase);
            var status = getStatus(persentase);

            var row = '<tr>' +
                '<td class="text-center">' + (index + 1) + '</td>' +
                '<td>' + item.nama + '</td>';

            // Monthly data columns
            for (var m = 1; m <= 12; m++) {
                var monthValue = item.monthly_data[m] || 0;
                row += '<td class="text-center">' + formatNumber(monthValue) + '</td>';
            }

            row += '<td class="text-center fw-bold">' + formatNumber(item.total_achievement) + '</td>' +
                '<td class="text-center">' + formatNumber(item.target_tahunan) + '</td>' +
                '<td class="text-center"><span class="badge ' + badgeClass + '">' + persentase.toFixed(1) +
                '%</span></td>' +
                '<td class="text-center"><span class="badge ' + badgeClass + '">' + status + '</span></td>' +
                '</tr>';

            tbody.innerHTML += row;
        });

        // Show yearly container
        document.getElementById('kpiYearlyContainer').classList.remove('d-none');
    }

    function getBadgeClass(persentase) {
        if (persentase >= 100) return 'bg-success';
        if (persentase >= 75) return 'bg-info';
        if (persentase >= 50) return 'bg-warning';
        return 'bg-danger';
    }

    function getStatus(persentase) {
        if (persentase >= 100) return 'Tercapai';
        if (persentase >= 75) return 'Hampir';
        if (persentase >= 50) return 'Perlu Tingkat';
        return 'Tidak Tercapai';
    }

    function formatNumber(num) {
        if (num === null || num === undefined) return '0';
        var n = parseFloat(num);
        if (isNaN(n)) return '0';
        if (Number.isInteger(n)) return n.toLocaleString('id-ID');
        return n.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatDate(dateStr) {
        if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
        var d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        return String(d.getDate()).padStart(2, '0') + '/' + String(d.getMonth() + 1).padStart(2, '0') + '/' + d
            .getFullYear();
    }

    // Achievement Detail Click Handler
    document.getElementById('kpiMonthlyTableBody').addEventListener('click', function(e) {
        var link = e.target.closest('.achievement-link');
        if (!link) return;
        var sarmutKey = link.getAttribute('data-key');
        var sarmutNama = link.getAttribute('data-nama');
        if (!currentTahun || !currentBulan) return;
        loadAchievementDetail(sarmutKey, sarmutNama);
    });

    function loadAchievementDetail(sarmutKey, sarmutNama) {
        var modalEl = document.getElementById('detailAchievementModal');
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);

        document.getElementById('detailSarmutName').textContent = sarmutNama;
        document.getElementById('detailUserName').textContent = '';
        document.getElementById('detailPeriode').textContent = '';
        document.getElementById('detailTotal').textContent = '...';
        document.getElementById('detailTableHead').innerHTML = '';
        document.getElementById('detailTableBody').innerHTML = '';
        document.getElementById('detailLoading').classList.remove('d-none');
        document.getElementById('detailTableWrapper').classList.add('d-none');
        modal.show();

        $.ajax({
            url: base_url + 'Profile/getAchievementDetail',
            type: 'POST',
            data: {
                tahun: currentTahun,
                bulan: currentBulan,
                sarmut_key: sarmutKey
            },
            dataType: 'json',
            success: function(data) {
                document.getElementById('detailLoading').classList.add('d-none');
                document.getElementById('detailTableWrapper').classList.remove('d-none');

                if (data.success) {
                    document.getElementById('detailUserName').textContent = 'User: ' + data.user_nama;
                    document.getElementById('detailPeriode').textContent = data.bulan_nama + ' ' + data
                        .tahun;
                    document.getElementById('detailTotal').textContent = data.total;

                    var exportUrl = base_url + 'Profile/exportAchievementDetail?tahun=' + currentTahun +
                        '&bulan=' + currentBulan + '&sarmut_key=' + encodeURIComponent(sarmutKey);
                    document.getElementById('btnExportDetail').href = exportUrl;

                    renderDetailTable(sarmutKey, data.data);
                } else {
                    document.getElementById('detailTableBody').innerHTML =
                        '<tr><td colspan="10" class="text-center text-danger py-3">' + (data.message ||
                            'Gagal memuat data') + '</td></tr>';
                }
            },
            error: function() {
                document.getElementById('detailLoading').classList.add('d-none');
                document.getElementById('detailTableWrapper').classList.remove('d-none');
                document.getElementById('detailTableBody').innerHTML =
                    '<tr><td colspan="10" class="text-center text-danger py-3">Terjadi kesalahan saat memuat data</td></tr>';
            }
        });
    }

    function renderDetailTable(sarmutKey, data) {
        var columns = getDetailColumns(sarmutKey);
        var headHtml = '<tr><th class="text-center" style="width:50px">No</th>';
        columns.forEach(function(col) {
            headHtml += '<th class="' + (col.align || '') + '">' + col.label + '</th>';
        });
        headHtml += '</tr>';

        var bodyHtml = '';
        if (data.length === 0) {
            bodyHtml = '<tr><td colspan="' + (columns.length + 1) +
                '" class="text-center text-muted py-4">Tidak ada data</td></tr>';
        } else {
            data.forEach(function(row, index) {
                bodyHtml += '<tr><td class="text-center">' + (index + 1) + '</td>';
                columns.forEach(function(col) {
                    var val = row[col.field] !== undefined && row[col.field] !== null ? row[col.field] :
                        '-';
                    if (col.format === 'currency') val = 'Rp ' + formatNumber(val);
                    else if (col.format === 'date' && val && val !== '-') val = formatDate(val);
                    bodyHtml += '<td class="' + (col.align || '') + '">' + escapeHtml(String(val)) +
                        '</td>';
                });
                bodyHtml += '</tr>';
            });
        }

        document.getElementById('detailTableHead').innerHTML = headHtml;
        document.getElementById('detailTableBody').innerHTML = bodyHtml;
    }

    function getDetailColumns(sarmutKey) {
        var map = {
            'proposal_masuk': [{
                    field: 'nama_client',
                    label: 'Nama Perusahaan'
                },
                {
                    field: 'alamat_client',
                    label: 'Alamat Perusahaan'
                },
                {
                    field: 'sektor',
                    label: 'Sektor'
                },
                {
                    field: 'project',
                    label: 'Project'
                },
                {
                    field: 'service',
                    label: 'Service'
                },
                {
                    field: 'nama_pic',
                    label: 'PIC'
                },
                {
                    field: 'email_pic',
                    label: 'Email'
                },
                {
                    field: 'status_lead',
                    label: 'Status',
                    align: 'text-center'
                },
                {
                    field: 'catatan',
                    label: 'Keterangan'
                    format: 'date'
                }
            ],
            'keluhan_pelanggan': [{
                    field: 'nama_client',
                    label: 'Nama Client'
                },
                {
                    field: 'kategori',
                    label: 'Kategori',
                    align: 'text-center'
                },
                {
                    field: 'pic',
                    label: 'PIC'
                },
                {
                    field: 'complain',
                    label: 'Keluhan'
                },
                {
                    field: 'tgl_masuk',
                    label: 'Tgl Masuk',
                    align: 'text-center',
                    format: 'date'
                },
                {
                    field: 'tgl_selesai',
                    label: 'Tgl Selesai',
                    align: 'text-center',
                    format: 'date'
                },
                {
                    field: 'keterangan',
                    label: 'Keterangan'
                }
            ],
            'customer_repeat_order': [{
                    field: 'nama_client',
                    label: 'Nama Client'
                },
                {
                    field: 'nama_project',
                    label: 'Nama Project'
                },
                {
                    field: 'service',
                    label: 'Service'
                },
                {
                    field: 'estimasi',
                    label: 'Estimasi',
                    align: 'text-end',
                    format: 'currency'
                },
                {
                    field: 'status_project',
                    label: 'Status',
                    align: 'text-center'
                },
                {
                    field: 'tgl_pelaksanaan',
                    label: 'Tgl Pelaksanaan',
                    align: 'text-center',
                    format: 'date'
                },
                {
                    field: 'tgl_selesai',
                    label: 'Tgl Selesai',
                    align: 'text-center',
                    format: 'date'
                }
            ],
            'achievement_sales': [{
                    field: 'nama_client',
                    label: 'Nama Client'
                },
                {
                    field: 'nama_project',
                    label: 'Nama Project'
                },
                {
                    field: 'service',
                    label: 'Service'
                },
                {
                    field: 'estimasi',
                    label: 'Estimasi',
                    align: 'text-end',
                    format: 'currency'
                },
                {
                    field: 'status_project',
                    label: 'Status',
                    align: 'text-center'
                },
                {
                    field: 'tgl_pelaksanaan',
                    label: 'Tgl Pelaksanaan',
                    align: 'text-center',
                    format: 'date'
                },
                {
                    field: 'tgl_selesai',
                    label: 'Tgl Selesai',
                    align: 'text-center',
                    format: 'date'
                }
            ],
            'new_customer': [{
                    field: 'nama_client',
                    label: 'Nama Client'
                },
                {
                    field: 'nama_pic',
                    label: 'PIC'
                },
                {
                    field: 'tlp_pic',
                    label: 'Telepon'
                },
                {
                    field: 'email_pic',
                    label: 'Email'
                },
                {
                    field: 'sektor',
                    label: 'Sektor'
                },
                {
                    field: 'status',
                    label: 'Status',
                    align: 'text-center'
                },
                {
                    field: 'created_at',
                    label: 'Tanggal',
                    align: 'text-center',
                    format: 'date'
                }
            ],
            'project_lost': [{
                    field: 'nama_client',
                    label: 'Nama Client'
                },
                {
                    field: 'nama_pic',
                    label: 'PIC'
                },
                {
                    field: 'project',
                    label: 'Project'
                },
                {
                    field: 'service',
                    label: 'Service'
                },
                {
                    field: 'estimasi_lead',
                    label: 'Estimasi',
                    align: 'text-end',
                    format: 'currency'
                },
                {
                    field: 'status_lead',
                    label: 'Status',
                    align: 'text-center'
                },
                {
                    field: 'created_at',
                    label: 'Tanggal',
                    align: 'text-center',
                    format: 'date'
                }
            ]
        };
        return map[sarmutKey] || [{
            field: 'id',
            label: 'ID'
        }];
    }

    // Export Excel buttons
    document.getElementById('btnExportMonthly').addEventListener('click', function() {
        if (currentTahun && currentBulan) {
            window.location.href = base_url + 'Profile/exportExcel?tahun=' + currentTahun + '&bulan=' +
                currentBulan;
        }
    });

    document.getElementById('btnExportYearly').addEventListener('click', function() {
        if (currentTahun) {
            window.location.href = base_url + 'Profile/exportExcel?tahun=' + currentTahun;
        }
    });
    </script>