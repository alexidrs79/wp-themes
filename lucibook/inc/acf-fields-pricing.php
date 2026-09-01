<?php
/**
 * ACF field group: Pricing section.
 * Figma: node 15532:491 ("Section 06 — Pricing").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_pricing_field_group' );

function lucibook_register_pricing_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_pricing',
			'title'  => 'Pricing Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_pricing_headline',
					'label'         => 'Headline',
					'name'          => 'pricing_headline',
					'type'          => 'text',
					'default_value' => 'Simple pricing. No accounting required.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_pricing_sub',
					'label'         => 'Supporting Line',
					'name'          => 'pricing_sub',
					'type'          => 'text',
					'default_value' => 'Start with what you need today. Move up when your practice needs more.',
					'required'      => 1,
				),
				array(
					'key'          => 'field_lb_pricing_tiers',
					'label'        => 'Pricing Tiers',
					'name'         => 'pricing_tiers',
					'type'         => 'repeater',
					'layout'       => 'block',
					'button_label' => 'Add Tier',
					'min'          => 3,
					'max'          => 3,
					'sub_fields'   => array(
						array( 'key' => 'field_lb_tier_name', 'label' => 'Tier Name', 'name' => 'name', 'type' => 'text' ),
						array( 'key' => 'field_lb_tier_badge', 'label' => 'Badge (e.g. "Most Popular")', 'name' => 'badge', 'type' => 'text' ),
						array( 'key' => 'field_lb_tier_featured', 'label' => 'Featured Tier', 'name' => 'featured', 'type' => 'true_false', 'ui' => 1 ),
						array( 'key' => 'field_lb_tier_price', 'label' => 'Price', 'name' => 'price', 'type' => 'text' ),
						array( 'key' => 'field_lb_tier_per', 'label' => 'Per', 'name' => 'per', 'type' => 'text' ),
						array( 'key' => 'field_lb_tier_description', 'label' => 'Description', 'name' => 'description', 'type' => 'text' ),
						array(
							'key'          => 'field_lb_tier_features',
							'label'        => 'Features',
							'name'         => 'features',
							'type'         => 'repeater',
							'layout'       => 'table',
							'button_label' => 'Add Feature',
							'sub_fields'   => array(
								array( 'key' => 'field_lb_tier_feature_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
							),
						),
						array( 'key' => 'field_lb_tier_cta_label', 'label' => 'CTA Label', 'name' => 'cta_label', 'type' => 'text' ),
						array( 'key' => 'field_lb_tier_cta_url', 'label' => 'CTA URL', 'name' => 'cta_url', 'type' => 'text', 'default_value' => '#' ),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-landing-lucibook.php',
					),
				),
			),
		)
	);
}
