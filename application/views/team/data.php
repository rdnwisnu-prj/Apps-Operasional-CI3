<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1">Team Marketing</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Team</a>
                        </li>
                        <li class="breadcrumb-item active">Team Marketing</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
            <?php if ($this->session->flashdata('flash')): ?>
            <?php endif; ?>
        </div>


        <div class="card">
            <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Data <?= $header?></h5>
                <a href="<?= base_url()?>Team/Store" class="btn btn-custom"> <i
                        class="tf-icons ti ti-circle-plus me-2"></i>Tambah Marketing</a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Posisi</th>
                            <th>Cabang</th>
                            <th>Email</th>
                            <th>No Tlp</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($teams as $team): ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                            <td><a href="<?= base_url('Team/View/' . urlencode($team['id_user'])); ?>"
                                    class="waves-effect waves-light">
                                    <?= $team['nama']; ?>
                                </a>
                            </td>
                            <td><?= $team['nama_role']; ?></td>
                            <td><?= $team['posisi']; ?></td>
                            <td><?= $team['nama_cabang']; ?></td>
                            <td><?= $team['email']; ?></td>
                            <td><?= $team['no_tlp']; ?></td>
                            <td class="text-center">
                                <a href="<?= base_url(); ?>Team/update/<?= $team['id_user']; ?>"
                                    class="btn btn-icon rounded-pill btn-edit waves-effect waves-light"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit team">
                                    <i class="tf-icons ti ti-edit"></i>
                                </a>
                                <a href="<?= base_url(); ?>Team/destroy/<?= $team['id_user']; ?>"
                                    class="btn btn-icon rounded-pill btn-delete waves-effect waves-light btn-destroy"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="delete team">
                                    <i class="tf-icons ti ti-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>