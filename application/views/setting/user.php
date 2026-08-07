<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $subheader;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader;?></li>
                </ol>
            </nav>
        </div>

        <div class="card border-0">
            <div class="card-body pb-0 pt-0 px-2">
                <ul class="nav nav-tabs nav-bordered nav-bordered-custom">
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Cabang')?>" class="nav-link p-2">
                            Cabang
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Dept')?>" class="nav-link p-2">
                            Departemen
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/User')?>" class="nav-link p-2 active">
                            User
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Menu')?>" class="nav-link p-2">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Role')?>" class="nav-link p-2">
                            Role & Access
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                            <?php echo $subheader;?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Setting/User/update') : base_url('Setting/User/create') ?>"
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
                                <label for="dept_id" class="form-label">Departement</label>
                                <select class="form-control" name="dept_id" id="dept_id">
                                    <option value="">Pilih Departement</option>
                                    <?php foreach ($dept as $d): ?>
                                    <option value="<?= $d['id_dept']; ?>"
                                        <?= (isset($edit_data) && $edit_data['dept_id'] == $d['id_dept']) || set_value('cabang') == $d['id_dept'] ? 'selected' : '' ?>>
                                        <?= $d['nama_dept']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="cabang_id" class="form-label">Cabang</label>
                                <select class="form-control" name="cabang_id" id="cabang_id">
                                    <option value="">Pilih Cabang</option>
                                    <?php foreach ($cabang as $c): ?>
                                    <option value="<?= $c['id_cabang']; ?>"
                                        <?= (isset($edit_data) && $edit_data['cabang_id'] == $c['id_cabang']) || set_value('cabang') == $c['id_cabang'] ? 'selected' : '' ?>>
                                        <?= $c['nama_cabang']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
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
                                <label for="password" class="form-label">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-1">
                                    <input type="password"
                                        class="form-control pe-5 password-input <?= form_error('password') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter password" id="password-input" name="password" value="">
                                    <button
                                        class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon"
                                        type="button" id="password-addon" aria-label="Tampilkan password"
                                        aria-pressed="false">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                <?php if(isset($edit_data)): ?>
                                <div class="form-text">
                                    <p class="mb-0 text-danger"><em>Kosongkan kolom ini jika tidak ingin mengubah
                                            password.</em></p>
                                </div>
                                <?php endif; ?>

                                <div class="invalid-feedback">
                                    <?= form_error('password') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select class="form-control" id="role_id" name="role_id">
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
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Setting/User') ?>" class="btn btn-light w-100">Batal</a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <button type="submit" class="btn btn-custom w-100"><i
                                        class="ri ri-save-line align-bottom me-2"></i>
                                    Submit</button>
                                <?php endif; ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama User</th>
                                    <th>Departemen</th>
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
                                    <td><?= $u['nama_dept']; ?></td>
                                    <td><?= $u['nama_cabang']; ?></td>
                                    <td class="text-center" style="width: 10%;">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Setting/User/edit/<?= $u['id_user']; ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Setting/User/destroy/' . $u['id_user']); ?>">
                                                        <i
                                                            class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>