var birthdayAudio = null;
var birthdayRemindersData = null;

document.addEventListener('DOMContentLoaded', function () {
	if (
		typeof birthdayReminders !== 'undefined' &&
		birthdayReminders.length > 0
	) {
		birthdayRemindersData = birthdayReminders;
		showInitialNotification(birthdayReminders.length);
	}
});

function showInitialNotification(count) {
	Swal.fire({
		html:
			'<div class="mt-3">' +
			'<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:100px;height:100px"></lord-icon>' +
			'<div class="mt-4 pt-2">' +
			'<h4 class="text-primary mb-3"><i class="ri-cake-2-line me-2"></i>Ada ' +
			count +
			' Pengingat Ulang Tahun!</h4>' +
			'<p class="text-muted mb-0">Klik tombol di bawah untuk melihat detail</p>' +
			'</div></div>',
		width: '600px',
		showCancelButton: true,
		showConfirmButton: true,
		confirmButtonText:
			'<i class="ri-music-2-line me-1"></i> Lihat dengan Musik',
		cancelButtonText:
			'<i class="ri-volume-mute-line me-1"></i> Lihat Tanpa Musik',
		buttonsStyling: false,
		showCloseButton: true,
		customClass: {
			confirmButton: 'btn btn-primary me-2',
			cancelButton: 'btn btn-outline-secondary',
			popup: 'info-birthday',
		},
		allowOutsideClick: false,
	}).then(function (result) {
		if (result.isConfirmed) {
			showBirthdayReminder(birthdayRemindersData, true);
		} else if (result.dismiss === Swal.DismissReason.cancel) {
			showBirthdayReminder(birthdayRemindersData, false);
		}
	});
}

function showBirthdayReminder(reminders, withMusic) {
	let htmlContent = '<div class="mt-3">';

	// Lord icon for celebration
	htmlContent +=
		'<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:100px;height:100px"></lord-icon>';

	htmlContent += '<div class="mt-4 pt-2">';
	htmlContent +=
		'<h4 class="text-primary mb-3"><i class="ri-cake-2-line me-2"></i>Pengingat Ulang Tahun</h4>';
	htmlContent +=
		'<p class="text-muted mb-3">Berikut adalah daftar ulang tahun dalam 3 hari ke depan:</p>';

	// Table for reminders
	htmlContent +=
		'<div class="table-responsive" style="max-height: 300px; overflow-y: auto;">';
	htmlContent +=
		'<table class="table table-bordered table-sm align-middle mb-0">';
	htmlContent += '<thead class="table-light">';
	htmlContent += '<tr>';
	htmlContent += '<th class="text-center" style="width: 60px;">Hari</th>';
	htmlContent += '<th>Tanggal</th>';
	htmlContent += '<th>Nama</th>';
	htmlContent += '<th>Kategori</th>';
	htmlContent += '<th>Perusahaan</th>';
	htmlContent += '<th>Marketing</th>';
	htmlContent += '</tr>';
	htmlContent += '</thead>';
	htmlContent += '<tbody>';

	reminders.forEach(function (reminder) {
		let badgeClass = '';
		let dayLabel = '';

		// Determine badge color based on days remaining
		if (reminder.sisa_hari === 0) {
			badgeClass = 'bg-danger';
			dayLabel = 'Hari Ini!';
		} else if (reminder.sisa_hari === 1) {
			badgeClass = 'bg-warning';
			dayLabel = 'H-1';
		} else if (reminder.sisa_hari === 2) {
			badgeClass = 'bg-info';
			dayLabel = 'H-2';
		} else {
			badgeClass = 'bg-secondary';
			dayLabel = 'H-3';
		}

		// Icon based on type
		let typeIcon =
			reminder.type === 'client' ? 'ri-building-line' : 'ri-user-line';

		htmlContent += '<tr>';
		htmlContent +=
			'<td class="text-center"><span class="badge ' +
			badgeClass +
			'">' +
			dayLabel +
			'</span></td>';
		htmlContent +=
			'<td><small>' + escapeHtml(reminder.tanggal_full) + '</small></td>';
		htmlContent +=
			'<td><i class="' +
			typeIcon +
			' me-1"></i>' +
			escapeHtml(reminder.nama) +
			'</td>';
		htmlContent +=
			'<td><small class="text-muted">' +
			escapeHtml(reminder.category) +
			'</small></td>';
		htmlContent +=
			'<td><small>' + escapeHtml(reminder.company) + '</small></td>';
		htmlContent +=
			'<td><small class="text-primary">' +
			escapeHtml(reminder.marketing) +
			'</small></td>';
		htmlContent += '</tr>';
	});

	htmlContent += '</tbody>';
	htmlContent += '</table>';
	htmlContent += '</div>';

	htmlContent +=
		'<p class="text-muted mt-3 mb-0"><small><i class="ri-information-line me-1"></i>Jangan lupa untuk memberikan ucapan selamat!</small></p>';
	htmlContent += '</div>';
	htmlContent += '</div>';

	// Play birthday music only if user chose to
	if (withMusic) {
		playBirthdayMusic();
	}

	// Show SweetAlert popup
	Swal.fire({
		html: htmlContent,
		width: '1200px',
		showCancelButton: false,
		showConfirmButton: true,
		confirmButtonClass: 'btn btn-primary w-xs mb-1',
		confirmButtonText: '<i class="ri-check-line me-1"></i> Mengerti',
		buttonsStyling: false,
		showCloseButton: true,
		customClass: {
			confirmButton: 'btn btn-primary',
			popup: 'birthday-reminder-popup',
		},
		didClose: function () {
			stopBirthdayMusic();
		},
	});
}

// Function to play birthday music
function playBirthdayMusic() {
	try {
		// Create audio element
		birthdayAudio = new Audio(base_url + 'assets/audio/happy-birthday.mp3');
		birthdayAudio.volume = 0.5; // Set volume to 50%
		birthdayAudio.loop = false; // Don't loop the music

		// Play the audio
		var playPromise = birthdayAudio.play();

		// Handle autoplay restrictions
		if (playPromise !== undefined) {
			playPromise.catch(function (error) {
				console.log('Audio autoplay was prevented:', error);
			});
		}
	} catch (error) {
		console.log('Error playing birthday music:', error);
	}
}

// Function to stop birthday music
function stopBirthdayMusic() {
	if (birthdayAudio) {
		birthdayAudio.pause();
		birthdayAudio.currentTime = 0;
		birthdayAudio = null;
	}
}

// Helper function to escape HTML
function escapeHtml(text) {
	if (!text) return '-';
	var div = document.createElement('div');
	div.appendChild(document.createTextNode(text));
	return div.innerHTML;
}
