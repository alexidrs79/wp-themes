<?php
/**
 * Template part: plain legal/text page (Privacy Policy, Terms of Service).
 *
 * Content lives in the ACF `legal_content` WYSIWYG field, not
 * post_content — matches how every other page's content on this site
 * is editor-managed via ACF rather than the block editor. See
 * inc/acf-fields-legal.php for the field group and the required-legal-
 * review note attached to it.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();

	$content       = get_field( 'legal_content' );
	$last_updated  = get_field( 'legal_last_updated' );
	?>
	<article class="legal-page">
		<div class="legal-page__inner container">
			<h1 class="legal-page__title"><?php the_title(); ?></h1>

			<?php if ( $last_updated ) : ?>
				<p class="legal-page__updated">Last updated: <?php echo esc_html( $last_updated ); ?></p>
			<?php endif; ?>

			<?php if ( $content ) : ?>
				<div class="legal-page__body">
					<?php echo wp_kses_post( $content ); ?>
				</div>
			<?php endif; ?>
		</div>
	</article>
	<?php
endwhile;
