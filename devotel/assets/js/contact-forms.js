/**
 * Initialize bundled Contact Form 7 markup (snapshots / extracted HTML).
 */
(function () {
	"use strict";

	var MOBILE_MAX_WIDTH = 768;
	var ignoreCountryDropdownOutsideClose = false;
	var countryDropdownDocBound = false;

	function isMobileViewport() {
		return window.matchMedia("(max-width: " + MOBILE_MAX_WIDTH + "px)").matches;
	}

	function isMobileUserAgent() {
		return /Android.+Mobile|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
			navigator.userAgent
		);
	}

	function usesItiMobileOverlay() {
		return isMobileUserAgent() || isMobileViewport();
	}

	function isItiCountryListOpen() {
		return !!document.querySelector(
			".intl-tel-input .country-list:not(.hide), body.iti-mobile .iti-container .country-list:not(.hide)"
		);
	}

	function openItiCountryDropdown(flag) {
		var wrap = flag.closest(".intl-tel-input");
		if (!wrap) {
			return false;
		}

		var input = wrap.querySelector(".wpcf7-phonetext, input[type='tel']");
		if (!input || typeof jQuery === "undefined") {
			return false;
		}

		var plugin = jQuery(input).data("plugin_intlTelInput");
		if (plugin && typeof plugin._n === "function") {
			plugin._n();
			return true;
		}

		flag.click();
		return true;
	}

	function bindItiCountryFlagTouchTargets(root) {
		var scope = root || document;
		var selector =
			".final-cta-form-wrapper .intl-tel-input .selected-flag, " +
			".wpcf7-form .intl-tel-input .selected-flag";

		scope.querySelectorAll(selector).forEach(function (flag) {
			if (flag.dataset.devotelItiBound === "1") {
				return;
			}

			flag.dataset.devotelItiBound = "1";

			flag.addEventListener(
				"touchend",
				function () {
					if (!usesItiMobileOverlay()) {
						return;
					}

					window.setTimeout(function () {
						if (isItiCountryListOpen()) {
							return;
						}

						openItiCountryDropdown(flag);
					}, 80);
				},
				{ passive: true }
			);
		});
	}

	function initItiPhoneCountryDropdown(root) {
		bindItiCountryFlagTouchTargets(root);
	}

	function bindPrivacyCheckbox(input) {
		if (!input || input.dataset.devotelPrivacyBound === "1") {
			return;
		}

		input.dataset.devotelPrivacyBound = "1";

		var syncState = function () {
			input.classList.toggle("devotel-checkbox-checked", input.checked);
		};

		input.addEventListener("change", syncState);
		input.addEventListener("click", syncState);
		syncState();

		var row = input.closest("p, label, .wpcf7-form-control-wrap, .form-checkbox-wrapper");
		if (!row) {
			return;
		}

		row.querySelectorAll("label").forEach(function (label) {
			if (label.querySelector("input[type='checkbox']") === input) {
				return;
			}
			label.addEventListener("click", function (event) {
				if (event.target === input) {
					return;
				}
				event.preventDefault();
				input.checked = !input.checked;
				input.dispatchEvent(new Event("change", { bubbles: true }));
			});
		});
	}

	function initPrivacyCheckboxes() {
		var selector = [
			".final-cta-form-wrapper input[type='checkbox'][name='privacy-policy']",
			".final-cta-form-wrapper input[type='checkbox'][data-name='privacy-policy']",
			".wpcf7-form input[type='checkbox'][name='privacy-policy']",
			".wpcf7-form input[type='checkbox'][data-name='privacy-policy']",
		].join(", ");

		document.querySelectorAll(selector).forEach(bindPrivacyCheckbox);
	}

	function replaceItiArrow(root) {
		if (!root || !root.querySelectorAll) {
			return;
		}

		root.querySelectorAll(".iti-arrow").forEach(function (arrow) {
			if (arrow.querySelector("svg.custom-arrow-svg")) {
				return;
			}

			var svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
			svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
			svg.setAttribute("width", "16");
			svg.setAttribute("height", "16");
			svg.setAttribute("viewBox", "0 0 16 16");
			svg.setAttribute("fill", "none");
			svg.setAttribute("class", "custom-arrow-svg");

			var path = document.createElementNS("http://www.w3.org/2000/svg", "path");
			path.setAttribute("d", "M4 6L8 10L12 6");
			path.setAttribute("stroke", "#A4A7AE");
			path.setAttribute("stroke-width", "1.75");
			path.setAttribute("stroke-linecap", "round");
			path.setAttribute("stroke-linejoin", "round");

			svg.appendChild(path);
			arrow.innerHTML = "";
			arrow.appendChild(svg);
			arrow.style.display = "inline-block";
			arrow.style.width = "16px";
			arrow.style.height = "16px";
		});
	}

	function initItiArrows() {
		document
			.querySelectorAll(
				".final-cta-form-wrapper, .wpcf7-form, .wpcf7-newsletter-wrapper"
			)
			.forEach(function (wrapper) {
				replaceItiArrow(wrapper);
			});
	}

	/**
	 * Desktop only: strip ITI mobile overlay class so the compact inline list stays.
	 * Real phones use body.iti-mobile (UA-based) — never remove that class there.
	 */
	function normalizePhoneCountryDropdownForDesktop() {
		if (!usesItiMobileOverlay()) {
			document.body.classList.remove("iti-mobile");
		}
	}

	function schedulePhoneCountryDropdownFix() {
		if (usesItiMobileOverlay()) {
			initItiPhoneCountryDropdown();
			return;
		}

		normalizePhoneCountryDropdownForDesktop();
		window.setTimeout(normalizePhoneCountryDropdownForDesktop, 100);
		window.setTimeout(normalizePhoneCountryDropdownForDesktop, 500);
		window.setTimeout(normalizePhoneCountryDropdownForDesktop, 1500);
	}

	var COUNTRY_FLAG_MAP = {
		GB: "fi-gb",
		US: "fi-us",
		UAE: "fi-ae",
		FR: "fi-fr",
		DE: "fi-de",
		IT: "fi-it",
		ES: "fi-es",
		NL: "fi-nl",
		BE: "fi-be",
		CH: "fi-ch",
		AT: "fi-at",
		SE: "fi-se",
		NO: "fi-no",
		DK: "fi-dk",
		FI: "fi-fi",
		PL: "fi-pl",
		CZ: "fi-cz",
		IE: "fi-ie",
		PT: "fi-pt",
		GR: "fi-gr",
		AU: "fi-au",
		CA: "fi-ca",
		NZ: "fi-nz",
		JP: "fi-jp",
		KR: "fi-kr",
		CN: "fi-cn",
		IN: "fi-in",
		SG: "fi-sg",
		MY: "fi-my",
		TH: "fi-th",
		PH: "fi-ph",
		ID: "fi-id",
		VN: "fi-vn",
		BR: "fi-br",
		MX: "fi-mx",
		AR: "fi-ar",
		CL: "fi-cl",
		CO: "fi-co",
		ZA: "fi-za",
		EG: "fi-eg",
		SA: "fi-sa",
		IL: "fi-il",
		TR: "fi-tr",
		RU: "fi-ru",
	};

	function getCountryFlagClass(countryCode) {
		return COUNTRY_FLAG_MAP[countryCode] || "fi-xx";
	}

	function createFlagElement(countryCode) {
		var flagSpan = document.createElement("span");
		flagSpan.className = "fi " + getCountryFlagClass(countryCode) + " country-flag";
		return flagSpan;
	}

	function appendPhoneCountryArrow(button, wrapper) {
		var existingArrow = wrapper.querySelector(".phone-country-arrow");
		if (existingArrow) {
			button.appendChild(existingArrow.cloneNode(true));
			return;
		}

		var arrow = document.createElementNS("http://www.w3.org/2000/svg", "svg");
		arrow.setAttribute("class", "phone-country-arrow");
		arrow.setAttribute("xmlns", "http://www.w3.org/2000/svg");
		arrow.setAttribute("width", "16");
		arrow.setAttribute("height", "16");
		arrow.setAttribute("viewBox", "0 0 16 16");
		arrow.setAttribute("fill", "none");

		var arrowPath = document.createElementNS("http://www.w3.org/2000/svg", "path");
		arrowPath.setAttribute("d", "M4 6L8 10L12 6");
		arrowPath.setAttribute("stroke", "#A4A7AE");
		arrowPath.setAttribute("stroke-width", "1.75");
		arrowPath.setAttribute("stroke-linecap", "round");
		arrowPath.setAttribute("stroke-linejoin", "round");
		arrow.appendChild(arrowPath);
		button.appendChild(arrow);
	}

	function updateCustomCountryButton(button, wrapper, countryCode) {
		button.innerHTML = "";
		button.appendChild(createFlagElement(countryCode));
		button.appendChild(document.createTextNode(countryCode));
		appendPhoneCountryArrow(button, wrapper);
	}

	function closeAllCustomCountryDropdowns() {
		document.querySelectorAll(".custom-country-dropdown.open").forEach(function (dropdown) {
			dropdown.classList.remove("open");
			var button = dropdown.previousElementSibling;
			if (button && button.classList.contains("custom-country-select-button")) {
				button.setAttribute("aria-expanded", "false");
			}
		});
	}

	function bindCountryDropdownDocumentListeners() {
		if (countryDropdownDocBound) {
			return;
		}

		countryDropdownDocBound = true;

		document.addEventListener(
			"pointerdown",
			function (event) {
				if (ignoreCountryDropdownOutsideClose) {
					return;
				}
				if (event.target.closest(".custom-country-select")) {
					return;
				}
				closeAllCustomCountryDropdowns();
			},
			true
		);

		document.addEventListener("keydown", function (event) {
			if (event.key === "Escape") {
				closeAllCustomCountryDropdowns();
			}
		});
	}

	function bindCustomCountryButton(button, dropdown, select, wrapper) {
		if (button.dataset.devotelCountryBound === "1") {
			return;
		}

		button.dataset.devotelCountryBound = "1";

		button.addEventListener(
			"pointerdown",
			function (event) {
				if (event.pointerType === "touch" || event.pointerType === "pen") {
					event.preventDefault();
				}
				ignoreCountryDropdownOutsideClose = true;
				window.requestAnimationFrame(function () {
					window.requestAnimationFrame(function () {
						ignoreCountryDropdownOutsideClose = false;
					});
				});
			},
			true
		);

		if (button.dataset.devotelCountryManaged !== "central") {
			return;
		}

		button.addEventListener(
			"click",
			function (event) {
				event.preventDefault();
				event.stopPropagation();
				var isOpen = dropdown.classList.contains("open");
				closeAllCustomCountryDropdowns();
				if (!isOpen) {
					dropdown.classList.add("open");
					button.setAttribute("aria-expanded", "true");
				}
			},
			true
		);

		dropdown.querySelectorAll(".custom-country-option").forEach(function (option) {
			if (option.dataset.devotelCountryBound === "1") {
				return;
			}

			option.dataset.devotelCountryBound = "1";

			var selectOption = function (event) {
				if (event) {
					event.preventDefault();
					event.stopPropagation();
				}

				if (!select) {
					return;
				}

				var value = option.getAttribute("data-value");
				if (value === null) {
					return;
				}

				select.value = value;
				select.dispatchEvent(new Event("change", { bubbles: true }));
				updateCustomCountryButton(button, wrapper, value);

				dropdown.querySelectorAll(".custom-country-option").forEach(function (opt) {
					opt.classList.remove("selected");
					opt.setAttribute("aria-selected", "false");
				});
				option.classList.add("selected");
				option.setAttribute("aria-selected", "true");
				dropdown.classList.remove("open");
				button.setAttribute("aria-expanded", "false");
			};

			option.addEventListener("click", selectOption);
			option.addEventListener("pointerup", function (event) {
				if (event.pointerType === "mouse") {
					return;
				}
				selectOption(event);
			});
		});
	}

	function enhanceCustomCountryDropdowns(root) {
		var scope = root || document;

		scope.querySelectorAll(".custom-country-select").forEach(function (customSelect) {
			if (customSelect.dataset.devotelCountryInit === "1") {
				return;
			}

			customSelect.dataset.devotelCountryInit = "1";

			var button = customSelect.querySelector(".custom-country-select-button");
			var dropdown = customSelect.querySelector(".custom-country-dropdown");
			var wrapper = customSelect.closest(".phone-country-code-wrapper");
			var select =
				wrapper &&
				wrapper.querySelector(
					"select.phone-country-code, select.wpcf7-select.phone-country-code, #country-code"
				);

			if (!button || !dropdown) {
				return;
			}

			bindCustomCountryButton(button, dropdown, select, wrapper || customSelect);
		});
	}

	function buildCustomCountryDropdown(select) {
		var wrapper = select.closest(".phone-country-code-wrapper");
		if (!wrapper || wrapper.querySelector(".custom-country-select")) {
			return;
		}

		if (wrapper.dataset.devotelCountryInit === "1") {
			return;
		}

		wrapper.dataset.devotelCountryInit = "1";

		var customSelect = document.createElement("div");
		customSelect.className = "custom-country-select";
		customSelect.dataset.devotelCountryInit = "1";

		var button = document.createElement("button");
		button.type = "button";
		button.className = "custom-country-select-button";
		button.dataset.devotelCountryManaged = "central";
		button.setAttribute("aria-haspopup", "listbox");
		button.setAttribute("aria-expanded", "false");

		var dropdown = document.createElement("div");
		dropdown.className = "custom-country-dropdown";
		dropdown.setAttribute("role", "listbox");

		var currentValue = select.value || (select.options[0] && select.options[0].value) || "";
		updateCustomCountryButton(button, wrapper, currentValue);

		Array.from(select.options).forEach(function (option) {
			var optionDiv = document.createElement("div");
			optionDiv.className = "custom-country-option";
			if (option.value === currentValue) {
				optionDiv.classList.add("selected");
			}

			optionDiv.appendChild(createFlagElement(option.value));
			optionDiv.appendChild(document.createTextNode(option.value));
			optionDiv.setAttribute("data-value", option.value);
			optionDiv.setAttribute("role", "option");
			optionDiv.setAttribute("aria-selected", option.value === currentValue ? "true" : "false");
			dropdown.appendChild(optionDiv);
		});

		customSelect.appendChild(button);
		customSelect.appendChild(dropdown);
		wrapper.insertBefore(customSelect, select);
		select.classList.add("hidden-select");

		bindCustomCountryButton(button, dropdown, select, wrapper);
	}

	function initCustomCountryDropdowns(root) {
		bindCountryDropdownDocumentListeners();

		var scope = root || document;
		var selector =
			".phone-country-code-wrapper select.phone-country-code, " +
			".phone-country-code-wrapper select.wpcf7-select.phone-country-code, " +
			"#country-code, " +
			".wpcf7-select.phone-country-code";

		scope.querySelectorAll(selector).forEach(buildCustomCountryDropdown);
		enhanceCustomCountryDropdowns(scope);
	}

	function observeCustomCountryDropdowns() {
		if (window.__devotelCountryDropdownObserver) {
			return;
		}

		window.__devotelCountryDropdownObserver = new MutationObserver(function () {
			initCustomCountryDropdowns();
		});

		document
			.querySelectorAll(".final-cta-form-wrapper, .wpcf7-form, .wpcf7-newsletter-wrapper")
			.forEach(function (wrapper) {
				window.__devotelCountryDropdownObserver.observe(wrapper, {
					childList: true,
					subtree: true,
				});
			});
	}

	function resetContactFormValidation(form) {
		if (!form || !form.classList.contains("wpcf7-form")) {
			return;
		}

		form.classList.remove("invalid", "sent", "failed", "spam", "unaccepted");
		form.setAttribute("data-status", "init");

		form.querySelectorAll(".wpcf7-not-valid").forEach(function (wrap) {
			wrap.classList.remove("wpcf7-not-valid");
		});

		form.querySelectorAll(".wpcf7-not-valid-tip").forEach(function (tip) {
			tip.textContent = "";
		});

		form.querySelectorAll('[aria-invalid="true"]').forEach(function (field) {
			field.setAttribute("aria-invalid", "false");
		});

		var response = form.querySelector(".wpcf7-response-output");
		if (response) {
			response.textContent = "";
			response.setAttribute("aria-hidden", "true");
			response.style.display = "";
		}

		var wrapper = form.closest(".wpcf7");
		if (wrapper) {
			wrapper.classList.remove(
				"invalid",
				"sent",
				"failed",
				"spam",
				"unaccepted",
				"fcta7cf-wp7-sentouter"
			);
		}
	}

	function resetAllContactForms() {
		document.querySelectorAll(".wpcf7-form").forEach(resetContactFormValidation);
	}

	function initWpcf7Forms() {
		resetAllContactForms();

		if (typeof wpcf7 === "undefined" || typeof wpcf7.init !== "function") {
			return;
		}

		document.querySelectorAll(".wpcf7.no-js").forEach(function (wrapper) {
			try {
				wpcf7.init(wrapper);
			} catch (error) {
				// Ignore duplicate init on live shortcode forms.
			}
		});

		resetAllContactForms();
	}

	function initContactFormAccessibility() {
		document.querySelectorAll('select[name="topic"]:not([aria-label])').forEach(function (select) {
			select.setAttribute("aria-label", "Topic");
		});

		document.querySelectorAll("#devotel-newsletter-email:not([aria-label])").forEach(function (input) {
			input.setAttribute("aria-label", "Email address");
		});
	}

	function initContactForms() {
		if (
			!document.querySelector(
				".final-cta-form-wrapper, .wpcf7-form, .wpcf7-newsletter-wrapper"
			)
		) {
			return;
		}

		initContactFormAccessibility();
		initPrivacyCheckboxes();
		initItiArrows();
		schedulePhoneCountryDropdownFix();
		initItiPhoneCountryDropdown();
		initCustomCountryDropdowns();
		observeCustomCountryDropdowns();
		initWpcf7Forms();

		window.setTimeout(initItiPhoneCountryDropdown, 300);
		window.setTimeout(initItiPhoneCountryDropdown, 1000);
		window.setTimeout(initItiPhoneCountryDropdown, 2500);
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", initContactForms);
	} else {
		initContactForms();
	}

	document.addEventListener("wpcf7submit", initPrivacyCheckboxes);
	document.addEventListener("wpcf7invalid", initPrivacyCheckboxes);
	document.addEventListener("wpcf7submit", initItiArrows);
	document.addEventListener("wpcf7invalid", initItiArrows);
	document.addEventListener("wpcf7submit", initItiPhoneCountryDropdown);
	document.addEventListener("wpcf7invalid", initItiPhoneCountryDropdown);
	document.addEventListener("wpcf7submit", initCustomCountryDropdowns);
	document.addEventListener("wpcf7invalid", initCustomCountryDropdowns);
	document.addEventListener("devotel-cf7-ready", initItiPhoneCountryDropdown);
	document.addEventListener("devotel-cf7-ready", initContactForms);
	window.addEventListener("resize", schedulePhoneCountryDropdownFix);
})();
