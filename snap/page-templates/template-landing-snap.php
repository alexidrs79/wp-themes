<?php
/**
 * Template Name: Snap Landing
 *
 * Assembles the Snap marketing landing page from template-parts, in order.
 * No content logic lives here — each part pulls its own ACF fields.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/trust' );
get_template_part( 'template-parts/problem-section' );
get_template_part( 'template-parts/meet-snap' );
get_template_part( 'template-parts/more-than-ocr' );
get_template_part( 'template-parts/built-for-uk' );
get_template_part( 'template-parts/how-snap-works' );
get_template_part( 'template-parts/real-usecases' );
get_template_part( 'template-parts/cta-demo-form' );

get_footer();
