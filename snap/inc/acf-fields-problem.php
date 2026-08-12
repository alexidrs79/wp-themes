<?php
/**
 * ACF field group: The Problem section.
 * Figma: node 15150:1708 ("Frame 37").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_problem_field_group' );

function snap_register_problem_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_problem',
			'title'  => 'The Problem Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_problem_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'problem_eyebrow',
					'type'          => 'text',
					'instructions'  => 'e.g. "THE PROBLEM".',
					'required'      => 1,
					'default_value' => 'THE PROBLEM',
				),
				array(
					'key'           => 'field_snap_problem_headline_main',
					'label'         => 'Headline — Main',
					'name'          => 'problem_headline_main',
					'type'          => 'text',
					'instructions'  => 'e.g. "Accounting doesn\'t have a data problem."',
					'required'      => 1,
					'default_value' => 'Accounting doesn\'t have a data problem.',
				),
				array(
					'key'           => 'field_snap_problem_headline_accent',
					'label'         => 'Headline — Accent',
					'name'          => 'problem_headline_accent',
					'type'          => 'text',
					'instructions'  => 'e.g. "It has a document problem." Rendered in brand orange.',
					'required'      => 1,
					'default_value' => 'It has a document problem.',
				),
				array(
					'key'           => 'field_snap_problem_intro',
					'label'         => 'Intro Copy',
					'name'          => 'problem_intro',
					'type'          => 'textarea',
					'rows'          => 3,
					'required'      => 1,
					'default_value' => 'Every workflow starts with a document—and too many still depend on someone finding, reading, checking and re-keying it by hand.',
				),
				array(
					'key'           => 'field_snap_problem_photo',
					'label'         => 'Photo',
					'name'          => 'problem_photo',
					'type'          => 'image',
					'instructions'  => 'The orange frame peeking behind this photo is CSS, not part of this image.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_PROBLEM_PHOTO_ID,
				),
				array(
					'key'          => 'field_snap_problem_points',
					'label'        => 'Pain Points',
					'name'         => 'problem_points',
					'type'         => 'repeater',
					'instructions' => 'Rows shown as icon + label cards next to the photo. Add, remove, or reorder to update without touching code.',
					'layout'       => 'table',
					'button_label' => 'Add Pain Point',
					'min'          => 1,
					'default_value' => array(
						array(
							'field_snap_problem_point_icon'  => SNAP_PROBLEM_ICON_X_ID,
							'field_snap_problem_point_label' => 'Invoices arrive late',
						),
						array(
							'field_snap_problem_point_icon'  => SNAP_PROBLEM_ICON_X_ID,
							'field_snap_problem_point_label' => 'VAT gets coded incorrectly',
						),
						array(
							'field_snap_problem_point_icon'  => SNAP_PROBLEM_ICON_X_ID,
							'field_snap_problem_point_label' => 'Statements don\'t match',
						),
						array(
							'field_snap_problem_point_icon'  => SNAP_PROBLEM_ICON_X_ID,
							'field_snap_problem_point_label' => 'Reviews consume hours',
						),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_problem_point_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_problem_point_label',
							'label'    => 'Label',
							'name'     => 'label',
							'type'     => 'text',
							'required' => 1,
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
