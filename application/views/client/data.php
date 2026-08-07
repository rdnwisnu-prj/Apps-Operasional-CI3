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
            <div class="col-xl-3 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="all" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Client</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($group_counts['Total']) ? $group_counts['Total'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-stack-back fs-16 text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="VIP" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">VIP</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($group_counts['VIP']) ? $group_counts['VIP'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-dark rounded-circle fs-2 shadow">
                                        <i class="ti ti-award fs-16 text-dark"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Gold" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Gold</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($group_counts['Gold']) ? $group_counts['Gold'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-warning rounded-circle fs-2 shadow">
                                        <i class="ti ti-star fs-16 text-warning"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-12">
                <div class="card card-animate card-filter cursor-pointer" data-status="Silver" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Silver</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">
                                    <?= isset($group_counts['Silver']) ? $group_counts['Silver'] : 0 ?>
                                </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i class="ti ti-shield fs-16 text-info"></i>
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
                <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Data Client
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
                        <select name="filter_sektor" id="filter_sektor" class="form-control">
                            <option value="">-- Semua Sektor --</option>
                            <option value="Industri">Industri</option>
                            <option value="Kementerian/ Government">Kementerian/ Government</option>
                            <option value="Danantara (BUMN Karya)">Danantara (BUMN Karya)</option>
                            <option value="Pertambangan/ Mining">Pertambangan/ Mining</option>
                            <option value="Perkantoran/ Office">Perkantoran/ Office</option>
                            <option value="Perhotelan">Perhotelan</option>
                            <option value="Facility services (Security, Cleaning service, Catering)">Facility
                                services</option>
                            <option value="Instansi Pendidikan">Instansi Pendidikan</option>
                            <option value="Travel & Agent">Travel & Agent</option>
                            <option value="Rumah Sakit & Lab">Rumah Sakit & Lab</option>
                            <option value="Yayasan">Yayasan</option>
                            <option value="Shipping">Shipping</option>
                            <option value="Retail Market">Retail Market</option>
                            <option value="Engineering (Air, Listrik, IT)">Engineering (Air, Listrik, IT)</option>
                            <option value="Finance (Banking & Insurance)">Finance (Banking & Insurance)</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Construction">Construction</option>
                            <option value="Plantation">Plantation</option>
                        </select>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <select id="filter_tahun" name="filter_tahun" class="form-control">
                            <option value="">-- Semua Tahun --</option>
                            <?php for($y = date('Y') - 1; $y <= date('Y') + 5; $y++): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="btnFilterClient" class="btn btn-primary me-2">
                            <i class="ri-search-line me-1"></i> Tampilkan
                        </button>
                        <button type="button" id="btnResetFilterClient" class="btn btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i> Reset
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <?php endif; ?>
        <!-- End Filter Form -->


        <!-- Jumlah Estimasi -->
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
        <!-- End Jumlah Estimasi -->

        <!-- Table Client -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Perusahaan</h5>
                <div class="d-flex align-content-center flex-wrap">
                    <button type="button" id="btnDeleteSelectedClient"
                        class="btn btn-danger waves-effect waves-light me-2" style="display: none;">
                        <i class="ri-delete-bin-line align-bottom me-1"></i> Hapus Terpilih (<span
                            id="selectedCountClient">0</span>)
                    </button>
                    <!-- <button type="button" class="btn btn-success waves-effect waves-light me-2" data-bs-toggle="modal"
                        data-bs-target="#fileModal">
                        <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Import
                        Client
                    </button> -->
                    <!-- <a href="<?= base_url()?>Client/Store" class="btn btn-custom"> <i
                            class="ri-add-circle-line align-bottom me-1"></i> Add
                        Client
                    </a> -->
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="table-client" class="table align-middle table-hover bordered-table">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" id="checkAllClient" class="form-check-input">
                            </th>
                            <th>Nama Perusahaan</th>
                            <th>Sektor Perusahaan</th>
                            <th>HUT Perusahaan</th>
                            <th>Nama PIC</th>
                            <th>HUT PIC</th>
                            <th>Client Group</th>
                            <th>Status Client</th>
                            <th>Periode</th>
                            <th>Omset</th>
                            <th>Marketing</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($client as $c): ?>
                        <tr>
                            <td class="text-center"><input type="checkbox" class="form-check-input checkbox-item-client"
                                    value="<?= $c['id_client']; ?>">
                            </td>
                            <td><a href="<?= base_url('Client/View/' . urlencode($c['id_client'])); ?>"
                                    class="text-primary text-uppercase fw-medium">
                                    <?= $c['nama_client']; ?>
                                </a>
                            </td>
                            <td><?= $c['sektor']; ?></td>
                            <td>
                                <?php if ($c['hut_client'] == '0000-00-00' || empty($c['hut_client'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($c['hut_client'])); ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $c['nama_pic']; ?></td>
                            <td>
                                <?php if ($c['hut_pic'] == '0000-00-00' || empty($c['hut_pic'])) : ?>
                                Belum ada data
                                <?php else : ?>
                                <?= tanggal_indonesia_medium(date($c['hut_pic'])); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($c['group'] == 'VIP') : ?>
                                <span class="badge bg-dark"><?= $c['group']; ?></span>
                                <?php elseif($c['group'] == 'Gold') : ?>
                                <span class="badge bg-warning"><?= $c['group']; ?></span>
                                <?php elseif($c['group'] == 'Silver') : ?>
                                <span class="badge bg-info"><?= $c['group']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $c['status']; ?></td>
                            <td><?php 
                                $bulan_singkat = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                                echo isset($bulan_singkat[$c['periode_bulan']]) ? $bulan_singkat[$c['periode_bulan']] : $c['periode_bulan'];
                                ?> - <?= $c['periode_tahun']; ?>
                            </td>
                            <td data-order="<?= $c['total_estimasi']; ?>">Rp
                                <?= number_format($c['total_estimasi'], 0, ',', '.'); ?></td>
                            <td><?= $c['nama']; ?></td>
                            <td class="text-center" style="width: 5%;">
                                <?php 
                                    $can_edit = $c['user_id'] == $current_user_id;
                                    ?>

                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url(); ?>Client/Update/<?= $c['id_client']; ?>"
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
                                            <a href="<?= base_url(); ?>Client/destroy/<?= $c['id_client']; ?>"
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
        <!-- End Table Client -->

    </div>

    <div class="modal fade" id="fileModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Perusahaan </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importFormClient">
                        <div class="dropzone" id="dropzone-client">
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

                        <ul class="list-unstyled mb-3" id="dropzone-preview-client">
                            <li class="mt-2" id="dropzone-preview-list-client">
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
                            <a href="<?= base_url()?>assets/import/Template-Client.xlsx"
                                download="Template - Client.xlsx" class="btn btn-success waves-effect waves-light me-2">
                                <i class="ri ri-file-excel-2-line align-bottom me-1"></i> Download Template
                            </a>
                            <button type="button" id="submitBtn" class="btn btn-custom"><i
                                    class="ri-checkbox-circle-line label-icon align-middle me-1"></i>Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var table = $('#table-client').DataTable();
            var cardFilters = document.querySelectorAll('.card-filter');
            var defaultCard = document.querySelector('.card-filter[data-status="all"]');
            var urlParams = new URLSearchParams(window.location.search);
            var groupParam = urlParams.get('group');
            var sektorParam = urlParams.get('sektor');
            var marketingParam = urlParams.get('marketing');
            if (sektorParam) {
                table.column(2).search(sektorParam, false, false).draw();
                var sektorSelect = document.getElementById('filter_sektor');
                if (sektorSelect) {
                    for (var i = 0; i < sektorSelect.options.length; i++) {
                        if (sektorSelect.options[i].value === sektorParam ||
                            sektorSelect.options[i].value.indexOf(sektorParam) !== -1) {
                            sektorSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
            }

            if (marketingParam) {
                var marketingSelect = document.getElementById('filter_user_id');
                if (marketingSelect) {
                    for (var i = 0; i < marketingSelect.options.length; i++) {
                        if (marketingSelect.options[i].value === marketingParam) {
                            marketingSelect.selectedIndex = i;
                            var selectedText = marketingSelect.options[i].text.trim();
                            table.column(10).search('^' + selectedText.replace(/[.*+?^${}()|[\]\\]/g,
                                '\\$&') + '$', true, false).draw();

                            // Hitung total estimasi dari baris yang terlihat
                            var totalEstimasi = 0;
                            var visibleRows = 0;
                            table.rows({
                                search: 'applied'
                            }).every(function() {
                                var cellNode = this.node();
                                var estimasiCell = cellNode.querySelectorAll('td')[9];
                                var rawValue = estimasiCell ? estimasiCell.getAttribute(
                                    'data-order') : '0';
                                totalEstimasi += parseFloat(rawValue) || 0;
                                visibleRows++;
                            });

                            var formatted = 'Rp ' + totalEstimasi.toLocaleString('id-ID', {
                                minimumFractionDigits: 0
                            });
                            document.getElementById('totalEstimasiValue').textContent = formatted;
                            document.getElementById('totalRowCount').textContent = visibleRows +
                            ' data';

                            var summaryCard = document.getElementById('estimasiSummary');
                            summaryCard.style.display = 'block';
                            summaryCard.style.animation = 'fadeSlideIn 0.4s ease';
                            break;
                        }
                    }
                }
            }

            if (groupParam) {
                var matchingCard = document.querySelector('.card-filter[data-status="' + groupParam +
                    '"]');
                if (matchingCard) {
                    matchingCard.classList.add('active');
                    table.column(6).search('^' + groupParam + '$', true, false).draw();
                } else {
                    if (defaultCard) {
                        defaultCard.classList.add('active');
                    }
                }
            } else {
                if (defaultCard) {
                    defaultCard.classList.add('active');
                }
            }

            cardFilters.forEach(function(card) {
                card.addEventListener('click', function() {
                    var status = this.getAttribute('data-status');
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                    if (status === 'all') {
                        table.column(6).search('').draw();
                        var newUrl = window.location.pathname;
                        window.history.replaceState({}, '', newUrl);
                    } else {
                        table.column(6).search('^' + status + '$', true, false).draw();
                        var newUrl = window.location.pathname + '?group=' +
                            encodeURIComponent(status);
                        window.history.replaceState({}, '', newUrl);
                    }
                });
            });

            var btnFilter = document.getElementById('btnFilterClient');
            var btnReset = document.getElementById('btnResetFilterClient');
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

            if (btnFilter) {
                btnFilter.addEventListener('click', function() {
                    var userId = document.getElementById('filter_user_id') ? document
                        .getElementById('filter_user_id').value : '';
                    var sektor = document.getElementById('filter_sektor') ? document
                        .getElementById('filter_sektor').value : '';
                    var filterBulan = document.getElementById('filter_bulan') ? document
                        .getElementById('filter_bulan').value : '';
                    var filterTahun = document.getElementById('filter_tahun') ? document
                        .getElementById('filter_tahun').value : '';

                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                        if (settings.nTable.id !== 'table-client') {
                            return true;
                        }

                        var rowSektor = data[2] || '';
                        var rowPeriode = data[8] || '';
                        var rowMarketing = data[10] || '';
                        if (userId) {
                            var marketingSelect = document.getElementById(
                                'filter_user_id');
                            var selectedText = marketingSelect.options[marketingSelect
                                .selectedIndex].text.trim();
                            if (rowMarketing.trim() !== selectedText) {
                                return false;
                            }
                        }

                        if (sektor) {
                            if (rowSektor.trim().indexOf(sektor) === -1) {
                                return false;
                            }
                        }

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
                        var cellNode = this.node();
                        var estimasiCell = cellNode.querySelectorAll('td')[9];
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
                    if (document.getElementById('filter_sektor')) {
                        document.getElementById('filter_sektor').value = '';
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

    <style>
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