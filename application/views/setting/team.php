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
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $subheader?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                            <?php echo $header;?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Setting/Team/update') : base_url('Setting/Team/create') ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_team" value="<?= $edit_data['id_team'] ?>">
                            <?php endif; ?>



                            <div class="mb-3">
                                <label for="nama_team" class="form-label">Nama Team <span class="text-danger">
                                        *</span></label>
                                <input type="text" id="nama_team" name="nama_team"
                                    class="form-control  <?= form_error('nama_team') ? 'is-invalid' : '' ?>"
                                    placeholder="Enter Nama Team"
                                    value="<?= isset($edit_data) ? $edit_data['nama_team'] : set_value('nama_team') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('nama_team') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="kota_cabang" class="form-label">SPV</label>
                                <select class="form-control select2" data-toggle="select2" id="id_spv" name="id_spv">
                                    <option value="">Pilih SPV</option>
                                    <?php foreach ($user as $u): ?>
                                    <option value="<?= $u['id_user']; ?>"
                                        <?= (isset($edit_data) && $edit_data['id_spv'] == $u['id_user']) || set_value('id_spv') == $u['id_user'] ? 'selected' : '' ?>>
                                        <?= $u['nama']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5"
                                    placeholder="Input Deskripsi"><?= isset($edit_data) ? $edit_data['deskripsi'] : set_value('deskripsi') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Setting/Team') ?>" class="btn btn-light w-100">Batal</a>
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
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data <?= $header;?></h5>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Team</th>
                                    <th>SPV</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($team as $t): ?>
                                <tr>
                                    <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $t['nama_team']; ?></td>
                                    <td><?= $t['nama']; ?></td>
                                    <td class="text-center" style="width: 5%;">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Setting/Team/edit/<?= $t['id_team']; ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Setting/Team/destroy/' . $t['id_team']); ?>">
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