<?php
/**
 * ACF field group: "Designed Around UK Accounting Workflows" section.
 * Figma: node 15150:1739 ("Background").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_built_for_uk_field_group' );

function snap_register_built_for_uk_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_built_for_uk',
			'title'  => 'Built For UK Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_uk_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'uk_eyebrow',
					'type'          => 'text',
					'default_value' => 'BUILT FOR UK',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_uk_headline_line_1',
					'label'         => 'Headline Line 1',
					'name'          => 'uk_headline_line_1',
					'type'          => 'text',
					'default_value' => 'Designed Around',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_uk_headline_line_2',
					'label'         => 'Headline Line 2',
					'name'          => 'uk_headline_line_2',
					'type'          => 'text',
					'default_value' => 'UK Accounting Workflows',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_uk_photo',
					'label'         => 'Background Photo',
					'name'          => 'uk_photo',
					'type'          => 'image',
					'instructions'  => 'The dark gradient fade over the bottom of this photo (for text readability) is CSS, not part of this image.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_UK_PHOTO_ID,
				),
				array(
					'key'          => 'field_snap_uk_cards',
					'label'        => 'Feature Cards',
					'name'         => 'uk_cards',
					'type'         => 'repeater',
					'instructions' => 'Shown as a 3-column grid (2 rows of 3). Add/remove/reorder rows to update without touching code.',
					'layout'       => 'table',
					'button_label' => 'Add Card',
					'min'          => 1,
					'default_value' => array(
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'UK VAT awareness' ),
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'Multi-rate VAT support' ),
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'Supplier statement matching' ),
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'CIS-ready processing' ),
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'HMRC-conscious workflows' ),
						array( 'field_snap_uk_card_icon' => SNAP_UK_ICON_CHECK_ID, 'field_snap_uk_card_title' => 'Accounting firm-focused automation' ),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_uk_card_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_uk_card_title',
							'label'    => 'Title',
							'name'     => 'title',
							'type'     => 'text',
							'required' => 1,
						),
					),
				),
				array(
					'key'           => 'field_snap_uk_statement_1',
					'label'         => 'Statement — Sentence 1',
					'name'          => 'uk_statement_1',
					'type'          => 'text',
					'instructions'  => 'e.g. "Snap wasn\'t adapted for UK accounting."',
					'default_value' => 'Snap wasn\'t adapted for UK accounting.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_uk_statement_2',
					'label'         => 'Statement — Sentence 2',
					'name'          => 'uk_statement_2',
					'type'          => 'text',
					'instructions'  => 'e.g. "It was built for it." Rendered bold/emphasized.',
					'default_value' => 'It was built for it.',
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
