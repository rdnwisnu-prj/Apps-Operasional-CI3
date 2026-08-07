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
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="<?= base_url('Perusahaan/syncAll'); ?>" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="Sync Data dari Marketing"
                    onclick="return confirm('Sinkronisasi semua data client dari Marketing?')">
                    <i class="ti ti-refresh me-1"></i>Sync API
                </a>
                <button class="btn btn-custom" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvas-perusahaan-add" aria-controls="offcanvas-perusahaan-add">
                    <i class="ti ti-circle-plus me-1"></i>Tambah Perusahaan
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar Perusahaan</h5>
            </div>
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat</th>
                            <th>PIC</th>
                            <th>Telp PIC</th>
                            <th>Marketing</th>
                            <th>Sumber</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($perusahaan as $p): ?>
                        <tr>
                            <td class="text-center" style="width: 3%;"><?= $no++; ?></td>
                            <td><?= html_escape($p['nama_perusahaan']); ?></td>
                            <td class="text-wrap" style="width: 15%;"><?= html_escape($p['alamat_perusahaan']); ?></td>
                            <td><?= html_escape($p['nama_pic']); ?></td>
                            <td><?= html_escape($p['tlp_pic']); ?></td>
                            <td><?= html_escape($p['marketing_name'] ?: '-'); ?></td>
                            <td>
                                <?php if (($p['source'] ?? '') === 'api'): ?>
                                <span class="badge bg-info-subtle text-info">API Marketing</span>
                                <?php else: ?>
                                <span class="badge bg-success-subtle text-success">Manual</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-perusahaan" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-perusahaan-edit"
                                                data-id="<?= (int) $p['id_perusahaan']; ?>"
                                                data-nama-perusahaan="<?= html_escape($p['nama_perusahaan'] ?? ''); ?>"
                                                data-no-tlp="<?= html_escape($p['no_tlp'] ?? ''); ?>"
                                                data-email="<?= html_escape($p['email'] ?? ''); ?>"
                                                data-alamat="<?= html_escape($p['alamat_perusahaan'] ?? ''); ?>"
                                                data-nama-pic="<?= html_escape($p['nama_pic'] ?? ''); ?>"
                                                data-tlp-pic="<?= html_escape($p['tlp_pic'] ?? ''); ?>"
                                                data-marketing-id="<?= html_escape($p['marketing_id'] ?? ''); ?>"
                                                data-source="<?= html_escape($p['source'] ?? 'manual'); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy"
                                                href="<?= base_url('Perusahaan/destroy/' . $p['id_perusahaan']); ?>">
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-perusahaan-add"
        aria-labelledby="offcanvas-perusahaan-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-perusahaan-add-label" class="mb-0">Tambah Perusahaan</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-perusahaan" action="<?= base_url('Perusahaan/Store'); ?>" method="post">
                <div class="mb-3">
                    <label class="form-label" for="add_nama_perusahaan">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="add_nama_perusahaan" name="nama_perusahaan" placeholder="Nama perusahaan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_no_tlp">No Tlp Perusahaan</label>
                    <input type="text" class="form-control" id="add_no_tlp" name="no_tlp" placeholder="No telepon perusahaan">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_email">Email Perusahaan</label>
                    <input type="email" class="form-control" id="add_email" name="email" placeholder="Email perusahaan">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_alamat_perusahaan">Alamat Perusahaan</label>
                    <textarea class="form-control" id="add_alamat_perusahaan" name="alamat_perusahaan" rows="3" placeholder="Alamat perusahaan"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_nama_pic">Nama PIC <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="add_nama_pic" name="nama_pic" placeholder="Nama PIC" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_tlp_pic">No Tlp PIC</label>
                    <input type="text" class="form-control" id="add_tlp_pic" name="tlp_pic" placeholder="No telepon PIC">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="add_marketing_id">Marketing</label>
                    <select class="form-select" id="add_marketing_id" name="marketing_id">
                        <option value="">Pilih Marketing</option>
                        <?php foreach ($marketing as $m): ?>
                        <option value="<?= (int) $m['id_user']; ?>"><?= html_escape($m['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($marketing)): ?>
                    <small class="text-danger d-block mt-1">Data marketing dari API belum tersedia.</small>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-perusahaan" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-perusahaan-edit"
        aria-labelledby="offcanvas-perusahaan-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-perusahaan-edit-label" class="mb-0">Edit Perusahaan</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-perusahaan" action="<?= base_url('Perusahaan/update'); ?>" method="post">
                <input type="hidden" name="id_perusahaan" value="">
                <div class="mb-3 js-source-wrap"></div>
                <div class="mb-3">
                    <label class="form-label" for="edit_nama_perusahaan">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_nama_perusahaan" name="nama_perusahaan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_no_tlp">No Tlp Perusahaan</label>
                    <input type="text" class="form-control" id="edit_no_tlp" name="no_tlp">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_email">Email Perusahaan</label>
                    <input type="email" class="form-control" id="edit_email" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_alamat_perusahaan">Alamat Perusahaan</label>
                    <textarea class="form-control" id="edit_alamat_perusahaan" name="alamat_perusahaan" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_nama_pic">Nama PIC <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_nama_pic" name="nama_pic" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_tlp_pic">No Tlp PIC</label>
                    <input type="text" class="form-control" id="edit_tlp_pic" name="tlp_pic">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="edit_marketing_id">Marketing</label>
                    <select class="form-select" id="edit_marketing_id" name="marketing_id">
                        <option value="">Pilih Marketing</option>
                        <?php foreach ($marketing as $m): ?>
                        <option value="<?= (int) $m['id_user']; ?>"><?= html_escape($m['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($marketing)): ?>
                    <small class="text-danger d-block mt-1">Data marketing dari API belum tersedia.</small>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-perusahaan" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#offcanvas-perusahaan-add').on('show.bs.offcanvas', function() {
            $('#form-add-perusahaan')[0].reset();
        });

        $('.btn-edit-perusahaan').on('click', function() {
            var $button = $(this);
            var $form = $('#form-edit-perusahaan');
            var source = $button.attr('data-source') || 'manual';

            $form[0].reset();
            $form.find('[name="id_perusahaan"]').val($button.attr('data-id') || '');
            $form.find('[name="nama_perusahaan"]').val($button.attr('data-nama-perusahaan') || '');
            $form.find('[name="no_tlp"]').val($button.attr('data-no-tlp') || '');
            $form.find('[name="email"]').val($button.attr('data-email') || '');
            $form.find('[name="alamat_perusahaan"]').val($button.attr('data-alamat') || '');
            $form.find('[name="nama_pic"]').val($button.attr('data-nama-pic') || '');
            $form.find('[name="tlp_pic"]').val($button.attr('data-tlp-pic') || '');
            $form.find('[name="marketing_id"]').val($button.attr('data-marketing-id') || '');

            $form.find('.js-source-wrap').html(source === 'api'
                ? '<span class="badge bg-info-subtle text-info"><i class="ti ti-cloud me-1"></i>Sumber: API Marketing</span>'
                : '<span class="badge bg-success-subtle text-success"><i class="ti ti-pencil me-1"></i>Sumber: Manual</span>');
        });
    });
    </script>
</div>
