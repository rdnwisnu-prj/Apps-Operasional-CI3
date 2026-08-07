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
                <a href="<?= base_url()?>Rekanan/Store" class="btn btn-custom waves-effect waves-light"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Rekanan
                </a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Rekanan</th>
                            <th>Alamat Rekanan</th>
                            <th>Kota Rekanan</th>
                            <th>Telepon Rekanan</th>
                            <th>Invoice</th>
                            <th>Owner</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($rekanan as $r): ?>
                        <tr>
                            <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                            <td style="width: 15%;"><?= $r['nama_rekanan']; ?></td>
                            <td class="text-wrap" style="width: 20%;"><?= $r['alamat_rekanan']; ?></td>
                            <td><?= $r['kota_rekanan']; ?></td>
                            <td><?= $r['tlp_rekanan']; ?></td>
                            <td>Rp <?= number_format($r['omset'], 0, ',', '.'); ?></td>
                            <td><?= $r['nama']; ?></td>
                            <td class="text-center" style="width: 5%;">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?= base_url()?>Rekanan/Update/<?= $r['id_rekanan']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?= base_url()?>Rekanan/Delete/<?= $r['id_rekanan']; ?>"
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