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
                    <a href="<?= base_url()?>Benefit" class="btn btn-custom"><i
                            class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="post">

                    <div class="row mb-3">
                        <label for="client_id" class="col-md-2 col-form-label">Pilih Client <span
                                class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="client_id" name="client_id">
                                <option value="">Pilih Client</option>
                                <?php foreach ($clients as $cl): ?>
                                <option value="<?= $cl['id_client']; ?>" <?= (isset($selected_client) && $selected_client == $cl['id_client']) ? 'selected' : '' ?>><?= $cl['nama_client']; ?></option>
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
                                <option value="Presentasi">Presentasi</option>
                                <option value="Konsultasi">Konsultasi</option>
                                <option value="Health Talk">Health Talk</option>
                                <option value="Banner">Banner</option>
                                <option value="Plakat">Plakat</option>
                                <option value="Training P3K">Training P3K</option>
                                <option value="Analisa PAK">Analisa PAK</option>
                                <option value="WTS">WTS</option>
                                <option value="Wellness">Wellness</option>
                                <option value="Analisa MCU">Analisa MCU</option>
                                <option value="Kotak P3K">Kotak P3K</option>
                                <option value="Uji Lingkungan">Uji Lingkungan</option>
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
                                <option value="Berjalan">Berjalan</option>
                                <option value="Tidak Berjalan">Tidak Berjalan</option>
                                <option value="Selesai">Selesai</option>
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
                                <option value="Cakra Medika">Cakra Medika</option>
                                <option value="Konsehat">Konsehat</option>
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
                                    placeholder="Input Tanggal Mulai Benefit">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
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
                                    name="tgl_benefit_selesai" placeholder="Input Tanggal Selesai Benefit">
                                <div class="input-group-text">
                                    <i class="ti ti-calendar-event"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <label class="col-md-2 col-form-label" for="keterangan">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Input Keterangan"></textarea>
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
    $(document).ready(function() {
        // Function to load projects by client
        function loadProjectsByClient(clientId) {
            if (clientId) {
                $('#project_id').html('<option value="">Memuat project...</option>');

                $.ajax({
                    url: '<?= base_url() ?>Benefit/getProjectByClient/' + clientId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(projects) {
                        let options = '<option value="">Pilih Project</option>';

                        if (projects.length > 0) {
                            $.each(projects, function(index, project) {
                                options +=
                                    `<option value="${project.id_project}">${project.nama_project}</option>`;
                            });
                        } else {
                            options =
                                '<option value="">Tidak ada project untuk client ini</option>';
                        }

                        $('#project_id').html(options);

                        // Refresh Choices.js jika digunakan
                        if ($('#project_id').data('choices')) {
                            $('#project_id').data('choices').destroy();
                            new Choices('#project_id');
                        }
                    },
                    error: function() {
                        $('#project_id').html(
                            '<option value="">Gagal memuat data project</option>');
                    }
                });
            } else {
                $('#project_id').html('<option value="">Pilih Client Terlebih Dahulu</option>');
            }
        }

        // On client change
        $('#client_id').on('change', function() {
            const clientId = $(this).val();
            $('#project_id').html('<option value="">Pilih Project</option>');
            loadProjectsByClient(clientId);
        });

        // Auto-load projects if client is pre-selected
        var selectedClient = $('#client_id').val();
        if (selectedClient) {
            loadProjectsByClient(selectedClient);
        }
    });
    </script>