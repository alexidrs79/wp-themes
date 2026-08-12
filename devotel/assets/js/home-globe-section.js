/**
 * Keep homepage Three.js globe colors consistent when the mobile layout applies.
 *
 * @package Devotel
 */
(function () {
	'use strict';

	var MOBILE_MAX = 768;
	var lastViewportMobile = null;

	function isMobileViewport() {
		return window.innerWidth <= MOBILE_MAX;
	}

	function getGlobeContainer() {
		var frame = document.querySelector('.frame-2147227567');
		if (!frame) {
			return null;
		}
		return frame.querySelector('#globe-container');
	}

	function resetGlobeContainer(container) {
		if (!container) {
			return;
		}
		container.removeAttribute('data-globe-initialized');
		container.innerHTML = '';
	}

	function initGlobeIfReady() {
		if (typeof window.initGlobe !== 'function') {
			return false;
		}
		window.initGlobe();
		return true;
	}

	function syncGlobeToLayout() {
		var container = getGlobeContainer();
		if (!container) {
			return;
		}

		var rect = container.getBoundingClientRect();
		var width = Math.round(rect.width);
		var height = Math.round(rect.height);

		if (width < 100 || height < 100) {
			return;
		}

		var canvas = container.querySelector('canvas');
		if (!canvas) {
			if (!container.hasAttribute('data-globe-initialized')) {
				initGlobeIfReady();
			}
			return;
		}

		var dpr = Math.min(window.devicePixelRatio || 1, 2);
		var expectedWidth = Math.round(width * dpr);
		var expectedHeight = Math.round(height * dpr);
		var sizeMismatch =
			Math.abs(canvas.width - expectedWidth) > 2 ||
			Math.abs(canvas.height - expectedHeight) > 2;

		if (sizeMismatch) {
			resetGlobeContainer(container);
			initGlobeIfReady();
		}
	}

	function onViewportChange() {
		var mobile = isMobileViewport();
		if (lastViewportMobile === null) {
			lastViewportMobile = mobile;
			return;
		}
		if (lastViewportMobile !== mobile) {
			lastViewportMobile = mobile;
			resetGlobeContainer(getGlobeContainer());
			window.setTimeout(initGlobeIfReady, 50);
			return;
		}
		syncGlobeToLayout();
	}

	function boot() {
		lastViewportMobile = isMobileViewport();
		window.setTimeout(syncGlobeToLayout, 120);
		window.setTimeout(syncGlobeToLayout, 400);
	}

	var resizeTimer;
	window.addEventListener('resize', function () {
		window.clearTimeout(resizeTimer);
		resizeTimer = window.setTimeout(onViewportChange, 150);
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}

	window.addEventListener('load', function () {
		window.setTimeout(syncGlobeToLayout, 200);
	});
})();
