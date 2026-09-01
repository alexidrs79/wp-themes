<?php
/**
 * ACF field group: Theme Settings (site-wide).
 * Figma: node 15532:80 ("Header").
 *
 * Registered on a real ACF Options Page, same pattern as the Snap theme's
 * Theme Settings — nav items are a real repeater so editors can add/
 * remove/reorder rows without touching code.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'LUCIBOOK_THEME_SETTINGS_PAGE_ID' ) ) {
	define( 'LUCIBOOK_THEME_SETTINGS_PAGE_ID', 'option' );
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'lucibook-theme-settings',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-customizer',
			'position'   => 59,
			'redirect'   => false,
		)
	);
}

add_action( 'acf/init', 'lucibook_register_theme_settings_field_group' );

function lucibook_register_theme_settings_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_theme_settings',
			'title'  => 'Theme Settings',
			'fields' => array(

				// ---------------------------------------------------
				// Tab 1 — General / Logo
				// ---------------------------------------------------
				array(
					'key'   => 'field_lb_ts_tab_general',
					'label' => 'General / Logo',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_lb_ts_site_logo',
					'label'         => 'Site Logo',
					'name'          => 'theme_site_logo',
					'type'          => 'image',
					'instructions'  => 'The "Lucibook" leaf mark + wordmark used in the header. Falls back to Appearance → Customize → Site Identity if left blank.',
					'return_format' => 'id',
				),

				// ---------------------------------------------------
				// Tab 2 — Header
				// ---------------------------------------------------
				array(
					'key'   => 'field_lb_ts_tab_header',
					'label' => 'Header',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_lb_ts_nav_items',
					'label'        => 'Nav Items',
					'name'         => 'theme_nav_items',
					'type'         => 'repeater',
					'instructions' => 'Primary header nav links. Add, remove, or reorder rows to update the menu without touching code.',
					'layout'       => 'table',
					'button_label' => 'Add Nav Item',
					'sub_fields'   => array(
						array(
							'key'   => 'field_lb_nav_item_label',
							'label' => 'Label',
							'name'  => 'label',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_lb_nav_item_url',
							'label'        => 'URL',
							'name'         => 'url',
							'type'         => 'text',
							'instructions' => 'Full URL or a same-page anchor like /#pricing.',
						),
					),
				),
				array(
					'key'           => 'field_lb_ts_login_label',
					'label'         => '"Log in" — Label',
					'name'          => 'theme_login_label',
					'type'          => 'text',
					'default_value' => 'Log in',
				),
				array(
					'key'           => 'field_lb_ts_login_url',
					'label'         => '"Log in" — URL',
					'name'          => 'theme_login_url',
					'type'          => 'text',
					'default_value' => '#',
				),
				array(
					'key'           => 'field_lb_ts_header_cta_label',
					'label'         => 'Header CTA Button — Label',
					'name'          => 'theme_header_cta_label',
					'type'          => 'text',
					'default_value' => 'Get started →',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ts_header_cta_url',
					'label'         => 'Header CTA Button — URL',
					'name'          => 'theme_header_cta_url',
					'type'          => 'text',
					'default_value' => '/#founding-offer',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ts_sticky_header',
					'label'         => 'Sticky Header',
					'name'          => 'theme_sticky_header_enabled',
					'type'          => 'true_false',
					'instructions'  => 'Keep the header pinned to the top of the viewport on scroll.',
					'default_value' => 1,
					'ui'            => 1,
				),

				// ---------------------------------------------------
				// Tab 3 — Footer
				// ---------------------------------------------------
				array(
					'key'   => 'field_lb_ts_tab_footer',
					'label' => 'Footer',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_lb_ts_footer_note',
					'label'   => '',
					'name'    => 'theme_footer_note',
					'type'    => 'message',
					'message' => 'The Figma design has no dedicated footer section — the page ends after the Founding Offer panel. This adds a minimal copyright bar only, standard practice for a real site.',
				),
				array(
					'key'           => 'field_lb_footer_rights_text',
					'label'         => 'Copyright — Rights Text',
					'name'          => 'footer_rights_text',
					'type'          => 'text',
					'instructions'  => 'The year is added automatically — just the text after it.',
					'default_value' => 'Lucibook. All rights reserved.',
					'required'      => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'lucibook-theme-settings',
					),
				),
			),
		)
	);
}
