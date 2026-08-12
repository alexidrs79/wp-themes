<?php
/**
 * ACF field group: Contact page.
 *
 * Rebuilt from the original two-form layout to a single unified form +
 * contact-details column. No Figma design exists for this page — reuses
 * established tokens/components (see template-parts/contact.php).
 *
 * The form itself is a real Contact Form 7 form (id 106), same
 * CF7 + Fluent SMTP stack as every other form on the site — only the
 * surrounding page copy (headline, intro) is ACF-driven here. The
 * "Reason for contact" dropdown does NOT route to different recipients
 * yet — flagged separately, not built until asked.
 *
 * The actual contact DETAILS (email, phone, address, hours, map embed)
 * moved to the site-wide Theme Settings page (see
 * inc/acf-fields-theme-settings.php) so they're a single source of
 * truth instead of living only on this page — template-parts/contact.php
 * reads those from SNAP_THEME_SETTINGS_PAGE_ID now, not from here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_contact_field_group' );

function snap_register_contact_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_contact',
			'title'  => 'Contact Page',
			'fields' => array(
				array(
					'key'           => 'field_snap_contact_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'contact_eyebrow',
					'type'          => 'text',
					'default_value' => 'GET IN TOUCH',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_contact_headline',
					'label'         => 'Headline',
					'name'          => 'contact_headline',
					'type'          => 'text',
					'default_value' => "Let's talk about your workflow.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_contact_intro',
					'label'         => 'Left Column — Intro Line',
					'name'          => 'contact_intro',
					'type'          => 'text',
					'default_value' => 'Reach out directly, or send us a message.',
				),
				array(
					'key'     => 'field_snap_contact_placeholder_note',
					'label'   => 'Note',
					'name'    => 'contact_placeholder_note',
					'type'    => 'message',
					'message' => 'Email, phone, address, and business hours below are placeholder details — replace with the real ones before this page goes live.',
				),
				array(
					'key'     => 'field_snap_contact_trust_note',
					'label'   => 'Note',
					'name'    => 'contact_trust_placeholder_note',
					'type'    => 'message',
					'message' => 'The 4 reassurance items below are placeholder copy — replace with real claims (or delete unused ones) before this page goes live.',
				),
				array(
					'key'           => 'field_snap_contact_trust_item_1',
					'label'         => 'Reassurance Item 1',
					'name'          => 'contact_trust_item_1',
					'type'          => 'text',
					'default_value' => 'Response within 1 business day',
				),
				array(
					'key'           => 'field_snap_contact_trust_item_2',
					'label'         => 'Reassurance Item 2',
					'name'          => 'contact_trust_item_2',
					'type'          => 'text',
					'default_value' => 'UK-based support',
				),
				array(
					'key'           => 'field_snap_contact_trust_item_3',
					'label'         => 'Reassurance Item 3',
					'name'          => 'contact_trust_item_3',
					'type'          => 'text',
					'default_value' => 'No sales pressure',
				),
				array(
					'key'           => 'field_snap_contact_trust_item_4',
					'label'         => 'Reassurance Item 4',
					'name'          => 'contact_trust_item_4',
					'type'          => 'text',
					'default_value' => 'Free 15-minute walkthrough',
				),
				array(
					'key'           => 'field_snap_contact_response_note',
					'label'         => 'Closing Response-time Note',
					'name'          => 'contact_response_note',
					'type'          => 'text',
					'default_value' => 'We typically respond within 1 business day.',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-contact.php',
					),
				),
			),
		)
	);
}
