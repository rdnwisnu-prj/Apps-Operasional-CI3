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
                    <li class="breadcrumb-item"><?= $header;?></li>
                    <li class="breadcrumb-item">Pengaturan</li>
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
                        <a href="<?= base_url('Setting/User')?>" class="nav-link p-2">
                            User
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Menu')?>" class="nav-link p-2">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Role')?>" class="nav-link p-2 active">
                            Role & Access
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Data <?= $subheader;?></h5>
                        <button type="button" class="btn btn-cakra waves-effect waves-light" data-bs-toggle="modal"
                            data-bs-target="#addRole">
                            <i class="ri-add-circle-line align-bottom me-1"></i> Add
                            Role
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
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
                                <?php foreach ($roles as $role): ?>
                                <tr>
                                    <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $role['nama_role']; ?></td>
                                    <td class="text-center" style="width: 10%;">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><button class="dropdown-item btn-access-role"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="access role" data-role-id="<?= $role['id_role']; ?>"
                                                        data-role-name="<?= $role['nama_role']; ?>"><i
                                                            class="ri-git-repository-private-line align-bottom me-2 text-muted"></i>
                                                        Access</button>
                                                </li>
                                                <li><a class="dropdown-item edit-role" href="javascript:void(0);"
                                                        data-id-role="<?= $role['id_role']; ?>"
                                                        data-bs-placement="bottom" title="edit role">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Setting/Role/destroy/' . $role['id_role']); ?>">
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
            <div class="col-12 col-lg-6 d-none" id="accessCard">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-0" id="roleTitle">Nama Role </h6>
                            </div>
                            <div class="flex-shrink-0">
                                <ul class="list-inline card-toolbar-menu d-flex align-items-center mb-0">
                                    <li class="list-inline-item">
                                        <button type="button" class="btn-close fs-10 align-middle"></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="accessList">
                        <div class="text-center py-4">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-custom" id="saveAccess">
                                <i class="ri-checkbox-circle-line align-bottom me-1"></i> Save Access
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRole" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRole">Tambah Role Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddRole" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="nama_role" class="col-md-2 col-form-label">Nama Role</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Role" id="nama_role"
                                    name="nama_role">
                                <div class="invalid-feedback" id="nama_role_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line label-icon align-middle"></i> Close
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="editRole" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRole">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditRole" method="post" action="<?= base_url('Setting/Role/update'); ?>">
                    <input type="hidden" name="id_role" id="edit_id_role">
                    <div class="modal-body">
                        <div class="row">
                            <label for="edit_nama_role" class="col-md-2 col-form-label">Nama Role</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Role" id="edit_nama_role"
                                    name="nama_role">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line label-icon align-middle"></i> Close
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle"></i> Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>