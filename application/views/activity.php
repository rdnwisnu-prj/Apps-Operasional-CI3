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
                        <h4 class="mb-sm-0"><?= $header?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header?></a></li>
                                <li class="breadcrumb-item active"><?= $subheader?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h4>
                    <div class="flex-shrink-0">
                        <a href="<?= base_url()?>Activity/Store" class="btn btn-custom"> <i
                                class="ri-add-circle-line align-bottom me-1"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="alternative-pagination"
                        class="table dt-responsive align-middle table-hover bordered-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Aktifitas</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Kendala</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($activity as $act): ?>
                            <tr>
                                <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                <td><?= $act['nama']; ?></td>
                                <td><?= $act['aktifitas']; ?></td>
                                <td><?= tanggal_indonesia_medium(date($act['tgl_aktifitas'])); ?>
                                </td>
                                <td><?= format_jam_indonesia($act['jam_aktifitas']);?> </td>
                                <td><?= $act['kendala']; ?></td>
                                <td><?= $act['lokasi']; ?></td>
                                <td><?= $act['prioritas']; ?></td>
                                <td><?= $act['keterangan']; ?></td>
                                <td class="text-center">
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="<?= base_url(); ?>Activity/update/<?= $act['id_activity']; ?>"
                                                    class="dropdown-item edit-item-btn"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= base_url(); ?>Activity/destroy/<?= $act['id_activity']; ?>"
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