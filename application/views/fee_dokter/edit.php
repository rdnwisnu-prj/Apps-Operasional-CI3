<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <?php
    $baseRoute = $base_route ?? 'FeeDokter';
    $pageLabel = $page_label ?? 'Fee Dokter';
    $showProject = $show_project ?? true;
    $bankOptions = [
        'BCA', 'Mandiri', 'BNI', 'BSI', 'BRI', 'BTN', 'CIMB Niaga', 'Danamon', 'Permata',
        'Maybank Indonesia', 'Blu (BCA Digital)', 'Panin', 'OCBC Indonesia', 'Bank Mega',
        'Bank BTPN', 'Sinarmas', 'Mayapada', 'Victoria', 'Hana Bank', 'Muamalat',
        'BCA Syariah', 'Bank DKI', 'Bank BJB', 'Bank Jateng', 'Bank Jatim', 'Bank Sumut',
        'Bank Jago', 'SeaBank'
    ];
    $selectedDokterId = set_value('dokter_id', $edit_data['dokter_id'] ?? '');
    if (empty($selectedDokterId)) {
        foreach ($dokter as $d) {
            if (strtoupper(trim($d['nama_dokter'])) === strtoupper(trim($edit_data['nama_dokter'] ?? ''))) {
                $selectedDokterId = $d['id_dokter'];
                break;
            }
        }
    }
    $oldTanggal = set_value('tgl_project', $edit_data['tgl_project'] ?? '');
    $existingRekening = [];
    foreach ($rekening as $rek) {
        $existingRekening[] = [
            'bank'       => $rek['bank'] ?? '',
            'no_rek'     => $rek['no_rek'] ?? '',
            'atas_nama'  => $rek['atas_nama'] ?? '',
            'kcp'        => $rek['kcp'] ?? '',
            'is_active'  => (int) ($rek['is_active'] ?? 0),
        ];
    }
    ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $subheader; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= $header; ?></a></li>
                    <li class="breadcrumb-item"><a
                            href="<?= base_url($baseRoute); ?>"><?= html_escape($pageLabel); ?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader; ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1"><?= $subheader; ?></h4>
                <div class="flex-shrink-0">
                    <a href="<?= base_url($baseRoute); ?>" class="btn btn-custom">
                        <i class="ri-arrow-left-circle-line align-bottom me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form id="form-edit-fee" action="<?= base_url($baseRoute . '/update'); ?>" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="id_fee" value="<?= (int) $edit_data['id_fee']; ?>">

                    <?php if ($showProject): ?>
                    <div class="row mb-3">
                        <label for="project" class="col-form-label col-lg-2">Project <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('project') ? 'is-invalid' : ''; ?>" id="project"
                                name="project">
                                <option value="">-- Pilih Project --</option>
                                <?php foreach ($projects as $p): ?>
                                <option value="<?= html_escape($p['kode_project']); ?>"
                                    <?= set_select('project', $p['kode_project'], ($edit_data['project'] ?? '') === $p['kode_project']); ?>>
                                    <?= html_escape($p['kode_project'] . ' - ' . $p['nama_project']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('project'); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row mb-3">
                        <label for="tgl_project" class="col-form-label col-lg-2">Tanggal <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <input type="text"
                                class="form-control <?= form_error('tgl_project') ? 'is-invalid' : ''; ?>"
                                id="tgl_project" name="tgl_project" value="<?= html_escape($oldTanggal); ?>"
                                placeholder="Pilih tanggal" autocomplete="off">
                            <div class="invalid-feedback"><?= form_error('tgl_project'); ?></div>
                            <small class="text-muted" id="date-range-info">Tanggal tidak dibatasi oleh project.</small>
                        </div>
                        <label for="cabang" class="col-form-label col-lg-2">Cabang <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-4">
                            <select class="form-control <?= form_error('cabang') ? 'is-invalid' : ''; ?>" id="cabang"
                                name="cabang">
                                <option value="">-- Pilih Cabang --</option>
                                <?php foreach ($cabang as $c): ?>
                                <option value="<?= (int) $c['id_cabang']; ?>"
                                    <?= set_select('cabang', $c['id_cabang'], (string) ($edit_data['cabang'] ?? '') === (string) $c['id_cabang']); ?>>
                                    <?= html_escape($c['nama_cabang']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('cabang'); ?></div>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="ti ti-stethoscope me-1"></i> Data Dokter</h5>

                    <div class="row mb-3">
                        <label for="dokter_id" class="col-form-label col-lg-2">Nama Dokter <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <select class="form-select <?= form_error('dokter_id') ? 'is-invalid' : ''; ?>"
                                id="dokter_id" name="dokter_id">
                                <option value="">-- Pilih Dokter --</option>
                                <?php foreach ($dokter as $d): ?>
                                <option value="<?= (int) $d['id_dokter']; ?>"
                                    data-bank="<?= html_escape($d['bank']); ?>"
                                    data-no-rekening="<?= html_escape($d['no_rekening']); ?>"
                                    data-atas-nama="<?= html_escape($d['atas_nama']); ?>"
                                    data-kcp="<?= html_escape($d['kcp']); ?>"
                                    data-ktp="<?= html_escape($d['ktp'] ?? ''); ?>"
                                    <?= set_select('dokter_id', $d['id_dokter'], (string) $selectedDokterId === (string) $d['id_dokter']); ?>>
                                    <?= html_escape($d['nama_dokter']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= form_error('dokter_id'); ?></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="spesialis" class="col-form-label col-lg-2">Spesialis</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="spesialis" name="spesialis">
                                <option value="">-- Pilih Spesialis --</option>
                                <?php foreach (['dr. Sp.PD','dr. Sp.Paru','dr. Sp.Jantung','dr. Sp.Mata','dr. Sp.THT','dr. Sp.Urologi','dr. Sp. Gizi','dr. Sp.KFR','dr. Sp.Orthopedi','dr. Sp.Bedah','dr. Sp.Psikiatri','dr. Sp.KK','dr. Gigi','dr. Umum','Radiologi','Dokter Sp. OK','Dokter Sp. PK'] as $sp): ?>
                                <option value="<?= html_escape($sp); ?>"
                                    <?= set_select('spesialis', $sp, ($edit_data['spesialis'] ?? '') === $sp); ?>>
                                    <?= html_escape($sp); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="ktp" class="col-form-label col-lg-2">No. KTP</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control bg-light" id="ktp" name="ktp" placeholder="No. KTP"
                                value="<?= set_value('ktp', $edit_data['ktp'] ?? ''); ?>" readonly>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="ti ti-building-bank me-1"></i> Rekening Utama Dokter</h5>

                    <div class="row g-3 mb-3">
                        <div class="col-lg-3">
                            <label class="form-label small">Bank</label>
                            <input type="text" class="form-control bg-light" id="dokter_bank" readonly
                                value="<?= html_escape($edit_data['bank'] ?? ''); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label small">No. Rekening</label>
                            <input type="text" class="form-control bg-light" id="dokter_no_rekening" readonly
                                value="<?= html_escape($edit_data['no_rek'] ?? ''); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label small">Atas Nama</label>
                            <input type="text" class="form-control bg-light" id="dokter_atas_nama" readonly
                                value="<?= html_escape($edit_data['atas_nama'] ?? ''); ?>">
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label small">KCP</label>
                            <input type="text" class="form-control bg-light" id="dokter_kcp" readonly
                                value="<?= html_escape($edit_data['kcp'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0"><i class="ti ti-credit-card me-1"></i> Rekening Tambahan</h5>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-rek">
                            <i class="ti ti-plus me-1"></i>Tambah Rekening
                        </button>
                    </div>
                    <div id="rekening-container"></div>
                    <p class="text-muted mb-0" id="rekening-empty-info">Belum ada rekening tambahan.</p>

                    <hr>
                    <h5 class="mb-3"><i class="ti ti-calculator me-1"></i> Perhitungan Fee</h5>

                    <div class="row mb-3">
                        <label for="jumlah_hari" class="col-form-label col-lg-2">Jumlah Hari</label>
                        <div class="col-lg-4">
                            <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari"
                                placeholder="0" min="0"
                                value="<?= set_value('jumlah_hari', $edit_data['jumlah_hari'] ?? '0'); ?>">
                        </div>
                        <label for="fee_display" class="col-form-label col-lg-2">Fee / Hari (Rp)</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control format-number" id="fee_display" placeholder="0"
                                    autocomplete="off">
                                <input type="hidden" id="fee" name="fee"
                                    value="<?= set_value('fee', $edit_data['fee'] ?? '0'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis_biaya_tambahan" class="col-form-label col-lg-2">Biaya Tambahan</label>
                        <div class="col-lg-4">
                            <select class="form-select" id="jenis_biaya_tambahan" name="jenis_biaya_tambahan">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Lembur"
                                    <?= set_select('jenis_biaya_tambahan', 'Lembur', ($edit_data['jenis_biaya_tambahan'] ?? '') === 'Lembur'); ?>>
                                    Lembur</option>
                                <option value="Lain-Lain"
                                    <?= set_select('jenis_biaya_tambahan', 'Lain-Lain', ($edit_data['jenis_biaya_tambahan'] ?? '') === 'Lain-Lain'); ?>>
                                    Lain-Lain</option>
                            </select>
                        </div>
                        <label for="biaya_tambahan_display" class="col-form-label col-lg-2">Nominal (Rp)</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control format-number" id="biaya_tambahan_display"
                                    placeholder="0" autocomplete="off">
                                <input type="hidden" id="biaya_tambahan" name="biaya_tambahan"
                                    value="<?= set_value('biaya_tambahan', $edit_data['biaya_tambahan'] ?? '0'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="total_display" class="col-form-label col-lg-2">Total Fee (Rp) <span
                                class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text"
                                    class="form-control format-number <?= form_error('total') ? 'is-invalid' : ''; ?>"
                                    id="total_display" placeholder="0" autocomplete="off">
                                <input type="hidden" id="total" name="total"
                                    value="<?= set_value('total', $edit_data['total'] ?? '0'); ?>">
                            </div>
                            <div class="invalid-feedback"><?= form_error('total'); ?></div>
                            <small class="text-muted">Total otomatis dari (Jumlah Hari x Fee) + Biaya Tambahan, dan
                                masih bisa disesuaikan manual.</small>
                        </div>
                    </div>

                    <hr>
                    <h5 class="mb-3"><i class="ti ti-receipt-tax me-1"></i> Pajak PPH21</h5>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2">Jenis Pajak <span class="text-danger">*</span></label>
                        <div class="col-lg-10">
                            <div class="d-flex gap-4 pt-1 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pph21" id="pajak_pph21" value="1"
                                        <?= set_value('pph21', (string) ($edit_data['pph21'] ?? '1')) === '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="pajak_pph21">
                                        <strong>PPH21</strong>
                                        <small class="text-muted d-block">Pajak 2.5% dipotong dari total fee.</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="pph21" id="pajak_nonpph21"
                                        value="0"
                                        <?= set_value('pph21', (string) ($edit_data['pph21'] ?? '1')) === '0' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="pajak_nonpph21">
                                        <strong>Non-PPH21</strong>
                                        <small class="text-muted d-block">Diterima dokter dihitung dari Total Fee /
                                            97.5%.</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-form-label col-lg-2">Nominal Pajak</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control bg-light" id="preview_pajak" readonly value="Rp 0">
                        </div>
                        <label class="col-form-label col-lg-2">Diterima Dokter</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control bg-light" id="preview_diterima" readonly
                                value="Rp 0">
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <label for="lampiran" class="col-form-label col-lg-2">Lampiran</label>
                        <div class="col-lg-10">
                            <input type="file" class="form-control" id="lampiran" name="lampiran"
                                accept=".jpg,.jpeg,.png">
                            <?php if (!empty($edit_data['lampiran'])): ?>
                            <a href="<?= base_url('uploads/lampiran/' . $edit_data['lampiran']); ?>" target="_blank"
                                class="d-inline-block mt-2">
                                <i class="ti ti-photo me-1"></i>Lihat lampiran saat ini
                            </a>
                            <?php endif; ?>
                            <small class="text-muted d-block">Format: JPG, JPEG, PNG. Maksimal 5MB.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="keterangan" class="col-form-label col-lg-2">Keterangan</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Keterangan"><?= set_value('keterangan', $edit_data['keterangan'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer border-top d-flex justify-content-between align-items-center">
                <a href="<?= base_url($baseRoute); ?>">Cancel</a>
                <button type="submit" form="form-edit-fee" class="btn btn-custom">
                    <i class="ri-checkbox-circle-line me-1"></i>Update
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var showProject = <?= $showProject ? 'true' : 'false'; ?>;
        var projectDates = {};
        var oldDate = '<?= html_escape($oldTanggal); ?>';
        var existingRekening = <?= json_encode($existingRekening); ?>;

        <?php foreach (($projects ?? []) as $p): ?>
        projectDates['<?= html_escape($p['kode_project']); ?>'] = {
            tgl_mulai: '<?= html_escape($p['tgl_mulai']); ?>',
            tgl_selesai: '<?= html_escape($p['tgl_selesai']); ?>'
        };
        <?php endforeach; ?>

        var tglProjectPicker = null;

        if (typeof flatpickr !== 'undefined') {
            tglProjectPicker = flatpickr('#tgl_project', {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd M Y',
                allowInput: false,
                clickOpens: true,
                disableMobile: true
            });
        }

        if (typeof $.fn.select2 !== 'undefined') {
            if (showProject) {
                $('#project').select2({
                    theme: 'bootstrap-5',
                    placeholder: '-- Pilih Project --',
                    allowClear: true,
                    width: '100%'
                });
            }

            $('#dokter_id').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Dokter --',
                allowClear: true,
                width: '100%'
            });
        }

        function rupiah(value) {
            value = Math.round(parseFloat(value) || 0);
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function setMoney($display, $hidden, value) {
            value = Math.round(parseFloat(value) || 0);
            $hidden.val(value);
            $display.val(value > 0 ? value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '');
        }

        function updateProjectDateRange() {
            var kode = $('#project').val();
            var $tgl = $('#tgl_project');
            var $info = $('#date-range-info');

            $tgl.removeAttr('min').removeAttr('max').prop('disabled', false);
            if (tglProjectPicker) {
                tglProjectPicker.set('minDate', null);
                tglProjectPicker.set('maxDate', null);
                tglProjectPicker.set('clickOpens', true);
                if (tglProjectPicker.altInput) {
                    tglProjectPicker.altInput.disabled = false;
                }
                if (oldDate) {
                    tglProjectPicker.setDate(oldDate, false, 'Y-m-d');
                    oldDate = '';
                }
            } else if (oldDate) {
                $tgl.val(oldDate);
                oldDate = '';
            }

            $info.text('Tanggal tidak dibatasi oleh project.');
        }

        function updateDoctorAccount() {
            var $selected = $('#dokter_id option:selected');
            $('#dokter_bank').val($selected.data('bank') || '');
            $('#dokter_no_rekening').val($selected.data('no-rekening') || '');
            $('#dokter_atas_nama').val($selected.data('atas-nama') || '');
            $('#dokter_kcp').val($selected.data('kcp') || '');
            $('#ktp').val($selected.data('ktp') || '');
        }

        function hitungPajak() {
            var total = parseFloat($('#total').val()) || 0;
            var jenisPajak = $('input[name="pph21"]:checked').val();
            var nominalPajak = 0;
            var diterima = 0;

            if (jenisPajak === '1') {
                nominalPajak = total * 0.025;
                diterima = total - nominalPajak;
            } else {
                diterima = total / 0.975;
                nominalPajak = diterima - total;
            }

            $('#preview_pajak').val(rupiah(nominalPajak));
            $('#preview_diterima').val(rupiah(diterima));
        }

        function hitungTotal() {
            var jumlahHari = parseFloat($('#jumlah_hari').val()) || 0;
            var fee = parseFloat($('#fee').val()) || 0;
            var tambahan = parseFloat($('#biaya_tambahan').val()) || 0;
            var total = (jumlahHari * fee) + tambahan;

            setMoney($('#total_display'), $('#total'), total);
            hitungPajak();
        }

        function toggleEmptyInfo() {
            $('#rekening-empty-info').toggle($('#rekening-container .rekening-row').length === 0);
        }

        var rekIndex = 0;
        var bankOptions =
            `<?php foreach ($bankOptions as $bank): ?><option value="<?= html_escape($bank); ?>"><?= html_escape($bank); ?></option><?php endforeach; ?>`;

        function addRekeningRow(data) {
            data = data || {};
            var checked = data.is_active == 1 || $('#rekening-container input[name="rek_active"]:checked')
                .length === 0 ? ' checked' : '';
            var html = '' +
                '<div class="rekening-row border rounded p-3 mb-3 position-relative" data-index="' + rekIndex +
                '">' +
                '<div class="d-flex justify-content-between align-items-center mb-2">' +
                '<div class="form-check">' +
                '<input class="form-check-input" type="radio" name="rek_active" value="' + rekIndex + '"' +
                checked + '>' +
                '<label class="form-check-label"><strong>Rekening Aktif Tambahan</strong></label>' +
                '</div>' +
                '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-rek"><i class="ti ti-x"></i></button>' +
                '</div>' +
                '<div class="row g-2">' +
                '<div class="col-lg-3"><label class="form-label small">Bank</label><select class="form-select form-select-sm" name="rek_bank[]"><option value="">-- Pilih Bank --</option>' +
                bankOptions + '</select></div>' +
                '<div class="col-lg-3"><label class="form-label small">No. Rekening</label><input type="text" class="form-control form-control-sm" name="rek_no_rek[]" placeholder="No. Rekening"></div>' +
                '<div class="col-lg-3"><label class="form-label small">Atas Nama</label><input type="text" class="form-control form-control-sm" name="rek_atas_nama[]" placeholder="Atas Nama"></div>' +
                '<div class="col-lg-3"><label class="form-label small">KCP</label><input type="text" class="form-control form-control-sm" name="rek_kcp[]" placeholder="KCP"></div>' +
                '</div></div>';

            $('#rekening-container').append(html);
            var $row = $('#rekening-container .rekening-row:last');
            $row.find('select[name="rek_bank[]"]').val(data.bank || '');
            $row.find('input[name="rek_no_rek[]"]').val(data.no_rek || '');
            $row.find('input[name="rek_atas_nama[]"]').val(data.atas_nama || '');
            $row.find('input[name="rek_kcp[]"]').val(data.kcp || '');
            rekIndex++;
            toggleEmptyInfo();
        }

        if (showProject) {
            $('#project').off('change.feeDokter').on('change.feeDokter', updateProjectDateRange);
        }
        $('#dokter_id').off('change.feeDokter').on('change.feeDokter', updateDoctorAccount);
        $('#jumlah_hari, #fee_display, #biaya_tambahan_display').off('input.feeDokter').on('input.feeDokter',
            function() {
                setTimeout(hitungTotal, 30);
            });
        $('#total_display').off('input.feeDokter').on('input.feeDokter', function() {
            setTimeout(hitungPajak, 30);
        });
        $('input[name="pph21"]').off('change.feeDokter').on('change.feeDokter', hitungPajak);
        $('#btn-add-rek').off('click.feeDokterRekening').on('click.feeDokterRekening', function() {
            addRekeningRow();
        });
        $(document).off('click.feeDokterRekening', '.btn-remove-rek').on('click.feeDokterRekening',
            '.btn-remove-rek',
            function() {
                var $row = $(this).closest('.rekening-row');
                var wasActive = $row.find('input[name="rek_active"]').is(':checked');
                $row.remove();
                if (wasActive) {
                    $('#rekening-container .rekening-row:first input[name="rek_active"]').prop('checked',
                        true);
                }
                toggleEmptyInfo();
            });

        $.each(existingRekening, function(_, item) {
            addRekeningRow(item);
        });

        setMoney($('#fee_display'), $('#fee'), $('#fee').val());
        setMoney($('#biaya_tambahan_display'), $('#biaya_tambahan'), $('#biaya_tambahan').val());
        setMoney($('#total_display'), $('#total'), $('#total').val());
        if (showProject) {
            updateProjectDateRange();
        }
        updateDoctorAccount();
        hitungPajak();
        toggleEmptyInfo();
    });
    </script>
</div>