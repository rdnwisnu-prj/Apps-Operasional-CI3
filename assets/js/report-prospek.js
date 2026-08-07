var prospekTahunanChart;
var statusProspekChart;

$(document).ready(function () {
	if (typeof prospekMonthlyData !== 'undefined') {
		initProspekTahunanChart(prospekMonthlyData);
	}

	if (
		typeof prospekStatusLabels !== 'undefined' &&
		typeof prospekStatusData !== 'undefined'
	) {
		initStatusProspekChart(prospekStatusLabels, prospekStatusData);
	}

	$('.year-prospek-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearProspek').text(year);
		loadProspekTahunan(year);
	});

	$('.year-status-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearStatus').text(year);
		loadStatusProspek(year);
	});
});

function initProspekTahunanChart(data) {
	var options = {
		series: [
			{
				name: 'Jumlah Prospek',
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
			enabled: false,
		},
		colors: ['#5156BE'],
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
					return val + ' Prospek';
				},
			},
		},
	};

	if (prospekTahunanChart) {
		prospekTahunanChart.destroy();
	}

	prospekTahunanChart = new ApexCharts(
		document.querySelector('#ProspekTahunanChart'),
		options
	);
	prospekTahunanChart.render();
}

function initStatusProspekChart(labels, data) {
	var options = {
		series: data,
		chart: {
			type: 'pie',
			height: 350,
		},
		labels: labels,
		colors: ['#5156BE', '#FFC107', '#28A745', '#DC3545'],
		legend: {
			position: 'bottom',
			horizontalAlign: 'center',
		},
		dataLabels: {
			enabled: true,
			formatter: function (val, opts) {
				return (
					opts.w.config.series[opts.seriesIndex] + ' (' + val.toFixed(1) + '%)'
				);
			},
		},
		tooltip: {
			y: {
				formatter: function (val) {
					return val + ' Prospek';
				},
			},
		},
		responsive: [
			{
				breakpoint: 480,
				options: {
					chart: {
						width: 300,
					},
					legend: {
						position: 'bottom',
					},
				},
			},
		],
		noData: {
			text: 'Tidak ada data',
			align: 'center',
			verticalAlign: 'middle',
			style: {
				fontSize: '14px',
			},
		},
	};

	if (statusProspekChart) {
		statusProspekChart.destroy();
	}

	statusProspekChart = new ApexCharts(
		document.querySelector('#StatusProspekTahunanChart'),
		options
	);
	statusProspekChart.render();
}

function loadProspekTahunan(year) {
	$.ajax({
		url: base_url + 'Report/Prospek/getProspekTahunan',
		type: 'POST',
		data: {
			year: year,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				prospekTahunanChart.updateSeries([
					{
						name: 'Jumlah Prospek',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading prospek tahunan:', error);
		},
	});
}

function loadStatusProspek(year) {
	$.ajax({
		url: base_url + 'Report/Prospek/getStatusProspek',
		type: 'POST',
		data: {
			year: year,
		},
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				if (response.labels.length > 0) {
					statusProspekChart.updateOptions({
						labels: response.labels,
					});
					statusProspekChart.updateSeries(response.data);
				} else {
					statusProspekChart.updateOptions({
						labels: ['Tidak ada data'],
					});
					statusProspekChart.updateSeries([0]);
				}
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading status prospek:', error);
		},
	});
}

// Report Prospek DataTable
$(document).ready(function () {
	if ($('#leads_reports').length) {
		var leadsReportTable = $('#leads_reports').DataTable({
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
				url: base_url + 'Report/Prospek/getFilteredLeads',
				type: 'POST',
				dataSrc: function (json) {
					return json.data || [];
				},
			},
			columns: [
				{ data: 'nama_client' },
				{ data: 'project' },
				{ data: 'service' },
				{ data: 'periode' },
				{ data: 'estimasi_lead' },
				{ data: 'marketing' },
				{
					data: 'status_lead',
					render: function (data) {
						var badgeClass = 'bg-secondary';
						if (data === 'Deal') badgeClass = 'bg-success';
						else if (data === 'Negosiasi') badgeClass = 'bg-warning';
						else if (data === 'Lost') badgeClass = 'bg-danger';
						else if (data === 'Proses Prospek') badgeClass = 'bg-info';
						return '<span class="badge ' + badgeClass + '">' + data + '</span>';
					},
				},
			],
		});

		$('#btnFilterReportProspek').on('click', function () {
			var user_id = $('#filter_user_id').val();
			var status = $('#status').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			$.ajax({
				url: base_url + 'Report/Prospek/getFilteredLeads',
				type: 'POST',
				data: {
					user_id: user_id,
					status: status,
					bulan: bulan,
					tahun: tahun,
				},
				dataType: 'json',
				success: function (response) {
					leadsReportTable.clear();
					if (response.data && response.data.length > 0) {
						leadsReportTable.rows.add(response.data).draw();
					} else {
						leadsReportTable.draw();
					}
				},
				error: function () {
					Swal.fire('Error', 'Gagal mengambil data', 'error');
				},
			});
		});

		$('#btnResetFilterReportProspek').on('click', function () {
			$('#filter_user_id').val('');
			$('#status').val('');
			$('#bulan').val('');
			$('#tahun').val('');

			$.ajax({
				url: base_url + 'Report/Prospek/getFilteredLeads',
				type: 'POST',
				data: {},
				dataType: 'json',
				success: function (response) {
					leadsReportTable.clear();
					if (response.data && response.data.length > 0) {
						leadsReportTable.rows.add(response.data).draw();
					} else {
						leadsReportTable.draw();
					}
				},
			});
		});

		$('#btnDownloadExcel').on('click', function (e) {
			e.preventDefault();
			var user_id = $('#filter_user_id').val();
			var status = $('#status').val();
			var bulan = $('#bulan').val();
			var tahun = $('#tahun').val();

			var params = new URLSearchParams();
			if (user_id) params.append('user_id', user_id);
			if (status) params.append('status', status);
			if (bulan) params.append('bulan', bulan);
			if (tahun) params.append('tahun', tahun);

			var url = base_url + 'Report/Prospek/exportExcel';
			if (params.toString()) {
				url += '?' + params.toString();
			}

			window.location.href = url;
		});
	}
});
