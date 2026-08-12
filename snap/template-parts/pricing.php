<?php
/**
 * Template part: Pricing page content.
 *
 * No Figma design exists for this page — assembled from patterns already
 * established across the site rather than inventing new ones:
 * - eyebrow + headline + card style: same reuse as the Contact page
 *   (bold orange eyebrow / heavy-weight headline; the hard-shadow
 *   "neubrutalist" card — 1.702px black border + a crisp -2px/-2px
 *   offset shadow — borrowed from the Real Usecases row icon badges).
 * - checkmark icon: reuses the exact same asset as the More Than OCR
 *   section's "Snap understands" column (SNAP_OCR_ICON_CHECK_ID) — a
 *   single self-contained orange circle+check SVG, not a new icon.
 * - buttons: .btn + .btn-stack-hover, the same component/hover-layer
 *   used everywhere else, not a new button style.
 * - FAQ is a button + animated panel (grid-template-rows 0fr/1fr, see
 *   assets/js/faq-accordion.js) rather than native <details>/<summary> —
 *   swapped in so open/close can animate smoothly; <details> can't
 *   transition its display:none/block toggle. Multiple items can stay
 *   open at once (no shared exclusivity), matching the <details> version's
 *   original behavior before this change.
 * - entrance animation: [data-animate]/[data-animate-group] only.
 *
 * Tiers and FAQ are real ACF Pro repeaters (see inc/acf-fields-pricing.php)
 * — each tier's own feature list is a nested repeater, and one tier is
 * marked "Featured" via its own true/false field rather than a fixed
 * tier-2-is-always-highlighted assumption.
 *
 * The closing CTA is template-parts/cta-simple.php — a no-form variant
 * of the landing page's CTA/Demo Form section, with its own field group
 * (inc/acf-fields-pricing-cta.php) so it's independently editable.
 *
 * PLACEHOLDER CONTENT — flagged here and in the ACF admin UI, review
 * before launch:
 * - All 3 tier prices, names, descriptions, and every feature line.
 * - All 5 FAQ questions and answers.
 * - The pricing subhead ("No hidden fees. Cancel anytime.").
 * - The closing CTA's headline, supporting copy, and button label.
 * Everything else (headline copy, layout, component choices) is
 * intended to ship as-is.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'pricing_eyebrow' );
$headline = get_field( 'pricing_headline' );
$subhead  = get_field( 'pricing_subhead' );

$tiers = array_filter( (array) get_field( 'pricing_tiers' ), function ( $tier ) {
	return ! empty( $tier['name'] );
} );

$faqs = array_filter( (array) get_field( 'pricing_faq' ), function ( $faq ) {
	return ! empty( $faq['question'] );
} );

?>
<section class="pricing-hero">
	<div class="pricing-hero__inner container" data-animate-group>
		<?php if ( $eyebrow ) : ?>
			<p class="pricing-hero__eyebrow" data-animate><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<h1 class="pricing-hero__headline" data-animate><?php echo esc_html( $headline ); ?></h1>

		<?php if ( $subhead ) : ?>
			<p class="pricing-hero__subhead" data-animate><?php echo esc_html( $subhead ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="pricing-tiers">
	<div class="pricing-tiers__inner container" data-animate-group>
		<?php foreach ( $tiers as $tier_data ) : ?>
			<?php
			$featured = ! empty( $tier_data['featured'] );

			$features = array_filter( array_map(
				function ( $row ) {
					return $row['feature'] ?? '';
				},
				(array) ( $tier_data['features'] ?? array() )
			) );

			$card_class = 'pricing-tier' . ( $featured ? ' pricing-tier--featured' : '' );
			$btn_class  = $featured ? 'btn--primary' : 'btn--secondary';
			$layer_mod  = $featured ? 'btn__stack-back--black' : 'btn__stack-back--orange';
			?>
			<div class="<?php echo esc_attr( $card_class ); ?>" data-animate>
				<?php if ( ! empty( $tier_data['badge'] ) ) : ?>
					<span class="pricing-tier__badge"><?php echo esc_html( $tier_data['badge'] ); ?></span>
				<?php endif; ?>

				<h2 class="pricing-tier__name"><?php echo esc_html( $tier_data['name'] ); ?></h2>

				<?php if ( ! empty( $tier_data['description'] ) ) : ?>
					<p class="pricing-tier__description"><?php echo esc_html( $tier_data['description'] ); ?></p>
				<?php endif; ?>

				<p class="pricing-tier__price">
					<span class="pricing-tier__price-amount"><?php echo esc_html( $tier_data['price'] ?? '' ); ?></span>
					<?php if ( ! empty( $tier_data['price_suffix'] ) ) : ?>
						<span class="pricing-tier__price-suffix"><?php echo esc_html( $tier_data['price_suffix'] ); ?></span>
					<?php endif; ?>
				</p>

				<?php if ( ! empty( $tier_data['button_label'] ) ) : ?>
					<span class="btn-stack-hover pricing-tier__cta">
						<span class="btn__stack-back <?php echo esc_attr( $layer_mod ); ?>" aria-hidden="true"></span>
						<a class="btn <?php echo esc_attr( $btn_class ); ?>" href="<?php echo esc_url( $tier_data['button_url'] ?? '#' ); ?>">
							<span><?php echo esc_html( $tier_data['button_label'] ); ?></span>
						</a>
					</span>
				<?php endif; ?>

				<?php if ( $features ) : ?>
					<ul class="pricing-tier__features">
						<?php foreach ( $features as $feature ) : ?>
							<li class="pricing-tier__feature">
								<?php snap_print_icon( 'SNAP_OCR_ICON_CHECK_ID', 'pricing-tier__feature-icon' ); ?>
								<span><?php echo esc_html( $feature ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<?php if ( $faqs ) : ?>
	<section class="pricing-faq">
		<div class="pricing-faq__inner container" data-animate-group>
			<h2 class="pricing-faq__heading" data-animate>Frequently asked questions</h2>

			<div class="pricing-faq__list">
				<?php foreach ( $faqs as $i => $faq ) : ?>
					<?php $panel_id = 'pricing-faq-panel-' . $i; ?>
					<div class="pricing-faq__item" data-animate>
						<h3 class="pricing-faq__question-wrap">
							<button
								type="button"
								class="pricing-faq__question"
								aria-expanded="false"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>"
							>
								<span class="pricing-faq__question-text"><?php echo esc_html( $faq['question'] ); ?></span>
								<span class="pricing-faq__icon" aria-hidden="true"></span>
							</button>
						</h3>
						<div id="<?php echo esc_attr( $panel_id ); ?>" class="pricing-faq__panel" role="region">
							<div class="pricing-faq__panel-inner">
								<p class="pricing-faq__answer"><?php echo esc_html( $faq['answer'] ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta-simple' ); ?>
