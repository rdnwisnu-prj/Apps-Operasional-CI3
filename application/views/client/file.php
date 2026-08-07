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
                            <a class="nav-link"
                                href="<?= base_url('Client/Gift/' . urlencode($client['id_client'])) ?>">Gift</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link active"
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

        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="card-title m-0"><?= isset($edit_data) ? 'Edit' : 'Tambah' ?> File
                            <?php echo $client['nama_client']?></h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Client/updateFile/'.$id_client) : base_url('Client/storeFile/'.$id_client) ?>"
                            method="post" enctype="multipart/form-data">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_file" value="<?= $edit_data['id_file'] ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="nama_file" class="form-label">Nama File<span class="text-danger">
                                        *</span></label>
                                <input type="text"
                                    class="form-control <?= form_error('nama_file') ? 'is-invalid' : '' ?>"
                                    id="nama_file" name="nama_file" placeholder="Nama File"
                                    value="<?= isset($edit_data) ? $edit_data['nama_file'] : set_value('nama_file') ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('nama_file') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="lampiran_file" class="form-label">Lampiran</label>
                                <input class="form-control" type="file" id="lampiran_file" name="lampiran_file">
                                <?php if(isset($edit_data) && $edit_data['lampiran_file']): ?>
                                <p class="fs-7 mt-2">
                                    File saat ini:
                                    <a href="<?= base_url('upload/files/' . $edit_data['lampiran_file']) ?>"
                                        target="_blank">
                                        <?= $edit_data['lampiran_file'] ?>
                                    </a>
                                </p>
                                <?php endif; ?>
                                <p class="fs-12"><em>(Maksimal ukuran 10MB)</em></p>
                            </div>

                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Client/File/' . $id_client) ?>"
                                            class="btn btn-light w-100">Batal</a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <button type="submit" class="btn btn-custom w-100">Submit</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-title m-0">Daftar File <?php echo $client['nama_client']?></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="general"
                                class="table table-hover table-striped bordered-table dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">No</th>
                                        <th style="width: 25%;">Nama File</th>
                                        <th style="width: 25%;">Lampiran</th>
                                        <th style="width: 15%;">Upload By</th>
                                        <th style="width: 15%;">Tanggal Upload</th>
                                        <th class="text-center" style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($file)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="ri-file-list-3-line fs-1 d-block mb-2"></i>
                                            Belum ada file yang diupload
                                        </td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($file as $f): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-xs me-2 flex-shrink-0">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded">
                                                        <i class="ri-file-text-line"></i>
                                                    </span>
                                                </div>
                                                <span class="fw-medium"><?= htmlspecialchars($f['nama_file']); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($f['lampiran_file']): ?>
                                            <?php 
                                                    $ext = pathinfo($f['lampiran_file'], PATHINFO_EXTENSION);
                                                    $icon = 'ri-file-line';
                                                    $badge_class = 'bg-primary';
                                                    if(in_array($ext, ['pdf'])) { $icon = 'ri-file-pdf-line'; $badge_class = 'bg-danger'; }
                                                    elseif(in_array($ext, ['doc', 'docx'])) { $icon = 'ri-file-word-line'; $badge_class = 'bg-info'; }
                                                    elseif(in_array($ext, ['xls', 'xlsx'])) { $icon = 'ri-file-excel-line'; $badge_class = 'bg-success'; }
                                                    elseif(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) { $icon = 'ri-image-line'; $badge_class = 'bg-warning'; }
                                                    elseif(in_array($ext, ['zip', 'rar'])) { $icon = 'ri-file-zip-line'; $badge_class = 'bg-secondary'; }
                                                ?>
                                            <span class="badge <?= $badge_class ?> rounded-pill">
                                                <i class="<?= $icon ?> me-1"></i><?= strtoupper($ext) ?>
                                            </span>
                                            <small class="d-block text-muted mt-1 text-truncate"
                                                style="max-width: 200px;" title="<?= $f['lampiran_file'] ?>">
                                                <?= $f['lampiran_file'] ?>
                                            </small>
                                            <?php else: ?>
                                            <span class="badge bg-light text-muted">
                                                <i class="ri-close-circle-line me-1"></i>Tidak ada lampiran
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span
                                                class="text-body"><?= isset($f['nama']) ? htmlspecialchars($f['nama']) : '-'; ?></span>
                                        </td>
                                        <td>
                                            <?php if(isset($f['created_at']) && $f['created_at']): ?>
                                            <span class="text-muted">
                                                <i
                                                    class="ri-calendar-line me-1"></i><?= date('d M Y', strtotime($f['created_at'])); ?>
                                            </span>
                                            <small
                                                class="d-block text-muted"><?= date('H:i', strtotime($f['created_at'])); ?>
                                                WIB</small>
                                            <?php else: ?>
                                            <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <?php if($f['lampiran_file']): ?>
                                                <a href="<?= base_url('Client/downloadFile/' . $id_client . '/' . $f['id_file']); ?>"
                                                    class="btn btn-icon rounded-pill btn-sm btn-cakra waves-effect waves-light"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Download File">
                                                    <i class="ri-file-download-line"></i>
                                                </a>
                                                <?php else: ?>
                                                <button
                                                    class="btn btn-icon rounded-pill btn-sm btn-light waves-effect waves-light"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Tidak ada file" disabled>
                                                    <i class="ri-file-download-line"></i>
                                                </button>
                                                <?php endif; ?>

                                                <a href="<?= base_url('Client/editFile/' . $id_client . '/' . $f['id_file']); ?>"
                                                    class="btn btn-icon rounded-pill btn-sm btn-edit waves-effect waves-light"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit File">
                                                    <i class="ri-edit-circle-fill"></i>
                                                </a>
                                                <a href="<?= base_url('Client/destroyFile/' . $id_client . '/' . $f['id_file']); ?>"
                                                    class="btn btn-icon rounded-pill btn-sm btn-delete waves-effect waves-light btn-destroy"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus File">
                                                    <i class="ri-delete-bin-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>