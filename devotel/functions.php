<?php
/**
 * Theme bootstrap.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$devotel_includes = array(
	'/inc/blog.php',
	'/inc/performance.php',
	'/inc/css-bundle.php',
	'/inc/setup.php',
	'/inc/theme-options.php',
	'/inc/enqueue.php',
	'/inc/extracted.php',
	'/inc/dynamic-sections.php',
	'/inc/page-render.php',
	'/inc/inner-page-layout.php',
	'/inc/acf.php',
	'/inc/gutenberg.php',
);

foreach ( $devotel_includes as $devotel_file ) {
	$devotel_path = get_template_directory() . $devotel_file;
	if ( file_exists( $devotel_path ) ) {
		require_once $devotel_path;
	}
}

