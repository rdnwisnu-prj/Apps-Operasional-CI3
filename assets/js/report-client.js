/**
 * Report Client Charts - ApexCharts
 * ClientTahunanChart (Bar Chart)
 * Filter & Download Excel
 */

var clientTahunanChart;

$(document).ready(function () {
	// Check if chart data exists
	if (typeof clientMonthlyData !== 'undefined') {
		initClientTahunanChart(clientMonthlyData);
	}

	// Year selection for Client Tahunan
	$('.year-prospek-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearProspek').text(year);
		loadClientTahunan(year);
	});

	// Load Top 10 Clients
	loadTopClients();
});

function formatRupiahReport(value) {
	if (value >= 1000000000) {
		return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
	} else if (value >= 1000000) {
		return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
	} else if (value >= 1000) {
		return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
	}
	return 'Rp ' + value.toLocaleString('id-ID');
}

function loadTopClients() {
	$.ajax({
		url: base_url + 'Report/Client/getTopClients',
		type: 'POST',
		dataType: 'json',
		success: function (response) {
			var tbody = $('#top-clients tbody');
			tbody.empty();

			if (response.success && response.data && response.data.length > 0) {
				$.each(response.data, function (index, item) {
					tbody.append(
						'<tr>' +
							'<td class="text-center">' +
							(index + 1) +
							'</td>' +
							'<td>' +
							item.nama_client +
							'</td>' +
							'<td>' +
							item.sektor +
							'</td>' +
							'<td>' +
							item.group +
							'</td>' +
							'<td>' +
							formatRupiahReport(item.total_estimasi) +
							'</td>' +
							'<td>' +
							item.marketing +
							'</td>' +
							'</tr>'
					);
				});
			} else {
				tbody.append(
					'<tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>'
				);
			}
		},
		error: function () {
			$('#top-clients tbody').html(
				'<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>'
			);
		},
	});
}

function initClientTahunanChart(data) {
	var options = {
		series: [
			{
				name: 'Jumlah Client',
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
		colors: ['#38cab3'],
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
					return val + ' Client';
				},
			},
		},
	};

	clientTahunanChart = new ApexCharts(
		document.querySelector('#ClientTahunanChart'),
		options
	);
	clientTahunanChart.render();
}

function loadClientTahunan(year) {
	$.ajax({
		url: base_url + 'Report/Client/getClientTahunan',
		type: 'POST',
		data: { year: year },
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				clientTahunanChart.updateSeries([
					{
						name: 'Jumlah Client',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading client data:', error);
		},
	});
}

$(document).ready(function () {
	if ($('#client_reports').length) {
		var clientReportTable = $('#client_reports').DataTable({
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
				url: base_url + 'Report/Client/getFilteredClients',
				type: 'POST',
				dataSrc: function (json) {
					return json.data || [];
				},
			},
			columns: [
				{ data: 'nama_client' },
				{ data: 'sektor' },
				{ data: 'nama_pic' },
				{ data: 'tlp_pic' },
				{ data: 'group' },
				{ data: 'status' },
				{ data: 'periode' },
				{ data: 'marketing' },
			],
		});

		$('#btnFilterReportClient').on('click', function () {
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.ajax({
				url: base_url + 'Report/Client/getFilteredClients',
				type: 'POST',
				data: {
					user_id: user_id,
					bulan: bulan,
					tahun: tahun,
				},
				dataType: 'json',
				success: function (response) {
					clientReportTable.clear();
					if (response.data && response.data.length > 0) {
						clientReportTable.rows.add(response.data).draw();
					} else {
						clientReportTable.draw();
					}
				},
				error: function () {
					Swal.fire('Error', 'Gagal mengambil data', 'error');
				},
			});
		});

		$('#btnResetFilterReportClient').on('click', function () {
			$('#filter_user_id').val('');
			$('#bulan').val('');
			$('#tahun').val('');

			$.ajax({
				url: base_url + 'Report/Client/getFilteredClients',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function (response) {
					clientReportTable.clear();
					if (response.data && response.data.length > 0) {
						clientReportTable.rows.add(response.data).draw();
					} else {
						clientReportTable.draw();
					}
				},
			});
		});

		$('#btnDownloadExcel').on('click', function (e) {
			e.preventDefault();
			var user_id = $('#filter_user_id').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			var params = new URLSearchParams();
			if (user_id) params.append('user_id', user_id);
			if (bulan) params.append('bulan', bulan);
			if (tahun) params.append('tahun', tahun);

			var url = base_url + 'Report/Client/exportExcel';
			if (params.toString()) {
				url += '?' + params.toString();
			}

			window.location.href = url;
		});
	}
});
