<div class="page-wrapper">


    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-login" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">

        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-xl-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">Selamat Datang,
                                        <?php echo $this->session->userdata('nama'); ?>!</h4>
                                    <p class="text-muted mb-0">Berikut adalah data statistik anda</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-primary btn-icon waves-effect waves-light layout-rightside-btn shadow-none"
                                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                                aria-controls="offcanvasRight"><i class="ri-pulse-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (in_array($role_id, [1, 2, 3, 4, 6, 8, 9, 10, 11, 13])): ?>
                    <div class="row">
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Cakra Medika</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value"
                                                    data-target="<?= isset($entitas_counts['cakra_medika']['count']) ? $entitas_counts['cakra_medika']['count'] : 0 ?>">0</span>
                                                <span class="fs-10 text-muted">crosseling</span>
                                            </h2>
                                            <p class="mb-0 text-muted">
                                                <span class="text-success fw-medium">
                                                    Rp
                                                    <?= number_format(isset($entitas_counts['cakra_medika']['total_deal']) ? $entitas_counts['cakra_medika']['total_deal'] : 0, 0, ',', '.'); ?>
                                                </span> total deal
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-primary rounded-circle fs-2 shadow">
                                                    <i data-feather="briefcase" class="text-primary"></i>
                                                    <i class="ti ti-briefcase fs-16 text-primary"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Konsehat</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value"
                                                    data-target="<?= isset($entitas_counts['konsehat']['count']) ? $entitas_counts['konsehat']['count'] : 0 ?>">0</span>
                                                <span class="fs-10 text-muted">crosseling</span>
                                            </h2>
                                            <p class="mb-0 text-muted">
                                                <span class="text-success fw-medium">
                                                    Rp
                                                    <?= number_format(isset($entitas_counts['konsehat']['total_deal']) ? $entitas_counts['konsehat']['total_deal'] : 0, 0, ',', '.'); ?>
                                                </span> total deal
                                            </p>
                                        </div>
                                        <div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-success rounded-circle fs-2 shadow">
                                                    <i class="ti ti-heart fs-16 text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="fw-medium text-muted mb-0">Total Crosseling</p>
                                            <h2 class="mt-4 ff-secondary fw-semibold">
                                                <span class="counter-value"
                                                    data-target="<?= isset($entitas_counts['total']) ? $entitas_counts['total'] : 0 ?>">0</span>
                                                <span class="fs-10 text-muted">crosseling</span>
                                            </h2>
                                            <p class="mb-0 text-muted">
                                                <span class="badge bg-soft-primary text-primary">
                                                    <?= isset($entitas_counts['cakra_medika']['count']) ? $entitas_counts['cakra_medika']['count'] : 0 ?>
                                                    Cakra Medika
                                                </span>
                                                <span class="badge bg-soft-success text-success">
                                                    <?= isset($entitas_counts['konsehat']['count']) ? $entitas_counts['konsehat']['count'] : 0 ?>
                                                    Konsehat
                                                </span>
                                            </p>
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
                    </div>
                    <?php endif; ?>

                    <?php if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 6 || $role_id == 13): ?>
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Total Kontribusi Sales</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="totalContributionChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Total Rujuk Balik By Cabang</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="totalRujukBalikChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Product Sales By Cakra</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="productCakraChart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">Product Sales By Konsehat</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="productKonsehatChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Filter Data By Tanggal</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 overflow-hidden">
            <div data-simplebar style="height: calc(100vh - 112px);">
                <div class="acitivity-timeline p-4">
                    <form id="filterDateForm">

                        <div class="mb-3">
                            <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                            <input type="text" id="tgl_awal" name="tgl_awal" class="form-control flatpickr-date"
                                placeholder="Input Tanggal Awal" />
                        </div>

                        <div class="mb-3">
                            <label for="tgl_akhir" class="form-label">Tanggal Akhir </label>
                            <input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control flatpickr-date"
                                placeholder="Input Tanggal Akhir" />
                        </div>


                        <div class="mb-3">
                            <div class="d-flex gap-2">
                                <button type="button" id="btnFilterDate" class="btn btn-custom flex-grow-1">
                                    <i class="ri-search-line me-1"></i> Cari
                                </button>
                                <button type="button" id="btnResetFilter" class="btn btn-outline-secondary">
                                    <i class="ri-refresh-line"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Birthday Reminder Script -->
    <script>
    var birthdayReminders = <?php echo json_encode($reminders ?? []); ?>;
    var crmChartData = {
        total_contribution: <?php echo json_encode($total_contribution ?? ['labels' => [], 'series' => [], 'total' => 0]); ?>,
        product_cakra: <?php echo json_encode($product_cakra ?? ['labels' => [], 'series' => []]); ?>,
        product_konsehat: <?php echo json_encode($product_konsehat ?? ['labels' => [], 'series' => []]); ?>,
        rujuk_balik: <?php echo json_encode($rujuk_balik ?? ['labels' => [], 'series' => []]); ?>
    };
    </script>