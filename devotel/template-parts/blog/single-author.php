<?php
/**
 * Single blog post author box.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post = isset( $args['post'] ) ? $args['post'] : null;
if ( ! $post instanceof WP_Post ) {
	return;
}

$author_id   = (int) $post->post_author;
$author_name = get_the_author_meta( 'display_name', $author_id );
$author_bio  = get_the_author_meta( 'description', $author_id );
?>
<footer class="devotel-blog-single-author">
	<div class="devotel-blog-single-author__avatar">
		<?php echo get_avatar( $author_id, 64, '', sprintf( __( 'Picture of %s', 'devotel' ), $author_name ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<div class="devotel-blog-single-author__text">
		<h4 class="devotel-blog-single-author__name"><?php echo esc_html( $author_name ); ?></h4>
		<?php if ( $author_bio ) : ?>
			<p class="devotel-blog-single-author__bio"><?php echo esc_html( $author_bio ); ?></p>
		<?php endif; ?>
	</div>
</footer>
