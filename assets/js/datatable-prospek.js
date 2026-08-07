$(document).ready(function () {
	initProspekDataTable('#table-prospek', 'Prospek');
});

function initProspekDataTable(tableSelector, controllerName) {
	if (!$(tableSelector).length) {
		return;
	}

	if (!$.fn.DataTable.isDataTable(tableSelector)) {
		$(tableSelector).DataTable({
			bFilter: true,
			pageLength: 25,
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
				{ targets: [0], width: '40px', className: 'text-center' },
				{ targets: [1], width: '180px' },
				{ targets: [2], width: '50px' },
				{ targets: [3], width: '120px' },
				{ targets: [4], width: '120px' },
				{ targets: [5], width: '100px' },
				{ targets: [6], width: '130px' },
				{ targets: [7], width: '120px' },
				{ targets: [8], width: '250px', className: 'wrap-text' },
				{ targets: [9], width: '50px' },
				{ targets: [10], width: '50px' },
				{ targets: [11], width: '40px', className: 'text-center' },
			],
		});
	}

	$('#checkAll').on('change', function () {
		$('.checkbox-item').prop('checked', $(this).is(':checked'));
		updateProspekSelectedCount();
	});

	$(document).on('change', '.checkbox-item', function () {
		var total = $('.checkbox-item').length;
		var checked = $('.checkbox-item:checked').length;
		$('#checkAll').prop('checked', total === checked);
		updateProspekSelectedCount();
	});

	$('#btnDeleteSelected').on('click', function () {
		var selectedIds = [];
		$('.checkbox-item:checked').each(function () {
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
				' data yang dipilih?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url + controllerName + '/bulkDelete',
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
}

function updateProspekSelectedCount() {
	var count = $('.checkbox-item:checked').length;
	$('#selectedCount').text(count);
	if (count > 0) {
		$('#btnDeleteSelected').show();
	} else {
		$('#btnDeleteSelected').hide();
	}
}
