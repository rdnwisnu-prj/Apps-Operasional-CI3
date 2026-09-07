<?php
$proses_options = $proses_options ?? [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
$nominalValue = isset($edit_data) ? ($edit_data['nominal'] ?? 0) : set_value('nominal', 0);
?>
<div class="page-wrapper">
    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= html_escape($subheader); ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                    <li class="breadcrumb-item active"><?= html_escape($subheader); ?></li>
                </ol>
            </nav>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= $errors; ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0"><?= isset($edit_data) ? 'Edit' : 'Tambah'; ?>
                            <?= html_escape($subheader); ?></h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('TopUpSaldo/update') : base_url('TopUpSaldo/create'); ?>"
                            method="post">
                            <?php if (isset($edit_data)): ?>
                            <input type="hidden" name="id_topup" value="<?= (int) $edit_data['id_topup']; ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="project" class="form-label">Project <span
                                        class="text-danger">*</span></label>
                                <?php $selectedProject = isset($edit_data) ? ($edit_data['project'] ?? '') : set_value('project'); ?>
                                <select id="project" name="project"
                                    class="form-control <?= form_error('project') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Project --</option>
                                    <?php foreach ($project as $p): ?>
                                    <option value="<?= html_escape($p['kode_project']); ?>"
                                        <?= (string) $selectedProject === (string) $p['kode_project'] ? 'selected' : ''; ?>>
                                        <?= html_escape($p['nama_perusahaan'] . ' - ' . $p['nama_site']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= form_error('project'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="proses" class="form-label">Proses <span class="text-danger">*</span></label>
                                <?php $selectedProses = isset($edit_data) ? ($edit_data['proses'] ?? '') : set_value('proses'); ?>
                                <select id="proses" name="proses"
                                    class="form-control <?= form_error('proses') ? 'is-invalid' : ''; ?>" required>
                                    <option value="">-- Pilih Proses --</option>
                                    <?php foreach ($proses_options as $value => $label): ?>
                                    <option value="<?= html_escape($value); ?>"
                                        <?= (string) $selectedProses === (string) $value ? 'selected' : ''; ?>>
                                        <?= html_escape($label); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"><?= form_error('proses'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="tgl_topup" class="form-label">Tanggal Penambahan <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control js-topup-date <?= form_error('tgl_topup') ? 'is-invalid' : ''; ?>"
                                    id="tgl_topup" name="tgl_topup"
                                    value="<?= html_escape(isset($edit_data) ? ($edit_data['tgl_topup'] ?? '') : set_value('tgl_topup', date('Y-m-d'))); ?>"
                                    autocomplete="off" required>
                                <div class="invalid-feedback"><?= form_error('tgl_topup'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="nominal_display" class="form-label">Nominal Top Up <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text"
                                        class="form-control js-money-display <?= form_error('nominal') ? 'is-invalid' : ''; ?>"
                                        id="nominal_display"
                                        value="<?= $nominalValue ? number_format((float) $nominalValue, 0, ',', '.') : ''; ?>"
                                        placeholder="0" autocomplete="off" required>
                                    <input type="hidden" id="nominal" name="nominal"
                                        value="<?= html_escape($nominalValue); ?>">
                                </div>
                                <div class="invalid-feedback"><?= form_error('nominal'); ?></div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                                    placeholder="Catatan penambahan saldo"><?= html_escape(isset($edit_data) ? ($edit_data['keterangan'] ?? '') : set_value('keterangan')); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <?php if (isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100"><i
                                                class="ri-checkbox-circle-line fs-20 me-1"></i>Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('TopUpSaldo'); ?>" class="btn btn-light w-100">Batal</a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <button type="submit" class="btn btn-custom w-100"><i
                                        class="ri-checkbox-circle-line fs-20 me-1"></i>Save</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data <?= html_escape($subheader); ?></h5>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Proses</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Nominal</th>
                                    <th>Keterangan</th>
                                    <th>Input Oleh</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($topup as $row): ?>
                                <tr>
                                    <td class="text-center" style="width:5%;"><?= $no++; ?></td>
                                    <td>
                                        <span
                                            class="badge bg-primary-subtle text-primary me-1"><?= html_escape($row['project']); ?></span>
                                        <?= html_escape($row['nama_project'] ?? '-'); ?>
                                    </td>
                                    <td><?= html_escape($proses_options[(string) ($row['proses'] ?? '')] ?? '-'); ?>
                                    </td>
                                    <td><?= !empty($row['tgl_topup']) ? tanggal_indonesia_medium($row['tgl_topup']) : '-'; ?>
                                    </td>
                                    <td class="text-end">Rp
                                        <?= number_format((float) ($row['nominal'] ?? 0), 0, ',', '.'); ?></td>
                                    <td><?= html_escape($row['keterangan'] ?? '-'); ?></td>
                                    <td><?= html_escape($row['created_by'] ?? '-'); ?></td>
                                    <td class="text-end">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('TopUpSaldo/edit/' . $row['id_topup']); ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('TopUpSaldo/destroy/' . $row['id_topup']); ?>">
                                                        <i
                                                            class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete
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
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function cleanNumber(value) {
        return (value || '').toString().replace(/[^0-9]/g, '');
    }

    function displayNumber(value) {
        var number = cleanNumber(value);
        return number ? number.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    }

    var display = document.getElementById('nominal_display');
    var hidden = document.getElementById('nominal');

    if (display && hidden) {
        display.addEventListener('input', function() {
            var raw = cleanNumber(display.value);
            display.value = displayNumber(raw);
            hidden.value = raw || '0';
        });
        hidden.value = cleanNumber(hidden.value) || '0';
        display.value = displayNumber(display.value || hidden.value);
    }

    if (typeof flatpickr !== 'undefined') {
        flatpickr('.js-topup-date', {
            dateFormat: 'Y-m-d',
            allowInput: true,
            disableMobile: true
        });
    }
});
</script>