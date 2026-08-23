<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_project">Project <span class="text-danger">*</span></label>
    <select class="form-select" id="<?= $form_mode; ?>_project" name="project" required>
        <option value="">-- Pilih Project --</option>
        <?php foreach ($projects as $project): ?>
        <option value="<?= html_escape($project['kode_project']); ?>">
            <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="row g-2">
    <div class="col-md-6 mb-3">
        <?php include APPPATH . 'views/operasional/_proses_field.php'; ?>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_tgl_transport">Tanggal Transport <span
                class="text-danger">*</span></label>
        <input type="text" class="form-control js-tgl-transport" id="<?= $form_mode; ?>_tgl_transport"
            name="tgl_transport" autocomplete="off" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_jenis_pengeluaran">Jenis Pengeluaran <span
            class="text-danger">*</span></label>
    <select class="form-select js-jenis-pengeluaran" id="<?= $form_mode; ?>_jenis_pengeluaran" name="jenis_pengeluaran"
        required>
        <option value="">-- Pilih Jenis Pengeluaran --</option>
        <?php foreach ($jenis_pengeluaran_options as $option): ?>
        <option value="<?= html_escape($option); ?>"><?= html_escape($option); ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_nominal">Nominal <span class="text-danger">*</span></label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="text" class="form-control format-number" id="<?= $form_mode; ?>_nominal" name="nominal"
            inputmode="numeric" autocomplete="off" required>
    </div>
</div>
<div class="row g-2 js-mobil-fields d-none">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_transport">Transport <span
                class="text-danger">*</span></label>
        <select class="form-select js-mobil-required" id="<?= $form_mode; ?>_transport" name="transport">
            <option value="">-- Pilih Transport --</option>
            <?php foreach ($transport_options as $option): ?>
            <option value="<?= html_escape($option); ?>"><?= html_escape($option); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_jenis">Jenis <span class="text-danger">*</span></label>
        <select class="form-select js-mobil-required" id="<?= $form_mode; ?>_jenis" name="jenis">
            <option value="">-- Pilih Jenis --</option>
            <?php foreach ($jenis_options as $option): ?>
            <option value="<?= html_escape($option); ?>"><?= html_escape($option); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div class="mb-3 js-mobil-fields d-none">
    <label class="form-label" for="<?= $form_mode; ?>_tipe">Merk Kendaraan <span class="text-danger">*</span></label>
    <input type="text" class="form-control js-mobil-required" id="<?= $form_mode; ?>_tipe" name="tipe">
</div>
<div class="js-sewa-fields d-none">
    <div class="mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_nama_pemilik">Nama Pemilik <span
                class="text-danger">*</span></label>
        <input type="text" class="form-control js-sewa-required" id="<?= $form_mode; ?>_nama_pemilik"
            name="nama_pemilik">
    </div>
    <div class="mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_nopol_kendaraan">Nomer Polisi Kendaraan <span
                class="text-danger">*</span></label>
        <input type="text" class="form-control js-sewa-required" id="<?= $form_mode; ?>_nopol_kendaraan"
            name="nopol_kendaraan">
    </div>
    <div class="mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_ktp_pemilik">Nomer KTP <span
                class="text-danger">*</span></label>
        <input type="text" class="form-control js-sewa-required" id="<?= $form_mode; ?>_ktp_pemilik" name="ktp_pemilik">
    </div>
    <div class="mb-3 <?= $form_mode === 'edit' ? '' : 'd-none'; ?> js-current-stnk-wrap">
        <a href="javascript:void(0);" class="link-primary js-current-stnk" target="_blank"><i
                class="ti ti-paperclip me-1"></i>Lihat STNK saat ini</a>
    </div>
    <div class="mb-3">
        <label class="form-label" for="<?= $form_mode; ?>_stnk">Upload STNK</label>
        <input type="file" class="form-control" id="<?= $form_mode; ?>_stnk" name="stnk" accept="image/jpeg,image/png">
        <small class="text-muted"><?= $form_mode === 'edit' ? 'Kosongkan jika tidak ingin mengganti STNK. ' : ''; ?>Maks
            upload 5MB, disimpan maksimal 100KB.</small>
    </div>
</div>
<div class="mb-3 <?= $form_mode === 'edit' ? '' : 'd-none'; ?> js-current-lampiran-wrap">
    <a href="javascript:void(0);" class="link-primary js-current-lampiran" target="_blank"><i
            class="ti ti-paperclip me-1"></i>Lihat bukti/struk saat ini</a>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_lampiran">Upload Bukti/Struk</label>
    <input type="file" class="form-control" id="<?= $form_mode; ?>_lampiran" name="lampiran"
        accept="image/jpeg,image/png">
    <small
        class="text-muted"><?= $form_mode === 'edit' ? 'Kosongkan jika tidak ingin mengganti bukti/struk. ' : ''; ?>Maks
        upload 5MB, disimpan maksimal 100KB.</small>
</div>
<div class="mb-3">
    <label class="form-label" for="<?= $form_mode; ?>_keterangan">Keterangan</label>
    <textarea class="form-control" id="<?= $form_mode; ?>_keterangan" name="keterangan" rows="3"></textarea>
</div>
