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

        <div class="card mb-6">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                        <li class="nav-item me-2">
                            <a class="nav-link active"
                                href="<?= base_url('Client/View/' . urlencode($client['id_client'])) ?>"></i>Overview</a>
                        </li>

                        <li class="nav-item me-2">
                            <a class="nav-link"
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

        <div class="row">
            <div class="col-xl-4 col-lg-5 order-1 order-md-0">
                <div class="card">
                    <div class="card-header d-flex justify-content-between border-bottom">
                        <h5 class="card-title">
                            <i class="ri-briefcase-3-line align-bottom me-2"></i> Detail Perusahaan
                        </h5>
                        <div class="dropdown table-action">
                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#editClient">
                                    <i class="ti ti-edit text-blue"></i> Update Client
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div>
                            <div class="flex-shrink-0 avatar-md mx-auto">
                                <div class="avatar-title bg-light rounded">
                                    <img src="<?= base_url('uploads/client/' . $client['logo_client']); ?>" alt=""
                                        height="50" />
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3"><?= $client['nama_client']?></h5>
                            </div>
                            <div class="mt-4">
                                <ul>
                                    <li class="row mb-2"><span class="col-4">Nama PIC</span><span
                                            class="col-8 text-dark"><?= $client['nama_pic'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">Sektor Perusahaan</span><span
                                            class="col-8 text-dark"><?= $client['sektor'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">Group Perusahaan</span><span
                                            class="col-8 text-dark"><?= $client['group'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">Status Perusahaan</span><span
                                            class="col-8 text-dark"><?= $client['status'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">Email</span><span
                                            class="col-8 text-dark"><?= $client['email_pic'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">No. HP</span><span
                                            class="col-8 text-dark"><?= $client['tlp_pic'] ?: '-' ?></span>
                                    </li>
                                    <li class="row mb-2"><span class="col-4">Alamat</span><span
                                            class="col-8 text-dark"><?= $client['alamat_client'] ?: '-' ?></span>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-7 order-0 order-md-1">
                <div class="row">
                    <div class="col-xl-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-primary text-white rounded-2 fs-2 shadow">
                                            <i class="ti ti-briefcase fs-16 text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Total Projects</p>
                                        <h4 class="fs-4 mb-3"><?= number_format($total_project) ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success text-white rounded-2 fs-2 shadow">
                                            <i class="ti ti-coin fs-16 text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-medium text-muted mb-3">Total Revenue</p>
                                        <h4 class="fs-4 mb-3">Rp.
                                            <?= number_format($total_revenue, 0, ',', '.'); ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><i class="ri-user-add-line me-2"></i>PIC Tambahan</h5>
                                <button type="button" class="btn btn-sm btn-custom" data-bs-toggle="modal"
                                    data-bs-target="#addPicModal">
                                    <i class="ri-add-line me-1"></i> Tambah PIC
                                </button>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($pic_client)): ?>
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
                                            <?php $no = 1; foreach ($pic_client as $pic): ?>
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
                                                    <button type="button"
                                                        class="btn btn-sm btn-soft-primary btn-edit-pic"
                                                        data-id="<?= $pic['id_pc']; ?>" data-bs-toggle="modal"
                                                        data-bs-target="#editPicModal">
                                                        <i class="ri-pencil-line"></i>
                                                    </button>
                                                    <a href="<?= base_url('Client/DeletePic/' . $pic['id_pc']); ?>"
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
        </div>
    </div>

    <div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="editClient" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClient">Edit Data Perusahaan/Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditClientView" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_client" name="id_client" value="<?= $client['id_client'] ?>">
                    <input type="hidden" id="edit_nama_client" name="nama_client" value="<?= $client['nama_client'] ?>">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="nama_pic">Nama PIC <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="edit_nama_pic" name="nama_pic"
                                    placeholder="Input Nama PIC" value="<?= $client['nama_pic'] ?>" />
                                <div class="invalid-feedback" id="edit_nama_pic_error"></div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="edit_tlp_pic" name="tlp_pic"
                                    placeholder="Input No PIC" value="<?= $client['tlp_pic'] ?>" />
                                <div class="invalid-feedback" id="edit_tlp_pic_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="email_pic">Email PIC</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" id="edit_email_pic" name="email_pic"
                                    placeholder="Input Email PIC" value="<?= $client['email_pic'] ?>" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="edit_alamat_client" name="alamat_client" rows="3"
                                    placeholder="Input Alamat Perusahaan"><?= $client['alamat_client'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="sektor" class="col-md-3 col-form-label">Sektor </label>
                            <div class="col-md-9">
                                <select class="form-control select2SektorEdit" id="edit_sektor" name="sektor">
                                    <option>Pilih Sektor</option>
                                    <option value="Industri" <?= $client['sektor'] == 'Industri' ? 'selected' : '' ?>>
                                        Industri</option>
                                    <option value="Kementerian/ Goverment"
                                        <?= $client['sektor'] == 'Kementerian/ Goverment' ? 'selected' : '' ?>>
                                        Kementerian/ Goverment</option>
                                    <option value="Danantara (BUMN Karya)"
                                        <?= $client['sektor'] == 'Danantara (BUMN Karya)' ? 'selected' : '' ?>>
                                        Danantara (BUMN Karya)</option>
                                    <option value="Pertambangan/ Mining"
                                        <?= $client['sektor'] == 'Pertambangan/ Mining' ? 'selected' : '' ?>>
                                        Pertambangan/ Mining</option>
                                    <option value="Perkantoran/ Office"
                                        <?= $client['sektor'] == 'Perkantoran/ Office' ? 'selected' : '' ?>>
                                        Perkantoran/ Office</option>
                                    <option value="Perhotelan"
                                        <?= $client['sektor'] == 'Perhotelan' ? 'selected' : '' ?>>Perhotelan
                                    </option>
                                    <option value="Facility services (Security, Cleaning service, Catering)"
                                        <?= $client['sektor'] == 'Facility services (Security, Cleaning service, Catering)' ? 'selected' : '' ?>>
                                        Facility
                                        services (Security, Cleaning service, Catering)</option>
                                    <option value="Instansi Pendidikan"
                                        <?= $client['sektor'] == 'Instansi Pendidikan' ? 'selected' : '' ?>>Instansi
                                        Pendidikan</option>
                                    <option value="Travel & Agent"
                                        <?= $client['sektor'] == 'Travel & Agent' ? 'selected' : '' ?>>Travel &
                                        Agent</option>
                                    <option value="Rumah Sakit & Lab"
                                        <?= $client['sektor'] == 'Rumah Sakit & Lab' ? 'selected' : '' ?>>Rumah
                                        Sakit & Lab</option>
                                    <option value="Yayasan" <?= $client['sektor'] == 'Yayasan' ? 'selected' : '' ?>>
                                        Yayasan</option>
                                    <option value="Shipping" <?= $client['sektor'] == 'Shipping' ? 'selected' : '' ?>>
                                        Shipping</option>
                                    <option value="Retail Market"
                                        <?= $client['sektor'] == 'Retail Market' ? 'selected' : '' ?>>Retail Market
                                    </option>
                                    <option value="Engineering (Air, Listrik, IT)"
                                        <?= $client['sektor'] == 'Engineering (Air, Listrik, IT)' ? 'selected' : '' ?>>
                                        Engineering (Air, Listrik, IT)</option>
                                    <option value="Finance (Banking, Insurance)"
                                        <?= $client['sektor'] == 'Finance (Banking, Insurance)' ? 'selected' : '' ?>>
                                        Finance (Banking, Insurance)</option>
                                    <option value="Transportation"
                                        <?= $client['sektor'] == 'Transportation' ? 'selected' : '' ?>>
                                        Transportation</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="group" class="col-md-3 col-form-label">Group </label>
                            <div class="col-md-9">
                                <select class="form-control select2GroupEdit" id="edit_group" name="group">
                                    <option>Pilih Group</option>
                                    <option value="VIP" <?= $client['group'] == 'VIP' ? 'selected' : '' ?>>VIP
                                    </option>
                                    <option value="Gold" <?= $client['group'] == 'Gold' ? 'selected' : '' ?>>Gold
                                    </option>
                                    <option value="Silver" <?= $client['group'] == 'Silver' ? 'selected' : '' ?>>
                                        Silver</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="status" class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <select class="form-control select2StatusEdit" id="edit_status" name="status">
                                    <option>Pilih Status</option>
                                    <option value="New Customer"
                                        <?= $client['status'] == 'New Customer' ? 'selected' : '' ?>>New Customer
                                    </option>
                                    <option value="Old Customer"
                                        <?= $client['status'] == 'Old Customer' ? 'selected' : '' ?>>Old Customer
                                    </option>
                                    <option value="Lost Customer"
                                        <?= $client['status'] == 'Lost Customer' ? 'selected' : '' ?>>Lost Customer
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="logo_client">Logo Perusahaan</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" id="edit_logo_client" name="logo_client" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line label-icon align-middle"></i> Close
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle"></i> Save
                        </button>
                    </div>
                </form>
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
                <form id="formAddPic">
                    <input type="hidden" name="client_id" value="<?= $client['id_client']; ?>">
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
                                <input type="text" class="form-control form-control-icon flatpickr-input"
                                    id="add_hut_pic" name="hut_pic" placeholder="Pilih tanggal">
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
                <form id="formEditPic">
                    <input type="hidden" id="edit_id_pc" name="id_pc">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama_pic_modal" class="form-label">Nama PIC <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama_pic_modal" name="nama_pic"
                                placeholder="Masukkan nama PIC" required>
                            <div class="invalid-feedback" id="edit_nama_pic_modal_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_no_pic_modal" class="form-label">No. HP <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_no_pic_modal" name="no_pic"
                                placeholder="Masukkan no HP" required>
                            <div class="invalid-feedback" id="edit_no_pic_modal_error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email_pic_modal" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email_pic_modal" name="email_pic"
                                placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="edit_hut_pic_modal" class="form-label">HUT PIC</label>
                            <div class="form-icon right">
                                <input type="text" class="form-control form-control-icon flatpickr-input"
                                    id="edit_hut_pic_modal" name="hut_pic" placeholder="Pilih tanggal">
                                <i class="ri-calendar-2-line"></i>
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