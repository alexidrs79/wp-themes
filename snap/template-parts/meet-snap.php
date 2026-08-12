<?php
/**
 * Template part: "Meet Snap" section.
 * Figma: node 15150:1666 ("Frame 38"), 1440x1152, positioned at page y:1642.
 *
 * Like the Problem section, frame x:100 is exactly the .container's left
 * edge on a 1440px canvas, and the orange card (15150:1669) is x:100,
 * width:1240 — i.e. it IS the container, full width. So the card, the
 * illustration photo and the 4 step cards are all positioned as percentages
 * of that 1240x527 box, container-relative.
 *
 * The illustration (15150:1707) and step card 1 (Frame 22) both extend
 * above the orange card's top edge, and step card 4 (Frame 25) extends
 * below its bottom edge — confirmed against the Figma screenshot, not a
 * clipping bug — so the card box must NOT have overflow: hidden.
 *
 * Node 15150:1669 is a flat, unshadowed orange fill with no image content —
 * same CSS-div pattern as the hero backdrop and the Problem section's photo
 * backing — so it isn't an ACF image field. It's a separate child
 * (.meet-snap__card-bg) from the positioning ancestor (.meet-snap__visual)
 * rather than being the bordered ancestor itself — a bordered element's
 * padding-box (the containing block percentages resolve against) is
 * smaller than its declared size by the border width, which was quietly
 * shrinking every percentage-positioned child by a couple of pixels.
 *
 * The 4 step cards are staggered, not gridded, so their position/size is
 * fixed CSS tied to repeater row order (nth-child), not computed from
 * content — reordering rows in wp-admin moves content between the 4 fixed
 * slots rather than reflowing a grid.
 *
 * Each card is split into .meet-snap__step (positioned/animated outer <li>)
 * and .meet-snap__step-face (visual card, .card-hover-lift hover target) so
 * the scroll-entrance transform (on the <li>) and the hover-lift transform
 * (on the face) are on different elements — same property, same element
 * would fight over one `transition` duration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow        = get_field( 'meet_eyebrow' );
$heading_main   = get_field( 'meet_heading_main' );
$heading_accent = get_field( 'meet_heading_accent' );
$intro          = get_field( 'meet_intro' );
$photo_id       = get_field( 'meet_photo' );
$steps          = get_field( 'meet_steps' );
?>
<section class="meet-snap" id="meet-snap">
	<div class="meet-snap__inner container">
		<div class="meet-snap__heading-group" data-animate>
			<?php if ( $eyebrow ) : ?>
				<p class="meet-snap__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="meet-snap__heading">
				<span class="meet-snap__heading-line"><?php echo esc_html( $heading_main ); ?></span>
				<span class="meet-snap__heading-line meet-snap__heading-line--accent"><?php echo esc_html( $heading_accent ); ?></span>
			</h2>

			<?php if ( $intro ) : ?>
				<p class="meet-snap__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>
		</div>

		<div class="meet-snap__visual" data-animate-group>
			<div class="meet-snap__card-bg" aria-hidden="true"></div>

			<?php if ( $photo_id ) : ?>
				<div class="meet-snap__photo-frame" data-animate>
					<?php
					echo wp_get_attachment_image(
						$photo_id,
						'full',
						false,
						array(
							'class' => 'meet-snap__photo',
							'sizes' => '(max-width: 480px) 100vw, 571px',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<?php if ( $steps ) : ?>
				<ul class="meet-snap__steps">
					<?php foreach ( $steps as $step ) : ?>
						<?php
						$icon_id = $step['icon'] ?? null;
						$number  = $step['number'] ?? '';
						$body    = $step['body'] ?? '';
						?>
						<li class="meet-snap__step" data-animate>
							<div class="meet-snap__step-face card-hover-lift">
								<?php if ( $icon_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										$icon_id,
										'full',
										false,
										array( 'class' => 'meet-snap__step-icon', 'alt' => '' )
									);
									?>
								<?php endif; ?>

								<?php if ( $number ) : ?>
									<span class="meet-snap__step-number"><?php echo esc_html( $number ); ?></span>
								<?php endif; ?>

								<?php if ( $body ) : ?>
									<p class="meet-snap__step-body"><?php echo esc_html( $body ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
