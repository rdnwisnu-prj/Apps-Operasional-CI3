$(document).ready(function () {
	$('#table-projek-setting').DataTable();
});
!(function (t) {
	'use strict';
	function e() {}
	(e.prototype.init = function () {
		t('#tgl_terima').flatpickr();
		t('#tgl_maintenance').flatpickr();
		t('#tgl_kalibrasi').flatpickr();
		t('#tgl_next_kalibrasi').flatpickr();
		t('#tgl_start_req').flatpickr();
		t('#tgl_end_req').flatpickr();
		t('#tgl_lahir').flatpickr();
		t('#tgl_aktifitas').flatpickr();
		t('#tgl_inspeksi').flatpickr();
		t('#tgl_inspeksi_saran').flatpickr();
		t('#tgl_inspeksi_kendaraan').flatpickr();
		t('#tgl_keluar').flatpickr();
		t('#deadline').flatpickr();
		t('#tgl_project').flatpickr();
		t('#jam_aktifitas').flatpickr({
			enableTime: true,
			noCalendar: true,
			dateFormat: 'H:i',
			time_24hr: true,
		});
		t('#jam_pemakaian').flatpickr({
			enableTime: true,
			noCalendar: true,
			dateFormat: 'H:i',
			time_24hr: true,
		});
		t('#jam_kembali').flatpickr({
			enableTime: true,
			noCalendar: true,
			dateFormat: 'H:i',
			time_24hr: true,
		});
		t('#tahun').flatpickr({
			enableTime: true,
			noCalendar: true,
			dateFormat: 'Y',
		});
	}),
		(t.FormPickers = new e()),
		(t.FormPickers.Constructor = e);
})(window.jQuery),
	(function () {
		'use strict';
		window.jQuery.FormPickers.init();
	})();
