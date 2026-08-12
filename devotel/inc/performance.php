<?php
/**
 * Frontend performance and SEO helpers.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Remove WordPress assets that are unused on the public theme frontend.
 */
function devotel_dequeue_unused_frontend_assets() {
	if ( is_admin() ) {
		return;
	}

	// Dashicons is required by the admin bar when logged in.
	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
		wp_deregister_style( 'dashicons' );
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'devotel_dequeue_unused_frontend_assets', 100 );

/**
 * Move jQuery to the footer on public pages to reduce render-blocking JS.
 */
function devotel_move_jquery_to_footer() {
	if ( is_admin() ) {
		return;
	}

	if ( wp_script_is( 'jquery', 'registered' ) ) {
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	}
}
add_action( 'wp_enqueue_scripts', 'devotel_move_jquery_to_footer', 1 );

/**
 * Load reCAPTCHA in the footer on the homepage (contact form is below the fold).
 */
function devotel_move_recaptcha_to_footer_on_home() {
	if ( is_admin() || ! is_front_page() || ! wp_script_is( 'google-recaptcha', 'registered' ) ) {
		return;
	}

	wp_scripts()->add_data( 'google-recaptcha', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'devotel_move_recaptcha_to_footer_on_home', 30 );

/**
 * Whether the current route needs Tailwind utility classes.
 *
 * @return bool
 */
function devotel_needs_tailwind_cdn() {
	if ( is_page( 'products' ) ) {
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
 * Output a meta description when no SEO plugin has already provided one.
 */
function devotel_print_meta_description() {
	if ( is_admin() ) {
		return;
	}

	$description = devotel_get_meta_description();
	if ( '' === $description ) {
		return;
	}

	printf(
		'<meta name="description" content="%s" />' . "\n",
		esc_attr( $description )
	);
}
add_action( 'wp_head', 'devotel_print_meta_description', 1 );

/**
 * Build the meta description for the current request.
 *
 * @return string
 */
function devotel_get_meta_description() {
	$description = '';

	if ( is_front_page() ) {
		$description = function_exists( 'devotel_get_default_site_tagline' )
			? devotel_get_default_site_tagline()
			: get_bloginfo( 'description' );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			if ( has_excerpt( $post ) ) {
				$description = (string) get_the_excerpt( $post );
			} else {
				$description = wp_trim_words( wp_strip_all_tags( (string) $post->post_content ), 30, '…' );
			}
		}
	} elseif ( is_home() || ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) ) {
		$description = __( 'Latest insights and updates on customer communication, connectivity, and telecom solutions from Devotel.', 'devotel' );
	}

	$description = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $description ) ) );
	if ( '' === $description ) {
		return '';
	}

	if ( function_exists( 'mb_strlen' ) && mb_strlen( $description ) > 160 ) {
		$description = mb_substr( $description, 0, 157 ) . '…';
	} elseif ( strlen( $description ) > 160 ) {
		$description = substr( $description, 0, 157 ) . '…';
	}

	return $description;
}

/**
 * Add resource hints for font CDNs used by the theme.
 *
 * @param array<int, string> $urls          Hint URLs.
 * @param string             $relation_type Hint type.
 * @return array<int, string>
 */
function devotel_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}

	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);

	return $urls;
}
add_filter( 'wp_resource_hints', 'devotel_resource_hints', 10, 2 );

/**
 * Dequeue Google Fonts CSS registered by plugins (theme fonts load via inter-fonts.css).
 */
function devotel_dequeue_google_font_styles() {
	if ( is_admin() ) {
		return;
	}

	global $wp_styles;

	if ( ! $wp_styles instanceof WP_Styles ) {
		return;
	}

	foreach ( (array) $wp_styles->registered as $handle => $style ) {
		$src = isset( $style->src ) ? (string) $style->src : '';
		if ( false !== strpos( $src, 'fonts.googleapis.com' ) ) {
			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'devotel_dequeue_google_font_styles', 9999 );

/**
 * Drop Google Fonts stylesheet tags if a plugin prints them anyway.
 *
 * @param string $html   Stylesheet tag.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @param string $media  Media attribute.
 * @return string
 */
function devotel_block_google_font_stylesheet_tag( $html, $handle, $href, $media ) {
	unset( $handle, $media );

	if ( false !== strpos( (string) $href, 'fonts.googleapis.com' ) ) {
		return '';
	}

	return $html;
}
add_filter( 'style_loader_tag', 'devotel_block_google_font_stylesheet_tag', 99, 4 );

/**
 * Remove duplicate Google Fonts tags embedded in snapshot / extracted HTML.
 *
 * @param string $markup HTML markup.
 * @return string
 */
function devotel_strip_embedded_google_fonts( $markup ) {
	$markup = (string) $markup;

	$patterns = array(
		'/<link[^>]*href=["\'][^"\']*fonts\.googleapis\.com[^"\']*["\'][^>]*>\s*/i',
		'/<link[^>]*href=["\'][^"\']*fonts\.gstatic\.com[^"\']*["\'][^>]*>\s*/i',
		'/@import\s+url\(\s*["\']?https?:\/\/fonts\.googleapis\.com[^)]+\)\s*;?/i',
		'/src:\s*url\(\s*["\']?https?:\/\/fonts\.googleapis\.com[^)]+\)\s*;?/i',
	);

	foreach ( $patterns as $pattern ) {
		$markup = devotel_safe_preg_replace( $pattern, '', $markup );
	}

	return $markup;
}

/**
 * Ensure admin-bar dependencies remain available for logged-in users.
 */
function devotel_ensure_admin_bar_assets() {
	if ( ! is_admin_bar_showing() ) {
		return;
	}

	wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'devotel_ensure_admin_bar_assets', 1 );

/**
 * Load below-the-fold plugin and admin styles asynchronously on the homepage.
 *
 * @param string $html   Stylesheet tag.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @param string $media  Media attribute.
 * @return string
 */
function devotel_defer_noncritical_home_styles( $html, $handle, $href, $media ) {
	unset( $media );

	if ( is_admin() || ! is_front_page() ) {
		return $html;
	}

	$defer_handles = array(
		'admin-bar',
		'dashicons',
	);

	$defer_patterns = array(
		'wp-optimize-global',
	);

	$should_defer = in_array( $handle, $defer_handles, true );

	if ( ! $should_defer ) {
		foreach ( $defer_patterns as $pattern ) {
			if ( false !== strpos( (string) $href, $pattern ) ) {
				$should_defer = true;
				break;
			}
		}
	}

	if ( ! $should_defer ) {
		return $html;
	}

	return function_exists( 'devotel_make_stylesheet_nonblocking' )
		? devotel_make_stylesheet_nonblocking( $html )
		: $html;
}
add_filter( 'style_loader_tag', 'devotel_defer_noncritical_home_styles', 20, 4 );

/**
 * Preload hero-critical Inter weights before CSS parses @font-face rules.
 */
function devotel_preload_home_fonts() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}

	$fonts = array(
		'https://fonts.gstatic.com/s/inter/v18/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuLyfAZ9hiJ-Ek-_EeA.woff2',
		'https://fonts.gstatic.com/s/inter/v18/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuGKYAZ9hiJ-Ek-_EeA.woff2',
		'https://fonts.gstatic.com/s/robotomono/v23/L0xuDF4xlVMF-BfR8bXMIhJHg45mwgGEFl0_3vq_ROW4.woff2',
	);

	foreach ( $fonts as $font_url ) {
		printf(
			'<link rel="preload" as="font" type="font/woff2" crossorigin href="%s" />' . "\n",
			esc_url( $font_url )
		);
	}
}
add_action( 'wp_head', 'devotel_preload_home_fonts', 0 );


