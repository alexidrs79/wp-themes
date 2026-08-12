/**
 * Theme-level behavior for extracted sections.
 */
(function () {
	"use strict";

	/**
	 * Fallback for any image still using data-src.
	 */
	function rewriteLegacyImageHost(src) {
		if (!src || src.indexOf("data:image/svg+xml") === 0) {
			return src;
		}

		var origin = window.location.origin;
		return src.replace(/^https?:\/\/devotel\.com/i, origin);
	}

	function hydrateLegacyImages(root) {
		var scope = root && root.querySelectorAll ? root : document;
		var images = root && root.tagName === "IMG" ? [root] : scope.querySelectorAll("img");

		images.forEach(function (img) {
			var currentSrc = img.getAttribute("src") || "";
			var legacySrc = img.getAttribute("data-src") || "";
			var rawTag = img.outerHTML || "";

			if (!currentSrc || currentSrc.indexOf("data:image/svg+xml") === 0) {
				var srcMatches = rawTag.match(/\bsrc="([^"]+)"/gi) || [];
				for (var i = 0; i < srcMatches.length; i++) {
					var srcMatch = srcMatches[i].match(/\bsrc="([^"]+)"/i);
					if (
						srcMatch &&
						srcMatch[1] &&
						srcMatch[1].indexOf("data:image/svg+xml") !== 0 &&
						srcMatch[1].indexOf("/wp-content/uploads/") !== -1
					) {
						img.setAttribute("src", rewriteLegacyImageHost(srcMatch[1]));
						currentSrc = img.getAttribute("src") || "";
						break;
					}
				}
			}

			if (currentSrc.indexOf("data:image/svg+xml") === 0) {
				var uploadsMatch = rawTag.match(/\bsrc="([^"]*\/wp-content\/uploads\/[^"]+)"/i);
				if (uploadsMatch && uploadsMatch[1]) {
					img.setAttribute("src", rewriteLegacyImageHost(uploadsMatch[1]));
					currentSrc = img.getAttribute("src") || "";
				} else if (legacySrc) {
					img.setAttribute("src", rewriteLegacyImageHost(legacySrc));
					currentSrc = img.getAttribute("src") || "";
				}
			}

			if (legacySrc && (!currentSrc || currentSrc.indexOf("data:image/svg+xml") === 0)) {
				img.setAttribute("src", rewriteLegacyImageHost(legacySrc));
				currentSrc = img.getAttribute("src") || "";
			}

			if (currentSrc) {
				var rewritten = rewriteLegacyImageHost(currentSrc);
				if (rewritten !== currentSrc) {
					img.setAttribute("src", rewritten);
				}
			}

			var dataSrcSet = img.getAttribute("data-srcset");
			if (dataSrcSet && !img.getAttribute("srcset")) {
				img.setAttribute("srcset", dataSrcSet.replace(/https?:\/\/devotel\.com/gi, window.location.origin));
			}

			img.removeAttribute("data-src");
			img.removeAttribute("data-srcset");
			img.classList.remove("lazyload", "lazyloading", "lazyloaded");

			var inlineStyle = img.getAttribute("style") || "";
			if (inlineStyle.indexOf("--smush-placeholder") !== -1) {
				var widthMatch = inlineStyle.match(/--smush-placeholder-width:\s*(\d+)px/i);
				var ratioMatch = inlineStyle.match(/--smush-placeholder-aspect-ratio:\s*(\d+)\/(\d+)/i);

				if (!img.getAttribute("width") && widthMatch) {
					var renderedWidth = parseInt(widthMatch[1], 10);
					if (renderedWidth > 0) {
						img.setAttribute("width", String(renderedWidth));
					}
				}

				if (!img.getAttribute("height") && ratioMatch) {
					var ratioWidth = parseInt(ratioMatch[1], 10);
					var ratioHeight = parseInt(ratioMatch[2], 10);
					var attrWidth = parseInt(img.getAttribute("width"), 10) || 0;
					if (ratioWidth > 0 && attrWidth > 0) {
						img.setAttribute(
							"height",
							String(Math.round((attrWidth * ratioHeight) / ratioWidth))
						);
					}
				}

				img.removeAttribute("style");
			}

			if (!img.getAttribute("loading")) {
				img.setAttribute("loading", "lazy");
			}

			if (
				!img.getAttribute("width") &&
				img.closest(".testimonial-card-logo-wrap")
			) {
				img.setAttribute("width", "176");
				img.setAttribute("height", "48");
			}
		});
	}

	/**
	 * Fix extracted Elementor blog loop markup for Lighthouse a11y audits.
	 */
	function fixBlogLoopAccessibility() {
		document.querySelectorAll(".elementor-loop-container[role='list']").forEach(function (container) {
			container.removeAttribute("role");
		});

		document.querySelectorAll('[data-elementor-type="loop-item"]').forEach(function (item) {
			var titleEl = item.querySelector(".elementor-heading-title, h2, h3");
			var title = titleEl ? titleEl.textContent.trim() : "";

			item.querySelectorAll("a[href]").forEach(function (link) {
				if (!title || link.textContent.trim()) {
					return;
				}

				if (!link.getAttribute("aria-label")) {
					link.setAttribute("aria-label", title);
				}
			});
		});
	}

	/**
	 * Add body class once page is fully interactive.
	 */
	function markReady() {
		document.body.classList.add("devotel-ready");
	}

	/**
	 * Clear mobile-menu scroll lock if overlay closed without unlock (or stale inline styles).
	 */
	function isMobileMenuOpen() {
		return (
			document.body.classList.contains("devotel-mobile-menu-open") ||
			document.body.dataset.devotelScrollLocked === "1"
		);
	}

	function elevateHeaderForMenuLock() {
		if (!window.matchMedia("(max-width: 768px)").matches) {
			return;
		}

		if (isOverlayHeaderPage() || isFlushHeroUtilityPage()) {
			return;
		}

		var headerWrapper = getThemeHeaderWrapper();
		var siteHeader = document.getElementById("site-header");
		if (!headerWrapper || headerWrapper.dataset.devotelMenuElevated === "1") {
			return;
		}

		if (siteHeader && headerWrapper.parentElement === siteHeader) {
			var adminBar = document.getElementById("wpadminbar");
			var insertBefore = adminBar ? adminBar.nextSibling : document.body.firstChild;
			document.body.insertBefore(headerWrapper, insertBefore);
		}

		headerWrapper.classList.add("devotel-header-elevated");
		headerWrapper.dataset.devotelMenuElevated = "1";
	}

	function restoreHeaderAfterMenuLock() {
		var headerWrapper = getThemeHeaderWrapper();
		var siteHeader = document.getElementById("site-header");
		if (!headerWrapper || headerWrapper.dataset.devotelMenuElevated !== "1") {
			return;
		}

		delete headerWrapper.dataset.devotelMenuElevated;

		/* Keep navbar on body when shell is collapsed (homepage/SIM/flush-hero). */
		if (isFlushHeroUtilityPage() || isOverlayHeaderPage()) {
			return;
		}

		if (siteHeader && headerWrapper.parentElement !== siteHeader) {
			siteHeader.appendChild(headerWrapper);
			headerWrapper.classList.remove("devotel-header-elevated");
		}
	}

	function lockBodyScrollForMenu() {
		if (isMobileMenuOpen()) {
			return;
		}

		var scrollY =
			window.pageYOffset !== undefined
				? window.pageYOffset
				: document.documentElement.scrollTop;
		var isMobile = window.matchMedia("(max-width: 768px)").matches;

		document.body.dataset.devotelScrollLocked = "1";
		document.body.dataset.devotelScrollY = String(scrollY);

		/* Mobile + overlay pages: overflow lock only (preserves scroll position, no jump). */
		if (isMobile || isOverlayHeaderPage()) {
			document.body.style.overflow = "hidden";
			document.documentElement.style.overflow = "hidden";
			return;
		}

		elevateHeaderForMenuLock();

		document.body.style.position = "fixed";
		document.body.style.top = "-" + scrollY + "px";
		document.body.style.width = "100%";
		document.body.style.overflow = "hidden";
		document.documentElement.style.overflow = "hidden";
	}

	function unlockBodyScrollForMenu() {
		if (document.body.dataset.devotelScrollLocked !== "1") {
			return;
		}

		var isMobile = window.matchMedia("(max-width: 768px)").matches;
		var overlayLock = isOverlayHeaderPage();
		var scrollY = parseInt(document.body.dataset.devotelScrollY || "0", 10) || 0;

		document.body.style.overflow = "";
		document.documentElement.style.overflow = "";
		document.body.style.position = "";
		document.body.style.width = "";
		document.body.style.height = "";
		document.body.style.top = "";
		delete document.body.dataset.devotelScrollLocked;
		delete document.body.dataset.devotelScrollY;

		if (isMobile || overlayLock) {
			return;
		}

		window.devotelScrollRestoring = true;
		restoreHeaderAfterMenuLock();

		window.scrollTo(0, scrollY);
		document.documentElement.scrollTop = scrollY;
		document.body.scrollTop = scrollY;

		requestAnimationFrame(function () {
			window.scrollTo(0, scrollY);
			requestAnimationFrame(function () {
				window.scrollTo(0, scrollY);
				setTimeout(function () {
					if (typeof window.devotelReapplyHeaderLayout === "function") {
						window.devotelReapplyHeaderLayout();
					}
					window.devotelScrollRestoring = false;
				}, 50);
			});
		});
	}

	window.devotelLockBodyScroll = lockBodyScrollForMenu;
	window.devotelUnlockBodyScroll = unlockBodyScrollForMenu;
	window.devotelMenuClosing = false;
	window.devotelScrollRestoring = false;

	function unlockBodyScroll() {
		var overlay = document.getElementById("mobileMenuOverlay");
		var menuVisiblyOpen =
			isMobileMenuOpen() ||
			window.devotelMenuClosing ||
			window.devotelScrollRestoring ||
			(overlay && overlay.classList.contains("active"));

		if (menuVisiblyOpen) {
			return;
		}

		document.body.classList.remove("devotel-mobile-menu-open");
		delete document.body.dataset.devotelScrollLocked;

		var lockedTop = document.body.style.top;
		var scrollY = 0;
		if (lockedTop) {
			scrollY = Math.abs(parseInt(lockedTop, 10)) || 0;
		}

		document.body.style.overflow = "";
		document.body.style.position = "";
		document.body.style.top = "";
		document.body.style.width = "";
		document.body.style.height = "";
		document.documentElement.style.overflow = "";

		if (scrollY > 0) {
			window.scrollTo(0, scrollY);
		}
	}

	function recoverPageState() {
		unlockBodyScroll();
		hydrateLegacyImages();
		syncVisibleFadeSections();
		initSectionFadeIn();
		ensureRecaptchaBadgeOnTop();
		updateAboutHeroGradient();
	}

	/**
	 * Keep the reCAPTCHA v3 badge on body with max z-index so it is not trapped
	 * behind sections that create stacking contexts on mobile.
	 */
	var recaptchaBadgeObserver = null;

	function ensureRecaptchaBadgeOnTop() {
		document.querySelectorAll(".grecaptcha-badge").forEach(function (badge) {
			if (badge.parentElement !== document.body) {
				document.body.appendChild(badge);
			}

			badge.style.setProperty("position", "fixed", "important");
			badge.style.setProperty("z-index", "2147483647", "important");
			badge.style.setProperty("visibility", "visible", "important");
			badge.style.setProperty("pointer-events", "auto", "important");
		});
	}

	function initRecaptchaBadgeLayer() {
		ensureRecaptchaBadgeOnTop();

		if (recaptchaBadgeObserver || !window.MutationObserver) {
			return;
		}

		recaptchaBadgeObserver = new MutationObserver(function () {
			ensureRecaptchaBadgeOnTop();
		});

		recaptchaBadgeObserver.observe(document.body, {
			childList: true,
		});

		window.setTimeout(ensureRecaptchaBadgeOnTop, 500);
		window.setTimeout(ensureRecaptchaBadgeOnTop, 2000);
	}

	function animateCounterElement(el, obs) {
		if (el.dataset.animated === "1") {
			if (obs) {
				obs.unobserve(el);
			}
			return;
		}

		el.dataset.animated = "1";
		var target = 0;
		var suffix = "";

		var suffixEl = null;
		if (el.classList.contains("elementor-counter-number")) {
			target = parseFloat(el.getAttribute("data-to-value") || "0");
			suffixEl = el.parentElement
				? el.parentElement.querySelector(".elementor-counter-number-suffix")
				: null;
			suffix = suffixEl ? suffixEl.textContent.trim() : "";
		} else {
			target = parseFloat(el.getAttribute("data-target") || "0");
			suffix = el.getAttribute("data-suffix") || "";
		}

		var start = performance.now();
		var duration = 1800;

		function setCounterValue(value) {
			var display = String(Math.floor(value));
			if (suffixEl) {
				el.textContent = display;
			} else {
				el.textContent = display + suffix;
			}
		}

		function tick(now) {
			var progress = Math.min((now - start) / duration, 1);
			var eased = 1 - Math.pow(1 - progress, 3);
			var value = Math.floor(target * eased);
			setCounterValue(value);
			if (progress < 1) {
				requestAnimationFrame(tick);
			} else {
				setCounterValue(target);
			}
		}

		requestAnimationFrame(tick);
		if (obs) {
			obs.unobserve(el);
		}
	}

	function animateCounters() {
		var counters = document.querySelectorAll(
			".counter-number[data-target], .elementor-counter-number[data-to-value]"
		);
		if (!counters.length) {
			return;
		}

		var observer = new IntersectionObserver(
			function (entries, obs) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting) {
						return;
					}
					animateCounterElement(entry.target, obs);
				});
			},
			{ threshold: 0.3 }
		);

		counters.forEach(function (counter) {
			observer.observe(counter);
		});
	}

	function initIntegrationsVisibility() {
		document
			.querySelectorAll(".integrations-section .logo-box")
			.forEach(function (el) {
				el.style.opacity = "1";
			});
	}

	/**
	 * Homepage + SIM heroes use a fixed overlay bar; other inner pages use in-flow CSS.
	 */
	function isOverlayHeaderPage() {
		return document.body.classList.contains("devotel-sim-based-page");
	}

	function isStandardStickyHeaderPage() {
		if (
			document.body.classList.contains("devotel-sim-based-page") ||
			isFlushHeroUtilityPage()
		) {
			return false;
		}

		return (
			document.body.classList.contains("is-home-page") ||
			document.body.classList.contains("devotel-inner-page")
		);
	}

	function isMobileOverlayHeaderPage() {
		return window.matchMedia("(max-width: 768px)").matches;
	}

	function isInnerPageInFlowHeader() {
		return isStandardStickyHeaderPage();
	}

	/**
	 * Utility HTML-widget heroes (privacy, brand kit) must sit flush under the sticky bar.
	 */
	function isFlushHeroUtilityPage() {
		return (
			document.body.classList.contains("devotel-privacy-page") ||
			document.body.classList.contains("privacy-policy") ||
			document.body.classList.contains("devotel-brand-kit-page")
		);
	}

	/**
	 * Theme header shell — elevated on body (homepage mobile / utility) or inside #site-header.
	 */
	function getThemeHeaderWrapper() {
		var elevated = document.querySelector(
			".header-navbar-wrapper.devotel-header-elevated"
		);
		if (elevated) {
			return elevated;
		}

		var siteHeader = document.getElementById("site-header");
		if (siteHeader) {
			var inShell = siteHeader.querySelector(".header-navbar-wrapper");
			if (inShell) {
				return inShell;
			}
		}

		return document.querySelector(".header-navbar-wrapper");
	}

	window.devotelGetHeaderWrapper = getThemeHeaderWrapper;

	function elevateHeaderForFlushHero(siteHeader, headerWrapper) {
		if (!siteHeader || !headerWrapper) {
			return;
		}

		if (!headerWrapper.classList.contains("devotel-header-elevated")) {
			var skipLink = document.querySelector(".skip-link");
			var insertBefore = skipLink ? skipLink.nextSibling : siteHeader;
			document.body.insertBefore(headerWrapper, insertBefore);
			headerWrapper.classList.add("devotel-header-elevated");
		}

		siteHeader.style.setProperty("height", "0", "important");
		siteHeader.style.setProperty("min-height", "0", "important");
		siteHeader.style.setProperty("overflow", "visible", "important");
		siteHeader.style.setProperty("margin", "0", "important");
		siteHeader.style.setProperty("padding", "0", "important");
		siteHeader.style.setProperty("border", "0", "important");
		siteHeader.style.setProperty("position", "static", "important");
		siteHeader.style.setProperty("background", "transparent", "important");
		siteHeader.style.setProperty("background-color", "transparent", "important");
	}

	/**
	 * Inner pages: solid white header + clear any overlay-era inline positioning.
	 */
	function applyInnerPageHeaderLayout() {
		if (isMobileOverlayHeaderPage()) {
			return;
		}

		if (!isInnerPageInFlowHeader()) {
			return;
		}

		var siteHeader = document.getElementById("site-header");
		var headerWrapper = getThemeHeaderWrapper();
		var headerMain = headerWrapper
			? headerWrapper.querySelector(".header-navbar-main")
			: document.querySelector(".header-navbar-main");
		var flushHero = isFlushHeroUtilityPage();

		resetHeaderShellForRoute();

		syncAdminBarOffset();

		if (headerWrapper && !headerWrapper.classList.contains("header-scrolled")) {
			headerWrapper.style.removeProperty("background");
			headerWrapper.style.removeProperty("background-color");
		} else if (headerWrapper) {
			headerWrapper.style.removeProperty("background");
			headerWrapper.style.removeProperty("background-color");
		}

		if (headerMain) {
			headerMain.style.removeProperty("background");
			headerMain.style.removeProperty("background-color");
		}

		if (flushHero) {
			elevateHeaderForFlushHero(siteHeader, headerWrapper);
		} else if (siteHeader) {
			siteHeader.style.removeProperty("height");
			siteHeader.style.removeProperty("min-height");
			siteHeader.style.setProperty("position", "static", "important");
			siteHeader.style.setProperty("background", "#ffffff", "important");
			siteHeader.style.setProperty("background-color", "#ffffff", "important");
		}

		if (headerWrapper) {
			syncStickyHeaderLayout(headerWrapper);
		}
	}

	function resetHeaderShellForRoute() {
		var siteHeader = document.getElementById("site-header");
		var headerWrapper = getThemeHeaderWrapper();
		if (!headerWrapper) {
			return;
		}

		if (
			headerWrapper.classList.contains("devotel-header-elevated") &&
			siteHeader &&
			!isFlushHeroUtilityPage() &&
			!isMobileOverlayHeaderPage()
		) {
			siteHeader.appendChild(headerWrapper);
			headerWrapper.classList.remove("devotel-header-elevated");
		}

		clearMobileHeaderInlineStyles(siteHeader, headerWrapper);
	}

	function clearMobileHeaderInlineStyles(siteHeader, headerWrapper) {
		var props = [
			"position",
			"height",
			"min-height",
			"overflow",
			"margin",
			"padding",
			"z-index",
			"transform",
			"top",
			"left",
			"right",
			"width",
			"max-width",
		];

		props.forEach(function (prop) {
			if (siteHeader) {
				siteHeader.style.removeProperty(prop);
			}
			if (headerWrapper) {
				headerWrapper.style.removeProperty(prop);
			}
		});
	}

	/**
	 * Move navbar to body on mobile so position:fixed is viewport-relative
	 * (avoids containing blocks from #site-header, body scroll-lock, etc.).
	 */
	function elevateMobileHeader() {
		var siteHeader = document.getElementById("site-header");
		var headerWrapper = getThemeHeaderWrapper();
		if (!siteHeader || !headerWrapper) {
			return;
		}

		var isMobile = window.matchMedia("(max-width: 768px)").matches;

		if (!isMobile) {
			if (
				headerWrapper.classList.contains("devotel-header-elevated") &&
				!isFlushHeroUtilityPage()
			) {
				siteHeader.appendChild(headerWrapper);
				headerWrapper.classList.remove("devotel-header-elevated");
			}
			if (!isInnerPageInFlowHeader()) {
				clearMobileHeaderInlineStyles(siteHeader, headerWrapper);
			}
			return;
		}

		if (!isMobileOverlayHeaderPage()) {
			if (headerWrapper.classList.contains("devotel-header-elevated")) {
				siteHeader.appendChild(headerWrapper);
				headerWrapper.classList.remove("devotel-header-elevated");
			}
			clearMobileHeaderInlineStyles(siteHeader, headerWrapper);
			return;
		}

		if (!headerWrapper.classList.contains("devotel-header-elevated")) {
			var adminBar = document.getElementById("wpadminbar");
			var insertBefore = adminBar ? adminBar.nextSibling : document.body.firstChild;
			document.body.insertBefore(headerWrapper, insertBefore);
			headerWrapper.classList.add("devotel-header-elevated");
		}

		fixMobileHeaderFixed();
	}

	function syncAdminBarOffset() {
		var adminBar = document.getElementById("wpadminbar");
		var offset =
			adminBar && adminBar.offsetHeight > 0
				? Math.ceil(adminBar.getBoundingClientRect().height)
				: 0;
		document.documentElement.style.setProperty(
			"--devotel-admin-bar-height",
			offset > 0 ? offset + "px" : "0px"
		);
		return offset > 0 ? offset + "px" : "0px";
	}

	/**
	 * Position mobile menu panel below sticky header (all mobile opens).
	 */
	function clearMobileMenuPanelPosition() {
		var wrapper = getThemeHeaderWrapper();
		var overlay = wrapper
			? wrapper.querySelector("#mobileMenuOverlay")
			: document.getElementById("mobileMenuOverlay");
		if (!overlay) {
			return;
		}

		overlay.classList.remove("devotel-mobile-menu-panel");
		[
			"top",
			"left",
			"right",
			"bottom",
			"max-height",
			"width",
			"height",
			"border-radius",
			"border-top-left-radius",
			"border-top-right-radius",
			"border-bottom-left-radius",
			"border-bottom-right-radius",
		].forEach(function (prop) {
			overlay.style.removeProperty(prop);
		});
	}

	function syncMobileMenuPanelPosition() {
		if (!window.matchMedia("(max-width: 768px)").matches) {
			clearMobileMenuPanelPosition();
			return;
		}

		var wrapper = getThemeHeaderWrapper();
		var overlay = wrapper
			? wrapper.querySelector("#mobileMenuOverlay")
			: document.getElementById("mobileMenuOverlay");
		if (!wrapper || !overlay || !overlay.classList.contains("active")) {
			return;
		}

		overlay.classList.add("devotel-mobile-menu-panel");

		var navbarMain = wrapper.querySelector(".header-navbar-main");
		var barEl = navbarMain || wrapper;
		var barRect = barEl.getBoundingClientRect();
		var shellRect = wrapper.getBoundingClientRect();
		var rootStyle = getComputedStyle(document.documentElement);
		var bottomInset =
			parseFloat(
				rootStyle.getPropertyValue("--devotel-header-boxed-inset-mobile").trim()
			) || 12;
		var panelLeft = Math.round(shellRect.left);
		var panelWidth = Math.round(shellRect.width);
		var panelTop = Math.ceil(barRect.bottom);

		overlay.style.setProperty("top", panelTop + "px", "important");
		overlay.style.setProperty("left", panelLeft + "px", "important");
		overlay.style.setProperty("width", panelWidth + "px", "important");
		overlay.style.setProperty("box-sizing", "border-box", "important");
		overlay.style.removeProperty("right");
		overlay.style.setProperty("height", "auto", "important");
		overlay.style.setProperty("min-height", "0", "important");
		overlay.style.setProperty("bottom", bottomInset + "px", "important");
		overlay.style.setProperty(
			"max-height",
			"calc(100dvh - " + (panelTop + bottomInset) + "px)",
			"important"
		);
		overlay.style.setProperty(
			"border-radius",
			"0 0 var(--devotel-header-boxed-radius, 24px) var(--devotel-header-boxed-radius, 24px)",
			"important"
		);
		overlay.style.setProperty("border-top-left-radius", "0", "important");
		overlay.style.setProperty("border-top-right-radius", "0", "important");
	}

	window.devotelSyncMobileMenuPanel = syncMobileMenuPanelPosition;
	window.devotelClearMobileMenuPanel = clearMobileMenuPanelPosition;
	window.devotelSyncScrolledMobileMenu = syncMobileMenuPanelPosition;

	function syncMobileMenuHeaderLayout() {
		if (!window.matchMedia("(max-width: 768px)").matches) {
			return;
		}

		var headerWrapper = getThemeHeaderWrapper();
		if (!headerWrapper) {
			return;
		}

		[
			"top",
			"width",
			"max-width",
			"left",
			"right",
			"margin-left",
			"margin-right",
			"border-radius",
			"border",
			"box-shadow",
		].forEach(function (prop) {
			headerWrapper.style.removeProperty(prop);
		});

		syncMobileMenuPanelPosition();
	}

	window.devotelSyncMobileMenuHeaderLayout = syncMobileMenuHeaderLayout;

	/**
	 * Preserve document flow when inner-page header becomes fixed on scroll.
	 */
	function syncHeaderScrollSpacer(headerWrapper) {
		var siteHeader = document.getElementById("site-header");
		if (!siteHeader || !headerWrapper) {
			return;
		}

		var isDesktop = window.matchMedia("(min-width: 769px)").matches;
		var scrolled = headerWrapper.classList.contains("header-scrolled");
		var needsSpacer =
			scrolled && (isInnerPageInFlowHeader() || isFlushHeroUtilityPage());

		if (needsSpacer) {
			var height = Math.ceil(headerWrapper.getBoundingClientRect().height);
			if (height > 0) {
				siteHeader.style.setProperty("min-height", height + "px", "important");
			}
		} else {
			siteHeader.style.removeProperty("min-height");
		}
	}

	/**
	 * Apply sticky/fixed chrome without overriding boxed-scroll width (CSS-driven).
	 */
	function syncStickyHeaderLayout(headerWrapper) {
		if (!headerWrapper) {
			return;
		}

		var scrolled = headerWrapper.classList.contains("header-scrolled");
		var isMobile = window.matchMedia("(max-width: 768px)").matches;

		if (isOverlayHeaderPage() || isMobileOverlayHeaderPage()) {
			syncHeaderScrollSpacer(headerWrapper);
			return;
		}

		if (!isInnerPageInFlowHeader() && !isFlushHeroUtilityPage()) {
			if (scrolled) {
				headerWrapper.style.removeProperty("width");
				headerWrapper.style.removeProperty("max-width");
				headerWrapper.style.removeProperty("left");
				headerWrapper.style.removeProperty("right");
				headerWrapper.style.removeProperty("top");
				headerWrapper.style.removeProperty("background");
				headerWrapper.style.removeProperty("background-color");
			}
			syncHeaderScrollSpacer(headerWrapper);
			return;
		}

		headerWrapper.style.setProperty(
			"z-index",
			isMobile ? "99999" : "99998",
			"important"
		);

		headerWrapper.style.removeProperty("width");
		headerWrapper.style.removeProperty("max-width");
		headerWrapper.style.removeProperty("left");
		headerWrapper.style.removeProperty("right");
		headerWrapper.style.removeProperty("top");
		headerWrapper.style.removeProperty("position");

		var headerMain = headerWrapper.querySelector(".header-navbar-main");
		if (headerMain) {
			headerMain.style.removeProperty("background");
			headerMain.style.removeProperty("background-color");
		}
		headerWrapper.style.removeProperty("background");
		headerWrapper.style.removeProperty("background-color");

		syncHeaderScrollSpacer(headerWrapper);
	}

	/**
	 * Pin navbar to viewport on homepage + SIM overlay pages (mobile + desktop).
	 */
	function fixOverlayHeaderFixed() {
		var siteHeader = document.getElementById("site-header");
		var headerWrapper = getThemeHeaderWrapper();
		if (!headerWrapper) {
			return;
		}

		var isMobile = window.matchMedia("(max-width: 768px)").matches;
		if (!isOverlayHeaderPage() && !isMobile) {
			syncAdminBarOffset();
			syncMobileMenuPanelPosition();
			return;
		}

		syncAdminBarOffset();

		if (siteHeader) {
			siteHeader.style.setProperty("position", "static", "important");
			siteHeader.style.setProperty("height", "0", "important");
			siteHeader.style.setProperty("min-height", "0", "important");
			siteHeader.style.setProperty("overflow", "visible", "important");
			siteHeader.style.setProperty("margin", "0", "important");
			siteHeader.style.setProperty("padding", "0", "important");
			siteHeader.style.setProperty("z-index", "auto", "important");
			siteHeader.style.setProperty("transform", "none", "important");
		}

		document.body.style.setProperty("transform", "none", "important");
		document.documentElement.style.setProperty("transform", "none", "important");

		headerWrapper.style.setProperty("position", "fixed", "important");
		headerWrapper.style.setProperty("z-index", "99999", "important");
		headerWrapper.style.setProperty("transform", "none", "important");
		headerWrapper.style.removeProperty("margin");

		if (document.body.classList.contains("devotel-mobile-menu-open")) {
			syncMobileMenuHeaderLayout();
			return;
		}

		/* Let CSS drive top/width/insets for both scrolled states — avoids fighting transitions. */
		headerWrapper.style.removeProperty("top");
		headerWrapper.style.removeProperty("width");
		headerWrapper.style.removeProperty("max-width");
		headerWrapper.style.removeProperty("left");
		headerWrapper.style.removeProperty("right");
		headerWrapper.style.removeProperty("margin-left");
		headerWrapper.style.removeProperty("margin-right");

		var height = Math.ceil(headerWrapper.getBoundingClientRect().height);
		if (height > 0) {
			document.documentElement.style.setProperty(
				"--devotel-mobile-header-height",
				height + "px"
			);
		}
		syncMobileMenuPanelPosition();
	}

	function fixMobileHeaderFixed() {
		fixOverlayHeaderFixed();
	}

	/**
	 * Header: blue logo always; transparent → frosted glass on scroll.
	 */
	function initSiteHeader() {
		var headerWrapper = getThemeHeaderWrapper();
		var logo = document.querySelector(".header-logo-svg");
		var config = window.devotelHeader || {};
		var logoDefault = config.logoDefault || "";

		function updateLogo() {
			if (!logo || !logoDefault) {
				return;
			}
			if (logo.getAttribute("src") !== logoDefault) {
				logo.setAttribute("src", logoDefault);
			}
			if (logo.getAttribute("data-src") && logo.getAttribute("data-src") !== logoDefault) {
				logo.setAttribute("data-src", logoDefault);
			}
		}

		function syncHeaderOffset() {
			syncAdminBarOffset();

			if (!headerWrapper) {
				return;
			}

			var height = Math.ceil(headerWrapper.getBoundingClientRect().height);
			if (height > 0) {
				document.documentElement.style.setProperty(
					"--devotel-header-height",
					height + "px"
				);
			}
		}

		function updateHeaderScrolled() {
			headerWrapper = getThemeHeaderWrapper();
			if (!headerWrapper) {
				return;
			}

			if (
				document.body.classList.contains("devotel-mobile-menu-open") ||
				window.devotelMenuClosing
			) {
				syncMobileMenuPanelPosition();
				return;
			}

			syncHeaderOffset();
			var scrollY =
				window.pageYOffset !== undefined
					? window.pageYOffset
					: document.documentElement.scrollTop;
			var isScrolled = headerWrapper.classList.contains("header-scrolled");
			var scrollOn = 24;
			var scrollOff = 8;

			if (!isScrolled && scrollY > scrollOn) {
				headerWrapper.classList.add("header-scrolled");
			} else if (isScrolled && scrollY < scrollOff) {
				headerWrapper.classList.remove("header-scrolled");
			}

			syncStickyHeaderLayout(headerWrapper);
			fixMobileHeaderFixed();
			syncMobileMenuPanelPosition();
			syncHeaderScrollSpacer(headerWrapper);
		}

		updateLogo();
		elevateMobileHeader();
		applyInnerPageHeaderLayout();
		syncHeaderOffset();
		updateHeaderScrolled();
		if (!isMobileMenuOpen()) {
			unlockBodyScroll();
		}
		fixMobileHeaderFixed();
		requestAnimationFrame(function () {
			applyInnerPageHeaderLayout();
			updateHeaderScrolled();
			fixMobileHeaderFixed();
		});
		window.addEventListener("scroll", function () {
			if (window.devotelScrollRestoring || window.devotelMenuClosing) {
				return;
			}
			if (!isMobileMenuOpen()) {
				unlockBodyScroll();
			}
			updateHeaderScrolled();
			fixMobileHeaderFixed();
		}, { passive: true });
		window.addEventListener("resize", function () {
			if (!isMobileMenuOpen()) {
				unlockBodyScroll();
			}
			elevateMobileHeader();
			applyInnerPageHeaderLayout();
			updateHeaderScrolled();
			syncHeaderOffset();
			fixMobileHeaderFixed();
		});

		window.devotelReapplyHeaderLayout = function () {
			elevateMobileHeader();
			applyInnerPageHeaderLayout();
			updateHeaderScrolled();
			fixMobileHeaderFixed();
		};
	}

	function initHomeProductTabs() {
		var roots = document.querySelectorAll("#dvthm-prdsec-root");
		roots.forEach(function (root) {
			if (root.getAttribute("data-dvthm-init") === "1") {
				return;
			}
			var firstTab = root.querySelector(".dvthm-prdsec-tab");
			if (firstTab) {
				firstTab.click();
			}
		});
	}

	/**
	 * Section entrance fade — avoid hiding content already in the viewport.
	 */
	var sectionFadeObserver = null;

	function isSectionInViewport(el) {
		if (!el || !el.getBoundingClientRect) {
			return false;
		}

		var rect = el.getBoundingClientRect();
		var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
		return rect.bottom > 0 && rect.top < viewportHeight;
	}

	function revealFadeSection(el) {
		if (!el || el.classList.contains("is-visible")) {
			return;
		}

		el.classList.add("is-visible");
		hydrateLegacyImages(el);
	}

	function syncVisibleFadeSections() {
		document.querySelectorAll(".devotel-fade-section:not(.is-visible)").forEach(function (el) {
			if (isSectionInViewport(el)) {
				revealFadeSection(el);
			}
		});
	}

	function initSectionFadeIn() {
		var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
		var disableMobileFade = window.matchMedia("(max-width: 767px)").matches;
		var selectors = [
			".devotel-cached-snapshot > .e-con.e-parent",
			".devotel-cached-snapshot > .elementor > .e-con.e-parent",
			".devotel-el-fallback > *",
			".devotel-blog-archive .e-parent",
			".d-devotel-products-all-products > *",
		];
		var sections = [];
		var seen = new Set();

		function shouldSkipSection(el) {
			if (!el || !el.getBoundingClientRect) {
				return true;
			}

			if (
				el.closest(
					"#site-header, #site-footer, footer, .header-navbar-wrapper, .elementor-location-header, .elementor-location-footer, .mobile-menu-overlay, .header-platform, .header-telco, .header-company"
				)
			) {
				return true;
			}

			var rect = el.getBoundingClientRect();
			if (rect.height < 56 || rect.width < 280) {
				return true;
			}
			if (rect.height > window.innerHeight * 1.8) {
				return true;
			}

			var cs = window.getComputedStyle(el);
			if (cs.display === "none" || cs.visibility === "hidden" || cs.opacity === "0") {
				return true;
			}

			return false;
		}

		selectors.forEach(function (selector) {
			document.querySelectorAll(selector).forEach(function (el) {
				if (seen.has(el) || shouldSkipSection(el)) {
					return;
				}
				seen.add(el);
				sections.push(el);
			});
		});

		if (!sections.length) {
			syncVisibleFadeSections();
			return;
		}

		if (reduceMotion || disableMobileFade) {
			sections.forEach(function (el) {
				el.classList.add("devotel-fade-section", "is-visible");
			});
			hydrateLegacyImages();
			return;
		}

		var pending = [];

		sections.forEach(function (el) {
			if (el.classList.contains("devotel-fade-section")) {
				if (isSectionInViewport(el)) {
					revealFadeSection(el);
				} else {
					pending.push(el);
				}
				return;
			}

			el.classList.add("devotel-fade-section");
			if (isSectionInViewport(el)) {
				revealFadeSection(el);
			} else {
				pending.push(el);
			}
		});

		if (!pending.length) {
			return;
		}

		if (!sectionFadeObserver) {
			sectionFadeObserver = new IntersectionObserver(
				function (entries, obs) {
					entries.forEach(function (entry) {
						if (!entry.isIntersecting) {
							return;
						}
						revealFadeSection(entry.target);
						obs.unobserve(entry.target);
					});
				},
				{ threshold: 0.01, rootMargin: "0px 0px -4% 0px" }
			);
		}

		pending.forEach(function (el, idx) {
			if (el.classList.contains("is-visible")) {
				return;
			}
			el.style.setProperty("--devotel-fade-delay", Math.min(idx, 8) * 35 + "ms");
			sectionFadeObserver.observe(el);
		});
	}

	function fixProductsPageLayout() {
		if (!document.body.classList.contains("devotel-products-page")) {
			return;
		}

		var root = document.querySelector(
			".devotel-cached-snapshot .d-devotel-products-all-products, .d-devotel-products-all-products"
		);
		if (!root) {
			return;
		}

		root.style.setProperty("display", "flex", "important");
		root.style.setProperty("flex-direction", "column", "important");
		root.style.setProperty("height", "auto", "important");
		root.style.setProperty("min-height", "0", "important");
		root.style.setProperty("position", "relative", "important");

		[".header-section", ".frame-2147227641", ".cta-main-dark"].forEach(function (selector) {
			var el = root.querySelector(selector);
			if (!el) {
				return;
			}
			el.style.setProperty("position", "relative", "important");
			el.style.setProperty("top", "auto", "important");
			el.style.setProperty("left", "auto", "important");
			el.style.setProperty("right", "auto", "important");
			el.style.setProperty("translate", "none", "important");
			el.style.setProperty("width", "100%", "important");
		});

		var heroCards = root.querySelector(".header-section .frame-2147227575");
		if (heroCards) {
			heroCards.style.setProperty("position", "relative", "important");
			heroCards.style.setProperty("top", "auto", "important");
			heroCards.style.setProperty("left", "auto", "important");
			heroCards.style.setProperty("transform", "none", "important");
			heroCards.style.setProperty("width", "100%", "important");
			heroCards.style.setProperty("max-width", "1240px", "important");
			heroCards.style.setProperty("margin", "32px auto 0", "important");
		}

		root.querySelectorAll('[class*="animate-"], .heading, .supporting-text, .card-172, .card-132, .card-152, .tabs-and-sort, .frame-2147227640').forEach(function (el) {
			el.style.setProperty("opacity", "1", "important");
			el.style.setProperty("visibility", "visible", "important");
			el.style.setProperty("animation", "none", "important");
			el.style.setProperty("transform", "none", "important");
		});

		root.querySelectorAll("img[data-src]").forEach(function (img) {
			var legacySrc = img.getAttribute("data-src") || "";
			if (legacySrc) {
				img.setAttribute("src", legacySrc);
				img.removeAttribute("data-src");
			}
		});
	}

	/**
	 * About hero — blue gradient ends at vertical midpoint of hero images (Figma).
	 */
	var aboutHeroGradientObserver = null;
	var aboutHeroGradientBound = false;

	function getAboutHeroImageMidpoint(img, bandTop) {
		var rect = img.getBoundingClientRect();
		var height = rect.height;
		var width = rect.width;

		if (height < 80) {
			var attrW = parseInt(img.getAttribute("width"), 10) || img.naturalWidth || 0;
			var attrH = parseInt(img.getAttribute("height"), 10) || img.naturalHeight || 0;
			if (attrW > 0 && attrH > 0) {
				var cs = window.getComputedStyle(img);
				var maxW = parseFloat(cs.maxWidth) || 0;
				var maxH = parseFloat(cs.maxHeight) || 0;
				var renderedW = width > 80 ? width : (maxW > 0 ? Math.min(maxW, attrW) : attrW);
				height = renderedW * (attrH / attrW);
				if (maxH > 0) {
					height = Math.min(height, maxH);
				}
			}
		}

		if (height <= 0) {
			return 0;
		}

		return rect.top + height / 2 - bandTop;
	}

	function applyAboutHeroBlueHeight(band, end) {
		if (!band || end <= 0) {
			return;
		}

		var px = Math.round(end) + "px";
		var blue = band.querySelector(".devotel-about-hero-blue");
		if (blue) {
			blue.style.height = px;
		}
		band.style.setProperty("--devotel-about-hero-blue-height", px);
		if (window.innerWidth <= 767) {
			band.style.setProperty("--devotel-about-hero-blue-end", px);
		} else {
			band.style.removeProperty("--devotel-about-hero-blue-end");
		}
	}

	function updateAboutHeroGradient() {
		var band = document.querySelector(".devotel-about-hero-band");
		if (!band) {
			return;
		}

		var imageRow = band.querySelector(".elementor-element-42a5b1c");
		var imageWrap = band.querySelector(".elementor-element-cb4f458");
		var imgs = imageRow ? imageRow.querySelectorAll("img") : band.querySelectorAll("img");
		var bandRect = band.getBoundingClientRect();
		var end = 0;

		Array.prototype.forEach.call(imgs, function (img) {
			var mid = getAboutHeroImageMidpoint(img, bandRect.top);
			if (mid > end) {
				end = mid;
			}
		});

		if (end < 120 && imageWrap) {
			var wrapRect = imageWrap.getBoundingClientRect();
			if (wrapRect.height > 80) {
				end = wrapRect.top + wrapRect.height / 2 - bandRect.top;
			}
		}

		if (end < 120 && imageRow) {
			var rowRect = imageRow.getBoundingClientRect();
			if (rowRect.height > 80) {
				end = rowRect.top + rowRect.height / 2 - bandRect.top;
			}
		}

		applyAboutHeroBlueHeight(band, end);
	}

	function initAboutHeroGradient() {
		if (!document.body.classList.contains("devotel-about-page")) {
			return;
		}

		var band = document.querySelector(".devotel-about-hero-band");
		if (!band) {
			return;
		}

		var schedule = function () {
			window.requestAnimationFrame(updateAboutHeroGradient);
		};

		schedule();
		window.setTimeout(schedule, 100);
		window.setTimeout(schedule, 450);
		window.setTimeout(schedule, 900);
		window.setTimeout(schedule, 1600);

		if (!aboutHeroGradientBound) {
			aboutHeroGradientBound = true;
			var resizeTimer = null;
			window.addEventListener("resize", function () {
				if (resizeTimer) {
					window.clearTimeout(resizeTimer);
				}
				resizeTimer = window.setTimeout(updateAboutHeroGradient, 80);
			});
			window.addEventListener("orientationchange", updateAboutHeroGradient);
			window.addEventListener("load", updateAboutHeroGradient);
		}

		if (!aboutHeroGradientObserver && window.ResizeObserver) {
			aboutHeroGradientObserver = new ResizeObserver(function () {
				updateAboutHeroGradient();
			});
			aboutHeroGradientObserver.observe(band);
			var imageRow = band.querySelector(".elementor-element-42a5b1c");
			var imageWrap = band.querySelector(".elementor-element-cb4f458");
			if (imageRow) {
				aboutHeroGradientObserver.observe(imageRow);
			}
			if (imageWrap) {
				aboutHeroGradientObserver.observe(imageWrap);
			}
		}

		band.querySelectorAll("img").forEach(function (img) {
			var onReady = function () {
				updateAboutHeroGradient();
			};
			if (img.complete) {
				if (typeof img.decode === "function") {
					img.decode().then(onReady).catch(onReady);
				} else {
					onReady();
				}
				return;
			}
			img.addEventListener("load", onReady, { once: true });
		});
	}

	document.addEventListener("DOMContentLoaded", function () {
		unlockBodyScroll();
		resetHeaderShellForRoute();
		elevateMobileHeader();
		applyInnerPageHeaderLayout();
		fixMobileHeaderFixed();
		hydrateLegacyImages();
		fixBlogLoopAccessibility();
		markReady();
		animateCounters();
		initIntegrationsVisibility();
		initSiteHeader();
		initSectionFadeIn();
		initRecaptchaBadgeLayer();
		fixProductsPageLayout();
		initAboutHeroGradient();
		window.setTimeout(initHomeProductTabs, 250);
	});

	window.addEventListener("load", function () {
		recoverPageState();
		ensureRecaptchaBadgeOnTop();
	});

	window.addEventListener("pageshow", function () {
		resetHeaderShellForRoute();
		elevateMobileHeader();
		applyInnerPageHeaderLayout();
		fixMobileHeaderFixed();
		initAboutHeroGradient();
		recoverPageState();
	});

	document.addEventListener("visibilitychange", function () {
		if (document.visibilityState === "visible") {
			recoverPageState();
		}
	});

	requestAnimationFrame(function () {
		resetHeaderShellForRoute();
		elevateMobileHeader();
		applyInnerPageHeaderLayout();
		fixMobileHeaderFixed();
		initAboutHeroGradient();
	});
})();

