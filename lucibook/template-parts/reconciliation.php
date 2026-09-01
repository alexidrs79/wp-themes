<?php
/**
 * Template part: Reconciliation section.
 * Figma: node 15532:149 ("Section 03 — Reconciliation").
 *
 * The LuciCore mockup (668x647) is dense, screenshot-style decorative
 * content — reproduced at native px and scaled as one rigid unit via
 * `transform: scale(calc(100cqw / 668px))`, same cqw-scale technique used
 * throughout this build for dense mockups. Table rows are simplified to
 * flexbox rows (shared row height, icon+text vertically centered) rather
 * than literally replicating every child's own micro-offset — visually
 * equivalent, much less markup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'rc_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'rc_headline' ) ) ) );
$body     = get_field( 'rc_body' );
$closing  = get_field( 'rc_closing' );

$rows = array(
	array( 'date' => 'May 20, 2024', 'desc' => 'Office Supplies', 'account' => 'Business Current', 'amount' => '£64.99', 'n' => 1 ),
	array( 'date' => 'May 20, 2024', 'desc' => 'Corner Coffee', 'account' => 'Business Current', 'amount' => '£4.25', 'n' => 2 ),
	array( 'date' => 'May 21, 2024', 'desc' => 'Blue Skies Travel', 'account' => 'Business Current', 'amount' => '£218.00', 'n' => 3 ),
	array( 'date' => 'May 21, 2024', 'desc' => 'Card Payment Fee', 'account' => 'Business Current', 'amount' => '£1.20', 'n' => 4 ),
	array( 'date' => 'May 22, 2024', 'desc' => 'Fresh Foods', 'account' => 'Business Current', 'amount' => '£37.48', 'n' => 5 ),
);
?>
<section class="reconciliation">
	<div class="container reconciliation__inner">
		<div class="reconciliation__content" data-animate>
			<p class="reconciliation__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h2 class="reconciliation__headline">
				<?php foreach ( $headline_lines as $line ) : ?>
					<span class="reconciliation__headline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</h2>
			<p class="reconciliation__body"><?php echo esc_html( $body ); ?></p>
			<p class="reconciliation__closing"><?php echo esc_html( $closing ); ?></p>
		</div>

		<div class="reconciliation__visual" data-animate>
			<div class="reconciliation__mockup">
				<?php lucibook_print_icon( 'LUCIBOOK_RC_GLOW_LEFT_ID', 'reconciliation__glow reconciliation__glow--left' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_RC_GLOW_RIGHT_ID', 'reconciliation__glow reconciliation__glow--right' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_RC_BLOB_LEFT_ID', 'reconciliation__blob reconciliation__blob--left' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_RC_BLOB_RIGHT_ID', 'reconciliation__blob reconciliation__blob--right' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_RC_WALLET_ID', 'reconciliation__wallet' ); ?>
				<?php lucibook_print_icon( 'LUCIBOOK_RC_COIN_STACK_ID', 'reconciliation__coins' ); ?>

				<div class="reconciliation__card" aria-hidden="true">
					<?php lucibook_print_icon( 'LUCIBOOK_RC_MARK_ID', 'reconciliation__card-mark' ); ?>
					<p class="reconciliation__card-brand">LuciCore</p>

					<div class="reconciliation__top-status">
						<?php lucibook_print_icon( 'LUCIBOOK_RC_CHECK_CIRCLE_ID', 'reconciliation__top-status-circle' ); ?>
						<?php lucibook_print_icon( 'LUCIBOOK_RC_CHECK_ICON_ID', 'reconciliation__top-status-check' ); ?>
						<span class="reconciliation__top-status-text">18 transactions reconciled</span>
					</div>

					<?php lucibook_print_icon( 'LUCIBOOK_RC_RING_3_ID', 'reconciliation__ring reconciliation__ring--3' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_RING_2_ID', 'reconciliation__ring reconciliation__ring--2' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_RING_1_ID', 'reconciliation__ring reconciliation__ring--1' ); ?>

					<p class="reconciliation__card-title">Reconciliation</p>
					<p class="reconciliation__card-subtitle">Connect. Match. Reconcile.</p>

					<span class="reconciliation__reconcile-btn">Reconcile</span>

					<span class="reconciliation__select-all-box"></span>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_SELECT_ALL_CHECK_ID', 'reconciliation__select-all-check' ); ?>
					<span class="reconciliation__select-all-label">Select all (18)</span>

					<?php lucibook_print_icon( 'LUCIBOOK_RC_CURSOR_1_ID', 'reconciliation__cursor reconciliation__cursor--1' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_CURSOR_2_ID', 'reconciliation__cursor reconciliation__cursor--2' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_CLICK_RAYS_ID', 'reconciliation__click-rays' ); ?>

					<div class="reconciliation__table-head">
						<span>Date</span>
						<span>Description</span>
						<span>Account</span>
						<span>Amount</span>
						<span>Status</span>
					</div>

					<div class="reconciliation__table">
						<?php foreach ( $rows as $row ) : ?>
							<div class="reconciliation__row">
								<span class="reconciliation__row-checkbox"></span>
								<span class="reconciliation__row-date"><?php echo esc_html( $row['date'] ); ?></span>
								<span class="reconciliation__row-icon">
									<?php lucibook_print_icon( 'LUCIBOOK_RC_ROW_ICON_BG_' . $row['n'] . '_ID', 'reconciliation__row-icon-bg' ); ?>
									<?php lucibook_print_icon( 'LUCIBOOK_RC_ROW_ICON_' . $row['n'] . '_ID', 'reconciliation__row-icon-glyph' ); ?>
								</span>
								<span class="reconciliation__row-desc"><?php echo esc_html( $row['desc'] ); ?></span>
								<span class="reconciliation__row-account"><?php echo esc_html( $row['account'] ); ?></span>
								<span class="reconciliation__row-amount"><?php echo esc_html( $row['amount'] ); ?></span>
								<span class="reconciliation__row-status">
									<?php lucibook_print_icon( 'LUCIBOOK_RC_STATUS_CIRCLE_ID', 'reconciliation__status-circle' ); ?>
									<?php lucibook_print_icon( 'LUCIBOOK_RC_STATUS_CHECK_ID', 'reconciliation__status-check' ); ?>
								</span>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="reconciliation__banner">
						<?php lucibook_print_icon( 'LUCIBOOK_RC_BANNER_ICON_ID', 'reconciliation__banner-icon' ); ?>
						<span class="reconciliation__banner-text">18 transactions reconciled</span>
					</div>

					<?php lucibook_print_icon( 'LUCIBOOK_RC_ACCENT_1_ID', 'reconciliation__accent reconciliation__accent--1' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_ACCENT_2_ID', 'reconciliation__accent reconciliation__accent--2' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_ACCENT_3_ID', 'reconciliation__accent reconciliation__accent--3' ); ?>
					<?php lucibook_print_icon( 'LUCIBOOK_RC_ACCENT_4_ID', 'reconciliation__accent reconciliation__accent--4' ); ?>
				</div>
			</div>
		</div>
	</div>
</section>
