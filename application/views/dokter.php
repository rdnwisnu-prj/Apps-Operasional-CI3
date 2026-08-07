<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1"><?= html_escape($subheader); ?></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                        <li class="breadcrumb-item active"><?= html_escape($subheader); ?></li>
                    </ol>
                </nav>
            </div>
            <button class="btn btn-custom" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-dokter-add"
                aria-controls="offcanvas-dokter-add">
                <i class="ti ti-circle-plus me-1"></i>Tambah Dokter
            </button>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Data <?= html_escape($subheader); ?></h5>
            </div>
            <div class="card-body">
                <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dokter</th>
                            <th>No. KTP</th>
                            <th>Bank</th>
                            <th>No Rekening</th>
                            <th>Atas Nama</th>
                            <th>KCP</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($dokter as $d): ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"><?= $no++; ?></td>
                            <td><?= html_escape($d['nama_dokter'] ?? '-'); ?></td>
                            <td><?= html_escape($d['ktp'] ?? '-'); ?></td>
                            <td><?= html_escape($d['bank'] ?? '-'); ?></td>
                            <td><?= html_escape($d['no_rekening'] ?? '-'); ?></td>
                            <td><?= html_escape($d['atas_nama'] ?? '-'); ?></td>
                            <td><?= html_escape($d['kcp'] ?? '-'); ?></td>
                            <td class="text-end">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-dokter" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-dokter-edit"
                                                data-id="<?= (int) $d['id_dokter']; ?>"
                                                data-nama-dokter="<?= html_escape($d['nama_dokter'] ?? ''); ?>"
                                                data-ktp="<?= html_escape($d['ktp'] ?? ''); ?>"
                                                data-bank="<?= html_escape($d['bank'] ?? ''); ?>"
                                                data-no-rekening="<?= html_escape($d['no_rekening'] ?? ''); ?>"
                                                data-atas-nama="<?= html_escape($d['atas_nama'] ?? ''); ?>"
                                                data-kcp="<?= html_escape($d['kcp'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy" href="<?= base_url('Dokter/destroy/' . $d['id_dokter']); ?>">
                                                <i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-dokter-add" aria-labelledby="offcanvas-dokter-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-dokter-add-label" class="mb-0">Tambah Dokter</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-dokter" action="<?= base_url('Dokter/create'); ?>" method="post">
                <div class="mb-3">
                    <label for="add_nama_dokter" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="add_nama_dokter" name="nama_dokter" placeholder="Nama dokter" required>
                </div>
                <div class="mb-3">
                    <label for="add_ktp" class="form-label">No. KTP</label>
                    <input type="text" class="form-control" id="add_ktp" name="ktp" placeholder="No. KTP">
                </div>
                <div class="mb-3">
                    <label for="add_bank" class="form-label">Bank <span class="text-danger">*</span></label>
                    <select id="add_bank" name="bank" class="form-select" required>
                        <option value="">-- Pilih Bank --</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                        <option value="BSI">BSI</option>
                        <option value="BRI">BRI</option>
                        <option value="BTN">BTN</option>
                        <option value="CIMB Niaga">CIMB Niaga</option>
                        <option value="Danamon">Danamon</option>
                        <option value="Permata">Permata</option>
                        <option value="Maybank Indonesia">Maybank Indonesia</option>
                        <option value="Blu (BCA Digital)">Blu (BCA Digital)</option>
                        <option value="Panin">Panin</option>
                        <option value="OCBC Indonesia">OCBC Indonesia</option>
                        <option value="Bank Mega">Bank Mega</option>
                        <option value="Bank BTPN">Bank BTPN</option>
                        <option value="Sinarmas">Sinarmas</option>
                        <option value="Mayapada">Mayapada</option>
                        <option value="Victoria">Victoria</option>
                        <option value="Hana Bank">Hana Bank</option>
                        <option value="Muamalat">Muamalat</option>
                        <option value="BCA Syariah">BCA Syariah</option>
                        <option value="Bank DKI">Bank DKI</option>
                        <option value="Bank BJB">Bank BJB</option>
                        <option value="Bank Jateng">Bank Jateng</option>
                        <option value="Bank Jatim">Bank Jatim</option>
                        <option value="Bank Sumut">Bank Sumut</option>
                        <option value="Bank Jago">Bank Jago</option>
                        <option value="SeaBank">SeaBank</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="add_no_rekening" class="form-label">No Rekening <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="add_no_rekening" name="no_rekening" placeholder="No rekening" required>
                </div>
                <div class="mb-3">
                    <label for="add_atas_nama" class="form-label">Atas Nama</label>
                    <input type="text" class="form-control" id="add_atas_nama" name="atas_nama" placeholder="Atas nama rekening">
                </div>
                <div class="mb-3">
                    <label for="add_kcp" class="form-label">KCP Bank</label>
                    <input type="text" class="form-control" id="add_kcp" name="kcp" placeholder="KCP bank">
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-dokter" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-dokter-edit" aria-labelledby="offcanvas-dokter-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-dokter-edit-label" class="mb-0">Edit Dokter</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-dokter" action="<?= base_url('Dokter/update'); ?>" method="post">
                <input type="hidden" name="id_dokter" value="">
                <div class="mb-3">
                    <label for="edit_nama_dokter" class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_nama_dokter" name="nama_dokter" required>
                </div>
                <div class="mb-3">
                    <label for="edit_ktp" class="form-label">No. KTP</label>
                    <input type="text" class="form-control" id="edit_ktp" name="ktp">
                </div>
                <div class="mb-3">
                    <label for="edit_bank" class="form-label">Bank <span class="text-danger">*</span></label>
                    <select id="edit_bank" name="bank" class="form-select" required>
                        <option value="">-- Pilih Bank --</option>
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                        <option value="BSI">BSI</option>
                        <option value="BRI">BRI</option>
                        <option value="BTN">BTN</option>
                        <option value="CIMB Niaga">CIMB Niaga</option>
                        <option value="Danamon">Danamon</option>
                        <option value="Permata">Permata</option>
                        <option value="Maybank Indonesia">Maybank Indonesia</option>
                        <option value="Blu (BCA Digital)">Blu (BCA Digital)</option>
                        <option value="Panin">Panin</option>
                        <option value="OCBC Indonesia">OCBC Indonesia</option>
                        <option value="Bank Mega">Bank Mega</option>
                        <option value="Bank BTPN">Bank BTPN</option>
                        <option value="Sinarmas">Sinarmas</option>
                        <option value="Mayapada">Mayapada</option>
                        <option value="Victoria">Victoria</option>
                        <option value="Hana Bank">Hana Bank</option>
                        <option value="Muamalat">Muamalat</option>
                        <option value="BCA Syariah">BCA Syariah</option>
                        <option value="Bank DKI">Bank DKI</option>
                        <option value="Bank BJB">Bank BJB</option>
                        <option value="Bank Jateng">Bank Jateng</option>
                        <option value="Bank Jatim">Bank Jatim</option>
                        <option value="Bank Sumut">Bank Sumut</option>
                        <option value="Bank Jago">Bank Jago</option>
                        <option value="SeaBank">SeaBank</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_no_rekening" class="form-label">No Rekening <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_no_rekening" name="no_rekening" required>
                </div>
                <div class="mb-3">
                    <label for="edit_atas_nama" class="form-label">Atas Nama</label>
                    <input type="text" class="form-control" id="edit_atas_nama" name="atas_nama">
                </div>
                <div class="mb-3">
                    <label for="edit_kcp" class="form-label">KCP Bank</label>
                    <input type="text" class="form-control" id="edit_kcp" name="kcp">
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-dokter" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#offcanvas-dokter-add').on('show.bs.offcanvas', function() {
            $('#form-add-dokter')[0].reset();
        });

        $('.btn-edit-dokter').on('click', function() {
            var $button = $(this);
            var $form = $('#form-edit-dokter');
            $form[0].reset();
            $form.find('[name="id_dokter"]').val($button.attr('data-id') || '');
            $form.find('[name="nama_dokter"]').val($button.attr('data-nama-dokter') || '');
            $form.find('[name="ktp"]').val($button.attr('data-ktp') || '');
            $form.find('[name="bank"]').val($button.attr('data-bank') || '');
            $form.find('[name="no_rekening"]').val($button.attr('data-no-rekening') || '');
            $form.find('[name="atas_nama"]').val($button.attr('data-atas-nama') || '');
            $form.find('[name="kcp"]').val($button.attr('data-kcp') || '');
        });
    });
    </script>
</div>
