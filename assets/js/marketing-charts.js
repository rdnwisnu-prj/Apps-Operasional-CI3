(function () {
	const isDarkStyle = false;
	let cardColor, headingColor, labelColor, legendColor, borderColor;

	if (isDarkStyle) {
		cardColor = '#2b3550';
		headingColor = '#e4e8f3';
		labelColor = '#8a99c0';
		legendColor = '#c3cbe4';
		borderColor = '#3b4563';
	} else {
		cardColor = '#ffffff';
		headingColor = '#2c323f';
		labelColor = '#6d788d';
		legendColor = '#5d6680';
		borderColor = '#e5e7eb';
	}

	// Color palettes for each chart
	const prospekColors = [
		'#28c76f',
		'#3fd0bd',
		'#00cfe8',
		'#7367f0',
		'#a855f7',
		'#10b981',
		'#059669',
		'#047857',
		'#22d3ee',
		'#06b6d4',
	];

	const clientColors = [
		'#ff9f43',
		'#ffc107',
		'#f59e0b',
		'#fbbf24',
		'#f97316',
		'#fb923c',
		'#fdba74',
		'#fed7aa',
		'#ffedd5',
		'#ea580c',
	];

	const lostColors = [
		'#ea5455',
		'#f87171',
		'#ef4444',
		'#dc2626',
		'#b91c1c',
		'#991b1b',
		'#7f1d1d',
		'#fca5a5',
		'#fecaca',
		'#fee2e2',
	];

	let prospekMarketingChart = null;
	let clientMarketingChart = null;
	let lostMarketingChart = null;

	function createPieChartConfig(
		labels,
		series,
		colors,
		totalLabel,
		totalValue
	) {
		return {
			chart: {
				height: 350,
				type: 'donut',
			},
			labels: labels,
			series: series,
			colors: colors.slice(0, labels.length),
			stroke: {
				show: false,
				curve: 'straight',
			},
			dataLabels: {
				enabled: true,
				formatter: function (val, opts) {
					return opts.w.config.series[opts.seriesIndex];
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
					colors: legendColor,
					useSeriesColors: false,
				},
			},
			tooltip: {
				enabled: true,
				y: {
					formatter: function (value) {
						return value + ' Data';
					},
				},
			},
			plotOptions: {
				pie: {
					donut: {
						labels: {
							show: true,
							name: {
								fontSize: '1.5rem',
								fontFamily: 'Inter',
							},
							value: {
								fontSize: '1rem',
								color: legendColor,
								fontFamily: 'Inter',
								formatter: function (val) {
									return val + ' Data';
								},
							},
							total: {
								show: true,
								fontSize: '0.9rem',
								color: headingColor,
								label: totalLabel,
								formatter: function () {
									return totalValue;
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
							height: 320,
						},
						legend: {
							position: 'bottom',
						},
					},
				},
				{
					breakpoint: 576,
					options: {
						chart: {
							height: 280,
						},
						legend: {
							show: false,
						},
					},
				},
			],
		};
	}

	function renderNoData(element, message) {
		if (element) {
			element.innerHTML = `
				<div class="d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
					<i class="ri-pie-chart-line text-muted" style="font-size: 3rem;"></i>
					<p class="text-muted mt-2 mb-0">${message}</p>
				</div>
			`;
		}
	}

	function renderError(element, error) {
		if (element) {
			element.innerHTML = `
				<div class="d-flex flex-column align-items-center justify-content-center text-danger" style="height: 300px;">
					<i class="ri-error-warning-line" style="font-size: 3rem;"></i>
					<p class="mt-2 mb-0">Failed to load chart</p>
					<small>${error}</small>
				</div>
			`;
		}
	}

	function fetchProspekMarketingChart(startDate = null, endDate = null) {
		const chartEl = document.querySelector('#prospekMarketingChart');
		if (!chartEl) return;

		const formData = new FormData();
		if (startDate && endDate) {
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		}

		fetch(base_url + 'Dashboard/getProspekMarketingChart', {
			method: 'POST',
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success && data.labels.length > 0) {
					if (prospekMarketingChart) {
						prospekMarketingChart.destroy();
					}

					const config = createPieChartConfig(
						data.labels,
						data.series,
						prospekColors,
						'Total Prospek',
						data.total_prospek + ' Data'
					);

					prospekMarketingChart = new ApexCharts(chartEl, config);
					prospekMarketingChart.render();
				} else {
					renderNoData(chartEl, 'Tidak ada data prospek');
				}
			})
			.catch((error) => {
				console.error('Error fetching Prospek Marketing Chart:', error);
				renderError(chartEl, error.message);
			});
	}

	function fetchClientMarketingChart(startDate = null, endDate = null) {
		const chartEl = document.querySelector('#clientMarketingChart');
		if (!chartEl) return;

		const formData = new FormData();
		if (startDate && endDate) {
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		}

		fetch(base_url + 'Dashboard/getClientMarketingChart', {
			method: 'POST',
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success && data.labels.length > 0) {
					if (clientMarketingChart) {
						clientMarketingChart.destroy();
					}

					const config = createPieChartConfig(
						data.labels,
						data.series,
						clientColors,
						'Total Client',
						data.total_client + ' Data'
					);

					clientMarketingChart = new ApexCharts(chartEl, config);
					clientMarketingChart.render();
				} else {
					renderNoData(chartEl, 'Tidak ada data client');
				}
			})
			.catch((error) => {
				console.error('Error fetching Client Marketing Chart:', error);
				renderError(chartEl, error.message);
			});
	}

	function fetchLostMarketingChart(startDate = null, endDate = null) {
		const chartEl = document.querySelector('#lostMarketingChart');
		if (!chartEl) return;

		const formData = new FormData();
		if (startDate && endDate) {
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		}

		fetch(base_url + 'Dashboard/getLostMarketingChart', {
			method: 'POST',
			body: formData,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success && data.labels.length > 0) {
					if (lostMarketingChart) {
						lostMarketingChart.destroy();
					}

					const config = createPieChartConfig(
						data.labels,
						data.series,
						lostColors,
						'Total Lost',
						data.total_lost + ' Data'
					);

					lostMarketingChart = new ApexCharts(chartEl, config);
					lostMarketingChart.render();
				} else {
					renderNoData(chartEl, 'Tidak ada data lost');
				}
			})
			.catch((error) => {
				console.error('Error fetching Lost Marketing Chart:', error);
				renderError(chartEl, error.message);
			});
	}

	function initializeMarketingCharts() {
		fetchProspekMarketingChart();
		fetchClientMarketingChart();
		fetchLostMarketingChart();
	}

	window.refreshMarketingCharts = function (startDate, endDate) {
		fetchProspekMarketingChart(startDate, endDate);
		fetchClientMarketingChart(startDate, endDate);
		fetchLostMarketingChart(startDate, endDate);
	};

	window.resetMarketingCharts = function () {
		fetchProspekMarketingChart();
		fetchClientMarketingChart();
		fetchLostMarketingChart();
	};
	document.addEventListener('DOMContentLoaded', function () {
		initializeMarketingCharts();
	});
})();
