var keluhanTahunanChart;

$(document).ready(function () {
	// Init chart
	if (typeof keluhanMonthlyData !== 'undefined') {
		initKeluhanTahunanChart(keluhanMonthlyData);
	}

	// Year dropdown selection
	$('.year-keluhan-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearKeluhan').text(year);
		loadKeluhanTahunan(year);
	});

	// DataTable init
	if ($('#keluhan_client_reports').length) {
		var keluhanClientTable = $('#keluhan_client_reports').DataTable({
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
				url: base_url + 'Report/KeluhanClient/getFilteredKeluhan',
				type: 'POST',
				dataSrc: function (json) {
					return json.data || [];
				},
			},
			columns: [
				{ data: 'tgl_masuk' },
				{ data: 'perusahaan' },
				{ data: 'pic' },
				{ data: 'media' },
				{ data: 'divisi' },
				{ data: 'kategori' },
				{ data: 'customer_service' },
			],
		});

		// Filter Button
		$('#btnFilterKeluhanClient').on('click', function () {
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.ajax({
				url: base_url + 'Report/KeluhanClient/getFilteredKeluhan',
				type: 'POST',
				data: {
					user_id: user_id,
					bulan: bulan,
					tahun: tahun,
				},
				dataType: 'json',
				success: function (response) {
					keluhanClientTable.clear();
					if (response.data && response.data.length > 0) {
						keluhanClientTable.rows.add(response.data).draw();
					} else {
						keluhanClientTable.draw();
					}
				},
				error: function () {
					Swal.fire('Error', 'Gagal mengambil data', 'error');
				},
			});
		});

		// Reset Button
		$('#btnResetFilterKeluhanClient').on('click', function () {
			$('#filter_user_id').val('');
			$('#bulan').val('');
			$('#tahun').val('');

			$.ajax({
				url: base_url + 'Report/KeluhanClient/getFilteredKeluhan',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function (response) {
					keluhanClientTable.clear();
					if (response.data && response.data.length > 0) {
						keluhanClientTable.rows.add(response.data).draw();
					} else {
						keluhanClientTable.draw();
					}
				},
			});
		});

		// Download Excel Button (placeholder)
		$('#btnDownloadExcelKeluhan').on('click', function (e) {
			e.preventDefault();
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			var params = new URLSearchParams();
			if (user_id) params.append('user_id', user_id);
			if (bulan) params.append('bulan', bulan);
			if (tahun) params.append('tahun', tahun);

			var url = base_url + 'Report/KeluhanClient/exportExcel';
			if (params.toString()) {
				url += '?' + params.toString();
			}

			window.location.href = url;
		});
	}
});

function initKeluhanTahunanChart(data) {
	var options = {
		series: [
			{
				name: 'Jumlah Keluhan',
				data: data,
			},
		],
		chart: {
			type: 'bar',
			height: 350,
			toolbar: {
				show: false,
			},
		},
		plotOptions: {
			bar: {
				borderRadius: 4,
				columnWidth: '50%',
			},
		},
		dataLabels: {
			enabled: true,
			formatter: function (val) {
				return val > 0 ? val : '';
			},
			style: {
				fontSize: '12px',
				colors: ['#fff'],
			},
		},
		colors: ['#E74C3C'],
		xaxis: {
			categories: [
				'Jan',
				'Feb',
				'Mar',
				'Apr',
				'Mei',
				'Jun',
				'Jul',
				'Agu',
				'Sep',
				'Okt',
				'Nov',
				'Des',
			],
			labels: {
				style: {
					fontSize: '12px',
				},
			},
		},
		yaxis: {
			min: 0,
			tickAmount: 5,
			labels: {
				formatter: function (val) {
					return Math.round(val);
				},
			},
		},
		grid: {
			borderColor: '#f1f1f1',
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val + ' Keluhan';
				},
			},
		},
	};

	keluhanTahunanChart = new ApexCharts(
		document.querySelector('#KeluhanTahunanChart'),
		options
	);
	keluhanTahunanChart.render();
}

function loadKeluhanTahunan(year) {
	$.ajax({
		url: base_url + 'Report/KeluhanClient/getKeluhanTahunan',
		type: 'POST',
		data: { year: year },
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				keluhanTahunanChart.updateSeries([
					{
						name: 'Jumlah Keluhan',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading keluhan tahunan:', error);
		},
	});
}
