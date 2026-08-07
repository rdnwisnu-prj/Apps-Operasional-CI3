// Toast notification mixin - only declare if not already defined
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

// Import Client Dropzone
if (document.querySelector('#dropzone-preview-list-client')) {
	var dropzonePreviewNodeClient = document.querySelector(
		'#dropzone-preview-list-client'
	);
	var previewTemplateClient = dropzonePreviewNodeClient.parentNode.innerHTML;
	dropzonePreviewNodeClient.parentNode.removeChild(dropzonePreviewNodeClient);

	var clientDropzone = new Dropzone('#dropzone-client', {
		url: base_url + 'Client/import',
		method: 'post',
		previewTemplate: previewTemplateClient,
		previewsContainer: '#dropzone-preview-client',
		paramName: 'file',
		acceptedFiles: '.xlsx,.xls,.csv',
		dictInvalidFileType: 'File type not allowed (only xlsx, xls, csv)',
		dictFileTooBig: 'File is too big (max 2MB)',
		maxFiles: 1,
		autoProcessQueue: false,
		init: function () {
			var submitButton = document.querySelector('#submitBtn');
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
				formData.append(
					'<?php echo $this->security->get_csrf_token_name(); ?>',
					'<?php echo $this->security->get_csrf_hash(); ?>'
				);
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
					title: errorMessage.message || 'Terjadi kesalahan saat upload file.',
					timer: 3000,
				});
			});
		},
	});
}
