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
                    <a href="<?= base_url()?>Gift" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('Gift/Store') ?>" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Nama Client <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id">
                                <option value="">Pilih Client</option>
                                <?php foreach ($client as $c): ?>
                                <option value="<?= $c['id_client']; ?>"><?= $c['nama_client']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('client_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_gift">Nama Gift <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_gift" name="nama_gift"
                                placeholder="Input Nama Gift" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_gift') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="bu_gift">Kop Unit Bisnis <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="bu_gift" name="bu_gift">
                                <option value="">Pilih Kop Unit Bisnis</option>
                                <option value="Cakra Medika">Cakra Medika</option>
                                <option value="Konsehat">Konsehat</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('bu_gift') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="harga_gift">Harga Gift <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="harga_giftdisplay"
                                    placeholder="Input Estimasi Prospek" autocomplete="off" />
                                <input type="hidden" id="harga_gift" name="harga_gift" value="0" />
                            </div>
                            <div class="form-text text-danger">
                                <?= form_error('harga_gift') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="add_pelaksana" class="col-md-2 col-form-label">Pelaksana <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="pelaksana" name="pelaksana">
                                <option value="">Pilih Pelaksana</option>
                                <?php foreach ($team as $u): ?>
                                <option value="<?= $u['id_user']; ?>"><?= $u['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('pelaksana') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="add_tgl_gift">Tanggal Gift <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_gift" name="tgl_gift"
                                    placeholder="Input Tanggal Gift" />
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-text text-danger">
                            <?= form_error('tgl_gift') ?>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="lampiran_gift">Lampiran</label>
                        <div class="col-md-10">
                            <input type="file" class="form-control" id="lampiran_gift" name="lampiran_gift"
                                accept=".jpg,.jpeg,.png" />
                            <small class="text-muted">Format: jpg, jpeg, png Max: 10MB</small>
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