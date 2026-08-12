<?php
/**
 * Blog archive post grid with pagination.
 *
 * @package Devotel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query = isset( $args['query'] ) && $args['query'] instanceof WP_Query ? $args['query'] : null;
if ( ! $query ) {
	return;
}

$category_slug = isset( $args['category_slug'] ) ? (string) $args['category_slug'] : '';
?>
<div class="elementor-element elementor-element-504959e elementor-grid-3 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-widget elementor-widget-loop-grid" data-id="504959e" data-element_type="widget" data-widget_type="loop-grid.post">
	<div class="elementor-widget-container">
		<div class="elementor-loop-container elementor-grid">
			<?php if ( $query->have_posts() ) : ?>
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/blog/post', 'card', array( 'post' => get_post() ) );
				endwhile;
				?>
			<?php else : ?>
				<p class="devotel-blog-empty"><?php esc_html_e( 'No posts found.', 'devotel' ); ?></p>
			<?php endif; ?>
		</div>
		<?php devotel_render_blog_pagination( $query, $category_slug ); ?>
	</div>
</div>
<?php wp_reset_postdata(); ?>
