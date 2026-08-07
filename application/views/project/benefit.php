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
                    <li class="breadcrumb-item active">Detail Project</li>

                </ol>
            </nav>
        </div>


        <div class="card mb-3">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                        <li class="nav-item">
                            <a class="nav-link "
                                href="<?= base_url('Project/View/' . urlencode($project['id_project'])) ?>"></i>Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                                href="<?= base_url('Project/Benefit/' . urlencode($project['id_project'])) ?>">Benefit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('Project/Crosseling/' . urlencode($project['id_project'])) ?>">Crosseling</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <a href="<?= base_url()?>Project" class="btn btn-custom"> <i
                            class="ri-arrow-left-circle-line align-bottom me-2"></i>Kembali</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom">
                <h5 class="card-title m-0">Daftar Benefit</h5>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Benefit</th>
                            <th>Status</th>
                            <th>Entitas</th>
                            <th>Tanggal Mulai Benefit</th>
                            <th>Tanggal Selesai Benefit</th>
                            <th>Marketing</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($benefit as $b): ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                            <td><?= $b['nama_benefit']; ?></td>
                            <td><?= $b['status_benefit']; ?></td>
                            <td><?= $b['entitas']; ?></td>
                            <td>
                                <?php echo tanggal_indonesia_medium(date($b['tgl_benefit_mulai'])); ?>
                            </td>
                            <td>
                                <?php echo tanggal_indonesia_medium(date($b['tgl_benefit_selesai'])); ?>
                            </td>
                            <td><?= $b['nama']; ?></td>
                            <td><?= $b['keterangan']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>