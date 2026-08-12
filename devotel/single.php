<?php
/**
 * Single post template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	devotel_render_blog_single( get_the_ID() );
endwhile;

get_footer();
