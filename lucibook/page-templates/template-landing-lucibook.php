<?php
/**
 * Template Name: Lucibook Landing
 *
 * Assembles the Lucibook marketing landing page from template-parts, in
 * order. No content logic lives here — each part pulls its own ACF
 * fields. Figma: node 15532:79 ("Lucibook — Final Landing Page").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/social-proof' );
get_template_part( 'template-parts/reconciliation' );
get_template_part( 'template-parts/luci-ai' );
get_template_part( 'template-parts/connected-workspace' );
get_template_part( 'template-parts/pricing' );
get_template_part( 'template-parts/founding-offer' );

get_footer();
