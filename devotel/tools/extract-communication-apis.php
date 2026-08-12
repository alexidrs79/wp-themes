<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Extract Communication APIs subpages from production HTML.
 *
 * Usage: php tools/extract-communication-apis.php
 *
 * @package Devotel
 */

$theme = dirname( __DIR__ );

$pages = array(
	'sms'                => array(
		'url'     => 'https://devotel.com/products/communication-apis/sms/',
		'post_id' => 2002,
	),
	'rcs'                => array(
		'url'     => 'https://devotel.com/products/communication-apis/rcs/',
		'post_id' => 2326,
	),
	'email'              => array(
		'url'     => 'https://devotel.com/products/communication-apis/email/',
		'post_id' => 2276,
	),
	'whatsapp-business'  => array(
		'url'     => 'https://devotel.com/products/communication-apis/whatsapp-business/',
		'post_id' => 2342,
	),
);

/**
 * Balance-close a div opened at $open_pos.
 *
 * @param string $html HTML string.
 * @param int    $open_pos Position of opening tag.
 * @return string
 */
function comm_api_extract_balanced_div( $html, $open_pos ) {
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
function comm_api_extract_wp_page_markup( $html ) {
	$marker = 'data-elementor-type="wp-page"';
	$pos    = strpos( $html, $marker );
	if ( false === $pos ) {
		return '';
	}

	$open_pos = strripos( substr( $html, 0, $pos ), '<div' );
	if ( false === $open_pos ) {
		return '';
	}

	return comm_api_extract_balanced_div( $html, $open_pos );
}

/**
 * Clean extracted widget markup.
 *
 * @param string $html Raw extracted HTML.
 * @return string
 */
function comm_api_clean_markup( $html ) {
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

	return trim( (string) $html );
}

/**
 * Write extracted widget PHP file.
 *
 * @param string $path Destination path.
 * @param string $slug Slug for comment.
 * @param string $html HTML content.
 */
function comm_api_write_widget( $path, $slug, $html ) {
	$dir = dirname( $path );
	if ( ! is_dir( $dir ) ) {
		mkdir( $dir, 0755, true );
	}

	$php = "<?php\n/** products/communication-apis/{$slug} extracted from production */\nif (!defined('ABSPATH')) exit;\n?>\n" . trim( $html ) . "\n";
	file_put_contents( $path, $php );
	echo 'Wrote widget ' . $path . ' (' . strlen( $html ) . " bytes)\n";
}

foreach ( $pages as $slug => $meta ) {
	$html = file_get_contents( $meta['url'] );
	if ( ! $html ) {
		fwrite( STDERR, "Failed to fetch {$meta['url']}\n" );
		continue;
	}

	$page_markup = comm_api_extract_wp_page_markup( $html );
	if ( '' === $page_markup ) {
		fwrite( STDERR, "No wp-page markup for {$slug}\n" );
		continue;
	}

	$page_markup = comm_api_clean_markup( $page_markup );

	$widget_path = $theme . '/template-parts/extracted/products/communication-apis/' . $slug . '/section-main.php';
	comm_api_write_widget( $widget_path, $slug, $page_markup );

	$snapshot_dir = $theme . '/snapshots/products/communication-apis/' . $slug;
	if ( ! is_dir( $snapshot_dir ) ) {
		mkdir( $snapshot_dir, 0755, true );
	}

	// Store production HTML snapshot for fallback/debug parity checks.
	file_put_contents( $snapshot_dir . '/index.html', $html );
	echo 'Wrote snapshot ' . $snapshot_dir . '/index.html (' . strlen( $html ) . " bytes)\n";
}

echo "Done.\n";
