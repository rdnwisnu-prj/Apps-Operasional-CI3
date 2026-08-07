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
        <div class="row">
            <?php 
            $card_config = [
                ['key' => 'Total',       'label' => 'Total Crosseling', 'icon' => 'ti-stack-back',    'color' => 'info'],
                ['key' => 'Training',    'label' => 'Training',         'icon' => 'ti-school',         'color' => 'primary'],
                ['key' => 'Project MCU', 'label' => 'Project MCU',      'icon' => 'ti-report-medical', 'color' => 'success'],
                ['key' => 'Health Talk', 'label' => 'Health Talk',      'icon' => 'ti-microphone',     'color' => 'warning'],
                ['key' => 'Vaksinasi',   'label' => 'Vaksinasi',        'icon' => 'ti-vaccine',        'color' => 'danger'],
                ['key' => 'Konsultasi',  'label' => 'Konsultasi',       'icon' => 'ti-stethoscope',    'color' => 'secondary'],
                ['key' => 'Lab',         'label' => 'Lab',              'icon' => 'ti-flask',          'color' => 'primary'],
                ['key' => 'IHC',         'label' => 'IHC',              'icon' => 'ti-heart',          'color' => 'info'],
                ['key' => 'HSEO',        'label' => 'HSEO',             'icon' => 'ti-shield',         'color' => 'warning'],
                ['key' => 'Dokter',      'label' => 'Dokter',           'icon' => 'ti-user-plus',      'color' => 'success'],
                ['key' => 'Program',     'label' => 'Program',          'icon' => 'ti-clipboard-list', 'color' => 'danger'],
            ];
            ?>
            <?php foreach ($card_config as $card): ?>
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="card card-animate card-filter-cros cursor-pointer" data-nama-cros="<?= $card['key'] ?>" style="cursor: pointer;">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1 fs-13"><?= $card['label'] ?></p>
                                <h3 class="mb-0 ff-secondary fw-semibold">
                                    <?= isset($nama_cros_counts[$card['key']]) ? $nama_cros_counts[$card['key']] : 0 ?>
                                </h3>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-<?= $card['color'] ?> rounded-circle fs-2 shadow">
                                    <i class="ti <?= $card['icon'] ?> fs-16 text-<?= $card['color'] ?>"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Daftar <?= $subheader?></h5>
                <a href="<?= base_url()?>Crosseling/Store" class="btn btn-custom"> <i
                        class="ri-add-circle-line align-bottom me-1"></i> Add
                    Crosseling
                </a>
            </div>
            <div class="card-body">
                <table id="table-cros" class="table bordered-table w-100 table-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Crosseling</th>
                            <th>Nama Client</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Entitas</th>
                            <th class="text-end">Deal</th>
                            <th class="text-end">Prospek</th>
                            <th class="text-end">Lost</th>
                            <th>Marketing</th>
                            <th>Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($cros as $c): ?>
                        <tr>
                            <td> <?= $no++; ?></td>
                            <td><?= $c['nama_cros']; ?></td>
                            <td><?= $c['nama_client']; ?></td>
                            <td class="text-center">
                                <?= (!empty($c['tgl_crosseling']) && $c['tgl_crosseling'] != '0000-00-00') ? date('d/m/Y', strtotime($c['tgl_crosseling'])) : '-'; ?>
                            </td>
                            <td>
                                <?php if ($c['entitas'] == 'Cakra Medika'): ?>
                                <span class="badge bg-primary"><?= $c['entitas']; ?></span>
                                <?php elseif ($c['entitas'] == 'Konsehat'): ?>
                                <span class="badge bg-success"><?= $c['entitas']; ?></span>
                                <?php else: ?>
                                <span class="badge bg-secondary"><?= $c['entitas']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                Rp <?= number_format($c['deal_cros'], 0, ',', '.'); ?>
                            </td>
                            <td class="text-end">
                                Rp <?= number_format($c['prospek_cros'], 0, ',', '.'); ?>
                            </td>
                            <td class="text-end">
                                Rp <?= number_format($c['lost_cros'], 0, ',', '.'); ?>
                            </td>
                            <td><?= $c['nama']; ?></td>
                            <td><?= $c['ket_cros']; ?></td>
                            <td>

                                <?php 
                                    $can_edit = $c['user_id'] == $current_user_id;
                                    ?>

                                <div class="dropdown table-action">
                                    <button class="action-icon btn btn-xs shadow btn-icon btn-outline-light"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <?php if ($can_edit): ?>
                                        <li>
                                            <a href="<?= base_url()?>Crosseling/Update/<?= $c['id_cros']; ?>"
                                                class="dropdown-item edit-item-btn"><i
                                                    class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <span class="dropdown-item text-muted disabled" data-bs-toggle="tooltip"
                                                data-bs-placement="right" title="Tidak memiliki akses edit">
                                                <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                Edit
                                            </span>
                                        </li>
                                        <?php endif; ?>

                                        <li>
                                            <a href="<?= base_url()?>Crosseling/Destroy/<?= $c['id_cros']; ?>"
                                                class="dropdown-item remove-item-btn btn-destroy">
                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                Delete
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

    <style>
    .card-filter-cros {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .card-filter-cros:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }
    .card-filter-cros.active {
        border: 2px solid #405189;
        box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var table = $('#table-cros').DataTable();
            var cardFilters = document.querySelectorAll('.card-filter-cros');
            var defaultCard = document.querySelector('.card-filter-cros[data-nama-cros="Total"]');

            if (defaultCard) {
                defaultCard.classList.add('active');
            }

            cardFilters.forEach(function(card) {
                card.addEventListener('click', function() {
                    var namaCros = this.getAttribute('data-nama-cros');
                    cardFilters.forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                    if (namaCros === 'Total') {
                        table.column(1).search('').draw();
                    } else {
                        table.column(1).search('^' + namaCros + '$', true, false).draw();
                    }
                });
            });
        }, 500);
    });
    </script>