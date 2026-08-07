if (typeof window.ImportToast === 'undefined') {
	window.ImportToast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer);
			toast.addEventListener('mouseleave', Swal.resumeTimer);
		},
	});
}

function initProspekImportDropzone(config) {
	if (typeof Dropzone === 'undefined') {
		console.warn('Dropzone library not loaded');
		return;
	}

	Dropzone.autoDiscover = false;

	if (document.querySelector(config.previewListSelector)) {
		var dropzonePreviewNodeProspek = document.querySelector(
			config.previewListSelector
		);
		var previewTemplateProspek =
			dropzonePreviewNodeProspek.parentNode.innerHTML;
		dropzonePreviewNodeProspek.parentNode.removeChild(
			dropzonePreviewNodeProspek
		);

		new Dropzone(config.dropzoneSelector, {
			url: base_url + config.controller + '/import',
			method: 'post',
			previewTemplate: previewTemplateProspek,
			previewsContainer: config.previewSelector,
			paramName: 'file',
			acceptedFiles: '.xlsx,.xls,.csv',
			dictInvalidFileType: 'File type not allowed (only xlsx, xls, csv)',
			dictFileTooBig: 'File is too big (max 2MB)',
			maxFiles: 1,
			autoProcessQueue: false,
			init: function () {
				var submitButton = document.querySelector(config.submitSelector);
				var dzInstance = this;

				if (submitButton) {
					submitButton.addEventListener('click', function () {
						if (dzInstance.files.length === 0) {
							Swal.fire('Error!', 'Tidak ada data yang di import!', 'warning');
							return;
						}
						dzInstance.processQueue();
					});
				}

				this.on('sending', function (file, xhr, formData) {
					if (window.csrfTokenName && window.csrfHash) {
						formData.append(window.csrfTokenName, window.csrfHash);
					}
				});

				this.on('success', function (file, response) {
					if (typeof response === 'string') {
						try {
							response = JSON.parse(response);
						} catch (e) {
							response = { success: false, message: 'Invalid server response' };
						}
					}

					if (response.success) {
						this.removeFile(file);

						window.ImportToast.fire({
							icon: 'success',
							title: response.message || 'Berhasil import file.',
							timer: 1500,
						});
						setTimeout(function () {
							location.reload();
						}, 2000);
					} else {
						this.removeFile(file);
						window.ImportToast.fire({
							icon: 'error',
							title: response.message || 'Terjadi kesalahan saat import file.',
							timer: 3000,
						});
					}
				});

				this.on('error', function (file, errorMessage) {
					this.removeFile(file);
					window.ImportToast.fire({
						icon: 'error',
						title:
							errorMessage.message || 'Terjadi kesalahan saat upload file.',
						timer: 3000,
					});
				});
			},
		});
	}
}

// Import Prospek Dropzone
$(document).ready(function () {
	initProspekImportDropzone({
		controller: 'Prospek',
		dropzoneSelector: '#dropzone-prospek',
		previewSelector: '#dropzone-preview-prospek',
		previewListSelector: '#dropzone-preview-list-prospek',
		submitSelector: '#submitBtnProspek',
	});
});
