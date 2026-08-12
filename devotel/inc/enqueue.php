<?php
/**
 * Asset enqueueing.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue a theme-bundled legacy Elementor CSS file.
 *
 * @param string $filename File name under assets/css/legacy/.
 * @return void
 */
function devotel_enqueue_theme_legacy_stylesheet( $filename ) {
	$filename    = basename( (string) $filename );
	$legacy_path = get_template_directory() . '/assets/css/legacy/' . $filename;

	if ( ! file_exists( $legacy_path ) ) {
		return;
	}

	wp_enqueue_style(
		'devotel-legacy-' . sanitize_title( $filename ),
		get_template_directory_uri() . '/assets/css/legacy/' . $filename,
		array( 'devotel-main' ),
		filemtime( $legacy_path )
	);
}

/**
 * Enqueue frontend assets.
 */
function devotel_enqueue_assets() {
	$theme_version = wp_get_theme()->get( 'Version' );
	$version       = $theme_version ? $theme_version : '1.0.0';
	$main_css_path = get_template_directory() . '/assets/css/main.css';
	$main_js_path  = get_template_directory() . '/assets/js/main.js';
	$main_css_ver  = file_exists( $main_css_path ) ? filemtime( $main_css_path ) : $version;
	$main_js_ver   = file_exists( $main_js_path ) ? filemtime( $main_js_path ) : $version;

	wp_enqueue_style(
		'devotel-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		$main_css_ver
	);

	$header_css_path = get_template_directory() . '/assets/css/pages/header.css';
	if ( file_exists( $header_css_path ) ) {
		wp_enqueue_style(
			'devotel-header',
			get_template_directory_uri() . '/assets/css/pages/header.css',
			array( 'devotel-main' ),
			filemtime( $header_css_path )
		);
	}

	$footer_css_path = get_template_directory() . '/assets/css/pages/footer.css';
	if ( file_exists( $footer_css_path ) ) {
		wp_enqueue_style(
			'devotel-footer',
			get_template_directory_uri() . '/assets/css/pages/footer.css',
			array( 'devotel-main' ),
			filemtime( $footer_css_path )
		);
	}

	$footer_js_path = get_template_directory() . '/assets/js/footer.js';
	if ( file_exists( $footer_js_path ) ) {
		wp_enqueue_script(
			'devotel-footer',
			get_template_directory_uri() . '/assets/js/footer.js',
			array(),
			filemtime( $footer_js_path ),
			true
		);
	}

	// Global Elementor kit tokens only; page-specific legacy CSS is enqueued per route.
	devotel_enqueue_theme_legacy_stylesheet( 'post-6.css' );

	if ( is_front_page() ) {
		$home_legacy = array(
			'post-1027.css',
			'post-908.css',
			'post-495.css',
			'post-52.css',
			'post-73.css',
			'post-872.css',
			'loop-880.css',
		);
		foreach ( $home_legacy as $legacy_css_file ) {
			devotel_enqueue_theme_legacy_stylesheet( $legacy_css_file );
		}

	}

	// Compatibility layer for migrated Elementor-origin markup after Elementor
	// is disabled. These are static CSS assets only (no runtime dependency).
	$elementor_compat_css = array(
		'frontend.min.css',
		'widget-heading.min.css',
		'widget-image.min.css',
		'widget-text-editor.min.css',
		'widget-icon-list.min.css',
		'widget-spacer.min.css',
		'widget-divider.min.css',
		'widget-icon-box.min.css',
		'e-sticky.min.css',
		'widget-loop-common.min.css',
		'widget-loop-grid.min.css',
		'e-animation-fadeIn.min.css',
	);

	foreach ( $elementor_compat_css as $elementor_css_file ) {
		$theme_compat_path = get_template_directory() . '/assets/css/elementor-compat/' . $elementor_css_file;

		if ( file_exists( $theme_compat_path ) ) {
			wp_enqueue_style(
				'devotel-elementor-compat-' . sanitize_title( $elementor_css_file ),
				get_template_directory_uri() . '/assets/css/elementor-compat/' . $elementor_css_file,
				array( 'devotel-main' ),
				filemtime( $theme_compat_path )
			);
		}
	}

	// Inter + kit aliases (@font-face with font-display: swap). No Google Fonts CSS CDN.
	$inter_fonts_path = get_template_directory() . '/assets/css/inter-fonts.css';
	if ( file_exists( $inter_fonts_path ) ) {
		wp_enqueue_style(
			'devotel-inter-fonts',
			get_template_directory_uri() . '/assets/css/inter-fonts.css',
			array(),
			filemtime( $inter_fonts_path )
		);
	}

	$header_overlay_nav_path = get_template_directory() . '/assets/css/components/header-overlay-nav.css';
	if ( file_exists( $header_overlay_nav_path ) ) {
		wp_enqueue_style(
			'devotel-header-overlay-nav',
			get_template_directory_uri() . '/assets/css/components/header-overlay-nav.css',
			array( 'devotel-header' ),
			filemtime( $header_overlay_nav_path )
		);
	}

	$header_js_path = get_template_directory() . '/assets/js/header.js';
	if ( file_exists( $header_js_path ) ) {
		wp_enqueue_script(
			'devotel-header',
			get_template_directory_uri() . '/assets/js/header.js',
			array(),
			filemtime( $header_js_path ),
			true
		);
	}

	wp_enqueue_script(
		'devotel-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array( 'devotel-header' ),
		$main_js_ver,
		true
	);

	$uploads_base = trailingslashit( wp_upload_dir()['baseurl'] );
	wp_localize_script(
		'devotel-main',
		'devotelHeader',
		array(
			'logoHome'    => $uploads_base . '2025/12/Group-20.png',
			'logoDefault' => $uploads_base . '2025/12/Group-20.png',
		)
	);

	$needs_tailwind_config = function_exists( 'devotel_needs_tailwind_cdn' ) && devotel_needs_tailwind_cdn();

	// Product pages only — homepage and inner pages do not use Tailwind utilities.
	if ( $needs_tailwind_config ) {
		wp_enqueue_script(
			'devotel-tailwind-cdn',
			'https://cdn.tailwindcss.com',
			array(),
			null,
			false
		);

		// Config must run after the CDN defines `tailwind` (Play CDN docs).
		wp_add_inline_script(
			'devotel-tailwind-cdn',
			"if(typeof tailwind!=='undefined'){tailwind.config={theme:{extend:{animation:{'fade-in':'fadeIn 0.6s ease-out','fade-in-up':'fadeInUp 0.6s ease-out','fade-in-down':'fadeInDown 0.6s ease-out','slide-in-left':'slideInLeft 0.6s ease-out','slide-in-right':'slideInRight 0.6s ease-out','scale-in':'scaleIn 0.5s ease-out'},keyframes:{fadeIn:{'0%':{opacity:'0'},'100%':{opacity:'1'}},fadeInUp:{'0%':{opacity:'0',transform:'translateY(20px)'},'100%':{opacity:'1',transform:'translateY(0)'}},fadeInDown:{'0%':{opacity:'0',transform:'translateY(-20px)'},'100%':{opacity:'1',transform:'translateY(0)'}},slideInLeft:{'0%':{opacity:'0',transform:'translateX(-30px)'},'100%':{opacity:'1',transform:'translateX(0)'}},slideInRight:{'0%':{opacity:'0',transform:'translateX(30px)'},'100%':{opacity:'1',transform:'translateX(0)'}},scaleIn:{'0%':{opacity:'0',transform:'scale(0.9)'},'100%':{opacity:'1',transform:'scale(1)'}}}}}};}",
			'after'
		);
	}

	devotel_enqueue_current_page_legacy_assets();
	devotel_enqueue_home_solutions_hero_assets();
	devotel_enqueue_home_product_use_cases_assets();
	devotel_enqueue_partner_logos_assets();
	devotel_enqueue_home_globe_section_assets();
	devotel_enqueue_home_testimonials_assets();
	devotel_enqueue_home_final_cta_assets();

	if ( function_exists( 'devotel_enqueue_route_legacy_assets' ) ) {
		devotel_enqueue_route_legacy_assets();
	}

	devotel_enqueue_contact_form_assets();
	devotel_enqueue_home_contact_section_assets();
}
add_action( 'wp_enqueue_scripts', 'devotel_enqueue_assets' );

/**
 * Load CF7 reCAPTCHA v3 in the footer on the homepage (contact form is below the fold).
 */
function devotel_load_google_recaptcha_in_head() {
	if ( is_admin() || ! wp_script_is( 'google-recaptcha', 'enqueued' ) ) {
		return;
	}

	if ( is_front_page() ) {
		return;
	}

	wp_scripts()->add_data( 'google-recaptcha', 'group', 0 );
}
add_action( 'wp_enqueue_scripts', 'devotel_load_google_recaptcha_in_head', 25 );

/**
 * Keep reCAPTCHA script order stable when WP-Optimize minifies footer bundles.
 *
 * @param string $tag    Full script tag.
 * @param string $handle Asset handle.
 * @param string $src    Script URL.
 * @return string
 */
function devotel_filter_cf7_recaptcha_script_tag( $tag, $handle, $src ) {
	if ( is_admin() ) {
		return $tag;
	}

	if ( 'google-recaptcha' === $handle ) {
		if ( is_front_page() && false === strpos( $tag, ' defer' ) ) {
			return str_replace( ' src=', ' defer src=', $tag );
		}

		return preg_replace( '/\s+(async|defer)(=(["\'])[^"\']*\3)?/i', '', $tag );
	}

	if (
		'wpcf7-recaptcha' === $handle
		|| false !== strpos( (string) $src, 'wpcf7-recaptcha' )
	) {
		if ( false === strpos( $tag, ' defer' ) ) {
			$tag = str_replace( ' src=', ' defer src=', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'devotel_filter_cf7_recaptcha_script_tag', 999, 3 );

/**
 * Contact section glow asset URL for CSS custom properties.
 *
 * Uses a site-root path so WP Smush/CDN plugins cannot produce broken
 * concatenated URLs like https://devotel.comhttps://cdn.example/...
 *
 * @return string
 */
function devotel_get_contact_section_bg_url() {
	return '/wp-content/uploads/2026/01/Group-1321314986.png';
}

/**
 * Contact Form 7 + contact section assets for bundled static forms.
 */
function devotel_enqueue_contact_form_assets() {
	if ( is_admin() ) {
		return;
	}

	$contact_bg = devotel_get_contact_section_bg_url();

	if ( ! is_front_page() ) {
		wp_add_inline_style(
			'devotel-main',
			':root{--devotel-contact-section-bg:url("' . esc_url( $contact_bg ) . '");}'
		);
	}

	$contact_css = get_template_directory() . '/assets/css/components/contact-section.css';
	if ( file_exists( $contact_css ) ) {
		wp_enqueue_style(
			'devotel-contact-section',
			get_template_directory_uri() . '/assets/css/components/contact-section.css',
			array( 'devotel-main' ),
			filemtime( $contact_css )
		);
	}

	if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
		wpcf7_enqueue_styles();
	}

	if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
		wpcf7_enqueue_scripts();
	}

	wp_enqueue_style(
		'devotel-flag-icons',
		'https://cdn.jsdelivr.net/npm/flag-icons@7.2.3/css/flag-icons.min.css',
		array(),
		'7.2.3'
	);

	$contact_js = get_template_directory() . '/assets/js/contact-forms.js';
	if ( file_exists( $contact_js ) ) {
		$deps = array( 'jquery', 'devotel-main' );
		if ( wp_script_is( 'contact-form-7', 'registered' ) ) {
			$deps[] = 'contact-form-7';
		}
		if ( wp_script_is( 'nbcpf-intlTelInput-script', 'registered' ) ) {
			$deps[] = 'nbcpf-intlTelInput-script';
		}
		if ( wp_script_is( 'nbcpf-countryFlag-script', 'registered' ) ) {
			$deps[] = 'nbcpf-countryFlag-script';
		}

		wp_enqueue_script(
			'devotel-contact-forms',
			get_template_directory_uri() . '/assets/js/contact-forms.js',
			$deps,
			filemtime( $contact_js ),
			true
		);
	}
}

/**
 * Enqueue homepage solutions hero styles and scripts.
 */
function devotel_enqueue_home_solutions_hero_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-solutions-hero.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'devotel-home-solutions-hero',
			get_template_directory_uri() . '/assets/css/components/home-solutions-hero.css',
			array( 'devotel-main' ),
			filemtime( $css_path )
		);

		$pattern = esc_url( trailingslashit( wp_upload_dir()['baseurl'] ) . '2026/05/Background-pattern.svg' );
		wp_add_inline_style(
			'devotel-home-solutions-hero',
			':root{--devotel-solutions-pattern:url("' . $pattern . '");}'
		);
	}

	$preload_path = get_template_directory() . '/assets/js/home-solutions-hero-preload.js';
	$hero_path    = get_template_directory() . '/assets/js/home-solutions-hero.js';

	$hero_config = array(
		'uploadsBase' => trailingslashit( wp_upload_dir()['baseurl'] ),
		'contactUrl'  => home_url( '/contact-us/' ),
	);

	if ( file_exists( $preload_path ) ) {
		wp_enqueue_script(
			'devotel-home-solutions-hero-preload',
			get_template_directory_uri() . '/assets/js/home-solutions-hero-preload.js',
			array(),
			filemtime( $preload_path ),
			true
		);
		wp_localize_script( 'devotel-home-solutions-hero-preload', 'devotelHomeHero', $hero_config );
	}

	if ( file_exists( $hero_path ) ) {
		wp_enqueue_script(
			'devotel-home-solutions-hero',
			get_template_directory_uri() . '/assets/js/home-solutions-hero.js',
			array( 'devotel-home-solutions-hero-preload' ),
			filemtime( $hero_path ),
			true
		);
		wp_localize_script( 'devotel-home-solutions-hero', 'devotelHomeHero', $hero_config );
	}
}

/**
 * Output solutions hero image preload hints.
 */
function devotel_print_home_solutions_hero_preload_links() {
	if ( ! is_front_page() || wp_is_mobile() ) {
		return;
	}

	$uploads = trailingslashit( wp_upload_dir()['baseurl'] );
	$assets  = array(
		'2026/05/Background-pattern.svg',
		'2026/05/Gemini_Generated_Image_s1d35vs1d35vs1d3-1-2.webp',
	);

	foreach ( $assets as $asset ) {
		$attrs = 'rel="preload" as="image" href="' . esc_url( $uploads . $asset ) . '"';
		if ( str_ends_with( $asset, '.webp' ) ) {
			$attrs .= ' fetchpriority="high"';
		}
		printf( '<link %s />' . "\n", $attrs );
	}
}
add_action( 'wp_head', 'devotel_print_home_solutions_hero_preload_links', 1 );

/**
 * Enqueue homepage product use-cases styles and scripts.
 */
function devotel_enqueue_home_product_use_cases_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-product-use-cases.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'devotel-home-product-use-cases',
			get_template_directory_uri() . '/assets/css/components/home-product-use-cases.css',
			array( 'devotel-main' ),
			filemtime( $css_path )
		);
	}

	$preload_path = get_template_directory() . '/assets/js/home-product-use-cases-preload.js';
	$script_path  = get_template_directory() . '/assets/js/home-product-use-cases.js';

	$config = array(
		'uploadsBase' => trailingslashit( wp_upload_dir()['baseurl'] ),
	);

	if ( file_exists( $preload_path ) ) {
		wp_enqueue_script(
			'devotel-home-product-use-cases-preload',
			get_template_directory_uri() . '/assets/js/home-product-use-cases-preload.js',
			array(),
			filemtime( $preload_path ),
			true
		);
		wp_localize_script( 'devotel-home-product-use-cases-preload', 'devotelHomeProductUseCases', $config );
	}

	if ( file_exists( $script_path ) ) {
		wp_enqueue_script(
			'devotel-home-product-use-cases',
			get_template_directory_uri() . '/assets/js/home-product-use-cases.js',
			array( 'devotel-home-product-use-cases-preload' ),
			filemtime( $script_path ),
			true
		);
	}
}

/**
 * Output product use-case image preload hints.
 */
function devotel_print_home_product_use_cases_preload_links() {
	if ( ! is_front_page() || wp_is_mobile() ) {
		return;
	}

	$uploads = trailingslashit( wp_upload_dir()['baseurl'] );
	$assets  = array(
		'2026/05/Notification-Campaigns.png',
	);

	foreach ( $assets as $asset ) {
		printf(
			'<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
			esc_url( $uploads . $asset )
		);
	}
}
add_action( 'wp_head', 'devotel_print_home_product_use_cases_preload_links', 1 );

/**
 * Whether the current route renders the partner logos section.
 *
 * @return bool
 */
function devotel_should_enqueue_partner_logos_assets() {
	if ( is_front_page() ) {
		return true;
	}

	if ( ! is_singular( 'page' ) || ! function_exists( 'devotel_get_cached_uri_path_for_post' ) || ! function_exists( 'devotel_is_product_subpage_uri_path' ) ) {
		return false;
	}

	$post_id  = (int) get_queried_object_id();
	$uri_path = devotel_get_cached_uri_path_for_post( $post_id );

	return devotel_is_product_subpage_uri_path( $uri_path );
}

/**
 * Partner logo file numbers used in the social-proof flip pool (26 brands; no logo 14).
 *
 * @return array<int, int>
 */
function devotel_get_partner_logo_numbers() {
	return array_merge( range( 1, 13 ), range( 15, 27 ) );
}

/**
 * Enqueue shared partner logos grid styles, preload, and flip animation scripts.
 */
function devotel_enqueue_partner_logos_assets() {
	if ( ! devotel_should_enqueue_partner_logos_assets() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/social-proof-partners.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'devotel-social-proof-partners',
			get_template_directory_uri() . '/assets/css/components/social-proof-partners.css',
			array( 'devotel-main' ),
			filemtime( $css_path )
		);
	}

	$preload_path = get_template_directory() . '/assets/js/social-proof-partners-preload.js';
	$flip_path    = get_template_directory() . '/assets/js/social-proof-partners-flip.js';

	if ( file_exists( $preload_path ) ) {
		wp_enqueue_script(
			'devotel-social-proof-partners-preload',
			get_template_directory_uri() . '/assets/js/social-proof-partners-preload.js',
			array(),
			filemtime( $preload_path ),
			true
		);

		$logo_numbers = devotel_get_partner_logo_numbers();

		wp_localize_script(
			'devotel-social-proof-partners-preload',
			'devotelPartnerLogos',
			array(
				'uploadsBase'  => trailingslashit( wp_upload_dir()['baseurl'] ),
				'poolSize'     => count( $logo_numbers ),
				'logoNumbers'  => $logo_numbers,
			)
		);
	}

	if ( file_exists( $flip_path ) ) {
		wp_enqueue_script(
			'devotel-social-proof-partners-flip',
			get_template_directory_uri() . '/assets/js/social-proof-partners-flip.js',
			array( 'devotel-social-proof-partners-preload' ),
			filemtime( $flip_path ),
			true
		);
	}
}

/**
 * Enqueue homepage testimonials layout overrides.
 */
function devotel_enqueue_home_testimonials_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-testimonials.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'devotel-home-testimonials',
			get_template_directory_uri() . '/assets/css/components/home-testimonials.css',
			array( 'devotel-main' ),
			filemtime( $css_path )
		);
	}

	$js_path = get_template_directory() . '/assets/js/home-testimonials.js';
	if ( file_exists( $js_path ) ) {
		wp_enqueue_script(
			'devotel-home-testimonials',
			get_template_directory_uri() . '/assets/js/home-testimonials.js',
			array(),
			filemtime( $js_path ),
			true
		);
	}
}

/**
 * Enqueue homepage final CTA button/section styles.
 */
function devotel_enqueue_home_final_cta_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-final-cta.css';
	if ( ! file_exists( $css_path ) ) {
		return;
	}

	wp_enqueue_style(
		'devotel-home-final-cta',
		get_template_directory_uri() . '/assets/css/components/home-final-cta.css',
		array( 'devotel-main' ),
		filemtime( $css_path )
	);
}

/**
 * Enqueue homepage contact section layout overrides.
 */
function devotel_enqueue_home_contact_section_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-contact-section.css';
	if ( ! file_exists( $css_path ) ) {
		return;
	}

	wp_enqueue_style(
		'devotel-home-contact-section',
		get_template_directory_uri() . '/assets/css/components/home-contact-section.css',
		array( 'devotel-contact-section' ),
		filemtime( $css_path )
	);
}

/**
 * Enqueue homepage stats globe mobile parity assets.
 */
function devotel_enqueue_home_globe_section_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$css_path = get_template_directory() . '/assets/css/components/home-globe-section.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'devotel-home-globe-section',
			get_template_directory_uri() . '/assets/css/components/home-globe-section.css',
			array( 'devotel-main' ),
			filemtime( $css_path )
		);
	}

	$js_path = get_template_directory() . '/assets/js/home-globe-section.js';
	if ( file_exists( $js_path ) ) {
		wp_enqueue_script(
			'devotel-home-globe-section',
			get_template_directory_uri() . '/assets/js/home-globe-section.js',
			array(),
			filemtime( $js_path ),
			true
		);
	}
}

/**
 * Output partner logo image preload hints (boxes.html head links).
 */
function devotel_print_partner_logos_preload_links() {
	// Partner logos are below the fold; preloading all 14 PNGs delays window load on mobile.
}
add_action( 'wp_head', 'devotel_print_partner_logos_preload_links', 2 );

/**
 * Skip full-page cache for verify fetches and other dynamic query routes.
 */
function devotel_bypass_page_cache_for_verify() {
	if ( defined( 'DONOTCACHEPAGE' ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$verify = isset( $_GET['devotel_verify'] ) ? wp_unslash( (string) $_GET['devotel_verify'] ) : '';
	if ( '' !== $verify && preg_match( '/^[0-9]{6,20}$/', $verify ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
}
add_action( 'init', 'devotel_bypass_page_cache_for_verify', 0 );

/**
 * Enqueue page-specific legacy CSS when available.
 */
function devotel_enqueue_current_page_legacy_assets() {
	if ( is_admin() ) {
		return;
	}

	$post_id = (int) get_queried_object_id();
	if ( $post_id <= 0 ) {
		return;
	}

	$page_slug = (string) get_post_field( 'post_name', $post_id );
	if ( in_array( $page_slug, array( 'about-us', 'contact-us' ), true ) ) {
		return;
	}

	$theme_legacy = get_template_directory() . '/assets/css/legacy/post-' . $post_id . '.css';
	if ( function_exists( 'devotel_enqueue_sanitized_legacy_post_css' ) ) {
		devotel_enqueue_sanitized_legacy_post_css(
			$post_id,
			'devotel-legacy',
			array( 'devotel-main' )
		);
	} elseif ( file_exists( $theme_legacy ) ) {
		wp_enqueue_style(
			'devotel-legacy-post-' . $post_id,
			get_template_directory_uri() . '/assets/css/legacy/post-' . $post_id . '.css',
			array( 'devotel-main' ),
			filemtime( $theme_legacy )
		);
	} else {
		$upload_legacy = WP_CONTENT_DIR . '/uploads/elementor/css/post-' . $post_id . '.css';
		if ( file_exists( $upload_legacy ) ) {
			wp_enqueue_style(
				'devotel-upload-legacy-post-' . $post_id,
				content_url( 'uploads/elementor/css/post-' . $post_id . '.css' ),
				array( 'devotel-main' ),
				filemtime( $upload_legacy )
			);
		}
	}
}

/**
 * Keep frontend independent from Elementor runtime assets.
 */
function devotel_dequeue_elementor_frontend_assets() {
	if ( is_admin() ) {
		return;
	}

	$style_handles = array(
		'elementor-frontend',
		'e-sticky',
		'e-animation-fadeIn',
		'elementor-post-6',
		'elementor-post-12',
		'elementor-post-21',
		'elementor-post-52',
		'elementor-post-73',
		'elementor-post-495',
		'elementor-post-872',
		'elementor-post-908',
		'elementor-post-1027',
		'elementor-pro',
		'elementor-global',
	);

	$script_handles = array(
		'elementor-frontend',
		'elementor-webpack-runtime',
		'elementor-frontend-modules',
		'elementor-waypoints',
		'elementor-sticky',
		'elementor-pro-frontend',
		'elementor-pro-webpack-runtime',
		'pro-elements-handlers',
		'e-sticky',
	);

	foreach ( $style_handles as $handle ) {
		wp_dequeue_style( $handle );
		wp_deregister_style( $handle );
	}

	foreach ( $script_handles as $handle ) {
		wp_dequeue_script( $handle );
		wp_deregister_script( $handle );
	}

	global $wp_styles, $wp_scripts;

	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( (array) $wp_styles->registered as $handle => $style ) {
			$src = isset( $style->src ) ? (string) $style->src : '';
			if ( '' !== $src && false !== strpos( $src, '/plugins/elementor' ) ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
			}
		}
	}

	if ( $wp_scripts instanceof WP_Scripts ) {
		foreach ( (array) $wp_scripts->registered as $handle => $script ) {
			$src = isset( $script->src ) ? (string) $script->src : '';
			if ( '' !== $src && false !== strpos( $src, '/plugins/elementor' ) ) {
				wp_dequeue_script( $handle );
				wp_deregister_script( $handle );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'devotel_dequeue_elementor_frontend_assets', 999 );

/**
 * Final sweep right before printing assets.
 */
function devotel_dequeue_elementor_print_assets() {
	global $wp_styles, $wp_scripts;

	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( (array) $wp_styles->queue as $handle ) {
			$src = isset( $wp_styles->registered[ $handle ]->src ) ? (string) $wp_styles->registered[ $handle ]->src : '';
			if ( '' !== $src && false !== strpos( $src, '/plugins/elementor' ) ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
			}
		}
	}

	if ( $wp_scripts instanceof WP_Scripts ) {
		foreach ( (array) $wp_scripts->queue as $handle ) {
			$src = isset( $wp_scripts->registered[ $handle ]->src ) ? (string) $wp_scripts->registered[ $handle ]->src : '';
			if ( '' !== $src && false !== strpos( $src, '/plugins/elementor' ) ) {
				wp_dequeue_script( $handle );
				wp_deregister_script( $handle );
			}
		}
	}
}
add_action( 'wp_print_styles', 'devotel_dequeue_elementor_print_assets', 9999 );
add_action( 'wp_print_scripts', 'devotel_dequeue_elementor_print_assets', 9999 );

/**
 * Strip any Elementor asset tags that still reach frontend output.
 *
 * @param string $html   Full HTML tag.
 * @param string $handle Asset handle.
 * @param string $href   Asset URL.
 * @return string
 */
function devotel_filter_elementor_style_tag( $html, $handle, $href ) {
	if ( ! is_admin() && false !== strpos( (string) $href, '/plugins/elementor' ) ) {
		return '';
	}

	return $html;
}
add_filter( 'style_loader_tag', 'devotel_filter_elementor_style_tag', 10, 3 );

/**
 * Block any stylesheet still pointing at local dev URLs (mixed content safety net).
 *
 * @param string $html   Full HTML tag.
 * @param string $handle Asset handle.
 * @param string $href   Asset URL.
 * @return string
 */
function devotel_block_local_dev_asset_tags( $html, $handle, $href ) {
	unset( $handle );

	if ( is_admin() ) {
		return $html;
	}

	$href = (string) $href;
	if ( '' !== $href && false !== strpos( $href, 'devotel.local' ) ) {
		return '';
	}

	return $html;
}
add_filter( 'style_loader_tag', 'devotel_block_local_dev_asset_tags', 999, 3 );
add_filter( 'script_loader_tag', 'devotel_block_local_dev_asset_tags', 999, 3 );

/**
 * Strip any Elementor script tags that still reach frontend output.
 *
 * @param string $tag    Full script tag.
 * @param string $handle Asset handle.
 * @param string $src    Script URL.
 * @return string
 */
function devotel_filter_elementor_script_tag( $tag, $handle, $src ) {
	if ( ! is_admin() && false !== strpos( (string) $src, '/plugins/elementor' ) ) {
		return '';
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'devotel_filter_elementor_script_tag', 10, 3 );

/**
 * Inner page layout overrides — must load after all other theme/page CSS.
 */
function devotel_enqueue_inner_page_layout_css() {
	if ( is_admin() || is_front_page() ) {
		return;
	}

	$layout_css_path = get_template_directory() . '/assets/css/inner-page-layout.css';
	if ( ! file_exists( $layout_css_path ) ) {
		return;
	}

	global $wp_styles;
	$deps = array( 'devotel-header', 'devotel-main' );
	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( (array) $wp_styles->queue as $handle ) {
			if ( is_string( $handle ) && str_starts_with( $handle, 'devotel-' ) ) {
				$deps[] = $handle;
			}
		}
	}

	wp_enqueue_style(
		'devotel-inner-page-layout',
		get_template_directory_uri() . '/assets/css/inner-page-layout.css',
		array_values( array_unique( $deps ) ),
		filemtime( $layout_css_path )
	);

	if ( function_exists( 'devotel_get_inner_page_layout_critical_css' ) ) {
		wp_add_inline_style(
			'devotel-inner-page-layout',
			devotel_get_inner_page_layout_critical_css()
		);
	}

	if ( is_page( 'about-us' ) && function_exists( 'devotel_get_about_hero_blue_layer_css' ) ) {
		wp_add_inline_style(
			'devotel-inner-page-layout',
			devotel_get_about_hero_blue_layer_css()
		);
	}

	if ( is_page( 'brand-kit' ) ) {
		$shared_css = get_template_directory() . '/assets/css/pages/shared.css';
		if ( file_exists( $shared_css ) && ! wp_style_is( 'devotel-pages-shared', 'enqueued' ) ) {
			wp_enqueue_style(
				'devotel-pages-shared',
				get_template_directory_uri() . '/assets/css/pages/shared.css',
				array( 'devotel-main' ),
				filemtime( $shared_css )
			);
		}

		$brand_kit_css = get_template_directory() . '/assets/css/pages/brand-kit.css';
		if ( file_exists( $brand_kit_css ) ) {
			$brand_deps = array( 'devotel-inner-page-layout' );
			if ( wp_style_is( 'devotel-route-legacy-post-9513', 'registered' ) ) {
				$brand_deps[] = 'devotel-route-legacy-post-9513';
			} elseif ( wp_style_is( 'devotel-legacy-post-9513', 'registered' ) ) {
				$brand_deps[] = 'devotel-legacy-post-9513';
			}
			wp_enqueue_style(
				'devotel-page-brand-kit',
				get_template_directory_uri() . '/assets/css/pages/brand-kit.css',
				$brand_deps,
				filemtime( $brand_kit_css )
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'devotel_enqueue_inner_page_layout_css', 10001 );

/**
 * Local dev: discourage stale HTML caching while iterating on layout/CSS.
 */
function devotel_local_dev_no_cache_headers( $headers ) {
	if ( is_admin() ) {
		return $headers;
	}

	$host = (string) wp_parse_url( home_url( '/' ), PHP_URL_HOST );
	if ( '' === $host || ! str_ends_with( $host, '.local' ) ) {
		return $headers;
	}

	$headers['Cache-Control'] = 'no-cache, must-revalidate, max-age=0';
	$headers['Pragma']        = 'no-cache';

	return $headers;
}
add_filter( 'wp_headers', 'devotel_local_dev_no_cache_headers' );

/**
 * Normalize embedded form card padding in Elementor HTML widgets (homepage, etc.).
 *
 * @param string                 $content Widget HTML.
 * @param \Elementor\Widget_Base $widget  Widget instance.
 * @return string
 */
function devotel_patch_elementor_form_card_padding( $content, $widget ) {
	if ( is_admin() || ! function_exists( 'devotel_is_contact_us_page' ) || devotel_is_contact_us_page() ) {
		return $content;
	}

	if ( ! function_exists( 'devotel_patch_form_card_padding_markup' ) ) {
		return $content;
	}

	return devotel_patch_form_card_padding_markup( $content );
}
add_filter( 'elementor/widget/render_content', 'devotel_patch_elementor_form_card_padding', 20, 2 );

