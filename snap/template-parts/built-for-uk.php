<?php
/**
 * Template part: "Designed Around UK Accounting Workflows" section.
 * Figma: node 15150:1739 ("Background"), 1440x1214, positioned at page y:3926.
 *
 * Frame x:100 is again exactly the .container's left edge on a 1440px
 * canvas, so this whole section — photo, headline, the 6-card grid, and the
 * statement strip — is one percentage-positioned box (matching the hero/
 * Problem/Meet Snap technique) sized to the union of all of it: 1240x964
 * (x:100-1340, y:131-1095 in frame-local coordinates).
 *
 * Each card is a color-backing-peeking-behind-a-white-card pair, same
 * pattern as the hero illustration and header bar — the orange backing is a
 * flat, unshadowed CSS fill (not an ACF field), offset 5px up/left from the
 * white card that sits on top of it.
 *
 * Figma has TWO nearly-identical "Supporting Copy" frames here (15150:1744
 * and 15150:1773) with the exact same two sentences. Only 15150:1773 (the
 * orange one) is actually visible in Figma's own rendered screenshot —
 * 15150:1744 (black, slightly different size/position) is a leftover
 * design-iteration duplicate fully hidden behind it, so only one strip is
 * rendered here, using 15150:1773's styling.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow        = get_field( 'uk_eyebrow' );
$headline_line1 = get_field( 'uk_headline_line_1' );
$headline_line2 = get_field( 'uk_headline_line_2' );
$photo_id       = get_field( 'uk_photo' );
$cards          = get_field( 'uk_cards' );
$statement_1    = get_field( 'uk_statement_1' );
$statement_2    = get_field( 'uk_statement_2' );
?>
<section class="built-for-uk" id="built-for-uk">
	<div class="built-for-uk__inner container">
		<div class="built-for-uk__visual">
			<div class="built-for-uk__intro-group" data-animate-group>
				<?php if ( $photo_id ) : ?>
					<div class="built-for-uk__photo-frame" data-animate>
						<?php
						echo wp_get_attachment_image(
							$photo_id,
							'full',
							false,
							array(
								'class' => 'built-for-uk__photo',
								'sizes' => '(max-width: 1240px) 100vw, 1240px',
							)
						);
						?>
						<div class="built-for-uk__photo-gradient" aria-hidden="true"></div>
					</div>
				<?php endif; ?>

				<div class="built-for-uk__text-block">
					<?php if ( $eyebrow ) : ?>
						<p class="built-for-uk__eyebrow" data-animate><?php echo esc_html( $eyebrow ); ?></p>
					<?php endif; ?>

					<h2 class="built-for-uk__headline" data-animate>
						<span class="built-for-uk__headline-line"><?php echo esc_html( $headline_line1 ); ?></span>
						<span class="built-for-uk__headline-line"><?php echo esc_html( $headline_line2 ); ?></span>
					</h2>
				</div>
			</div>

			<?php if ( $cards ) : ?>
				<ul class="built-for-uk__cards" data-animate-group>
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$icon_id = $card['icon'] ?? null;
						$title   = $card['title'] ?? '';
						?>
						<li class="built-for-uk__card" data-animate>
							<div class="built-for-uk__card-backing" aria-hidden="true"></div>
							<div class="built-for-uk__card-face card-hover-lift">
								<?php if ( $icon_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										$icon_id,
										'full',
										false,
										array( 'class' => 'built-for-uk__card-icon', 'alt' => '' )
									);
									?>
								<?php endif; ?>
								<p class="built-for-uk__card-title"><?php echo esc_html( $title ); ?></p>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $statement_1 || $statement_2 ) : ?>
				<div class="built-for-uk__statement" data-animate>
					<?php if ( $statement_1 ) : ?>
						<p class="built-for-uk__statement-1"><?php echo esc_html( $statement_1 ); ?></p>
					<?php endif; ?>
					<?php if ( $statement_2 ) : ?>
						<p class="built-for-uk__statement-2"><?php echo esc_html( $statement_2 ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
