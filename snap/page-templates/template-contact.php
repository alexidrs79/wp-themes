<?php
/**
 * Template Name: Contact
 *
 * Assembles the Contact page. Reuses the site-wide header/footer exactly
 * as the Snap Landing template does — no separate header/footer markup
 * lives here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/contact' );

get_footer();
