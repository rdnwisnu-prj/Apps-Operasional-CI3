$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timerProgressBar: false,
		customClass: {
			popup: 'colored-toast',
		},
	});

	var currentRoleId = null;

	$(document).on('click', '.btn-access-role', function () {
		currentRoleId = $(this).data('role-id');
		var roleName = $(this).data('role-name');

		$('#roleTitle').text('Nama Role : ' + roleName);
		$('#accessCard').removeClass('d-none');
		loadRoleAccess(currentRoleId);
	});

	$('.btn-close').on('click', function () {
		$('#accessCard').addClass('d-none');
	});

	function loadRoleAccess(roleId) {
		$('#accessList').html(`
        <div class="text-left py-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

		$.ajax({
			url: base_url + 'Setting/Role/getMenuAccess/' + roleId,
			type: 'GET',
			dataType: 'json',
			success: function (response) {
				if (!response || response.length === 0) {
					$('#accessList').html(`
                    <div class="text-center py-4">
                        <p class="text-muted">Tidak ada data menu yang tersedia.</p>
                    </div>
                `);
					return;
				}

				var html = `
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 25%;">HEADER</th>
                                    <th scope="col" style="width: 30%;">MENU</th>
                                    <th scope="col" style="width: 30%;">SUBMENU</th>
                                    <th scope="col" class="text-center" style="width: 15%;">AKSES</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
				var currentHeader = '';

				$.each(response, function (index, menu) {
					if (menu.menu_header !== currentHeader) {
						currentHeader = menu.menu_header;

						html += `
                            <tr>
                                <td colspan="4" class="table-secondary fw-semibold">
                                    ${menu.menu_header}
                                </td>
                            </tr>
                        `;
					}

					if (menu.submenus.length > 0) {
						$.each(menu.submenus, function (subIndex, submenu) {
							html += '<tr>';
							html += '<td>-</td>';
							html += `<td>${menu.menu_name}</td>`;
							html += `<td>${submenu.submenu_name}</td>`;
							html += `<td class="text-center">
                                <input class="form-check-input access-checkbox" type="checkbox"
                                    data-menu-id="${menu.menu_id}" 
                                    data-submenu-id="${submenu.submenu_id}" 
                                    ${submenu.has_access ? 'checked' : ''} />
                            </td>`;

							html += '</tr>';
						});
					} else {
						html += '<tr>';
						html += '<td>-</td>';
						html += `<td>${menu.menu_name}</td>`;
						html += `<td>-</td>`;
						html += `<td class="text-center">
                            <input class="form-check-input access-checkbox" type="checkbox"
                                data-menu-id="${menu.menu_id}" 
                                data-submenu-id="0" 
                                ${menu.has_access ? 'checked' : ''} />
                        </td>`;

						html += '</tr>';
					}
				});

				html += `
                            </tbody>
                        </table>
                    </div>
                `;

				$('#accessList').html(html);
			},
			error: function (xhr, status, error) {
				$('#accessList').html(`
                <div class="alert alert-danger mx-3 my-3">
                    <i class="ri-error-warning-line me-2"></i>Error loading data. Silakan coba lagi.
                </div>
            `);
				console.error('Error:', error);
			},
		});
	}
	$('#saveAccess').on('click', function () {
		if (!currentRoleId) {
			alert('Pilih role terlebih dahulu');
			return;
		}

		var accessData = [];
		$('.access-checkbox:checked').each(function () {
			var menuId = $(this).data('menu-id');
			var submenuId = $(this).data('submenu-id');

			accessData.push({
				menu_id: menuId,
				submenu_id: submenuId,
			});
		});

		saveAccess(currentRoleId, accessData);
	});

	function saveAccess(roleId, accessData) {
		$.ajax({
			url: base_url + 'Setting/Role/saveAccess',
			type: 'POST',
			data: {
				role_id: roleId,
				access_data: accessData,
			},
			success: function (response) {
				var result = JSON.parse(response);
				if (result.status === 'success') {
					Toast.fire({
						icon: 'success',
						title: result.message,
						timer: 1500,
					}).then(() => {
						location.reload();
					});
				} else {
					alert('Terjadi kesalahan: ' + result.message);
				}
			},
			error: function (xhr, status, error) {
				console.error('Error:', error);
				alert('Error menyimpan akses: ' + error);
			},
		});
	}
});
