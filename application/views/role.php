<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Role Dashboard</h4>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">Role</li>
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
                            <h5 class="card-title mb-0">Data Role</h5>
                        </div>
                        <div class="card-body">
                            <table id="general"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Role</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($role as $r): ?>
                                    <tr>
                                        <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                        <td><?= $r['nama_role']; ?></td>
                                        <td class="text-center" style="width: 10%;">
                                            <a href="<?= base_url(); ?>Role/edit/<?= $r['id_role']; ?>"
                                                class="btn btn-outline-warning btn-sm edit me-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                <i class="mdi mdi-square-edit-outline"></i>
                                            </a>
                                            <a href="<?= base_url(); ?>Role/destroy/<?= $r['id_role']; ?>"
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
                            <h5 class="card-title mb-0"><?= isset($edit_data) ? 'Edit' : 'Tambah' ?> Data Role</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= isset($edit_data) ? base_url('Role/update') : base_url('Role/create') ?>"
                                method="post">
                                <?php if(isset($edit_data)): ?>
                                <input type="hidden" name="id_role" value="<?= $edit_data['id_role'] ?>">
                                <?php endif; ?>


                                <div class="mb-3">
                                    <label for="nama_role" class="form-label">Nama Role</label>
                                    <input type="text" id="nama_role" name="nama_role"
                                        class="form-control <?= form_error('nama_role') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter Nama Role"
                                        value="<?= isset($edit_data) ? $edit_data['nama_role'] : set_value('nama_role') ?>" />
                                    <div class="invalid-feedback">
                                        <?= form_error('nama_role') ?>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-custom me-2">
                                            <?= isset($edit_data) ? 'Update' : 'Submit' ?>
                                        </button>
                                        <?php if(isset($edit_data)): ?>
                                        <a href="<?= base_url('Role') ?>" class="btn btn-light">Batal</a>
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