<div class="page-wrapper">

    <?php if ($this->session->flashdata('flash')): ?>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="flash-failed" data-flashdata="<?= $this->session->flashdata('error'); ?>"></div>
    <?php endif; ?>

    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Menu</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">Menu</li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $header?></li>
                    </ol>
                </nav>
            </div>
            <div class="gap-2 d-flex align-items-center flex-wrap">
                <button type="button" class="btn btn-primary" id="btn-new-event">
                    <i class="ti ti-circle-plus me-1"></i>Add Event
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Daftar Kegiatan</h4>
                            </div>
                            <div class="card-body mb-0">
                                <div id="external-events">
                                    <p class="text-muted"></p>
                                    <div class="external-event fc-event bg-soft-info text-info"
                                        data-class="bg-soft-info">
                                        <i class="ti ti-square-check fw-bold font-size-11 me-2"></i>Visit
                                        Client
                                    </div>
                                    <div class="external-event fc-event bg-soft-dark text-dark"
                                        data-class="bg-soft-dark">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>Meeting
                                        Online
                                    </div>
                                    <div class="external-event fc-event bg-soft-secondary text-secondary"
                                        data-class="bg-soft-secondary">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>TM External
                                    </div>
                                    <div class="external-event fc-event bg-soft-danger text-danger"
                                        data-class="bg-soft-danger">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>TM Internal
                                    </div>
                                    <div class="external-event fc-event bg-soft-success text-success"
                                        data-class="bg-soft-success">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>Presentasi /
                                        Meeting Bidding
                                    </div>
                                    <div class="external-event fc-event bg-soft-blue text-light"
                                        data-class="bg-soft-blue">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>Entertainment
                                        Client
                                    </div>

                                    <div class="external-event fc-event bg-soft-cakra text-light"
                                        data-class="bg-soft-cakra">
                                        <i class="ti ti-square-check font-size-11 me-2"></i>Lain - lain
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div style='clear:both'></div>

                <!-- Modal Add Event -->
                <div class="modal fade" id="modal-add-event" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-soft-success">
                                <h5 class="modal-title">Tambah Kegiatan Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form class="needs-validation" id="form-add-event" novalidate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select class="form-select" name="category" id="add-event-category"
                                                    required>
                                                    <option value="">Pilih Kategori Kegiatan</option>
                                                    <option value="bg-soft-info">Visit Client</option>
                                                    <option value="bg-soft-dark">Meeting Online</option>
                                                    <option value="bg-soft-secondary">TM External</option>
                                                    <option value="bg-soft-danger">TM Internal</option>
                                                    <option value="bg-soft-success">Presentasi / Meeting Bidding
                                                    </option>
                                                    <option value="bg-soft-blue">Entertainment Client</option>
                                                    <option value="bg-soft-cakra">Lain - lain</option>
                                                </select>
                                                <div class="invalid-feedback">Pilih kategori kegiatan</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kegiatan</label>
                                                <input class="form-control" placeholder="Masukkan nama kegiatan"
                                                    type="text" name="title" id="add-event-title" required />
                                                <div class="invalid-feedback">Masukkan nama kegiatan</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Kegiatan</label>
                                                <div class="input-group">
                                                    <input type="text" id="add-event-start-date"
                                                        class="form-control flatpickr flatpickr-input"
                                                        placeholder="Pilih tanggal" readonly required>
                                                    <span class="input-group-text"><i
                                                            class="ri-calendar-event-line"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="add-event-time">
                                            <div class="mb-2">
                                                <label class="form-label">Waktu Cepat</label>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="08:00" data-end="09:00"
                                                        data-modal="add">08:00-09:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="09:00" data-end="10:00"
                                                        data-modal="add">09:00-10:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="10:00" data-end="12:00"
                                                        data-modal="add">10:00-12:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="13:00" data-end="15:00"
                                                        data-modal="add">13:00-15:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="14:00" data-end="16:00"
                                                        data-modal="add">14:00-16:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary time-preset"
                                                        data-start="15:00" data-end="17:00"
                                                        data-modal="add">15:00-17:00</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Mulai</label>
                                                        <div class="input-group">
                                                            <input id="add-timepicker1" type="text"
                                                                class="form-control flatpickr flatpickr-input"
                                                                placeholder="Pilih jam" readonly>
                                                            <span class="input-group-text"><i
                                                                    class="ri-time-line"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Selesai</label>
                                                        <div class="input-group">
                                                            <input id="add-timepicker2" type="text"
                                                                class="form-control flatpickr flatpickr-input"
                                                                placeholder="Pilih jam" readonly>
                                                            <span class="input-group-text"><i
                                                                    class="ri-time-line"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="location"
                                                    id="add-event-location" placeholder="Masukkan lokasi">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="add-event-description"
                                                    placeholder="Masukkan keterangan" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success" id="btn-add-event">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail Event -->
                <div class="modal fade" id="modal-detail-event" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-soft-info">
                                <h5 class="modal-title" id="detail-modal-title">Detail Kegiatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="event-details">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ti ti-category text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span id="detail-event-category"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ti ti-calendar-week text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block fw-semibold mb-0" id="detail-event-date"></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-time-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block fw-semibold mb-0">
                                                <span id="detail-event-time-start"></span> - <span
                                                    id="detail-event-time-end"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-map-pin-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block fw-semibold mb-0" id="detail-event-location"></p>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-discuss-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block text-muted mb-0" id="detail-event-description"></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-user-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="d-block fw-semibold mb-0">Dibuat oleh: <span
                                                    id="detail-event-createdby"></span></p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="detail-eventid" value="" />
                                <div class="hstack gap-2 justify-content-end mt-3">
                                    <button type="button" class="btn btn-soft-danger" id="btn-delete-event"><i
                                            class="ri-delete-bin-line align-bottom"></i> Hapus</button>
                                    <button type="button" class="btn btn-soft-primary" id="btn-open-edit"><i
                                            class="ri-edit-line align-bottom"></i> Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Event -->
                <div class="modal fade" id="modal-edit-event" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0">
                            <div class="modal-header p-3 bg-soft-warning">
                                <h5 class="modal-title">Edit Kegiatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-hidden="true"></button>
                            </div>
                            <div class="modal-body p-4">
                                <form class="needs-validation" id="form-edit-event" novalidate>
                                    <input type="hidden" id="edit-eventid" name="eventid" value="" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Kategori</label>
                                                <select class="form-select" name="category" id="edit-event-category"
                                                    required>
                                                    <option value="">Pilih Kategori Kegiatan</option>
                                                    <option value="bg-soft-info">Visit Client</option>
                                                    <option value="bg-soft-dark">Meeting Online</option>
                                                    <option value="bg-soft-secondary">TM External</option>
                                                    <option value="bg-soft-danger">TM Internal</option>
                                                    <option value="bg-soft-success">Presentasi / Meeting Bidding
                                                    </option>
                                                    <option value="bg-soft-blue">Entertainment Client</option>
                                                    <option value="bg-soft-cakra">Lain - lain</option>
                                                </select>
                                                <div class="invalid-feedback">Pilih kategori kegiatan</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kegiatan</label>
                                                <input class="form-control" placeholder="Masukkan nama kegiatan"
                                                    type="text" name="title" id="edit-event-title" required />
                                                <div class="invalid-feedback">Masukkan nama kegiatan</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Kegiatan</label>
                                                <div class="input-group">
                                                    <input type="text" id="edit-event-start-date"
                                                        class="form-control flatpickr flatpickr-input"
                                                        placeholder="Pilih tanggal" readonly required>
                                                    <span class="input-group-text"><i
                                                            class="ri-calendar-event-line"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="edit-event-time">
                                            <div class="mb-2">
                                                <label class="form-label">Waktu Cepat</label>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="08:00" data-end="09:00"
                                                        data-modal="edit">08:00-09:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="09:00" data-end="10:00"
                                                        data-modal="edit">09:00-10:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="10:00" data-end="12:00"
                                                        data-modal="edit">10:00-12:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="13:00" data-end="15:00"
                                                        data-modal="edit">13:00-15:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="14:00" data-end="16:00"
                                                        data-modal="edit">14:00-16:00</button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning time-preset"
                                                        data-start="15:00" data-end="17:00"
                                                        data-modal="edit">15:00-17:00</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Mulai</label>
                                                        <div class="input-group">
                                                            <input id="edit-timepicker1" type="text"
                                                                class="form-control flatpickr flatpickr-input"
                                                                placeholder="Pilih jam" readonly>
                                                            <span class="input-group-text"><i
                                                                    class="ri-time-line"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Waktu Selesai</label>
                                                        <div class="input-group">
                                                            <input id="edit-timepicker2" type="text"
                                                                class="form-control flatpickr flatpickr-input"
                                                                placeholder="Pilih jam" readonly>
                                                            <span class="input-group-text"><i
                                                                    class="ri-time-line"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="location"
                                                    id="edit-event-location" placeholder="Masukkan lokasi">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="edit-event-description"
                                                    placeholder="Masukkan keterangan" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning"
                                            id="btn-update-event">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>