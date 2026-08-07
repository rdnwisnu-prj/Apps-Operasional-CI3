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
                        <h4 class="mb-sm-0">Pemakaian Aset</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Fitur</a></li>
                                <li class="breadcrumb-item active">Pemakaian Aset</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 flex-grow-1">Daftar <?= $header;?></h4>
                </div>
                <div class="card-body">
                    <table id="alternative-pagination"
                        class="table dt-responsive align-middle table-hover bordered-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 2%;">No</th>
                                <th>Nama Karyawan</th>
                                <th style="width: 10%;">Tgl Pemakaian</th>
                                <th style="width: 10%;">Jam Pemakaian</th>
                                <th style="width: 10%;">Tgl Selesai</th>
                                <th style="width: 10%;">Jam Selesai</th>
                                <th>Tujuan</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                                <th style="width: 10%;">Detail</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($request as $r): ?>
                            <tr>
                                <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                                <td><?= $r['nama_req']; ?></td>
                                <td><?= tanggal_indonesia_medium(date($r['tgl_start_req'])); ?></td>
                                <td><?= format_jam_indonesia($r['jam_pemakaian']);?> </td>
                                <td><?= tanggal_indonesia_medium(date($r['tgl_end_req'])); ?></td>
                                <td><?= format_jam_indonesia($r['jam_kembali']);?> </td>
                                <td><?= $r['tujuan']; ?></td>
                                <td><?= $r['keperluan']; ?></td>
                                <td>
                                    <?php 
                                        if ($r['status_req'] == 0) {
                                            echo '<span class="badge bg-warning">Pending</span>';
                                        } elseif ($r['status_req'] == 1) {
                                            echo '<span class="badge bg-success">Diterima</span>';
                                        } else {
                                            echo '<span class="badge bg-danger">Ditolak</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($r['status_req'] == 1):?>
                                    <button type="button"
                                        class="btn btn-soft-info btn-sm waves-effect waves-light shadow-none btn-lihat-detail"
                                        data-bs-toggle="modal" data-bs-target="#modalLihat"
                                        data-id-request="<?= $r['id_request']; ?>">Lihat
                                    </button>
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="width: 7%;">
                                    <?php if ($r['status_req'] == 0): ?>
                                    <a href="<?= base_url('pemakaian/approve/' . $r['id_request']); ?>"
                                        class="btn btn-icon rounded-pill btn-success btn-sm waves-effect waves-light"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="approve"
                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui permintaan ini?');">
                                        <i class="ri-check-fill"></i>
                                    </a>

                                    <a href="<?= base_url('pemakaian/reject/' . $r['id_request']); ?>"
                                        class="btn btn-icon rounded-pill btn-delete btn-sm waves-effect waves-light"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="reject"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak permintaan ini?');">
                                        <i class="ri-close-fill"></i>
                                    </a>
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLihat" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Aset Alokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="modalLihatContent" class="modal-body text-center p-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addAset" tabindex="-1" role="dialog" aria-labelledby="addAset" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAset">Tambah Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddAset" method="post" action="<?= base_url('Pemakaian/saveAset'); ?>">
                    <input type="hidden" name="request_id" id="add_aset_request_id">
                    <div class="modal-body">
                        <div class="g-3">
                            <label for="aset_id" class="form-label">Daftar Aset</label>
                            <select class="form-control" data-choices name="aset_id" id="aset_id">
                                <option value="">Tambah Aset</option>
                                <?php foreach ($aset as $as): ?>
                                <option value="<?= $as['kode_aset']; ?>">
                                    <?= $as['nama_aset']; ?> - <?= $as['sn_aset']; ?> (<?= $as['nama_cabang']; ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
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

    <div class="modal fade" id="editAset" tabindex="-1" role="dialog" aria-labelledby="editAsetLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAsetLabel">Ubah Alokasi Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditAset" method="post" action="<?= base_url('Pemakaian/saveAset'); ?>">
                    <input type="hidden" name="request_id" id="edit_aset_request_id">
                    <div class="modal-body">
                        <div class="g-3">
                            <label for="edit_aset_id" class="form-label">Daftar Aset Baru</label>
                            <select class="form-control" data-choices name="aset_id" id="edit_aset_id">
                                <option value="">Pilih Aset Baru</option>
                                <?php foreach ($aset as $as): ?>
                                <option value="<?= $as['kode_aset']; ?>">
                                    <?= $as['nama_aset']; ?> - <?= $as['sn_aset']; ?> (<?= $as['nama_cabang']; ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line label-icon align-middle"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="ri-save-line label-icon align-middle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>