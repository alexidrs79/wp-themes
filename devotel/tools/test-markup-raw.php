<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Test extracted markup without WordPress.
 */
define( 'ABSPATH', __DIR__ );
define( 'WPINC', 'wp-includes' );

function wp_strip_all_tags( $str ) {
	return strip_tags( $str );
}
function trailingslashit( $str ) {
	return rtrim( $str, '/\\' ) . '/';
}
function untrailingslashit( $str ) {
	return rtrim( $str, '/\\' );
}
function get_template_directory() {
	return dirname( __DIR__ );
}
function home_url( $path = '' ) {
	return 'http://devotel.local' . $path;
}
function wp_parse_url( $url, $component = -1 ) {
	return parse_url( $url, $component );
}
define( 'WP_CONTENT_DIR', dirname( dirname( dirname( __DIR__ ) ) ) );

$theme = dirname( __DIR__ );
require $theme . '/inc/extracted.php';

foreach ( array( 'about', 'contact' ) as $dir ) {
	$markup = devotel_get_extracted_directory_markup( $dir );
	$len    = strlen( $markup );
	$sub    = devotel_markup_is_substantial( $markup );
	echo "$dir: len=$len substantial=" . ( $sub ? 'yes' : 'no' ) . "\n";
	if ( 'about' === $dir ) {
		echo '  7ee2817: ' . ( strpos( $markup, '7ee2817' ) !== false ? 'yes' : 'no' ) . "\n";
	}
	if ( 'contact' === $dir ) {
		echo '  9e6c16f: ' . ( strpos( $markup, '9e6c16f' ) !== false ? 'yes' : 'no' ) . "\n";
	}
}
