<?php
/**
 * ACF field group: Luci AI section.
 * Figma: node 15532:302 ("Section 04 — Luci AI").
 *
 * Note: layer/component names in this section of the Figma file say
 * "Luci" (Luci Character Stage, Luci Name Badge, etc.) but the actual
 * rendered copy consistently says "Lucy" (eyebrow "LUCY AI", headline
 * "She knows accountancy", badge text "Lucy · your AI accountant",
 * placeholder "Ask Lucy anything…") — visible text wins throughout this
 * build, "Luci" is only kept for the genuinely distinct "LuciCore"
 * reconciliation engine and the "Lucibook" product name.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_luci_ai_field_group' );

function lucibook_register_luci_ai_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_luci_ai',
			'title'  => 'Luci AI Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_luci_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'luci_eyebrow',
					'type'          => 'text',
					'default_value' => 'LUCY AI',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_headline',
					'label'         => 'Headline',
					'name'          => 'luci_headline',
					'type'          => 'textarea',
					'rows'          => 2,
					'instructions'  => 'One line per row.',
					'default_value' => "She knows accountancy.\nAll of it.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_challenge',
					'label'         => 'Challenge Line',
					'name'          => 'luci_challenge',
					'type'          => 'text',
					'default_value' => 'Don\'t believe us? Ask her.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_positioning',
					'label'         => 'Positioning Copy',
					'name'          => 'luci_positioning',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'An expert accountant you can actually ask — built around accounting knowledge, standards, compliance and the rules that shape the work.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_input_placeholder',
					'label'         => 'Ask-input Placeholder',
					'name'          => 'luci_input_placeholder',
					'type'          => 'text',
					'default_value' => 'Ask Lucy anything about accountancy…',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_input_note',
					'label'         => 'Input Note',
					'name'          => 'luci_input_note',
					'type'          => 'text',
					'default_value' => 'Tax, standards, deadlines, legislation — ask in plain English.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_luci_character_photo',
					'label'         => 'Character Photo',
					'name'          => 'luci_character_photo',
					'type'          => 'image',
					'return_format' => 'id',
					'default_value' => lucibook_get_attachment_id_by_filename( 'luci-character' ),
				),
				array(
					'key'           => 'field_lb_luci_name_badge',
					'label'         => 'Name Badge Text',
					'name'          => 'luci_name_badge',
					'type'          => 'text',
					'default_value' => 'Lucy · your AI accountant',
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
