<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Materialize OTA section-main.php as static HTML from WPO cache (optional).
 *
 * Usage: php tools/extract-sim-ota-section.php
 *
 * @package Devotel
 */

$theme_dir = dirname( __DIR__ );
$wp_root   = dirname( dirname( dirname( $theme_dir ) ) );

require_once $wp_root . '/wp-load.php';

$html = devotel_get_product_subpage_snapshot_source_html( 'products/sim-based/ota' );
if ( '' === $html ) {
	fwrite( STDERR, "No OTA cache snapshot found.\n" );
	exit( 1 );
}

$markup = devotel_slice_product_subpage_snapshot_html( $html, 7796 );
if ( '' === trim( $markup ) ) {
	fwrite( STDERR, "Could not slice OTA markup.\n" );
	exit( 1 );
}

$target_dir = $theme_dir . '/template-parts/extracted/products/sim-based/ota';
if ( ! is_dir( $target_dir ) ) {
	mkdir( $target_dir, 0755, true );
}

$target_file = $target_dir . '/section-main.php';
$php         = "<?php\n/** products/sim-based/ota extracted from WPO cache / production */\nif (!defined('ABSPATH')) exit;\n?>\n" . $markup . "\n";

file_put_contents( $target_file, $php );

fwrite( STDERR, "Wrote " . strlen( $php ) . " bytes to {$target_file}\n" );
