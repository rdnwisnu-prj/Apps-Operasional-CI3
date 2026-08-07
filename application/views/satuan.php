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
                        <h4 class="mb-sm-0">Fitur</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fitur</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                                <li class="breadcrumb-item active"><?= $subheader;?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Data <?= $header;?></h5>
                        </div>
                        <div class="card-body">
                            <table id="alternative-pagination"
                                class="table nowrap dt-responsive align-middle table-hover bordered-table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Satuan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($satuan as $s): ?>
                                    <tr>
                                        <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                        <td><?= $s['nama_satuan']; ?></td>
                                        <td class="text-center" style="width: 10%;">
                                            <a href="<?= base_url(); ?>Satuan/edit/<?= $s['id_satuan']; ?>"
                                                class="btn btn-icon rounded-pill btn-edit btn-sm waves-effect waves-light"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit menu"><i
                                                    class="ri-edit-box-line"></i>
                                            </a>
                                            <a href="<?= base_url('Satuan/destroy/' . $s['id_satuan']); ?>"
                                                class="btn btn-icon rounded-pill btn-delete btn-sm waves-effect waves-light btn-destroy"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="delete menu"><i class="ri-delete-bin-line"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                                <?php echo $header;?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <form
                                action="<?= isset($edit_data) ? base_url('Satuan/update') : base_url('Satuan/create') ?>"
                                method="post">
                                <?php if(isset($edit_data)): ?>
                                <input type="hidden" name="id_satuan" value="<?= $edit_data['id_satuan'] ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="nama_satuan" class="form-label">Nama Satuan <span class="text-danger">
                                            *</span></label>
                                    <input type="text" id="nama_satuan" name="nama_satuan"
                                        class="form-control  <?= form_error('nama_satuan') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter Nama Satuan"
                                        value="<?= isset($edit_data) ? $edit_data['nama_satuan'] : set_value('nama_satuan') ?>" />

                                    <div class="invalid-feedback">
                                        <?= form_error('nama_satuan') ?>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-custom me-2">
                                            <?= isset($edit_data) ? 'Update' : 'Submit' ?>
                                        </button>
                                        <?php if(isset($edit_data)): ?>
                                        <a href="<?= base_url('Satuan') ?>" class="btn btn-light">Batal</a>
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