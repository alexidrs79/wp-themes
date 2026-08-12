/**
 * Blog archive — AJAX category filters + pagination (no full reload).
 */
(function () {
	'use strict';

	var config = window.devotelBlogFilters || {};
	var archive = document.querySelector('.devotel-blog-archive');
	if (!archive) {
		return;
	}

	var filters = document.getElementById('filters');
	var gridSelector = '.devotel-blog-archive .elementor-element-504959e';
	var gridAnchorSelector = '.devotel-blog-archive .elementor-element-a743aca';

	function getGrid() {
		return document.querySelector(gridSelector);
	}

	function canUseAjax() {
		return !!(config.ajaxUrl && config.nonce && getGrid());
	}

	function getCategoryFromUrl() {
		var params = new URLSearchParams(window.location.search);
		return params.get('category_name') || '';
	}

	function getPageFromUrl() {
		var params = new URLSearchParams(window.location.search);
		var fromQuery = parseInt(params.get('paged') || '0', 10);
		if (fromQuery > 0) {
			return fromQuery;
		}

		var match = window.location.pathname.match(/\/page\/(\d+)\/?$/);
		if (match && match[1]) {
			return parseInt(match[1], 10) || 1;
		}

		return 1;
	}

	function buildUrl(slug, paged) {
		var base = config.blogUrl || window.location.pathname;
		var url = new URL(base.split('?')[0], window.location.origin);
		var page = Math.max(1, parseInt(String(paged || 1), 10) || 1);

		if (slug) {
			url.searchParams.set('category_name', slug);
		}

		if (page > 1) {
			url.searchParams.set('paged', String(page));
		}

		return url.pathname + url.search;
	}

	function setActiveTab(slug) {
		if (!filters) {
			return;
		}

		filters.querySelectorAll('.e-filter-item').forEach(function (item) {
			var filter = item.getAttribute('data-filter') || '';
			var active = '' === slug ? '__all' === filter : filter === slug;
			item.setAttribute('aria-pressed', active ? 'true' : 'false');
		});
	}

	function scrollToGrid() {
		var anchor = document.querySelector(gridAnchorSelector);
		if (!anchor) {
			return;
		}

		var headerOffset = 96;
		var top = anchor.getBoundingClientRect().top + window.pageYOffset - headerOffset;
		window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
	}

	function navigateFallback(fallbackUrl) {
		if (fallbackUrl) {
			window.location.assign(fallbackUrl);
		}
	}

	function parseGridMarkup(html) {
		if (!html || 'string' !== typeof html) {
			return null;
		}

		var parser = new DOMParser();
		var doc = parser.parseFromString(html, 'text/html');
		var nextGrid = doc.querySelector('.elementor-element-504959e');
		if (!nextGrid) {
			return null;
		}

		// Defensive: reject any unexpected executable tags in payload.
		if (nextGrid.querySelector('script, iframe, object, embed')) {
			return null;
		}

		return nextGrid;
	}

	function loadGrid(slug, paged, updateHistory, fallbackUrl) {
		var grid = getGrid();
		if (!grid) {
			navigateFallback(fallbackUrl);
			return Promise.resolve(false);
		}

		if (!config.ajaxUrl || !config.nonce) {
			navigateFallback(fallbackUrl);
			return Promise.resolve(false);
		}

		var page = Math.max(1, parseInt(String(paged || 1), 10) || 1);
		grid.classList.remove('is-error');
		grid.classList.add('is-loading');

		var body = new FormData();
		body.append('action', 'devotel_blog_grid');
		body.append('nonce', config.nonce);
		body.append('category_slug', slug);
		body.append('paged', String(page));

		return fetch(config.ajaxUrl, {
			method: 'POST',
			body: body,
			credentials: 'same-origin',
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (data) {
				if (!data || !data.success || !data.data || !data.data.html) {
					grid.classList.add('is-error');
					navigateFallback(fallbackUrl);
					return false;
				}

				var nextGrid = parseGridMarkup(data.data.html);
				if (!nextGrid) {
					grid.classList.add('is-error');
					navigateFallback(fallbackUrl);
					return false;
				}

				grid.replaceWith(nextGrid);
				document.dispatchEvent(new CustomEvent('devotel:blog-grid-updated'));

				if (updateHistory) {
					history.pushState({ category: slug, paged: page }, '', buildUrl(slug, page));
				}

				setActiveTab(slug);
				scrollToGrid();
				return true;
			})
			.catch(function (error) {
				grid.classList.add('is-error');
				if (window.console && console.warn) {
					console.warn('Devotel blog filter request failed.', error);
				}
				navigateFallback(fallbackUrl);
				return false;
			})
			.finally(function () {
				var nextGrid = getGrid();
				if (nextGrid) {
					nextGrid.classList.remove('is-loading');
				}
			});
	}

	if (filters) {
		filters.addEventListener('click', function (event) {
			var item = event.target.closest('.e-filter-item');
			if (!item || !filters.contains(item)) {
				return;
			}

			var slug = item.getAttribute('data-filter') || '';
			if ('__all' === slug) {
				slug = '';
			}

			var fallbackUrl = item.getAttribute('href') || buildUrl(slug, 1);
			if (!canUseAjax()) {
				return;
			}

			event.preventDefault();
			loadGrid(slug, 1, true, fallbackUrl);
		});
	}

	archive.addEventListener('click', function (event) {
		var link = event.target.closest('.elementor-pagination a.page-numbers');
		if (!link || !archive.contains(link)) {
			return;
		}

		var fallbackUrl = link.getAttribute('href') || '';

		if (link.classList.contains('prev') || link.classList.contains('next')) {
			var dataPage = link.getAttribute('data-page');
			if (!dataPage) {
				return;
			}
			if (!canUseAjax()) {
				return;
			}
			event.preventDefault();
			loadGrid(getCategoryFromUrl(), parseInt(dataPage, 10) || 1, true, fallbackUrl);
			return;
		}

		if (link.classList.contains('page-numbers') && !link.classList.contains('dots')) {
			if (!canUseAjax()) {
				return;
			}
			event.preventDefault();
			var page = parseInt(link.getAttribute('data-page') || link.textContent.trim(), 10) || 1;
			loadGrid(getCategoryFromUrl(), page, true, fallbackUrl);
		}
	});

	window.addEventListener('popstate', function () {
		var slug = getCategoryFromUrl();
		var page = getPageFromUrl();
		setActiveTab(slug);
		loadGrid(slug, page, false, buildUrl(slug, page));
	});

	setActiveTab(getCategoryFromUrl());
})();
