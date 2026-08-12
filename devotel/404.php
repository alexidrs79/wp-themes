<?php
/**
 * 404 template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$illustration_path = WP_CONTENT_DIR . '/uploads/2025/11/Frame-2147227571.svg';
$illustration_url  = file_exists( $illustration_path )
	? content_url( 'uploads/2025/11/Frame-2147227571.svg' )
	: 'https://devotel.com/wp-content/uploads/2025/11/Frame-2147227571.svg';
?>
<section class="devotel-404" aria-labelledby="devotel-404-title">
	<img
		class="devotel-404__illustration"
		src="<?php echo esc_url( $illustration_url ); ?>"
		alt=""
		width="634"
		height="260"
		loading="eager"
		decoding="async"
	>
	<h1 id="devotel-404-title" class="devotel-404__title">
		<?php esc_html_e( 'Page not found!', 'devotel' ); ?>
	</h1>
	<p class="devotel-404__text">
		<?php esc_html_e( 'Sorry, the page you are looking for doesn\'t exist. Head back to our home page or tell us what you were looking for.', 'devotel' ); ?>
	</p>
	<div class="devotel-404__actions">
		<a class="devotel-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Homepage', 'devotel' ); ?>
		</a>
		<a class="devotel-btn devotel-btn--secondary" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
			<?php esc_html_e( 'Contact Us', 'devotel' ); ?>
		</a>
	</div>
</section>
<?php
get_footer();
