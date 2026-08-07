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
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader?></a></li>
                    <li class="breadcrumb-item active">Tambah <?= $subheader?> </li>
                </ol>
            </nav>
        </div>



        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Tambah <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>KeluhanAps" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_client">Nama Client <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_client" name="nama_client"
                                placeholder="Input Nama Client" />
                            <div class="form-text text-danger">
                                <?= form_error('nama_client') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_masuk">Tanggal Masuk <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_masuk" name="tgl_masuk"
                                    placeholder="Pilih tanggal">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                            <div class="form-text text-danger">
                                <?= form_error('tgl_masuk') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kategori" class="col-md-2 col-form-label">Kategori <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="kategori" name="kategori">
                                <option value="">Pilih Kategori</option>
                                <option value="Major">Major</option>
                                <option value="Minor">Minor</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('kategori') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="pic">Nama PIC </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="pic" name="pic" placeholder="Input Nama PIC" />
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="media">Media Aduan</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="media" name="media" placeholder="Input Media">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="divisi">Divisi yang dituju</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="divisi" name="divisi"
                                placeholder="Input Divisi yang dituju">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="complain">Isi Komplain</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-complain" data-placeholder="Input Isi Komplain"
                                style="height: 150px;"></div>
                            <input type="hidden" name="complain" id="complain">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="analisa">Analisa</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-analisa" data-placeholder="Input Analisa"
                                style="height: 150px;"></div>
                            <input type="hidden" name="analisa" id="analisa">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="rencana_tl">RTL</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-rencana_tl" data-placeholder="Input RTL"
                                style="height: 150px;"></div>
                            <input type="hidden" name="rencana_tl" id="rencana_tl">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tidak_lanjut">TL</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-tidak_lanjut" data-placeholder="Input TL"
                                style="height: 150px;"></div>
                            <input type="hidden" name="tidak_lanjut" id="tidak_lanjut">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_respon">Tanggal Respon </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_respon" name="tgl_respon"
                                    placeholder="Pilih tanggal">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tgl_selesai">Tanggal Selesai </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai"
                                    placeholder="Pilih tanggal">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="eval_after_tl">Eval After TL</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-eval_after_tl"
                                data-placeholder="Input Eval After TL" style="height: 150px;"></div>
                            <input type="hidden" name="eval_after_tl" id="eval_after_tl">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-md-10">
                            <div class="quill-keluhan-aps" id="editor-keterangan" data-placeholder="Input Keterangan"
                                style="height: 150px;"></div>
                            <input type="hidden" name="keterangan" id="keterangan">
                        </div>
                    </div>



                    <div class="text-end">
                        <button type="reset" class="btn btn-light">
                            <i class="ri-close-circle-line label-icon align-middle me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle me-2"></i> Save
                        </button>
                    </div>


                </form>
            </div>
        </div>
    </div>