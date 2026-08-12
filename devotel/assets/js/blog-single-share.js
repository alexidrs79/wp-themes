(function () {
	'use strict';

	document.addEventListener('click', function (event) {
		var button = event.target.closest('.elementor-element-f47042b .elementor-share-btn[data-share-url]');
		if (!button) {
			return;
		}

		event.preventDefault();
		window.open(button.getAttribute('data-share-url'), '_blank', 'noopener,noreferrer');
	});

	document.addEventListener('keydown', function (event) {
		if (event.key !== 'Enter' && event.key !== ' ') {
			return;
		}

		var button = event.target.closest('.elementor-element-f47042b .elementor-share-btn[data-share-url]');
		if (!button) {
			return;
		}

		event.preventDefault();
		window.open(button.getAttribute('data-share-url'), '_blank', 'noopener,noreferrer');
	});
})();
