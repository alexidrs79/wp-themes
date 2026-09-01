<?php
/**
 * Template part: Pricing section.
 * Figma: node 15532:491 ("Section 06 — Pricing").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline = get_field( 'pricing_headline' );
$sub      = get_field( 'pricing_sub' );
$tiers    = get_field( 'pricing_tiers' );
?>
<section class="pricing" id="pricing">
	<div class="container">
		<h2 class="pricing__headline" data-animate><?php echo esc_html( $headline ); ?></h2>
		<p class="pricing__sub" data-animate><?php echo esc_html( $sub ); ?></p>

		<?php if ( $tiers ) : ?>
			<div class="pricing__grid">
				<?php foreach ( $tiers as $tier ) : ?>
					<?php $featured = ! empty( $tier['featured'] ); ?>
					<div class="pricing__card<?php echo $featured ? ' pricing__card--featured' : ''; ?>" data-animate>
						<?php if ( ! empty( $tier['badge'] ) ) : ?>
							<span class="pricing__badge"><?php echo esc_html( $tier['badge'] ); ?></span>
						<?php endif; ?>
						<p class="pricing__tier-name"><?php echo esc_html( $tier['name'] ?? '' ); ?></p>
						<p class="pricing__price">
							<?php echo esc_html( $tier['price'] ?? '' ); ?>
							<span class="pricing__per"><?php echo esc_html( $tier['per'] ?? '' ); ?></span>
						</p>
						<p class="pricing__description"><?php echo esc_html( $tier['description'] ?? '' ); ?></p>
						<span class="pricing__divider"></span>
						<?php if ( ! empty( $tier['features'] ) ) : ?>
							<ul class="pricing__features">
								<?php foreach ( $tier['features'] as $feature ) : ?>
									<li>
										<?php lucibook_print_icon( $featured ? 'LUCIBOOK_PRICING_CHECK_WHITE_ID' : 'LUCIBOOK_PRICING_CHECK_BLUE_ID', 'pricing__feature-icon' ); ?>
										<?php echo esc_html( $feature['label'] ?? '' ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<a class="btn <?php echo $featured ? 'btn--white' : 'btn--primary'; ?> pricing__cta" href="<?php echo esc_url( lucibook_resolve_theme_url( $tier['cta_url'] ?? '#' ) ); ?>">
							<?php echo esc_html( $tier['cta_label'] ?? '' ); ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
