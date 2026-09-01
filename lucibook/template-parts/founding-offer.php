<?php
/**
 * Template part: Founding Offer section.
 * Figma: node 15532:564 ("Section 07 — Founding Offer").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'fo_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'fo_headline' ) ) ) );
$body_paras = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'fo_body' ) ) ) );
$signup_title = get_field( 'fo_signup_title' );
$email_placeholder = get_field( 'fo_email_placeholder' );
$claim_label = get_field( 'fo_claim_label' );
$small_print = get_field( 'fo_small_print' );
$bottom_note = get_field( 'fo_bottom_note' );
?>
<section class="founding-offer" id="founding-offer">
	<div class="container">
		<div class="founding-offer__panel">
			<?php lucibook_print_icon( 'LUCIBOOK_FO_SUNBURST_ID', 'founding-offer__sunburst' ); ?>

			<div class="founding-offer__content" data-animate>
				<p class="founding-offer__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
				<h2 class="founding-offer__headline">
					<?php foreach ( $headline_lines as $line ) : ?>
						<span class="founding-offer__headline-line"><?php echo esc_html( $line ); ?></span>
					<?php endforeach; ?>
				</h2>
				<div class="founding-offer__body">
					<?php foreach ( $body_paras as $para ) : ?>
						<p><?php echo esc_html( $para ); ?></p>
					<?php endforeach; ?>
				</div>

				<div class="founding-offer__brand">
					<?php lucibook_print_icon( 'LUCIBOOK_FO_LOGO_WHITE_ID', 'founding-offer__brand-logo' ); ?>
				</div>
				<p class="founding-offer__bottom-note"><?php echo esc_html( $bottom_note ); ?></p>
			</div>

			<div class="founding-offer__signup" data-animate>
				<p class="founding-offer__signup-title"><?php echo esc_html( $signup_title ); ?></p>
				<form class="founding-offer__form" onsubmit="return false;">
					<input type="email" class="founding-offer__email" placeholder="<?php echo esc_attr( $email_placeholder ); ?>">
					<button type="submit" class="btn btn--primary founding-offer__claim-btn">
						<?php echo esc_html( $claim_label ); ?>
					</button>
				</form>
				<p class="founding-offer__small-print"><?php echo esc_html( $small_print ); ?></p>
			</div>
		</div>
	</div>
</section>
