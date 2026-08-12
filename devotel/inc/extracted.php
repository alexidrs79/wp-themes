<?php
/**
 * Helpers for extracted Elementor widgets.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rewrite production and legacy local URLs to the current site home URL.
 *
 * @param string $markup Markup to rewrite.
 * @return string
 */
/**
 * Run preg_replace without letting PCRE failures null out large snapshot markup.
 *
 * @param string $pattern     Regex pattern.
 * @param string $replacement Replacement string.
 * @param string $subject     Input markup.
 * @param int    $limit       Maximum replacements (-1 for all).
 * @return string
 */
function devotel_safe_preg_replace( $pattern, $replacement, $subject, $limit = -1 ) {
	$subject = (string) $subject;
	if ( '' === $subject ) {
		return '';
	}

	$result = preg_replace( $pattern, $replacement, $subject, $limit );

	return is_string( $result ) ? $result : $subject;
}

/**
 * Remove inline Elementor frontend config scripts without catastrophic backtracking.
 *
 * @param string $markup Snapshot markup.
 * @return string
 */
function devotel_strip_elementor_config_scripts( $markup ) {
	$markup  = (string) $markup;
	$markers = array(
		'elementorFrontendConfig',
		'elementorProFrontendConfig',
		'elementorFrontend.',
		'ElementorProFrontendConfig',
	);

	foreach ( $markers as $marker ) {
		$offset = 0;

		while ( false !== ( $pos = stripos( $markup, $marker, $offset ) ) ) {
			$script_start = strripos( substr( $markup, 0, $pos ), '<script' );
			$script_end   = stripos( $markup, '</script>', $pos );

			if ( false === $script_start || false === $script_end ) {
				break;
			}

			$script_tag = substr( $markup, $script_start, $script_end - $script_start + 9 );
			if ( false !== stripos( $script_tag, 'src=' ) ) {
				$offset = $script_end + 9;
				continue;
			}

			$markup = substr( $markup, 0, $script_start ) . substr( $markup, $script_end + 9 );
			$offset = $script_start;
		}
	}

	return $markup;
}

/**
 * Remove Smush/lazyload placeholder src when a real src already exists on the tag.
 *
 * @param string $markup HTML markup.
 * @return string
 */
function devotel_fix_smush_duplicate_src_markup( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_safe_preg_replace( '/\sdata-srcset="([^"]*)"/i', ' srcset="$1"', $markup );
	$markup = devotel_safe_preg_replace( "/\sdata-srcset='([^']*)'/i", " srcset='$1'", $markup );
	$markup = devotel_safe_preg_replace( '/\sdata-src="([^"]*)"/i', ' src="$1"', $markup );
	$markup = devotel_safe_preg_replace( "/\sdata-src='([^']*)'/i", " src='$1'", $markup );
	$markup = devotel_safe_preg_replace( '/\sclass="lazyload"/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/\sclass="([^"]*\s)?lazyload(\s[^"]*)?"/i', ' class="$1$2"', $markup );
	$markup = devotel_safe_preg_replace( '/\sclass="\s*"/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/\slazyload\b/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/\slazyloading\b/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/\slazyloaded\b/i', '', $markup );

	// Drop Smush duplicate placeholder src while keeping other attributes (alt, class, etc.).
	$markup = devotel_safe_preg_replace(
		'/(\bsrc="(?!data:image\/svg\+xml)[^"]+"[^>]*?)\ssrc="data:image\/svg\+xml[^"]*"/i',
		'$1',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/<img\b([^>]*)\sdata-src="([^"]+)"([^>]*)\ssrc="data:image\/svg\+xml[^"]*"[^>]*>/i',
		'<img$1 src="$2"$3>',
		$markup
	);
	$markup = devotel_safe_preg_replace( '/\ssrc="data:image\/svg\+xml[^"]*"\s*style="--smush-placeholder-[^"]*"/i', '', $markup );
	$markup = devotel_safe_preg_replace( "/\ssrc='data:image\/svg\+xml[^']*'\s*style='--smush-placeholder-[^']*'/i", '', $markup );
	$markup = devotel_safe_preg_replace( '/\sstyle="--smush-placeholder-[^"]*"/i', '', $markup );
	$markup = devotel_safe_preg_replace( "/\sstyle='--smush-placeholder-[^']*'/i", '', $markup );

	return $markup;
}

/**
 * Remove embedded Tailwind Play CDN tags and orphaned config scripts.
 *
 * Extracted/snapshot markup often includes both the CDN and
 * `tailwind.config = …`. The theme loads the CDN only on product routes,
 * so orphaned config scripts throw "tailwind is not defined" elsewhere.
 *
 * @param string $markup HTML markup.
 * @return string
 */
function devotel_strip_embedded_tailwind_scripts( $markup ) {
	$markup = (string) $markup;

	$patterns = array(
		// CDN script tags (src=cdn.tailwindcss.com).
		'/<script[^>]*src=["\']https?:\/\/cdn\.tailwindcss\.com[^"\']*["\'][^>]*>\s*<\/script>\s*/i',
		// Inline config / bootstrap that references the global `tailwind` object.
		'/<script\b[^>]*>\s*(?:window\.)?tailwind\s*(?:\.config\s*=|\s*=\s*\{)[\s\S]*?<\/script>\s*/i',
		'/<script\b[^>]*>\s*if\s*\(\s*typeof\s+tailwind\s*!==\s*[\'"]undefined[\'"]\s*\)\s*\{[\s\S]*?<\/script>\s*/i',
	);

	foreach ( $patterns as $pattern ) {
		$markup = devotel_safe_preg_replace( $pattern, '', $markup );
	}

	return $markup;
}

/**
 * Fix inline snapshot form scripts (SVG className is read-only in DOM).
 *
 * @param string $markup HTML markup.
 * @return string
 */
function devotel_patch_snapshot_inline_form_scripts( $markup ) {
	$markup = (string) $markup;

	$replacements = array(
		"svg.className = 'custom-arrow-svg'"  => "svg.setAttribute('class', 'custom-arrow-svg')",
		'svg.className = "custom-arrow-svg"'  => 'svg.setAttribute("class", "custom-arrow-svg")',
		"svg.className='custom-arrow-svg'"    => "svg.setAttribute('class','custom-arrow-svg')",
		'svg.className="custom-arrow-svg"'    => 'svg.setAttribute("class","custom-arrow-svg")',
	);

	return str_replace( array_keys( $replacements ), array_values( $replacements ), $markup );
}

function devotel_rewrite_legacy_site_urls( $markup ) {
	$home_url          = trailingslashit( home_url() );
	$home_url_no_slash = untrailingslashit( home_url() );

	if ( is_ssl() ) {
		$home_url          = set_url_scheme( $home_url, 'https' );
		$home_url_no_slash = set_url_scheme( $home_url_no_slash, 'https' );
	}

	$markup = str_replace(
		array(
			'https://devotel.com/',
			'http://devotel.com/',
			'https://devotel.local/',
			'http://devotel.local/',
			'https://devotel.local',
			'http://devotel.local',
			'https://localhost/conversion/',
			'http://localhost/conversion/',
			'https://localhost/conversion',
			'http://localhost/conversion',
		),
		array(
			$home_url,
			$home_url,
			$home_url,
			$home_url,
			$home_url_no_slash,
			$home_url_no_slash,
			$home_url,
			$home_url,
			$home_url_no_slash,
			$home_url_no_slash,
		),
		$markup
	);

	return $markup;
}

/**
 * Strip dev/local absolute URLs from CSS or HTML so assets load on HTTPS production.
 *
 * @param string $text Asset markup or CSS.
 * @return string
 */
function devotel_sanitize_extracted_asset_urls( $text ) {
	$text = (string) $text;
	if ( '' === $text ) {
		return $text;
	}

	return str_replace(
		array(
			'http://devotel.local/wp-content',
			'https://devotel.local/wp-content',
			'http://devotel.com/wp-content',
			'https://devotel.com/wp-content',
		),
		'/wp-content',
		$text
	);
}

/**
 * Locate bundled or uploads Elementor legacy CSS for a template ID.
 *
 * @param int $legacy_id Elementor post/template ID.
 * @return string Absolute file path or empty string.
 */
function devotel_find_legacy_post_css_path( $legacy_id ) {
	$legacy_id = (int) $legacy_id;
	if ( $legacy_id <= 0 ) {
		return '';
	}

	$candidates = array(
		get_template_directory() . '/assets/css/legacy/post-' . $legacy_id . '.css',
		WP_CONTENT_DIR . '/uploads/elementor/css/post-' . $legacy_id . '.css',
	);

	foreach ( $candidates as $path ) {
		if ( file_exists( $path ) ) {
			return $path;
		}
	}

	return '';
}

/**
 * Strip About hero legacy Elementor rules that fight the hero-band gradient layout.
 *
 * @param string $css Legacy post-12 CSS.
 * @return string
 */
function devotel_sanitize_about_legacy_post_css( $css ) {
	$css = (string) $css;
	$css = str_replace( '--min-height:760px', '--min-height:0px', $css );
	$css = str_replace( '--min-height:952px', '--min-height:0px', $css );
	$css = str_replace(
		'.elementor-12 .elementor-element.elementor-element-7ee2817:not(.elementor-motion-effects-element-type-background), .elementor-12 .elementor-element.elementor-element-7ee2817 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-color:transparent;background-image:linear-gradient(180deg, #172154 0%, #325FEC 100%);}',
		'.elementor-12 .elementor-element.elementor-element-7ee2817:not(.elementor-motion-effects-element-type-background), .elementor-12 .elementor-element.elementor-element-7ee2817 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-color:transparent;background-image:none;}',
		$css
	);

	return $css;
}

/**
 * Enqueue legacy Elementor CSS inline with sanitized upload URLs (avoids mixed content).
 *
 * @param int                $legacy_id     Elementor post/template ID.
 * @param string             $handle_prefix Handle prefix, e.g. devotel-route-legacy.
 * @param array<int, string> $deps          Style dependencies.
 * @return bool
 */
function devotel_enqueue_sanitized_legacy_post_css( $legacy_id, $handle_prefix, $deps = array() ) {
	$legacy_id = (int) $legacy_id;
	if ( $legacy_id <= 0 ) {
		return false;
	}

	$path = devotel_find_legacy_post_css_path( $legacy_id );
	if ( '' === $path ) {
		return false;
	}

	$css = devotel_sanitize_extracted_asset_urls( (string) file_get_contents( $path ) );
	if ( 12 === $legacy_id ) {
		$css = devotel_sanitize_about_legacy_post_css( $css );
	}
	if ( '' === trim( $css ) ) {
		return false;
	}

	$handle = sanitize_key( $handle_prefix . '-post-' . $legacy_id );
	wp_register_style( $handle, false, $deps, filemtime( $path ) );
	wp_enqueue_style( $handle );
	wp_add_inline_style( $handle, $css );

	return true;
}

/**
 * Resolve a WPO page-cache snapshot file for the current route.
 *
 * @param string $uri_path Relative URI path.
 * @return string Absolute file path or empty string.
 */
function devotel_get_wpo_cache_snapshot_file( $uri_path ) {
	$uri_path   = trim( (string) $uri_path, '/' );
	$candidates = array();
	$parsed     = wp_parse_url( home_url() );
	$host       = isset( $parsed['host'] ) ? (string) $parsed['host'] : '';
	$path       = isset( $parsed['path'] ) ? trim( (string) $parsed['path'], '/' ) : '';

	if ( '' !== $host ) {
		$candidates[] = $host;
	}
	if ( '' !== $path ) {
		$candidates[] = $path;
		if ( 'localhost' === $host ) {
			$candidates[] = 'localhost/' . $path;
		}
	}

	$candidates[] = 'devotel.local';
	$candidates[] = 'localhost/conversion';
	$candidates   = array_values( array_unique( array_filter( $candidates ) ) );

	foreach ( $candidates as $cache_key ) {
		$base = WP_CONTENT_DIR . '/cache/wpo-cache/' . $cache_key;
		$file = '' === $uri_path
			? $base . '/index.html'
			: $base . '/' . $uri_path . '/index.html';

		if ( file_exists( $file ) ) {
			return $file;
		}
	}

	return '';
}

/**
 * Get and sanitize extracted widget markup.
 *
 * @param string $relative_path Relative path under template-parts/extracted.
 * @return string
 */
function devotel_get_extracted_markup( $relative_path ) {
	$file_path = get_template_directory() . '/template-parts/extracted/' . ltrim( $relative_path, '/' ) . '.php';

	if ( ! file_exists( $file_path ) ) {
		return '';
	}

	// Footer and product subpage section extracts may execute PHP (upload URLs, snapshot loaders).
	if (
		false !== strpos( $relative_path, 'footer/site-footer-html' )
		|| str_ends_with( $relative_path, '/section-main' )
	) {
		ob_start();
		include $file_path;
		$markup = (string) ob_get_clean();
	} else {
		$raw_markup = (string) file_get_contents( $file_path );

		// Remove PHP guards added during extraction.
		$markup = preg_replace( '/^\s*<\?php[\s\S]*?\?>\s*/', '', $raw_markup );

		if ( ! is_string( $markup ) ) {
			$markup = $raw_markup;
		}
	}

	// Remove known trailing footer/chrome accidentally appended after widgets (multiline-safe).
	$markup = preg_replace( '/<footer\b[\s\S]*?data-elementor-type\s*=\s*["\']footer["\'][\s\S]*$/iu', '', $markup );
	if ( false === strpos( $relative_path, 'footer/site-footer-html' ) ) {
		$markup = preg_replace( '/<div\b[^>]*\bid\s*=\s*["\']devotel-footer-wrapper["\'][\s\S]*$/iu', '', $markup );
	}

	// Remove Elementor/plugin assets accidentally captured in widgets.
	$markup = preg_replace( '/<script[^>]*src="[^"]*elementor[^"]*"[^>]*><\/script>/i', '', $markup );
	$markup = preg_replace( '/<link[^>]*href="[^"]*elementor[^"]*"[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<script[^>]*src=["\'](?:https?:)?\/\/cdn\.tailwindcss\.com[^"\']*["\'][^>]*><\/script>/i', '', $markup );
	$markup = preg_replace( '/<!--\s*Cached by WP-Optimize[\s\S]*$/i', '', $markup );

	// Keep footer markup but drop extra script payloads captured with it.
	if ( false !== strpos( $relative_path, 'footer/site-footer-html' ) ) {
		$footer_styles  = '';
		$footer_scripts = '';
		$body_markup    = $markup;

		if ( preg_match_all( '/<style[^>]*>[\s\S]*?<\/style>/i', $markup, $style_matches ) && ! empty( $style_matches[0] ) ) {
			$footer_styles = implode( "\n", $style_matches[0] );
		}

		if ( preg_match_all( '/<script(?![^>]*\bsrc=)[^>]*>[\s\S]*?<\/script>/i', $markup, $script_matches ) && ! empty( $script_matches[0] ) ) {
			$footer_scripts = implode( "\n", $script_matches[0] );
		}

		if ( preg_match( '/<body[^>]*>([\s\S]*?)<\/body>/i', $markup, $body_match ) ) {
			$body_markup = (string) $body_match[1];
		} else {
			$footer_end = stripos( $markup, '</footer>' );
			if ( false !== $footer_end ) {
				$body_markup = substr( $markup, 0, $footer_end + 9 );
			}
		}

		$body_markup = preg_replace( '/<\/?(?:html|head|body|footer)[^>]*>/i', '', $body_markup );
		$body_markup = preg_replace( '/<meta[^>]*>/i', '', $body_markup );
		$body_markup = preg_replace( '/<link[^>]*>/i', '', $body_markup );
		$body_markup = preg_replace( '/<script[^>]*src=[^>]*>[\s\S]*?<\/script>/i', '', $body_markup );
		$wrapper_pos = stripos( $body_markup, 'id="devotel-footer-wrapper"' );
		if ( false !== $wrapper_pos ) {
			$div_start = strripos( substr( $body_markup, 0, $wrapper_pos ), '<div' );
			if ( false !== $div_start ) {
				$body_markup = substr( $body_markup, $div_start );
			}
		}

		// Drop accidental </footer> bleed and production scripts bundled in the extract file.
		$body_markup = preg_replace( '/<\/?footer\b[^>]*>/i', '', $body_markup );
		$cut_markers = array(
			'<script type="speculationrules"',
			'<script type="text/javascript">document.oncontextmenu',
			'<!-- Cached by WP-Optimize',
		);
		foreach ( $cut_markers as $marker ) {
			$cut_pos = stripos( $body_markup, $marker );
			if ( false !== $cut_pos ) {
				$body_markup = substr( $body_markup, 0, $cut_pos );
				break;
			}
		}

		$markup = trim( $footer_styles . "\n" . $footer_scripts . "\n" . $body_markup );
	}

	// Trim known homepage bleed captured after the integrations widget.
	if ( false !== strpos( $relative_path, 'home/integrations' ) ) {
		$integrations_bleed = stripos( $markup, 'class="elementor-element elementor-element-480683d' );
		if ( false !== $integrations_bleed ) {
			$markup = substr( $markup, 0, $integrations_bleed );
		}
	}

	// Trim known trailing container bleed on extracted homepage sections.
	if ( false !== strpos( $relative_path, 'home/features' ) ) {
		$features_bleed = stripos( $markup, 'class="elementor-element elementor-element-de9d7f9' );
		if ( false !== $features_bleed ) {
			$markup = substr( $markup, 0, $features_bleed );
		}
	}

	if ( false !== strpos( $relative_path, 'home/testimonials' ) ) {
		$testimonials_bleed = stripos( $markup, 'class="elementor-element elementor-element-336ca7d' );
		if ( false !== $testimonials_bleed ) {
			$markup = substr( $markup, 0, $testimonials_bleed );
		}
	}

	if ( false !== strpos( $relative_path, 'home/products-tabs' ) ) {
		$products_bleed = stripos( $markup, 'class="elementor-element elementor-element-698e5c1' );
		if ( false !== $products_bleed ) {
			$markup = substr( $markup, 0, $products_bleed );
		}
	}

	// About team widget: trim Elementor counter bleed captured after custom HTML.
	if ( false !== strpos( $relative_path, 'about/widget-6d9a1aa' ) ) {
		$team_bleed = stripos( $markup, 'class="elementor-element elementor-element-59be7c5' );
		if ( false !== $team_bleed ) {
			$markup = substr( $markup, 0, $team_bleed );
		}
	}

	// Keep integrations icons visible even if GSAP runtime is unavailable.
	if ( false !== strpos( $relative_path, 'home/integrations' ) ) {
		$markup = preg_replace(
			'/(\.integrations-section\s+\.logo-box\{)opacity:0([^}]*\})/i',
			'$1opacity:1$2',
			$markup
		);
	}

	// Header extract: markup only — styles/scripts live in header.css + header.js + main.js.
	if ( false !== strpos( $relative_path, 'header/site-header-html' ) ) {
		if ( preg_match( '/<div[^>]*\bclass="header-navbar-wrapper"/i', $markup, $header_match, PREG_OFFSET_CAPTURE ) ) {
			$markup = substr( $markup, (int) $header_match[0][1] );
		}

		$page_bleed = stripos( $markup, 'data-elementor-type="wp-page"' );
		if ( false !== $page_bleed ) {
			$markup = substr( $markup, 0, $page_bleed );
		}

		$markup = preg_replace( '/<\/?header[^>]*>/i', '', $markup );
		$markup = preg_replace( '/<\/?(?:html|head|body)[^>]*>/i', '', $markup );
		$markup = preg_replace( '/<meta[^>]*>/i', '', $markup );
		$markup = preg_replace( '/<link[^>]*>/i', '', $markup );
		$markup = preg_replace( '/<style[^>]*>[\s\S]*?<\/style>/i', '', $markup );
		$markup = preg_replace( '/<script[^>]*>[\s\S]*?<\/script>/i', '', $markup );

		$markup = devotel_apply_header_theme_options( $markup );
	}

	$markup = devotel_fix_smush_duplicate_src_markup( $markup );
	$markup = preg_replace( '/<img(?![^>]*loading=)/i', '<img loading="lazy"', $markup );

	// ACF overrides for key editable content without changing layout markup.
	if ( in_array( $relative_path, array( 'home/hero', 'home/features' ), true ) && function_exists( 'get_field' ) && is_front_page() ) {
		$hero_kicker = (string) get_field( 'devotel_hero_kicker' );
		$hero_title  = (string) get_field( 'devotel_hero_title' );
		$hero_desc   = (string) get_field( 'devotel_hero_description' );

		if ( $hero_kicker ) {
			$markup = str_replace( 'Devotel in Numbers', esc_html( $hero_kicker ), $markup );
		}
		if ( $hero_title ) {
			$markup = str_replace( 'Trusted Infrastructure, Proven Results', esc_html( $hero_title ), $markup );
		}
		if ( $hero_desc ) {
			$markup = preg_replace(
				'/(<div\s+class="globe-supporting-text">)[\s\S]*?(<\/div>)/i',
				'$1' . esc_html( $hero_desc ) . '$2',
				$markup,
				1
			);
		}

		$hero_stats = get_field( 'devotel_hero_stats' );
		if ( is_array( $hero_stats ) && ! empty( $hero_stats ) ) {
			$index = 0;
			$markup = preg_replace_callback(
				'/<span\s+class="counter-number"[^>]*data-target="(\d+)"[^>]*>.*?<\/span>/i',
				static function ( $matches ) use ( $hero_stats, &$index ) {
					if ( ! isset( $hero_stats[ $index ]['value'] ) ) {
						$index++;
						return $matches[0];
					}
					$value = trim( (string) $hero_stats[ $index ]['value'] );
					$index++;
					if ( '' === $value ) {
						return $matches[0];
					}

					$target_number = preg_replace( '/[^0-9]/', '', $value );
					$suffix        = preg_replace( '/[0-9\.\s]/', '', $value );
					if ( '' === $target_number ) {
						return $matches[0];
					}

					return '<span class="counter-number" data-target="' . esc_attr( $target_number ) . '" data-suffix="' . esc_attr( $suffix ) . '">0</span>';
				},
				$markup
			);
		}
	}

	if ( function_exists( 'get_field' ) && is_front_page() && in_array( $relative_path, array( 'home/cta-desktop', 'home/cta-mobile', 'home/final-cta' ), true ) ) {
		$front_replace_map = array(
			'Our blog' => (string) get_field( 'devotel_home_blog_kicker' ),
			'Insights from the Telecom Industry' => (string) get_field( 'devotel_home_blog_title' ),
			'Stay informed with expert analysis, industry trends, and technical guides.' => (string) get_field( 'devotel_home_blog_text' ),
			'Contact us' => (string) get_field( 'devotel_home_contact_kicker' ),
			'Let’s discuss your project' => (string) get_field( 'devotel_home_contact_title' ),
			"Let's discuss your project" => (string) get_field( 'devotel_home_contact_title' ),
			'Discover how our SMS API can enhance your messaging strategy in a 15-minute conversation with one of our experts. No commitments, just insights.' => (string) get_field( 'devotel_home_contact_text' ),
			"Enhance and Scale Your Communication Today with Devotel's solutions" => (string) get_field( 'devotel_home_final_cta_title' ),
			'Join 500+ companies who chose us for reliable, customisable, and carrier-grade solutions worldwide.' => (string) get_field( 'devotel_home_final_cta_text' ),
		);

		foreach ( $front_replace_map as $search_text => $replacement_text ) {
			if ( '' !== trim( (string) $replacement_text ) ) {
				$markup = str_replace( $search_text, esc_html( (string) $replacement_text ), $markup );
			}
		}

		$final_cta_button = trim( (string) get_field( 'devotel_home_final_cta_button' ) );
		if ( '' !== $final_cta_button ) {
			$markup = str_replace( '>Start now<', '>' . esc_html( $final_cta_button ) . '<', $markup );
		}
	}

	if ( false !== strpos( $relative_path, 'footer/site-footer-html' ) ) {
		$markup = devotel_apply_footer_theme_options( $markup );
	}

	if ( function_exists( 'get_field' ) && function_exists( 'have_rows' ) && function_exists( 'is_singular' ) && is_singular( 'page' ) ) {
		$page_id = function_exists( 'get_queried_object_id' ) ? (int) get_queried_object_id() : 0;
		if ( $page_id > 0 && (bool) get_field( 'devotel_enable_route_overrides', $page_id ) ) {
			if ( have_rows( 'devotel_route_text_replacements', $page_id ) ) {
				while ( have_rows( 'devotel_route_text_replacements', $page_id ) ) {
					the_row();
					$find_text    = (string) get_sub_field( 'find_text' );
					$replace_text = (string) get_sub_field( 'replace_text' );
					if ( '' !== trim( $find_text ) ) {
						$markup = str_replace( $find_text, $replace_text, $markup );
					}
				}
			}

			if ( have_rows( 'devotel_route_url_replacements', $page_id ) ) {
				while ( have_rows( 'devotel_route_url_replacements', $page_id ) ) {
					the_row();
					$find_url    = trim( (string) get_sub_field( 'find_url' ) );
					$replace_url = trim( (string) get_sub_field( 'replace_url' ) );
					if ( '' !== $find_url && '' !== $replace_url ) {
						$markup = str_replace( $find_url, esc_url( $replace_url ), $markup );
					}
				}
			}
		}
	}

	$markup = devotel_rewrite_legacy_site_urls( $markup );

	if ( false === strpos( $relative_path, 'header/site-header-html' ) && false === strpos( $relative_path, 'footer/site-footer-html' ) ) {
		$markup = preg_replace( '/<footer\b[\s\S]*?data-elementor-type\s*=\s*["\']footer["\'][\s\S]*$/iu', '', $markup );
		$markup = preg_replace( '/<div\b[^>]*\bid\s*=\s*["\']devotel-footer-wrapper["\'][\s\S]*$/iu', '', $markup );
		$footer_pos = stripos( $markup, 'id="devotel-footer-wrapper"' );
		if ( false !== $footer_pos ) {
			$markup = substr( $markup, 0, $footer_pos );
		}
		$markup = preg_replace( '/<div[^>]*\bclass="header-navbar-wrapper"[\s\S]*?<\/header>/i', '', $markup, 1 );
	}

	$markup = devotel_strip_extracted_document_bleed( $markup );
	$markup = devotel_patch_snapshot_inline_form_scripts( $markup );
	if ( function_exists( 'devotel_strip_snapshot_legacy_mobile_menu_script' ) ) {
		$markup = devotel_strip_snapshot_legacy_mobile_menu_script( $markup );
	}
	if ( function_exists( 'devotel_strip_embedded_legacy_mobile_menu_styles' ) ) {
		$markup = devotel_strip_embedded_legacy_mobile_menu_styles( $markup );
	}
	$markup = devotel_strip_embedded_tailwind_scripts( $markup );
	$markup = devotel_strip_embedded_google_fonts( $markup );

	if ( false !== strpos( $relative_path, 'contact/widget-contact-hero' ) ) {
		$markup = devotel_dedupe_contact_form_assets( $markup );
	} elseif ( false === strpos( $relative_path, 'contact/' ) && function_exists( 'devotel_patch_form_card_padding_markup' ) ) {
		$markup = devotel_patch_form_card_padding_markup( $markup );
	}

	return trim( (string) $markup );
}

/**
 * Remove full HTML document wrappers accidentally captured in widget extracts.
 *
 * @param string $markup Raw widget HTML.
 * @return string
 */
function devotel_strip_extracted_document_bleed( $markup ) {
	$markup = (string) $markup;
	if ( '' === $markup ) {
		return '';
	}

	$markup = preg_replace( '/<!DOCTYPE[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<\/?html[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<\/?head[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<\/?body[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<title[^>]*>[\s\S]*?<\/title>/i', '', $markup );
	$markup = preg_replace( '/<meta[^>]*>/i', '', $markup );

	// Head-only assets inside fragments (fonts/flag-icons are enqueued globally).
	$markup = preg_replace( '/<link[^>]*fonts\.googleapis\.com[^>]*>/i', '', $markup );
	$markup = preg_replace( '/<link[^>]*flag-icons[^>]*>/i', '', $markup );

	return is_string( $markup ) ? $markup : '';
}

/**
 * Contact hero may include two copied form bundles; keep the first style/script pair.
 *
 * @param string $markup Contact hero markup.
 * @return string
 */
function devotel_dedupe_contact_form_assets( $markup ) {
	$markup = (string) $markup;
	$marker = '/* Contact Form CSS Styles - Scoped to prevent conflicts */';

	$first = stripos( $markup, $marker );
	if ( false === $first ) {
		return $markup;
	}

	while ( false !== ( $second = stripos( $markup, $marker, $first + strlen( $marker ) ) ) ) {
		$style_start = strripos( substr( $markup, 0, $second ), '<style' );
		$style_end   = stripos( $markup, '</style>', $second );
		if ( false === $style_start || false === $style_end ) {
			break;
		}
		$markup = substr( $markup, 0, $style_start ) . substr( $markup, $style_end + 8 );
	}

	$script_marker = 'function bootFinalCtaFormWrappers';
	$first_script  = stripos( $markup, $script_marker );
	if ( false === $first_script ) {
		return $markup;
	}

	while ( false !== ( $second_script = stripos( $markup, $script_marker, $first_script + 20 ) ) ) {
		$script_start = strripos( substr( $markup, 0, $second_script ), '<script' );
		$script_end   = stripos( $markup, '</script>', $second_script );
		if ( false === $script_start || false === $script_end ) {
			break;
		}
		$markup = substr( $markup, 0, $script_start ) . substr( $markup, $script_end + 9 );
	}

	return $markup;
}

/**
 * Determine whether recovered markup has enough content to render.
 *
 * @param string $markup Markup string.
 * @param int    $minimum_text_length Minimum stripped text length.
 * @return bool
 */
function devotel_markup_is_substantial( $markup, $minimum_text_length = 400 ) {
	$text = trim( wp_strip_all_tags( (string) $markup ) );

	return strlen( $text ) >= (int) $minimum_text_length;
}

/**
 * Build extracted directory markup without rendering.
 *
 * @param string $directory Relative directory under template-parts/extracted.
 * @return string
 */
function devotel_get_extracted_directory_markup( $directory ) {
	$glob_pattern = trailingslashit( get_template_directory() . '/template-parts/extracted/' . trim( $directory, '/' ) ) . '*.php';
	$files        = glob( $glob_pattern );

	if ( empty( $files ) ) {
		return '';
	}

	$directory_trimmed = trim( $directory, '/' );

	$widget_order = array();
	if ( 'about' === $directory_trimmed ) {
		// Production document order (devotel.com/about-us/).
		$widget_order = array(
			'widget-hero.php',
			'widget-about-intro.php',
			'widget-910680a.php',
			'widget-6d9a1aa.php',
			'widget-stats.php',
			'widget-79d494a.php',
			'widget-893dae1.php',
			'widget-480d110.php',
			'widget-a8b7b70.php',
			'widget-bottom-cta.php',
		);
	} elseif ( 'contact' === $directory_trimmed ) {
		$widget_order = array(
			'widget-contact-hero.php',
			'widget-locations-header.php',
			'widget-f7c355e.php',
			'widget-88b8c88.php',
		);
	}

	if ( ! empty( $widget_order ) ) {
		$ordered = array();
		$by_name = array();
		foreach ( $files as $file_path ) {
			$by_name[ basename( $file_path ) ] = $file_path;
		}
		foreach ( $widget_order as $basename ) {
			if ( isset( $by_name[ $basename ] ) ) {
				$ordered[] = $by_name[ $basename ];
				unset( $by_name[ $basename ] );
			}
		}
		foreach ( $by_name as $file_path ) {
			$ordered[] = $file_path;
		}
		$files = $ordered;
	} else {
		natsort( $files );
	}

	$skip_basenames = array();
	if ( 'contact' === $directory_trimmed ) {
		// Hero includes form; legacy widgets are superseded by production extracts.
		$skip_basenames = array(
			'widget-4039395.php',
			'widget-c77501f.php',
		);
	}
	if ( 'about' === $directory_trimmed ) {
		$skip_basenames = array(
			'widget-7d33934.php',
		);
	}

	$output = '';
	foreach ( $files as $file_path ) {
		if ( ! empty( $skip_basenames ) && in_array( basename( $file_path ), $skip_basenames, true ) ) {
			continue;
		}

		$relative = str_replace(
			array(
				get_template_directory() . '/template-parts/extracted/',
				'.php',
			),
			'',
			$file_path
		);
		$output .= devotel_get_extracted_markup( $relative );
	}

	$output = trim( (string) $output );

	if ( 'about' === $directory_trimmed ) {
		$output = devotel_repair_about_us_extracted_markup( $output );
	}

	return $output;
}

/**
 * Echo extracted markup.
 *
 * @param string $relative_path Relative path under template-parts/extracted.
 * @return void
 */
function devotel_include_extracted( $relative_path ) {
	echo devotel_get_extracted_markup( $relative_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Render all widgets from an extracted directory.
 *
 * @param string $directory Relative directory under template-parts/extracted.
 * @return void
 */
function devotel_render_extracted_directory( $directory ) {
	$glob_pattern = trailingslashit( get_template_directory() . '/template-parts/extracted/' . trim( $directory, '/' ) ) . '*.php';
	$files        = glob( $glob_pattern );

	if ( empty( $files ) ) {
		return;
	}

	natsort( $files );

	foreach ( $files as $file_path ) {
		$relative = str_replace(
			array(
				get_template_directory() . '/template-parts/extracted/',
				'.php',
			),
			'',
			$file_path
		);
		devotel_include_extracted( $relative );
	}
}

/**
 * Check whether an extracted directory exists and has widget files.
 *
 * @param string $directory Relative directory under template-parts/extracted.
 * @return bool
 */
function devotel_extracted_directory_exists( $directory ) {
	$glob_pattern = trailingslashit( get_template_directory() . '/template-parts/extracted/' . trim( $directory, '/' ) ) . '*.php';
	$files        = glob( $glob_pattern );

	return ! empty( $files );
}

/**
 * Resolve extracted directory name for a page.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function devotel_resolve_extracted_directory_for_post( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return '';
	}

	$slug = (string) get_post_field( 'post_name', $post_id );
	if ( '' === $slug ) {
		return '';
	}
	$page_uri = function_exists( 'get_page_uri' ) ? trim( (string) get_page_uri( $post_id ), '/' ) : '';

	$explicit_map = array(
		'products' => 'products',
	);

	if ( isset( $explicit_map[ $slug ] ) && devotel_extracted_directory_is_usable( $explicit_map[ $slug ] ) ) {
		return $explicit_map[ $slug ];
	}

	$candidates = array_unique(
		array_filter(
			array(
				$page_uri,
				$slug,
				str_replace( '-', '', $slug ),
				str_replace( '-', '_', $slug ),
				preg_replace( '/-us$/', '', $slug ),
			)
		)
	);

	usort(
		$candidates,
		static function ( $a, $b ) {
			return strlen( (string) $b ) <=> strlen( (string) $a );
		}
	);

	foreach ( $candidates as $candidate ) {
		if ( devotel_extracted_directory_is_usable( $candidate ) ) {
			return $candidate;
		}
	}

	return '';
}

/**
 * Render a best-effort fallback from Elementor JSON data.
 *
 * This keeps non-HTML widgets visible after disabling Elementor and provides
 * a migration bridge until all sections are rebuilt in ACF/Gutenberg.
 *
 * @param int $post_id Post ID.
 * @return bool True when fallback markup was rendered.
 */
function devotel_render_elementor_data_fallback( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	$raw = get_post_meta( $post_id, '_elementor_data', true );
	if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
		return false;
	}

	$elements = json_decode( $raw, true );
	if ( ! is_array( $elements ) || empty( $elements ) ) {
		return false;
	}

	$render_node = static function ( $node ) use ( &$render_node ) {
		if ( ! is_array( $node ) ) {
			return '';
		}

		$el_type   = isset( $node['elType'] ) ? (string) $node['elType'] : '';
		$widget    = isset( $node['widgetType'] ) ? (string) $node['widgetType'] : '';
		$settings  = isset( $node['settings'] ) && is_array( $node['settings'] ) ? $node['settings'] : array();
		$children  = isset( $node['elements'] ) && is_array( $node['elements'] ) ? $node['elements'] : array();
		$child_out = '';

		foreach ( $children as $child ) {
			$child_out .= (string) $render_node( $child );
		}

		if ( 'widget' === $el_type ) {
			if ( 'heading' === $widget ) {
				$title = isset( $settings['title'] ) ? (string) $settings['title'] : '';
				if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
					return '';
				}
				return '<h2 class="devotel-el-fallback__heading">' . wp_kses_post( $title ) . '</h2>';
			}

			if ( 'text-editor' === $widget ) {
				$editor = isset( $settings['editor'] ) ? (string) $settings['editor'] : '';
				if ( '' === trim( wp_strip_all_tags( $editor ) ) ) {
					return '';
				}
				return '<div class="devotel-el-fallback__text">' . wp_kses_post( $editor ) . '</div>';
			}

			if ( 'image' === $widget ) {
				$image_url = '';
				$alt       = '';
				if ( isset( $settings['image'] ) && is_array( $settings['image'] ) ) {
					$image_url = isset( $settings['image']['url'] ) ? (string) $settings['image']['url'] : '';
					$alt       = isset( $settings['image']['alt'] ) ? (string) $settings['image']['alt'] : '';
				}
				if ( '' === $image_url ) {
					return '';
				}
				return '<div class="devotel-el-fallback__image"><img loading="lazy" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( $alt ) . '"></div>';
			}

			if ( 'button' === $widget ) {
				$text = isset( $settings['text'] ) ? (string) $settings['text'] : '';
				$url  = isset( $settings['link']['url'] ) ? (string) $settings['link']['url'] : '';
				if ( '' === trim( $text ) ) {
					return '';
				}
				if ( '' === trim( $url ) ) {
					$url = '#';
				}
				return '<p><a class="devotel-btn" href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a></p>';
			}

			if ( 'html' === $widget ) {
				$html = isset( $settings['html'] ) ? (string) $settings['html'] : '';
				if ( '' === trim( $html ) ) {
					return '';
				}

				if ( false === stripos( $html, '<' ) && false !== strpos( $html, '{' ) ) {
					$html = '<style>' . $html . '</style>';
				}

				$html = devotel_strip_embedded_chrome_markup( $html );

				return '<div class="devotel-el-fallback__html">' . $html . '</div>';
			}
		}

		// Render containers/sections/columns as structural wrappers.
		if ( '' !== $child_out ) {
			return '<div class="devotel-el-fallback__container">' . $child_out . '</div>';
		}

		return '';
	};

	$output = '';
	foreach ( $elements as $element ) {
		$output .= (string) $render_node( $element );
	}

	if ( '' === trim( wp_strip_all_tags( $output ) ) ) {
		return false;
	}

	echo '<section class="devotel-el-fallback" data-source="elementor-data">';
	echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';

	return true;
}

/**
 * Build a cache path for a post based on its hierarchical URI.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function devotel_get_cached_uri_path_for_post( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return '';
	}

	$front_page_id = (int) get_option( 'page_on_front' );
	if ( $front_page_id > 0 && $post_id === $front_page_id ) {
		return '';
	}

	if ( function_exists( 'get_page_uri' ) ) {
		$page_uri = (string) get_page_uri( $post_id );
		if ( '' !== $page_uri ) {
			return trim( $page_uri, '/' );
		}
	}

	$slug = (string) get_post_field( 'post_name', $post_id );
	return trim( $slug, '/' );
}

/**
 * Trim homepage snapshot header bleed before elementor-1027 content.
 *
 * @param string $html Snapshot HTML.
 * @return string
 */
function devotel_trim_products_snapshot_bleed( $html ) {
	$html = (string) $html;

	$config_pos = stripos( $html, 'tailwind.config' );
	if ( false !== $config_pos ) {
		$script_start = strripos( substr( $html, 0, $config_pos ), '<script' );
		if ( false !== $script_start ) {
			return substr( $html, $script_start );
		}
	}

	$markers = array(
		'class="d-devotel-products-all-products"',
		"class='d-devotel-products-all-products'",
	);

	foreach ( $markers as $marker ) {
		$pos = stripos( $html, $marker );
		if ( false === $pos ) {
			continue;
		}

		$style_start = strripos( substr( $html, 0, $pos ), '<style' );
		if ( false !== $style_start ) {
			$script_start = strripos( substr( $html, 0, $style_start ), '<script' );
			if ( false !== $script_start && ( $style_start - $script_start ) < 800 ) {
				return substr( $html, $script_start );
			}

			return substr( $html, $style_start );
		}

		$tag_start = strripos( substr( $html, 0, $pos ), '<div' );
		if ( false !== $tag_start ) {
			return substr( $html, $tag_start );
		}

		return substr( $html, $pos );
	}

	return $html;
}

/**
 * Products layout fix CSS (appended after widget inline styles).
 *
 * @return string
 */
function devotel_get_products_layout_fix_css() {
	static $css = null;

	if ( null !== $css ) {
		return $css;
	}

	$path = get_template_directory() . '/assets/css/pages/products.css';
	if ( ! is_readable( $path ) ) {
		$css = '';
		return $css;
	}

	$raw = (string) file_get_contents( $path );
	$css = trim( (string) preg_replace( '/^\/\*[\s\S]*?\*\/\s*/', '', $raw ) );

	return $css;
}

/**
 * CTA button CSS copied from about-us bottom CTA widget.
 *
 * @return string
 */
function devotel_get_products_cta_button_css() {
	return '.d-devotel-products-all-products .cta-main-dark .button{color:#fff;font-family:Inter,sans-serif}'
		. '.d-devotel-products-all-products .cta-main-dark .button2,.d-devotel-products-all-products .cta-main-dark .button2:hover,.d-devotel-products-all-products .cta-main-dark .button2:active,.d-devotel-products-all-products .cta-main-dark .button2:focus,.d-devotel-products-all-products .cta-main-dark .button2:visited{background-color:#325fec!important;color:#fff!important;border-color:transparent!important;text-decoration:none!important}'
		. '.d-devotel-products-all-products .cta-main-dark .button2 *,.d-devotel-products-all-products .cta-main-dark .button2:hover *,.d-devotel-products-all-products .cta-main-dark .button2:active *,.d-devotel-products-all-products .cta-main-dark .button2:focus *{color:#fff!important}'
		. '.d-devotel-products-all-products .cta-main-dark a.button2{display:flex;flex-direction:row;align-items:center;justify-content:center;border-radius:10px;padding:0 15px;position:relative;overflow:hidden;cursor:pointer;width:186px;height:40px;box-sizing:border-box;text-align:center}'
		. '.d-devotel-products-all-products .cta-main-dark .button2 .content{height:40px;display:flex;flex-direction:row;align-items:center;justify-content:center;gap:4px}'
		. '.d-devotel-products-all-products .cta-main-dark .button2 .talk-to-an{position:relative;line-height:24px;font-weight:500;padding:0;transition:transform .3s ease;text-align:center}'
		. '.d-devotel-products-all-products .cta-main-dark .button2:hover .talk-to-an{transform:translateX(-6px)!important}'
		. '.d-devotel-products-all-products .cta-main-dark .button2 .icon{height:20px;width:0;opacity:0;flex-shrink:0;transform:translateX(-8px)!important;transition:width .3s ease,opacity .3s ease,transform .3s ease;overflow:hidden;color:#fff!important}'
		. '.d-devotel-products-all-products .cta-main-dark .button2:hover .icon{width:20px!important;opacity:1!important;transform:translateX(0)!important}'
		. '.d-devotel-products-all-products .cta-main-dark .button2 .icon path{stroke:#fff!important}'
		. '.d-devotel-products-all-products .cta-main-dark .button2:hover{background-color:#1e4fd9!important}';
}

/**
 * Hard overrides injected after the widget stylesheet.
 *
 * @return string
 */
function devotel_get_products_critical_css() {
	return 'body.devotel-products-page .d-devotel-products-all-products,body.elementor-page-495 .d-devotel-products-all-products,.devotel-cached-snapshot .d-devotel-products-all-products{display:flex!important;flex-direction:column!important;height:auto!important;min-height:0!important;background:#f8fafb!important;position:relative!important;overflow:visible!important}'
		. 'body.devotel-products-page .d-devotel-products-all-products>.header-section,body.devotel-products-page .d-devotel-products-all-products>.frame-2147227641,body.devotel-products-page .d-devotel-products-all-products>.cta-main-dark,.devotel-cached-snapshot .d-devotel-products-all-products>.header-section,.devotel-cached-snapshot .d-devotel-products-all-products>.frame-2147227641,.devotel-cached-snapshot .d-devotel-products-all-products>.cta-main-dark{position:relative!important;top:auto!important;left:auto!important;right:auto!important;translate:none!important;opacity:1!important;visibility:visible!important;width:100%!important;max-width:100%!important}'
		. 'body.devotel-products-page .d-devotel-products-all-products .header-section,.devotel-cached-snapshot .d-devotel-products-all-products .header-section{background:linear-gradient(180deg,rgb(23 33 84) 0%,rgb(50 95 236) 100%)!important;opacity:1!important;visibility:visible!important;overflow:visible!important}'
		. 'body.devotel-products-page .d-devotel-products-all-products .header-section .frame-2147227575,.devotel-cached-snapshot .d-devotel-products-all-products .header-section .frame-2147227575{position:relative!important;top:auto!important;left:auto!important;transform:none!important;opacity:1!important;visibility:visible!important;display:flex!important;flex-direction:row!important;flex-wrap:wrap!important;gap:32px!important;width:100%!important;max-width:1240px!important;margin:32px auto 0!important}'
		. 'body.devotel-products-page .d-devotel-products-all-products [class*="animate-"],.devotel-cached-snapshot .d-devotel-products-all-products [class*="animate-"],body.devotel-products-page .d-devotel-products-all-products .heading,body.devotel-products-page .d-devotel-products-all-products .supporting-text,body.devotel-products-page .d-devotel-products-all-products .card-172,body.devotel-products-page .d-devotel-products-all-products .card-132,body.devotel-products-page .d-devotel-products-all-products .card-152,body.devotel-products-page .d-devotel-products-all-products .tabs-and-sort,body.devotel-products-page .d-devotel-products-all-products .frame-2147227640,.devotel-cached-snapshot .d-devotel-products-all-products .heading,.devotel-cached-snapshot .d-devotel-products-all-products .supporting-text,.devotel-cached-snapshot .d-devotel-products-all-products .card-172,.devotel-cached-snapshot .d-devotel-products-all-products .card-132,.devotel-cached-snapshot .d-devotel-products-all-products .card-152,.devotel-cached-snapshot .d-devotel-products-all-products .tabs-and-sort,.devotel-cached-snapshot .d-devotel-products-all-products .frame-2147227640{opacity:1!important;visibility:visible!important;animation:none!important;transform:none!important}'
		. '@media (min-width:769px){body.devotel-products-page .d-devotel-products-all-products .header-section .frame-2147227575,.devotel-cached-snapshot .d-devotel-products-all-products .header-section .frame-2147227575{position:relative!important;top:auto!important;left:auto!important;transform:none!important}}'
		. 'body.devotel-products-page .d-devotel-products-all-products a.content2,.devotel-cached-snapshot .d-devotel-products-all-products a.content2{color:#325fec!important}'
		. 'body.devotel-products-page .d-devotel-products-all-products a.content2 svg path,.devotel-cached-snapshot .d-devotel-products-all-products a.content2 svg path{stroke:#325fec!important}';
}

/**
 * Match about-us CTA: use anchor.button2 instead of anchor > button.button2.
 *
 * @param string $markup Products widget markup.
 * @return string
 */
function devotel_patch_products_cta_button_markup( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_safe_preg_replace(
		'/<a(\s+href=(?:\'[^\']*\'|"[^"]*"))(?:\s+style="[^"]*")?\s*>\s*<button\s+class="button2"\s*>([\s\S]*?)<\/button>\s*<\/a>/i',
		'<a$1 class="button2">$2</a>',
		$markup
	);

	$stroke_patched = preg_replace_callback(
		'/<a\b[^>]*\bclass="button2"[^>]*>[\s\S]*?<\/a>/i',
		static function ( $matches ) {
			return str_replace( 'stroke="currentColor"', 'stroke="#ffffff"', (string) $matches[0] );
		},
		$markup
	);
	if ( is_string( $stroke_patched ) ) {
		$markup = $stroke_patched;
	}

	return $markup;
}

/**
 * Neutralize absolute canvas layout baked into the products widget stylesheet.
 *
 * @param string $markup Products snapshot markup.
 * @return string
 */
function devotel_patch_products_widget_style_block( $markup ) {
	$markup = (string) $markup;
	$needle = '<style>';
	$style_pos = stripos( $markup, $needle );

	if ( false === $style_pos ) {
		return $markup;
	}

	$style_end = stripos( $markup, '</style>', $style_pos );
	if ( false === $style_end ) {
		return $markup;
	}

	$css = substr( $markup, $style_pos + strlen( $needle ), $style_end - $style_pos - strlen( $needle ) );
	$patched = $css;

	$patched = str_replace( 'height:3936px', 'height:auto', $patched );
	$patched = str_replace(
		'width:1440px;position:absolute;left:50%;translate:-50%;top:878px;',
		'width:100%;max-width:1440px;position:relative;left:auto;translate:none;top:auto;margin-left:auto;margin-right:auto;',
		$patched
	);
	$patched = str_replace( '@media (min-width:769px){.frame-2147227641{top:878px!important}}', '', $patched );
	$patched = str_replace(
		'position:absolute;left:0;top:0;overflow:visible;z-index:10}',
		'position:relative;left:auto;top:auto;overflow:visible;z-index:10}',
		$patched
	);
	$patched = str_replace( 'position:absolute;left:0;top:3560px;', 'position:relative;left:auto;top:auto;', $patched );
	$patched = str_replace(
		'position:absolute!important;left:50%!important;transform:translateX(-50%)!important;top:380px!important;',
		'position:relative!important;left:auto!important;transform:none!important;top:auto!important;',
		$patched
	);
	$patched = str_replace(
		'position:absolute!important;left:50%!important;transform:translateX(-50%) scale(var(--gizmo-container-width-scale,1))!important;top:380px!important;',
		'position:relative!important;left:auto!important;transform:none!important;top:auto!important;',
		$patched
	);
	$patched = str_replace(
		'[class*="animate-"]{animation-fill-mode:both}',
		'[class*="animate-"]{animation:none!important;opacity:1!important;visibility:visible!important}',
		$patched
	);
	$patched = str_replace(
		'[class*="animate-"]{animation-fill-mode:forwards}',
		'[class*="animate-"]{animation:none!important;opacity:1!important;visibility:visible!important}',
		$patched
	);
	$patched .= devotel_get_products_critical_css();
	$patched .= devotel_get_products_cta_button_css();

	return substr( $markup, 0, $style_pos + strlen( $needle ) ) . $patched . substr( $markup, $style_end );
}

/**
 * Patch products snapshot markup for document-flow layout.
 *
 * @param string $markup Products snapshot markup.
 * @return string
 */
function devotel_patch_products_snapshot_markup( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_safe_preg_replace(
		'/<script[^>]*src=["\']https?:\/\/cdn\.tailwindcss\.com[^"\']*["\'][^>]*>\s*<\/script>\s*/i',
		'',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/\s+animate-(?:fade|scale|slide)-[a-z0-9-]+/i',
		'',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/\sstyle="animation-delay:\s*[^"]*;\s*animation-fill-mode:\s*both;"/i',
		'',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/(<img\b[^>]*\bsrc="(?!data:image\/svg\+xml)[^"]+")[^>]*\s+src="data:image\/svg\+xml[^"]*"/i',
		'$1',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/<img\b([^>]*)\sdata-src="([^"]+)"([^>]*)\ssrc="data:image\/svg\+xml[^"]*"[^>]*>/i',
		'<img$1 src="$2"$3>',
		$markup
	);

	$markup = devotel_patch_products_cta_button_markup( $markup );
	$markup = devotel_patch_products_widget_style_block( $markup );

	$fix_css = devotel_get_products_layout_fix_css();
	if ( '' !== $fix_css ) {
		$markup .= '<style id="devotel-products-layout-fix">' . $fix_css . '</style>';
	}

	$markup .= '<style id="devotel-products-cta-button">' . devotel_get_products_cta_button_css() . '</style>';

	return $markup;
}

/**
 * Whether a URI path is a nested product subpage (not the main /products/ listing).
 *
 * @param string $uri_path Relative URI path.
 * @return bool
 */
function devotel_is_product_subpage_uri_path( $uri_path ) {
	$uri_path = trim( (string) $uri_path, '/' );
	if ( '' === $uri_path || 'products' === $uri_path ) {
		return false;
	}

	$prefixes = array(
		'products/communication-apis/',
		'products/platforms/',
		'products/telco/',
		'products/sim-based/',
	);

	foreach ( $prefixes as $prefix ) {
		if ( str_starts_with( $uri_path, $prefix ) && strlen( $uri_path ) > strlen( $prefix ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Critical CSS for product subpages (Elementor HTML widgets without runtime).
 *
 * @return string
 */
function devotel_get_product_subpage_critical_css() {
	return 'body.devotel-product-subpage article.devotel-page,body.devotel-communication-apis-page article.devotel-page,body.devotel-platforms-page article.devotel-page,body.devotel-telco-page article.devotel-page,body.devotel-sim-based-page article.devotel-page{padding-left:0!important;padding-right:0!important;max-width:100%!important}'
		. 'body.devotel-product-subpage .devotel-cached-snapshot .elementor-invisible,body.devotel-communication-apis-page .devotel-cached-snapshot .elementor-invisible,body.devotel-platforms-page .devotel-cached-snapshot .elementor-invisible,body.devotel-telco-page .devotel-cached-snapshot .elementor-invisible,body.devotel-sim-based-page .devotel-cached-snapshot .elementor-invisible,body.devotel-sim-based-page .devotel-el-fallback .elementor-invisible{opacity:1!important;visibility:visible!important;animation:none!important}'
		. 'body.devotel-product-subpage .devotel-cached-snapshot [class*="animate-"],body.devotel-communication-apis-page .devotel-cached-snapshot [class*="animate-"],body.devotel-platforms-page .devotel-cached-snapshot [class*="animate-"],body.devotel-telco-page .devotel-cached-snapshot [class*="animate-"],body.devotel-sim-based-page .devotel-cached-snapshot [class*="animate-"],body.devotel-sim-based-page .devotel-el-fallback [class*="animate-"]{opacity:1!important;visibility:visible!important;animation:none!important;transform:none!important}'
		. 'body.devotel-product-subpage .devotel-cached-snapshot .elementor-widget-heading .elementor-heading-title,body.devotel-communication-apis-page .devotel-cached-snapshot .elementor-widget-heading .elementor-heading-title,body.devotel-platforms-page .devotel-cached-snapshot .elementor-widget-heading .elementor-heading-title,body.devotel-telco-page .devotel-cached-snapshot .elementor-widget-heading .elementor-heading-title,body.devotel-sim-based-page .devotel-cached-snapshot .elementor-widget-heading .elementor-heading-title,body.devotel-sim-based-page .devotel-el-fallback .elementor-widget-heading .elementor-heading-title{opacity:1!important;visibility:visible!important}'
		. '@media (max-width:767px){body.devotel-product-subpage section.devotel-cached-snapshot,body.devotel-communication-apis-page section.devotel-cached-snapshot,body.devotel-platforms-page section.devotel-cached-snapshot,body.devotel-telco-page section.devotel-cached-snapshot,body.devotel-sim-based-page section.devotel-cached-snapshot{background:#fdfdfe!important;background-image:none!important}body.devotel-product-subpage .devotel-cached-snapshot .ts-section,body.devotel-communication-apis-page .devotel-cached-snapshot .ts-section,body.devotel-platforms-page .devotel-cached-snapshot .ts-section,body.devotel-telco-page .devotel-cached-snapshot .ts-section,body.devotel-sim-based-page .devotel-cached-snapshot .ts-section{background:#fdfdfe!important;background-image:none!important}}';
}

/**
 * Read a product subpage snapshot HTML file for a URI path.
 *
 * @param string $uri_path Relative URI path.
 * @return string
 */
function devotel_get_product_subpage_snapshot_source_html( $uri_path ) {
	$uri_path = trim( (string) $uri_path, '/' );
	if ( '' === $uri_path ) {
		return '';
	}

	$sources = array();

	$wpo_file = devotel_get_wpo_cache_snapshot_file( $uri_path );
	if ( '' !== $wpo_file ) {
		$sources[] = $wpo_file;
	}

	$sources[] = get_template_directory() . '/snapshots/' . $uri_path . '/index.html';

	foreach ( $sources as $source ) {
		if ( is_readable( $source ) ) {
			$html = (string) file_get_contents( $source );
			if ( '' !== trim( $html ) ) {
				return $html;
			}
		}
	}

	return '';
}

/**
 * Find the byte offset immediately after the closing </div> for an opening <div>.
 *
 * @param string $html     Full HTML document.
 * @param int    $open_pos Offset of the opening <div>.
 * @return int|false
 */
function devotel_find_balanced_div_close_end( $html, $open_pos ) {
	$html     = (string) $html;
	$open_pos = (int) $open_pos;
	$len      = strlen( $html );

	if ( $open_pos < 0 || $open_pos >= $len || ! preg_match( '/<div\b/i', $html, $open_match, 0, $open_pos ) ) {
		return false;
	}

	$depth = 1;
	$i     = $open_pos + strlen( $open_match[0] );

	while ( $i < $len ) {
		$next_open  = stripos( $html, '<div', $i );
		$next_close = stripos( $html, '</div>', $i );

		if ( false === $next_close ) {
			break;
		}

		if ( false !== $next_open && $next_open < $next_close && preg_match( '/<div\b/i', $html, $open_tag, 0, $next_open ) && (int) $open_tag[0][1] === $next_open ) {
			$depth++;
			$i = $next_open + 4;
			continue;
		}

		$depth--;
		$i = $next_close + 6;
		if ( 0 === $depth ) {
			return $i;
		}
	}

	return false;
}

/**
 * Resolve slice end offset for product subpage snapshots.
 *
 * @param string $html      Full snapshot HTML.
 * @param int    $start_pos Slice start offset.
 * @param string $wrapper   Slice wrapper type.
 * @return int|false
 */
function devotel_find_product_subpage_snapshot_end_pos( $html, $start_pos, $wrapper ) {
	$html      = (string) $html;
	$start_pos = (int) $start_pos;
	$wrapper   = (string) $wrapper;

	$chrome_markers = array(
		'data-elementor-type="footer"',
		'id="devotel-footer-wrapper"',
	);

	foreach ( $chrome_markers as $marker ) {
		$chrome_pos = stripos( $html, $marker, $start_pos );
		if ( false === $chrome_pos ) {
			continue;
		}

		$before   = substr( $html, $start_pos, $chrome_pos - $start_pos );
		$last_div = strripos( $before, '</div>' );
		if ( false !== $last_div ) {
			return $start_pos + $last_div + strlen( '</div>' );
		}
	}

	$end_markers = array(
		'</section>	</article>',
		'</section></article>',
	);

	foreach ( $end_markers as $marker ) {
		$pos = stripos( $html, $marker, $start_pos );
		if ( false === $pos ) {
			continue;
		}

		if ( 'elementor' === $wrapper ) {
			$before   = substr( $html, $start_pos, $pos - $start_pos );
			$last_div = strripos( $before, '</div>' );
			if ( false !== $last_div ) {
				return $start_pos + $last_div + strlen( '</div>' );
			}
		}

		return $pos;
	}

	if ( 'elementor' === $wrapper ) {
		$balanced_end = devotel_find_balanced_div_close_end( $html, $start_pos );
		if ( false !== $balanced_end ) {
			return $balanced_end;
		}
	}

	return false;
}

/**
 * Slice product subpage body markup from a full-page snapshot HTML document.
 *
 * @param string $html Full snapshot HTML.
 * @param int    $elementor_id Elementor page ID for wrapper.
 * @return string
 */
function devotel_slice_product_subpage_snapshot_html( $html, $elementor_id = 0 ) {
	$html = (string) $html;
	if ( '' === trim( $html ) ) {
		return '';
	}

	$elementor_id = (int) $elementor_id;
	$start_pos    = false;
	$end_pos      = false;
	$wrapper      = 'fallback';

	$fallback_marker = '<section class="devotel-el-fallback" data-source="elementor-data">';
	$fallback_pos    = stripos( $html, $fallback_marker );
	if ( false !== $fallback_pos ) {
		$start_pos = $fallback_pos + strlen( $fallback_marker );
		$wrapper   = 'fallback';
	}

	if ( false === $start_pos ) {
		$snapshot_marker = '<section class="devotel-cached-snapshot devotel-product-subpage" data-source="extracted-widget">';
		$snapshot_pos    = stripos( $html, $snapshot_marker );
		if ( false !== $snapshot_pos ) {
			$start_pos = $snapshot_pos + strlen( $snapshot_marker );
			$wrapper   = 'snapshot';
		}
	}

	if ( false === $start_pos && $elementor_id > 0 ) {
		$elementor_marker = 'class="elementor elementor-' . $elementor_id . '"';
		$elementor_pos    = stripos( $html, $elementor_marker );
		if ( false !== $elementor_pos ) {
			$tag_start = strripos( substr( $html, 0, $elementor_pos ), '<div' );
			$start_pos = false !== $tag_start ? $tag_start : $elementor_pos;
			$wrapper   = 'elementor';
		}
	}

	if ( false === $start_pos ) {
		return '';
	}

	$end_pos = devotel_find_product_subpage_snapshot_end_pos( $html, $start_pos, $wrapper );
	if ( false === $end_pos ) {
		return '';
	}

	$markup = substr( $html, $start_pos, $end_pos - $start_pos );
	$markup = trim( (string) $markup );

	$footer_pos = stripos( $markup, 'id="devotel-footer-wrapper"' );
	if ( false !== $footer_pos ) {
		$markup = substr( $markup, 0, $footer_pos );
	}

	$markup = devotel_strip_extracted_document_bleed( $markup );
	$markup = devotel_safe_preg_replace(
		'/<script[^>]*src=["\']https?:\/\/cdn\.tailwindcss\.com[^"\']*["\'][^>]*>\s*<\/script>\s*/i',
		'',
		$markup
	);

	if ( 'elementor' !== $wrapper && $elementor_id > 0 ) {
		$markup = '<div data-elementor-type="wp-page" data-elementor-id="' . $elementor_id . '" class="elementor elementor-' . $elementor_id . '" data-elementor-post-type="page">' . $markup . '</div>';
	}

	return trim( (string) $markup );
}

/**
 * Build extracted product subpage markup from WPO/theme snapshots.
 *
 * @param string $uri_path Relative URI path.
 * @param int    $elementor_id Elementor page ID.
 * @return string
 */
function devotel_get_product_subpage_snapshot_extract_markup( $uri_path, $elementor_id = 0 ) {
	$html = devotel_get_product_subpage_snapshot_source_html( $uri_path );
	if ( '' === $html ) {
		return '';
	}

	return devotel_slice_product_subpage_snapshot_html( $html, $elementor_id );
}

/**
 * Remove inline hi-section scroll-lock script (loaded via sim-based-how-it-works.js).
 *
 * @param string $markup Snapshot/extracted markup.
 * @return string
 */
function devotel_strip_sim_based_hi_section_inline_script( $markup ) {
	$markup = (string) $markup;
	$marker = "getElementById('hi-line-progress')";
	$pos    = strpos( $markup, $marker );
	if ( false === $pos ) {
		$marker = 'getElementById("hi-line-progress")';
		$pos    = strpos( $markup, $marker );
	}
	if ( false === $pos ) {
		return $markup;
	}

	$script_start = strripos( substr( $markup, 0, $pos ), '<script' );
	$script_end   = stripos( $markup, '</script>', $pos );
	if ( false === $script_start || false === $script_end ) {
		return $markup;
	}

	$script_tag = substr( $markup, $script_start, $script_end - $script_start + 9 );
	if ( false !== stripos( $script_tag, 'src=' ) ) {
		return $markup;
	}

	return substr( $markup, 0, $script_start ) . substr( $markup, $script_end + 9 );
}

/**
 * Ensure contact blocks expose cm7/cm6 scroll targets for hero CTAs.
 *
 * @param string $markup Snapshot/extracted markup.
 * @return string
 */
function devotel_patch_product_subpage_contact_scroll_anchors( $markup ) {
	$markup = (string) $markup;

	if ( false === stripos( $markup, 'id="cm7"' ) && false === stripos( $markup, "id='cm7'" ) ) {
		$markup = devotel_safe_preg_replace(
			'/(<div class="devotel-el-fallback__container)([^>]*)(>\s*<div class="devotel-el-fallback__container">\s*<h2 class="devotel-el-fallback__heading">Contact us<\/h2>)/i',
			'$1$2 id="cm7" class="cm7"$3',
			$markup,
			1
		);

		$markup = devotel_safe_preg_replace(
			'/(<div(?![^>]*\bid=["\']cm7["\'])[^>]*\bclass="[^"]*\bcm7\b[^"]*")/i',
			'$1 id="cm7"',
			$markup,
			1
		);
	}

	if ( false === stripos( $markup, 'id="cm6"' ) && false === stripos( $markup, "id='cm6'" ) ) {
		$markup = devotel_safe_preg_replace(
			'/(<div(?![^>]*\bid=["\']cm6["\'])[^>]*\bclass="[^"]*\bcm6\b[^"]*elementor-hidden-desktop[^"]*")/i',
			'$1 id="cm6"',
			$markup,
			1
		);
	}

	return $markup;
}

/**
 * Ensure testimonial carousel logos use the shared ts-company-logo class.
 *
 * @param string $markup Subpage markup.
 * @return string
 */
function devotel_patch_product_subpage_testimonial_logos( $markup ) {
	$markup = (string) $markup;

	if ( false === stripos( $markup, 'ts-section' ) ) {
		return $markup;
	}

	$markup = devotel_safe_preg_replace(
		'/(<div class="ts-image-frame">\s*<img)(?![^>]*\bclass=)/i',
		'$1 class="ts-company-logo"',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/(<div class="ts-image-frame">\s*<img\b(?![^>]*\bts-company-logo\b)[^>]*\bclass=")([^"]*)(")/i',
		'$1$2 ts-company-logo$3',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/(<div class="ts-company-name">\s*<img)(?![^>]*\bclass=)/i',
		'$1 class="ts-company-logo"',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/(<div class="ts-company-name">\s*<img\b(?![^>]*\bts-company-logo\b)[^>]*\bclass=")([^"]*)(")/i',
		'$1$2 ts-company-logo$3',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/\bclass="([^"]*)\bts-company-logo(?:\s+ts-company-logo)+\b([^"]*)"/i',
		'class="$1ts-company-logo$2"',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/\bclass="\s*ts-company-logo\s+ts-company-logo\s*"/i',
		'class="ts-company-logo"',
		$markup
	);

	return $markup;
}

/**
 * Render the homepage solutions hero markup.
 *
 * @return string
 */
function devotel_get_home_solutions_hero_markup() {
	ob_start();
	get_template_part( 'template-parts/components/home', 'solutions-hero' );
	$markup = ob_get_clean();

	return is_string( $markup ) ? $markup : '';
}

/**
 * Replace legacy Elementor homepage hero with the solutions hero component.
 *
 * @param string $markup Page markup.
 * @return string
 */
function devotel_patch_home_hero_section( $markup ) {
	$markup = (string) $markup;

	if ( false !== stripos( $markup, 'devotel-solutions' ) ) {
		return $markup;
	}

	if ( false === stripos( $markup, 'elementor-element-09ee701' ) ) {
		return $markup;
	}

	$replacement = devotel_get_home_solutions_hero_markup();
	if ( '' === trim( $replacement ) ) {
		return $markup;
	}

	$wrapped = '<section class="devotel-section devotel-section--hero devotel-section--solutions-hero" aria-label="hero">'
		. $replacement
		. '</section>';

	$needle    = 'elementor-element-09ee701';
	$pos       = stripos( $markup, $needle );
	$div_start = false === $pos ? false : strrpos( substr( $markup, 0, $pos ), '<div' );

	if ( false === $div_start ) {
		return $markup;
	}

	$div_end = devotel_find_balanced_div_end( $markup, $div_start );
	if ( false === $div_end ) {
		return $markup;
	}

	return substr( $markup, 0, $div_start ) . $wrapped . substr( $markup, $div_end );
}

/**
 * Render the shared partner logos section markup.
 *
 * @return string
 */
function devotel_get_partner_logos_markup() {
	ob_start();
	get_template_part( 'template-parts/components/partner', 'logos' );
	$markup = ob_get_clean();

	return is_string( $markup ) ? $markup : '';
}

/**
 * Align homepage stats globe mobile sizing/rendering with desktop colors.
 *
 * @param string $markup Homepage markup.
 * @return string
 */
function devotel_patch_home_globe_section( $markup ) {
	$markup = (string) $markup;

	if ( false === stripos( $markup, 'frame-2147227567' ) ) {
		return $markup;
	}

	$replacements = array(
		'contain:layout style paint!important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%)!important' => 'contain:layout style!important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%)!important',
		'contain:layout style paint !important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%) !important' => 'contain:layout style !important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%) !important',
		'contain: layout style paint !important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%) !important' => 'contain: layout style !important;background:linear-gradient(159deg,#01050E 29.41%,#325FEC 114.95%) !important',
		'.frame-2147227567 .layer-1{flex-shrink:0!important;width:540px!important;height:540px!important;max-width:calc(100vw - 32px)!important;max-height:calc(100vw - 32px)!important;' => '.frame-2147227567 .layer-1{flex-shrink:0!important;width:min(540px,calc(100vw - 32px))!important;height:min(540px,calc(100vw - 32px))!important;max-width:min(540px,calc(100vw - 32px))!important;max-height:min(540px,calc(100vw - 32px))!important;min-width:0!important;min-height:0!important;',
		'.frame-2147227567 .layer-1{flex-shrink:0 !important;width:540px !important;height:540px !important;max-width:calc(100vw - 32px) !important;max-height:calc(100vw - 32px) !important;' => '.frame-2147227567 .layer-1{flex-shrink:0 !important;width:min(540px,calc(100vw - 32px)) !important;height:min(540px,calc(100vw - 32px)) !important;max-width:min(540px,calc(100vw - 32px)) !important;max-height:min(540px,calc(100vw - 32px)) !important;min-width:0 !important;min-height:0 !important;',
		'.frame-2147227567 #globe-container{width:100%!important;height:100%!important;min-width:540px!important;min-height:540px!important;' => '.frame-2147227567 #globe-container{width:100%!important;height:100%!important;min-width:0!important;min-height:0!important;',
		'.frame-2147227567 #globe-container{width:100% !important;height:100% !important;min-width:540px !important;min-height:540px !important;' => '.frame-2147227567 #globe-container{width:100% !important;height:100% !important;min-width:0 !important;min-height:0 !important;',
		'let width=container.offsetWidth;let height=container.offsetHeight;if(width===0||height===0){const computedStyle=window.getComputedStyle(container);width=parseFloat(computedStyle.width)||500;height=parseFloat(computedStyle.height)||500;if(width===0||height===0){const isMobile=window.innerWidth<=768;width=isMobile?540:820;height=isMobile?540:820}' => 'const rect=container.getBoundingClientRect();let width=Math.round(rect.width)||container.offsetWidth;let height=Math.round(rect.height)||container.offsetHeight;if(width<100||height<100){const isMobile=window.innerWidth<=768;const fallback=isMobile?Math.min(540,window.innerWidth-32):820;width=width<100?fallback:width;height=height<100?fallback:height}',
		'if(w>0&&h>0&&camera&&renderer){camera.aspect=w/h;camera.updateProjectionMatrix();renderer.setSize(w,h)}' => 'if(w>0&&h>0&&camera&&renderer){camera.aspect=w/h;camera.updateProjectionMatrix();renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));renderer.setSize(w,h,true)}',
	);

	foreach ( $replacements as $search => $replace ) {
		if ( false !== strpos( $markup, $search ) ) {
			$markup = str_replace( $search, $replace, $markup );
		}
	}

	return $markup;
}

/**
 * Replace legacy marquee social-proof block with the grid partner logos component.
 *
 * @param string $markup Page markup.
 * @return string
 */
function devotel_patch_social_proof_section( $markup ) {
	$markup = (string) $markup;

	$replacement = devotel_get_partner_logos_markup();
	if ( '' === trim( $replacement ) ) {
		return $markup;
	}

	$has_canonical_sp = false !== stripos( $markup, 'sp-section' )
		&& false !== stripos( $markup, 'sp-grid-separator-h-row' );

	if ( $has_canonical_sp && false === stripos( $markup, 'social-proof-section' ) ) {
		if ( false !== stripos( $markup, 'elementor-element-cc977f7' ) ) {
			$needle    = 'elementor-element-cc977f7';
			$pos       = stripos( $markup, $needle );
			$div_start = false === $pos ? false : strrpos( substr( $markup, 0, $pos ), '<div' );

			if ( false !== $div_start ) {
				$div_end = devotel_find_balanced_div_end( $markup, $div_start );
				if ( false !== $div_end ) {
					return substr( $markup, 0, $div_start ) . $replacement . substr( $markup, $div_end );
				}
			}
		}

		return $markup;
	}

	if ( false !== stripos( $markup, 'social-proof-section' ) ) {
		$markup = devotel_safe_preg_replace(
			'/<style>\.social-proof-section[\s\S]*?<\/style>\s*/i',
			'',
			$markup,
			1
		);

		$needle    = 'social-proof-section';
		$pos       = stripos( $markup, $needle );
		$div_start = false === $pos ? false : strrpos( substr( $markup, 0, $pos ), '<div' );

		if ( false !== $div_start ) {
			$div_end = devotel_find_balanced_div_end( $markup, $div_start );
			if ( false !== $div_end ) {
				return substr( $markup, 0, $div_start ) . $replacement . substr( $markup, $div_end );
			}
		}
	}

	if ( false !== stripos( $markup, 'sp-section' ) && ! $has_canonical_sp ) {
		$pos       = stripos( $markup, 'sp-section' );
		$div_start = false === $pos ? false : strrpos( substr( $markup, 0, $pos ), '<div' );

		if ( false !== $div_start ) {
			$div_end = devotel_find_balanced_div_end( $markup, $div_start );
			if ( false !== $div_end ) {
				return substr( $markup, 0, $div_start ) . $replacement . substr( $markup, $div_end );
			}
		}
	}

	return $markup;
}

/**
 * Render the homepage product use-cases section markup.
 *
 * @return string
 */
function devotel_get_home_product_use_cases_markup() {
	ob_start();
	get_template_part( 'template-parts/components/home', 'product-use-cases' );
	$markup = ob_get_clean();

	return is_string( $markup ) ? $markup : '';
}

/**
 * Replace legacy homepage products tabs block with the use-cases card grid.
 *
 * @param string $markup Page markup.
 * @return string
 */
function devotel_patch_home_product_use_cases_section( $markup ) {
	$markup = (string) $markup;

	if ( false !== stripos( $markup, 'devotel-product-use-cases' ) ) {
		return $markup;
	}

	$replacement = devotel_get_home_product_use_cases_markup();
	if ( '' === trim( $replacement ) ) {
		return $markup;
	}

	$needles = array( 'elementor-element-e06718b', 'dvthm-prdsec-root' );
	$pos     = false;

	foreach ( $needles as $needle ) {
		$found = stripos( $markup, $needle );
		if ( false !== $found ) {
			$pos = $found;
			break;
		}
	}

	if ( false === $pos ) {
		return $markup;
	}

	$div_start = strrpos( substr( $markup, 0, $pos ), '<div' );
	if ( false === $div_start ) {
		return $markup;
	}

	$div_end = devotel_find_balanced_div_end( $markup, $div_start );
	if ( false === $div_end ) {
		return $markup;
	}

	return substr( $markup, 0, $div_start ) . $replacement . substr( $markup, $div_end );
}

/**
 * Scope embedded final-CTA mobile CSS to the CTA section only.
 *
 * Legacy widgets used `section { background: … }`, which painted the outer
 * snapshot wrapper and transparent sections blue on mobile.
 *
 * @param string $markup Subpage markup.
 * @return string
 */
function devotel_patch_product_subpage_cta_mobile_section_css( $markup ) {
	$replacements = array(
		'@media (max-width:768px){section{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg,#1E318A 22.26%,#266DF0 79.12%)!important}' => '@media (max-width:768px){section.bg-gradient-to-r,section[class*="bg-gradient-to-r"]{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg,#1E318A 22.26%,#266DF0 79.12%)!important}',
		'@media (max-width: 768px){section{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg,#1E318A 22.26%,#266DF0 79.12%)!important}' => '@media (max-width: 768px){section.bg-gradient-to-r,section[class*="bg-gradient-to-r"]{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg,#1E318A 22.26%,#266DF0 79.12%)!important}',
		'@media (max-width: 768px){section{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg, #1E318A 22.26%, #266DF0 79.12%)!important}' => '@media (max-width: 768px){section.bg-gradient-to-r,section[class*="bg-gradient-to-r"]{min-height:auto;padding-bottom:48px;background:linear-gradient(164deg, #1E318A 22.26%, #266DF0 79.12%)!important}',
	);

	foreach ( $replacements as $search => $replace ) {
		if ( false !== strpos( $markup, $search ) ) {
			$markup = str_replace( $search, $replace, $markup );
		}
	}

	return $markup;
}

/**
 * Patch product subpage snapshot/extracted markup.
 *
 * @param string $markup Subpage markup.
 * @return string
 */
function devotel_patch_product_subpage_snapshot_markup( $markup ) {
	$markup = (string) $markup;

	$markup = devotel_strip_extracted_document_bleed( $markup );
	$markup = devotel_patch_social_proof_section( $markup );
	$markup = devotel_patch_product_subpage_testimonial_logos( $markup );
	$markup = devotel_patch_product_subpage_cta_mobile_section_css( $markup );
	$markup = devotel_rewrite_legacy_site_urls( $markup );
	$markup = devotel_safe_preg_replace(
		'/body\s*\{\s*min-height:\s*200vh;\s*margin:\s*0;\s*\}/i',
		'',
		$markup
	);
	$markup = devotel_strip_sim_based_hi_section_inline_script( $markup );
	$markup = devotel_patch_product_subpage_contact_scroll_anchors( $markup );

	if ( function_exists( 'devotel_patch_form_card_padding_markup' ) ) {
		$markup = devotel_patch_form_card_padding_markup( $markup );
	}

	$markup = devotel_strip_embedded_tailwind_scripts( $markup );
	$markup = devotel_strip_embedded_google_fonts( $markup );
	$markup = devotel_safe_preg_replace( '/\s+elementor-invisible\b/i', '', $markup );
	$markup = devotel_safe_preg_replace(
		'/\s+animate-(?:fade|scale|slide)-[a-z0-9-]+/i',
		'',
		$markup
	);
	$markup = devotel_safe_preg_replace(
		'/\sstyle="animation-delay:\s*[^"]*;\s*animation-fill-mode:\s*both;"/i',
		'',
		$markup
	);
	$markup = devotel_fix_smush_duplicate_src_markup( $markup );
	$markup = devotel_safe_preg_replace( '/<header[^>]*class="[^"]*entry-header[^"]*"[^>]*>[\s\S]*?<\/header>/i', '', $markup );
	$markup = devotel_safe_preg_replace( '/<h1[^>]*class="[^"]*entry-title[^"]*"[^>]*>[\s\S]*?<\/h1>/i', '', $markup );

	if ( function_exists( 'do_shortcode' ) ) {
		$markup = do_shortcode( $markup );
	}

	$markup .= '<style id="devotel-product-subpage-critical">' . devotel_get_product_subpage_critical_css() . '</style>';

	return $markup;
}

/**
 * Include a contact extracted widget and return its HTML output.
 *
 * @param string $basename Widget filename.
 * @return string
 */
function devotel_include_contact_widget_markup( $basename ) {
	$basename = sanitize_file_name( (string) $basename );
	if ( '' === $basename ) {
		return '';
	}

	$path = get_template_directory() . '/template-parts/extracted/contact/' . $basename;
	if ( ! is_readable( $path ) ) {
		return '';
	}

	ob_start();
	include $path;

	return (string) ob_get_clean();
}

/**
 * Replace inner HTML of an Elementor HTML widget matched by data-id.
 *
 * @param string $markup       Snapshot HTML.
 * @param string $widget_id    Elementor widget data-id value.
 * @param string $replacement  New widget body HTML.
 * @return string
 */
function devotel_replace_elementor_html_widget_content( $markup, $widget_id, $replacement ) {
	$markup      = (string) $markup;
	$widget_id   = sanitize_key( (string) $widget_id );
	$replacement = (string) $replacement;

	if ( '' === $widget_id || '' === trim( $replacement ) ) {
		return $markup;
	}

	$needle = 'data-id="' . $widget_id . '"';
	$start  = strpos( $markup, $needle );
	if ( false === $start ) {
		return $markup;
	}

	$content_start = strpos( $markup, '>', $start );
	if ( false === $content_start ) {
		return $markup;
	}
	$content_start++;

	$depth = 1;
	$pos   = $content_start;
	$len   = strlen( $markup );

	while ( $pos < $len && $depth > 0 ) {
		$next_open  = stripos( $markup, '<div', $pos );
		$next_close = stripos( $markup, '</div>', $pos );

		if ( false === $next_close ) {
			break;
		}

		if ( false !== $next_open && $next_open < $next_close ) {
			$depth++;
			$pos = $next_open + 4;
			continue;
		}

		$depth--;
		if ( 0 === $depth ) {
			return substr( $markup, 0, $content_start ) . $replacement . substr( $markup, $next_close );
		}

		$pos = $next_close + 6;
	}

	return $markup;
}

/**
 * Swap broken Tailwind-dependent location widgets with self-contained markup.
 *
 * @param string $markup Contact Us snapshot HTML.
 * @return string
 */
function devotel_patch_contact_us_snapshot_markup( $markup ) {
	$markup = devotel_replace_elementor_html_widget_content(
		$markup,
		'f7c355e',
		devotel_include_contact_widget_markup( 'widget-f7c355e.php' )
	);

	$markup = devotel_replace_elementor_html_widget_content(
		$markup,
		'88b8c88',
		devotel_include_contact_widget_markup( 'widget-88b8c88.php' )
	);

	return $markup;
}

/**
 * Render a product subpage from extracted widgets.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function devotel_render_product_subpage_for_post( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	$uri_path = devotel_get_cached_uri_path_for_post( $post_id );
	if ( ! devotel_is_product_subpage_uri_path( $uri_path ) ) {
		return false;
	}

	$relative = $uri_path . '/section-main';
	$markup   = devotel_get_extracted_markup( $relative );

	if ( '' === trim( $markup ) ) {
		$markup = devotel_get_cached_snapshot_markup( $uri_path );
	}

	if ( '' === trim( $markup ) || ! devotel_markup_is_substantial( $markup ) ) {
		return false;
	}

	$markup = devotel_patch_product_subpage_snapshot_markup( $markup );

	echo '<section class="devotel-cached-snapshot devotel-product-subpage" data-source="extracted-widget">';
	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';

	return true;
}

/**
 * Render products page from the extracted widget (cleaner than WPO snapshot).
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function devotel_render_products_extracted_for_post( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	$markup = devotel_get_extracted_markup( 'products/widget-f330ca4' );
	if ( '' === trim( $markup ) ) {
		return false;
	}

	$markup = devotel_patch_products_snapshot_markup( $markup );

	echo '<section class="devotel-cached-snapshot devotel-products-widget" data-source="extracted-widget">';
	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';

	return true;
}

/**
 * Find where trimmed products widget markup ends.
 *
 * @param string $html Products snapshot HTML.
 * @return int|false
 */
function devotel_find_products_snapshot_content_end( $html ) {
	$html = (string) $html;
	$markers = array(
		'class="d-devotel-products-all-products"',
		"class='d-devotel-products-all-products'",
	);

	foreach ( $markers as $marker ) {
		$pos = stripos( $html, $marker );
		if ( false === $pos ) {
			continue;
		}

		$tag_start = strripos( substr( $html, 0, $pos ), '<div' );
		if ( false === $tag_start ) {
			continue;
		}

		$end = devotel_find_balanced_div_end( $html, $tag_start );
		if ( false !== $end ) {
			return $end;
		}
	}

	return false;
}

function devotel_trim_home_snapshot_bleed( $html ) {
	$markers = array(
		'class="elementor elementor-1027"',
		'data-elementor-id="1027"',
	);

	foreach ( $markers as $marker ) {
		$pos = stripos( $html, $marker );
		if ( false === $pos ) {
			continue;
		}

		$tag_start = strripos( substr( $html, 0, $pos ), '<div' );
		if ( false !== $tag_start ) {
			return substr( $html, $tag_start );
		}

		return substr( $html, $pos );
	}

	return $html;
}

/**
 * Find where snapshot page content starts.
 *
 * @param string $html Snapshot HTML.
 * @param string $uri_path Relative URI path.
 * @return int|false
 */
function devotel_find_snapshot_content_start( $html, $uri_path = '' ) {
	$uri_path = trim( (string) $uri_path, '/' );

	if ( 'privacy-policy' === $uri_path ) {
		$privacy_markers = array(
			'class="elementor elementor-3"',
			'class="d-devotelutilityprivacy-po"',
			'elementor-element-955add0',
		);

		foreach ( $privacy_markers as $marker ) {
			$pos = stripos( $html, $marker );
			if ( false === $pos ) {
				continue;
			}

			$tag_start = strripos( substr( $html, 0, $pos ), '<div' );
			if ( false !== $tag_start ) {
				return $tag_start;
			}

			return $pos;
		}
	}

	if ( '' === $uri_path ) {
		$trimmed = devotel_trim_home_snapshot_bleed( $html );
		if ( $trimmed !== $html ) {
			return 0;
		}
	} elseif ( 'products' === $uri_path || str_starts_with( $uri_path, 'products/' ) ) {
		$trimmed = devotel_trim_products_snapshot_bleed( $html );
		if ( $trimmed !== $html ) {
			return 0;
		}
	}

	$types  = array( 'wp-page', 'archive', 'single-page', 'single' );
	$best   = false;
	$offset = 0;

	foreach ( $types as $type ) {
		$needle = 'data-elementor-type="' . $type . '"';
		$offset = 0;

		while ( false !== ( $pos = stripos( $html, $needle, $offset ) ) ) {
			$tag_start = strripos( substr( $html, 0, $pos ), '<div' );
			$candidate = false !== $tag_start ? $tag_start : $pos;

			if ( false === $best || $candidate < $best ) {
				$best = $candidate;
			}

			$offset = $pos + 1;
		}
	}

	if ( false !== $best ) {
		return $best;
	}

	return stripos( $html, '<div class="elementor elementor-' );
}

/**
 * Find where snapshot page content ends.
 *
 * @param string $html Snapshot HTML.
 * @param int    $content_start Start position.
 * @return int|false
 */
function devotel_find_snapshot_content_end( $html, $content_start ) {
	$markers = array(
		'<footer id="site-footer"',
		'data-elementor-type="footer"',
		'id="devotel-footer-wrapper"',
	);

	$best = false;
	foreach ( $markers as $marker ) {
		$pos = stripos( $html, $marker, $content_start );
		if ( false !== $pos && ( false === $best || $pos < $best ) ) {
			$best = $pos;
		}
	}

	if ( false !== $best ) {
		return $best;
	}

	$body_end = strripos( $html, '</body>' );
	if ( false !== $body_end && $body_end > $content_start ) {
		return $body_end;
	}

	return false;
}

/**
 * Remove accidental full-page chrome from snapshot markup.
 *
 * @param string $markup Snapshot markup.
 * @return string
 */
function devotel_strip_embedded_chrome_markup( $markup ) {
	if ( preg_match( '/^\s*<!DOCTYPE/i', $markup ) ) {
		$markup = preg_replace( '/<!DOCTYPE[\s\S]*?<body[^>]*>/i', '', $markup, 1 );
		$body_end = strripos( $markup, '</body>' );
		if ( false !== $body_end ) {
			$markup = substr( $markup, 0, $body_end );
		}
	}

	$page_start = devotel_find_snapshot_content_start( $markup );
	if ( false !== $page_start && $page_start > 0 ) {
		$markup = substr( $markup, $page_start );
	} else {
		$markup = preg_replace( '/<div[^>]*\bclass="header-navbar-wrapper"[\s\S]*?<\/header>/i', '', $markup, 1 );
	}

	if ( false !== stripos( $markup, 'header-navbar-wrapper' ) || false !== stripos( $markup, '<footer id="site-footer"' ) ) {
		$footer_pos = devotel_find_snapshot_content_end( $markup, 0 );
		if ( false !== $footer_pos && $footer_pos > 0 ) {
			$markup = substr( $markup, 0, $footer_pos );
		}
	}

	return trim( (string) $markup );
}

/**
 * Get cached HTML snapshot for a relative URI path.
 *
 * @param string $uri_path Relative URI path under /conversion.
 * @return string
 */
/**
 * Find byte offset after a balanced <div> … </div> block.
 *
 * @param string $html       HTML string.
 * @param int    $start_pos  Position of opening <div>.
 * @return int|false End offset after closing tag, or false.
 */
function devotel_find_balanced_div_end( $html, $start_pos ) {
	$html      = (string) $html;
	$start_pos = (int) $start_pos;
	$length    = strlen( $html );
	$depth     = 0;
	$offset    = $start_pos;

	while ( $offset < $length ) {
		if ( ! preg_match( '/<\/?div\b/i', $html, $match, PREG_OFFSET_CAPTURE, $offset ) ) {
			return false;
		}

		$tag    = $match[0][0];
		$offset = (int) $match[0][1];

		if ( str_starts_with( strtolower( $tag ), '</div' ) ) {
			$depth--;
			if ( 0 === $depth ) {
				$gt_pos = strpos( $html, '>', $offset );
				if ( false === $gt_pos ) {
					return false;
				}

				return $gt_pos + 1;
			}
		} else {
			$depth++;
		}

		$offset += strlen( $tag );
	}

	return false;
}

/**
 * Repair extracted About markup: desktop feature section + careers bleed.
 *
 * @param string $markup Concatenated about widget HTML.
 * @return string
 */
function devotel_repair_about_us_extracted_markup( $markup ) {
	if ( '' === trim( $markup ) ) {
		return $markup;
	}

	if ( ! str_contains( $markup, 'devotel-feature-boxes' ) ) {
		return $markup;
	}

	// Note: 438df3a is the divider wrapper between Careers and Security — do not strip it.

	if ( ! str_contains( $markup, 'elementor-element-55a4bdf' ) ) {
		$needle = '<div class="devotel-feature-boxes">';
		$pos    = strpos( $markup, $needle );

		if ( false !== $pos ) {
			$start = $pos;
			$style = strrpos( substr( $markup, 0, $pos ), '<style>' );
			if ( false !== $style ) {
				$start = (int) $style;
				$script = strrpos( substr( $markup, 0, $start ), '<script src="https://cdn.tailwindcss.com">' );
				if ( false !== $script ) {
					$start = (int) $script;
				}
			}

			$end = devotel_find_balanced_div_end( $markup, $pos );
			if ( false !== $end ) {
				$segment = substr( $markup, $start, $end - $start );
				$rest    = substr( $markup, $end );

				// Trim stray closing tags left by the broken extract before the mobile block.
				$rest = preg_replace(
					'/^(?:\s*<\/div>){1,4}(?=\s*<div class="elementor-element elementor-element-ef476df\b)/',
					'',
					$rest
				) ?? $rest;

				$intro = '<div class="elementor-element elementor-element-55a4bdf elementor-hidden-tablet elementor-hidden-mobile e-flex e-con-boxed e-con e-parent" data-id="55a4bdf" data-element_type="container">'
					. '<div class="e-con-inner">'
					. '<div class="elementor-element elementor-element-507a273 e-con-full e-flex e-con e-child" data-id="507a273">'
					. '<div class="elementor-element elementor-element-7c81d02 elementor-widget elementor-widget-heading" data-id="7c81d02">'
					. '<h2 class="elementor-heading-title elementor-size-default">WHAT SETS DEVOTEL APART</h2></div>'
					. '<div class="elementor-element elementor-element-cafa195 elementor-widget elementor-widget-heading" data-id="cafa195">'
					. '<h3 class="elementor-heading-title elementor-size-default">We&#8217;re Not Just Another Communications Platform</h3></div>'
					. '<div class="elementor-element elementor-element-f06bcbb elementor-widget elementor-widget-text-editor" data-id="f06bcbb">'
					. '<p><span style="font-weight: 400;">We&#8217;re built into the telecom backbone, combining carrier-grade expertise with end-to-end solutions and a developer experience that actually makes sense.</span></p>'
					. '</div></div>'
					. '<div class="elementor-element elementor-element-34e9566 e-con-full e-flex e-con e-child" data-id="34e9566">'
					. '<div class="elementor-element elementor-element-79d494a elementor-widget elementor-widget-html" data-id="79d494a">'
					. $segment
					. '</div></div></div></div>';

				$markup = substr( $markup, 0, $start ) . $intro . $rest;
			}
		}
	}

	return $markup;
}

/**
 * Wrap About hero title block + image row for controlled mobile blue background.
 *
 * @param string $markup Snapshot main content HTML.
 * @return string
 */
function devotel_wrap_about_us_hero_band( $markup ) {
	if ( str_contains( $markup, 'devotel-about-hero-blue' ) ) {
		return $markup;
	}

	if ( str_contains( $markup, 'devotel-about-hero-band' ) ) {
		$injected = preg_replace(
			'/(<div class="devotel-about-hero-band">)/',
			'<div class="devotel-about-hero-band"><div class="devotel-about-hero-blue" aria-hidden="true"></div>',
			$markup,
			1,
			$blue_inserted
		);

		return $blue_inserted ? $injected : $markup;
	}

	$wrapped = preg_replace(
		'/(<div class="elementor-element elementor-element-7ee2817\b)/',
		'<div class="devotel-about-hero-band"><div class="devotel-about-hero-blue" aria-hidden="true"></div><div class="elementor-element elementor-element-7ee2817',
		$markup,
		1,
		$opened
	);

	if ( ! $opened ) {
		return $markup;
	}

	$closed = preg_replace(
		'/(<div class="elementor-element elementor-element-42a5b1c\b[^>]*>\s*<div class="elementor-element elementor-element-cb4f458\b[^>]*>[\s\S]*?<\/div>\s*<\/div>)(\s*<div class="elementor-element elementor-element-2c18098\b)/',
		'$1</div>$2',
		$wrapped,
		1,
		$count_close
	);

	return $count_close ? $closed : $markup;
}

function devotel_get_cached_snapshot_markup( $uri_path = '' ) {
	$uri_path = trim( (string) $uri_path, '/' );
	if ( str_contains( $uri_path, '..' ) ) {
		return '';
	}

	$theme_snapshot_base = get_template_directory() . '/snapshots';
	$theme_snapshot_file = '' === $uri_path
		? $theme_snapshot_base . '/index.html'
		: $theme_snapshot_base . '/' . $uri_path . '/index.html';

	if ( file_exists( $theme_snapshot_file ) ) {
		$html = (string) file_get_contents( $theme_snapshot_file );
	} else {
		$file = devotel_get_wpo_cache_snapshot_file( $uri_path );
		if ( '' === $file ) {
			return '';
		}

		$html = (string) file_get_contents( $file );
	}
	if ( '' === trim( $html ) ) {
		return '';
	}

	if ( '' === $uri_path ) {
		$html = devotel_trim_home_snapshot_bleed( $html );
	} elseif ( 'products' === $uri_path || str_starts_with( $uri_path, 'products/' ) ) {
		$html = devotel_trim_products_snapshot_bleed( $html );
	}

	$main = '';
	if ( preg_match( '/<main[^>]*>([\s\S]*?)<\/main>/i', $html, $matches ) ) {
		$main = (string) $matches[1];
	}

	if ( '' === trim( $main ) ) {
		$content_start = devotel_find_snapshot_content_start( $html, $uri_path );

		if ( false !== $content_start ) {
			if ( 'products' === $uri_path || str_starts_with( $uri_path, 'products/' ) ) {
				$content_end = devotel_find_products_snapshot_content_end( $html );
			} else {
				$content_end = devotel_find_snapshot_content_end( $html, $content_start );
			}

			if ( false !== $content_end && $content_end > $content_start ) {
				$main = substr( $html, $content_start, $content_end - $content_start );
			}
		}
	}

	if ( '' === trim( $main ) ) {
		$main = $html;
	}

	$main = devotel_strip_embedded_chrome_markup( $main );

	$main = devotel_rewrite_legacy_site_urls( $main );

	$main = devotel_safe_preg_replace( '/<div id="wpadminbar"[\s\S]*?<\/div>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<style id="admin-bar-inline-css"[\s\S]*?<\/style>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<\/?(?:html|head|body)[^>]*>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<title[\s\S]*?<\/title>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<meta[^>]*>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<link[^>]*>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<script[^>]*src="[^"]*wp-includes\/js\/jquery[^"]*"[^>]*><\/script>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<script[^>]*src="[^"]*\/wp-admin\/[^"]*"[^>]*><\/script>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<script[^>]*src="[^"]*\/plugins\/elementor[^"]*"[^>]*><\/script>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<link[^>]*href="[^"]*\/plugins\/elementor[^"]*"[^>]*>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<script[^>]*src="[^"]*\/uploads\/elementor\/[^"]*"[^>]*><\/script>/i', '', $main );
	$main = devotel_safe_preg_replace( '/<link[^>]*href="[^"]*\/uploads\/elementor\/[^"]*"[^>]*>/i', '', $main );
	$main = devotel_strip_elementor_config_scripts( $main );
	if ( function_exists( 'devotel_strip_snapshot_legacy_header_scroll_script' ) ) {
		$main = devotel_strip_snapshot_legacy_header_scroll_script( $main );
	}
	$main = devotel_safe_preg_replace( '/<div[^>]*\bclass="header-navbar-wrapper"[\s\S]*?<\/header>/i', '', $main, 1 );

	$footer_markers = array(
		'<footer id="site-footer"',
		'<div id="devotel-footer-wrapper"',
		'<footer data-elementor-type="footer"',
	);
	foreach ( $footer_markers as $footer_marker ) {
		$footer_pos = strripos( $main, $footer_marker );
		if ( false !== $footer_pos ) {
			$main = substr( $main, 0, $footer_pos );
			break;
		}
	}

	$last_main_close = strripos( $main, '</main>' );
	if ( false !== $last_main_close ) {
		$main = substr( $main, 0, $last_main_close );
	}
	$main = devotel_safe_preg_replace( '/<section class="devotel-cached-snapshot"[^>]*>/i', '', $main );
	$main = str_replace( '</section></section>', '</section>', $main );

	if ( 'products' === $uri_path || str_starts_with( $uri_path, 'products/' ) ) {
		$main = devotel_safe_preg_replace( '/<article[^>]*\bclass="[^"]*devotel-page[^"]*"[^>]*>\s*/i', '', $main );
		$main = devotel_safe_preg_replace( '/\s*<\/article>\s*$/i', '', $main );
	}

	if ( 'about-us' === $uri_path || str_ends_with( $uri_path, '/about-us' ) ) {
		// Strip document closers embedded in HTML widgets (do not mutate div structure).
		$main = preg_replace( '/<\/body>\s*<\/html>/i', '', $main ) ?? $main;
		$main = str_replace(
			'</br>',
			'<span class="team-row-break" aria-hidden="true"></span>',
			$main
		);
		$main = devotel_repair_about_us_extracted_markup( $main );
		$main = devotel_wrap_about_us_hero_band( $main );
		$main = str_replace(
			'that powers global connectivity.',
			'that powers global<br> connectivity.',
			$main
		);
	}

	// ACF text overrides for recovered homepage sections.
	if ( function_exists( 'get_field' ) && is_front_page() ) {
		$replace_map = array(
			'Connect with Every Customer and Optimise Every Network' => (string) get_field( 'devotel_home_connect_title' ),
			'Our comprehensive suite powers millions of connections monthly. From messaging and eSIM connectivity to network protection, Devotel gives enterprises and telcos everything they need to thrive globally.' => (string) get_field( 'devotel_home_connect_text' ),
			'Our blog' => (string) get_field( 'devotel_home_blog_kicker' ),
			'Insights from the Telecom Industry' => (string) get_field( 'devotel_home_blog_title' ),
			'Stay informed with expert analysis, industry trends, and technical guides.' => (string) get_field( 'devotel_home_blog_text' ),
			'Contact us' => (string) get_field( 'devotel_home_contact_kicker' ),
			'Let’s discuss your project' => (string) get_field( 'devotel_home_contact_title' ),
			'Discover how our SMS API can enhance your messaging strategy in a 15-minute conversation with one of our experts. No commitments, just insights.' => (string) get_field( 'devotel_home_contact_text' ),
		);

		foreach ( $replace_map as $search => $replacement ) {
			if ( '' !== trim( $replacement ) ) {
				$main = str_replace( $search, esc_html( $replacement ), $main );
			}
		}
	}

	if ( function_exists( 'get_field' ) && function_exists( 'have_rows' ) && function_exists( 'is_singular' ) && is_singular( 'page' ) ) {
		$page_id = function_exists( 'get_queried_object_id' ) ? (int) get_queried_object_id() : 0;
		if ( $page_id > 0 && (bool) get_field( 'devotel_enable_route_overrides', $page_id ) ) {
			if ( have_rows( 'devotel_route_text_replacements', $page_id ) ) {
				while ( have_rows( 'devotel_route_text_replacements', $page_id ) ) {
					the_row();
					$find_text    = (string) get_sub_field( 'find_text' );
					$replace_text = (string) get_sub_field( 'replace_text' );
					if ( '' !== trim( $find_text ) ) {
						$main = str_replace( $find_text, $replace_text, $main );
					}
				}
			}

			if ( have_rows( 'devotel_route_url_replacements', $page_id ) ) {
				while ( have_rows( 'devotel_route_url_replacements', $page_id ) ) {
					the_row();
					$find_url    = trim( (string) get_sub_field( 'find_url' ) );
					$replace_url = trim( (string) get_sub_field( 'replace_url' ) );
					if ( '' !== $find_url && '' !== $replace_url ) {
						$main = str_replace( $find_url, esc_url( $replace_url ), $main );
					}
				}
			}
		}
	}

	if ( '' === $uri_path ) {
		$main = devotel_patch_home_hero_section( $main );
		$main = devotel_patch_home_product_use_cases_section( $main );
		$main = devotel_patch_home_globe_section( $main );
	}

	$main = devotel_patch_social_proof_section( $main );

	if ( 'products' === $uri_path ) {
		$main = devotel_patch_products_snapshot_markup( $main );
	} elseif ( devotel_is_product_subpage_uri_path( $uri_path ) ) {
		$main = devotel_patch_product_subpage_snapshot_markup( $main );
	} elseif ( 'contact-us' === $uri_path ) {
		$main = devotel_patch_contact_us_snapshot_markup( $main );
	} elseif ( function_exists( 'devotel_patch_inner_page_snapshot_markup' ) ) {
		$main = devotel_patch_inner_page_snapshot_markup( $main, $uri_path );
	}

	$main = devotel_fix_smush_duplicate_src_markup( $main );
	$main = devotel_patch_snapshot_inline_form_scripts( $main );
	if ( 'contact-us' !== $uri_path && function_exists( 'devotel_patch_form_card_padding_markup' ) ) {
		$main = devotel_patch_form_card_padding_markup( $main );
	}
	if ( function_exists( 'devotel_strip_snapshot_legacy_mobile_menu_script' ) ) {
		$main = devotel_strip_snapshot_legacy_mobile_menu_script( $main );
	}
	if ( function_exists( 'devotel_strip_embedded_legacy_mobile_menu_styles' ) ) {
		$main = devotel_strip_embedded_legacy_mobile_menu_styles( $main );
	}
	$main = devotel_strip_embedded_tailwind_scripts( $main );
	$main = devotel_strip_embedded_google_fonts( $main );

	return trim( (string) $main );
}

/**
 * Render cached snapshot fallback for a post.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function devotel_render_cached_snapshot_for_post( $post_id ) {
	$uri_path = devotel_get_cached_uri_path_for_post( $post_id );
	$markup   = devotel_get_cached_snapshot_markup( $uri_path );

	if ( '' === $markup ) {
		return false;
	}

	echo '<section class="devotel-cached-snapshot" data-source="wpo-cache">';
	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';

	return true;
}

/**
 * Resolve current request path relative to site home path.
 *
 * @return string
 */
function devotel_get_current_request_cache_path() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( '' === $request_uri ) {
		return '';
	}

	$request_path = (string) parse_url( $request_uri, PHP_URL_PATH );
	$home_path    = (string) parse_url( home_url( '/' ), PHP_URL_PATH );

	$request_path = trim( $request_path, '/' );
	$home_path    = trim( $home_path, '/' );

	if ( '' !== $home_path && str_starts_with( $request_path, $home_path ) ) {
		$request_path = ltrim( substr( $request_path, strlen( $home_path ) ), '/' );
	}

	return trim( $request_path, '/' );
}

/**
 * Render cached snapshot fallback for current request URI.
 *
 * @return bool
 */
function devotel_render_cached_snapshot_for_request() {
	$uri_path = devotel_get_current_request_cache_path();
	$markup   = devotel_get_cached_snapshot_markup( $uri_path );

	if ( '' === $markup ) {
		return false;
	}

	echo '<section class="devotel-cached-snapshot" data-source="wpo-cache-request">';
	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '</section>';

	return true;
}

