<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="<?php echo base_url()?>assets/img/full.jpg" alt="Banner image" class="rounded-top" />
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-5">
                        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                            <img src="<?= base_url('upload/employee/' . $team['foto']); ?>" alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded user-profile-img" />
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6"><?= $team['nama']; ?></h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 my-2">
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="ti ti-user-square ti-lg"></i><span
                                                class="fw-medium"><?= $team['jabatan']; ?></span>
                                        </li>
                                        <li class="list-inline-item d-flex gap-2 align-items-center">
                                            <i class="ti ti-scan-position ti-lg"></i><span
                                                class="fw-medium"><?= $team['posisi']; ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-2 gap-lg-0">
                        <li class="nav-item">
                            <a class="nav-link " href="<?php echo base_url()?>Profile"><i
                                    class="ti-sm ti ti-device-laptop me-1_5"></i>
                                Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?php echo base_url()?>Profile/Setting"><i
                                    class="ti-sm ti ti-user-cog me-1_5"></i>
                                Pengaturan Akun</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
            <?php if ($this->session->flashdata('flash')): ?>
            <?php endif; ?>
        </div>

        <div class="flash-error" data-flashdata="<?= $this->session->flashdata('error'); ?>">
            <?php if ($this->session->flashdata('error')): ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="card mb-6">
                    <div class="card-body">
                        <small class="card-text text-uppercase text-muted small">Personal Information</small>
                        <dl class="row mt-2">
                            <dt class="col-sm-6 mb-3"><i class="ti ti-user ti-lg"></i><span class="fw-medium mx-2">Nama
                                    Lengkap</span></dt>
                            <dd class="col-sm-6">: <?php echo $team['nama']; ?></dd>

                            <dt class="col-sm-6 mb-3"><i class="ti ti-phone-call ti-lg"></i><span
                                    class="fw-medium mx-2">No
                                    Tlp</span></dt>
                            <dd class="col-sm-6">
                                : <?php echo $team['no_tlp']; ?>
                            </dd>

                            <dt class="col-sm-6 mb-3"> <i class="ti ti-mail ti-lg"></i><span
                                    class="fw-medium mx-2">Email</span></dt>
                            <dd class="col-sm-6">
                                : <?php echo $team['email']; ?>
                            </dd>
                        </dl>
                        <small class="card-text text-uppercase text-muted small">Job Information</small>

                        <dl class="row mt-2">
                            <dt class="col-sm-6 mb-3">
                                <i class="ti ti-id-badge-2 ti-lg"></i><span class="fw-medium mx-2">NIK</span>
                            </dt>
                            <dd class="col-sm-6">: <?php echo $team['nik']; ?></dd>

                            <dt class="col-sm-6 mb-3">
                                <i class="ti ti-hierarchy ti-lg"></i><span class="fw-medium mx-2">Cabang</span>
                            </dt>
                            <dd class="col-sm-6">: <?php echo $team['nama_cabang']; ?></dd>

                            <dt class="col-sm-6 mb-3">
                                <i class="ti ti-user-square ti-lg"></i><span class="fw-medium mx-2">Jabatan</span>
                            </dt>
                            <dd class="col-sm-6">: <?php echo $team['jabatan']; ?></dd>

                            <dt class="col-sm-6 mb-3">
                                <i class="ti ti-scan-position ti-lg"></i><span class="fw-medium mx-2">Posisi</span>
                            </dt>
                            <dd class="col-sm-6">: <?php echo $team['posisi']; ?></dd>

                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('profile/updatesetting') ?>" method="post"
                            enctype="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                                value="<?= $this->security->get_csrf_hash() ?>">
                            <input type="hidden" name="id_user" value="<?= $team['id_user'] ?>">

                            <h6>1. General Info</h6>

                            <div class="mb-3 row">
                                <label for="nama" class="col-md-2 col-form-label">Nama Lengkap<span class="text-danger">
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?= $team['nama']; ?>" id="nama"
                                        name="nama">
                                    <div class="form-text text-danger">
                                        <?= form_error('nama') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-2 col-form-label">Email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="email" value="<?= $team['email']; ?>" id="email"
                                        name="email">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="no_tlp" class="col-md-2 col-form-label">No Tlp</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?= $team['no_tlp']; ?>" id="no_tlp"
                                        name="no_tlp">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="t_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="<?= $team['t_lahir']; ?>"
                                        id="t_lahir" name="t_lahir">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tgl_lahir" class="col-md-2 col-form-label">Tgl Lahir</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                            value="<?= $team['tgl_lahir']; ?>">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="gender" class="col-md-2 col-form-label">Gender</label>
                                <div class="col-md-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="gender" id="genderL"
                                            value="L" <?= ($team['gender'] == 'L') ? 'checked' : '' ?> />
                                        <label class="form-check-label" for="genderL">Laki - Laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderP"
                                            value="P" <?= ($team['gender'] == 'P') ? 'checked' : '' ?> />
                                        <label class="form-check-label" for="genderP">Perempuan</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="foto" class="col-md-2 col-form-label">Foto</label>
                                <div class="col-md-10">
                                    <?php if (!empty($team['foto']) && file_exists(FCPATH . 'upload/employee/' . $team['foto'])): ?>
                                    <div class="mb-3">
                                        <p class="text-muted mb-1">Foto saat ini:</p>
                                        <img src="<?= base_url('upload/employee/' . $team['foto']) ?>" alt="Foto Profil"
                                            class="img-thumbnail"
                                            style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        <p class="text-muted mt-1 small"><?= $team['foto'] ?></p>
                                    </div>
                                    <?php elseif (!empty($team['foto'])): ?>
                                    <div class="alert alert-warning p-2 small mb-2">
                                        <i class="mdi mdi-alert-circle-outline"></i> File foto tidak
                                        ditemukan di server
                                    </div>
                                    <?php else: ?>
                                    <div class="alert alert-info p-2 small mb-2">
                                        <i class="mdi mdi-information-outline"></i> Belum ada foto yang
                                        diupload
                                    </div>
                                    <?php endif; ?>

                                    <input class="form-control" type="file" id="foto" name="foto"
                                        accept=".jpg,.jpeg,.png">
                                    <div class="form-text">
                                        <p class="mb-1"><em>Hanya mendukung format JPG, JPEG, dan PNG (maks.
                                                2MB)</em></p>
                                        <p class="mb-0 text-success"><em>Biarkan kosong untuk mempertahankan
                                                foto saat ini</em></p>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6 mx-n4" />

                            <h6>2. Account Setting</h6>

                            <div class="row mb-3">
                                <label for="username" class="col-md-2 col-form-label">Username <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" id="username" name="username"
                                        value="<?= $team['username']; ?>">
                                    <div class="form-text text-danger">
                                        <?= form_error('username') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-2 col-form-label">Password <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-10">
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password" class="form-control" placeholder="Masukkan password baru"
                                            aria-label="Password" aria-describedby="password-addon" id="password"
                                            name="password">
                                        <button class="btn btn-light" type="button" id="password-addon">
                                            <i class="tf-icons ti ti-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-danger">
                                        <p><em>Kosongkan kolom ini jika tidak ingin mengubah password.</em></p>
                                    </div>
                                    <div class="form-text text-danger">
                                        <?= form_error('password') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-warning me-2">
                                        <i class="bx bx-check-circle font-size-16 align-middle"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>