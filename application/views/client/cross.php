<div class="content-wrapper">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1"> <i class="tf-icons ti ti-briefcase-2 me-2"></i><?php echo $client['nama_client']?>
                </h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);">Client</a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $header?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
            <?php if ($this->session->flashdata('flash')): ?>
            <?php endif; ?>
        </div>

        <div class="card mb-6">
            <div class="card-header rounded d-flex justify-content-between align-items-center">
                <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-md-row flex-wrap row-gap-2">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('Clients/Data/View/' . urlencode($client['id_client'])) ?>"></i>Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('Clients/Data/Project/' . urlencode($client['id_client'])) ?>">Project</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active"
                                href="<?= base_url('Clients/Data/Crosseling/' . urlencode($client['id_client'])) ?>">Crosseling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('Clients/Data/Gift/' . urlencode($client['id_client'])) ?>">Gift</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('Clients/Data/File/' . urlencode($client['id_client'])) ?>">File</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <a href="<?= base_url()?>Clients/Data" class="btn btn-custom"> <i
                            class="tf-icons ti ti-circle-arrow-left me-2"></i>Kembali</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h5 class="card-title m-0">Daftar Crosseling Project <?php echo $client['nama_client']?></h5>
                    </div>
                    <div class="card-body">
                        <table id="general" class="table bordered-table dt-responsive w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Crosseling</th>
                                    <th>Tim CRM</th>
                                    <th>Projek</th>
                                    <th>Estimasi</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($cros as $c): ?>
                                <tr>
                                    <td class="text-center" style="width: 5%;"> <?= $no++; ?></td>
                                    <td><?= $c['nama_crosseling']; ?></td>
                                    <td><?= $c['nama']; ?></td>
                                    <td><?= $c['projek']; ?></td>
                                    <td><?= $c['estimasi_cros']; ?></td>
                                    <td><?= $c['ket_cros']; ?></td>
                                    <td class="text-center" style="width: 10%;">
                                        <a href="<?= base_url('Client/' . $id_client . '/editCros/' . $c['id_cross']); ?>"
                                            class="btn btn-outline-warning btn-sm edit me-1" title="edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="<?= base_url(); ?>Client/destroyCross/<?= $client['id_client']; ?>/<?= $c['id_cross']; ?>"
                                            class="btn btn-outline-danger btn-sm btn-destroy" title="hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                        <h4 class="card-title mb-0 flex-grow-1">
                            <?= isset($edit_data) ? 'Edit' : 'Tambah' ?> Project Crosseling
                        </h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?= isset($edit_data) ? base_url('Client/updateCross/'.$id_client) : base_url('Client/storeCross/'.$id_client) ?>"
                            method="post">
                            <?php if(isset($edit_data)): ?>
                            <input type="hidden" name="id_cross" value="<?= $edit_data['id_cross'] ?>">
                            <input type="hidden" name="id_client" value="<?= $id_client ?>">
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="nama_crosseling" class="form-label">Nama Crosseling</label>
                                <input type="text"
                                    class="form-control <?= form_error('nama_crosseling') ? 'is-invalid' : '' ?>"
                                    id="nama_crosseling" name="nama_crosseling" placeholder="Nama Crosseling"
                                    value="<?= isset($edit_data) ? $edit_data['nama_crosseling'] : set_value('nama_crosseling') ?>">
                                <div class="invalid-feedback">
                                    <?= form_error('nama_crosseling') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="user_crm" class="form-label">Tim CRM</label>
                                <select
                                    class="form-control select2form <?= form_error('user_crm') ? 'is-invalid' : '' ?>"
                                    id="user_crm" name="user_crm">
                                    <option value="">Pilih Tim CRM</option>
                                    <?php foreach ($users_crm as $u): ?>
                                    <option value="<?= $u['id_user']; ?>"
                                        <?= (isset($edit_data) && $edit_data['user_crm'] == $u['id_user']) || set_value('user_crm') == $u['id_user'] ? 'selected' : '' ?>>
                                        <?= $u['nama']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= form_error('user_crm') ?>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="projek" class="form-label">Projek</label>
                                <select class="form-control select2form" id="projek" name="projek">
                                    <option value="">Pilih Projek</option>
                                    <?php 
                                                $options = ['Cakra Medika', 'Konsehat'];
                                                foreach ($options as $option): 
                                                ?>
                                    <option value="<?= $option ?>"
                                        <?= (isset($edit_data) && $edit_data['projek'] == $option) ? 'selected' : '' ?>>
                                        <?= $option ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="estimasi_cros" class="form-label">Estimasi</label>
                                <input type="text" class="form-control" id="estimasi_cros" name="estimasi_cros"
                                    placeholder="Estimasi"
                                    value="<?= isset($edit_data) ? $edit_data['estimasi_cros'] : set_value('estimasi_cros') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="ket_cros" class="form-label">Keterangan</label>
                                <textarea name="ket_cros" id="ket_cros" class="form-control" placeholder="Keterangan"
                                    rows="3"><?= isset($edit_data) ? $edit_data['ket_cros'] : set_value('ket_cros') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-custom me-2">
                                        <?= isset($edit_data) ? 'Update' : 'Submit' ?>
                                    </button>
                                    <?php if(isset($edit_data)): ?>
                                    <a href="<?= base_url('Client/Crosseling/' . $id_client) ?>"
                                        class="btn btn-secondary">Batal</a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>