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

        <!-- Chart Keluhan Tahunan -->
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                        <h6 class="mb-0">Keluhan Tahunan</h6>
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown"
                                href="javascript:void(0);" id="yearDropdownKeluhan">
                                <i class="ti ti-calendar me-1"></i>
                                <span id="selectedYearKeluhan"><?= $current_year ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php for ($y = 2025; $y <= 2030; $y++): ?>
                                <a href="javascript:void(0);" class="dropdown-item year-keluhan-item"
                                    data-year="<?= $y ?>">
                                    <?= $y ?>
                                </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="KeluhanTahunanChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Data Keluhan -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data Keluhan</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="filter_user_id" id="filter_user_id" class="form-control">
                            <option value="">-- Semua Customer Service --</option>
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
                        <button type="button" id="btnFilterKeluhanClient" class="btn btn-primary me-2">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                        <button type="button" id="btnResetFilterKeluhanClient" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Keluhan -->
        <div class="card border-0 rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between gap-2 flex-wrap">
                <h5 class="card-title mb-0">Data Keluhan Client</h5>
                <button type="button" id="btnDownloadExcelKeluhan" class="btn btn-primary">
                    <i class="ti ti-file-download me-1"></i>Download Report
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-table">
                    <table class="table table-nowrap" id="keluhan_client_reports">
                        <thead class="table-light">
                            <tr>
                                <th>Tgl Masuk</th>
                                <th>Perusahaan</th>
                                <th>PIC</th>
                                <th>Media</th>
                                <th>Divisi</th>
                                <th>Kategori</th>
                                <th>Customer Service</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    var keluhanMonthlyData = <?= json_encode($keluhan_monthly) ?>;
    </script>