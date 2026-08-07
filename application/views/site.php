<style>
.site-offcanvas-select2,
.select2-container--open {
    z-index: 20000 !important;
}
.offcanvas .select2-container {
    width: 100% !important;
}
</style>
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
            <button class="btn btn-custom" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-site-add"
                aria-controls="offcanvas-site-add">
                <i class="ti ti-circle-plus me-1"></i>Tambah Site
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
                            <th>Perusahaan</th>
                            <th>Nama Site</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Keterangan</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($site as $s): ?>
                        <tr>
                            <td class="text-center" style="width: 5%;"><?= $no++; ?></td>
                            <td><?= html_escape($s['nama_perusahaan'] ?? '-'); ?></td>
                            <td><?= html_escape($s['nama_site'] ?? '-'); ?></td>
                            <td><?= html_escape($s['nama_kota'] ?? '-'); ?></td>
                            <td><?= html_escape($s['nama_provinsi'] ?? '-'); ?></td>
                            <td><?= html_escape($s['keterangan'] ?? '-'); ?></td>
                            <td class="text-end" style="width: 10%;">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item btn-edit-site" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-site-edit"
                                                data-id="<?= (int) $s['id_site']; ?>"
                                                data-id-perusahaan="<?= html_escape($s['id_perusahaan'] ?? ''); ?>"
                                                data-nama-site="<?= html_escape($s['nama_site'] ?? ''); ?>"
                                                data-provinsi="<?= html_escape($s['provinsi'] ?? ''); ?>"
                                                data-kota="<?= html_escape($s['kota'] ?? ''); ?>"
                                                data-keterangan="<?= html_escape($s['keterangan'] ?? ''); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy" href="<?= base_url('Site/destroy/' . $s['id_site']); ?>">
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-site-add" aria-labelledby="offcanvas-site-add-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-site-add-label" class="mb-0">Tambah Site</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-site" action="<?= base_url('Site/create'); ?>" method="post" class="site-form">
                <div class="mb-3">
                    <label for="add_id_perusahaan" class="form-label">Perusahaan <span class="text-danger">*</span></label>
                    <select id="add_id_perusahaan" name="id_perusahaan" class="form-select js-site-perusahaan" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= (int) $p['id_perusahaan']; ?>"><?= html_escape($p['nama_perusahaan']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="add_nama_site" class="form-label">Nama Site <span class="text-danger">*</span></label>
                    <input type="text" id="add_nama_site" name="nama_site" class="form-control" placeholder="Nama site" required>
                </div>
                <div class="mb-3">
                    <label for="add_provinsi" class="form-label">Provinsi</label>
                    <select id="add_provinsi" name="provinsi" class="form-select js-provinsi">
                        <option value="">-- Pilih Provinsi --</option>
                        <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= (int) $prov['id_provinsi']; ?>"><?= html_escape($prov['nama_provinsi']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="add_kota" class="form-label">Kota</label>
                    <select id="add_kota" name="kota" class="form-select js-kota">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="add_keterangan" class="form-label">Keterangan</label>
                    <textarea id="add_keterangan" name="keterangan" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-site" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas-site-edit" aria-labelledby="offcanvas-site-edit-label">
        <div class="offcanvas-header border-bottom">
            <h4 id="offcanvas-site-edit-label" class="mb-0">Edit Site</h4>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-site" action="<?= base_url('Site/update'); ?>" method="post" class="site-form">
                <input type="hidden" name="id_site" value="">
                <div class="mb-3">
                    <label for="edit_id_perusahaan" class="form-label">Perusahaan <span class="text-danger">*</span></label>
                    <select id="edit_id_perusahaan" name="id_perusahaan" class="form-select js-site-perusahaan" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php foreach ($perusahaan as $p): ?>
                        <option value="<?= (int) $p['id_perusahaan']; ?>"><?= html_escape($p['nama_perusahaan']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_nama_site" class="form-label">Nama Site <span class="text-danger">*</span></label>
                    <input type="text" id="edit_nama_site" name="nama_site" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="edit_provinsi" class="form-label">Provinsi</label>
                    <select id="edit_provinsi" name="provinsi" class="form-select js-provinsi">
                        <option value="">-- Pilih Provinsi --</option>
                        <?php foreach ($provinsi as $prov): ?>
                        <option value="<?= (int) $prov['id_provinsi']; ?>"><?= html_escape($prov['nama_provinsi']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_kota" class="form-label">Kota</label>
                    <select id="edit_kota" name="kota" class="form-select js-kota">
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_keterangan" class="form-label">Keterangan</label>
                    <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-site" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function select2Parent($el) {
            var $offcanvas = $el.closest('.offcanvas');
            return $offcanvas.length ? $offcanvas : $(document.body);
        }

        function initPerusahaanSelect2($scope) {
            if (!$.fn.select2) return;

            $scope.find('.js-site-perusahaan').each(function() {
                var $select = $(this);
                if ($select.data('select2')) {
                    $select.select2('destroy');
                }
                $select.select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: select2Parent($select),
                    placeholder: '-- Pilih Perusahaan --',
                    allowClear: true
                });
            });
        }

        function setSelectValue($select, value) {
            $select.val(value || '').trigger('change.select2');
        }

        function loadKota($form, provinsi, selectedKota) {
            var $kota = $form.find('.js-kota');
            $kota.html('<option value="">-- Pilih Kota --</option>');
            if (!provinsi) return;

            $.ajax({
                url: base_url + 'Site/getKota/' + provinsi,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $.each(data || [], function(i, kota) {
                        var selected = String(kota.id_kota) === String(selectedKota || '') ? ' selected' : '';
                        $kota.append('<option value="' + kota.id_kota + '"' + selected + '>' + kota.nama_kota + '</option>');
                    });
                }
            });
        }

        $('.site-form .js-provinsi').on('change', function() {
            var $form = $(this).closest('form');
            loadKota($form, $(this).val(), '');
        });

        initPerusahaanSelect2($('.site-form'));

        $('#offcanvas-site-add, #offcanvas-site-edit').on('shown.bs.offcanvas', function() {
            initPerusahaanSelect2($(this));
        });

        $('#offcanvas-site-add').on('show.bs.offcanvas', function() {
            var $form = $('#form-add-site');
            $form[0].reset();
            setSelectValue($form.find('.js-site-perusahaan'), '');
            $form.find('.js-kota').html('<option value="">-- Pilih Kota --</option>');
        });

        $('.btn-edit-site').on('click', function() {
            var $button = $(this);
            var $form = $('#form-edit-site');
            $form[0].reset();
            $form.find('[name="id_site"]').val($button.attr('data-id') || '');
            setSelectValue($form.find('[name="id_perusahaan"]'), $button.attr('data-id-perusahaan') || '');
            $form.find('[name="nama_site"]').val($button.attr('data-nama-site') || '');
            $form.find('[name="provinsi"]').val($button.attr('data-provinsi') || '');
            $form.find('[name="keterangan"]').val($button.attr('data-keterangan') || '');
            loadKota($form, $button.attr('data-provinsi') || '', $button.attr('data-kota') || '');
        });
    });
    </script>
</div>
