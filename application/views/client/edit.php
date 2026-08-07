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
                    <li class="breadcrumb-item active">Update <?= $subheader?> </li>
                </ol>
            </nav>
        </div>


        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Update <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>Client" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="id_client" value="<?= $client['id_client']; ?>">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Perusahaan <span
                                class="text-danger"> *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                placeholder="Nama Perusahaan"
                                value="<?= set_value('nama_client', $client['nama_client']); ?>" />
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
                                placeholder="Input Nama PIC"
                                value="<?= set_value('nama_pic', $client['nama_pic']); ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_pic') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_pic">Alamat PIC</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_pic" name="alamat_pic" rows="3"
                                placeholder="Input Alamat PIC"><?= set_value('alamat_pic', $client['alamat_pic']); ?></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                placeholder="Input No PIC" value="<?= set_value('tlp_pic', $client['tlp_pic']); ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('tlp_pic') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="email_pic">Email PIC</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email_pic" name="email_pic"
                                placeholder="Input Email PIC"
                                value="<?= set_value('email_pic', $client['email_pic']); ?>" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_client" name="alamat_client" rows="3"
                                placeholder="Input Alamat Perusahaan"><?= set_value('alamat_client', $client['alamat_client']); ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="hut_client" class="col-md-2 col-form-label">Hut Client </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="hut_client" name="hut_client"
                                    placeholder="Input Hut Client"
                                    value="<?= set_value('hut_client', $client['hut_client']); ?>">
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
                                    placeholder="Input Hut PIC"
                                    value="<?= set_value('hut_pic', $client['hut_pic']); ?>">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="sektor" class="col-md-2 col-form-label">Sektor </label>
                        <div class="col-md-10">
                            <?php $sektor_val = set_value('sektor', $client['sektor']); ?>
                            <select class="form-control" id="sektor" name="sektor">
                                <option value="">Pilih Sektor</option>
                                <option value="Industri" <?= $sektor_val == 'Industri' ? 'selected' : ''; ?>>
                                    Industri</option>
                                <option value="Kementerian/ Goverment"
                                    <?= $sektor_val == 'Kementerian/ Goverment' ? 'selected' : ''; ?>>
                                    Kementerian/ Goverment</option>
                                <option value="Danantara (BUMN Karya)"
                                    <?= $sektor_val == 'Danantara (BUMN Karya)' ? 'selected' : ''; ?>>
                                    Danantara (BUMN Karya)</option>
                                <option value="Pertambangan/ Mining"
                                    <?= $sektor_val == 'Pertambangan/ Mining' ? 'selected' : ''; ?>>
                                    Pertambangan/ Mining</option>
                                <option value="Perkantoran/ Office"
                                    <?= $sektor_val == 'Perkantoran/ Office' ? 'selected' : ''; ?>>
                                    Perkantoran/ Office</option>
                                <option value="Perhotelan" <?= $sektor_val == 'Perhotelan' ? 'selected' : ''; ?>>
                                    Perhotelan
                                </option>
                                <option value="Facility services (Security, Cleaning service, Catering)"
                                    <?= $sektor_val == 'Facility services (Security, Cleaning service, Catering)' ? 'selected' : ''; ?>>
                                    Facility services (Security, Cleaning service, Catering)</option>
                                <option value="Instansi Pendidikan"
                                    <?= $sektor_val == 'Instansi Pendidikan' ? 'selected' : ''; ?>>Instansi
                                    Pendidikan</option>
                                <option value="Travel & Agent"
                                    <?= $sektor_val == 'Travel & Agent' ? 'selected' : ''; ?>>Travel & Agent
                                </option>
                                <option value="Rumah Sakit & Lab"
                                    <?= $sektor_val == 'Rumah Sakit & Lab' ? 'selected' : ''; ?>>Rumah Sakit
                                    & Lab</option>
                                <option value="Yayasan" <?= $sektor_val == 'Yayasan' ? 'selected' : ''; ?>>
                                    Yayasan</option>
                                <option value="Shipping" <?= $sektor_val == 'Shipping' ? 'selected' : ''; ?>>
                                    Shipping</option>
                                <option value="Retail Market" <?= $sektor_val == 'Retail Market' ? 'selected' : ''; ?>>
                                    Retail Market</option>
                                <option value="Engineering (Air, Listrik, IT)"
                                    <?= $sektor_val == 'Engineering (Air, Listrik, IT)' ? 'selected' : ''; ?>>
                                    Engineering (Air, Listrik, IT)</option>
                                <option value="Finance (Banking, Insurance)"
                                    <?= $sektor_val == 'Finance (Banking, Insurance)' ? 'selected' : ''; ?>>
                                    Finance (Banking, Insurance)</option>
                                <option value="Transportation"
                                    <?= $sektor_val == 'Transportation' ? 'selected' : ''; ?>>
                                    Transportation</option>
                                <option value="Construction" <?= $sektor_val == 'Construction' ? 'selected' : ''; ?>>
                                    Construction</option>
                                <option value="Plantation" <?= $sektor_val == 'Plantation' ? 'selected' : ''; ?>>
                                    Plantation</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="group" class="col-md-2 col-form-label">Group </label>
                        <div class="col-md-10">
                            <?php $group_val = set_value('group', $client['group']); ?>
                            <select class="form-control" id="group" name="group">
                                <option value="">Pilih Group</option>
                                <option value="VIP" <?= $group_val == 'VIP' ? 'selected' : ''; ?>>VIP
                                </option>
                                <option value="Gold" <?= $group_val == 'Gold' ? 'selected' : ''; ?>>Gold
                                </option>
                                <option value="Silver" <?= $group_val == 'Silver' ? 'selected' : ''; ?>>
                                    Silver</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status" class="col-md-2 col-form-label">Status</label>
                        <div class="col-md-10">
                            <?php $status_val = set_value('status', $client['status']); ?>
                            <select class="form-control" id="status" name="status">
                                <option value="">Pilih Status</option>
                                <option value="New Customer" <?= $status_val == 'New Customer' ? 'selected' : ''; ?>>New
                                    Customer
                                </option>
                                <option value="Old Customer" <?= $status_val == 'Old Customer' ? 'selected' : ''; ?>>Old
                                    Customer
                                </option>
                                <option value="Lost Customer" <?= $status_val == 'Lost Customer' ? 'selected' : ''; ?>>
                                    Lost Customer
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label for="periode_bulan" class="col-md-2 col-form-label">Periode </label>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_bulan" name="periode_bulan">
                                <option value="">Pilih Bulan</option>
                                <?php 
                                $bulan_names = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                $current_bulan = isset($client['periode_bulan']) ? $client['periode_bulan'] : date('m');
                                for($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $current_bulan == $m ? 'selected' : '' ?>><?= $bulan_names[$m] ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select class="form-control" id="periode_tahun" name="periode_tahun">
                                <option value="">Pilih Tahun</option>
                                <?php 
                                $current_tahun = isset($client['periode_tahun']) ? $client['periode_tahun'] : date('Y');
                                for($y = date('Y') - 5; $y <= date('Y') + 5; $y++): ?>
                                <option value="<?= $y ?>" <?= $current_tahun == $y ? 'selected' : '' ?>><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="reset" class="btn btn-light">
                            <i class="ri-close-circle-line label-icon align-middle me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle me-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>