$(document).ready(function () {
	let currentFolderId = null;

	$('#createfolder-form').on('submit', function (e) {
		e.preventDefault();

		const folderName = $('#foldername-input').val().trim();
		const folderId = $('#folderid-input').val();

		if (!folderName) {
			alert('Nama folder harus diisi!');
			return;
		}

		const url = folderId
			? base_url + 'File/update/' + folderId
			: base_url + 'File/create';

		const formData = new FormData();
		formData.append('nama_folder', folderName);

		$.ajax({
			url: url,
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function (response) {
				if (response.status) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: response.message,
						timer: 2000,
						showConfirmButton: false,
					});
					$('#createFolderModal').modal('hide');
					$('#foldername-input').val('');
					$('#folderid-input').val('');
					setTimeout(() => {
						location.reload();
					}, 1000);
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message,
					});
				}
			},
			error: function (xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});

	$(document).on('click', '.edit-folder-list', function () {
		const folderId = $(this).data('folder-id');
		currentFolderId = folderId;
		$.ajax({
			url: base_url + 'File/get_folder_json/' + folderId,
			type: 'GET',
			dataType: 'json',
			success: function (response) {
				if (response.status) {
					$('#foldername-input').val(response.data.nama_folder);
					$('#folderid-input').val(response.data.id_folder);
					$('#createFolderModalLabel').text('Edit Folder');
					$('#addNewFolder').text('Update Folder');
				} else {
					alert(response.message);
				}
			},
		});
	});

	$(document).on('click', '.delete-folder', function () {
		currentFolderId = $(this).data('folder-id');
	});

	$('#remove-folderList').on('click', function () {
		if (!currentFolderId) return;

		$.ajax({
			url: base_url + 'File/delete/' + currentFolderId,
			type: 'POST',
			dataType: 'json',
			success: function (response) {
				if (response.status) {
					Swal.fire({
						icon: 'success',
						title: 'Deleted!',
						text: response.message,
						timer: 2000,
						showConfirmButton: false,
					});

					$('#removeFolderModal').modal('hide');
					$('#folder-card-' + currentFolderId).remove();
					currentFolderId = null;
					if ($('.folder-card').length === 0) {
						$('#folderlist-data').html(`
                            <div class="col-12 text-center py-5">
                                <i class="ri-folder-open-line display-4 text-muted"></i>
                                <h5 class="mt-3">Belum ada folder</h5>
                                <p class="text-muted">Klik "Create Folder" untuk membuat folder baru</p>
                            </div>
                        `);
					}
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message,
					});
					$('#removeFolderModal').modal('hide');
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'Terjadi kesalahan pada server',
				});
			},
		});
	});

	$('#createFolderModal').on('hidden.bs.modal', function () {
		$('#foldername-input').val('');
		$('#folderid-input').val('');
		$('#createFolderModalLabel').text('Create Folder');
		$('#addNewFolder').text('Add Folder');
		currentFolderId = null;
	});

	$('#removeFolderModal').on('hidden.bs.modal', function () {
		currentFolderId = null;
	});
});
