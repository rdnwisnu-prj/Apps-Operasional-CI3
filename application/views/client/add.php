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
                    <a href="<?= base_url()?>Client" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Perusahaan <span
                                class="text-danger"> *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                placeholder="Nama Perusahaan" />
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
                        <label class="col-md-2 col-form-label" for="email_pic">Email PIC</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email_pic" name="email_pic"
                                placeholder="Input Email PIC" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_client" name="alamat_client" rows="3"
                                placeholder="Input Alamat Perusahaan"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="hut_client" class="col-md-2 col-form-label">Hut Client </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="hut_client" name="hut_client"
                                    placeholder="Input Hut Client">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="hut_pic" class="col-md-2 col-form-label">Hut PIC </label>
                        <div class="col-md-10">

                            <div class="input-group">
                                <input type="text" class="form-control" id="hut_pic" name="hut_pic"
                                    placeholder="Input Hut PIC">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sektor" class="col-md-2 col-form-label">Sektor </label>
                        <div class="col-md-10">
                            <select class="form-control" id="sektor" name="sektor">
                                <option value="">Pilih Sektor</option>
                                <option value="Industri">Industri</option>
                                <option value="Kementerian/ Goverment">Kementerian/ Goverment</option>
                                <option value="Danantara (BUMN Karya)">Danantara (BUMN Karya)</option>
                                <option value="Pertambangan/ Mining">Pertambangan/ Mining</option>
                                <option value="Perkantoran/ Office">Perkantoran/ Office</option>
                                <option value="Perhotelan">Perhotelan</option>
                                <option value="Facility services (Security, Cleaning service, Catering)">
                                    Facility
                                    services (Security, Cleaning service, Catering)</option>
                                <option value="Instansi Pendidikan">Instansi Pendidikan</option>
                                <option value="Travel & Agent">Travel & Agent</option>
                                <option value="Rumah Sakit & Lab">Rumah Sakit & Lab</option>
                                <option value="Yayasan">Yayasan</option>
                                <option value="Shipping">Shipping</option>
                                <option value="Retail Market">Retail Market</option>
                                <option value="Engineering (Air, Listrik, IT)">Engineering (Air, Listrik,
                                    IT)</option>
                                <option value="Finance (Banking, Insurance)">Finance (Banking, Insurance)
                                </option>
                                <option value="Transportation">Transportation</option>
                                <option value="Construction">Construction</option>
                                <option value="Plantation">Plantation</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="group" class="col-md-2 col-form-label">Group </label>
                        <div class="col-md-10">
                            <select class="form-control" id="group" name="group">
                                <option value="">Pilih Group</option>
                                <option value="VIP">VIP</option>
                                <option value="Gold">Gold</option>
                                <option value="Silver">Silver</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <select class="form-control" id="status" name="status">
                                <option value="">Pilih Status</option>
                                <option value="New Customer">New Customer</option>
                                <option value="Old Customer">Old Customer</option>
                                <option value="Lost Customer">Lost Customer</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-5">
                        <label for="periode_bulan" class="col-md-2 col-form-label">Periode </label>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_bulan" name="periode_bulan">
                                <option value="">Pilih Bulan</option>
                                <option value="1" <?= date('m') == 1 ? 'selected' : '' ?>>Januari</option>
                                <option value="2" <?= date('m') == 2 ? 'selected' : '' ?>>Februari</option>
                                <option value="3" <?= date('m') == 3 ? 'selected' : '' ?>>Maret</option>
                                <option value="4" <?= date('m') == 4 ? 'selected' : '' ?>>April</option>
                                <option value="5" <?= date('m') == 5 ? 'selected' : '' ?>>Mei</option>
                                <option value="6" <?= date('m') == 6 ? 'selected' : '' ?>>Juni</option>
                                <option value="7" <?= date('m') == 7 ? 'selected' : '' ?>>Juli</option>
                                <option value="8" <?= date('m') == 8 ? 'selected' : '' ?>>Agustus</option>
                                <option value="9" <?= date('m') == 9 ? 'selected' : '' ?>>September</option>
                                <option value="10" <?= date('m') == 10 ? 'selected' : '' ?>>Oktober</option>
                                <option value="11" <?= date('m') == 11 ? 'selected' : '' ?>>November</option>
                                <option value="12" <?= date('m') == 12 ? 'selected' : '' ?>>Desember</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_tahun" name="periode_tahun">
                                <option value="">Pilih Tahun</option>
                                <?php for($y = date('Y') - 5; $y <= date('Y') + 5; $y++): ?>
                                <option value="<?= $y ?>" <?= date('Y') == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
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