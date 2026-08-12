<?php
/**
 * Template part: "Simple CTA" section — the Pricing page's closing CTA.
 *
 * A no-form variant of the landing page's CTA/Demo Form section
 * (template-parts/cta-demo-form.php): reuses that section's exact
 * background/ring treatment and headline styles (.cta-demo,
 * .cta-demo__glow, .cta-demo__ellipse--*, .cta-demo__headline, etc.)
 * rather than rebuilding the same asset/technique under new classes —
 * per explicit instruction to reuse, not duplicate, the visual system.
 * Only the content differs: a headline + single button instead of a
 * headline + email form, with its own copy and its own ACF field group
 * (pricing_cta_*, see inc/acf-fields-pricing-cta.php) so this stays
 * independently editable from the landing page's CTA.
 *
 * Button reuses the site-wide .btn / .btn-stack-hover hover-layer
 * pattern, linking to the Contact page by default.
 *
 * PLACEHOLDER CONTENT — flagged here and in the ACF admin UI, review
 * before launch: the headline, supporting copy, and button label.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logo_id         = get_field( 'pricing_cta_logo_mark' );
$headline_white  = get_field( 'pricing_cta_headline_white' );
$headline_ink    = get_field( 'pricing_cta_headline_ink' );
$supporting_copy = get_field( 'pricing_cta_supporting_copy' );
$button_label    = get_field( 'pricing_cta_button_label' );
$button_url      = get_field( 'pricing_cta_button_url' );

if ( ! $headline_white && ! $headline_ink ) {
	return;
}
?>
<section class="cta-demo cta-simple">
	<div class="cta-demo__glow" aria-hidden="true">
		<span class="cta-demo__ellipse cta-demo__ellipse--3"></span>
		<span class="cta-demo__ellipse cta-demo__ellipse--2"></span>
		<span class="cta-demo__ellipse cta-demo__ellipse--1"></span>
		<span class="cta-demo__ellipse cta-demo__ellipse--4"></span>
	</div>

	<div class="cta-demo__inner container">
		<?php if ( $logo_id ) : ?>
			<div class="cta-demo__logo" data-animate>
				<?php echo wp_get_attachment_image( $logo_id, 'full', false, array( 'class' => 'cta-demo__logo-img', 'alt' => 'Snap' ) ); ?>
			</div>
		<?php endif; ?>

		<h2 class="cta-demo__headline" data-animate>
			<span class="cta-demo__headline-white"><?php echo esc_html( $headline_white ); ?></span>
			<br />
			<span class="cta-demo__headline-ink"><?php echo esc_html( $headline_ink ); ?></span>
		</h2>

		<?php if ( $supporting_copy ) : ?>
			<p class="cta-demo__copy" data-animate><?php echo esc_html( $supporting_copy ); ?></p>
		<?php endif; ?>

		<?php if ( $button_label ) : ?>
			<div class="cta-simple__actions" data-animate>
				<span class="btn-stack-hover">
					<span class="btn__stack-back btn__stack-back--orange" aria-hidden="true"></span>
					<a class="btn btn--dark" href="<?php echo esc_url( $button_url ? $button_url : home_url( '/contact/' ) ); ?>">
						<span><?php echo esc_html( $button_label ); ?></span>
					</a>
				</span>
			</div>
		<?php endif; ?>
	</div>
</section>
