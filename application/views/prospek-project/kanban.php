<?php
$format_currency = function ($value) {
    return 'Rp ' . number_format((float) ($value ?? 0), 0, ',', '.');
};

$display_value = function ($value) {
    $value = trim((string) ($value ?? ''));
    return $value !== '' ? $value : '-';
};

$statuses = $kanban_statuses ?? [];
$summary = $kanban_summary ?? [];
$months = $bulan_names ?? [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];

$leads_by_status = [];
foreach ($statuses as $status) {
    $leads_by_status[$status['key']] = [];
}

foreach (($kanban_leads ?? []) as $lead) {
    $status_key = $lead['status_lead'] ?? 'Proses Prospek';

    if (!isset($leads_by_status[$status_key])) {
        continue;
    }

    $leads_by_status[$status_key][] = $lead;
}

$period_text = function ($lead) use ($months) {
    $month = (int) ($lead['periode_bulan'] ?? 0);
    $year = trim((string) ($lead['periode_tahun'] ?? ''));

    if ($month < 1 || $month > 12 || $year === '') {
        return '-';
    }

    return ($months[$month] ?? $month) . ' ' . $year;
};
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
            <h4 class="mb-1"><?= $header; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="">Marketing Project</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $subheader; ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group" role="group" aria-label="Prospek Project Navigation">
                        <a href="<?= base_url('ProspekProject'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'overview') ? 'active' : ''; ?>">
                            Overview
                        </a>
                        <a href="<?= base_url('ProspekProject/DataProspek'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'data') ? 'active' : ''; ?>">
                            Data Prospek
                        </a>
                        <a href="<?= base_url('ProspekProject/Kanban'); ?>"
                            class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'kanban') ? 'active' : ''; ?>">
                            Kanban
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="input-icon input-icon-start position-relative prospek-kanban-search">
                <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                <input type="text" class="form-control" id="prospekProjectKanbanSearch"
                    placeholder="Search nama perusahaan / PIC" autocomplete="off">
            </div>
        </div>

        <div class="prospek-kanban-board" id="prospekProjectKanbanBoard">
            <?php foreach ($statuses as $status): ?>
            <?php
            $status_key = $status['key'];
            $status_summary = $summary[$status_key] ?? ['total' => 0, 'estimasi_total' => 0];
            $status_leads = $leads_by_status[$status_key] ?? [];
            ?>
            <div class="kanban-list-items prospek-kanban-column p-2 rounded border"
                data-kanban-column="<?= html_escape($status_key); ?>">
                <div class="prospek-kanban-header">
                    <div>
                        <h6 class="d-flex align-items-center mb-1">
                            <i class="ti ti-circle-filled fs-10 <?= html_escape($status['text_class']); ?> me-1"></i>
                            <?= html_escape($status['label']); ?>
                        </h6>
                        <span class="fw-medium">
                            <?= (int) $status_summary['total']; ?> Leads -
                            <?= $format_currency($status_summary['estimasi_total']); ?>
                        </span>
                    </div>
                </div>

                <div class="kanban-drag-wrap prospek-kanban-cards">
                    <?php foreach ($status_leads as $lead): ?>
                    <?php
                    $company_name = $display_value($lead['nama_client'] ?? null);
                    $pic_name = $display_value($lead['nama_pic'] ?? null);
                    $search_text = strtolower($company_name . ' ' . $pic_name);
                    ?>
                    <div class="card kanban-card prospek-kanban-card border shadow-sm"
                        data-search="<?= html_escape($search_text); ?>">
                        <div class="card-body">
                            <div class="prospek-kanban-topbar mb-3 <?= html_escape($status['bar_class']); ?>"></div>
                            <h6 class="fw-medium fs-14 mb-3">
                                <a href="<?= base_url('ProspekProject/View/' . $lead['id_leads']); ?>">
                                    <?= html_escape($company_name); ?>
                                </a>
                            </h6>

                            <div class="d-flex flex-column">
                                <p class="lead-field text-default d-inline-flex align-items-start mb-2">
                                    <i class="ti ti-user text-dark me-1"></i>
                                    <span><?= html_escape($pic_name); ?></span>
                                </p>
                                <p class="lead-field text-default d-inline-flex align-items-start mb-2">
                                    <i class="ti ti-clock-hour-3 text-dark me-1"></i>
                                    <span><?= html_escape($period_text($lead)); ?></span>
                                </p>
                                <p class="lead-field text-default d-inline-flex align-items-start mb-2">
                                    <i class="ti ti-report-money text-dark me-1"></i>
                                    <span><?= $format_currency($lead['estimasi_lead'] ?? 0); ?></span>
                                </p>
                                <p class="lead-field text-default d-inline-flex align-items-start mb-2">
                                    <i class="ti ti-mail text-dark me-1"></i>
                                    <span><?= html_escape($display_value($lead['email_pic'] ?? null)); ?></span>
                                </p>
                                <p class="lead-field text-default d-inline-flex align-items-start mb-2">
                                    <i class="ti ti-phone text-dark me-1"></i>
                                    <span><?= html_escape($display_value($lead['tlp_pic'] ?? null)); ?></span>
                                </p>
                                <p class="lead-field text-default d-inline-flex align-items-start mb-0">
                                    <i class="ti ti-map-pin-pin text-dark me-1"></i>
                                    <span><?= html_escape($display_value($lead['alamat_client'] ?? null)); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="prospek-kanban-empty <?= !empty($status_leads) ? 'd-none' : ''; ?>">
                        Tidak ada data prospek.
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
