<?php
/**
 * Template part: One Connected Workspace section.
 * Figma: node 15532:356 ("Section 05 — One Connected Workspace").
 *
 * The diagram (dashed orbit + Snap/Lucibook-dashboard/Luci product
 * callouts) is dense decorative content reproduced at native 791x735 px
 * and scaled as one unit — same cqw-scale technique as the rest of this
 * build. Internal mockup content (receipt line items, transaction rows,
 * capability checklist) is simplified to real text laid out with
 * flexbox rather than replicating every literal sub-pixel offset.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'ws_eyebrow' );
$headline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'ws_headline' ) ) ) );
$body     = get_field( 'ws_body' );
$closing  = get_field( 'ws_closing' );
$cta_label = get_field( 'ws_cta_label' );
$cta_url   = get_field( 'ws_cta_url' );
$tagline_lines = array_filter( array_map( 'trim', explode( "\n", (string) get_field( 'ws_tagline' ) ) ) );
?>
<section class="workspace">
	<div class="container workspace__inner">
		<div class="workspace__content" data-animate>
			<p class="workspace__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<h2 class="workspace__headline">
				<?php foreach ( $headline_lines as $line ) : ?>
					<span class="workspace__headline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</h2>
			<p class="workspace__body"><?php echo esc_html( $body ); ?></p>
			<p class="workspace__closing"><?php echo esc_html( $closing ); ?></p>
			<a class="btn btn--primary workspace__cta" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
				<?php echo esc_html( $cta_label ); ?>
			</a>
			<p class="workspace__tagline">
				<?php foreach ( $tagline_lines as $line ) : ?>
					<span class="workspace__tagline-line"><?php echo esc_html( $line ); ?></span>
				<?php endforeach; ?>
			</p>
		</div>

		<div class="workspace__visual" data-animate>
			<div class="workspace__diagram">
				<div class="workspace__panel" aria-hidden="true"></div>
				<?php lucibook_print_icon( 'LUCIBOOK_WS_ORBIT_ID', 'workspace__orbit' ); ?>

				<div class="workspace__card workspace__card--snap">
					<div class="workspace__callout workspace__callout--snap">
						<?php lucibook_print_icon( 'LUCIBOOK_WS_SNAP_ICON_BUBBLE_ID', 'workspace__callout-icon' ); ?>
						<span class="workspace__callout-title">Snap</span>
						<span class="workspace__callout-desc">captures it</span>
					</div>
					<div class="workspace__phone">
						<div class="workspace__receipt">
							<p class="workspace__receipt-merchant">ACME COFFEE</p>
							<p class="workspace__receipt-address">12 High Street<br>London, UK</p>
							<div class="workspace__receipt-rule"></div>
							<p class="workspace__receipt-meta">Date: 16 May 2024<br>Receipt: #1257</p>
							<div class="workspace__receipt-rule"></div>
							<div class="workspace__receipt-line"><span>Latte</span><span>£3.20</span></div>
							<div class="workspace__receipt-line"><span>Croissant</span><span>£2.80</span></div>
							<div class="workspace__receipt-line"><span>Oat Milk</span><span>£0.50</span></div>
							<div class="workspace__receipt-rule"></div>
							<div class="workspace__receipt-line workspace__receipt-line--total"><span>Total</span><span>£6.50</span></div>
							<p class="workspace__receipt-card">Card •••• 4242</p>
						</div>
						<span class="workspace__captured-check">
							<?php lucibook_print_icon( 'LUCIBOOK_WS_CAPTURED_CHECK_ID', 'workspace__captured-check-icon' ); ?>
						</span>
					</div>
				</div>

				<div class="workspace__card workspace__card--dashboard">
					<div class="workspace__dashboard-header"></div>
					<div class="workspace__dashboard-sidebar">
						<span class="workspace__dashboard-icon workspace__dashboard-icon--active">
							<?php lucibook_print_icon( 'LUCIBOOK_WS_CAMERA_ICON_ID', '' ); ?>
						</span>
						<span class="workspace__dashboard-icon"></span>
						<span class="workspace__dashboard-icon"></span>
						<span class="workspace__dashboard-icon"></span>
					</div>
					<div class="workspace__dashboard-body">
						<p class="workspace__dashboard-title">Transactions</p>
						<div class="workspace__dashboard-list">
							<div class="workspace__dashboard-row">
								<span class="workspace__dashboard-row-icon">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ROW_ICON_BG_ID', 'workspace__dashboard-row-icon-bg' ); ?>
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ICON_OFFICE_SUPPLIES_ID', 'workspace__dashboard-row-icon-glyph' ); ?>
								</span>
								<span class="workspace__dashboard-row-label">Office Supplies</span>
								<span class="workspace__dashboard-row-amount">£42.60</span>
								<span class="workspace__dashboard-row-tag">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?>
									Categorised
								</span>
							</div>
							<div class="workspace__dashboard-row">
								<span class="workspace__dashboard-row-icon">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ROW_ICON_BG_ID', 'workspace__dashboard-row-icon-bg' ); ?>
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ICON_TRAVEL_ID', 'workspace__dashboard-row-icon-glyph' ); ?>
								</span>
								<span class="workspace__dashboard-row-label">Travel</span>
								<span class="workspace__dashboard-row-amount">£215.00</span>
								<span class="workspace__dashboard-row-tag">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?>
									Categorised
								</span>
							</div>
							<div class="workspace__dashboard-row">
								<span class="workspace__dashboard-row-icon">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ROW_ICON_BG_ID', 'workspace__dashboard-row-icon-bg' ); ?>
									<?php lucibook_print_icon( 'LUCIBOOK_WS_ICON_LUNCH_ID', 'workspace__dashboard-row-icon-glyph' ); ?>
								</span>
								<span class="workspace__dashboard-row-label">Client Lunch</span>
								<span class="workspace__dashboard-row-amount">£68.30</span>
								<span class="workspace__dashboard-row-tag">
									<?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?>
									Categorised
								</span>
							</div>
						</div>
					</div>
				</div>

				<div class="workspace__card workspace__card--luci">
					<?php lucibook_print_icon( 'LUCIBOOK_WS_LUCI_OUTER_GLOW_ID', 'workspace__luci-glow' ); ?>
					<span class="workspace__luci-avatar">
						<?php lucibook_print_icon( 'LUCIBOOK_WS_LUCI_ORB_ID', 'workspace__luci-orb' ); ?>
						<?php lucibook_print_icon( 'LUCIBOOK_WS_LUCI_FACE_PHOTO_ID', 'workspace__luci-face-photo' ); ?>
					</span>
					<p class="workspace__luci-name">Lucy</p>
					<p class="workspace__luci-tag">knows it</p>
					<div class="workspace__luci-checklist">
						<span><?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?> Reads</span>
						<span><?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?> Understands</span>
						<span><?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?> Categorises</span>
						<span><?php lucibook_print_icon( 'LUCIBOOK_WS_CHECK_ID', '' ); ?> Learns</span>
					</div>
				</div>

				<div class="workspace__card workspace__card--together">
					<?php lucibook_print_icon( 'LUCIBOOK_WS_LAYERS_BUBBLE_ID', 'workspace__together-icon' ); ?>
					<p class="workspace__together-brand">LUCIBOOK</p>
					<p class="workspace__together-desc">brings it all together</p>
				</div>
			</div>
		</div>
	</div>
</section>
