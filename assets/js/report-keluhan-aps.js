var keluhanApsTahunanChart;

$(document).ready(function () {
	// Init chart
	if (typeof keluhanApsMonthlyData !== 'undefined') {
		initKeluhanApsTahunanChart(keluhanApsMonthlyData);
	}

	// Year dropdown selection
	$('.year-keluhan-aps-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearKeluhanAps').text(year);
		loadKeluhanApsTahunan(year);
	});

	// DataTable init
	if ($('#keluhan_aps_reports').length) {
		var keluhanApsTable = $('#keluhan_aps_reports').DataTable({
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
				url: base_url + 'Report/KeluhanAps/getFilteredKeluhanAps',
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
		$('#btnFilterKeluhanAps').on('click', function () {
			var user_id = $('#filter_user_id_aps').val();
			var bulan = $('#bulan_aps').val();
			var tahun = $('#tahun_aps').val();

			$.ajax({
				url: base_url + 'Report/KeluhanAps/getFilteredKeluhanAps',
				type: 'POST',
				data: {
					user_id: user_id,
					bulan: bulan,
					tahun: tahun,
				},
				dataType: 'json',
				success: function (response) {
					keluhanApsTable.clear();
					if (response.data && response.data.length > 0) {
						keluhanApsTable.rows.add(response.data).draw();
					} else {
						keluhanApsTable.draw();
					}
				},
				error: function () {
					Swal.fire('Error', 'Gagal mengambil data', 'error');
				},
			});
		});

		// Reset Button
		$('#btnResetFilterKeluhanAps').on('click', function () {
			$('#filter_user_id_aps').val('');
			$('#bulan_aps').val('');
			$('#tahun_aps').val('');

			$.ajax({
				url: base_url + 'Report/KeluhanAps/getFilteredKeluhanAps',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function (response) {
					keluhanApsTable.clear();
					if (response.data && response.data.length > 0) {
						keluhanApsTable.rows.add(response.data).draw();
					} else {
						keluhanApsTable.draw();
					}
				},
			});
		});

		// Download Excel Button
		$('#btnDownloadExcelKeluhanAps').on('click', function (e) {
			e.preventDefault();
			var user_id = $('#filter_user_id_aps').val();
			var bulan = $('#bulan_aps').val();
			var tahun = $('#tahun_aps').val();

			var params = new URLSearchParams();
			if (user_id) params.append('user_id', user_id);
			if (bulan) params.append('bulan', bulan);
			if (tahun) params.append('tahun', tahun);

			var url = base_url + 'Report/KeluhanAps/exportExcel';
			if (params.toString()) {
				url += '?' + params.toString();
			}

			window.location.href = url;
		});
	}
});

function initKeluhanApsTahunanChart(data) {
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

	keluhanApsTahunanChart = new ApexCharts(
		document.querySelector('#KeluhanApsTahunanChart'),
		options
	);
	keluhanApsTahunanChart.render();
}

function loadKeluhanApsTahunan(year) {
	$.ajax({
		url: base_url + 'Report/KeluhanAps/getKeluhanApsTahunan',
		type: 'POST',
		data: { year: year },
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				keluhanApsTahunanChart.updateSeries([
					{
						name: 'Jumlah Keluhan',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading keluhan APS tahunan:', error);
		},
	});
}
