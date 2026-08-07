<?php
$proses_labels = [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$transport_options = ['Mobil Operasional', 'Mobil Pribadi', 'Taxi Online', 'Sewa'];
$jenis_options = ['Bis', 'Mobil Penumpang', 'Mobil Barang', 'Motor'];
?>
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
                    <li class="breadcrumb-item"><a href="<?= base_url('Transport'); ?>"><?= html_escape($subheader); ?></a></li>
                    <li class="breadcrumb-item active">Edit <?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= html_escape($subheader); ?></h4>
                <a href="<?= base_url('Transport'); ?>" class="btn btn-custom">
                    <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body">
                <form id="form-edit-transport" action="<?= base_url('Transport/update'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_transport" value="<?= html_escape($edit_data['id_transport']); ?>">

                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2 text-lg-end">Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project" name="project" required>
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($projects as $project): ?>
                                <option value="<?= html_escape($project['kode_project']); ?>" <?= set_select('project', $project['kode_project'], ($edit_data['project'] ?? '') == $project['kode_project']); ?>>
                                    <?= html_escape($project['kode_project'] . ' - ' . $project['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="proses" class="col-form-label col-lg-2 text-lg-end">Proses <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('proses') ? 'is-invalid' : ''; ?>" id="proses" name="proses" required>
                                <option value="">-- Pilih Proses --</option>
                                <?php foreach ($proses_labels as $value => $label): ?>
                                <option value="<?= html_escape($value); ?>" <?= set_select('proses', $value, (string) ($edit_data['proses'] ?? '') === (string) $value); ?>><?= html_escape($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('proses'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_transport" class="col-form-label col-lg-2 text-lg-end">Tanggal Transport <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tgl_transport') ? 'is-invalid' : ''; ?>" id="tgl_transport" name="tgl_transport" value="<?= set_value('tgl_transport', $edit_data['tgl_transport']); ?>" autocomplete="off" required>
                            <div class="invalid-feedback"><?= form_error('tgl_transport'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="transport" class="col-form-label col-lg-2 text-lg-end">Transport <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('transport') ? 'is-invalid' : ''; ?>" id="transport" name="transport" required>
                                <option value="">-- Pilih Transport --</option>
                                <?php foreach ($transport_options as $option): ?>
                                <option value="<?= html_escape($option); ?>" <?= set_select('transport', $option, ($edit_data['transport'] ?? '') === $option); ?>><?= html_escape($option); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('transport'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis" class="col-form-label col-lg-2 text-lg-end">Jenis <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('jenis') ? 'is-invalid' : ''; ?>" id="jenis" name="jenis" required>
                                <option value="">-- Pilih Jenis --</option>
                                <?php foreach ($jenis_options as $option): ?>
                                <option value="<?= html_escape($option); ?>" <?= set_select('jenis', $option, ($edit_data['jenis'] ?? '') === $option); ?>><?= html_escape($option); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('jenis'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tipe" class="col-form-label col-lg-2 text-lg-end">Merk Kendaraan <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control <?= form_error('tipe') ? 'is-invalid' : ''; ?>" id="tipe" name="tipe" value="<?= set_value('tipe', $edit_data['tipe']); ?>" required>
                            <div class="invalid-feedback"><?= form_error('tipe'); ?></div>
                        </div>
                    </div>

                    <div class="js-sewa-fields d-none">
                        <div class="row mb-3">
                            <label for="nama_pemilik" class="col-form-label col-lg-2 text-lg-end">Nama Pemilik <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control js-sewa-required <?= form_error('nama_pemilik') ? 'is-invalid' : ''; ?>" id="nama_pemilik" name="nama_pemilik" value="<?= set_value('nama_pemilik', $edit_data['nama_pemilik'] ?? ''); ?>">
                                <div class="invalid-feedback"><?= form_error('nama_pemilik'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nopol_kendaraan" class="col-form-label col-lg-2 text-lg-end">Nomer Polisi Kendaraan <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control js-sewa-required <?= form_error('nopol_kendaraan') ? 'is-invalid' : ''; ?>" id="nopol_kendaraan" name="nopol_kendaraan" value="<?= set_value('nopol_kendaraan', $edit_data['nopol_kendaraan'] ?? ''); ?>">
                                <div class="invalid-feedback"><?= form_error('nopol_kendaraan'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ktp_pemilik" class="col-form-label col-lg-2 text-lg-end">Nomer KTP <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control js-sewa-required <?= form_error('ktp_pemilik') ? 'is-invalid' : ''; ?>" id="ktp_pemilik" name="ktp_pemilik" value="<?= set_value('ktp_pemilik', $edit_data['ktp_pemilik'] ?? ''); ?>">
                                <div class="invalid-feedback"><?= form_error('ktp_pemilik'); ?></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="stnk" class="col-form-label col-lg-2 text-lg-end">Upload STNK</label>
                            <div class="col-lg-10">
                                <?php if (!empty($edit_data['stnk'])): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/transport/' . rawurlencode($edit_data['stnk'])); ?>" target="_blank" class="link-primary">
                                        <i class="ti ti-paperclip me-1"></i>Lihat STNK saat ini
                                    </a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="stnk" name="stnk" accept="image/jpeg,image/png">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti STNK. Maks upload 5MB, disimpan maksimal 100KB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-form-label col-lg-2 text-lg-end">Upload Bukti/Struk</label>
                        <div class="col-lg-10">
                            <?php if (!empty($edit_data['lampiran'])): ?>
                            <div class="mb-2">
                                <a href="<?= base_url('uploads/transport/' . rawurlencode($edit_data['lampiran'])); ?>" target="_blank" class="link-primary">
                                    <i class="ti ti-paperclip me-1"></i>Lihat bukti/struk saat ini
                                </a>
                            </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="lampiran" name="lampiran" accept="image/jpeg,image/png">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti bukti/struk. Maks upload 5MB, disimpan maksimal 100KB.</small>
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
                <a href="<?= base_url('Transport'); ?>">Cancel</a>
                <button type="submit" form="form-edit-transport" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof flatpickr !== 'undefined') {
        flatpickr('#tgl_transport', {dateFormat: 'Y-m-d', allowInput: true});
    }

    function toggleSewaFields() {
        var isSewa = $('#transport').val() === 'Sewa';
        $('.js-sewa-fields').toggleClass('d-none', !isSewa);
        $('.js-sewa-required').prop('required', isSewa);
        if (!isSewa) {
            $('.js-sewa-required').not('[type="file"]').val('');
            $('#stnk').val('');
        }
    }

    $('#transport').on('change', toggleSewaFields);
    toggleSewaFields();
});
</script>
