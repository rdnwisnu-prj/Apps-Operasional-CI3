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

            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-auto">
                            <button type="button"
                                class="btn btn-success waves-effect waves-light me-1 btn-barcode-multiple">
                                <i class="ri-barcode-box-line align-bottom me-2"></i> Barcode
                            </button>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <a href="<?= base_url()?>Aset/Store" class="btn btn-custom"> <i
                                        class="ri-add-circle-line align-bottom me-1"></i> Tambah
                                    Aset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Daftar <?= $header?></h4>
                </div>
                <div class="card-body">
                    <table id="asset-keluar-table"
                        class="table nowrap dt-responsive align-middle table-hover bordered-table">
                        <thead>
                            <tr>
                                <th style="width: 2%;"><input type="checkbox" id="checkAll"></th>
                                <th>Foto Aset</th>
                                <th style="width: 5%;">Kode Aset</th>
                                <th>No Accurate</th>
                                <th>Nama Aset</th>
                                <th>SN Aset</th>
                                <th>Merk</th>
                                <th>Tipe</th>
                                <th>Kategori</th>
                                <th style="width: 5%;">Cabang</th>
                                <th class="text-center" style="width: 2%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($aset as $as): ?>
                            <tr>
                                <td><input type="checkbox" class="checkRowOrder" value="<?= $as['kode_aset']; ?>">
                                </td>
                                <td>
                                    <img src="<?= base_url('upload/aset/' . $as['foto']); ?>" alt="Foto" width="100">
                                </td>

                                <td><?= $as['kode_aset']; ?></td>
                                <td><?= $as['no_accurate']; ?></td>
                                <td><?= $as['nama_aset']; ?></td>
                                <td><?= $as['sn_aset']; ?></td>
                                <td><?= $as['tipe']; ?></td>
                                <td><?= $as['merk']; ?></td>
                                <td><?= $as['kategori']; ?></td>
                                <td><?= $as['nama_cabang']; ?></td>
                                <td class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="<?= base_url(); ?>Aset/Detail/<?= $as['kode_aset']; ?>"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-file-info-line align-bottom me-2 text-muted"></i>
                                                    Detail Aset
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>Aset/Maintenance/<?= $as['kode_aset']; ?>"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-tools-fill align-bottom me-2 text-muted"></i>
                                                    Maintenance
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>Aset/Kalibrasi/<?= $as['kode_aset']; ?>"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-focus-3-fill align-bottom me-2 text-muted"></i>
                                                    Kalibrasi
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item barcode-item-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#qrCodeModal<?= $as['kode_aset']; ?>"><i
                                                        class="ri-barcode-box-fill align-bottom me-2 text-muted"></i>Barcode
                                                </button>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>Aset/Update/<?= $as['kode_aset']; ?>"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>Aset/destroy/<?= $as['kode_aset']; ?>"
                                                    class="dropdown-item remove-item-btn btn-destroy">
                                                    <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Delete
                                                </a>
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

    <?php foreach ($aset as $as): ?>
    <div class="modal fade" id="qrCodeModal<?= $as['kode_aset']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Asset - <?= $as['nama_aset']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="border border-dark border-3">
                                    <?php if (!empty($as['kode_aset'])): ?>
                                    <img src="<?= $as['qr_code_path']; ?>" alt="QR Code" width="200">
                                    <?php else: ?>
                                    <span class="text-muted">No Barcode</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <table class="table border-0 mb-0">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="width: 25%;" class="border-2">Kode Aset
                                                    </th>
                                                    <td style="width: 2%;" class="border-2">:</td>
                                                    <td class="border-2"> <?= $as['kode_aset']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="border-2">Nama Aset</th>
                                                    <td class="border-2" :</td>
                                                    <td class="border-2"><?= $as['nama_aset']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="border-2" scope="row">Merk</th>
                                                    <td class="border-2">:</td>
                                                    <td class="border-2"><?= $as['merk']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="border-2" scope="row">Cabang</th>
                                                    <td class="border-2">:</td>
                                                    <td class="border-2"><?= $as['nama_cabang']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="<?= base_url('Aset/cetak_qrcode/'.$as['kode_aset']) ?>"
                            class="btn btn-cakra waves-effect waves-light me-1" target="_blank">
                            <i class="ri-barcode-box-fill align-bottom me-2 text-muted"></i>Cetak QrCode
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>