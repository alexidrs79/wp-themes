<?php
/**
 * Single blog post bottom CTA — products-style video band.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$uploads   = wp_upload_dir();
$base      = trailingslashit( $uploads['baseurl'] );
$cta_url   = function_exists( 'devotel_get_header_cta_url' ) ? devotel_get_header_cta_url() : home_url( '/contact-us/' );
$cta_label = function_exists( 'devotel_get_theme_option' ) ? devotel_get_theme_option( 'devotel_header_cta_text', '' ) : '';
$cta_label = $cta_label ? $cta_label : __( 'Talk to an expert', 'devotel' );
$video     = $base . '2025/11/logo-alpha.webm';
$video_mob = $base . '2026/01/logo-alpha-mobile.webm';
?>
<div class="cta-main-dark devotel-blog-single-cta-band">
	<div class="cta-container">
		<div class="video-wrapper">
			<div class="video-gradient-container">
				<video autoplay loop muted playsinline>
					<source src="<?php echo esc_url( $video ); ?>" type="video/webm">
				</video>
			</div>
		</div>
		<div class="video-wrapper-mobile">
			<div class="video-gradient-container">
				<video autoplay loop muted playsinline>
					<source src="<?php echo esc_url( $video_mob ); ?>" type="video/webm">
				</video>
			</div>
		</div>
		<div class="frame-2147227717">
			<div class="ready-to-transform-your-customer-communications">
				<?php esc_html_e( 'Ready to Transform Your Customer Communications?', 'devotel' ); ?>
			</div>
			<div class="button">
				<a href="<?php echo esc_url( $cta_url ); ?>" class="button2">
					<div class="content">
						<span class="talk-to-an"><?php echo esc_html( $cta_label ); ?></span>
						<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" aria-hidden="true">
							<path d="M4.16406 10H15.8307" stroke="#ffffff" stroke-width="1.66566" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M10 4.16699L15.8333 10.0003L10 15.8337" stroke="#ffffff" stroke-width="1.66566" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
