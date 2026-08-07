document.addEventListener('DOMContentLoaded', function () {
	var table = new DataTable('#asset-keluar-table', {
		pagingType: 'full_numbers',
		order: [[1, 'desc']],
		responsive: true,
	});

	$('#checkAll').on('click', function () {
		var rows = table.rows({ search: 'applied' }).nodes();
		$('input[type="checkbox"]', rows).prop('checked', this.checked);
	});

	$('#asset-keluar-table tbody').on(
		'change',
		'input[type="checkbox"]',
		function () {
			if (!this.checked) {
				var el = $('#checkAll').get(0);
				if (el && el.checked && 'indeterminate' in el) {
					el.indeterminate = true;
				}
			}
		}
	);

	$('.btn-barcode-multiple').on('click', function () {
		var selected = [];
		$('.checkRowOrder:checked').each(function () {
			selected.push($(this).val());
		});

		if (selected.length === 0) {
			alert('Pilih minimal satu data untuk dicetak');
			return;
		}

		var form = $('<form>', {
			action: base_url + 'Aset/cetak_qrcode_multiple',
			method: 'post',
			target: '_blank',
		});

		$.each(selected, function (index, value) {
			form.append(
				$('<input>', {
					type: 'hidden',
					name: 'kode_aset[]',
					value: value,
				})
			);
		});

		$('body').append(form);
		form.submit();
		form.remove();
	});
});
