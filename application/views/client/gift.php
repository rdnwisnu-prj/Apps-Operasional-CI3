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
                            <a class="nav-link "
                                href="<?= base_url('Client/Project/' . urlencode($client['id_client'])) ?>">Project</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link"
                                href="<?= base_url('Client/Complaint/' . urlencode($client['id_client'])) ?>">Complaint
                                & Feedback</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link active"
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
            <div class="card-header bg-transparent border-bottom">
                <h5 class="card-title m-0">Daftar Gift <?php echo $client['nama_client']?></h5>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive w-100">
                    <thead>
                        <tr>
                            <th style="width: 3%;" class="text-center">No</th>
                            <th>Nama Gift</th>
                            <th>Cakra/Konsehat</th>
                            <th>Harga</th>
                            <th>Pelaksana</th>
                            <th>Tgl Pelaksanaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($gift as $g): ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                            <td><?= $g['nama_gift']; ?></td>
                            <td><?= $g['bu_gift']; ?></td>
                            <td>Rp <?= number_format($g['harga_gift'], 0, ',', '.'); ?></td>
                            <td><?= $g['nama']; ?></td>
                            <td><?= tanggal_indonesia_medium(date($g['tgl_gift'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>