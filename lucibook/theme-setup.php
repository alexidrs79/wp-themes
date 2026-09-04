<?php
/**
 * Core theme setup: supports, menus, assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lucibook_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support(
		'custom-logo',
		array(
			'width'       => 190,
			'height'      => 40,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'lucibook_theme_setup' );

/**
 * Allow SVG uploads through the Media Library — needed for the vector
 * wordmark logo and the many decorative line-art icons this design uses.
 * Restricted to admins to keep the door narrow.
 */
function lucibook_allow_svg_upload( $mimes ) {
	if ( ( defined( 'WP_CLI' ) && WP_CLI ) || current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'lucibook_allow_svg_upload' );

function lucibook_fix_svg_mime_type( $data, $file, $filename, $mimes ) {
	if ( ! empty( $data['ext'] ) ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );
	if ( 'svg' === $filetype['ext'] ) {
		$data['ext']             = 'svg';
		$data['type']            = 'image/svg+xml';
		$data['proper_filename'] = $filename;
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'lucibook_fix_svg_mime_type', 10, 4 );

function lucibook_enqueue_assets() {
	wp_enqueue_style(
		'lucibook-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'lucibook-style', get_stylesheet_uri(), array( 'lucibook-fonts' ), filemtime( get_stylesheet_directory() . '/style.css' ) );

	$scroll_animations_path = get_template_directory() . '/assets/js/scroll-animations.js';
	wp_enqueue_script(
		'lucibook-scroll-animations',
		get_template_directory_uri() . '/assets/js/scroll-animations.js',
		array(),
		file_exists( $scroll_animations_path ) ? filemtime( $scroll_animations_path ) : null,
		true
	);

	$sticky_header_path = get_template_directory() . '/assets/js/sticky-header.js';
	wp_enqueue_script(
		'lucibook-sticky-header',
		get_template_directory_uri() . '/assets/js/sticky-header.js',
		array(),
		file_exists( $sticky_header_path ) ? filemtime( $sticky_header_path ) : null,
		true
	);

	$mobile_menu_path = get_template_directory() . '/assets/js/mobile-menu.js';
	wp_enqueue_script(
		'lucibook-mobile-menu',
		get_template_directory_uri() . '/assets/js/mobile-menu.js',
		array(),
		file_exists( $mobile_menu_path ) ? filemtime( $mobile_menu_path ) : null,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'lucibook_enqueue_assets' );

/**
 * Marks <html> as animate-ready as early as possible (before first paint),
 * so the CSS that hides [data-animate] elements is scoped to
 * `html.js-animate` rather than applying unconditionally. If JS is
 * disabled or scroll-animations.js fails to load, this class never gets
 * added, the hiding rule never matches, and every section just renders in
 * its final visible state — nothing can get stuck invisible.
 */
function lucibook_animate_ready_class() {
	echo '<script>document.documentElement.classList.add("js-animate");</script>' . "\n";
}
add_action( 'wp_head', 'lucibook_animate_ready_class', 0 );

/**
 * Prints an attachment as an <img>, given a media-defaults constant name.
 *
 * The constant's value is either a literal attachment ID (only portable if
 * local and the deploy target happen to share the same media library ID
 * sequence, which they generally don't) or an uploads-relative filename
 * stem (e.g. "hero-orb"), resolved on THIS install via
 * `lucibook_get_attachment_id_by_filename()`. Always prefer the filename-
 * stem form for new constants — see that function's docblock for why:
 * a sibling theme (Snap) lost its hero icons to exactly this problem every
 * time its code redeployed to a different install than the one the
 * numeric IDs were captured against.
 */
function lucibook_print_icon( $constant_name, $class ) {
	if ( ! defined( $constant_name ) ) {
		return;
	}
	$value         = constant( $constant_name );
	$attachment_id = is_numeric( $value ) ? (int) $value : lucibook_get_attachment_id_by_filename( $value );
	if ( ! $attachment_id ) {
		return;
	}
	echo wp_get_attachment_image(
		$attachment_id,
		'full',
		false,
		array( 'class' => $class, 'alt' => '' )
	);
}

/**
 * Resolves a filename stem (no path, no extension — e.g. "hero-orb") to
 * whatever attachment ID actually owns a matching file on THIS install.
 *
 * Numeric attachment IDs are environment-specific: each WordPress database
 * assigns them independently, so a constant capturing one is only valid
 * against the install it was captured on. Deploying the *code* (this file,
 * media-defaults.php) to another install carries the numeric constant
 * along but not the matching database row, so it silently resolves to
 * nothing (or a wrong, unrelated attachment) there. A filename stem
 * sidesteps this: as long as the uploaded file's base name is the same on
 * every install (something we control when uploading it), this lookup
 * resolves correctly on whichever install the code happens to be running
 * on — local, live, or a future staging site — with no manual re-patch
 * needed after each deploy. Matches by LIKE so it's also robust to the
 * file living in a different month's uploads folder or extension.
 */
function lucibook_get_attachment_id_by_filename( $filename_stem ) {
	static $cache = array();

	if ( isset( $cache[ $filename_stem ] ) ) {
		return $cache[ $filename_stem ];
	}

	global $wpdb;
	$attachment_id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta}
			WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s
			ORDER BY post_id DESC LIMIT 1",
			'%' . $wpdb->esc_like( $filename_stem ) . '%'
		)
	);

	$cache[ $filename_stem ] = $attachment_id ? (int) $attachment_id : 0;
	return $cache[ $filename_stem ];
}

/**
 * Resolves a plain-text URL value from a Theme Settings field (nav items,
 * header CTA, etc.) into a real href. A single text input rather than
 * ACF's 'link'/'url' field types so editors can type a same-page anchor
 * like "/#pricing" — which needs home_url() prefixing to work from any
 * page — while a full external URL or a bare "#" placeholder passes
 * through untouched.
 */
function lucibook_resolve_theme_url( $value ) {
	if ( empty( $value ) ) {
		return '#';
	}

	if ( '#' === $value || preg_match( '#^(https?:)?//#', $value ) ) {
		return $value;
	}

	return home_url( $value );
}

/**
 * Wraps a trailing arrow ("→", "->", ">") in a button label with its own
 * span so CSS can nudge just the arrow on hover, independent of the rest
 * of the label — the arrow lives inline in the ACF field text (e.g. "Get
 * your hours back →"), not as a separate field, so this is the only way
 * to isolate it without a content/schema change. Already-escaped text in,
 * HTML out — call this around esc_html(), not instead of it.
 */
function lucibook_wrap_trailing_arrow( $escaped_label ) {
	return preg_replace(
		'/\s*(→|-&gt;|&gt;)\s*$/u',
		' <span class="btn__arrow">$1</span>',
		$escaped_label
	);
}
