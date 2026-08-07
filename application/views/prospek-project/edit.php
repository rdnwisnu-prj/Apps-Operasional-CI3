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
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>ProspekProject" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('ProspekProject/update/' . $leads['id_leads']) ?>" method="post">
                    <input type="hidden" name="id_leads" value="<?= $leads['id_leads'] ?>">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Perusahaan <span
                                class="text-danger"> *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                placeholder="Input Nama Perusahaan"
                                value="<?= set_value('nama_client', $leads['nama_client']) ?>" />
                            <div class="form-text text-danger"><?= form_error('nama_client') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_pic">Nama PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_pic" name="nama_pic"
                                placeholder="Input Nama PIC" value="<?= set_value('nama_pic', $leads['nama_pic']) ?>" />
                            <div class="form-text text-danger"><?= form_error('nama_pic') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                placeholder="Input No PIC" value="<?= set_value('tlp_pic', $leads['tlp_pic']) ?>" />
                            <div class="form-text text-danger"><?= form_error('tlp_pic') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="email_pic">Email PIC </label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email_pic" name="email_pic"
                                placeholder="Input Email PIC"
                                value="<?= set_value('email_pic', $leads['email_pic']) ?>" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_client" name="alamat_client" rows="3"
                                placeholder="Input Alamat Perusahaan"><?= set_value('alamat_client', $leads['alamat_client']) ?></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="status_lead" class="col-md-2 col-form-label">Status Prospek <span
                                class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="status_lead" name="status_lead">
                                <option value="">Pilih Status Prospek</option>
                                <option value="Proses Prospek"
                                    <?= set_select('status_lead', 'Proses Prospek', $leads['status_lead'] == 'Proses Prospek') ?>>
                                    Proses Prospek</option>
                                <option value="Negosiasi"
                                    <?= set_select('status_lead', 'Negosiasi', $leads['status_lead'] == 'Negosiasi') ?>>
                                    Negosiasi</option>
                                <option value="Deal"
                                    <?= set_select('status_lead', 'Deal', $leads['status_lead'] == 'Deal') ?>>Deal
                                </option>
                                <option value="Lost"
                                    <?= set_select('status_lead', 'Lost', $leads['status_lead'] == 'Lost') ?>>Lost
                                </option>
                            </select>
                            <div class="form-text text-danger"><?= form_error('status_lead') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status_project" class="col-md-2 col-form-label">Status Project <span
                                class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <?php $current_status_project = !empty($leads['status_project']) ? $leads['status_project'] : 'New'; ?>
                            <select class="form-control" id="status_project" name="status_project">
                                <option value="">Pilih Status Project</option>
                                <option value="New"
                                    <?= set_select('status_project', 'New', $current_status_project == 'New') ?>>New
                                </option>
                                <option value="Repeat"
                                    <?= set_select('status_project', 'Repeat', $current_status_project == 'Repeat') ?>>
                                    Repeat</option>
                            </select>
                            <div class="form-text text-danger"><?= form_error('status_project') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="estimasi_lead_display">Estimasi Prospek</label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input type="text" class="form-control format-number" id="estimasi_lead_display"
                                    placeholder="Input Estimasi Prospek" autocomplete="off"
                                    value="<?= number_format(set_value('estimasi_lead', $leads['estimasi_lead']), 0, ',', '.') ?>" />
                                <input type="hidden" id="estimasi_lead" name="estimasi_lead"
                                    value="<?= set_value('estimasi_lead', $leads['estimasi_lead']) ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sektor" class="col-md-2 col-form-label">Sektor </label>
                        <div class="col-md-10">
                            <select class="form-control" id="sektor" name="sektor">
                                <option value="">Pilih Sektor</option>
                                <?php
                                $sektor_options = ['Industri', 'Kementerian/ Goverment', 'Danantara (BUMN Karya)', 'Pertambangan/ Mining', 'Perkantoran/ Office', 'Perhotelan', 'Facility services (Security, Cleaning service, Catering)', 'Instansi Pendidikan', 'Travel & Agent', 'Rumah Sakit & Lab', 'Yayasan', 'Shipping', 'Retail Market', 'Engineering (Air, Listrik, IT)', 'Finance (Banking, Insurance)', 'Transportation', 'Construction', 'Plantation'];
                                foreach ($sektor_options as $opt): ?>
                                <option value="<?= $opt ?>" <?= (isset($leads['sektor']) && $leads['sektor'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="group" class="col-md-2 col-form-label">Group </label>
                        <div class="col-md-10">
                            <select class="form-control" id="group" name="group">
                                <option value="">Pilih Group</option>
                                <?php
                                $group_options = ['VIP', 'Gold', 'Silver'];
                                foreach ($group_options as $opt): ?>
                                <option value="<?= $opt ?>" <?= (isset($leads['group']) && $leads['group'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="service">Layanan </label>
                        <div class="col-md-10">
                            <select class="form-control" id="service" name="service">
                                <option value="">Pilih Service</option>
                                <?php
                                $service_options = ['MCU', 'IHC', 'VAKSIN', 'HSEO', 'LAB RUJUKAN'];
                                foreach ($service_options as $opt): ?>
                                <option value="<?= $opt ?>" <?= (isset($leads['service']) && $leads['service'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('service') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="periode_bulan" class="col-md-2 col-form-label">Periode </label>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_bulan" name="periode_bulan">
                                <option value="">Pilih Bulan</option>
                                <?php 
                                $bulan_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                $current_bulan = isset($leads['periode_bulan']) ? $leads['periode_bulan'] : date('m');
                                for($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $current_bulan == $m ? 'selected' : '' ?>><?= $bulan_names[$m] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_tahun" name="periode_tahun">
                                <option value="">Pilih Tahun</option>
                                <?php 
                                $current_tahun = isset($leads['periode_tahun']) ? $leads['periode_tahun'] : date('Y');
                                for($y = date('Y') - 5; $y <= date('Y') + 5; $y++): ?>
                                <option value="<?= $y ?>" <?= $current_tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="catatan">Catatan <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                placeholder="Input Catatan"><?= set_value('catatan', $leads['catatan']) ?></textarea>
                            <div class="form-text text-danger"><?= form_error('catatan') ?></div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?= base_url('ProspekProject') ?>" class="btn btn-light">
                            <i class="ri-close-circle-line label-icon align-middle me-2"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle me-2"></i> Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
