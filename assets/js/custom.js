(function () {
	'use strict';

	/* basic select2 */

	$('.select2RuanganAdd').select2({
		dropdownParent: $('#addRuangan'),
	});

	$('.select2RuanganEdit').select2({
		dropdownParent: $('#editRuangan'),
	});

	$('.select2BasicBed').select2({
		dropdownParent: $('#addBed'),
	});

	$('.select2BasicUser').select2({
		dropdownParent: $('#addUser'),
	});

	$('.select2BasicDokter').select2({
		dropdownParent: $('#addDokter'),
	});

	$('.select2SubKat').select2({
		dropdownParent: $('#addSubKategori'),
	});

	$('.select2JK').select2({
		dropdownParent: $('#addNilai'),
	});

	$('.select2Usia').select2({
		dropdownParent: $('#addNilai'),
	});

	$('.selectSample').select2({
		dropdownParent: $('#addAlat'),
	});

	$('.selectStatus').select2({
		dropdownParent: $('#addAlat'),
	});

	$('.selectCabang').select2({
		dropdownParent: $('#addCabang'),
	});

	$('.selectCabang').select2({
		dropdownParent: $('#addCabang'),
	});

	$('.selectKategori').select2({
		dropdownParent: $('#addItem'),
	});

	$('.selectSubKategori').select2({
		dropdownParent: $('#addItem'),
	});

	$('.selectSatuan').select2({
		dropdownParent: $('#addItem'),
	});

	$('.selectSample').select2({
		dropdownParent: $('#addItem'),
	});

	$('.selectInput').select2({
		dropdownParent: $('#addItem'),
	});

	$('.tipe_barang').select2();
	$('[data-toggle="select2"]').select2();

	$(document).ready(function () {
		// Inisialisasi Select2 untuk semua modal
		$('.modal').on('shown.bs.modal', function () {
			$(this)
				.find('.selectsubmenu')
				.select2({
					dropdownParent: $(this),
					width: '100%',
				});
		});

		// Bersihkan Select2 ketika modal ditutup
		$('.modal').on('hidden.bs.modal', function () {
			$(this).find('.selectsubmenu').select2('destroy');
		});
	});

	$.fn.DataTable.ext.pager.numbers_length = 5;

	var table = $('#general-datatable').DataTable({
		ordering: false,
		paging: true,
		pageLength: 10,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, 'All'],
		],
		pagingType: 'full_numbers',
		language: {
			paginate: {
				first: 'First',
				last: 'Last',
				previous: "<i class='ri-arrow-left-line ti-sm'></i>",
				next: "<i class='ri-arrow-right-line ti-sm'></i>",
			},
		},
	});
})();

!(function ($) {
	'use strict';

	function FormPickers() {
		this.init();
	}

	FormPickers.prototype.init = function () {
		this.initDatePickers();
	};

	FormPickers.prototype.initDatePickers = function () {
		$('#cari_tanggal').flatpickr({
			dateFormat: 'd M, Y',
			altInput: true,
			altFormat: 'Y-m-d',
			locale: this.getIndonesianLocale(),
			time_24hr: true,
		});

		$('#tanggal').flatpickr({
			mode: 'range',
			dateFormat: 'd M, Y',
			altInput: true,
			altFormat: 'Y-m-d',
			locale: this.getIndonesianLocale(),
			time_24hr: true,
			onChange: function (selectedDates, dateStr, instance) {
				if (selectedDates.length === 2) {
					const startDate = instance.formatDate(selectedDates[0], 'd M, Y');
					const endDate = instance.formatDate(selectedDates[1], 'd M, Y');
					instance.input.value = `${startDate} to ${endDate}`;
				}
			},
		});
	};

	FormPickers.prototype.getIndonesianLocale = function () {
		return {
			rangeSeparator: ' to ',
			firstDayOfWeek: 1,
			weekdays: {
				shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
				longhand: [
					'Minggu',
					'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
				],
			},
			months: {
				shorthand: [
					'Jan',
					'Feb',
					'Mar',
					'Apr',
					'Mei',
					'Jun',
					'Jul',
					'Ags',
					'Sep',
					'Okt',
					'Nov',
					'Des',
				],
				longhand: [
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
			},
		};
	};

	$.FormPickers = new FormPickers();
})(window.jQuery);

$(document).ready(function () {
	if (window.jQuery && window.jQuery.FormPickers) {
		window.jQuery.FormPickers.init();
	}
});

!(function (t) {
	'use strict';
	function e() {}
	(e.prototype.init = function () {
		t('#tgl_terima').flatpickr();
		t('#tgl_kadaluarsa').flatpickr();
		t('#tgl_lahir').flatpickr();
	}),
		(t.FormPickers = new e()),
		(t.FormPickers.Constructor = e);
})(window.jQuery),
	(function () {
		'use strict';
		window.jQuery.FormPickers.init();
	})();

$(document).ready(function () {
	$('[data-toggle="select2"]').select2({
		width: '100%',
	});
	$('.select2').select2({
		width: '100%',
	});

	if (typeof Choices !== 'undefined') {
		document.querySelectorAll('[data-choices]').forEach(function (element) {
			if (!element.classList.contains('choices__input')) {
				new Choices(element, {
					removeItemButton: true,
					searchEnabled: true,
					placeholder: true,
					placeholderValue: element.getAttribute('placeholder') || 'Pilih...',
					searchPlaceholderValue: 'Cari...',
					noResultsText: 'Tidak ada hasil',
					noChoicesText: 'Tidak ada pilihan',
					itemSelectText: 'Klik untuk memilih',
				});
			}
		});
	}

	$('.modal').on('shown.bs.modal', function () {
		$(this)
			.find('[data-toggle="select2"]')
			.select2({
				dropdownParent: $(this),
				width: '100%',
			});
		$(this)
			.find('.select2')
			.select2({
				dropdownParent: $(this),
				width: '100%',
			});
	});
});
