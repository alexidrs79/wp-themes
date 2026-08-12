<?php
/**
 * ACF field group: Meet Snap section.
 * Figma: node 15150:1666 ("Frame 38").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_meet_snap_field_group' );

function snap_register_meet_snap_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_meet_snap',
			'title'  => 'Meet Snap Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_meet_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'meet_eyebrow',
					'type'          => 'text',
					'instructions'  => 'e.g. "MEET SNAP".',
					'required'      => 1,
					'default_value' => 'MEET SNAP',
				),
				array(
					'key'           => 'field_snap_meet_heading_main',
					'label'         => 'Heading — Main',
					'name'          => 'meet_heading_main',
					'type'          => 'text',
					'instructions'  => 'First line, e.g. "One intelligent route".',
					'required'      => 1,
					'default_value' => 'One intelligent route',
				),
				array(
					'key'           => 'field_snap_meet_heading_accent',
					'label'         => 'Heading — Accent',
					'name'          => 'meet_heading_accent',
					'type'          => 'text',
					'instructions'  => 'Second line, e.g. "from paperwork to prepared data." Rendered in brand orange.',
					'required'      => 1,
					'default_value' => 'from paperwork to prepared data.',
				),
				array(
					'key'           => 'field_snap_meet_intro',
					'label'         => 'Intro Copy',
					'name'          => 'meet_intro',
					'type'          => 'textarea',
					'rows'          => 2,
					'required'      => 1,
					'default_value' => 'Snap sits between your documents and accounting systems, removing the manual work in between.',
				),
				array(
					'key'           => 'field_snap_meet_photo',
					'label'         => 'Illustration Photo',
					'name'          => 'meet_photo',
					'type'          => 'image',
					'instructions'  => 'The orange card behind this photo is CSS, not part of this image. The photo is intentionally taller than the orange card and overlaps its top/bottom edges — matches Figma, not a bug.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_MEET_PHOTO_ID,
				),
				array(
					'key'          => 'field_snap_meet_steps',
					'label'        => 'Steps',
					'name'         => 'meet_steps',
					'type'         => 'repeater',
					'instructions' => 'Exactly 4 rows expected — each row renders in one of 4 fixed, staggered card positions (in row order) matching the Figma layout. Reorder rows to move content between slots; editing card position/size requires a code change.',
					'layout'       => 'block',
					'button_label' => 'Add Step',
					'min'          => 4,
					'max'          => 4,
					'default_value' => array(
						array(
							'field_snap_meet_step_icon'  => SNAP_MEET_ICON_CAPTURE_ID,
							'field_snap_meet_step_number' => '1. Capture',
							'field_snap_meet_step_body'  => 'Upload your invoice from desktop, forward by email, or snap a photo in seconds with the app',
						),
						array(
							'field_snap_meet_step_icon'  => SNAP_MEET_ICON_EXTRACT_ID,
							'field_snap_meet_step_number' => '2. Extract',
							'field_snap_meet_step_body'  => 'Let our AI read every key fields and line item with 99%+ accuracy',
						),
						array(
							'field_snap_meet_step_icon'  => SNAP_MEET_ICON_REVIEW_ID,
							'field_snap_meet_step_number' => '3. Review',
							'field_snap_meet_step_body'  => 'Edit, approve, and collaborate with full version history',
						),
						array(
							'field_snap_meet_step_icon'  => SNAP_MEET_ICON_EXPORT_ID,
							'field_snap_meet_step_number' => '4. Export',
							'field_snap_meet_step_body'  => 'Export to Xero, QuickBooks, or any system via CSV or API, instantly',
						),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_meet_step_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'          => 'field_snap_meet_step_number',
							'label'        => 'Number + Title',
							'name'         => 'number',
							'type'         => 'text',
							'instructions' => 'e.g. "1. Capture" — shown in the pill.',
							'required'     => 1,
						),
						array(
							'key'      => 'field_snap_meet_step_body',
							'label'    => 'Body Copy',
							'name'     => 'body',
							'type'     => 'textarea',
							'rows'     => 3,
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
