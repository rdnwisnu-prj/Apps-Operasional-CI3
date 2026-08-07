var start_date = document.getElementById('event-start-date'),
	timepicker1 = document.getElementById('timepicker1'),
	timepicker2 = document.getElementById('timepicker2'),
	date_range = null,
	T_check = null;

function flatPickrInit() {
	var timeConfig = { enableTime: true, noCalendar: true, time_24hr: true };

	if (start_date && !start_date._flatpickr) {
		flatpickr(start_date, {
			enableTime: false,
			mode: 'range',
			dateFormat: 'Y-m-d',
			onChange: function (selectedDates, dateStr, instance) {
				if (selectedDates.length > 1) {
					document.getElementById('event-time').setAttribute('hidden', true);
				} else {
					document.getElementById('event-time').removeAttribute('hidden');
					document
						.getElementById('timepicker1')
						.parentNode.classList.remove('d-none');
					document
						.getElementById('timepicker1')
						.classList.replace('d-none', 'd-block');
					document
						.getElementById('timepicker2')
						.parentNode.classList.remove('d-none');
					document
						.getElementById('timepicker2')
						.classList.replace('d-none', 'd-block');
				}
			},
		});
	}

	if (timepicker1 && !timepicker1._flatpickr) {
		flatpickr(timepicker1, timeConfig);
	}
	if (timepicker2 && !timepicker2._flatpickr) {
		flatpickr(timepicker2, timeConfig);
	}
}

function flatpicekrValueClear() {
	if (start_date && start_date._flatpickr) start_date._flatpickr.clear();
	if (timepicker1 && timepicker1._flatpickr) timepicker1._flatpickr.clear();
	if (timepicker2 && timepicker2._flatpickr) timepicker2._flatpickr.clear();
}

function eventClicked() {
	document.getElementById('form-event').classList.add('view-event');
	document.getElementById('event-title').classList.replace('d-block', 'd-none');
	document
		.getElementById('event-category')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-start-date')
		.parentNode.classList.add('d-none');
	document
		.getElementById('event-start-date')
		.classList.replace('d-block', 'd-none');
	document.getElementById('event-time').setAttribute('hidden', true);
	document.getElementById('timepicker1').parentNode.classList.add('d-none');
	document.getElementById('timepicker1').classList.replace('d-block', 'd-none');
	document.getElementById('timepicker2').parentNode.classList.add('d-none');
	document.getElementById('timepicker2').classList.replace('d-block', 'd-none');
	document
		.getElementById('event-location')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-description')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-start-date-tag')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-timepicker1-tag')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-timepicker2-tag')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-location-tag')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-description-tag')
		.classList.replace('d-none', 'd-block');
	document.getElementById('btn-save-event').setAttribute('hidden', true);

	// Hide event-form labels when in view mode
	document.querySelectorAll('.event-form .form-label').forEach(function (el) {
		el.style.display = 'none';
	});
	document.querySelectorAll('.event-form label').forEach(function (el) {
		el.style.display = 'none';
	});
}

function editEvent(e) {
	var t = e.getAttribute('data-id');
	if (t === 'new-event') {
		document.getElementById('modal-title').innerHTML = 'Add Event';
		document.getElementById('btn-save-event').innerHTML = 'Add Event';
		eventTyped();
	} else if (t === 'edit-event') {
		e.innerHTML = 'Cancel';
		e.setAttribute('data-id', 'cancel-event');
		document.getElementById('btn-save-event').innerHTML = 'Update Event';
		e.removeAttribute('hidden');
		eventTyped();
	} else {
		e.innerHTML = 'Edit';
		e.setAttribute('data-id', 'edit-event');
		eventClicked();
	}
}

function eventTyped() {
	document.getElementById('form-event').classList.remove('view-event');
	document.getElementById('event-title').classList.replace('d-none', 'd-block');
	document
		.getElementById('event-category')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-start-date')
		.parentNode.classList.remove('d-none');
	document
		.getElementById('event-start-date')
		.classList.replace('d-none', 'd-block');
	document.getElementById('timepicker1').parentNode.classList.remove('d-none');
	document.getElementById('timepicker1').classList.replace('d-none', 'd-block');
	document.getElementById('timepicker2').parentNode.classList.remove('d-none');
	document.getElementById('timepicker2').classList.replace('d-none', 'd-block');
	document
		.getElementById('event-location')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-description')
		.classList.replace('d-none', 'd-block');
	document
		.getElementById('event-start-date-tag')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-timepicker1-tag')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-timepicker2-tag')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-location-tag')
		.classList.replace('d-block', 'd-none');
	document
		.getElementById('event-description-tag')
		.classList.replace('d-block', 'd-none');
	document.getElementById('btn-save-event').removeAttribute('hidden');
	document.getElementById('event-time').removeAttribute('hidden');

	// Show event-form labels when in edit mode
	document.querySelectorAll('.event-form .form-label').forEach(function (el) {
		el.style.display = '';
	});
	document.querySelectorAll('.event-form label').forEach(function (el) {
		el.style.display = '';
	});
}

function getTime(e) {
	if (e) {
		var date = new Date(e);
		if (!isNaN(date.getTime())) {
			return (
				String(date.getHours()).padStart(2, '0') +
				':' +
				String(date.getMinutes()).padStart(2, '0')
			);
		}
	}
	return '00:00';
}

function tConvert(timeStr) {
	if (!timeStr) return '';
	var parts = timeStr.split(':');
	var hours = parseInt(parts[0], 10);
	var minutes = parts[1] || '00';
	var ampm = hours >= 12 ? 'PM' : 'AM';
	hours = hours % 12 || 12;
	return (
		hours +
		':' +
		(parseInt(minutes) < 10 ? '0' + parseInt(minutes) : minutes) +
		' ' +
		ampm
	);
}

var calendarInstance = null;
var eventsArray = [];

function showSuccessAlert(message) {
	Swal.fire({
		icon: 'success',
		title: 'Berhasil',
		text: message,
		timer: 2000,
		showConfirmButton: false,
	});
}

function showErrorAlert(message) {
	Swal.fire({
		icon: 'error',
		title: 'Error',
		text: message,
	});
}

function loadEventsFromServer() {
	$.ajax({
		url: base_url + 'Event/getEvents',
		type: 'POST',
		dataType: 'json',
		success: function (events) {
			if (calendarInstance) {
				calendarInstance.removeAllEvents();
				if (Array.isArray(events) && events.length > 0) {
					events.forEach(function (event) {
						calendarInstance.addEvent({
							id: event.id,
							title: event.title,
							start: event.start,
							end: event.end,
							allDay: event.allDay || false,
							className: event.classNames || ['bg-soft-info'],
							extendedProps: {
								description: event.extendedProps
									? event.extendedProps.description
									: '',
								location: event.extendedProps
									? event.extendedProps.location
									: '',
								created_by: event.extendedProps
									? event.extendedProps.created_by
									: 'Unknown',
								waktu_mulai: event.extendedProps
									? event.extendedProps.waktu_mulai
									: '',
								waktu_selesai: event.extendedProps
									? event.extendedProps.waktu_selesai
									: '',
							},
						});
					});
					eventsArray = events;
				}
			}
		},
		error: function (xhr, status, error) {
			console.log('Error loading events:', error, xhr);
		},
	});
}

document.addEventListener('DOMContentLoaded', function () {
	// Check if calendar element exists on this page
	var calendarEl = document.getElementById('calendar');
	if (!calendarEl) {
		return;
	}

	flatPickrInit();

	var modalElement = new bootstrap.Modal(
		document.getElementById('event-modal'),
		{
			keyboard: false,
		}
	);

	var modalTitle = document.getElementById('modal-title');
	var formEvent = document.getElementById('form-event');
	var currentEvent = null;
	var eventCategorySelect = document.getElementById('event-category');

	function r() {
		return 768 <= window.innerWidth && window.innerWidth < 1200
			? 'timeGridWeek'
			: window.innerWidth <= 768
				? 'listMonth'
				: 'dayGridMonth';
	}

	calendarInstance = new FullCalendar.Calendar(calendarEl, {
		timeZone: 'local',
		editable: true,
		droppable: true,
		selectable: true,
		navLinks: true,
		initialView: r(),
		themeSystem: 'bootstrap',
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
		},
		windowResize: function () {
			calendarInstance.changeView(r());
		},
		eventClick: function (info) {
			currentEvent = info.event;

			document.getElementById('edit-event-btn').removeAttribute('hidden');
			document.getElementById('btn-save-event').setAttribute('hidden', '');
			document
				.getElementById('edit-event-btn')
				.setAttribute('data-id', 'edit-event');
			document.getElementById('edit-event-btn').innerHTML = 'Edit';

			eventClicked();
			modalElement.show();

			modalTitle.innerText = currentEvent.title;

			// Set detail view values
			document.getElementById('event-location-tag').innerHTML =
				currentEvent.extendedProps.location || '-';
			document.getElementById('event-description-tag').innerHTML =
				currentEvent.extendedProps.description || '-';
			document.getElementById('event-createdby-tag').innerHTML =
				currentEvent.extendedProps.created_by || 'Unknown';

			// Set form values for editing
			document.getElementById('event-title').value = currentEvent.title;
			document.getElementById('event-location').value =
				currentEvent.extendedProps.location || '';
			document.getElementById('event-description').value =
				currentEvent.extendedProps.description || '';
			document.getElementById('eventid').value = currentEvent.id;

			if (currentEvent.classNames && currentEvent.classNames[0]) {
				eventCategorySelect.value = currentEvent.classNames[0];
			}

			var startDate = new Date(currentEvent.start);
			var endDate = currentEvent.end ? new Date(currentEvent.end) : null;

			// Format date for display
			var dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
			var dateStr = startDate.toLocaleDateString('id-ID', dateOptions);
			if (endDate && endDate.getTime() !== startDate.getTime()) {
				dateStr += ' - ' + endDate.toLocaleDateString('id-ID', dateOptions);
			}
			document.getElementById('event-start-date-tag').innerHTML = dateStr;

			// Format time for display
			var startTime = getTime(currentEvent.start);
			var endTime = endDate ? getTime(currentEvent.end) : startTime;
			document.getElementById('event-timepicker1-tag').innerHTML =
				tConvert(startTime);
			document.getElementById('event-timepicker2-tag').innerHTML =
				tConvert(endTime);

			// Set flatpickr values for editing
			if (start_date && start_date._flatpickr) {
				if (endDate) {
					start_date._flatpickr.setDate([startDate, endDate]);
				} else {
					start_date._flatpickr.setDate(startDate);
				}
			}
			if (timepicker1 && timepicker1._flatpickr) {
				timepicker1._flatpickr.setDate(startTime, true);
			}
			if (timepicker2 && timepicker2._flatpickr) {
				timepicker2._flatpickr.setDate(endTime, true);
			}

			document.getElementById('btn-delete-event').removeAttribute('hidden');
		},
		dateClick: function (info) {
			openNewEventModal(info.dateStr);
		},
		events: function (info, successCallback, failureCallback) {
			successCallback(eventsArray);
		},
	});

	calendarInstance.render();
	loadEventsFromServer();

	formEvent.addEventListener('submit', function (e) {
		e.preventDefault();

		var title = document.getElementById('event-title').value;
		var category = document.getElementById('event-category').value;
		var startDateStr = document.getElementById('event-start-date').value;
		var location = document.getElementById('event-location').value;
		var description = document.getElementById('event-description').value;
		var eventid = document.getElementById('eventid').value;
		var startTime = document.getElementById('timepicker1').value.trim();
		var endTime = document.getElementById('timepicker2').value.trim();

		var dateParts = startDateStr.split(' to ');
		var startDate = dateParts[0] ? dateParts[0].trim() : '';
		var endDate = dateParts[1] ? dateParts[1].trim() : startDate;

		var isDateRange =
			dateParts.length > 1 && dateParts[1] && dateParts[1].trim() !== '';

		if (!title || !category || !startDate) {
			showErrorAlert('Mohon isi semua field yang diperlukan');
			return;
		}

		if (!isDateRange && (!startTime || !endTime)) {
			showErrorAlert('Mohon isi waktu mulai dan waktu selesai');
			return;
		}

		var ajaxData = {
			title: title,
			category: category,
			start_date: startDate,
			end_date: endDate,
			start_time: startTime || '00:00',
			end_time: endTime || '23:59',
			location: location,
			description: description,
			is_range: isDateRange ? '1' : '0',
			eventid: eventid,
		};

		$.ajax({
			url: base_url + 'Event/add',
			type: 'POST',
			data: ajaxData,
			dataType: 'json',
			success: function (response) {
				if (response.success) {
					showSuccessAlert(response.message);
					loadEventsFromServer();
					modalElement.hide();
					formEvent.reset();
					document.getElementById('eventid').value = '';
					flatpicekrValueClear();
				} else {
					showErrorAlert(response.message || 'Gagal menyimpan kegiatan');
				}
			},
			error: function (xhr, status, error) {
				console.log('Error:', error);
				showErrorAlert('Terjadi kesalahan server');
			},
		});
	});

	document
		.getElementById('btn-delete-event')
		.addEventListener('click', function () {
			var eventid = document.getElementById('eventid').value;

			if (!eventid) {
				showErrorAlert('ID Event tidak ditemukan');
				return;
			}

			Swal.fire({
				title: 'Hapus Event?',
				text: 'Apakah Anda yakin ingin menghapus kegiatan ini?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonText: 'Batal',
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: base_url + 'Event/delete/' + eventid,
						type: 'POST',
						dataType: 'json',
						success: function (response) {
							if (response.success) {
								showSuccessAlert(response.message);
								loadEventsFromServer();
								modalElement.hide();
							} else {
								showErrorAlert(response.message || 'Gagal menghapus kegiatan');
							}
						},
						error: function () {
							showErrorAlert('Terjadi kesalahan server');
						},
					});
				}
			});
		});

	document
		.getElementById('btn-new-event')
		.addEventListener('click', function () {
			openNewEventModal();
		});

	var btnHeaderNewEvent = document.getElementById('btn-header-new-event');
	if (btnHeaderNewEvent) {
		btnHeaderNewEvent.addEventListener('click', function () {
			openNewEventModal();
		});
	}

	function openNewEventModal(dateStr) {
		flatpicekrValueClear();

		formEvent.reset();
		document.getElementById('btn-delete-event').setAttribute('hidden', '');
		document.getElementById('eventid').value = '';
		eventCategorySelect.value = '';

		if (dateStr && start_date && start_date._flatpickr) {
			start_date._flatpickr.setDate(dateStr);
		}

		modalElement.show();
		formEvent.classList.remove('was-validated');

		currentEvent = null;
		modalTitle.innerText = 'Add Event';

		document
			.getElementById('edit-event-btn')
			.setAttribute('data-id', 'new-event');
		document.getElementById('edit-event-btn').click();
		document.getElementById('edit-event-btn').setAttribute('hidden', '');
	}
});
