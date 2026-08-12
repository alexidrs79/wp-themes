<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * Extract About/Contact sections from production HTML into widget files.
 *
 * Usage: php tools/extract-production-sections.php
 *
 * @package Devotel
 */

$theme = dirname( __DIR__ );
$about_html   = file_get_contents( 'https://devotel.com/about-us/' );
$contact_html = file_get_contents( 'https://devotel.com/contact-us/' );

if ( ! $about_html || ! $contact_html ) {
	fwrite( STDERR, "Failed to fetch production pages.\n" );
	exit( 1 );
}

/**
 * Slice HTML between two markers (start inclusive).
 *
 * @param string $html Full HTML.
 * @param string $start_marker Substring to find start.
 * @param string $end_marker Substring to find end (exclusive).
 * @return string
 */
function slice_between( $html, $start_marker, $end_marker ) {
	$start = strpos( $html, $start_marker );
	if ( false === $start ) {
		return '';
	}
	$end = strpos( $html, $end_marker, $start + 1 );
	if ( false === $end ) {
		return '';
	}
	return substr( $html, $start, $end - $start );
}

/**
 * Balance-close a div opened at $open_pos in $html.
 *
 * @param string $html HTML string.
 * @param int    $open_pos Position of opening tag.
 * @return string
 */
function extract_balanced_div( $html, $open_pos ) {
	$depth = 0;
	$len   = strlen( $html );
	$i     = $open_pos;
	while ( $i < $len ) {
		if ( '<div' === substr( $html, $i, 4 ) ) {
			++$depth;
			$i += 4;
			continue;
		}
		if ( '</div>' === substr( $html, $i, 6 ) ) {
			--$depth;
			$i += 6;
			if ( 0 === $depth ) {
				return substr( $html, $open_pos, $i - $open_pos );
			}
			continue;
		}
		++$i;
	}
	return '';
}

/**
 * Write widget PHP file.
 *
 * @param string $path File path.
 * @param string $slug Widget slug comment.
 * @param string $html HTML content.
 */
function write_widget( $path, $slug, $html ) {
	$html = preg_replace( '/https:\/\/devotel\.com\//', '{{HOME}}/', $html );
	$html = preg_replace( '/\sdata-src="/i', ' src="', $html );
	$html = preg_replace( '/\slazyload\b/i', '', $html );
	$php  = "<?php\n/** {$slug} */\nif (!defined('ABSPATH')) exit;\n?>\n" . trim( $html ) . "\n";
	$php  = str_replace( '{{HOME}}/', 'https://devotel.com/', $php );
	file_put_contents( $path, $php );
	echo 'Wrote ' . basename( $path ) . ' (' . strlen( $html ) . " bytes)\n";
}

// --- Contact: desktop hero (9e6c16f) + mobile (bcde5de) ---
$contact_start = strpos( $contact_html, 'elementor-element-9e6c16f' );
$contact_start = strripos( substr( $contact_html, 0, $contact_start ), '<div' );
$mobile_start  = strpos( $contact_html, 'elementor-element-bcde5de', $contact_start );
$locations_start = strpos( $contact_html, 'elementor-element-e3241fe', $mobile_start );

$hero_desktop = extract_balanced_div( $contact_html, $contact_start );
$hero_mobile  = slice_between( $contact_html, 'elementor-element-bcde5de', 'elementor-element-e3241fe' );
$hero_mobile  = preg_replace( '/^[\s\S]*?<div/', '<div', $hero_mobile, 1 );
if ( $hero_mobile && '<div' === substr( trim( $hero_mobile ), 0, 4 ) ) {
	$ms = strpos( $contact_html, trim( preg_replace( '/^[\s\S]*?(<div class="elementor-element elementor-element-bcde5de)/', '$1', $hero_mobile ) ) );
}
// Re-extract mobile with balanced div
$mob_pos = strpos( $contact_html, '<div class="elementor-element elementor-element-bcde5de' );
$hero_mobile = $mob_pos ? extract_balanced_div( $contact_html, $mob_pos ) : '';

$contact_hero = '<div class="elementor elementor-21 devotel-contact-hero-wrap">' . "\n"
	. $hero_desktop . "\n"
	. $hero_mobile . "\n"
	. '</div>';

write_widget(
	$theme . '/template-parts/extracted/contact/widget-contact-hero.php',
	'contact - hero (9e6c16f + bcde5de)',
	$contact_hero
);

// Contact locations header (e3241fe only - map/cards are separate widgets)
$loc_pos = strpos( $contact_html, '<div class="elementor-element elementor-element-e3241fe' );
$locations_header = $loc_pos ? extract_balanced_div( $contact_html, $loc_pos ) : '';
write_widget(
	$theme . '/template-parts/extracted/contact/widget-locations-header.php',
	'contact - locations heading',
	'<div class="elementor elementor-21">' . $locations_header . '</div>'
);

// --- About sections ---
$about_page_start = strpos( $about_html, 'data-elementor-type="wp-page"' );
$about_page_start = strripos( substr( $about_html, 0, $about_page_start ), '<div' );

function about_slice( $html, $id, $next_id ) {
	$marker = 'elementor-element-' . $id;
	$start  = strpos( $html, $marker );
	if ( false === $start ) {
		return '';
	}
	$start = strripos( substr( $html, 0, $start ), '<div' );
	$chunk = extract_balanced_div( $html, $start );
	if ( '' === $chunk ) {
		return '';
	}

	if ( $next_id ) {
		$bleed = strpos( $chunk, 'elementor-element-' . $next_id );
		if ( false !== $bleed ) {
			$chunk = substr( $chunk, 0, $bleed );
		}
	}

	return $chunk;
}

// Hero: 7ee2817 + cb4f458 (through end of cb4f458 before 2c18098)
$hero7 = about_slice( $about_html, '7ee2817', '42a5b1c' );
$imgs  = about_slice( $about_html, 'cb4f458', '2c18098' );
write_widget(
	$theme . '/template-parts/extracted/about/widget-hero.php',
	'about - hero (7ee2817 + cb4f458)',
	'<div class="elementor elementor-12 devotel-about-hero-wrap">' . $hero7 . $imgs . '</div>'
);

// Intro: container 2c18098
$intro = about_slice( $about_html, '2c18098', '45848ad' );
write_widget(
	$theme . '/template-parts/extracted/about/widget-about-intro.php',
	'about - intro (Empowering...)',
	'<div class="elementor elementor-12">' . $intro . '</div>'
);

// Stats: 59be7c5 container (balanced extract; do not truncate by next id).
$stats = about_slice( $about_html, '59be7c5', '' );
write_widget(
	$theme . '/template-parts/extracted/about/widget-stats.php',
	'about - stats band',
	'<div class="elementor elementor-12">' . $stats . '</div>'
);

// Bottom CTA: 1dd90da parent with 7d33934 widget
$cta_pos = strpos( $about_html, '<div class="elementor-element elementor-element-1dd90da' );
$cta     = $cta_pos ? extract_balanced_div( $about_html, $cta_pos ) : about_slice( $about_html, '7d33934', '' );
write_widget(
	$theme . '/template-parts/extracted/about/widget-bottom-cta.php',
	'about - bottom CTA',
	'<div class="elementor elementor-12">' . $cta . '</div>'
);

echo "Done.\n";
