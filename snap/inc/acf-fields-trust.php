<?php
/**
 * ACF field group: Trust Strip.
 *
 * Figma only has a placeholder note here ("need a trust section or
 * something separator") — no real design to replicate, so this section is
 * built from the existing design tokens (color, type scale, spacing)
 * already established by the header/hero rather than introducing new ones.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_trust_field_group' );

function snap_register_trust_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_trust',
			'title'  => 'Trust Strip',
			'fields' => array(
				array(
					'key'          => 'field_snap_trust_stat_line',
					'label'        => 'Stat Line',
					'name'         => 'trust_stat_line',
					'type'         => 'text',
					'instructions' => 'Short, understated line, e.g. "Trusted by 500+ UK accounting firms."',
					'required'     => 1,
					'default_value' => 'Trusted by 500+ UK accounting firms',
				),
				array(
					'key'          => 'field_snap_trust_logos',
					'label'        => 'Logos',
					'name'         => 'trust_logos',
					'type'         => 'repeater',
					'instructions' => 'Client/partner logos shown in the trust strip. Add, remove, or reorder rows to update the row without touching code.',
					'layout'       => 'table',
					'button_label' => 'Add Logo',
					'default_value' => array(
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_1_ID,
							'field_snap_trust_logo_link'  => '',
						),
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_2_ID,
							'field_snap_trust_logo_link'  => '',
						),
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_3_ID,
							'field_snap_trust_logo_link'  => '',
						),
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_4_ID,
							'field_snap_trust_logo_link'  => '',
						),
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_5_ID,
							'field_snap_trust_logo_link'  => '',
						),
						array(
							'field_snap_trust_logo_image' => SNAP_TRUST_LOGO_6_ID,
							'field_snap_trust_logo_link'  => '',
						),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_trust_logo_image',
							'label'         => 'Logo',
							'name'          => 'logo',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
						array(
							'key'          => 'field_snap_trust_logo_link',
							'label'        => 'Link URL',
							'name'         => 'link',
							'type'         => 'url',
							'instructions' => 'Optional — leave blank for a non-clickable logo.',
						),
					),
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
