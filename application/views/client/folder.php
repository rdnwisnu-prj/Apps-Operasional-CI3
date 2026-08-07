<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <?php if ($this->session->flashdata('flash')): ?>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
            <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><?= $header?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header?></a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $subheader?></a></li>
                                <li class="breadcrumb-item active">Detail Perusahaan</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
                <?php if ($this->session->flashdata('flash')): ?>
                <?php endif; ?>
            </div>


            <div class="card mb-3">
                <div class="card-header rounded d-flex justify-content-between align-items-center">
                    <div class="nav-align-top">
                        <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                            <li class="nav-item me-2">
                                <a class="nav-link "
                                    href="<?= base_url('Client/View/' . urlencode($client['id_client'])) ?>"></i>Overview</a>
                            </li>

                            <li class="nav-item me-2">
                                <a class="nav-link "
                                    href="<?= base_url('Client/Project/' . urlencode($client['id_client'])) ?>">Project</a>
                            </li>

                            <li class="nav-item me-2">
                                <a class="nav-link"
                                    href="<?= base_url('Client/Complaint/' . urlencode($client['id_client'])) ?>">Complaint
                                    & Feedback</a>
                            </li>

                            <li class="nav-item me-2">
                                <a class="nav-link"
                                    href="<?= base_url('Client/Gift/' . urlencode($client['id_client'])) ?>">Gift</a>
                            </li>

                            <li class="nav-item me-2">
                                <a class="nav-link active"
                                    href="<?= base_url('Client/File/' . urlencode($client['id_client'])) ?>">File</a>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex align-content-center flex-wrap gap-4">
                        <a href="<?= base_url()?>Client" class="btn btn-custom"> <i
                                class="ri-arrow-left-circle-line align-bottom me-2"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-3">
            <div class="file-manager-content w-100 p-3 py-0">
                <div class="mx-n3 pt-4 px-4 file-manager-content-scroll" data-simplebar>
                    <div id="folder-list" class="mb-2">
                        <div class="row justify-content-beetwen g-2 mb-3">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2 d-block d-lg-none">
                                        <button type="button"
                                            class="btn btn-soft-success btn-icon btn-sm fs-16 file-menu-btn">
                                            <i class="ri-menu-2-fill align-bottom"></i>
                                        </button>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-0">Folders</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex gap-2 align-items-start">
                                    <button class="btn btn-primary w-sm create-folder-modal flex-shrink-0"
                                        data-bs-toggle="modal" data-bs-target="#createFolderModal">
                                        <i class="ri-add-line align-bottom me-1"></i> Create Folder
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="folderlist-data">
                            <?php if (!empty($folders)): ?>
                            <?php foreach ($folders as $folder): ?>
                            <div class="col-xxl-2 col-6 folder-card" id="folder-card-<?= $folder['id_folder'] ?>">
                                <div class="card bg-light shadow-none" id="folder-<?= $folder['id_folder'] ?>">
                                    <div class="card-body">
                                        <div class="text-end">
                                            <div class="dropdown">
                                                <button
                                                    class="btn btn-ghost-primary btn-icon btn-sm dropdown shadow-none"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-2-fill fs-16 align-bottom"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item view-item-btn"
                                                            href="<?= base_url() ?>File/OpenFile/<?= $folder['id_folder'] ?>">
                                                            Open
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item edit-folder-list"
                                                            href="#createFolderModal" data-bs-toggle="modal"
                                                            data-folder-id="<?= $folder['id_folder'] ?>">
                                                            Rename
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item delete-folder" href="#removeFolderModal"
                                                            data-bs-toggle="modal"
                                                            data-folder-id="<?= $folder['id_folder'] ?>">
                                                            Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="mb-2">
                                                <i class="ri-folder-2-fill align-bottom text-warning display-5"></i>
                                            </div>
                                            <h6 class="fs-15 folder-name">
                                                <?= htmlspecialchars($folder['nama_folder']) ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <i class="ri-folder-open-line display-4 text-muted"></i>
                                <h5 class="mt-3">Belum ada folder</h5>
                                <p class="text-muted">Klik "Create Folder" untuk membuat folder baru</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade zoomIn" id="createFolderModal" tabindex="-1" aria-labelledby="createFolderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header p-3 bg-soft-success">
                    <h5 class="modal-title" id="createFolderModalLabel">Create Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="addFolderBtn-close"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="needs-validation createfolder-form" id="createfolder-form"
                        novalidate>
                        <div class="mb-4">
                            <label for="foldername-input" class="form-label">Folder Name</label>
                            <input type="text" class="form-control" id="foldername-input" required
                                placeholder="Enter folder name">
                            <div class="invalid-feedback">Please enter a folder name.</div>
                            <input type="hidden" class="form-control" id="folderid-input" value="">
                        </div>
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-ghost-success shadow-none" data-bs-dismiss="modal"><i
                                    class="ri-close-line align-bottom"></i> Close</button>
                            <button type="submit" class="btn btn-primary" id="addNewFolder">Add Folder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="removeFolderModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-removeFoldermodal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this folder ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-folderList">Yes, Delete
                            It!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>