<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Rebuild contact hero widget without nested HTML documents.
 * Run: php tools/clean-contact-hero.php
 */

$theme = dirname( __DIR__ );
$path  = $theme . '/template-parts/extracted/contact/widget-contact-hero.php';
$raw   = file_get_contents( $path );

if ( ! preg_match( '/^<\?php[\s\S]*?\?>\s*/', $raw, $php_match ) ) {
	fwrite( STDERR, "missing php header\n" );
	exit( 1 );
}
$php_header = $php_match[0];

$first_doc = stripos( $raw, '<!DOCTYPE' );
if ( false === $first_doc ) {
	echo "no DOCTYPE found — already clean?\n";
	exit( 0 );
}

$prefix = substr( $raw, 0, $first_doc );

// First embedded document: style + form + script.
$doc1 = substr( $raw, $first_doc );
$doc1_end = stripos( $doc1, '</html>' );
if ( false === $doc1_end ) {
	fwrite( STDERR, "first </html> not found\n" );
	exit( 1 );
}
$doc1 = substr( $doc1, 0, $doc1_end + 7 );

preg_match( '/<style[^>]*>([\s\S]*?)<\/style>/i', $doc1, $style_match );
preg_match( '/<script[^>]*>([\s\S]*?)<\/script>/i', $doc1, $script_match );
preg_match( '/<div class="wpcf7 no-js"[\s\S]*?<\/form>/i', $doc1, $form_match );

if ( empty( $style_match[0] ) || empty( $script_match[0] ) || empty( $form_match[0] ) ) {
	fwrite( STDERR, "could not extract style/script/form from desktop block\n" );
	exit( 1 );
}

$desktop_form = $style_match[0] . "\n" . $form_match[0] . "\n" . $script_match[0];

$desktop = $prefix . $desktop_form . "\n				</div>\n					</div>\n				</div>\n				</div>\n";

// Mobile block: from bcde5de through file end, strip nested documents.
$mobile_start = stripos( $raw, 'elementor-element-bcde5de' );
$mobile       = substr( $raw, $mobile_start );

$clean_mobile = preg_replace( '/<!DOCTYPE[\s\S]*?<body[^>]*>/i', '', $mobile );
$clean_mobile = preg_replace( '/<\/body>\s*<\/html>/i', '', $clean_mobile );
$clean_mobile = preg_replace( '/<head\b[^>]*>[\s\S]*?<\/head>/i', '', $clean_mobile );
$clean_mobile = preg_replace( '/<\/?html[^>]*>/i', '', $clean_mobile );
$clean_mobile = preg_replace( '/<title[^>]*>[\s\S]*?<\/title>/i', '', $clean_mobile );
$clean_mobile = preg_replace( '/<meta[^>]*>/i', '', $clean_mobile );
$clean_mobile = preg_replace( '/<link[^>]*>/i', '', $clean_mobile );

// Drop duplicate form CSS blocks (keep first style only).
$marker = '/* Contact Form CSS Styles - Scoped to prevent conflicts */';
while ( false !== ( $second = stripos( $clean_mobile, $marker, stripos( $clean_mobile, $marker ) + 1 ) ) ) {
	$style_start = strripos( substr( $clean_mobile, 0, $second ), '<style' );
	$style_end   = stripos( $clean_mobile, '</style>', $second );
	if ( false === $style_start || false === $style_end ) {
		break;
	}
	$clean_mobile = substr( $clean_mobile, 0, $style_start ) . substr( $clean_mobile, $style_end + 8 );
}

// Drop duplicate bootFinalCtaFormWrappers scripts (keep first).
$script_marker = 'function bootFinalCtaFormWrappers';
$first_script    = stripos( $clean_mobile, $script_marker );
if ( false !== $first_script ) {
	$second_script = stripos( $clean_mobile, $script_marker, $first_script + 20 );
	while ( false !== $second_script ) {
		$script_start = strripos( substr( $clean_mobile, 0, $second_script ), '<script' );
		$script_end   = stripos( $clean_mobile, '</script>', $second_script );
		if ( false === $script_start || false === $script_end ) {
			break;
		}
		$clean_mobile = substr( $clean_mobile, 0, $script_start ) . substr( $clean_mobile, $script_end + 9 );
		$second_script = stripos( $clean_mobile, $script_marker, $first_script + 20 );
	}
}

$out = $php_header . $desktop . $clean_mobile;
file_put_contents( $path, $out );

echo 'wrote ' . strlen( $out ) . " bytes (was " . strlen( $raw ) . ")\n";
echo "body tags remaining: " . substr_count( strtolower( $out ), '<body' ) . "\n";
echo "doctype remaining: " . substr_count( strtolower( $out ), '<!doctype' ) . "\n";
