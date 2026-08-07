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
                    <li class="breadcrumb-item"><?= $header;?></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $subheader?></li>
                </ol>
            </nav>
        </div>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="input-icon input-icon-start position-relative">
                    <span class="input-icon-addon text-dark"><i class="ti ti-search"></i></span>
                    <input type="text" class="form-control" placeholder="Search" id="searchMemberList"
                        placeholder="Cari data Marketing" onkeyup="searchTeam()">
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMyTeam">
                    <i class="ri-add-circle-line align-bottom me-1"></i> Add
                    Data
                </button>
            </div>
        </div>

        <h4 class="fs-16 mb-3">Nama Team</h4>

        <?php if (!empty($team)): ?>
        <?php foreach ($team as $t): ?>
        <div class="mb-4">
            <h5 class="text-primary"><?= $t['nama_team'] ?></h5>
            <p class="text-muted">Supervisor: <?= $t['nama_spv'] ?></p>

            <h6>Anggota Tim:</h6>
            <?php 
                $team_staff = array_filter($my_staff, function($staff) use ($t) {
                    return $staff['team_id'] == $t['id_team'];
                });
                ?>

            <?php if (!empty($team_staff)): ?>
            <div id="teamContainer">
                <div class="row g-6">

                    <?php foreach ($team_staff as $staff): ?>
                    <?php $foto = !empty($staff['foto']) ? $staff['foto'] : 'default.png'; ?>
                    <div class="col-xxl-3 col-xl-4 col-md-6 mb-3 team-card">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <a href="<?= base_url('Team/View/' . urlencode($staff['id_user'])); ?>"
                                            class="avatar avatar-md flex-shrink-0 me-2">
                                            <img src="<?= base_url('upload/employee/' . $foto); ?>" alt="img"
                                                class="rounded-circle">
                                        </a>
                                        <div>
                                            <h6 class="fs-14"><a
                                                    href="<?= base_url('Team/View/' . urlencode($staff['id_user'])); ?>"
                                                    class="fw-medium"><?= $staff['nama']; ?></a></h6>
                                            <p class="text-default mb-0"><?= $staff['jabatan']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="dropdown table-action">
                                        <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item text-danger btn-destroy"
                                                href="<?= base_url('MyTeam/DeleteStaff/' . $t['id_team'] . '/' . $staff['id_user']); ?>"><i
                                                    class="ti ti-trash"></i> Hapus</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block">
                                    <div class="d-flex flex-column">
                                        <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                                class="ti ti-award text-dark me-1"></i> Prospek :
                                            <?= $staff['leads_count'] ?? 0 ?>
                                        </h6>
                                        <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                                class="ti ti-report-money text-dark me-1"></i> Total Prospek :
                                            Rp <?= number_format($staff['leads_total'] ?? 0, 0, ',', '.'); ?>
                                        </h6>
                                        <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                                class="ti ti-award text-dark me-1"></i> Client :
                                            <?= $staff['client_count'] ?? 0 ?>
                                        </h6>
                                        <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                                class="ti ti-report-money text-dark me-1"></i> Total Sales :
                                            Rp <?= number_format($staff['sales_total'] ?? 0, 0, ',', '.'); ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('Team/View/' . urlencode($staff['id_user'])); ?>"
                                    class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <p class="text-muted">Belum ada staff dalam tim ini.</p>
            <?php endif; ?>
        </div>
        <hr>
        <?php endforeach; ?>
        <?php else: ?>
        <p class="text-muted">Anda belum memiliki tim.</p>
        <?php endif; ?>

    </div>

    <div class="modal fade" id="addMyTeam" tabindex="-1" role="dialog" aria-labelledby="addLeads" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="addMyTeam">Tambah Daftar Tim Marketing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formAddMyTeam" method="post">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="team_id" class="col-md-3 col-form-label">Team <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="team_id" name="team_id">
                                    <option value="">Pilih Team</option>
                                    <?php foreach ($team as $t): ?>
                                    <option value="<?= $t['id_team']; ?>">
                                        <?= $t['nama_team']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="team_id_error"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="staff_id" class="col-md-3 col-form-label">Staff <span class="text-danger">
                                    *</span></label>
                            <div class="col-md-9">
                                <select class="form-control" id="staff_id" name="staff_id">
                                    <option value="">Pilih Team terlebih dahulu</option>
                                </select>
                                <div class="invalid-feedback" id="staff_id_error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="ri-close-circle-line label-icon align-middle"></i> Close
                        </button>
                        <button type="submit" class="btn btn-custom">
                            <i class="ri-checkbox-circle-line label-icon align-middle"></i> Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script>
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function searchTeam() {
        const searchTerm = document.getElementById('searchMemberList').value;
        if (searchTerm.trim() === '') {
            location.reload();
            return;
        }

        fetch(`<?= base_url('Team/search'); ?>?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                updateTeamView(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateTeamView(teams) {
        const container = document.getElementById('teamContainer');
        if (teams.length === 0) {
            container.innerHTML = `
            <div class="text-center py-6">
                <p class="text-muted">Tidak ada data marketing yang ditemukan</p>
            </div>
        `;
            return;
        }

        const formatRupiah = (number) => {
            const num = parseFloat(number) || 0;
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(num).replace('IDR', 'Rp').trim();
        };

        let html = '<div class="row g-6">';

        teams.forEach(team => {
            const leadsTotalFormatted = formatRupiah(team.leads_total);
            const salesTotalFormatted = formatRupiah(team.sales_total);
            const baseUrl = '<?= base_url(); ?>';
            const foto = team.foto || 'default.png';

            html += `
            <div class="col-xxl-3 col-xl-4 col-md-6 mb-3 team-card">
                <div class="card shadow h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <a href="${baseUrl}Team/View/${team.id_user}"
                                    class="avatar avatar-md flex-shrink-0 me-2">
                                    <img src="${baseUrl}upload/employee/${foto}" alt="img"
                                        class="rounded-circle">
                                </a>
                                <div>
                                    <h6 class="fs-14"><a
                                            href="${baseUrl}Team/View/${team.id_user}"
                                            class="fw-medium">${team.nama || ''}</a></h6>
                                    <p class="text-default mb-0">${team.jabatan || ''}
                                    </p>
                                </div>
                            </div>
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon btn btn-icon btn-sm btn-outline-light shadow"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item text-danger btn-destroy"
                                        href="${baseUrl}Team/destroy/${team.id_user}"><i
                                            class="ti ti-trash"></i> Hapus</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-block">
                            <div class="d-flex flex-column">
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                        class="ti ti-award text-dark me-1"></i> Prospek :
                                    ${team.leads_count || 0}
                                </h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                        class="ti ti-report-money text-dark me-1"></i> Total Prospek :
                                    ${leadsTotalFormatted}
                                </h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                        class="ti ti-award text-dark me-1"></i> Client :
                                    ${team.client_count || 0}
                                </h6>
                                <h6 class="text-default d-inline-flex align-items-center mb-2"><i
                                        class="ti ti-report-money text-dark me-1"></i> Total Sales :
                                    ${salesTotalFormatted}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="${baseUrl}Team/View/${team.id_user}"
                            class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';
        container.innerHTML = html;
    }

    document.getElementById('searchMemberList').addEventListener('input', debounce(searchTeam, 300));
    let staffChoices = null;
    const staffSelect = document.getElementById('staff_id');
    const teamSelect = document.getElementById('team_id');

    if (typeof Choices !== 'undefined') {
        staffChoices = new Choices(staffSelect, {
            searchEnabled: true,
            itemSelectText: '',
            allowHTML: true,
            placeholder: true,
            placeholderValue: 'Pilih Team terlebih dahulu'
        });
    }

    function loadStaffByTeam(teamId) {
        if (staffChoices) {
            staffChoices.clearStore();
            staffChoices.setChoices([{
                value: '',
                label: 'Memuat data...',
                selected: true,
                disabled: true
            }], 'value', 'label', true);
        } else {
            staffSelect.innerHTML = '<option value="">Memuat data...</option>';
        }

        if (!teamId) {
            if (staffChoices) {
                staffChoices.clearStore();
                staffChoices.setChoices([{
                    value: '',
                    label: 'Pilih Team terlebih dahulu',
                    selected: true,
                    disabled: true
                }], 'value', 'label', true);
            } else {
                staffSelect.innerHTML = '<option value="">Pilih Team terlebih dahulu</option>';
            }
            return;
        }

        fetch(`<?= base_url('MyTeam/getStaffByTeam/'); ?>${teamId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    let choices = [{
                        value: '',
                        label: 'Pilih Staff',
                        selected: true,
                        disabled: true
                    }];
                    data.data.forEach(staff => {
                        choices.push({
                            value: staff.id_user,
                            label: staff.nama
                        });
                    });

                    if (staffChoices) {
                        staffChoices.clearStore();
                        staffChoices.setChoices(choices, 'value', 'label', true);
                    } else {
                        let options = '<option value="">Pilih Staff</option>';
                        data.data.forEach(staff => {
                            options += `<option value="${staff.id_user}">${staff.nama}</option>`;
                        });
                        staffSelect.innerHTML = options;
                    }
                } else {
                    if (staffChoices) {
                        staffChoices.clearStore();
                        staffChoices.setChoices([{
                            value: '',
                            label: 'Tidak ada staff tersedia',
                            selected: true,
                            disabled: true
                        }], 'value', 'label', true);
                    } else {
                        staffSelect.innerHTML = '<option value="">Tidak ada staff tersedia</option>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (staffChoices) {
                    staffChoices.clearStore();
                    staffChoices.setChoices([{
                        value: '',
                        label: 'Gagal memuat data',
                        selected: true,
                        disabled: true
                    }], 'value', 'label', true);
                } else {
                    staffSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                }
            });
    }

    // Listen to change event on team_id (works with both Choices.js and native select)
    teamSelect.addEventListener('change', function() {
        loadStaffByTeam(this.value);
    });
    </script>