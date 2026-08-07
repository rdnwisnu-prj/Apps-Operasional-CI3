/**
 * Dashboard Filter by Bulan & Tahun
 */

'use strict';

(function () {
	// Store chart instances
	let serviceChartInstance = null;
	let sektorChartInstance = null;
	let branchChartInstance = null;
	let groupChartInstance = null;
	let barChartInstance = null;

	// Get filter button and reset button
	const btnFilter = document.getElementById('btnFilterDashboard');
	const btnReset = document.getElementById('btnResetDashboard');
	const filterInfoCard = document.getElementById('filterInfoCard');
	const filterRangeText = document.getElementById('filterRangeText');

	if (btnFilter) {
		btnFilter.addEventListener('click', function () {
			const bulan = document.getElementById('filter_bulan')
				? document.getElementById('filter_bulan').value
				: '';
			const tahun = document.getElementById('filter_tahun')
				? document.getElementById('filter_tahun').value
				: '';
			const filterUserId = document.getElementById('filter_user_id')
				? document.getElementById('filter_user_id').value
				: '';

			// At least one filter must be selected
			if (!filterUserId && !bulan && !tahun) {
				Swal.fire({
					icon: 'warning',
					title: 'Perhatian',
					text: 'Silakan pilih marketing atau bulan dan tahun untuk filter',
				});
				return;
			}

			// If month/year is partially filled, both must be filled
			if ((bulan && !tahun) || (!bulan && tahun)) {
				Swal.fire({
					icon: 'warning',
					title: 'Perhatian',
					text: 'Silakan pilih bulan dan tahun',
				});
				return;
			}

			// Close offcanvas before showing loading
			const offcanvasEl = document.getElementById('offcanvasRight');
			if (offcanvasEl) {
				const offcanvasInstance = bootstrap.Offcanvas.getInstance(offcanvasEl);
				if (offcanvasInstance) {
					offcanvasInstance.hide();
				}
			}

			// Show loading
			Swal.fire({
				title: 'Memuat Data...',
				allowOutsideClick: false,
				didOpen: () => {
					Swal.showLoading();
				},
			});

			// Get selected user name for display
			const filterUserSelect = document.getElementById('filter_user_id');
			const selectedUserName =
				filterUserSelect && filterUserId
					? filterUserSelect.options[filterUserSelect.selectedIndex].text
					: '';

			// Build filter info text
			let filterInfoText = '';
			if (filterUserId && selectedUserName) {
				filterInfoText = selectedUserName;
			}
			if (bulan && tahun) {
				const namaBulan =
					document.getElementById('filter_bulan').options[
						document.getElementById('filter_bulan').selectedIndex
					].text;
				if (filterInfoText) {
					filterInfoText += ' | ' + namaBulan + ' ' + tahun;
				} else {
					filterInfoText = namaBulan + ' ' + tahun;
				}
			}

			// Update filter info card
			if (filterInfoCard && filterInfoText) {
				filterInfoCard.classList.remove('d-none');
				filterRangeText.textContent = filterInfoText;
			}

			// Call all filter functions
			Promise.all([
				filterDashboardCards(bulan, tahun, filterUserId),
				filterServiceChart(bulan, tahun, filterUserId),
				filterSektorChart(bulan, tahun, filterUserId),
				filterBranchChart(bulan, tahun, filterUserId),
				filterGroupChart(bulan, tahun, filterUserId),
				filterSalesMonthChart(bulan, tahun, filterUserId),
				filterOmsetChart(bulan, tahun, filterUserId),
				filterProspekMarketingChart(bulan, tahun, filterUserId),
				filterClientMarketingChart(bulan, tahun, filterUserId),
				filterLostMarketingChart(bulan, tahun, filterUserId),
			])
				.then(() => {
					// Also refresh marketing charts if the function exists
					if (typeof window.refreshMarketingCharts === 'function') {
						window.refreshMarketingCharts(bulan, tahun);
					}
					Swal.fire({
						icon: 'success',
						title: 'Berhasil',
						text: 'Data berhasil difilter',
						timer: 1500,
						showConfirmButton: false,
					});
				})
				.catch((error) => {
					Swal.close();
					console.error('Error filtering data:', error);
				});
		});
	}

	if (btnReset) {
		btnReset.addEventListener('click', function () {
			// Clear select inputs
			document.getElementById('filter_bulan').value = '';
			document.getElementById('filter_tahun').value = '';
			var filterUserEl = document.getElementById('filter_user_id');
			if (filterUserEl) filterUserEl.value = '';

			// Hide filter info card
			if (filterInfoCard) {
				filterInfoCard.classList.add('d-none');
			}

			// Reload page to reset all data
			location.reload();
		});
	}

	// Build body params helper
	function buildBodyParams(bulan, tahun, filterUserId) {
		var params = '';
		if (bulan && tahun) {
			params =
				'periode_bulan=' +
				encodeURIComponent(bulan) +
				'&periode_tahun=' +
				encodeURIComponent(tahun);
		}
		if (filterUserId) {
			params +=
				(params ? '&' : '') +
				'filter_user_id=' +
				encodeURIComponent(filterUserId);
		}
		return params;
	}

	// Filter Dashboard Cards (Total Prospek, Estimasi, Client, Sales)
	function filterDashboardCards(bulan, tahun, filterUserId) {
		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();
		return fetch(base_url + 'Dashboard/filterDashboardData', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					// Update card values
					const cardProspek = document.getElementById('cardTotalProspek');
					const cardEstimasi = document.getElementById('cardEstimasiLead');
					const cardClient = document.getElementById('cardTotalClient');
					const cardSales = document.getElementById('cardTotalSales');

					if (cardProspek) {
						cardProspek.innerHTML =
							'<span class="counter-value">' + data.total_prospek + '</span>';
					}
					if (cardEstimasi) {
						cardEstimasi.textContent = data.total_estimasi_lead;
					}
					if (cardClient) {
						cardClient.innerHTML =
							'<span class="counter-value">' + data.total_client + '</span>';
					}
					if (cardSales) {
						cardSales.textContent = data.total_sales;
					}
				}
			})
			.catch((error) => {
				console.error('Error filtering dashboard cards:', error);
			});
	}

	// Filter Service Chart
	function filterServiceChart(bulan, tahun, filterUserId) {
		const serviceChartEl = document.getElementById('serviceChart');
		if (!serviceChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getServiceChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'serviceChart',
						data.labels,
						data.series,
						data.total_projects,
						'Total Project'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering service chart:', error);
			});
	}

	// Filter Sektor Chart
	function filterSektorChart(bulan, tahun, filterUserId) {
		const sektorChartEl = document.getElementById('sektorChart');
		if (!sektorChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getSektorChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateBarHorizontalChart('sektorChart', data.labels, data.series);
				}
			})
			.catch((error) => {
				console.error('Error filtering sektor chart:', error);
			});
	}

	// Filter Branch Chart
	function filterBranchChart(bulan, tahun, filterUserId) {
		const branchChartEl = document.getElementById('branchChart');
		if (!branchChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getBranchChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'branchChart',
						data.labels,
						data.series,
						data.total_projects,
						'Total Project'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering branch chart:', error);
			});
	}

	// Filter Group Chart
	function filterGroupChart(bulan, tahun, filterUserId) {
		const groupChartEl = document.getElementById('groupChart');
		if (!groupChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();
		return fetch(base_url + 'Dashboard/getGroupChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'groupChart',
						data.labels,
						data.series,
						data.total_clients,
						'Total Client'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering group chart:', error);
			});
	}

	// Filter Sales Month Chart
	function filterSalesMonthChart(bulan, tahun, filterUserId) {
		const barChartEl = document.getElementById('barChart');
		if (!barChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();
		return fetch(base_url + 'Dashboard/getSalesMonthdata', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				updateBarChart('barChart', data.categories, data.series);
			})
			.catch((error) => {
				console.error('Error filtering sales month chart:', error);
			});
	}

	// Update Donut Chart
	function updateDonutChart(chartId, labels, series, total, totalLabel) {
		const chartEl = document.getElementById(chartId);
		if (!chartEl) return;

		// Destroy existing chart if exists
		if (ApexCharts.getChartByID(chartId)) {
			ApexCharts.getChartByID(chartId).destroy();
		}

		const colorPalette = [
			'#fee802',
			'#3fd0bd',
			'#826bf8',
			'#F1F0F2',
			'#ff9f43',
			'#7367f0',
			'#ea5455',
			'#28c76f',
		];

		const chartConfig = {
			chart: {
				id: chartId,
				height: 390,
				type: 'donut',
			},
			labels: labels,
			series: series,
			colors: colorPalette,
			stroke: {
				show: false,
			},
			dataLabels: {
				enabled: true,
				formatter: function (val) {
					return parseFloat(val).toFixed(1) + '%';
				},
			},
			legend: {
				show: true,
				position: 'bottom',
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
								fontSize: '1.2rem',
								formatter: function (val) {
									return parseFloat(val).toFixed(1) + '%';
								},
							},
							total: {
								show: true,
								fontSize: '1.2rem',
								label: totalLabel,
								formatter: function () {
									return total;
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
					},
				},
			],
		};

		const chart = new ApexCharts(chartEl, chartConfig);
		chart.render();
	}

	// Update Bar Chart (for Sales by Month)
	function updateBarChart(chartId, categories, series) {
		const chartEl = document.getElementById(chartId);
		if (!chartEl) return;

		// Try to get existing chart and update it
		const existingChart = ApexCharts.getChartByID(chartId);
		if (existingChart) {
			existingChart.updateOptions({
				xaxis: {
					categories: categories,
				},
			});
			existingChart.updateSeries(series);
		} else {
			// Create new chart if not exists
			const chartColors = {
				series1: '#826af9',
				series2: '#d2b0ff',
				series3: '#2ecc71',
				series4: '#e74c3c',
				series5: '#3498db',
			};

			const chartConfig = {
				chart: {
					id: chartId,
					height: 400,
					type: 'bar',
					toolbar: {
						show: false,
					},
				},
				plotOptions: {
					bar: {
						columnWidth: '50%',
						borderRadius: 5,
					},
				},
				dataLabels: {
					enabled: false,
				},
				legend: {
					show: true,
					position: 'bottom',
				},
				colors: [
					chartColors.series1,
					chartColors.series2,
					chartColors.series3,
					chartColors.series4,
					chartColors.series5,
				],
				stroke: {
					show: true,
					width: 2,
					colors: ['transparent'],
				},
				xaxis: {
					categories: categories,
				},
				series: series,
				yaxis: {
					labels: {
						formatter: function (val) {
							if (val >= 1000000000) {
								return (val / 1000000000).toFixed(1) + ' M';
							} else if (val >= 1000000) {
								return (val / 1000000).toFixed(1) + ' Jt';
							}
							return val;
						},
					},
				},
			};

			const chart = new ApexCharts(chartEl, chartConfig);
			chart.render();
		}
	}

	// Update Horizontal Bar Chart (for Sektor)
	function updateBarHorizontalChart(chartId, labels, series) {
		const chartEl = document.getElementById(chartId);
		if (!chartEl) return;

		// Destroy existing chart if exists
		if (ApexCharts.getChartByID(chartId)) {
			ApexCharts.getChartByID(chartId).destroy();
		}

		const chartConfig = {
			chart: {
				id: chartId,
				height: 400,
				type: 'bar',
				toolbar: {
					show: false,
				},
			},
			plotOptions: {
				bar: {
					horizontal: true,
					borderRadius: 4,
					dataLabels: {
						position: 'top',
					},
				},
			},
			dataLabels: {
				enabled: true,
				offsetX: -6,
				style: {
					fontSize: '12px',
					colors: ['#fff'],
				},
				formatter: function (val) {
					return val.toFixed(1) + '%';
				},
			},
			colors: ['#826bf8'],
			xaxis: {
				categories: labels,
				labels: {
					formatter: function (val) {
						return val + '%';
					},
				},
			},
			series: [
				{
					name: 'Persentase',
					data: series,
				},
			],
		};

		const chart = new ApexCharts(chartEl, chartConfig);
		chart.render();
	}

	// Filter Omset Chart
	function filterOmsetChart(bulan, tahun, filterUserId) {
		const omsetChartEl = document.getElementById('omsetChart');
		if (!omsetChartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getOmsetChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateBarHorizontalOmsetChart(
						'omsetChart',
						data.labels,
						data.series,
						data.user_ids || []
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering omset chart:', error);
			});
	}

	function updateBarHorizontalOmsetChart(chartId, labels, series, userIds) {
		var chartEl = document.getElementById(chartId);
		if (!chartEl) return;

		if (ApexCharts.getChartByID(chartId)) {
			ApexCharts.getChartByID(chartId).destroy();
		}
		chartEl.innerHTML = '';

		function formatRupiah(value) {
			if (value >= 1000000000)
				return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
			if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
			if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
			return 'Rp ' + value.toLocaleString('id-ID');
		}

		var calculatedHeight = Math.max(350, labels.length * 35 + 80);
		var colorPalette = [
			'#00cfe8',
			'#7367f0',
			'#ea5455',
			'#28c76f',
			'#ff9f43',
			'#9c8dff',
			'#87ceeb',
			'#f06292',
			'#4db6ac',
			'#ffb74d',
			'#ba68c8',
			'#64b5f6',
			'#81c784',
			'#e57373',
			'#ffd54f',
			'#90a4ae',
		];

		var chartConfig = {
			chart: {
				id: chartId,
				height: calculatedHeight,
				type: 'bar',
				toolbar: { show: false },
				events: {
					dataPointSelection: function (event, chartContext, config) {
						var selectedUserId = userIds[config.dataPointIndex];
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
					dataLabels: { position: 'bottom' },
				},
			},
			colors: colorPalette,
			dataLabels: {
				enabled: true,
				textAnchor: 'start',
				style: { colors: ['#fff'], fontSize: '12px', fontWeight: 500 },
				formatter: function (val) {
					return formatRupiah(val);
				},
				offsetX: 0,
				dropShadow: { enabled: false },
			},
			stroke: { width: 1, colors: ['#fff'] },
			xaxis: {
				categories: labels,
				labels: {
					style: { colors: '#6d788d', fontSize: '12px' },
					formatter: function (val) {
						if (val >= 1e9) return (val / 1e9).toFixed(1) + ' M';
						if (val >= 1e6) return (val / 1e6).toFixed(1) + ' Jt';
						if (val >= 1e3) return (val / 1e3).toFixed(1) + ' Rb';
						return val;
					},
				},
			},
			yaxis: {
				labels: {
					show: true,
					style: { colors: '#6d788d', fontSize: '11px' },
					maxWidth: 200,
				},
			},
			tooltip: {
				theme: 'dark',
				x: { show: true },
				y: {
					title: {
						formatter: function (sn, opts) {
							return opts.w.globals.labels[opts.dataPointIndex] + ':';
						},
					},
					formatter: function (val) {
						return formatRupiah(val);
					},
				},
			},
			legend: { show: false },
			grid: { borderColor: '#e5e7eb' },
			series: [{ name: 'Total Estimasi', data: series }],
		};

		var chart = new ApexCharts(chartEl, chartConfig);
		chart.render();
	}

	// Filter Prospek Marketing Chart
	function filterProspekMarketingChart(bulan, tahun, filterUserId) {
		const chartEl = document.getElementById('prospekMarketingChart');
		if (!chartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getProspekMarketingChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'prospekMarketingChart',
						data.labels,
						data.series,
						data.total_prospek,
						'Total Prospek'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering prospek marketing chart:', error);
			});
	}

	// Filter Client Marketing Chart
	function filterClientMarketingChart(bulan, tahun, filterUserId) {
		const chartEl = document.getElementById('clientMarketingChart');
		if (!chartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getClientMarketingChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'clientMarketingChart',
						data.labels,
						data.series,
						data.total_client,
						'Total Client'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering client marketing chart:', error);
			});
	}

	// Filter Lost Marketing Chart
	function filterLostMarketingChart(bulan, tahun, filterUserId) {
		const chartEl = document.getElementById('lostMarketingChart');
		if (!chartEl) return Promise.resolve();

		var bodyParams = buildBodyParams(bulan, tahun, filterUserId);
		if (!bodyParams) return Promise.resolve();

		return fetch(base_url + 'Dashboard/getLostMarketingChart', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: bodyParams,
		})
			.then((response) => response.json())
			.then((data) => {
				if (data.success) {
					updateDonutChart(
						'lostMarketingChart',
						data.labels,
						data.series,
						data.total_lost,
						'Total Lost'
					);
				}
			})
			.catch((error) => {
				console.error('Error filtering lost marketing chart:', error);
			});
	}
})();
