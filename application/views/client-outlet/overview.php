<div class="page-wrapper">
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $header; ?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);"><?= $breadcrumb; ?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader; ?></li>
                </ol>
            </nav>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="<?= $subheader; ?> Navigation">
                    <a href="<?= base_url($controller); ?>"
                        class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'overview') ? 'active' : ''; ?>">
                        Overview
                    </a>
                    <a href="<?= base_url($controller . '/Data'); ?>"
                        class="btn btn-outline-primary <?= (isset($active_page) && $active_page === 'data') ? 'active' : ''; ?>">
                        Data
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body text-center text-muted py-5">
                Konten overview akan diatur belakangan.
            </div>
        </div>
    </div>
