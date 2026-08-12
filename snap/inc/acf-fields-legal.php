<?php
/**
 * ACF field group: Legal pages (Privacy Policy, Terms of Service).
 *
 * Content lives in `legal_content` (WYSIWYG) rather than post_content —
 * matches every other page on this site being ACF-managed, not block-
 * editor-managed. The `legal_review_note` field is a `message` type,
 * which ACF only ever renders in wp-admin — it cannot appear on the
 * front end, by design, since it's a flag for whoever edits this page,
 * not visitor-facing content.
 *
 * IMPORTANT — the seeded WYSIWYG content on both pages is placeholder
 * legal text, not reviewed or approved by a solicitor. Do not treat it
 * as compliant as-is; have an actual UK legal advisor review both pages
 * before relying on them.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SNAP_PRIVACY_POLICY_PAGE_ID' ) ) {
	define( 'SNAP_PRIVACY_POLICY_PAGE_ID', 3 );
}

if ( ! defined( 'SNAP_TERMS_OF_SERVICE_PAGE_ID' ) ) {
	define( 'SNAP_TERMS_OF_SERVICE_PAGE_ID', 116 );
}

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

add_action( 'acf/init', 'snap_register_legal_field_group' );

function snap_register_legal_field_group() {
	acf_add_local_field_group(
		array(
			'key'    => 'group_snap_legal',
			'title'  => 'Legal Page Content',
			'fields' => array(
				array(
					'key'     => 'field_snap_legal_review_note',
					'label'   => 'Before you publish changes',
					'type'    => 'message',
					'message' => 'This content is placeholder legal text, not written or reviewed by a solicitor. Have a qualified UK legal advisor review this page before treating it as compliant. This note only ever shows here in wp-admin — visitors never see it.',
				),
				array(
					'key'           => 'field_snap_legal_last_updated',
					'label'         => 'Last Updated',
					'name'          => 'legal_last_updated',
					'type'          => 'date_picker',
					'display_format' => 'F j, Y',
					'return_format' => 'F j, Y',
					'instructions'  => 'Shown to visitors at the top of the page.',
				),
				array(
					'key'          => 'field_snap_legal_content',
					'label'        => 'Page Content',
					'name'         => 'legal_content',
					'type'         => 'wysiwyg',
					'tabs'         => 'all',
					'toolbar'      => 'full',
					'media_upload' => 0,
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => SNAP_PRIVACY_POLICY_PAGE_ID,
					),
				),
				array(
					array(
						'param'    => 'page',
						'operator' => '==',
						'value'    => SNAP_TERMS_OF_SERVICE_PAGE_ID,
					),
				),
			),
		)
	);
}
