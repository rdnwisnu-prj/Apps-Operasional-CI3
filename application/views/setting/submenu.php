<div class="page-wrapper">
    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>
    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1">Sub Menu</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Menu
                            <?= $menu['nama_menu']; ?></a></li>
                    <li class="breadcrumb-item active">Sub Menu</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                            <?php echo $header;?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Setting/Menu/UpdateSubmenu/'.$id_menu) : base_url('Setting/Menu/StoreSubmenu/'.$id_menu) ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_submenu" value="<?= $edit_data['id_submenu'] ?>">
                            <input type="hidden" name="id_menu" value="<?= $id_menu ?>">
                            <?php endif; ?>


                            <div class="mb-3">
                                <label for="nama_submenu" class="form-label">Nama Sub Menu</label>
                                <input type="text" id="nama_submenu" name="nama_submenu"
                                    class="form-control <?= form_error('nama_submenu') ? 'is-invalid' : '' ?>"
                                    placeholder="Nama Sub Menu"
                                    value="<?= isset($edit_data) ? $edit_data['nama_submenu'] : set_value('nama_submenu') ?>" />
                                <div class="invalid-feedback">
                                    <?= form_error('nama_submenu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="url_submenu" class="form-label">Url Sub Menu</label>
                                <input type="text" id="url_submenu" name="url_submenu"
                                    class="form-control <?= form_error('url_submenu') ? 'is-invalid' : '' ?>"
                                    placeholder="Url Sub Menu"
                                    value="<?= isset($edit_data) ? $edit_data['url_submenu'] : set_value('url_submenu') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('url_submenu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="segment_submenu" class="form-label">Url Segment Sub Menu</label>
                                <input type="text" id="segment_submenu" name="segment_submenu"
                                    class="form-control <?= form_error('segment_submenu') ? 'is-invalid' : '' ?>"
                                    placeholder="Url Segment Sub Menu"
                                    value="<?= isset($edit_data) ? $edit_data['segment_submenu'] : set_value('segment_submenu') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('segment_submenu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="order_submenu" class="form-label">Urutan</label>
                                <input type="text" id="order_submenu" name="order_submenu"
                                    class="form-control <?= form_error('order_submenu') ? 'is-invalid' : '' ?>"
                                    placeholder="Urutan"
                                    value="<?= isset($edit_data) ? $edit_data['order_submenu'] : set_value('order_submenu') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('order_submenu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Setting/Menu/Submenu/' . $id_menu) ?>"
                                            class="btn btn-light w-100">Batal</a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <button type="submit" class="btn btn-custom w-100"><i
                                        class="ri ri-save-line align-bottom me-2"></i>
                                    Submit</button>
                                <?php endif; ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0"><?= $header;?></h5>
                        <a href="<?= base_url('Setting/Menu') ?>" class="btn btn-custom waves-effect waves-light"><i
                                class="ri-arrow-left-circle-line label-icon align-middle fs-16 me-2"></i>
                            Kembali</a>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Nama Sub Menu</th>
                                    <th>URL</th>
                                    <th>Urutan</th>
                                    <th class="text-center" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($submenu as $sm): ?>
                                <tr>
                                    <td style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $sm['nama_submenu']; ?></td>
                                    <td><?= $sm['url_submenu']; ?></td>
                                    <td><?= $sm['order_submenu']; ?></td>
                                    <td class="text-center">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?= base_url('Setting/Menu/' . $id_menu . '/EditSubmenu/' . $sm['id_submenu']); ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-destroy"
                                                        href="<?= base_url(); ?>Setting/Menu/DeleteSubmenu/<?= $menu['id_menu']; ?>/<?= $sm['id_submenu']; ?>">
                                                        <i
                                                            class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete
                                                    </a>
                                                </li>
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


        </div>
    </div>