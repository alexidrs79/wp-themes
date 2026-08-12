<?php
/**
 * Core theme setup: supports, menus, assets.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function snap_theme_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support(
		'custom-logo',
		array(
			'width'       => 119,
			'height'      => 36,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

}
add_action( 'after_setup_theme', 'snap_theme_setup' );

/**
 * Allow SVG uploads through the Media Library — needed for the vector
 * wordmark logo. Restricted to admins to keep the door narrow.
 */
function snap_allow_svg_upload( $mimes ) {
	if ( ( defined( 'WP_CLI' ) && WP_CLI ) || current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'snap_allow_svg_upload' );

function snap_fix_svg_mime_type( $data, $file, $filename, $mimes ) {
	if ( ! empty( $data['ext'] ) ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );
	if ( 'svg' === $filetype['ext'] ) {
		$data['ext']             = 'svg';
		$data['type']             = 'image/svg+xml';
		$data['proper_filename'] = $filename;
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'snap_fix_svg_mime_type', 10, 4 );

function snap_enqueue_assets() {
	wp_enqueue_style(
		'snap-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;800&family=Inter:wght@400;500;600;700&family=Covered+By+Your+Grace&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'snap-style', get_stylesheet_uri(), array( 'snap-fonts' ), filemtime( get_stylesheet_directory() . '/style.css' ) );

	$cookieyes_css_path = get_template_directory() . '/assets/css/cookieyes-consent.css';
	if ( file_exists( $cookieyes_css_path ) ) {
		wp_enqueue_style( 'snap-cookieyes-consent', get_template_directory_uri() . '/assets/css/cookieyes-consent.css', array( 'snap-style' ), filemtime( $cookieyes_css_path ) );
	}

	$scroll_animations_path = get_template_directory() . '/assets/js/scroll-animations.js';
	wp_enqueue_script(
		'snap-scroll-animations',
		get_template_directory_uri() . '/assets/js/scroll-animations.js',
		array(),
		file_exists( $scroll_animations_path ) ? filemtime( $scroll_animations_path ) : null,
		true
	);

	$cta_demo_form_path = get_template_directory() . '/assets/js/cta-demo-form.js';
	wp_enqueue_script(
		'snap-cta-demo-form',
		get_template_directory_uri() . '/assets/js/cta-demo-form.js',
		array(),
		file_exists( $cta_demo_form_path ) ? filemtime( $cta_demo_form_path ) : null,
		true
	);

	$faq_accordion_path = get_template_directory() . '/assets/js/faq-accordion.js';
	wp_enqueue_script(
		'snap-faq-accordion',
		get_template_directory_uri() . '/assets/js/faq-accordion.js',
		array(),
		file_exists( $faq_accordion_path ) ? filemtime( $faq_accordion_path ) : null,
		true
	);

	$sticky_header_path = get_template_directory() . '/assets/js/sticky-header.js';
	wp_enqueue_script(
		'snap-sticky-header',
		get_template_directory_uri() . '/assets/js/sticky-header.js',
		array(),
		file_exists( $sticky_header_path ) ? filemtime( $sticky_header_path ) : null,
		true
	);

	$mobile_menu_path = get_template_directory() . '/assets/js/mobile-menu.js';
	wp_enqueue_script(
		'snap-mobile-menu',
		get_template_directory_uri() . '/assets/js/mobile-menu.js',
		array(),
		file_exists( $mobile_menu_path ) ? filemtime( $mobile_menu_path ) : null,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'snap_enqueue_assets' );

/**
 * Marks <html> as animate-ready as early as possible (before first paint),
 * so the CSS that hides [data-animate] elements is scoped to
 * `html.js-animate` rather than applying unconditionally. If JS is
 * disabled or scroll-animations.js fails to load, this class never gets
 * added, the hiding rule never matches, and every section just renders in
 * its final visible state — nothing can get stuck invisible.
 */
function snap_animate_ready_class() {
	echo '<script>document.documentElement.classList.add("js-animate");</script>' . "\n";
}
add_action( 'wp_head', 'snap_animate_ready_class', 0 );

/**
 * Prints an attachment as an <img>, given a media-defaults constant name.
 * Used by the "Real Usecases" row partial, which is included once per row
 * (a plain function def in that file would fatal on the 2nd include).
 *
 * The constant's value is either a literal attachment ID (legacy — only
 * portable if local and the deploy target happen to share the same media
 * library ID sequence, which they generally don't) or an uploads-relative
 * filename stem (e.g. "hero-scan-glyph"), resolved on THIS install via
 * `snap_get_attachment_id_by_filename()`. Prefer filename-stem constants
 * for anything added after this comment was written — see that function's
 * docblock for why: hardcoded IDs are what caused the hero icons to go
 * blank on live every time the theme's code redeployed there, even though
 * the files themselves were still present in that install's media library
 * the whole time, just under a different post ID.
 */
function snap_print_icon( $constant_name, $class ) {
	if ( ! defined( $constant_name ) ) {
		return;
	}
	$value         = constant( $constant_name );
	$attachment_id = is_numeric( $value ) ? (int) $value : snap_get_attachment_id_by_filename( $value );
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
 * Resolves a filename stem (no path, no extension — e.g. "hero-scan-glyph")
 * to whatever attachment ID actually owns a matching file on THIS install.
 *
 * Media-defaults.php's own numeric IDs are environment-specific: they're
 * only valid for the install they were captured against, because each
 * WordPress database assigns attachment IDs independently. Deploying the
 * *code* (this file, media-defaults.php) to another install — the normal
 * way theme changes reach the live site — carries the numeric constant
 * along, but not the matching database row, so it silently resolves to
 * nothing (or worse, a wrong, unrelated attachment) there. That's exactly
 * what happened to the hero section's scan-glyph/success-check icons: the
 * live database had the right files uploaded under IDs 124-127, but a
 * routine code deploy overwrote the live media-defaults.php back to this
 * theme's own 119-122, which don't exist on that install.
 *
 * A filename stem sidesteps this: as long as the uploaded file's base name
 * is the same on every install (something we control when uploading it,
 * unlike the numeric ID, which WordPress assigns automatically), this
 * lookup resolves to the correct attachment ID on whichever install the
 * code happens to be running on — local, live, or a future staging site —
 * with no code change or manual re-patch needed after each deploy. Matches
 * by LIKE rather than an exact path so it's also robust to the file living
 * in a different month's uploads folder or a different extension (e.g.
 * local's hero-scan-glyph.svg vs. live's hero-scan-glyph.png, uploaded on
 * a different date, after live's security plugin turned out to block SVG
 * uploads) — only the base filename actually needs to match.
 */
function snap_get_attachment_id_by_filename( $filename_stem ) {
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
 * "Talk to us", the header CTA button) into a real href. These fields are
 * a single text input rather than ACF's 'link'/'url' field types so
 * editors can type a same-page anchor like "/#meet-snap" — which needs
 * home_url() prefixing to work from any page, not just the landing page,
 * same reasoning as every other internal link in this build — while a
 * full external URL or a bare "#" placeholder passes through untouched.
 */
function snap_resolve_theme_url( $value ) {
	if ( empty( $value ) ) {
		return '#';
	}

	if ( '#' === $value || preg_match( '#^(https?:)?//#', $value ) ) {
		return $value;
	}

	return home_url( $value );
}
