<?php
/**
 * Single blog post hero.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post     = isset( $args['post'] ) ? $args['post'] : null;
$read_min = isset( $args['read_min'] ) ? (int) $args['read_min'] : 1;
if ( ! $post instanceof WP_Post ) {
	return;
}

$category = devotel_get_post_primary_category( $post->ID );
?>
<header class="devotel-blog-single-hero">
	<div class="devotel-blog-single-hero__meta">
		<?php if ( $category instanceof WP_Term ) : ?>
			<a class="devotel-blog-single-hero__category" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
		<?php endif; ?>
		<span class="devotel-blog-single-hero__date"><?php echo esc_html( get_the_date( 'M j, Y', $post ) ); ?></span>
		<span class="devotel-blog-single-hero__read-time">
			<?php
			printf(
				/* translators: %d: estimated minutes to read */
				esc_html( _n( '%d min read', '%d min read', $read_min, 'devotel' ) ),
				$read_min
			);
			?>
		</span>
	</div>
	<h1 class="devotel-blog-single-hero__title"><?php echo esc_html( get_the_title( $post ) ); ?></h1>
	<?php if ( has_post_thumbnail( $post ) ) : ?>
		<div class="devotel-blog-single-hero__image">
			<?php echo get_the_post_thumbnail( $post, 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php endif; ?>
</header>
