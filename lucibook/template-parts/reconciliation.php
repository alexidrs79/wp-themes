<?php
/**
 * Template part: Reconciliation section.
 * Figma: node 15532:149 ("Section 03 — Reconciliation").
 *
 * The right-side illustration is a single flattened mockup image
 * (668x647), not a layered composite of individual SVG elements.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'rc_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'rc_headline' ) ) ) );
$body     = get_field( 'rc_body' );
$closing  = get_field( 'rc_closing' );
?>
<section class="reconciliation">
	<div class="container reconciliation__inner">
		<div class="reconciliation__content" data-animate="fade">
			<p class="reconciliation__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h2 class="reconciliation__headline">
				<?php foreach ( $headline_lines as $line ) : ?>
					<span class="reconciliation__headline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</h2>
			<p class="reconciliation__body"><?php echo esc_html( $body ); ?></p>
			<p class="reconciliation__closing"><?php echo esc_html( $closing ); ?></p>
		</div>

		<div class="reconciliation__visual" data-animate="reveal">
			<?php lucibook_print_icon( 'LUCIBOOK_RC_MOCKUP_IMAGE_ID', 'reconciliation__mockup-image' ); ?>
		</div>
	</div>
</section>
