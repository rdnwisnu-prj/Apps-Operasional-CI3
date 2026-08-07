'use strict';

(function () {
	const isDarkStyle = false;
	let branchCardColor,
		branchHeadingColor,
		branchLabelColor,
		branchBorderColor,
		branchLegendColor;

	if (isDarkStyle) {
		branchCardColor = '#2b3550';
		branchHeadingColor = '#e4e8f3';
		branchLabelColor = '#8a99c0';
		branchLegendColor = '#c3cbe4';
		branchBorderColor = '#3b4563';
	} else {
		branchCardColor = '#ffffff';
		branchHeadingColor = '#2c323f';
		branchLabelColor = '#6d788d';
		branchLegendColor = '#5d6680';
		branchBorderColor = '#e5e7eb';
	}

	const branchChartColors = {
		donut: {
			series1: '#805dca',
			series2: '#f29292',
			series3: '#56b6b6',
			series4: '#e8c766',
			series5: '#c285ff',
			series6: '#7bd0f0',
			series7: '#ff8a65',
			series8: '#4db6ac',
		},
	};

	const branchColorPalette = [
		branchChartColors.donut.series1,
		branchChartColors.donut.series2,
		branchChartColors.donut.series3,
		branchChartColors.donut.series4,
		branchChartColors.donut.series5,
		branchChartColors.donut.series6,
		branchChartColors.donut.series7,
		branchChartColors.donut.series8,
	];

	const branchChartEl = document.querySelector('#branchChart');
	let branchChartInstance = null;

	function renderBranchChart(labels, series) {
		const branchChartConfig = {
			chart: {
				height: 390,
				type: 'donut',
			},
			labels: labels,
			series: series,
			colors: branchColorPalette,
			stroke: {
				show: false,
				curve: 'straight',
			},
			dataLabels: {
				enabled: true,
				formatter: function (val, opt) {
					return parseFloat(val).toFixed(1) + '%';
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
					colors: branchLegendColor,
					useSeriesColors: false,
				},
			},
			tooltip: {
				enabled: true,
				y: {
					formatter: function (value) {
						return value.toFixed(1) + '%';
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
								color: branchLegendColor,
								fontFamily: 'Inter',
								formatter: function (val) {
									return parseFloat(val).toFixed(1) + '%';
								},
							},
							total: {
								show: true,
								fontSize: '1rem',
								color: branchHeadingColor,
								label: 'Total Cabang',
								formatter: function (w) {
									const total = w.globals.seriesTotals.reduce(
										(a, b) => a + b,
										0
									);
									return Math.round(total) + '%';
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
								colors: branchLegendColor,
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
								colors: branchLegendColor,
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
			branchChartInstance &&
			typeof branchChartInstance.destroy === 'function'
		) {
			branchChartInstance.destroy();
		}

		branchChartInstance = new ApexCharts(branchChartEl, branchChartConfig);
		branchChartInstance.render();
	}

	function fetchBranchChartData() {
		if (!branchChartEl) {
			console.error('Element #branchChart tidak ditemukan');
			return;
		}

		fetch('Dashboard/getBranchChart')
			.then((response) => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then((data) => {
				if (data.success) {
					renderBranchChart(data.labels, data.series);
				} else {
					throw new Error(data.message || 'Failed to load branch chart data');
				}
			})
			.catch((error) => {
				if (branchChartEl) {
					branchChartEl.innerHTML = `
                        <div class="text-center p-4 text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <br>
                            Failed to load branch chart data
                            <br>
                            <small>${error.message}</small>
                        </div>
                    `;
				}
			});
	}

	function initializeBranchChart() {
		if (typeof branchChartEl !== 'undefined' && branchChartEl !== null) {
			setTimeout(fetchBranchChartData, 100);
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initializeBranchChart);
	} else {
		initializeBranchChart();
	}
})();
