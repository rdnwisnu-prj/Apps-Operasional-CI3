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

            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $header?></h5>
                    <button type="button" class="btn btn-custom waves-effect waves-light" data-bs-toggle="modal"
                        data-bs-target="#addLeads">
                        <i class="ri-add-circle-line align-bottom me-1"></i> Add
                        Data
                    </button>
                </div>
                <div class="card-body">
                    <table id="general" class="table bordered-table dt-responsive nowrap w-100">
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
                                <th>Action</th>
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
                                <td class="text-center" style="width: 5%;">
                                    <a href="javascript:void(0);"
                                        class="btn btn-icon rounded-pill btn-edit btn-sm waves-effect waves-light edit-leads"
                                        data-id-leads="<?= $l['id_leads']; ?>" data-bs-toggle="modal"
                                        data-bs-target="#editLeads" data-bs-placement="bottom" title="edit prospek"><i
                                            class="ri ri-edit-circle-fill align-bottom"></i>
                                    </a>

                                    <a href="<?= base_url(); ?>Leads/destroy/<?= $l['id_leads']; ?>"
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

        <!-- Modal add -->
        <div class="modal fade" id="addLeads" tabindex="-1" role="dialog" aria-labelledby="addLeads" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="addLeads">Tambah Prospek Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formAddLeads" method="post">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="nama_client">Nama Perusahaan <span
                                        class="text-danger"> *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nama_client" name="nama_client"
                                        placeholder="Input Nama Perusahaan" />
                                    <div class="invalid-feedback" id="nama_client_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="nama_pic">Nama PIC <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nama_pic" name="nama_pic"
                                        placeholder="Input Nama PIC" />
                                    <div class="invalid-feedback" id="nama_pic_error"></div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="tlp_pic">No PIC <span class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                        placeholder="Input No PIC" />
                                    <div class="invalid-feedback" id="tlp_pic_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="email_pic">Email PIC </label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" id="email_pic" name="email_pic"
                                        placeholder="Input Email PIC" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="alamat_client">Alamat Perusahaan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="alamat_client" name="alamat_client" rows="3"
                                        placeholder="Input Alamat Perusahaan"></textarea>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="status_lead" class="col-md-3 col-form-label">Status Prospek <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <select class="form-control" data-choices id="status_lead" name="status_lead">
                                        <option value="">Pilih Status Prospek</option>
                                        <option value="Proses Prospek">Proses Prospek</option>
                                        <option value="Negosiasi">Negosiasi</option>
                                        <option value="Deal">Deal</option>
                                        <option value="Lost">Lost</option>
                                    </select>
                                    <div class="invalid-feedback" id="status_lead_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="estimasi_lead">Estimasi Prospek</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="number" class="form-control" id="estimasi_lead"
                                            name="estimasi_lead" placeholder="Input Estimasi Prospek" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label class="col-md-3 col-form-label" for="catatan">Catatan <span class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                        placeholder="Input Catatan"></textarea>
                                    <div class="invalid-feedback" id="catatan_error"></div>
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

        <!-- Modal edit -->
        <div class="modal fade" id="editLeads" tabindex="-1" role="dialog" aria-labelledby="editLeads"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLeads">Edit Prospek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formEditLeads" method="post">
                        <input type="hidden" id="edit_id_leads" name="id_leads">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="edit_nama_client">Nama Perusahaan <span
                                        class="text-danger"> *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="edit_nama_client" name="nama_client"
                                        placeholder="Input Nama Perusahaan" />
                                    <div class="invalid-feedback" id="edit_nama_client_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="edit_nama_pic">Nama PIC <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="edit_nama_pic" name="nama_pic"
                                        placeholder="Input Nama PIC" />
                                    <div class="invalid-feedback" id="edit_nama_pic_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="edit_tlp_pic">No PIC <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="edit_tlp_pic" name="tlp_pic"
                                        placeholder="Input No PIC" />
                                    <div class="invalid-feedback" id="edit_tlp_pic_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="edit_email_pic">Email PIC </label>
                                <div class="col-md-9">
                                    <input type="email" class="form-control" id="edit_email_pic" name="email_pic"
                                        placeholder="Input Email PIC" />
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="edit_alamat_client">Alamat
                                    Perusahaan</label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="edit_alamat_client" name="alamat_client" rows="3"
                                        placeholder="Input Alamat Perusahaan"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="edit_status_lead" class="col-md-3 col-form-label">Status Prospek <span
                                        class="text-danger"> *</span></label>
                                <div class="col-md-9">
                                    <select class="form-control select2LeadsEdit" id="edit_status_lead"
                                        name="status_lead">
                                        <option value="">Pilih Status Prospek</option>
                                        <option value="Proses Prospek">Proses Prospek</option>
                                        <option value="Negosiasi">Negosiasi</option>
                                        <option value="Deal">Deal</option>
                                        <option value="Lost">Lost</option>
                                    </select>
                                    <div class="invalid-feedback" id="edit_status_lead_error"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-3 col-form-label" for="estimasi_lead">Estimasi Prospek</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                        <input type="number" class="form-control" id="edit_estimasi_lead"
                                            name="estimasi_lead" placeholder="Input Estimasi Prospek" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <label class="col-md-3 col-form-label" for="edit_catatan">Catatan <span
                                        class="text-danger">
                                        *</span></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="edit_catatan" name="catatan" rows="3"
                                        placeholder="Input Catatan"></textarea>
                                    <div class="invalid-feedback" id="edit_catatan_error"></div>
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