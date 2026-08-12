<?php
/**
 * Template part: "Real Usecases" section.
 * Figma: node 15151:902 ("Frame 64"), 1440x2814, positioned at page y:6187.
 *
 * Duplicate/leftover layers resolved here (see inc/media-defaults.php for
 * the full writeup): each row's flat orange "backing" rectangle
 * (15150:1492/1493/1494/1495) is the same peeking-color-backing pattern
 * used everywhere else in this build, not a competing photo. Rows 1 and 3
 * additionally have 2-3 stacked candidate photos from design iteration —
 * only the last one in each layer list is visible; the earlier ones are
 * fully covered and unused.
 *
 * Two floating cards ("Monthly Profit" on Bookkeepers, "Expense Summary"
 * on SMEs) weren't in the original brief but are genuinely visible in
 * Figma's own rendered screenshot, so they're included.
 *
 * Each row is its own percentage-positioned box (matching the hero/Problem/
 * Meet Snap technique), sized to the union of that row's text block +
 * image cluster, container-relative (frame x:100 = container left edge on
 * a 1440px canvas, same as every prior section). Because the 4 rows are
 * NOT uniform (different image-cluster proportions, different card sets),
 * each row's percentages are its own — see style.css's
 * `.usecase-row--N` rules — rather than one shared ratio.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow        = get_field( 'ru_eyebrow' );
$headline_main  = get_field( 'ru_headline_main' );
$headline_accent = get_field( 'ru_headline_accent' );
$usecases       = get_field( 'ru_usecases' );
?>
<section class="usecases" id="usecases">
	<div class="usecases__inner container">
		<div class="usecases__heading" data-animate>
			<?php if ( $eyebrow ) : ?>
				<p class="usecases__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="usecases__headline">
				<span class="usecases__headline-orange"><?php echo esc_html( $headline_main ); ?></span>
				<br />
				<span class="usecases__headline-ink"><?php echo esc_html( $headline_accent ); ?></span>
			</h2>
		</div>

		<?php if ( $usecases ) : ?>
			<?php foreach ( $usecases as $index => $usecase ) : ?>
				<?php get_template_part( 'template-parts/usecase-row', null, array( 'usecase' => $usecase, 'index' => $index ) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
