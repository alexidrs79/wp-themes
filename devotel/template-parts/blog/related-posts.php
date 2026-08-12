<?php
/**
 * Related blog posts — Elementor 908 related band.
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

$category = devotel_get_post_primary_category( $post->ID );
$related  = new WP_Query(
	array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 4,
		'post__not_in'        => array( $post->ID ),
		'ignore_sticky_posts' => true,
		'category__in'        => $category instanceof WP_Term ? array( (int) $category->term_id ) : array(),
	)
);

if ( ! $related->have_posts() ) {
	$related = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => 4,
			'post__not_in'        => array( $post->ID ),
			'ignore_sticky_posts' => true,
		)
	);
}

if ( ! $related->have_posts() ) {
	return;
}

$blog_url = devotel_get_blog_archive_url();
?>
<div class="elementor-element elementor-element-98c7270 e-flex e-con-boxed e-con e-parent" data-id="98c7270" data-element_type="container">
	<div class="e-con-inner">
		<div class="elementor-element elementor-element-b47177a e-con-full e-flex e-con e-child" data-id="b47177a" data-element_type="container">
			<div class="elementor-element elementor-element-a0951e2 elementor-widget elementor-widget-heading" data-id="a0951e2" data-element_type="widget" data-widget_type="heading.default">
				<div class="elementor-heading-title elementor-size-default"><?php esc_html_e( 'Our blog', 'devotel' ); ?></div>
			</div>
			<div class="elementor-element elementor-element-bf785a3 elementor-widget elementor-widget-heading" data-id="bf785a3" data-element_type="widget" data-widget_type="heading.default">
				<h2 class="elementor-heading-title elementor-size-default"><?php esc_html_e( 'Latest blog posts', 'devotel' ); ?></h2>
			</div>
			<div class="elementor-element elementor-element-45dfe62 elementor-widget elementor-widget-text-editor" data-id="45dfe62" data-element_type="widget" data-widget_type="text-editor.default">
				<p><?php esc_html_e( 'Tool and strategies modern teams need to help their companies grow.', 'devotel' ); ?></p>
			</div>
		</div>
		<div class="elementor-element elementor-element-fad9316 e-con-full e-flex e-con e-child devotel-blog-see-all--header" data-id="fad9316" data-element_type="container">
			<?php devotel_render_blog_see_all_posts_button( $blog_url ); ?>
		</div>
	</div>
</div>
<div class="elementor-element elementor-element-7fe62a2 e-flex e-con-boxed e-con e-parent" data-id="7fe62a2" data-element_type="container">
	<div class="e-con-inner">
		<div class="elementor-element elementor-element-b1db0c6 elementor-grid-2 elementor-grid-tablet-2 elementor-grid-mobile-1 elementor-widget elementor-widget-loop-grid" data-id="b1db0c6" data-element_type="widget" data-widget_type="loop-grid.post">
			<div class="elementor-widget-container">
				<div class="elementor-loop-container elementor-grid devotel-blog-related__grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/blog/related-post', 'card', array( 'post' => get_post() ) );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
		<div class="elementor-element elementor-element-fad9316 e-con-full e-flex e-con e-child devotel-blog-see-all--footer" data-id="fad9316" data-element_type="container">
			<?php devotel_render_blog_see_all_posts_button( $blog_url ); ?>
		</div>
	</div>
</div>
