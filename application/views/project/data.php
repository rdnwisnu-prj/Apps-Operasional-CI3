<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Project</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Data Project</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar Project</h5>
                <a href="<?= base_url()?>Project/Store" class="btn btn-custom"> <i
                        class="tf-icons ti ti-circle-plus me-2"></i>Add Data</a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Projek</th>
                            <th>Nama Client</th>
                            <th>Jenis Projek</th>
                            <th>Marketing</th>
                            <th>Tgl Pelaksanaan</th>
                            <th>Estimasi</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($project as $p): ?>
                        <tr>
                            <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                            <td><a href="<?= base_url('Project/View/' . urlencode($p['id_project'])); ?>"
                                    class="waves-effect waves-light">
                                    <?= $p['nama_project']; ?>
                                </a>
                            </td>
                            <td><?= $p['nama_client']; ?></td>
                            <td><?= $p['service']; ?></td>
                            <td><?= $p['nama']; ?></td>
                            <td><?= tanggal_indonesia_medium(date($p['tgl_pelaksanaan'])); ?></td>
                            <td><?= $p['estimasi']; ?></td>
                            <td><?= $p['status_project']; ?></td>
                            <td class="text-center" style="width: 5%;">
                                <a class="btn btn-outline-warning btn-sm edit-project me-1" title="edit"
                                    data-id-project="<?= $p['id_project']; ?>" data-bs-toggle="modal"
                                    data-bs-target="#editProject">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="<?= base_url(); ?>Project/destroy/<?= $p['id_project']; ?>"
                                    class="btn btn-outline-danger btn-sm btn-destroy" title="hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>