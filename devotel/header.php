<?php
/**
 * Header template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?><?php echo is_front_page() ? ' data-wp-home-page="1"' : ''; ?> data-home-path="<?php echo esc_attr( trailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) ) ); ?>">
<?php wp_body_open(); ?>

<a class="screen-reader-text skip-link" href="#devotel-content">
	<?php esc_html_e( 'Skip to content', 'devotel' ); ?>
</a>

<header id="site-header" class="site-header" role="banner">
	<?php
	$header_markup = devotel_get_extracted_markup( 'header/site-header-html' );
	$has_extracted_header = ! empty( $header_markup ) && false !== stripos( $header_markup, 'header-navbar-wrapper' );
	if ( $has_extracted_header ) :
		echo $header_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	else :
		?>
		<div class="devotel-fallback-header">
			<div class="devotel-fallback-header__inner">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="devotel-fallback-header__brand">
					<?php bloginfo( 'name' ); ?>
				</a>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => 'nav',
						'menu_class'     => 'devotel-fallback-header__menu',
						'fallback_cb'    => false,
					)
				);
				?>
			</div>
		</div>
	<?php endif; ?>
</header>

<main id="devotel-content" class="site-main">

