<?php
/**
 * ACF field group: Theme Settings (site-wide).
 *
 * Registered on a real ACF Options Page (see acf_add_options_page() call
 * below) now that this install runs ACF Pro. Nav items and footer columns
 * are real Repeater fields (footer columns are a repeater of repeaters —
 * each column's own links are independently add/remove-able). This
 * replaces the earlier free-tier build, which stood in with a hidden page
 * (post ID 100) + ACF Group fields with a fixed number of slots — that
 * content was migrated into this structure, not re-entered by hand.
 *
 * Tabs (ACF 'tab' fields) split this into the 4 sections asked for.
 * Social Links and Tracking/Misc tabs were explicitly skipped for now
 * (no real social presence or tracking snippet exists yet) — add them
 * here later the same way if/when needed.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SNAP_THEME_SETTINGS_PAGE_ID' ) ) {
	define( 'SNAP_THEME_SETTINGS_PAGE_ID', 'option' );
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'snap-theme-settings',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-customizer',
			'position'   => 59,
			'redirect'   => false,
		)
	);
}

add_action( 'acf/init', 'snap_register_theme_settings_field_group' );

function snap_register_theme_settings_field_group() {
	$nav_item_subfields = array(
		array(
			'key'   => 'field_snap_nav_item_label',
			'label' => 'Label',
			'name'  => 'label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_nav_item_url',
			'label' => 'URL',
			'name'  => 'url',
			'type'  => 'text',
			'instructions' => 'Full URL or a same-page anchor like /#meet-snap.',
		),
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_theme_settings',
			'title'  => 'Theme Settings',
			'fields' => array(

				// ---------------------------------------------------
				// Tab 1 — General / Logo
				// ---------------------------------------------------
				array(
					'key'   => 'field_snap_ts_tab_general',
					'label' => 'General / Logo',
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_snap_ts_site_logo',
					'label'         => 'Site Logo',
					'name'          => 'theme_site_logo',
					'type'          => 'image',
					'instructions'  => 'The orange "Snap" mark used in the header. Falls back to Appearance → Customize → Site Identity if left blank.',
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_snap_ts_footer_logo',
					'label'         => 'Footer Logo',
					'name'          => 'theme_footer_logo',
					'type'          => 'image',
					'instructions'  => 'A genuinely separate asset, not the site logo recolored via CSS — orange icon + WHITE text, for the dark footer background.',
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_snap_ts_favicon',
					'label'         => 'Favicon',
					'name'          => 'theme_favicon',
					'type'          => 'image',
					'instructions'  => 'Saving this also updates the site icon WordPress itself uses to generate favicon tags (Settings → General), so this is the only place you need to set it.',
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_snap_ts_site_tagline',
					'label'         => 'Site Tagline',
					'name'          => 'theme_site_tagline',
					'type'          => 'text',
					'instructions'  => 'Used in the footer (and anywhere else a short tagline is needed) — one shared field, not duplicated per location.',
					'default_value' => 'AI-powered document intelligence for accounting.',
					'required'      => 1,
				),

				// ---------------------------------------------------
				// Tab 2 — Header
				// ---------------------------------------------------
				array(
					'key'   => 'field_snap_ts_tab_header',
					'label' => 'Header',
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_snap_ts_nav_items',
					'label'        => 'Nav Items',
					'name'         => 'theme_nav_items',
					'type'         => 'repeater',
					'instructions' => 'Primary header nav links. Add, remove, or reorder rows to update the menu without touching code.',
					'layout'       => 'table',
					'button_label' => 'Add Nav Item',
					'sub_fields'   => $nav_item_subfields,
				),
				array(
					'key'           => 'field_snap_ts_talk_label',
					'label'         => '"Talk to us" — Label',
					'name'          => 'theme_talk_to_us_label',
					'type'          => 'text',
					'default_value' => 'Talk to us',
				),
				array(
					'key'           => 'field_snap_ts_talk_url',
					'label'         => '"Talk to us" — URL',
					'name'          => 'theme_talk_to_us_url',
					'type'          => 'text',
					'default_value' => '#',
				),
				array(
					'key'           => 'field_snap_ts_header_cta_label',
					'label'         => 'Header CTA Button — Label',
					'name'          => 'theme_header_cta_label',
					'type'          => 'text',
					'default_value' => 'Book a demo',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ts_header_cta_url',
					'label'         => 'Header CTA Button — URL',
					'name'          => 'theme_header_cta_url',
					'type'          => 'text',
					'default_value' => '/#cta-demo-email',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ts_sticky_header',
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
					'key'   => 'field_snap_ts_tab_footer',
					'label' => 'Footer',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_snap_ts_footer_note',
					'label'   => 'Note',
					'name'    => 'theme_footer_note',
					'type'    => 'message',
					'message' => 'The footer tagline is shared with Tab 1\'s Site Tagline field above, not repeated here.',
				),
				array(
					'key'          => 'field_snap_footer_columns',
					'label'        => 'Footer Columns',
					'name'         => 'footer_columns',
					'type'         => 'repeater',
					'instructions' => 'Footer link columns. Add, remove, or reorder columns and their links to update the footer without touching code.',
					'layout'       => 'block',
					'button_label' => 'Add Column',
					'sub_fields'   => array(
						array(
							'key'   => 'field_snap_footer_col_heading',
							'label' => 'Column Heading',
							'name'  => 'heading',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_snap_footer_col_links',
							'label'        => 'Links',
							'name'         => 'links',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => 'Add Link',
							'sub_fields'   => array(
								array(
									'key'   => 'field_snap_footer_col_link',
									'label' => 'Link',
									'name'  => 'link',
									'type'  => 'link',
								),
							),
						),
					),
				),
				array(
					'key'           => 'field_snap_footer_rights_text',
					'label'         => 'Copyright — Rights Text',
					'name'          => 'footer_rights_text',
					'type'          => 'text',
					'instructions'  => 'The year is added automatically — just the text after it, e.g. "Snap. All rights reserved." Rendered uppercase (CSS), so type normal case here.',
					'default_value' => 'Snap. All rights reserved.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_footer_credit',
					'label'         => 'Bottom-right Credit',
					'name'          => 'footer_credit',
					'type'          => 'text',
					'instructions'  => 'Rendered uppercase (CSS), so type normal case here. Leave blank to remove it entirely.',
					'default_value' => 'A Lucibook product',
				),

				// ---------------------------------------------------
				// Tab 4 — Contact Information
				// ---------------------------------------------------
				array(
					'key'   => 'field_snap_ts_tab_contact',
					'label' => 'Contact Information',
					'type'  => 'tab',
				),
				array(
					'key'     => 'field_snap_ts_contact_note',
					'label'   => 'Note',
					'name'    => 'theme_contact_note',
					'type'    => 'message',
					'message' => 'Single source of truth for contact details — used on the Contact page and anywhere else these appear (e.g. the footer, if added there later). Placeholder values below, review before launch.',
				),
				array(
					'key'           => 'field_snap_ts_contact_email',
					'label'         => 'Email',
					'name'          => 'theme_contact_email',
					'type'          => 'email',
					'default_value' => 'hello@snapapp.io',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ts_contact_phone',
					'label'         => 'Phone',
					'name'          => 'theme_contact_phone',
					'type'          => 'text',
					'default_value' => '+44 20 7946 0958',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ts_contact_address',
					'label'         => 'Address',
					'name'          => 'theme_contact_address',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => "86 Riverside Quarter\nLondon, SE1 9RT\nUnited Kingdom",
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ts_contact_hours',
					'label'         => 'Business Hours',
					'name'          => 'theme_contact_hours',
					'type'          => 'text',
					'default_value' => 'Mon–Fri, 9am–5pm GMT',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_ts_contact_map_embed_url',
					'label'        => 'Map Embed URL',
					'name'         => 'theme_contact_map_embed_url',
					'type'         => 'url',
					'instructions' => "Paste just the iframe's src URL from Google Maps' \"Embed a map\" share option (no API key required). Leave blank to show a static placeholder instead.",
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'snap-theme-settings',
					),
				),
			),
		)
	);
}
