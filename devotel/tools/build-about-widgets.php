<?php
require_once __DIR__ . '/_cli-only.php';
$theme = dirname( __DIR__ );
$html  = file_get_contents( 'https://devotel.com/about-us/' );
if ( ! $html ) {
	fwrite( STDERR, "fetch failed\n" );
	exit( 1 );
}
$lines   = explode( "\n", $html );
$desktop = implode( "\n", array_slice( $lines, 6689, 62 ) );
$mobile  = implode( "\n", array_slice( $lines, 6751, 56 ) );
$clean   = static function ( $chunk ) {
	$chunk = preg_replace( '/<span data-metadata="[^"]*"><\/span>/', '', $chunk );
	$chunk = preg_replace( '/<span data-buffer="[^"]*"><\/span>/', '', $chunk );
	return trim( $chunk );
};
$stats = '<div class="elementor elementor-12 devotel-stats-wrap">' . $clean( $desktop ) . "\n" . $clean( $mobile ) . '</div>';
file_put_contents(
	$theme . '/template-parts/extracted/about/widget-stats.php',
	"<?php\n/** about - stats band */\nif (!defined('ABSPATH')) exit;\n?>\n" . $stats . "\n"
);
echo 'stats: ' . strlen( $stats ) . "\n";

$cta = file_get_contents( $theme . '/template-parts/extracted/about/widget-7d33934.php' );
$cta = preg_replace( '/^\s*<\?php[\s\S]*?\?>\s*/', '', $cta );
$cta = str_replace( 'Talk to an expert', 'Contact Us', $cta );
$bottom = '<div class="elementor elementor-12"><div class="elementor-element elementor-element-1dd90da e-con-full e-flex e-con e-parent" data-id="1dd90da" data-element_type="container" data-e-type="container">' . trim( $cta ) . '</div></div>';
file_put_contents(
	$theme . '/template-parts/extracted/about/widget-bottom-cta.php',
	"<?php\n/** about - bottom CTA */\nif (!defined('ABSPATH')) exit;\n?>\n" . $bottom . "\n"
);
echo "bottom cta done\n";
