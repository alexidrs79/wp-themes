<?php
/**
 * ACF field group: Reconciliation section.
 * Figma: node 15532:149 ("Section 03 — Reconciliation").
 *
 * The LuciCore mockup card itself (transaction table, statuses, buttons)
 * is dense screenshot-style decorative content, static like Snap's own
 * mockup cards — only the section's marketing copy is editable here.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'lucibook_register_reconciliation_field_group' );

function lucibook_register_reconciliation_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_lucibook_reconciliation',
			'title'  => 'Reconciliation Section',
			'fields' => array(
				array(
					'key'           => 'field_lb_rc_eyebrow',
					'label'         => 'Eyebrow',
					'name'          => 'rc_eyebrow',
					'type'          => 'text',
					'default_value' => 'LUCICORE',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_rc_headline',
					'label'         => 'Headline',
					'name'          => 'rc_headline',
					'type'          => 'textarea',
					'rows'          => 3,
					'instructions'  => 'One line per row.',
					'default_value' => "Reconcile everything\nwith one click.\nFinally.",
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_rc_body',
					'label'         => 'Body',
					'name'          => 'rc_body',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => 'No endless reviewing. No working through matches one by one. LuciCore is engineered specifically for reconciliation — so you can move from transactions to reconciled accounts in one flow.',
					'required'      => 1,
				),
				array(
					'key'           => 'field_lb_rc_closing',
					'label'         => 'Closing Line',
					'name'          => 'rc_closing',
					'type'          => 'text',
					'default_value' => 'Stop reviewing. Start reconciling.',
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
