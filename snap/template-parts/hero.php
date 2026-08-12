<?php
/**
 * Template part: Hero section.
 * Figma: nodes 15150:1576-1587 (headline/copy/actions/proof, direct children
 * of the page root) plus the illustration nodes 15150:1499-1796.
 *
 * The receipt/invoice previews, the Extracted Details card, the scan icon,
 * and the "Ready for bookkeeping" badge (nodes 15150:1527, 15150:1537,
 * 15150:1505, 15150:1792, 15150:1796) were previously flattened raster
 * mockups (receipt-15x-noborder.png etc.) — real text/lines/borders baked
 * into pixels, which is why border-radius fixes on them never held (you
 * can't CSS-fix the corner of a static image file). They're now real
 * HTML/CSS, built from `get_design_context` on each node individually
 * (exact text, colors, fonts, positions) — same technique as the Real
 * Usecases row cards: each floating item is a `container-type: inline-size`
 * host box (position/size unchanged from before — the existing container-
 * relative percentages below were re-confirmed against the same node
 * geometry and didn't need to move) wrapping a fixed-native-px inner card
 * that's scaled as one rigid unit via
 * `transform: scale(calc(100cqw / <native-width>px))`, so every literal px
 * value from Figma (font sizes, line thicknesses, border radii) scales
 * fluidly with zero reflow. See the `.hero__receipt` / `.hero__invoice` /
 * `.hero__card` / `.hero__badge` / `.hero__scan-icon-inner` rules in
 * style.css. Only 4 small glyphs (scan glyph, sparkles, confidence check,
 * success check) remain real media-library icon assets — everything else
 * (card chrome, backgrounds, borders, static labels, line placeholders) is
 * plain markup.
 *
 * The main photo (15150:1501) is unaffected — already a real <img> with a
 * working corner-radius fix. Nodes 15150:1499/1500 are NOT duplicates of it:
 * 1499 is the flat orange backdrop (`.hero__illustration-backdrop`, already
 * CSS — it has an unused, fully-covered leftover image layer underneath
 * that never renders) and 1500 is a genuinely different, unused candidate
 * photo from an earlier design pass (confirmed via design context: a
 * different generated photo entirely). Neither needed any change.
 *
 * The dashed connectors (15150:1503, 15150:1504) and dot markers
 * (15150:1801, 15150:1802) are true vector SVG exports (real path data, not
 * a CSS approximation) — re-confirmed via design context, unchanged.
 *
 * The solid-orange backdrop (15150:1499) and the small orange card backing
 * behind the receipt (15150:1502) are flat, unshadowed color fills with
 * nothing photographic in them, so those two are plain CSS divs rather than
 * images — nothing is lost by not routing a solid color swatch through the
 * Media Library.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline_line_1  = get_field( 'headline_line_1' );
$headline_line_2  = get_field( 'headline_line_2' );
$supporting_copy  = get_field( 'supporting_copy' );
$primary_button   = get_field( 'primary_button' );
$secondary_button = get_field( 'secondary_button' );
$proof_title      = get_field( 'proof_title' );
$proof_copy       = get_field( 'proof_copy' );

$illustration_photo_id      = get_field( 'hero_illustration_background' );
$illustration_connector_1_id = get_field( 'hero_illustration_connector_1' );
$illustration_connector_2_id = get_field( 'hero_illustration_connector_2' );
$illustration_dot_1_id       = get_field( 'hero_illustration_dot_1' );
$illustration_dot_2_id       = get_field( 'hero_illustration_dot_2' );

$receipt_total  = get_field( 'hero_receipt_total' );
$invoice_total  = get_field( 'hero_invoice_total' );

$card_supplier   = get_field( 'hero_card_supplier' );
$card_date       = get_field( 'hero_card_date' );
$card_total      = get_field( 'hero_card_total' );
$card_vat        = get_field( 'hero_card_vat' );
$card_category   = get_field( 'hero_card_category' );
$card_confidence = get_field( 'hero_card_confidence' );
?>
<section class="hero">
	<div class="hero__inner container" data-animate-onload>
		<div class="hero__content">
			<h1 class="hero__headline" data-animate>
				<span class="hero__headline-line"><?php echo esc_html( $headline_line_1 ); ?></span>
				<span class="hero__headline-line hero__headline-line--accent"><?php echo esc_html( $headline_line_2 ); ?></span>
			</h1>

			<p class="hero__copy" data-animate><?php echo esc_html( $supporting_copy ); ?></p>

			<div class="hero__actions" data-animate>
				<?php if ( $primary_button ) : ?>
					<span class="btn-stack-hover">
						<span class="btn__stack-back btn__stack-back--black" aria-hidden="true"></span>
						<a
							class="btn btn--primary"
							href="<?php echo esc_url( $primary_button['url'] ); ?>"
							<?php echo ! empty( $primary_button['target'] ) ? 'target="' . esc_attr( $primary_button['target'] ) . '"' : ''; ?>
						>
							<span><?php echo esc_html( $primary_button['title'] ); ?></span>
						</a>
					</span>
				<?php endif; ?>

				<?php if ( $secondary_button ) : ?>
					<span class="btn-stack-hover">
						<span class="btn__stack-back btn__stack-back--orange" aria-hidden="true"></span>
						<a
							class="btn btn--secondary"
							href="<?php echo esc_url( $secondary_button['url'] ); ?>"
							<?php echo ! empty( $secondary_button['target'] ) ? 'target="' . esc_attr( $secondary_button['target'] ) . '"' : ''; ?>
						>
							<span><?php echo esc_html( $secondary_button['title'] ); ?></span>
						</a>
					</span>
				<?php endif; ?>
			</div>

			<div class="hero__proof" data-animate>
				<p class="hero__proof-title"><?php echo esc_html( $proof_title ); ?></p>
				<p class="hero__proof-copy"><?php echo esc_html( $proof_copy ); ?></p>
			</div>
		</div>

		<div class="hero__visual">
			<div class="hero__illustration" data-animate>
				<div class="hero__illustration-backdrop" aria-hidden="true"></div>

				<?php if ( $illustration_photo_id ) : ?>
					<div class="hero__illustration-photo-frame">
						<?php
						echo wp_get_attachment_image(
							$illustration_photo_id,
							'full',
							false,
							array(
								'class' => 'hero__illustration-photo',
								'sizes' => '(max-width: 768px) 100vw, 589px',
							)
						);
						?>
					</div>
				<?php endif; ?>

				<div class="hero__card-backing" aria-hidden="true"></div>

				<!-- Node 15150:1527 "Document / Receipt" -->
				<div class="hero__doc hero__doc--receipt">
					<div class="hero__receipt" aria-hidden="true">
						<p class="hero__receipt-title">RECEIPT</p>
						<span class="hero__receipt-divider"></span>
						<span class="hero__receipt-line" style="top:36.94px;"></span>
						<span class="hero__receipt-line hero__receipt-line--short" style="top:47.72px;"></span>
						<span class="hero__receipt-line" style="top:58.5px;"></span>
						<span class="hero__receipt-line hero__receipt-line--short" style="top:69.28px;"></span>
						<p class="hero__receipt-total"><?php echo esc_html( $receipt_total ); ?></p>
						<span class="hero__receipt-footer"></span>
						<p class="hero__receipt-footer-label">THANK YOU</p>
					</div>
				</div>

				<!-- Node 15150:1537 "Document / Invoice" -->
				<div class="hero__doc hero__doc--invoice">
					<div class="hero__invoice" aria-hidden="true">
						<p class="hero__invoice-title">INVOICE</p>
						<span class="hero__invoice-divider"></span>
						<span class="hero__invoice-line hero__invoice-line--left" style="top:33.81px;width:25.879px;"></span>
						<span class="hero__invoice-line hero__invoice-line--right" style="top:33.81px;"></span>
						<span class="hero__invoice-line hero__invoice-line--left" style="top:41.2px;width:22.182px;"></span>
						<span class="hero__invoice-line hero__invoice-line--right" style="top:41.2px;"></span>
						<span class="hero__invoice-line hero__invoice-line--left" style="top:48.59px;width:18.485px;"></span>
						<span class="hero__invoice-line hero__invoice-line--right" style="top:48.59px;"></span>

						<div class="hero__invoice-table">
							<span class="hero__invoice-table-col" style="left:33.27px;"></span>
							<span class="hero__invoice-table-col" style="left:52.5px;"></span>
							<span class="hero__invoice-table-header-divider"></span>

							<span class="hero__invoice-table-row" style="top:15.53px;"></span>
							<span class="hero__invoice-table-amount" style="top:15.53px;"></span>
							<span class="hero__invoice-table-tax" style="top:15.53px;"></span>

							<span class="hero__invoice-table-row" style="top:21.07px;"></span>
							<span class="hero__invoice-table-amount" style="top:21.07px;"></span>
							<span class="hero__invoice-table-tax" style="top:21.07px;"></span>

							<span class="hero__invoice-table-row" style="top:26.62px;"></span>
							<span class="hero__invoice-table-amount" style="top:26.62px;"></span>
							<span class="hero__invoice-table-tax" style="top:26.62px;"></span>

							<span class="hero__invoice-table-row" style="top:32.16px;"></span>
							<span class="hero__invoice-table-amount" style="top:32.16px;"></span>
							<span class="hero__invoice-table-tax" style="top:32.16px;"></span>
						</div>

						<p class="hero__invoice-total-label">TOTAL</p>
						<p class="hero__invoice-total-value"><?php echo esc_html( $invoice_total ); ?></p>
					</div>
				</div>

				<?php if ( $illustration_connector_1_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$illustration_connector_1_id,
						'full',
						false,
						array( 'class' => 'hero__connector hero__connector--1', 'alt' => '' )
					);
					?>
				<?php endif; ?>

				<?php if ( $illustration_connector_2_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$illustration_connector_2_id,
						'full',
						false,
						array( 'class' => 'hero__connector hero__connector--2', 'alt' => '' )
					);
					?>
				<?php endif; ?>

				<!-- Node 15150:1792 "Process / Scan Icon" -->
				<div class="hero__scan-icon">
					<div class="hero__scan-icon-inner">
						<?php snap_print_icon( 'SNAP_HERO_SCAN_GLYPH_ID', 'hero__scan-icon-glyph' ); ?>
					</div>
				</div>

				<!-- Node 15150:1505 "Card / Extracted Details" -->
				<div class="hero__doc hero__doc--card">
					<div class="hero__card">
						<?php snap_print_icon( 'SNAP_HERO_SPARKLES_ICON_ID', 'hero__card-icon' ); ?>
						<p class="hero__card-title">Extracted details</p>
						<span class="hero__card-divider"></span>

						<p class="hero__card-label" style="top:48px;">Supplier</p>
						<p class="hero__card-value" style="top:48px;left:107px;"><?php echo esc_html( $card_supplier ); ?></p>

						<p class="hero__card-label" style="top:71px;">Date</p>
						<p class="hero__card-value" style="top:71px;left:130px;"><?php echo esc_html( $card_date ); ?></p>

						<p class="hero__card-label" style="top:94px;">Total</p>
						<p class="hero__card-value" style="top:94px;left:151px;"><?php echo esc_html( $card_total ); ?></p>

						<p class="hero__card-label" style="top:117px;">VAT</p>
						<p class="hero__card-value" style="top:117px;left:155px;"><?php echo esc_html( $card_vat ); ?></p>

						<p class="hero__card-label" style="top:140px;">Category</p>
						<span class="hero__card-pill"><?php echo esc_html( $card_category ); ?></span>

						<span class="hero__card-confidence-divider"></span>
						<?php snap_print_icon( 'SNAP_HERO_CONFIDENCE_CHECK_ID', 'hero__card-confidence-icon' ); ?>
						<p class="hero__card-confidence-label">Confidence</p>
						<p class="hero__card-confidence-value"><?php echo esc_html( $card_confidence ); ?></p>
					</div>
				</div>

				<!-- Node 15150:1796 "Status / Ready for Bookkeeping" -->
				<div class="hero__status-badge">
					<div class="hero__badge">
						<span class="hero__badge-circle">
							<?php snap_print_icon( 'SNAP_HERO_SUCCESS_CHECK_ID', 'hero__badge-check' ); ?>
						</span>
						<p class="hero__badge-label">Ready for bookkeeping</p>
					</div>
				</div>

				<?php
				/*
				 * Dot markers (15150:1801/1802) sit after the card and badge
				 * in Figma's own layer order, painting on top where they
				 * overlap those elements' edges — not behind them.
				 */
				?>
				<?php if ( $illustration_dot_1_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$illustration_dot_1_id,
						'full',
						false,
						array( 'class' => 'hero__dot hero__dot--1', 'alt' => '' )
					);
					?>
				<?php endif; ?>

				<?php if ( $illustration_dot_2_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$illustration_dot_2_id,
						'full',
						false,
						array( 'class' => 'hero__dot hero__dot--2', 'alt' => '' )
					);
					?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
