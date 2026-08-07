<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">User Dashboard</h4>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">User</li>
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

            <div class="row">
                <div class="col-xl-9 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data User</h5>
                        </div>
                        <div class="card-body">
                            <table id="general"
                                class="table bordered-table dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama User</th>
                                        <th>Posisi</th>
                                        <th>Jabatan</th>
                                        <th>Cabang</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($user as $u): ?>
                                    <tr>
                                        <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                        <td><?= $u['nik']; ?></td>
                                        <td><?= $u['nama']; ?></td>
                                        <td><?= $u['posisi']; ?></td>
                                        <td><?= $u['jabatan']; ?></td>
                                        <td><?= $u['cabang']; ?></td>
                                        <td class="text-center" style="width: 10%;">
                                            <a href="<?= base_url(); ?>User/edit/<?= $u['id_user']; ?>"
                                                class="btn btn-outline-warning btn-sm edit me-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>
                                            <a href="<?= base_url(); ?>User/destroy/<?= $u['id_user']; ?>"
                                                class="btn btn-outline-danger btn-sm btn-destroy"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-xl-3 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><?= isset($edit_data) ? 'Edit' : 'Tambah' ?> Data User</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= isset($edit_data) ? base_url('User/update') : base_url('User/create') ?>"
                                method="post">
                                <?php if(isset($edit_data)): ?>
                                <input type="hidden" name="id_user" value="<?= $edit_data['id_user'] ?>">
                                <?php endif; ?>


                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK<span class="text-danger"> *</span></label>
                                    <input type="text" id="nik" name="nik"
                                        class="form-control <?= form_error('nik') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter NIK"
                                        value="<?= isset($edit_data) ? $edit_data['nik'] : set_value('nik') ?>" />
                                    <div class="invalid-feedback">
                                        <?= form_error('nik') ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Karyawan<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="nama" name="nama"
                                        class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter Nama Karyawan"
                                        value="<?= isset($edit_data) ? $edit_data['nama'] : set_value('nama') ?>" />
                                    <div class="invalid-feedback">
                                        <?= form_error('nama') ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="t_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="t_lahir" name="t_lahir" class="form-control"
                                        placeholder="Enter Nama Role"
                                        value="<?= isset($edit_data) ? $edit_data['t_lahir'] : set_value('t_lahir') ?>" />
                                </div>

                                <div class="mb-3">
                                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                            placeholder="Enter Tgl Lahir"
                                            value="<?= isset($edit_data) ? $edit_data['tgl_lahir'] : set_value('tgl_lahir') ?>">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="posisi" class="form-label">Posisi</label>
                                    <select class="form-control select2form" id="posisi" name="posisi">
                                        <option value="">Pilih Posisi</option>
                                        <?php 
                                                $options = ['Manager', 'Supervisor', 'Staff'];
                                                foreach ($options as $option): 
                                                ?>
                                        <option value="<?= $option ?>"
                                            <?= (isset($edit_data) && $edit_data['posisi'] == $option) ? 'selected' : '' ?>>
                                            <?= $option ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" id="jabatan" name="jabatan" class="form-control"
                                        placeholder="Enter Jabatan"
                                        value="<?= isset($edit_data) ? $edit_data['jabatan'] : set_value('jabatan') ?>" />
                                </div>

                                <div class="mb-3">
                                    <label for="cabang" class="form-label">Cabang</label>
                                    <input type="text" id="cabang" name="cabang" class="form-control"
                                        placeholder="Enter Cabang"
                                        value="<?= isset($edit_data) ? $edit_data['cabang'] : set_value('cabang') ?>" />
                                </div>


                                <div class="mb-3">
                                    <label for="username" class="form-label">Username<span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="username" name="username"
                                        class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter Username"
                                        value="<?= isset($edit_data) ? $edit_data['username'] : set_value('username') ?>" />
                                    <div class="invalid-feedback">
                                        <?= form_error('username') ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password<span class="text-danger">
                                            *</span></label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input type="password"
                                            class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"
                                            placeholder="Enter password" aria-label="Password"
                                            aria-describedby="password-addon" name="password" id="password"
                                            value="<?= isset($edit_data) ? $edit_data['password'] : set_value('password') ?>">
                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= form_error('password') ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Role</label>
                                    <select class="select2form" id="role_id" name="role_id">
                                        <option value="">Pilih Role</option>
                                        <?php foreach ($role as $r): ?>
                                        <option value="<?= $r['id_role']; ?>"
                                            <?= (isset($edit_data) && $edit_data['role_id'] == $r['id_role']) || set_value('role_id') == $r['id_role'] ? 'selected' : '' ?>>
                                            <?= $r['nama_role']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-custom me-2">
                                            <?= isset($edit_data) ? 'Update' : 'Submit' ?>
                                        </button>
                                        <?php if(isset($edit_data)): ?>
                                        <a href="<?= base_url('User') ?>" class="btn btn-light">Batal</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>