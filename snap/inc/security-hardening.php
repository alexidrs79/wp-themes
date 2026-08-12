<?php
/**
 * WordPress-level security hardening. Config-only — no template, ACF, or
 * front-end behavior changes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Disable XML-RPC entirely. Confirmed no Jetpack, remote-publishing
 * tool, or XML-RPC usage anywhere in this theme before adding this.
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * 2. Hide the WordPress version number from the <head> generator meta tag
 * and from RSS/Atom feed generator tags. The `?ver=` query strings on
 * enqueued scripts/styles are deliberately left alone — they're the
 * theme's own filemtime()-based cache-busting (see theme-setup.php),
 * not WordPress core version disclosure, and stripping them would break
 * cache invalidation on future asset edits.
 */
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

/**
 * 3. Disable user enumeration.
 *
 * a) ?author=<id> style URLs: NOT handled here — Wordfence already blocks
 * this (Firewall > "Prevent WordPress from disclosing the login names of
 * users via /?author=N scans", wordfenceClass::preventAuthorNScans(),
 * gated by its own loginSec_disableAuthorScan setting). Confirmed active:
 * it hooks the 'request' filter and exit()s before this theme's own
 * hooks ever run, so a second implementation here would be dead code.
 *
 * b) Restrict the /wp/v2/users REST endpoint to logged-in requests.
 * Wordfence does not cover this route — confirmed no matching code in
 * its plugin source. No theme/ACF code depends on public REST user data.
 */
add_filter( 'rest_endpoints', 'snap_restrict_users_rest_endpoint' );
function snap_restrict_users_rest_endpoint( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'] );
		unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
}

/**
 * 4. Login rate-limiting: 5 failed attempts from one IP locks that IP out
 * of wp-login for 10 minutes. Custom + transient-based rather than
 * Wordfence's own brute-force module, because that module is installed
 * but its enable flag (loginSec_enableBruteForce) is currently OFF — so
 * there's no live conflict. If Wordfence's own login protection gets
 * turned on later, turn this off (or leave it; the two would just track
 * lockouts independently and redundantly, not break anything).
 */
/**
 * Hooked to wp_authenticate_user (not the earlier 'authenticate' filter)
 * because it runs right before the password is checked, and — unlike
 * most 'authenticate' callbacks — WordPress core immediately returns if
 * this filter yields a WP_Error (see wp_authenticate_username_password()
 * in wp-includes/user.php), so a lockout reliably wins over a correct
 * password rather than risking being overwritten by a later callback.
 */
add_filter( 'wp_authenticate_user', 'snap_check_login_lockout', 1, 1 );
function snap_check_login_lockout( $user ) {
	if ( get_transient( 'snap_login_lockout_' . md5( snap_get_client_ip() ) ) ) {
		return new WP_Error( 'snap_login_locked_out', __( 'Too many failed login attempts. Please try again in a few minutes.', 'snap' ) );
	}
	return $user;
}

add_action( 'wp_login_failed', 'snap_record_failed_login' );
function snap_record_failed_login() {
	$key      = 'snap_login_attempts_' . md5( snap_get_client_ip() );
	$attempts = (int) get_transient( $key ) + 1;
	set_transient( $key, $attempts, 10 * MINUTE_IN_SECONDS );

	if ( $attempts >= 5 ) {
		set_transient( 'snap_login_lockout_' . md5( snap_get_client_ip() ), 1, 10 * MINUTE_IN_SECONDS );
	}
}

add_action( 'wp_login', 'snap_clear_login_attempts' );
function snap_clear_login_attempts() {
	delete_transient( 'snap_login_attempts_' . md5( snap_get_client_ip() ) );
	delete_transient( 'snap_login_lockout_' . md5( snap_get_client_ip() ) );
}

function snap_get_client_ip() {
	foreach ( array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ) as $header ) {
		if ( empty( $_SERVER[ $header ] ) ) {
			continue;
		}
		$ip = trim( explode( ',', $_SERVER[ $header ] )[0] );
		if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
			return $ip;
		}
	}
	return '0.0.0.0';
}

/**
 * 5. Security headers. Added via PHP rather than .htaccess — this host
 * serves the site through nginx (confirmed via the Server response
 * header), which never reads .htaccess, so an Apache-only approach would
 * silently do nothing here. No iframe embedding of this site anywhere
 * (checked), so SAMEORIGIN is safe.
 */
add_action( 'send_headers', 'snap_add_security_headers' );
function snap_add_security_headers() {
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
