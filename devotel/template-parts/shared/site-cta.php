<?php
/**
 * Shared bottom CTA band (matches about-us elementor-element-1dd90da).
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$uploads      = wp_upload_dir();
$base         = trailingslashit( $uploads['baseurl'] );
$primary_url  = function_exists( 'devotel_get_header_cta_url' ) ? devotel_get_header_cta_url() : home_url( '/contact-us/' );
$primary_text = function_exists( 'devotel_get_theme_option' ) ? devotel_get_theme_option( 'devotel_header_cta_text', '' ) : '';
$primary_text = $primary_text ? $primary_text : __( 'Talk to an expert', 'devotel' );
$video        = $base . '2025/11/logo-alpha.webm';
$video_mob    = $base . '2026/01/logo-alpha-mobile.webm';
?>
<div class="elementor-element elementor-element-1dd90da e-con-full e-flex e-con e-parent devotel-site-cta-wrap" data-id="1dd90da" data-element_type="container">
	<section class="relative w-full overflow-hidden devotel-site-cta">
		<div class="cta-section-container">
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
			<div class="content-wrapper relative z-10">
				<div class="flex flex-col items-start gap-8">
					<h2 class="font-duplet font-semibold text-white text-left">
						<?php esc_html_e( 'Ready to Transform Your Customer Communications?', 'devotel' ); ?>
					</h2>
					<div class="button">
						<a href="<?php echo esc_url( $primary_url ); ?>" class="button2">
							<div class="content">
								<span class="talk-to-an"><?php echo esc_html( $primary_text ); ?></span>
								<svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none" aria-hidden="true">
									<path d="M4.16406 10H15.8307" stroke="currentColor" stroke-width="1.66566" stroke-linecap="round" stroke-linejoin="round" />
									<path d="M10 4.16699L15.8333 10.0003L10 15.8337" stroke="currentColor" stroke-width="1.66566" stroke-linecap="round" stroke-linejoin="round" />
								</svg>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
