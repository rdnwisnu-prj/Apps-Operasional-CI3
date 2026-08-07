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
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader?></a></li>
                    <li class="breadcrumb-item active">Detail Perusahaan</li>
                </ol>
            </nav>
        </div>

        <div class="card mb-3">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                        <li class="nav-item me-2">
                            <a class="nav-link "
                                href="<?= base_url('Client/View/' . urlencode($client['id_client'])) ?>"></i>Overview</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link active"
                                href="<?= base_url('Client/Project/' . urlencode($client['id_client'])) ?>">Project</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link"
                                href="<?= base_url('Client/Complaint/' . urlencode($client['id_client'])) ?>">Complaint
                                & Feedback</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link"
                                href="<?= base_url('Client/Gift/' . urlencode($client['id_client'])) ?>">Gift</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link"
                                href="<?= base_url('Client/File/' . urlencode($client['id_client'])) ?>">File</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <a href="<?= base_url()?>Client" class="btn btn-custom"> <i
                            class="ri-arrow-left-circle-line align-bottom me-2"></i>Kembali</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">Daftar Projek <?php echo $client['nama_client']?></h5>
                <a href="<?= base_url()?>Project/Store/<?= $client['id_client']; ?>" class="btn btn-custom"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Tambah Project
                </a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive  w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Projek</th>
                            <th style="width: 10%;">Layanan</th>
                            <th style="width: 15%;">Tgl Pelaksanaan</th>
                            <th style="width: 15%;">Tgl Selesai</th>
                            <th>Jumlah Karyawan</th>
                            <th>Estimasi</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Marketing</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($project)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($project as $proj): ?>
                        <tr>
                            <td class="text-center" style="width: 3%;"><?= $no++; ?></td>
                            <td>
                                <a href="<?= base_url('Project/View/' . urlencode($proj['id_project'])); ?>"
                                    class="waves-effect waves-light">
                                    <?= $proj['nama_project']; ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($proj['service']); ?></td>
                            <td>
                                <?php if ($proj['tgl_pelaksanaan'] == '0000-00-00' || empty($proj['tgl_pelaksanaan'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($proj['tgl_pelaksanaan'])); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($proj['tgl_selesai'] == '0000-00-00' || empty($proj['tgl_selesai'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($proj['tgl_selesai'])); ?>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($proj['jumlah_karyawan']); ?></td>
                            <td>Rp <?= number_format($proj['estimasi'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($proj['project']); ?></td>
                            <td>
                                <?php if ($proj['status_project'] == 'New') : ?>
                                <span class="badge bg-info"><?= $proj['status_project']; ?></span>
                                <?php elseif($proj['status_project'] == 'Repeat') : ?>
                                <span class="badge bg-success"><?= $proj['status_project']; ?></span>
                                <?php elseif($proj['status_project'] == 'Lost') : ?>
                                <span class="badge bg-danger"><?= $proj['status_project']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($proj['nama']); ?></td>
                            <td class="text-center">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?= base_url(); ?>Project/Update/<?= $proj['id_project']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url(); ?>Project/destroy/<?= $proj['id_project']; ?>"
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
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data project untuk client ini</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>