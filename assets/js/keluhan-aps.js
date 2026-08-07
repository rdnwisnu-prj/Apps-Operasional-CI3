// Prevent multiple script execution
if (window.quillKeluhanApsInitialized) {
	// Already initialized, exit
} else {
	window.quillKeluhanApsInitialized = true;
	var quillInstancesAps = {};

	function updateAllEditorsAps() {
		for (var fieldName in quillInstancesAps) {
			if (quillInstancesAps.hasOwnProperty(fieldName)) {
				var hiddenInput = document.getElementById(fieldName);
				if (hiddenInput && quillInstancesAps[fieldName]) {
					hiddenInput.value = quillInstancesAps[fieldName].root.innerHTML;
				}
			}
		}
	}

	document.addEventListener('DOMContentLoaded', function () {
		document
			.querySelectorAll('.quill-keluhan-aps')
			.forEach(function (container) {
				// Prevent double initialization
				if (container.dataset.quillInitialized === 'true') {
					return;
				}
				container.dataset.quillInitialized = 'true';

				var fieldName = container.id.replace('editor-', '');
				var hiddenInput = document.getElementById(fieldName);

				var quill = new Quill(container, {
					theme: 'snow',
					modules: {
						toolbar: [
							[{ header: [1, 2, 3, false] }],
							['bold', 'italic', 'underline'],
							['link'],
							[{ list: 'ordered' }, { list: 'bullet' }],
							[{ indent: '-1' }, { indent: '+1' }],
							['blockquote'],
							['clean'],
						],
					},
					placeholder:
						'Input ' +
						fieldName.replace(/_/g, ' ').replace(/\b\w/g, function (l) {
							return l.toUpperCase();
						}),
				});

				quillInstancesAps[fieldName] = quill;

				// Sync content to hidden input on text change
				quill.on('text-change', function () {
					if (hiddenInput) {
						hiddenInput.value = quill.root.innerHTML;
					}
				});

				// Set initial value if exists
				if (hiddenInput && hiddenInput.value) {
					quill.root.innerHTML = hiddenInput.value;
				}
			});

		var form = document.querySelector('form');
		if (form) {
			form.addEventListener('submit', function (e) {
				updateAllEditorsAps();
			});
		}
	});
}
