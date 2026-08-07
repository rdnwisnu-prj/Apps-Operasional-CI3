<div class="page-wrapper">
    <script>
    window.prospekController = 'ProspekOutlet';
    </script>

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
                    <li class="breadcrumb-item"><a href="<?= base_url('ProspekOutlet') ?>"><?= $subheader?></a>
                    </li>
                    <li class="breadcrumb-item active">Detail Prospek</li>
                </ol>
            </nav>
        </div>

        <div class="mb-3">
            <a href="<?= base_url()?>ProspekOutlet"><i class="ti ti-arrow-narrow-left me-1"></i>Back to
                Prospek</a>
        </div>

        <div class="row">
            <div class="col-xl-4 col-lg-5 order-1 order-md-0">
                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom">
                        <h5 class="card-title">
                            <i class="ri-user-line align-bottom me-2"></i> Detail Prospek
                        </h5>
                        <div class="dropdown table-action">
                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item"
                                    href="<?= base_url('ProspekOutlet/Update/' . $leads['id_leads']) ?>"><i
                                        class="ti ti-edit text-blue"></i> Update Prospek</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 mb-3">
                        <div>
                            <div class="flex-shrink-0 avatar-md mx-auto">
                                <div class="avatar-title bg-light rounded">
                                    <i class="ri-building-2-line fs-1 text-primary"></i>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3"><?= $leads['nama_client']?></h5>
                                <?php
                                    $status = $leads['status_lead'];
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
                                <span class="badge <?= $badge_class ?>"><?= $status ?></span>
                            </div>
                            <div class="mt-4">
                                <ul>
                                    <li class="row mb-2"><span class="col-6">Alamat Perusahaan</span><span
                                            class="col-6 text-dark"><?= $leads['alamat_client'] ?: '-' ?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0"><i class="ri-file-text-line me-2"></i>Catatan</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><?= $leads['catatan'] ?: 'Tidak ada catatan' ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 order-0 order-md-1">
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary text-white rounded-2 fs-2 shadow">
                                            <i class="ti ti-briefcase fs-16 text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Service</p>
                                        <h5 class="fs-5 mb-3"><?= $leads['service'] ?: '-' ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success text-white rounded-2 fs-2 shadow">
                                            <i class="ti ti-coin fs-16 text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Estimasi Nilai</p>
                                        <h5 class="fs-5 mb-3">Rp
                                            <?= number_format($leads['estimasi_lead'], 0, ',', '.'); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning text-white rounded-2 fs-2 shadow">
                                            <i class="ti ti-calendar-event fs-16 text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Periode</p>
                                        <h5 class="fs-5 mb-3">
                                            <?php if ($leads['periode'] && $leads['periode'] != '0000-00-00'): ?>
                                            <?= tanggal_indonesia_medium($leads['periode']); ?>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0"><i class="ri-information-line me-2"></i>Informasi PIC</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li class="row mb-2"><span class="col-6">Nama PIC</span><span
                                    class="col-6 text-dark"><?= $leads['nama_pic'] ?: '-' ?></span></li>
                            <li class="row mb-2"><span class="col-6">No. HP PIC</span><span
                                    class="col-6 text-dark"><?= $leads['tlp_pic'] ?: '-' ?></span></li>
                            <li class="row mb-2"><span class="col-6">Email PIC</span><span
                                    class="col-6 text-dark"><?= $leads['email_pic'] ?: '-' ?></span></li>
                        </ul>
                    </div>
                </div>

                <!-- PIC Tambahan -->
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="ri-user-add-line me-2"></i>PIC Tambahan</h5>
                        <button type="button" class="btn btn-sm btn-custom" data-bs-toggle="modal"
                            data-bs-target="#addPicModal">
                            <i class="ri-add-line me-1"></i> Tambah PIC
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($pic_leads)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Nama PIC</th>
                                        <th>No. HP</th>
                                        <th>Email</th>
                                        <th>HUT PIC</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($pic_leads as $pic): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $pic['nama_pic']; ?></td>
                                        <td><?= $pic['no_pic']; ?></td>
                                        <td><?= $pic['email_pic'] ?: '-'; ?></td>
                                        <td>
                                            <?php if ($pic['hut_pic'] && $pic['hut_pic'] != '0000-00-00'): ?>
                                            <?= tanggal_indonesia_medium($pic['hut_pic']); ?>
                                            <?php else: ?>
                                            -
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-soft-primary btn-edit-pic-lead"
                                                data-id="<?= $pic['id_pl']; ?>" data-bs-toggle="modal"
                                                data-bs-target="#editPicModal">
                                                <i class="ri-pencil-line"></i>
                                            </button>
                                            <a href="<?= base_url('ProspekOutlet/DeletePic/' . $pic['id_pl']); ?>"
                                                class="btn btn-sm btn-soft-danger btn-destroy">
                                                <i class="ri-delete-bin-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="ri-user-line fs-1 mb-2 d-block"></i>
                            <p class="mb-0">Belum ada PIC tambahan</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add PIC -->
    <div class="modal fade" id="addPicModal" tabindex="-1" aria-labelledby="addPicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPicModalLabel">Tambah PIC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddPicLeads">
                    <input type="hidden" name="leads_id" value="<?= $leads['id_leads']; ?>">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_nama_pic" class="form-label">Nama PIC <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_nama_pic" name="nama_pic"
                                placeholder="Masukkan nama PIC" required>
                            <div class="invalid-feedback" id="add_nama_pic_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="add_no_pic" class="form-label">No. HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_no_pic" name="no_pic"
                                placeholder="Masukkan no HP" required>
                            <div class="invalid-feedback" id="add_no_pic_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="add_email_pic" class="form-label">Email</label>
                            <input type="email" class="form-control" id="add_email_pic" name="email_pic"
                                placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="add_hut_pic" class="form-label">HUT PIC</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="add_hut_pic" name="hut_pic"
                                    placeholder="Pilih tanggal">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit PIC -->
    <div class="modal fade" id="editPicModal" tabindex="-1" aria-labelledby="editPicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPicModalLabel">Edit PIC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditPicLeads">
                    <input type="hidden" id="edit_id_pl" name="id_pl">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_pic" class="form-label">Nama PIC <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_pic" name="nama_pic"
                                placeholder="Masukkan nama PIC" required>
                            <div class="invalid-feedback" id="edit_nama_pic_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_pic" class="form-label">No. HP <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_no_pic" name="no_pic"
                                placeholder="Masukkan no HP" required>
                            <div class="invalid-feedback" id="edit_no_pic_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email_pic" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email_pic" name="email_pic"
                                placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_hut_pic" class="form-label">HUT PIC</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="edit_hut_pic" name="hut_pic">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line me-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>