<?php
/**
 * Page content rendering helpers (no Elementor runtime).
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether an extracted directory only contains placeholder/stub widgets.
 *
 * @param string $directory Relative path under template-parts/extracted.
 * @return bool
 */
function devotel_is_extracted_stub_directory( $directory ) {
	$directory = trim( (string) $directory, '/' );
	if ( '' === $directory ) {
		return true;
	}

	$markup = devotel_get_extracted_directory_markup( $directory );

	return ! devotel_markup_is_substantial( $markup );
}

/**
 * Check whether extracted directory exists and has real content.
 *
 * @param string $directory Relative path under template-parts/extracted.
 * @return bool
 */
function devotel_extracted_directory_is_usable( $directory ) {
	$directory = trim( (string) $directory, '/' );
	if ( '' === $directory || ! devotel_extracted_directory_exists( $directory ) ) {
		return false;
	}

	return ! devotel_is_extracted_stub_directory( $directory );
}

/**
 * Map request URI paths to Elementor post CSS bundles shipped in the theme.
 *
 * @param string $uri_path Relative URI path.
 * @return array<int, int>
 */
function devotel_get_legacy_elementor_ids_for_uri_path( $uri_path ) {
	$uri_path = trim( (string) $uri_path, '/' );

	$map = array(
		'about-us'                                        => array( 12 ),
		'contact-us'                                      => array( 21 ),
		'products'                                        => array( 495 ),
		'products/communication-apis'                     => array( 495 ),
		'products/communication-apis/sms'                 => array( 2002 ),
		'products/communication-apis/rcs'                 => array( 2326 ),
		'products/communication-apis/email'               => array( 2276 ),
		'products/communication-apis/whatsapp-business'   => array( 2342 ),
		'products/platforms'                              => array( 495 ),
		'products/platforms/orbit'                        => array( 2363 ),
		'products/platforms/cmp'                          => array( 2051 ),
		'products/telco'                                  => array( 495 ),
		'products/telco/sms-solutions-for-telco'        => array( 2427 ),
		'products/telco/sms-firewall'                     => array( 2406 ),
		'products/telco/sms-monetisation'                 => array( 2418 ),
		'products/telco/voice-solutions'                  => array( 2452 ),
		'products/telco/voice-firewall'                     => array( 2433 ),
		'products/telco/voice-monetisation'               => array( 2446 ),
		'products/sim-based'                              => array( 495 ),
		'products/sim-based/ota'                          => array( 7796 ),
		'products/sim-based/coverage-monitoring-platform' => array( 8835 ),
		'products/sim-based/communication-platform'       => array( 8717 ),
		'products/sim-based/otp'                          => array( 8645 ),
		'blog'                                            => array( 872 ),
		'privacy-policy'                                  => array( 3 ),
		'brand-kit'                                       => array( 9513 ),
	);

	if ( isset( $map[ $uri_path ] ) ) {
		return $map[ $uri_path ];
	}

	$best_match = '';
	foreach ( array_keys( $map ) as $candidate ) {
		if ( '' === $candidate ) {
			continue;
		}
		if ( str_starts_with( $uri_path, $candidate ) && strlen( $candidate ) > strlen( $best_match ) ) {
			$best_match = $candidate;
		}
	}

	if ( '' !== $best_match ) {
		return $map[ $best_match ];
	}

	return array();
}

/**
 * Enqueue legacy Elementor CSS for the current route when available.
 */
function devotel_enqueue_route_legacy_assets() {
	if ( is_admin() ) {
		return;
	}

	$uri_path = devotel_get_current_request_cache_path();
	if ( is_singular( 'page' ) ) {
		$post_path = devotel_get_cached_uri_path_for_post( (int) get_queried_object_id() );
		if ( '' !== $post_path ) {
			$uri_path = $post_path;
		}
	}

	if ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) {
		$uri_path = 'blog';
	}

	$legacy_ids = array();
	if ( is_singular( 'post' ) ) {
		$single_id  = function_exists( 'devotel_get_blog_single_template_id' ) ? devotel_get_blog_single_template_id() : 908;
		$legacy_ids = array( $single_id, 880 );
	} else {
		$legacy_ids = devotel_get_legacy_elementor_ids_for_uri_path( $uri_path );
		if ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) {
			$legacy_ids = array_values( array_unique( array_merge( $legacy_ids, array( 880 ) ) ) );
		}
	}
	foreach ( $legacy_ids as $legacy_id ) {
		$legacy_id = (int) $legacy_id;
		if ( $legacy_id <= 0 ) {
			continue;
		}

		$theme_legacy = get_template_directory() . '/assets/css/legacy/post-' . $legacy_id . '.css';
		if ( function_exists( 'devotel_enqueue_sanitized_legacy_post_css' ) ) {
			devotel_enqueue_sanitized_legacy_post_css(
				$legacy_id,
				'devotel-route-legacy',
				array( 'devotel-main' )
			);
		} elseif ( file_exists( $theme_legacy ) ) {
			wp_enqueue_style(
				'devotel-route-legacy-post-' . $legacy_id,
				get_template_directory_uri() . '/assets/css/legacy/post-' . $legacy_id . '.css',
				array( 'devotel-main' ),
				filemtime( $theme_legacy )
			);
		} else {
			$upload_legacy = WP_CONTENT_DIR . '/uploads/elementor/css/post-' . $legacy_id . '.css';
			if ( file_exists( $upload_legacy ) ) {
				wp_enqueue_style(
					'devotel-route-upload-legacy-post-' . $legacy_id,
					content_url( 'uploads/elementor/css/post-' . $legacy_id . '.css' ),
					array( 'devotel-main' ),
					filemtime( $upload_legacy )
				);
			}
		}
	}

	$pages_css_dir = get_template_directory() . '/assets/css/pages';
	$route_page_css = array(
		'about-us'        => 'about.css',
		'contact-us'      => 'contact.css',
		'privacy-policy'  => 'privacy.css',
		'products'        => 'products.css',
	);

	$subpage_css = '';
	if ( devotel_is_product_subpage_uri_path( $uri_path ) ) {
		$subpage_css = 'product-subpage.css';
		if ( str_starts_with( $uri_path, 'products/communication-apis/' ) ) {
			$subpage_css = 'communication-apis.css';
		} elseif ( str_starts_with( $uri_path, 'products/platforms/' ) ) {
			$subpage_css = 'platforms.css';
		} elseif ( str_starts_with( $uri_path, 'products/telco/' ) ) {
			$subpage_css = 'telco.css';
		} elseif ( str_starts_with( $uri_path, 'products/sim-based/' ) ) {
			$subpage_css = 'sim-based.css';
		}
	}

	if ( '' !== $subpage_css ) {
		$shared_css = $pages_css_dir . '/shared.css';
		if ( file_exists( $shared_css ) ) {
			wp_enqueue_style(
				'devotel-pages-shared',
				get_template_directory_uri() . '/assets/css/pages/shared.css',
				array( 'devotel-main' ),
				filemtime( $shared_css )
			);
		}

		$base_subpage_css = $pages_css_dir . '/product-subpage.css';
		$page_style_deps  = array( 'devotel-main' );
		if ( file_exists( $shared_css ) ) {
			$page_style_deps[] = 'devotel-pages-shared';
		}
		if ( wp_style_is( 'devotel-elementor-compat-frontend-min-css-css', 'registered' ) ) {
			$page_style_deps[] = 'devotel-elementor-compat-frontend-min-css-css';
		}
		foreach ( devotel_get_legacy_elementor_ids_for_uri_path( $uri_path ) as $legacy_id ) {
			$legacy_id = (int) $legacy_id;
			if ( $legacy_id <= 0 ) {
				continue;
			}
			if ( wp_style_is( 'devotel-route-legacy-post-' . $legacy_id, 'registered' ) ) {
				$page_style_deps[] = 'devotel-route-legacy-post-' . $legacy_id;
			} elseif ( wp_style_is( 'devotel-legacy-post-' . $legacy_id, 'registered' ) ) {
				$page_style_deps[] = 'devotel-legacy-post-' . $legacy_id;
			}
		}
		if ( file_exists( $base_subpage_css ) ) {
			wp_enqueue_style(
				'devotel-page-product-subpage-base',
				get_template_directory_uri() . '/assets/css/pages/product-subpage.css',
				$page_style_deps,
				filemtime( $base_subpage_css )
			);
			$page_style_deps = array( 'devotel-page-product-subpage-base' );

			$testimonials_css = get_template_directory() . '/assets/css/components/product-testimonials.css';
			if ( file_exists( $testimonials_css ) ) {
				wp_enqueue_style(
					'devotel-product-testimonials',
					get_template_directory_uri() . '/assets/css/components/product-testimonials.css',
					array( 'devotel-page-product-subpage-base' ),
					filemtime( $testimonials_css )
				);
			}
		}

	$page_css = $pages_css_dir . '/' . $subpage_css;
		if ( file_exists( $page_css ) ) {
			$page_handle = 'devotel-page-product-subpage';
			wp_register_style( $page_handle, false, $page_style_deps, filemtime( $page_css ) );
			wp_enqueue_style( $page_handle );
			$page_css_contents = devotel_sanitize_extracted_asset_urls( (string) file_get_contents( $page_css ) );
			wp_add_inline_style( $page_handle, $page_css_contents );
			wp_add_inline_style( $page_handle, devotel_get_product_subpage_critical_css() );
		}

		$use_cases_tabs_css = get_template_directory() . '/assets/css/components/use-cases-tabs.css';
		if ( file_exists( $use_cases_tabs_css ) ) {
			wp_register_style(
				'devotel-use-cases-tabs',
				get_template_directory_uri() . '/assets/css/components/use-cases-tabs.css',
				array(),
				filemtime( $use_cases_tabs_css )
			);
		}

		if ( 'sim-based.css' === $subpage_css ) {
			$capabilities_css = get_template_directory() . '/assets/css/components/ctab-capabilities.css';
			if ( file_exists( $capabilities_css ) ) {
				wp_enqueue_style(
					'devotel-ctab-capabilities',
					get_template_directory_uri() . '/assets/css/components/ctab-capabilities.css',
					array( 'devotel-page-product-subpage' ),
					filemtime( $capabilities_css )
				);
			}

			$hi_js = get_template_directory() . '/assets/js/sim-based-how-it-works.js';
			if ( file_exists( $hi_js ) ) {
				wp_enqueue_script(
					'devotel-sim-based-how-it-works',
					get_template_directory_uri() . '/assets/js/sim-based-how-it-works.js',
					array( 'devotel-main' ),
					filemtime( $hi_js ),
					true
				);
			}
		}
	}

	if ( ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) || is_singular( 'post' ) ) {
		$blog_css = $pages_css_dir . '/blog.css';
		if ( file_exists( $blog_css ) ) {
			$blog_deps = array( 'devotel-main' );
			foreach ( $legacy_ids as $legacy_id ) {
				$legacy_id = (int) $legacy_id;
				if ( $legacy_id <= 0 ) {
					continue;
				}
				if ( wp_style_is( 'devotel-route-legacy-post-' . $legacy_id, 'registered' ) ) {
					$blog_deps[] = 'devotel-route-legacy-post-' . $legacy_id;
				}
			}

			$blog_compat_css = array();
			if ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) {
				$blog_compat_css = array(
					'widget-loop-grid.min.css',
					'widget-loop-common.min.css',
				);
			} elseif ( is_singular( 'post' ) ) {
				$blog_compat_css = array(
					'widget-loop-grid.min.css',
					'widget-loop-common.min.css',
				);
			}

			foreach ( $blog_compat_css as $compat_file ) {
				$compat_path = get_template_directory() . '/assets/css/elementor-compat/' . $compat_file;
				if ( ! file_exists( $compat_path ) ) {
					continue;
				}
				$compat_handle = 'devotel-blog-compat-' . sanitize_title( $compat_file );
				wp_enqueue_style(
					$compat_handle,
					get_template_directory_uri() . '/assets/css/elementor-compat/' . $compat_file,
					array( 'devotel-main' ),
					filemtime( $compat_path )
				);
				$blog_deps[] = $compat_handle;
			}

			wp_enqueue_style(
				'devotel-page-blog',
				get_template_directory_uri() . '/assets/css/pages/blog.css',
				$blog_deps,
				filemtime( $blog_css )
			);

			if ( ( function_exists( 'devotel_is_blog_listing' ) && devotel_is_blog_listing() ) || is_singular( 'post' ) ) {
				$cta_css = get_template_directory() . '/assets/css/components/cta.css';
				if ( file_exists( $cta_css ) ) {
					wp_enqueue_style(
						'devotel-site-cta',
						get_template_directory_uri() . '/assets/css/components/cta.css',
						array( 'devotel-page-blog' ),
						filemtime( $cta_css )
					);
				}
			}
		}
	}

	if ( isset( $route_page_css[ $uri_path ] ) ) {
		$shared_css = $pages_css_dir . '/shared.css';
		if ( file_exists( $shared_css ) ) {
			wp_enqueue_style(
				'devotel-pages-shared',
				get_template_directory_uri() . '/assets/css/pages/shared.css',
				array( 'devotel-main' ),
				filemtime( $shared_css )
			);
		}

		if ( 'contact-us' === $uri_path ) {
			devotel_enqueue_theme_legacy_stylesheet( 'widget-social-icons.min.css' );
		}
		if ( 'about-us' === $uri_path ) {
			devotel_enqueue_theme_legacy_stylesheet( 'widget-counter.min.css' );
		}

		$page_css = $pages_css_dir . '/' . $route_page_css[ $uri_path ];
		if ( file_exists( $page_css ) ) {
			$page_style_deps = array( 'devotel-main' );
			if ( file_exists( $shared_css ) ) {
				$page_style_deps[] = 'devotel-pages-shared';
			}
			if ( 'contact-us' === $uri_path ) {
				$page_style_deps[] = 'devotel-legacy-widget-social-icons-min-css';
			}
			if ( 'about-us' === $uri_path ) {
				$page_style_deps[] = 'devotel-legacy-widget-counter-min-css';
				if ( wp_style_is( 'devotel-route-legacy-post-12', 'registered' ) ) {
					$page_style_deps[] = 'devotel-route-legacy-post-12';
				}
				if ( wp_style_is( 'devotel-elementor-compat-frontend-min-css-css', 'registered' ) ) {
					$page_style_deps[] = 'devotel-elementor-compat-frontend-min-css-css';
				}
			}
			$page_style_handle = 'devotel-page-' . str_replace( '-', '_', $uri_path );
			wp_enqueue_style(
				$page_style_handle,
				get_template_directory_uri() . '/assets/css/pages/' . $route_page_css[ $uri_path ],
				$page_style_deps,
				filemtime( $page_css )
			);

			if ( 'contact-us' === $uri_path ) {
				$locations_css = get_template_directory() . '/assets/css/components/contact-locations.css';
				if ( file_exists( $locations_css ) ) {
					wp_enqueue_style(
						'devotel-contact-locations',
						get_template_directory_uri() . '/assets/css/components/contact-locations.css',
						array( $page_style_handle ),
						filemtime( $locations_css )
					);
				}
			}

			if ( 'products' === $uri_path ) {
				$products_flow_css = 'body.devotel-products-page .d-devotel-products-all-products>.frame-2147227641,body.elementor-page-495 .d-devotel-products-all-products>.frame-2147227641{display:block!important;visibility:visible!important;opacity:1!important}';
				wp_add_inline_style( $page_style_handle, $products_flow_css );
			}

			if ( 'about-us' === $uri_path ) {
				$about_style_handle = 'devotel-page-about_us';
				$about_mobile_gutter = 'body.devotel-about-page .elementor-element-be2c7de.e-con.e-parent,body.elementor-page-12 .elementor-element-be2c7de.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-ef476df.e-con.e-parent,body.elementor-page-12 .elementor-element-ef476df.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-1214f66.e-con.e-parent,body.elementor-page-12 .elementor-element-1214f66.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-2c18098.e-con.e-parent,body.elementor-page-12 .elementor-element-2c18098.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-d3bce70.e-con.e-parent,body.elementor-page-12 .elementor-element-d3bce70.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-f90e4f2.e-con.e-parent,body.elementor-page-12 .elementor-element-f90e4f2.e-con.e-parent,'
					. 'body.devotel-about-page .elementor-element-438df3a.e-con.e-parent,body.elementor-page-12 .elementor-element-438df3a.e-con.e-parent{'
					. '--container-default-padding-left:16px!important;--container-default-padding-right:16px!important;'
					. '--padding-left:16px!important;--padding-right:16px!important;'
					. '--padding-inline-start:16px!important;--padding-inline-end:16px!important;'
					. 'padding-inline:16px!important;padding-left:16px!important;padding-right:16px!important}';
				$about_flush_css    = 'body.devotel-about-page .e-con,body.elementor-page-12 .e-con,body.devotel-about-page .e-con.e-parent,body.elementor-page-12 .e-con.e-parent,body.devotel-about-page .e-con>.e-con-inner,body.elementor-page-12 .e-con>.e-con-inner{--container-default-padding-right:0px!important;--container-default-padding-left:0px!important;--padding-right:0px!important;--padding-left:0px!important;--padding-inline-start:0px!important;--padding-inline-end:0px!important;padding-left:0!important;padding-right:0!important;padding-inline:0!important}body.devotel-about-page article.devotel-page,body.elementor-page-12 article.devotel-page{padding-left:0!important;padding-right:0!important;max-width:100%!important}'
				. 'body.devotel-about-page .elementor-element-59be7c5.e-con.e-parent,body.elementor-page-12 .elementor-element-59be7c5.e-con.e-parent{--container-default-padding-left:100px!important;--container-default-padding-right:100px!important;--padding-left:100px!important;--padding-right:100px!important;--padding-inline-start:100px!important;--padding-inline-end:100px!important;padding-inline:100px!important;padding-left:100px!important;padding-right:100px!important}'
				. '@media (max-width:767px){body.devotel-about-page .elementor-element-59be7c5.e-con.e-parent,body.elementor-page-12 .elementor-element-59be7c5.e-con.e-parent{--container-default-padding-left:16px!important;--container-default-padding-right:16px!important;--padding-left:16px!important;--padding-right:16px!important;--padding-inline-start:16px!important;--padding-inline-end:16px!important;padding-inline:16px!important;padding-left:16px!important;padding-right:16px!important}'
				. $about_mobile_gutter
				. '}'
				. '@media (min-width:1025px){body.devotel-about-page .elementor-element-55a4bdf.e-con.e-parent,body.elementor-page-12 .elementor-element-55a4bdf.e-con.e-parent{--container-default-padding-left:100px!important;--container-default-padding-right:100px!important;--padding-left:100px!important;--padding-right:100px!important;--padding-inline-start:100px!important;--padding-inline-end:100px!important;padding-top:120px!important;padding-bottom:120px!important;padding-inline:100px!important;padding-left:100px!important;padding-right:100px!important}body.devotel-about-page .elementor-element-55a4bdf.e-con.e-parent>.e-con-inner,body.elementor-page-12 .elementor-element-55a4bdf.e-con.e-parent>.e-con-inner{padding-top:0!important;padding-bottom:0!important;padding-inline:0!important;padding-left:0!important;padding-right:0!important}}';
				wp_add_inline_style( $about_style_handle, $about_flush_css );
			}
		}

	}
}

/**
 * Late products layout overrides (after widget inline styles are not enqueued — belt-and-suspenders).
 */
function devotel_enqueue_products_layout_overrides() {
	if ( ! is_page( 'products' ) ) {
		return;
	}

	if ( ! wp_style_is( 'devotel-page-products', 'enqueued' ) ) {
		return;
	}

	$late_css = '.devotel-cached-snapshot .d-devotel-products-all-products{display:flex!important;flex-direction:column!important;height:auto!important}'
		. '.devotel-cached-snapshot .d-devotel-products-all-products>.frame-2147227641,.devotel-cached-snapshot .d-devotel-products-all-products>.cta-main-dark{position:relative!important;top:auto!important;left:auto!important;translate:none!important}';
	wp_add_inline_style( 'devotel-page-products', $late_css );
}
add_action( 'wp_enqueue_scripts', 'devotel_enqueue_products_layout_overrides', 100 );

/**
 * Footer products layout fix — loads after widget inline <style> in the body.
 */
function devotel_print_products_layout_fix_footer() {
	if ( ! is_page( 'products' ) ) {
		return;
	}

	$css = devotel_get_products_layout_fix_css();
	if ( '' === $css && ! function_exists( 'devotel_get_products_critical_css' ) ) {
		return;
	}

	$footer_css = function_exists( 'devotel_get_products_critical_css' ) ? devotel_get_products_critical_css() : '';
	if ( function_exists( 'devotel_get_products_cta_button_css' ) ) {
		$footer_css .= devotel_get_products_cta_button_css();
	}
	if ( '' !== $css ) {
		$footer_css .= $css;
	}
	if ( '' === $footer_css ) {
		return;
	}

	echo '<style id="devotel-products-layout-fix-footer">' . $footer_css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_products_layout_fix_footer', 999 );

/**
 * Footer product subpage visibility fix — loads after inline widget styles.
 */
function devotel_print_product_subpage_fix_footer() {
	if ( ! is_singular( 'page' ) ) {
		return;
	}

	$uri_path = devotel_get_cached_uri_path_for_post( (int) get_queried_object_id() );
	if ( ! devotel_is_product_subpage_uri_path( $uri_path ) ) {
		return;
	}

	$css = devotel_get_product_subpage_critical_css();
	$css .= '@media (min-width:768px){'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot section[class*="bg-gradient-to-r"]:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback section[class*="bg-gradient-to-r"]:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot section.relative:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback section.relative:has(.cta-section-container){min-height:376px!important;background:linear-gradient(104.63deg,#1e318a 0%,#266df0 100%)!important;overflow:hidden!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .cta-section-container,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .cta-section-container{max-width:1440px!important;width:100%!important;min-height:376px!important;height:376px!important;margin:0 auto!important;position:relative!important;padding:0!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .video-wrapper,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .video-wrapper{position:absolute!important;inset:0!important;width:100%!important;height:100%!important;pointer-events:none!important;overflow:hidden!important;display:block!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .video-wrapper .video-gradient-container,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .video-wrapper .video-gradient-container{position:absolute!important;inset:0!important;width:100%!important;height:100%!important;background:transparent!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .video-wrapper .video-gradient-container video,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .video-wrapper .video-gradient-container video{position:absolute!important;width:100%!important;height:100%!important;object-fit:contain!important;object-position:right center!important;right:0!important;top:50%!important;transform:translate(-25%,-50%) scale(1.6)!important;mix-blend-mode:screen!important;display:block!important;max-height:none!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .content-wrapper,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .content-wrapper{position:absolute!important;top:50%!important;left:calc((100% - 1440px) / 2 + 80px)!important;transform:translateY(-50%)!important;width:576px!important;max-width:calc(100% - 160px)!important;z-index:10!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .content-wrapper > div,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .content-wrapper > div{display:flex!important;flex-direction:column!important;align-items:flex-start!important;gap:32px!important}'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot .content-wrapper h2,'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback .content-wrapper h2{font-family:Duplet,Inter,sans-serif!important;font-size:40px!important;font-weight:600!important;line-height:50px!important;letter-spacing:-0.8px!important;color:#fff!important;margin:0!important}'
		. '}';
	$css .= '@media (max-width:767px){'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot section[class*="bg-gradient-to-r"]:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback section[class*="bg-gradient-to-r"]:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-cached-snapshot section.relative:has(.cta-section-container),'
		. 'body.devotel-product-subpage:not(.devotel-platforms-page):not(.devotel-sim-based-page) .devotel-el-fallback section.relative:has(.cta-section-container){min-height:0!important;padding-bottom:24px!important;background:linear-gradient(164deg,#1e318a 22.26%,#266df0 79.12%)!important;overflow:hidden!important}'
		. '.devotel-cached-snapshot .video-wrapper-mobile,.devotel-el-fallback .video-wrapper-mobile{display:block!important;position:relative!important;width:100%!important;height:390px!important;min-height:390px!important;max-height:none!important;order:4!important;flex-shrink:0!important;pointer-events:none!important;overflow:visible!important;margin-bottom:0!important}'
		. '.devotel-cached-snapshot .video-wrapper-mobile .video-gradient-container,.devotel-el-fallback .video-wrapper-mobile .video-gradient-container{position:relative!important;inset:auto!important;width:100%!important;height:100%!important;min-height:0!important;max-height:none!important;background:transparent!important}'
		. '.devotel-cached-snapshot .video-wrapper-mobile .video-gradient-container video,.devotel-el-fallback .video-wrapper-mobile .video-gradient-container video{position:relative!important;width:100%!important;height:100%!important;min-height:0!important;max-height:none!important;object-fit:contain!important;object-position:center center!important;right:auto!important;top:auto!important;transform:none!important;mix-blend-mode:screen!important;background-color:transparent!important;display:block!important}'
		. '}';
	if ( '' === $css ) {
		return;
	}

	echo '<style id="devotel-product-subpage-fix-footer">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_product_subpage_fix_footer', 999 );

/**
 * Use Cases tabs — load after inline widget styles on product subpages.
 */
function devotel_print_use_cases_tabs_footer() {
	if ( ! is_singular( 'page' ) ) {
		return;
	}

	$uri_path = devotel_get_cached_uri_path_for_post( (int) get_queried_object_id() );
	if ( ! devotel_is_product_subpage_uri_path( $uri_path ) ) {
		return;
	}

	if ( ! wp_style_is( 'devotel-use-cases-tabs', 'registered' ) ) {
		return;
	}

	wp_enqueue_style( 'devotel-use-cases-tabs' );
	wp_print_styles( 'devotel-use-cases-tabs' );
}
add_action( 'wp_footer', 'devotel_print_use_cases_tabs_footer', 1000 );

/**
 * Render page content using extracted widgets, snapshots, then fallbacks.
 *
 * @param int $post_id Page post ID.
 * @return bool True when content was rendered.
 */
function devotel_render_page_content( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 ) {
		return false;
	}

	if ( devotel_use_dynamic_builder( $post_id ) && devotel_render_dynamic_sections( $post_id ) ) {
		return true;
	}

	if ( function_exists( 'have_rows' ) && have_rows( 'devotel_dynamic_sections', $post_id ) && devotel_render_dynamic_sections( $post_id ) ) {
		return true;
	}

	$resolved_extracted_dir = devotel_resolve_extracted_directory_for_post( $post_id );
	$page_slug              = get_post_field( 'post_name', $post_id );
	$snapshot_first_routes  = array( 'about-us', 'contact-us' );
	$is_snapshot_first      = in_array( (string) $page_slug, $snapshot_first_routes, true );

	// Products: extracted widget is more reliable than the corrupted WPO snapshot dump.
	if ( 'products' === (string) $page_slug && devotel_render_products_extracted_for_post( $post_id ) ) {
		return true;
	}

	// Product subpages (Communication APIs, Platforms, Telco children).
	if ( devotel_render_product_subpage_for_post( $post_id ) ) {
		return true;
	}

	// About/Contact: prefer fresh production snapshot for closest parity.
	if ( $is_snapshot_first && devotel_render_cached_snapshot_for_post( $post_id ) ) {
		return true;
	}

	if ( '' !== $resolved_extracted_dir ) {
		$extracted_markup = devotel_get_extracted_directory_markup( $resolved_extracted_dir );
		if ( devotel_markup_is_substantial( $extracted_markup ) ) {
			echo $extracted_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return true;
		}
	}

	if ( ! $is_snapshot_first && devotel_render_cached_snapshot_for_post( $post_id ) ) {
		return true;
	}

	if (
		! $is_snapshot_first
		&& devotel_render_cached_snapshot_for_request()
	) {
		return true;
	}

	if ( devotel_render_elementor_data_fallback( $post_id ) ) {
		return true;
	}

	return false;
}

/**
 * Render composed homepage sections when snapshot markup is unavailable.
 *
 * @return bool
 */
function devotel_render_home_section_fallback() {
	ob_start();
	?>
	<div class="devotel-home">
		<?php get_template_part( 'template-parts/sections/home', 'hero' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'social-proof' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'products-tabs' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'features' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'testimonials' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'integrations' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'blog-insights' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'contact-cta' ); ?>
		<?php get_template_part( 'template-parts/sections/home', 'final-cta' ); ?>
	</div>
	<?php
	$markup = (string) ob_get_clean();

	if ( ! devotel_markup_is_substantial( $markup ) ) {
		return false;
	}

	echo $markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	return true;
}

/**
 * Render native Gutenberg/ACF fallback content for a page.
 *
 * @param int $post_id Page post ID.
 * @return void
 */
function devotel_render_page_native_fallback( $post_id ) {
	$post_id = (int) $post_id;
	?>
	<header class="entry-header devotel-entry-header">
		<h1 class="entry-title"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>
	</header>
	<div class="entry-content">
		<?php
		$content = get_post_field( 'post_content', $post_id );
		if ( is_string( $content ) && '' !== trim( $content ) ) {
			echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		?>
	</div>
	<?php
	if ( function_exists( 'have_rows' ) && have_rows( 'devotel_page_sections', $post_id ) ) : ?>
		<div class="devotel-acf-sections">
			<?php
			while ( have_rows( 'devotel_page_sections', $post_id ) ) :
				the_row();
				$layout = get_row_layout();

				if ( 'wysiwyg_content' === $layout ) :
					?>
					<section class="devotel-acf-section devotel-acf-section--wysiwyg">
						<?php the_sub_field( 'content' ); ?>
					</section>
					<?php
				elseif ( 'cta_banner' === $layout ) :
					$cta_title       = (string) get_sub_field( 'title' );
					$cta_text        = (string) get_sub_field( 'text' );
					$cta_button_text = (string) get_sub_field( 'button_text' );
					$cta_button_url  = (string) get_sub_field( 'button_url' );
					?>
					<section class="devotel-acf-section devotel-acf-section--cta">
						<?php if ( $cta_title ) : ?>
							<h2><?php echo esc_html( $cta_title ); ?></h2>
						<?php endif; ?>
						<?php if ( $cta_text ) : ?>
							<p><?php echo esc_html( $cta_text ); ?></p>
						<?php endif; ?>
						<?php if ( $cta_button_text && $cta_button_url ) : ?>
							<a class="devotel-btn" href="<?php echo esc_url( $cta_button_url ); ?>">
								<?php echo esc_html( $cta_button_text ); ?>
							</a>
						<?php endif; ?>
					</section>
					<?php
				endif;
			endwhile;
			?>
		</div>
	<?php endif; ?>
	<?php
}

/**
 * Footer CSS for SIM product pages — must load after widget inline <style> blocks.
 *
 * @return string
 */
function devotel_get_sim_based_footer_css() {
	return '@media (min-width:769px){'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled){background:transparent!important;background-color:transparent!important;border:0!important;border-bottom:0!important;box-shadow:none!important;backdrop-filter:none!important;-webkit-backdrop-filter:none!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled)::before{opacity:0!important;background:transparent!important;backdrop-filter:none!important;-webkit-backdrop-filter:none!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-navbar-main{background:transparent!important;background-color:transparent!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-products,'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-telco,'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-company,'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-menu-item-text,'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-menu-item,'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-frame-parent a{color:#fff!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-arrow-down svg path{stroke:#fff!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled){top:var(--devotel-admin-bar-height,0px)!important}'
		. 'body.devotel-inner-page.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-login-wrapper{background:transparent!important;background-color:transparent!important;border-color:#fff!important}'
		. 'body.devotel-inner-page.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-login-text{color:#fff!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-logo-svg{filter:brightness(0) invert(1)!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-talk-to-an-expert-wrapper{background-color:#fff!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-talk-to-an{color:#0f172b!important}'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-7796 .elementor-element-d8ae8b8,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8835 .elementor-element-dda41cf,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8717 .elementor-element-b95215f,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8645 .elementor-element-e3020eb{margin-top:-70px!important;--margin-top:-70px!important;padding-top:0!important;--padding-top:0px!important}'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-7796 .elementor-element-d8ae8b8>.e-con-inner,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8835 .elementor-element-dda41cf>.e-con-inner,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8717 .elementor-element-b95215f>.e-con-inner,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8645 .elementor-element-e3020eb>.e-con-inner{padding-top:0!important;--padding-top:0px!important}'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-7796 .elementor-element-2dbba2f,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8835 .elementor-element-b91bec6,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8717 .elementor-element-77034f6,'
		. 'body.devotel-sim-based-page .devotel-cached-snapshot .elementor.elementor-8645 .elementor-element-174944c{margin-top:167px!important;--margin-top:167px!important}'
		. 'body.devotel-sim-based-page .sim-cmp-section [class*="sim-cmp-cell-l"],body.devotel-sim-based-page .sim-cmp-section [class*="sim-cmp-cell-r"]{box-sizing:border-box!important;display:flex!important;flex-direction:row!important;align-items:center!important;justify-content:flex-start!important;padding:0 56px 0 0!important;height:48px!important;min-height:48px!important}'
		. 'body.devotel-sim-based-page .sim-cmp-section [class*="sim-cmp-cell-l"]{max-width:465px!important}'
		. 'body.devotel-sim-based-page .sim-cmp-section [class*="sim-cmp-cell-r"]{max-width:520px!important}'
		. 'body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-l1,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-l2,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-l5,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-l8,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-r1,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-r2,body.devotel-sim-based-page .sim-cmp-section .sim-cmp-cell-r8{height:auto!important;min-height:48px!important;max-height:58px!important;align-items:center!important}'
		. 'body.devotel-sim-based-page .sim-cmp-section [class*="sim-cmp-cell-"]>div:not(:first-child){flex:1 1 auto!important;min-width:0!important;max-width:100%!important;overflow-wrap:break-word!important;word-break:break-word!important;font-size:15px!important;line-height:22px!important}'
		. '}'
		. '@media (max-width:768px){'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled){background:transparent!important;background-color:transparent!important;border:0!important;box-shadow:none!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled)::before{opacity:0!important}'
		. 'body.devotel-sim-based-page .header-navbar-wrapper:not(.header-scrolled) .header-mobile-menu-button svg path{stroke:#fff!important}'
		. '}';
}

/**
 * Print SIM footer overrides after snapshot widget styles.
 */
function devotel_print_sim_based_footer_css() {
	if ( is_admin() || ! is_page() ) {
		return;
	}

	$classes = get_body_class();
	if ( ! in_array( 'devotel-sim-based-page', $classes, true ) ) {
		return;
	}

	$css = devotel_get_sim_based_footer_css();
	if ( '' === $css ) {
		return;
	}

	echo '<style id="devotel-sim-based-footer">' . $css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_footer', 'devotel_print_sim_based_footer_css', 100003 );
