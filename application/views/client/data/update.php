<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Perusahaan</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Perusahaan
                            </li>
                            <li class="breadcrumb-item">Data</li>
                            <li class="breadcrumb-item active"><?= $header?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Form <?= $header?></h5>
                <a href="<?= base_url()?>Client" class="btn btn-custom"> <i
                        class="tf-icons ti ti-circle-arrow-left me-2"></i>Kembali</a>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="id_client" id="id_client" value="<?= $client['id_client']; ?>">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Perusahaan <span
                                class="text-danger"> *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                value="<?= $client['nama_client']; ?>" />
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
                                value="<?= $client['nama_pic']; ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_pic') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_pic">Alamat PIC</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_pic" name="alamat_pic" rows="3"
                                placeholder="Input Alamat PIC"><?= $client['alamat_pic']; ?></textarea>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                *</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                value="<?= $client['tlp_pic']; ?>" />
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
                                value="<?= $client['email_pic']; ?>" />
                            <div class="form-text text-danger">
                                <?= form_error('email_pic') ?>
                            </div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_client" name="alamat_client" rows="3"
                                placeholder="Input Alamat Perusahaan"><?= $client['alamat_client']; ?></textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="hut_client" class="col-md-2 col-form-label">Hut Client </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" id="hut_client" name="hut_client" class="form-control"
                                    value="<?= $client['hut_client']; ?>">
                                <span class="input-group-text"><i class="ti ti-calendar-month"></i></span>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="hut_pic" class="col-md-2 col-form-label">Hut PIC </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" id="hut_pic" name="hut_pic" class="form-control"
                                    value="<?= $client['hut_pic']; ?>">
                                <span class="input-group-text"><i class="ti ti-calendar-month"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 row">
                        <label for="group" class="col-md-2 col-form-label">Group</label>
                        <div class="col-md-10">
                            <select class="form-control select2form" id="group" name="group">
                                <?php foreach ($group as $g): ?>
                                <option value="<?= $g['id_group']; ?>"
                                    <?= ($client['group'] == $g['id_group']) ? 'selected' : ''; ?>>
                                    <?= $g['nama_group']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
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