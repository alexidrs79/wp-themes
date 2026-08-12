<?php
/**
 * Compact horizontal related post card (blog single).
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
$classes    = implode(
	' ',
	array_filter(
		array(
			'elementor',
			'elementor-880',
			'e-loop-item',
			'e-loop-item-' . $post->ID,
			'post-' . $post->ID,
			'post',
			'type-post',
			'status-publish',
			'devotel-blog-related-card',
			has_post_thumbnail( $post ) ? 'has-post-thumbnail' : '',
		)
	)
);
?>
<div data-elementor-type="loop-item" data-elementor-id="880" class="<?php echo esc_attr( $classes ); ?>" data-elementor-post-type="post" role="listitem">
	<div class="elementor-element elementor-element-350c5b6 e-con-full e-flex e-con e-parent devotel-blog-related-card__row" data-id="350c5b6" data-element_type="container">
		<?php if ( has_post_thumbnail( $post ) ) : ?>
			<div class="elementor-element elementor-element-8a7194b elementor-widget elementor-widget-theme-post-featured-image elementor-widget-image devotel-blog-related-card__thumb" data-id="8a7194b" data-element_type="widget" data-widget_type="theme-post-featured-image.default">
				<a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
					<?php echo get_the_post_thumbnail( $post, 'large', array( 'class' => 'elementor-animation-float attachment-large size-large' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			</div>
		<?php endif; ?>
		<div class="elementor-element elementor-element-e5b0a22 e-flex e-con-boxed e-con e-child devotel-blog-related-card__body" data-id="e5b0a22" data-element_type="container">
			<div class="e-con-inner">
				<?php if ( ! empty( $categories ) ) : ?>
					<div class="elementor-element elementor-element-aa71598 elementor-widget elementor-widget-heading" data-id="aa71598" data-element_type="widget" data-widget_type="heading.default">
						<?php devotel_render_post_category_links( $post->ID ); ?>
					</div>
				<?php endif; ?>
				<div class="elementor-element elementor-element-15a46e6 elementor-widget elementor-widget-theme-post-title elementor-page-title elementor-widget-heading" data-id="15a46e6" data-element_type="widget" data-widget_type="theme-post-title.default">
					<h3 class="elementor-heading-title elementor-size-default">
						<a href="<?php echo esc_url( get_permalink( $post ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a>
					</h3>
				</div>
				<div class="elementor-element elementor-element-72570d9 elementor-widget elementor-widget-theme-post-excerpt" data-id="72570d9" data-element_type="widget" data-widget_type="theme-post-excerpt.default">
					<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $post ) ), 14, '…' ) ); ?></p>
				</div>
				<div class="elementor-element elementor-element-6f2f221 e-con-full e-flex e-con e-child devotel-blog-related-card__meta" data-id="6f2f221" data-element_type="container">
					<div class="elementor-element elementor-element-ce2259a elementor-author-box--align-left elementor-author-box--image-valign-middle elementor-author-box--layout-image-left elementor-widget__width-auto elementor-author-box--avatar-yes elementor-author-box--name-yes elementor-author-box--link-no elementor-widget elementor-widget-author-box" data-id="ce2259a" data-element_type="widget" data-widget_type="author-box.default">
						<div class="elementor-author-box">
							<div class="elementor-author-box__avatar">
								<?php echo get_avatar( (int) $post->post_author, 28, '', sprintf( __( 'Picture of %s', 'devotel' ), $author ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<div class="elementor-author-box__text">
								<div>
									<span class="elementor-author-box__name"><?php echo esc_html( $author ); ?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="elementor-element elementor-element-bfc32a3 elementor-widget__width-auto elementor-widget elementor-widget-heading" data-id="bfc32a3" data-element_type="widget" data-widget_type="heading.default">
						<span class="elementor-heading-title elementor-size-default"><?php echo esc_html( get_the_date( 'F j, Y', $post ) ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
