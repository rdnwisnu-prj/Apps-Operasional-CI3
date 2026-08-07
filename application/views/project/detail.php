<?php
$finance = $financial_summary ?? [];
$process_finance = $finance['expense_by_process'] ?? [];
$category_totals = $finance['category_totals'] ?? [];
$grand_budget = (float) ($finance['grand_budget'] ?? 0);
$grand_initial_budget = (float) ($finance['grand_initial_budget'] ?? $grand_budget);
$grand_topup = (float) ($finance['grand_topup'] ?? 0);
$grand_expense = (float) ($finance['grand_expense'] ?? 0);
$grand_remaining = (float) ($finance['grand_remaining'] ?? 0);
$financial_scope = $financial_scope ?? 'Semua Proses';

if (!function_exists('project_detail_money')) {
    function project_detail_money($value)
    {
        return 'Rp ' . number_format((float) ($value ?? 0), 0, ',', '.');
    }
}

if (!function_exists('project_detail_number')) {
    function project_detail_number($value)
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return number_format((float) $value, 0, ',', '.');
    }
}

if (!function_exists('project_detail_date')) {
    function project_detail_date($date)
    {
        return !empty($date) ? tanggal_indonesia_medium($date) : '-';
    }
}

if (!function_exists('project_detail_date_range')) {
    function project_detail_date_range($start, $end = null)
    {
        $startLabel = project_detail_date($start);
        $endLabel = project_detail_date($end);

        if ($endLabel === '-' || $startLabel === $endLabel) {
            return $startLabel;
        }

        return $startLabel . ' - ' . $endLabel;
    }
}

$startDate = $project_detail['tgl_mulai'] ?? null;
$endDate = $project_detail['tgl_selesai'] ?? null;
$durationDays = '-';
if (!empty($startDate) && !empty($endDate)) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $durationDays = $start->diff($end)->days + 1;
}

$budgetPercentRaw = $grand_budget > 0 ? max(0, ($grand_expense / $grand_budget) * 100) : 0;
$budgetPercent = min(100, $budgetPercentRaw);
$processCount = count($process_finance);
$processCardClass = $processCount === 1 ? 'col-md-12' : ($processCount === 3 ? 'col-md-4' : 'col-md-3');

$operationalTabs = [];
foreach ($process_finance as $processKey => $processRow) {
    foreach (($processRow['categories'] ?? []) as $categoryKey => $category) {
        if (!isset($operationalTabs[$categoryKey])) {
            $operationalTabs[$categoryKey] = [
                'label' => $category['label'] ?? ucfirst($categoryKey),
                'rows' => [],
                'total' => 0,
                'count' => 0,
            ];
        }

        foreach (($category['rows'] ?? []) as $expense) {
            $expense['process_label'] = $processRow['label'] ?? '-';
            $expense['process_key'] = $processKey;
            $operationalTabs[$categoryKey]['rows'][] = $expense;
        }

        $operationalTabs[$categoryKey]['total'] += (float) ($category['total'] ?? 0);
        $operationalTabs[$categoryKey]['count'] += (int) ($category['count'] ?? 0);
    }
}
?>

<style>
.project-detail-stat,
.project-process-summary {
    border: 1px solid var(--bs-border-color);
    border-radius: 8px;
    padding: 16px;
    height: 100%;
    background: var(--bs-body-bg);
}

.project-detail-stat .icon-box {
    width: 42px;
    height: 42px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.project-info-card .info-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 12px;
}

.project-info-card .info-row:last-child {
    margin-bottom: 0;
}

.project-info-card .info-label {
    color: var(--bs-secondary-color);
    margin-bottom: 0;
}

.project-info-card .info-value {
    color: var(--bs-body-color);
    font-weight: 600;
    margin-bottom: 0;
    text-align: right;
    word-break: break-word;
}

.project-korlap-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px dashed var(--bs-border-color);
}

.project-korlap-item:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.project-expense-table th,
.project-expense-table td {
    white-space: normal;
    vertical-align: middle;
}

.project-expense-table .item-meta {
    font-size: 12px;
}

@media (max-width: 767.98px) {
    .project-info-card .info-row {
        display: block;
    }

    .project-info-card .info-value {
        text-align: left;
        margin-top: 4px;
    }
}
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
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <h4 class="mb-0"><?= html_escape($project_detail['nama_project']); ?></h4>
                    <span class="badge bg-primary-subtle text-primary">Tampilan:
                        <?= html_escape($financial_scope); ?></span>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('Project'); ?>">Data Project</a></li>
                        <li class="breadcrumb-item active"><?= html_escape($project_detail['kode_project']); ?></li>
                    </ol>
                </nav>
            </div>
            <a href="<?= base_url('Project'); ?>" class="btn btn-outline-light">
                <i class="ti ti-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="project-detail-stat">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="text-muted mb-1">Total Saldo</p>
                            <small class="text-muted d-block mb-1"><?= html_escape($financial_scope); ?></small>
                            <h4 class="mb-0"><?= project_detail_money($grand_budget); ?></h4>
                        </div>
                        <span class="icon-box bg-primary-subtle text-primary"><i class="ti ti-wallet fs-22"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="project-detail-stat">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="text-muted mb-1">Total Pengeluaran</p>
                            <small class="text-muted d-block mb-1"><?= html_escape($financial_scope); ?></small>
                            <h4 class="mb-0"><?= project_detail_money($grand_expense); ?></h4>
                        </div>
                        <span class="icon-box bg-warning-subtle text-warning"><i
                                class="ti ti-receipt-2 fs-22"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="project-detail-stat">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="text-muted mb-1">Sisa Budget</p>
                            <small class="text-muted d-block mb-1"><?= html_escape($financial_scope); ?></small>
                            <h4 class="mb-0 <?= $grand_remaining < 0 ? 'text-danger' : 'text-success'; ?>">
                                <?= project_detail_money($grand_remaining); ?></h4>
                        </div>
                        <span
                            class="icon-box <?= $grand_remaining < 0 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success'; ?>"><i
                                class="ti ti-calculator fs-22"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="project-detail-stat">
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div>
                            <p class="text-muted mb-1">Top Up Saldo</p>
                            <small class="text-muted d-block mb-1">Tambahan saldo</small>
                            <h4 class="mb-0"><?= project_detail_money($grand_topup); ?></h4>
                        </div>
                        <span class="icon-box bg-info-subtle text-info"><i class="ti ti-circle-plus fs-22"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <?php foreach ($process_finance as $process => $row): ?>
            <?php
                    $processBudget = (float) ($row['budget'] ?? 0);
                    $processInitialBudget = (float) ($row['initial_budget'] ?? 0);
                    $processTopup = (float) ($row['topup'] ?? 0);
                    $processExpense = (float) ($row['total'] ?? 0);
                    $processRemaining = (float) ($row['remaining'] ?? 0);
                    $processPercent = $processBudget > 0 ? min(100, max(0, ($processExpense / $processBudget) * 100)) : 0;
                    ?>
            <div class="<?= $processCardClass; ?>">
                <div class="project-process-summary">
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                        <div>
                            <span class="badge bg-primary-subtle text-primary mb-2">Proses
                                <?= html_escape($process); ?></span>
                            <h6 class="mb-0"><?= html_escape($row['label']); ?></h6>
                        </div>
                        <i class="ti ti-activity fs-22 text-muted"></i>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Budget Awal</span>
                        <span class="fw-semibold"><?= project_detail_money($processInitialBudget); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Top Up</span>
                        <span class="fw-semibold"><?= project_detail_money($processTopup); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Saldo</span>
                        <span class="fw-semibold"><?= project_detail_money($processBudget); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Pengeluaran</span>
                        <span class="fw-semibold"><?= project_detail_money($processExpense); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Sisa</span>
                        <span
                            class="fw-semibold <?= $processRemaining < 0 ? 'text-danger' : 'text-success'; ?>"><?= project_detail_money($processRemaining); ?></span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar <?= $processRemaining < 0 ? 'bg-danger' : 'bg-success'; ?>"
                            role="progressbar" style="width: <?= $processPercent; ?>%;"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-4">
            <div class="col-xl-3">
                <div class="card project-info-card">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">Informasi Project</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="info-row">
                                <p class="info-label">Kode Project</p>
                                <p class="info-value"><?= html_escape($project_detail['kode_project']); ?></p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Nama Project</p>
                                <p class="info-value"><?= html_escape($project_detail['nama_project']); ?></p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Periode</p>
                                <p class="info-value"><?= project_detail_date_range($startDate, $endDate); ?></p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Perusahaan</p>
                                <p class="info-value"><?= html_escape($project_detail['nama_perusahaan'] ?? '-'); ?></p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Site</p>
                                <p class="info-value"><?= html_escape($project_detail['nama_site'] ?? '-'); ?></p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Lokasi</p>
                                <p class="info-value">
                                    <?= html_escape(trim(($project_detail['nama_kota'] ?? '') . ' ' . ($project_detail['nama_provinsi'] ?? '')) ?: '-'); ?>
                                </p>
                            </div>
                            <div class="info-row">
                                <p class="info-label">Dibuat Oleh</p>
                                <p class="info-value"><?= html_escape($project_detail['created_by'] ?? '-'); ?></p>
                            </div>
                        </div>

                        <h6 class="mb-3 fw-semibold">Deskripsi</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <p class="mb-0"><?= nl2br(html_escape($project_detail['deskripsi'] ?? '-')); ?></p>
                        </div>

                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <h6 class="mb-3 fw-semibold">Korlap</h6>
                            <span
                                class="badge bg-primary-subtle text-primary mb-3"><?= project_detail_number(count($korlap ?? [])); ?>
                                orang</span>
                        </div>
                        <?php if (!empty($korlap)): ?>
                        <div>
                            <?php foreach ($korlap as $row): ?>
                            <?php $initial = strtoupper(substr((string) ($row['nama'] ?? 'K'), 0, 1)); ?>
                            <div class="project-korlap-item">
                                <span
                                    class="avatar avatar-sm rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center flex-shrink-0"><?= html_escape($initial); ?></span>
                                <div class="flex-grow-1">
                                    <p class="mb-0 fw-semibold"><?= html_escape($row['nama'] ?? '-'); ?></p>
                                    <small
                                        class="text-muted"><?= project_detail_date_range($row['tgl_mulai'] ?? null, $row['tgl_selesai'] ?? null); ?></small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-muted mb-0">Belum ada data korlap.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card">
                    <div
                        class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <div>
                            <h5 class="card-title mb-0">Detail Pengeluaran Operasional</h5>
                            <small class="text-muted">Data dipisah per operasional untuk tampilan
                                <?= html_escape($financial_scope); ?>.</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-bordered border-0 mb-3" role="tablist">
                            <?php $tabIndex = 0; ?>
                            <?php foreach ($operationalTabs as $categoryKey => $tab): ?>
                            <?php $tabIndex++; ?>
                            <li class="nav-item" role="presentation">
                                <a href="#project-expense-<?= html_escape($categoryKey); ?>" data-bs-toggle="tab"
                                    class="nav-link border-3 <?= $tabIndex === 1 ? 'active' : ''; ?>"
                                    aria-selected="<?= $tabIndex === 1 ? 'true' : 'false'; ?>" role="tab">
                                    <?= html_escape($tab['label']); ?>
                                    <span
                                        class="badge bg-secondary-subtle text-secondary ms-1"><?= project_detail_number($tab['count']); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <div class="tab-content">
                            <?php $paneIndex = 0; ?>
                            <?php foreach ($operationalTabs as $categoryKey => $tab): ?>
                            <?php $paneIndex++; ?>
                            <div class="tab-pane fade <?= $paneIndex === 1 ? 'show active' : ''; ?>"
                                id="project-expense-<?= html_escape($categoryKey); ?>" role="tabpanel">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-3">
                                    <h6 class="mb-0"><?= html_escape($tab['label']); ?></h6>
                                    <span class="badge bg-success-subtle text-success">Total
                                        <?= project_detail_money($tab['total']); ?></span>
                                </div>

                                <?php if (!empty($tab['rows'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle project-expense-table mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 14%;">Proses</th>
                                                <th style="width: 14%;">Tanggal</th>
                                                <th>Detail</th>
                                                <th class="text-end" style="width: 10%;">Qty</th>
                                                <th class="text-end" style="width: 14%;">Nominal</th>
                                                <th class="text-end" style="width: 14%;">Total</th>
                                                <th style="width: 12%;">Input Oleh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tab['rows'] as $expense): ?>
                                            <tr>
                                                <td><span
                                                        class="badge bg-primary-subtle text-primary"><?= html_escape($expense['process_label'] ?? '-'); ?></span>
                                                </td>
                                                <td><?= project_detail_date_range($expense['date_start'] ?? null, $expense['date_end'] ?? null); ?>
                                                </td>
                                                <td>
                                                    <span
                                                        class="fw-semibold d-block"><?= html_escape($expense['item_name'] ?? '-'); ?></span>
                                                    <?php if (!empty($expense['item_meta'])): ?>
                                                    <span
                                                        class="text-muted item-meta d-block"><?= html_escape($expense['item_meta']); ?></span>
                                                    <?php endif; ?>
                                                    <?php if (!empty($expense['keterangan'])): ?>
                                                    <span
                                                        class="text-muted item-meta d-block"><?= html_escape($expense['keterangan']); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end">
                                                    <?= project_detail_number($expense['quantity'] ?? null); ?>
                                                </td>
                                                <td class="text-end">
                                                    <?= $expense['unit_price'] === null ? '-' : project_detail_money($expense['unit_price']); ?>
                                                </td>
                                                <td class="text-end fw-semibold">
                                                    <?= $expense['amount'] === null ? '-' : project_detail_money($expense['amount']); ?>
                                                </td>
                                                <td><?= html_escape($expense['created_by'] ?? '-'); ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div class="border rounded p-3 text-muted">Belum ada pengeluaran
                                    <?= html_escape($tab['label']); ?>.</div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            </div>


        </div>


    </div>