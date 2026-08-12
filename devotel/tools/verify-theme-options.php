<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Verify theme options helpers and header/footer wiring.
 *
 * Usage: php wp-content/themes/devotel/tools/verify-theme-options.php
 *
 * @package Devotel
 */

$wp_load = dirname( __DIR__, 4 ) . '/wp-load.php';
if ( ! file_exists( $wp_load ) ) {
	fwrite( STDERR, "Cannot find wp-load.php at {$wp_load}\n" );
	exit( 1 );
}

require_once $wp_load;

$failures = 0;

/**
 * @param bool   $ok      Pass state.
 * @param string $message Message.
 */
function devotel_verify_option_assert( $ok, $message ) {
	global $failures;
	echo ( $ok ? '  OK ' : ' BAD' ) . ' ' . $message . "\n";
	if ( ! $ok ) {
		++$failures;
	}
}

echo "=== Devotel Theme Options ===\n";

devotel_verify_option_assert( function_exists( 'devotel_get_theme_option' ), 'devotel_get_theme_option exists' );
devotel_verify_option_assert( function_exists( 'devotel_get_contact_defaults' ), 'devotel_get_contact_defaults exists' );
devotel_verify_option_assert( function_exists( 'devotel_replace_year_token' ), 'devotel_replace_year_token exists' );
devotel_verify_option_assert( function_exists( 'devotel_apply_header_theme_options' ), 'devotel_apply_header_theme_options exists' );
devotel_verify_option_assert( function_exists( 'devotel_apply_footer_theme_options' ), 'devotel_apply_footer_theme_options exists' );

$year_text = devotel_replace_year_token( '© {year} Devotel' );
devotel_verify_option_assert( str_contains( $year_text, (string) gmdate( 'Y' ) ), 'year token replacement' );

$acf_json = get_template_directory() . '/acf-json/group_devotel_theme_settings.json';
devotel_verify_option_assert( file_exists( $acf_json ), 'acf-json/group_devotel_theme_settings.json exists' );

if ( file_exists( $acf_json ) ) {
	$group = json_decode( (string) file_get_contents( $acf_json ), true );
	devotel_verify_option_assert( is_array( $group ) && ! empty( $group['fields'] ), 'theme settings field group parses' );
	$field_names = array();
	foreach ( $group['fields'] as $field ) {
		if ( ! empty( $field['name'] ) ) {
			$field_names[] = (string) $field['name'];
		}
	}
	devotel_verify_option_assert( in_array( 'devotel_site_tagline', $field_names, true ), 'devotel_site_tagline field defined' );
	devotel_verify_option_assert( in_array( 'devotel_footer_social_links', $field_names, true ), 'devotel_footer_social_links field defined' );
	devotel_verify_option_assert( ! in_array( 'devotel_footer_quick_links', $field_names, true ), 'removed dead devotel_footer_quick_links field' );
}

$header_sample = '<a href="https://devotel.com/contact-us/"><div class="header-talk-to-an-expert-wrapper"><div class="header-talk-to-an">Talk to an expert</div></div></a>';
$header_sample .= '<a href="https://devotel.com/contact-us/"><button class="mobile-menu-button-primary"><div class="mobile-menu-button-primary-text">Talk to an expert</div></button></a>';

if ( function_exists( 'update_field' ) ) {
	update_field( 'devotel_header_cta_text', 'Book a demo', 'option' );
	update_field( 'devotel_header_cta_url', home_url( '/contact-us/' ), 'option' );
}

$header_patched = devotel_apply_header_theme_options( $header_sample );
devotel_verify_option_assert( str_contains( $header_patched, 'Book a demo' ), 'header CTA text patches all instances' );
devotel_verify_option_assert( str_contains( $header_patched, esc_url( home_url( '/contact-us/' ) ) ), 'header CTA URL patches desktop + mobile' );

$footer_sample = '<div class="devotel-footer-description">' . devotel_get_default_site_tagline() . '</div>';
$footer_sample .= '<div class="devotel-footer-copyright">&copy; 2026 Devotel LTD. All rights reserved.</div>';
$footer_sample .= '<a href="https://esimora.com/">Esimora</a><a href="https://hub.devotel.com/#home">Devhub</a>';

if ( function_exists( 'update_field' ) ) {
	update_field( 'devotel_site_tagline', 'Custom footer tagline for verify.', 'option' );
	update_field( 'devotel_footer_copyright', '© {year} Verify Co.', 'option' );
	update_field(
		'devotel_footer_external_links',
		array(
			'esimora_url' => 'https://example.com/esimora',
			'devhub_url'  => 'https://example.com/devhub',
		),
		'option'
	);
}

$footer_patched = devotel_apply_footer_theme_options( $footer_sample );
devotel_verify_option_assert( str_contains( $footer_patched, 'Custom footer tagline for verify.' ), 'footer tagline override' );
devotel_verify_option_assert( str_contains( $footer_patched, 'Verify Co.' ), 'footer copyright with year token' );
devotel_verify_option_assert( str_contains( $footer_patched, 'https://example.com/esimora' ), 'footer esimora URL override' );
devotel_verify_option_assert( str_contains( $footer_patched, 'https://example.com/devhub' ), 'footer devhub URL override' );

$live_header = devotel_get_extracted_markup( 'header/site-header-html' );
devotel_verify_option_assert( '' !== $live_header, 'live header extract loads' );
devotel_verify_option_assert( str_contains( $live_header, 'Book a demo' ), 'live header reflects theme option CTA text' );

$live_footer = devotel_get_extracted_markup( 'footer/site-footer-html' );
devotel_verify_option_assert( '' !== $live_footer, 'live footer extract loads' );
devotel_verify_option_assert( str_contains( $live_footer, 'Custom footer tagline for verify.' ), 'live footer reflects theme option tagline' );

if ( function_exists( 'update_field' ) ) {
	update_field( 'devotel_header_cta_text', 'Talk to an expert', 'option' );
	update_field( 'devotel_header_cta_url', '', 'option' );
	update_field( 'devotel_site_tagline', devotel_get_default_site_tagline(), 'option' );
	update_field( 'devotel_footer_copyright', devotel_get_default_footer_copyright(), 'option' );
	update_field( 'devotel_footer_external_links', array(), 'option' );
}

echo $failures ? "\nFAILED: {$failures} check(s)\n" : "\nAll theme option checks passed.\n";
exit( $failures ? 1 : 0 );
