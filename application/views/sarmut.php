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
                        <h4 class="mb-sm-0">Pengaturan</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pengaturan</a></li>
                                <li class="breadcrumb-item active"><?= $header;?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>User/Manajer</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Pilih User</option>
                                <?php foreach ($user as $u): ?>
                                <option value="<?= $u['id_user'] ?>"><?= $u['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>" required>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sasaran Mutu</th>
                                <th>Satuan</th>
                                <th>Target Tahunan</th>
                                <th>Target Bulanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kpi as $k): ?>
                            <tr>
                                <td><?= $k['nama_kpi'] ?></td>
                                <td><?= $k['satuan'] ?></td>
                                <td>
                                    <input type="number" name="targets[<?= $k['id_kpi'] ?>][tahunan]"
                                        class="form-control" step="0.01" required>
                                </td>
                                <td>
                                    <input type="number" name="targets[<?= $k['id_kpi'] ?>][bulanan]"
                                        class="form-control" step="0.01" required>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Target</button>
            </form>
        </div>
    </div>