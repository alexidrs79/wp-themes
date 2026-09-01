<?php
/**
 * Template part: Social Proof section.
 * Figma: node 15532:141 ("Section 02 — Social Proof").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headline = get_field( 'sp_headline' );
$logos    = get_field( 'sp_logos' );
?>
<section class="social-proof">
	<div class="container">
		<h2 class="social-proof__headline" data-animate><?php echo esc_html( $headline ); ?></h2>
		<?php if ( $logos ) : ?>
			<ul class="social-proof__logos" data-animate>
				<?php foreach ( $logos as $logo ) : ?>
					<li class="social-proof__logo"><?php echo esc_html( $logo['name'] ?? '' ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
