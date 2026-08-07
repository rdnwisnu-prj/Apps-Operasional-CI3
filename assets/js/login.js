$(document).ready(function () {
	$('.toggle-password').on('click', function () {
		var passInput = $(this).closest('.pass-group').find('.pass-input');
		var icon = $(this).find('i');
		var isHidden = passInput.attr('type') === 'password';

		if (isHidden) {
			passInput.attr('type', 'text');
			icon.removeClass('ti-eye-off').addClass('ti-eye');
			$(this)
				.attr('aria-label', 'Sembunyikan password')
				.attr('aria-pressed', 'true');
		} else {
			passInput.attr('type', 'password');
			icon.removeClass('ti-eye').addClass('ti-eye-off');
			$(this)
				.attr('aria-label', 'Tampilkan password')
				.attr('aria-pressed', 'false');
		}
	});

	$(document).on('click', '.password-addon', function () {
		var button = $(this);
		var wrapper = button.closest('.auth-pass-inputgroup, .input-group');
		var passInput = wrapper.find('.password-input').first();

		if (!passInput.length) {
			passInput = wrapper
				.find('input[type="password"], input[type="text"]')
				.first();
		}

		if (!passInput.length) {
			passInput = $('#password-input');
		}

		var icon = button.find('i');
		var isHidden = passInput.attr('type') === 'password';

		passInput.attr('type', isHidden ? 'text' : 'password');
		button
			.attr(
				'aria-label',
				isHidden ? 'Sembunyikan password' : 'Tampilkan password'
			)
			.attr('aria-pressed', isHidden ? 'true' : 'false');

		if (icon.hasClass('ri-eye-fill') || icon.hasClass('ri-eye-off-fill')) {
			icon
				.toggleClass('ri-eye-fill', !isHidden)
				.toggleClass('ri-eye-off-fill', isHidden);
		} else {
			icon.toggleClass('ti-eye-off', !isHidden).toggleClass('ti-eye', isHidden);
		}
	});

	$('#login-year').text(new Date().getFullYear());
});
