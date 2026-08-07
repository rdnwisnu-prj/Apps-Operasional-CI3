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
                    <li class="breadcrumb-item active">KPI Target Tahunan</li>
                </ol>
            </nav>
        </div>


        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data KPI Tahunan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
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
                            <div class="col-md-3">
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
                        <p class="text-muted mb-0">Silakan pilih User dan Tahun untuk menampilkan data KPI
                            Tahunan.<br>
                            Pilihan Sasaran Mutu bersifat opsional (kosongkan untuk menampilkan semua).</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section: Laporan KPI Tahunan -->
        <div class="row d-none" id="kpiTableContainer">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0"><i class="ri-bar-chart-grouped-line me-2"></i>Laporan
                                Pencapaian KPI Tahunan</h5>
                            <small class="text-muted">
                                User: <strong id="selectedUserName">-</strong> |
                                Tahun: <strong id="selectedYear">-</strong> |
                                Sasaran Mutu: <strong id="selectedSarmut">Semua</strong>
                            </small>
                        </div>
                        <div>
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
                                        <th class="text-center align-middle" rowspan="2" style="width: 50px;">No.</th>
                                        <th class="text-center align-middle" rowspan="2" style="min-width: 180px;">Sasaran Mutu</th>
                                        <th class="text-center align-middle" colspan="12">Achievement per Bulan</th>
                                        <th class="text-center align-middle" rowspan="2" style="width: 100px;">Total</th>
                                        <th class="text-center align-middle" rowspan="2" style="width: 100px;">Target Tahunan</th>
                                        <th class="text-center align-middle" rowspan="2" style="width: 80px;">%</th>
                                        <th class="text-center align-middle" rowspan="2" style="width: 100px;">Status</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($bulan_names as $key => $nama): ?>
                                        <th class="text-center" style="width: 70px; font-size: 11px;"><?= substr($nama, 0, 3) ?></th>
                                        <?php endforeach; ?>
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
                                    <span class="badge bg-danger">Merah</span> Tercapai < 50%
                                </small>
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
</div>

<style>
#kpiTable {
    font-size: 11px;
}

#kpiTable th,
#kpiTable td {
    vertical-align: middle;
    padding: 6px 4px;
}

#kpiTable thead th {
    background-color: #405189;
    color: white;
    border-color: #364574;
}

#kpiTable thead tr:nth-child(2) th {
    background-color: #4a5b9d;
}

.table-success-custom {
    background-color: rgba(25, 135, 84, 0.15) !important;
}

.table-danger-custom {
    background-color: rgba(220, 53, 69, 0.15) !important;
}

.monthly-cell {
    min-width: 60px;
    font-size: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = '<?= base_url() ?>';
    let currentUserId = null;
    let currentTahun = null;
    let currentSarmutId = null;
    let currentData = null;

    const bulanNames = <?= json_encode($bulan_names) ?>;
    const sasaranMutuList = <?= json_encode($sasaran_mutu) ?>;

    // Button Tampilkan Click
    document.getElementById('btnTampilkan').addEventListener('click', function() {
        const userId = document.getElementById('user_id').value;
        const tahun = document.getElementById('tahun').value;
        const sarmutId = document.getElementById('sarmut_id').value;

        if (!userId) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih User terlebih dahulu!'
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

        loadKPIData(userId, tahun, sarmutId);
    });

    // Load KPI Data via AJAX
    function loadKPIData(userId, tahun, sarmutId) {
        // Hide all sections, show loading
        hideAllSections();
        document.getElementById('loadingIndicator').classList.remove('d-none');

        let postData = 'user_id=' + userId + '&tahun=' + tahun;
        if (sarmutId) {
            postData += '&sarmut_id=' + sarmutId;
        }

        fetch(baseUrl + 'KPI/Tahunan/getKPIData', {
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
                    currentSarmutId = sarmutId;
                    currentData = data;

                    // Update user info
                    const userName = data.user ? data.user.nama : '-';

                    // Get selected sarmut name
                    let sarmutNama = 'Semua';
                    if (sarmutId) {
                        const selectedSarmut = sasaranMutuList.find(s => s.id == sarmutId);
                        if (selectedSarmut) {
                            sarmutNama = selectedSarmut.nama;
                        }
                    }

                    document.getElementById('selectedUserName').textContent = userName;
                    document.getElementById('selectedYear').textContent = tahun;
                    document.getElementById('selectedSarmut').textContent = sarmutNama;
                    document.getElementById('footerUserName').textContent = userName;
                    document.getElementById('footerValidator').textContent = data.validator || '-';

                    // Render KPI table
                    renderKPITable(data);
                    document.getElementById('kpiTableContainer').classList.remove('d-none');

                    // Update Export button
                    const btnExport = document.getElementById('btnExport');
                    let exportUrl = baseUrl + 'KPI/Tahunan/exportExcel?user_id=' + userId + '&tahun=' + tahun;
                    if (sarmutId) {
                        exportUrl += '&sarmut_id=' + sarmutId;
                    }
                    btnExport.href = exportUrl;

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
        document.getElementById('kpiTableContainer').classList.add('d-none');
    }

    // Render KPI Table for Tahunan (Annual)
    function renderKPITable(data) {
        let html = '';
        let no = 1;

        if (data.report_data.length === 0) {
            html = '<tr><td colspan="18" class="text-center text-muted py-4">Tidak ada data ditemukan</td></tr>';
        } else {
            data.report_data.forEach(function(item) {
                const persentase = item.persentase_tahunan;
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

                // Monthly data (January to December)
                for (let bulan = 1; bulan <= 12; bulan++) {
                    const monthValue = item.monthly_data[bulan] || 0;
                    const cellClass = monthValue > 0 ? 'text-primary fw-bold' : 'text-muted';
                    html += '<td class="text-center monthly-cell ' + cellClass + '">' + formatValue(monthValue, item.key) + '</td>';
                }

                // Total Achievement
                html += '<td class="text-center fw-bold text-success">' + formatValue(item.total_achievement, item.key) + '</td>';

                // Target Tahunan
                html += '<td class="text-center fw-bold">' + formatValue(item.target_tahunan, item.key) + '</td>';

                // Persentase
                html += '<td class="text-center"><span class="badge ' + badgeClass + '">' + persentase.toFixed(0) + '%</span></td>';

                // Status
                html += '<td class="text-center"><span class="badge ' + badgeClass + '">' + statusText + '</span></td>';

                html += '</tr>';
            });
        }

        document.getElementById('kpiTableBody').innerHTML = html;
    }

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
});
</script>
