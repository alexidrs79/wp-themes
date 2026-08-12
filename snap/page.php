<?php
/**
 * Default template for standard WordPress Pages (post_type=page with no
 * page-templates/ file assigned) — Privacy Policy and Terms of Service
 * use this. Simple single-column text layout: site header/footer, page
 * title, "Last updated" line, and the ACF WYSIWYG legal content field.
 * Deliberately has none of the card/section apparatus the page-templates/
 * marketing pages use — this is prose, not a landing page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

get_template_part( 'template-parts/legal-page' );

get_footer();
