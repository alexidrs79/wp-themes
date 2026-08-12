(function () {
	'use strict';

	var tocRoot = document.getElementById('elementor-toc__66fa37e');
	var contentRoot = document.getElementById('blogsss');

	if (!tocRoot || !contentRoot) {
		return;
	}

	var links = Array.prototype.slice.call(
		tocRoot.querySelectorAll('a[data-toc-target]')
	);
	var headings = Array.prototype.slice.call(contentRoot.querySelectorAll('h2[id]'));

	if (!links.length || !headings.length) {
		return;
	}

	var setActive = function (activeId) {
		links.forEach(function (link) {
			var item = link.closest('.elementor-toc__list-item');
			var isActive = link.getAttribute('data-toc-target') === activeId;
			link.classList.toggle('is-active', isActive);
			if (item) {
				item.classList.toggle('is-active', isActive);
			}
		});
	};

	var getActiveHeadingId = function () {
		var offset = 120;
		var activeId = headings[0].id;

		headings.forEach(function (heading) {
			if (heading.getBoundingClientRect().top - offset <= 0) {
				activeId = heading.id;
			}
		});

		return activeId;
	};

	var onScroll = function () {
		setActive(getActiveHeadingId());
	};

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll, { passive: true });
	onScroll();
})();
