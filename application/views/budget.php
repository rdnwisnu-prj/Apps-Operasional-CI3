<?php
$proses_options = $proses_options ?? [
    '1' => 'Setting MCU',
    '2' => 'Pelaksanaan MCU',
    '3' => 'Bongkar Setting',
    '4' => 'Kirim Hasil',
];
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
            <h4 class="mb-1"><?= $subheader;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader;?></li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                            <?php echo $subheader;?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= isset($edit_data) ? base_url('Budget/update') : base_url('Budget/create') ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_budget" value="<?= $edit_data['id_budget'] ?>">
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="project" class="form-label">Project <span class="text-danger">
                                        *</span></label>
                                <select id="project" name="project" class="form-control">
                                    <option value="">-- Pilih Project --</option>
                                    <?php foreach ($project as $p): ?>
                                    <option value="<?= $p['kode_project'] ?>"
                                        <?= (isset($edit_data) && $edit_data['project'] == $p['kode_project']) ? 'selected' : set_select('project', $p['kode_project']) ?>>
                                        <?= html_escape($p['nama_perusahaan'] . ' - ' . $p['nama_site']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('project') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="proses" class="form-label">Proses <span class="text-danger">
                                        *</span></label>
                                <?php $selected_proses = isset($edit_data) ? ($edit_data['proses'] ?? '') : set_value('proses'); ?>
                                <select id="proses" name="proses"
                                    class="form-control <?= form_error('proses') ? 'is-invalid' : '' ?>">
                                    <option value="">-- Pilih Proses --</option>
                                    <?php foreach ($proses_options as $value => $label): ?>
                                    <option value="<?= html_escape($value); ?>"
                                        <?= (string) $selected_proses === (string) $value ? 'selected' : ''; ?>>
                                        <?= html_escape($label); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('proses') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="total_budget" class="form-label">Total Budget <span class="text-danger">
                                        *</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input type="text"
                                        class="form-control format-number <?= form_error('total_budget') ? 'is-invalid' : '' ?>"
                                        id="total_budget_display" placeholder="Input Estimasi Prospek"
                                        autocomplete="off"
                                        value="<?= isset($edit_data) ? $edit_data['total_budget'] : set_value('total_budget') ?>" />
                                    <input type="hidden" id="total_budget" name="total_budget" value="0" />
                                </div>
                                <div class="invalid-feedback">
                                    <?= form_error('total_budget') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" class="form-control" rows="3"
                                    placeholder="Enter Keterangan"><?= isset($edit_data) ? $edit_data['keterangan'] : set_value('keterangan') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100"><i
                                                class="ri-checkbox-circle-line fs-20 me-1"></i>Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Budget') ?>" class="btn btn-light w-100">Batal</a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <button type="submit" class="btn btn-custom w-100"><i
                                        class="ri-checkbox-circle-line fs-20 me-1"></i> Save</button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data <?= $subheader;?></h5>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Proses</th>
                                    <th>Jumlah Budget</th>
                                    <th>Keterangan</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($budget as $b): ?>
                                <tr>
                                    <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $b['nama_project']; ?></td>
                                    <td><?= html_escape($proses_options[(string) ($b['proses'] ?? '')] ?? '-'); ?></td>
                                    <td>Rp
                                        <?= number_format($b['total_budget'], 0, ',', '.'); ?>
                                    </td>
                                    <td><?= $b['keterangan']; ?></td>
                                    <td class="text-end">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Budget/edit/<?= $b['id_budget']; ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Budget/destroy/' . $b['id_budget']); ?>">
                                                        <i
                                                            class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a>
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