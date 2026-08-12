/**
 * Footer mobile masonry — splits 5 nav columns into two columns.
 */
(function () {
	"use strict";

	function isMobile() {
		return window.matchMedia("(max-width: 768px)").matches;
	}

	function getNavContainer() {
		var wrapper = document.getElementById("devotel-footer-wrapper");
		if (!wrapper) {
			return null;
		}
		return (
			wrapper.querySelector(".devotel-footer-nav") ||
			wrapper.querySelector("div:first-child > div > div > div:last-child")
		);
	}

	function storeOriginalOrder(container) {
		if (container.dataset.originalHtml) {
			return;
		}
		container.dataset.originalHtml = container.innerHTML;
		Array.from(container.children).forEach(function (child, index) {
			child.setAttribute("data-original-index", String(index));
		});
	}

	function restoreDesktopLayout(container) {
		if (!container.classList.contains("masonry-initialized")) {
			return;
		}
		if (container.dataset.originalHtml) {
			container.innerHTML = container.dataset.originalHtml;
		}
		container.classList.remove("masonry-initialized");
		container.removeAttribute("style");
	}

	function initMasonry() {
		var container = getNavContainer();
		if (!container) {
			return;
		}

		if (!isMobile()) {
			restoreDesktopLayout(container);
			return;
		}

		storeOriginalOrder(container);

		if (container.classList.contains("masonry-initialized")) {
			return;
		}

		var links = Array.from(container.children).filter(function (el) {
			return el.classList.contains("devotel-footer-nav-col") || el.querySelector("a");
		});

		if (links.length < 5) {
			return;
		}

		var leftColumn = document.createElement("div");
		leftColumn.className = "masonry-left-col";

		var rightColumn = document.createElement("div");
		rightColumn.className = "masonry-right-col";

		// Left (3): Communication APIs (0), Telco (2), Resources (3)
		// Right (2): Platforms (1), Company (4)
		// Resources/Blog last in left column — closest to divider when left column is tallest
		[0, 2, 3].forEach(function (idx) {
			if (links[idx]) {
				leftColumn.appendChild(links[idx].cloneNode(true));
			}
		});
		[1, 4].forEach(function (idx) {
			if (links[idx]) {
				rightColumn.appendChild(links[idx].cloneNode(true));
			}
		});

		container.innerHTML = "";
		container.classList.add("masonry-initialized");
		container.appendChild(leftColumn);
		container.appendChild(rightColumn);
	}

	function boot() {
		initMasonry();
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", function () {
			setTimeout(boot, 100);
		});
	} else {
		setTimeout(boot, 100);
	}

	setTimeout(boot, 500);

	var resizeTimer;
	window.addEventListener("resize", function () {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(initMasonry, 250);
	});
})();
