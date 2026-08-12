<?php
/**
 * ACF field group: Pricing page.
 *
 * No Figma design exists for this page — built from the site's
 * established tokens/components, same approach as the Contact page
 * (see template-parts/pricing.php for the specific reuse mapping).
 *
 * Tiers and FAQ items are real ACF Pro repeaters (each tier's own feature
 * list is a nested repeater), replacing the earlier free-tier build's
 * fixed 3-tier / 8-feature-slot / 5-FAQ Group fields. That content was
 * migrated into the new rows, not re-entered by hand.
 *
 * ALL pricing numbers, feature copy, and FAQ content registered here are
 * placeholders — flagged individually below and again in the template's
 * doc comment — since real pricing hadn't been finalized at build time.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_pricing_field_group' );

function snap_register_pricing_field_group() {
	$tier_subfields = array(
		array(
			'key'   => 'field_snap_pricing_tier_name',
			'label' => 'Tier Name',
			'name'  => 'name',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_badge',
			'label' => 'Badge Label (optional — e.g. "Most popular")',
			'name'  => 'badge',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_featured',
			'label' => 'Featured / Highlighted Tier',
			'name'  => 'featured',
			'type'  => 'true_false',
			'ui'    => 1,
		),
		array(
			'key'   => 'field_snap_pricing_tier_price',
			'label' => 'Price (placeholder — e.g. "£49" or "Custom pricing")',
			'name'  => 'price',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_price_suffix',
			'label' => 'Price Suffix (optional — e.g. "/month")',
			'name'  => 'price_suffix',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_description',
			'label' => 'Description',
			'name'  => 'description',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_button_label',
			'label' => 'Button Label',
			'name'  => 'button_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_tier_button_url',
			'label' => 'Button URL',
			'name'  => 'button_url',
			'type'  => 'url',
		),
		array(
			'key'          => 'field_snap_pricing_tier_features',
			'label'        => 'Features',
			'name'         => 'features',
			'type'         => 'repeater',
			'layout'       => 'table',
			'button_label' => 'Add Feature',
			'sub_fields'   => array(
				array(
					'key'   => 'field_snap_pricing_tier_feature',
					'label' => 'Feature',
					'name'  => 'feature',
					'type'  => 'text',
				),
			),
		),
	);
	
	$faq_subfields = array(
		array(
			'key'   => 'field_snap_pricing_faq_question',
			'label' => 'Question',
			'name'  => 'question',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_snap_pricing_faq_answer',
			'label' => 'Answer',
			'name'  => 'answer',
			'type'  => 'textarea',
			'rows'  => 3,
		),
	);

	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_pricing',
			'title'  => 'Pricing Page',
			'fields' => array(
				array(
					'key'           => 'field_snap_pricing_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'pricing_eyebrow',
					'type'          => 'text',
					'default_value' => 'PRICING',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_pricing_headline',
					'label'         => 'Headline',
					'name'          => 'pricing_headline',
					'type'          => 'text',
					'default_value' => 'Simple pricing that scales with you.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_pricing_subhead',
					'label'         => 'Supporting Line',
					'name'          => 'pricing_subhead',
					'type'          => 'text',
					'default_value' => 'No hidden fees. Cancel anytime.',
				),
				array(
					'key'     => 'field_snap_pricing_placeholder_note',
					'label'   => 'Note',
					'name'    => 'pricing_placeholder_note',
					'type'    => 'message',
					'message' => 'Every price, feature line, and FAQ answer below is placeholder copy — review and replace before this page goes live. See the template file\'s doc comment for the full list of what\'s placeholder vs. real.',
				),
				array(
					'key'          => 'field_snap_pricing_tiers',
					'label'        => 'Pricing Tiers',
					'name'         => 'pricing_tiers',
					'type'         => 'repeater',
					'instructions' => 'Add, remove, or reorder pricing tiers. Toggle "Featured" on the one tier that should be visually highlighted.',
					'layout'       => 'block',
					'button_label' => 'Add Tier',
					'sub_fields'   => $tier_subfields,
				),
				array(
					'key'          => 'field_snap_pricing_faq',
					'label'        => 'FAQ',
					'name'         => 'pricing_faq',
					'type'         => 'repeater',
					'instructions' => 'Add, remove, or reorder FAQ entries.',
					'layout'       => 'block',
					'button_label' => 'Add FAQ',
					'sub_fields'   => $faq_subfields,
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
