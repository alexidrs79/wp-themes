<?php
/**
 * ACF integration.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Point ACF JSON to theme folder.
 *
 * @param array<int, string> $paths Paths.
 * @return array<int, string>
 */
function devotel_acf_json_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'devotel_acf_json_load_point' );

/**
 * Save ACF JSON to theme folder.
 *
 * @param string $path Default path.
 * @return string
 */
function devotel_acf_json_save_point( $path ) {
	return get_template_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'devotel_acf_json_save_point' );

/**
 * Register options page.
 */
function devotel_register_acf_options() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Devotel Theme Settings', 'devotel' ),
			'menu_title' => __( 'Theme Settings', 'devotel' ),
			'menu_slug'  => 'devotel-theme-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'devotel_register_acf_options' );

