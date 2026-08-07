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
        <label class="form-label" for="<?= $form_mode; ?>_tanggal">Tanggal <span class="text-danger">*</span></label>
        <input type="text" class="form-control js-tanggal" id="<?= $form_mode; ?>_tanggal" name="tanggal" autocomplete="off" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_kebutuhan">Kebutuhan</label>
    <input type="text" class="form-control" id="<?= $form_mode; ?>_kebutuhan" name="kebutuhan">
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_nominal_display">Nominal</label>
    <input type="text" class="form-control js-nominal-display" id="<?= $form_mode; ?>_nominal_display" placeholder="0">
    <input type="hidden" class="js-nominal" name="nominal" value="">
</div>
<div class="mb-3 <?= $form_mode === 'edit' ? '' : 'd-none'; ?> js-current-lampiran-wrap">
    <a href="javascript:void(0);" class="link-primary js-current-lampiran" target="_blank"><i class="ti ti-paperclip me-1"></i>Lihat bukti/struk saat ini</a>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_lampiran">Upload Bukti/Struk</label>
    <input type="file" class="form-control" id="<?= $form_mode; ?>_lampiran" name="lampiran" accept=".jpg,.jpeg,.png">
    <small class="text-muted"><?= $form_mode === 'edit' ? 'Kosongkan jika tidak ingin mengganti bukti/struk. ' : ''; ?>Format JPG, JPEG, PNG. Maks 5MB.</small>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_keterangan">Keterangan</label>
    <textarea class="form-control" id="<?= $form_mode; ?>_keterangan" name="keterangan" rows="3"></textarea>
</div>
