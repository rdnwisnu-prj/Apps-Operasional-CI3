<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $subheader;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><?= $header;?></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $subheader?></li>
                </ol>
            </nav>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-icon input-icon-start position-relative">
                    <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search" id="searchMemberList">
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="javascript:void(0);" class="btn btn-primary" data-bs-toggle="offcanvas"
                    data-bs-target="#add_marketing"><i class="ti ti-square-rounded-plus-filled me-1"></i>Add
                    Data</a>
            </div>
        </div>

        <div id="teamContainer">
            <div class="row">
                <?php foreach ($teams as $team): ?>
                <div class="col-xxl-3 col-xl-4 col-md-6 mb-3">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <a href="<?= base_url('Team/View/' . urlencode($team['id_user'])); ?>"
                                        class="avatar avatar-md flex-shrink-0 me-2">
                                        <img src="<?= base_url('upload/employee/' . $team['foto']); ?>" alt="img"
                                            class="rounded-circle">
                                    </a>
                                    <div>
                                        <h6 class="fs-14"><a
                                                href="<?= base_url('Team/View/' . urlencode($team['id_user'])); ?>"
                                                class="fw-medium"><?= $team['nama']; ?></a></h6>
                                        <p class="text-default mb-0"><?= $team['jabatan']; ?> |
                                            <?= $team['nama_cabang']; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="dropdown table-action">
                                    <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item btn-edit" href="javascript:void(0);"
                                            data-id="<?= $team['id_user']; ?>" data-bs-toggle="offcanvas"
                                            data-bs-target="#edit_marketing"><i class="ti ti-edit"></i>
                                            Edit</a>
                                        <a class="dropdown-item btn-delete" href="javascript:void(0);"
                                            data-id="<?= $team['id_user']; ?>" data-nama="<?= $team['nama']; ?>"><i
                                                class="ti ti-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-block">
                                <div class="d-flex flex-column">
                                    <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-award text-dark me-1"></i> Prospek :
                                        <?= $team['leads_count'] ?>
                                    </h6>
                                    <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-report-money text-dark me-1"></i> Total Prospek :
                                        Rp <?= number_format($team['leads_total'], 0, ',', '.'); ?>
                                    </h6>
                                    <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-award text-dark me-1"></i> Client :
                                        <?= $team['client_count'] ?>
                                    </h6>
                                    <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                            class="ti ti-report-money text-dark me-1"></i> Total Sales :
                                        Rp <?= number_format($team['sales_total'], 0, ',', '.'); ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="<?= base_url('Team/View/' . urlencode($team['id_user'])); ?>"
                                class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Add Marketing Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="add_marketing">
        <div class="offcanvas-header border-bottom">
            <h5 class="mb-0">Add New Marketing</h5>
            <button type="button"
                class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                data-bs-dismiss="offcanvas" aria-label="Close">
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="formAddMarketing" enctype="multipart/form-data">
                <div class="accordion accordion-bordered" id="main_accordion">
                    <!-- General Info -->
                    <div class="accordion-item rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded"
                                data-bs-toggle="collapse" data-bs-target="#basic">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-user-plus"></i></span>
                                General Info
                            </a>
                        </div>
                        <div class="accordion-collapse collapse show" id="basic" data-bs-parent="#main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0"
                                                id="add_foto_preview">
                                                <div class="position-relative d-flex align-items-center">
                                                    <i class="ti ti-photo text-dark fs-16"></i>
                                                </div>
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div
                                                    class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="ti ti-file-broken me-1"></i>Upload foto
                                                    <input type="file" class="form-control image-sign" name="foto"
                                                        id="add_foto" accept="image/*">
                                                </div>
                                                <span>JPG, GIF or PNG. Max size of 2MB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Input Nama Lengkap"
                                                name="nama" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email </label>
                                            <input class="form-control" type="email" placeholder="Input Email"
                                                name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">No Tlp</label>
                                            <input class="form-control" type="text" placeholder="No Tlp" name="no_tlp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir </label>
                                            <input class="form-control" type="text" placeholder="Tempat Lahir"
                                                name="t_lahir">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="input-group w-auto input-group-flat">
                                                <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"
                                                    placeholder="YYYY-MM-DD" />
                                                <span class="input-group-text">
                                                    <i class="ti ti-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="add_genderL" value="L" />
                                                    <label class="form-check-label" for="add_genderL">Laki -
                                                        Laki</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="add_genderP" value="P" />
                                                    <label class="form-check-label" for="add_genderP">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /General Info -->

                    <!-- Job Info -->
                    <div class="accordion-item border-top rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#address">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-map-pin-cog"></i></span>
                                Job Info
                            </a>
                        </div>
                        <div class="accordion-collapse collapse" id="address" data-bs-parent="#main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Input NIK" name="nik"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan </label>
                                            <select class="form-control" name="jabatan">
                                                <option value="">Pilih Jabatan</option>
                                                <option value="Direksi">Direksi</option>
                                                <option value="General Manager">General Manager</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Supervisor">Supervisor</option>
                                                <option value="Staff">Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cabang </label>
                                            <select class="form-control" name="cabang">
                                                <option value="">Pilih Cabang</option>
                                                <?php foreach ($cabang as $c): ?>
                                                <option value="<?= $c['id_cabang']; ?>"><?= $c['nama_cabang']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Job Info -->

                    <!-- Account Setting -->
                    <div class="accordion-item border-top rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#social">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-social"></i></span>
                                Account Setting
                            </a>
                        </div>
                        <div class="accordion-collapse collapse" id="social" data-bs-parent="#main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Username <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Username"
                                                name="username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-flat pass-group">
                                                <input type="password" class="form-control pass-input" name="password"
                                                    placeholder="Enter password (min 8 karakter)">
                                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                    <i class="ti ti-eye-off"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Role </label>
                                            <select class="form-control" name="role_id">
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($role as $r): ?>
                                                <option value="<?= $r['id_role']; ?>"><?= $r['nama_role']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnAddMarketing">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Add Marketing Offcanvas -->

    <!-- Edit Marketing Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_marketing">
        <div class="offcanvas-header border-bottom">
            <h5 class="mb-0">Edit Marketing</h5>
            <button type="button"
                class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
                data-bs-dismiss="offcanvas" aria-label="Close">
            </button>
        </div>
        <div class="offcanvas-body">
            <form id="formEditMarketing" enctype="multipart/form-data">
                <input type="hidden" name="id_user" id="edit_id_user">
                <div class="accordion accordion-bordered" id="edit_main_accordion">
                    <!-- General Info -->
                    <div class="accordion-item rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded"
                                data-bs-toggle="collapse" data-bs-target="#edit_basic">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-user-plus"></i></span>
                                General Info
                            </a>
                        </div>
                        <div class="accordion-collapse collapse show" id="edit_basic"
                            data-bs-parent="#edit_main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar avatar-xxl border border-dashed me-3 flex-shrink-0"
                                                id="edit_foto_preview">
                                                <img src="" alt="Foto" class="rounded-circle"
                                                    style="width:100%;height:100%;object-fit:cover;" id="edit_foto_img">
                                            </div>
                                            <div class="d-inline-flex flex-column align-items-start">
                                                <div
                                                    class="drag-upload-btn btn btn-sm btn-primary position-relative mb-2">
                                                    <i class="ti ti-file-broken me-1"></i>Upload foto
                                                    <input type="file" class="form-control image-sign" name="foto"
                                                        id="edit_foto" accept="image/*">
                                                </div>
                                                <span>JPG, GIF or PNG. Max size of 2MB</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Input Nama Lengkap"
                                                name="nama" id="edit_nama" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email </label>
                                            <input class="form-control" type="email" placeholder="Input Email"
                                                name="email" id="edit_email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">No Tlp</label>
                                            <input class="form-control" type="text" placeholder="No Tlp" name="no_tlp"
                                                id="edit_no_tlp">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tempat Lahir </label>
                                            <input class="form-control" type="text" placeholder="Tempat Lahir"
                                                name="t_lahir" id="edit_t_lahir">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <div class="input-group w-auto input-group-flat">
                                                <input type="date" name="tgl_lahir" id="edit_tgl_lahir"
                                                    class="form-control" placeholder="YYYY-MM-DD" />
                                                <span class="input-group-text">
                                                    <i class="ti ti-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <div class="d-flex flex-wrap gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="edit_genderL" value="L" />
                                                    <label class="form-check-label" for="edit_genderL">Laki -
                                                        Laki</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="edit_genderP" value="P" />
                                                    <label class="form-check-label" for="edit_genderP">Perempuan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /General Info -->

                    <!-- Job Info -->
                    <div class="accordion-item border-top rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#edit_address">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-map-pin-cog"></i></span>
                                Job Info
                            </a>
                        </div>
                        <div class="accordion-collapse collapse" id="edit_address"
                            data-bs-parent="#edit_main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Input NIK" name="nik"
                                                id="edit_nik" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Jabatan </label>
                                            <select class="form-control" name="jabatan" id="edit_jabatan">
                                                <option value="">Pilih Jabatan</option>
                                                <option value="Direksi">Direksi</option>
                                                <option value="General Manager">General Manager</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Supervisor">Supervisor</option>
                                                <option value="Staff">Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cabang </label>
                                            <select class="form-control" name="cabang" id="edit_cabang">
                                                <option value="">Pilih Cabang</option>
                                                <?php foreach ($cabang as $c): ?>
                                                <option value="<?= $c['id_cabang']; ?>"><?= $c['nama_cabang']; ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Job Info -->

                    <!-- Account Setting -->
                    <div class="accordion-item border-top rounded mb-3">
                        <div class="accordion-header">
                            <a href="#" class="accordion-button accordion-custom-button rounded collapsed"
                                data-bs-toggle="collapse" data-bs-target="#edit_social">
                                <span class="avatar avatar-md rounded me-1"><i class="ti ti-social"></i></span>
                                Account Setting
                            </a>
                        </div>
                        <div class="accordion-collapse collapse" id="edit_social" data-bs-parent="#edit_main_accordion">
                            <div class="accordion-body border-top">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Username <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" placeholder="Username"
                                                name="username" id="edit_username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Password <small class="text-muted">(Kosongkan jika
                                                    tidak ingin mengubah)</small></label>
                                            <div class="input-group input-group-flat pass-group">
                                                <input type="password" class="form-control pass-input" name="password"
                                                    id="edit_password"
                                                    placeholder="Enter new password (min 8 karakter)">
                                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                    <i class="ti ti-eye-off"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Role </label>
                                            <select class="form-control" name="role_id" id="edit_role_id">
                                                <option value="">Pilih Role</option>
                                                <?php foreach ($role as $r): ?>
                                                <option value="<?= $r['id_role']; ?>"><?= $r['nama_role']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <button type="button" data-bs-dismiss="offcanvas" class="btn btn-light me-2">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnEditMarketing">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Edit Marketing Offcanvas -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data <strong id="deleteUserName"></strong>?</p>
                    <p class="text-danger small">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="deleteUserId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">
                        <span class="spinner-border spinner-border-sm d-none me-1" role="status"></span>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Confirmation Modal -->

    <script>
    const baseUrl = '<?= base_url(); ?>';

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function searchTeam() {
        const searchTerm = document.getElementById('searchMemberList').value;
        if (searchTerm.trim() === '') {
            location.reload();
            return;
        }

        fetch(`<?= base_url('Team/search'); ?>?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                updateTeamView(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateTeamView(teams) {
        const container = document.getElementById('teamContainer');
        if (teams.length === 0) {
            container.innerHTML = `
            <div class="text-center py-6">
                <p class="text-muted">Tidak ada data marketing yang ditemukan</p>
            </div>
        `;
            return;
        }

        const formatRupiah = (number) => {
            const num = parseFloat(number) || 0;
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(num).replace('IDR', 'Rp').trim();
        };

        let html = '<div class="row">';

        teams.forEach(team => {
            const leadsTotalFormatted = formatRupiah(team.leads_total);
            const salesTotalFormatted = formatRupiah(team.sales_total);

            html += `
            <div class="col-xxl-3 col-xl-4 col-md-6 mb-3">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <a href="${baseUrl}Team/View/${team.id_user}" class="avatar avatar-md flex-shrink-0 me-2">
                                    <img src="${baseUrl}upload/employee/${team.foto}" alt="img" class="rounded-circle">
                                </a>
                                <div>
                                    <h6 class="fs-14"><a href="${baseUrl}Team/View/${team.id_user}" class="fw-medium">${team.nama || ''}</a></h6>
                                    <p class="text-default mb-0">${team.jabatan || ''} | ${team.nama_cabang || ''}</p>
                                </div>
                            </div>
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item btn-edit" href="javascript:void(0);" data-id="${team.id_user}" data-bs-toggle="offcanvas" data-bs-target="#edit_marketing">
                                        <i class="ti ti-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="${team.id_user}" data-nama="${team.nama}">
                                        <i class="ti ti-trash text-danger"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="d-flex flex-column">
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i class="ti ti-award text-dark me-1"></i> Prospek : ${team.leads_count || 0}</h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i class="ti ti-report-money text-dark me-1"></i> Total Prospek : ${leadsTotalFormatted}</h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i class="ti ti-award text-dark me-1"></i> Client : ${team.client_count || 0}</h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i class="ti ti-report-money text-dark me-1"></i> Total Sales : ${salesTotalFormatted}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="${baseUrl}Team/View/${team.id_user}" class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';
        container.innerHTML = html;

        // Re-bind event listeners
        bindEventListeners();
    }

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.pass-input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            }
        });
    });

    // Photo preview for add form
    document.getElementById('add_foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('add_foto_preview').innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="rounded-circle" style="width:100%;height:100%;object-fit:cover;">
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Photo preview for edit form
    document.getElementById('edit_foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('edit_foto_img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Add Marketing Form Submit
    document.getElementById('formAddMarketing').addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnAddMarketing');
        const spinner = btn.querySelector('.spinner-border');

        btn.disabled = true;
        spinner.classList.remove('d-none');

        const formData = new FormData(this);

        fetch('<?= base_url('Team/Store'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                spinner.classList.add('d-none');

                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: data.message
                    });
                }
            })
            .catch(error => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data'
                });
            });
    });

    // Edit Marketing Form Submit
    document.getElementById('formEditMarketing').addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = document.getElementById('btnEditMarketing');
        const spinner = btn.querySelector('.spinner-border');
        const idUser = document.getElementById('edit_id_user').value;

        btn.disabled = true;
        spinner.classList.remove('d-none');

        const formData = new FormData(this);

        fetch(`<?= base_url('Team/Update/'); ?>${idUser}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                spinner.classList.add('d-none');

                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: data.message
                    });
                }
            })
            .catch(error => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memperbarui data'
                });
            });
    });

    // Delete confirmation
    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        const btn = this;
        const spinner = btn.querySelector('.spinner-border');
        const idUser = document.getElementById('deleteUserId').value;

        btn.disabled = true;
        spinner.classList.remove('d-none');

        fetch(`<?= base_url('Team/destroy/'); ?>${idUser}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                spinner.classList.add('d-none');

                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                modal.hide();

                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                btn.disabled = false;
                spinner.classList.add('d-none');
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menghapus data'
                });
            });
    });

    // Bind event listeners for edit and delete buttons
    function bindEventListeners() {
        // Edit button handler
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const idUser = this.getAttribute('data-id');
                loadUserData(idUser);
            });
        });

        // Delete button handler
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const idUser = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                document.getElementById('deleteUserId').value = idUser;
                document.getElementById('deleteUserName').textContent = nama;

                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            });
        });
    }

    // Load user data for edit form
    function loadUserData(idUser) {
        fetch(`<?= base_url('Team/getUser/'); ?>${idUser}`)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const user = data.data;

                    document.getElementById('edit_id_user').value = user.id_user;
                    document.getElementById('edit_nama').value = user.nama || '';
                    document.getElementById('edit_email').value = user.email || '';
                    document.getElementById('edit_no_tlp').value = user.no_tlp || '';
                    document.getElementById('edit_t_lahir').value = user.t_lahir || '';
                    document.getElementById('edit_tgl_lahir').value = user.tgl_lahir || '';
                    document.getElementById('edit_nik').value = user.nik || '';
                    document.getElementById('edit_username').value = user.username || '';
                    document.getElementById('edit_password').value = '';

                    // Set gender radio
                    if (user.gender === 'L') {
                        document.getElementById('edit_genderL').checked = true;
                    } else if (user.gender === 'P') {
                        document.getElementById('edit_genderP').checked = true;
                    }

                    // Set select values
                    document.getElementById('edit_jabatan').value = user.jabatan || '';
                    document.getElementById('edit_cabang').value = user.cabang || '';
                    document.getElementById('edit_role_id').value = user.role_id || '';

                    // Set photo preview
                    if (user.foto) {
                        document.getElementById('edit_foto_img').src =
                            `<?= base_url('upload/employee/'); ?>${user.foto}`;
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memuat data'
                });
            });
    }

    // Reset add form when offcanvas is closed
    document.getElementById('add_marketing').addEventListener('hidden.bs.offcanvas', function() {
        document.getElementById('formAddMarketing').reset();
        document.getElementById('add_foto_preview').innerHTML = `
            <div class="position-relative d-flex align-items-center">
                <i class="ti ti-photo text-dark fs-16"></i>
            </div>
        `;
    });

    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        bindEventListeners();
    });

    document.getElementById('searchMemberList').addEventListener('input', debounce(searchTeam, 300));
    </script>