<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <?php if ($this->session->flashdata('flash')): ?>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
            <?php endif; ?>

            <div class="profile-foreground position-relative mx-n4 mt-n4">
                <div class="profile-wid-bg">
                    <img src="<?= base_url()?>assets/img/cakra.jpg" alt="" class="profile-wid-img" />
                </div>
            </div>

            <div class="pt-4 mb-4 mb-lg-3 pb-lg-4">
                <div class="row g-4">
                    <div class="col-auto">
                        <div class="avatar-lg">
                            <img src="<?= base_url('upload/employee/' . $teams['foto']); ?>" alt="user-img"
                                class="img-thumbnail rounded-circle" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-2">
                            <h3 class="text-white mb-1"><?= $teams['nama']; ?></h3>
                            <p class="text-white-75"><?= $teams['jabatan']; ?> - <?= $teams['nama_posisi']; ?> </p>
                            <div class="hstack text-white-50 gap-1">
                                <div class="me-2"><i
                                        class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i><?php echo $teams['nama_cabang']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex">
                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= base_url('Team/View/' . urlencode($teams['id_user'])) ?>"><i
                                        class="ti-sm ti ti-user-check me-1_5"></i> Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active"
                                    href="<?= base_url('Team/Leads/' . urlencode($teams['id_user'])) ?>"><i
                                        class="ti-sm ti ti-stack-back me-1_5"></i>
                                    Leads/Prospek</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= base_url('Team/Client/' . urlencode($teams['id_user'])) ?>"><i
                                        class="ti-sm ti ti-briefcase-2 me-1_5"></i>
                                    Client</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= base_url('Team/Project/' . urlencode($teams['id_user'])) ?>"><i
                                        class="ti-sm ti ti-layout-grid me-1_5"></i> Projects</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?= base_url('Team/Kpi/' . urlencode($teams['id_user'])) ?>"><i
                                        class="ti-sm ti ti-brand-speedtest me-1_5"></i> KPI</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content pt-4">
                        <div class="tab-pane active" id="overview-tab" role="tabpanel">
                            <div class="row">
                                <div class="col-xxl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <small class="card-text text-uppercase text-muted small">Personal
                                                Information</small>
                                            <dl class="row mt-2">
                                                <dt class="col-sm-5 mb-3"><i class="ti ti-user ti-lg"></i><span
                                                        class="fw-medium mx-2">Nama
                                                        Lengkap</span></dt>
                                                <dd class="col-sm-7">: <?php echo $teams['nama']; ?></dd>

                                                <dt class="col-sm-5 mb-3"><i class="ti ti-phone-call ti-lg"></i><span
                                                        class="fw-medium mx-2">No
                                                        Tlp</span></dt>
                                                <dd class="col-sm-7">
                                                    : <?php echo $teams['no_tlp']; ?>
                                                </dd>

                                                <dt class="col-sm-5 mb-3"> <i class="ti ti-mail ti-lg"></i><span
                                                        class="fw-medium mx-2">Email</span></dt>
                                                <dd class="col-sm-7">
                                                    : <?php echo $teams['email']; ?>
                                                </dd>
                                            </dl>
                                            <small class="card-text text-uppercase text-muted small">Job
                                                Information</small>

                                            <dl class="row mt-2">
                                                <dt class="col-sm-5 mb-3">
                                                    <i class="ti ti-id-badge-2 ti-lg"></i><span
                                                        class="fw-medium mx-2">NIK</span>
                                                </dt>
                                                <dd class="col-sm-7">: <?php echo $teams['nik']; ?></dd>

                                                <dt class="col-sm-5 mb-3">
                                                    <i class="ti ti-hierarchy ti-lg"></i><span
                                                        class="fw-medium mx-2">Cabang</span>
                                                </dt>
                                                <dd class="col-sm-7">: <?php echo $teams['nama_cabang']; ?></dd>

                                                <dt class="col-sm-5 mb-3">
                                                    <i class="ti ti-user-square ti-lg"></i><span
                                                        class="fw-medium mx-2">Jabatan</span>
                                                </dt>
                                                <dd class="col-sm-7">: <?php echo $teams['jabatan']; ?></dd>

                                                <dt class="col-sm-5 mb-3">
                                                    <i class="ti ti-scan-position ti-lg"></i><span
                                                        class="fw-medium mx-2">Posisi</span>
                                                </dt>
                                                <dd class="col-sm-7">: <?php echo $teams['nama_posisi']; ?></dd>

                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xxl-9">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $header?></h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="general" class="table bordered-table dt-responsive w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">No</th>
                                                        <th>Nama Perusahaan</th>
                                                        <th>Nama PIC</th>
                                                        <th>No Tlp PIC</th>
                                                        <th>Email PIC</th>
                                                        <th>Status</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($leads as $l): ?>
                                                    <tr>
                                                        <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                                                        <td><?= $l['nama_client']; ?></td>
                                                        <td><?= $l['nama_pic']; ?></td>
                                                        <td><?= $l['tlp_pic']; ?></td>
                                                        <td><?= $l['email_pic']; ?></td>
                                                        <td>
                                                            <?php
                                                            $status = $l['status_lead'];
                                                            $badge_class = '';
                                                            
                                                            if ($status == 'Proses Prospek') {
                                                                $badge_class = 'bg-warning';
                                                            } elseif ($status == 'Negosiasi') {
                                                                $badge_class = 'bg-info';
                                                            } elseif ($status == 'Deal') {
                                                                $badge_class = 'bg-success';
                                                            } elseif ($status == 'Lost') {
                                                                $badge_class = 'bg-danger';
                                                            } else {
                                                                $badge_class = 'bg-secondary';
                                                            }
                                                            ?>
                                                            <span
                                                                class="badge rounded-pill <?= $badge_class; ?>"><?= $status; ?></span>
                                                        </td>
                                                        <td><?= $l['catatan']; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>