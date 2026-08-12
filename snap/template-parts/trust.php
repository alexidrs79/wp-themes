<?php
/**
 * Template part: Trust strip.
 *
 * Sits between the hero and "The Problem" (Frame 37, y:953). Figma has no
 * real design here — only a placeholder note ("need a trust section or
 * something separator") — so this is built from the existing design tokens
 * (color, type scale, spacing) rather than introducing new styles, and kept
 * deliberately quiet: a transition strip, not another hero moment.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stat_line = get_field( 'trust_stat_line' );
$logos     = get_field( 'trust_logos' );

if ( ! $stat_line && ! $logos ) {
	return;
}
?>
<section class="trust">
	<div class="trust__inner">
		<div class="trust__card" data-animate-group>
			<?php if ( $stat_line ) : ?>
				<p class="trust__stat" data-animate><?php echo esc_html( $stat_line ); ?></p>
			<?php endif; ?>

			<?php if ( $logos ) : ?>
				<ul class="trust__logos">
					<?php foreach ( $logos as $logo ) : ?>
						<?php
						$logo_id  = $logo['logo'] ?? null;
						$logo_url = $logo['link'] ?? '';

						if ( ! $logo_id ) {
							continue;
						}

						$logo_img = wp_get_attachment_image(
							$logo_id,
							'medium',
							false,
							array( 'class' => 'trust__logo', 'loading' => 'lazy' )
						);
						?>
						<li class="trust__logo-item" data-animate>
							<?php if ( $logo_url ) : ?>
								<a href="<?php echo esc_url( $logo_url ); ?>" class="trust__logo-link">
									<?php echo $logo_img; ?>
								</a>
							<?php else : ?>
								<?php echo $logo_img; ?>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>
