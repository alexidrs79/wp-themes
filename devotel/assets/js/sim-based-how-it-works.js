/**
 * SIM-based product subpages — "How it works" scroll-lock (desktop) + step sync (mobile).
 */
(function () {
	"use strict";

	var LINE_TOP = 24;
	var BADGE_HALF = 24;
	var WHEEL_MIN_DELTA = 10;
	var WHEEL_STEP_THRESHOLD_MOUSE = 320;
	var WHEEL_STEP_THRESHOLD_TOUCHPAD = 120;
	var WHEEL_SMALL_DELTA_CUTOFF = 25;
	var WHEEL_DECAY_MS = 280;
	var STEP_CHANGE_COOLDOWN_MS = 420;
	var ESCAPE_WHEEL_THRESHOLD = 200;

	var hiRoot = document.querySelector(".hi-section");
	if (!hiRoot) {
		return;
	}

	var stepsRow = hiRoot.querySelector(".steps-row");
	var stepsColumn = hiRoot.querySelector(".steps-column");
	var lineTrack = stepsColumn ? stepsColumn.querySelector(".line-track") : null;
	var lineProgress = document.getElementById("hi-line-progress");
	var stepContentEl = document.getElementById("hi-step-content");
	var stepItems = hiRoot.querySelectorAll(".step-item");
	var STEP_COUNT = stepItems.length;
	var LINE_TOTAL = Math.max(512, STEP_COUNT * 200);

	var mobileObserver = null;
	var currentStep = 0;
	var wheelSum = 0;
	var lastWheelTime = 0;
	var lastStepChangeTime = 0;
	var pinY = null;
	var tickId = null;
	var escapeCooldownUntil = 0;

	function isMobile() {
		return window.matchMedia("(max-width: 768px)").matches;
	}

	function prefersReducedMotion() {
		return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	}

	if (!stepsRow || !stepsColumn || !stepItems.length) {
		return;
	}

	var CENTER_MARGIN = 100;
	var ESCAPE_NUDGE_PX = 400;
	var ESCAPE_NUDGE_DOWN_PX = 260;
	var ESCAPE_COOLDOWN_MS = 900;
	var escapeWheelSum = 0;

	function isStepsRowCentered() {
		var r = stepsRow.getBoundingClientRect();
		var vh = window.innerHeight;
		var mid = vh * 0.5;
		return r.top <= mid + CENTER_MARGIN && r.bottom >= mid - CENTER_MARGIN;
	}

	function scrollYToCenterStepsRow() {
		var r = stepsRow.getBoundingClientRect();
		var vh = window.innerHeight;
		var y = window.scrollY || window.pageYOffset;
		return Math.round(y + r.top - vh * 0.5 + r.height * 0.5);
	}

	function clearLock() {
		pinY = null;
		if (tickId != null) {
			cancelAnimationFrame(tickId);
			tickId = null;
		}
	}

	function releaseLockForProgrammaticScroll() {
		clearLock();
		startEscapeCooldown();
	}

	function startEscapeCooldown() {
		escapeCooldownUntil = Date.now() + ESCAPE_COOLDOWN_MS;
	}

	function isInEscapeCooldown() {
		return Date.now() < escapeCooldownUntil;
	}

	function getStepPositions() {
		var top = stepsColumn.getBoundingClientRect().top + (window.scrollY || window.pageYOffset);
		var startY = top + LINE_TOP;
		var out = [];
		var i;
		for (i = 0; i < stepItems.length; i++) {
			var stepY = stepItems[i].getBoundingClientRect().top + (window.scrollY || window.pageYOffset);
			out.push(Math.max(0, Math.min(LINE_TOTAL, stepY + BADGE_HALF - startY)));
		}
		for (var j = 1; j < out.length; j++) {
			if (out[j] <= out[j - 1]) {
				out[j] = out[j - 1] + 1;
			}
		}
		return out;
	}

	function setActiveStep(index) {
		index = Math.max(0, Math.min(STEP_COUNT - 1, index));
		stepItems.forEach(function (el, i) {
			var isCurrent = i === index;
			var isPassed = i < index;
			el.classList.toggle("active", isCurrent);
			el.classList.toggle("passed", isPassed);
			el.setAttribute("aria-current", isCurrent ? "step" : "false");
			var t = el.querySelector(".step-title");
			var d = el.querySelector(".step-desc");
			if (t) {
				t.classList.toggle("inactive", !isCurrent);
			}
			if (d) {
				d.classList.toggle("inactive", !isCurrent);
			}
		});
		if (stepContentEl) {
			stepContentEl.setAttribute("data-step", String(index + 1));
			var panels = stepContentEl.querySelectorAll(".content-panel");
			panels.forEach(function (panel, panelIndex) {
				panel.classList.toggle("active", panelIndex === index);
			});
		}
	}

	function lineWidthForStep(index) {
		var pos = getStepPositions();
		if (index <= 0) {
			return pos[0] || 0;
		}
		if (index >= pos.length) {
			return LINE_TOTAL;
		}
		return pos[index];
	}

	function updateLineTrackWidth() {
		if (isMobile() || !lineTrack) {
			return;
		}
		var pos = getStepPositions();
		var end = pos.length ? pos[pos.length - 1] : 0;
		lineTrack.style.width = Math.round(end) + "px";
	}

	function goToStep(index) {
		currentStep = Math.max(0, Math.min(STEP_COUNT - 1, index));
		var w = Math.round(lineWidthForStep(currentStep));
		if (lineProgress) {
			lineProgress.style.width = w + "px";
		}
		setActiveStep(currentStep);
	}

	function getScrollProgress() {
		var y = window.scrollY || window.pageYOffset;
		var r = stepsColumn.getBoundingClientRect();
		var t = r.top + y;
		var h = r.height;
		var vh = window.innerHeight;
		var start = t - vh;
		var end = t + h * 0.5;
		return Math.max(0, Math.min(1, (y - start) / (end - start)));
	}

	function stepFromProgress(p) {
		var pos = getStepPositions();
		var w = p * LINE_TOTAL;
		var idx = 0;
		for (var i = 0; i < pos.length; i++) {
			if (w >= pos[i]) {
				idx = i;
			}
		}
		return idx;
	}

	function resetProgressToInactive() {
		wheelSum = 0;
		escapeWheelSum = 0;
		lastStepChangeTime = 0;
		currentStep = 0;
		if (lineProgress) {
			lineProgress.style.width = "0px";
		}
		setActiveStep(0);
	}

	function isStepChangeCooldown() {
		return Date.now() - lastStepChangeTime < STEP_CHANGE_COOLDOWN_MS;
	}

	function normalizeWheelDelta(e) {
		var d = e.deltaY;
		var mode = e.deltaMode || 0;
		if (mode === 1) {
			d *= 33;
		} else if (mode === 2) {
			d *= window.innerHeight;
		}
		return d;
	}

	function paintFromScroll() {
		var p = getScrollProgress();
		var maxW = lineWidthForStep(STEP_COUNT - 1);
		var w = Math.min(Math.round(p * LINE_TOTAL), Math.round(maxW));
		if (lineProgress) {
			lineProgress.style.width = w + "px";
		}
		setActiveStep(stepFromProgress(p));
	}

	function pinLoop() {
		if (isMobile() || prefersReducedMotion()) {
			return;
		}
		if (pinY == null) {
			return;
		}
		var y = window.scrollY || window.pageYOffset;
		if (y !== pinY) {
			window.scrollTo({ top: pinY, left: 0, behavior: "auto" });
		}
		tickId = requestAnimationFrame(pinLoop);
	}

	function onScroll() {
		if (isMobile()) {
			return;
		}
		if (prefersReducedMotion()) {
			requestAnimationFrame(paintFromScroll);
			return;
		}
		if (pinY != null) {
			window.scrollTo({ top: pinY, left: 0, behavior: "auto" });
			return;
		}
		if (isInEscapeCooldown()) {
			if (!isStepsRowCentered()) {
				clearLock();
				resetProgressToInactive();
			} else {
				requestAnimationFrame(paintFromScroll);
			}
			return;
		}
		if (!isStepsRowCentered()) {
			clearLock();
			resetProgressToInactive();
			return;
		}
		pinY = scrollYToCenterStepsRow();
		if (pinY == null) {
			return;
		}
		currentStep = 0;
		window.scrollTo({ top: pinY, left: 0, behavior: "auto" });
		tickId = requestAnimationFrame(pinLoop);
		goToStep(0);
	}

	function onWheel(e) {
		if (isMobile() || prefersReducedMotion()) {
			return;
		}
		if (isInEscapeCooldown()) {
			return;
		}
		if (!isStepsRowCentered()) {
			return;
		}

		e.preventDefault();
		e.stopPropagation();

		if (pinY == null) {
			pinY = scrollYToCenterStepsRow();
			if (pinY == null) {
				return;
			}
			currentStep = 0;
			window.scrollTo({ top: pinY, left: 0, behavior: "auto" });
			tickId = requestAnimationFrame(pinLoop);
			goToStep(0);
		}

		var delta = normalizeWheelDelta(e);
		var up = delta < -WHEEL_MIN_DELTA;
		var down = delta > WHEEL_MIN_DELTA;

		if (currentStep !== 0 && currentStep !== STEP_COUNT - 1) {
			escapeWheelSum = 0;
		}

		if (currentStep === 0 && up) {
			escapeWheelSum += delta;
			if (escapeWheelSum < -ESCAPE_WHEEL_THRESHOLD) {
				escapeWheelSum = 0;
				wheelSum = 0;
				clearLock();
				startEscapeCooldown();
				var currentYUp = window.scrollY || window.pageYOffset;
				var nudgeUp = Math.max(ESCAPE_NUDGE_PX, window.innerHeight * 0.55);
				var targetYUp = Math.max(0, currentYUp - nudgeUp);
				window.scrollTo({ top: targetYUp, left: 0, behavior: "auto" });
			}
			return;
		}
		if (currentStep === 0 && down) {
			escapeWheelSum = 0;
		}

		if (currentStep === STEP_COUNT - 1 && down) {
			escapeWheelSum += delta;
			if (escapeWheelSum > ESCAPE_WHEEL_THRESHOLD) {
				escapeWheelSum = 0;
				wheelSum = 0;
				clearLock();
				startEscapeCooldown();
				var maxY = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
				var currentYDown = window.scrollY || window.pageYOffset;
				var nudgeDown = Math.min(ESCAPE_NUDGE_DOWN_PX, window.innerHeight * 0.38);
				var targetYDown = Math.min(maxY, currentYDown + nudgeDown);
				window.scrollTo({ top: targetYDown, left: 0, behavior: "auto" });
			}
			return;
		}
		if (currentStep === STEP_COUNT - 1 && up) {
			escapeWheelSum = 0;
		}

		if (delta === 0) {
			return;
		}

		var now = Date.now();
		if (now - lastWheelTime > WHEEL_DECAY_MS) {
			wheelSum = 0;
			escapeWheelSum = 0;
		}
		lastWheelTime = now;
		if (isStepChangeCooldown()) {
			return;
		}
		if ((delta > 0 && wheelSum < 0) || (delta < 0 && wheelSum > 0)) {
			wheelSum = 0;
		}

		wheelSum += delta;

		var threshold =
			Math.abs(delta) < WHEEL_SMALL_DELTA_CUTOFF
				? WHEEL_STEP_THRESHOLD_TOUCHPAD
				: WHEEL_STEP_THRESHOLD_MOUSE;
		if (wheelSum > threshold && currentStep < STEP_COUNT - 1) {
			wheelSum = 0;
			lastStepChangeTime = Date.now();
			goToStep(currentStep + 1);
		} else if (wheelSum < -threshold && currentStep > 0) {
			wheelSum = 0;
			lastStepChangeTime = Date.now();
			goToStep(currentStep - 1);
		}
	}

	function onKeyDown(e) {
		if (isMobile() || prefersReducedMotion()) {
			return;
		}
		var key = e.key;
		if (key !== "ArrowDown" && key !== "ArrowUp") {
			return;
		}
		if (isInEscapeCooldown()) {
			return;
		}
		if (!isStepsRowCentered()) {
			return;
		}

		if (pinY == null) {
			pinY = scrollYToCenterStepsRow();
			if (pinY == null) {
				return;
			}
			currentStep = 0;
			window.scrollTo(0, pinY);
			tickId = requestAnimationFrame(pinLoop);
			goToStep(0);
		}

		var up = key === "ArrowUp";
		var down = key === "ArrowDown";

		if (currentStep === 0 && up) {
			clearLock();
			startEscapeCooldown();
			var currentYKeyUp = window.scrollY || window.pageYOffset;
			var nudgeKeyUp = Math.max(ESCAPE_NUDGE_PX, window.innerHeight * 0.55);
			var targetYKeyUp = Math.max(0, currentYKeyUp - nudgeKeyUp);
			window.scrollTo(0, targetYKeyUp);
			e.preventDefault();
			return;
		}
		if (currentStep === STEP_COUNT - 1 && down) {
			clearLock();
			startEscapeCooldown();
			var maxYKey = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
			var currentYKeyDown = window.scrollY || window.pageYOffset;
			var nudgeKeyDown = Math.min(ESCAPE_NUDGE_DOWN_PX, window.innerHeight * 0.38);
			var targetYKeyDown = Math.min(maxYKey, currentYKeyDown + nudgeKeyDown);
			window.scrollTo(0, targetYKeyDown);
			e.preventDefault();
			return;
		}

		e.preventDefault();
		if (down && currentStep < STEP_COUNT - 1) {
			goToStep(currentStep + 1);
		} else if (up && currentStep > 0) {
			goToStep(currentStep - 1);
		}
	}

	function initMobile() {
		if (mobileObserver) {
			stepItems.forEach(function (el) {
				mobileObserver.unobserve(el);
			});
			mobileObserver = null;
		}
		if (!isMobile()) {
			return;
		}
		mobileObserver = new IntersectionObserver(
			function (entries) {
				entries.forEach(function (entry) {
					if (!entry.isIntersecting || entry.intersectionRatio < 0.2) {
						return;
					}
					var idx = [].indexOf.call(stepItems, entry.target);
					if (idx !== -1) {
						setActiveStep(idx);
					}
				});
			},
			{ rootMargin: "-15% 0px -55% 0px", threshold: [0, 0.2, 0.5, 1] }
		);
		stepItems.forEach(function (el) {
			mobileObserver.observe(el);
		});
		if (lineProgress) {
			lineProgress.style.width = "0px";
		}
		setActiveStep(0);
	}

	function initDesktop() {
		if (isMobile()) {
			return;
		}
		updateLineTrackWidth();
		if (prefersReducedMotion()) {
			if (isStepsRowCentered()) {
				paintFromScroll();
			} else {
				resetProgressToInactive();
			}
			return;
		}
		if (!isStepsRowCentered()) {
			clearLock();
			resetProgressToInactive();
			return;
		}
		currentStep = 0;
		goToStep(0);
		pinY = scrollYToCenterStepsRow();
		if (pinY != null) {
			window.scrollTo({ top: pinY, left: 0, behavior: "auto" });
			tickId = requestAnimationFrame(pinLoop);
		}
	}

	function onResize() {
		if (isMobile()) {
			initMobile();
			window.removeEventListener("wheel", onWheel);
			window.removeEventListener("keydown", onKeyDown);
		} else {
			if (mobileObserver) {
				stepItems.forEach(function (el) {
					mobileObserver.unobserve(el);
				});
				mobileObserver = null;
			}
			updateLineTrackWidth();
			initDesktop();
			window.removeEventListener("scroll", onScroll);
			window.removeEventListener("wheel", onWheel);
			window.removeEventListener("keydown", onKeyDown);
			window.addEventListener("scroll", onScroll, { passive: true });
			window.addEventListener("wheel", onWheel, { passive: false, capture: true });
			window.addEventListener("keydown", onKeyDown, { capture: true });
		}
	}

	if (isMobile()) {
		initMobile();
	} else {
		window.addEventListener("scroll", onScroll, { passive: true });
		window.addEventListener("wheel", onWheel, { passive: false, capture: true });
		window.addEventListener("keydown", onKeyDown, { capture: true });
		initDesktop();
	}
	window.addEventListener("resize", onResize);
	window.addEventListener("releaseScrollLock", releaseLockForProgrammaticScroll);
})();
