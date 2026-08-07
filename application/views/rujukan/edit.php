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
                    <li class="breadcrumb-item active">Edit <?= $subheader?> </li>
                </ol>
            </nav>
        </div>




        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>Rujukan" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('Rujukan/Update/' . $rujukan_data['id_rujukan']) ?>" method="post">


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama">Nama Peserta <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Input Nama Peserta"
                                value="<?= set_value('nama', $rujukan_data['nama']); ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('nama') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Instansi</label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id"
                                <?= (!empty($rujukan_data['other_client'])) ? 'disabled' : ''; ?>>
                                <option value="">Pilih Instansi</option>
                                <?php foreach ($client as $c): ?>
                                <option value="<?= $c['id_client']; ?>"
                                    <?= ($rujukan_data['client_id'] == $c['id_client']) ? 'selected' : ''; ?>>
                                    <?= $c['nama_client']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="manual_client" name="manual_client"
                                    value="1" <?= (!empty($rujukan_data['other_client'])) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="manual_client">
                                    Instansi/Perusahaan tidak ada dalam daftar? Centang untuk input manual
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="manual_client_fields"
                        style="display: <?= (!empty($rujukan_data['other_client'])) ? 'block' : 'none'; ?>;">
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label" for="other_client">Nama Instansi
                                <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="other_client" name="other_client"
                                    placeholder="Input Nama Instansi/Perusahaan"
                                    value="<?= set_value('other_client', $rujukan_data['other_client']); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="dokter">Dokter Spesialis <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <?php $dokter_options = ['dr. Sp.PD', 'dr. Sp.Paru', 'dr. Sp.Jantung', 'dr. Sp.Mata', 'dr. Sp.THT', 'dr. Sp.Urologi', 'dr. Sp. Gizi', 'dr. Sp.KFR', 'dr. Sp.Orthopedi', 'dr. Sp.Bedah', 'dr. Sp.Psikiatri', 'dr. Sp.KK', 'dr. Gigi', 'dr. Umum', 'Radiologi']; ?>
                            <select class="form-control" id="dokter" name="dokter">
                                <option value="">Pilih Dokter Spesialis</option>
                                <?php foreach ($dokter_options as $option): ?>
                                <option value="<?= $option; ?>"
                                    <?= (set_value('dokter', $rujukan_data['dokter']) == $option) ? 'selected' : ''; ?>>
                                    <?= $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('dokter') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_konsul">Tanggal Konsul</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tgl_konsul" name="tgl_konsul"
                                placeholder="Pilih Tanggal Konsul"
                                value="<?= set_value('tgl_konsul', $rujukan_data['tgl_konsul']); ?>" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="harga">Harga</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="harga_display"
                                    placeholder="Input Estimasi Prospek" autocomplete="off"
                                    value="<?= number_format(set_value('harga', $rujukan_data['harga']), 0, ',', '.') ?>" />
                                <input type="hidden" id="harga" name="harga"
                                    value="<?= set_value('harga', $rujukan_data['harga']) ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="hpp">HPP</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="hpp_display"
                                    placeholder="Input Estimasi Prospek" autocomplete="off"
                                    value="<?= number_format(set_value('hpp', $rujukan_data['hpp']), 0, ',', '.') ?>" />
                                <input type="hidden" id="hpp" name="hpp"
                                    value="<?= set_value('hpp', $rujukan_data['hpp']) ?>" />
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="lokasi">Lokasi</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Input Lokasi"
                                value="<?= set_value('lokasi', $rujukan_data['lokasi']); ?>" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="pembayaran" class="col-md-2 col-form-label">Status Pembayaran <span
                                class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="pembayaran" name="pembayaran">
                                <option value="">Pilih Status Pembayaran</option>
                                <option value="Lunas"
                                    <?= ($rujukan_data['pembayaran'] == 'Lunas') ? 'selected' : ''; ?>>Lunas
                                </option>
                                <option value="Belum Lunas"
                                    <?= ($rujukan_data['pembayaran'] == 'Belum Lunas') ? 'selected' : ''; ?>>
                                    Belum Lunas</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('pembayaran') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"
                                placeholder="Input Keterangan"><?= set_value('keterangan', $rujukan_data['keterangan']); ?></textarea>
                        </div>
                    </div>


                    <div class="mb-3">
                        <div class="text-end">
                            <a href="<?= base_url('Rujukan') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-custom me-2">
                                Update </button>
                        </div>
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
                if (clientSelect.choices) {
                    clientSelect.choices.setChoiceByValue('');
                }
            } else {
                manualFields.style.display = 'none';
                clientSelect.disabled = false;
                document.getElementById('other_client').value = '';
            }
        });
    });
    </script>