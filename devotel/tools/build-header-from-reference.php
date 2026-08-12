<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Rebuild header assets from Desktop/header.html reference.
 *
 * Usage: php tools/build-header-from-reference.php
 *
 * Reference structure (header.html):
 * - CSS: lines 10-3606 (inside <style>)
 * - Markup: 3608-4397 (navbar) + 4549-5144 (mobile menu overlay, after desktop script)
 * - Desktop JS: 4399-4547 (inside first <script>)
 * - Mobile JS: 5146-5384 (inside second <script>)
 * - Pink-button override: 5387-5403 → header.css
 * - DO NOT port: 5405+ (checkHomePage, updateLogo, updateHeaderScrolled)
 *
 * @package Devotel
 */

$reference = '/Users/alexidermo/Desktop/header.html';
$theme     = dirname( __DIR__ );

if ( ! is_readable( $reference ) ) {
	fwrite( STDERR, "Reference not found: {$reference}\n" );
	exit( 1 );
}

$lines = file( $reference, FILE_IGNORE_NEW_LINES );
if ( ! is_array( $lines ) ) {
	fwrite( STDERR, "Failed to read reference file.\n" );
	exit( 1 );
}

$total = count( $lines );

/**
 * Extract inner JS from a <script>…</script> line range (1-based inclusive).
 *
 * @param array<int, string> $lines   All reference lines.
 * @param int                $start   1-based start line.
 * @param int                $end     1-based end line.
 * @return string
 */
function devotel_extract_script_body( array $lines, $start, $end ) {
	$chunk  = array_slice( $lines, $start - 1, $end - $start + 1 );
	$body   = implode( "\n", $chunk );
	$body   = preg_replace( '/^\s*<script[^>]*>\s*/i', '', $body );
	$body   = preg_replace( '/\s*<\/script>\s*$/i', '', $body );

	return trim( (string) $body );
}

// CSS: lines 10-3606.
$css_lines = array_slice( $lines, 9, 3597 );

// Markup: navbar + mobile overlay (not the interleaved desktop script block).
$markup_lines = array_merge(
	array_slice( $lines, 3607, 790 ),  // 3608-4397
	array_slice( $lines, 4548, 596 )   // 4549-5144
);

$css_path = $theme . '/assets/css/pages/header.css';
$js_path  = $theme . '/assets/js/header.js';
$php_path = $theme . '/template-parts/extracted/header/site-header-html.php';

if ( ! is_dir( dirname( $css_path ) ) ) {
	mkdir( dirname( $css_path ), 0755, true );
}

// Pink-button override from reference lines 5387-5403 → append to CSS.
$pink_chunk = implode( "\n", array_slice( $lines, 5386, 17 ) );
$pink_css   = '';
if ( preg_match( '/style\.textContent\s*=\s*`([\s\S]*?)`;/', $pink_chunk, $pink_match ) ) {
	$pink_css = trim( (string) $pink_match[1] );
}

file_put_contents( $css_path, implode( "\n", $css_lines ) . "\n\n/* Mobile login button — prevent #cc3366 bleed */\n" . $pink_css );

$markup = implode( "\n", $markup_lines );
$markup = preg_replace( '/\sdata-srcset="([^"]*)"/i', ' srcset="$1"', $markup );
$markup = preg_replace( '/\sdata-src="([^"]*)"/i', ' src="$1"', $markup );
$markup = preg_replace( '/\sclass="header-logo-svg lazyload"/i', ' class="header-logo-svg"', $markup );
$markup = preg_replace( '/\sstyle="[^"]*smush[^"]*"/i', '', $markup );

$php = "<?php\n/**\n * Header markup from reference header.html\n *\n * @package Devotel\n */\nif ( ! defined( 'ABSPATH' ) ) {\n\texit;\n}\n?>\n" . $markup . "\n";

file_put_contents( $php_path, $php );

$desktop_js = devotel_extract_script_body( $lines, 4398, 4548 );
$mobile_js  = devotel_extract_script_body( $lines, 5145, 5384 );

$raw_js = $desktop_js . "\n\n" . $mobile_js;

// Fix mobile menu scroll lock — overflow only, never body position fixed.
$raw_js = preg_replace(
	'/function lockBodyScroll\(\)\s*\{[\s\S]*?document\.body\.style\.width\s*=\s*[\'"]100%[\'"];\s*\}/',
	"function lockBodyScroll() {\n\t\t\t\tscrollPosition = window.pageYOffset || document.documentElement.scrollTop;\n\t\t\t\tdocument.documentElement.style.overflow = 'hidden';\n\t\t\t\tdocument.body.style.overflow = 'hidden';\n\t\t\t}",
	$raw_js
);
$raw_js = preg_replace(
	'/function unlockBodyScroll\(\)\s*\{[\s\S]*?window\.scrollTo\(0,\s*scrollPosition\);\s*\}/',
	"function unlockBodyScroll() {\n\t\t\t\tdocument.documentElement.style.overflow = '';\n\t\t\t\tdocument.body.style.overflow = '';\n\t\t\t\tdocument.body.style.position = '';\n\t\t\t\tdocument.body.style.top = '';\n\t\t\t\tdocument.body.style.width = '';\n\t\t\t\tif ( scrollPosition ) {\n\t\t\t\t\twindow.scrollTo(0, scrollPosition);\n\t\t\t\t}\n\t\t\t}",
	$raw_js
);

// Strip pink override IIFE (merged into header.css) and homepage/logo/scroll tail if present.
$raw_js = preg_replace(
	'/\/\/ Additional global override[\s\S]*?document\.head\.appendChild\(style\);\s*\}\)\(\);\s*/',
	'',
	$raw_js,
	1
);
$raw_js = preg_replace(
	'/\/\/ Detect home page[\s\S]*$/',
	'',
	$raw_js
);

$js = "/**\n * Header interactions from reference header.html (mega menu + mobile menu).\n */\n(function () {\n\t'use strict';\n\n\tdocument.addEventListener('DOMContentLoaded', function () {\n" . $raw_js . "\n\t});\n})();\n";

file_put_contents( $js_path, $js );

echo "Built header assets from {$reference}\n";
echo "  CSS:    {$css_path} (" . count( $css_lines ) . " lines)\n";
echo "  Markup: {$php_path} (" . count( $markup_lines ) . " lines)\n";
echo "  JS:     {$js_path}\n";
echo "  Reference total lines: {$total}\n";
