<?php
/**
 * ACF field group: "More Than OCR" section.
 * Figma: node 15150:1588 ("04 / More Than OCR").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_more_than_ocr_field_group' );

function snap_register_more_than_ocr_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_more_than_ocr',
			'title'  => 'More Than OCR Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_ocr_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'ocr_eyebrow',
					'type'          => 'text',
					'default_value' => 'MORE THAN OCR',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ocr_headline_main',
					'label'         => 'Headline — Main',
					'name'          => 'ocr_headline_main',
					'type'          => 'text',
					'default_value' => 'OCR reads text.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ocr_headline_accent',
					'label'         => 'Headline — Accent',
					'name'          => 'ocr_headline_accent',
					'type'          => 'text',
					'instructions'  => 'Rendered in brand orange.',
					'default_value' => 'Snap Understands Context.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ocr_supporting',
					'label'         => 'Supporting Copy',
					'name'          => 'ocr_supporting',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => 'Extraction is only useful when the result is correct, complete and ready for the next accounting decision.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ocr_left_title',
					'label'         => 'Left Column Title',
					'name'          => 'ocr_left_title',
					'type'          => 'text',
					'default_value' => 'Traditional OCR',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_ocr_left_items',
					'label'        => 'Left Column Items',
					'name'         => 'ocr_left_items',
					'type'         => 'repeater',
					'instructions' => 'The "Traditional OCR" limitations list.',
					'layout'       => 'table',
					'button_label' => 'Add Item',
					'min'          => 1,
					'default_value' => array(
						array( 'field_snap_ocr_left_item_icon' => SNAP_OCR_ICON_MINUS_ID, 'field_snap_ocr_left_item_label' => 'Reads characters' ),
						array( 'field_snap_ocr_left_item_icon' => SNAP_OCR_ICON_MINUS_ID, 'field_snap_ocr_left_item_label' => 'Extracts fields' ),
						array( 'field_snap_ocr_left_item_icon' => SNAP_OCR_ICON_MINUS_ID, 'field_snap_ocr_left_item_label' => 'Requires review' ),
						array( 'field_snap_ocr_left_item_icon' => SNAP_OCR_ICON_MINUS_ID, 'field_snap_ocr_left_item_label' => 'Finds numbers' ),
						array( 'field_snap_ocr_left_item_icon' => SNAP_OCR_ICON_MINUS_ID, 'field_snap_ocr_left_item_label' => 'Stops after capture' ),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_ocr_left_item_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_ocr_left_item_label',
							'label'    => 'Label',
							'name'     => 'label',
							'type'     => 'text',
							'required' => 1,
						),
					),
				),
				array(
					'key'           => 'field_snap_ocr_right_title',
					'label'         => 'Right Column Title',
					'name'          => 'ocr_right_title',
					'type'          => 'text',
					'default_value' => 'Snap',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_ocr_right_items',
					'label'        => 'Right Column Items',
					'name'         => 'ocr_right_items',
					'type'         => 'repeater',
					'instructions' => 'The "Snap" capabilities list.',
					'layout'       => 'table',
					'button_label' => 'Add Item',
					'min'          => 1,
					'default_value' => array(
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Understands accounting context' ),
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Identifies suppliers' ),
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Validates VAT treatment' ),
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Detects anomalies' ),
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Learns from accounting workflows' ),
						array( 'field_snap_ocr_right_item_icon' => SNAP_OCR_ICON_CHECK_ID, 'field_snap_ocr_right_item_label' => 'Prepares data for reconciliation' ),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_ocr_right_item_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_ocr_right_item_label',
							'label'    => 'Label',
							'name'     => 'label',
							'type'     => 'text',
							'required' => 1,
						),
					),
				),
				array(
					'key'           => 'field_snap_ocr_statement_old',
					'label'         => 'Statement — Old',
					'name'          => 'ocr_statement_old',
					'type'          => 'text',
					'instructions'  => 'e.g. "OCR extracts." Shown before the arrow.',
					'default_value' => 'OCR extracts.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ocr_statement_new',
					'label'         => 'Statement — New',
					'name'          => 'ocr_statement_new',
					'type'          => 'text',
					'instructions'  => 'e.g. "Snap understands." Shown after the arrow, rendered in brand orange.',
					'default_value' => 'Snap understands.',
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
