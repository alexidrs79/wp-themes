<?php
/**
 * Homepage section: connect-network (converted from Elementor widgets).
 *
 * @package Devotel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_connect_title' ) : '';
$text  = function_exists( 'get_field' ) ? (string) get_field( 'devotel_home_connect_text' ) : '';

$title = $title ? $title : 'Connect with Every Customer and Optimise Every Network';
$text  = $text ? $text : 'Our comprehensive suite powers millions of connections monthly. From messaging and eSIM connectivity to network protection, Devotel gives enterprises and telcos everything they need to thrive globally.';
?>
<section class="devotel-section devotel-section--connect-network devotel-connect-network" aria-label="connect-network">
	<div class="devotel-container">
		<h2 class="devotel-connect-network__title"><?php echo esc_html( $title ); ?></h2>
		<p class="devotel-connect-network__text"><?php echo esc_html( $text ); ?></p>
		<div class="actions-container">
			<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn-primary">
				<div class="btn-inner">
					<span class="btn-label"><?php esc_html_e( 'Book a Demo', 'devotel' ); ?></span>
				</div>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn-secondary">
				<div class="btn-inner">
					<span class="btn-label"><?php esc_html_e( 'Talk to an expert', 'devotel' ); ?></span>
				</div>
			</a>
		</div>
	</div>
</section>
