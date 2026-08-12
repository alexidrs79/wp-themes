<?php
/**
 * Template part: Site header.
 * Figma: node 15150:1564 ("00 / Header").
 *
 * Logo, nav items, "Talk to us", the CTA button, and the sticky-header
 * toggle are all now ACF fields on the site-wide Theme Settings options
 * page (SNAP_THEME_SETTINGS_PAGE_ID) — see
 * inc/acf-fields-theme-settings.php — rather than hardcoded here or in
 * theme-setup.php's old snap_default_primary_nav() fallback (removed;
 * superseded by this). Nav items are a real ACF Pro repeater
 * (theme_nav_items), so editors add/remove/reorder rows in wp-admin.
 *
 * Below 768px (see style.css), .site-header__nav and .site-header__
 * actions' inline contents are hidden and a hamburger button
 * (.site-header__menu-toggle) appears instead, opening a slide-in panel
 * (.mobile-menu-panel) built from the same nav/talk-link/CTA data
 * already fetched above — one source of truth rendered twice, not a
 * second nav system. assets/js/mobile-menu.js drives the open/close
 * state, the backdrop, Escape-to-close, and the body-scroll lock while
 * it's open.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings_id = SNAP_THEME_SETTINGS_PAGE_ID;

$site_logo_id  = get_field( 'theme_site_logo', $settings_id );
$nav_items     = array_filter(
	(array) get_field( 'theme_nav_items', $settings_id ),
	function ( $item ) {
		return ! empty( $item['label'] );
	}
);

$talk_label = get_field( 'theme_talk_to_us_label', $settings_id );
$talk_url   = get_field( 'theme_talk_to_us_url', $settings_id );
$cta_label  = get_field( 'theme_header_cta_label', $settings_id );
$cta_url    = get_field( 'theme_header_cta_url', $settings_id );

$sticky_enabled = get_field( 'theme_sticky_header_enabled', $settings_id );
$header_class   = 'site-header' . ( $sticky_enabled ? '' : ' site-header--static' );
?>
<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="site-header__backing" aria-hidden="true"></div>
	<div class="site-header__bar container">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			// Falls back to the Customizer's Site Identity logo (still
			// registered via add_theme_support('custom-logo')), then to
			// plain site-title text, if the Theme Settings field is empty.
			$fallback_logo_id = $site_logo_id ? $site_logo_id : get_theme_mod( 'custom_logo' );
			if ( $fallback_logo_id ) {
				echo wp_get_attachment_image(
					$fallback_logo_id,
					'full',
					false,
					array( 'class' => 'site-header__logo-img' )
				);
			} else {
				bloginfo( 'name' );
			}
			?>
		</a>

		<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'snap' ); ?>">
			<?php foreach ( $nav_items as $item ) : ?>
				<a href="<?php echo esc_url( snap_resolve_theme_url( $item['url'] ?? '' ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="site-header__actions">
			<?php if ( $talk_label ) : ?>
				<a class="site-header__talk-link" href="<?php echo esc_url( snap_resolve_theme_url( $talk_url ) ); ?>"><?php echo esc_html( $talk_label ); ?></a>
			<?php endif; ?>
			<?php if ( $cta_label ) : ?>
				<span class="btn-stack-hover">
					<span class="btn__stack-back btn__stack-back--orange" aria-hidden="true"></span>
					<a class="btn btn--dark" href="<?php echo esc_url( snap_resolve_theme_url( $cta_url ) ); ?>">
						<span><?php echo esc_html( $cta_label ); ?></span>
					</a>
				</span>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="site-header__menu-toggle"
			aria-expanded="false"
			aria-controls="mobile-menu-panel"
			aria-label="Open menu"
		>
			<span class="site-header__menu-icon" aria-hidden="true"></span>
		</button>
	</div>

	<div class="mobile-menu-backdrop" data-mobile-menu-backdrop></div>

	<div class="mobile-menu-panel" id="mobile-menu-panel" aria-hidden="true">
		<div class="mobile-menu-panel__header">
			<span class="mobile-menu-panel__title">Menu</span>
			<button type="button" class="mobile-menu-panel__close" aria-label="Close menu">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>

		<nav class="mobile-menu-panel__nav" aria-label="<?php esc_attr_e( 'Mobile primary', 'snap' ); ?>">
			<?php foreach ( $nav_items as $item ) : ?>
				<a href="<?php echo esc_url( snap_resolve_theme_url( $item['url'] ?? '' ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
			<?php if ( $talk_label ) : ?>
				<a class="mobile-menu-panel__talk-link" href="<?php echo esc_url( snap_resolve_theme_url( $talk_url ) ); ?>"><?php echo esc_html( $talk_label ); ?></a>
			<?php endif; ?>
		</nav>

		<?php if ( $cta_label ) : ?>
			<div class="mobile-menu-panel__cta">
				<span class="btn-stack-hover mobile-menu-panel__cta-stack">
					<span class="btn__stack-back btn__stack-back--orange" aria-hidden="true"></span>
					<a class="btn btn--dark mobile-menu-panel__cta-btn" href="<?php echo esc_url( snap_resolve_theme_url( $cta_url ) ); ?>">
						<span><?php echo esc_html( $cta_label ); ?></span>
					</a>
				</span>
			</div>
		<?php endif; ?>
	</div>
</header>

