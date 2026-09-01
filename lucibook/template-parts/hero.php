<?php
/**
 * Template part: Hero section.
 * Figma: node 15532:88 ("Section 01 — Hero"), blue panel 1376x749.
 *
 * Text column (headline/body/CTA/note) is normal responsive flow. The
 * illustration cluster (orb, Product Workspace mockup, photo, 3 floating
 * status labels, 2 stars) is one relative box with children positioned by
 * percentage of its own bounding box (726,36,634,713 within the panel) —
 * same technique as Snap's hero illustration. The Product Workspace card
 * itself is dense, screenshot-style mockup content, so it's reproduced at
 * its native 312x312 px and scaled as one rigid unit via
 * `transform: scale(calc(100cqw / 312px))` (the cqw-scale technique,
 * matching Snap's `.usecase-row` / receipt-card pattern) rather than
 * hand-converted to a fluid layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'hero_headline' ) ) ) );
$body_lines      = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'hero_body' ) ) ) );
$cta_label       = get_field( 'hero_cta_label' );
$cta_url         = get_field( 'hero_cta_url' );
$small_note      = get_field( 'hero_small_note' );
$photo_id        = get_field( 'hero_photo' );
$hours_value     = get_field( 'hero_hours_value' );
$footer_microcopy = get_field( 'hero_footer_microcopy' );

$label_submission_title = get_field( 'hero_label_submission_title' );
$label_submission_desc  = get_field( 'hero_label_submission_desc' );
$label_reconciled_title = get_field( 'hero_label_reconciled_title' );
$label_reconciled_desc  = get_field( 'hero_label_reconciled_desc' );
$label_categorised_title = get_field( 'hero_label_categorised_title' );
$label_categorised_desc  = get_field( 'hero_label_categorised_desc' );
?>
<section class="hero">
	<div class="container">
		<div class="hero__panel">
			<div class="hero__content" data-animate>
				<h1 class="hero__headline">
					<?php foreach ( $headline_lines as $line ) : ?>
						<span class="hero__headline-line"><?php echo esc_html( $line ); ?></span>
					<?php endforeach; ?>
				</h1>
				<p class="hero__body">
					<?php foreach ( $body_lines as $i => $line ) : ?>
						<?php echo esc_html( $line ); ?><?php echo $i < count( $body_lines ) - 1 ? '<br>' : ''; ?>
					<?php endforeach; ?>
				</p>
				<a class="btn btn--white hero__cta" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
					<?php echo esc_html( $cta_label ); ?>
				</a>
				<p class="hero__small-note"><?php echo esc_html( $small_note ); ?></p>
			</div>

			<div class="hero__visual" data-animate>
				<?php lucibook_print_icon( 'LUCIBOOK_HERO_ORB_ID', 'hero__orb' ); ?>

				<div class="hero__workspace">
					<div class="hero__workspace-inner">
						<p class="hero__ws-brand">LUCIBOOK</p>
						<span class="hero__ws-period">This week</span>
						<div class="hero__ws-hours">
							<p class="hero__ws-hours-label">Hours given back this week</p>
							<p class="hero__ws-hours-value"><?php echo esc_html( $hours_value ); ?></p>
							<span class="hero__ws-uptodate">Up to date</span>
						</div>
						<div class="hero__ws-txn">
							<span class="hero__ws-txn-merchant">Tesco Stores</span>
							<span class="hero__ws-txn-amount">£146.20</span>
							<span class="hero__ws-txn-status hero__ws-txn-status--blue">Categorised</span>
						</div>
						<div class="hero__ws-txn hero__ws-txn--2">
							<span class="hero__ws-txn-merchant">HMRC Payment</span>
							<span class="hero__ws-txn-amount">£2,840.00</span>
							<span class="hero__ws-txn-status hero__ws-txn-status--blue">Reconciled</span>
						</div>
						<div class="hero__ws-txn hero__ws-txn--3">
							<span class="hero__ws-txn-merchant">Adobe</span>
							<span class="hero__ws-txn-amount">£54.99</span>
							<span class="hero__ws-txn-status hero__ws-txn-status--green">Submission</span>
						</div>
						<p class="hero__ws-footer"><?php echo esc_html( $footer_microcopy ); ?></p>
						<p class="hero__ws-title">Everything that needs your attention</p>
					</div>
				</div>

				<?php if ( $photo_id ) : ?>
					<div class="hero__photo-frame">
						<?php
						echo wp_get_attachment_image(
							$photo_id,
							'full',
							false,
							array( 'class' => 'hero__photo', 'sizes' => '(max-width: 768px) 100vw, 492px' )
						);
						?>
					</div>
				<?php endif; ?>

				<div class="hero__label hero__label--submission">
					<?php lucibook_print_icon( 'LUCIBOOK_HERO_ICON_SUBMISSION_ID', 'hero__label-icon' ); ?>
					<div class="hero__label-text">
						<p class="hero__label-title"><?php echo esc_html( $label_submission_title ); ?></p>
						<p class="hero__label-desc"><?php echo esc_html( $label_submission_desc ); ?></p>
					</div>
				</div>

				<div class="hero__label hero__label--reconciled">
					<?php lucibook_print_icon( 'LUCIBOOK_HERO_ICON_RECONCILED_ID', 'hero__label-icon' ); ?>
					<div class="hero__label-text">
						<p class="hero__label-title"><?php echo esc_html( $label_reconciled_title ); ?></p>
						<p class="hero__label-desc"><?php echo esc_html( $label_reconciled_desc ); ?></p>
					</div>
				</div>

				<div class="hero__label hero__label--categorised">
					<?php lucibook_print_icon( 'LUCIBOOK_HERO_ICON_CATEGORISED_ID', 'hero__label-icon' ); ?>
					<div class="hero__label-text">
						<p class="hero__label-title"><?php echo esc_html( $label_categorised_title ); ?></p>
						<p class="hero__label-desc"><?php echo esc_html( $label_categorised_desc ); ?></p>
					</div>
				</div>

				<?php lucibook_print_icon( 'LUCIBOOK_HERO_STAR_1_ID', 'hero__star hero__star--1' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_HERO_STAR_2_ID', 'hero__star hero__star--2' ); ?>
			</div>
		</div>
	</div>
</section>
