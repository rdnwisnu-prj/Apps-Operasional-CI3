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
                    <li class="breadcrumb-item active"><?= $subheader?></li>
                </ol>
            </nav>
        </div>

        <!-- Card -->
        <div class="row">
            <div class="col-xl-4 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="all" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Prospek</p>
                                <h2 class="mt-4 fw-semibold">
                                    <?= isset($status_counts['Total']) ? $status_counts['Total'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-building fs-16 text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Proses Prospek"
                    style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Proses Prospek</p>
                                <h2 class="mt-4 fw-semibold">
                                    <?= isset($status_counts['Proses Prospek']) ? $status_counts['Proses Prospek'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-warning rounded-circle fs-2 shadow">
                                        <i class="ti ti-file-description fs-16 text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Negosiasi"
                    style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Negosiasi</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($status_counts['Negosiasi']) ? $status_counts['Negosiasi'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-brand-messenger fs-16 text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Deal" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Deal</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($status_counts['Deal']) ? $status_counts['Deal'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded-circle fs-2 shadow">
                                        <i class="ti ti-circle-check fs-16 text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Lost" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Lost</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($status_counts['Lost']) ? $status_counts['Lost'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-danger rounded-circle fs-2 shadow">
                                        <i class="ti ti-xbox-x fs-16 text-danger"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Filter Form -->
        <?php if (isset($can_filter) && $can_filter): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data Prospek
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="filter_user_id" id="filter_user_id" class="form-control">
                            <option value="">-- Semua Marketing --</option>
                            <?php 
                                $members = isset($team_members) ? $team_members : [];
                                foreach ($members as $m): ?>
                            <option value="<?= $m['id_user'] ?>">
                                <?= htmlspecialchars($m['nama']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_bulan" name="filter_bulan" class="form-control">
                            <option value="">-- Semua Bulan --</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_tahun" name="filter_tahun" class="form-control">
                            <option value="">-- Semua Tahun --</option>
                            <?php for($y = date('Y') - 1; $y <= date('Y') + 5; $y++): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" id="btnFilterProspek" class="btn btn-primary me-2">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                        <button type="button" id="btnResetFilter" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- End Filter Form -->

        <!-- Jumlah Estimasi Lead -->
        <div id="estimasiSummary" class="card border-0 shadow-sm mb-3"
            style="display: none; background: linear-gradient(135deg, #34c38f 0%, #28a745 100%);">
            <div class="card-body py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            <span class="avatar-title bg-opacity-25 rounded-circle fs-3">
                                <i class="ri-money-dollar-circle-line text-white"></i>
                            </span>
                        </div>
                        <div>
                            <p class="text-white-50 mb-0 fs-13">Total Estimasi Sales (Hasil Filter)</p>
                            <h4 class="text-white mb-0 fw-bold" id="totalEstimasiValue">Rp 0</h4>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-white bg-opacity-25 text-success fs-12 px-3 py-2" id="totalRowCount">0
                            data</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Jumlah Estimasi Lead -->



        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>


                <div class="d-flex align-content-center flex-wrap">
                    <button type="button" id="btnDeleteSelected" class="btn btn-danger waves-effect waves-light me-2"
                        style="display: none;">
                        <i class="ri-delete-bin-line align-bottom me-1"></i> Hapus Terpilih (<span
                            id="selectedCount">0</span>)
                    </button>
                    <button type="button" class="btn btn-success waves-effect waves-light me-2" data-bs-toggle="modal"
                        data-bs-target="#ImportProspek">
                        <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Import
                        Prospek
                    </button>
                    <a href="<?= base_url()?>Prospek/Store" class="btn btn-custom"> <i
                            class="ri-add-circle-line align-bottom me-1"></i> Add
                        Prospek
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="table-prospek" class="table align-middle table-hover bordered-table w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 2%"><input type="checkbox" id="checkAll"
                                    class="form-check-input"></th>
                            <th>Nama Perusahaan</th>
                            <th>Project</th>
                            <th>Nama PIC</th>
                            <th>No Tlp PIC</th>
                            <th>Periode</th>
                            <th>Estimasi</th>
                            <th>Marketing</th>
                            <th>Keterangan</th>
                            <th style="width: 2%;">Status</th>
                            <th class="text-center" style="width: 2%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $l): ?>

                        <tr>
                            <td class="text-center" style="width: 2%;"><input type="checkbox"
                                    class="form-check-input checkbox-item" value="<?= $l['id_leads']; ?>"></td>
                            <td><a href="<?= base_url('Prospek/View/' . urlencode($l['id_leads'])); ?>"
                                    class="text-primary text-uppercase fw-medium">
                                    <?= $l['nama_client']; ?>
                                </a>
                            </td>
                            <td><?= $l['service']; ?></td>
                            <td><?= $l['nama_pic']; ?></td>
                            <td><?= $l['tlp_pic']; ?></td>
                            <td>
                                <?php 
                                $bulan_singkat = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                echo isset($bulan_singkat[$l['periode_bulan']]) ? $bulan_singkat[$l['periode_bulan']] : $l['periode_bulan'];
                                ?> - <?= $l['periode_tahun']; ?>
                            </td>
                            <td data-order="<?= $l['estimasi_lead']; ?>">Rp
                                <?= number_format($l['estimasi_lead'], 0, ',', '.'); ?></td>
                            <td><?= $l['nama']; ?></td>
                            <td><?= $l['catatan']; ?></td>
                            <td>
                                <?php
                                $status = $l['status_lead'];
                                $badge_class = '';
                                
                                if ($status == 'Proses Prospek') {
                                    $badge_class = 'bg-warning';
                                } elseif ($status == 'Negosiasi') {
                                    $badge_class = 'bg-info';
                                } elseif ($status == 'Deal') {
                                    $badge_class = 'bg-success';
                                } elseif ($status == 'Lost') {
                                    $badge_class = 'bg-danger';
                                } else {
                                    $badge_class = 'bg-secondary';
                                }
                                ?>
                                <span class="badge rounded-pill <?= $badge_class; ?>"><?= $status; ?></span>
                            </td>
                            <td class="text-center">
                                <?php 
                                    $can_edit = $l['user_id'] == $current_user_id;
                                    ?>
                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Prospek/Update/<?= $l['id_leads']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses edit">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Prospek/destroy/<?= $l['id_leads']; ?>"
                                                class="dropdown-item remove-item-btn btn-destroy">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses hapus">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
                                            </span>
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

    <div class="modal fade" id="ImportProspek" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Prospek </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importFormProspek">
                        <div class="dropzone" id="dropzone-prospek">
                            <div class="fallback">
                                <input name="file" type="file" required />
                            </div>
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                </div>
                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>

                        <ul class="list-unstyled mb-3" id="dropzone-preview-prospek">
                            <li class="mt-2" id="dropzone-preview-list-prospek">
                                <div class="border rounded">
                                    <div class="d-flex p-2">
                                        <div class="flex-grow-1">
                                            <div class="pt-1">
                                                <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                <strong class="error text-danger" data-dz-errormessage></strong>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-end">
                            <a href="<?= base_url()?>assets/import/New-Template.xlsx"
                                download="Template-Prospek.xlsx" class="btn btn-success waves-effect waves-light me-2">
                                <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Download Template
                            </a>
                            <button type="button" id="submitBtnProspek" class="btn btn-custom"><i
                                    class="ri-checkbox-circle-line label-icon align-middle me-1"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card-filter {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .card-filter:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .card-filter.active {
        border: 2px solid #405189;
        box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
    }

    @keyframes fadeSlideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var table = $('#table-prospek').DataTable();
            var cardFilters = document.querySelectorAll('.card-filter');
            var defaultCard = document.querySelector('.card-filter[data-status="all"]');
            if (defaultCard) {
                defaultCard.classList.add('active');
            }

            cardFilters.forEach(function(card) {
                card.addEventListener('click', function() {
                    var status = this.getAttribute('data-status');
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                    if (status === 'all') {
                        table.column(9).search('').draw();
                    } else {
                        table.column(9).search('^' + status + '$', true, false).draw();
                    }
                });
            });

            // Mapping bulan singkat ke angka
            var bulanMap = {
                'Jan': 1,
                'Feb': 2,
                'Mar': 3,
                'Apr': 4,
                'Mei': 5,
                'Jun': 6,
                'Jul': 7,
                'Agt': 8,
                'Sep': 9,
                'Okt': 10,
                'Nov': 11,
                'Des': 12
            };

            var btnFilter = document.getElementById('btnFilterProspek');
            var btnReset = document.getElementById('btnResetFilter');

            if (btnFilter) {
                btnFilter.addEventListener('click', function() {
                    var userId = document.getElementById('filter_user_id') ? document
                        .getElementById('filter_user_id').value : '';
                    var filterBulan = document.getElementById('filter_bulan') ? document
                        .getElementById('filter_bulan').value : '';
                    var filterTahun = document.getElementById('filter_tahun') ? document
                        .getElementById('filter_tahun').value : '';

                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (settings.nTable.id !== 'table-prospek') {
                            return true;
                        }

                        var rowMarketing = data[7] || '';
                        var rowPeriode = data[5] || '';

                        // Filter by marketing
                        if (userId) {
                            var marketingSelect = document.getElementById(
                                'filter_user_id');
                            var selectedText = marketingSelect.options[marketingSelect
                                .selectedIndex].text.trim();
                            if (rowMarketing.trim() !== selectedText) {
                                return false;
                            }
                        }

                        // Filter by bulan dan tahun dari kolom Periode (format: "Jan - 2025")
                        if (filterBulan || filterTahun) {
                            var periodeParts = rowPeriode.trim().split(' - ');
                            if (periodeParts.length >= 2) {
                                var rowBulanStr = periodeParts[0].trim();
                                var rowTahun = periodeParts[1].trim();
                                var rowBulan = bulanMap[rowBulanStr] || 0;

                                if (filterBulan && rowBulan != parseInt(filterBulan)) {
                                    return false;
                                }
                                if (filterTahun && rowTahun != filterTahun) {
                                    return false;
                                }
                            } else {
                                return false;
                            }
                        }

                        return true;
                    });

                    table.draw();
                    $.fn.dataTable.ext.search.pop();

                    // Hitung total estimasi dari baris yang terlihat
                    var totalEstimasi = 0;
                    var visibleRows = 0;
                    table.rows({
                        search: 'applied'
                    }).every(function() {
                        var rowData = this.data();
                        // Kolom estimasi (index 6) punya data-order dengan nilai numerik
                        var cellNode = this.node();
                        var estimasiCell = cellNode.querySelectorAll('td')[6];
                        var rawValue = estimasiCell ? estimasiCell.getAttribute(
                            'data-order') : '0';
                        totalEstimasi += parseFloat(rawValue) || 0;
                        visibleRows++;
                    });

                    // Format angka ke Rupiah
                    var formatted = 'Rp ' + totalEstimasi.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });
                    document.getElementById('totalEstimasiValue').textContent = formatted;
                    document.getElementById('totalRowCount').textContent = visibleRows +
                        ' data';

                    // Tampilkan summary card
                    var summaryCard = document.getElementById('estimasiSummary');
                    summaryCard.style.display = 'block';
                    summaryCard.style.animation = 'fadeSlideIn 0.4s ease';
                });
            }

            if (btnReset) {
                btnReset.addEventListener('click', function() {
                    if (document.getElementById('filter_user_id')) {
                        document.getElementById('filter_user_id').value = '';
                    }
                    if (document.getElementById('filter_bulan')) {
                        document.getElementById('filter_bulan').value = '';
                    }
                    if (document.getElementById('filter_tahun')) {
                        document.getElementById('filter_tahun').value = '';
                    }

                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    if (defaultCard) {
                        defaultCard.classList.add('active');
                    }
                    table.search('').columns().search('').draw();

                    // Sembunyikan summary estimasi
                    document.getElementById('estimasiSummary').style.display = 'none';
                });
            }
        }, 500);
    });
    </script>