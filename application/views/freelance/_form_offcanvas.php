<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_project">Project <span class="text-danger">*</span></label>
    <select class="form-select" id="<?= $form_mode; ?>_project" name="project" required>
        <option value="">-- Pilih Project --</option>
        <?php foreach ($projects as $project): ?>
        <option value="<?= html_escape($project['kode_project']); ?>"><?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <?php include APPPATH . 'views/operasional/_proses_field.php'; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_tgl_fee">Tanggal Fee <span class="text-danger">*</span></label>
        <input type="text" class="form-control js-tgl-fee" id="<?= $form_mode; ?>_tgl_fee" name="tgl_fee" autocomplete="off" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_jobdesk">Jobdesk <span class="text-danger">*</span></label>
    <select class="form-select" id="<?= $form_mode; ?>_jobdesk" name="jobdesk" required>
        <option value="">-- Pilih Jobdesk --</option>
        <?php foreach ($jobdesk_options as $jobdesk): ?>
        <option value="<?= html_escape($jobdesk); ?>"><?= html_escape($jobdesk); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_jumlah_orang">Jumlah Orang <span class="text-danger">*</span></label>
        <input type="number" class="form-control js-jumlah-orang" id="<?= $form_mode; ?>_jumlah_orang" name="jumlah_orang" step="any" min="0" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_jumlah_hari">Jumlah Hari <span class="text-danger">*</span></label>
        <input type="number" class="form-control js-jumlah-hari" id="<?= $form_mode; ?>_jumlah_hari" name="jumlah_hari" step="any" min="0" required>
    </div>
</div>
<div class="row g-2">
    <div class="col-md-4 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_fee_display">Fee <span class="text-danger">*</span></label>
        <input type="text" class="form-control js-fee-display" id="<?= $form_mode; ?>_fee_display" placeholder="0" required>
        <input type="hidden" class="js-fee" name="fee" value="">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_biaya_tambahan_display">Biaya Tambahan</label>
        <input type="text" class="form-control js-biaya-tambahan-display" id="<?= $form_mode; ?>_biaya_tambahan_display" placeholder="0">
        <input type="hidden" class="js-biaya-tambahan" name="biaya_tambahan" value="0">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_total_display">Total</label>
        <input type="text" class="form-control js-total-display" id="<?= $form_mode; ?>_total_display" placeholder="0" readonly>
        <input type="hidden" class="js-total" name="total" value="">
    </div>
</div>
<div class="mb-3 <?= $form_mode === 'edit' ? '' : 'd-none'; ?> js-current-lampiran-wrap">
    <a href="javascript:void(0);" class="link-primary js-current-lampiran" target="_blank"><i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini</a>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_lampiran">Lampiran</label>
    <input type="file" class="form-control" id="<?= $form_mode; ?>_lampiran" name="lampiran" accept="image/jpeg,image/png">
    <small class="text-muted"><?= $form_mode === 'edit' ? 'Kosongkan jika tidak ingin mengganti lampiran. ' : ''; ?>Format JPG/PNG. File dikompres otomatis maksimal 100KB.</small>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_keterangan">Keterangan</label>
    <textarea class="form-control" id="<?= $form_mode; ?>_keterangan" name="keterangan" rows="3"></textarea>
</div>
