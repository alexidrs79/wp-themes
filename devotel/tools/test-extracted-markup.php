<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * CLI test for extracted markup (loads WordPress if available).
 */
define( 'ABSPATH', dirname( __DIR__, 4 ) . '/' );
$_SERVER['HTTP_HOST']   = 'localhost';
$_SERVER['REQUEST_URI'] = '/conversion/about-us/';

require ABSPATH . 'wp-load.php';

if ( ! function_exists( 'devotel_get_extracted_directory_markup' ) ) {
	fwrite( STDERR, "Theme functions missing\n" );
	exit( 1 );
}

foreach ( array( 'about', 'contact' ) as $dir ) {
	$markup = devotel_get_extracted_directory_markup( $dir );
	$sub    = devotel_markup_is_substantial( $markup );
	$usable = devotel_extracted_directory_is_usable( $dir );
	echo "$dir: len=" . strlen( $markup ) . " substantial=" . ( $sub ? 'yes' : 'no' ) . " usable=" . ( $usable ? 'yes' : 'no' ) . "\n";
	if ( 'about' === $dir ) {
		echo "  has 7ee2817: " . ( strpos( $markup, '7ee2817' ) !== false ? 'yes' : 'no' ) . "\n";
	}
	if ( 'contact' === $dir ) {
		echo "  has 9e6c16f: " . ( strpos( $markup, '9e6c16f' ) !== false ? 'yes' : 'no' ) . "\n";
		echo "  wpcf7 count: " . substr_count( $markup, 'class="wpcf7' ) . "\n";
	}
}

$about_id = get_page_by_path( 'about-us' );
if ( $about_id ) {
	echo "about-us dynamic builder: " . ( devotel_use_dynamic_builder( $about_id->ID ) ? 'ON' : 'off' ) . "\n";
	echo "resolved dir: " . devotel_resolve_extracted_directory_for_post( $about_id->ID ) . "\n";
}
