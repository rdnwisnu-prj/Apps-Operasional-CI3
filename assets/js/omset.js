(function () {
	const isDarkStyle = false;
	let omsetLabelColor, omsetBorderColor;

	if (isDarkStyle) {
		omsetLabelColor = '#8a99c0';
		omsetBorderColor = '#3b4563';
	} else {
		omsetLabelColor = '#6d788d';
		omsetBorderColor = '#e5e7eb';
	}

	const omsetChartColors = {
		bar: {
			series1: '#00cfe8',
			series2: '#7367f0',
			series3: '#ea5455',
			series4: '#28c76f',
			series5: '#ff9f43',
			series6: '#9c8dff',
			series7: '#87ceeb',
			series8: '#f06292',
			series9: '#4db6ac',
			series10: '#ffb74d',
			series11: '#ba68c8',
			series12: '#64b5f6',
			series13: '#81c784',
			series14: '#e57373',
			series15: '#ffd54f',
			series16: '#90a4ae',
		},
	};

	const omsetColorPalette = [
		omsetChartColors.bar.series1,
		omsetChartColors.bar.series2,
		omsetChartColors.bar.series3,
		omsetChartColors.bar.series4,
		omsetChartColors.bar.series5,
		omsetChartColors.bar.series6,
		omsetChartColors.bar.series7,
		omsetChartColors.bar.series8,
		omsetChartColors.bar.series9,
		omsetChartColors.bar.series10,
		omsetChartColors.bar.series11,
		omsetChartColors.bar.series12,
		omsetChartColors.bar.series13,
		omsetChartColors.bar.series14,
		omsetChartColors.bar.series15,
		omsetChartColors.bar.series16,
	];

	let omsetChartInstance = null;
	let omsetUserIds = [];

	function formatRupiah(value) {
		if (value >= 1000000000) {
			return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
		} else if (value >= 1000000) {
			return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
		} else if (value >= 1000) {
			return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
		}
		return 'Rp ' + value.toLocaleString('id-ID');
	}

	function renderOmsetChart(labels, series, totalOmset, userIds) {
		const omsetChartEl = document.querySelector('#omsetChart');
		if (!omsetChartEl) {
			console.warn('Element #omsetChart tidak ditemukan untuk rendering');
			return;
		}

		omsetUserIds = userIds || [];

		const barHeight = 35;
		const minHeight = 350;
		const calculatedHeight = Math.max(
			minHeight,
			labels.length * barHeight + 80
		);

		const omsetChartConfig = {
			series: [
				{
					name: 'Total Estimasi',
					data: series,
				},
			],
			chart: {
				type: 'bar',
				height: calculatedHeight,
				toolbar: { show: false },
				events: {
					dataPointSelection: function (event, chartContext, config) {
						var selectedUserId = omsetUserIds[config.dataPointIndex];
						if (selectedUserId) {
							var baseUrl =
								window.location.origin +
								window.location.pathname.split('/').slice(0, -1).join('/') +
								'/';
							window.location.href =
								baseUrl +
								'Client?marketing=' +
								encodeURIComponent(selectedUserId);
						}
					},
				},
			},
			plotOptions: {
				bar: {
					barHeight: '80%',
					distributed: true,
					horizontal: true,
					dataLabels: {
						position: 'bottom',
					},
				},
			},
			colors: omsetColorPalette,
			dataLabels: {
				enabled: true,
				textAnchor: 'start',
				style: {
					colors: ['#fff'],
					fontSize: '12px',
					fontWeight: 500,
				},
				formatter: function (val) {
					return formatRupiah(val);
				},
				offsetX: 0,
				dropShadow: {
					enabled: false,
				},
			},
			stroke: {
				width: 1,
				colors: ['#fff'],
			},
			xaxis: {
				categories: labels,
				labels: {
					style: {
						colors: omsetLabelColor,
						fontSize: '12px',
					},
					formatter: function (val) {
						if (val >= 1000000000) {
							return (val / 1000000000).toFixed(1) + ' M';
						} else if (val >= 1000000) {
							return (val / 1000000).toFixed(1) + ' Jt';
						} else if (val >= 1000) {
							return (val / 1000).toFixed(1) + ' Rb';
						}
						return val;
					},
				},
			},
			yaxis: {
				labels: {
					show: true,
					style: {
						colors: omsetLabelColor,
						fontSize: '11px',
					},
					maxWidth: 200,
				},
			},
			tooltip: {
				theme: 'dark',
				x: {
					show: true,
				},
				y: {
					title: {
						formatter: function (seriesName, opts) {
							return opts.w.globals.labels[opts.dataPointIndex] + ':';
						},
					},
					formatter: function (val) {
						return formatRupiah(val);
					},
				},
			},
			legend: {
				show: false,
			},
			grid: {
				borderColor: omsetBorderColor,
			},
			responsive: [
				{
					breakpoint: 576,
					options: {
						chart: {
							height: Math.max(300, labels.length * 30 + 60),
						},
						dataLabels: {
							style: {
								fontSize: '10px',
							},
						},
					},
				},
			],
		};

		if (
			omsetChartInstance &&
			typeof omsetChartInstance.destroy === 'function'
		) {
			omsetChartInstance.destroy();
		}

		omsetChartEl.innerHTML = '';
		omsetChartInstance = new ApexCharts(omsetChartEl, omsetChartConfig);
		omsetChartInstance.render();
	}

	/**
	 * Fetch chart data from server
	 * @param {string|null} startDate
	 * @param {string|null} endDate
	 */
	function fetchOmsetChartData(startDate = null, endDate = null) {
		const omsetChartEl = document.querySelector('#omsetChart');
		if (!omsetChartEl) {
			console.warn(
				'Element #omsetChart tidak ditemukan di DOM - skipping fetch'
			);
			return;
		}

		omsetChartEl.innerHTML = `
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Loading chart data...</p>
            </div>
        `;

		const formData = new FormData();
		if (startDate && endDate) {
			formData.append('start_date', startDate);
			formData.append('end_date', endDate);
		}

		fetch(base_url + 'Dashboard/getOmsetChart', {
			method: 'POST',
			body: formData,
		})
			.then((response) => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then((data) => {
				if (data.success) {
					if (data.labels.length === 0) {
						omsetChartEl.innerHTML = `
							<div class="text-center p-4 text-muted">
								<i class="ri-bar-chart-horizontal-line fs-1"></i>
								<p class="mt-2 mb-0">Tidak ada data omset yang tersedia</p>
							</div>
						`;
					} else {
						renderOmsetChart(
							data.labels,
							data.series,
							data.total_omset,
							data.user_ids || []
						);
					}
				} else {
					throw new Error(data.message || 'Failed to load omset chart data');
				}
			})
			.catch((error) => {
				console.error('Error fetching omset chart data:', error);
				if (omsetChartEl) {
					omsetChartEl.innerHTML = `
                        <div class="text-center p-4 text-danger">
                            <i class="ri-error-warning-line fs-1"></i>
                            <p class="mt-2 mb-0">Gagal memuat data chart</p>
                            <small>${error.message}</small>
                        </div>
                    `;
				}
			});
	}

	/**
	 * Initialize the omset chart
	 */
	function initializeOmsetChart() {
		const omsetChartEl = document.querySelector('#omsetChart');
		if (omsetChartEl) {
			fetchOmsetChartData();
		}
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			setTimeout(initializeOmsetChart, 100);
		});
	} else {
		setTimeout(initializeOmsetChart, 100);
	}

	window.omsetChart = {
		initialize: initializeOmsetChart,
		refresh: fetchOmsetChartData,
	};
})();
