<?php
/**
 * Template part: "How Snap Works" section.
 * Figma: node 15150:1803 ("Frame 55"), 1440x1047, positioned at page y:5140.
 *
 * This section had three duplicate-pair questions, all resolved by checking
 * which layer Figma's own rendered screenshot actually shows on top (later
 * siblings in the layer list paint over earlier ones):
 *
 * 1. Heading/eyebrow exist twice — once nested inside the 4-step frame
 *    (15150:1847/1870) and once as section-level siblings (15150:1972/
 *    1973). The section-level pair is what's visible; the nested pair sits
 *    at a position fully covered by the opaque white step-timeline card on
 *    top of it. Its Figma layer NAME says "How you get a new career in 5
 *    months" but that's a stale rename — the actual TEXT rendered
 *    (confirmed against the screenshot) is "One clean flow. Zero
 *    busywork.", which is legitimate Snap copy, not placeholder text.
 * 2. The 4-step timeline is two frames: 15150:1804 (orange, offset 8px
 *    up/right) and 15150:1889 (white, on top). Same peeking-color-backing
 *    pattern as the hero/Meet Snap/Built for UK — 1804 is a plain backing
 *    div; every visible icon/title/connector comes from 1889.
 * 3. The integration strip is two frames: 15150:1974 (solid orange, small
 *    side photo only) and 15150:2000 (full-width photo background, on
 *    top). 2000 is what's visible; 1974 is the peeking backing again.
 *    Inside 2000 there's a third-level duplicate too — photo 15150:2001 vs
 *    15150:2002, where 2002 (dark gradient overlay, painted last) is the
 *    one actually visible; 2001 is discarded.
 *
 * The steps card (1889) and the integration card (2000) overlap slightly
 * in Figma's own coordinates (confirmed with a 1:1 pixel screenshot, not
 * assumed) — the steps card's rounded top-left corner tucks a few px under
 * the integration card's bottom-left corner. z-index (not DOM order)
 * reproduces that stacking so the heading can still sit first in the DOM
 * for reading order.
 *
 * Everything here is positioned as percentages of one container-relative
 * union box (x:96-1344, y:124-923 in frame-local coordinates → treated as
 * a 1240x799 box anchored at the container's left edge, x:100), same
 * technique as the Problem/Meet Snap/Built for UK sections.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow         = get_field( 'hsw_eyebrow' );
$headline_main   = get_field( 'hsw_headline_main' );
$headline_accent = get_field( 'hsw_headline_accent' );
$steps           = get_field( 'hsw_steps' );
$bg_photo_id     = get_field( 'hsw_bg_photo' );
$cutout_id       = get_field( 'hsw_subject_cutout' );
$copy_line_1     = get_field( 'hsw_copy_line_1' );
$copy_line_2     = get_field( 'hsw_copy_line_2' );
$copy_accent     = get_field( 'hsw_copy_accent' );
$integrations    = get_field( 'hsw_integrations' );
$badge_text      = get_field( 'hsw_badge_text' );
$badge_icon_id   = get_field( 'hsw_badge_icon' );
?>
<section class="hsw">
	<div class="hsw__inner container">
		<div class="hsw__heading" data-animate>
			<?php if ( $eyebrow ) : ?>
				<p class="hsw__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="hsw__headline">
				<?php /* Reversed from most other sections: the FIRST span is orange, the second is ink — confirmed against Figma. */ ?>
				<span class="hsw__headline-orange"><?php echo esc_html( $headline_main ); ?></span>
				<span class="hsw__headline-ink"><?php echo esc_html( $headline_accent ); ?></span>
			</h2>
		</div>

		<div class="hsw__steps-backing" aria-hidden="true"></div>

		<?php if ( $steps ) : ?>
			<div class="hsw__steps-face" data-animate-group>
				<div class="hsw__steps-face-bg" aria-hidden="true"></div>
				<ul class="hsw__steps">
					<?php foreach ( $steps as $i => $step ) : ?>
						<?php
						$icon_id = $step['icon'] ?? null;
						$number  = $step['number'] ?? '';
						$title   = $step['title'] ?? '';
						$body    = $step['body'] ?? '';
						?>
						<li class="hsw__step">
							<div class="hsw__step-inner" data-animate>
								<div class="hsw__step-icon-wrap">
									<div class="hsw__step-tile">
										<?php if ( $icon_id ) : ?>
											<?php
											echo wp_get_attachment_image(
												$icon_id,
												'full',
												false,
												array( 'class' => 'hsw__step-icon', 'alt' => '' )
											);
											?>
										<?php endif; ?>
									</div>
									<span class="hsw__step-badge"><?php echo esc_html( $number ); ?></span>
								</div>
								<p class="hsw__step-title"><?php echo esc_html( $title ); ?></p>
								<p class="hsw__step-body"><?php echo esc_html( $body ); ?></p>
							</div>
						</li>
						<?php if ( $i < count( $steps ) - 1 ) : ?>
							<li class="hsw__connector" aria-hidden="true">
								<span class="hsw__connector-line"></span>
								<?php
								echo wp_get_attachment_image(
									SNAP_HSW_CONNECTOR_CHEVRON_ID,
									'full',
									false,
									array( 'class' => 'hsw__connector-chevron', 'alt' => '' )
								);
								?>
								<span class="hsw__connector-line"></span>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="hsw__integration-backing" aria-hidden="true"></div>

		<div class="hsw__integration-face" data-animate-group>
			<?php if ( $bg_photo_id ) : ?>
				<div class="hsw__integration-photo-frame">
					<?php
					echo wp_get_attachment_image(
						$bg_photo_id,
						'full',
						false,
						array(
							'class' => 'hsw__integration-photo',
							'sizes' => '(max-width: 960px) 100vw, 1172px',
						)
					);
					?>
					<div class="hsw__integration-gradient" aria-hidden="true"></div>
					<?php if ( $cutout_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$cutout_id,
							'full',
							false,
							array(
								'class' => 'hsw__integration-cutout',
								'alt'   => '',
								'sizes' => '(max-width: 960px) 100vw, 353px',
							)
						);
						?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="hsw__integration-copy" data-animate>
				<?php if ( $copy_line_1 ) : ?><span class="hsw__integration-copy-line"><?php echo esc_html( $copy_line_1 ); ?></span><?php endif; ?>
				<?php if ( $copy_line_2 ) : ?><span class="hsw__integration-copy-line"><?php echo esc_html( $copy_line_2 ); ?></span><?php endif; ?>
				<?php if ( $copy_accent ) : ?>
					<span class="hsw__integration-copy-accent">
						<?php echo esc_html( $copy_accent ); ?>
						<?php
						echo wp_get_attachment_image(
							SNAP_HSW_COPY_UNDERLINE_ID,
							'full',
							false,
							array( 'class' => 'hsw__integration-copy-underline', 'alt' => '' )
						);
						?>
					</span>
				<?php endif; ?>
			</div>

			<div class="hsw__integration-footer">
				<?php if ( $integrations ) : ?>
					<ul class="hsw__integrations" data-animate>
						<?php foreach ( $integrations as $integration ) : ?>
							<?php
							$icon_id       = $integration['icon'] ?? null;
							$name          = $integration['name'] ?? '';
							$show_initials = ! empty( $integration['show_initials'] );
							?>
							<?php if ( $icon_id ) : ?>
								<li class="hsw__integration-item">
									<?php
									echo wp_get_attachment_image(
										$icon_id,
										'full',
										false,
										array( 'class' => 'hsw__integration-icon', 'alt' => $name )
									);
									?>
									<?php if ( $show_initials ) : ?>
										<span class="hsw__integration-initials"><?php echo esc_html( $name ); ?></span>
									<?php endif; ?>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( $badge_text ) : ?>
				<div class="hsw__badge">
					<div class="hsw__badge-inner" data-animate>
						<?php if ( $badge_icon_id ) : ?>
							<?php
							echo wp_get_attachment_image(
								$badge_icon_id,
								'full',
								false,
								array( 'class' => 'hsw__badge-icon', 'alt' => '' )
							);
							?>
						<?php endif; ?>
						<p class="hsw__badge-text"><?php echo esc_html( $badge_text ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
