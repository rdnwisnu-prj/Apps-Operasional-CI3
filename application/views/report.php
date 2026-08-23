<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="d-flex align-items-center gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1"><?= html_escape($subheader); ?></h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);"><?= html_escape($header); ?></a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Laporan</a></li>
                        <li class="breadcrumb-item active"><?= html_escape($subheader); ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card" id="proses-cetak">
            <div class="card-header">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <form action="<?= base_url('Report/exportActivity') ?>" method="post"
                            id="form-export-activity">
                            <div class="row g-3">
                                <div class="col-xl-12">
                                    <div class="row g-3 align-items-end">
                                        <div class="col-xl-3 col-lg-6">
                                            <label class="form-label" for="kode_project">Project/Site</label>
                                            <select class="form-select" name="kode_project" id="kode_project" required>
                                                <option value="">Pilih Project/Site</option>
                                                <?php foreach (($projects ?? []) as $project): ?>
                                                <?php
                                                $siteLabel = $project['nama_site'] ?? '';
                                                $projectLabel = $project['nama_project'] ?? '';
                                                $companyLabel = $project['nama_perusahaan'] ?? '';
                                                $optionLabel = trim($project['kode_project'] . ' - ' . ($siteLabel ?: $projectLabel));
                                                if ($companyLabel !== '') {
                                                    $optionLabel .= ' - ' . $companyLabel;
                                                }
                                                ?>
                                                <option value="<?= html_escape($project['kode_project']); ?>"
                                                    data-tgl-mulai="<?= html_escape($project['tgl_mulai'] ?? ''); ?>"
                                                    data-tgl-selesai="<?= html_escape($project['tgl_selesai'] ?? ''); ?>">
                                                    <?= html_escape($optionLabel); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-6">
                                            <label class="form-label" for="proses">Proses</label>
                                            <select class="form-select" name="proses" id="proses" required>
                                                <option value="">Pilih Proses</option>
                                                <?php foreach (($process_options ?? []) as $value => $label): ?>
                                                <option value="<?= html_escape($value); ?>">
                                                    <?= html_escape($label); ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-6">
                                            <label class="form-label">Tanggal Awal</label>
                                            <input type="text" class="form-control" name="tgl_awal" id="report_tgl_awal"
                                                data-provider="flatpickr" data-date-format="Y-m-d"
                                                placeholder="Pilih Tanggal Awal" required />
                                        </div>
                                        <div class="col-xl-2 col-lg-6">
                                            <label class="form-label">Tanggal Akhir</label>
                                            <input type="text" class="form-control" name="tgl_akhir" id="report_tgl_akhir"
                                                data-provider="flatpickr" data-date-format="Y-m-d"
                                                placeholder="Pilih Tanggal Akhir" required />
                                        </div>
                                        <div class="col-xl-2 col-lg-6">
                                            <div>
                                                <button type="submit" class="btn btn-danger" id="btn-export-excel">
                                                    <i class="ti ti-file-type-pdf me-2 align-bottom"></i> Download PDF
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Informasi</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0">
                    <h6 class="alert-heading"><i class="ri-information-line me-2"></i>Petunjuk Penggunaan</h6>
                    <ul class="mb-0">
                        <li>Pilih <strong>Project/Site</strong> terlebih dahulu agar tanggal mengikuti range project.
                        </li>
                        <li>Pilih <strong>Proses</strong> untuk menentukan scope laporan operasional.</li>
                        <li>Pilih <strong>Tanggal Awal</strong> dan <strong>Tanggal Akhir</strong> untuk menentukan
                            periode laporan operasional.</li>
                        <li>Klik tombol <strong>Download PDF</strong> untuk mengunduh laporan dalam format PDF.
                        </li>
                        <li>Data yang ditampilkan berdasarkan pengeluaran operasional pada project terpilih.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var projectSelect = document.getElementById('kode_project');
        var startInput = document.getElementById('report_tgl_awal');
        var endInput = document.getElementById('report_tgl_akhir');
        var startPicker = null;
        var endPicker = null;

        if (typeof flatpickr !== 'undefined') {
            startPicker = startInput._flatpickr || flatpickr(startInput, {
                dateFormat: 'Y-m-d',
                allowInput: true,
                disableMobile: true
            });
            endPicker = endInput._flatpickr || flatpickr(endInput, {
                dateFormat: 'Y-m-d',
                allowInput: true,
                disableMobile: true
            });
        }

        if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
            $('#kode_project').select2({
                placeholder: 'Pilih Project/Site',
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5'
            });
            $('#proses').select2({
                placeholder: 'Pilih Proses',
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5'
            });
        }

        function setPickerRange() {
            var selected = projectSelect.options[projectSelect.selectedIndex];
            var minDate = selected ? selected.getAttribute('data-tgl-mulai') : '';
            var maxDate = selected ? selected.getAttribute('data-tgl-selesai') : '';

            if (startPicker && endPicker) {
                startPicker.clear();
                endPicker.clear();
                startPicker.set('minDate', minDate || null);
                startPicker.set('maxDate', maxDate || null);
                endPicker.set('minDate', minDate || null);
                endPicker.set('maxDate', maxDate || null);

                if (minDate) {
                    startPicker.setDate(minDate, false, 'Y-m-d');
                }
                if (maxDate) {
                    endPicker.setDate(maxDate, false, 'Y-m-d');
                }
            } else {
                startInput.value = minDate || '';
                endInput.value = maxDate || '';
                startInput.min = minDate || '';
                startInput.max = maxDate || '';
                endInput.min = minDate || '';
                endInput.max = maxDate || '';
            }
        }

        projectSelect.addEventListener('change', setPickerRange);
        if (typeof $ !== 'undefined') {
            $('#kode_project').on('select2:select select2:clear', setPickerRange);
        }
    });
    </script>
