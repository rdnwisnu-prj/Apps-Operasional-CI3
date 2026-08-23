<?php
if (!function_exists('report_activity_money')) {
    function report_activity_money($value)
    {
        return $value > 0 ? 'Rp ' . number_format((float) $value, 0, ',', '.') : '';
    }
}

if (!function_exists('report_activity_date')) {
    function report_activity_date($date)
    {
        return !empty($date) ? tanggal_indonesia_medium($date) : '-';
    }
}

$companyName = $project['nama_perusahaan'] ?? '-';
$siteName = $project['nama_site'] ?? ($project['nama_project'] ?? '-');
$periodLabel = report_activity_date($date_start) . ' - ' . report_activity_date($date_end);
$processLabel = $process_label ?? '-';
$korlapName = !empty($korlap_name) ? $korlap_name : 'Nama Korlap';
$verifiedByName = !empty($verified_by_name) ? $verified_by_name : 'Nama Admin Ops';
$validatedByName = !empty($validated_by_name) ? $validated_by_name : 'Nama Spv Medis';
$approvedByName = !empty($approved_by_name) ? $approved_by_name : 'Nama Mgr Project/GM Project';
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <style>
    @page {
        margin: 26px 34px 28px;
    }

    body {
        font-family: Helvetica, Arial, sans-serif;
        color: #111;
        font-size: 12px;
    }

    .header-table {
        width: 100%;
        margin-bottom: 18px;
    }

    .brand {
        font-size: 28px;
        font-weight: 700;
        line-height: 1.05;
    }

    .brand-subtitle {
        font-size: 12px;
        font-style: italic;
        margin-top: 2px;
    }

    .logo {
        width: 155px;
        height: auto;
    }

    .cert-box {
        border: 2px solid #222;
        width: 150px;
        height: 48px;
        text-align: center;
        font-size: 10px;
        line-height: 48px;
        font-weight: 700;
        margin-left: auto;
    }

    .title {
        text-align: center;
        font-size: 17px;
        font-weight: 700;
        margin: 12px 0 18px;
    }

    .meta-table {
        width: 70%;
        margin: 0 0 18px 0;
        font-size: 12px;
        table-layout: auto;
    }

    .meta-table td {
        padding: 2px 0;
        vertical-align: top;
    }

    .meta-label {
        width: 120px;
    }

    .meta-colon {
        width: 10px;
        text-align: left;
        font-weight: 700;
    }

    .meta-value {
        width: auto;
        font-weight: 400;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-size: 11px;
    }

    .report-table th,
    .report-table td {
        border: .8px solid #111;
        padding: 3px 7px;
        vertical-align: middle;
    }

    .report-table th {
        text-align: center;
        font-weight: 700;
    }

    .no-col {
        width: 18px;
        min-width: 18px;
        max-width: 18px;
        text-align: center;
        white-space: nowrap;
    }

    .report-table th.no-col,
    .report-table td.no-col {
        padding-left: 1px;
        padding-right: 1px;
    }

    .desc-col {
        width: auto;
    }

    .amount-col {
        width: 230px;
        text-align: right;
    }

    .summary-label {
        text-align: center;
        font-weight: 400;
    }

    .summary-strong {
        font-weight: 700;
    }

    .signature-table {
        width: 100%;
        margin-top: 20px;
        font-size: 11px;
        table-layout: fixed;
    }

    .signature-table td {
        width: 50%;
        padding: 2px 36px 0;
        vertical-align: top;
    }

    .signature-space {
        height: 56px;
    }

    .signature-name {
        font-style: italic;
    }

    .text-center {
        text-align: center;
    }

    .row-space td {
        padding-top: 36px;
    }
    </style>
</head>

<body>
    <table class="header-table">
        <tr>
            <td>
                <?php if (!empty($logo_base64)): ?>
                <img src="<?= $logo_base64; ?>" class="logo" alt="Cakra Medika">
                <?php else: ?>
                <div class="brand">Cakra Medika</div>
                <div class="brand-subtitle">Laboratorium Klinik & Kesehatan Kerja</div>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div class="title">FORM LAPORAN OPERASIONAL</div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Nama Perusahaan</td>
            <td class="meta-colon">:</td>
            <td class="meta-value"><?= html_escape($companyName); ?></td>
        </tr>
        <tr>
            <td class="meta-label">Nama Pekerjaan</td>
            <td class="meta-colon">:</td>
            <td class="meta-value"><?= html_escape($processLabel); ?></td>
        </tr>
        <tr>
            <td class="meta-label">Tanggal</td>
            <td class="meta-colon">:</td>
            <td class="meta-value"><?= html_escape($periodLabel); ?></td>
        </tr>
        <tr>
            <td class="meta-label">Site</td>
            <td class="meta-colon">:</td>
            <td class="meta-value"><?= html_escape($siteName); ?></td>
        </tr>
    </table>

    <table class="report-table">
        <colgroup>
            <col width="18" style="width: 18px;">
            <col>
            <col width="230" style="width: 230px;">
        </colgroup>
        <thead>
            <tr>
                <th class="no-col" width="18">No</th>
                <th class="desc-col">Keterangan</th>
                <th class="amount-col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $index => $row): ?>
            <tr>
                <td class="no-col" width="18"><?= $index + 1; ?></td>
                <td><?= html_escape($row['label']); ?></td>
                <td class="amount-col"><?= report_activity_money($row['total']); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="no-col" width="18"></td>
                <td class="summary-label">Pemasukan (Saldo Utama)</td>
                <td class="amount-col"><?= report_activity_money($income_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="18"></td>
                <td class="summary-label">Pengeluaran</td>
                <td class="amount-col"><?= report_activity_money($expense_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="18"></td>
                <td class="summary-label">Sisa Saldo</td>
                <td class="amount-col"><?= report_activity_money($saldo_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="18"></td>
                <td class="summary-label">Top Up Saldo</td>
                <td class="amount-col"><?= report_activity_money($topup_total); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td>
                <div>Dibuat oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">(<?= html_escape($korlapName); ?>)</div>
            </td>
            <td>
                <div>Diverifikasi oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">(<?= html_escape($verifiedByName); ?>)</div>
            </td>
        </tr>
        <tr class="row-space">
            <td>
                <div>Divalidasi oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">(<?= html_escape($validatedByName); ?>)</div>
            </td>
            <td>
                <div>Disetujui oleh</div>
                <div class="signature-space"></div>
                <div class="signature-name">(<?= html_escape($approvedByName); ?>)</div>
            </td>
        </tr>
    </table>
</body>

</html>
