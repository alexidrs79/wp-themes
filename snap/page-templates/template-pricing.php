<?php
/**
 * Template Name: Pricing
 *
 * Assembles the Pricing page. Reuses the site-wide header/footer exactly
 * as the Snap Landing and Contact templates do.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/pricing' );

get_footer();
