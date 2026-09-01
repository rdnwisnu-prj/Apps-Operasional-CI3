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
$isPreviewMode = !empty($preview_mode);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <?php if ($isPreviewMode): ?>
    <title>Preview Laporan Operasional</title>
    <?php endif; ?>
    <style>
    @page {
        margin: 26px 34px 28px;
    }

    body {
        font-family: Helvetica, Arial, sans-serif;
        color: #111;
        font-size: 12px;
    }

    <?php if ($isPreviewMode): ?>
    body {
        background: #eef1f5;
        margin: 0;
        padding: 86px 24px 32px;
    }

    .preview-toolbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 10;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 14px 24px;
        background: #111827;
        color: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .22);
    }

    .preview-title {
        font-size: 14px;
        font-weight: 700;
    }

    .preview-subtitle {
        margin-top: 2px;
        font-size: 12px;
        color: #cbd5e1;
    }

    .preview-download {
        border: 0;
        border-radius: 4px;
        padding: 10px 15px;
        background: #ef1e1e;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .preview-page {
        max-width: 794px;
        min-height: 1123px;
        margin: 0 auto;
        padding: 34px;
        background: #fff;
        box-shadow: 0 20px 45px rgba(15, 23, 42, .18);
        box-sizing: border-box;
    }

    @media print {
        body {
            background: #fff;
            padding: 0;
        }

        .preview-toolbar {
            display: none;
        }

        .preview-page {
            max-width: none;
            min-height: 0;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }
    }
    <?php endif; ?>

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
        font-size: 12.5px;
        page-break-inside: avoid;
    }

    .report-table th,
    .report-table td {
        border: .8px solid #111;
        padding: 4px 8px;
        vertical-align: middle;
        line-height: 1.25;
    }

    .report-table th {
        text-align: center;
        font-weight: 700;
    }

    .no-col {
        width: 22px;
        min-width: 22px;
        max-width: 22px;
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
        width: 220px;
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
        margin-top: 24px;
        font-size: 12px;
        table-layout: fixed;
        page-break-inside: avoid;
    }

    .signature-table td {
        width: 50%;
        padding: 2px 36px 0;
        vertical-align: top;
    }

    .signature-space {
        display: block;
        height: 74px;
        line-height: 74px;
        font-size: 1px;
        color: #fff;
    }

    .signature-name {
        font-style: italic;
    }

    .text-center {
        text-align: center;
    }

    .row-space td {
        padding-top: 22px;
    }

    .attachment-section {
        page-break-before: always;
        margin-top: 18px;
    }

    .preview-page .attachment-section {
        page-break-before: auto;
        border-top: 1px solid #e5e7eb;
        padding-top: 18px;
    }

    .attachment-title {
        margin: 20px 0 12px;
        text-align: center;
        font-size: 15px;
        font-weight: 700;
    }

    .attachment-process {
        margin: 14px 0 8px;
        padding: 7px 9px;
        border: .8px solid #111;
        font-size: 12px;
        font-weight: 700;
        background: #f2f2f2;
    }

    .attachment-category {
        margin: 10px 0 6px;
        font-size: 12px;
        font-weight: 700;
    }

    .attachment-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        margin: 0 0 14px;
        font-size: 10.8px;
    }

    .attachment-table th,
    .attachment-table td {
        border: .8px solid #111;
        padding: 6px 7px;
        vertical-align: top;
        line-height: 1.35;
    }

    .attachment-table th {
        text-align: center;
        font-weight: 700;
        background: #f2f2f2;
    }

    .attachment-table tr {
        page-break-inside: avoid;
    }

    .attachment-no {
        width: 26px;
        text-align: center;
    }

    .attachment-proof {
        width: 160px;
        text-align: center;
    }

    .attachment-amount {
        width: 118px;
        text-align: right;
    }

    .attachment-img {
        max-width: 145px;
        max-height: 100px;
    }

    .attachment-file {
        display: block;
        min-height: 78px;
        padding: 14px 8px;
        border: .8px dashed #777;
        color: #555;
        font-size: 10px;
        line-height: 1.35;
        text-align: center;
    }

    .attachment-name {
        font-weight: 700;
    }

    .attachment-muted {
        color: #444;
    }
    </style>
</head>

<body>
    <?php if ($isPreviewMode): ?>
    <div class="preview-toolbar">
        <div>
            <div class="preview-title">Preview Laporan Operasional</div>
            <div class="preview-subtitle"><?= html_escape(($project['kode_project'] ?? '-') . ' - ' . $periodLabel); ?></div>
        </div>
        <form action="<?= base_url('Report/exportActivity'); ?>" method="post">
            <input type="hidden" name="kode_project" value="<?= html_escape($project['kode_project'] ?? ''); ?>">
            <input type="hidden" name="tgl_awal" value="<?= html_escape($date_start); ?>">
            <input type="hidden" name="tgl_akhir" value="<?= html_escape($date_end); ?>">
            <?php foreach (($proses_list ?? []) as $process): ?>
            <input type="hidden" name="proses[]" value="<?= html_escape($process); ?>">
            <?php endforeach; ?>
            <button type="submit" class="preview-download">Download PDF</button>
        </form>
    </div>
    <div class="preview-page">
    <?php endif; ?>

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
            <col width="22" style="width: 22px;">
            <col>
            <col width="220" style="width: 220px;">
        </colgroup>
        <thead>
            <tr>
                <th class="no-col" width="22">No</th>
                <th class="desc-col">Keterangan</th>
                <th class="amount-col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $index => $row): ?>
            <tr>
                <td class="no-col" width="22"><?= $index + 1; ?></td>
                <td><?= html_escape($row['label']); ?></td>
                <td class="amount-col"><?= report_activity_money($row['total']); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="no-col" width="22"></td>
                <td class="summary-label">Pemasukan (Saldo Utama)</td>
                <td class="amount-col"><?= report_activity_money($income_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="22"></td>
                <td class="summary-label">Pengeluaran</td>
                <td class="amount-col"><?= report_activity_money($expense_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="22"></td>
                <td class="summary-label">Sisa Saldo</td>
                <td class="amount-col"><?= report_activity_money($saldo_total); ?></td>
            </tr>
            <tr>
                <td class="no-col" width="22"></td>
                <td class="summary-label">Top Up Saldo</td>
                <td class="amount-col"><?= report_activity_money($topup_total); ?></td>
            </tr>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td>
                <div>Dibuat oleh</div>
                <div class="signature-space">&nbsp;</div>
                <div class="signature-name">(<?= html_escape($korlapName); ?>)</div>
            </td>
            <td>
                <div>Diverifikasi oleh</div>
                <div class="signature-space">&nbsp;</div>
                <div class="signature-name">(<?= html_escape($verifiedByName); ?>)</div>
            </td>
        </tr>
        <tr class="row-space">
            <td>
                <div>Divalidasi oleh</div>
                <div class="signature-space">&nbsp;</div>
                <div class="signature-name">(<?= html_escape($validatedByName); ?>)</div>
            </td>
            <td>
                <div>Disetujui oleh</div>
                <div class="signature-space">&nbsp;</div>
                <div class="signature-name">(<?= html_escape($approvedByName); ?>)</div>
            </td>
        </tr>
    </table>

    <?php if (!empty($attachment_sections)): ?>
    <div class="attachment-section">
        <?php if (!$isPreviewMode): ?>
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
        <?php endif; ?>

        <div class="attachment-title">LAMPIRAN BUKTI OPERASIONAL</div>
        <?php foreach ($attachment_sections as $processSection): ?>
        <div class="attachment-process"><?= html_escape($processSection['label'] ?? '-'); ?></div>
            <?php foreach (($processSection['categories'] ?? []) as $category): ?>
            <div class="attachment-category"><?= html_escape($category['label'] ?? '-'); ?></div>
            <table class="attachment-table">
                <colgroup>
                    <col style="width: 26px;">
                    <col style="width: 160px;">
                    <col>
                    <col style="width: 118px;">
                </colgroup>
                <thead>
                    <tr>
                        <th class="attachment-no">No</th>
                        <th class="attachment-proof">Bukti</th>
                        <th>Informasi Lampiran</th>
                        <th class="attachment-amount">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($category['items'] ?? []) as $itemIndex => $item): ?>
                    <tr>
                        <td class="attachment-no"><?= $itemIndex + 1; ?></td>
                        <td class="attachment-proof">
                            <?php if (!empty($item['image_base64'])): ?>
                            <img src="<?= $item['image_base64']; ?>" class="attachment-img" alt="<?= html_escape($item['filename'] ?? 'Lampiran'); ?>">
                            <?php else: ?>
                            <span class="attachment-file"><?= html_escape($item['filename'] ?? 'Lampiran'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="attachment-name"><?= html_escape(($item['label'] ?? 'Lampiran') . ' - ' . ($item['title'] ?? '-')); ?></div>
                            <div class="attachment-muted">Tanggal:
                                <?= html_escape(report_activity_date($item['date_start'] ?? '')); ?>
                                <?php if (!empty($item['date_end']) && $item['date_end'] !== ($item['date_start'] ?? '')): ?>
                                - <?= html_escape(report_activity_date($item['date_end'])); ?>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['meta'])): ?>
                            <div class="attachment-muted">Detail: <?= html_escape($item['meta']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($item['keterangan'])): ?>
                            <div class="attachment-muted">Keterangan: <?= html_escape($item['keterangan']); ?></div>
                            <?php endif; ?>
                            <?php if ($isPreviewMode && !empty($item['url'])): ?>
                            <div class="attachment-muted">File: <a href="<?= html_escape($item['url']); ?>" target="_blank"><?= html_escape($item['filename'] ?? 'Lihat file'); ?></a></div>
                            <?php endif; ?>
                        </td>
                        <td class="attachment-amount"><?= html_escape(report_activity_money($item['amount'] ?? 0)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($isPreviewMode): ?>
    </div>
    <?php endif; ?>
</body>

</html>
