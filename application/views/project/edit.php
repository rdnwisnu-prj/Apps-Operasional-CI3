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
                    <li class="breadcrumb-item active">Edit <?= $subheader?></li>

                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>Project" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form id="form-edit-project" action="<?= base_url('Project/update') ?>" method="post">
                    <input type="hidden" name="kode_project" value="<?= $edit_data['kode_project'] ?>">

                    <div class="row mb-3">
                        <label for="nama_project" class="col-form-label col-lg-2 text-lg-end">Nama
                            Project <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <input type="text"
                                class="form-control <?= form_error('nama_project') ? 'is-invalid' : '' ?>"
                                id="nama_project" name="nama_project" placeholder="Enter Nama Project"
                                value="<?= set_value('nama_project', $edit_data['nama_project']) ?>">
                            <div class="invalid-feedback"><?= form_error('nama_project') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="perusahaan_id" class="col-form-label col-lg-2 text-lg-end">Perusahaan
                            <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('perusahaan_id') ? 'is-invalid' : '' ?>"
                                id="perusahaan_id" name="perusahaan_id">
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach ($perusahaan as $p) : ?>
                                <option value="<?= $p['id_perusahaan'] ?>"
                                    <?= ($edit_data['perusahaan_id'] == $p['id_perusahaan']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['nama_perusahaan']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('perusahaan_id') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="site_id" class="col-form-label col-lg-2 text-lg-end">Site</label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('site_id') ? 'is-invalid' : '' ?>" id="site_id"
                                name="site_id">
                                <option value="">-- Pilih Site --</option>
                                <?php foreach ($sites as $s) : ?>
                                <option value="<?= $s['id_site'] ?>"
                                    <?= ($edit_data['site_id'] == $s['id_site']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['nama_site']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('site_id') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_mulai" class="col-form-label col-lg-2 text-lg-end">Tanggal Mulai
                            <span class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control <?= form_error('tgl_mulai') ? 'is-invalid' : '' ?>"
                                id="tgl_mulai" name="tgl_mulai"
                                value="<?= set_value('tgl_mulai', $edit_data['tgl_mulai']) ?>">
                            <div class="invalid-feedback"><?= form_error('tgl_mulai') ?></div>
                        </div>
                        <label for="tgl_selesai" class="col-form-label col-lg-2 text-lg-end">Tanggal Selesai
                            <span class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control <?= form_error('tgl_selesai') ? 'is-invalid' : '' ?>"
                                id="tgl_selesai" name="tgl_selesai"
                                value="<?= set_value('tgl_selesai', $edit_data['tgl_selesai']) ?>">
                            <div class="invalid-feedback"><?= form_error('tgl_selesai') ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="deskripsi" class="col-form-label col-lg-2 text-lg-end">Deskripsi</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Enter Deskripsi Project"><?= set_value('deskripsi', $edit_data['deskripsi']) ?></textarea>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="ti ti-users me-1"></i> Data Korlap</h5>

                    <div id="korlap-container">
                        <?php if (!empty($korlap)): ?>
                        <?php foreach ($korlap as $i => $k): ?>
                        <div class="row mb-2 korlap-row">
                            <div class="col-lg-2 text-lg-end pt-1">
                                <label class="col-form-label">Korlap</label>
                            </div>
                            <div class="col-lg-4">
                                <select class="form-select" name="korlap_id[]">
                                    <option value="">-- Pilih Korlap --</option>
                                    <?php foreach ($users as $u) : ?>
                                    <option value="<?= $u['id_user'] ?>"
                                        <?= ($k['user_id'] == $u['id_user']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($u['nama']) ?> - <?= htmlspecialchars($u['jabatan']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="korlap_tgl_mulai[]"
                                    value="<?= $k['tgl_mulai'] ?>">
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="korlap_tgl_selesai[]"
                                    value="<?= $k['tgl_selesai'] ?>">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-danger btn-sm btn-remove-korlap"
                                    <?= ($i === 0 && count($korlap) === 1) ? 'style="display:none;"' : '' ?>>
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="row mb-2 korlap-row">
                            <div class="col-lg-2 text-lg-end pt-1">
                                <label class="col-form-label">Korlap</label>
                            </div>
                            <div class="col-lg-4">
                                <select class="form-select" name="korlap_id[]">
                                    <option value="">-- Pilih Korlap --</option>
                                    <?php foreach ($users as $u) : ?>
                                    <option value="<?= $u['id_user'] ?>">
                                        <?= htmlspecialchars($u['nama']) ?> - <?= htmlspecialchars($u['jabatan']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="korlap_tgl_mulai[]">
                            </div>
                            <div class="col-lg-2">
                                <input type="text" class="form-control" name="korlap_tgl_selesai[]">
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn btn-danger btn-sm btn-remove-korlap"
                                    style="display:none;">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-10 offset-lg-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-korlap">
                                <i class="ti ti-plus me-1"></i> Tambah Korlap
                            </button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url() ?>Project">Cancel</a>
                <button type="submit" form="form-edit-project" class="btn btn-custom"><i
                        class="ri-checkbox-circle-line me-1"></i>
                    Update</button>
            </div>
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select2 for Perusahaan (searchable)
        $('#perusahaan_id').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Perusahaan --',
            allowClear: true
        });

        // Init flatpickr on korlap date inputs
        function initKorlapFlatpickr(container) {
            $(container).find('input[name="korlap_tgl_mulai[]"]').each(function() {
                if (!this._flatpickr) flatpickr(this, {});
            });
            $(container).find('input[name="korlap_tgl_selesai[]"]').each(function() {
                if (!this._flatpickr) flatpickr(this, {});
            });
        }
        initKorlapFlatpickr('#korlap-container');

        // Cascading: Perusahaan → Site
        $(document).off('change.projectSite', '#perusahaan_id').on('change.projectSite', '#perusahaan_id', function() {
            var perusahaan_id = $(this).val();
            var siteSelect = $('#site_id');
            siteSelect.html('<option value="">-- Pilih Site --</option>');

            if (perusahaan_id) {
                $.ajax({
                    url: base_url + 'Project/getSites',
                    type: 'GET',
                    data: {
                        perusahaan_id: perusahaan_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(i, site) {
                            siteSelect.append('<option value="' + site.id_site +
                                '">' + site.nama_site + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error getSites:', error);
                    }
                });
            }
        });

        // Korlap template
        var korlapTemplate = `
        <div class="row mb-2 korlap-row">
            <div class="col-lg-2 text-lg-end pt-1">
                <label class="col-form-label">Korlap</label>
            </div>
            <div class="col-lg-4">
                <select class="form-select" name="korlap_id[]">
                    <option value="">-- Pilih Korlap --</option>
                    <?php foreach ($users as $u) : ?>
                    <option value="<?= $u['id_user'] ?>"><?= htmlspecialchars($u['nama']) ?> - <?= htmlspecialchars($u['jabatan']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="korlap_tgl_mulai[]" placeholder="Tgl Mulai">
            </div>
            <div class="col-lg-2">
                <input type="text" class="form-control" name="korlap_tgl_selesai[]" placeholder="Tgl Selesai">
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove-korlap">
                    <i class="ti ti-trash"></i>
                </button>
            </div>
        </div>`;

        // Add korlap row
        $(document).off('click.projectKorlapAdd', '#btn-add-korlap').on('click.projectKorlapAdd',
            '#btn-add-korlap',
            function() {
            $('#korlap-container').append(korlapTemplate);
            var newRow = $('#korlap-container .korlap-row:last');
            initKorlapFlatpickr(newRow);
            updateRemoveButtons();
        });

        // Remove korlap row
        $(document).off('click.projectKorlapRemove', '.btn-remove-korlap').on('click.projectKorlapRemove',
            '.btn-remove-korlap',
            function() {
            $(this).closest('.korlap-row').remove();
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            var rows = $('#korlap-container .korlap-row');
            if (rows.length > 1) {
                rows.find('.btn-remove-korlap').show();
            } else {
                rows.find('.btn-remove-korlap').hide();
            }
        }

        updateRemoveButtons();
    });
    </script>
