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
                            <a class="nav-link active"
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
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title m-0">Daftar Complaint <?php echo $client['nama_client']?></h5>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width: 3%;">No</th>
                            <th style="width: 10%;">Tgl Masuk Komplain</th>
                            <th style="width: 10%;">Nama PIC</th>
                            <th style="width: 10%;">Media</th>
                            <th style="width: 10%;">Divisi</th>
                            <th style="width: 10%;">Kategori</th>
                            <th>Tgl Respon</th>
                            <th>Customer Service</th>
                            <th style="width: 5%;">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($complaint as $comp): ?>
                        <tr>
                            <td class="text-center" style="width: 3%;"><?= $no++; ?></td>
                            <td> <?= tanggal_indonesia_medium(date($comp['tgl_masuk'])); ?></td>
                            <td><?= htmlspecialchars($comp['pic']); ?></td>
                            <td><?= htmlspecialchars($comp['media']); ?></td>
                            <td><?= htmlspecialchars($comp['divisi']); ?></td>
                            <td><?= htmlspecialchars($comp['kategori']); ?></td>
                            <td><?= tanggal_indonesia_medium(date($comp['tgl_respon'])); ?></td>
                            <td><?= htmlspecialchars($comp['nama']); ?></td>
                            <td> <button type="button"
                                    class="btn btn-primary btn-sm waves-effect waves-light btn-detail"
                                    data-bs-toggle="modal" data-bs-target="#detailComplaint"
                                    data-tgl_masuk="<?= tanggal_indonesia_medium($comp['tgl_masuk']); ?>"
                                    data-pic="<?= htmlspecialchars($comp['pic']); ?>"
                                    data-media="<?= htmlspecialchars($comp['media']); ?>"
                                    data-divisi="<?= htmlspecialchars($comp['divisi']); ?>"
                                    data-kategori="<?= htmlspecialchars($comp['kategori']); ?>"
                                    data-complain="<?= htmlspecialchars($comp['complain']); ?>"
                                    data-analisa="<?= htmlspecialchars($comp['analisa']); ?>"
                                    data-rencana_tl="<?= htmlspecialchars($comp['rencana_tl']); ?>"
                                    data-tidak_lanjut="<?= htmlspecialchars($comp['tidak_lanjut']); ?>"
                                    data-tgl_respon="<?= tanggal_indonesia_medium($comp['tgl_respon']); ?>"
                                    data-tgl_selesai="<?= tanggal_indonesia_medium($comp['tgl_selesai']); ?>"
                                    data-eval_after_tl="<?= htmlspecialchars($comp['eval_after_tl']); ?>"
                                    data-keterangan="<?= htmlspecialchars($comp['keterangan']); ?>">
                                    <i class="ri-eye-line me-1"></i> Lihat Detail
                                </button>
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