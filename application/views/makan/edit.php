<div class="page-wrapper">

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= html_escape($header); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Makan'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Edit <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Makan'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-edit-makan" action="<?= base_url('Makan/update'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_makan" value="<?= html_escape($edit_data['id_makan']); ?>">

                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2 text-lg-end">Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project" name="project">
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>" <?= set_select('project', $project['kode_project'], $edit_data['project'] == $project['kode_project']); ?>>
                                    <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="proses" class="col-form-label col-lg-2 text-lg-end">Proses</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" id="proses" name="proses" value="<?= set_value('proses', $edit_data['proses']); ?>" step="any">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_makan" class="col-form-label col-lg-2 text-lg-end">Tanggal Makan <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control js-flatpickr <?= form_error('tgl_makan') ? 'is-invalid' : ''; ?>" id="tgl_makan" name="tgl_makan" value="<?= set_value('tgl_makan', $edit_data['tgl_makan']); ?>" autocomplete="off">
                            <div class="invalid-feedback"><?= form_error('tgl_makan'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jumlah" class="col-form-label col-lg-2 text-lg-end">Jumlah</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control js-calc-makan" id="jumlah" name="jumlah" value="<?= set_value('jumlah', $edit_data['jumlah']); ?>" step="any">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nominal" class="col-form-label col-lg-2 text-lg-end">Nominal</label>
                        <div class="col-lg-10">
                            <?php $nominalValue = set_value('nominal', $edit_data['nominal']); ?>
                            <input type="text" class="form-control format-number js-calc-makan" id="nominal_display" value="<?= $nominalValue !== '' ? number_format((float) $nominalValue, 0, ',', '.') : ''; ?>">
                            <input type="hidden" id="nominal" name="nominal" value="<?= html_escape($nominalValue); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total" class="col-form-label col-lg-2 text-lg-end">Total <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <?php $totalValue = set_value('total', $edit_data['total']); ?>
                            <input type="text" class="form-control format-number <?= form_error('total') ? 'is-invalid' : ''; ?>" id="total_display" value="<?= $totalValue !== '' ? number_format((float) $totalValue, 0, ',', '.') : ''; ?>">
                            <input type="hidden" id="total" name="total" value="<?= html_escape($totalValue); ?>">
                            <div class="invalid-feedback"><?= form_error('total'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-form-label col-lg-2 text-lg-end">Lampiran</label>
                        <div class="col-lg-10">
                            <?php if (!empty($edit_data['lampiran'])): ?>
                            <div class="mb-2">
                                <a href="<?= base_url('uploads/makan/' . $edit_data['lampiran']); ?>" target="_blank" class="link-primary">
                                    <i class="ti ti-paperclip me-1"></i>Lihat lampiran saat ini
                                </a>
                            </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="lampiran" name="lampiran" accept=".jpg,.jpeg,.png">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti lampiran.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="keterangan" class="col-form-label col-lg-2 text-lg-end">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= set_value('keterangan', $edit_data['keterangan']); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url('Makan'); ?>">Cancel</a>
                <button type="submit" form="form-edit-makan" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#tgl_makan', {dateFormat: 'Y-m-d', altInput: true, altFormat: 'd M Y', allowInput: true});
    }

    function cleanNumber(value) {
        return parseFloat(String(value || '0').replace(/[^0-9.-]/g, '')) || 0;
    }

    function setMoney(name, value) {
        var rounded = Math.round(value || 0);
        $('#' + name).val(rounded);
        $('#' + name + '_display').val(typeof formatNumber === 'function' ? formatNumber(String(rounded)) : String(rounded));
    }

    function calculateTotal() {
        setMoney('total', cleanNumber($('#jumlah').val()) * cleanNumber($('#nominal').val()));
    }

    $(document).off('input.makanCalc change.makanCalc', '.js-calc-makan')
        .on('input.makanCalc change.makanCalc', '.js-calc-makan', calculateTotal);
});
</script>
