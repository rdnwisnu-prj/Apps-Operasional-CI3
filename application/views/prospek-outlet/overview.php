<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $header; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="">Marketing Outlet</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $subheader; ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group" role="group" aria-label="Prospek Outlet Navigation">
                        <a href="<?= base_url('ProspekOutlet'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'overview') ? 'active' : ''; ?>">
                            Overview
                        </a>
                        <a href="<?= base_url('ProspekOutlet/DataProspek'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'data') ? 'active' : ''; ?>">
                            Data Prospek
                        </a>
                        <a href="<?= base_url('ProspekOutlet/Kanban'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'kanban') ? 'active' : ''; ?>">
                            Kanban
                        </a>
                    </div>
                    <a href="<?= base_url('ProspekOutlet/DataProspek'); ?>" class="btn btn-custom">
                        <i class="ri-table-line align-bottom me-1"></i> Data Prospek
                    </a>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- Chart Total Prospek Outlet -->
            <div class="col-md-7 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                        <h6 class="mb-0">Total Prospek Outlet MCU</h6>
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown"
                                href="javascript:void(0);" id="yearDropdownProspekOutlet">
                                <i class="ti ti-calendar me-1"></i>
                                <span id="selectedYearProspekOutlet"><?= $current_year ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php for ($y = 2025; $y <= 2030; $y++): ?>
                                <a href="javascript:void(0);" class="dropdown-item year-prospek-outlet-item"
                                    data-year="<?= $y ?>">
                                    <?= $y ?>
                                </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ProspekOutletTahunanChart"></div>
                    </div>
                </div>
            </div>
            <!-- End Chart Total Prospek Outlet -->

            <!-- Chart Status Prospek Outlet -->
            <div class="col-md-5 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                        <h6 class="mb-0">Status Prospek Outlet</h6>
                        <div class="d-flex align-items-center gap-2">
                            <select id="statusProspekOutletMonth" class="form-select form-select-sm w-auto">
                                <?php foreach ($bulan_names as $key => $nama): ?>
                                <option value="<?= $key ?>"
                                    <?= ((int) $current_month === (int) $key) ? 'selected' : '' ?>>
                                    <?= $nama ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <select id="statusProspekOutletYear" class="form-select form-select-sm w-auto">
                                <?php for ($y = 2025; $y <= 2030; $y++): ?>
                                <option value="<?= $y ?>" <?= ((int) $current_year === (int) $y) ? 'selected' : '' ?>>
                                    <?= $y ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="StatusProspekOutletTahunanChart"></div>
                    </div>
                </div>
            </div>
            <!-- End Chart Status Prospek Outlet -->
        </div>

        <!-- Card Sales Prospek Outlet MCU -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                <h6 class="mb-0">Sales Prospek Outlet MCU</h6>
                <div class="dropdown">
                    <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown"
                        href="javascript:void(0);" id="yearDropdownSalesProspekOutletMcu">
                        <i class="ti ti-calendar me-1"></i>
                        <span id="selectedYearSalesProspekOutletMcu"><?= $current_year ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <?php for ($y = 2025; $y <= 2030; $y++): ?>
                        <a href="javascript:void(0);" class="dropdown-item year-sales-prospek-outlet-mcu-item"
                            data-year="<?= $y ?>">
                            <?= $y ?>
                        </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="TotalSalesProspekOutlet"></div>
            </div>
        </div>

        <!-- Top 10 Prospek Outlet -->
        <div class="card flex-fill">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h6 class="mb-0">Top 10 Prospek Outlet</h6>
                    <div class="d-flex align-items-center gap-2">
                        <select id="topProspekOutletMonth" class="form-select form-select-sm w-auto">
                            <?php foreach ($bulan_names as $key => $nama): ?>
                            <option value="<?= $key ?>" <?= ((int) $current_month === (int) $key) ? 'selected' : '' ?>>
                                <?= $nama ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <select id="topProspekOutletYear" class="form-select form-select-sm w-auto">
                            <?php for ($y = 2025; $y <= 2030; $y++): ?>
                            <option value="<?= $y ?>" <?= ((int) $current_year === (int) $y) ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive custom-table">
                    <table class="table table-nowrap" id="top-leads-outlet">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Outlet</th>
                                <th>Nama PIC</th>
                                <th>Estimasi</th>
                                <th>Marketing</th>
                            </tr>
                        </thead>
                        <tbody id="topProspekOutletBody">
                            <?php if (!empty($top_leads)): ?>
                            <?php foreach ($top_leads as $lead): ?>
                            <tr>
                                <td><?= htmlspecialchars($lead['nama_client']) ?></td>
                                <td><?= htmlspecialchars($lead['service']) ?></td>
                                <td><?= htmlspecialchars($lead['nama_pic']) ?></td>
                                <td>Rp <?= number_format($lead['estimasi_lead'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($lead['marketing'] ?? '-') ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data prospek outlet dengan status
                                    Deal</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    var prospekOutletMonthlyData = <?= json_encode($prospek_monthly) ?>;
    var prospekOutletStatusLabels = <?= json_encode($prospek_status['labels']) ?>;
    var prospekOutletStatusData = <?= json_encode($prospek_status['data']) ?>;
    var salesProspekOutletMcuData = <?= json_encode($sales_mcu_monthly) ?>;
    var currentProspekOutletMonth = <?= json_encode((int) $current_month) ?>;
    var currentProspekOutletYear = <?= json_encode((int) $current_year) ?>;
    </script>