(function () {
	const isDarkStyle = false;
	let groupCardColor,
		groupHeadingColor,
		groupLabelColor,
		groupLegendColor,
		groupBorderColor;

	if (isDarkStyle) {
		groupCardColor = '#2b3550';
		groupHeadingColor = '#e4e8f3';
		groupLabelColor = '#8a99c0';
		groupLegendColor = '#c3cbe4';
		groupBorderColor = '#3b4563';
	} else {
		groupCardColor = '#ffffff';
		groupHeadingColor = '#2c323f';
		groupLabelColor = '#6d788d';
		groupLegendColor = '#5d6680';
		groupBorderColor = '#e5e7eb';
	}

	const groupChartColors = {
		donut: {
			series1: 'rgb(53, 119, 241) ',
			series2: 'rgb(255, 190, 11)',
			series3: 'rgb(33, 37, 41)',
		},
	};

	const groupColorPalette = [
		groupChartColors.donut.series1,
		groupChartColors.donut.series2,
		groupChartColors.donut.series3,
		groupChartColors.donut.series4,
		groupChartColors.donut.series5,
		groupChartColors.donut.series6,
		groupChartColors.donut.series7,
	];

	let groupChartInstance = null;

	function renderGroupChart(labels, series, totalClients) {
		const groupChartEl = document.querySelector('#groupChart');

		if (!groupChartEl) {
			console.warn('Element #groupChart tidak ditemukan untuk rendering');
			return;
		}

		const groupChartConfig = {
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
							baseUrl + 'Client?group=' + encodeURIComponent(selectedLabel);
					},
				},
			},
			labels: labels,
			series: series,
			colors: groupColorPalette,
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
					colors: groupLegendColor,
					useSeriesColors: false,
				},
			},
			tooltip: {
				enabled: true,
				y: {
					formatter: function (value) {
						return value + ' Clients';
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
								color: groupLegendColor,
								fontFamily: 'Inter',
								formatter: function (val) {
									return val + ' Clients';
								},
							},
							total: {
								show: true,
								fontSize: '1rem',
								color: groupHeadingColor,
								label: 'Total Clients',
								formatter: function (w) {
									return totalClients + ' Clients';
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
								colors: groupLegendColor,
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
								colors: groupLegendColor,
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

		if (
			groupChartInstance &&
			typeof groupChartInstance.destroy === 'function'
		) {
			groupChartInstance.destroy();
		}

		groupChartEl.innerHTML = '';
		groupChartInstance = new ApexCharts(groupChartEl, groupChartConfig);
		groupChartInstance.render();
	}

	function fetchGroupChartData() {
		const groupChartEl = document.querySelector('#groupChart');

		if (!groupChartEl) {
			console.warn(
				'Element #groupChart tidak ditemukan di DOM - skipping fetch'
			);
			return;
		}

		groupChartEl.innerHTML = `
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Loading chart data...</p>
            </div>
        `;

		fetch('Dashboard/getGroupChart')
			.then((response) => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then((data) => {
				if (data.success) {
					renderGroupChart(data.labels, data.series, data.total_clients);
				} else {
					throw new Error(data.message || 'Failed to load group chart data');
				}
			})
			.catch((error) => {
				console.error('Error fetching group chart data:', error);
				const groupCharttEl = document.querySelector('#groupChartt');
				if (groupCharttEl) {
					groupCharttEl.innerHTML = `
                        <div class="text-center p-4 text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <br>
                            <small>Failed to load group chart data</small>
                            <br>
                            <small>${error.message}</small>
                        </div>
                    `;
				}
			});
	}

	function initializeGroupChart() {
		const groupChartEl = document.querySelector('#groupChart');

		if (groupChartEl) {
			fetchGroupChartData();
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			setTimeout(initializeGroupChart, 100);
		});
	} else {
		setTimeout(initializeGroupChart, 100);
	}

	window.groupChart = {
		initialize: initializeGroupChart,
		refresh: fetchGroupChartData,
	};
})();
