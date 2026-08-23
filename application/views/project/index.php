<?php
$project_payload = [];
foreach ($project as $p) {
    $project_payload[$p['kode_project']] = [
        'kode_project' => $p['kode_project'],
        'nama_project' => $p['nama_project'],
        'perusahaan_id' => $p['perusahaan_id'],
        'site_id' => $p['site_id'],
        'tgl_mulai' => $p['tgl_mulai'],
        'tgl_selesai' => $p['tgl_selesai'],
        'deskripsi' => $p['deskripsi'] ?? '',
        'nama_perusahaan' => $p['nama_perusahaan'] ?? '',
        'nama_site' => $p['nama_site'] ?? '',
        'marketing_project_id' => $p['marketing_project_id'] ?? '',
        'marketing_site_id' => $p['marketing_site_id'] ?? '',
        'marketing_key' => (!empty($p['marketing_project_id']) && !empty($p['marketing_site_id']))
            ? $p['marketing_project_id'] . '|' . $p['marketing_site_id']
            : '',
        'source' => $p['source'] ?? 'manual',
        'korlap' => $p['korlap_rows'] ?? [],
    ];
}
$marketing_site_payload = [];
foreach (($marketing_project_sites ?? []) as $site) {
    $key = $site['marketing_key'] ?? (((int) ($site['marketing_project_id'] ?? 0)) . '|' . ((int) ($site['marketing_site_id'] ?? 0)));
    $marketing_site_payload[$key] = $site;
}
$user_options = array_map(function ($u) {
    return [
        'id_user' => $u['id_user'],
        'nama' => $u['nama']
    ];
}, $users);
$can_manage_project = $can_manage_project ?? true;
$json_flags = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
?>
<style>
.project-offcanvas {
    width: min(680px, 100vw);
}

.project-offcanvas .offcanvas-body {
    background: #f8fafc;
}

.project-form-section {
    background: #fff;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 14px;
}

.project-form-section-title {
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 12px;
}

.project-form-section .form-label {
    font-weight: 600;
}

.project-offcanvas-flatpickr,
.select2-container--open {
    z-index: 20000 !important;
}

.project-offcanvas .select2-container {
    width: 100% !important;
}

.korlap-row {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 8px;
    padding: 10px;
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
            <?php if ($can_manage_project): ?>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="<?= base_url('Project/syncMarketingSites'); ?>" class="btn btn-outline-primary">
                    <i class="ti ti-cloud-download me-1"></i>Get Data Project/Site
                </a>
                <button class="btn btn-custom" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvas-project-add" aria-controls="offcanvas-project-add">
                    <i class="ti ti-circle-plus me-1"></i>Tambah Project
                </button>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="general" class="table bordered-table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Project</th>
                            <th>Nama Project</th>
                            <th>Perusahaan</th>
                            <th>Site</th>
                            <th>Periode</th>
                            <th>Status Get</th>
                            <th>Korlap</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($project as $p): ?>
                        <tr>
                            <td class="text-center" style="width: 3%;"><?= $no++; ?></td>
                            <td style="width: 10%;"><span
                                    class="badge bg-primary-subtle text-primary"><?= html_escape($p['kode_project']); ?></span>
                            </td>
                            <td><?= html_escape($p['nama_project']); ?></td>
                            <td><?= html_escape($p['nama_perusahaan'] ?? '-'); ?></td>
                            <td><?= html_escape($p['nama_site'] ?? '-'); ?></td>
                            <td>
                                <?= !empty($p['tgl_mulai']) ? tanggal_indonesia_medium($p['tgl_mulai']) : '-'; ?> -
                                <?= !empty($p['tgl_selesai']) ? tanggal_indonesia_medium($p['tgl_selesai']) : '-'; ?>
                            </td>
                            <td>
                                <?php if (($p['source'] ?? '') === 'api_project_site'): ?>
                                <span class="badge bg-success-subtle text-success">
                                    <i class="ti ti-circle-check me-1"></i>Sudah Get
                                </span>
                                <?php if (!empty($p['marketing_site_id'])): ?>
                                <small class="d-block text-muted">Site ID:
                                    <?= (int) $p['marketing_site_id']; ?></small>
                                <?php endif; ?>
                                <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary">Manual</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($p['korlap_rows'])): ?>
                                <?php foreach ($p['korlap_rows'] as $korlap): ?>
                                <div class="mb-1">
                                    <span class="fw-semibold"><?= html_escape($korlap['nama'] ?? '-'); ?></span>
                                    <?php if (!empty($korlap['tgl_mulai']) && !empty($korlap['tgl_selesai'])): ?>
                                    <small class="d-block text-muted">
                                        <?= tanggal_indonesia_medium($korlap['tgl_mulai']); ?> -
                                        <?= tanggal_indonesia_medium($korlap['tgl_selesai']); ?>
                                    </small>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                -
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item"
                                                href="<?= base_url('Project/detail/' . rawurlencode($p['kode_project'])); ?>">
                                                <i class="ti ti-eye me-2 text-muted"></i>Detail
                                            </a>
                                        </li>
                                        <?php if ($can_manage_project): ?>
                                        <li>
                                            <a class="dropdown-item btn-edit-project" href="javascript:void(0);"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvas-project-edit"
                                                data-kode="<?= html_escape($p['kode_project']); ?>">
                                                <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item btn-destroy"
                                                href="<?= base_url('Project/destroy/' . $p['kode_project']); ?>">
                                                <i class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete
                                            </a>
                                        </li>
                                        <?php endif; ?>
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

    <div class="offcanvas offcanvas-end project-offcanvas" tabindex="-1" id="offcanvas-project-add"
        aria-labelledby="offcanvas-project-add-label">
        <div class="offcanvas-header border-bottom bg-white">
            <div>
                <h4 id="offcanvas-project-add-label" class="mb-1">Tambah Project</h4>
                <p class="text-muted mb-0">Lengkapi data project, periode, dan korlap.</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-add-project" class="project-form" action="<?= base_url('Project/Store'); ?>" method="post">
                <div class="project-form-section">
                    <div class="project-form-section-title"><i class="ti ti-briefcase"></i>Informasi Project</div>
                    <div class="mb-3">
                        <label for="add_marketing_project_site_key" class="form-label">Project/Site Marketing <span
                                class="text-danger">*</span></label>
                        <input type="hidden" class="js-marketing-key-hidden" name="marketing_project_site_key" value="">
                        <select class="form-select js-marketing-project-site" id="add_marketing_project_site_key"
                            required>
                            <option value="">-- Pilih Project/Site Marketing --</option>
                            <?php foreach (($marketing_project_sites ?? []) as $site): ?>
                            <?php $key = $site['marketing_key'] ?? (((int) ($site['marketing_project_id'] ?? 0)) . '|' . ((int) ($site['marketing_site_id'] ?? 0))); ?>
                            <option value="<?= html_escape($key); ?>">
                                <?= html_escape(($site['nama_client'] ?? '-') . ' | ' . ($site['nama_project'] ?? '-') . ' | ' . ($site['nama_site'] ?? '-') . ' | Marketing: ' . ($site['marketing_name'] ?? '-')); ?>
                                <?= !empty($site['is_synced']) ? ' (Sudah Get)' : ''; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="project-marketing-info bg-light rounded border p-3 mb-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Perusahaan</label>
                                <input type="text" class="form-control bg-white js-info-perusahaan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Marketing</label>
                                <input type="text" class="form-control bg-white js-info-marketing" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Project</label>
                                <input type="text" class="form-control bg-white js-info-project" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Site</label>
                                <input type="text" class="form-control bg-white js-info-site" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control bg-white js-info-provinsi" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-control bg-white js-info-kota" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-3">
                            <label for="add_tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="text" class="form-control js-project-date" id="add_tgl_mulai" name="tgl_mulai"
                                placeholder="Tanggal dari Marketing" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="add_tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control js-project-date" id="add_tgl_selesai"
                                name="tgl_selesai" placeholder="Tanggal dari Marketing" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="add_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="add_deskripsi" name="deskripsi" rows="3"
                            placeholder="Deskripsi project"></textarea>
                    </div>
                </div>
                <div class="project-form-section mb-0">
                    <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                        <div class="project-form-section-title mb-0"><i class="ti ti-users"></i>Data Korlap</div>
                        <button type="button" class="btn btn-sm btn-outline-primary js-add-korlap">
                            <i class="ti ti-plus me-1"></i>Tambah Korlap
                        </button>
                    </div>
                    <div class="js-korlap-container"></div>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center bg-white">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-add-project" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Save
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end project-offcanvas" tabindex="-1" id="offcanvas-project-edit"
        aria-labelledby="offcanvas-project-edit-label">
        <div class="offcanvas-header border-bottom bg-white">
            <div>
                <h4 id="offcanvas-project-edit-label" class="mb-1">Edit Project</h4>
                <p class="text-muted mb-0">Perbarui data project, periode, dan korlap.</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="form-edit-project" class="project-form" action="<?= base_url('Project/update'); ?>" method="post">
                <input type="hidden" name="kode_project" value="">
                <div class="project-form-section">
                    <div class="project-form-section-title"><i class="ti ti-briefcase"></i>Informasi Project</div>
                    <div class="mb-3">
                        <label for="edit_kode_project_display" class="form-label">Kode Project</label>
                        <input type="text" class="form-control" id="edit_kode_project_display" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_marketing_project_site_key" class="form-label">Project/Site Marketing <span
                                class="text-danger">*</span></label>
                        <input type="hidden" class="js-marketing-key-hidden" name="marketing_project_site_key" value="">
                        <select class="form-select js-marketing-project-site" id="edit_marketing_project_site_key"
                            required>
                            <option value="">-- Pilih Project/Site Marketing --</option>
                            <?php foreach (($marketing_project_sites ?? []) as $site): ?>
                            <?php $key = $site['marketing_key'] ?? (((int) ($site['marketing_project_id'] ?? 0)) . '|' . ((int) ($site['marketing_site_id'] ?? 0))); ?>
                            <option value="<?= html_escape($key); ?>">
                                <?= html_escape(($site['nama_client'] ?? '-') . ' | ' . ($site['nama_project'] ?? '-') . ' | ' . ($site['nama_site'] ?? '-') . ' | Marketing: ' . ($site['marketing_name'] ?? '-')); ?>
                                <?= !empty($site['is_synced']) ? ' (Sudah Get)' : ''; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="project-marketing-info bg-light rounded border p-3 mb-3">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label">Perusahaan</label>
                                <input type="text" class="form-control bg-white js-info-perusahaan" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Marketing</label>
                                <input type="text" class="form-control bg-white js-info-marketing" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Project</label>
                                <input type="text" class="form-control bg-white js-info-project" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Site</label>
                                <input type="text" class="form-control bg-white js-info-site" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <input type="text" class="form-control bg-white js-info-provinsi" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota</label>
                                <input type="text" class="form-control bg-white js-info-kota" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="text" class="form-control js-project-date" id="edit_tgl_mulai" name="tgl_mulai"
                                autocomplete="off" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control js-project-date" id="edit_tgl_selesai"
                                name="tgl_selesai" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="project-form-section mb-0">
                    <div class="d-flex align-items-center justify-content-between mb-2 gap-2">
                        <div class="project-form-section-title mb-0"><i class="ti ti-users"></i>Data Korlap</div>
                        <button type="button" class="btn btn-sm btn-outline-primary js-add-korlap">
                            <i class="ti ti-plus me-1"></i>Tambah Korlap
                        </button>
                    </div>
                    <div class="js-korlap-container"></div>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer border-top p-3 d-flex justify-content-between align-items-center bg-white">
            <button type="button" class="btn btn-outline-light" data-bs-dismiss="offcanvas">Cancel</button>
            <button type="submit" form="form-edit-project" class="btn btn-custom">
                <i class="ri-checkbox-circle-line me-1"></i>Update
            </button>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var projectData = <?= json_encode($project_payload, $json_flags); ?>;
        var marketingSiteData = <?= json_encode($marketing_site_payload, $json_flags); ?>;
        var userOptions = <?= json_encode($user_options, $json_flags); ?>;

        function escapeHtml(text) {
            return $('<div>').text(text || '').html();
        }

        function select2Parent($el) {
            var $offcanvas = $el.closest('.offcanvas');
            return $offcanvas.length ? $offcanvas : $(document.body);
        }

        function initProjectSelect2($scope) {
            if (!$.fn.select2) return;
            $scope.find('.js-marketing-project-site').each(function() {
                var $select = $(this);
                if ($select.data('select2')) {
                    $select.select2('destroy');
                }
                $select.select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: select2Parent($select),
                    placeholder: '-- Pilih Project/Site Marketing --',
                    allowClear: true
                });
            });
        }

        function initFlatpickr(container) {
            if (typeof flatpickr === 'undefined') return;
            $(container).find('.js-korlap-date').each(function() {
                if (this._flatpickr) return;
                flatpickr(this, {
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    disableMobile: true,
                    appendTo: document.body,
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.calendarContainer.classList.add(
                            'project-offcanvas-flatpickr');
                    },
                    onOpen: function(selectedDates, dateStr, instance) {
                        instance.calendarContainer.classList.add(
                            'project-offcanvas-flatpickr');
                    }
                });
            });
        }

        function setDate($input, value) {
            var input = $input[0];
            if (input && input._flatpickr) {
                input._flatpickr.setDate(value || null, false, 'Y-m-d');
            } else {
                $input.val(value || '');
            }
        }

        function setSelectValue($select, value) {
            $select.val(value || '').trigger('change.select2');
        }

        function ensureMarketingOption($select, key, data) {
            if (!key || $select.find('option[value="' + key + '"]').length) return;
            var label = [
                data.nama_perusahaan || '-',
                data.nama_project || '-',
                data.nama_site || '-'
            ].join(' | ');
            $select.append('<option value="' + escapeHtml(key) + '">' + escapeHtml(label) + '</option>');
        }

        function applyMarketingProjectSite($form, key, fallback) {
            var data = marketingSiteData[key] || fallback || {};
            $form.find('.js-marketing-key-hidden').val(key || '');
            $form.find('.js-info-perusahaan').val(data.nama_client || data.nama_perusahaan || '');
            $form.find('.js-info-marketing').val(data.marketing_name || '');
            $form.find('.js-info-project').val(data.nama_project || '');
            $form.find('.js-info-site').val(data.nama_site || '');
            $form.find('.js-info-provinsi').val(data.nama_provinsi || '');
            $form.find('.js-info-kota').val(data.nama_kota || '');
            setDate($form.find('[name="tgl_mulai"]'), data.tgl_pelaksanaan || data.tgl_mulai || '');
            setDate($form.find('[name="tgl_selesai"]'), data.tgl_selesai || '');
        }

        function korlapRow(row) {
            row = row || {};
            var options = '<option value="">-- Pilih Korlap --</option>';
            $.each(userOptions || [], function(i, user) {
                var selected = String(user.id_user) === String(row.user_id || '') ? ' selected' : '';
                options += '<option value="' + user.id_user + '"' + selected + '>' + escapeHtml(user
                    .nama) + '</option>';
            });

            return '<div class="korlap-row mb-2">' +
                '<div class="row g-2 align-items-end">' +
                '<div class="col-md-5"><label class="form-label">Korlap</label><select class="form-select" name="korlap_id[]">' +
                options + '</select></div>' +
                '<div class="col-md-3"><label class="form-label">Tgl Mulai</label><input type="text" class="form-control js-korlap-date" name="korlap_tgl_mulai[]" value="' +
                escapeHtml(row.tgl_mulai || '') + '" placeholder="Tgl Mulai"></div>' +
                '<div class="col-md-3"><label class="form-label">Tgl Selesai</label><input type="text" class="form-control js-korlap-date" name="korlap_tgl_selesai[]" value="' +
                escapeHtml(row.tgl_selesai || '') + '" placeholder="Tgl Selesai"></div>' +
                '<div class="col-md-1 d-grid"><button type="button" class="btn btn-outline-danger btn-remove-korlap" aria-label="Hapus korlap"><i class="ti ti-trash"></i></button></div>' +
                '</div>' +
                '</div>';
        }

        function renderKorlap($form, rows) {
            var $container = $form.find('.js-korlap-container');
            $container.empty();
            rows = rows && rows.length ? rows : [{}];
            $.each(rows, function(i, row) {
                $container.append(korlapRow(row));
            });
            updateRemoveButtons($form);
            initFlatpickr($container);
        }

        function updateRemoveButtons($form) {
            var $rows = $form.find('.korlap-row');
            $rows.find('.btn-remove-korlap').toggle($rows.length > 1);
        }

        $(document)
            .off('change.projectOffcanvas', '.project-form .js-marketing-project-site')
            .on('change.projectOffcanvas', '.project-form .js-marketing-project-site', function() {
                var $form = $(this).closest('form');
                applyMarketingProjectSite($form, $(this).val(), {});
            });

        $(document)
            .off('click.projectKorlapAdd', '.project-form .js-add-korlap')
            .on('click.projectKorlapAdd', '.project-form .js-add-korlap', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var button = this;
                if (button.dataset.busy === '1') return;
                button.dataset.busy = '1';
                window.setTimeout(function() {
                    button.dataset.busy = '0';
                }, 250);

                var $form = $(button).closest('form');
                var $container = $form.find('.js-korlap-container');
                $container.append(korlapRow({}));
                updateRemoveButtons($form);
                initFlatpickr($container.find('.korlap-row:last'));
            });

        $(document)
            .off('click.projectKorlapRemove', '.project-form .btn-remove-korlap')
            .on('click.projectKorlapRemove', '.project-form .btn-remove-korlap', function(e) {
                e.preventDefault();
                var $form = $(this).closest('form');
                $(this).closest('.korlap-row').remove();
                updateRemoveButtons($form);
            });

        $('.project-form').each(function() {
            initProjectSelect2($(this));
            initFlatpickr(this);
            renderKorlap($(this), [{}]);
        });

        $('#offcanvas-project-add').off('shown.bs.offcanvas.projectOffcanvas').on(
            'shown.bs.offcanvas.projectOffcanvas',
            function() {
                var $form = $('#form-add-project');
                initProjectSelect2($form);
            });

        $('#offcanvas-project-edit').off('shown.bs.offcanvas.projectOffcanvas').on(
            'shown.bs.offcanvas.projectOffcanvas',
            function() {
                var $form = $('#form-edit-project');
                initProjectSelect2($form);
            });

        $('#offcanvas-project-add').off('show.bs.offcanvas.projectOffcanvas').on(
            'show.bs.offcanvas.projectOffcanvas',
            function() {
                var $form = $('#form-add-project');
                $form[0].reset();
                $form.find('.js-marketing-project-site').prop('disabled', false);
                setSelectValue($form.find('.js-marketing-project-site'), '');
                applyMarketingProjectSite($form, '', {});
                renderKorlap($form, [{}]);
                initFlatpickr($form);
                setDate($form.find('[name="tgl_mulai"]'), '');
                setDate($form.find('[name="tgl_selesai"]'), '');
            });

        $('.btn-edit-project').off('click.projectOffcanvas').on('click.projectOffcanvas', function() {
            var kode = $(this).attr('data-kode') || '';
            var data = projectData[kode] || {};
            var $form = $('#form-edit-project');

            $form[0].reset();
            $form.find('[name="kode_project"]').val(data.kode_project || '');
            $form.find('#edit_kode_project_display').val(data.kode_project || '');
            ensureMarketingOption($form.find('.js-marketing-project-site'), data.marketing_key || '', data);
            $form.find('.js-marketing-project-site').prop('disabled', (data.source || '') === 'api_project_site');
            setSelectValue($form.find('.js-marketing-project-site'), data.marketing_key || '');
            applyMarketingProjectSite($form, data.marketing_key || '', data);
            setDate($form.find('[name="tgl_mulai"]'), data.tgl_mulai || '');
            setDate($form.find('[name="tgl_selesai"]'), data.tgl_selesai || '');
            $form.find('[name="deskripsi"]').val(data.deskripsi || '');
            renderKorlap($form, data.korlap || []);
            initFlatpickr($form);
        });
    });
    </script>
