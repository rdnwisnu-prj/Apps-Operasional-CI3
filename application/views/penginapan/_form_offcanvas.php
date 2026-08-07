<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_project">Project <span class="text-danger">*</span></label>
    <select class="form-select js-project" id="<?= $form_mode; ?>_project" name="project" required>
        <option value="" data-start="" data-end="">-- Pilih Project --</option>
        <?php foreach ($projects as $project): ?>
        <option value="<?= html_escape($project['kode_project']); ?>" data-start="<?= html_escape($project['tgl_mulai']); ?>" data-end="<?= html_escape($project['tgl_selesai']); ?>"><?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_tgl_checkin">Tanggal Checkin <span class="text-danger">*</span></label>
        <input type="text" class="form-control js-tgl-checkin" id="<?= $form_mode; ?>_tgl_checkin" name="tgl_checkin" autocomplete="off" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_tgl_checkout">Tanggal Checkout <span class="text-danger">*</span></label>
        <input type="text" class="form-control js-tgl-checkout" id="<?= $form_mode; ?>_tgl_checkout" name="tgl_checkout" autocomplete="off" required>
    </div>
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <?php include APPPATH . 'views/operasional/_proses_field.php'; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_jumlah_hari">Jumlah Hari</label>
        <input type="number" class="form-control js-jumlah-hari" id="<?= $form_mode; ?>_jumlah_hari" name="jumlah_hari" readonly>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_nominal_display">Nominal <span class="text-danger">*</span></label>
    <input type="text" class="form-control js-nominal-display" id="<?= $form_mode; ?>_nominal_display" placeholder="0" required>
    <input type="hidden" class="js-nominal" name="nominal" value="">
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_nama_hunian">Nama Hunian <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="<?= $form_mode; ?>_nama_hunian" name="nama_hunian" required>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_tipe_hunian">Tipe Hunian <span class="text-danger">*</span></label>
    <select class="form-select" id="<?= $form_mode; ?>_tipe_hunian" name="tipe_hunian" required>
        <option value="">-- Pilih Tipe Hunian --</option>
        <?php foreach ($tipe_hunian_options as $option): ?>
        <option value="<?= html_escape($option); ?>"><?= html_escape($option); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3 <?= $form_mode === 'edit' ? '' : 'd-none'; ?> js-current-invoice-wrap">
    <a href="javascript:void(0);" class="link-primary js-current-invoice" target="_blank"><i class="ti ti-paperclip me-1"></i>Lihat invoice/bukti saat ini</a>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_invoice">Invoice/Bukti</label>
    <input type="file" class="form-control" id="<?= $form_mode; ?>_invoice" name="invoice" accept="image/jpeg,image/png">
    <small class="text-muted"><?= $form_mode === 'edit' ? 'Kosongkan jika tidak ingin mengganti invoice/bukti. ' : ''; ?>Maks upload 5MB, disimpan maksimal 100KB.</small>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_keterangan">Keterangan</label>
    <textarea class="form-control" id="<?= $form_mode; ?>_keterangan" name="keterangan" rows="3"></textarea>
</div>
