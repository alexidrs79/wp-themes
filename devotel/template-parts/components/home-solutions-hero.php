<?php
/**
 * Homepage solutions hero — markup from boxes.html.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$markup_path = get_template_directory() . '/template-parts/components/home-solutions-hero-markup.html';
if ( ! is_readable( $markup_path ) ) {
	return;
}

$markup  = (string) file_get_contents( $markup_path );
$uploads = trailingslashit( wp_upload_dir()['baseurl'] );

$markup = str_replace( 'https://devotel.com/wp-content/uploads/', $uploads, $markup );
$markup = str_replace( 'https://devotel.com/contact-us/', home_url( '/contact-us/' ), $markup );

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static HTML widget; URLs rewritten above.
echo $markup;
