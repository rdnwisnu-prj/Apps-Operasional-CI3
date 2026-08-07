<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Dashboard Profile</h4>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">Menu</li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($this->session->flashdata('flash')): ?>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('flash')): ?>
            <div class="flash-login" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <?php endif; ?>


            <div class="row">
                <div class="col-xxl-3">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="<?= base_url()?>assets/img/avatar.png"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                        alt="user-profile-image">
                                </div>
                                <h5 class="fs-16 mb-1"><?php echo $user['nama']; ?> - <?php echo $user['nik']; ?></h5>
                                <p class="text-muted mb-0"><?php echo $user['jabatan']; ?> /
                                    <?php echo $user['cabang']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 flex-grow-1">Data User</h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="<?= base_url('Profil/update') ?>" method="post">
                                <input type="hidden" name="id_user" value="<?php echo $user['id_user']; ?>">
                                <input type="hidden" name="nik" value="<?php echo $user['nik']; ?>">
                                <input type="hidden" name="role_id" value="<?php echo $user['role_id']; ?>">

                                <h6 class="mb-3">1. General Info</h6>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="text" class="form-control" id="nik" name="nik_display"
                                                value="<?php echo $user['nik']; ?>" readonly disabled>
                                            <small class="form-text text-muted">NIK tidak dapat diubah</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                value="<?php echo set_value('nama', $user['nama']); ?>" readonly>
                                            <small class="form-text text-muted">Nama tidak dapat diubah</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="t_lahir" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="t_lahir" name="t_lahir"
                                                value="<?php echo set_value('t_lahir', $user['t_lahir']); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                            <div class="input-group">
                                                <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                                    placeholder="Enter Tgl Lahir"
                                                    value="<?php echo set_value('tgl_lahir', $user['tgl_lahir']); ?>">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="posisi" class="form-label">Posisi</label>
                                            <select class="form-control select2form" id="posisi" name="posisi">
                                                <?php 
                                                $options = ['Manager', 'Supervisor', 'Staff'];
                                                foreach ($options as $option): 
                                                ?>
                                                <option value="<?= $option ?>"
                                                    <?= set_select('posisi', $option, ($user['posisi'] == $option)) ?>>
                                                    <?= $option ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                value="<?php echo set_value('jabatan', $user['jabatan']); ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="cabang" class="form-label">Cabang</label>
                                            <input type="text" class="form-control" id="cabang" name="cabang"
                                                value="<?php echo set_value('cabang', $user['cabang']); ?>">
                                        </div>
                                    </div>

                                    <h6 class="mb-3">2. Pengaturan Akun</h6>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                value="<?php echo set_value('username', $user['username']); ?>">
                                            <div class="form-text text-danger">
                                                <?= form_error('username') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" class="form-control"
                                                    placeholder="Masukkan password baru" aria-label="Password"
                                                    aria-describedby="password-addon" id="password" name="password"
                                                    value="<?php echo set_value('password'); ?>">
                                                <button class="btn btn-light" type="button" id="password-addon">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </button>
                                            </div>
                                            <div class="form-text text-muted">
                                                <small>Kosongkan kolom ini jika tidak ingin mengubah password.</small>
                                            </div>
                                            <div class="form-text text-danger">
                                                <?= form_error('password') ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-custom">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>