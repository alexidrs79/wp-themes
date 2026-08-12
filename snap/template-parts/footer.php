<?php
/**
 * Template part: Site-wide Footer.
 * Figma: node 15150:2322 ("Footer" / "Frame 62"), 1440x397, full-bleed
 * dark background (#111315).
 *
 * ACF fields live on the site-wide Theme Settings options page
 * (SNAP_THEME_SETTINGS_PAGE_ID), not per-post content — see
 * inc/acf-fields-theme-settings.php. Columns are a real ACF Pro
 * repeater-of-repeaters (footer_columns > links), so editors add/remove
 * columns and links independently in wp-admin. The tagline field is
 * shared with the header's logo/tagline tab (theme_site_tagline), not a
 * separate footer-only field.
 *
 * Figma positions the whole content block at x=114 (not the sitewide
 * x=100 used by every other section on the page) as a fixed offset —
 * asymmetric against the 1440 frame (114 left / 86 right), so it isn't
 * a centered container at all in the source. Reproducing that literally
 * would break at any viewport other than the 1440 reference. Uses the
 * sitewide responsive .container instead (centers at ~x=100), trading a
 * ~14px discrepancy from the literal reference numbers for a footer
 * that actually works at other widths, consistent with every section
 * above it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings_id = SNAP_THEME_SETTINGS_PAGE_ID;

$tagline     = get_field( 'theme_site_tagline', $settings_id );
$columns     = (array) get_field( 'footer_columns', $settings_id );
$rights_text = get_field( 'footer_rights_text', $settings_id );
$credit      = get_field( 'footer_credit', $settings_id );
?>
<footer class="site-footer">
	<div class="site-footer__inner container">
		<div class="site-footer__top">
			<div class="site-footer__brand">
				<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php snap_print_icon( 'SNAP_FOOTER_LOGO_ID', 'site-footer__logo-img' ); ?>
				</a>
				<?php if ( $tagline ) : ?>
					<p class="site-footer__tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $columns ) : ?>
				<div class="site-footer__columns">
					<?php foreach ( $columns as $column ) : ?>
						<?php if ( empty( $column['heading'] ) ) { continue; } ?>
						<div class="site-footer__column">
							<p class="site-footer__column-heading"><?php echo esc_html( $column['heading'] ); ?></p>
							<ul class="site-footer__column-links">
								<?php foreach ( (array) ( $column['links'] ?? array() ) as $link_row ) : ?>
									<?php $link = $link_row['link'] ?? null; ?>
									<?php if ( ! empty( $link['url'] ) ) : ?>
										<li>
											<a
												class="site-footer__link"
												href="<?php echo esc_url( $link['url'] ); ?>"
												<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '"' : ''; ?>
											><?php echo esc_html( $link['title'] ); ?></a>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="site-footer__bottom">
			<div class="site-footer__legal">
				<p class="site-footer__copyright">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $rights_text ); ?>
				</p>
				<nav class="site-footer__legal-links" aria-label="Legal">
					<a href="<?php echo esc_url( get_privacy_policy_url() ); ?>">Privacy Policy</a>
					<?php if ( defined( 'SNAP_TERMS_OF_SERVICE_PAGE_ID' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( SNAP_TERMS_OF_SERVICE_PAGE_ID ) ); ?>">Terms of Service</a>
					<?php endif; ?>
				</nav>
			</div>
			<?php if ( $credit ) : ?>
				<p class="site-footer__credit"><?php echo esc_html( $credit ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</footer>
