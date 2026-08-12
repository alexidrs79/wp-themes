/**
 * Blog archive pagination — mobile "Page X of Y" (ported from live post-872.css).
 */
(function () {
	'use strict';

	function isMobile() {
		return window.innerWidth <= 768;
	}

	function storeOriginalText(pagination) {
		pagination.querySelectorAll('.page-numbers:not(.prev):not(.next):not(.dots)').forEach(function (el) {
			var text = el.textContent.trim();
			if (text && !el.hasAttribute('data-original-text')) {
				el.setAttribute('data-original-text', text);
			}
		});
	}

	function formatPaginationMobile() {
		var pagination = document.querySelector('.devotel-blog-archive .elementor-pagination');
		if (!pagination) {
			return;
		}

		var pageNumbers = Array.prototype.filter.call(
			pagination.querySelectorAll('.page-numbers'),
			function (el) {
				return (
					!el.classList.contains('prev') &&
					!el.classList.contains('next') &&
					!el.classList.contains('dots')
				);
			}
		);

		if (!pageNumbers.length) {
			return;
		}

		storeOriginalText(pagination);

		if (isMobile()) {
			var currentPageEl = pagination.querySelector('.page-numbers.current');
			var currentPage = 1;

			if (currentPageEl) {
				var originalText = currentPageEl.getAttribute('data-original-text') || currentPageEl.textContent.trim();
				currentPage = parseInt(originalText, 10) || 1;
			}

			var totalPages = 0;
			pageNumbers.forEach(function (el) {
				var pageText = el.getAttribute('data-original-text') || el.textContent.trim();
				var pageNum = parseInt(pageText, 10);
				if (pageNum && pageNum > totalPages) {
					totalPages = pageNum;
				}
			});

			if (totalPages === 0 || totalPages < currentPage) {
				totalPages = Math.max(pageNumbers.length, currentPage);
			}

			pageNumbers.forEach(function (el) {
				if (el.classList.contains('current')) {
					el.textContent = 'Page ' + currentPage + ' of ' + totalPages;
					el.style.display = 'inline-flex';
				} else {
					el.style.display = 'none';
				}
			});
		} else {
			pageNumbers.forEach(function (el) {
				el.style.display = '';
				var stored = el.getAttribute('data-original-text');
				if (stored && el.textContent.indexOf('Page') !== -1 && el.textContent.indexOf('of') !== -1) {
					el.textContent = stored;
				}
			});
		}
	}

	function init() {
		formatPaginationMobile();

		var resizeTimer;
		window.addEventListener('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(formatPaginationMobile, 100);
		});
	}

	document.addEventListener('devotel:blog-grid-updated', formatPaginationMobile);

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
