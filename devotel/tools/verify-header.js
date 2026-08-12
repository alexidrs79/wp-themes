/**
 * Header verification — boxed scroll, dropdowns, inset symmetry, mobile menu.
 */
import { chromium } from "playwright";

const BASE = "http://devotel.local";
const VIEWPORTS = [
	{ name: "mobile", width: 375, height: 812 },
	{ name: "tablet", width: 768, height: 1024 },
	{ name: "desktop", width: 1440, height: 900 },
	{ name: "wide", width: 1920, height: 1080 },
];

const PAGES = [
	{ path: "/", name: "home" },
	{ path: "/contact-us/", name: "contact" },
	{ path: "/about-us/", name: "about" },
	{ path: "/products/", name: "products" },
	{ path: "/brand-kit/", name: "brand-kit" },
	{ path: "/privacy-policy/", name: "privacy" },
];


function probeMobileGutter() {
	const sel =
		"h1,h2,.heading,.brk9dvtl__mob__heading,.blog-post-page-header .heading,.heading-and-subheading .heading,.elementor-heading-title,.devotel-solutions__headline";
	const els = [...document.querySelectorAll(sel)].filter((el) => {
		const t = (el.textContent || "").trim();
		const r = el.getBoundingClientRect();
		return t.length > 8 && r.width > 50 && r.top > 40 && r.top < 500;
	});
	const el = els.sort((a, b) => a.getBoundingClientRect().top - b.getBoundingClientRect().top)[0];
	if (!el) {
		return { error: "no hero text" };
	}
	let gutterEl = el.parentElement;
	for (let i = 0; i < 12 && gutterEl; i++) {
		const cs = getComputedStyle(gutterEl);
		const pl = parseFloat(cs.paddingLeft) || 0;
		const pr = parseFloat(cs.paddingRight) || 0;
		if (pl >= 15 || pr >= 15) {
			break;
		}
		gutterEl = gutterEl.parentElement;
	}
	if (!gutterEl) {
		gutterEl = el;
	}
	const gr = gutterEl.getBoundingClientRect();
	const gcs = getComputedStyle(gutterEl);
	const pl = parseFloat(gcs.paddingLeft) || 0;
	const pr = parseFloat(gcs.paddingRight) || 0;
	return {
		text: el.textContent.trim().slice(0, 48),
		left: Math.round(gr.left + pl),
		right: Math.round(innerWidth - gr.right + pr),
	};
}

function probeHeader() {
	const w =
		typeof window.devotelGetHeaderWrapper === "function"
			? window.devotelGetHeaderWrapper()
			: document.querySelector(".header-navbar-wrapper");
	if (!w) {
		return { error: "no header" };
	}
	const cs = getComputedStyle(w);
	const r = w.getBoundingClientRect();
	const main = w.querySelector(".header-navbar-main");
	const mainCs = main ? getComputedStyle(main) : null;
	const hero = document.querySelector(
		".header-section, .devotel-about-hero-band, .brk9dvtl__desk__frame-2147228532, .d-devotelutilityprivacy-po .header-section"
	);
	const hR = hero ? hero.getBoundingClientRect() : null;
	const wR = w.getBoundingClientRect();
	return {
		scrollY: Math.round(window.scrollY),
		scrollH: document.documentElement.scrollHeight,
		scrolled: w.classList.contains("header-scrolled"),
		width: Math.round(r.width),
		left: Math.round(r.left),
		right: Math.round(innerWidth - r.right),
		insetLeft: Math.round(r.left),
		insetRight: Math.round(innerWidth - r.right),
		insetDelta: Math.abs(Math.round(r.left) - Math.round(innerWidth - r.right)),
		radius: Math.round(parseFloat(cs.borderRadius) || 0),
		pos: cs.position,
		overflow: cs.overflow,
		mainBg: mainCs ? mainCs.backgroundColor : null,
		heroGap: hR && wR ? Math.round(hR.top - wR.bottom) : null,
		hasPrivacy: !!document.querySelector(".d-devotelutilityprivacy-po"),
	};
}

function navTabPositions() {
	const tabs = ["header-products-parent", "header-telco-parent", "header-company-parent"];
	const out = {};
	for (const cls of tabs) {
		const el = document.querySelector("." + cls);
		if (el) {
			const r = el.getBoundingClientRect();
			out[cls] = { left: Math.round(r.left), width: Math.round(r.width) };
		}
	}
	if (out["header-products-parent"] && out["header-telco-parent"]) {
		out.gapProductsTelco = out["header-telco-parent"].left - (out["header-products-parent"].left + out["header-products-parent"].width);
	}
	if (out["header-telco-parent"] && out["header-company-parent"]) {
		out.gapTelcoCompany = out["header-company-parent"].left - (out["header-telco-parent"].left + out["header-telco-parent"].width);
	}
	return out;
}

async function testDropdown(page, scrollY) {
	await page.evaluate((y) => window.scrollTo(0, y), scrollY);
	await page.waitForTimeout(scrollY > 0 ? 550 : 300);

	const pairs = [
		{ parent: ".header-products-parent", menu: ".header-platform" },
		{ parent: ".header-telco-parent", menu: ".header-telco" },
		{ parent: ".header-company-parent", menu: ".header-company" },
	];

	const results = [];
	for (const { parent, menu } of pairs) {
		const parentLoc = page.locator(parent).first();
		if (!(await parentLoc.count())) {
			results.push({ parent, scrollY, error: "no parent" });
			continue;
		}
		await parentLoc.hover();
		await page.waitForTimeout(300);
		const menuLoc = page.locator(menu).first();
		const visible = await menuLoc.isVisible().catch(() => false);
		const box = visible ? await menuLoc.boundingBox() : null;
		results.push({
			parent,
			scrollY,
			visible,
			width: box ? Math.round(box.width) : 0,
			height: box ? Math.round(box.height) : 0,
		});
		await page.mouse.move(0, 0);
		await page.waitForTimeout(100);
	}
	return results;
}

async function testMorphSmoothness(page) {
	await page.evaluate(() => window.scrollTo(0, 0));
	await page.waitForTimeout(400);

	const samples = await page.evaluate(async () => {
		const w =
			typeof window.devotelGetHeaderWrapper === "function"
				? window.devotelGetHeaderWrapper()
				: document.querySelector(".header-navbar-wrapper");
		if (!w) return { error: "no header" };
		w.classList.remove("header-scrolled");
		window.scrollTo(0, 0);
		await new Promise((r) => requestAnimationFrame(() => requestAnimationFrame(r)));
		const startWidth = w.getBoundingClientRect().width;
		window.scrollTo(0, 200);
		const widths = [startWidth];
		for (let i = 0; i < 6; i++) {
			await new Promise((r) => setTimeout(r, 100));
			widths.push(w.getBoundingClientRect().width);
		}
		const endWidth = widths[widths.length - 1];
		const midChange = Math.abs(widths[2] - startWidth);
		const totalChange = Math.abs(endWidth - startWidth);
		return {
			startWidth: Math.round(startWidth),
			endWidth: Math.round(endWidth),
			widths: widths.map((v) => Math.round(v)),
			midChange: Math.round(midChange),
			totalChange: Math.round(totalChange),
			gradual:
				totalChange <= 30 ||
				(totalChange > 20 && midChange > 5 && midChange < totalChange),
		};
	});
	return samples;
}

async function testMobileCloseFlash(page) {
	await page.evaluate(() => window.scrollTo(0, 500));
	await page.waitForTimeout(300);
	const beforeScroll = await page.evaluate(() => window.scrollY);

	const btn = page.locator(".header-mobile-menu-button").first();
	if (!(await btn.count())) {
		return { skipped: true };
	}

	await btn.click();
	await page.waitForTimeout(400);

	const flashData = await page.evaluate(async () => {
		const btn = document.querySelector(".header-mobile-menu-button");
		const samples = [];

		function sample() {
			const overlay = document.querySelector(".mobile-menu-overlay");
			const footer = document.querySelector(".mobile-menu-footer");
			const fR = footer ? footer.getBoundingClientRect() : null;
			const footerCs = footer ? getComputedStyle(footer) : null;
			samples.push({
				active: overlay ? overlay.classList.contains("active") : false,
				footerLeft: fR ? Math.round(fR.left) : null,
				footerTop: fR ? Math.round(fR.top) : null,
				footerVisible:
					footerCs &&
					footerCs.visibility !== "hidden" &&
					parseFloat(footerCs.opacity || "1") > 0.1,
			});
		}

		const sampler = (async () => {
			const end = Date.now() + 500;
			while (Date.now() < end) {
				sample();
				await new Promise((r) => setTimeout(r, 50));
			}
		})();

		if (btn) {
			btn.click();
		}
		await sampler;

		const flash = samples.some(
			(f) =>
				!f.active &&
				f.footerLeft !== null &&
				f.footerTop !== null &&
				f.footerLeft < 20 &&
				f.footerTop < 80 &&
				f.footerVisible
		);

		return { flash, frameCount: samples.length };
	});

	await page.waitForTimeout(450);
	const afterScroll = await page.evaluate(() => window.scrollY);

	return {
		beforeScroll: Math.round(beforeScroll),
		afterScroll: Math.round(afterScroll),
		flash: flashData.flash,
		frameCount: flashData.frameCount,
	};
}

async function run() {
	const browser = await chromium.launch({ headless: true });
	const results = [];
	const dropdownResults = [];
	const morphResults = [];
	const flashResults = [];

	for (const vp of VIEWPORTS) {
		for (const pageDef of PAGES) {
			const tab = await browser.newPage({ viewport: { width: vp.width, height: vp.height } });
			await tab.goto(BASE + pageDef.path, { waitUntil: "networkidle", timeout: 60000 });
			await tab.waitForTimeout(800);

			const top = await tab.evaluate(probeHeader);
			const mobileGutter = vp.width <= 768 ? await tab.evaluate(probeMobileGutter) : null;
			const navTop = null;

			await tab.evaluate(() => window.scrollTo(0, 200));
			await tab.waitForTimeout(550);
			const scrolled = await tab.evaluate(probeHeader);
			const navScrolled = vp.width >= 769 ? await tab.evaluate(navTabPositions) : null;

			let navScrolledDeep = null;
			if (vp.width >= 769) {
				await tab.evaluate(() => window.scrollTo(0, 400));
				await tab.waitForTimeout(300);
				navScrolledDeep = await tab.evaluate(navTabPositions);
			}

			let menuScroll = null;
			if (vp.width <= 768) {
				menuScroll = await testMobileCloseFlash(tab);
			}

			if (vp.width >= 769 && (pageDef.name === "home" || pageDef.name === "contact")) {
				for (const scrollY of [0, 200]) {
					const dr = await testDropdown(tab, scrollY);
					dropdownResults.push({ vp: vp.name, page: pageDef.name, scrollY, dropdowns: dr });
				}
			}

			if (vp.width >= 1440 && pageDef.name === "contact") {
				const morph = await testMorphSmoothness(tab);
				morphResults.push({ vp: vp.name, page: pageDef.name, morph });
			}

			results.push({
				vp: vp.name,
				page: pageDef.name,
				top,
				mobileGutter,
				scrolled,
				navTop,
				navScrolled,
				navScrolledDeep,
				menuScroll,
			});
			await tab.close();
		}
	}

	await browser.close();

	console.log("=== PROBE RESULTS ===");
	console.log(JSON.stringify(results, null, 2));
	console.log("=== DROPDOWN RESULTS ===");
	console.log(JSON.stringify(dropdownResults, null, 2));
	console.log("=== MORPH RESULTS ===");
	console.log(JSON.stringify(morphResults, null, 2));

	let failed = 0;

	for (const r of results) {
		if (r.page === "privacy" && r.top.scrollH < 2000) {
			console.error(`FAIL privacy content height at ${r.vp}: ${r.top.scrollH}`);
			failed++;
		}
		if (
			r.vp === "mobile" &&
			r.mobileGutter &&
			!r.mobileGutter.error &&
			(Math.abs(r.mobileGutter.left - 16) > 2 || Math.abs(r.mobileGutter.right - 16) > 2)
		) {
			console.error(
				`FAIL mobile gutter on ${r.page}/${r.vp}: left=${r.mobileGutter.left} right=${r.mobileGutter.right} (${r.mobileGutter.text})`
			);
			failed++;
		}
		if (r.scrolled.scrolled && r.vp !== "mobile" && r.scrolled.radius < 20) {
			console.error(`FAIL radius at scroll on ${r.page}/${r.vp}: ${r.scrolled.radius}`);
			failed++;
		}
		if (r.scrolled.scrolled && r.scrolled.mainBg === "rgb(255, 255, 255)") {
			console.error(`FAIL main still white when scrolled on ${r.page}/${r.vp}`);
			failed++;
		}
		if (r.scrolled.scrolled && r.scrolled.overflow === "hidden") {
			console.error(`FAIL overflow hidden when scrolled on ${r.page}/${r.vp}`);
			failed++;
		}
		if (r.menuScroll && !r.menuScroll.skipped) {
			if (Math.abs(r.menuScroll.beforeScroll - r.menuScroll.afterScroll) > 12) {
				console.error(
					`FAIL menu scroll jump on ${r.page}/${r.vp}: ${r.menuScroll.beforeScroll} -> ${r.menuScroll.afterScroll}`
				);
				failed++;
			}
			if (r.menuScroll.flash) {
				console.error(`FAIL mobile menu close flash on ${r.page}/${r.vp}`);
				failed++;
			}
		}
		if (
			(r.page === "brand-kit" || r.page === "privacy") &&
			r.top.heroGap !== null &&
			r.vp !== "mobile" &&
			r.vp !== "tablet" &&
			r.top.heroGap > 2
		) {
			console.error(`FAIL hero gap on ${r.page}/${r.vp}: ${r.top.heroGap}`);
			failed++;
		}
		if (
			(r.page === "brand-kit" || r.page === "privacy") &&
			r.top.heroGap !== null &&
			(r.vp === "mobile" || r.vp === "tablet") &&
			Math.abs(r.top.heroGap - 56) > 6
		) {
			console.error(`FAIL mobile hero gap on ${r.page}/${r.vp}: ${r.top.heroGap}`);
			failed++;
		}
		if (
			r.scrolled.scrolled &&
			(r.vp === "desktop" || r.vp === "wide") &&
			r.scrolled.insetDelta > 2
		) {
			console.error(
				`FAIL inset asymmetry on ${r.page}/${r.vp}: left=${r.scrolled.insetLeft} right=${r.scrolled.insetRight}`
			);
			failed++;
		}
		if (r.navScrolled && r.navScrolledDeep) {
			const g1 = r.navScrolled.gapProductsTelco;
			const g2 = r.navScrolled.gapTelcoCompany;
			const g1d = r.navScrolledDeep.gapProductsTelco;
			const g2d = r.navScrolledDeep.gapTelcoCompany;
			if (g1 != null && g1d != null && Math.abs(g1 - g1d) > 2) {
				console.error(
					`FAIL nav spacing Products↔Telco (scrolled) on ${r.page}/${r.vp}: ${g1} vs ${g1d}`
				);
				failed++;
			}
			if (g2 != null && g2d != null && Math.abs(g2 - g2d) > 2) {
				console.error(
					`FAIL nav spacing Telco↔Company (scrolled) on ${r.page}/${r.vp}: ${g2} vs ${g2d}`
				);
				failed++;
			}
		}
	}

	for (const dr of dropdownResults) {
		for (const d of dr.dropdowns) {
			if (d.error) continue;
			if (!d.visible || d.width < 200) {
				console.error(
					`FAIL dropdown ${d.parent} at scroll ${dr.scrollY} on ${dr.page}/${dr.vp}: visible=${d.visible} width=${d.width}`
				);
				failed++;
			}
		}
	}

	for (const mr of morphResults) {
		if (mr.morph.error) {
			console.error(`FAIL morph test error on ${mr.page}/${mr.vp}`);
			failed++;
		} else if (!mr.morph.gradual) {
			console.error(
				`FAIL morph not gradual on ${mr.page}/${mr.vp}: ${JSON.stringify(mr.morph)}`
			);
			failed++;
		}
	}

	console.log(failed === 0 ? "\nALL CHECKS PASSED" : `\n${failed} CHECK(S) FAILED`);
	process.exit(failed > 0 ? 1 : 0);
}

run().catch((err) => {
	console.error(err);
	process.exit(1);
});
