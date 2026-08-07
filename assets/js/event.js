var calendarInstance = null;
var eventsArray = [];
var currentEventData = null;

var modalAddEvent = null;
var modalDetailEvent = null;
var modalEditEvent = null;

var addDatePicker = null;
var addTimePicker1 = null;
var addTimePicker2 = null;
var editDatePicker = null;
var editTimePicker1 = null;
var editTimePicker2 = null;

var categoryColors = {
	'bg-soft-info': '#d1ecf1',
	'bg-soft-dark': '#d3d3d4',
	'bg-soft-secondary': '#e2e3e5',
	'bg-soft-danger': '#f8d7da',
	'bg-soft-success': '#d1e7dd',
	'bg-soft-blue': '#cfe2ff',
	'bg-soft-cakra': '#e2d9f3',
};

var categoryTextColors = {
	'bg-soft-info': '#0c5460',
	'bg-soft-dark': '#1a1a1a',
	'bg-soft-secondary': '#383d41',
	'bg-soft-danger': '#721c24',
	'bg-soft-success': '#155724',
	'bg-soft-blue': '#004085',
	'bg-soft-cakra': '#4a1d91',
};

var categoryBorderColors = {
	'bg-soft-info': '#0dcaf0',
	'bg-soft-dark': '#212529',
	'bg-soft-secondary': '#6c757d',
	'bg-soft-danger': '#dc3545',
	'bg-soft-success': '#198754',
	'bg-soft-blue': '#0d6efd',
	'bg-soft-cakra': '#6f42c1',
};

// Map category class to display name
var categoryNames = {
	'bg-soft-info': 'Visit Client',
	'bg-soft-dark': 'Meeting Online',
	'bg-soft-secondary': 'TM External',
	'bg-soft-danger': 'TM Internal',
	'bg-soft-success': 'Presentasi / Meeting Bidding',
	'bg-soft-blue': 'Entertainment Client',
	'bg-soft-cakra': 'Lain - lain',
};

function getCategoryName(category) {
	return categoryNames[category] || 'Tidak diketahui';
}

function getCategoryColor(category) {
	return categoryColors[category] || '#d1ecf1';
}

function getCategoryTextColor(category) {
	return categoryTextColors[category] || '#0c5460';
}

function getCategoryBorderColor(category) {
	return categoryBorderColors[category] || '#0dcaf0';
}

function initFlatpickr() {
	var timeConfig = {
		enableTime: true,
		noCalendar: true,
		time_24hr: true,
		minuteIncrement: 15,
		defaultHour: 9,
		defaultMinute: 0,
	};
	var dateConfig = {
		enableTime: false,
		mode: 'range',
		dateFormat: 'Y-m-d',
		onClose: function (selectedDates, dateStr, instance) {
			var timeContainer = instance.element
				.closest('.modal')
				.querySelector('[id$="-event-time"]');
			if (timeContainer) {
				if (dateStr.indexOf(' to ') !== -1) {
					timeContainer.style.display = 'none';
				} else {
					timeContainer.style.display = 'block';
				}
			}
		},
	};

	var addStartDate = document.getElementById('add-event-start-date');
	if (addStartDate && !addStartDate._flatpickr) {
		addDatePicker = flatpickr(addStartDate, dateConfig);
	}
	var addTime1 = document.getElementById('add-timepicker1');
	if (addTime1 && !addTime1._flatpickr) {
		addTimePicker1 = flatpickr(addTime1, timeConfig);
	}
	var addTime2 = document.getElementById('add-timepicker2');
	if (addTime2 && !addTime2._flatpickr) {
		addTimePicker2 = flatpickr(addTime2, timeConfig);
	}

	var editStartDate = document.getElementById('edit-event-start-date');
	if (editStartDate && !editStartDate._flatpickr) {
		editDatePicker = flatpickr(editStartDate, dateConfig);
	}
	var editTime1 = document.getElementById('edit-timepicker1');
	if (editTime1 && !editTime1._flatpickr) {
		editTimePicker1 = flatpickr(editTime1, timeConfig);
	}
	var editTime2 = document.getElementById('edit-timepicker2');
	if (editTime2 && !editTime2._flatpickr) {
		editTimePicker2 = flatpickr(editTime2, timeConfig);
	}
}

function clearAddForm() {
	var form = document.getElementById('form-add-event');
	if (form) form.reset();
	if (addDatePicker) addDatePicker.clear();
	if (addTimePicker1) addTimePicker1.clear();
	if (addTimePicker2) addTimePicker2.clear();
	var timeContainer = document.getElementById('add-event-time');
	if (timeContainer) timeContainer.style.display = 'block';
}

function clearEditForm() {
	var form = document.getElementById('form-edit-event');
	if (form) form.reset();
	document.getElementById('edit-eventid').value = '';
	if (editDatePicker) editDatePicker.clear();
	if (editTimePicker1) editTimePicker1.clear();
	if (editTimePicker2) editTimePicker2.clear();
	var timeContainer = document.getElementById('edit-event-time');
	if (timeContainer) timeContainer.style.display = 'block';
}

function getTime(dateInput) {
	if (dateInput) {
		var date = new Date(dateInput);
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

function formatTime12h(timeStr) {
	if (!timeStr) return '-';
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
						var eventCategory = event.classNames
							? event.classNames[0]
							: 'bg-soft-info';
						calendarInstance.addEvent({
							id: event.id,
							title: event.title,
							start: event.start,
							end: event.end,
							allDay: event.allDay || false,
							className: event.classNames || ['bg-soft-info'],
							backgroundColor: getCategoryColor(eventCategory),
							borderColor: getCategoryBorderColor(eventCategory),
							textColor: getCategoryTextColor(eventCategory),
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
								category: eventCategory,
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

function openAddModal(dateStr) {
	clearAddForm();
	if (dateStr && addDatePicker) {
		addDatePicker.setDate(dateStr);
	}
	modalAddEvent.show();
}

function openDetailModal(event) {
	currentEventData = event;
	document.getElementById('detail-modal-title').innerText = event.title;
	var startDate = new Date(event.start);
	var endDate = event.end ? new Date(event.end) : null;
	if (event.allDay && endDate) {
		endDate = new Date(endDate.getTime() - 24 * 60 * 60 * 1000);
	}

	var dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
	var dateStr = startDate.toLocaleDateString('id-ID', dateOptions);
	if (endDate && endDate.getTime() !== startDate.getTime()) {
		dateStr += ' - ' + endDate.toLocaleDateString('id-ID', dateOptions);
	}
	document.getElementById('detail-event-date').innerText = dateStr;

	var startTime = getTime(event.start);
	var endTime = endDate ? getTime(event.end) : startTime;
	document.getElementById('detail-event-time-start').innerText =
		formatTime12h(startTime);
	document.getElementById('detail-event-time-end').innerText =
		formatTime12h(endTime);

	var category = event.extendedProps.category || '';
	var categoryBadge = document.getElementById('detail-event-category');
	categoryBadge.innerText = getCategoryName(category);
	categoryBadge.style.backgroundColor = getCategoryColor(category);
	categoryBadge.style.color = getCategoryTextColor(category);
	categoryBadge.style.border = '2px solid ' + getCategoryBorderColor(category);

	document.getElementById('detail-event-location').innerText =
		event.extendedProps.location || '-';
	document.getElementById('detail-event-description').innerText =
		event.extendedProps.description || '-';
	document.getElementById('detail-event-createdby').innerText =
		event.extendedProps.created_by || 'Unknown';
	document.getElementById('detail-eventid').value = event.id;

	modalDetailEvent.show();
}

function openEditModal() {
	if (!currentEventData) return;

	modalDetailEvent.hide();
	document.getElementById('edit-eventid').value = currentEventData.id;
	document.getElementById('edit-event-title').value = currentEventData.title;
	document.getElementById('edit-event-location').value =
		currentEventData.extendedProps.location || '';
	document.getElementById('edit-event-description').value =
		currentEventData.extendedProps.description || '';
	var category = currentEventData.classNames
		? currentEventData.classNames[0]
		: '';
	document.getElementById('edit-event-category').value = category;

	var startDate = new Date(currentEventData.start);
	var endDate = currentEventData.end ? new Date(currentEventData.end) : null;

	if (editDatePicker) {
		if (endDate && endDate.getTime() !== startDate.getTime()) {
			editDatePicker.setDate([startDate, endDate]);
			document.getElementById('edit-event-time').style.display = 'none';
		} else {
			editDatePicker.setDate(startDate);
			document.getElementById('edit-event-time').style.display = 'block';
		}
	}

	var startTime = getTime(currentEventData.start);
	var endTime = endDate ? getTime(currentEventData.end) : startTime;

	if (editTimePicker1) editTimePicker1.setDate(startTime, true);
	if (editTimePicker2) editTimePicker2.setDate(endTime, true);

	setTimeout(function () {
		modalEditEvent.show();
	}, 300);
}

function submitAddEvent(e) {
	e.preventDefault();

	var title = document.getElementById('add-event-title').value;
	var category = document.getElementById('add-event-category').value;
	var startDateStr = document.getElementById('add-event-start-date').value;
	var location = document.getElementById('add-event-location').value;
	var description = document.getElementById('add-event-description').value;
	var startTime = document.getElementById('add-timepicker1').value.trim();
	var endTime = document.getElementById('add-timepicker2').value.trim();

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
		eventid: '',
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
				modalAddEvent.hide();
				clearAddForm();
			} else {
				showErrorAlert(response.message || 'Gagal menyimpan kegiatan');
			}
		},
		error: function (xhr, status, error) {
			console.log('Error:', error);
			showErrorAlert('Terjadi kesalahan server');
		},
	});
}

function submitEditEvent(e) {
	e.preventDefault();

	var eventid = document.getElementById('edit-eventid').value;
	var title = document.getElementById('edit-event-title').value;
	var category = document.getElementById('edit-event-category').value;
	var startDateStr = document.getElementById('edit-event-start-date').value;
	var location = document.getElementById('edit-event-location').value;
	var description = document.getElementById('edit-event-description').value;
	var startTime = document.getElementById('edit-timepicker1').value.trim();
	var endTime = document.getElementById('edit-timepicker2').value.trim();

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
				modalEditEvent.hide();
				clearEditForm();
			} else {
				showErrorAlert(response.message || 'Gagal mengupdate kegiatan');
			}
		},
		error: function (xhr, status, error) {
			console.log('Error:', error);
			showErrorAlert('Terjadi kesalahan server');
		},
	});
}

function deleteEvent() {
	var eventid = document.getElementById('detail-eventid').value;

	if (!eventid) {
		showErrorAlert('ID Event tidak ditemukan');
		return;
	}

	Swal.fire({
		title: 'Hapus Kegiatan?',
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
						modalDetailEvent.hide();
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
}

document.addEventListener('DOMContentLoaded', function () {
	var calendarEl = document.getElementById('calendar');
	if (!calendarEl) return;

	// Initialize modals
	var modalAddEl = document.getElementById('modal-add-event');
	var modalDetailEl = document.getElementById('modal-detail-event');
	var modalEditEl = document.getElementById('modal-edit-event');

	if (modalAddEl)
		modalAddEvent = new bootstrap.Modal(modalAddEl, { keyboard: false });
	if (modalDetailEl)
		modalDetailEvent = new bootstrap.Modal(modalDetailEl, { keyboard: false });
	if (modalEditEl)
		modalEditEvent = new bootstrap.Modal(modalEditEl, { keyboard: false });

	// Initialize flatpickr
	initFlatpickr();

	// Responsive view helper
	function getResponsiveView() {
		return 768 <= window.innerWidth && window.innerWidth < 1200
			? 'timeGridWeek'
			: window.innerWidth <= 768
				? 'listMonth'
				: 'dayGridMonth';
	}

	// Initialize calendar
	calendarInstance = new FullCalendar.Calendar(calendarEl, {
		timeZone: 'local',
		editable: true,
		droppable: true,
		selectable: true,
		navLinks: true,
		initialView: getResponsiveView(),
		themeSystem: 'bootstrap',
		height: 'auto',
		contentHeight: 'auto',
		fixedWeekCount: false,
		expandRows: true,
		eventDisplay: 'block',
		displayEventTime: false,
		displayEventEnd: false,
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			hour12: false,
		},
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
		},
		dayMaxEvents: false,
		dayMaxEventRows: false,
		moreLinkClick: 'day',
		eventContent: function (arg) {
			var title = arg.event.title || '';
			var timeText = arg.timeText || '';
			var category = arg.event.extendedProps.category || 'bg-soft-info';
			var textColor = getCategoryTextColor(category);

			// For day grid month view, show title only
			if (arg.view.type === 'dayGridMonth') {
				return {
					html:
						'<div class="fc-event-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; padding: 2px 4px; font-weight: 500; color: ' +
						textColor +
						';">' +
						title +
						'</div>',
				};
			}

			// For list view
			if (
				arg.view.type === 'listMonth' ||
				arg.view.type === 'listWeek' ||
				arg.view.type === 'listDay'
			) {
				return {
					html:
						'<div class="fc-event-title" style="padding: 4px 8px; font-weight: 500; color: ' +
						textColor +
						';">' +
						title +
						'</div>',
				};
			}

			return {
				html:
					'<div class="fc-event-main-frame" style="padding: 2px 4px; color: ' +
					textColor +
					';"><div class="fc-event-time" style="font-weight: 600;">' +
					timeText +
					'</div><div class="fc-event-title" style="font-weight: 500;">' +
					title +
					'</div></div>',
			};
		},
		windowResize: function () {
			calendarInstance.changeView(getResponsiveView());
		},
		eventClick: function (info) {
			openDetailModal(info.event);
		},
		dateClick: function (info) {
			openAddModal(info.dateStr);
		},
		events: function (info, successCallback, failureCallback) {
			var formattedEvents = eventsArray.map(function (event) {
				var eventCategory = event.classNames
					? event.classNames[0]
					: 'bg-soft-info';
				return {
					id: event.id,
					title: event.title,
					start: event.start,
					end: event.end,
					allDay: event.allDay || false,
					className: event.classNames || ['bg-soft-info'],
					backgroundColor: getCategoryColor(eventCategory),
					borderColor: getCategoryBorderColor(eventCategory),
					textColor: getCategoryTextColor(eventCategory),
					extendedProps: {
						description: event.extendedProps
							? event.extendedProps.description
							: '',
						location: event.extendedProps ? event.extendedProps.location : '',
						created_by: event.extendedProps
							? event.extendedProps.created_by
							: 'Unknown',
						waktu_mulai: event.extendedProps
							? event.extendedProps.waktu_mulai
							: '',
						waktu_selesai: event.extendedProps
							? event.extendedProps.waktu_selesai
							: '',
						category: eventCategory,
					},
				};
			});
			successCallback(formattedEvents);
		},
		eventDidMount: function (arg) {
			// Apply text color to all event elements
			var category = arg.event.extendedProps.category || 'bg-soft-info';
			var textColor = getCategoryTextColor(category);
			if (arg.el) {
				arg.el.style.color = textColor;
				// For list view, find and style all text elements
				var allTextEls = arg.el.querySelectorAll(
					'.fc-list-event-title, .fc-list-event-title a, .fc-event-title, a'
				);
				allTextEls.forEach(function (el) {
					el.style.color = textColor;
				});
			}
		},
	});

	calendarInstance.render();
	loadEventsFromServer();
	var formAdd = document.getElementById('form-add-event');
	if (formAdd) formAdd.addEventListener('submit', submitAddEvent);

	var formEdit = document.getElementById('form-edit-event');
	if (formEdit) formEdit.addEventListener('submit', submitEditEvent);
	var btnNewEvent = document.getElementById('btn-new-event');
	if (btnNewEvent) {
		btnNewEvent.addEventListener('click', function () {
			openAddModal();
		});
	}

	var btnOpenEdit = document.getElementById('btn-open-edit');
	if (btnOpenEdit) {
		btnOpenEdit.addEventListener('click', function () {
			openEditModal();
		});
	}

	var btnDeleteEvent = document.getElementById('btn-delete-event');
	if (btnDeleteEvent) {
		btnDeleteEvent.addEventListener('click', function () {
			deleteEvent();
		});
	}
	document.querySelectorAll('.time-preset').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var startTime = this.getAttribute('data-start');
			var endTime = this.getAttribute('data-end');
			var modalType = this.getAttribute('data-modal');

			if (modalType === 'add') {
				if (addTimePicker1) addTimePicker1.setDate(startTime, true);
				if (addTimePicker2) addTimePicker2.setDate(endTime, true);
			} else if (modalType === 'edit') {
				if (editTimePicker1) editTimePicker1.setDate(startTime, true);
				if (editTimePicker2) editTimePicker2.setDate(endTime, true);
			}
		});
	});
});
