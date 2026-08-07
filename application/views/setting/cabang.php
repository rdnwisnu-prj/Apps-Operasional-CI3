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
                        <a href="<?= base_url('Setting/Cabang')?>" class="nav-link p-2 active">
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
                            action="<?= isset($edit_data) ? base_url('Setting/Cabang/update') : base_url('Setting/Cabang/create') ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_cabang" value="<?= $edit_data['id_cabang'] ?>">
                            <?php endif; ?>



                            <div class="mb-3">
                                <label for="nama_cabang" class="form-label">Nama Cabang <span class="text-danger">
                                        *</span></label>
                                <input type="text" id="nama_cabang" name="nama_cabang"
                                    class="form-control  <?= form_error('nama_cabang') ? 'is-invalid' : '' ?>"
                                    placeholder="Enter Nama Cabang"
                                    value="<?= isset($edit_data) ? $edit_data['nama_cabang'] : set_value('nama_cabang') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('nama_cabang') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Setting/Cabang') ?>"
                                            class="btn btn-light w-100">Batal</a>
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
                                    <th>Nama Cabang</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($cabang as $cab): ?>
                                <tr>
                                    <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $cab['nama_cabang']; ?></td>
                                    <td class="text-center" style="width: 5%;">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Setting/Cabang/edit/<?= $cab['id_cabang']; ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Setting/Cabang/destroy/' . $cab['id_cabang']); ?>">
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