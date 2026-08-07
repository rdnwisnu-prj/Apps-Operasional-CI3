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


            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
                <?php if ($this->session->flashdata('flash')): ?>
                <?php endif; ?>
            </div>

            <div class="flash-error" data-flashdata="<?= $this->session->flashdata('error'); ?>">
                <?php if ($this->session->flashdata('error')): ?>
                <?php endif; ?>
            </div>

            <div class="flash-warning" data-flashdata="<?= $this->session->flashdata('warning'); ?>">
                <?php if ($this->session->flashdata('warning')): ?>
                <?php endif; ?>
            </div>

            <div class="row mb-4">
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Total Prospek</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                            data-target="<?= isset($status_counts['Total']['current']) ? $status_counts['Total']['current'] : 0 ?>">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <?php 
                                        $is_increase = isset($status_counts['Total']['is_increase']) ? $status_counts['Total']['is_increase'] : true;
                                        $percentage = isset($status_counts['Total']['percentage']) ? $status_counts['Total']['percentage'] : 0;
                                        ?>
                                        <span
                                            class="badge bg-light <?= $is_increase ? 'text-success' : 'text-danger' ?> mb-0">
                                            <i
                                                class="ri-arrow-<?= $is_increase ? 'up' : 'down' ?>-line align-middle"></i>
                                            <?= $percentage ?> %
                                        </span> vs. previous month
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-secondary rounded-circle fs-2 shadow">
                                            <i data-feather="layers" class="text-secondary"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Proses Prospek</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                            data-target="<?= isset($status_counts['Proses Prospek']['current']) ? $status_counts['Proses Prospek']['current'] : 0 ?>">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <?php 
                                        $is_increase = isset($status_counts['Proses Prospek']['is_increase']) ? $status_counts['Proses Prospek']['is_increase'] : true;
                                        $percentage = isset($status_counts['Proses Prospek']['percentage']) ? $status_counts['Proses Prospek']['percentage'] : 0;
                                        ?>
                                        <span
                                            class="badge bg-light <?= $is_increase ? 'text-success' : 'text-danger' ?> mb-0">
                                            <i
                                                class="ri-arrow-<?= $is_increase ? 'up' : 'down' ?>-line align-middle"></i>
                                            <?= $percentage ?> %
                                        </span> vs. previous month
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-warning rounded-circle fs-2 shadow">
                                            <i data-feather="file-text" class="text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Negosiasi</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                            data-target="<?= isset($status_counts['Negosiasi']['current']) ? $status_counts['Negosiasi']['current'] : 0 ?>">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <?php 
                                        $is_increase = isset($status_counts['Negosiasi']['is_increase']) ? $status_counts['Negosiasi']['is_increase'] : true;
                                        $percentage = isset($status_counts['Negosiasi']['percentage']) ? $status_counts['Negosiasi']['percentage'] : 0;
                                        ?>
                                        <span
                                            class="badge bg-light <?= $is_increase ? 'text-success' : 'text-danger' ?> mb-0">
                                            <i
                                                class="ri-arrow-<?= $is_increase ? 'up' : 'down' ?>-line align-middle"></i>
                                            <?= $percentage ?> %
                                        </span> vs. previous month
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                            <i data-feather="message-circle" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Deal</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                            data-target="<?= isset($status_counts['Deal']['current']) ? $status_counts['Deal']['current'] : 0 ?>">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <?php 
                                        $is_increase = isset($status_counts['Deal']['is_increase']) ? $status_counts['Deal']['is_increase'] : true;
                                        $percentage = isset($status_counts['Deal']['percentage']) ? $status_counts['Deal']['percentage'] : 0;
                                        ?>
                                        <span
                                            class="badge bg-light <?= $is_increase ? 'text-success' : 'text-danger' ?> mb-0">
                                            <i
                                                class="ri-arrow-<?= $is_increase ? 'up' : 'down' ?>-line align-middle"></i>
                                            <?= $percentage ?> %
                                        </span> vs. previous month
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-success rounded-circle fs-2 shadow">
                                            <i data-feather="check-circle" class="text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Lost</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                            data-target="<?= isset($status_counts['Lost']['current']) ? $status_counts['Lost']['current'] : 0 ?>">0</span>
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <?php 
                                        $is_increase = isset($status_counts['Lost']['is_increase']) ? $status_counts['Lost']['is_increase'] : true;
                                        $percentage = isset($status_counts['Lost']['percentage']) ? $status_counts['Lost']['percentage'] : 0;
                                        ?>
                                        <span
                                            class="badge bg-light <?= $is_increase ? 'text-success' : 'text-danger' ?> mb-0">
                                            <i
                                                class="ri-arrow-<?= $is_increase ? 'up' : 'down' ?>-line align-middle"></i>
                                            <?= $percentage ?> %
                                        </span> vs. previous month
                                    </p>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-danger rounded-circle fs-2 shadow">
                                            <i data-feather="x-circle" class="text-danger"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>


                    <div class="d-flex align-content-center flex-wrap">
                        <button type="button" class="btn btn-success waves-effect waves-light me-2"
                            data-bs-toggle="modal" data-bs-target="#ImportProspek">
                            <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Import
                            Prospek
                        </button>
                        <a href="<?= base_url()?>Prospek/Store" class="btn btn-custom"> <i
                                class="ri-add-circle-line align-bottom me-1"></i> Add
                            Prospek
                        </a>
                    </div>
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
                                <th>Estimasi</th>
                                <th>Marketing</th>
                                <th>Keterangan</th>
                                <th class="text-center">Action</th>
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
                                    <span class="badge rounded-pill <?= $badge_class; ?>"><?= $status; ?></span>
                                </td>
                                <td>Rp
                                    <?= number_format($l['estimasi_lead'], 0, ',', '.'); ?></td>
                                <td><?= $l['nama']; ?></td>
                                <td><?= $l['catatan']; ?></td>
                                <td class="text-center" style="width: 7%;">
                                    <a href="<?= base_url(); ?>Prospek/Update/<?= $l['id_leads']; ?>"
                                        class="btn btn-icon rounded-pill btn-edit btn-sm waves-effect waves-light edit-leads"><i
                                            class="ri ri-edit-circle-fill align-bottom"></i>
                                    </a>

                                    <a href="<?= base_url(); ?>Prospek/destroy/<?= $l['id_leads']; ?>"
                                        class="btn btn-icon rounded-pill btn-delete btn-sm waves-effect waves-light btn-destroy"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="delete prospek"><i
                                            class="ri ri-delete-bin-fill align-bottom"></i>
                                    </a>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ImportProspek" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Prospek </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importFormProspek">
                        <div class="dropzone" id="dropzone-prospek">
                            <div class="fallback">
                                <input name="file" type="file" required />
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>
                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-3" id="dropzone-preview-prospek">
                            <li class="mt-2" id="dropzone-preview-list-prospek">
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-end">
                            <a href="<?= base_url()?>assets/import/Template.xlsx" download="Template.xlsx"
                                class="btn btn-success waves-effect waves-light me-2">
                                <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Download Template
                            </a>
                            <button type="button" id="submitBtnProspek" class="btn btn-custom"><i
                                    class="ri-checkbox-circle-line label-icon align-middle me-1"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>