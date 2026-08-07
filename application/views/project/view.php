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

        <div class="card mb-6">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                        <li class="nav-item me-2">
                            <a class="nav-link active"
                                href="<?= base_url('Project/View/' . urlencode($project['id_project'])) ?>"></i>Overview</a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link"
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

        <div class="row">
            <div class="col-xl-4 col-lg-12 order-1 order-md-0">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between border-bottom">
                        <h5 class="card-title">
                            <i class="ri-briefcase-3-line align-bottom me-2"></i> Detail Project
                        </h5>
                        <div class="dropdown table-action">
                            <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#editProject">
                                    Update Project
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="mt-4">
                            <ul>
                                <li class="row mb-2"><span class="col-4">Nama Project</span><span
                                        class="col-8 text-dark"><?= $project['nama_project'] ?: '-' ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Nama Client</span><span
                                        class="col-8 text-dark"><?= $project['nama_client'] ?: '-' ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Service</span><span
                                        class="col-8 text-dark"><?= $project['service'] ?: '-' ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Tanggal Pelaksanaan Project</span><span
                                        class="col-8 text-dark"><?php echo tanggal_indonesia_medium(date($project['tgl_pelaksanaan'])); ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Tanggal Selesai Project</span><span
                                        class="col-8 text-dark"><?php echo tanggal_indonesia_medium(date($project['tgl_selesai'])); ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Total Peserta</span><span
                                        class="col-8 text-dark"><?= $project['jumlah_karyawan'] ?: '-' ?></span>
                                </li>
                                <li class="row mb-2"><span class="col-4">Total Nilai Project</span><span
                                        class="col-8 text-dark">Rp.
                                        <?= number_format($project['estimasi'], 0, '.', '.'); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Deskripsi</h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $project['deskripsi']?></p>
                    </div>
                </div>
            </div>

            <!-- HPP / Business Plan Section -->
            <div class="col-xl-8 col-lg-12 order-0 order-md-1">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between border-bottom">
                        <h5 class="card-title">
                            <i class="ri-calculator-line align-bottom me-2"></i> Business Plan (HPP)
                        </h5>
                        <div class="d-flex gap-2">
                            <?php if (isset($hpp_data['lampiran_bp']) && !empty($hpp_data['lampiran_bp'])): ?>
                            <a href="<?= base_url('upload/file_bp/' . $hpp_data['lampiran_bp']); ?>"
                                class="btn btn-sm btn-success" download>
                                <i class="ri-download-line me-1"></i>Download Lampiran
                            </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm btn-custom" data-bs-toggle="modal"
                                data-bs-target="#modalHpp">
                                <i class="ri-edit-line me-1"></i>
                                <?= isset($hpp_data) && $hpp_data ? 'Edit HPP' : 'Input HPP' ?>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light-primary border-0">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Nilai Project</h6>
                                        <h4 class="mb-0 text-primary">Rp.
                                            <?= number_format($project['estimasi'], 0, '.', '.'); ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light-warning border-0">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Total HPP</h6>
                                        <h4 class="mb-0 text-warning" id="display_total_hpp">
                                            Rp.
                                            <?= isset($hpp_data['total_hpp']) ? number_format($hpp_data['total_hpp'], 0, '.', '.') : '0'; ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="card <?= (isset($hpp_data['margin_persen']) && $hpp_data['margin_persen'] >= 30) ? 'bg-light-success' : 'bg-light-danger'; ?> border-0">
                                    <div class="card-body text-center py-3">
                                        <h6 class="text-muted mb-1">Margin/Profit</h6>
                                        <h4 class="mb-0 <?= (isset($hpp_data['margin_persen']) && $hpp_data['margin_persen'] >= 30) ? 'text-success' : 'text-danger'; ?>"
                                            id="display_margin">
                                            Rp.
                                            <?= isset($hpp_data['margin_nominal']) ? number_format($hpp_data['margin_nominal'], 0, '.', '.') : '0'; ?>
                                            <small class="fs-9"
                                                id="display_margin_persen">(<?= isset($hpp_data['margin_persen']) ? $hpp_data['margin_persen'] : '0'; ?>%)</small>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($hpp_data['margin_persen']) && $hpp_data['margin_persen'] < 30): ?>
                        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert"
                            id="margin_warning_alert">
                            <i class="ri-error-warning-line me-2 fs-4"></i>
                            <div>
                                <strong>Perhatian!</strong> Margin dibawah 30%. Minimal margin yang direkomendasikan
                                adalah 30%.
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- HPP Detail Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="45%">Komponen HPP</th>
                                        <th width="50%" class="text-end">Nilai (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td><i class="ri-shopping-bag-line me-2 text-primary"></i>HPP Barang</td>
                                        <td class="text-end" id="display_hpp_barang">
                                            <?= isset($hpp_data['hpp_barang']) ? number_format($hpp_data['hpp_barang'], 0, '.', '.') : '0'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td><i class="ri-service-line me-2 text-info"></i>HPP Jasa</td>
                                        <td class="text-end" id="display_hpp_jasa">
                                            <?= isset($hpp_data['hpp_jasa']) ? number_format($hpp_data['hpp_jasa'], 0, '.', '.') : '0'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td><i class="ri-folder-chart-line me-2 text-warning"></i>HPP Project</td>
                                        <td class="text-end" id="display_hpp_project">
                                            <?= isset($hpp_data['hpp_project']) ? number_format($hpp_data['hpp_project'], 0, '.', '.') : '0'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td><i class="ri-money-dollar-circle-line me-2 text-danger"></i>HPP Biaya</td>
                                        <td class="text-end" id="display_hpp_biaya">
                                            <?= isset($hpp_data['hpp_biaya']) ? number_format($hpp_data['hpp_biaya'], 0, '.', '.') : '0'; ?>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-end">Total HPP</th>
                                        <th class="text-end" id="display_total_hpp_table">
                                            <?= isset($hpp_data['total_hpp']) ? number_format($hpp_data['total_hpp'], 0, '.', '.') : '0'; ?>
                                        </th>
                                    </tr>
                                    <tr class="<?= (isset($hpp_data['margin_persen']) && $hpp_data['margin_persen'] >= 30) ? 'table-success' : 'table-danger'; ?>"
                                        id="margin_row">
                                        <th colspan="2" class="text-end">
                                            Margin/Profit
                                            <span
                                                class="badge <?= (isset($hpp_data['margin_persen']) && $hpp_data['margin_persen'] >= 30) ? 'bg-success' : 'bg-danger'; ?> ms-2"
                                                id="margin_badge">
                                                <?= isset($hpp_data['margin_persen']) ? $hpp_data['margin_persen'] : '0'; ?>%
                                            </span>
                                        </th>
                                        <th class="text-end" id="display_margin_table">
                                            <?= isset($hpp_data['margin_nominal']) ? number_format($hpp_data['margin_nominal'], 0, '.', '.') : '0'; ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <?php if (isset($hpp_data['catatan']) && !empty($hpp_data['catatan'])): ?>
                        <div class="mt-3">
                            <h6><i class="ri-sticky-note-line me-1"></i> Catatan:</h6>
                            <p class="text-muted mb-0"><?= $hpp_data['catatan']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProject" tabindex="-1" role="dialog" aria-labelledby="editProject"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProject">Edit Data Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formeditProjectView" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_project" name="id_project" value="<?= $project['id_project'] ?>">
                    <input type="hidden" id="edit_nama_project" name="nama_project"
                        value="<?= $project['nama_project'] ?>">
                    <div class="modal-body">

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="bast">BAST <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-9">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="edit_bast" name="bast" value="1"
                                        <?= $project['bast'] == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="edit_bast">
                                        BAST
                                    </label>
                                </div>
                                <div class="invalid-feedback" id="edit_bast_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="owner" class="col-md-3 col-form-label">Entitas </label>
                            <div class="col-md-9">
                                <select class="form-control select2EntitasEdit" id="edit_owner" name="owner">
                                    <option>Pilih Entitas</option>
                                    <option value="Cakra" <?= $project['owner'] == 'Cakra' ? 'selected' : '' ?>>Cakra
                                    </option>
                                    <option value="Konsehat" <?= $project['owner'] == 'Konsehat' ? 'selected' : '' ?>>
                                        Konsehat
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"
                                    placeholder="Input Keterangan"><?= $project['keterangan'] ?></textarea>
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

    <!-- Modal HPP Input -->
    <div class="modal fade" id="modalHpp" tabindex="-1" role="dialog" aria-labelledby="modalHppLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalHppLabel">
                        <i class="ri-calculator-line me-2"></i>Input HPP / Business Plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formHpp" enctype="multipart/form-data">
                    <input type="hidden" name="project_id" value="<?= $project['id_project'] ?>">
                    <input type="hidden" id="hpp_estimasi_value" value="<?= $project['estimasi'] ?? 0 ?>">
                    <div class="modal-body">
                        <!-- Info Nilai Project -->
                        <div class="alert alert-info d-flex align-items-center mb-4">
                            <i class="ri-information-line me-2 fs-4"></i>
                            <div>
                                <strong>Nilai Project:</strong> Rp.
                                <?= number_format($project['estimasi'], 0, '.', '.'); ?>
                                <br><small class="text-muted">Minimal margin yang direkomendasikan adalah
                                    <strong>30%</strong></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hpp_barang" class="form-label">
                                        <i class="ri-shopping-bag-line me-1 text-primary"></i>HPP Barang
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control hpp-input" id="hpp_barang"
                                            name="hpp_barang"
                                            value="<?= isset($hpp_data['hpp_barang']) ? number_format($hpp_data['hpp_barang'], 0, '.', '.') : '0'; ?>"
                                            placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hpp_jasa" class="form-label">
                                        <i class="ri-service-line me-1 text-info"></i>HPP Jasa
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control hpp-input" id="hpp_jasa" name="hpp_jasa"
                                            value="<?= isset($hpp_data['hpp_jasa']) ? number_format($hpp_data['hpp_jasa'], 0, '.', '.') : '0'; ?>"
                                            placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hpp_project" class="form-label">
                                        <i class="ri-folder-chart-line me-1 text-warning"></i>HPP Project
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control hpp-input" id="hpp_project"
                                            name="hpp_project"
                                            value="<?= isset($hpp_data['hpp_project']) ? number_format($hpp_data['hpp_project'], 0, '.', '.') : '0'; ?>"
                                            placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hpp_biaya" class="form-label">
                                        <i class="ri-money-dollar-circle-line me-1 text-danger"></i>HPP Biaya
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control hpp-input" id="hpp_biaya"
                                            name="hpp_biaya"
                                            value="<?= isset($hpp_data['hpp_biaya']) ? number_format($hpp_data['hpp_biaya'], 0, '.', '.') : '0'; ?>"
                                            placeholder="0" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Calculation -->
                        <div class="card bg-light mt-3">
                            <div class="card-body">
                                <h6 class="card-title mb-3"><i class="ri-calculator-line me-1"></i>Preview Perhitungan
                                </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <small class="text-muted">Total HPP</small>
                                            <h5 class="mb-0 text-warning" id="preview_total_hpp">Rp. 0</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <small class="text-muted">Margin Nominal</small>
                                            <h5 class="mb-0" id="preview_margin_nominal">Rp. 0</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <small class="text-muted">Margin Persentase</small>
                                            <h5 class="mb-0" id="preview_margin_persen">0%</h5>
                                        </div>
                                    </div>
                                </div>
                                <div id="preview_warning" class="alert alert-danger mt-3 mb-0 d-none">
                                    <i class="ri-error-warning-line me-1"></i>
                                    Margin dibawah 30%! Harap pertimbangkan kembali.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="lampiran_bp" class="form-label">
                                <i class="ri-file-excel-line me-1"></i>Lampiran Excel (Opsional)
                            </label>
                            <input type="file" class="form-control" id="lampiran_bp" name="lampiran_bp"
                                accept=".xlsx,.xls,.csv">
                            <small class="text-muted">Format: xlsx, xls, csv (Max: 5MB)</small>
                            <?php if (isset($hpp_data['lampiran_bp']) && !empty($hpp_data['lampiran_bp'])): ?>
                            <div class="mt-2">
                                <span class="badge bg-success">
                                    <i class="ri-file-excel-line me-1"></i>
                                    File saat ini: <?= $hpp_data['lampiran_bp'] ?>
                                </span>
                                <a href="<?= base_url('upload/file_bp/' . $hpp_data['lampiran_bp']); ?>"
                                    class="btn btn-sm btn-outline-primary ms-2" download>
                                    <i class="ri-download-line"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="catatan" class="form-label">
                                <i class="ri-sticky-note-line me-1"></i>Catatan (Opsional)
                            </label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="2"
                                placeholder="Tambahkan catatan jika diperlukan"><?= isset($hpp_data['catatan']) ? $hpp_data['catatan'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-custom" id="btnSaveHpp">
                            <i class="ri-save-line me-1"></i>Simpan HPP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>