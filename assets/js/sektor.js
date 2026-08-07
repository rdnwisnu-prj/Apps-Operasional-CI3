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

	const sektorChartColors = {
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

	const sektorColorPalette = [
		sektorChartColors.bar.series1,
		sektorChartColors.bar.series2,
		sektorChartColors.bar.series3,
		sektorChartColors.bar.series4,
		sektorChartColors.bar.series5,
		sektorChartColors.bar.series6,
		sektorChartColors.bar.series7,
		sektorChartColors.bar.series8,
		sektorChartColors.bar.series9,
		sektorChartColors.bar.series10,
		sektorChartColors.bar.series11,
		sektorChartColors.bar.series12,
		sektorChartColors.bar.series13,
		sektorChartColors.bar.series14,
		sektorChartColors.bar.series15,
		sektorChartColors.bar.series16,
	];

	let sektorChartInstance = null;

	function renderSektorChart(labels, series) {
		const sektorChartEl = document.querySelector('#sektorChart');

		if (!sektorChartEl) {
			console.warn('Element #sektorChart tidak ditemukan untuk rendering');
			return;
		}

		// Calculate dynamic height based on number of items
		const barHeight = 35;
		const minHeight = 350;
		const calculatedHeight = Math.max(
			minHeight,
			labels.length * barHeight + 80
		);

		const sektorChartConfig = {
			series: [
				{
					name: 'Persentase',
					data: series,
				},
			],
			chart: {
				type: 'bar',
				height: calculatedHeight,
				toolbar: { show: false },
				events: {
					dataPointSelection: function (event, chartContext, config) {
						var selectedLabel = labels[config.dataPointIndex];
						var baseUrl =
							window.location.origin +
							window.location.pathname.split('/').slice(0, -1).join('/') +
							'/';
						window.location.href =
							baseUrl + 'Client?sektor=' + encodeURIComponent(selectedLabel);
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
			colors: sektorColorPalette,
			dataLabels: {
				enabled: true,
				textAnchor: 'start',
				style: {
					colors: ['#fff'],
					fontSize: '12px',
					fontWeight: 500,
				},
				formatter: function (val, opt) {
					return val.toFixed(1) + '%';
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
						colors: sektorLabelColor,
						fontSize: '12px',
					},
					formatter: function (val) {
						return val.toFixed(1) + '%';
					},
				},
			},
			yaxis: {
				labels: {
					show: true,
					style: {
						colors: sektorLabelColor,
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
						return val.toFixed(1) + '%';
					},
				},
			},
			legend: {
				show: false,
			},
			grid: {
				borderColor: sektorBorderColor,
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
			sektorChartInstance &&
			typeof sektorChartInstance.destroy === 'function'
		) {
			sektorChartInstance.destroy();
		}

		sektorChartEl.innerHTML = '';
		sektorChartInstance = new ApexCharts(sektorChartEl, sektorChartConfig);
		sektorChartInstance.render();
	}

	function fetchSektorChartData() {
		const sektorChartEl = document.querySelector('#sektorChart');

		if (!sektorChartEl) {
			console.warn(
				'Element #sektorChart tidak ditemukan di DOM - skipping fetch'
			);
			return;
		}

		sektorChartEl.innerHTML = `
            <div class="text-center p-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 mb-0">Loading chart data...</p>
            </div>
        `;

		fetch('Dashboard/getSektorChart')
			.then((response) => {
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				return response.json();
			})
			.then((data) => {
				if (data.success) {
					renderSektorChart(data.labels, data.series);
				} else {
					throw new Error(data.message || 'Failed to load sektor chart data');
				}
			})
			.catch((error) => {
				console.error('Error fetching sektor chart data:', error);
				const sektorChartEl = document.querySelector('#sektorChart');
				if (sektorChartEl) {
					sektorChartEl.innerHTML = `
                        <div class="text-center p-4 text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <br>
                            <small>Failed to load sektor chart data</small>
                            <br>
                            <small>${error.message}</small>
                        </div>
                    `;
				}
			});
	}

	function initializeSektorChart() {
		const sektorChartEl = document.querySelector('#sektorChart');

		if (sektorChartEl) {
			fetchSektorChartData();
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			setTimeout(initializeSektorChart, 100);
		});
	} else {
		setTimeout(initializeSektorChart, 100);
	}

	window.sektorChart = {
		initialize: initializeSektorChart,
		refresh: fetchSektorChartData,
	};
})();
