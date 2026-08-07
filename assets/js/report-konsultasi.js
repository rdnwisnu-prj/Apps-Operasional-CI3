var rujukanTahunanChart;

$(document).ready(function () {
	if (typeof rujukanMonthlyData !== 'undefined') {
		initRujukanTahunanChart(rujukanMonthlyData);
	}

	// Year selection for Rujukan Tahunan
	$('.year-rujukan-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearRujukan').text(year);
		loadRujukanTahunan(year);
	});
});

function initRujukanTahunanChart(data) {
	var options = {
		series: [
			{
				name: 'Jumlah Rujukan',
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
					return val + ' Rujukan';
				},
			},
		},
	};

	rujukanTahunanChart = new ApexCharts(
		document.querySelector('#RujukanTahunanChart'),
		options
	);
	rujukanTahunanChart.render();
}

function loadRujukanTahunan(year) {
	$.ajax({
		url: base_url + 'Report/Konsultasi/getRujukanTahunan',
		type: 'POST',
		data: { year: year },
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				rujukanTahunanChart.updateSeries([
					{
						name: 'Jumlah Rujukan',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading rujukan data:', error);
		},
	});
}
