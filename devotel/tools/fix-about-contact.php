<?php
require_once __DIR__ . '/_cli-only.php';
/**
 * One-off: truncate corrupted widgets and pull production CSS.
 * Run: php tools/fix-about-contact.php
 */

$theme = dirname( __DIR__ );

function truncate_file( $path, $needle ) {
	$c   = file_get_contents( $path );
	$pos = stripos( $c, $needle );
	if ( false === $pos ) {
		echo "needle not found: {$path}\n";
		return 0;
	}
	file_put_contents( $path, substr( $c, 0, $pos ) );
	return strlen( $c ) - $pos;
}

echo 'team removed: ' . truncate_file( $theme . '/template-parts/extracted/about/widget-6d9a1aa.php', 'class="elementor-element elementor-element-59be7c5' ) . "\n";
echo 'hero removed: ' . truncate_file( $theme . '/template-parts/extracted/about/widget-7d33934.php', '<footer' ) . "\n";
echo 'contact removed: ' . truncate_file( $theme . '/template-parts/extracted/contact/widget-88b8c88.php', '<footer' ) . "\n";

$about   = file_get_contents( 'https://devotel.com/about-us/' );
$contact = file_get_contents( 'https://devotel.com/contact-us/' );

$hero = $team = $fb = $form = $locs = '';

if ( preg_match( '/(\.cta-section-container[\s\S]{0,12000})/', $about, $m ) ) {
	$hero = $m[1];
}
if ( preg_match( '/(\.team-section-wrapper[\s\S]*?\.team-member-linkedin img[^}]*\})/', $about, $m ) ) {
	$team = $m[1];
}
if ( preg_match( '/(\.feature-boxes-wrapper[\s\S]*?\.feature-box-description[^}]*\})/', $about, $m ) ) {
	$fb = $m[1];
} elseif ( preg_match( '/(\.feature-boxes-wrapper[\s\S]*?\.feature-box:hover[^}]*\})/', $about, $m ) ) {
	$fb = $m[1];
}
if ( preg_match( '/(\.final-cta-form-wrapper\s*\{[\s\S]*?\.final-cta-form-wrapper \.wpcf7-submit[^}]*\})/', $contact, $m ) ) {
	$form = $m[1];
}
$telco = $theme . '/template-parts/extracted/products/telco/voice-solutions/section-main.php';
if ( strlen( $form ) < 8000 && file_exists( $telco ) ) {
	$t = file_get_contents( $telco );
	if ( preg_match( '/(\.final-cta-form-wrapper[\s\S]*?\.final-cta-form-wrapper \.wpcf7-response-output[\s\S]*?\})/', $t, $m ) ) {
		$form = $m[1];
	}
}
if ( preg_match( '/(\.card-10[\s\S]*?@media \(max-width:768px\)\{[^}]*\.bayway-locations-grid[^}]*\})/', $contact, $m ) ) {
	$locs = $m[1];
}
if ( preg_match( '/(@media \(max-width:768px\)\{\.bayway-locations[\s\S]*?\})/', $contact, $m ) ) {
	$locs = $m[0] . "\n" . $locs;
}
if ( preg_match_all( '/<style[^>]*>([\s\S]*?)<\/style>/i', $contact, $ms ) ) {
	foreach ( $ms[1] as $css ) {
		if ( stripos( $css, '.card-10' ) !== false && stripos( $css, '.bayway' ) !== false ) {
			$locs = $css . "\n" . $locs;
			break;
		}
	}
}

$hero_tailwind = <<<'CSS'
/* Hero section — replaces stripped Tailwind utilities (widget-7d33934) */
.devotel-about-page section.relative,
.devotel-about-page .devotel-about-hero {
	position: relative;
	width: 100%;
	min-height: 450px;
	overflow: hidden;
	background: linear-gradient(to right, #1e318a, #266df0);
}
.devotel-about-page .devotel-about-hero .content-wrapper {
	position: absolute;
	top: 50%;
	left: max(80px, calc((100% - 1440px) / 2 + 80px));
	transform: translateY(-50%);
	width: 647px;
	max-width: calc(100% - 160px);
	z-index: 10;
}
.devotel-about-page .devotel-about-hero .flex {
	display: flex;
	flex-direction: column;
	align-items: flex-start;
	gap: 32px;
}
.devotel-about-page .devotel-about-hero h2 {
	font-size: 48px;
	font-weight: 600;
	color: #fff;
	line-height: 60px;
	letter-spacing: -0.02em;
	margin: 0;
}
.devotel-about-page .devotel-about-hero .button2 {
	display: inline-flex;
	align-items: center;
	text-decoration: none;
	color: inherit;
}
.devotel-about-page .devotel-about-hero .icon {
	width: 20px;
	height: 20px;
	flex-shrink: 0;
}
@media (max-width: 1024px) {
	.devotel-about-page .devotel-about-hero .content-wrapper { left: 80px; }
}
@media (max-width: 768px) {
	.devotel-about-page .devotel-about-hero { min-height: 380px; }
	.devotel-about-page .devotel-about-hero h2 { font-size: 36px; line-height: 44px; }
	.devotel-about-page .devotel-about-hero .content-wrapper {
		left: 24px;
		max-width: calc(100% - 48px);
	}
}
CSS;

$dir = $theme . '/assets/css/pages';
if ( ! is_dir( $dir ) ) {
	mkdir( $dir, 0755, true );
}

$about_css = "/* About Us — production-derived */\n\n{$hero_tailwind}\n\n/* Hero container */\n{$hero}\n\n/* Feature boxes */\n{$fb}\n\n/* Team */\n{$team}\n";
file_put_contents( $dir . '/about.css', $about_css );

$contact_css = "/* Contact Us — production-derived */\n\n{$locs}\n\n{$form}\n";
file_put_contents( $dir . '/contact.css', $contact_css );

$shared = <<<'CSS'
/* Shared inner page fixes */
article.devotel-page {
	width: 100%;
	max-width: 100%;
}
article.devotel-page img {
	max-width: 100%;
	height: auto;
}
article.devotel-page .elementor-icon svg,
article.devotel-page .e-font-icon-svg {
	max-width: 48px;
	max-height: 48px;
	width: 1em;
	height: 1em;
}
.devotel-contact-page .w-full { width: 100%; }
.devotel-contact-page .bg-\[\#f9fafb\] { background: #f9fafb; }
.devotel-contact-page .py-24 { padding-top: 96px; padding-bottom: 96px; }
.devotel-contact-page .px-8 { padding-left: 32px; padding-right: 32px; }
.devotel-contact-page .flex { display: flex; }
.devotel-contact-page .flex-wrap { flex-wrap: wrap; }
.devotel-contact-page .items-center { align-items: center; }
.devotel-contact-page .justify-center { justify-content: center; }
.devotel-contact-page .gap-12 { gap: 48px; }
CSS;
file_put_contents( $dir . '/shared.css', $shared );

echo 'about.css: ' . strlen( $about_css ) . " bytes\n";
echo 'contact.css: ' . strlen( $contact_css ) . " bytes\n";
echo "done.\n";
