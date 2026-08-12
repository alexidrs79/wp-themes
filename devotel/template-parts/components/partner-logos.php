<?php
/**
 * Partner logos section — markup from boxes.html (canonical design).
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$markup_path = get_template_directory() . '/template-parts/components/partner-logos-markup.html';
if ( ! is_readable( $markup_path ) ) {
	return;
}

$markup  = (string) file_get_contents( $markup_path );
$uploads = trailingslashit( wp_upload_dir()['baseurl'] );

$markup = str_replace( 'https://devotel.com/wp-content/uploads/', $uploads, $markup );

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static HTML widget; image URLs rewritten above.
echo $markup;
