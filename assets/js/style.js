$(document).ready(function () {
	$('#table-projek-setting').DataTable();
});
!(function (t) {
	'use strict';
	function e() {}
	(e.prototype.init = function () {
		t('#tgl_terima').flatpickr();
		t('#tgl_crosseling').flatpickr();
		t('#tgl_kadaluarsa').flatpickr();
		t('#tgl_lahir').flatpickr();
		t('#edit_tgl_lahir').flatpickr();
		t('#hut_client').flatpickr();
		t('#hut_pic').flatpickr();
		t('#edit_hut_client').flatpickr();
		t('#edit_hut_pic').flatpickr();
		t('#tgl_awal').flatpickr();
		t('#tgl_pelaksanaan').flatpickr();
		t('#edit_tgl_pelaksanaan').flatpickr();
		t('#tgl_mulai').flatpickr();
		t('#tgl_selesai').flatpickr();
		t('#tgl_respon').flatpickr();
		t('#edit_tgl_selesai').flatpickr();
		t('#tgl_gift').flatpickr();
		t('#tgl_konsul').flatpickr();
		t('#add_tgl_gift').flatpickr();
		t('#tgl_benefit_mulai').flatpickr();
		t('#tgl_benefit_selesai').flatpickr();
		t('#tgl_awal').flatpickr();
		t('#tgl_akhir').flatpickr();
		t('#periode').flatpickr();
		t('#add_hut_pic').flatpickr();
		t('#edit_hut_pic').flatpickr();
		t('#tgl_project').flatpickr();
	}),
		(t.FormPickers = new e()),
		(t.FormPickers.Constructor = e);
})(window.jQuery),
	(function () {
		'use strict';
		window.jQuery.FormPickers.init();
	})();

$(document).ready(function () {
	if ($('#client_id').length && typeof $.fn.select2 !== 'undefined') {
		$('#client_id').select2({
			placeholder: 'Pilih Client',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#project').length && typeof $.fn.select2 !== 'undefined') {
		$('#project').select2({
			placeholder: 'Pilih Project',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#marketing_id').length && typeof $.fn.select2 !== 'undefined') {
		$('#marketing_id').select2({
			placeholder: 'Pilih Marketing',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#filter_user_id').length && typeof $.fn.select2 !== 'undefined') {
		$('#filter_user_id').select2({
			placeholder: '-- Semua Marketing --',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#filter_client_id').length && typeof $.fn.select2 !== 'undefined') {
		$('#filter_client_id').select2({
			placeholder: '-- Semua Client --',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#filter_karyawan').length && typeof $.fn.select2 !== 'undefined') {
		$('#filter_karyawan').select2({
			placeholder: '-- Semua Marketing --',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#user_id').length && typeof $.fn.select2 !== 'undefined') {
		$('#user_id').select2({
			placeholder: '-- Semua Marketing --',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}

	if ($('#jobdesk').length && typeof $.fn.select2 !== 'undefined') {
		$('#jobdesk').select2({
			placeholder: 'Pilih Jobdesk',
			allowClear: true,
			width: '100%',
			theme: 'bootstrap-5',
		});
	}
});

$(function () {
	var bsDatepickerBasic = $('#bs-datepicker-basic'),
		bsDatepickerFormat = $('#bs-datepicker-format'),
		bsDatepickerRange = $('#bs-datepicker-daterange'),
		bsDatepickerDisabledDays = $('#bs-datepicker-disabled-days'),
		bsDatepickerMultidate = $('#bs-datepicker-multidate'),
		bsDatepickerOptions = $('#bs-datepicker-options'),
		bsDatepickerAutoclose = $('#bs-datepicker-autoclose'),
		bsDatepickerInlinedate = $('#bs-datepicker-inline');

	if (bsDatepickerBasic.length) {
		bsDatepickerBasic.datepicker({
			todayHighlight: true,
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerFormat.length) {
		bsDatepickerFormat.datepicker({
			todayHighlight: true,
			format: 'dd/mm/yyyy',
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerRange.length) {
		bsDatepickerRange.datepicker({
			todayHighlight: true,
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerDisabledDays.length) {
		bsDatepickerDisabledDays.datepicker({
			todayHighlight: true,
			daysOfWeekDisabled: [0, 6],
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerMultidate.length) {
		bsDatepickerMultidate.datepicker({
			multidate: true,
			todayHighlight: true,
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerOptions.length) {
		bsDatepickerOptions.datepicker({
			calendarWeeks: true,
			clearBtn: true,
			todayHighlight: true,
			orientation: isRtl ? 'auto left' : 'auto right',
		});
	}

	if (bsDatepickerAutoclose.length) {
		bsDatepickerAutoclose.datepicker({
			todayHighlight: true,
			autoclose: true,
			orientation: isRtl ? 'auto right' : 'auto left',
		});
	}

	if (bsDatepickerInlinedate.length) {
		bsDatepickerInlinedate.datepicker({
			todayHighlight: true,
		});
	}

	var bsRangePickerBasic = $('#bs-rangepicker-basic'),
		bsRangePickerSingle = $('#bs-rangepicker-single'),
		bsRangePickerTime = $('#bs-rangepicker-time'),
		bsRangePickerRange = $('#bs-rangepicker-range'),
		bsRangePickerWeekNum = $('#bs-rangepicker-week-num'),
		bsRangePickerDropdown = $('#bs-rangepicker-dropdown'),
		bsRangePickerCancelBtn = document.getElementsByClassName('cancelBtn');

	if (bsRangePickerBasic.length) {
		bsRangePickerBasic.daterangepicker({
			opens: isRtl ? 'left' : 'right',
		});
	}

	if (bsRangePickerSingle.length) {
		bsRangePickerSingle.daterangepicker({
			singleDatePicker: true,
			opens: isRtl ? 'left' : 'right',
		});
	}

	if (bsRangePickerTime.length) {
		bsRangePickerTime.daterangepicker({
			timePicker: true,
			timePickerIncrement: 30,
			locale: {
				format: 'MM/DD/YYYY h:mm A',
			},
			opens: isRtl ? 'left' : 'right',
		});
	}

	if (bsRangePickerRange.length) {
		bsRangePickerRange.daterangepicker({
			ranges: {
				Today: [moment(), moment()],
				Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [
					moment().subtract(1, 'month').startOf('month'),
					moment().subtract(1, 'month').endOf('month'),
				],
			},
			opens: isRtl ? 'left' : 'right',
		});
	}

	if (bsRangePickerWeekNum.length) {
		bsRangePickerWeekNum.daterangepicker({
			showWeekNumbers: true,
			opens: isRtl ? 'left' : 'right',
		});
	}

	if (bsRangePickerDropdown.length) {
		bsRangePickerDropdown.daterangepicker({
			showDropdowns: true,
			opens: isRtl ? 'left' : 'right',
			locale: {
				format: 'YYYY-MM-DD',
			},
		});
	}
	for (var i = 0; i < bsRangePickerCancelBtn.length; i++) {
		bsRangePickerCancelBtn[i].classList.remove('btn-default');
		bsRangePickerCancelBtn[i].classList.add('btn-label-primary');
	}
});
document.getElementById('hut-pic') &&
	document.getElementById('hut-pic').addEventListener('click', function () {
		Swal.fire({
			html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Well done !</h4><p class="text-muted mx-4 mb-0">Aww yeah, you successfully read this important message.</p></div></div>',
			showCancelButton: !0,
			showConfirmButton: !1,
			cancelButtonClass: 'btn btn-primary w-xs mb-1',
			cancelButtonText: 'Back',
			buttonsStyling: !1,
			showCloseButton: !0,
		});
	});
