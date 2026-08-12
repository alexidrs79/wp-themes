<?php
/**
 * Inner page layout — footer-critical CSS + snapshot patches (beats widget inline styles).
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * URI paths that use utility HTML-widget heroes (privacy, brand kit, etc.).
 *
 * @param string $uri_path Relative URI path.
 * @return bool
 */
function devotel_is_utility_inner_page_uri( $uri_path ) {
	$uri_path = trim( (string) $uri_path, '/' );

	return in_array(
		$uri_path,
		array(
			'privacy-policy',
			'brand-kit',
			'about-us',
			'contact-us',
		),
		true
	);
}

/**
 * About hero blue layer — real DOM element + transparent image containers.
 *
 * @return string
 */
function devotel_get_about_hero_blue_layer_css() {
	$hero_transparent = 'body.devotel-about-page .devotel-about-hero-band .elementor-element-42a5b1c,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-cb4f458,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-42a5b1c>.e-con-inner,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-cb4f458>.e-con-inner,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-92dbb07,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-b68bc90,'
		. 'body.devotel-about-page .devotel-about-hero-band .e-con,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-widget-image,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-widget-image .elementor-widget-container'
		. '{background:transparent!important;background-color:transparent!important;background-image:none!important}';

	$hero_text_transparent = 'body.devotel-about-page .devotel-about-hero-band .elementor-element-7ee2817,'
		. 'body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-7ee2817,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element.elementor-element-7ee2817,'
		. 'body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-7ee2817,'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-7ee2817:not(.elementor-motion-effects-element-type-background),'
		. 'body.devotel-about-page .devotel-about-hero-band .elementor-element-7ee2817>.elementor-motion-effects-container>.elementor-motion-effects-layer,'
		. 'body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-7ee2817:not(.elementor-motion-effects-element-type-background),'
		. 'body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-7ee2817>.elementor-motion-effects-container>.elementor-motion-effects-layer'
		. '{background:transparent!important;background-color:transparent!important;background-image:none!important;min-height:0!important;--min-height:0px!important;padding-bottom:64px!important;overflow:visible!important}';

	return 'body.devotel-about-page .devotel-about-hero-band{margin-top:0!important;padding-top:0!important;overflow:visible!important}'
		. '@media (min-width:769px){body.devotel-about-page .devotel-about-hero-band{background:#f9fafb!important;position:relative!important;isolation:isolate!important}'
		. 'body.devotel-about-page .devotel-about-hero-blue{position:absolute!important;left:0!important;right:0!important;top:0!important;width:100%!important;height:620px;min-height:0;background:linear-gradient(180deg,#172154 0%,#325fec 100%)!important;z-index:0!important;pointer-events:none!important}'
		. 'body.devotel-about-page .devotel-about-hero-band:has(.devotel-about-hero-blue)::before{display:none!important;content:none!important}'
		. 'body.devotel-about-page .devotel-about-hero-band:not(:has(.devotel-about-hero-blue))::before{display:block!important;content:""!important;position:absolute;left:0;right:0;top:0;height:var(--devotel-about-hero-blue-height,620px)!important;background:linear-gradient(180deg,#172154 0%,#325fec 100%)!important;z-index:0;pointer-events:none}'
		. 'body.devotel-about-page .devotel-about-hero-band>*:not(.devotel-about-hero-blue){position:relative;z-index:1}'
		. $hero_text_transparent
		. $hero_transparent
		. 'body.devotel-about-page .elementor-element-c1cc0f1,body.devotel-about-page .elementor-12 .elementor-element-c1cc0f1{margin-top:32px!important;--margin-top:32px!important}'
		. 'body.devotel-about-page .elementor-element-cb4f458,body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-cb4f458{margin-top:-40px!important;--margin-top:-40px!important;position:relative!important;top:auto!important;padding-bottom:64px!important}'
		. 'body.devotel-about-page .elementor-element-42a5b1c,body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-42a5b1c{margin-top:0!important;--margin-top:0px!important;overflow:visible!important}'
		. 'body.devotel-about-page .elementor-element-2c18098,body.devotel-about-page.elementor-page-12 .elementor-12 .elementor-element.elementor-element-2c18098{margin-top:0!important;--margin-top:0px!important}}'
		. '@media (max-width:768px){body.devotel-about-page .devotel-about-hero-band{background:#fff!important;position:relative!important}'
		. 'body.devotel-about-page .devotel-about-hero-blue{position:absolute!important;left:0!important;right:0!important;top:0!important;width:100%!important;height:var(--devotel-about-hero-blue-end,100%);background:linear-gradient(180deg,#172154 0%,#325fec 100%)!important;z-index:0!important;pointer-events:none!important}'
		. 'body.devotel-about-page .devotel-about-hero-band:has(.devotel-about-hero-blue)::before{display:none!important}'
		. 'body.devotel-about-page .devotel-about-hero-band>*:not(.devotel-about-hero-blue){position:relative;z-index:1}'
		. $hero_text_transparent . '}';
}

/**
 * Standard sticky header scope: inner pages + homepage (not SIM overlay heroes).
 *
 * @param string $suffix CSS selector suffix (e.g. " .site-main").
 * @return string
 */
function devotel_std_header_selector( $suffix = '' ) {
	return 'body.devotel-inner-page:not(.devotel-sim-based-page)' . $suffix
		. ',body.is-home-page:not(.devotel-sim-based-page)' . $suffix;
}

/**
 * Critical inner-page layout CSS — must load after widget <style> blocks in body.
 *
 * @return string
 */
function devotel_get_inner_page_layout_critical_css() {
	$privacy_brand_econ = 'body.devotel-privacy-page .elementor-element-955add0,body.privacy-policy .elementor-element-955add0,body.devotel-brand-kit-page .elementor-element-8dee260{display:flex!important;flex-direction:column!important;gap:0!important;row-gap:0!important;column-gap:0!important;--gap:0px!important;--row-gap:0px!important;--column-gap:0px!important;align-items:stretch!important;padding-left:0!important;padding-right:0!important;--padding-left:0px!important;--padding-right:0px!important;max-width:none!important}'
		. 'body.devotel-privacy-page .elementor-element-9dbdb93,body.privacy-policy .elementor-element-9dbdb93,body.devotel-brand-kit-page .elementor-element-66c8b32{gap:0!important;row-gap:0!important;--gap:0px!important;--row-gap:0px!important}';

	$privacy_brand_full_bleed = 'body.privacy-policy .d-devotelutilityprivacy-po .header-section,body.devotel-privacy-page .d-devotelutilityprivacy-po .header-section{width:100vw!important;max-width:100vw!important;margin-left:calc(50% - 50vw)!important;margin-right:calc(50% - 50vw)!important;box-sizing:border-box!important}'
		. 'body.devotel-brand-kit-page .brk9dvtl__desk__frame-2147228579,body.devotel-brand-kit-page .brk9dvtl__mob__frame-2147228464{width:100%!important;max-width:none!important}'
		. 'body.devotel-brand-kit-page .brk9dvtl__desk__frame-2147228532,body.devotel-brand-kit-page .brk9dvtl__mob__frame-2147228532{width:100vw!important;max-width:100vw!important;margin-left:calc(50% - 50vw)!important;margin-right:calc(50% - 50vw)!important;box-sizing:border-box!important}';

	$privacy_brand_flush = 'body.devotel-privacy-page #site-header,body.privacy-policy #site-header,body.devotel-brand-kit-page #site-header{display:block!important;height:0!important;min-height:0!important;max-height:none!important;overflow:visible!important;margin:0!important;padding:0!important;border:0!important;background:transparent!important;background-color:transparent!important;position:static!important}'
		. 'body.devotel-privacy-page #site-header:empty,body.privacy-policy #site-header:empty,body.devotel-brand-kit-page #site-header:empty{display:none!important}'
		. 'body.devotel-privacy-page .header-navbar-wrapper.devotel-header-elevated,body.privacy-policy .header-navbar-wrapper.devotel-header-elevated,body.devotel-brand-kit-page .header-navbar-wrapper.devotel-header-elevated{margin-bottom:0!important}'
		. 'body.devotel-privacy-page .site-main,body.privacy-policy .site-main,body.devotel-brand-kit-page .site-main,body.devotel-privacy-page article.devotel-page,body.privacy-policy article.devotel-page,body.devotel-brand-kit-page article.devotel-page,body.devotel-privacy-page .devotel-cached-snapshot,body.privacy-policy .devotel-cached-snapshot,body.devotel-brand-kit-page .devotel-cached-snapshot{margin-top:0!important;padding-top:0!important}'
		. 'body.devotel-privacy-page .elementor-3,body.privacy-policy .elementor-3,body.devotel-privacy-page .elementor-element-955add0,body.privacy-policy .elementor-element-955add0,body.devotel-privacy-page .elementor-element-9dbdb93,body.privacy-policy .elementor-element-9dbdb93,body.devotel-brand-kit-page .elementor-9513,body.devotel-brand-kit-page .elementor-element-8dee260,body.devotel-brand-kit-page .elementor-element-66c8b32,body.devotel-privacy-page .elementor-widget-container,body.privacy-policy .elementor-widget-container,body.devotel-brand-kit-page .elementor-widget-container,body.devotel-brand-kit-page #brk9dvtl-mount{margin-top:0!important;padding-top:0!important;--margin-top:0px!important;--padding-top:0px!important}';

	return devotel_std_header_selector( ' .site-main' ) . '{padding-top:0!important;margin-top:0!important}'
		. devotel_std_header_selector() . '{overflow-x:visible!important;overflow-y:visible!important}'
		. devotel_std_header_selector( ' #site-header' ) . '{background:#fff!important;background-color:#fff!important}'
		. devotel_std_header_selector( ' .header-navbar-wrapper:not(.header-scrolled)' ) . '{background:#fff!important;background-color:#fff!important;border-bottom:1px solid #e2e8f0!important;backdrop-filter:none!important;-webkit-backdrop-filter:none!important}'
		. devotel_std_header_selector( ' .header-navbar-main' ) . '{background:#fff!important;background-color:#fff!important}'
		. devotel_std_header_selector( ' .header-navbar-wrapper:not(.header-scrolled) .header-navbar-main' ) . '{background:#fff!important;background-color:#fff!important}'
		. devotel_std_header_selector( ' .header-navbar-wrapper.header-scrolled .header-navbar-main' ) . '{background:transparent!important;background-color:transparent!important}'
		. '@media (min-width:769px){' . devotel_std_header_selector( ' #site-header' ) . '{position:static!important;top:auto!important;left:auto!important;right:auto!important;width:100%!important;height:auto!important;min-height:0!important;z-index:auto!important}'
		. devotel_std_header_selector( ' #site-header .header-navbar-wrapper:not(.header-scrolled)' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper:not(.header-scrolled)' ) . '{position:sticky!important;top:var(--devotel-admin-bar-height,0px)!important;left:0!important;right:0!important;width:100%!important;max-width:100%!important;z-index:99998!important}'
		. devotel_std_header_selector( ' #site-header .header-navbar-wrapper.header-scrolled' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper.header-scrolled' ) . '{position:fixed!important;z-index:99998!important;top:calc(var(--devotel-admin-bar-height,0px) + var(--devotel-header-boxed-gap,20px))!important;width:min(var(--devotel-header-boxed-max-width,1200px),calc(100% - (var(--devotel-header-boxed-inset,24px) * 2)))!important;max-width:var(--devotel-header-boxed-max-width,1200px)!important;left:0!important;right:0!important;margin-left:auto!important;margin-right:auto!important;border-radius:var(--devotel-header-boxed-radius,24px)!important}'
		. 'body.devotel-privacy-page #site-header,body.privacy-policy #site-header,body.devotel-brand-kit-page #site-header{height:0!important;overflow:visible!important;background:transparent!important;background-color:transparent!important;border:0!important}}'
		. '@media (max-width:768px){' . devotel_std_header_selector( ' #site-header' ) . '{position:static!important;height:0!important;min-height:0!important;overflow:visible!important;margin:0!important;padding:0!important;border:0!important;z-index:auto!important;transform:none!important;background:transparent!important;background-color:transparent!important}'
		. devotel_std_header_selector( ' #site-header .header-navbar-wrapper:not(.header-scrolled)' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper:not(.header-scrolled)' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper.devotel-header-elevated:not(.header-scrolled)' ) . '{position:fixed!important;top:var(--devotel-admin-bar-height,0px)!important;left:0!important;right:0!important;width:100%!important;max-width:100%!important;z-index:99999!important;transform:none!important;margin:0!important}'
		. devotel_std_header_selector( ' #site-header .header-navbar-wrapper.header-scrolled' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper.header-scrolled' ) . ',' . devotel_std_header_selector( ' .header-navbar-wrapper.devotel-header-elevated.header-scrolled' ) . '{position:fixed!important;z-index:99999!important;transform:none!important;top:calc(var(--devotel-admin-bar-height,0px) + var(--devotel-header-boxed-gap-mobile,12px))!important;width:min(var(--devotel-header-boxed-max-width,1200px),calc(100% - (var(--devotel-header-boxed-inset-mobile,12px) * 2)))!important;max-width:min(var(--devotel-header-boxed-max-width,1200px),calc(100% - (var(--devotel-header-boxed-inset-mobile,12px) * 2)))!important;left:0!important;right:0!important;margin-left:auto!important;margin-right:auto!important;border-radius:var(--devotel-header-boxed-radius,24px)!important}'
		. 'body.devotel-mobile-menu-open.devotel-inner-page:not(.devotel-sim-based-page) .header-navbar-wrapper.header-scrolled,body.devotel-mobile-menu-open.devotel-inner-page:not(.devotel-sim-based-page) .header-navbar-wrapper.devotel-header-elevated.header-scrolled,body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled,body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled{width:min(var(--devotel-header-boxed-max-width,1200px),calc(100% - (var(--devotel-header-boxed-inset-mobile,12px) * 2)))!important;max-width:min(var(--devotel-header-boxed-max-width,1200px),calc(100% - (var(--devotel-header-boxed-inset-mobile,12px) * 2)))!important;top:calc(var(--devotel-admin-bar-height,0px) + var(--devotel-header-boxed-gap-mobile,12px))!important;left:0!important;right:0!important;margin-left:auto!important;margin-right:auto!important;border-radius:var(--devotel-header-boxed-radius,24px)!important;border:1px solid rgba(202,213,226,.6)!important;box-shadow:0 8px 32px rgba(15,23,43,.08)!important;z-index:100001!important;overflow:visible!important}'
		. 'body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled:has(.mobile-menu-overlay.active),body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled:has(.mobile-menu-overlay.active){border-bottom-left-radius:0!important;border-bottom-right-radius:0!important}'
		. 'body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled:has(.mobile-menu-overlay.active)::before,body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled:has(.mobile-menu-overlay.active)::before,body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled:has(.mobile-menu-overlay.active) .header-navbar-main,body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled:has(.mobile-menu-overlay.active) .header-navbar-main{border-bottom-left-radius:0!important;border-bottom-right-radius:0!important}'
		. 'body.devotel-mobile-menu-open .header-navbar-wrapper:not(.header-scrolled),body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated:not(.header-scrolled){z-index:100001!important;overflow:visible!important;width:100%!important;max-width:100%!important;top:var(--devotel-admin-bar-height,0px)!important;left:0!important;right:0!important;margin-left:0!important;margin-right:0!important;border-radius:0!important;border:none!important;box-shadow:none!important}'
		. 'body.devotel-mobile-menu-open.is-home-page .header-navbar-wrapper:not(.header-scrolled),body.devotel-mobile-menu-open.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled){background:#fff!important;background-color:#fff!important}'
		. devotel_std_header_selector( ':not(.devotel-privacy-page):not(.privacy-policy):not(.devotel-brand-kit-page) .site-main' ) . '{padding-top:var(--devotel-mobile-header-height,64px)!important;margin-top:0!important}'
		. 'body.devotel-privacy-page #site-header,body.privacy-policy #site-header,body.devotel-brand-kit-page #site-header{height:0!important;overflow:visible!important;background:transparent!important;background-color:transparent!important;border:0!important}}'
		. 'body.devotel-contact-page .elementor-element-9e6c16f,body.devotel-contact-page .elementor-element-bcde5de{margin-top:0!important;--margin-top:0px!important;background:none!important;background-image:none!important}'
		. 'body.devotel-contact-page .elementor-element-38ce168,body.devotel-contact-page #blueback,body.devotel-contact-page .elementor-element-d27c074.blueback{background:radial-gradient(90.99% 90.99% at 51.64% 113.96%,#325fec 0%,#01020a 100%),linear-gradient(266deg,#325fec 0%,#172154 100%)!important;background-size:cover!important}'
		. '@media (min-width:769px){body.devotel-contact-page .elementor-element-9e6c16f{align-items:stretch!important;--align-items:stretch!important}'
		. 'body.devotel-contact-page .elementor-element-38ce168,body.devotel-contact-page #blueback{padding-top:60px!important;--padding-top:60px!important;padding-left:168px!important;--padding-left:168px!important;padding-right:0!important;--padding-right:0px!important;align-self:stretch!important;min-height:100%!important}'
		. 'body.devotel-contact-page .elementor-element-bcfd608{padding-top:60px!important;--padding-top:60px!important;justify-content:flex-start!important;--justify-content:flex-start!important;align-self:stretch!important}'
		. 'body.devotel-contact-page .elementor-element-c77501f{margin-top:0!important;margin-bottom:0!important;align-self:flex-start!important}}'
		. '@media (max-width:768px){body.devotel-contact-page .elementor-element-70b888a{padding-top:var(--devotel-mobile-content-gap,56px)!important;--padding-top:var(--devotel-mobile-content-gap,56px)!important}'
		. 'body.devotel-contact-page .elementor-element-70b888a>.e-con-inner{padding-top:0!important;--padding-top:0px!important}'
		. 'body.devotel-contact-page .elementor-element-1fff65a{margin-top:0!important;--margin-top:0px!important}}'
		. devotel_get_about_hero_blue_layer_css()
		. $privacy_brand_flush
		. $privacy_brand_econ
		. $privacy_brand_full_bleed
		. 'body.privacy-policy .d-devotelutilityprivacy-po,body.devotel-privacy-page .d-devotelutilityprivacy-po{margin-top:0!important;min-height:0!important}'
		. 'body.privacy-policy .d-devotelutilityprivacy-po .navbar-main,body.devotel-privacy-page .d-devotelutilityprivacy-po .navbar-main{display:none!important}'
		. 'body.privacy-policy .d-devotelutilityprivacy-po .header-section,body.devotel-privacy-page .d-devotelutilityprivacy-po .header-section{margin-top:0!important;padding:96px 0!important}'
		. 'body.privacy-policy .d-devotelutilityprivacy-po .blog-post-page-header,body.devotel-privacy-page .d-devotelutilityprivacy-po .blog-post-page-header{padding-top:48px!important}'
		. '@media (max-width:768px){body.privacy-policy .d-devotelutilityprivacy-po .header-section,body.devotel-privacy-page .d-devotelutilityprivacy-po .header-section{padding:var(--devotel-mobile-content-gap,56px) 0 48px!important}'
		. 'body.privacy-policy .d-devotelutilityprivacy-po .blog-post-page-header,body.devotel-privacy-page .d-devotelutilityprivacy-po .blog-post-page-header{padding-top:32px!important}'
		. 'body.privacy-policy .d-devotelutilityprivacy-po .section,body.devotel-privacy-page .d-devotelutilityprivacy-po .section,body.privacy-policy .d-devotelutilityprivacy-po .container,body.devotel-privacy-page .d-devotelutilityprivacy-po .container{padding-left:var(--devotel-mobile-gutter,16px)!important;padding-right:var(--devotel-mobile-gutter,16px)!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__frame-2147228532{min-height:0!important;height:auto!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__frame-2147228540{justify-content:flex-start!important;align-items:center!important;padding-top:var(--devotel-mobile-content-gap,56px)!important;padding-bottom:var(--devotel-mobile-content-gap,56px)!important;padding-left:16px!important;padding-right:16px!important;box-sizing:border-box!important;text-align:center!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__container2{padding-top:0!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__frame-2147228553,body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__heading-and-supporting-text{align-items:center!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__heading,body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page .brk9dvtl__mob__supporting-text{text-align:center!important}}'
		. 'body.devotel-brand-kit-page .brk9dvtl__desk__navbar-main,body.devotel-brand-kit-page .brk9dvtl__mob__header{display:none!important}'
		. 'body.devotel-brand-kit-page #brk9dvtl-mount.brk9dvtl__page,body.devotel-brand-kit-page .brk9dvtl__page{min-height:0!important}'
		. 'body.devotel-brand-kit-page .brk9dvtl__desk__d-brk9dvtl-host,body.devotel-brand-kit-page .brk9dvtl__mob__m-brk9dvtl-host{align-items:flex-start!important;background:transparent!important;padding-top:0!important;margin-top:0!important}'
		. 'body.devotel-brand-kit-page .brk9dvtl__desk-root,body.devotel-brand-kit-page .brk9dvtl__mob-root,body.devotel-brand-kit-page .brk9dvtl__desk__frame-2147228579,body.devotel-brand-kit-page .brk9dvtl__mob__frame-2147228464,body.devotel-brand-kit-page .brk9dvtl__desk__frame-2147228532{padding-top:0!important;margin-top:0!important}';
}

/**
 * Canonical phone dropdown layering + height for all CF7 forms.
 *
 * @return string
 */
function devotel_is_contact_us_page() {
	if ( is_admin() ) {
		return false;
	}

	if ( is_page( 'contact-us' ) ) {
		return true;
	}

	$uri_path = function_exists( 'devotel_get_current_request_cache_path' )
		? devotel_get_current_request_cache_path()
		: '';

	return 'contact-us' === trim( (string) $uri_path, '/' );
}

/**
 * Figma form card padding (35px vertical) for all pages except /contact-us/.
 *
 * @return string
 */
function devotel_get_form_card_padding_css() {
	return 'body:not(.devotel-contact-page) .final-cta-form-wrapper .final-cta-form,'
		. 'body:not(.devotel-contact-page) .final-cta-form-wrapper .wpcf7-form{'
		. 'padding-top:35px!important;padding-bottom:35px!important;'
		. 'padding-left:32px!important;padding-right:32px!important}';
}

/**
 * Replace legacy inline form card padding in embedded widget markup.
 *
 * @param string $markup HTML markup.
 * @return string
 */
function devotel_patch_form_card_padding_markup( $markup ) {
	$markup = (string) $markup;

	if ( '' === $markup || false === stripos( $markup, '32px 34px' ) ) {
		return $markup;
	}

	return preg_replace( '/padding:\s*32px\s+34px/i', 'padding: 35px 32px', $markup );
}

function devotel_get_contact_form_phone_dropdown_css() {
	return '.final-cta-form-wrapper .phone-input-wrapper,.final-cta-form-wrapper .phone-country-code-wrapper,.final-cta-form-wrapper .wpcf7-form-control-wrap:has(.wpcf7-phonetext),.final-cta-form-wrapper .wpcf7-form-control-wrap:has(input[type="tel"]),.final-cta-form-wrapper .intl-tel-input{position:relative!important;z-index:20!important}'
		. '.final-cta-form-wrapper .intl-tel-input .country-list,.final-cta-form-wrapper .country-list,.final-cta-form-wrapper .flag-dropdown .country-list,.final-cta-form-wrapper .intl-tel-input.iti-container .country-list,.final-cta-form-wrapper .custom-country-dropdown{max-height:200px!important;overflow-y:auto!important;overflow-x:hidden!important;z-index:1000!important}'
		. '.final-cta-form-wrapper .intl-tel-input .country-list,.final-cta-form-wrapper .country-list,.final-cta-form-wrapper .flag-dropdown .country-list{width:275px!important;min-width:275px!important;max-width:275px!important;border-radius:8px!important}'
		. '.final-cta-form-wrapper .wpcf7-form>p:has(input[type="checkbox"]),.final-cta-form-wrapper .wpcf7-form>p:has([acceptance]),.final-cta-form-wrapper .wpcf7-form>p:has(.wpcf7-form-control-wrap[data-name="privacy-policy"]),.final-cta-form-wrapper .wpcf7-form-control-wrap[data-name="privacy-policy"]{position:relative!important;z-index:1!important}'
		. '.final-cta-form-wrapper .wpcf7-form input[type="checkbox"],.final-cta-form-wrapper .wpcf7-form-control-wrap input[type="checkbox"],.final-cta-form-wrapper input[type="checkbox"].form-checkbox{z-index:auto!important}'
		. '.final-cta-form-wrapper .intl-tel-input .selected-flag,.final-cta-form-wrapper .intl-tel-input .flag-container{pointer-events:auto!important;cursor:pointer}'
		. '@media (max-width:768px){.final-cta-form-wrapper .wpcf7-form>p:has(.wpcf7-phonetext),.final-cta-form-wrapper .wpcf7-form-control-wrap:has(.wpcf7-phonetext),.final-cta-form-wrapper .phone-input-wrapper,.final-cta-form-wrapper .phone-country-code-wrapper,.final-cta-form-wrapper .intl-tel-input{overflow:visible!important}'
		. '.final-cta-form-wrapper .intl-tel-input .selected-flag,.final-cta-form-wrapper .intl-tel-input .flag-container{min-height:44px!important;min-width:44px!important}}'
		. 'body.iti-mobile .intl-tel-input.iti-container{z-index:100000!important}'
		. 'body.iti-mobile .intl-tel-input .country-list{-webkit-overflow-scrolling:touch}';
}

/**
 * Contact Us locations map + office cards CSS (snapshot-safe).
 *
 * @return string
 */
function devotel_get_contact_locations_css() {
	$path = get_template_directory() . '/assets/css/components/contact-locations.css';

	if ( ! is_readable( $path ) ) {
		return '';
	}

	return (string) file_get_contents( $path );
}

/**
 * Print contact locations CSS after snapshot/widget inline styles.
 */
function devotel_print_contact_locations_footer_css() {
	if ( is_admin() || is_front_page() ) {
		return;
	}

	$uri_path = function_exists( 'devotel_get_current_request_cache_path' )
		? devotel_get_current_request_cache_path()
		: '';

	if ( is_singular( 'page' ) && function_exists( 'devotel_get_cached_uri_path_for_post' ) ) {
		$post_path = devotel_get_cached_uri_path_for_post( (int) get_queried_object_id() );
		if ( '' !== $post_path ) {
			$uri_path = $post_path;
		}
	}

	if ( 'contact-us' !== trim( (string) $uri_path, '/' ) ) {
		return;
	}

	$css = devotel_get_contact_locations_css();
	if ( '' === $css ) {
		return;
	}

	echo '<style id="devotel-contact-locations">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_contact_locations_footer_css', 99996 );

/**
 * Print contact-form fixes after snapshot inline styles.
 */
function devotel_print_contact_form_footer_css() {
	if ( is_admin() ) {
		return;
	}

	echo '<style id="devotel-contact-form-footer">' . devotel_get_contact_form_phone_dropdown_css() . devotel_get_form_card_padding_css() . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_contact_form_footer_css', 99997 );

/**
 * Canonical mobile menu CSS for the theme header (printed after snapshot widget styles).
 *
 * @return string
 */
function devotel_get_mobile_menu_canonical_css() {
	$scope    = '#site-header .header-navbar-wrapper,.header-navbar-wrapper.devotel-header-elevated';
	$overlay   = $scope . ' .mobile-menu-overlay,' . $scope . ' #mobileMenuOverlay';
	$wrap_sel  = $scope;
	$btn_sel   = $scope . ' .header-mobile-menu-button';
	$boxed_w   = 'min(var(--devotel-header-boxed-max-width,1440px),calc(100% - (var(--devotel-header-boxed-inset-mobile,12px) * 2)))';
	$trans     = 'transform .32s cubic-bezier(.4,0,.2,1),opacity .32s cubic-bezier(.4,0,.2,1),visibility 0s linear .32s';
	$trans_in  = 'transform .32s cubic-bezier(.4,0,.2,1),opacity .32s cubic-bezier(.4,0,.2,1),visibility 0s';

	return '@media (max-width:768px){'
		. '@keyframes devotel-mobile-menu-slide-down{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:translateY(0)}}'
		. $overlay
		. '{display:flex!important;position:fixed!important;top:0!important;left:0!important;right:auto!important;bottom:auto!important;width:auto!important;height:auto!important;min-height:0!important;background:#fff!important;z-index:100002!important;overflow:hidden!important;-webkit-overflow-scrolling:touch!important;flex-direction:column!important;transform:translateY(-12px) scale(.98)!important;transform-origin:top center!important;opacity:0!important;transition:' . $trans . '!important;visibility:hidden!important;pointer-events:none!important;border-radius:var(--devotel-header-boxed-radius,24px)!important;border:1px solid rgba(202,213,226,.6)!important;box-shadow:0 8px 32px rgba(15,23,43,.08)!important;will-change:transform,opacity!important}'
		. $overlay . '.active:not(.devotel-menu-closing)'
		. '{visibility:visible!important;pointer-events:auto!important;transform:translateY(0) scale(1)!important;opacity:1!important;transition:' . $trans_in . '!important}'
		. $overlay . '.devotel-menu-closing'
		. '{transform:translateY(-12px) scale(.98)!important;transform-origin:top center!important;opacity:0!important;visibility:hidden!important;pointer-events:none!important;transition:' . $trans . '!important}'
		. $overlay . '.devotel-mobile-menu-panel.active:not(.devotel-menu-closing)'
		. '{height:auto!important;min-height:0!important;box-sizing:border-box!important;border-top-left-radius:0!important;border-top-right-radius:0!important;border-top:0!important;border-bottom-left-radius:var(--devotel-header-boxed-radius,24px)!important;border-bottom-right-radius:var(--devotel-header-boxed-radius,24px)!important;border:1px solid rgba(202,213,226,.6)!important;border-top:none!important}'
		. $overlay . '.devotel-mobile-menu-panel.devotel-menu-closing'
		. '{height:auto!important;min-height:0!important;box-sizing:border-box!important;border-top-left-radius:0!important;border-top-right-radius:0!important;border-top:0!important;border-bottom-left-radius:var(--devotel-header-boxed-radius,24px)!important;border-bottom-right-radius:var(--devotel-header-boxed-radius,24px)!important;border:1px solid rgba(202,213,226,.6)!important;border-top:none!important}'
		. '.site-main .mobile-menu-overlay,.site-main #mobileMenuOverlay{display:none!important;visibility:hidden!important;pointer-events:none!important}'
		. $scope . ' .mobile-menu-header{display:none!important}'
		. $wrap_sel . ':has(.mobile-menu-overlay.active){z-index:100001!important;overflow:visible!important;transition:top .5s cubic-bezier(.4,0,.2,1),width .5s cubic-bezier(.4,0,.2,1),max-width .5s cubic-bezier(.4,0,.2,1),border-radius .5s cubic-bezier(.4,0,.2,1),box-shadow .5s cubic-bezier(.4,0,.2,1)!important}'
		. $wrap_sel . '.header-scrolled:has(.mobile-menu-overlay.active),body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled,body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled,body.devotel-mobile-menu-open.devotel-inner-page:not(.devotel-sim-based-page) .header-navbar-wrapper.header-scrolled,body.devotel-mobile-menu-open.devotel-inner-page:not(.devotel-sim-based-page) .header-navbar-wrapper.devotel-header-elevated.header-scrolled{z-index:100001!important;position:fixed!important;top:calc(var(--devotel-admin-bar-height,0px) + var(--devotel-header-boxed-gap-mobile,12px))!important;width:' . $boxed_w . '!important;max-width:' . $boxed_w . '!important;left:0!important;right:0!important;margin-left:auto!important;margin-right:auto!important;border-radius:var(--devotel-header-boxed-radius,24px)!important;border:1px solid rgba(202,213,226,.6)!important;box-shadow:0 8px 32px rgba(15,23,43,.08)!important;background:#fff!important;background-color:#fff!important;overflow:visible!important;transition:top .5s cubic-bezier(.4,0,.2,1),width .5s cubic-bezier(.4,0,.2,1),max-width .5s cubic-bezier(.4,0,.2,1),border-radius .5s cubic-bezier(.4,0,.2,1),box-shadow .5s cubic-bezier(.4,0,.2,1)!important}'
		. $wrap_sel . '.header-scrolled:has(.mobile-menu-overlay.active),body.devotel-mobile-menu-open .header-navbar-wrapper.header-scrolled:has(.mobile-menu-overlay.active),body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated.header-scrolled:has(.mobile-menu-overlay.active){border-bottom-left-radius:0!important;border-bottom-right-radius:0!important}'
		. $wrap_sel . '.header-scrolled:has(.mobile-menu-overlay.active)::before,' . $wrap_sel . '.header-scrolled:has(.mobile-menu-overlay.active) .header-navbar-main{border-bottom-left-radius:0!important;border-bottom-right-radius:0!important}'
		. 'body.devotel-mobile-menu-open .header-navbar-wrapper:not(.header-scrolled),body.devotel-mobile-menu-open .header-navbar-wrapper.devotel-header-elevated:not(.header-scrolled),body.devotel-mobile-menu-open #site-header .header-navbar-wrapper:not(.header-scrolled){z-index:100001!important;overflow:visible!important;width:100%!important;max-width:100%!important;top:var(--devotel-admin-bar-height,0px)!important;left:0!important;right:0!important;margin-left:0!important;margin-right:0!important;border-radius:0!important;border:none!important;box-shadow:none!important}'
		. $btn_sel . '{z-index:100002!important;position:relative!important;transition:background-color .25s ease!important}'
		. $btn_sel . ' .header-mobile-menu-icon--close{display:none!important}'
		. $btn_sel . '.is-open .header-mobile-menu-icon--open{display:none!important}'
		. $btn_sel . '.is-open .header-mobile-menu-icon--close{display:block!important}'
		. 'body.devotel-mobile-menu-open .header-navbar-main{background-color:#fff!important}'
		. 'body.devotel-mobile-menu-open .header-mobile-menu-button{position:relative!important;z-index:100003!important}'
		. $scope . ' .mobile-menu-content{padding:16px 16px 24px!important;display:flex!important;flex-direction:column!important;gap:0!important;width:100%!important;align-items:center!important;flex:1 1 0!important;overflow-y:auto!important;overflow-x:hidden!important;-webkit-overflow-scrolling:touch!important;min-height:0!important}'
		. $scope . ' .mobile-menu-item{padding:12px 0!important;display:flex!important;flex-direction:row!important;gap:12px!important;align-items:center!important;justify-content:center!important;width:100%!important;cursor:pointer!important;-webkit-tap-highlight-color:transparent!important}'
		. $scope . ' .mobile-menu-item-text{color:#181d27!important;font-family:Inter,sans-serif!important;font-size:16px!important;font-weight:500!important;text-align:left!important}'
		. $scope . ' .mobile-menu-chevron{transition:transform .3s ease!important}'
		. $scope . ' .mobile-menu-divider{border-top:1px solid #cad5e2!important;width:100%!important;height:0!important;margin:0!important}'
		. $scope . ' .mobile-menu-dropdown{display:none!important;padding:0 16px 24px!important;background:#fff!important;width:100%!important;overflow:visible!important}'
		. $scope . ' .mobile-menu-dropdown.active{display:block!important;animation:devotel-mobile-menu-slide-down .3s ease-out!important}'
		. $scope . ' .mobile-menu-footer{border-top:none!important;padding:65px 16px!important;display:flex!important;flex-direction:column!important;gap:12px!important;background:#fff!important;margin-top:auto!important;transform:translateY(-20px)!important;align-self:stretch!important;flex-shrink:0!important}'
		. $scope . ' .mobile-menu-button-primary{background:#325fec!important;border-radius:10px!important;padding:10px 14px!important;display:flex!important;align-items:center!important;justify-content:center!important;height:36px!important;border:none!important;align-self:stretch!important;transition:background-color .2s!important}'
		. $scope . ' .mobile-menu-button-secondary{border-radius:10px!important;border:1px solid #cad5e2!important;padding:10px 14px!important;display:flex!important;align-items:center!important;justify-content:center!important;height:36px!important;background:transparent!important;align-self:stretch!important;transition:border-color .2s!important}'
		. '@media (prefers-reduced-motion:reduce){'
		. $overlay . ',' . $overlay . '.active,' . $overlay . '.devotel-menu-closing{transition:none!important}'
		. $scope . ' .mobile-menu-dropdown.active{animation:none!important}'
		. '}'
		. '}';
}

/**
 * Print canonical mobile menu CSS after snapshot/widget inline styles.
 */
function devotel_print_mobile_menu_footer_css() {
	if ( is_admin() ) {
		return;
	}

	echo '<style id="devotel-mobile-menu-canonical">' . devotel_get_mobile_menu_canonical_css() . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_mobile_menu_footer_css', 100002 );

/**
 * Strip legacy snapshot mobile menu JS (conflicts with assets/js/header.js).
 *
 * @param string $markup Snapshot HTML.
 * @return string
 */
function devotel_strip_snapshot_legacy_mobile_menu_script( $markup ) {
	$markup = (string) $markup;

	$patterns = array(
		'/<script>\s*\/\/\s*Mobile Menu Toggle\s*[\s\S]*?const\s+mobileMenuButton\s*=\s*document\.querySelector\s*\(\s*[\'"]\.header-mobile-menu-button[\'"]\s*\)[\s\S]*?\}\)\(\)\s*;?\s*<\/script>/i',
		'/<script>\s*[\s\S]*?\/\/\s*Mobile Menu Toggle[\s\S]*?getElementById\s*\(\s*[\'"]mobileMenuOverlay[\'"]\s*\)[\s\S]*?\}\)\(\)\s*;?\s*<\/script>/i',
	);

	foreach ( $patterns as $pattern ) {
		$markup = devotel_safe_preg_replace( $pattern, '', $markup );
	}

	return $markup;
}

/**
 * Neutralize legacy full-screen slide-in mobile menu rules embedded in snapshots.
 *
 * @param string $markup Snapshot HTML.
 * @return string
 */
function devotel_strip_embedded_legacy_mobile_menu_styles( $markup ) {
	$markup = (string) $markup;

	// Remove entire legacy mobile-menu stylesheet blocks (prevents global bleed onto theme header).
	$block_patterns = array(
		'/\/\*\s*Mobile Menu Styles\s*\*\/[\s\S]*?\.mobile-menu-see-all-arrow\s*\{[^}]+\}\s*/i',
		'/@media\s*\(\s*min-width\s*:\s*769px\s*\)\s*\{\s*\.mobile-menu-overlay\s*\{\s*display\s*:\s*none\s*!important;\s*\}\s*\}/i',
		'/\.mobile-menu-overlay\{display\s*:\s*flex\s*;position\s*:\s*fixed\s*;[^}]*translateX\s*\(\s*100\s*%\s*\)[^}]*\}/i',
		'/\.mobile-menu-overlay\.active\{[^}]*translateX\s*\(\s*0\s*\)[^}]*\}/i',
		'/\.mobile-menu-overlay\.active\{[^}]*visibility\s*:\s*visible[^}]*\}/i',
		'/\.mobile-menu-overlay\{[^}]*position\s*:\s*fixed[^}]*flex-direction\s*:\s*column[^}]*\}/i',
	);

	foreach ( $block_patterns as $pattern ) {
		$markup = devotel_safe_preg_replace( $pattern, '', $markup );
	}

	$patterns = array(
		'/(\.mobile-menu-overlay\s*\{[^}]*?)transform\s*:\s*translateX\s*\([^)]+\)\s*;?/i'              => '$1',
		'/(\.mobile-menu-overlay\.active\s*\{[^}]*?)transform\s*:\s*translateX\s*\([^)]+\)\s*;?/i'    => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)width\s*:\s*100vw\s*;?/i'                               => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)height\s*:\s*100dvh\s*;?/i'                            => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)height\s*:\s*100vh\s*;?/i'                              => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)min-height\s*:\s*100vh\s*;?/i'                         => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)min-height\s*:\s*-webkit-fill-available\s*;?/i'        => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)right\s*:\s*0\s*;?/i'                                  => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)bottom\s*:\s*0\s*;?/i'                                 => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)z-index\s*:\s*9999\s*;?/i'                             => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)transition\s*:\s*transform\s*0\.3s[^;]*;?/i'          => '$1',
		'/(\.mobile-menu-overlay\.active[^{}]*\{[^}]*?)transition\s*:\s*transform\s*0\.3s[^;]*;?/i'  => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)transition\s*:\s*transform\s*0\.25s[^;]*;?/i'          => '$1',
		'/(\.mobile-menu-header\s*\{[^}]*?)display\s*:\s*flex\s*;?/i'                                 => '$1display:none!important;',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)max-height\s*:\s*100vh\s*;?/i'                         => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)max-height\s*:\s*100dvh\s*;?/i'                        => '$1',
		'/(\.mobile-menu-overlay[^{}]*\{[^}]*?)opacity\s*:\s*[^;]+;?/i'                               => '$1',
	);

	foreach ( $patterns as $pattern => $replacement ) {
		$markup = devotel_safe_preg_replace( $pattern, $replacement, $markup );
	}

	$markup = devotel_safe_preg_replace(
		'/body\.devotel-mobile-menu-open[^{]*\{[^}]*width\s*:\s*min\s*\([^)]+\)[^}]*\}/i',
		'',
		$markup
	);

	return $markup;
}

/**
 * Strip legacy snapshot inline JS that only toggles header-scrolled on the homepage.
 *
 * @param string $markup Snapshot HTML.
 * @return string
 */
function devotel_strip_snapshot_legacy_header_scroll_script( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_safe_preg_replace(
		'/(?:\/\/\s*Home page header: add blue background when scrolled \(sticky mode\)\s*)?\(function\s*\(\)\s*\{[\s\S]*?headerWrapper\.classList\.contains\(\s*[\'"]is-home-page[\'"]\s*\)[\s\S]*?header-scrolled[\s\S]*?\}\)\(\)\s*;?/i',
		'',
		$markup
	);

	$markup = devotel_safe_preg_replace(
		'/<script[^>]*>[\s\S]*?headerWrapper\.classList\.(?:add|remove)\(\s*[\'"]header-scrolled[\'"]\s*\)[\s\S]*?<\/script>/i',
		'',
		$markup
	);

	$markup = devotel_safe_preg_replace(
		'/<script[^>]*>[\s\S]*?scrollThreshold[\s\S]*?header-scrolled[\s\S]*?<\/script>/i',
		'',
		$markup
	);

	return $markup;
}

/**
 * Strip accidental nested HTML documents inside Elementor HTML widgets.
 *
 * @param string $markup Snapshot HTML.
 * @return string
 */
function devotel_strip_widget_nested_document_markup( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_safe_preg_replace( '/<!DOCTYPE\s+html[^>]*>/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/<\/?html[^>]*>/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/<head[^>]*>.*?<\/head>/is', '', $markup );
	$markup = devotel_safe_preg_replace( '/<\/?body[^>]*>/i', '', $markup );
	$markup = devotel_safe_preg_replace(
		'/(<div class="elementor-widget-container">\s*)<!DOCTYPE\s+html[^>]*>\s*<html[^>]*>\s*<head>.*?<\/head>\s*<body[^>]*>/is',
		'$1',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/<\/body>\s*<\/html>\s*(?=<\/div>\s*<\/div>)/is',
		'',
		$markup
	);

	return $markup;
}

/**
 * Patch snapshot markup: neutralize widget hero offsets + append winning CSS.
 *
 * @param string $markup   Snapshot HTML.
 * @param string $uri_path Relative URI path.
 * @return string
 */
function devotel_patch_inner_page_snapshot_markup( $markup, $uri_path ) {
	$markup   = (string) $markup;
	$uri_path = trim( (string) $uri_path, '/' );

	if ( ! devotel_is_utility_inner_page_uri( $uri_path ) ) {
		return $markup;
	}

	$markup = devotel_strip_widget_nested_document_markup( $markup );
	$markup = devotel_strip_snapshot_legacy_mobile_menu_script( $markup );
	$markup = devotel_strip_embedded_legacy_mobile_menu_styles( $markup );
	$markup = devotel_strip_snapshot_legacy_header_scroll_script( $markup );

	if ( 'privacy-policy' === $uri_path ) {
		$markup = devotel_safe_preg_replace(
			'/\.d-devotelutilityprivacy-po \.navbar-main\{[^}]+\}/',
			'.d-devotelutilityprivacy-po .navbar-main{display:none!important}',
			$markup
		);
		$markup = devotel_safe_preg_replace(
			'/<div class="heading-and-subheading"><div class="heading2">Privacy Policy<\/div><\/div>(<div class="supporting-text">[\s\S]*?<\/div>)<div class="subheading">(Effective Date: 01\.01\.2025)<\/div>/',
			'<div class="heading-and-subheading"><div class="subheading">$2</div><div class="heading2">Privacy Policy</div></div>$1',
			$markup
		);
	}

	if ( 'brand-kit' === $uri_path ) {
		$markup = devotel_safe_preg_replace(
			'/\.brk9dvtl__page\s*\{([^}]*?)min-height:\s*100vh([^}]*)\}/',
			'.brk9dvtl__page{$1min-height:0$2}',
			$markup
		);
		$markup = devotel_safe_preg_replace(
			'/\.brk9dvtl__desk__d-brk9dvtl-host\s*\{([^}]*?)align-items:\s*center([^}]*)\}/',
			'.brk9dvtl__desk__d-brk9dvtl-host{$1align-items:flex-start$2}',
			$markup
		);
		$markup = devotel_safe_preg_replace(
			'/\.brk9dvtl__mob__m-brk9dvtl-host\s*\{([^}]*?)align-items:\s*center([^}]*)\}/',
			'.brk9dvtl__mob__m-brk9dvtl-host{$1align-items:flex-start$2}',
			$markup
		);
		$markup = devotel_safe_preg_replace(
			'/(\.brk9dvtl__desk__d-brk9dvtl-host\s*\{[^}]*?)background:\s*#f9fafb([^}]*)\}/',
			'$1background:transparent$2}',
			$markup
		);
	}

	// Widget captures sometimes end with an unclosed <footer bleed.
	$markup = devotel_safe_preg_replace( '/<footer\b[\s\S]*$/i', '', $markup );

	return $markup;
}

/**
 * Print layout-critical CSS in footer (after all widget inline styles).
 */
function devotel_print_inner_page_layout_footer_css() {
	if ( is_admin() ) {
		return;
	}

	$classes = get_body_class();
	$has_standard_header = in_array( 'devotel-inner-page', $classes, true )
		|| in_array( 'is-home-page', $classes, true );

	if ( ! $has_standard_header || in_array( 'devotel-sim-based-page', $classes, true ) ) {
		return;
	}

	$critical = devotel_get_inner_page_layout_critical_css();
	if ( '' === $critical ) {
		return;
	}

	echo '<style id="devotel-inner-page-layout-footer">' . $critical . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_inner_page_layout_footer_css', 99999 );
