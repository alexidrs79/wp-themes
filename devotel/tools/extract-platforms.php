<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Extract Platforms subpages from production HTML.
 *
 * Usage: php tools/extract-platforms.php
 *
 * @package Devotel
 */

$theme = dirname( __DIR__ );

$pages = array(
	'orbit' => array(
		'url'     => 'https://devotel.com/products/platforms/orbit/',
		'post_id' => 2363,
	),
	'cmp'   => array(
		'url'     => 'https://devotel.com/products/platforms/cmp/',
		'post_id' => 2051,
	),
);

/**
 * Balance-close a div opened at $open_pos.
 *
 * @param string $html HTML string.
 * @param int    $open_pos Position of opening tag.
 * @return string
 */
function platform_extract_balanced_div( $html, $open_pos ) {
	$depth = 0;
	$len   = strlen( $html );
	$i     = $open_pos;

	while ( $i < $len ) {
		if ( '<div' === substr( $html, $i, 4 ) ) {
			++$depth;
			$i += 4;
			continue;
		}
		if ( '</div>' === substr( $html, $i, 6 ) ) {
			--$depth;
			$i += 6;
			if ( 0 === $depth ) {
				return substr( $html, $open_pos, $i - $open_pos );
			}
			continue;
		}
		++$i;
	}

	return '';
}

/**
 * Extract elementor wp-page root from full HTML.
 *
 * @param string $html Full page HTML.
 * @return string
 */
function platform_extract_wp_page_markup( $html ) {
	$marker = 'data-elementor-type="wp-page"';
	$pos    = strpos( $html, $marker );
	if ( false === $pos ) {
		return '';
	}

	$open_pos = strripos( substr( $html, 0, $pos ), '<div' );
	if ( false === $open_pos ) {
		return '';
	}

	return platform_extract_balanced_div( $html, $open_pos );
}

/**
 * Clean extracted widget markup.
 *
 * @param string $html Raw extracted HTML.
 * @return string
 */
function platform_clean_markup( $html ) {
	$html = (string) $html;

	// Strip document wrappers only — keep <style> blocks inside <head>.
	$html = preg_replace( '/<!DOCTYPE[^>]*>/i', '', $html );
	$html = preg_replace( '/<\/?html[^>]*>/i', '', $html );
	$html = preg_replace( '/<\/?head[^>]*>/i', '', $html );
	$html = preg_replace( '/<\/?body[^>]*>/i', '', $html );
	$html = preg_replace( '/<title[^>]*>[\s\S]*?<\/title>/i', '', $html );
	$html = preg_replace( '/<meta[^>]*>/i', '', $html );
	$html = preg_replace( '/<link[^>]*fonts\.googleapis\.com[^>]*>/i', '', $html );
	$html = preg_replace( '/<script[^>]*src=["\']https?:\/\/cdn\.tailwindcss\.com[^"\']*["\'][^>]*>\s*<\/script>/i', '', $html );
	$html = preg_replace(
		'/(<img\b[^>]*\bsrc="(?!data:image\/svg\+xml)[^"]+")(?:\s[^>]*)?\s+src="data:image\/svg\+xml[^"]*"\s*style="--smush-placeholder-[^"]*"/i',
		'$1',
		$html
	);
	$html = preg_replace(
		'/(<img\b[^>]*\bsrc="(?!data:image\/svg\+xml)[^"]+")[^>]*\s+src="data:image\/svg\+xml[^"]*"/i',
		'$1',
		$html
	);
	$html = preg_replace( '/\ssrc="data:image\/svg\+xml[^"]*"\s*style="--smush-placeholder-[^"]*"/i', '', $html );
	$html = preg_replace( '/\sdata-srcset="([^"]*)"/i', ' srcset="$1"', $html );
	$html = preg_replace( '/\sdata-src="([^"]*)"/i', ' src="$1"', $html );
	$html = preg_replace( '/\slazyload\b/i', '', $html );
	$html = preg_replace( '/\slazyloading\b/i', '', $html );
	$html = preg_replace( '/\slazyloaded\b/i', '', $html );
	$html = preg_replace( '/\s+elementor-invisible\b/i', '', $html );
	$html = preg_replace( '/\s+animate-(?:fade|scale|slide)-[a-z0-9-]+/i', '', $html );
	$html = preg_replace( '/\sstyle="animation-delay:[^"]*;?\s*animation-fill-mode:\s*both;?"/i', '', $html );

	// Scope final CTA mobile gradient to the CTA section only (not page wrapper).
	$html = preg_replace(
		'/(\/\* Section - mobile: adjust padding and height \*\/\s*)section\s*\{/',
		'$1section.bg-gradient-to-r {',
		$html
	);

	// Constrain testimonial carousel logos.
	$html = preg_replace(
		'/(<div class="ts-image-frame">\s*<img)(?![^>]*\bclass=)/i',
		'$1 class="ts-company-logo"',
		$html
	);
	$html = preg_replace(
		'/(<div class="ts-image-frame">\s*<img\b[^>]*\bclass=")([^"]*)(")/i',
		'$1$2 ts-company-logo$3',
		$html
	);
	$html = preg_replace( '/\bclass="([^"]*)\s+ts-company-logo\s+ts-company-logo([^"]*)"/i', 'class="$1 ts-company-logo$2"', $html );

	// Hero/final CTA buttons — use max-width arrow reveal so label does not collapse.
	$html = preg_replace(
		'/\.btn-icon-arrow\s*\{[^}]*width:\s*0[^}]*\}/i',
		'.btn-icon-arrow { height: 20px; width: 20px !important; max-width: 0; opacity: 0; flex-shrink: 0; transform: none; transition: max-width 0.3s ease, opacity 0.3s ease; overflow: hidden; }',
		$html
	);
	$html = preg_replace(
		'/\.btn-primary:hover\s+\.btn-icon-arrow,\s*\.btn-secondary:hover\s+\.btn-icon-arrow\s*\{[^}]*width:\s*20px[^}]*\}/i',
		'.btn-primary:hover .btn-icon-arrow, .btn-secondary:hover .btn-icon-arrow { max-width: 20px !important; width: 20px !important; opacity: 1; transform: none; }',
		$html
	);
	$html = preg_replace(
		'/\.btn-secondary\s*\{([^}]*?)width:\s*180px([^}]*)\}/i',
		'.btn-secondary {$1width: auto; min-width: 200px$2}',
		$html
	);

	return trim( (string) $html );
}

/**
 * Write extracted widget PHP file.
 *
 * @param string $path Destination path.
 * @param string $slug Slug for comment.
 * @param string $html HTML content.
 */
/**
 * Rewrite production URLs to local dev in legacy CSS.
 *
 * @param string $css CSS content.
 * @return string
 */
function platform_rewrite_legacy_css_urls( $css ) {
	$css = (string) $css;

	return str_replace(
		array(
			'https://devotel.com/',
			'http://devotel.com/',
		),
		'http://devotel.local/',
		$css
	);
}

/**
 * Resolve Elementor post CSS URL from page HTML or default uploads path.
 *
 * @param string $html    Full page HTML.
 * @param int    $post_id Elementor post ID.
 * @return string
 */
function platform_resolve_legacy_css_url( $html, $post_id ) {
	$post_id = (int) $post_id;
	$pattern = '/href=["\']([^"\']*\/uploads\/elementor\/css\/post-' . $post_id . '\.css(?:\?[^"\']*)?)["\']/i';

	if ( preg_match( $pattern, (string) $html, $matches ) ) {
		$url = html_entity_decode( (string) $matches[1], ENT_QUOTES );
		if ( str_starts_with( $url, '//' ) ) {
			return 'https:' . $url;
		}
		if ( str_starts_with( $url, '/' ) ) {
			return 'https://devotel.com' . $url;
		}
		return $url;
	}

	return 'https://devotel.com/wp-content/uploads/elementor/css/post-' . $post_id . '.css';
}

/**
 * Download legacy Elementor CSS for a platform page.
 *
 * @param string $theme   Theme directory.
 * @param string $html    Full page HTML (for link discovery).
 * @param int    $post_id Elementor post ID.
 * @return bool
 */
function platform_download_legacy_css( $theme, $html, $post_id ) {
	$post_id  = (int) $post_id;
	$css_url  = platform_resolve_legacy_css_url( $html, $post_id );
	$css      = file_get_contents( $css_url );
	$css_dir  = $theme . '/assets/css/legacy';
	$css_path = $css_dir . '/post-' . $post_id . '.css';

	if ( ! $css ) {
		fwrite( STDERR, "Failed to fetch legacy CSS {$css_url}\n" );
		return false;
	}

	if ( ! is_dir( $css_dir ) ) {
		mkdir( $css_dir, 0755, true );
	}

	$css = platform_rewrite_legacy_css_urls( $css );
	file_put_contents( $css_path, $css );
	echo 'Wrote legacy CSS ' . $css_path . ' (' . strlen( $css ) . " bytes) from {$css_url}\n";

	return true;
}

function platform_write_widget( $path, $slug, $html ) {
	$dir = dirname( $path );
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0755, true );
	}

	$php = "<?php\n/** products/platforms/{$slug} extracted from production */\nif (!defined('ABSPATH')) exit;\n?>\n" . trim( $html ) . "\n";
	file_put_contents( $path, $php );
	echo 'Wrote widget ' . $path . ' (' . strlen( $html ) . " bytes)\n";
}

foreach ( $pages as $slug => $meta ) {
	$html = file_get_contents( $meta['url'] );
	if ( ! $html ) {
		fwrite( STDERR, "Failed to fetch {$meta['url']}\n" );
		continue;
	}

	$page_markup = platform_extract_wp_page_markup( $html );
	if ( '' === $page_markup ) {
		fwrite( STDERR, "No wp-page markup for {$slug}\n" );
		continue;
	}

	$page_markup = platform_clean_markup( $page_markup );

	$widget_path = $theme . '/template-parts/extracted/products/platforms/' . $slug . '/section-main.php';
	platform_write_widget( $widget_path, $slug, $page_markup );

	$snapshot_dir = $theme . '/snapshots/products/platforms/' . $slug;
	if ( ! is_dir( $snapshot_dir ) ) {
		mkdir( $snapshot_dir, 0755, true );
	}

	file_put_contents( $snapshot_dir . '/index.html', $html );
	echo 'Wrote snapshot ' . $snapshot_dir . '/index.html (' . strlen( $html ) . " bytes)\n";

	platform_download_legacy_css( $theme, $html, (int) $meta['post_id'] );
}

echo "Done.\n";
