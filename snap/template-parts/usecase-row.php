<?php
/**
 * Reusable partial: one "Real Usecases" row.
 * Invoked via get_template_part( 'template-parts/usecase-row', null, [ 'usecase' => ..., 'index' => ... ] ).
 *
 * Renders the shared shell (backing, photo frame, icon/title/body) plus
 * that row's own set of floating stat cards, chosen by row position
 * (1st = invoice list, 2nd = expense/profit charts, 3rd = receipt capture,
 * 4th = entity list) — see inc/acf-fields-real-usecases.php for why these
 * aren't a single generic "card" repeater.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$usecase = $args['usecase'] ?? array();
$index   = $args['index'] ?? 0;
$row_num = $index + 1;

$icon_id    = $usecase['icon'] ?? null;
$title      = $usecase['title'] ?? '';
$body       = $usecase['body'] ?? '';
$image_id   = $usecase['image'] ?? null;
$image_side = $usecase['image_side'] ?? 'left';

// Anchor targets for the footer's "For teams" links (row order is fixed:
// Accounting firms, Bookkeepers, SMEs, Multi-entity businesses).
$row_anchors = array(
	1 => 'usecase-accounting-firms',
	2 => 'usecase-bookkeepers',
	3 => 'usecase-smes',
	4 => 'usecase-multi-entity',
);
$row_anchor  = $row_anchors[ $row_num ] ?? '';

// Each row's photo renders at a different fixed max-width on desktop
// (see usecase-row--N .usecase-row__photo-frame percentages in style.css,
// all resolved against the shared 1240px container); below the 960px
// stacking breakpoint it goes full-width, so only the desktop figure
// needs to vary per row.
$row_photo_desktop_width = array(
	1 => 392,
	2 => 481,
	3 => 406,
	4 => 446,
);
$photo_sizes = sprintf(
	'(max-width: 960px) 100vw, %dpx',
	$row_photo_desktop_width[ $row_num ] ?? 460
);
?>
<div class="usecase-row-group" id="<?php echo esc_attr( $row_anchor ); ?>">
<div class="usecase-row-frame usecase-row-frame--<?php echo (int) $row_num; ?>">
<div class="usecase-row usecase-row--<?php echo (int) $row_num; ?> usecase-row--<?php echo esc_attr( $image_side ); ?>">
	<div class="usecase-row__backing" aria-hidden="true"></div>

	<?php if ( $image_id ) : ?>
		<div class="usecase-row__photo-frame" data-animate>
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'full',
				false,
				array(
					'class' => 'usecase-row__photo',
					'sizes' => $photo_sizes,
				)
			);
			?>
		</div>
	<?php endif; ?>

	<?php if ( 1 === $row_num ) : ?>

		<div class="usecase-card usecase-card--invoice-review" data-animate>
			<p class="usecase-card__title"><?php echo esc_html( $usecase['r1_invoice_title'] ?? '' ); ?></p>
			<?php snap_print_icon( 'SNAP_USECASES_R1_INVOICE_ICON_ID', 'usecase-card__title-icon' ); ?>
			<?php if ( ! empty( $usecase['r1_invoices'] ) ) : ?>
				<ul class="usecase-card__invoice-list">
					<?php foreach ( $usecase['r1_invoices'] as $invoice ) : ?>
						<li class="usecase-card__invoice-row">
							<span class="usecase-card__invoice-id"><?php echo esc_html( $invoice['invoice_id'] ?? '' ); ?></span>
							<span class="usecase-card__invoice-bar" aria-hidden="true"></span>
							<span class="usecase-card__invoice-amount"><?php echo esc_html( $invoice['amount'] ?? '' ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="usecase-card usecase-card--stat" data-animate>
			<p class="usecase-card__stat-value"><?php echo esc_html( $usecase['r1_stat_value'] ?? '' ); ?></p>
			<p class="usecase-card__stat-label"><?php echo esc_html( $usecase['r1_stat_label'] ?? '' ); ?></p>
		</div>

		<div class="usecase-badge usecase-badge--filed" data-animate>
			<?php snap_print_icon( 'SNAP_USECASES_R1_FILED_CHECK_ID', 'usecase-badge__icon' ); ?>
			<span class="usecase-badge__label"><?php echo esc_html( $usecase['r1_badge_1'] ?? '' ); ?></span>
		</div>

		<div class="usecase-badge usecase-badge--approved" data-animate>
			<span class="usecase-badge__icon-stack">
				<?php snap_print_icon( 'SNAP_USECASES_R1_APPROVED_CIRCLE_ID', 'usecase-badge__icon-bg' ); ?>
				<?php snap_print_icon( 'SNAP_USECASES_R1_APPROVED_CHECK_ID', 'usecase-badge__icon-check' ); ?>
			</span>
			<span class="usecase-badge__label"><?php echo esc_html( $usecase['r1_badge_2'] ?? '' ); ?></span>
		</div>

	<?php elseif ( 2 === $row_num ) : ?>

		<div class="usecase-card usecase-card--donut" data-animate>
			<p class="usecase-card__title"><?php echo esc_html( $usecase['r2_donut_title'] ?? '' ); ?></p>
			<?php snap_print_icon( 'SNAP_USECASES_R2_DONUT_CHART_ID', 'usecase-card__donut-img' ); ?>
			<?php if ( ! empty( $usecase['r2_donut_legend'] ) ) : ?>
				<ul class="usecase-card__legend">
					<?php foreach ( $usecase['r2_donut_legend'] as $item ) : ?>
						<li class="usecase-card__legend-row">
							<span class="usecase-card__legend-dot" style="background:<?php echo esc_attr( $item['color'] ?? '#ccc' ); ?>"></span>
							<span class="usecase-card__legend-label"><?php echo esc_html( $item['label'] ?? '' ); ?></span>
							<span class="usecase-card__legend-percent"><?php echo esc_html( $item['percent'] ?? '' ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="usecase-card usecase-card--reconciliation" data-animate>
			<span class="usecase-badge__icon-stack usecase-card__reconciliation-icon">
				<?php snap_print_icon( 'SNAP_USECASES_R2_RECONCILIATION_BG_ID', 'usecase-badge__icon-bg' ); ?>
				<?php snap_print_icon( 'SNAP_USECASES_R2_RECONCILIATION_CHECK_ID', 'usecase-badge__icon-check' ); ?>
			</span>
			<div class="usecase-card__reconciliation-text">
				<p class="usecase-card__reconciliation-title"><?php echo esc_html( $usecase['r2_reconciliation_title'] ?? '' ); ?></p>
				<p class="usecase-card__reconciliation-subtitle"><?php echo esc_html( $usecase['r2_reconciliation_subtitle'] ?? '' ); ?></p>
			</div>
		</div>

		<div class="usecase-card usecase-card--profit" data-animate>
			<p class="usecase-card__title"><?php echo esc_html( $usecase['r2_profit_title'] ?? '' ); ?></p>
			<div class="usecase-card__profit-row">
				<p class="usecase-card__profit-value"><?php echo esc_html( $usecase['r2_profit_value'] ?? '' ); ?></p>
				<span class="usecase-card__profit-change"><?php echo esc_html( $usecase['r2_profit_change'] ?? '' ); ?></span>
			</div>
			<?php snap_print_icon( 'SNAP_USECASES_R2_MONTHLY_CHART_ID', 'usecase-card__profit-chart' ); ?>
		</div>

	<?php elseif ( 3 === $row_num ) : ?>

		<div class="usecase-card usecase-card--receipt" data-animate>
			<p class="usecase-card__title"><?php echo esc_html( $usecase['r3_receipt_title'] ?? '' ); ?></p>
			<?php snap_print_icon( 'SNAP_USECASES_R3_CAMERA_ICON_ID', 'usecase-card__camera-icon' ); ?>
			<div class="usecase-card__receipt-preview" aria-hidden="true">
				<span class="usecase-card__receipt-label">RECEIPT</span>
				<span class="usecase-card__receipt-line"></span>
				<span class="usecase-card__receipt-line usecase-card__receipt-line--short"></span>
				<span class="usecase-card__receipt-line"></span>
				<span class="usecase-card__receipt-line usecase-card__receipt-line--short"></span>
				<span class="usecase-card__receipt-line"></span>
			</div>
			<p class="usecase-card__receipt-total-label">Total</p>
			<p class="usecase-card__receipt-total"><?php echo esc_html( $usecase['r3_receipt_total'] ?? '' ); ?></p>
			<span class="usecase-badge__icon-stack usecase-card__receipt-check">
				<?php snap_print_icon( 'SNAP_USECASES_R3_CAPTURED_BG_ID', 'usecase-badge__icon-bg' ); ?>
				<?php snap_print_icon( 'SNAP_USECASES_R3_CAPTURED_CHECK_ID', 'usecase-badge__icon-check' ); ?>
			</span>
			<span class="usecase-card__receipt-status"><?php echo esc_html( $usecase['r3_receipt_status'] ?? '' ); ?></span>
		</div>

		<div class="usecase-card usecase-card--expense" data-animate>
			<p class="usecase-card__title"><?php echo esc_html( $usecase['r3_expense_title'] ?? '' ); ?></p>
			<?php snap_print_icon( 'SNAP_USECASES_R3_EXPENSE_FILE_ICON_ID', 'usecase-card__file-icon' ); ?>
			<?php if ( ! empty( $usecase['r3_expense_rows'] ) ) : ?>
				<ul class="usecase-card__legend usecase-card__legend--expense">
					<?php foreach ( $usecase['r3_expense_rows'] as $item ) : ?>
						<li class="usecase-card__legend-row">
							<span class="usecase-card__legend-dot" style="background:<?php echo esc_attr( $item['color'] ?? '#ccc' ); ?>"></span>
							<span class="usecase-card__legend-label"><?php echo esc_html( $item['label'] ?? '' ); ?></span>
							<span class="usecase-card__legend-amount"><?php echo esc_html( $item['amount'] ?? '' ); ?></span>
							<span class="usecase-card__legend-percent"><?php echo esc_html( $item['percent'] ?? '' ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="usecase-badge usecase-badge--organized" data-animate>
			<?php snap_print_icon( 'SNAP_USECASES_R3_ORGANIZED_CHECK_ID', 'usecase-badge__icon' ); ?>
			<span class="usecase-badge__label"><?php echo esc_html( $usecase['r3_organized_badge'] ?? '' ); ?></span>
		</div>

	<?php elseif ( 4 === $row_num ) : ?>

		<div class="usecase-card usecase-card--entity" data-animate>
			<div class="usecase-card__entity-header">
				<?php snap_print_icon( 'SNAP_USECASES_R4_BUILDING_HEADER_ID', 'usecase-card__entity-header-icon' ); ?>
				<p class="usecase-card__entity-header-title"><?php echo esc_html( $usecase['r4_entity_title'] ?? '' ); ?></p>
			</div>
			<?php if ( ! empty( $usecase['r4_entities'] ) ) : ?>
				<ul class="usecase-card__entity-list">
					<?php foreach ( $usecase['r4_entities'] as $entity ) : ?>
						<li class="usecase-card__entity-row">
							<span class="usecase-card__entity-icon-tile">
								<?php snap_print_icon( 'SNAP_USECASES_R4_BUILDING_ROW_ID', 'usecase-card__entity-icon' ); ?>
							</span>
							<span class="usecase-card__entity-name"><?php echo esc_html( $entity['name'] ?? '' ); ?></span>
							<span class="usecase-card__entity-status"><?php echo esc_html( $entity['status'] ?? '' ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<div class="usecase-card usecase-card--synced" data-animate>
			<span class="usecase-card__folder-tile">
				<?php snap_print_icon( 'SNAP_USECASES_R4_FOLDER_ICON_ID', 'usecase-card__folder-icon' ); ?>
			</span>
			<p class="usecase-card__synced-value"><?php echo esc_html( $usecase['r4_synced_value'] ?? '' ); ?></p>
			<p class="usecase-card__synced-label"><?php echo esc_html( $usecase['r4_synced_label'] ?? '' ); ?></p>
		</div>

		<div class="usecase-badge usecase-badge--centralized" data-animate>
			<?php snap_print_icon( 'SNAP_USECASES_R4_CENTRALIZED_CHECK_ID', 'usecase-badge__icon' ); ?>
			<span class="usecase-badge__label"><?php echo esc_html( $usecase['r4_centralized_label'] ?? '' ); ?></span>
		</div>

		<div class="usecase-badge usecase-badge--synced" data-animate>
			<span class="usecase-badge__label"><?php echo esc_html( $usecase['r4_synced_badge_label'] ?? '' ); ?></span>
			<?php snap_print_icon( 'SNAP_USECASES_R4_SYNCED_ICON_ID', 'usecase-badge__synced-icon' ); ?>
		</div>

	<?php endif; ?>
</div>
</div>

	<div class="usecase-row__text usecase-row__text--<?php echo (int) $row_num; ?>" data-animate>
		<?php if ( $icon_id ) : ?>
			<div class="usecase-row__icon-badge">
				<?php
				echo wp_get_attachment_image(
					$icon_id,
					'full',
					false,
					array( 'class' => 'usecase-row__icon', 'alt' => '' )
				);
				?>
			</div>
		<?php endif; ?>
		<h3 class="usecase-row__title"><?php echo esc_html( $title ); ?></h3>
		<p class="usecase-row__body"><?php echo esc_html( $body ); ?></p>
	</div>
</div>
