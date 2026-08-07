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
                <a href="<?= base_url()?>Gift/Store" class="btn btn-custom waves-effect waves-light"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Gift
                </a>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Client</th>
                            <th>Nama Gift</th>
                            <th>Business Unit</th>
                            <th>Harga Gift</th>
                            <th>Pelaksana</th>
                            <th>Tanggal Gift</th>
                            <th>Lampiran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($gift as $g): ?>
                        <tr>
                            <td class="text-center" style="width: 2%;"> <?= $no++; ?></td>
                            <td><?= $g['nama_client']; ?></td>
                            <td><?= $g['nama_gift']; ?></td>
                            <td><?= $g['bu_gift']; ?></td>
                            <td>Rp <?= number_format($g['harga_gift'], 0, ',', '.'); ?></td>
                            <td><?= $g['nama']; ?></td>
                            <td><?= tanggal_indonesia_medium(date($g['tgl_gift'])); ?></td>
                            <td>
                                <?php if (!empty($g['lampiran_gift'])): ?>
                                <a href="<?= base_url('upload/gift/' . $g['lampiran_gift']); ?>" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="ri-file-line"></i> Lihat
                                </a>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center" style="width: 5%;">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="<?= base_url()?>Gift/Update/<?= $g['id_gift']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a href="<?= base_url()?>Gift/Destroy/<?= $g['id_gift']; ?>"
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

    <!-- Modal Add Gift -->
    <div class="modal fade" id="addGift" tabindex="-1" role="dialog" aria-labelledby="addGiftLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGiftLabel">Tambah Gift Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formAddGift" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="add_client_id" class="col-md-3 col-form-label">Nama Client <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="add_client_id" name="client_id">
                                    <option value="">Pilih Client</option>
                                    <?php foreach ($client as $c): ?>
                                    <option value="<?= $c['id_client']; ?>"><?= $c['nama_client']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="add_client_id_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="add_nama_gift">Nama Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="add_nama_gift" name="nama_gift"
                                    placeholder="Input Nama Gift" />
                                <div class="invalid-feedback" id="add_nama_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="add_bu_gift">Kop Unit Bisnis <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="add_bu_gift" name="bu_gift">
                                    <option value="">Pilih Kop Unit Bisnis</option>
                                    <option value="Cakra Medika">Cakra Medika</option>
                                    <option value="Konsehat">Konsehat</option>
                                </select>
                                <div class="invalid-feedback" id="add_bu_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="add_harga_gift">Harga Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="add_harga_gift" name="harga_gift"
                                        placeholder="Input Harga Gift" />
                                </div>
                                <div class="invalid-feedback" id="add_harga_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="add_pelaksana" class="col-md-3 col-form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="add_pelaksana" name="pelaksana">
                                    <option value="">Pilih Pelaksana</option>
                                    <?php foreach ($team as $u): ?>
                                    <option value="<?= $u['id_user']; ?>"><?= $u['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="add_pelaksana_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="add_tgl_gift">Tanggal Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="add_tgl_gift" name="tgl_gift"
                                    placeholder="Input Tanggal Gift" />
                                <div class="invalid-feedback" id="add_tgl_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="add_lampiran_gift">Lampiran</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" id="add_lampiran_gift" name="lampiran_gift"
                                    accept=".jpg,.jpeg,.png" />
                                <small class="text-muted">Format: jpg, jpeg, png Max: 10MB</small>
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

    <!-- Modal Edit Gift -->
    <div class="modal fade" id="editGift" tabindex="-1" role="dialog" aria-labelledby="editGiftLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGiftLabel">Edit Gift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditGift" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_gift" name="id_gift">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="edit_client_id" class="col-md-3 col-form-label">Nama Client <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="edit_client_id" name="client_id">
                                    <option value="">Pilih Client</option>
                                    <?php foreach ($client as $c): ?>
                                    <option value="<?= $c['id_client']; ?>"><?= $c['nama_client']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="edit_client_id_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="edit_nama_gift">Nama Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="edit_nama_gift" name="nama_gift"
                                    placeholder="Input Nama Gift" />
                                <div class="invalid-feedback" id="edit_nama_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="edit_bu_gift">Kop Unit Bisnis <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="edit_bu_gift" name="bu_gift">
                                    <option value="">Pilih Kop Unit Bisnis</option>
                                    <option value="Cakra Medika">Cakra Medika</option>
                                    <option value="Konsehat">Konsehat</option>
                                </select>
                                <div class="invalid-feedback" id="edit_bu_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="edit_harga_gift">Harga Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="edit_harga_gift" name="harga_gift"
                                        placeholder="Input Harga Gift" />
                                </div>
                                <div class="invalid-feedback" id="edit_harga_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_pelaksana" class="col-md-3 col-form-label">Pelaksana <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="edit_pelaksana" name="pelaksana">
                                    <option value="">Pilih Pelaksana</option>
                                    <?php foreach ($team as $t): ?>
                                    <option value="<?= $t['id_user']; ?>"><?= $t['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="edit_pelaksana_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="edit_tgl_gift">Tanggal Gift <span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="edit_tgl_gift" name="tgl_gift" />
                                <div class="invalid-feedback" id="edit_tgl_gift_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 col-form-label" for="edit_lampiran_gift">Lampiran</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control" id="edit_lampiran_gift" name="lampiran_gift"
                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />
                                <small class="text-muted">Format: jpg, jpeg, png, pdf, doc, docx. Max: 2MB</small>
                                <div id="current_lampiran" class="mt-2"></div>
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

</div>