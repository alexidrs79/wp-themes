<?php
/**
 * ACF field group: One Connected Workspace section.
 * Figma: node 15532:356 ("Section 05 — One Connected Workspace").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_connected_workspace_field_group' );

function lucibook_register_connected_workspace_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_connected_workspace',
			'title'  => 'Connected Workspace Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_ws_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'ws_eyebrow',
					'type'          => 'text',
					'default_value' => 'LUCIBOOK',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_headline',
					'label'         => 'Headline',
					'name'          => 'ws_headline',
					'type'          => 'textarea',
					'rows'          => 3,
					'instructions'  => 'One line per row.',
					'default_value' => "They made accounting\ncomplicated.\nWe made Lucibook.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_body',
					'label'         => 'Body',
					'name'          => 'ws_body',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'Everything your practice needs, working together in one place — from capturing documents and doing the accounts to getting answers and preparing for submission.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_closing',
					'label'         => 'Closing Line',
					'name'          => 'ws_closing',
					'type'          => 'text',
					'default_value' => 'Everything connected. Without the complexity.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_cta_label',
					'label'         => 'CTA Label',
					'name'          => 'ws_cta_label',
					'type'          => 'text',
					'default_value' => 'Explore Lucibook',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_cta_url',
					'label'         => 'CTA URL',
					'name'          => 'ws_cta_url',
					'type'          => 'text',
					'default_value' => '#',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_ws_tagline',
					'label'         => 'Tagline',
					'name'          => 'ws_tagline',
					'type'          => 'textarea',
					'rows'          => 3,
					'instructions'  => 'One line per row.',
					'default_value' => "Snap captures it.\nLuci knows it.\nLucibook brings it all together.",
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
