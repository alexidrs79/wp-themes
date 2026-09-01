<?php
/**
 * ACF field group: Founding Offer section.
 * Figma: node 15532:564 ("Section 07 — Founding Offer").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_founding_offer_field_group' );

function lucibook_register_founding_offer_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_founding_offer',
			'title'  => 'Founding Offer Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_fo_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'fo_eyebrow',
					'type'          => 'text',
					'default_value' => 'FOUNDING OFFER',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_headline',
					'label'         => 'Headline',
					'name'          => 'fo_headline',
					'type'          => 'textarea',
					'rows'          => 2,
					'instructions'  => 'One line per row.',
					'default_value' => "Be one of the first 5,000.\nKeep 50% off. For life.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_body',
					'label'         => 'Body',
					'name'          => 'fo_body',
					'type'          => 'textarea',
					'rows'          => 2,
					'instructions'  => 'One paragraph per row.',
					'default_value' => "The first 5,000 Lucibook customers will get 50% off their subscription for life.\nNo countdowns. No temporary offers. Get in early, and the price stays with you.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_signup_title',
					'label'         => 'Signup Card — Title',
					'name'          => 'fo_signup_title',
					'type'          => 'text',
					'default_value' => 'Claim your founding price',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_email_placeholder',
					'label'         => 'Email Input — Placeholder',
					'name'          => 'fo_email_placeholder',
					'type'          => 'text',
					'default_value' => 'Enter your email address',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_claim_label',
					'label'         => 'Claim Button — Label',
					'name'          => 'fo_claim_label',
					'type'          => 'text',
					'default_value' => 'Claim my 50%',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_small_print',
					'label'         => 'Small Print',
					'name'          => 'fo_small_print',
					'type'          => 'text',
					'default_value' => 'Your 50% lifetime discount will be linked to the email address you register with.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_fo_bottom_note',
					'label'         => 'Bottom Note',
					'name'          => 'fo_bottom_note',
					'type'          => 'text',
					'default_value' => 'No countdowns. No pressure. Just a better price for getting in early.',
					'required'      => 1,
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
