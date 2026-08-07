<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $header;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader?></a></li>
                    <li class="breadcrumb-item active">Tambah <?= $subheader?> </li>
                </ol>
            </nav>
        </div>


        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Tambah <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>Crosseling" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">

                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Pilih Client <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id">
                                <option value="">Pilih Client</option>
                                <?php foreach ($clients as $cl): ?>
                                <option value="<?= $cl['id_client']; ?>"><?= $cl['nama_client']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('client_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manual_client" name="manual_client"
                                    value="1">
                                <label class="form-check-label" for="manual_client">
                                    Client tidak ada dalam daftar? Centang untuk input manual
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="manual_client_fields" style="display: none;">
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="other_client">Nama Client Manual
                                <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="other_client" name="other_client"
                                    placeholder="Input Nama Client/Perusahaan" />
                                <div class="form-text text-danger">
                                    <?= form_error('other_client') ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_cros">Nama Crosseling <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="nama_cros" name="nama_cros">
                                <option value="">Pilih Crosseling</option>
                                <option value="Training">Training</option>
                                <option value="Project MCU">Project MCU</option>
                                <option value="Health Talk">Health Talk</option>
                                <option value="Vaksinasi">Vaksinasi</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Lab">Lab</option>
                                <option value="IHC">IHC</option>
                                <option value="HSEO">HSEO</option>
                                <option value="Dokter">Dokter</option>
                                <option value="Program">Program</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('nama_cros') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_crosseling">Tanggal Crosseling</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" id="tgl_crosseling" name="tgl_crosseling"
                                placeholder="Pilih Tanggal" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="entitas">Entitas <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="entitas" name="entitas">
                                <option value="">Pilih Entitas</option>
                                <option value="Cakra Medika">Cakra Medika</option>
                                <option value="Konsehat">Konsehat</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('entitas') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="deal_cros">Deal</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control format-number" id="deal_cros_display"
                                    placeholder="Input Nilai Deal" autocomplete="off" />
                                <input type="hidden" id="deal_cros" name="deal_cros" value="0" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="prospek_cros">Prospek</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control format-number" id="prospek_cros_display"
                                    placeholder="Input Nilai Prospek" autocomplete="off" />
                                <input type="hidden" id="prospek_cros" name="prospek_cros" value="0" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="lost_cros">Lost</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control format-number" id="lost_cros_display"
                                    placeholder="Input Nilai Lost" autocomplete="off" />
                                <input type="hidden" id="lost_cros" name="lost_cros" value="0" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="ket_cros">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="ket_cros" name="ket_cros" rows="3"
                                placeholder="Input Keterangan"></textarea>
                        </div>
                    </div>


                    <div class="text-end">
                        <button type="reset" class="btn btn-light">
                            <i class="ri-close-circle-line label-icon align-middle me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle me-2"></i> Save
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const manualCheckbox = document.getElementById('manual_client');
        const manualFields = document.getElementById('manual_client_fields');
        const clientSelect = document.getElementById('client_id');

        manualCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manualFields.style.display = 'block';
                clientSelect.disabled = true;
                clientSelect.value = '';
            } else {
                manualFields.style.display = 'none';
                clientSelect.disabled = false;
                document.getElementById('other_client').value = '';
            }
        });
    });
    </script>