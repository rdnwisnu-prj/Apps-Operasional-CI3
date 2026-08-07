<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Profile</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="">Menu</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                    <img src="<?= base_url('upload/employee/' . $user['foto']); ?>" alt="img">
                                    <span class="status online"></span>
                                </div>
                                <div>
                                    <h5 class="mb-1"><?php echo $user['nama']; ?> - <?php echo $user['nik']; ?> </h5>
                                    <p class="mb-2"><?= $user['nama_cabang']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('Profile/update') ?>" method="post" enctype="multipart/form-data"
                        accept-charset="utf-8">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                            value="<?= $this->security->get_csrf_hash() ?>">
                        <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">

                        <h6>1. General Info</h6>

                        <div class="mb-3 row">
                            <label for="nama" class="col-md-2 col-form-label">Nama Lengkap<span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $user['nama']; ?>" id="nama"
                                    name="nama">
                                <div class="form-text text-danger">
                                    <?= form_error('nama') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="foto" class="col-md-2 col-form-label">Foto</label>
                            <div class="col-md-10">
                                <?php if (!empty($user['foto']) && file_exists(FCPATH . 'upload/employee/' . $user['foto'])): ?>
                                <div class="mb-3">
                                    <p class="text-muted mb-1">Foto saat ini:</p>
                                    <img src="<?= base_url('upload/employee/' . $user['foto']) ?>" alt="Foto Profil"
                                        class="img-thumbnail"
                                        style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    <p class="text-muted mt-1 small"><?= $user['foto'] ?></p>
                                </div>
                                <?php elseif (!empty($user['foto'])): ?>
                                <div class="alert alert-warning p-2 small mb-2">
                                    <i class="mdi mdi-alert-circle-outline"></i> File foto tidak
                                    ditemukan di server
                                </div>
                                <?php else: ?>
                                <div class="alert alert-info p-2 small mb-2">
                                    <i class="mdi mdi-information-outline"></i> Belum ada foto
                                    yang
                                    diupload
                                </div>
                                <?php endif; ?>

                                <input class="form-control" type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png">
                                <div class="form-text">
                                    <p class="mb-1"><em>Hanya mendukung format JPG, JPEG, dan
                                            PNG (maks.
                                            2MB)</em></p>
                                    <p class="mb-0 text-success"><em>Biarkan kosong untuk
                                            mempertahankan
                                            foto saat ini</em></p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6 mx-n3" />

                        <h6>2. Account Setting</h6>

                        <div class="row mb-3">
                            <label for="username" class="col-md-2 col-form-label">Username <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="username" name="username"
                                    value="<?= $user['username']; ?>">
                                <div class="form-text text-danger">
                                    <?= form_error('username') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-2 col-form-label">Password <span class="text-danger">
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
                                    <p><em>Kosongkan kolom ini jika tidak ingin mengubah
                                            password.</em></p>
                                </div>
                                <div class="form-text text-danger">
                                    <?= form_error('password') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning me-2">
                                    <i class="bx bx-check-circle font-size-16 align-middle"></i>
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>