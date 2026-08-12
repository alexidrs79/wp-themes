<?php
/**
 * Homepage section: final-cta
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_title = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_final_cta_title' ) : '';
$cta_text  = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_final_cta_text' ) : '';
$cta_btn   = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_final_cta_button' ) : '';

$cta_title = $cta_title ? $cta_title : "Enhance and Scale Your Communication Today with Devotel's solutions";
$cta_text  = $cta_text ? $cta_text : 'Join 500+ companies who chose us for reliable, customizable, and carrier-grade solutions worldwide.';
$cta_btn   = $cta_btn ? $cta_btn : 'Start now';
?>
<section class="devotel-section devotel-section--final_cta devotel-native-final-cta" aria-label="final-cta">
	<div class="devotel-container">
		<div class="devotel-native-final-cta__inner">
			<h2><?php echo esc_html( $cta_title ); ?></h2>
			<p><?php echo esc_html( $cta_text ); ?></p>
			<a class="devotel-btn" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
				<?php echo esc_html( $cta_btn ); ?>
			</a>
		</div>
	</div>
</section>
