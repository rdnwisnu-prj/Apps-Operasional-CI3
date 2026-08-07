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
                <h4 class="card-title mb-0 flex-grow-1">Edit <?= $subheader?> </h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url()?>Benefit" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="id_benefit" value="<?= $benefit['id_benefit'] ?>">
                    <input type="hidden" name="created_at" value="<?= $benefit['created_at']; ?>">

                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Pilih Client <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id">
                                <option value="">Pilih Client</option>
                                <?php foreach ($clients as $cl): ?>
                                <option value="<?= $cl['id_client']; ?>"
                                    <?= ($cl['id_client'] == $benefit['client_id']) ? 'selected' : ''; ?>>
                                    <?= $cl['nama_client']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('client_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="project_id" class="col-md-2 col-form-label">Pilih Project <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="project_id" name="project_id">
                                <option value="">Pilih Client Terlebih Dahulu</option>
                                <?php foreach ($projects as $p): ?>
                                <?php if ($p['client_id'] == $benefit['client_id']): ?>
                                <option value="<?= $p['id_project']; ?>"
                                    <?= ($p['id_project'] == $benefit['project_id']) ? 'selected' : ''; ?>>
                                    <?= $p['nama_project']; ?> (<?= $p['service']; ?>)</option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('project_id') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="nama_benefit">Nama Benefit <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="nama_benefit" name="nama_benefit">
                                <option value="">Pilih Benefit</option>
                                <option value="Presentasi"
                                    <?= ($benefit['nama_benefit'] == 'Presentasi') ? 'selected' : '' ?>>
                                    Presentasi</option>
                                <option value="Konsultasi"
                                    <?= ($benefit['nama_benefit'] == 'Konsultasi') ? 'selected' : '' ?>>
                                    Konsultasi</option>
                                <option value="Health Talk"
                                    <?= ($benefit['nama_benefit'] == 'Health Talk') ? 'selected' : '' ?>>
                                    Health Talk</option>
                                <option value="Banner" <?= ($benefit['nama_benefit'] == 'Banner') ? 'selected' : '' ?>>
                                    Banner
                                </option>
                                <option value="Plakat" <?= ($benefit['nama_benefit'] == 'Plakat') ? 'selected' : '' ?>>
                                    Plakat
                                </option>
                                <option value="Training P3K"
                                    <?= ($benefit['nama_benefit'] == 'Training P3K') ? 'selected' : '' ?>>
                                    Training P3K
                                </option>
                                <option value="Analisa PAK"
                                    <?= ($benefit['nama_benefit'] == 'Analisa PAK') ? 'selected' : '' ?>>
                                    Analisa PAK</option>
                                <option value="WTS" <?= ($benefit['nama_benefit'] == 'WTS') ? 'selected' : '' ?>>WTS
                                </option>
                                <option value="Wellness"
                                    <?= ($benefit['nama_benefit'] == 'Wellness') ? 'selected' : '' ?>>
                                    Wellness
                                </option>
                                <option value="Analisa MCU"
                                    <?= ($benefit['nama_benefit'] == 'Analisa MCU') ? 'selected' : '' ?>>
                                    Analisa MCU
                                </option>
                                <option value="Kotak P3K"
                                    <?= ($benefit['nama_benefit'] == 'Kotak P3K') ? 'selected' : '' ?>>Kotak
                                    P3K
                                </option>
                                <option value="Uji Lingkungan"
                                    <?= ($benefit['nama_benefit'] == 'Uji Lingkungan') ? 'selected' : '' ?>>
                                    Uji Lingkungan
                                </option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('nama_benefit') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="status_benefit">Status Benefit <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="status_benefit" name="status_benefit">
                                <option value="">Pilih Status</option>
                                <option value="Berjalan"
                                    <?= ($benefit['status_benefit'] == 'Berjalan') ? 'selected' : '' ?>>
                                    Berjalan</option>
                                <option value="Tidak Berjalan"
                                    <?= ($benefit['status_benefit'] == 'Tidak Berjalan') ? 'selected' : '' ?>>
                                    Tidak Berjalan</option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('status_benefit') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="entitas">Entitas <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="entitas" name="entitas">
                                <option value="">Pilih Entitas</option>
                                <option value="Cakra Medika"
                                    <?= ($benefit['entitas'] == 'Cakra Medika') ? 'selected' : '' ?>>Cakra
                                    Medika</option>
                                <option value="Konsehat" <?= ($benefit['entitas'] == 'Konsehat') ? 'selected' : '' ?>>
                                    Konsehat
                                </option>
                            </select>
                            <div class="form-text text-danger">
                                <?= form_error('entitas') ?>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_benefit_mulai" class="col-md-2 col-form-label">Tanggal Mulai Benefit
                        </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_benefit_mulai" name="tgl_benefit_mulai"
                                    placeholder="Input Tanggal Mulai Benefit"
                                    value="<?= isset($benefit['tgl_benefit_mulai']) ? $benefit['tgl_benefit_mulai'] : '' ?>">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tgl_benefit_selesai" class="col-md-2 col-form-label">Tanggal Selesai
                            Benefit
                        </label>
                        <div class="col-md-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="tgl_benefit_selesai"
                                    name="tgl_benefit_selesai" placeholder="Input Tanggal Selesai Benefit"
                                    value="<?= isset($benefit['tgl_benefit_selesai']) ? $benefit['tgl_benefit_selesai'] : '' ?>">
                                <i class="ti ti-calendar-event"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Input Keterangan"><?= isset($benefit['keterangan']) ? $benefit['keterangan'] : '' ?></textarea>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const clientSelect = document.getElementById('client_id');
        const projectSelect = document.getElementById('project_id');
        const currentProjectId = '<?= $cros['project_id']; ?>';

        // Store all projects data
        const allProjects = <?= json_encode($projects); ?>;

        clientSelect.addEventListener('change', function() {
            const clientId = this.value;

            // Clear project select
            projectSelect.innerHTML = '<option value="">Pilih Project</option>';

            if (clientId) {
                // Filter projects by client_id
                const filteredProjects = allProjects.filter(p => p.client_id == clientId);

                filteredProjects.forEach(function(project) {
                    const option = document.createElement('option');
                    option.value = project.id_project;
                    option.textContent = project.nama_project + ' (' + project.service +
                        ')';
                    projectSelect.appendChild(option);
                });
            }
        });
    });
    </script>