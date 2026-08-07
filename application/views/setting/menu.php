<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="mb-4">
            <h4 class="mb-1"><?= $subheader;?></h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Setting</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= $header;?></a></li>
                    <li class="breadcrumb-item active"><?= $subheader;?></li>
                </ol>
            </nav>
        </div>

        <div class="card border-0">
            <div class="card-body pb-0 pt-0 px-2">
                <ul class="nav nav-tabs nav-bordered nav-bordered-custom">
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Cabang')?>" class="nav-link p-2">
                            Cabang
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Dept')?>" class="nav-link p-2">
                            Departemen
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/User')?>" class="nav-link p-2">
                            User
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Menu')?>" class="nav-link p-2 active">
                            Menu
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <a href="<?= base_url('Setting/Role')?>" class="nav-link p-2">
                            Role & Access
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0"> <?= isset($edit_data) ? 'Edit' : 'Tambah' ?>
                            <?php echo $subheader;?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Setting/Menu/update') : base_url('Setting/Menu/create') ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_menu" value="<?= $edit_data['id_menu'] ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="header" class="form-label">Header </label>
                                <input type="text" id="header" name="header" class="form-control"
                                    placeholder="Enter Header Menu"
                                    value="<?= isset($edit_data) ? $edit_data['header'] : set_value('header') ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="nama_menu" class="form-label">Nama Menu <span class="text-danger">
                                        *</span></label>
                                <input type="text" id="nama_menu" name="nama_menu"
                                    class="form-control  <?= form_error('nama_menu') ? 'is-invalid' : '' ?>"
                                    placeholder="Enter Nama Menu"
                                    value="<?= isset($edit_data) ? $edit_data['nama_menu'] : set_value('nama_menu') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('nama_menu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="icon_menu" class="form-label">Icon Menu <span class="text-danger">
                                        *</span></label>
                                <input type="text" id="icon_menu" name="icon_menu"
                                    class="form-control  <?= form_error('icon_menu') ? 'is-invalid' : '' ?>"
                                    placeholder="Enter Icon Menu"
                                    value="<?= isset($edit_data) ? $edit_data['icon_menu'] : set_value('icon_menu') ?>" />

                                <div class="invalid-feedback">
                                    <?= form_error('icon_menu') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="url_menu" class="form-label">Url Menu </label>
                                <input type="text" id="url_menu" name="url_menu" class="form-control"
                                    placeholder="Enter Url Menu"
                                    value="<?= isset($edit_data) ? $edit_data['url_menu'] : set_value('url_menu') ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="segment_menu" class="form-label">Url Segment</label>
                                <input type="text" id="segment_menu" name="segment_menu" class="form-control"
                                    placeholder="Enter Url Segment"
                                    value="<?= isset($edit_data) ? $edit_data['segment_menu'] : set_value('segment_menu') ?>" />
                            </div>

                            <div class="mb-3">
                                <label for="order_menu" class="form-label">Urutan <span class="text-danger">
                                        *</span></label>
                                <input type="text" id="order_menu" name="order_menu"
                                    class="form-control <?= form_error('order_menu') ? 'is-invalid' : '' ?>"
                                    placeholder="Enter Urutan Menu"
                                    value="<?= isset($edit_data) ? $edit_data['order_menu'] : set_value('order_menu') ?>" />
                                <div class="invalid-feedback">
                                    <?= form_error('order_menu') ?>
                                </div>
                            </div>

                            <?php 
                                $is_dropdown = isset($edit_data) ? $edit_data['is_dropdown'] : 1;
                                ?>
                            <div class="mb-3">
                                <label for="order_menu" class="form-label">Dropdown</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="1" id="dropdown_yes"
                                        name="is_dropdown" <?= ($is_dropdown == 1) ? 'checked' : '' ?> />
                                    <label class="form-check-label" for="dropdown_yes">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="0" id="dropdown_no"
                                        name="is_dropdown" <?= ($is_dropdown == 0) ? 'checked' : '' ?> />
                                    <label class="form-check-label" for="dropdown_no">
                                        Tidak
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <?php if(isset($edit_data)): ?>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-custom w-100">Update</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="<?= base_url('Setting/Menu') ?>" class="btn btn-light w-100">Batal</a>
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
                    <div class="card-body">
                        <table id="general" class="table nowrap dt-responsive align-middle table-hover bordered-table"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%;">No</th>
                                    <th>Header</th>
                                    <th>Nama Menu</th>
                                    <th>Icon</th>
                                    <th>Url</th>
                                    <th>Urutan</th>
                                    <th>Dropdown</th>
                                    <th class="text-center" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($menus as $menu): ?>
                                <tr>
                                    <td> <?= $no++; ?></td>
                                    <td><?= $menu['header']; ?></td>
                                    <td><?= $menu['nama_menu']; ?></td>
                                    <td><?= $menu['icon_menu']; ?></td>
                                    <td><?= $menu['url_menu']; ?></td>
                                    <td><?= $menu['order_menu']; ?></td>
                                    <td><?php if ($menu['is_dropdown'] == 1): ?>
                                        <span class="badge badge-soft-success">Ya</span>
                                        <?php else: ?>
                                        <span class="badge badge-soft-danger">Tidak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown table-action">
                                            <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <?php if ($menu['is_dropdown'] == 1): ?>
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Setting/Menu/Submenu/<?= $menu['id_menu']; ?>"><i
                                                            class="ri-menu-line align-bottom me-2 text-muted"></i>
                                                        Submenu</a>
                                                </li>
                                                <?php endif; ?>
                                                <li><a class="dropdown-item"
                                                        href="<?= base_url(); ?>Setting/Menu/edit/<?= $menu['id_menu']; ?>">
                                                        <i class="ri-pencil-line align-bottom me-2 text-muted"></i>
                                                        Edit</a>
                                                </li>
                                                <li><a class="dropdown-item btn-destroy"
                                                        href="<?= base_url('Setting/Menu/destroy/' . $menu['id_menu']); ?>">
                                                        <i
                                                            class="ri-delete-bin-line align-bottom me-2 text-muted"></i>Delete</a>
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