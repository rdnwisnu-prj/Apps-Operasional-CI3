(function () {
	console.log('Chart script loaded');

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

	const chartColors = {
		column: {
			series1: '#826af9',
			series2: '#d2b0ff',
			series3: '#2ecc71',
			series4: '#e74c3c',
			series5: '#3498db',
		},
	};

	const barChartEl = document.querySelector('#barChart');

	console.log('Chart element:', barChartEl);

	function fetchChartData() {
		console.log('Fetching chart data from API...');
		return fetch(base_url + 'Dashboard/getSalesMonthdata')
			.then((response) => {
				console.log('Response status:', response.status);
				if (!response.ok) {
					throw new Error('Network response was not ok: ' + response.status);
				}
				return response.json();
			})
			.then((data) => {
				console.log('Data fetched successfully:', data);
				return data;
			})
			.catch((error) => {
				console.error('Error fetching chart data:', error);
				return getDefaultChartData();
			});
	}

	if (typeof barChartEl !== 'undefined' && barChartEl !== null) {
		console.log('Initializing chart...');

		// Debug globalChartData
		console.log('Global chart data:', typeof globalChartData, globalChartData);

		const chartPromise =
			typeof globalChartData !== 'undefined' && globalChartData !== null
				? Promise.resolve(globalChartData)
				: fetchChartData();

		chartPromise
			.then((chartData) => {
				console.log('Chart data to render:', chartData);
				if (chartData && chartData.series && chartData.categories) {
					initializeChart(chartData);
				} else {
					console.error('Invalid chart data structure:', chartData);
					initializeChart(getDefaultChartData());
				}
			})
			.catch((error) => {
				console.error('Error in chart promise:', error);
				initializeChart(getDefaultChartData());
			});
	} else {
		console.error('Chart element not found!');
	}

	function initializeChart(chartData) {
		console.log('Initializing chart with data:', chartData);

		// Pastikan data series ada
		if (!chartData.series || !Array.isArray(chartData.series)) {
			console.error('Invalid series data');
			chartData = getDefaultChartData();
		}

		const barChartConfig = {
			chart: {
				height: 400,
				type: 'bar',
				parentHeightOffset: 0,
				toolbar: {
					show: false,
				},
			},
			plotOptions: {
				bar: {
					columnWidth: '50%',
					borderRadius: 5,
					distributed: false,
				},
			},
			dataLabels: {
				enabled: false,
			},
			legend: {
				show: true,
				position: 'bottom',
				horizontalAlign: 'center',
				labels: {
					colors: legendColor,
					useSeriesColors: false,
				},
			},
			colors: [
				chartColors.column.series1,
				chartColors.column.series2,
				chartColors.column.series3,
				chartColors.column.series4,
				chartColors.column.series5,
			],
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent'],
			},
			grid: {
				borderColor: borderColor,
				xaxis: {
					lines: {
						show: true,
					},
				},
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 10,
				},
			},
			series: chartData.series,
			xaxis: {
				categories: chartData.categories,
				axisBorder: {
					show: false,
				},
				axisTicks: {
					show: false,
				},
				labels: {
					style: {
						colors: labelColor,
						fontSize: '11px',
					},
					rotate: -45,
				},
			},
			yaxis: {
				labels: {
					style: {
						colors: labelColor,
						fontSize: '13px',
					},
					formatter: function (value) {
						if (value >= 1000000000) {
							return 'Rp ' + (value / 1000000000).toFixed(1) + 'M';
						} else if (value >= 1000000) {
							return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
						} else {
							return 'Rp ' + value;
						}
					},
				},
				tickAmount: 6,
			},
			tooltip: {
				y: {
					formatter: function (value) {
						if (value >= 1000000000) {
							return 'Rp ' + (value / 1000000000).toFixed(2) + ' Milyar';
						} else if (value >= 1000000) {
							return 'Rp ' + (value / 1000000).toFixed(1) + ' Juta';
						} else {
							return 'Rp ' + value.toLocaleString();
						}
					},
				},
			},
			fill: {
				opacity: 1,
			},
		};

		if (barChartEl.classList.contains('apexcharts-inner')) {
			barChartEl.innerHTML = '';
		}

		const barChart = new ApexCharts(barChartEl, barChartConfig);
		barChart.render();
		console.log('Chart rendered');
	}

	function getDefaultChartData() {
		console.log('Using default chart data');
		return {
			categories: [
				'Januari',
				'Februari',
				'Maret',
				'April',
				'Mei',
				'Juni',
				'Juli',
				'Agustus',
				'September',
				'Oktober',
				'November',
				'Desember',
			],
			series: [
				{ name: 'MCU', data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] },
				{ name: 'IHC', data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] },
				{ name: 'VAKSIN', data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] },
				{ name: 'HSEO', data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] },
				{ name: 'LAB RUJUKAN', data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] },
			],
		};
	}
})();
