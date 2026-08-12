<?php
/**
 * Concatenate theme CSS into route-specific bundles to reduce render-blocking requests.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Above-the-fold homepage CSS (blocking — kept small).
 *
 * @return array<int, string>
 */
function devotel_get_home_critical_css_bundle_paths() {
	$base = 'assets/css/';

	return array(
		$base . 'inter-fonts.css',
		$base . 'main.css',
		$base . 'pages/header.css',
		$base . 'components/header-overlay-nav.css',
		$base . 'components/home-solutions-hero.css',
		$base . 'components/contact-section.css',
		$base . 'legacy/post-6.css',
		$base . 'legacy/post-1027.css',
		// After legacy Elementor CSS so box overrides win the cascade.
		$base . 'components/home-contact-section.css',
	);
}

/**
 * Below-the-fold homepage CSS (loaded asynchronously).
 *
 * @return array<int, string>
 */
function devotel_get_home_deferred_css_bundle_paths() {
	$base = 'assets/css/';

	$paths = array(
		$base . 'pages/footer.css',
		$base . 'legacy/post-908.css',
		$base . 'legacy/post-495.css',
		$base . 'legacy/post-52.css',
		$base . 'legacy/post-73.css',
		$base . 'legacy/post-872.css',
		$base . 'legacy/loop-880.css',
	);

	$elementor_compat = array(
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

	foreach ( $elementor_compat as $filename ) {
		$paths[] = $base . 'elementor-compat/' . $filename;
	}

	$components = array(
		'home-product-use-cases.css',
		'social-proof-partners.css',
		'home-globe-section.css',
		'home-testimonials.css',
		'home-final-cta.css',
	);

	foreach ( $components as $filename ) {
		$paths[] = $base . 'components/' . $filename;
	}

	return $paths;
}

/**
 * Legacy single-list accessor (tests / tooling).
 *
 * @return array<int, string>
 */
function devotel_get_home_css_bundle_paths() {
	return array_merge(
		devotel_get_home_critical_css_bundle_paths(),
		devotel_get_home_deferred_css_bundle_paths()
	);
}

/**
 * Build or refresh a cached CSS bundle on disk.
 *
 * @param string            $bundle_name     Bundle file slug.
 * @param array<int,string> $relative_paths Theme-relative CSS paths.
 * @return array{path:string,url:string,ver:int}|null
 */
function devotel_ensure_css_bundle( $bundle_name, array $relative_paths ) {
	$bundle_name = sanitize_file_name( (string) $bundle_name );
	if ( '' === $bundle_name ) {
		return null;
	}

	$theme_dir   = get_template_directory();
	$bundle_dir  = $theme_dir . '/assets/css/bundles';
	$bundle_path = $bundle_dir . '/' . $bundle_name . '.css';
	$max_mtime   = 0;
	$chunks      = array();

	foreach ( $relative_paths as $relative_path ) {
		$relative_path = ltrim( (string) $relative_path, '/' );
		$source_path   = $theme_dir . '/' . $relative_path;

		if ( ! is_readable( $source_path ) ) {
			continue;
		}

		$mtime     = (int) filemtime( $source_path );
		$max_mtime = max( $max_mtime, $mtime );
		$chunks[]  = array(
			'relative' => $relative_path,
			'contents' => (string) file_get_contents( $source_path ),
		);
	}

	if ( empty( $chunks ) ) {
		return null;
	}

	$needs_rebuild = ! is_readable( $bundle_path ) || (int) filemtime( $bundle_path ) < $max_mtime;

	if ( $needs_rebuild ) {
		wp_mkdir_p( $bundle_dir );

		$css = "/* Devotel bundle: {$bundle_name} */\n";
		foreach ( $chunks as $chunk ) {
			$css .= "\n/* Source: {$chunk['relative']} */\n";
			$css .= $chunk['contents'];
			$css .= "\n";
		}

		file_put_contents( $bundle_path, $css );
		touch( $bundle_path, $max_mtime );
	}

	return array(
		'path' => $bundle_path,
		'url'  => get_template_directory_uri() . '/assets/css/bundles/' . $bundle_name . '.css',
		'ver'  => (int) filemtime( $bundle_path ),
	);
}

/**
 * Replace many homepage theme stylesheets with critical + deferred bundles.
 */
function devotel_apply_home_css_bundle() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}

	global $wp_styles;

	$critical = devotel_ensure_css_bundle( 'home-critical', devotel_get_home_critical_css_bundle_paths() );
	$deferred = devotel_ensure_css_bundle( 'home-deferred', devotel_get_home_deferred_css_bundle_paths() );

	if ( null === $critical || null === $deferred ) {
		return;
	}

	$critical_css = devotel_get_home_critical_css_contents();
	$inline_css   = '';
	$dequeue_only_handles = array(
		'devotel-font-inter',
		'devotel-font-roboto',
		'devotel-font-roboto-slab',
		'devotel-inter-fonts',
	);

	if ( $wp_styles instanceof WP_Styles ) {
		foreach ( (array) $wp_styles->queue as $handle ) {
			if ( ! is_string( $handle ) || ! str_starts_with( $handle, 'devotel-' ) ) {
				continue;
			}

			if ( in_array( $handle, $dequeue_only_handles, true ) ) {
				wp_dequeue_style( $handle );
				wp_deregister_style( $handle );
				continue;
			}

			if ( ! empty( $wp_styles->registered[ $handle ]->extra['after'] ) ) {
				foreach ( (array) $wp_styles->registered[ $handle ]->extra['after'] as $chunk ) {
					$inline_css .= (string) $chunk;
				}
			}

			wp_dequeue_style( $handle );
			wp_deregister_style( $handle );
		}
	}

	wp_enqueue_style(
		'devotel-home-deferred',
		$deferred['url'],
		array(),
		$deferred['ver']
	);

	if ( '' === $critical_css ) {
		wp_enqueue_style(
			'devotel-home-critical',
			$critical['url'],
			array(),
			$critical['ver']
		);
	}

	if ( '' !== $inline_css ) {
		wp_add_inline_style( 'devotel-home-deferred', $inline_css );
	}
}
add_action( 'wp_enqueue_scripts', 'devotel_apply_home_css_bundle', 10050 );

/**
 * Read the homepage critical CSS bundle from disk.
 *
 * @return string
 */
function devotel_get_home_critical_css_contents() {
	$critical = devotel_ensure_css_bundle( 'home-critical', devotel_get_home_critical_css_bundle_paths() );
	if ( null === $critical || ! is_readable( $critical['path'] ) ) {
		return '';
	}

	$css = (string) file_get_contents( $critical['path'] );
	$css = preg_replace( '/\/\* Devotel bundle:[^*]*\*\/\s*/', '', $css );
	$css = preg_replace( '/\/\* Source:[^*]*\*\/\s*/', '', $css );

	return trim( $css );
}

/**
 * Print above-the-fold homepage CSS inline to avoid a render-blocking request.
 */
function devotel_print_inlined_home_critical_css() {
	if ( is_admin() || ! is_front_page() ) {
		return;
	}

	if ( wp_style_is( 'devotel-home-critical', 'enqueued' ) ) {
		return;
	}

	$css = devotel_get_home_critical_css_contents();
	if ( '' === $css ) {
		return;
	}

	$contact_bg = function_exists( 'devotel_get_contact_section_bg_url' )
		? devotel_get_contact_section_bg_url()
		: '/wp-content/uploads/2026/01/Group-1321314986.png';
	$css       .= ':root{--devotel-contact-section-bg:url("' . esc_url( $contact_bg ) . '");}';
	$css       .= function_exists( 'devotel_get_form_card_padding_css' ) ? devotel_get_form_card_padding_css() : '';

	printf(
		'<style id="devotel-home-critical-css">%s</style>' . "\n",
		$css // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- theme CSS bundle.
	);
}
add_action( 'wp_head', 'devotel_print_inlined_home_critical_css', 2 );

/**
 * Convert a stylesheet tag to non-render-blocking.
 *
 * @param string $html Stylesheet link tag.
 * @return string
 */
function devotel_make_stylesheet_nonblocking( $html ) {
	if ( false !== strpos( $html, 'media="print"' ) || false !== strpos( $html, "media='print'" ) ) {
		return $html;
	}

	$async = str_replace(
		array( "media='all'", 'media="all"' ),
		array( "media='print' onload=\"this.media='all'\"", 'media="print" onload="this.media=\'all\'"' ),
		$html
	);

	if ( $async === $html && false === strpos( $html, 'media=' ) ) {
		$async = str_replace( 'rel=\'stylesheet\'', 'rel=\'stylesheet\' media=\'print\' onload="this.media=\'all\'"', $async );
		$async = str_replace( 'rel="stylesheet"', 'rel="stylesheet" media="print" onload="this.media=\'all\'"', $async );
	}

	return $async . '<noscript>' . $html . '</noscript>';
}

/**
 * Load deferred homepage bundle without blocking first paint.
 *
 * @param string $html   Stylesheet tag.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @param string $media  Media attribute.
 * @return string
 */
function devotel_async_home_deferred_styles( $html, $handle, $href, $media ) {
	unset( $href, $media );

	if ( is_admin() || ! is_front_page() ) {
		return $html;
	}

	if ( 'devotel-home-deferred' === $handle ) {
		return devotel_make_stylesheet_nonblocking( $html );
	}

	return $html;
}
add_filter( 'style_loader_tag', 'devotel_async_home_deferred_styles', 15, 4 );
