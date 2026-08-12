<?php
/**
 * ACF field group: Pricing page — closing CTA section
 * (template-parts/cta-simple.php).
 *
 * A no-form variant of the landing page's CTA/Demo Form section: same
 * background/ring/headline treatment (reuses the .cta-demo CSS classes
 * directly), but its own template part and its own name-spaced fields
 * (pricing_cta_*) so it stays independently editable from the landing
 * page's CTA, per explicit instruction.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_pricing_cta_field_group' );

function snap_register_pricing_cta_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_pricing_cta',
			'title'  => 'Pricing Page — Closing CTA',
			'fields' => array(
				array(
					'key'           => 'field_snap_pricing_cta_logo_mark',
					'label'         => 'Logo Mark (White)',
					'name'          => 'pricing_cta_logo_mark',
					'type'          => 'image',
					'instructions'  => 'White version of the Snap mark, for use on the orange background.',
					'return_format' => 'id',
					'default_value' => SNAP_CTA_LOGO_MARK_ID,
				),
				array(
					'key'           => 'field_snap_pricing_cta_headline_white',
					'label'         => 'Headline — Line 1 (White)',
					'name'          => 'pricing_cta_headline_white',
					'type'          => 'text',
					'default_value' => 'Still deciding?',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_pricing_cta_headline_ink',
					'label'         => 'Headline — Line 2 (Ink)',
					'name'          => 'pricing_cta_headline_ink',
					'type'          => 'text',
					'default_value' => "Let's talk it through.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_pricing_cta_supporting_copy',
					'label'         => 'Supporting Copy',
					'name'          => 'pricing_cta_supporting_copy',
					'type'          => 'text',
					'default_value' => 'No pressure, no scripts — just a straight answer about whether Snap fits your firm.',
				),
				array(
					'key'           => 'field_snap_pricing_cta_button_label',
					'label'         => 'Button Label',
					'name'          => 'pricing_cta_button_label',
					'type'          => 'text',
					'default_value' => 'Talk to sales',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_pricing_cta_button_url',
					'label'        => 'Button URL',
					'name'         => 'pricing_cta_button_url',
					'type'         => 'url',
					'instructions' => 'Defaults to the Contact page if left blank.',
				),
				array(
					'key'     => 'field_snap_pricing_cta_note',
					'label'   => 'Note',
					'name'    => 'pricing_cta_placeholder_note',
					'type'    => 'message',
					'message' => 'Headline, supporting copy, and button label are placeholder copy — review before this page goes live.',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-pricing.php',
					),
				),
			),
		)
	);
}
