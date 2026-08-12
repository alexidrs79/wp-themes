<?php
/**
 * WordPress itself only reads the 'site_icon' OPTION to generate favicon
 * markup (see wp_site_icon()) — an ACF image field alone has no effect on
 * the actual favicon. Mirroring the saved attachment ID into that option
 * on every save is what makes the Theme Settings favicon field real
 * rather than cosmetic. The admin menu page itself is registered by
 * acf_add_options_page() in inc/acf-fields-theme-settings.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/save_post', 'snap_sync_favicon_to_site_icon', 20 );

function snap_sync_favicon_to_site_icon( $post_id ) {
	if ( (string) $post_id !== (string) SNAP_THEME_SETTINGS_PAGE_ID ) {
		return;
	}

	$favicon_id = get_field( 'theme_favicon', $post_id );
	update_option( 'site_icon', $favicon_id ? $favicon_id : 0 );
}
