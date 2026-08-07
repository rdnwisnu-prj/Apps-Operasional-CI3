$(document).ready(function () {
	$('#general').DataTable({
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
	});
});

$(document).ready(function () {
	$('#general-prospek').DataTable({
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
		autoWidth: false,
		columnDefs: [
			{ width: '4%', targets: 0, className: 'text-center' }, // No
			{ width: '20%', targets: 1, className: 'text-wrap' }, // Nama Perusahaan
			{ width: '15%', targets: 2, className: 'text-wrap' }, // Nama PIC
			{ width: '12%', targets: 3, className: 'text-center' }, // No Tlp PIC
			{ width: '15%', targets: 4, className: 'text-wrap' }, // Email PIC
			{ width: '10%', targets: 5, className: 'text-center' }, // Status
			{ width: '24%', targets: 6, className: 'text-wrap' }, // Keterangan
		],
	});
});

$(document).ready(function () {
	$('#general-client').DataTable({
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
	});
});

$(document).ready(function () {
	$('#general-project').DataTable({
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
		autoWidth: false,
		columnDefs: [
			{ width: '3%', targets: 0, className: 'text-center' }, // No
			{ width: '18%', targets: 1, className: 'text-wrap' }, // Nama Projek
			{ width: '15%', targets: 2, className: 'text-wrap' }, // Nama Client
			{ width: '12%', targets: 3, className: 'text-wrap' }, // Jenis Projek
			{ width: '12%', targets: 4, className: 'text-wrap' }, // Marketing
			{ width: '12%', targets: 5, className: 'text-center' }, // Tgl Pelaksanaan
			{ width: '12%', targets: 6, className: 'text-center' }, // Tgl Selesai
			{ width: '10%', targets: 7, className: 'text-end' }, // Estimasi
			{ width: '6%', targets: 8, className: 'text-center' }, // Status
		],
	});
});

$(document).ready(function () {
	$('#rujukan').DataTable({
		bFilter: true,
		sDom: 'fBtlpi',
		pageLength: 25,
		language: {
			paginate: {
				next: '<i class="ti ti-arrow-right"></i>',
				previous: '<i class="ti ti-arrow-left"></i> ',
			},
		},
		responsive: true,
		ordering: false,
		autoWidth: false,
		columnDefs: [
			{ width: '3%', targets: 0, className: 'text-center' }, // No
			{ width: '12%', targets: 1, className: 'text-wrap' }, // Nama Peserta
			{ width: '12%', targets: 2, className: 'text-wrap' }, // PT Lama
			{ width: '12%', targets: 3, className: 'text-wrap' }, // PT Baru
			{ width: '10%', targets: 4, className: 'text-wrap' }, // Dokter
			{ width: '8%', targets: 5, className: 'text-center' }, // Tgl Konsul
			{ width: '8%', targets: 6, className: 'text-end' }, // Harga
			{ width: '10%', targets: 7, className: 'text-wrap' }, // Lokasi
			{ width: '8%', targets: 8, className: 'text-center' }, // Pembayaran
			{ width: '10%', targets: 9, className: 'text-wrap' }, // Marketing
			{ width: '5%', targets: 10, className: 'text-center' }, // Action
		],
	});
});

// Report Konsultasi DataTable
$(document).ready(function () {
	if ($('#konsultasi_reports').length) {
		var konsultasiReportTable = $('#konsultasi_reports').DataTable({
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
			processing: true,
			ajax: {
				url: base_url + 'Report/Konsultasi/getFilteredRujukan',
				type: 'POST',
				dataSrc: function (json) {
					return json.data || [];
				},
			},
			columns: [
				{ data: 'nama' },
				{ data: 'pt_lama' },
				{ data: 'pt_baru' },
				{ data: 'dokter' },
				{ data: 'tgl_konsul' },
				{ data: 'harga' },
				{ data: 'lokasi' },
				{ data: 'pembayaran' },
				{ data: 'marketing' },
			],
		});

		// Filter Button
		$('#btnFilterReportProspek').on('click', function () {
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.ajax({
				url: base_url + 'Report/Konsultasi/getFilteredRujukan',
				type: 'POST',
				data: {
					user_id: user_id,
					bulan: bulan,
					tahun: tahun,
				},
				dataType: 'json',
				success: function (response) {
					konsultasiReportTable.clear();
					if (response.data && response.data.length > 0) {
						konsultasiReportTable.rows.add(response.data).draw();
					} else {
						konsultasiReportTable.draw();
					}
				},
				error: function () {
					Swal.fire('Error', 'Gagal mengambil data', 'error');
				},
			});
		});

		// Reset Button
		$('#btnResetFilterReportProspek').on('click', function () {
			$('#filter_user_id').val('');
			$('#bulan').val('');
			$('#tahun').val('');

			$.ajax({
				url: base_url + 'Report/Konsultasi/getFilteredRujukan',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function (response) {
					konsultasiReportTable.clear();
					if (response.data && response.data.length > 0) {
						konsultasiReportTable.rows.add(response.data).draw();
					} else {
						konsultasiReportTable.draw();
					}
				},
			});
		});

		// Download Excel Button for Konsultasi
		$('#btnDownloadExcel').on('click', function (e) {
			e.preventDefault();
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			var params = new URLSearchParams();
			if (user_id) params.append('user_id', user_id);
			if (bulan) params.append('bulan', bulan);
			if (tahun) params.append('tahun', tahun);

			var url = base_url + 'Report/Konsultasi/exportExcel';
			if (params.toString()) {
				url += '?' + params.toString();
			}

			window.location.href = url;
		});
	}
});

$(document).ready(function () {
	$('#table-cros').DataTable({
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
		autoWidth: false,
		columnDefs: [
			{ width: '3%', targets: 0, className: 'text-center' }, // No
			{ width: '12%', targets: 1, className: 'text-wrap' }, // Nama Crosseling
			{ width: '12%', targets: 2, className: 'text-wrap text-uppercase' }, // Nama Client
			{ width: '12%', targets: 3, className: 'text-wrap' }, // Nama Project
			{ width: '8%', targets: 4, className: 'text-center' }, // Entitas
			{ width: '10%', targets: 5, className: 'text-end' }, // Deal
			{ width: '10%', targets: 6, className: 'text-end' }, // Prospek
			{ width: '10%', targets: 7, className: 'text-end' }, // Lost
			{ width: '8%', targets: 8, className: 'text-wrap' }, // Marketing
			{ width: '10%', targets: 9, className: 'text-wrap' }, // Keterangan
			{ width: '5%', targets: 10, className: 'text-center', orderable: false }, // Action
		],
	});
});
