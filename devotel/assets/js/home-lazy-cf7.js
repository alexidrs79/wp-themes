/**
 * Lazy-load Contact Form 7 + phone-field assets on homepage when contact section nears viewport.
 */
(function () {
	"use strict";

	var LOADED = false;
	var SELECTOR =
		".final-cta-form-wrapper, .wpcf7-form, .wpcf7-newsletter-wrapper";

	function injectInlineChunks(chunks, prefix) {
		if (!Array.isArray(chunks) || !chunks.length) {
			return Promise.resolve();
		}

		chunks.forEach(function (code, index) {
			var id = (prefix || "script") + "-inline-" + index;
			if (document.getElementById(id)) {
				return;
			}

			var script = document.createElement("script");
			script.id = id;
			script.textContent = code;
			document.body.appendChild(script);
		});

		return Promise.resolve();
	}

	function loadScriptItem(item) {
		if (!item) {
			return Promise.resolve();
		}

		var prefix = item.id || "devotel-script";
		return injectInlineChunks(item.inline, prefix).then(function () {
			if (!item.src) {
				return Promise.resolve();
			}
			return loadScript(item.src);
		});
	}

	function loadScript(src) {
		return new Promise(function (resolve, reject) {
			var existing = document.querySelector('script[src="' + src + '"]');
			if (existing) {
				if (existing.dataset.devotelLoaded === "1") {
					resolve();
					return;
				}
				existing.addEventListener("load", resolve, { once: true });
				existing.addEventListener("error", reject, { once: true });
				return;
			}

			var script = document.createElement("script");
			script.src = src;
			script.async = true;
			script.onload = function () {
				script.dataset.devotelLoaded = "1";
				resolve();
			};
			script.onerror = reject;
			document.body.appendChild(script);
		});
	}

	function loadStylesheet(href, id) {
		if (id && document.getElementById(id)) {
			return Promise.resolve();
		}

		if (!id) {
			var existing = document.querySelector('link[rel="stylesheet"][href="' + href + '"]');
			if (existing) {
				return Promise.resolve();
			}
		}

		return new Promise(function (resolve, reject) {
			var link = document.createElement("link");
			link.rel = "stylesheet";
			link.href = href;
			if (id) {
				link.id = id;
			}
			link.onload = resolve;
			link.onerror = reject;
			document.head.appendChild(link);
		});
	}

	function getLocalizedAssets() {
		var payload = window.devotelLazyCf7 || {};
		return {
			styles: Array.isArray(payload.styles) ? payload.styles : [],
			scripts: Array.isArray(payload.scripts) ? payload.scripts : [],
		};
	}

	function loadCf7Assets() {
		if (LOADED) {
			return Promise.resolve();
		}
		LOADED = true;

		var assets = getLocalizedAssets();
		var chain = Promise.resolve();

		assets.styles.forEach(function (item) {
			if (!item || !item.href) {
				return;
			}
			chain = chain.then(function () {
				return loadStylesheet(item.href, item.id || "");
			});
		});

		if (!assets.styles.length) {
			chain = chain.then(function () {
				return loadStylesheet(
					"https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css",
					"devotel-flag-icons-css"
				);
			});
		}

		if (assets.scripts.length) {
			assets.scripts.forEach(function (item) {
				chain = chain.then(function () {
					return loadScriptItem(item);
				});
			});
		} else {
			var sitekey =
				typeof wpcf7_recaptcha !== "undefined" && wpcf7_recaptcha.sitekey
					? wpcf7_recaptcha.sitekey
					: "";
			var recaptchaSrc = sitekey
				? "https://www.google.com/recaptcha/api.js?render=" +
				  encodeURIComponent(sitekey)
				: "";

			chain = chain.then(function () {
				return loadScript(
					"/wp-content/plugins/contact-form-7/includes/js/index.js"
				);
			});

			if (recaptchaSrc) {
				chain = chain.then(function () {
					return loadScript(recaptchaSrc);
				});
			}
		}

		return chain.then(function () {
			document.dispatchEvent(new CustomEvent("devotel-cf7-ready"));
		});
	}

	function bindTriggers() {
		var targets = document.querySelectorAll(SELECTOR);
		if (!targets.length) {
			return;
		}

		var load = function () {
			loadCf7Assets().catch(function () {
				LOADED = false;
			});
		};

		if (!("IntersectionObserver" in window)) {
			load();
			return;
		}

		var observer = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (entry.isIntersecting) {
						observer.disconnect();
						load();
					}
				});
			},
			{ rootMargin: "300px", threshold: 0.01 }
		);

		targets.forEach(function (el) {
			observer.observe(el);
		});

		document.addEventListener(
			"focusin",
			function (event) {
				if (event.target && event.target.closest(SELECTOR)) {
					observer.disconnect();
					load();
				}
			},
			{ once: true, capture: true }
		);
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", bindTriggers);
	} else {
		bindTriggers();
	}
})();
