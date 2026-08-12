<?php
/**
 * ACF field group: Hero section.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_hero_field_group' );

function snap_register_hero_field_group() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_snap_hero',
			'title'    => 'Hero Section',
			'fields'   => array(
				array(
					'key'   => 'field_snap_hero_headline_line_1',
					'label' => 'Headline Line 1',
					'name'  => 'headline_line_1',
					'type'  => 'text',
					'instructions' => 'e.g. "Documents in."',
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_headline_line_2',
					'label' => 'Headline Line 2',
					'name'  => 'headline_line_2',
					'type'  => 'text',
					'instructions' => 'e.g. "Bookkeeping ready." Rendered in brand orange.',
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_supporting_copy',
					'label' => 'Supporting Copy',
					'name'  => 'supporting_copy',
					'type'  => 'textarea',
					'rows'  => 3,
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_primary_button',
					'label' => 'Primary Button',
					'name'  => 'primary_button',
					'type'  => 'link',
					'instructions' => 'e.g. "Book a demo". Rendered as the solid orange button.',
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_secondary_button',
					'label' => 'Secondary Button',
					'name'  => 'secondary_button',
					'type'  => 'link',
					'instructions' => 'e.g. "Watch product tour". Rendered as the outlined button.',
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_proof_title',
					'label' => 'Proof Title',
					'name'  => 'proof_title',
					'type'  => 'text',
					'instructions' => 'Small uppercase eyebrow line, e.g. "Built for the people behind the books."',
					'required' => 1,
				),
				array(
					'key'   => 'field_snap_hero_proof_copy',
					'label' => 'Proof Copy',
					'name'  => 'proof_copy',
					'type'  => 'text',
					'instructions' => 'e.g. "Fewer checks. Cleaner data. Faster closes."',
					'required' => 1,
				),
				array(
					'key'           => 'field_snap_hero_illustration_background',
					'label'         => 'Illustration — Anchor Photo',
					'name'          => 'hero_illustration_background',
					'type'          => 'image',
					'instructions'  => 'The photo behind the document stack (woman holding a phone). The thin orange frame around it is CSS, not part of this image.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HERO_ILLUSTRATION_BACKGROUND_ID,
				),
				array(
					'key'     => 'field_snap_hero_card_heading',
					'label'   => '',
					'name'    => 'hero_card_heading',
					'type'    => 'message',
					'message' => '<strong>Extracted Details Card</strong> — the floating card on the illustration (icon, title, and static row labels are fixed chrome; only the values below are editable).',
				),
				array(
					'key'           => 'field_snap_hero_card_supplier',
					'label'         => 'Supplier',
					'name'          => 'hero_card_supplier',
					'type'          => 'text',
					'default_value' => 'Office Central Ltd',
				),
				array(
					'key'           => 'field_snap_hero_card_date',
					'label'         => 'Date',
					'name'          => 'hero_card_date',
					'type'          => 'text',
					'default_value' => '12 May 2024',
				),
				array(
					'key'           => 'field_snap_hero_card_total',
					'label'         => 'Total',
					'name'          => 'hero_card_total',
					'type'          => 'text',
					'default_value' => '£850.00',
				),
				array(
					'key'           => 'field_snap_hero_card_vat',
					'label'         => 'VAT',
					'name'          => 'hero_card_vat',
					'type'          => 'text',
					'default_value' => '£141.67',
				),
				array(
					'key'           => 'field_snap_hero_card_category',
					'label'         => 'Category',
					'name'          => 'hero_card_category',
					'type'          => 'text',
					'default_value' => 'Office supplies',
				),
				array(
					'key'           => 'field_snap_hero_card_confidence',
					'label'         => 'Confidence',
					'name'          => 'hero_card_confidence',
					'type'          => 'text',
					'instructions'  => 'e.g. "98%".',
					'default_value' => '98%',
				),
				array(
					'key'     => 'field_snap_hero_doc_heading',
					'label'   => '',
					'name'    => 'hero_doc_heading',
					'type'    => 'message',
					'message' => '<strong>Receipt / Invoice Previews</strong> — the two small document mockups behind the scan icon. Titles, line placeholders, and labels are fixed chrome (matching the Real Usecases receipt card); only the total amounts below are editable.',
				),
				array(
					'key'           => 'field_snap_hero_receipt_total',
					'label'         => 'Receipt Total',
					'name'          => 'hero_receipt_total',
					'type'          => 'text',
					'default_value' => '£45.60',
				),
				array(
					'key'           => 'field_snap_hero_invoice_total',
					'label'         => 'Invoice Total',
					'name'          => 'hero_invoice_total',
					'type'          => 'text',
					'default_value' => '£850.00',
				),
				array(
					'key'           => 'field_snap_hero_illustration_connector_1',
					'label'         => 'Illustration — Connector (documents → scan icon)',
					'name'          => 'hero_illustration_connector_1',
					'type'          => 'image',
					'instructions'  => 'Dashed line from the document stack down to the scan icon.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HERO_ILLUSTRATION_CONNECTOR_1_ID,
				),
				array(
					'key'           => 'field_snap_hero_illustration_connector_2',
					'label'         => 'Illustration — Connector (card → status badge)',
					'name'          => 'hero_illustration_connector_2',
					'type'          => 'image',
					'instructions'  => 'Dashed line from the Extracted Details card to the status badge.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HERO_ILLUSTRATION_CONNECTOR_2_ID,
				),
				array(
					'key'           => 'field_snap_hero_illustration_dot_1',
					'label'         => 'Illustration — Dot Marker (documents end)',
					'name'          => 'hero_illustration_dot_1',
					'type'          => 'image',
					'instructions'  => 'Small ring marker at the document-stack end of connector 1.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HERO_ILLUSTRATION_DOT_1_ID,
				),
				array(
					'key'           => 'field_snap_hero_illustration_dot_2',
					'label'         => 'Illustration — Dot Marker (badge end)',
					'name'          => 'hero_illustration_dot_2',
					'type'          => 'image',
					'instructions'  => 'Small ring marker at the status-badge end of connector 2.',
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'default_value' => SNAP_HERO_ILLUSTRATION_DOT_2_ID,
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
