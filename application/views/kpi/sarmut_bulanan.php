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
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader;?></a></li>
                    <li class="breadcrumb-item active">KPI Target Bulanan</li>
                </ol>
            </nav>
        </div>


        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data KPI Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="user_id" class="form-label">Pilih User/Sales</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="">-- Pilih User --</option>
                                    <?php foreach ($users as $u): ?>
                                    <option value="<?= $u['id_user'] ?>">
                                        <?= htmlspecialchars($u['nama']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="sarmut_id" class="form-label">Sasaran Mutu</label>
                                <select name="sarmut_id" id="sarmut_id" class="form-select">
                                    <option value="">-- Semua Sasaran Mutu --</option>
                                    <?php foreach ($sasaran_mutu as $sm): ?>
                                    <option value="<?= $sm['id'] ?>">
                                        <?= htmlspecialchars($sm['nama']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <label for="tahun" class="form-label">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select">
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php for ($y = date('Y') - 2; $y <= date('Y') + 5; $y++): ?>
                                    <option value="<?= $y ?>" <?= ($tahun == $y) ? 'selected' : '' ?>>
                                        <?= $y ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" id="btnTampilkan" class="btn btn-primary w-100">
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
                        <h5 class="text-muted mt-3">Pilih Filter untuk Menampilkan Data</h5>
                        <p class="text-muted mb-0">Silakan pilih User, Bulan, dan Tahun untuk menampilkan data KPI
                            Bulanan.<br>
                            Pilihan Sasaran Mutu bersifat opsional (kosongkan untuk menampilkan semua).</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 1: Set Target (Tampil jika belum ada target) -->
        <div class="row d-none" id="setTargetSection">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning bg-opacity-10">
                        <h5 class="card-title mb-0 text-warning">
                            <i class="ri-settings-3-line me-2"></i>Pengaturan Target KPI Bulanan
                        </h5>
                        <small class="text-muted">
                            User: <strong id="targetUserName">-</strong> |
                            Bulan: <strong id="targetBulan">-</strong> |
                            Tahun: <strong id="targetYear">-</strong>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="targetAlert">
                            <i class="ri-information-line me-2"></i>
                            <strong>Perhatian!</strong> Target KPI belum diatur untuk user, bulan, dan tahun ini.
                            Silakan atur target untuk setiap sasaran mutu terlebih dahulu.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>

                        <form id="formSetTarget">
                            <input type="hidden" name="user_id" id="target_user_id">
                            <input type="hidden" name="tahun" id="target_tahun">
                            <input type="hidden" name="bulan" id="target_bulan">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="targetTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 50px;">No</th>
                                            <th style="min-width: 200px;">Sasaran Mutu</th>
                                            <th class="text-center" style="width: 100px;">Satuan</th>
                                            <th class="text-center" style="width: 200px;">Target</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($sasaran_mutu as $sm): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($sm['nama']) ?></td>
                                            <td class="text-center">
                                                <span
                                                    class="badge bg-secondary"><?= htmlspecialchars($sm['satuan']) ?></span>
                                            </td>
                                            <td>
                                                <input type="number" name="targets[<?= $sm['id'] ?>][target]"
                                                    class="form-control form-control-sm text-end target-input" value="0"
                                                    step="0.01" min="0" data-sarmut-id="<?= $sm['id'] ?>"
                                                    data-nama="<?= htmlspecialchars($sm['nama']) ?>" placeholder="0">
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    Masukkan target bulanan dan target tahunan untuk setiap sasaran mutu, lalu klik
                                    Simpan.
                                </small>
                                <div>
                                    <button type="button" class="btn btn-secondary d-none" id="btnCancelEdit">
                                        <i class="ri-close-line me-1"></i> Batal
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="btnSaveTarget">
                                        <i class="ri-save-line me-1"></i> Simpan Target
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Laporan KPI (Tampil jika sudah ada target) -->
        <div class="row d-none" id="kpiTableContainer">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0"><i class="ri-bar-chart-grouped-line me-2"></i>Laporan
                                Pencapaian KPI Bulanan</h5>
                            <small class="text-muted">
                                User: <strong id="selectedUserName">-</strong> |
                                Bulan: <strong id="selectedBulan">-</strong> |
                                Tahun: <strong id="selectedYear">-</strong> |
                                Sasaran Mutu: <strong id="selectedSarmut">Semua</strong>
                            </small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-warning me-2" id="btnEditTarget">
                                <i class="ri-edit-line me-1"></i> Edit Target
                            </button>
                            <a href="#" id="btnExport" class="btn btn-sm btn-success">
                                <i class="ri-file-excel-2-line me-1"></i> Export Excel
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="kpiTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center align-middle" style="width: 50px;">No.</th>
                                        <th class="text-center align-middle" style="min-width: 200px;">Sasaran Mutu</th>
                                        <th class="text-center align-middle" style="width: 120px;">Target Bulanan</th>
                                        <th class="text-center align-middle" style="width: 140px;">Achievement</th>
                                        <th class="text-center align-middle" style="width: 100px;">Persentase</th>
                                        <th class="text-center align-middle" style="width: 120px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="kpiTableBody">
                                    <!-- Data akan diisi via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Keterangan Warna Persentase:</strong><br>
                                    <span class="badge bg-success">Hijau</span> Tercapai ≥ 100% &nbsp;
                                    <span class="badge bg-info">Biru</span> Tercapai 75-99% &nbsp;
                                    <span class="badge bg-warning">Kuning</span> Tercapai 50-74% &nbsp;
                                    <span class="badge bg-danger">Merah</span> Tercapai < 50% </small>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <strong>Dibuat Oleh:</strong><br>
                                            <span id="footerUserName" class="text-primary fw-bold">-</span>
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <strong>Divalidasi Oleh:</strong><br>
                                            <span id="footerValidator" class="text-primary fw-bold">-</span>
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
                <div class="mb-3" id="detailInfo">
                    <span class="badge bg-primary me-2" id="detailSarmutName">-</span>
                    <span class="badge bg-secondary me-2" id="detailUserName">-</span>
                    <span class="badge bg-info" id="detailPeriode">-</span>
                    <span class="float-end fw-bold">Total: <span id="detailTotal" class="text-primary">0</span></span>
                </div>
                <div id="detailLoading" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat detail data...</p>
                </div>
                <div class="table-responsive" id="detailTableWrapper">
                    <table class="table table-bordered table-hover table-sm" id="detailTable">
                        <thead class="table-light" id="detailTableHead">
                        </thead>
                        <tbody id="detailTableBody">
                        </tbody>
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
#kpiTable,
#targetTable {
    font-size: 12px;
}

#kpiTable th,
#kpiTable td,
#targetTable th,
#targetTable td {
    vertical-align: middle;
    padding: 8px 6px;
}

#kpiTable thead th {
    background-color: #405189;
    color: white;
    border-color: #364574;
}

.table-success-custom {
    background-color: rgba(25, 135, 84, 0.15) !important;
}

.table-danger-custom {
    background-color: rgba(220, 53, 69, 0.15) !important;
}

.target-input {
    min-width: 120px;
}

.achievement-link {
    cursor: pointer;
    text-decoration: underline;
    color: #405189 !important;
    font-weight: bold;
}

.achievement-link:hover {
    color: #0d6efd !important;
    text-decoration: underline;
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
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = '<?= base_url() ?>';
    let currentUserId = null;
    let currentTahun = null;
    let currentBulan = null;
    let currentSarmutId = null;
    let currentTargets = {};
    let currentTargetsById = {};
    let currentData = null;
    let isEditMode = false;

    const bulanNames = <?= json_encode($bulan_names) ?>;
    const sasaranMutuList = <?= json_encode($sasaran_mutu) ?>;

    // Button Tampilkan Click
    document.getElementById('btnTampilkan').addEventListener('click', function() {
        const userId = document.getElementById('user_id').value;
        const tahun = document.getElementById('tahun').value;
        const bulan = document.getElementById('bulan').value;
        const sarmutId = document.getElementById('sarmut_id').value;

        if (!userId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih User terlebih dahulu!'
            });
            return;
        }

        if (!bulan) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih Bulan terlebih dahulu!'
            });
            return;
        }

        if (!tahun) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih Tahun terlebih dahulu!'
            });
            return;
        }

        isEditMode = false;
        loadKPIData(userId, tahun, bulan, sarmutId);
    });

    // Button Edit Target Click
    document.getElementById('btnEditTarget').addEventListener('click', function() {
        isEditMode = true;
        updateTargetForm(currentTargetsById);
        showSetTargetSection(true);
    });

    // Button Cancel Edit Click
    document.getElementById('btnCancelEdit').addEventListener('click', function() {
        isEditMode = false;
        if (currentData && currentData.has_target) {
            hideAllSections();
            document.getElementById('kpiTableContainer').classList.remove('d-none');
        } else {
            hideAllSections();
            document.getElementById('emptyState').classList.remove('d-none');
        }
    });

    // Load KPI Data via AJAX
    function loadKPIData(userId, tahun, bulan, sarmutId) {
        // Hide all sections, show loading
        hideAllSections();
        document.getElementById('loadingIndicator').classList.remove('d-none');

        let postData = 'user_id=' + userId + '&tahun=' + tahun + '&bulan=' + bulan;
        if (sarmutId) {
            postData += '&sarmut_id=' + sarmutId;
        }

        fetch(baseUrl + 'KPI/Bulanan/getKPIData', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: postData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingIndicator').classList.add('d-none');

                if (data.success) {
                    currentUserId = userId;
                    currentTahun = tahun;
                    currentBulan = bulan;
                    currentSarmutId = sarmutId;
                    currentTargets = data.targets || {};
                    currentTargetsById = data.targets_by_id || {};
                    currentData = data;

                    // Set hidden fields for form
                    document.getElementById('target_user_id').value = userId;
                    document.getElementById('target_tahun').value = tahun;
                    document.getElementById('target_bulan').value = bulan;

                    // Update user info
                    const userName = data.user ? data.user.nama : '-';
                    const bulanNama = data.bulan_nama || bulanNames[bulan] || '-';

                    // Get selected sarmut name
                    let sarmutNama = 'Semua';
                    if (sarmutId) {
                        const selectedSarmut = sasaranMutuList.find(s => s.id == sarmutId);
                        if (selectedSarmut) {
                            sarmutNama = selectedSarmut.nama;
                        }
                    }

                    document.getElementById('targetUserName').textContent = userName;
                    document.getElementById('targetYear').textContent = tahun;
                    if (document.getElementById('targetBulan')) {
                        document.getElementById('targetBulan').textContent = bulanNama;
                    }
                    document.getElementById('selectedUserName').textContent = userName;
                    document.getElementById('selectedYear').textContent = tahun;
                    document.getElementById('selectedBulan').textContent = bulanNama;
                    document.getElementById('selectedSarmut').textContent = sarmutNama;
                    document.getElementById('footerUserName').textContent = userName;
                    document.getElementById('footerValidator').textContent = data.validator || '-';

                    // Check if target exists
                    const hasTarget = data.has_target || false;

                    if (hasTarget && !isEditMode) {
                        // Target sudah ada, tampilkan laporan KPI
                        renderKPITable(data);
                        document.getElementById('kpiTableContainer').classList.remove('d-none');

                        // Update Export button
                        const btnExport = document.getElementById('btnExport');
                        let exportUrl = baseUrl + 'KPI/Bulanan/exportExcel?user_id=' + userId +
                            '&tahun=' +
                            tahun + '&bulan=' + bulan;
                        if (sarmutId) {
                            exportUrl += '&sarmut_id=' + sarmutId;
                        }
                        btnExport.href = exportUrl;
                    } else {
                        // Target belum ada atau mode edit, tampilkan form set target
                        updateTargetForm(currentTargetsById);
                        showSetTargetSection(isEditMode);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Gagal memuat data KPI'
                    });
                    document.getElementById('emptyState').classList.remove('d-none');
                }
            })
            .catch(error => {
                document.getElementById('loadingIndicator').classList.add('d-none');
                document.getElementById('emptyState').classList.remove('d-none');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat data'
                });
            });
    }

    // Hide all sections
    function hideAllSections() {
        document.getElementById('loadingIndicator').classList.add('d-none');
        document.getElementById('emptyState').classList.add('d-none');
        document.getElementById('setTargetSection').classList.add('d-none');
        document.getElementById('kpiTableContainer').classList.add('d-none');
    }

    // Show set target section
    function showSetTargetSection(isEdit) {
        hideAllSections();
        document.getElementById('setTargetSection').classList.remove('d-none');

        const alertDiv = document.getElementById('targetAlert');
        const btnCancel = document.getElementById('btnCancelEdit');

        if (isEdit) {
            alertDiv.innerHTML = `
                <i class="ri-edit-line me-2"></i>
                <strong>Mode Edit!</strong> Anda sedang mengedit target KPI. 
                Ubah nilai target sesuai kebutuhan, lalu klik Simpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertDiv.classList.remove('alert-warning');
            alertDiv.classList.add('alert-info');
            btnCancel.classList.remove('d-none');
        } else {
            alertDiv.innerHTML = `
                <i class="ri-information-line me-2"></i>
                <strong>Perhatian!</strong> Target KPI belum diatur untuk user dan tahun ini. 
                Silakan atur target bulanan dan tahunan untuk setiap sasaran mutu terlebih dahulu.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertDiv.classList.remove('alert-info');
            alertDiv.classList.add('alert-warning');
            btnCancel.classList.add('d-none');
        }
    }

    // Render KPI Table for Bulanan
    function renderKPITable(data) {
        let html = '';
        let no = 1;

        if (data.report_data.length === 0) {
            html =
                '<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data ditemukan</td></tr>';
        } else {
            data.report_data.forEach(function(item) {
                const persentase = item.persentase;
                const tipeTarget = item.tipe_target || 'higher_better';

                // Badge color for percentage
                let badgeClass = 'bg-danger';
                let statusText = 'Tidak Tercapai';
                if (persentase >= 100) {
                    badgeClass = 'bg-success';
                    statusText = 'Tercapai';
                } else if (persentase >= 75) {
                    badgeClass = 'bg-info';
                    statusText = 'Hampir Tercapai';
                } else if (persentase >= 50) {
                    badgeClass = 'bg-warning';
                    statusText = 'Perlu Peningkatan';
                }

                html += '<tr>';
                html += '<td class="text-center">' + no++ + '</td>';
                html += '<td>' + escapeHtml(item.nama) + '</td>';

                // Target Bulanan
                html += '<td class="text-center fw-bold">' + formatValue(item.target_bulanan, item
                    .key) + '</td>';

                // Achievement (clickable)
                html +=
                    '<td class="text-center"><a href="javascript:void(0)" class="achievement-link" data-key="' +
                    item.key + '" data-nama="' + escapeHtml(item.nama) + '">' + formatValue(item
                        .achievement,
                        item.key) + '</a></td>';

                // Persentase
                html += '<td class="text-center"><span class="badge ' + badgeClass + '">' +
                    persentase
                    .toFixed(0) + '%</span></td>';

                // Status
                html += '<td class="text-center"><span class="badge ' + badgeClass + '">' +
                    statusText +
                    '</span></td>';

                html += '</tr>';
            });
        }

        document.getElementById('kpiTableBody').innerHTML = html;
    }

    // Update Target Form with current values
    function updateTargetForm(targetsById) {
        document.querySelectorAll('.target-input').forEach(function(input) {
            const sarmutId = input.getAttribute('data-sarmut-id');
            const nama = input.getAttribute('data-nama');

            // Try to get value by ID first (more reliable), then fallback to name
            if (targetsById && targetsById[sarmutId]) {
                input.value = targetsById[sarmutId].bulanan || 0;
            } else if (currentTargets && currentTargets[nama]) {
                input.value = currentTargets[nama].bulanan || 0;
            } else {
                input.value = 0;
            }
        });
    }

    // Save Target Form
    document.getElementById('formSetTarget').addEventListener('submit', function(e) {
        e.preventDefault();

        const userId = document.getElementById('target_user_id').value;
        const tahun = document.getElementById('target_tahun').value;
        const bulan = document.getElementById('target_bulan').value;

        if (!userId || !tahun || !bulan) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih User, Bulan, dan Tahun terlebih dahulu!'
            });
            return;
        }

        // Validate at least one target is filled
        let hasValue = false;
        document.querySelectorAll('.target-input').forEach(function(input) {
            if (parseFloat(input.value) > 0) {
                hasValue = true;
            }
        });

        if (!hasValue) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan isi minimal satu target!'
            });
            return;
        }

        const formData = new FormData(this);
        const btnSave = document.getElementById('btnSaveTarget');
        btnSave.disabled = true;
        btnSave.innerHTML =
            '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

        fetch(baseUrl + 'KPI/Bulanan/saveTargets', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="ri-save-line me-1"></i> Simpan Target';

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload KPI data to show report
                        isEditMode = false;
                        const bulan = document.getElementById('bulan').value;
                        const sarmutId = document.getElementById('sarmut_id').value;
                        loadKPIData(userId, tahun, bulan, sarmutId);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Gagal menyimpan target'
                    });
                }
            })
            .catch(error => {
                btnSave.disabled = false;
                btnSave.innerHTML = '<i class="ri-save-line me-1"></i> Simpan Target';
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            });
    });

    // Helper Functions
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function formatValue(value, key) {
        if (key === 'achievement_sales') {
            return formatNumber(value);
        }
        return value;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Achievement Detail Click Handler (Event Delegation)
    document.getElementById('kpiTableBody').addEventListener('click', function(e) {
        const link = e.target.closest('.achievement-link');
        if (!link) return;

        const sarmutKey = link.getAttribute('data-key');
        const sarmutNama = link.getAttribute('data-nama');

        if (!currentUserId || !currentTahun || !currentBulan) return;

        loadAchievementDetail(sarmutKey, sarmutNama);
    });

    // Load Achievement Detail via AJAX
    function loadAchievementDetail(sarmutKey, sarmutNama) {
        const modalEl = document.getElementById('detailAchievementModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        const detailLoading = document.getElementById('detailLoading');
        const detailTableWrapper = document.getElementById('detailTableWrapper');

        // Show modal with loading
        document.getElementById('detailSarmutName').textContent = sarmutNama;
        document.getElementById('detailUserName').textContent = '';
        document.getElementById('detailPeriode').textContent = '';
        document.getElementById('detailTotal').textContent = '...';
        document.getElementById('detailTableHead').innerHTML = '';
        document.getElementById('detailTableBody').innerHTML = '';
        detailLoading.classList.remove('d-none');
        detailTableWrapper.classList.add('d-none');
        modal.show();

        const postData = 'user_id=' + currentUserId + '&tahun=' + currentTahun + '&bulan=' + currentBulan +
            '&sarmut_key=' + encodeURIComponent(sarmutKey);

        fetch(baseUrl + 'KPI/Bulanan/getAchievementDetail', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: postData
            })
            .then(response => response.json())
            .then(data => {
                detailLoading.classList.add('d-none');
                detailTableWrapper.classList.remove('d-none');

                if (data.success) {
                    document.getElementById('detailUserName').textContent = 'User: ' + data.user_nama;
                    document.getElementById('detailPeriode').textContent = data.bulan_nama + ' ' + data
                        .tahun;
                    document.getElementById('detailTotal').textContent = data.total;

                    // Set export URL
                    const exportUrl = baseUrl + 'KPI/Bulanan/exportAchievementDetail?user_id=' +
                        currentUserId + '&tahun=' + currentTahun + '&bulan=' + currentBulan +
                        '&sarmut_key=' + encodeURIComponent(sarmutKey);
                    document.getElementById('btnExportDetail').href = exportUrl;

                    renderDetailTable(sarmutKey, data.data);
                } else {
                    document.getElementById('detailTableBody').innerHTML =
                        '<tr><td colspan="10" class="text-center text-danger py-3">' + (data.message ||
                            'Gagal memuat data') + '</td></tr>';
                }
            })
            .catch(error => {
                detailLoading.classList.add('d-none');
                detailTableWrapper.classList.remove('d-none');
                document.getElementById('detailTableBody').innerHTML =
                    '<tr><td colspan="10" class="text-center text-danger py-3">Terjadi kesalahan saat memuat data</td></tr>';
                console.error('Error:', error);
            });
    }

    // Render Detail Table based on sarmut_key
    function renderDetailTable(sarmutKey, data) {
        let headHtml = '';
        let bodyHtml = '';
        const columns = getDetailColumns(sarmutKey);

        // Build header
        headHtml = '<tr>';
        headHtml += '<th class="text-center" style="width:50px">No</th>';
        columns.forEach(function(col) {
            headHtml += '<th class="' + (col.align || '') + '">' + col.label + '</th>';
        });
        headHtml += '</tr>';

        // Build body
        if (data.length === 0) {
            bodyHtml = '<tr><td colspan="' + (columns.length + 1) +
                '" class="text-center text-muted py-4">Tidak ada data</td></tr>';
        } else {
            data.forEach(function(row, index) {
                bodyHtml += '<tr>';
                bodyHtml += '<td class="text-center">' + (index + 1) + '</td>';
                columns.forEach(function(col) {
                    let val = row[col.field] !== undefined && row[col.field] !== null ? row[
                        col
                        .field] : '-';
                    if (col.format === 'currency') {
                        val = 'Rp ' + formatNumber(val);
                    } else if (col.format === 'date' && val && val !== '-') {
                        val = formatDate(val);
                    }
                    bodyHtml += '<td class="' + (col.align || '') + '">' + escapeHtml(
                        String(
                            val)) + '</td>';
                });
                bodyHtml += '</tr>';
            });
        }

        document.getElementById('detailTableHead').innerHTML = headHtml;
        document.getElementById('detailTableBody').innerHTML = bodyHtml;
    }

    // Column definitions per sarmut_key
    function getDetailColumns(sarmutKey) {
        switch (sarmutKey) {
            case 'proposal_masuk':
                return [{
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
                    }
                ];
            case 'keluhan_pelanggan':
                return [{
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
                ];
            case 'customer_repeat_order':
                return [{
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
                ];
            case 'achievement_sales':
                return [{
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
                ];
            case 'new_customer':
                return [{
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
                ];
            case 'project_lost':
                return [{
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
                ];
            default:
                return [{
                    field: 'id',
                    label: 'ID'
                }];
        }
    }

    // Format date helper
    function formatDate(dateStr) {
        if (!dateStr || dateStr === '-' || dateStr === '0000-00-00') return '-';
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return day + '/' + month + '/' + year;
    }
});
</script>