<?php
/**
 * Blog archive featured post row.
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

$categories = devotel_get_post_display_categories( $post->ID );
$author     = get_the_author_meta( 'display_name', (int) $post->post_author );
?>
<div class="elementor-element elementor-element-3158c58 e-flex e-con-boxed e-con e-parent" data-id="3158c58" data-element_type="container">
	<div class="e-con-inner">
		<div class="elementor-element elementor-element-abb4f7b e-con-full e-flex e-con e-child" data-id="abb4f7b" data-element_type="container">
			<div class="elementor-element elementor-element-5ecc0b7 elementor-widget elementor-widget-theme-post-featured-image elementor-widget-image" data-id="5ecc0b7" data-element_type="widget" data-widget_type="theme-post-featured-image.default">
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
					<?php echo get_the_post_thumbnail( $post, 'large', array( 'class' => 'attachment-large size-large' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>
		</div>
		<div class="elementor-element elementor-element-d385dc9 e-con-full e-flex e-con e-child" data-id="d385dc9" data-element_type="container">
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="elementor-element elementor-element-5f02ec0 elementor-widget elementor-widget-heading" data-id="5f02ec0" data-element_type="widget" data-widget_type="heading.default">
					<?php devotel_render_post_category_links( $post->ID ); ?>
				</div>
			<?php endif; ?>
			<div class="elementor-element elementor-element-61b4ffc elementor-widget elementor-widget-theme-post-title elementor-page-title elementor-widget-heading" data-id="61b4ffc" data-element_type="widget" data-widget_type="theme-post-title.default">
				<h1 class="elementor-heading-title elementor-size-default devotel-blog-title-with-arrow">
					<a class="devotel-blog-title-link" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
						<span class="devotel-blog-title-text"><?php echo esc_html( get_the_title( $post ) ); ?></span>
						<?php echo devotel_get_blog_title_arrow_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</a>
				</h1>
			</div>
			<div class="elementor-element elementor-element-451d1b0 elementor-widget elementor-widget-theme-post-excerpt" data-id="451d1b0" data-element_type="widget" data-widget_type="theme-post-excerpt.default">
				<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt( $post ) ) ); ?></p>
			</div>
			<div class="elementor-element elementor-element-3bf6b7d e-con-full e-flex e-con e-child" data-id="3bf6b7d" data-element_type="container">
				<div class="elementor-element elementor-element-2b24e5d elementor-author-box--align-left elementor-author-box--image-valign-middle elementor-widget__width-auto elementor-author-box--avatar-yes elementor-author-box--name-yes elementor-author-box--biography-yes elementor-author-box--link-no elementor-widget elementor-widget-author-box" data-id="2b24e5d" data-element_type="widget" data-widget_type="author-box.default">
					<div class="elementor-author-box">
						<div class="elementor-author-box__avatar">
							<?php echo get_avatar( (int) $post->post_author, 28, '', sprintf( __( 'Picture of %s', 'devotel' ), $author ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="elementor-author-box__text">
							<div>
								<span class="elementor-author-box__name"><?php echo esc_html( $author ); ?></span>
							</div>
							<div class="elementor-author-box__bio"></div>
						</div>
					</div>
				</div>
				<div class="elementor-element elementor-element-933ccd0 elementor-widget__width-auto elementor-widget elementor-widget-heading" data-id="933ccd0" data-element_type="widget" data-widget_type="heading.default">
					<span class="elementor-heading-title elementor-size-default"><?php echo esc_html( get_the_date( 'F j, Y', $post ) ); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>
