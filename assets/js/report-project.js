/**
 * Report Project Charts - ApexCharts
 * ProjectTahunanChart (Bar Chart)
 */

var projectTahunanChart;

$(document).ready(function () {
	// Check if chart data exists
	if (typeof projectMonthlyData !== 'undefined') {
		// Initialize ProjectTahunanChart (Bar Chart)
		initProjectTahunanChart(projectMonthlyData);
	}

	// Year selection for Project Tahunan
	$('.year-project-item').on('click', function () {
		var year = $(this).data('year');
		$('#selectedYearProject').text(year);
		loadProjectTahunan(year);
	});
});

function initProjectTahunanChart(data) {
	var options = {
		series: [
			{
				name: 'Jumlah Project',
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
					return val + ' Project';
				},
			},
		},
	};

	projectTahunanChart = new ApexCharts(
		document.querySelector('#ProjectTahunanChart'),
		options
	);
	projectTahunanChart.render();
}

function loadProjectTahunan(year) {
	$.ajax({
		url: base_url + 'Report/Project/getProjectTahunan',
		type: 'POST',
		data: { year: year },
		dataType: 'json',
		success: function (response) {
			if (response.status === 'success') {
				projectTahunanChart.updateSeries([
					{
						name: 'Jumlah Project',
						data: response.data,
					},
				]);
			}
		},
		error: function (xhr, status, error) {
			console.error('Error loading project data:', error);
		},
	});
}
