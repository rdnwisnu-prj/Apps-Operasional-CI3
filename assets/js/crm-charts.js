(function () {
	'use strict';

	// Color configurations
	const cardColor = '#ffffff';
	const headingColor = '#2c323f';
	const labelColor = '#6d788d';
	const legendColor = '#5d6680';
	const borderColor = '#e5e7eb';

	// Chart color palettes
	const contributionColors = ['#7367f0', '#28c76f'];

	const productColors = [
		'#7367f0',
		'#28c76f',
		'#ff9f43',
		'#ea5455',
		'#00cfe8',
		'#a855f7',
		'#10b981',
		'#f59e0b',
		'#ef4444',
		'#06b6d4',
		'#8b5cf6',
		'#14b8a6',
		'#f97316',
		'#dc2626',
		'#0891b2',
		'#6366f1',
		'#059669',
		'#d97706',
		'#b91c1c',
		'#0284c7',
		'#4f46e5',
		'#047857',
	];

	// Chart instances
	let totalContributionChart = null;
	let productCakraChart = null;
	let productKonsehatChart = null;
	let rujukBalikChart = null;

	/**
	 * Initialize Total Contribution Pie Chart
	 */
	function initTotalContributionChart(data) {
		const chartEl = document.querySelector('#totalContributionChart');
		if (!chartEl) return;

		// Destroy existing chart
		if (totalContributionChart) {
			totalContributionChart.destroy();
			totalContributionChart = null;
		}

		// Check if there's data
		if (!data || !data.series || data.series.every((val) => val === 0)) {
			chartEl.innerHTML =
				'<div class="text-center text-muted py-5">Tidak ada data</div>';
			return;
		}

		const options = {
			chart: {
				height: 350,
				type: 'pie',
				id: 'totalContributionChart',
			},
			labels: data.labels,
			series: data.series,
			colors: contributionColors,
			stroke: {
				show: false,
			},
			dataLabels: {
				enabled: true,
				formatter: function (val, opts) {
					return (
						opts.w.config.series[opts.seriesIndex] +
						' (' +
						val.toFixed(1) +
						'%)'
					);
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
					formatter: function (
						value,
						{ series, seriesIndex, dataPointIndex, w }
					) {
						const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
						const percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
						return value + ' Data (' + percent + '%)';
					},
				},
			},
			plotOptions: {
				pie: {
					expandOnClick: true,
					donut: {
						labels: {
							show: false,
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
			],
		};

		totalContributionChart = new ApexCharts(chartEl, options);
		totalContributionChart.render();
	}

	/**
	 * Initialize Product Sales Bar Chart
	 */
	function initProductChart(elementId, data, chartTitle, colorScheme) {
		const chartEl = document.querySelector('#' + elementId);
		if (!chartEl) return null;

		// Check if there's data
		if (!data || !data.series || data.series.length === 0) {
			chartEl.innerHTML =
				'<div class="text-center text-muted py-5">Tidak ada data</div>';
			return null;
		}

		// Truncate labels for display
		const truncatedLabels = data.labels.map((label) => {
			return label.length > 20 ? label.substring(0, 18) + '...' : label;
		});

		const options = {
			chart: {
				height: 350,
				type: 'bar',
				id: elementId,
				toolbar: {
					show: true,
					tools: {
						download: true,
						selection: false,
						zoom: false,
						zoomin: false,
						zoomout: false,
						pan: false,
						reset: false,
					},
				},
			},
			plotOptions: {
				bar: {
					horizontal: true,
					borderRadius: 4,
					distributed: true,
					barHeight: '70%',
					dataLabels: {
						position: 'top',
					},
				},
			},
			colors: productColors.slice(0, data.series.length),
			dataLabels: {
				enabled: true,
				formatter: function (val) {
					return val;
				},
				offsetX: 20,
				style: {
					fontSize: '12px',
					colors: [headingColor],
				},
			},
			series: [
				{
					name: 'Jumlah',
					data: data.series,
				},
			],
			xaxis: {
				categories: truncatedLabels,
				labels: {
					style: {
						colors: labelColor,
						fontSize: '11px',
					},
				},
				title: {
					text: 'Jumlah Data',
					style: {
						color: labelColor,
						fontSize: '12px',
					},
				},
			},
			yaxis: {
				labels: {
					style: {
						colors: labelColor,
						fontSize: '10px',
					},
					maxWidth: 150,
				},
			},
			legend: {
				show: false,
			},
			tooltip: {
				enabled: true,
				y: {
					formatter: function (val) {
						return val + ' Data';
					},
					title: {
						formatter: function (seriesName, opts) {
							return data.labels[opts.dataPointIndex] + ':';
						},
					},
				},
			},
			grid: {
				borderColor: borderColor,
				xaxis: {
					lines: {
						show: true,
					},
				},
				yaxis: {
					lines: {
						show: false,
					},
				},
			},
			responsive: [
				{
					breakpoint: 992,
					options: {
						chart: {
							height: 400,
						},
						plotOptions: {
							bar: {
								barHeight: '60%',
							},
						},
					},
				},
			],
		};

		const chart = new ApexCharts(chartEl, options);
		chart.render();
		return chart;
	}

	/**
	 * Initialize Product Cakra Chart
	 */
	function initProductCakraChart(data) {
		// Destroy existing chart
		if (productCakraChart) {
			productCakraChart.destroy();
			productCakraChart = null;
		}

		productCakraChart = initProductChart(
			'productCakraChart',
			data,
			'Product Sales By Cakra',
			productColors
		);
	}

	/**
	 * Initialize Product Konsehat Chart
	 */
	function initProductKonsehatChart(data) {
		// Destroy existing chart
		if (productKonsehatChart) {
			productKonsehatChart.destroy();
			productKonsehatChart = null;
		}

		productKonsehatChart = initProductChart(
			'productKonsehatChart',
			data,
			'Product Sales By Konsehat',
			productColors
		);
	}

	/**
	 * Initialize Rujuk Balik By Cabang Pie Chart
	 */
	function initRujukBalikChart(data) {
		const chartEl = document.querySelector('#totalRujukBalikChart');
		if (!chartEl) return;

		// Destroy existing chart
		if (rujukBalikChart) {
			rujukBalikChart.destroy();
			rujukBalikChart = null;
		}

		// Check if there's data
		if (
			!data ||
			!data.series ||
			data.series.length === 0 ||
			data.series.every((val) => val === 0)
		) {
			chartEl.innerHTML =
				'<div class="text-center text-muted py-5">Tidak ada data</div>';
			return;
		}

		const options = {
			chart: {
				height: 350,
				type: 'pie',
				id: 'totalRujukBalikChart',
			},
			labels: data.labels,
			series: data.series,
			colors: productColors.slice(0, data.series.length),
			stroke: {
				show: false,
			},
			dataLabels: {
				enabled: true,
				formatter: function (val, opts) {
					return (
						opts.w.config.series[opts.seriesIndex] +
						' (' +
						val.toFixed(1) +
						'%)'
					);
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
					formatter: function (
						value,
						{ series, seriesIndex, dataPointIndex, w }
					) {
						const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
						const percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
						return value + ' Data (' + percent + '%)';
					},
				},
			},
			plotOptions: {
				pie: {
					expandOnClick: true,
					donut: {
						labels: {
							show: false,
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
			],
		};

		rujukBalikChart = new ApexCharts(chartEl, options);
		rujukBalikChart.render();
	}

	/**
	 * Initialize all CRM charts
	 */
	function initAllCharts() {
		if (typeof crmChartData !== 'undefined' && crmChartData) {
			initTotalContributionChart(crmChartData.total_contribution);
			initRujukBalikChart(crmChartData.rujuk_balik);
			initProductCakraChart(crmChartData.product_cakra);
			initProductKonsehatChart(crmChartData.product_konsehat);
		}
	}

	/**
	 * Update charts with new data (for filter)
	 */
	function updateCharts(data) {
		if (data) {
			initTotalContributionChart(data.total_contribution);
			initRujukBalikChart(data.rujuk_balik);
			initProductCakraChart(data.product_cakra);
			initProductKonsehatChart(data.product_konsehat);
		}
	}

	// DOM Ready
	document.addEventListener('DOMContentLoaded', function () {
		// Initialize charts on page load
		initAllCharts();

		// Filter button click handler
		const btnFilterDate = document.getElementById('btnFilterDate');
		if (btnFilterDate) {
			btnFilterDate.addEventListener('click', function () {
				const tglAwal = document.getElementById('tgl_awal').value;
				const tglAkhir = document.getElementById('tgl_akhir').value;

				if (!tglAwal || !tglAkhir) {
					Swal.fire({
						icon: 'warning',
						title: 'Perhatian',
						text: 'Silakan pilih tanggal awal dan tanggal akhir',
						confirmButtonColor: '#7367f0',
					});
					return;
				}

				// Show loading
				Swal.fire({
					title: 'Memuat data...',
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading();
					},
				});

				// AJAX call to get filtered data
				$.ajax({
					url: base_url + 'CRM/getChartData',
					type: 'POST',
					data: {
						tgl_awal: tglAwal,
						tgl_akhir: tglAkhir,
					},
					dataType: 'json',
					success: function (response) {
						Swal.close();
						if (response.status === 'success') {
							updateCharts(response);

							// Close offcanvas
							const offcanvas = bootstrap.Offcanvas.getInstance(
								document.getElementById('offcanvasRight')
							);
							if (offcanvas) {
								offcanvas.hide();
							}

							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: 'Data berhasil difilter',
								timer: 1500,
								showConfirmButton: false,
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: 'Gagal memuat data',
								confirmButtonColor: '#7367f0',
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Terjadi kesalahan, silakan coba lagi',
							confirmButtonColor: '#7367f0',
						});
					},
				});
			});
		}

		// Reset filter button click handler
		const btnResetFilter = document.getElementById('btnResetFilter');
		if (btnResetFilter) {
			btnResetFilter.addEventListener('click', function () {
				// Clear input fields
				document.getElementById('tgl_awal').value = '';
				document.getElementById('tgl_akhir').value = '';

				// Reset charts to original data
				initAllCharts();

				// Close offcanvas
				const offcanvas = bootstrap.Offcanvas.getInstance(
					document.getElementById('offcanvasRight')
				);
				if (offcanvas) {
					offcanvas.hide();
				}

				Swal.fire({
					icon: 'success',
					title: 'Berhasil',
					text: 'Filter berhasil direset',
					timer: 1500,
					showConfirmButton: false,
				});
			});
		}
	});

	// Expose functions globally if needed
	window.CRMCharts = {
		init: initAllCharts,
		update: updateCharts,
	};
})();
