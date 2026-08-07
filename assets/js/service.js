/**
 * Charts Apex
 */

'use strict';

(function () {
	const isDarkStyle = false;
	let sektorCardColor,
		sektorHeadingColor,
		sektorLabelColor,
		sektorLegendColor,
		sektorBorderColor;

	if (isDarkStyle) {
		sektorCardColor = '#2b3550';
		sektorHeadingColor = '#e4e8f3';
		sektorLabelColor = '#8a99c0';
		sektorLegendColor = '#c3cbe4';
		sektorBorderColor = '#3b4563';
	} else {
		sektorCardColor = '#ffffff';
		sektorHeadingColor = '#2c323f';
		sektorLabelColor = '#6d788d';
		sektorLegendColor = '#5d6680';
		sektorBorderColor = '#e5e7eb';
	}

	const chartColors = {
		donut: {
			series1: '#fee802',
			series2: '#F1F0F2',
			series3: '#826bf8',
			series4: '#3fd0bd',
			series5: '#ff9f43',
		},
	};

	const colorPalette = [
		chartColors.donut.series1,
		chartColors.donut.series4,
		chartColors.donut.series3,
		chartColors.donut.series2,
		chartColors.donut.series5,
		'#7367f0',
		'#ea5455',
		'#28c76f',
	];

	const serviceChartEl = document.querySelector('#serviceChart');
	const filterForm = document.querySelector('#filterForm');
	const resetFilterBtn = document.querySelector('#resetFilter');

	function renderProjectChart(labels, series, totalProjects) {
		const serviceChartConfig = {
			chart: {
				height: 390,
				type: 'donut',
				events: {
					dataPointSelection: function (event, chartContext, config) {
						var selectedLabel = labels[config.dataPointIndex];
						var baseUrl =
							window.location.origin +
							window.location.pathname.split('/').slice(0, -1).join('/') +
							'/';
						window.location.href =
							baseUrl + 'Project?jenis=' + encodeURIComponent(selectedLabel);
					},
				},
			},
			labels: labels,
			series: series,
			colors: colorPalette,
			stroke: {
				show: false,
				curve: 'straight',
			},
			dataLabels: {
				enabled: true,
				formatter: function (val, opt) {
					return opt.w.config.series[opt.seriesIndex];
				},
			},
			legend: {
				show: true,
				position: 'bottom',
				markers: { offsetX: -3 },
				itemMargin: {
					vertical: 3,
					horizontal: 10,
				},
				labels: {
					colors: sektorLegendColor,
					useSeriesColors: false,
				},
			},
			tooltip: {
				enabled: true,
				y: {
					formatter: function (value) {
						return value + ' Projects';
					},
				},
			},
			plotOptions: {
				pie: {
					donut: {
						labels: {
							show: true,
							name: {
								fontSize: '2rem',
								fontFamily: 'Inter',
							},
							value: {
								fontSize: '1.2rem',
								color: sektorLegendColor,
								fontFamily: 'Inter',
								formatter: function (val) {
									return val + ' Projects';
								},
							},
							total: {
								show: true,
								fontSize: '1rem',
								color: sektorHeadingColor,
								label: 'Total Service',
								formatter: function (w) {
									return totalProjects + ' Projects';
								},
							},
						},
					},
				},
			},
			responsive: [
				{
					breakpoint: 992,
					options: {
						chart: {
							height: 380,
						},
						legend: {
							position: 'bottom',
							labels: {
								colors: sektorLegendColor,
								useSeriesColors: false,
							},
						},
					},
				},
				{
					breakpoint: 576,
					options: {
						chart: {
							height: 320,
						},
						plotOptions: {
							pie: {
								donut: {
									labels: {
										show: true,
										name: {
											fontSize: '1.5rem',
										},
										value: {
											fontSize: '1rem',
										},
										total: {
											fontSize: '1.5rem',
										},
									},
								},
							},
						},
						legend: {
							position: 'bottom',
							labels: {
								colors: sektorLegendColor,
								useSeriesColors: false,
							},
						},
					},
				},
				{
					breakpoint: 420,
					options: {
						chart: {
							height: 280,
						},
						legend: {
							show: false,
						},
					},
				},
				{
					breakpoint: 360,
					options: {
						chart: {
							height: 250,
						},
						legend: {
							show: false,
						},
					},
				},
			],
		};

		if (window.projectChart) {
			window.projectChart.destroy();
		}

		window.projectChart = new ApexCharts(serviceChartEl, serviceChartConfig);
		window.projectChart.render();
	}

	function fetchChartData(startDate = null, endDate = null) {
		const formData = new FormData();

		if (startDate && endDate) {
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		}

		fetch('Dashboard/getServiceChart', {
			method: 'POST',
			body: formData,
		})
			.then((response) => {
				if (!response.ok) {
					throw new Error('Network response was not ok');
				}
				return response.json();
			})
			.then((data) => {
				if (data.success) {
					renderProjectChart(data.labels, data.series, data.total_projects);
				} else {
					throw new Error(data.message || 'Failed to load chart data');
				}
			})
			.catch((error) => {
				console.error('Error fetching chart data:', error);
				if (serviceChartEl) {
					serviceChartEl.innerHTML = `
					<div class="text-center p-4 text-danger">
						<i class="fas fa-exclamation-triangle"></i>
						<br>
						Failed to load chart data
						<br>
						<small>${error.message}</small>
					</div>
				`;
				}
			});
	}

	function initializeProjectChart() {
		if (typeof serviceChartEl !== 'undefined' && serviceChartEl !== null) {
			fetchChartData();
		}
	}

	if (filterForm) {
		filterForm.addEventListener('submit', function (e) {
			e.preventDefault();

			const dateRange = document.getElementById(
				'bs-rangepicker-dropdown'
			).value;

			if (dateRange) {
				const dates = dateRange.split(' - ');
				if (dates.length === 2) {
					const startDate = dates[0];
					const endDate = dates[1];
					fetchChartData(startDate, endDate);
				}
			} else {
				fetchChartData();
			}
		});
	}

	if (resetFilterBtn) {
		resetFilterBtn.addEventListener('click', function () {
			document.getElementById('bs-rangepicker-dropdown').value = '';
			fetchChartData();
		});
	}

	document.addEventListener('DOMContentLoaded', function () {
		initializeProjectChart();
	});
})();
