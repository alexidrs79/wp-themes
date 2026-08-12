<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Seed theme snapshots + legacy CSS for SIM-based product subpages (Phase 6).
 *
 * Usage: php tools/seed-sim-subpage-extracts.php
 *
 * @package Devotel
 */

$theme_dir = dirname( __DIR__ );

$pages = array(
	'ota'                          => array(
		'id'  => 7796,
		'url' => 'https://devotel.com/products/sim-based/ota/',
	),
	'coverage-monitoring-platform' => array(
		'id'  => 8835,
		'url' => 'https://devotel.com/products/sim-based/coverage-monitoring-platform/',
	),
	'communication-platform'       => array(
		'id'  => 8717,
		'url' => 'https://devotel.com/products/sim-based/communication-platform/',
	),
	'otp'                          => array(
		'id'  => 8645,
		'url' => 'https://devotel.com/products/sim-based/otp/',
	),
);

/**
 * @param string $url Remote URL.
 * @return string
 */
function devotel_seed_fetch( $url ) {
	$context = stream_context_create(
		array(
			'http' => array(
				'timeout' => 60,
				'header'  => "User-Agent: DevotelThemeSeed/1.0\r\n",
			),
		)
	);
	$html = @file_get_contents( $url, false, $context );
	return is_string( $html ) ? $html : '';
}

/**
 * @param string $markup Raw markup.
 * @return string
 */
function devotel_seed_rewrite_urls( $markup ) {
	$replacements = array(
		'https://devotel.com' => 'http://devotel.local',
		'http://devotel.com'  => 'http://devotel.local',
		'//devotel.com'       => '//devotel.local',
	);
	return str_replace( array_keys( $replacements ), array_values( $replacements ), $markup );
}

foreach ( $pages as $slug => $config ) {
	$post_id  = (int) $config['id'];
	$uri_path = 'products/sim-based/' . $slug;

	echo "=== {$slug} ({$post_id}) ===\n";

	$html = devotel_seed_fetch( $config['url'] );
	if ( '' === trim( $html ) ) {
		fwrite( STDERR, "Failed to fetch page HTML for {$slug}\n" );
		exit( 1 );
	}

	$html = devotel_seed_rewrite_urls( $html );

	$snapshot_dir = $theme_dir . '/snapshots/' . $uri_path;
	if ( ! is_dir( $snapshot_dir ) ) {
		mkdir( $snapshot_dir, 0755, true );
	}
	$snapshot_file = $snapshot_dir . '/index.html';
	file_put_contents( $snapshot_file, $html );
	echo "Wrote snapshot: {$snapshot_file} (" . strlen( $html ) . " bytes)\n";

	$css_url  = 'https://devotel.com/wp-content/uploads/elementor/css/post-' . $post_id . '.css';
	$css      = devotel_seed_fetch( $css_url );
	if ( '' === trim( $css ) ) {
		fwrite( STDERR, "Failed to fetch legacy CSS for {$slug}\n" );
		exit( 1 );
	}
	$css = devotel_seed_rewrite_urls( $css );

	$legacy_dir = $theme_dir . '/assets/css/legacy';
	if ( ! is_dir( $legacy_dir ) ) {
		mkdir( $legacy_dir, 0755, true );
	}
	$legacy_file = $legacy_dir . '/post-' . $post_id . '.css';
	file_put_contents( $legacy_file, $css );
	echo "Wrote legacy CSS: {$legacy_file} (" . strlen( $css ) . " bytes)\n";

	$extract_dir = $theme_dir . '/template-parts/extracted/' . $uri_path;
	if ( ! is_dir( $extract_dir ) ) {
		mkdir( $extract_dir, 0755, true );
	}

	$section_main = $extract_dir . '/section-main.php';
	if ( ! is_readable( $section_main ) ) {
		$php = <<<PHP
<?php
/** {$uri_path} extracted from WPO cache / production */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\$markup = devotel_get_product_subpage_snapshot_extract_markup( '{$uri_path}', {$post_id} );
if ( '' !== trim( \$markup ) ) {
	echo \$markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

PHP;
		file_put_contents( $section_main, $php );
		echo "Wrote section-main.php\n";
	} else {
		echo "section-main.php already exists\n";
	}
}

echo "Done.\n";
