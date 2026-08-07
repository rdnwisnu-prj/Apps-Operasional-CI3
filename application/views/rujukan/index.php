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
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader?></li>
                </ol>
            </nav>
        </div>


        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>
                <a href="<?= base_url()?>Rujukan/Store" class="btn btn-custom waves-effect waves-light"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Rujukan
                </a>
            </div>
            <div class="card-body">
                <table id="rujukan" class="table bordered-table w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>PT Lama</th>
                            <th>PT Baru</th>
                            <th>Dokter</th>
                            <th>Tgl Konsul</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Pembayaran</th>
                            <th>Marketing</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($rujukan as $r): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $r['nama']; ?></td>
                            <td><?= $r['nama_client']; ?></td>
                            <td><?= $r['other_client']; ?></td>
                            <td><?= $r['dokter']; ?></td>
                            <td><?= tanggal_indonesia_medium(date($r['tgl_konsul'])); ?></td>
                            <td>Rp <?= number_format($r['harga'], 0, ',', '.'); ?></td>
                            <td><?= $r['lokasi']; ?></td>
                            <td><?= $r['pembayaran']; ?></td>
                            <td><?= $r['marketing']; ?></td>
                            <td class="text-center">
                                <?php 
                                    $can_edit = $r['user_id'] == $current_user_id;
                                    ?>

                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Rujukan/Update/<?= $r['id_rujukan']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses edit">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </span>
                                        </li>
                                        <?php endif; ?>

                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Rujukan/Delete/<?= $r['id_rujukan']; ?>"
                                                class="dropdown-item remove-item-btn btn-destroy">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses hapus">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </span>
                                        </li>
                                        <?php endif; ?>
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