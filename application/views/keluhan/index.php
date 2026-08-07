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
                    <li class="breadcrumb-item active"><?= $subheader?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>
                <a href="<?= base_url()?>Keluhan/Store" class="btn btn-custom waves-effect waves-light"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Keluhan
                </a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Tgl Masuk</th>
                            <th>Nama Perusahaan</th>
                            <th>PIC</th>
                            <th>Media</th>
                            <th>Divisi tujuan</th>
                            <th>Kategori</th>
                            <th class="text-center">Detail</th>
                            <th>Customer Service</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($keluhan as $k): ?>
                        <tr>
                            <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                            <td style="width: 5%;"> <?= tanggal_indonesia_medium(date($k['tgl_masuk'])); ?></td>
                            <td><?= $k['nama_client']; ?></td>
                            <td style="width: 7%;"><?= $k['pic']; ?></td>
                            <td style="width: 10%;"><?= $k['media']; ?></td>
                            <td style="width: 10%;"><?= $k['divisi']; ?></td>
                            <td style="width: 10%;"><?= $k['kategori']; ?></td>
                            <td class="text-center"> <button type="button"
                                    class="btn btn-purple btn-sm waves-effect waves-light btn-detail"
                                    data-bs-toggle="modal" data-bs-target="#detailComplaint"
                                    data-tgl_masuk="<?= tanggal_indonesia_medium($k['tgl_masuk']); ?>"
                                    data-kategori="<?= htmlspecialchars($k['kategori']); ?>"
                                    data-pic="<?= htmlspecialchars($k['pic']); ?>"
                                    data-media="<?= htmlspecialchars($k['media']); ?>"
                                    data-divisi="<?= htmlspecialchars($k['divisi']); ?>"
                                    data-complain="<?= htmlspecialchars($k['complain']); ?>"
                                    data-analisa="<?= htmlspecialchars($k['analisa']); ?>"
                                    data-rencana_tl="<?= htmlspecialchars($k['rencana_tl']); ?>"
                                    data-tidak_lanjut="<?= htmlspecialchars($k['tidak_lanjut']); ?>"
                                    data-tgl_respon="<?= tanggal_indonesia_medium($k['tgl_respon']); ?>"
                                    data-tgl_selesai="<?= tanggal_indonesia_medium($k['tgl_selesai']); ?>"
                                    data-eval_after_tl="<?= htmlspecialchars($k['eval_after_tl']); ?>"
                                    data-keterangan="<?= htmlspecialchars($k['keterangan']); ?>">
                                    <i class="ri-eye-line me-1"></i> Lihat Detail
                                </button></td>
                            <td style="width: 10%;"><?= $k['marketing']; ?></td>
                            <td class="text-center" style="width: 5%;">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?= base_url()?>Keluhan/Update/<?= $k['id_complain']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?= base_url()?>Keluhan/Delete/<?= $k['id_complain']; ?>"
                                                class="dropdown-item remove-item-btn btn-destroy">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="detailComplaint" tabindex="-1" aria-labelledby="detailComplaintLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="detailComplaintLabel">
                        <i class="ri-information-line me-2"></i>Detail Complaint
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Tanggal Masuk</label>
                                <p class="mb-0" id="detail_tgl_masuk">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Nama PIC</label>
                                <p class="mb-0" id="detail_pic">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Media</label>
                                <p class="mb-0" id="detail_media">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Divisi yang Dituju</label>
                                <p class="mb-0" id="detail_divisi">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Kategori</label>
                                <p class="mb-0" id="detail_kategori">-</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Isi Komplain</label>
                        <div class="p-3 bg-light rounded" id="detail_complain">-</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Analisa</label>
                        <div class="p-3 bg-light rounded" id="detail_analisa">-</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Rencana Tindak Lanjut (RTL)</label>
                                <div class="p-3 bg-light rounded" id="detail_rencana_tl">-</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Tindak Lanjut (TL)</label>
                                <div class="p-3 bg-light rounded" id="detail_tidak_lanjut">-</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Tanggal Respon</label>
                                <p class="mb-0" id="detail_tgl_respon">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Tanggal Selesai</label>
                                <p class="mb-0" id="detail_tgl_selesai">-</p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Evaluasi Setelah TL</label>
                        <div class="p-3 bg-light rounded" id="detail_eval_after_tl">-</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Keterangan</label>
                        <div class="p-3 bg-light rounded" id="detail_keterangan">-</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('click', function(e) {
        var button = e.target.closest('.btn-detail');
        if (!button) return;

        document.getElementById('detail_tgl_masuk').textContent = button.dataset.tgl_masuk || '-';
        document.getElementById('detail_kategori').textContent = button.dataset.kategori || '-';
        document.getElementById('detail_pic').textContent = button.dataset.pic || '-';
        document.getElementById('detail_media').textContent = button.dataset.media || '-';
        document.getElementById('detail_divisi').textContent = button.dataset.divisi || '-';
        document.getElementById('detail_complain').innerHTML = button.dataset.complain || '-';
        document.getElementById('detail_analisa').innerHTML = button.dataset.analisa || '-';
        document.getElementById('detail_rencana_tl').innerHTML = button.dataset.rencana_tl || '-';
        document.getElementById('detail_tidak_lanjut').innerHTML = button.dataset.tidak_lanjut || '-';
        document.getElementById('detail_tgl_respon').textContent = button.dataset.tgl_respon || '-';
        document.getElementById('detail_tgl_selesai').textContent = button.dataset.tgl_selesai || '-';
        document.getElementById('detail_eval_after_tl').innerHTML = button.dataset.eval_after_tl || '-';
        document.getElementById('detail_keterangan').innerHTML = button.dataset.keterangan || '-';
    });
    </script>