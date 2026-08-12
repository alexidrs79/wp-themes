/**
 * Devotel header QA — automated checks against devotel.local
 * Run: node tools/qa-header.mjs
 */
import { chromium, devices } from "playwright";

const BASE = process.env.DEVOTEL_QA_URL || "http://devotel.local";
const PAGES = [
	{ name: "homepage", path: "/", bodyClass: "is-home-page", extraClasses: ["devotel-home-solutions-hero"] },
	{ name: "products", path: "/products/", bodyClass: "devotel-inner-page" },
	{ name: "about", path: "/about-us/", bodyClass: "devotel-inner-page" },
	{ name: "contact", path: "/contact-us/", bodyClass: "devotel-inner-page" },
	{ name: "blog", path: "/blog/", bodyClass: "devotel-inner-page", extraClasses: ["devotel-blog-page"] },
	{
		name: "blog-single",
		path: "/blog/business-messaging-101-the-benefits-best-practices-and-use-cases/",
		bodyClass: "devotel-inner-page",
		extraClasses: ["devotel-blog-single-page"],
	},
	{ name: "sim-sms", path: "/products/communication-apis/sms/", bodyClass: "devotel-inner-page" },
	{ name: "sim-otp", path: "/products/sim-based/otp/", bodyClass: "devotel-inner-page", extraClasses: ["devotel-sim-based-page"] },
	{ name: "platform-orbit", path: "/products/platforms/orbit/", bodyClass: "devotel-inner-page" },
	{ name: "privacy", path: "/privacy-policy/", bodyClass: "devotel-inner-page", scrollable: false },
];

const bugs = [];
let passed = 0;
let failed = 0;

function record(id, severity, page, viewport, steps, expected, actual) {
	bugs.push({ id, severity, page, viewport, steps, expected, actual });
	failed++;
}

function pass(msg) {
	console.log("  ✓", msg);
	passed++;
}

function getWrapperSelector() {
	return `.header-navbar-wrapper.devotel-header-elevated, #site-header .header-navbar-wrapper, .header-navbar-wrapper`;
}

async function checkHeader(page, ctx) {
	const { name, viewport } = ctx;

	await page.goto(BASE + ctx.path, { waitUntil: "networkidle", timeout: 60000 });
	await page.waitForSelector(".header-navbar-wrapper", { timeout: 15000 });

	const bodyClass = await page.evaluate(() => document.body.className);
	if (ctx.bodyClass && !bodyClass.includes(ctx.bodyClass)) {
		record(`BODY-${name}`, "P2", name, viewport, "Load page", `body contains ${ctx.bodyClass}`, bodyClass);
	} else {
		pass(`${name}: body class OK`);
	}

	for (const extra of ctx.extraClasses || []) {
		if (!bodyClass.includes(extra)) {
			record(`BODY-${extra}`, "P2", name, viewport, "Load page", `body contains ${extra}`, bodyClass);
		}
	}

	const logoSrcTop = await page.$eval(".header-logo-svg", (el) => el.getAttribute("src"));
	await page.evaluate(() => window.scrollTo(0, 200));
	await page.waitForTimeout(600);
	const logoSrcScrolled = await page.$eval(".header-logo-svg", (el) => el.getAttribute("src"));
	if (logoSrcTop !== logoSrcScrolled) {
		record("LOGO-SRC", "P1", name, viewport, "Scroll to 200", "Same logo src", `${logoSrcTop} → ${logoSrcScrolled}`);
	} else {
		pass(`${name}: logo src stable`);
	}

	const scrolledStyles = await page.evaluate((sel) => {
		const w = document.querySelector(sel);
		if (!w) return null;
		const cs = getComputedStyle(w);
		return {
			hasScrolled: w.classList.contains("header-scrolled"),
			backdropFilter: cs.backdropFilter || cs.webkitBackdropFilter,
			position: cs.position,
			borderRadius: cs.borderRadius,
		};
	}, getWrapperSelector());

	const canScroll =
		ctx.scrollable === false
			? false
			: await page.evaluate(() => document.documentElement.scrollHeight > window.innerHeight + 40);

	if (canScroll) {
		if (!scrolledStyles?.hasScrolled) {
			record("SCROLL-CLASS", "P1", name, viewport, "scrollY=200", ".header-scrolled present", "missing");
		} else {
			pass(`${name}: .header-scrolled at scroll 200`);
		}
	} else {
		pass(`${name}: scroll N/A (short page)`);
	}

	if (scrolledStyles?.backdropFilter && scrolledStyles.backdropFilter !== "none") {
		record("LOGO-BLUR", "P1", name, viewport, "Inspect wrapper at scroll 200", "backdrop-filter: none on wrapper", scrolledStyles.backdropFilter);
	} else {
		pass(`${name}: wrapper backdrop-filter none`);
	}

	if (canScroll && scrolledStyles?.hasScrolled) {
		const radiusPx = parseFloat(scrolledStyles.borderRadius);
		if (Number.isNaN(radiusPx) || radiusPx < 20) {
			record("RADIUS", "P1", name, viewport, "scroll 200", "border-radius ≥ 20px", scrolledStyles.borderRadius);
		} else {
			pass(`${name}: scrolled border-radius ${scrolledStyles.borderRadius}`);
		}
	}

	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(500);
	await page.evaluate(() => window.scrollTo(0, 15));
	await page.waitForTimeout(100);
	const at15 = await page.$eval(".header-navbar-wrapper", (el) => el.classList.contains("header-scrolled"));
	if (at15) {
		record("HYST-15", "P2", name, viewport, "scroll to 15 from top", "not scrolled", "scrolled");
	} else {
		pass(`${name}: hysteresis holds at 15px`);
	}

	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(300);

	if (viewport.includes("1440")) {
		const scrollable = await page.evaluate(
			() => document.documentElement.scrollHeight > window.innerHeight + 80
		);
		if (!scrollable) {
			pass(`${name}: desktop gap skipped (page not scrollable)`);
		} else {
			await page.evaluate(() => window.scrollTo(0, 200));
			await page.waitForTimeout(700);
			const gapInfo = await page.evaluate((sel) => {
				const w = document.querySelector(sel);
				if (!w) return null;
				const admin = document.getElementById("wpadminbar");
				const refBottom = admin ? admin.getBoundingClientRect().bottom : 0;
				const pillTop = w.getBoundingClientRect().top;
				return {
					gap: Math.round((pillTop - refBottom) * 10) / 10,
					scrolled: w.classList.contains("header-scrolled"),
					position: getComputedStyle(w).position,
				};
			}, getWrapperSelector());
			if (!gapInfo?.scrolled) {
				record("DESKTOP-GAP", "P1", name, viewport, "scroll 200", ".header-scrolled", "missing");
			} else if (gapInfo.position !== "fixed") {
				record("DESKTOP-GAP", "P1", name, viewport, "scroll 200", "position:fixed", gapInfo.position);
			} else if (Math.abs(gapInfo.gap - 20) > 4) {
				record("DESKTOP-GAP", "P1", name, viewport, "scroll 200", "~20px gap above pill", "gap=" + gapInfo.gap);
			} else {
				pass(`${name}: desktop 20px gap (actual ${gapInfo.gap}px)`);
			}
		}
	}
}

async function checkLoginVisibility(page, ctx) {
	if (!ctx.viewport.includes("1440")) return;

	await page.goto(BASE + ctx.path, { waitUntil: "networkidle", timeout: 60000 });
	await page.waitForSelector(".header-login-wrapper", { timeout: 15000 });
	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(400);

	const topState = await page.evaluate(() => {
		function parseRgb(color) {
			const m = color.match(/rgba?\(\s*(\d+),\s*(\d+),\s*(\d+)/);
			return m ? [Number(m[1]), Number(m[2]), Number(m[3])] : [255, 255, 255];
		}
		function lum([r, g, b]) {
			const f = (v) => {
				v /= 255;
				return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
			};
			return 0.2126 * f(r) + 0.7152 * f(g) + 0.0722 * f(b);
		}
		function contrast(c1, c2) {
			const l1 = lum(parseRgb(c1));
			const l2 = lum(parseRgb(c2));
			return (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
		}

		const wrap = document.querySelector(".header-login-wrapper");
		const text = document.querySelector(".header-login-text");
		if (!wrap || !text) return { missing: true };
		const wcs = getComputedStyle(wrap);
		const tcs = getComputedStyle(text);
		const rect = wrap.getBoundingClientRect();
		const bg = wcs.backgroundColor;
		const color = tcs.color;
		return {
			missing: false,
			width: rect.width,
			height: rect.height,
			opacity: parseFloat(wcs.opacity),
			visibility: wcs.visibility,
			color,
			bg,
			borderRadius: wcs.borderRadius,
			contrast: contrast(color, bg === "rgba(0, 0, 0, 0)" ? "rgb(255, 255, 255)" : bg),
			isHomeHero: document.body.classList.contains("devotel-home-solutions-hero"),
			scrolled: document.querySelector(".header-navbar-wrapper")?.classList.contains("header-scrolled"),
		};
	});

	if (topState.missing) {
		record("LOGIN-VIS", "P0", ctx.name, ctx.viewport, "Top of page", ".header-login-wrapper present", "missing");
		return;
	}
	if (topState.width < 40 || topState.height < 20 || topState.opacity < 0.9 || topState.visibility !== "visible") {
		record("LOGIN-VIS", "P0", ctx.name, ctx.viewport, "Top of page", "login visible box", JSON.stringify(topState));
	} else if (topState.contrast < 4.5) {
		record("LOGIN-VIS", "P1", ctx.name, ctx.viewport, "Top of page", "contrast ≥ 4.5", `contrast=${topState.contrast.toFixed(2)}`);
	} else {
		pass(`${ctx.name}: login visible at top (contrast ${topState.contrast.toFixed(1)})`);
	}

	await page.evaluate(() => window.scrollTo(0, 250));
	await page.waitForTimeout(700);

	const scrolledState = await page.evaluate(() => {
		const wrap = document.querySelector(".header-login-wrapper");
		const wcs = getComputedStyle(wrap);
		return {
			borderRadius: wcs.borderRadius,
			borderWidth: wcs.borderTopWidth,
			bg: wcs.backgroundColor,
		};
	});

	if (parseFloat(scrolledState.borderRadius) < 9) {
		record("LOGIN-RADIUS", "P2", ctx.name, ctx.viewport, "Scrolled", "login border-radius 10px", scrolledState.borderRadius);
	} else {
		pass(`${ctx.name}: login border-radius at scroll OK`);
	}
}

async function checkMobileMenu(page, ctx) {
	const { name, viewport } = ctx;
	if (!viewport.includes("375")) return;

	await page.goto(BASE + ctx.path, { waitUntil: "networkidle", timeout: 60000 });
	await page.waitForSelector(".header-navbar-wrapper .header-mobile-menu-button", {
		state: "visible",
		timeout: 30000,
	});

	for (const scrollY of [0, 120]) {
		await page.evaluate((y) => window.scrollTo(0, y), scrollY);
		await page.waitForTimeout(800);

		const scrollBefore = await page.evaluate(() => window.scrollY);
		const btn = page.locator(".header-navbar-wrapper .header-mobile-menu-button").first();
		await btn.click();
		await page.waitForTimeout(550);

		const state = await page.evaluate(() => {
			const wrapper =
				document.querySelector(".header-navbar-wrapper.devotel-header-elevated") ||
				document.querySelector(".header-navbar-wrapper");
			const overlay = wrapper
				? wrapper.querySelector("#mobileMenuOverlay")
				: document.getElementById("mobileMenuOverlay");
			const main = wrapper?.querySelector(".header-navbar-main");
			const logo = wrapper?.querySelector(".header-logo-svg");
			const oRect = overlay?.getBoundingClientRect();
			const wRect = wrapper?.getBoundingClientRect();
			const mRect = main?.getBoundingClientRect();
			const oStyle = overlay ? getComputedStyle(overlay) : null;
			const wcs = wrapper ? getComputedStyle(wrapper) : null;
			const mcs = main ? getComputedStyle(main) : null;
			const logoCs = logo ? getComputedStyle(logo) : null;
			return {
				active: overlay?.classList.contains("active"),
				bodyOpen: document.body.classList.contains("devotel-mobile-menu-open"),
				isOpen: document.querySelector(".header-mobile-menu-button")?.classList.contains("is-open"),
				top: oRect?.top,
				mainBottom: mRect?.bottom,
				leftDelta: oRect && wRect ? Math.abs(oRect.left - wRect.left) : 999,
				widthDelta: oRect && wRect ? Math.abs(oRect.width - wRect.width) : 999,
				visibility: oStyle?.visibility,
				opacity: oStyle?.opacity,
				wrapperBg: wcs?.backgroundColor,
				mainBg: mcs?.backgroundColor,
				logoOpacity: logoCs?.opacity,
				logoHeight: logo?.getBoundingClientRect().height,
				headerHidden: document.querySelector(".mobile-menu-header")
					? getComputedStyle(document.querySelector(".mobile-menu-header")).display
					: "none",
			};
		});

		const label = `${name}@${scrollY}px`;
		if (!state.active || !state.bodyOpen || !state.isOpen) {
			record("MENU-OPEN", "P0", name, viewport, `Open menu at scroll ${scrollY}`, "active + body class + is-open", JSON.stringify(state));
		} else {
			pass(`${label}: menu opens`);
		}

		if (state.headerHidden !== "none") {
			record("MENU-DUP", "P2", name, viewport, "Open menu", ".mobile-menu-header display:none", state.headerHidden);
		}

		const wrapperOpaque =
			state.wrapperBg &&
			state.wrapperBg !== "rgba(0, 0, 0, 0)" &&
			state.wrapperBg !== "transparent";
		const mainOpaque =
			state.mainBg && state.mainBg !== "rgba(0, 0, 0, 0)" && state.mainBg !== "transparent";
		if (!wrapperOpaque && !mainOpaque) {
			record("MENU-CHROME", "P0", name, viewport, `Open at scroll ${scrollY}`, "opaque header chrome", `wrapper=${state.wrapperBg} main=${state.mainBg}`);
		} else {
			pass(`${label}: header chrome opaque`);
		}

		if (!state.logoHeight || state.logoHeight < 10 || parseFloat(state.logoOpacity) < 0.9) {
			record("MENU-LOGO", "P0", name, viewport, `Open at scroll ${scrollY}`, "logo visible", JSON.stringify(state));
		} else {
			pass(`${label}: logo visible when menu open`);
		}

		if (state.top !== undefined && state.mainBottom !== undefined && Math.abs(state.top - state.mainBottom) > 2) {
			record("MENU-TOP", "P1", name, viewport, `Open at scroll ${scrollY}`, "panel top ≈ navbar bottom", `top=${state.top} mainBottom=${state.mainBottom}`);
		} else {
			pass(`${label}: panel top aligned`);
		}

		if (state.leftDelta > 2 || state.widthDelta > 2) {
			record("MENU-WIDTH", "P1", name, viewport, `Open at scroll ${scrollY}`, "panel matches wrapper width/left", `Δleft=${state.leftDelta} Δwidth=${state.widthDelta}`);
		} else {
			pass(`${label}: panel width/left aligned`);
		}

		if (state.visibility !== "visible" || parseFloat(state.opacity) < 0.9) {
			record("MENU-VIS", "P0", name, viewport, `Open at scroll ${scrollY}`, "visible panel", `vis=${state.visibility} opacity=${state.opacity}`);
		}

		try {
			await btn.click({ force: true, timeout: 3000 });
		} catch (e) {
			await page.keyboard.press("Escape");
		}
		await page.waitForTimeout(600);
		const scrollAfter = await page.evaluate(() => window.scrollY);
		if (Math.abs(scrollBefore - scrollAfter) > 3) {
			record("MENU-SCROLL", "P1", name, viewport, `Open/close at scroll ${scrollY}`, `scroll stable (${scrollBefore})`, `before=${scrollBefore} after=${scrollAfter}`);
		} else {
			pass(`${label}: scroll position stable after menu`);
		}

		const closed = await page.evaluate(() => {
			const wrapper =
				document.querySelector(".header-navbar-wrapper.devotel-header-elevated") ||
				document.querySelector(".header-navbar-wrapper");
			const overlay = wrapper
				? wrapper.querySelector("#mobileMenuOverlay")
				: document.getElementById("mobileMenuOverlay");
			return {
				active: overlay?.classList.contains("active"),
				position: document.body.style.position,
				locked: document.body.dataset.devotelScrollLocked,
			};
		});
		if (closed.active) {
			record("MENU-CLOSE", "P0", name, viewport, "Close menu", "overlay inactive", "still active");
		} else {
			pass(`${label}: menu closes`);
		}
		if (closed.position === "fixed" || closed.locked === "1") {
			record("MENU-LOCK", "P1", name, viewport, "After close", "body scroll unlocked", JSON.stringify(closed));
		} else {
			pass(`${label}: scroll lock cleared`);
		}
	}
}

async function checkRadiusParity(page, ctx) {
	if (!ctx.viewport.includes("1440")) return;
	if (ctx.name !== "homepage" && ctx.name !== "blog") return;

	await page.goto(BASE + ctx.path, { waitUntil: "networkidle", timeout: 60000 });
	await page.evaluate(() => window.scrollTo(0, 250));
	await page.waitForTimeout(700);

	const radius = await page.evaluate(() => {
		const w = document.querySelector(".header-navbar-wrapper");
		const cs = getComputedStyle(w);
		return {
			radius: cs.borderRadius,
			width: cs.width,
			maxWidth: cs.maxWidth,
		};
	});

	if (!globalThis.__radiusBaseline) {
		globalThis.__radiusBaseline = radius;
		pass(`radius baseline (${ctx.name}): ${radius.radius}`);
	} else {
		const base = globalThis.__radiusBaseline;
		if (radius.radius !== base.radius) {
			record("RADIUS-PARITY", "P1", ctx.name, ctx.viewport, "Scrolled pill", `match homepage (${base.radius})`, radius.radius);
		} else {
			pass(`${ctx.name}: scrolled radius matches homepage (${radius.radius})`);
		}
	}
}

async function checkDesktopMega(page, ctx) {
	if (!ctx.viewport.includes("1440")) return;
	await page.goto(BASE + "/", { waitUntil: "networkidle", timeout: 60000 });
	await page.hover(".header-products-parent");
	await page.waitForTimeout(300);
	const dropdown = await page.evaluate(() => {
		const d = document.querySelector(".header-platform");
		if (!d) return { found: false };
		const r = d.getBoundingClientRect();
		const cs = getComputedStyle(d);
		return { found: true, height: r.height, visibility: cs.visibility, opacity: cs.opacity };
	});
	if (!dropdown.found || dropdown.height < 10) {
		record("MEGA-OPEN", "P1", "homepage", ctx.viewport, "Hover Products", "dropdown visible", JSON.stringify(dropdown));
	} else {
		pass("homepage: Products mega menu visible");
	}
}

async function main() {
	console.log("Devotel header QA —", BASE);
	let browser;
	try {
		browser = await chromium.launch({ headless: true });
	} catch (e) {
		console.error("Playwright chromium not installed. Run: npx playwright install chromium");
		process.exit(2);
	}

	const desktop = { ...devices["Desktop Chrome"], viewport: { width: 1440, height: 900 } };
	const mobile = devices["iPhone 13"];

	globalThis.__radiusBaseline = null;

	for (const p of PAGES) {
		console.log("\n===", p.name, "===");
		const dctx = { ...p, viewport: "1440" };
		const pageD = await browser.newPage({ ...desktop });
		await checkHeader(pageD, dctx);
		await checkLoginVisibility(pageD, dctx);
		await checkRadiusParity(pageD, dctx);
		if (p.name === "homepage") {
			await checkDesktopMega(pageD, dctx);
		}
		await pageD.close();

		const mctx = { ...p, viewport: "375" };
		const pageM = await browser.newPage({ ...mobile });
		await checkHeader(pageM, mctx);
		if (p.scrollable !== false) {
			await checkMobileMenu(pageM, mctx);
		}
		await pageM.close();
	}

	await browser.close();

	console.log("\n========== SUMMARY ==========");
	console.log(`Passed checks: ${passed}`);
	console.log(`Failed checks: ${failed}`);
	if (bugs.length) {
		console.log("\nBUGS:");
		console.log("| ID | Severity | Page | Viewport | Actual |");
		console.log("|----|----------|------|----------|--------|");
		for (const b of bugs) {
			console.log(`| ${b.id} | ${b.severity} | ${b.page} | ${b.viewport} | ${String(b.actual).slice(0, 60)} |`);
		}
	}
	process.exit(bugs.some((b) => b.severity === "P0" || b.severity === "P1") ? 1 : 0);
}

main().catch((e) => {
	console.error(e);
	process.exit(2);
});
