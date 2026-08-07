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
                        <h4 class="mb-sm-0">Kategori</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Komponen Aset</a></li>
                                <li class="breadcrumb-item active">Kategori</li>
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
                                        <th>Nama Kategori</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($kategori as $k): ?>
                                    <tr>
                                        <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                        <td><?= $k['nama_kategori']; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>Kategori/edit/<?= $k['id_kategori']; ?>"
                                                class="btn btn-icon rounded-pill btn-edit btn-sm waves-effect waves-light"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit menu"><i
                                                    class="ri-edit-box-line"></i>
                                            </a>
                                            <a href="<?= base_url('Kategori/destroy/' . $k['id_kategori']); ?>"
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
                                action="<?= isset($edit_data) ? base_url('Kategori/update') : base_url('Kategori/create') ?>"
                                method="post">
                                <?php if(isset($edit_data)): ?>
                                <input type="hidden" name="id_kategori" value="<?= $edit_data['id_kategori'] ?>">
                                <?php endif; ?>
                                <div class="mb-3">
                                    <label for="nama_kategori" class="form-label">Nama Kategori <span
                                            class="text-danger">
                                            *</span></label>
                                    <input type="text" id="nama_kategori" name="nama_kategori"
                                        class="form-control  <?= form_error('nama_kategori') ? 'is-invalid' : '' ?>"
                                        placeholder="Enter Nama Kategori"
                                        value="<?= isset($edit_data) ? $edit_data['nama_kategori'] : set_value('nama_kategori') ?>" />

                                    <div class="invalid-feedback">
                                        <?= form_error('nama_kategori') ?>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-custom me-2">
                                            <?= isset($edit_data) ? 'Update' : 'Submit' ?>
                                        </button>
                                        <?php if(isset($edit_data)): ?>
                                        <a href="<?= base_url('Kategori') ?>" class="btn btn-light">Batal</a>
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