<?php
/**
 * Archive template.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( function_exists( 'devotel_render_blog_listing' ) && devotel_render_blog_listing() ) {
	get_footer();
	return;
}
?>
<div class="devotel-container devotel-archive">
	<header class="page-header devotel-entry-header">
		<h1 class="page-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="devotel-post-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'devotel-post-card' ); ?>>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No posts found.', 'devotel' ); ?></p>
	<?php endif; ?>
</div>
<?php
get_footer();
