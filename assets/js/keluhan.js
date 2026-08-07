// Prevent multiple script execution
if (window.quillKeluhanInitialized) {
	// Already initialized, exit
} else {
	window.quillKeluhanInitialized = true;
	var quillInstances = {};

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.quill-keluhan').forEach(function (container) {
			// Prevent double initialization
			if (container.dataset.quillInitialized === 'true') {
				return;
			}
			container.dataset.quillInitialized = 'true';

			var hiddenInput = container.nextElementSibling;

			var quill = new Quill(container, {
				theme: 'snow',
				modules: {
					toolbar: [
						['bold', 'italic', 'underline'],
						[{ header: [null, 1, 2, 3] }],
						[{ list: 'ordered' }, { list: 'bullet' }],
						['link'],
						['clean'],
					],
				},
				placeholder:
					container.getAttribute('data-placeholder') || 'Tulis di sini...',
			});

			if (hiddenInput && hiddenInput.value) {
				quill.root.innerHTML = hiddenInput.value;
			}

			quill.on('text-change', function () {
				if (hiddenInput) {
					hiddenInput.value = quill.root.innerHTML;
				}
			});

			quillInstances[container.id] = quill;
		});

		var form = document.querySelector('form');
		if (form) {
			form.addEventListener('submit', function (e) {
				for (var id in quillInstances) {
					if (quillInstances.hasOwnProperty(id)) {
						var container = document.getElementById(id);
						var hiddenInput = container ? container.nextElementSibling : null;
						if (hiddenInput && quillInstances[id]) {
							hiddenInput.value = quillInstances[id].root.innerHTML;
						}
					}
				}
			});
		}
	});
}
