<?php
/**
 * ACF field group: Social Proof section.
 * Figma: node 15532:141 ("Section 02 — Social Proof").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_social_proof_field_group' );

function lucibook_register_social_proof_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_social_proof',
			'title'  => 'Social Proof Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_sp_headline',
					'label'         => 'Headline',
					'name'          => 'sp_headline',
					'type'          => 'text',
					'default_value' => 'Trusted by accountants who have better things to do.',
					'required'      => 1,
				),
				array(
					'key'          => 'field_lb_sp_logos',
					'label'        => 'Logos',
					'name'         => 'sp_logos',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add Logo',
					'min'          => 0,
					'max'          => 6,
					'sub_fields'   => array(
						array(
							'key'   => 'field_lb_sp_logo_name',
							'label' => 'Name',
							'name'  => 'name',
							'type'  => 'text',
						),
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
