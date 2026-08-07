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
                                <li class="breadcrumb-item active"><?= $subheader?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Update Marketing Team</h5>
                    <div class="gap-2">
                        <a href="<?= base_url()?>Team" class="btn btn-custom"> <i
                                class="ri-arrow-left-circle-line align-bottom me-2"></i>Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $teams['id_user']; ?>">


                        <h6>1. General Info</h6>
                        <div class="mb-3 row">
                            <label for="nama" class="col-md-2 col-form-label">Nama Lengkap<span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" placeholder="Nama Lengkap" id="nama" name="nama"
                                    value="<?= $teams['nama']; ?>">
                                <div class="form-text text-danger">
                                    <?= form_error('nama') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <input class="form-control" type="email" id="email" name="email"
                                    value="<?= $teams['email']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="no_tlp" class="col-md-2 col-form-label">No Tlp</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" id="no_tlp" name="no_tlp"
                                    value="<?= $teams['no_tlp']; ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="t_lahir" class="col-md-2 col-form-label">Tempat Lahir</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $teams['t_lahir']; ?>" id="t_lahir"
                                    name="t_lahir">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tgl_lahir" class="col-md-2 col-form-label">Tgl Lahir</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control"
                                        placeholder="Tgl Lahir" value="<?= $teams['tgl_lahir']; ?>">
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="gender" class="col-md-2 col-form-label">Gender</label>
                            <div class="col-md-10">
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="radio" name="gender" id="genderL" value="L"
                                        <?= ($teams['gender'] == 'L') ? 'checked' : '' ?> />
                                    <label class="form-check-label" for="genderL">Laki - Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderP" value="P"
                                        <?= ($teams['gender'] == 'P') ? 'checked' : '' ?> />
                                    <label class="form-check-label" for="genderP">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="foto" class="col-md-2 col-form-label">Foto</label>
                            <div class="col-md-10">
                                <?php if (!empty($teams['foto']) && file_exists(FCPATH . 'upload/employee/' . $teams['foto'])): ?>
                                <div class="mb-3">
                                    <p class="text-muted mb-1">Foto saat ini:</p>
                                    <img src="<?= base_url('upload/employee/' . $teams['foto']) ?>" alt="Foto Profil"
                                        class="img-thumbnail"
                                        style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    <p class="text-muted mt-1 small"><?= $teams['foto'] ?></p>
                                </div>
                                <?php elseif (!empty($teams['foto'])): ?>
                                <div class="alert alert-warning p-2 small mb-2">
                                    <i class="mdi mdi-alert-circle-outline"></i> File foto tidak ditemukan di
                                    server
                                </div>
                                <?php else: ?>
                                <div class="alert alert-info p-2 small mb-2">
                                    <i class="mdi mdi-information-outline"></i> Belum ada foto yang diupload
                                </div>
                                <?php endif; ?>

                                <input class="form-control" type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png">
                                <div class="form-text">
                                    <p class="mb-1"><em>Hanya mendukung format JPG, JPEG, dan PNG (maks.
                                            2MB)</em></p>
                                    <p class="mb-0 text-success"><em>Biarkan kosong untuk mempertahankan foto
                                            saat ini</em></p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3 mx-n3" />


                        <h6>2. Job Info</h6>

                        <div class="mb-3 row">
                            <label for="nik" class="col-md-2 col-form-label">NIK <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $teams['nik']; ?>" id="nik"
                                    name="nik">
                                <div class="form-text text-danger">
                                    <?= form_error('nik') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="posisi" class="col-md-2 col-form-label">Posisi</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="posisi" name="posisi">
                                    <option value="">Pilih Posisi</option>
                                    <?php foreach ($posisi as $p): ?>
                                    <option value="<?= $p['id_posisi']; ?>"
                                        <?= ($teams['posisi'] == $p['id_posisi']) ? 'selected' : ''; ?>>
                                        <?= $p['nama_posisi']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="jabatan" class="col-md-2 col-form-label">Jabatan</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="jabatan" name="jabatan">
                                    <option value="General Manager"
                                        <?= ($teams['jabatan'] == 'General Manager') ? 'selected' : '' ?>>
                                        General Manager
                                    </option>
                                    <option value="Manager" <?= ($teams['jabatan'] == 'Manager') ? 'selected' : '' ?>>
                                        Manager
                                    </option>
                                    <option value="Supervisor"
                                        <?= ($teams['jabatan'] == 'Supervisor') ? 'selected' : '' ?>>
                                        Supervisor
                                    </option>
                                    <option value="Staff" <?= ($teams['jabatan'] == 'Staff') ? 'selected' : '' ?>>
                                        Staff
                                    </option>
                                </select>
                            </div>
                        </div>



                        <div class="mb-3 row">
                            <label for="cabang" class="col-md-2 col-form-label">Cabang</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="cabang" name="cabang">
                                    <option>Pilih Cabang</option>
                                    <?php foreach ($cabang as $c): ?>
                                    <option value="<?= $c['id_cabang']; ?>"
                                        <?= ($teams['cabang'] == $c['id_cabang']) ? 'selected' : ''; ?>>
                                        <?= $c['nama_cabang']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <hr class="my-3 mx-n3" />

                        <h6>3. Account Setting</h6>

                        <div class="mb-3 row">
                            <label for="username" class="col-md-2 col-form-label">Username <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="<?= $teams['username']; ?>" id="username"
                                    name="username">
                                <div class="form-text text-danger">
                                    <?= form_error('username') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" class="form-control" placeholder="Masukkan password baru"
                                        aria-label="Password" aria-describedby="password-addon" id="password"
                                        name="password">
                                    <button class="btn btn-light" type="button" id="password-addon">
                                        <i class="tf-icons ti ti-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text text-danger">
                                    <small>Kosongkan kolom ini jika tidak ingin mengubah password.</small>
                                </div>
                                <div class="form-text text-danger">
                                    <?= form_error('password') ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="role" class="col-md-2 col-form-label">Role</label>
                            <div class="col-md-10">
                                <select class="form-control" data-choices id="role_id" name="role_id">
                                    <?php foreach ($role as $r): ?>
                                    <option value="<?= $r['id_role']; ?>"
                                        <?= ($teams['role_id'] == $r['id_role']) ? 'selected' : ''; ?>>
                                        <?= $r['nama_role']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="text-end">
                                <button type="reset" class="btn btn-secondary me-2">
                                    Reset </button>
                                <button type="submit" class="btn btn-custom me-2">
                                    Submit </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let previewContainer = document.getElementById('foto-preview');
                    if (!previewContainer) {
                        previewContainer = document.createElement('div');
                        previewContainer.id = 'foto-preview';
                        previewContainer.className = 'mb-3';
                        document.querySelector('input[name="foto"]').parentNode.insertBefore(
                            previewContainer,
                            document.querySelector('input[name="foto"]'));
                    }

                    previewContainer.innerHTML = `
                <p class="text-muted mb-1">Preview foto baru:</p>
                <img src="${e.target.result}" alt="Preview Foto" 
                     class="img-thumbnail" 
                     style="max-width: 150px; max-height: 150px; object-fit: cover;">
            `;
                }
                reader.readAsDataURL(file);
            }
        });
        </script>