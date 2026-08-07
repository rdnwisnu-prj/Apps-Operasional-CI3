<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <?php if ($this->session->flashdata('flash')): ?>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?= $header?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header?></a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader?></a></li>
                                <li class="breadcrumb-item active">Tambah Data <?= $subheader?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Add Marketing Team</h5>
                    <div class="gap-2">
                        <a href="<?= base_url()?>Team" class="btn btn-custom"> <i
                                class="ri-arrow-left-circle-line align-bottom me-2"></i>Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <h6>1. General Info</h6>
                        <div class="mb-3 row">
                            <label for="nama" class="col-md-2 col-form-label" for="nama">Nama Lengkap<span
                                    class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Nama Lengkap" id="nama"
                                    name="nama">
                                <div class="form-text text-danger">
                                    <?= form_error('nama') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label" for="email">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" placeholder="Email" id="email" name="email">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="no_tlp" class="col-md-2 col-form-label" for="no_tlp">No Tlp</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="No Tlp" id="no_tlp" name="no_tlp">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="t_lahir" class="col-md-2 col-form-label" for="t_lahir">Tempat
                                Lahir</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Tempat Lahir" id="t_lahir"
                                    name="t_lahir">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tgl_lahir" class="col-md-2 col-form-label" for="tgl_lahir">Tgl
                                Lahir</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                        placeholder="YYYY-MM-DD" />
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label" for="gender">Gender</label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="radio" name="gender" id="genderL" value="L" />
                                    <label class="form-check-label" for="genderL">Laki - Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderP" value="P" />
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="foto" class="col-md-2 col-form-label">Foto</label>
                            <div class="col-md-10">
                                <input class="form-control" type="file" id="foto" name="foto">
                                <p class="fs-7"><em>(Hanya mendukung format JPG, JPEG, dan PNG dengan maksimal
                                        ukuran
                                        2MB)</em></p>
                            </div>
                        </div>

                        <hr class="my-3 mx-n3" />

                        <h6>2. Job Info</h6>

                        <div class="mb-3 row">
                            <label for="nik" class="col-md-2 col-form-label">NIK <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="NIK" id="nik" name="nik">
                                <div class="form-text text-danger">
                                    <?= form_error('nik') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="posisi" class="col-md-2 col-form-label">Posisi</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="posisi" name="posisi">
                                    <option value="">Pilih Posisi</option>
                                    <?php foreach ($posisi as $p): ?>
                                    <option value="<?= $p['id_posisi']; ?>">
                                        <?= $p['nama_posisi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="jabatan" class="col-md-2 col-form-label">Jabatan</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="jabatan" name="jabatan">
                                    <option value="">Pilih Jabatan</option>
                                    <option value="General Manager">General Manager</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="cabang" class="col-md-2 col-form-label">Cabang</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="cabang" name="cabang">
                                    <option value="">Pilih Cabang</option>
                                    <?php foreach ($cabang as $c): ?>
                                    <option value="<?= $c['id_cabang']; ?>">
                                        <?= $c['nama_cabang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <hr class="my-3 mx-n3" />
                        <h6>3. Account Setting</h6>


                        <div class="mb-3 row">
                            <label for="username" class="col-md-2 col-form-label">Username <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Username" id="username"
                                    name="username">
                                <div class="form-text text-danger">
                                    <?= form_error('username') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-2 col-form-label">Password <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5 password-input"
                                        placeholder="Enter password" id="password-input" name="password">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon"><i
                                            class="ri-eye-fill align-middle"></i></button>
                                </div>
                                <div class="form-text text-danger">
                                    <?= form_error('password') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="role_id" name="role_id">
                                    <option value="">Pilih Role</option>
                                    <?php foreach ($role as $r): ?>
                                    <option value="<?= $r['id_role']; ?>">
                                        <?= $r['nama_role']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="text-end">
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
    </div>