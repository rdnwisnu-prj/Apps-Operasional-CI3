<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Prospek</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Prospek</li>
                            <li class="breadcrumb-item">Data</li>
                            <li class="breadcrumb-item active">Tambah Data Prospek</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Form <?= $header?></h5>
                <a href="<?= base_url()?>Leads" class="btn btn-custom"> <i
                        class="tf-icons ti ti-circle-arrow-left me-2"></i>Kembali</a>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Perusahaan <span
                                class="text-danger"> *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                placeholder="Input Nama Perusahaan" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_client') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_pic">Nama PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_pic" name="nama_pic"
                                placeholder="Input Nama PIC" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_pic') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_pic">Alamat PIC</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_pic" name="alamat_pic" rows="3"
                                placeholder="Input Alamat PIC"></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                placeholder="Input No PIC" />
                            <div class="form-text text-danger">
                                <?= form_error('tlp_pic') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="email_pic">Email PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email_pic" name="email_pic"
                                placeholder="Input Email PIC" />
                            <div class="form-text text-danger">
                                <?= form_error('email_pic') ?>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="status_lead" class="col-md-2 col-form-label">Status Prospek <span
                                class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <select class="form-control select2form" id="status_lead" name="status_lead">
                                <option>Pilih Status Prospek</option>
                                <option value="Proses Prospek">Proses Prospek</option>
                                <option value="Negosiasi">Negosiasi</option>
                                <option value="Deal">Deal</option>
                                <option value="Lost">Lost</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="catatan">Catatan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                placeholder="Input Catatan"></textarea>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="reset" class="btn btn-secondary me-2">
                                Reset </button>
                            <button type="submit" class="btn btn-custom me-2">
                                Submit </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>