<?php
/**
 * Theme setup.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register supports and menus.
 */
function devotel_setup() {
	load_theme_textdomain( 'devotel', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'devotel' ),
			'footer'  => __( 'Footer Menu', 'devotel' ),
		)
	);
}
add_action( 'after_setup_theme', 'devotel_setup' );

/**
 * Add homepage class expected by extracted styles.
 *
 * @param array<int, string> $classes Existing body classes.
 * @return array<int, string>
 */
function devotel_body_classes( $classes ) {
	if ( is_front_page() ) {
		$classes[] = 'is-home-page';
		$classes[] = 'devotel-home-page';
		$classes[] = 'devotel-home-solutions-hero';
		$classes[] = 'elementor-page-1027';
		$classes[] = 'elementor-kit-6';
	} else {
		$classes[] = 'devotel-inner-page';
	}

	if ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) {
		$classes[] = 'devotel-blog-page';
		$classes[] = 'elementor-page-872';
		$classes[] = 'elementor-kit-6';
	}

	if ( is_singular( 'post' ) ) {
		$classes[] = 'devotel-blog-single-page';
		$classes[] = 'elementor-page-' . ( function_exists( 'devotel_get_blog_single_template_id' ) ? devotel_get_blog_single_template_id() : 908 );
		$classes[] = 'elementor-kit-6';
	}

	if ( is_404() ) {
		$classes[] = 'devotel-404-page';
		$classes[] = 'elementor-kit-6';
	}

	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post ) {
			$slug = (string) $post->post_name;
			if ( ! is_front_page() ) {
				$classes[] = 'elementor-kit-6';
			}
			if ( 'about-us' === $slug ) {
				$classes[] = 'elementor-page-12';
				$classes[] = 'devotel-about-page';
			} elseif ( 'contact-us' === $slug ) {
				$classes[] = 'elementor-page-21';
				$classes[] = 'devotel-contact-page';
			} elseif ( 'brand-kit' === $slug ) {
				$classes[] = 'elementor-page-9513';
				$classes[] = 'devotel-brand-kit-page';
			} elseif ( 'privacy-policy' === $slug ) {
				$classes[] = 'elementor-page-3';
				$classes[] = 'devotel-privacy-page';
			} elseif ( 'products' === $slug ) {
				$classes[] = 'elementor-page-495';
				$classes[] = 'devotel-products-page';
			}

			$page_uri = function_exists( 'get_page_uri' ) ? trim( (string) get_page_uri( $post->ID ), '/' ) : '';
			if ( devotel_is_product_subpage_uri_path( $page_uri ) ) {
				$classes[] = 'devotel-product-subpage';
				$classes[] = 'elementor-page-' . (int) $post->ID;
				if ( str_starts_with( $page_uri, 'products/communication-apis/' ) ) {
					$classes[] = 'devotel-communication-apis-page';
				} elseif ( str_starts_with( $page_uri, 'products/platforms/' ) ) {
					$classes[] = 'devotel-platforms-page';
				} elseif ( str_starts_with( $page_uri, 'products/telco/' ) ) {
					$classes[] = 'devotel-telco-page';
				} elseif ( str_starts_with( $page_uri, 'products/sim-based/' ) ) {
					$classes[] = 'devotel-sim-based-page';
				}
			}
		}
	}

	return $classes;
}
add_filter( 'body_class', 'devotel_body_classes' );

