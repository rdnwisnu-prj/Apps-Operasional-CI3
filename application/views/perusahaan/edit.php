<div class="page-wrapper">
    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $subheader; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= $header; ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('Perusahaan'); ?>">Data Perusahaan</a></li>
                    <li class="breadcrumb-item active"><?= $subheader; ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between">
                <h4 class="card-title mb-0 flex-grow-1"><?= $subheader; ?></h4>
                <div class="d-flex align-items-center gap-2">
                    <?php if ($edit_data['source'] == 'api'): ?>
                    <span class="badge bg-info-subtle text-info fs-13">
                        <i class="ti ti-cloud me-1"></i> Sumber: API Marketing
                    </span>
                    <?php else: ?>
                    <span class="badge bg-success-subtle text-success fs-13">
                        <i class="ti ti-pencil me-1"></i> Sumber: Manual
                    </span>
                    <?php endif; ?>
                    <a href="<?= base_url('Perusahaan'); ?>" class="btn btn-custom">
                        <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $errors; ?>
                </div>
                <?php endif; ?>

                <form id="form-edit-perusahaan" action="<?= base_url('Perusahaan/update'); ?>" method="post">
                    <input type="hidden" name="id_perusahaan" value="<?= html_escape($edit_data['id_perusahaan']); ?>">

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_perusahaan">
                            Nama Perusahaan <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                placeholder="Nama Perusahaan"
                                value="<?= set_value('nama_perusahaan', $edit_data['nama_perusahaan']); ?>">
                            <div class="form-text text-danger">
                                <?= form_error('nama_perusahaan'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="no_tlp">No Tlp Perusahaan</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="no_tlp" name="no_tlp"
                                placeholder="Input No Tlp Perusahaan"
                                value="<?= set_value('no_tlp', $edit_data['no_tlp']); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="email">Email Perusahaan</label>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Input Email Perusahaan"
                                value="<?= set_value('email', $edit_data['email']); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="alamat_perusahaan">Alamat Perusahaan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="3"
                                placeholder="Input Alamat Perusahaan"><?= set_value('alamat_perusahaan', $edit_data['alamat_perusahaan']); ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_pic">
                            Nama PIC <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="nama_pic" name="nama_pic"
                                placeholder="Input Nama PIC"
                                value="<?= set_value('nama_pic', $edit_data['nama_pic']); ?>">
                            <div class="form-text text-danger">
                                <?= form_error('nama_pic'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="tlp_pic">No Tlp PIC</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="tlp_pic" name="tlp_pic"
                                placeholder="Input No Tlp PIC"
                                value="<?= set_value('tlp_pic', $edit_data['tlp_pic']); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="marketing_id" class="col-md-2 col-form-label">Marketing</label>
                        <div class="col-md-10">
                            <?php $selected_marketing = set_value('marketing_id', $edit_data['marketing_id']); ?>
                            <select class="form-control" id="marketing_id" name="marketing_id"
                                onchange="updateMarketingName(this)">
                                <option value="">Pilih Marketing</option>
                                <?php foreach ($marketing as $m): ?>
                                <option value="<?= $m['id_user']; ?>" data-nama="<?= htmlspecialchars($m['nama']); ?>"
                                    <?= ((string) $selected_marketing === (string) $m['id_user']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($m['nama']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" id="marketing_name" name="marketing_name"
                                value="<?= set_value('marketing_name', $edit_data['marketing_name']); ?>">
                            <?php if (empty($marketing)): ?>
                            <small class="text-danger d-block mt-1">
                                Data marketing dari API belum tersedia. Pastikan Apps-Marketing berjalan.
                            </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url('Perusahaan'); ?>">Cancel</a>
                <button type="submit" form="form-edit-perusahaan" class="btn btn-custom">
                    <i class="ti ti-device-floppy fs-20 me-1"></i>Update
                </button>
            </div>
        </div>
    </div>

    <script>
    function updateMarketingName(el) {
        var selected = el.options[el.selectedIndex];
        var nama = selected ? (selected.getAttribute('data-nama') || '') : '';
        document.getElementById('marketing_name').value = nama;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var marketingSelect = document.getElementById('marketing_id');
        if (marketingSelect) {
            updateMarketingName(marketingSelect);
        }
    });
    </script>
</div>