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

        <!-- Chart Total Client -->
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap row-gap-2">
                        <h6 class="mb-0">Project Tahunan</h6>
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-outline-light shadow" data-bs-toggle="dropdown"
                                href="javascript:void(0);" id="yearDropdownProject">
                                <i class="ti ti-calendar me-1"></i>
                                <span id="selectedYearProject"><?= $current_year ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php for ($y = 2025; $y <= 2030; $y++): ?>
                                <a href="javascript:void(0);" class="dropdown-item year-project-item"
                                    data-year="<?= $y ?>">
                                    <?= $y ?>
                                </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="ProjectTahunanChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var projectMonthlyData = <?= json_encode($project_monthly) ?>;
    </script>