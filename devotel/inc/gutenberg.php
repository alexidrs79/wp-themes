<?php
/**
 * Gutenberg integration.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom block pattern category.
 *
 * @return void
 */
function devotel_register_pattern_category() {
	if ( function_exists( 'register_block_pattern_category' ) ) {
		register_block_pattern_category(
			'devotel',
			array(
				'label' => __( 'Devotel Sections', 'devotel' ),
			)
		);
	}
}
add_action( 'init', 'devotel_register_pattern_category' );

/**
 * Register pattern files from theme.
 *
 * @return void
 */
function devotel_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	$patterns = array(
		'homepage-cta' => array(
			'title'       => __( 'Homepage CTA', 'devotel' ),
			'description' => __( 'Reusable CTA section aligned with Devotel design language.', 'devotel' ),
			'file'        => get_template_directory() . '/patterns/homepage-cta.php',
		),
		'faq-section'  => array(
			'title'       => __( 'FAQ Section', 'devotel' ),
			'description' => __( 'A two-column FAQ section for content teams.', 'devotel' ),
			'file'        => get_template_directory() . '/patterns/faq-section.php',
		),
	);

	foreach ( $patterns as $slug => $pattern ) {
		if ( ! file_exists( $pattern['file'] ) ) {
			continue;
		}

		register_block_pattern(
			'devotel/' . $slug,
			array(
				'title'       => $pattern['title'],
				'description' => $pattern['description'],
				'categories'  => array( 'devotel' ),
				'content'     => file_get_contents( $pattern['file'] ),
			)
		);
	}
}
add_action( 'init', 'devotel_register_patterns' );

