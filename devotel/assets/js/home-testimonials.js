/**
 * Seamless vertical loop for homepage testimonial columns.
 * Each track already contains a duplicated card list; we set the scroll
 * distance to the offset of the first card in the second half so the
 * CSS animation can wrap without a visible jump.
 */
(function () {
	'use strict';

	var SELECTOR = '.testimonials-section .testimonials-column-track';

	function measureTrack(track) {
		var cards = track.querySelectorAll(':scope > .testimonial-card');
		if (cards.length < 2 || cards.length % 2 !== 0) {
			return;
		}

		var mid = cards[cards.length / 2];
		if (!mid) {
			return;
		}

		var distance = mid.offsetTop;
		if (!(distance > 0)) {
			return;
		}

		track.style.setProperty('--testimonials-loop-distance', distance + 'px');
	}

	function measureAll() {
		document.querySelectorAll(SELECTOR).forEach(measureTrack);
	}

	function bindImages(root) {
		if (!root) {
			return;
		}
		root.querySelectorAll('img').forEach(function (img) {
			if (img.complete) {
				return;
			}
			img.addEventListener('load', measureAll, { once: true });
			img.addEventListener('error', measureAll, { once: true });
		});
	}

	function init() {
		var section = document.querySelector('.testimonials-section');
		if (!section) {
			return;
		}

		measureAll();
		bindImages(section);

		var resizeTimer;
		window.addEventListener(
			'resize',
			function () {
				window.clearTimeout(resizeTimer);
				resizeTimer = window.setTimeout(measureAll, 150);
			},
			{ passive: true }
		);

		if (typeof ResizeObserver === 'function') {
			var ro = new ResizeObserver(function () {
				measureAll();
			});
			section.querySelectorAll(SELECTOR).forEach(function (track) {
				ro.observe(track);
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
