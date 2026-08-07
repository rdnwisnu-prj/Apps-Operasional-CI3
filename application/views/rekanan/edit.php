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
                    <a href="<?= base_url()?>Rekanan" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">

                    <input type="hidden" name="id_rekanan" id="id_rekanan" value="<?= $rekanan['id_rekanan']; ?>">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_rekanan">Nama Rekanan <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_rekanan" name="nama_rekanan"
                                value="<?= $rekanan['nama_rekanan']; ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_rekanan') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_rekanan">Alamat Rekanan </label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="alamat_rekanan" id="alamat_rekanan"
                                rows="3"><?= $rekanan['alamat_rekanan']; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_rekanan">Telepon Rekanan </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_rekanan" name="tlp_rekanan"
                                value="<?= $rekanan['tlp_rekanan']; ?>" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="estimasi">Omset Rekanan</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="estimasi_lead_display"
                                    value="<?= number_format(set_value('omset', $rekanan['omset']), 0, ',', '.') ?>"
                                    autocomplete="off" />
                                <input type="hidden" id="omset" name="omset"
                                    value="<?= set_value('omset', $rekanan['omset']) ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="owner" class="col-md-2 col-form-label">Owner Data Rekanan</label>
                        <div class="col-md-10">
                            <select class="form-control" id="filter_user_id" name="owner">
                                <option value="">Pilih Owner</option>
                                <?php foreach ($team as $u): ?>
                                <option value="<?= $u['id_user']; ?>"
                                    <?= $u['id_user'] == $rekanan['owner'] ? 'selected' : '' ?>>
                                    <?= $u['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
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