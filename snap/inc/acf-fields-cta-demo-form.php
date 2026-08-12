<?php
/**
 * ACF field group: "CTA / Demo Form" section.
 * Figma: node 15150:2028 ("Frame 3").
 *
 * The headline is two lines with different colors (white / ink), same
 * two-field pattern as every other section's two-tone heading.
 *
 * The demo form itself is a real Contact Form 7 form (id 99, "CTA Demo
 * Form"), not ACF-driven — CF7 + Fluent SMTP (routed through Google
 * Workspace) is the project's chosen form/mail stack, per explicit
 * instruction. Its copy (email placeholder, button label) and mail
 * routing are edited via Contact > Contact Forms in wp-admin, not here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_cta_demo_form_field_group' );

function snap_register_cta_demo_form_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_cta_demo_form',
			'title'  => 'CTA / Demo Form Section',
			'fields' => array(
				array(
					'key'          => 'field_snap_cta_logo_mark',
					'label'        => 'Logo Mark (White)',
					'name'         => 'cta_logo_mark',
					'type'         => 'image',
					'instructions' => 'White version of the Snap mark, for use on the orange background.',
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_snap_cta_headline_white',
					'label'         => 'Headline — Line 1 (White)',
					'name'          => 'cta_headline_white',
					'type'          => 'text',
					'default_value' => 'Stop reading documents.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_cta_headline_ink',
					'label'         => 'Headline — Line 2 (Ink)',
					'name'          => 'cta_headline_ink',
					'type'          => 'text',
					'default_value' => 'Start understanding them.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_cta_supporting_copy',
					'label'         => 'Supporting Copy',
					'name'          => 'cta_supporting_copy',
					'type'          => 'text',
					'default_value' => 'The document intelligence platform built for modern UK accounting firms.',
					'required'      => 1,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'page-templates/template-landing-snap.php',
					),
				),
			),
		)
	);
}
