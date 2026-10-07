<?php
$dashboard = $dashboard ?? [];
$cards = $dashboard['cards'] ?? [];
$trend = $dashboard['trend'] ?? ['labels' => [], 'series' => []];
$composition = $dashboard['composition'] ?? ['labels' => [], 'series' => [], 'total' => 0];
$budgetRows = $dashboard['budget_rows'] ?? [];
$transactions = $dashboard['transactions'] ?? [];

if (!function_exists('dashboard_rupiah')) {
    function dashboard_rupiah($value)
    {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    }
}

if (!function_exists('dashboard_compact_rupiah')) {
    function dashboard_compact_rupiah($value)
    {
        $value = (float) $value;
        $abs = abs($value);

        if ($abs >= 1000000000) {
            return 'Rp ' . number_format($value / 1000000000, 1, ',', '.') . ' M';
        }

        if ($abs >= 1000000) {
            return 'Rp ' . number_format($value / 1000000, 1, ',', '.') . ' jt';
        }

        if ($abs >= 1000) {
            return 'Rp ' . number_format($value / 1000, 1, ',', '.') . ' rb';
        }

        return dashboard_rupiah($value);
    }
}

if (!function_exists('dashboard_date')) {
    function dashboard_date($date)
    {
        return !empty($date) ? tanggal_indonesia_medium($date) : '-';
    }
}

if (!function_exists('dashboard_status_class')) {
    function dashboard_status_class($status)
    {
        $status = strtolower((string) $status);
        if ($status === 'selesai' || $status === 'normal') {
            return 'success';
        }
        if ($status === 'waspada' || $status === 'menunggu') {
            return 'warning';
        }
        if ($status === 'validasi') {
            return 'primary';
        }
        return 'info';
    }
}

$cardStyles = [
    'success' => ['card' => 'dash-soft-success', 'badge' => 'dash-badge-success'],
    'danger' => ['card' => 'dash-soft-danger', 'badge' => 'dash-badge-danger'],
    'primary' => ['card' => 'dash-soft-primary', 'badge' => 'dash-badge-success'],
    'purple' => ['card' => 'dash-soft-purple', 'badge' => 'dash-badge-success'],
    'warning' => ['card' => 'dash-soft-warning', 'badge' => 'dash-badge-danger'],
];
?>
<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <style>
    .ops-dashboard {
        color: #111827;
    }

    .ops-dashboard .page-title {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .ops-dashboard .page-subtitle {
        color: #64748b;
        font-size: 15px;
        margin-bottom: 0;
    }

    .ops-toolbar {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
    }

    .ops-card,
    .ops-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .06);
    }

    .ops-card {
        min-height: 142px;
        padding: 22px;
    }

    .ops-card-inner {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .ops-icon {
        width: 62px;
        height: 62px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 31px;
        flex: 0 0 62px;
    }

    .dash-soft-success {
        background: #dff8f1;
        color: #00a889;
    }

    .dash-soft-danger {
        background: #ffe0e4;
        color: #ef4444;
    }

    .dash-soft-primary {
        background: #dcecff;
        color: #0d6efd;
    }

    .dash-soft-purple {
        background: #eadbff;
        color: #8b5cf6;
    }

    .dash-soft-warning {
        background: #fff1d6;
        color: #ea7a00;
    }

    .ops-card-label {
        color: #334155;
        font-size: 14px;
        margin-bottom: 7px;
    }

    .ops-card-value {
        color: #0f172a;
        font-size: 27px;
        font-weight: 800;
        line-height: 1.15;
    }

    .ops-card-footer {
        margin-top: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #64748b;
        font-size: 13px;
    }

    .ops-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 9px;
        border-radius: 999px;
        font-weight: 700;
    }

    .dash-badge-success {
        background: #dff8f1;
        color: #00a889;
    }

    .dash-badge-danger {
        background: #ffe3e6;
        color: #ef4444;
    }

    .ops-panel {
        padding: 20px;
    }

    .ops-panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 18px;
    }

    .ops-panel-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ops-panel-title h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 800;
    }

    .ops-panel-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .ops-chart {
        min-height: 285px;
        width: 100%;
        overflow: hidden;
    }

    .ops-chart .apexcharts-canvas {
        margin: 0 auto;
    }

    .composition-wrap {
        display: grid;
        grid-template-columns: minmax(240px, 1fr) minmax(230px, 300px);
        gap: 22px;
        align-items: center;
    }

    .composition-list {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .composition-item {
        display: grid;
        grid-template-columns: 14px 1fr auto 46px;
        gap: 12px;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eef2f7;
        font-size: 14px;
    }

    .composition-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .composition-amount {
        font-weight: 800;
        color: #0f172a;
        white-space: nowrap;
    }

    .composition-percent {
        color: #64748b;
        text-align: right;
    }

    .ops-table {
        margin-bottom: 0;
        font-size: 13px;
    }

    .ops-table thead th {
        background: #f8fafc;
        color: #475569;
        font-weight: 800;
        border-bottom: 0;
        padding: 12px;
    }

    .ops-table tbody td {
        padding: 11px 12px;
        vertical-align: middle;
        border-color: #eef2f7;
    }

    .progress-mini {
        display: inline-block;
        width: 90px;
        height: 8px;
        overflow: hidden;
        border-radius: 999px;
        background: #e5e7eb;
        vertical-align: middle;
    }

    .progress-mini>span {
        display: block;
        height: 100%;
        border-radius: inherit;
        background: #00a889;
    }

    .progress-mini.warn>span {
        background: #f59e0b;
    }

    .ops-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 74px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .ops-pill-success {
        background: #dcfce7;
        color: #079455;
    }

    .ops-pill-warning {
        background: #fef3c7;
        color: #d97706;
    }

    .ops-pill-primary {
        background: #dbeafe;
        color: #0d6efd;
    }

    .ops-pill-info {
        background: #e0f2fe;
        color: #0369a1;
    }

    .cat-dokter-project {
        background: #dbeafe;
        color: #0d6efd;
    }

    .cat-dokter-retail {
        background: #dff8f1;
        color: #008f79;
    }

    .cat-top-up {
        background: #dcfce7;
        color: #16a34a;
    }

    .cat-makan {
        background: #ffe0ef;
        color: #db2777;
    }

    .cat-transport {
        background: #eadbff;
        color: #6d28d9;
    }

    .cat-penginapan {
        background: #dbeafe;
        color: #0d6efd;
    }

    .cat-default {
        background: #f1f5f9;
        color: #475569;
    }

    @media (max-width: 1199px) {
        .composition-wrap {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <div class="content pb-0 ops-dashboard">
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap mb-4">
            <div>
                <h1 class="page-title">Selamat Datang, <?= html_escape($this->session->userdata('nama') ?: 'User'); ?>!
                </h1>
                <p class="page-subtitle">Berikut adalah data ringkasan operasional keuangan anda</p>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <?php foreach ($cards as $card): ?>
            <?php
            $style = $cardStyles[$card['tone'] ?? 'success'] ?? $cardStyles['success'];
            $percentage = (float) ($card['percentage'] ?? 0);
            $isUp = $percentage >= 0;
            ?>
            <div class="col-xxl col-xl-4 col-md-6">
                <div class="ops-card h-100">
                    <div class="ops-card-inner">
                        <span class="ops-icon <?= $style['card']; ?>"><i
                                class="<?= html_escape($card['icon']); ?>"></i></span>
                        <div>
                            <div class="ops-card-label"><?= html_escape($card['label']); ?></div>
                            <div class="ops-card-value"><?= html_escape($card['value_label']); ?></div>
                        </div>
                    </div>
                    <div class="ops-card-footer">
                        <span
                            class="ops-badge <?= $isUp ? ($style['badge'] ?? 'dash-badge-success') : 'dash-badge-danger'; ?>">
                            <i class="ti <?= $isUp ? 'ti-arrow-up-right' : 'ti-arrow-down-right'; ?>"></i>
                            <?= number_format(abs($percentage), 1, ',', '.'); ?>%
                        </span>
                        <span>dari bulan lalu</span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-xl-7">
                <div class="ops-panel h-100">
                    <div class="ops-panel-header">
                        <div class="ops-panel-title">
                            <span class="ops-icon dash-soft-success"><i class="ti ti-chart-bar"></i></span>
                            <div>
                                <h5>Tren Pengeluaran</h5>
                                <p>Total pengeluaran operasional 6 bulan terakhir</p>
                            </div>
                        </div>
                        <span class="btn btn-outline-warning btn-sm pe-none">6 Bulan Terakhir</span>
                    </div>
                    <div id="expenseTrendChart" class="ops-chart"></div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="ops-panel h-100">
                    <div class="ops-panel-header">
                        <div class="ops-panel-title">
                            <span class="ops-icon dash-soft-primary"><i class="ti ti-chart-pie"></i></span>
                            <div>
                                <h5>Komposisi Pengeluaran</h5>
                                <p>Distribusi pengeluaran berdasarkan kategori</p>
                            </div>
                        </div>
                        <span class="btn btn-outline-secondary btn-sm pe-none">Semua Data</span>
                    </div>
                    <div class="composition-wrap">
                        <div id="expenseCompositionChart" class="ops-chart"></div>
                        <div class="composition-list">
                            <?php
                            $compositionColors = ['#009883', '#19c2a7', '#77ddcf', '#aeb7c2'];
                            $compositionTotal = (float) ($composition['total'] ?? 0);
                            foreach (($composition['labels'] ?? []) as $index => $label):
                                $amount = (float) ($composition['series'][$index] ?? 0);
                                $percent = $compositionTotal > 0 ? round(($amount / $compositionTotal) * 100) : 0;
                            ?>
                            <div class="composition-item">
                                <span class="composition-dot"
                                    style="background: <?= $compositionColors[$index] ?? '#94a3b8'; ?>"></span>
                                <span><?= html_escape($label); ?></span>
                                <span
                                    class="composition-amount"><?= html_escape(dashboard_compact_rupiah($amount)); ?></span>
                                <span class="composition-percent"><?= (int) $percent; ?>%</span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xl-6">
                <div class="ops-panel h-100">
                    <div class="ops-panel-header">
                        <div class="ops-panel-title">
                            <span class="ops-icon dash-soft-success"><i class="ti ti-coins"></i></span>
                            <div>
                                <h5>Budget Project & Retail</h5>
                        <p>Realisasi pengeluaran dibandingkan budget</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table ops-table">
                            <thead>
                                <tr>
                                    <th>Nama Project/Retail</th>
                                    <th>Total Budget</th>
                                    <th>Realisasi</th>
                                    <th>Persentase</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($budgetRows)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data budget.</td>
                                </tr>
                                <?php endif; ?>
                                <?php foreach ($budgetRows as $row): ?>
                                <?php $isWarn = strtolower($row['status']) === 'waspada'; ?>
                                <tr>
                                    <td><?= html_escape($row['name']); ?></td>
                                    <td><?= html_escape($row['budget_label']); ?></td>
                                    <td><?= html_escape($row['realization_label']); ?></td>
                                    <td>
                                        <span class="me-2"><?= (int) $row['percentage']; ?>%</span>
                                        <span class="progress-mini <?= $isWarn ? 'warn' : ''; ?>">
                                            <span style="width: <?= (int) $row['percentage']; ?>%;"></span>
                                        </span>
                                    </td>
                                    <td><span
                                            class="ops-pill ops-pill-<?= $isWarn ? 'warning' : 'success'; ?>"><?= html_escape($row['status']); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="ops-panel h-100">
                    <div class="ops-panel-header">
                        <div class="ops-panel-title">
                            <span class="ops-icon dash-soft-primary"><i class="ti ti-file-invoice"></i></span>
                            <div>
                                <h5>Transaksi Terbaru</h5>
                                <p>Daftar 10 transaksi operasional terakhir</p>
                            </div>
                        </div>
                        <a href="<?= base_url('Report'); ?>" class="btn btn-outline-primary btn-sm">Lihat Semua <i
                                class="ti ti-arrow-right ms-1"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="table ops-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($transactions)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada transaksi.</td>
                                </tr>
                                <?php endif; ?>
                                <?php foreach ($transactions as $trx): ?>
                                <?php
                                $catClass = 'cat-' . strtolower(str_replace([' ', '&'], ['-', ''], $trx['category']));
                                if (!in_array($catClass, ['cat-dokter-project', 'cat-dokter-retail', 'cat-top-up', 'cat-makan', 'cat-transport', 'cat-penginapan'], true)) {
                                    $catClass = 'cat-default';
                                }
                                $statusClass = dashboard_status_class($trx['status']);
                                ?>
                                <tr>
                                    <td><?= html_escape(dashboard_date($trx['date'])); ?></td>
                                    <td><?= html_escape($trx['description']); ?></td>
                                    <td><span
                                            class="ops-pill <?= $catClass; ?>"><?= html_escape($trx['category']); ?></span>
                                    </td>
                                    <td><?= html_escape($trx['amount_label']); ?></td>
                                    <td><span
                                            class="ops-pill ops-pill-<?= $statusClass; ?>"><?= html_escape($trx['status']); ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var trendLabels = <?= json_encode($trend['labels'] ?? []); ?>;
        var trendSeries = <?= json_encode(array_map('floatval', $trend['series'] ?? [])); ?>;
        var compositionLabels = <?= json_encode($composition['labels'] ?? []); ?>;
        var compositionSeries = <?= json_encode(array_map('floatval', $composition['series'] ?? [])); ?>;
        var totalExpense = <?= json_encode((float) ($composition['total'] ?? 0)); ?>;

        function rupiahCompact(value) {
            value = Number(value || 0);
            if (Math.abs(value) >= 1000000000) {
                return 'Rp ' + (value / 1000000000).toFixed(1).replace('.', ',') + ' M';
            }
            if (Math.abs(value) >= 1000000) {
                return 'Rp ' + (value / 1000000).toFixed(1).replace('.', ',') + ' jt';
            }
            if (Math.abs(value) >= 1000) {
                return 'Rp ' + (value / 1000).toFixed(1).replace('.', ',') + ' rb';
            }
            return 'Rp ' + value.toLocaleString('id-ID');
        }

        if (typeof ApexCharts !== 'undefined' && document.querySelector('#expenseTrendChart')) {
            var trendEl = document.querySelector('#expenseTrendChart');
            trendEl.innerHTML = '';
            if (window.opsTrendChart) {
                window.opsTrendChart.destroy();
            }
            window.opsTrendChart = new ApexCharts(trendEl, {
                chart: {
                    type: 'bar',
                    height: 300,
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                series: [{
                    name: 'Pengeluaran',
                    data: trendSeries
                }],
                colors: ['#12b99f'],
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '52%'
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(value) {
                        return Number(value || 0) > 0 ? rupiahCompact(value) : '';
                    },
                    offsetY: -18,
                    style: {
                        colors: ['#0f172a'],
                        fontWeight: 800
                    }
                },
                grid: {
                    borderColor: '#e5e7eb'
                },
                xaxis: {
                    categories: trendLabels,
                    labels: {
                        style: {
                            colors: '#64748b'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: rupiahCompact,
                        style: {
                            colors: '#64748b'
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: rupiahCompact
                    }
                }
            });
            window.opsTrendChart.render();
        }

        if (typeof ApexCharts !== 'undefined' && document.querySelector('#expenseCompositionChart')) {
            var compositionEl = document.querySelector('#expenseCompositionChart');
            compositionEl.innerHTML = '';
            if (window.opsCompositionChart) {
                window.opsCompositionChart.destroy();
            }
            window.opsCompositionChart = new ApexCharts(compositionEl, {
                chart: {
                    type: 'donut',
                    height: 290,
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'inherit'
                },
                labels: compositionLabels,
                series: compositionSeries,
                colors: ['#009883', '#19c2a7', '#77ddcf', '#aeb7c2'],
                stroke: {
                    width: 2,
                    colors: ['#fff']
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(value) {
                        return Math.round(value) + '%';
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '62%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Pengeluaran',
                                    formatter: function() {
                                        return rupiahCompact(totalExpense);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: rupiahCompact
                    }
                }
            });
            window.opsCompositionChart.render();
        }
    });
    </script>
</div>
