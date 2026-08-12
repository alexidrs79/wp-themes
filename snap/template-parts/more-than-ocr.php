<?php
/**
 * Template part: "More Than OCR" section.
 * Figma: node 15150:1588 ("04 / More Than OCR"), 1440x1120.
 *
 * Unlike the hero/Problem/Meet Snap sections, nothing here is absolutely
 * positioned — Figma's own structure is a plain flex column (heading block,
 * comparison block, statement strip, each gap:52px apart), so this section
 * is built the same simple way: normal document flow, .container for the
 * 1240px content width (frame x:100 is again exactly the container's left
 * edge on a 1440px canvas).
 *
 * The background grid (15150:1589) is a decorative full-bleed vector, not
 * page content, so it's a theme asset constant rather than an ACF field —
 * same pattern as the site-wide background grid used behind the header/hero.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow          = get_field( 'ocr_eyebrow' );
$headline_main    = get_field( 'ocr_headline_main' );
$headline_accent  = get_field( 'ocr_headline_accent' );
$supporting       = get_field( 'ocr_supporting' );
$left_title       = get_field( 'ocr_left_title' );
$left_items       = get_field( 'ocr_left_items' );
$right_title      = get_field( 'ocr_right_title' );
$right_items      = get_field( 'ocr_right_items' );
$statement_old    = get_field( 'ocr_statement_old' );
$statement_new    = get_field( 'ocr_statement_new' );
?>
<section class="more-than-ocr" id="more-than-ocr">
	<?php
	echo wp_get_attachment_image(
		SNAP_OCR_BACKGROUND_GRID_ID,
		'full',
		false,
		array( 'class' => 'more-than-ocr__bg', 'alt' => '' )
	);
	?>

	<div class="more-than-ocr__inner container">
		<div class="more-than-ocr__heading" data-animate>
			<?php if ( $eyebrow ) : ?>
				<p class="more-than-ocr__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
			<?php endif; ?>

			<h2 class="more-than-ocr__headline">
				<span class="more-than-ocr__headline-line"><?php echo esc_html( $headline_main ); ?></span>
				<span class="more-than-ocr__headline-line more-than-ocr__headline-line--accent"><?php echo esc_html( $headline_accent ); ?></span>
			</h2>

			<?php if ( $supporting ) : ?>
				<p class="more-than-ocr__supporting"><?php echo esc_html( $supporting ); ?></p>
			<?php endif; ?>
		</div>

		<div class="more-than-ocr__comparison">
			<div class="more-than-ocr__column more-than-ocr__column--left" data-animate-group>
				<?php if ( $left_title ) : ?>
					<p class="more-than-ocr__column-title" data-animate><?php echo esc_html( $left_title ); ?></p>
				<?php endif; ?>

				<?php if ( $left_items ) : ?>
					<ul class="more-than-ocr__items more-than-ocr__items--left">
						<?php foreach ( $left_items as $item ) : ?>
							<?php
							$icon_id = $item['icon'] ?? null;
							$label   = $item['label'] ?? '';
							?>
							<li class="more-than-ocr__item more-than-ocr__item--left" data-animate>
								<?php if ( $icon_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										$icon_id,
										'full',
										false,
										array( 'class' => 'more-than-ocr__item-icon', 'alt' => '' )
									);
									?>
								<?php endif; ?>
								<span class="more-than-ocr__item-label"><?php echo esc_html( $label ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="more-than-ocr__column more-than-ocr__column--right" data-animate-group>
				<?php if ( $right_title ) : ?>
					<p class="more-than-ocr__column-title" data-animate><?php echo esc_html( $right_title ); ?></p>
				<?php endif; ?>

				<?php if ( $right_items ) : ?>
					<ul class="more-than-ocr__items more-than-ocr__items--right">
						<?php foreach ( $right_items as $item ) : ?>
							<?php
							$icon_id = $item['icon'] ?? null;
							$label   = $item['label'] ?? '';
							?>
							<li class="more-than-ocr__item more-than-ocr__item--right" data-animate>
								<?php if ( $icon_id ) : ?>
									<?php
									echo wp_get_attachment_image(
										$icon_id,
										'full',
										false,
										array( 'class' => 'more-than-ocr__item-icon', 'alt' => '' )
									);
									?>
								<?php endif; ?>
								<span class="more-than-ocr__item-label"><?php echo esc_html( $label ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $statement_old || $statement_new ) : ?>
			<div class="more-than-ocr__statement" data-animate>
				<?php if ( $statement_old ) : ?>
					<p class="more-than-ocr__statement-old"><?php echo esc_html( $statement_old ); ?></p>
				<?php endif; ?>

				<p class="more-than-ocr__statement-arrow" aria-hidden="true">&rarr;</p>

				<?php if ( $statement_new ) : ?>
					<p class="more-than-ocr__statement-new"><?php echo esc_html( $statement_new ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
