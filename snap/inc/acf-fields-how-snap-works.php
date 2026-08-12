<?php
/**
 * ACF field group: "How Snap Works" section.
 * Figma: node 15150:1803 ("Frame 55").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_how_snap_works_field_group' );

function snap_register_how_snap_works_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_how_snap_works',
			'title'  => 'How Snap Works Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_hsw_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'hsw_eyebrow',
					'type'          => 'text',
					'default_value' => 'HOW SNAP WORKS',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_hsw_headline_main',
					'label'         => 'Headline — Main',
					'name'          => 'hsw_headline_main',
					'type'          => 'text',
					'instructions'  => 'Rendered in brand orange.',
					'default_value' => 'One clean flow.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_hsw_headline_accent',
					'label'         => 'Headline — Accent',
					'name'          => 'hsw_headline_accent',
					'type'          => 'text',
					'instructions'  => 'Rendered in ink (not orange) — reversed from most other sections, confirmed against Figma.',
					'default_value' => 'Zero busywork.',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_hsw_steps',
					'label'        => 'Timeline Steps',
					'name'         => 'hsw_steps',
					'type'         => 'repeater',
					'instructions' => 'Exactly 4 rows expected — shown as a 4-step horizontal timeline connected by lines. Icon, step number, title, body.',
					'layout'       => 'block',
					'button_label' => 'Add Step',
					'min'          => 4,
					'max'          => 4,
					'default_value' => array(
						array(
							'field_snap_hsw_step_icon'   => SNAP_HSW_ICON_UPLOAD_ID,
							'field_snap_hsw_step_number' => '1',
							'field_snap_hsw_step_title'  => 'Upload',
							'field_snap_hsw_step_body'   => 'Any financial document',
						),
						array(
							'field_snap_hsw_step_icon'   => SNAP_HSW_ICON_UNDERSTAND_ID,
							'field_snap_hsw_step_number' => '2',
							'field_snap_hsw_step_title'  => 'Understand',
							'field_snap_hsw_step_body'   => 'Classify and interpret',
						),
						array(
							'field_snap_hsw_step_icon'   => SNAP_HSW_ICON_VALIDATE_ID,
							'field_snap_hsw_step_number' => '3',
							'field_snap_hsw_step_title'  => 'Validate',
							'field_snap_hsw_step_body'   => 'VAT, suppliers, errors',
						),
						array(
							'field_snap_hsw_step_icon'   => SNAP_HSW_ICON_DELIVER_ID,
							'field_snap_hsw_step_number' => '4',
							'field_snap_hsw_step_title'  => 'Deliver',
							'field_snap_hsw_step_body'   => 'To the tools you use',
						),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_hsw_step_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_hsw_step_number',
							'label'    => 'Number',
							'name'     => 'number',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'      => 'field_snap_hsw_step_title',
							'label'    => 'Title',
							'name'     => 'title',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'      => 'field_snap_hsw_step_body',
							'label'    => 'Body',
							'name'     => 'body',
							'type'     => 'text',
							'required' => 1,
						),
					),
				),
				array(
					'key'           => 'field_snap_hsw_bg_photo',
					'label'         => 'Integration Strip — Background Photo',
					'name'          => 'hsw_bg_photo',
					'type'          => 'image',
					'instructions'  => 'Full-width photo behind the integration strip; a dark gradient fade (CSS, not part of this image) sits over the left half for text readability.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HSW_BG_PHOTO_ID,
				),
				array(
					'key'           => 'field_snap_hsw_subject_cutout',
					'label'         => 'Integration Strip — Subject Cutout',
					'name'          => 'hsw_subject_cutout',
					'type'          => 'image',
					'instructions'  => 'Transparent cutout of the same subject as the background photo, layered on top so they stay sharp despite the gradient dimming the background behind them.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HSW_SUBJECT_CUTOUT_ID,
				),
				array(
					'key'           => 'field_snap_hsw_copy_line_1',
					'label'         => 'Integration Copy — Line 1',
					'name'          => 'hsw_copy_line_1',
					'type'          => 'text',
					'default_value' => 'From document',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_hsw_copy_line_2',
					'label'         => 'Integration Copy — Line 2',
					'name'          => 'hsw_copy_line_2',
					'type'          => 'text',
					'default_value' => 'to your tools.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_hsw_copy_accent',
					'label'         => 'Integration Copy — Accent Word',
					'name'          => 'hsw_copy_accent',
					'type'          => 'text',
					'instructions'  => 'Rendered in orange with a hand-drawn underline, e.g. "Automatically."',
					'default_value' => 'Automatically.',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_hsw_integrations',
					'label'        => 'Integration Logos',
					'name'         => 'hsw_integrations',
					'type'         => 'repeater',
					'instructions' => 'Small logo row shown under the integration copy.',
					'layout'       => 'table',
					'button_label' => 'Add Integration',
					'min'          => 1,
					'default_value' => array(
						array( 'field_snap_hsw_integration_icon' => SNAP_HSW_INTEGRATION_XERO_ID, 'field_snap_hsw_integration_name' => 'Xero', 'field_snap_hsw_integration_show_initials' => 0 ),
						array( 'field_snap_hsw_integration_icon' => SNAP_HSW_INTEGRATION_QB_ID, 'field_snap_hsw_integration_name' => 'QuickBooks', 'field_snap_hsw_integration_show_initials' => 0 ),
						array( 'field_snap_hsw_integration_icon' => SNAP_HSW_INTEGRATION_LB_ID, 'field_snap_hsw_integration_name' => 'LB', 'field_snap_hsw_integration_show_initials' => 1 ),
					),
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_hsw_integration_icon',
							'label'         => 'Icon',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_hsw_integration_name',
							'label'    => 'Name',
							'name'     => 'name',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'           => 'field_snap_hsw_integration_show_initials',
							'label'         => 'Show name as text on icon',
							'name'          => 'show_initials',
							'type'          => 'true_false',
							'instructions'  => 'Off for real brand logos with the wordmark baked into the icon (Xero, QuickBooks). On for a plain circle placeholder that needs the name/initials overlaid as text (e.g. "LB").',
							'ui'            => 1,
							'default_value' => 0,
						),
					),
				),
				array(
					'key'           => 'field_snap_hsw_badge_text',
					'label'         => 'Badge Text',
					'name'          => 'hsw_badge_text',
					'type'          => 'text',
					'instructions'  => 'e.g. "UK-Ready", shown next to the flag icon.',
					'default_value' => 'UK-Ready',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_hsw_badge_icon',
					'label'         => 'Badge Icon',
					'name'          => 'hsw_badge_icon',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'thumbnail',
					'default_value' => SNAP_HSW_UK_FLAG_ID,
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
