<?php
/**
 * Fallback template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php if ( devotel_render_cached_snapshot_for_request() ) : ?>
	<?php
	get_footer();
	return;
endif;
?>
<div class="devotel-container">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No content found.', 'devotel' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();

