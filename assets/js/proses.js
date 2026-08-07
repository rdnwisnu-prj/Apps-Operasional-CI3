function formatNumber(num) {
	return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function unformatNumber(str) {
	return str.replace(/\./g, '');
}

$(document).ready(function () {
	$('.format-number').on('input', function () {
		var cursorPos = this.selectionStart;
		var oldLength = this.value.length;
		var value = this.value.replace(/[^0-9]/g, '');
		var formatted = formatNumber(value);
		this.value = formatted;
		var hiddenField = $(this).siblings('input[type="hidden"]');
		if (hiddenField.length === 0) {
			hiddenField = $(this).parent().find('input[type="hidden"]');
		}
		hiddenField.val(value);
		var newLength = this.value.length;
		var posDiff = newLength - oldLength;
		this.setSelectionRange(cursorPos + posDiff, cursorPos + posDiff);
	});

	$('.format-number').each(function () {
		var hiddenField = $(this).siblings('input[type="hidden"]');
		if (hiddenField.length === 0) {
			hiddenField = $(this).parent().find('input[type="hidden"]');
		}
		if (hiddenField.val() && hiddenField.val() !== '0') {
			this.value = formatNumber(hiddenField.val());
		}
	});
});

$(function () {
	var SweetAlert = function () {};

	SweetAlert.prototype.init = function () {
		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timerProgressBar: false,
			customClass: {
				popup: 'colored-toast',
			},
		});

		const flashDataElem = document.querySelector('.flash-data');
		if (flashDataElem) {
			const flashData = flashDataElem.dataset.flashdata;
			if (flashData) {
				Toast.fire({
					icon: 'success',
					title: 'Data Berhasil ' + flashData,
					timer: 1500,
				});
			}
		}

		const flashErrorElem = document.querySelector('.flash-error');
		if (flashErrorElem) {
			const flashErrorData = flashErrorElem.dataset.flashdata;
			if (flashErrorData) {
				Toast.fire({
					icon: 'error',
					title: flashErrorData,
					timer: 1500,
				});
			}
		}

		const flashLoginElem = document.querySelector('.flash-login');
		if (flashLoginElem) {
			const flashLoginData = flashLoginElem.dataset.flashdata;
			if (flashLoginData) {
				Toast.fire({
					icon: 'success',
					title: flashLoginData,
					timer: 1500,
				});
			}
		}

		const flashFailedElem = document.querySelector('.flash-failed');
		if (flashFailedElem) {
			const flashFailedProses = flashFailedElem.dataset.flashdata;
			if (flashFailedProses) {
				Toast.fire({
					icon: 'error',
					title: flashFailedProses,
					timer: 1500,
				});
			}
		}

		const flashLogoutElem = document.querySelector('.flash-logout');
		if (flashLogoutElem) {
			const flashLogoutProses = flashLogoutElem.dataset.flashdata;
			if (flashLogoutProses) {
				Toast.fire({
					icon: 'success',
					title: flashLogoutProses,
					timer: 1500,
				});
			}
		}

		$(document).on('click', '.btn-logout', function (e) {
			e.preventDefault();
			const href = $(this).attr('href');

			Swal.fire({
				title: 'Apakah Anda yakin ingin logout?',
				text: 'Anda akan keluar dari sistem!',
				icon: 'warning',
				showCancelButton: !0,
				confirmButtonColor: '#34c38f',
				cancelButtonColor: '#f46a6a',
				confirmButtonText: 'Keluar',
				showCloseButton: !0,
			}).then((result) => {
				if (result.isConfirmed) {
					document.location.href = href;
				}
			});
		});

		$(document).on('click', '.btn-destroy', function (e) {
			e.preventDefault();
			const href = $(this).attr('href');

			Swal.fire({
				title: 'Apakah anda yakin ?',
				text: 'Data akan terhapus permanen!',
				icon: 'warning',
				showCancelButton: !0,
				confirmButtonColor: '#34c38f',
				cancelButtonColor: '#f46a6a',
				confirmButtonText: 'Ya, Hapus Data!',
			}).then((result) => {
				if (result.isConfirmed) {
					$.post(href, function (response) {
						Toast.fire({
							icon: 'success',
							title: 'Data berhasil dihapus',
							timer: 1500,
						});
						setTimeout(function () {
							location.reload();
						}, 2000);
					}).fail(function () {
						Toast.fire({
							icon: 'error',
							title: 'Terjadi kesalahan saat menghapus data.',
							timer: 1500,
						});
					});
				}
			});
		});

		$(document).on('click', '#btn-delete-selected', function (e) {
			e.preventDefault();
			var selectedOrders = [];
			$('.checkRowOrder:checked').each(function () {
				selectedOrders.push($(this).val());
			});

			if (selectedOrders.length === 0) {
				Swal.fire({
					icon: 'warning',
					title: 'Tidak ada data yang dipilih',
					text: 'Silakan pilih minimal satu data untuk dihapus.',
				});
				return;
			}

			Swal.fire({
				html: '<div class="mt-3"><div class="mt-4 pt-2 fs-15 mx-5"><h4>Apakah anda yakin?</h4><p class="text-muted mx-4 mb-0">Data akan dihapus !</p></div></div>',
				showCancelButton: true,
				confirmButtonText: 'Hapus Data!',
				customClass: {
					confirmButton: 'btn btn-purple me-3 waves-effect waves-light',
					cancelButton: 'btn btn-light waves-effect waves-light',
				},
				buttonsStyling: false,
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: base_url + 'Proses/Order/batchDestroy',
						type: 'POST',
						data: { orders: selectedOrders },
						success: function (response) {
							Toast.fire({
								icon: 'success',
								title: 'Data berhasil dihapus',
								timer: 1500,
							});
							setTimeout(function () {
								location.reload();
							}, 2000);
						},
						error: function () {
							Toast.fire({
								icon: 'error',
								title: 'Terjadi kesalahan saat menghapus data.',
								timer: 1500,
							});
						},
					});
				}
			});
		});
	};
	var sweetAlert = new SweetAlert();
	sweetAlert.init();
});

// Proses Add Role
$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});
	$('#formAddRole').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Setting/Role/store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addRole').modal('hide');
						location.reload();
					});
				} else if (response.status === 'error') {
					$('#nama_role').addClass('is-invalid');
					$('#nama_role_error').text('Nama Role wajib diisi').show();
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addRole').on('hidden.bs.modal', function () {
		$('#formAddRole')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
	});
});

// Proses Edit Role
$(document).ready(function () {
	$(document).on('click', '.edit-role', function (e) {
		e.preventDefault();

		var id = $(this).data('id-role');
		$.ajax({
			url: base_url + 'Setting/Role/getRoleById/' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function (data) {
				if (!data) {
					Swal.fire({
						icon: 'error',
						title: 'Gagal',
						text: 'Data role tidak ditemukan.',
					});
					return;
				}

				$('#edit_id_role').val(data.id_role);
				$('#edit_nama_role').val(data.nama_role);
				$('#editRole').modal('show');
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Gagal mengambil data role.',
				});
			},
		});
	});
});

// Proses Add Leads
$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});

	$('#formAddLeads').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Leads/store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addLeads').modal('hide');
						location.reload();
					});
				} else if (response.status === 'warning') {
					Toast.fire({
						icon: 'warning',
						title: response.message,
						timer: 3000,
					});

					$('#nama_client').addClass('is-invalid');
					$('#nama_client_error').text(response.message).show();
				} else if (response.status === 'error') {
					if (response.message.includes('Nama Perusahaan')) {
						$('#nama_client').addClass('is-invalid');
						$('#nama_client_error')
							.text('Nama Client tidak boleh kosong')
							.show();
					}

					if (response.message.includes('Nama PIC')) {
						$('#nama_pic').addClass('is-invalid');
						$('#nama_pic_error').text('Nama PIC tidak boleh kosong').show();
					}

					if (response.message.includes('No Tlp PIC')) {
						$('#tlp_pic').addClass('is-invalid');
						$('#tlp_pic_error').text('No Tlp PIC tidak boleh kosong').show();
					}

					if (response.message.includes('Status Prospek')) {
						$('#status_lead').addClass('is-invalid');
						$('#status_lead_error').text('Status Prospek harus dipilih').show();
					}

					if (response.message.includes('Catatan')) {
						$('#catatan').addClass('is-invalid');
						$('#catatan_error').text('Catatan tidak boleh kosong').show();
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addLeads').on('hidden.bs.modal', function () {
		$('#formAddLeads')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
	});
});

// Proses Edit Leads
$(document).ready(function () {
	$('.edit-leads').click(function () {
		var id = $(this).data('id-leads');
		$.ajax({
			url: base_url + 'Leads/getLeadsById/' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function (data) {
				$('#edit_id_leads').val(data.id_leads);
				$('#edit_nama_client').val(data.nama_client);
				$('#edit_nama_pic').val(data.nama_pic);
				$('#edit_tlp_pic').val(data.tlp_pic);
				$('#edit_email_pic').val(data.email_pic);
				$('#edit_alamat_client').val(data.alamat_client);
				$('#edit_status_lead').val(data.status_lead).trigger('change');
				$('#edit_estimasi_lead').val(data.estimasi_lead);
				$('#edit_catatan').val(data.catatan);
				$('.invalid-feedback').text('');
				$('.form-control, .select2LeadsEdit').removeClass('is-invalid');
			},
			error: function (xhr, status, error) {
				console.error('Error fetching lead data:', error);
			},
		});
	});

	$('#formEditLeads').submit(function (e) {
		e.preventDefault();
		$('.invalid-feedback').text('');
		$('.form-control, .select2LeadsEdit').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Leads/Update',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editLeads').modal('hide');
						location.reload();
					});
				} else {
					if (response.message) {
						let errors = response.message;
						if (errors.includes('Nama Perusahaan')) {
							$('#edit_nama_client').addClass('is-invalid');
							$('#edit_nama_client_error').text('Nama Perusahaan harus diisi');
						}
						if (errors.includes('Nama PIC')) {
							$('#edit_nama_pic').addClass('is-invalid');
							$('#edit_nama_pic_error').text('Nama PIC harus diisi');
						}
						if (errors.includes('No Tlp PIC')) {
							$('#edit_tlp_pic').addClass('is-invalid');
							$('#edit_tlp_pic_error').text('No Tlp PIC harus diisi');
						}
						if (errors.includes('Status Prospek')) {
							$('#edit_status_lead').addClass('is-invalid');
							$('#edit_status_lead_error').text('Status Prospek harus dipilih');
						}

						if (errors.includes('Catatan')) {
							$('#edit_catatan').addClass('is-invalid');
							$('#edit_catatan_error').text('Catatan harus diisi');
						}
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error updating lead:', error);
				alert('Terjadi kesalahan saat memperbarui data');
			},
		});
	});
});

// Proses Add Client
$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});

	$('#formAddClient').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Client/Store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addClient').modal('hide');
						location.reload();
					});
				} else if (response.status === 'warning') {
					Toast.fire({
						icon: 'warning',
						title: response.message,
						timer: 3000,
					});

					$('#nama_client').addClass('is-invalid');
					$('#nama_client_error').text(response.message).show();
				} else if (response.status === 'error') {
					if (response.message.includes('Nama Perusahaan')) {
						$('#nama_client').addClass('is-invalid');
						$('#nama_client_error')
							.text('Nama Client tidak boleh kosong')
							.show();
					}

					if (response.message.includes('Nama PIC')) {
						$('#nama_pic').addClass('is-invalid');
						$('#nama_pic_error').text('Nama PIC tidak boleh kosong').show();
					}

					if (response.message.includes('No Tlp PIC')) {
						$('#tlp_pic').addClass('is-invalid');
						$('#tlp_pic_error').text('No Tlp PIC tidak boleh kosong').show();
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addClient').on('hidden.bs.modal', function () {
		$('#formAddClient')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
	});
});

// Proses Edit Client
$(document).ready(function () {
	$('.edit-client').click(function () {
		var id = $(this).data('id-client');
		$.ajax({
			url: base_url + 'Client/getClientById/' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function (data) {
				$('#edit_id_client').val(data.id_client);
				$('#edit_nama_client').val(data.nama_client);
				$('#edit_nama_pic').val(data.nama_pic);
				$('#edit_alamat_pic').val(data.alamat_pic);
				$('#edit_tlp_pic').val(data.tlp_pic);
				$('#edit_email_pic').val(data.email_pic);
				$('#edit_alamat_client').val(data.alamat_client);
				$('#edit_hut_pic').val(data.hut_pic);
				$('#edit_hut_client').val(data.hut_client);
				$('#edit_sektor').val(data.sektor).trigger('change');
				$('#edit_group').val(data.group).trigger('change');
				$('#edit_status').val(data.status).trigger('change');
				$('.invalid-feedback').text('');
				$('.form-control, .select2SektorEdit').removeClass('is-invalid');
				$('.form-control, .select2GroupEdit').removeClass('is-invalid');
				$('.form-control, .select2StatusEdit').removeClass('is-invalid');
			},
			error: function (xhr, status, error) {
				console.error('Error fetching lead data:', error);
			},
		});
	});

	$('#formEditClient').submit(function (e) {
		e.preventDefault();
		$('.invalid-feedback').text('');
		$('.form-control, .select2SektorEdit').removeClass('is-invalid');
		$('.form-control, .select2GroupEdit').removeClass('is-invalid');
		$('.form-control, .select2StatusEdit').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Client/Update',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editClient').modal('hide');
						location.reload();
					});
				} else {
					if (response.message) {
						let errors = response.message;
						if (errors.includes('Nama Perusahaan')) {
							$('#edit_nama_client').addClass('is-invalid');
							$('#edit_nama_client_error').text('Nama Perusahaan harus diisi');
						}
						if (errors.includes('Nama PIC')) {
							$('#edit_nama_pic').addClass('is-invalid');
							$('#edit_nama_pic_error').text('Nama PIC harus diisi');
						}
						if (errors.includes('No Tlp PIC')) {
							$('#edit_tlp_pic').addClass('is-invalid');
							$('#edit_tlp_pic_error').text('No Tlp PIC harus diisi');
						}
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error updating lead:', error);
				alert('Terjadi kesalahan saat memperbarui data');
			},
		});
	});
});

$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});
	$('#formEditClientView').submit(function (e) {
		e.preventDefault();
		$('.invalid-feedback').text('');
		$('.form-control').removeClass('is-invalid');
		var formData = new FormData(this);

		$.ajax({
			url: base_url + 'Client/UpdateView',
			type: 'POST',
			data: formData,
			dataType: 'JSON',
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editClient').modal('hide');
						location.reload();
					});
				} else {
					if (response.message) {
						let errors = response.message;
						if (errors.includes('Nama PIC')) {
							$('#edit_nama_pic').addClass('is-invalid');
							$('#edit_nama_pic_error').text('Nama PIC harus diisi');
						}
						if (errors.includes('No Tlp PIC') || errors.includes('No PIC')) {
							$('#edit_tlp_pic').addClass('is-invalid');
							$('#edit_tlp_pic_error').text('No Tlp PIC harus diisi');
						}
					}
					Toast.fire({
						icon: 'error',
						title:
							response.message || 'Terjadi kesalahan saat memperbarui data',
						timer: 2000,
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('Error updating client:', error);
				Toast.fire({
					icon: 'error',
					title: 'Terjadi kesalahan saat memperbarui data',
					timer: 2000,
				});
			},
		});
	});
});

// Proses Add Project
$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});
	$('#formAddProject').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Project/store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addProject').modal('hide');
						location.reload();
					});
				} else if (response.status === 'error') {
					$('#client_id').addClass('is-invalid');
					$('#client_id_error').text('Client wajib dipilih').show();

					$('#nama_project').addClass('is-invalid');
					$('#nama_project_error').text('Nama Project wajib diisi').show();

					$('#service').addClass('is-invalid');
					$('#service_error').text('Service wajib diisi').show();
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addProject').on('hidden.bs.modal', function () {
		$('#formAddProject')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
	});
});

// Proses Edit Project
$(document).ready(function () {
	$('.edit-project').click(function () {
		var id = $(this).data('id-project');
		$.ajax({
			url: base_url + 'Project/getProjectById/' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function (data) {
				$('#edit_id_project').val(data.id_project);
				$('#edit_client_id').val(data.client_id).trigger('change');
				$('#edit_nama_project').val(data.nama_project);
				$('#edit_service').val(data.service).trigger('change');
				$('#edit_tgl_pelaksanaan').val(data.tgl_pelaksanaan);
				$('#edit_tgl_selesai').val(data.tgl_selesai);
				$('#edit_jumlah_karyawan').val(data.jumlah_karyawan);
				$('#edit_estimasi').val(data.estimasi);
				$('#edit_status_project').val(data.status_project).trigger('change');
				$('#edit_deskripsi').val(data.deskripsi);
				$('.invalid-feedback').text('');
				$('.form-control, .select2ClientsEdit').removeClass('is-invalid');
				$('.form-control, .select2ServiceEdit').removeClass('is-invalid');
			},
			error: function (xhr, status, error) {
				console.error('Error fetching lead data:', error);
			},
		});
	});

	$('#formEditProject').submit(function (e) {
		e.preventDefault();
		$('.invalid-feedback').text('');
		$('.form-control, .select2ClientsEdit').removeClass('is-invalid');
		$('.form-control, .select2ServiceEdit').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Project/Update',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editProject').modal('hide');
						location.reload();
					});
				} else {
					if (response.message) {
						let errors = response.message;
						if (errors.includes('Perusahaan')) {
							$('#edit_client_id').addClass('is-invalid');
							$('#edit_client_id_error').text('Perusahaan harus dipilih');
						}
						if (errors.includes('Nama Project')) {
							$('#edit_nama_project').addClass('is-invalid');
							$('#edit_nama_project_error').text('Nama Project harus diisi');
						}
						if (errors.includes('Service')) {
							$('#edit_service').addClass('is-invalid');
							$('#edit_service_error').text('Service harus dipilih');
						}
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error updating lead:', error);
				alert('Terjadi kesalahan saat memperbarui data');
			},
		});
	});
});

$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});
	$('#formAddMyTeam').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'MyTeam/store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addMyTeam').modal('hide');
						location.reload();
					});
				} else if (response.status === 'error') {
					$('#staff_id').addClass('is-invalid');
					$('#staff_id_error').text('Staff Wajib di pilih').show();
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addMyTeam').on('hidden.bs.modal', function () {
		$('#formAddMyTeam')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
	});
});

$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});

	$('#addBenefit #client_id').on('change', function () {
		var clientId = $(this).val();
		var projectSelect = $('#addBenefit #project_id');

		// Reset project dropdown
		projectSelect.empty();
		projectSelect.append(
			'<option value="">Pilih Client Terlebih Dahulu</option>'
		);

		if (clientId === '') {
			return;
		}

		// Fetch projects based on selected client
		$.ajax({
			url: base_url + 'Benefit/getProjectByClient/' + clientId,
			type: 'GET',
			dataType: 'json',
			success: function (projects) {
				if (projects.length > 0) {
					$.each(projects, function (index, project) {
						projectSelect.append(
							'<option value="' +
								project.id_project +
								'">' +
								project.nama_project +
								' - ' +
								project.service +
								'</option>'
						);
					});
				} else {
					projectSelect.append(
						'<option value="" disabled>Tidak ada project untuk client ini</option>'
					);
				}
			},
			error: function (xhr, status, error) {
				console.error('Error fetching projects:', error);
			},
		});
	});

	$('#edit_client_id').on('change', function () {
		var clientId = $(this).val();
		var projectSelect = $('#edit_project_id');

		// Reset project dropdown
		projectSelect.empty();
		projectSelect.append('<option value="">Pilih Project</option>');

		if (clientId === '') {
			return;
		}

		// Fetch projects based on selected client
		$.ajax({
			url: base_url + 'Benefit/getProjectByClient/' + clientId,
			type: 'GET',
			dataType: 'json',
			success: function (projects) {
				if (projects.length > 0) {
					$.each(projects, function (index, project) {
						projectSelect.append(
							'<option value="' +
								project.id_project +
								'">' +
								project.nama_project +
								' - ' +
								project.service +
								'</option>'
						);
					});
				} else {
					projectSelect.append(
						'<option value="" disabled>Tidak ada project untuk client ini</option>'
					);
				}
			},
			error: function (xhr, status, error) {
				console.error('Error fetching projects:', error);
			},
		});
	});

	$('#formAddBenefit').on('submit', function (e) {
		e.preventDefault();

		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Benefit/store',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#addBenefit').modal('hide');
						location.reload();
					});
				} else if (response.status === 'error') {
					Toast.fire({
						icon: 'error',
						title: 'Validasi gagal',
						timer: 3000,
					});

					if (response.message.includes('Client')) {
						$('#client_id').addClass('is-invalid');
						$('#client_id_error').text('Client harus dipilih').show();
					}

					if (response.message.includes('Project')) {
						$('#project_id').addClass('is-invalid');
						$('#project_id_error').text('Project harus dipilih').show();
					}

					if (response.message.includes('Nama Benefit')) {
						$('#nama_benefit').addClass('is-invalid');
						$('#nama_benefit_error')
							.text('Nama Benefit tidak boleh kosong')
							.show();
					}

					if (response.message.includes('Status Benefit')) {
						$('#status_benefit').addClass('is-invalid');
						$('#status_benefit_error')
							.text('Status Benefit harus dipilih')
							.show();
					}

					if (response.message.includes('Entitas')) {
						$('#entitas').addClass('is-invalid');
						$('#entitas_error').text('Entitas harus dipilih').show();
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#addBenefit').on('hidden.bs.modal', function () {
		$('#formAddBenefit')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
		$('#addBenefit #project_id')
			.empty()
			.append('<option value="">Pilih Client Terlebih Dahulu</option>');
	});
});

// Proses Edit Benefit
$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});

	$('.edit-benefit').click(function () {
		var id = $(this).data('id-benefit');
		$.ajax({
			url: base_url + 'Benefit/getBenefitById/' + id,
			type: 'GET',
			dataType: 'JSON',
			success: function (data) {
				$('#edit_id_benefit').val(data.id_benefit);
				$('#edit_client_id').val(data.client_id);

				// Load projects based on client_id via AJAX
				var projectSelect = $('#edit_project_id');
				projectSelect.empty();
				projectSelect.append('<option value="">Pilih Project</option>');

				if (data.client_id) {
					$.ajax({
						url: base_url + 'Benefit/getProjectByClient/' + data.client_id,
						type: 'GET',
						dataType: 'json',
						success: function (projects) {
							if (projects.length > 0) {
								$.each(projects, function (index, project) {
									projectSelect.append(
										'<option value="' +
											project.id_project +
											'">' +
											project.nama_project +
											'</option>'
									);
								});
							}
							// Set selected project after options are loaded
							projectSelect.val(data.project_id);
						},
						error: function (xhr, status, error) {
							console.error('Error fetching projects:', error);
						},
					});
				}

				$('#edit_nama_benefit').val(data.nama_benefit);
				$('#edit_status_benefit').val(data.status_benefit);
				$('#edit_entitas').val(data.entitas);
				$('#edit_tgl_benefit_mulai').val(data.tgl_benefit_mulai);
				$('#edit_tgl_benefit_selesai').val(data.tgl_benefit_selesai);
				$('#edit_keterangan').val(data.keterangan);
				$('.invalid-feedback').text('');
				$('.form-control').removeClass('is-invalid');
			},
			error: function (xhr, status, error) {
				console.error('Error fetching benefit data:', error);
			},
		});
	});

	$('#formEditBenefit').submit(function (e) {
		e.preventDefault();
		$('.invalid-feedback').text('');
		$('.form-control').removeClass('is-invalid');

		$.ajax({
			url: base_url + 'Benefit/update',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'JSON',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editBenefit').modal('hide');
						location.reload();
					});
				} else {
					Toast.fire({
						icon: 'error',
						title: response.message,
						timer: 3000,
					});

					if (response.message) {
						let errors = response.message;
						if (errors.includes('Client')) {
							$('#edit_client_id').addClass('is-invalid');
							$('#edit_client_id_error').text('Client harus dipilih');
						}
						if (errors.includes('Project')) {
							$('#edit_project_id').addClass('is-invalid');
							$('#edit_project_id_error').text('Project harus dipilih');
						}
						if (errors.includes('Nama Benefit')) {
							$('#edit_nama_benefit').addClass('is-invalid');
							$('#edit_nama_benefit_error').text('Nama Benefit harus diisi');
						}
						if (errors.includes('Status Benefit')) {
							$('#edit_status_benefit').addClass('is-invalid');
							$('#edit_status_benefit_error').text(
								'Status Benefit harus dipilih'
							);
						}
						if (errors.includes('Entitas')) {
							$('#edit_entitas').addClass('is-invalid');
							$('#edit_entitas_error').text('Entitas harus dipilih');
						}
						if (errors.includes('Tanggal Benefit Mulai')) {
							$('#edit_tgl_benefit_mulai').addClass('is-invalid');
							$('#edit_tgl_benefit_mulai_error').text(
								'Tanggal Benefit Mulai harus diisi'
							);
						}
						if (errors.includes('Tanggal Benefit Selesai')) {
							$('#edit_tgl_benefit_selesai').addClass('is-invalid');
							$('#edit_tgl_benefit_selesai_error').text(
								'Tanggal Benefit Selesai harus diisi'
							);
						}
					}
				}
			},
			error: function (xhr, status, error) {
				console.error('Error updating benefit:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat memperbarui data.',
				});
			},
		});
	});

	$('#editBenefit').on('hidden.bs.modal', function () {
		$('#formEditBenefit')[0].reset();
		$('.invalid-feedback').text('').hide();
		$('.form-control').removeClass('is-invalid');
		$('#edit_project_id')
			.empty()
			.append('<option value="">Pilih Client Terlebih Dahulu</option>');
	});
});

$(document).ready(function () {
	$('#client_id').on('change', function () {
		const clientId = $(this).val();

		$('#project_id').html('<option value="">Pilih Project</option>');

		if (clientId) {
			$('#project_id').html('<option value="">Memuat project...</option>');

			$.ajax({
				url: base_url + 'Crosseling/getProjectsByClient/' + clientId,
				type: 'GET',
				dataType: 'json',
				success: function (projects) {
					let options = '<option value="">Pilih Project</option>';

					if (projects.length > 0) {
						$.each(projects, function (index, project) {
							options += `<option value="${project.id_project}">${project.nama_project}</option>`;
						});
					} else {
						options =
							'<option value="">Tidak ada project untuk client ini</option>';
					}

					$('#project_id').html(options);
					if ($('#project_id').data('choices')) {
						$('#project_id').data('choices').destroy();
						new Choices('#project_id');
					}
				},
				error: function () {
					$('#project_id').html(
						'<option value="">Gagal memuat data project</option>'
					);
				},
			});
		} else {
			$('#project_id').html(
				'<option value="">Pilih Client Terlebih Dahulu</option>'
			);
		}
	});
});

$(document).ready(function () {
	$('#table-project').DataTable({
		bFilter: true,
		sDom: 'fBtlpi',
		language: {
			paginate: {
				next: '<i class="ti ti-arrow-right"></i>',
				previous: '<i class="ti ti-arrow-left"></i> ',
			},
		},
		responsive: true,
		autoWidth: false,
		ordering: false,
		columnDefs: [
			{
				targets: [0],
				width: '20px',
				className: 'text-center',
			},
			{
				targets: [1],
				width: '100px',
				className: 'wrap-text',
			},
			{
				targets: [2],
				width: '180px',
				className: 'wrap-text',
			},
			{
				targets: [3],
				width: '50px',
			},
			{
				targets: [4],
				width: '110px',
			},
			{
				targets: [5],
				width: '110px',
			},
			{
				targets: [6],
				width: '120px',
			},
			{
				targets: [7],
				width: '100px',
			},
			{
				targets: [8],
				width: '50px',
			},
			{
				targets: [9],
				width: '100px',
			},
			{
				targets: [10],
				width: '50px',
				className: 'text-center',
			},
		],
	});
});

$(document).ready(function () {
	$('#table-benefit').DataTable({
		bFilter: true,
		sDom: 'fBtlpi',
		language: {
			paginate: {
				next: '<i class="ti ti-arrow-right"></i>',
				previous: '<i class="ti ti-arrow-left"></i> ',
			},
		},
		ordering: false,
	});
});

$(document).ready(function () {
	var prospekController = window.prospekController || 'Prospek';

	$('#formAddPicLeads').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + prospekController + '/StorePic',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500,
					}).then(function () {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal!',
						text: response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});

	$('.btn-edit-pic-lead').on('click', function () {
		var id = $(this).data('id');

		$.ajax({
			url: base_url + prospekController + '/GetPicById/' + id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('#edit_id_pl').val(data.id_pl);
				$('#edit_nama_pic').val(data.nama_pic);
				$('#edit_no_pic').val(data.no_pic);
				$('#edit_email_pic').val(data.email_pic);
				$('#edit_hut_pic').val(data.hut_pic);
			},
		});
	});

	$('#formEditPicLeads').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + prospekController + '/UpdatePic',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500,
					}).then(function () {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal!',
						text: response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});
});

$(document).ready(function () {
	$('#formAddPic').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + 'Client/StorePic',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500,
					}).then(function () {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal!',
						text: response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});

	$('.btn-edit-pic').on('click', function () {
		var id = $(this).data('id');

		$.ajax({
			url: base_url + 'Client/GetPicById/' + id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('#edit_id_pc').val(data.id_pc);
				$('#edit_nama_pic_modal').val(data.nama_pic);
				$('#edit_no_pic_modal').val(data.no_pic);
				$('#edit_email_pic_modal').val(data.email_pic);
				$('#edit_hut_pic_modal').val(data.hut_pic);
			},
		});
	});

	$('#formEditPic').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + 'Client/UpdatePic',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500,
					}).then(function () {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal!',
						text: response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});
});

$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});
	$('#table-client').DataTable({
		bFilter: true,
		sDom: 'fBtlpi',
		language: {
			paginate: {
				next: '<i class="ti ti-arrow-right"></i>',
				previous: '<i class="ti ti-arrow-left"></i> ',
			},
		},
		responsive: true,
		ordering: false,
		columnDefs: [
			{ targets: [0], width: '20px', className: 'text-center' },
			{ targets: [1], width: '150px' },
			{ targets: [2], width: '150px', className: 'wrap-text' },
			{ targets: [3], width: '80px' },
			{ targets: [4], width: '120px' },
			{ targets: [5], width: '100px' },
			{ targets: [6], width: '100px' },
			{ targets: [7], width: '100px' },
			{ targets: [8], width: '110px' },
			{ targets: [9], width: '150px' },
			{ targets: [10], width: '120px' },
			{ targets: [11], width: '20px', className: 'text-center' },
		],
	});

	$('#checkAllClient').on('change', function () {
		$('.checkbox-item-client').prop('checked', $(this).is(':checked'));
		updateSelectedCountClient();
	});

	$(document).on('change', '.checkbox-item-client', function () {
		var total = $('.checkbox-item-client').length;
		var checked = $('.checkbox-item-client:checked').length;
		$('#checkAllClient').prop('checked', total === checked);
		updateSelectedCountClient();
	});

	function updateSelectedCountClient() {
		var count = $('.checkbox-item-client:checked').length;
		$('#selectedCountClient').text(count);
		if (count > 0) {
			$('#btnDeleteSelectedClient').show();
		} else {
			$('#btnDeleteSelectedClient').hide();
		}
	}

	$('#btnDeleteSelectedClient').on('click', function () {
		var selectedIds = [];
		$('.checkbox-item-client:checked').each(function () {
			selectedIds.push($(this).val());
		});

		if (selectedIds.length === 0) {
			Swal.fire({
				icon: 'warning',
				title: 'Peringatan',
				text: 'Pilih minimal satu data untuk dihapus!',
			});
			return;
		}

		Swal.fire({
			title: 'Konfirmasi Hapus',
			text:
				'Apakah Anda yakin ingin menghapus ' +
				selectedIds.length +
				' data client yang dipilih?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {
				var bulkDeleteController = window.clientListController || 'Client';
				$.ajax({
					url: base_url + bulkDeleteController + '/bulkDelete',
					type: 'POST',
					data: { ids: selectedIds },
					dataType: 'json',
					success: function (response) {
						if (response.status === 'success') {
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: response.message,
							}).then(() => {
								location.reload();
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: response.message,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Terjadi kesalahan pada server!',
						});
					},
				});
			}
		});
	});

	$('#formeditProjectView').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url + 'Project/UpdateProjectView',
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			success: function (response) {
				if (response.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: response.message,
						timer: 1500,
					}).then(() => {
						$('#editProject').modal('hide');
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal',
						text: response.message,
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan saat menyimpan data.',
				});
			},
		});
	});

	$('#editProject').on('hidden.bs.modal', function () {
		$('#formeditProjectView')[0].reset();
	});

	// ======================= HPP / Business Plan Form Handler =======================

	// Format number helper
	function formatNumberHpp(num) {
		return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}

	// Parse formatted number
	function parseNumberHpp(str) {
		if (!str) return 0;
		return parseFloat(str.toString().replace(/\./g, '').replace(',', '.')) || 0;
	}

	// Get estimasi from hidden field or data attribute
	function getEstimasiHpp() {
		var estimasiEl = $('#hpp_estimasi_value');
		if (estimasiEl.length > 0) {
			return parseFloat(estimasiEl.val()) || 0;
		}
		return 0;
	}

	// Calculate HPP preview
	function calculateHppPreview() {
		var estimasi = getEstimasiHpp();
		var hpp_barang = parseNumberHpp($('#hpp_barang').val());
		var hpp_jasa = parseNumberHpp($('#hpp_jasa').val());
		var hpp_project = parseNumberHpp($('#hpp_project').val());
		var hpp_biaya = parseNumberHpp($('#hpp_biaya').val());

		var total_hpp = hpp_barang + hpp_jasa + hpp_project + hpp_biaya;
		var margin_nominal = estimasi - total_hpp;
		var margin_persen = estimasi > 0 ? (margin_nominal / estimasi) * 100 : 0;

		$('#preview_total_hpp').text('Rp. ' + formatNumberHpp(total_hpp));
		$('#preview_margin_nominal').text('Rp. ' + formatNumberHpp(margin_nominal));
		$('#preview_margin_persen').text(margin_persen.toFixed(2) + '%');

		// Update colors based on margin
		if (margin_persen >= 30) {
			$('#preview_margin_nominal')
				.removeClass('text-danger')
				.addClass('text-success');
			$('#preview_margin_persen')
				.removeClass('text-danger')
				.addClass('text-success');
			$('#preview_warning').addClass('d-none');
		} else {
			$('#preview_margin_nominal')
				.removeClass('text-success')
				.addClass('text-danger');
			$('#preview_margin_persen')
				.removeClass('text-success')
				.addClass('text-danger');
			$('#preview_warning').removeClass('d-none');
		}
	}

	// Format input on change for HPP fields
	$(document).on('input', '.hpp-input', function () {
		var value = $(this).val().replace(/\D/g, '');
		if (value) {
			$(this).val(formatNumberHpp(parseInt(value)));
		} else {
			$(this).val('0');
		}
		calculateHppPreview();
	});

	// When HPP modal is shown, calculate preview
	$('#modalHpp').on('shown.bs.modal', function () {
		calculateHppPreview();
	});

	// HPP Form submit
	$('#formHpp').on('submit', function (e) {
		e.preventDefault();

		var formData = new FormData(this);

		$('#btnSaveHpp')
			.prop('disabled', true)
			.html('<i class="ri-loader-4-line me-1"></i>Menyimpan...');

		$.ajax({
			url: base_url + 'Project/SaveHpp',
			type: 'POST',
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.status === 'success') {
					// Update display values
					var data = response.data;

					$('#display_hpp_barang').text(formatNumberHpp(data.hpp_barang));
					$('#display_hpp_jasa').text(formatNumberHpp(data.hpp_jasa));
					$('#display_hpp_project').text(formatNumberHpp(data.hpp_project));
					$('#display_hpp_biaya').text(formatNumberHpp(data.hpp_biaya));
					$('#display_total_hpp').html(
						'Rp. ' + formatNumberHpp(data.total_hpp)
					);
					$('#display_total_hpp_table').text(formatNumberHpp(data.total_hpp));
					$('#display_margin').html(
						'Rp. ' +
							formatNumberHpp(data.margin_nominal) +
							' <small class="fs-6">(' +
							data.margin_persen +
							'%)</small>'
					);
					$('#display_margin_table').text(formatNumberHpp(data.margin_nominal));
					$('#display_margin_persen').text('(' + data.margin_persen + '%)');
					$('#margin_badge').text(data.margin_persen + '%');

					// Update margin styling
					if (data.margin_persen >= 30) {
						$('#margin_row')
							.removeClass('table-danger')
							.addClass('table-success');
						$('#margin_badge').removeClass('bg-danger').addClass('bg-success');
						$('#display_margin')
							.closest('.card')
							.removeClass('bg-light-danger')
							.addClass('bg-light-success');
						$('#display_margin')
							.removeClass('text-danger')
							.addClass('text-success');
						$('#margin_warning_alert').addClass('d-none');
					} else {
						$('#margin_row')
							.removeClass('table-success')
							.addClass('table-danger');
						$('#margin_badge').removeClass('bg-success').addClass('bg-danger');
						$('#display_margin')
							.closest('.card')
							.removeClass('bg-light-success')
							.addClass('bg-light-danger');
						$('#display_margin')
							.removeClass('text-success')
							.addClass('text-danger');
						if ($('#margin_warning_alert').length === 0) {
							$('.table-responsive').before(
								'<div class="alert alert-danger d-flex align-items-center mb-4" role="alert" id="margin_warning_alert"><i class="ri-error-warning-line me-2 fs-4"></i><div><strong>Perhatian!</strong> Margin dibawah 30%. Minimal margin yang direkomendasikan adalah 30%.</div></div>'
							);
						} else {
							$('#margin_warning_alert').removeClass('d-none');
						}
					}

					$('#modalHpp').modal('hide');

					Swal.fire({
						icon: 'success',
						title: 'Berhasil!',
						text: response.message,
						showConfirmButton: false,
						timer: 1500,
					});

					if (response.margin_warning) {
						setTimeout(function () {
							Swal.fire({
								icon: 'warning',
								title: 'Perhatian!',
								text: response.warning_message,
								confirmButtonText: 'Mengerti',
							});
						}, 1600);
					}
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Gagal!',
						text: response.message,
					});
				}
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error:', status, error);
				console.error('Response:', xhr.responseText);
				Swal.fire({
					icon: 'error',
					title: 'Error!',
					text: 'Terjadi kesalahan saat menyimpan data',
				});
			},
			complete: function () {
				$('#btnSaveHpp')
					.prop('disabled', false)
					.html('<i class="ri-save-line me-1"></i>Simpan HPP');
			},
		});
	});
});
