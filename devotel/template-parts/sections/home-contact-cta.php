<?php
/**
 * Homepage section: contact-cta (converted from Elementor widgets).
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$kicker = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_contact_kicker' ) : '';
$title  = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_contact_title' ) : '';
$text   = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_contact_text' ) : '';

$kicker = $kicker ? $kicker : 'Contact us';
$title  = $title ? $title : 'Let’s discuss your project';
$text   = $text ? $text : 'Discover how our SMS API can enhance your messaging strategy in a 15-minute conversation with one of our experts. No commitments, just insights.';
?>
<section class="devotel-section devotel-section--contact-cta devotel-contact-cta" aria-label="contact-cta">
	<div class="devotel-container">
		<p class="devotel-contact-cta__kicker"><?php echo esc_html( $kicker ); ?></p>
		<h3 class="devotel-contact-cta__title"><?php echo esc_html( $title ); ?></h3>
		<p class="devotel-contact-cta__text"><?php echo esc_html( $text ); ?></p>
		<div class="devotel-contact-cta__actions">
			<a class="devotel-btn" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
				<?php esc_html_e( 'Talk to an expert', 'devotel' ); ?>
			</a>
			<a class="devotel-btn devotel-btn--secondary" href="mailto:sales@devotel.com">sales@devotel.com</a>
		</div>
	</div>
</section>
