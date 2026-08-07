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
                    <li class="breadcrumb-item active">Detail Marketing</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <a href="<?php echo base_url('Team'); ?>"><i class="ti ti-arrow-narrow-left me-1"></i>Back to
                        Team</a>
                </div>
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-xxl avatar-rounded me-3 flex-shrink-0">
                                    <img src="<?= base_url('upload/employee/' . $teams['foto']); ?>" alt="img">
                                    <span class="status online"></span>
                                </div>
                                <div>
                                    <h5 class="mb-1"><?= $teams['nama']; ?></h5>
                                    <p class="mb-2"><?= $teams['jabatan']; ?></p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-soft-primary border-0 me-2"><i
                                                class="ti ti-map-pin me-1"></i><?= $teams['nama_cabang']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-semibold">Personal Information</h6>
                        <div class="border-bottom mb-3 pb-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-mail fs-14"></i>
                                </span>
                                <p class="mb-0"><?php echo $teams['email']; ?>
                                </p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-phone fs-14"></i>
                                </span>
                                <p class="mb-0"><?php echo $teams['no_tlp']; ?></p>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-map-pin fs-14"></i>
                                </span>
                                <p class="mb-0"><?php echo $teams['t_lahir']; ?></p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="avatar avatar-xs bg-light p-0 flex-shrink-0 rounded-circle text-dark me-2">
                                    <i class="ti ti-calendar-exclamation fs-14"></i>
                                </span>
                                <p class="mb-0">
                                    <?= tanggal_indonesia_lengkap(date($teams['tgl_lahir'])); ?></p>
                            </div>
                        </div>
                        <h6 class="mb-3 fw-semibold">Job Information</h6>
                        <ul class="mb-1 pb-1">
                            <li class="row mb-2"><span class="col-6">NIK</span><span
                                    class="col-6 text-dark"><?php echo $teams['nik']; ?></span></li>
                            <li class="row mb-2"><span class="col-6">Cabang</span><span
                                    class="col-6 text-dark"><?php echo $teams['nama_cabang']; ?></span></li>
                            <li class="row mb-2"><span class="col-6">Jabatan</span><span
                                    class="col-6 text-dark"><?php echo $teams['jabatan']; ?></span></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="card mb-3">
                    <div class="card-body pb-0 pt-2">
                        <ul class="nav nav-tabs nav-solid-primary mb-3" role="tablist">
                            <li class="nav-item me-2" role="detail">
                                <a href="#overview" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link active border-3" aria-selected="true" role="tab">
                                    <span class="d-md-inline-block"><i
                                            class="ti ti-alarm-minus me-1"></i>Overview</span>
                                </a>
                            </li>
                            <li class="nav-item me-2" role="detail">
                                <a href="#prospek" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-3"
                                    aria-selected="false" role="tab" tabindex="-1">
                                    <span class="d-md-inline-block"><i class="ti ti-notes me-1"></i>Prospek</span>
                                </a>
                            </li>
                            <li class="nav-item me-2" role="detail">
                                <a href="#client" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3"
                                    aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-phone me-1"></i>Client</span>
                                </a>
                            </li>
                            <li class="nav-item me-2" role="detail">
                                <a href="#project" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3"
                                    aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-file me-1"></i>Project</span>
                                </a>
                            </li>
                            <li class="nav-item me-2" role="detail">
                                <a href="#tab_5" data-bs-toggle="tab" aria-expanded="false" class="nav-link border-3"
                                    aria-selected="false" tabindex="-1" role="tab">
                                    <span class="d-md-inline-block"><i class="ti ti-mail-check me-1"></i>KPI</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content pt-0">

                    <!-- Overview -->
                    <div class="tab-pane active show" id="overview">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="avatar avatar-lg rounded-circle bg-secondary fs-24 flex-shrink-0"><i
                                                        class="ti ti-award"></i></span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Total Prospek</p>
                                                    <h6 class="mb-0"><?= number_format($stats['total_leads']) ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="avatar avatar-lg rounded-circle bg-success fs-24 flex-shrink-0"><i
                                                        class="ti ti-coin"></i></span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Total Estimasi Prospek</p>
                                                    <h6 class="mb-0"> Rp.
                                                        <?= number_format($stats['total_estimasi_lead'], 0, ',', '.') ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="avatar avatar-lg rounded-circle bg-danger fs-24 flex-shrink-0"><i
                                                        class="ti ti-briefcase"></i></span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Total Client</p>
                                                    <h6 class="mb-0"><?= number_format($stats['total_client']) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="avatar avatar-lg rounded-circle bg-success fs-24 flex-shrink-0"><i
                                                        class="ti ti-coin"></i></span>
                                                <div>
                                                    <p class="mb-1 text-truncate">Total Sales</p>
                                                    <h6 class="mb-0">Rp.
                                                        <?= number_format($stats['total_estimasi'], 0, ',', '.') ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Overview -->

                    <!-- Prospek -->
                    <div class="tab-pane fade" id="prospek">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="fw-semibold mb-0">Data Prospek</h5>
                            </div>
                            <div class="card-body">
                                <table id="general-prospek" class="table bordered-table w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
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
                                            <td> <?= $no++; ?></td>
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
                    <!-- /Prospek -->

                    <!-- Client -->
                    <div class="tab-pane fade" id="client">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="fw-semibold mb-0">Data Client</h5>
                            </div>
                            <div class="card-body">
                                <table id="general-client" class="table bordered-table dt-responsive w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Perusahaan</th>
                                            <th>HUT Perusahaan</th>
                                            <th>Nama PIC</th>
                                            <th>No Tlp PIC</th>
                                            <th>HUT PIC</th>
                                            <th>Client Group</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($client as $c): ?>
                                        <tr>
                                            <td class="text-center" style="width: 3%;"> <?= $no++; ?></td>
                                            <td><a href="<?= base_url('Client/View/' . urlencode($c['id_client'])); ?>"
                                                    class="waves-effect waves-light">
                                                    <?= $c['nama_client']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ($c['hut_client'] == '0000-00-00' || empty($c['hut_client'])) : ?>
                                                Belum ada data
                                                <?php else : ?>
                                                <?= tanggal_indonesia_medium(date($c['hut_client'])); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $c['nama_pic']; ?></td>
                                            <td><?= $c['tlp_pic']; ?></td>
                                            <td>
                                                <?php if ($c['hut_pic'] == '0000-00-00' || empty($c['hut_pic'])) : ?>
                                                Belum ada data
                                                <?php else : ?>
                                                <?= tanggal_indonesia_medium(date($c['hut_pic'])); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($c['group'] == 'VIP') : ?>
                                                <span class="badge bg-dark"><?= $c['group']; ?></span>
                                                <?php elseif($c['group'] == 'Gold') : ?>
                                                <span class="badge bg-warning"><?= $c['group']; ?></span>
                                                <?php elseif($c['group'] == 'Silver') : ?>
                                                <span class="badge bg-secondary"><?= $c['group']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Client -->

                    <!-- Project -->
                    <div class="tab-pane fade" id="project">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="fw-semibold mb-0">Data Project</h5>
                            </div>
                            <div class="card-body">
                                <table id="general-project" class="table bordered-table w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Projek</th>
                                            <th>Nama Client</th>
                                            <th>Jenis Projek</th>
                                            <th>Marketing</th>
                                            <th>Tgl Pelaksanaan</th>
                                            <th>Tgl Selesai</th>
                                            <th>Estimasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($project as $p): ?>
                                        <tr>
                                            <td> <?= $no++; ?></td>
                                            <td>
                                                <a href="<?= base_url('Project/View/' . urlencode($p['id_project'])); ?>"
                                                    class="waves-effect waves-light">
                                                    <?= $p['nama_project']; ?>
                                                </a>
                                            </td>
                                            <td><?= $p['nama_client']; ?></td>
                                            <td><?= $p['service']; ?></td>
                                            <td><?= $p['nama']; ?></td>
                                            <td>
                                                <?php if ($p['tgl_pelaksanaan'] == '0000-00-00' || empty($p['tgl_pelaksanaan'])) : ?>
                                                Belum ada data
                                                <?php else : ?>
                                                <?= tanggal_indonesia_medium(date($p['tgl_pelaksanaan'])); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($p['tgl_selesai'] == '0000-00-00' || empty($p['tgl_selesai'])) : ?>
                                                Belum ada data
                                                <?php else : ?>
                                                <?= tanggal_indonesia_medium(date($p['tgl_selesai'])); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>Rp <?= number_format($p['estimasi'], 0, ',', '.'); ?></td>
                                            <td>
                                                <?php if ($p['status_project'] == 'New') : ?>
                                                <span class="badge bg-primary"><?= $p['status_project']; ?></span>
                                                <?php elseif($p['status_project'] == 'Repeat') : ?>
                                                <span class="badge bg-success"><?= $p['status_project']; ?></span>
                                                <?php elseif($p['status_project'] == 'Lost') : ?>
                                                <span class="badge bg-danger"><?= $p['status_project']; ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Project -->

                    <!-- Email -->
                    <div class="tab-pane fade" id="tab_5">
                        <div class="card">
                            <div
                                class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                <h5 class="mb-1">Email</h5>
                                <div class="d-inline-flex align-items-center">
                                    <a href="javascript:void(0);" class="link-primary fw-medium"
                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                        data-bs-custom-class="tooltip-dark"
                                        data-bs-original-title="There are no email accounts configured, Please configured your email account in order to Send/ Create EMails"><i
                                            class="ti ti-circle-plus me-1"></i>Create Email</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card border mb-0">
                                    <div class="card-body pb-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <h6 class="mb-1">Manage Emails</h6>
                                                    <p>You can send and reply to emails directly via this section.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <div class="mb-3">
                                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#create_email">Connect Account</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Email -->

                </div>
                <!-- /Tab Content -->

            </div>
        </div>
    </div>