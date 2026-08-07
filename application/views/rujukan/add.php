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
                    <a href="<?= base_url()?>Rujukan" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('Rujukan/Store') ?>" method="post">


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama">Nama Peserta <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Input Nama Peserta" />
                            <div class="form-text text-danger">
                                <?= form_error('nama') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Instansi</label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id">
                                <option value="">Pilih Instansi</option>
                                <?php foreach ($client as $c): ?>
                                <option value="<?= $c['id_client']; ?>"><?= $c['nama_client']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manual_client" name="manual_client"
                                    value="1">
                                <label class="form-check-label" for="manual_client">
                                    Instansi/Perusahaan tidak ada dalam daftar? Centang untuk input manual
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="manual_client_fields" style="display: none;">
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="other_client">Nama Instansi
                                <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="other_client" name="other_client"
                                    placeholder="Input Nama Instansi/Perusahaan" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="dokter">Dokter Spesialis <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="dokter" name="dokter">
                                <option value="">Pilih Dokter Spesialis</option>
                                <option value="dr. Sp.PD">dr. Sp.PD</option>
                                <option value="dr. Sp.Paru">dr. Sp.Paru</option>
                                <option value="dr. Sp.Jantung">dr. Sp.Jantung</option>
                                <option value="dr. Sp.Mata">dr. Sp.Mata</option>
                                <option value="dr. Sp.THT">dr. Sp.THT</option>
                                <option value="dr. Sp.Urologi">dr. Sp.Urologi</option>
                                <option value="dr. Sp. Gizi">dr. Sp. Gizi</option>
                                <option value="dr. Sp.KFR">dr. Sp.KFR</option>
                                <option value="dr. Sp.Orthopedi">dr. Sp.Orthopedi</option>
                                <option value="dr. Sp.Bedah">dr. Sp.Bedah</option>
                                <option value="dr. Sp.Psikiatri">dr. Sp.Psikiatri</option>
                                <option value="dr. Sp.KK">dr. Sp.KK</option>
                                <option value="dr. Gigi">dr. Gigi</option>
                                <option value="dr. Umum">dr. Umum</option>
                                <option value="Radiologi">Radiologi</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('dokter') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_konsul">Tanggal Konsul</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_konsul" name="tgl_konsul"
                                    placeholder="Pilih Tanggal Konsul" />
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="harga">Harga</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="harga_display"
                                    placeholder="Input Harga" autocomplete="off" />
                                <input type="hidden" id="harga" name="harga" value="0" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="hpp">HPP</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="hpp_display"
                                    placeholder="Input HPP" autocomplete="off" />
                                <input type="hidden" id="hpp" name="hpp" value="0" />
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="lokasi">Lokasi</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                placeholder="Input Lokasi" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="pembayaran" class="col-md-2 col-form-label">Status Pembayaran <span
                                class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="pembayaran" name="pembayaran">
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum Lunas</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('pembayaran') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"
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
                // If using choices.js, need to refresh it
                if (clientSelect.choices) {
                    clientSelect.choices.setChoiceByValue('');
                }
            } else {
                manualFields.style.display = 'none';
                clientSelect.disabled = false;
                // Clear manual fields
                document.getElementById('nama_instansi_manual').value = '';
            }
        });
    });
    </script>