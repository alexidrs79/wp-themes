<?php
/**
 * Template part: "CTA / Demo Form" section.
 * Figma: node 15150:2028 ("Frame 3"), 1440x614, full-bleed (not
 * container-constrained) — content is centered on the full 1440px width
 * (headline/form center at x=720, exactly half), not the 1240px .container.
 *
 * Background: 4 concentric circle OUTLINES (not a filled radial glow) —
 * confirmed by downloading the actual SVG assets: each is a `fill:none`
 * circle with a black stroke at stroke-opacity:0.5, and the 4 elements'
 * own opacities are 0.5/0.3/0.1/0.5. Built as plain CSS (absolutely
 * positioned, bordered, border-radius:50% spans) rather than SVG/image
 * assets or a CSS radial-gradient — a gradient can't reproduce discrete
 * ring edges, and 4 tiny bordered divs are cheaper than 4 image requests.
 * 3 of the 4 share the exact same center point (719.5, 148.5); the 4th
 * (Ellipse 3) is close (720.5, 137.5) — all four are centered at ~50%
 * horizontally and a shared fixed vertical reference point here, since a
 * width-relative CSS `top` isn't expressible without a square aspect
 * parent, and the sub-11px difference is invisible at this opacity.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logo_id         = get_field( 'cta_logo_mark' );
$headline_white  = get_field( 'cta_headline_white' );
$headline_ink    = get_field( 'cta_headline_ink' );
$supporting_copy = get_field( 'cta_supporting_copy' );
?>
<section class="cta-demo">
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

		<div class="cta-demo__form" data-animate>
			<?php echo do_shortcode( '[contact-form-7 id="99" title="CTA Demo Form"]' ); ?>
		</div>
	</div>
</section>
