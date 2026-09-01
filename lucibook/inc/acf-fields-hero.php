<?php
/**
 * ACF field group: Hero section.
 * Figma: node 15532:88 ("Section 01 — Hero").
 *
 * The floating "Product Workspace" mockup (transaction list, hours-back
 * stat) and the 3 floating status labels are editable at the headline
 * level (stat value, label titles/descriptions) — the same scoping Snap
 * uses for its own dense mockup cards: real chrome text ("LUCIBOOK",
 * "This week", merchant names, statuses) stays static, matching a
 * screenshot of a real product rather than a CMS-driven data table.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_hero_field_group' );

function lucibook_register_hero_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_hero',
			'title'  => 'Hero Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_hero_headline',
					'label'         => 'Headline',
					'name'          => 'hero_headline',
					'type'          => 'textarea',
					'rows'          => 3,
					'instructions'  => 'One line per row.',
					'default_value' => "Accountancy software\nthat actually gives you\nyour hours back.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_hero_body',
					'label'         => 'Body',
					'name'          => 'hero_body',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => "Less categorising. Less reconciling. Less checking.\nMore hours back in your day.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_hero_cta_label',
					'label'         => 'CTA Label',
					'name'          => 'hero_cta_label',
					'type'          => 'text',
					'default_value' => 'Get your hours back →',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_hero_cta_url',
					'label'         => 'CTA URL',
					'name'          => 'hero_cta_url',
					'type'          => 'text',
					'default_value' => '/#founding-offer',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_hero_small_note',
					'label'         => 'Small Note',
					'name'          => 'hero_small_note',
					'type'          => 'text',
					'default_value' => 'One connected workspace for modern accountancy practices.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_hero_photo',
					'label'         => 'Photo',
					'name'          => 'hero_photo',
					'type'          => 'image',
					'return_format' => 'id',
					'default_value' => lucibook_get_attachment_id_by_filename( 'hero-photo' ),
				),
				array(
					'key'     => 'field_lb_hero_workspace_heading',
					'label'   => '',
					'name'    => 'hero_workspace_heading',
					'type'    => 'message',
					'message' => '<strong>Product Workspace mockup</strong> — chrome text (app name, period pill, merchant names, statuses) is fixed; only the stat and footer note below are editable.',
				),
				array(
					'key'           => 'field_lb_hero_hours_value',
					'label'         => 'Hours Back — Value',
					'name'          => 'hero_hours_value',
					'type'          => 'text',
					'default_value' => '6h 42m',
				),
				array(
					'key'           => 'field_lb_hero_footer_microcopy',
					'label'         => 'Workspace Footer Microcopy',
					'name'          => 'hero_footer_microcopy',
					'type'          => 'text',
					'default_value' => '3 items finished without opening another screen.',
				),
				array(
					'key'     => 'field_lb_hero_labels_heading',
					'label'   => '',
					'name'    => 'hero_labels_heading',
					'type'    => 'message',
					'message' => '<strong>Floating status labels</strong>',
				),
				array(
					'key'           => 'field_lb_hero_label_submission_title',
					'label'         => 'Label 1 — Title',
					'name'          => 'hero_label_submission_title',
					'type'          => 'text',
					'default_value' => 'Submission ready',
				),
				array(
					'key'           => 'field_lb_hero_label_submission_desc',
					'label'         => 'Label 1 — Description',
					'name'          => 'hero_label_submission_desc',
					'type'          => 'text',
					'default_value' => 'Everything checked and ready to go.',
				),
				array(
					'key'           => 'field_lb_hero_label_reconciled_title',
					'label'         => 'Label 2 — Title',
					'name'          => 'hero_label_reconciled_title',
					'type'          => 'text',
					'default_value' => 'Reconciled',
				),
				array(
					'key'           => 'field_lb_hero_label_reconciled_desc',
					'label'         => 'Label 2 — Description',
					'name'          => 'hero_label_reconciled_desc',
					'type'          => 'text',
					'default_value' => 'Accounts matched and up to date.',
				),
				array(
					'key'           => 'field_lb_hero_label_categorised_title',
					'label'         => 'Label 3 — Title',
					'name'          => 'hero_label_categorised_title',
					'type'          => 'text',
					'default_value' => 'Categorised',
				),
				array(
					'key'           => 'field_lb_hero_label_categorised_desc',
					'label'         => 'Label 3 — Description',
					'name'          => 'hero_label_categorised_desc',
					'type'          => 'text',
					'default_value' => 'Transactions sorted and ready.',
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
