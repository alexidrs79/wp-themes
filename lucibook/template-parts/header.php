<?php
/**
 * Template part: Site header.
 * Figma: node 15532:80 ("Header").
 *
 * Logo, nav items, "Log in" link, the CTA button, and the sticky-header
 * toggle are all ACF fields on the site-wide Theme Settings options page
 * (LUCIBOOK_THEME_SETTINGS_PAGE_ID) — see inc/acf-fields-theme-settings.php.
 * Same structure as the Snap theme's header (mobile hamburger + slide-in
 * panel built from the same nav data, driven by assets/js/mobile-menu.js).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$settings_id = LUCIBOOK_THEME_SETTINGS_PAGE_ID;

$site_logo_id = get_field( 'theme_site_logo', $settings_id );
$nav_items    = array_filter(
	(array) get_field( 'theme_nav_items', $settings_id ),
	function ( $item ) {
		return ! empty( $item['label'] );
	}
);

$login_label = get_field( 'theme_login_label', $settings_id );
$login_url   = get_field( 'theme_login_url', $settings_id );
$cta_label   = get_field( 'theme_header_cta_label', $settings_id );
$cta_url     = get_field( 'theme_header_cta_url', $settings_id );

$sticky_enabled = get_field( 'theme_sticky_header_enabled', $settings_id );
$header_class   = 'site-header' . ( $sticky_enabled ? '' : ' site-header--static' );
?>
<header class="<?php echo esc_attr( $header_class ); ?>">
	<div class="site-header__bar container">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
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

		<nav class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'lucibook' ); ?>">
			<?php foreach ( $nav_items as $item ) : ?>
				<a href="<?php echo esc_url( lucibook_resolve_theme_url( $item['url'] ?? '' ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
		</nav>

		<div class="site-header__actions">
			<?php if ( $login_label ) : ?>
				<a class="site-header__login-link" href="<?php echo esc_url( lucibook_resolve_theme_url( $login_url ) ); ?>"><?php echo esc_html( $login_label ); ?></a>
			<?php endif; ?>
			<?php if ( $cta_label ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
					<?php echo esc_html( $cta_label ); ?>
				</a>
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

		<nav class="mobile-menu-panel__nav" aria-label="<?php esc_attr_e( 'Mobile primary', 'lucibook' ); ?>">
			<?php foreach ( $nav_items as $item ) : ?>
				<a href="<?php echo esc_url( lucibook_resolve_theme_url( $item['url'] ?? '' ) ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
			<?php endforeach; ?>
			<?php if ( $login_label ) : ?>
				<a class="mobile-menu-panel__talk-link" href="<?php echo esc_url( lucibook_resolve_theme_url( $login_url ) ); ?>"><?php echo esc_html( $login_label ); ?></a>
			<?php endif; ?>
		</nav>

		<?php if ( $cta_label ) : ?>
			<div class="mobile-menu-panel__cta">
				<a class="btn btn--primary mobile-menu-panel__cta-btn" href="<?php echo esc_url( lucibook_resolve_theme_url( $cta_url ) ); ?>">
					<?php echo esc_html( $cta_label ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</header>
