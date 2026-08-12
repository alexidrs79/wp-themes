<?php
/**
 * ACF field group: "Real Usecases" section.
 * Figma: node 15151:902 ("Frame 64").
 *
 * The 4 usecase rows share a common shape (icon, title, body, image, image
 * side) but each has a structurally different set of floating stat cards
 * (an invoice list, a donut chart, an entity list, etc.) — too different in
 * shape to model as one generic "card" repeater. Per row-specific content
 * lives as extra sub-fields on the same "usecases" repeater row instead;
 * the template picks which ones to render based on row index. Two spots
 * (the donut chart legend, the entity list) are genuinely list-shaped, so
 * those use nested repeaters.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_real_usecases_field_group' );

function snap_register_real_usecases_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_real_usecases',
			'title'  => 'Real Usecases Section',
			'fields' => array(
				array(
					'key'           => 'field_snap_ru_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'ru_eyebrow',
					'type'          => 'text',
					'default_value' => 'REAL USECASES',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ru_headline_main',
					'label'         => 'Headline — Main',
					'name'          => 'ru_headline_main',
					'type'          => 'text',
					'instructions'  => 'Rendered in brand orange.',
					'default_value' => 'Built for finance teams',
					'required'      => 1,
				),
				array(
					'key'           => 'field_snap_ru_headline_accent',
					'label'         => 'Headline — Accent',
					'name'          => 'ru_headline_accent',
					'type'          => 'text',
					'instructions'  => 'Rendered in ink.',
					'default_value' => 'with better things to do.',
					'required'      => 1,
				),
				array(
					'key'          => 'field_snap_ru_usecases',
					'label'        => 'Usecase Rows',
					'name'         => 'ru_usecases',
					'type'         => 'repeater',
					'instructions' => 'Exactly 4 rows expected, alternating image-left/image-right layout automatically by row order. Each row\'s floating stat cards use a fixed layout matched to that row\'s position (1st = invoice list, 2nd = expense chart, 3rd = receipt capture, 4th = entity list) — only the text/numbers inside are editable here, in the "Row N Cards" fields further down. Fields for other rows are simply unused on a given row.',
					'layout'       => 'block',
					'button_label' => 'Add Usecase',
					'min'          => 4,
					'max'          => 4,
					'sub_fields'   => array(
						array(
							'key'           => 'field_snap_ru_icon',
							'label'         => 'Icon Badge',
							'name'          => 'icon',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'thumbnail',
						),
						array(
							'key'      => 'field_snap_ru_title',
							'label'    => 'Title',
							'name'     => 'title',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'      => 'field_snap_ru_body',
							'label'    => 'Body Copy',
							'name'     => 'body',
							'type'     => 'textarea',
							'rows'     => 3,
							'required' => 1,
						),
						array(
							'key'           => 'field_snap_ru_image',
							'label'         => 'Main Image',
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
						array(
							'key'           => 'field_snap_ru_image_side',
							'label'         => 'Image Side',
							'name'          => 'image_side',
							'type'          => 'select',
							'choices'       => array(
								'left'  => 'Left',
								'right' => 'Right',
							),
							'default_value' => 'left',
							'required'      => 1,
						),

						// --- Row 1 (Accounting firms): invoice list + stat + 2 status badges ---
						array(
							'key'     => 'field_snap_ru_row1_heading',
							'label'   => '',
							'name'    => 'row1_heading',
							'type'    => 'message',
							'message' => '<strong>Row 1 Cards (Accounting firms)</strong> — only used when this row is 1st.',
						),
						array(
							'key'      => 'field_snap_ru_r1_invoice_title',
							'label'    => 'Invoice Card Title',
							'name'     => 'r1_invoice_title',
							'type'     => 'text',
						),
						array(
							'key'      => 'field_snap_ru_r1_invoices',
							'label'    => 'Invoice Rows',
							'name'     => 'r1_invoices',
							'type'     => 'repeater',
							'layout'   => 'table',
							'min'      => 0,
							'max'      => 3,
							'sub_fields' => array(
								array( 'key' => 'field_snap_ru_r1_invoice_id', 'label' => 'Invoice ID', 'name' => 'invoice_id', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r1_invoice_amount', 'label' => 'Amount', 'name' => 'amount', 'type' => 'text' ),
							),
						),
						array(
							'key'      => 'field_snap_ru_r1_stat_value',
							'label'    => 'Big Stat Value',
							'name'     => 'r1_stat_value',
							'type'     => 'text',
						),
						array(
							'key'      => 'field_snap_ru_r1_stat_label',
							'label'    => 'Big Stat Label',
							'name'     => 'r1_stat_label',
							'type'     => 'text',
						),
						array(
							'key'      => 'field_snap_ru_r1_badge_1',
							'label'    => 'Status Badge 1',
							'name'     => 'r1_badge_1',
							'type'     => 'text',
						),
						array(
							'key'      => 'field_snap_ru_r1_badge_2',
							'label'    => 'Status Badge 2',
							'name'     => 'r1_badge_2',
							'type'     => 'text',
						),

						// --- Row 2 (Bookkeepers): donut chart + reconciliation status + profit chart ---
						array(
							'key'     => 'field_snap_ru_row2_heading',
							'label'   => '',
							'name'    => 'row2_heading',
							'type'    => 'message',
							'message' => '<strong>Row 2 Cards (Bookkeepers)</strong> — only used when this row is 2nd.',
						),
						array(
							'key'  => 'field_snap_ru_r2_donut_title',
							'label' => 'Donut Card Title',
							'name' => 'r2_donut_title',
							'type' => 'text',
						),
						array(
							'key'        => 'field_snap_ru_r2_donut_legend',
							'label'      => 'Donut Legend',
							'name'       => 'r2_donut_legend',
							'type'       => 'repeater',
							'layout'     => 'table',
							'min'        => 0,
							'max'        => 4,
							'sub_fields' => array(
								array( 'key' => 'field_snap_ru_r2_legend_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r2_legend_percent', 'label' => 'Percent', 'name' => 'percent', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r2_legend_color', 'label' => 'Dot Color', 'name' => 'color', 'type' => 'color_picker' ),
							),
						),
						array(
							'key'  => 'field_snap_ru_r2_reconciliation_title',
							'label' => 'Reconciliation Title',
							'name' => 'r2_reconciliation_title',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r2_reconciliation_subtitle',
							'label' => 'Reconciliation Subtitle',
							'name' => 'r2_reconciliation_subtitle',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r2_profit_title',
							'label' => 'Profit Card Title',
							'name' => 'r2_profit_title',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r2_profit_value',
							'label' => 'Profit Value',
							'name' => 'r2_profit_value',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r2_profit_change',
							'label' => 'Profit Change',
							'name' => 'r2_profit_change',
							'type' => 'text',
						),

						// --- Row 3 (SMEs): receipt capture + expense summary + organized badge ---
						array(
							'key'     => 'field_snap_ru_row3_heading',
							'label'   => '',
							'name'    => 'row3_heading',
							'type'    => 'message',
							'message' => '<strong>Row 3 Cards (SMEs)</strong> — only used when this row is 3rd.',
						),
						array(
							'key'  => 'field_snap_ru_r3_receipt_title',
							'label' => 'Receipt Card Title',
							'name' => 'r3_receipt_title',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r3_receipt_total',
							'label' => 'Receipt Total',
							'name' => 'r3_receipt_total',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r3_receipt_status',
							'label' => 'Receipt Status Label',
							'name' => 'r3_receipt_status',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r3_expense_title',
							'label' => 'Expense Card Title',
							'name' => 'r3_expense_title',
							'type' => 'text',
						),
						array(
							'key'        => 'field_snap_ru_r3_expense_rows',
							'label'      => 'Expense Rows',
							'name'       => 'r3_expense_rows',
							'type'       => 'repeater',
							'layout'     => 'table',
							'min'        => 0,
							'max'        => 4,
							'sub_fields' => array(
								array( 'key' => 'field_snap_ru_r3_expense_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r3_expense_amount', 'label' => 'Amount', 'name' => 'amount', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r3_expense_percent', 'label' => 'Percent', 'name' => 'percent', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r3_expense_color', 'label' => 'Dot Color', 'name' => 'color', 'type' => 'color_picker' ),
							),
						),
						array(
							'key'  => 'field_snap_ru_r3_organized_badge',
							'label' => 'Organized Badge Text',
							'name' => 'r3_organized_badge',
							'type' => 'text',
						),

						// --- Row 4 (Multi-entity): entity list + documents synced + 2 status badges ---
						array(
							'key'     => 'field_snap_ru_row4_heading',
							'label'   => '',
							'name'    => 'row4_heading',
							'type'    => 'message',
							'message' => '<strong>Row 4 Cards (Multi-entity)</strong> — only used when this row is 4th.',
						),
						array(
							'key'  => 'field_snap_ru_r4_entity_title',
							'label' => 'Entity Card Title',
							'name' => 'r4_entity_title',
							'type' => 'text',
						),
						array(
							'key'        => 'field_snap_ru_r4_entities',
							'label'      => 'Entities',
							'name'       => 'r4_entities',
							'type'       => 'repeater',
							'layout'     => 'table',
							'min'        => 0,
							'max'        => 3,
							'sub_fields' => array(
								array( 'key' => 'field_snap_ru_r4_entity_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text' ),
								array( 'key' => 'field_snap_ru_r4_entity_status', 'label' => 'Status', 'name' => 'status', 'type' => 'text' ),
							),
						),
						array(
							'key'  => 'field_snap_ru_r4_synced_value',
							'label' => 'Documents Synced Value',
							'name' => 'r4_synced_value',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r4_synced_label',
							'label' => 'Documents Synced Label',
							'name' => 'r4_synced_label',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r4_centralized_label',
							'label' => 'Centralized Badge Text',
							'name' => 'r4_centralized_label',
							'type' => 'text',
						),
						array(
							'key'  => 'field_snap_ru_r4_synced_badge_label',
							'label' => 'Synced Badge Text',
							'name' => 'r4_synced_badge_label',
							'type' => 'text',
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
