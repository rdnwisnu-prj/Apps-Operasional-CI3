<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="app-ecommerce">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Client</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);">Client</a>
                            </li>
                            <li class="breadcrumb-item active">Overview</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card mb-6">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item me-2">
                            <a href="<?= base_url()?>Clients/Overview" class="nav-link active">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url()?>Clients/Data" class="nav-link">
                                Data</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row g-6">
            <div class="col-lg-4 col-sm-12">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="ti ti-briefcase-2 ti-26px"></i>
                            </span>
                        </div>
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2 text-end"><?= number_format($total_client) ?></h5>
                            <p class="mb-0">Total Client</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-icon">
                            <span class="badge bg-label-primary rounded p-2">
                                <i class="ti ti-presentation ti-26px"></i>
                            </span>
                        </div>
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2 text-end"><?= number_format($total_project) ?></h5>
                            <p class="mb-0">Total Project</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="card-icon">
                            <span class="badge bg-label-success rounded p-2">
                                <i class="ti ti-currency-dollar ti-26px"></i>
                            </span>
                        </div>
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2 text-end">Rp <?= number_format($total_estimasi, 0, ',', '.') ?></h5>
                            <p class="mb-0 text-end">Total Estimasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>