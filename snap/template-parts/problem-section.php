<?php
/**
 * Template part: "The Problem" section.
 * Figma: node 15150:1708 ("Frame 37"), 1440x689, positioned at page y:953.
 *
 * Frame 37's content region maps exactly onto the site's .container: its
 * left-column text starts at frame x:100, which is precisely the container's
 * left edge on a 1440px canvas (min(1240, 1440-48) centered → 100px inset).
 * So positions below are given container-relative (figma_x - 100).
 *
 * The photo (15150:1713) and its orange backing (15150:1712) overlap the
 * pain-point list the same way the hero's document stack overlaps its photo,
 * so — like the hero — that cluster is a position:relative box with children
 * placed by percentage, computed from the union bounding box of all three
 * (backing, photo, pain-point list): x:546-1240, y:144-569 (694x425).
 *
 * Node 15150:1712 is a flat, unshadowed orange fill with no image content
 * (confirmed: it contributed zero raw images on export) — same as the
 * hero's illustration backdrop — so it's a CSS div, not an ACF image field;
 * only the real photo (15150:1713) needs one.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow          = get_field( 'problem_eyebrow' );
$headline_main    = get_field( 'problem_headline_main' );
$headline_accent  = get_field( 'problem_headline_accent' );
$intro            = get_field( 'problem_intro' );
$photo_id         = get_field( 'problem_photo' );
$points           = get_field( 'problem_points' );
?>
<section class="problem">
	<div class="problem__inner container">
		<div class="problem__content" data-animate>
			<?php if ( $eyebrow ) : ?>
				<p class="problem__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="problem__headline">
				<span class="problem__headline-line"><?php echo esc_html( $headline_main ); ?></span>
				<span class="problem__headline-line problem__headline-line--accent"><?php echo esc_html( $headline_accent ); ?></span>
			</h2>

			<?php if ( $intro ) : ?>
				<p class="problem__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>

		<div class="problem__visual" data-animate-group>
			<div class="problem__photo-wrap">
				<div class="problem__photo-backing" aria-hidden="true"></div>

				<?php if ( $photo_id ) : ?>
					<div class="problem__photo-frame" data-animate>
						<?php
						echo wp_get_attachment_image(
							$photo_id,
							'full',
							false,
							array(
								'class' => 'problem__photo',
								'sizes' => '(max-width: 960px) 100vw, 694px',
							)
						);
						?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $points ) : ?>
				<ul class="problem__points">
					<?php foreach ( $points as $point ) : ?>
						<?php
						$icon_id = $point['icon'] ?? null;
						$label   = $point['label'] ?? '';
						?>
						<li class="problem__point" data-animate>
							<?php if ( $icon_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$icon_id,
									'full',
									false,
									array( 'class' => 'problem__point-icon', 'alt' => '' )
								);
								?>
							<?php endif; ?>
							<span class="problem__point-label"><?php echo esc_html( $label ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
